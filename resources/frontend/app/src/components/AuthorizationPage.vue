<template>
    <header-component></header-component>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Вход</p>

                                    <form class="mx-1 mx-md-4" @submit.prevent>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input
                                                    v-bind:value="user.phone"
                                                    type="text"
                                                    @input="user.phone = $event.target.value"
                                                    id="form1Example1c"
                                                    class="form-control"
                                                >
                                                <label class="form-label" for="form1Example1c">телефон</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input
                                                    v-bind:value="user.password"
                                                    type="text"
                                                    @input="user.password = $event.target.value"
                                                    id="form2Example1c"
                                                    class="form-control"
                                                >
                                                <label class="form-label" for="form2Example1c">пароль</label>
                                            </div>
                                        </div>


                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="button" class="btn btn-primary btn-lg"
                                                    @click="getToken">Вход
                                            </button>
                                        </div>

                                    </form>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img
                                        src="//eluniver.ugrasu.ru/pluginfile.php/1/theme_opentechnology/settings_ugrasu_header_logoimage/1648635073/logo-new.png"
                                        class="img-fluid" alt="Sample image">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import {mapMutations} from "vuex";
import UserDataService from "@/services/UserDataServise";
import HeaderComponent from "@/components/HeaderComponent";

export default {
    name: "AuthorizationPage",
    components: {
        HeaderComponent
    },
    data() {
        return {
            user: {
                phone: '',
                password: '',
            },
            isAuth: false
        }
    },
    watch: {},
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
