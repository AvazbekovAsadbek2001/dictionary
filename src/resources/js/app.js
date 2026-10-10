import { createApp } from 'vue';
import Welcome from './views/welcome.vue';

const app = createApp({})

app.component('welcome', Welcome);

app.mount('#app');
