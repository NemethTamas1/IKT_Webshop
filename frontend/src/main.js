import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { router } from '@/router/index.js'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import { plugin, defaultConfig } from '@formkit/vue'
import config from '../formkit.config.js'

// Vue Toastify - Az értesítésekhez
import Toast from "vue3-toastify";
import "vue3-toastify/dist/index.css";

import App from '@/App.vue'

import '@assets/app.scss'

const app = createApp(App)

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

app.use(router)
app.use(plugin, defaultConfig(config))
app.use(pinia)
app.use(Toast);


app.mount('#app')
