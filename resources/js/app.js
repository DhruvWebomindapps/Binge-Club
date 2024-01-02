import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp, defineComponent } from "vue";

import Booking from './components/Admin/Booking.vue';
import FrontendBooking from './components/Frontend/Booking.vue';

const root = defineComponent({})

const app = createApp(root);
app.component('booking-app', Booking)

app.mount("#admin-app");


const rootFrontend = defineComponent({})

const frontendApp = createApp(root);
app.component('booking-app', FrontendBooking)

app.mount("#frontend-app");