<template>
    <div>
        <h1>Книги:</h1>
    </div>
    <button @click="takeTest" >Submit</button>

    <div>
        <h1>
            {{ text }}
        </h1>
    </div>
</template>

<script>
import TestDataService from "../services/BookDataServise";

export default {
    name: "BookPage",
    data() {
        return {
            text: '',
        }
    },
    methods: {
        takeTest() {
            TestDataService.getData()
                .then(response => {
                    console.log(response.data)
                    this.text = response.data[0]
                })
                .catch(e => {
                    console.log(e);
                });
        },
    },
    mounted() {
        this.takeTest()
    }
}
</script>

<style scoped>

</style>
