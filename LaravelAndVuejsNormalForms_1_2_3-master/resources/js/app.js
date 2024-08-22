import 'mdb-vue-ui-kit/css/mdb.min.css';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import { routes } from './routes.js';
import axios from 'axios';
import VueAxios from 'vue-axios';
import Navigation from './components/Navigation.vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle'; 
const router = createRouter({
    history: createWebHistory(),
    routes: routes
});
const app = createApp(Navigation);
app.use(router);
app.use(VueAxios, axios);
app.mount('#app');