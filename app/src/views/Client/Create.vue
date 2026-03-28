<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1 class="h4">Adicionar cliente</h1>
            </div>
            <div class="card-body">
                <div v-if="successMessage" class="alert alert-success shadow-sm alert-dismissible fade show">
                    {{ successMessage }}
                    <button type="button" class="btn-close" @click="successMessage = ''"></button>
                </div>
                <div v-if="errors.length > 0" class="alert alert-danger">
                    <ul class="mb-0">
                        <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                    </ul>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" v-model="model.client.name" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Documento (CPF/CNPJ)</label>
                    <input type="text" v-model="model.client.document" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" v-model="model.client.email" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select v-model="model.client.status" class="form-select">
                        <option value="" disabled>Selecione o status</option>
                        <option value="Ativo">Ativo</option>
                        <option value="Inativo">Inativo</option>
                    </select>
                </div>
                <div class="mb-3">
                    <button type="button" @click="saveClient" class="btn btn-success me-3">Salvar</button>
                    <router-link to="/clientes" class="btn btn-secondary">Voltar</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: 'ClientCreate',
        data() {
            return {
                model: {
                    client: {
                        name: '',
                        document: '',
                        email: '',
                        status: 'Ativo'
                    }
                },
                errors: [],
                successMessage: ''
            }
        },
        methods: {
            saveClient() {
                this.successMessage = ''
                this.errors = []

                axios.post('http://localhost:8080/api/clients', this.model.client).then(res => {
                    this.successMessage = res.data.message
                    this.model.client = {
                        name: '',
                        document: '',
                        email: '',
                        status: 'Ativo'
                    }
                    this.errors = []
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