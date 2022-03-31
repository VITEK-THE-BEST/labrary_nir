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
            <p>возращенно: {{ moment(order.updated_at).format("D.M.YY") }}</p>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import OrderDataService from "@/services/OrderDataServise";
import HeaderComponent from "@/components/HeaderComponent";

export default {
    name: "OrderComplete",
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
            OrderDataService.getCompleteOrder(this.$store.state.token)
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
            console.clear()

        }
    },
    mounted() {
        this.getOrders()
    }
}
</script>

<style scoped>

</style>
