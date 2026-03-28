<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h4">Contratos</h1>
                <RouterLink to="/contrato/adicionar" class="btn btn-primary">Adicionar</RouterLink>
            </div>
            <div class="card-body">
                <div v-if="successMessage" class="alert alert-success shadow-sm alert-dismissible fade show">
                    {{ successMessage }}
                    <button type="button" class="btn-close" @click="successMessage = ''"></button>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Início</th>
                            <th>Término</th>
                            <th>Valor total</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody v-if="contracts.length > 0">
                        <tr v-for="(contract, index) in contracts" :key="index">
                            <td>{{ contract.id }}</td>
                            <td>{{ contract.client ? contract.client.name : '' }}</td>
                            <td>{{ contract.start_date }}</td>
                            <td>{{ contract.end_date || 'Data Indeterminada' }}</td>
                            <td>R$ {{ contract.total_value.toFixed(2) }}</td>
                            <td>{{ contract.status }}</td>
                            <td>
                                <RouterLink :to="{path: '/contrato/' + contract.id + '/itens'}" class="btn btn-info mx-2 text-white">Itens</RouterLink>
                                <RouterLink :to="{path: '/contrato/editar/' + contract.id}" class="btn btn-success mx-2">Editar</RouterLink>
                                <button type="button" @click="deleteContract(contract.id)" class="btn btn-danger mx-2">Excluir</button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="7" class="text-center"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: 'ContractList',
        data() {
            return {
                contracts: [],
                successMessage: ''
            }
        },
        mounted() {
            this.getContracts()
        },
        methods: {
            getContracts() {
                axios.get('http://localhost:8080/api/contracts').then(res => {
                    this.contracts = res.data.data
                })
            },
            deleteContract(contractId) {
                this.successMessage = ''

                if (confirm('Tem certeza que gostaria de excluir esse registro?')) {
                    axios.delete('http://localhost:8080/api/contracts/' + contractId).then(res => {
                        this.successMessage = res.data.message
                        this.getContracts()
                    })
                }
            }
        }
    }
</script>