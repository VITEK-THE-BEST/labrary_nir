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
            <h3>Арендатель:</h3>
            <p>{{ this.currentOrder['user']['name'] }}</p>
            <p>{{ this.currentOrder['user']['surname'] }}</p>
            <p>{{ this.currentOrder['user']['patronymic'] }}</p>

            <h3>книга</h3>
            <p>{{ this.currentOrder.book.name }}</p>
            <p>{{ this.currentOrder.book.author }}</p>
            <div v-if="this.currentOrder['price'] > 0">
                <p>Вы должны дать арендателю: {{this.currentOrder['price']}} р.</p>
            </div>
            <div v-else>
                <p>Арендатель должен заплаить: {{ Math.abs(this.currentOrder['price']).toFixed(2)}} р.</p>
            </div>

            <button @click="completeOrder(this.currentOrder)">Поддтвердить возврат</button>
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
        completeOrder(order) {
            OrderDataService.completeAdmin(order['book']['id'], order['user']['id'],this.$store.state.token)
                .then(response => {
                    console.log(response.data)
                    this.getOrders()
                    this.dialogVisible = false
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
