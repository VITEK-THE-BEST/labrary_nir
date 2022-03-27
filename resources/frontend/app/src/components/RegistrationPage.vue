<template>
    <div>
        <form>
            <label>Имя</label>:
            <input type="text" id="name">

            <label>Фамилия</label> :
            <input type="text" id="surname">

            <label>Отчество</label>:
            <input type="text" id="patronymic">

            <label>Адресс</label>:
            <input type="text" id="address">

            <label>Телефон</label>:
            <input type="text" id="phone">

            <label>Пароль</label>:
            <input type="text" id="password">
            <div></div>
            <div></div>
            <div></div>
            <button @click=""> зарегистрироваться </button>
        </form>
    </div>
</template>

<script>
export default {
    name: "RegistrationPage"
}
</script>

<style scoped>

</style>
