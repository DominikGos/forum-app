import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'
import { store } from './vuex/index.js'
import CKEditor from '@ckeditor/ckeditor5-vue';

const app = createApp(App)

app
  .use(router)
  .use(store)
  .use(CKEditor)
  .mount('#app')
