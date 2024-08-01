import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './main.css'

// Importaciones de PrimeVue
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import 'primeicons/primeicons.css'

const app = createApp(App)

// Tema de Prime
app.use(PrimeVue, {
    theme: {
        preset: Aura
    }
});

app.use(router)

app.mount('#app')
