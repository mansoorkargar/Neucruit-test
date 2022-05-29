/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import { createApp } from 'vue';

require('./bootstrap');

import App    from './layouts/App';
import axios  from 'axios';
import router from './router';
import store  from './store';
import VueApexCharts from "vue3-apexcharts";
import VueTelInput from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css'
import { Dataset, DatasetItem, DatasetInfo, DatasetPager, DatasetSearch, DatasetShow } from 'vue-dataset'

axios.defaults.withCredentials = true
console.log(process.env.MIX_API_HOST )
axios.defaults.baseURL = process.env.MIX_API_HOST + '/api';

axios.interceptors.request.use((config) => {
    const token = store.getters['authToken'];
    const study = store.getters['study'];

    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }

    if (study) {
        config.headers['X-Header-Study-Id'] = study.id;
    }

    return config;
});

if (store.getters['authToken']) {
    axios.interceptors.response.use(
        response => {
            return response;
        },
        error => {
            // if (error.response?.status === 400) {
            //     if (error.response?.data?.study === false) {
            //         router.push('/select-study');
            //         return false;
            //     }
            // }

            if (error.response?.status === 401) {
                store.commit('logOut');
                //router.push('/login');
                window.location.pathname = '/login';
                return false;
            }

            return Promise.reject(error);
        }
    );
}

const app = createApp(App);
app.use(router);
app.use(store);
app.mount('#app');
app.use(VueApexCharts);
app.use(VueTelInput);

app.component('Dataset', Dataset)
app.component('DatasetItem', DatasetItem)
app.component('DatasetInfo', DatasetInfo)
app.component('DatasetPager', DatasetPager)
app.component('DatasetSearch', DatasetSearch)
app.component('DatasetShow', DatasetShow)
