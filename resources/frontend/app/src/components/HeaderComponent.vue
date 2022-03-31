<template>
    <div id="nav">
        <router-link to="/">Home</router-link>
        |
        <router-link to="/book" v-if="isAuth">Book</router-link>
        |
        <router-link to="/order" v-if="isAuth">Оренда</router-link>
        |
        <router-link to="/register" v-if="!isAuth">регистрация</router-link>
        |
        <router-link to="/authorization" v-if="!isAuth">вход</router-link>
        |
        <a href="/authorization" v-if="isAuth" @click="dropAuthToken">выход</a>


    </div>
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
        getStateIsAuth(){
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
        isAuth(){
            this.getStateIsAuth();
        }
    }
}
</script>

<style scoped>

</style>
