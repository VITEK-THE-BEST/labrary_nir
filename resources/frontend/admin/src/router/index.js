import { createWebHistory, createRouter } from "vue-router";
import Home from "@/components/HomePage.vue";
import Book from "@/components/BookPage.vue";
import Registration from "@/components/RegistrationPage.vue";
import Authorization from "@/components/AuthorizationPage.vue";
import OrderPage from "@/components/OrderPage";
import OrderComplete from "@/components/OrderComplete";
import OrderNotComplete from "@/components/OrderNotComplete";

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/book",
        name: "Book",
        component: Book,
    },
    {
        path: "/register",
        name: "Registration",
        component: Registration,
    },
    {
        path: "/authorization",
        name: "Authorization",
        component: Authorization,
    },
    {
        path: "/order",
        name: "order",
        component: OrderPage,
    },
    {
        path: "/order_notComplete",
        name: "OrderNotComplete",
        component: OrderNotComplete,
    },
    {
        path: "/order_Complete",
        name: "OrderComplete",
        component: OrderComplete,
    },
];

const router = createRouter({
    history: createWebHistory(),
    base:'/admin/',
    routes,
});

export default router;
