<template>

    <div class="main">
        <header-component></header-component>
        <div>
            <h1>Книги:</h1>
        </div>
        <div class="container">

            <dialog-component v-model:show="dialogVisible">
                <div>
                    <h3>Выберите до какого числа хотите аредовать книгу</h3>
                    <input
                        type="date"
                        @input="date = $event.target.value"
                        min="2022-04-05"
                    >

                    <div v-if="buttonOrderVisible">
                        <h4>Сумма залога: {{ this.priceOrder }}</h4>
                        <h4>Сумма аренды книги: {{ this.datePriceOrder }}</h4>
                        <button @click="orderBook(this.currentBook)">арендовать книгу</button>
                    </div>
                </div>
            </dialog-component>

            <div v-if="Object.keys(books).length > 0">

                <div>
                    <div
                        v-for="book in books"
                        :key="book"
                        class="card-question"
                    >

                        <h3 class="card-title">{{ book['name'] }}</h3>
                        <p class="card-text">{{ book['author'] }}</p>
                        <p class="card-text">{{ book['genre'] }}</p>
                        <button type="button" class="btn btn-primary btn-lg" @click="showDialogTakeData(book)">
                            арендовать
                        </button>
                    </div>
                </div>
            </div>
            <div v-else>
                <h3>Нет доступных книг</h3>
            </div>
        </div>
    </div>

</template>

<script>
import BookDataService from "../services/BookDataServise";
import OrderDataService from "../services/OrderDataServise";
import DialogComponent from "@/components/DialogComponent";
import HeaderComponent from "@/components/HeaderComponent";

export default {
    name: "BookPage",
    components: {
        DialogComponent,
        HeaderComponent
    },
    data() {
        return {
            date: "",
            nowDate: "2022-03-31",
            books: [],
            currentBook: {},
            dialogVisible: false,
            buttonOrderVisible: false,
            priceOrder: 0,
            datePriceOrder: 0,
        }
    },
    watch: {
        date(newVal) {
            this.getPrice(newVal)
        }
    },
    methods: {
        getNowDate() {
            let today = new Date();
            const dd = String(today.getDate()).padStart(2, '0');
            const mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            const yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;
            return today.toString();
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
                    this.priceOrder = response.data['order_price']
                    this.datePriceOrder = response.data['date_order_price']
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
        // this.nowDate = this.getNowDate()
    }
}
</script>

<style scoped>
.main {
    width: 100%;
    height: 100%;
    display: block;
    position: relative;
    background-color: #b0c3ef;
}

.main .container {
    padding: 30px 30px 30px 30px !important;
    margin-top: 100px;
    background: #FFFFFF;
    box-shadow: 0 6px 37px rgb(0 0 0 / 10%);
    border-radius: 15px;
    height: initial;
    margin-bottom: 50px !important;
    min-height: 800px;
}

textarea, textarea:focus {
    width: 500px;
    resize: none;
    outline: none;
    padding: 6px 10px 10px 10px;
    font-weight: 500;
    line-height: 1.2;
    font-size: 19px;
    color: #4b4b4b;
    border: none;
    border-bottom: 2px solid #2ab1a942;
    background: #f9f9f9;
    transition: 0.15s all ease-in-out;
    margin-bottom: 15px;
}


textarea:focus {
    background: #eeeeee;
    border-bottom: 2px solid #2ab1a999;
    transition: 0.15s all ease-in-out;
}

textarea:hover {
    background: #eeeeee;
    transition: 0.15s all ease-in-out;
}


.regulation__group-elements .element {
    padding: 8px 5px 8px 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: -1px;
    background-color: #fff;
    border: 1px solid rgba(0, 0, 0, .125);
}


h5.card-title {
    font-size: 27px;
}


p.card-text {
    font-size: 18px;
    color: #5d5d5d;
}

input[type=checkbox] {
    width: 16px;
    height: 16px;
    margin-right: 8px;
}


a {
    font-size: 16px;
    width: 100px;
    height: 30px;
    background: #2ab1a9;
    border-radius: 25px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.25);
    text-decoration: none;
    color: #F3F3F3 !important;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: 0.21s all ease-in-out;
    cursor: pointer;
}

.card-question {
    width: 970px;
    min-height: 140px;
    margin-top: 30px;
    transition: 0.12s border-left ease-in-out;
    border-radius: 10px;
    border-left: 10px solid #fff;
    box-shadow: 0 2px 21px rgb(0 0 0 / 9%);
    padding: 20px;
    height: initial;
    overflow: hidden;
    background-color: rgba(194, 206, 213, 0.56);
}

.border__nav-control .nav-control__fix {
    position: fixed;
    width: 70px;
    text-align: center;
    height: initial;
    border-radius: 10px;
}

.nav-control__fix ul {
    list-style: none;
    margin: 0;
    padding-inline-start: 0;
}

.nav-control__fix ul li {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 70px;
    height: 55px;
    transition: 0.1s all ease-in-out;
    border: 2px solid #f1f1f1;
    margin-bottom: 15px;
    border-radius: 15px;
}

.nav-control__fix ul li:first-child {
    height: 50px;
}


svg {
    font-size: 24px;
    color: #797979;
}

a:hover {
    transition: 0.2s all ease-in-out;
    background: #b12a2a;
    text-decoration: none;
    color: #F3F3F3;
}

label {
    margin-bottom: 0;
}


</style>
