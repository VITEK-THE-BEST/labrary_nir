<template>
    <header-component></header-component>

    <dialog-component v-model:show="dialogVisible">
        <div v-if="price < 0">
            <h3>Вы должны доплатить: {{ Math.abs(price).toFixed(2)}}</h3>
            <button @click="completeOrder(order.book.id)"> поддтвердить получение</button>
        </div>
        <div v-else>
            <h3>Вам должны вернуть: {{ price}}</h3>
            <button @click="completeOrder(order.book.id)"> поддтвердить получение</button>

        </div>
    </dialog-component>

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
            <button @click="showDialog()"> вернуть книгу</button>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import OrderDataService from "@/services/OrderDataServise";
import HeaderComponent from "@/components/HeaderComponent";
import DialogComponent from "@/components/DialogComponent";

export default {
    name: "OrderNotComplete",
    components:{
        HeaderComponent,
        DialogComponent
    },
    created: function () {
        this.moment = moment;
    },
    data() {
        return {
            orders: [],
            dialogVisible: false,
            price:0
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
        },
        showDialog(){
            this.dialogVisible = true
        },
    },
    mounted() {
        this.getOrders()
        this.getOrders()
    }
}
</script>

<style scoped>

</style>
