<template>
    <div>
        <router-link to="/order_notComplete">текущие заказы пользователей</router-link> |
        <router-link to="/order_Complete">завершенные заказы пользователей</router-link>  |

        <h1>мои заказы:</h1>
        <div>
            <router-view/>
        </div>

    </div>
</template>

<script>

export default {
    name: "OrderPage",

}
</script>

<style scoped>

</style>
