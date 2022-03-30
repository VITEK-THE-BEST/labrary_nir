<template>
    <div>
        <h1>Книги:</h1>
    </div>

    <div>
        <dialog-component v-model:show="dialogVisible">
            <div>
                <h3>Выберите до какого числа хотите аредовать книгу</h3>
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
            <h3>{{ book['name'] }}</h3>
            <p>{{ book['author'] }}</p>
            <p>{{ book['genre'] }}</p>
            <button @click="showDialogTakeData(book)">арендовать за</button>

        </div>

    </div>
</template>

<script>
import BookDataService from "../services/BookDataServise";
import OrderDataService from "../services/OrderDataServise";
import DialogComponent from "@/components/DialogComponent";

export default {
    name: "BookPage",
    components: {
        DialogComponent
    },
    data() {
        return {
            date: "",
            books: [],
            currentBook: {},
            dialogVisible: false,
            buttonOrderVisible: false,
            priceOrder: 0,
        }
    },
    watch: {
        date(newVal) {
            this.getPrice(newVal)
        }
    },
    methods: {
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
            console.log(book)

            OrderDataService.create(book, this.date, this.$store.state.token)
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
        }
    },
    mounted() {
        this.getBooks()
    }
}
</script>

<style scoped>

</style>
