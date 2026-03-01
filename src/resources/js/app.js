import './bootstrap';
import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import 'primeicons/primeicons.css';

const app = createApp({});

app.use(PrimeVue, {
    theme: {
        preset: Aura,
    }
});

app.mount('#app');