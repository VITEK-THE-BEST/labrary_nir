<template>
    <header-component></header-component>

    <div>
        <router-link to="/order_notComplete">текущие заказы</router-link> |
        <router-link to="/order_Complete">завершенные заказы</router-link>  |

        <h1>мои заказы:</h1>
        <div>
            <router-view/>
        </div>

    </div>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent";

export default {
    name: "OrderPage",
    components:{
        HeaderComponent
    }

}
</script>

<style scoped>

</style>
