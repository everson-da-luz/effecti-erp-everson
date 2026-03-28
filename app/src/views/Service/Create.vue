<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1 class="h4">Adicionar Serviço</h1>
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
                    <label class="form-label">Nome do Serviço</label>
                    <input type="text" v-model="model.service.name" class="form-control" placeholder="Ex: Consultoria">
                </div>
                <div class="mb-3">
                    <label class="form-label">Valor Mensal Base (R$)</label>
                    <input type="number" step="0.01" v-model="model.service.base_monthly_value" class="form-control">
                </div>
                <div class="mb-3">
                    <button type="button" @click="saveService" class="btn btn-success me-3">Salvar</button>
                    <router-link to="/servicos" class="btn btn-secondary">Voltar</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: 'ServiceCreate',
        data() {
            return {
                model: {
                    service: {
                        name: '',
                        base_monthly_value: 0
                    }
                },
                errors: [],
                successMessage: ''
            }
        },
        methods: {
            saveService() {
                this.errors = []
                this.successMessage = ''

                axios.post('http://localhost:8080/api/services', this.model.service).then(res => {
                    this.successMessage = res.data.message
                    this.model.service = {name: '', base_monthly_value: 0}
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