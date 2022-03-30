<template>
    <div>
        <router-link to="/order_notComplete">текущие заказы пользователей</router-link>
        |
        <router-link to="/order_Complete">завершенные заказы пользователей</router-link>
        |
    </div>
    <dialog-component
        v-model:show="dialogVisible"
    >
        <div>
            <h3>поддтвердить получение и оплату следующего тавара:</h3>
            <p>{{ this.currentOrder.book.name }}</p>
            <p>{{ this.currentOrder.book.author }}</p>
            <p>{{ this.currentOrder }}</p>
        </div>

    </dialog-component>
    <div
        v-for="order in orders"
        :key="order.id"
        @click="showDialog(order)"
    >
        <h3>{{ order.book.id }}</h3>
        <h3>{{ order.book.name }}</h3>
        <p>{{ order.book.author }}</p>
        <div>
            <p>статус заказа: {{ order.status }}</p>
            <p>статус заказа: {{ order.status }}</p>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import OrderDataService from "@/services/OrderDataServise";
import DialogComponent from "@/components/DialogComponent";

export default {
    name: "OrderNotComplete",
    components: {
        DialogComponent
    },
    created: function () {
        this.moment = moment;
    },
    data() {
        return {
            currentOrder: [],
            orders: [],
            dialogVisible: false,
        }
    },
    methods: {
        getOrders() {
            OrderDataService.getAllNotCompleteOrder(this.$store.state.token)
                .then(response => {
                    console.log(response.data)
                    this.orders = response.data
                    this.buttonOrderVisible = true
                })
                .catch(e => {
                    console.log(e);
                });
            console.clear()
        },
        showDialog(order) {
            this.dialogVisible = true
            this.currentOrder = order

        },
    },
    mounted() {
        this.getOrders()
    }
}
</script>

<style scoped>

</style>
