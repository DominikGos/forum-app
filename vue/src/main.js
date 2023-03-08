import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'
import { store } from './vuex/index.js'
import CKEditor from '@ckeditor/ckeditor5-vue'
import axios from "axios"

axios.defaults.baseURL = import.meta.env.VITE_BASE_URL
axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.headers.common['accept'] = 'application/json';

const app = createApp(App)

app
  .use(router)
  .use(store)
  .use(CKEditor)
  .mount('#app')
