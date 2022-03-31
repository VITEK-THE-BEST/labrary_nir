<template>
    <header-component></header-component>

    <div>
        <form @submit.prevent>
            <label>Имя</label>:
            <input
                v-bind:value="user.name"
                type="text"
                @input="user.name = $event.target.value"
                id="name">
            <br>
            <label>Фамилия</label> :
            <input
                v-bind:value="user.surname"
                type="text"
                @input="user.surname = $event.target.value"
                id="surname">
            <br>

            <label>Отчество</label>:
            <input
                v-bind:value="user.patronymic"
                type="text"
                @input="user.patronymic = $event.target.value"
                id="patronymic">
            <br>

            <label>Адрес</label>:
            <input
                v-bind:value="user.address"
                type="text"
                @input="user.address = $event.target.value"
                id="address">
            <br>

            <label>Телефон</label>:
            <input
                v-bind:value="user.phone"
                type="text"
                @input="user.phone = $event.target.value"
                id="phone">
            <br>

            <label>Пароль</label>:
            <input
                v-bind:value="user.password"
                type="text"
                @input="user.password = $event.target.value"
                id="password">

            <button @click="registerUser"> зарегистрироваться</button>
            <button @click="me"> получить текущего пользователя</button>
        </form>
    </div>
</template>

<script>
import UserDataService from "../services/UserDataServise";
import {mapMutations} from 'vuex';
import HeaderComponent from "@/components/HeaderComponent";

export default {
    name: "RegistrationPage",
    components:{
        HeaderComponent
    },
    data() {
        return {
            user: {
                name: '',
                surname: '',
                patronymic: '',
                address: '',
                phone: '',
                password: '',
                token: this.$store.state.token,
            }
        }
    },
    methods: {
        ...mapMutations({
            setToken: 'setToken'
        }),
        registerUser() {
            UserDataService.registration(this.user)
                .then(response => {
                    console.log(response.data)
                    this.setToken(response.data["token"])
                    this.$router.push('/')
                })
                .catch(e => {
                    console.log(e);
                });
        },
        me() {
            this.user['token'] = this.$store.state.token

                UserDataService.me(this.user)
                .then(response => {
                    console.log(response.data)
                })
                .catch(e => {
                    console.log(e);
                });
        }
    }
}
</script>

<style scoped>

</style>
