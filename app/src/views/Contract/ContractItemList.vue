<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h4">Itens do Contrato #{{ contractId }}</h1>
                <RouterLink :to="{path: '/contrato/' + contractId + '/item/adicionar'}" class="btn btn-primary">Adicionar</RouterLink>
            </div>
            <div class="card-body">
                <div v-if="successMessage" class="alert alert-success shadow-sm alert-dismissible fade show">
                    {{ successMessage }}
                    <button type="button" class="btn-close" @click="successMessage = ''"></button>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Serviço</th>
                            <th>Qtd</th>
                            <th>Valor Unit.</th>
                            <th>Subtotal</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody v-if="items.length > 0">
                        <tr v-for="(item, index) in items" :key="index">
                            <td>{{ item.service.name }}</td>
                            <td>{{ item.quantity }}</td>
                            <td>R$ {{ item.unit_value }}</td>
                            <td>R$ {{ (item.quantity * item.unit_value).toFixed(2) }}</td>
                            <td>
                                <button type="button" @click="deleteItem(item.id)" class="btn btn-danger mx-2">Remover</button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="5" class="text-center"></td>
                        </tr>
                    </tbody>
                    <tfoot v-if="items.length > 0">
                        <tr class="table-light">
                            <td colspan="3" class="text-end fw-bold">Total do Contrato:</td>
                            <td colspan="2" class="fw-bold text-success">R$ {{ contract.total_value.toFixed(2) }}</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="mt-3">
                    <RouterLink to="/contratos" class="btn btn-secondary">Voltar</RouterLink>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: 'ContractItemList',
        data() {
            return {
                contractId: this.$route.params.id,
                contract: {},
                items: [],
                successMessage: ''
            }
        },
        mounted() {
            this.getContractDetails()
        },
        methods: {
            getContractDetails() {
                axios.get(`http://localhost:8080/api/contracts/${this.contractId}`).then(res => {
                    this.contract = res.data.data;
                    this.items = res.data.data.items || []
                })
            },
            deleteItem(itemId) {
                if (confirm('Deseja remover este registro?')) {
                    axios.delete(`http://localhost:8080/api/contracts/items/${itemId}`).then(res => {
                        this.successMessage = res.data.message
                        this.getContractDetails()
                    })
                }
            }
        }
    }
</script>