<template>
    <div id="nav">
        <router-link to="/">Home</router-link> |
        <router-link to="/book">Book</router-link> |
        <router-link to="/register">регистрация</router-link>
    </div>
    <router-view />
</template>

<script>

export default {
  name: 'App',
}
</script>

<style>

</style>
