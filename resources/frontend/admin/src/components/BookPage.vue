<template>
    <div>
        <h1>Выдать книгу:</h1>
    </div>

    <div>
        <dialog-component v-model:show="dialogVisible">
            <div>
                <h3>человека который хочет арендовать книгу</h3>
                <select @change="switchSelect">
                    <option disabled value="">Выберите из списка</option>

                    <option
                        v-for="option in users"
                        :key="option.id"
                        :value="option.id"
                    >
                        {{ option.name }}
                    </option>
                </select>


                <br>
                <input
                    type="date"
                    @input="date = $event.target.value"
                >

                <div v-if="buttonOrderVisible">
                    <h4>цена аренды: {{ this.priceOrder }}</h4>
                    <button @click="orderBook(this.currentBook)">арендовать книгу</button>
                </div>
            </div>
        </dialog-component>
    </div>

    <div>
        <div
            v-for="book in books"
            :key="book.id"
        >
            <h3>{{ book['id'] }}</h3>
            <h3>{{ book['name'] }}</h3>
            <p>{{ book['author'] }}</p>
            <p>{{ book['genre'] }}</p>
            <button @click="showDialogTakeData(book)">выдать книгу</button>

        </div>

    </div>
</template>

<script>
import UserDataServise from "../services/UserDataServise";
import BookDataService from "../services/BookDataServise";
import OrderDataService from "../services/OrderDataServise";
import DialogComponent from "@/components/DialogComponent";

export default {
    name: "BookPage",
    components: {
        DialogComponent,
    },
    data() {
        return {
            date: "",
            books: [],
            currentBook: {},
            dialogVisible: false,
            buttonOrderVisible: false,
            priceOrder: 0,
            selectUser: '',
            users: [{}],
        }
    },
    watch: {
        date(newVal) {
            this.getPrice(newVal)
        }
    },
    methods: {
        switchSelect(event) {
            console.log(event)
            this.selectUser = event.target.value;
        },
        getBooks() {
            BookDataService.show()
                .then(response => {
                    // console.log(response.data)
                    this.books = response.data
                })
                .catch(e => {
                    console.log(e);
                });
        },
        getPrice(date) {
            this.currentBook['date'] = date
            OrderDataService.getPrice(this.currentBook)
                .then(response => {
                    console.log(response.data)
                    this.priceOrder = response.data
                    this.buttonOrderVisible = true
                })
                .catch(e => {
                    console.log(e);
                });
            console.clear()

        },
        orderBook(book) {
            OrderDataService.createOrderAdmin(book, this.date,this.selectUser, this.$store.state.token)
                .then(response => {
                    console.log(response.data)
                    this.getBooks();
                    this.priceOrder = response.data
                    this.dialogVisible = false;
                    this.buttonOrderVisible = false;

                })
                .catch(e => {
                    console.log(e);
                });
        },
        showDialogTakeData(book) {
            this.dialogVisible = true;
            this.currentBook = book;
        },
        getUsers() {
            UserDataServise.getUsers(this.$store.state.token)
                .then(response => {
                    this.users = response.data
                })
                .catch(e => {
                    console.log(e);
                });
        }
    },
    mounted() {
        this.getBooks()
        this.getUsers()
    }
}
</script>

<style scoped>

</style>
