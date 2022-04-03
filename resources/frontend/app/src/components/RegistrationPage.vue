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
                                    <dialog-component v-model:show="dialogVisible">
                                        <div>
                                            <h3>{{ errorMessage }}</h3>

                                        </div>
                                    </dialog-component>

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Регистрация</p>

                                    <form class="mx-1 mx-md-4" @submit.prevent>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input
                                                    minlength="3"
                                                    v-bind:value="user.name"
                                                    type="text"
                                                    @input="user.name = $event.target.value"
                                                    id="form1Example1c"
                                                    class="form-control"
                                                >
                                                <label class="form-label" for="form1Example1c">имя</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input
                                                    minlength="3"
                                                    v-bind:value="user.surname"
                                                    type="text"
                                                    @input="user.surname = $event.target.value"
                                                    id="form2Example1c"
                                                    class="form-control"
                                                >
                                                <label class="form-label" for="form2Example1c">фамилия</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input
                                                    minlength="3"
                                                    v-bind:value="user.patronymic"
                                                    type="text"
                                                    @input="user.patronymic = $event.target.value"
                                                    id="form3Example1c"
                                                    class="form-control"
                                                >
                                                <label class="form-label" for="form3Example1c">отчество</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input
                                                    minlength="3"
                                                    v-bind:value="user.address"
                                                    type="text"
                                                    @input="user.address = $event.target.value"
                                                    id="form4Example1c"
                                                    class="form-control"
                                                >
                                                <label class="form-label" for="form4Example1c">адрес</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input
                                                    minlength="11"
                                                    maxlength="11"
                                                    v-bind:value="user.phone"
                                                    type="text"
                                                    @input="user.phone = $event.target.value"
                                                    id="form5Example1c"
                                                    class="form-control"
                                                >
                                                <label class="form-label" for="form5Example1c">телефон</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input
                                                    minlength="2"
                                                    v-bind:value="user.password"
                                                    type="text"
                                                    @input="user.password = $event.target.value"
                                                    id="form7Example1c"
                                                    class="form-control"
                                                >
                                                <label class="form-label" for="form7Example1c">пароль</label>
                                            </div>
                                        </div>


                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="button" class="btn btn-primary btn-lg"
                                                    @click="checkCorrectValue(user)">Регистрация
                                            </button>
                                        </div>

                                    </form>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img  src="//eluniver.ugrasu.ru/pluginfile.php/1/theme_opentechnology/settings_ugrasu_header_logoimage/1648635073/logo-new.png" class="img-fluid" alt="Sample image">

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
import UserDataService from "../services/UserDataServise";
import {mapMutations} from 'vuex';
import HeaderComponent from "@/components/HeaderComponent";
import DialogComponent from "@/components/DialogComponent";

export default {
    name: "RegistrationPage",
    components: {
        DialogComponent,
        HeaderComponent
    },
    data() {
        return {
            dialogVisible: false,
            errorMessage: '',
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
        checkCorrectValue(user) {
            // console.log(user)
            let findError = false;
            const nameReg = new RegExp("[^a-zа-яё]+$");
            const phoneReg = new RegExp("[^0-9]+$");
            this.errorMessage = "вы не правильно заполнили следущие поля: "

            if (nameReg.test(user.name) || user.name.length < 3) {
                findError = true
                this.errorMessage += "имя "
            }
            if (nameReg.test(user.surname) || user.surname.length < 3) {
                findError = true
                this.errorMessage += "фаимилия "
            }
            if (nameReg.test(user.patronymic) || user.patronymic.length < 3) {
                findError = true
                this.errorMessage += "отчество "
            }
            if (user.address.length < 3) {
                findError = true
                this.errorMessage += "адрес "
            }
            if (phoneReg.test(user.phone) || user.phone.length !== 11) {
                console.log(user.phone.length)
                findError = true
                this.errorMessage += "телефон "
            }

            if (findError) {
                console.log(this.errorMessage)
                console.log(this.errorMessage)
                this.dialogVisible = true
            } else {
                this.registerUser(user)
            }
        },
        registerUser(user) {
            UserDataService.registration(user)
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
