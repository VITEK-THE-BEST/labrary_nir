<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <button
                class="navbar-toggler"
                type="button"
                data-mdb-toggle="collapse"
                data-mdb-target="#navbarExample01"
                aria-controls="navbarExample01"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <i class="fas fa-bars"></i>
            </button>
            <div
                class="collapse navbar-collapse"
                id="navbarExample01"
            >
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item active">
                        <router-link class="nav-link" aria-current="page" to="/">Домашняя страница</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/book" v-if="isAuth">Книги</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/order_notComplete" v-if="isAuth">Заказы</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/register" v-if="!isAuth">регистрация</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/authorization" v-if="!isAuth">вход</router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/authorization" v-if="isAuth" @click="dropAuthToken">выход</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</template>

<script>
import {mapGetters, mapMutations} from "vuex";
import UserDataService from "@/services/UserDataServise";

export default {
    name: "header-component",
    data() {
        return {
            isAuth: false,
            data: {
                token: this.$store.state.token
            }
        }
    },
    methods: {
        ...mapMutations({
            dropToken: 'dropToken'
        }),
        async dropAuthToken() {
            this.data.token = this.$store.state.token
            UserDataService.dropToken(this.data)
                .then(response => {
                    console.log(response.data)
                    this.dropToken()
                })
                .catch(e => {
                    console.log(e);
                });
        },
        getStateIsAuth() {
            console.log(this.isAuth)
        }
    },
    created() {
        this.isAuth = this.$store.state.isAuht
    },
    mounted() {
        this.isAuth = this.$store.state.isAuht
    },
    updated() {
        this.isAuth = this.$store.state.isAuht
    },
    watch: {
        isAuth() {
            this.getStateIsAuth();
        }
    }
}
</script>

<style scoped>

</style>
