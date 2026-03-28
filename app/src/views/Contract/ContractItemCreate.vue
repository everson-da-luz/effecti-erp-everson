<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1 class="h4">Adicionar Serviço ao Contrato #{{ contractId }}</h1>
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
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Serviço</label>
                        <select v-model="model.item.service_id" class="form-select" @change="updateValue">
                            <option value="">Selecione um serviço</option>
                            <option v-for="service in services" :key="service.id" :value="service.id">
                                {{ service.name }} (R$ {{ service.base_monthly_value }})
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Quantidade</label>
                        <input type="number" v-model="model.item.quantity" class="form-control" min="1">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Valor Unitário (R$)</label>
                        <input type="number" v-model="model.item.unit_value" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="mt-3">
                        <p>Serviços com quantidade igual ou maior que 5 ganharão a porcentagem de desconto definida no campo abaixo:</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">% Desconto</label>
                        <input type="number" v-model="model.item.discount_percent" class="form-control" min="0" max="100">
                    </div>
                </div>
                <div class="mb-3">
                    <button type="button" @click="saveItem" class="btn btn-primary me-3">Salvar</button>
                    <RouterLink :to="{path: '/contrato/' + contractId + '/itens'}" class="btn btn-secondary">Voltar</RouterLink>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: 'ContractItemCreate',
        data() {
            return {
                contractId: this.$route.params.id,
                services: [],
                model: {
                    item: {
                        service_id: '',
                        quantity: 1,
                        unit_value: '',
                        discount_percent: 10
                    }
                },
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
            updateValue() {
                const selected = this.services.find(s => s.id == this.model.item.service_id)

                if (selected) {
                    this.model.item.unit_value = selected.base_monthly_value
                }
            },
            saveItem() {
                this.errors = []
                this.successMessage = ''

                axios.post(`http://localhost:8080/api/contracts/${this.contractId}/items`, this.model.item).then(res => {
                    this.successMessage = res.data.message
                    this.model.item = {
                        service_id: '',
                        quantity: 1,
                        unit_value: ''
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