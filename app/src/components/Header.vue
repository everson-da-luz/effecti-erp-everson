<template>
    <header class="wrapper">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <router-link class="navbar-brand" to="/">
                    <img src="/img/logo.svg" alt="Logo">
                </router-link>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/clientes">Clientes</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/servicos">Serviços</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/contratos">Contratos</router-link>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>