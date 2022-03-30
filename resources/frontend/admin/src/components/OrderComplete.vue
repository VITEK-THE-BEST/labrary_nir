<template>
    <div>
        <router-link to="/order_notComplete">текущие заказы пользователей</router-link> |
        <router-link to="/order_Complete">завершенные заказы пользователей</router-link>  |

    </div>
    <div
        v-for="order in orders"
        :key="order.id"
    >
        <h3>{{ order.book.id }}</h3>
        <h3>{{ order.book.name }}</h3>
        <p>{{ order.book.author }}</p>

        <div v-if="order.price > 0">
            <p>Выплатили арендодателю: {{order['price']}} р.</p>
        </div>
        <div v-else>
            <p>Арендатель добавил к стоимости: {{ Math.abs(order['price']).toFixed(2)}} р.</p>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import OrderDataService from "@/services/OrderDataServise";

export default {
    name: "OrderComplete",
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
            OrderDataService.getAllCompleteOrder(this.$store.state.token)
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
