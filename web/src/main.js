import { createApp } from 'vue'
import VueRouter from './router/index'
import Antd from 'ant-design-vue'
import App from './App.vue'
import 'ant-design-vue/dist/reset.css'

const app = createApp(App)

app.use(Antd).use(VueRouter).mount('#app')