require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('home-page', require('./components/HomePage.vue').default);


import router from './router';

const app = new Vue({
    el: '#app',
    router
});
