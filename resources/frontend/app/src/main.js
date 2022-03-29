// import './plugins/axios'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import moment from 'moment'

createApp(App)
    .use(router)
    .use(store)
    .mount('#app')
