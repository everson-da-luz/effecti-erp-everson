<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h4">Serviços</h1>
                <RouterLink to="/servico/adicionar" class="btn btn-primary">Adicionar</RouterLink>
            </div>
            <div class="card-body">
                <div v-if="successMessage" class="alert alert-success shadow-sm alert-dismissible fade show">
                    {{ successMessage }}
                    <button type="button" class="btn-close" @click="successMessage = ''"></button>
                </div>
                <div v-if="errors.length > 0" class="alert alert-danger shadow-sm">
                    <ul class="mb-0">
                        <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                    </ul>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Valor base mensal</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody v-if="this.services.length > 0">
                        <tr v-for="(service, index) in this.services" :key="index">
                            <td>{{ service.id }}</td>
                            <td>{{ service.name }}</td>
                            <td>{{ service.base_monthly_value }}</td>
                            <td>
                                <RouterLink :to="{path: '/servico/editar/' + service.id}" class="btn btn-success mx-2">Editar</RouterLink>
                                <button type="button" @click="deleteService(service.id)" class="btn btn-danger mx-2">Excluir</button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="3">...</td>
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
        name: 'ServiceList',
        data() {
            return {
                services: [],
                errors: [],
                successMessage: ''
            }
        },
        mounted() {
            this.getServices()
        },
        methods: {
            getServices() {
                axios.get('http://localhost:8080/api/services').then(res => {
                    this.services = res.data.data
                })
            },
            deleteService(serviceId) {
                this.errors = []
                this.successMessage = ''

                if (confirm('Tem certeza que gostaria de excluir esse registro?')) {
                    axios.delete('http://localhost:8080/api/services/' + serviceId).then(res => {
                        this.successMessage = res.data.message
                        this.getServices()
                    }).catch(error => {
                        if (error.response.data.code == 500) {
                            this.errors = ['Não é permitido excluir um serviço vinculado a um contrato.']
                        }
                    })
                }
            }
        }
    }
</script>