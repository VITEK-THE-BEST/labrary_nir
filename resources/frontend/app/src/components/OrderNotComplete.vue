<template>
    <header-component></header-component>

    <div>
        <router-link to="/order_notComplete">текущие заказы</router-link> |
        <router-link to="/order_Complete">завершенные заказы</router-link>  |
    </div>

    <div
        v-for="order in orders"
        :key="order.id"
    >
        <h3>{{ order.book.id }}</h3>
        <h3>{{ order.book.name }}</h3>
        <p>{{ order.book.author }}</p>
        <div>
            <p>зарезеривирован до: {{ moment(order.date_complete_order).format("D.M.YY") }}</p>
            <button @click="completeOrder(order.book.id)"> вернуть книгу</button>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import OrderDataService from "@/services/OrderDataServise";
import HeaderComponent from "@/components/HeaderComponent";

export default {
    name: "OrderNotComplete",
    components:{
        HeaderComponent
    },
    created: function () {
        this.moment = moment;
    },
    data() {
        return {
            orders: [],
        }
    },
    methods: {
        getOrders() {
            OrderDataService.getNotCompleteOrder(this.$store.state.token)
                .then(response => {
                    console.log(response.data['orders'])
                    this.orders = response.data['orders']
                    this.buttonOrderVisible = true
                })
                .catch(e => {
                    console.log(e);
                });
            console.clear()
        },
        completeOrder(book_id) {
            console.log(book_id)
            OrderDataService.completeOrder(book_id, this.$store.state.token)
                .then(response => {
                    console.log(response.data)
                    this.getOrders()
                })
                .catch(e => {
                    console.log(e);
                });
        }
    },
    mounted() {
        this.getOrders()
    }
}
</script>

<style scoped>

</style>
