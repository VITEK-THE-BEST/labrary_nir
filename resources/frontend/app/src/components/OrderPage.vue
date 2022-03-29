<template>
    <div>
        <h1>мои заказы:</h1>
        <div>
            <div
                v-for="order in orders"
                :key="order.id"
                v-if="order"
            >
                <h3>{{ order.book.id }}</h3>
                <h3>{{ order.book.name }}</h3>
                <p>{{ order.book.author }}</p>
                <div v-if="order.book.reserved === 0"
                >
                    <p>зарезеривирован до: {{ moment(order.date_complete_order).format("D.M.YY") }}</p>
                    <button @click="completeOrder(order.book.id)"> вернуть книгу</button>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
import OrderDataService from "../services/OrderDataServise";
import moment from 'moment';

export default {
    name: "OrderPage",
    created: function () {
        this.moment = moment;
    },
    setup() {
        let todaysDate = new Date();
    },
    data() {
        return {
            orders: [],
        }
    },
    methods: {
        getOrders() {
            OrderDataService.getOrders(this.$store.state.token)
                .then(response => {
                    console.log(response.data[0]['orders'])
                    this.orders = response.data[0]['orders']
                    this.buttonOrderVisible = true
                })
                .catch(e => {
                    console.log(e);
                });
            console.clear()

        },
        completeOrder(book_id) {
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
