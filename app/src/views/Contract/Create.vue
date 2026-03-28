<template>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h1 class="h4">Adicionar Contrato</h1>
            </div>
            <div class="card-body">
                <div v-if="successMessage" class="alert alert-success alert-dismissible fade show">
                    {{ successMessage }}
                    <button type="button" class="btn-close" @click="successMessage = ''"></button>
                </div>
                <div v-if="errors.length > 0" class="alert alert-danger">
                    <ul class="mb-0">
                        <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                    </ul>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <select v-model="model.contract.client_id" class="form-select">
                        <option value="">Selecione um cliente</option>
                        <option v-for="client in clients" :key="client.id" :value="client.id">
                            {{ client.name }}
                        </option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Data de Início</label>
                        <input type="date" v-model="model.contract.start_date" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Data de Término (Opcional)</label>
                        <input type="date" v-model="model.contract.end_date" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select v-model="model.contract.status" class="form-select">
                        <option value="Ativo">Ativo</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                </div>
                <div class="mb-3">
                    <button type="button" @click="saveContract" class="btn btn-success me-3">Salvar</button>
                    <router-link to="/contratos" class="btn btn-secondary">Voltar</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: 'ContractCreate',
        data() {
            return {
                clients: [],
                model: {
                    contract: {
                        client_id: '',
                        start_date: '',
                        end_date: '',
                        status: 'Ativo'
                    }
                },
                errors: [],
                successMessage: ''
            }
        },
        mounted() {
            this.getClients()
        },
        methods: {
            getClients() {
                axios.get('http://localhost:8080/api/clients').then(res => {
                    this.clients = res.data.data
                })
            },
            saveContract() {
                this.errors = []
                this.successMessage = ''

                axios.post('http://localhost:8080/api/contracts', this.model.contract).then(res => {
                    this.successMessage = res.data.message
                    this.model.contract = {
                        client_id: '',
                        start_date: '',
                        end_date: '',
                        status: 'Ativo'
                    }
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.message
                    }
                })
            }
        }
    }
</script>