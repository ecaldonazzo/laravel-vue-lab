import './bootstrap'
import { createApp } from 'vue'
import PrimeVue from 'primevue/config'
import Aura from '@primevue/themes/aura'
import 'primeicons/primeicons.css'
import router from './router'
import AppLayout from './layouts/AppLayout.vue'

const app = createApp(AppLayout)

app.use(router)
app.use(PrimeVue, {
    theme: {
        preset: Aura,
    }
})

app.mount('#app')