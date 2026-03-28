<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h4">Clientes</h1>
                <RouterLink to="/cliente/adicionar" class="btn btn-primary">Adicionar</RouterLink>
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
                            <th>Nome</th>
                            <th>Documento</th>
                            <th>E-mail</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody v-if="this.clients.length > 0">
                        <tr v-for="(client, index) in this.clients" :key="index">
                            <td>{{ client.id }}</td>
                            <td>{{ client.name }}</td>
                            <td>{{ client.document }}</td>
                            <td>{{ client.email }}</td>
                            <td>{{ client.status }}</td>
                            <td>
                                <RouterLink :to="{path: '/cliente/editar/' + client.id}" class="btn btn-success mx-2">Editar</RouterLink>
                                <button type="button" @click="deleteClient(client.id)" class="btn btn-danger mx-2">Excluir</button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="6">...</td>
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
        name: 'ClientList',
        data() {
            return {
                clients: [],
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
            deleteClient(clientId) {
                this.successMessage = ''

                if (confirm('Tem certeza que gostaria de excluir esse registro?')) {
                    axios.delete('http://localhost:8080/api/clients/' + clientId).then(res => {
                        this.successMessage = res.data.message
                        this.getClients()
                    })
                }
            }
        }
    }
</script>