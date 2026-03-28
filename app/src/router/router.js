import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import ClientList from '../views/Client/List.vue'
import ClientCreate from '../views/Client/Create.vue'
import ClientEdit from '../views/Client/Edit.vue'
import ServiceList from '../views/Service/List.vue'
import ServiceCreate from '../views/Service/Create.vue'
import ServiceEdit from '../views/Service/Edit.vue'
import ContractList from '../views/Contract/List.vue'
import ContractCreate from '../views/Contract/Create.vue'
import ContractEdit from '../views/Contract/Edit.vue'
import ContractItemList from '../views/Contract/ContractItemList.vue'
import ContractItemCreate from '../views/Contract/ContractItemCreate.vue'

const routes = [
    { path: '/', component: Home },
    { path: '/clientes', component: ClientList },
    { path: '/cliente/adicionar', component: ClientCreate },
    { path: '/cliente/editar/:id', component: ClientEdit },
    { path: '/servicos', component: ServiceList },
    { path: '/servico/adicionar', component: ServiceCreate },
    { path: '/servico/editar/:id', component: ServiceEdit },
    { path: '/contratos', component: ContractList },
    { path: '/contrato/adicionar', component: ContractCreate },
    { path: '/contrato/editar/:id', component: ContractEdit },
    { path: '/contrato/:id/itens', component: ContractItemList },
    { path: '/contrato/:id/item/adicionar', component: ContractItemCreate }
]

export default createRouter({
    history: createWebHistory(),
    routes
})
