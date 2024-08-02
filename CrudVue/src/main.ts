import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './main.css'

// Importaciones de PrimeVue
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
import Aura from '@primevue/themes/aura';
import 'primeicons/primeicons.css'

const app = createApp(App)

// Toast de PrimeVue
app.use(ToastService);
app.use(ConfirmationService);

// Tema de Prime
app.use(PrimeVue, {
    theme: {
        preset: Aura
    }
});

app.use(router)

app.mount('#app')
