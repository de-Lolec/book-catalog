import { createApp } from 'vue'
import store from './store'
import './style.css'
import router from './router/router'
import App from './App.vue'

createApp(App)
  .use(router)
  .use(store)
  .mount('#app')
