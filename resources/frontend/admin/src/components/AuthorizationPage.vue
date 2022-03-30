<template>
    <div>
        <form @submit.prevent>

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

            <button @click="getToken"> зарегистрироваться</button>
        </form>
    </div>
</template>

<script>
import {mapMutations} from "vuex";
import UserDataService from "@/services/UserDataServise";

export default {
    name: "AuthorizationPage",
    data() {
        return {
            user: {
                phone: '',
                password: '',
            }
        }
    },
    methods: {
        ...mapMutations({
            setToken: 'setToken'
        }),
        getToken() {
            UserDataService.getToken(this.user)
                .then(response => {
                    console.log(response.data)
                    this.setToken(response.data["token"])
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
