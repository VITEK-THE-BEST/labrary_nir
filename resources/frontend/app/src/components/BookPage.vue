<template>
    <div>
        <h1>Книги:</h1>
    </div>

    <div>
        <dialog-component v-model:show="dialogVisible">
            <div>

                <h3>Укажите дату на которую вы планируете закзать</h3>
                <input type="date">
                <button @click="">подтвердить дату</button>
            </div>
        </dialog-component>
    </div>
    <div>
        <div
            v-for="book in books"
            :key="book.id"
        >

            <h3>{{ book.name }}</h3>
            <p>{{ book.author }}</p>
            <p>{{ book.genre }}</p>
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
            books: [],
            currentBook:{},
            dialogVisible: false,
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
        orderBook(book) {
            OrderDataService.create(book, this.$store.state.token)
                .then(response => {
                    console.log(response.data)
                    // this.books = response.data
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
