<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1 class="h4">Edição do cliente #{{ clientId }}</h1>
            </div>
            <div class="card-body">
                <div v-if="successMessage" class="alert alert-success alert-dismissible fade show">
                    {{ successMessage }}
                    <button type="button" class="btn-close" @click="successMessage = ''"></button>
                </div>
                <div v-if="errors.length > 0" class="alert alert-danger shadow-sm">
                    <ul class="mb-0">
                        <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                    </ul>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" v-model="model.client.name" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Documento</label>
                    <input type="text" v-model="model.client.document" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" v-model="model.client.email" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select v-model="model.client.status" class="form-select">
                        <option value="Ativo">Ativo</option>
                        <option value="Inativo">Inativo</option>
                    </select>
                </div>
                <div class="mb-3">
                    <button type="button" @click="updateClient" class="btn btn-success me-3">Salvar</button>
                    <router-link to="/clientes" class="btn btn-secondary">Voltar</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: 'ClientEdit',
        data() {
            return {
                clientId: '',
                model: {
                    client: {
                        name: '',
                        document: '',
                        email: '',
                        status: ''
                    }
                },
                errors: [],
                successMessage: ''
            }
        },
        mounted() {
            this.clientId = this.$route.params.id

            this.getClientData(this.clientId)
        },
        methods: {
            getClientData(clientId) {
                axios.get(`http://localhost:8080/api/clients/${clientId}`).then(res => {
                    this.model.client = res.data.data
                }).catch(error => {})
            },
            updateClient() {
                this.successMessage = ''
                this.errors = []

                axios.put(`http://localhost:8080/api/clients/${this.clientId}`, this.model.client).then(res => {
                    this.successMessage = res.data.message
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