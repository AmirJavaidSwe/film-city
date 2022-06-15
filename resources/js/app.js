import './bootstrap';

import { createApp } from 'vue'

import { createPinia } from 'pinia'

import App from './App.vue'

import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min.js'

const app = createApp(App)

import StarRating from 'vue-star-rating'

app.component("star-rating", StarRating);

const pinia = createPinia();

app.use(pinia)

import router from './router'

app.use(router)

import Multiselect from '@vueform/multiselect'

app.component("Multiselect", Multiselect);

import "@vueform/multiselect/themes/default.css"

app.mount('#app')
