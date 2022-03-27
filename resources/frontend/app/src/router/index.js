import { createWebHistory, createRouter } from "vue-router";
import Home from "@/components/HomePage.vue";
import Book from "@/components/BookPage.vue";
import Registration from "@/components/RegistrationPage.vue";

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
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
