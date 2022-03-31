<template>
    <header-component></header-component>
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

            <button @click="getToken" > зарегистрироваться</button>
        </form>
    </div>
</template>

<script>
import {mapMutations} from "vuex";
import UserDataService from "@/services/UserDataServise";
import HeaderComponent from "@/components/HeaderComponent";

export default {
    name: "AuthorizationPage",
    components:{
        HeaderComponent
    },
    data() {
        return {
            user: {
                phone: '',
                password: '',
            },
            isAuth:false
        }
    },
    watch:{

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
                    this.$router.push('/')
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
