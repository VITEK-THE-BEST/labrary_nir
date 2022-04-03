<template>
    <dvi class="main">

        <header-component></header-component>
        <div class="container">

            <h3>Научно-исследовательская работа 4 курс</h3>
            <h3>Выполнил студент Югорского государственного университета</h3>
            <h3>Лука Виктор Витальевич</h3>
            <h4>1181б</h4>
        </div>
    </dvi>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent";

export default {
    name: "HomePage",
    components: {
        HeaderComponent
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

</style>
