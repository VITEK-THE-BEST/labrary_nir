<template>
    <div id="nav">
        <router-link to="/">Home</router-link>
        |
        <router-link to="/book">Book</router-link>
        |
        <router-link to="/order">Оренда</router-link>
        |
        <router-link to="/register">регистрация</router-link>
        |
        <router-link to="/authorization">вход</router-link>
        |
        <div
            v-if="isAuth"
        >

            <router-link
                v-model="isAuth"

                to="/authorization">
                <div @click="dropAuthToken">
                    выход
                </div>
            </router-link>
        </div>
    </div>
    <router-view/>
</template>

<script>
import UserDataService from "@/services/UserDataServise";
import {mapMutations, mapGetters} from "vuex";

export default {
    name: 'App',
    data() {
        return {
            isAuth: this.$store.state.isAuth,
            data: {
                token: this.$store.state.token
            }
        }
    },
    methods: {
        ...mapMutations({
            dropToken: 'dropToken'
        }),
        ...mapGetters({
            getIsAuth: 'getIsAuth'
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
        getStateIsAuth(){
            this.isAuth = this.getIsAuth;
        }
    },
    mounted() {
        this.getStateIsAuth() ;
    },
    watch: {
        isAuth(){
            this.getStateIsAuth();
        }
    }
}
</script>

<style>

</style>
