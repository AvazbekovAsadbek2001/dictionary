import { createApp } from 'vue';
import Welcome from './views/welcome.vue';
import Menu from './views/menu.vue';
import Section from './views/section.vue';
import Condition from './views/condition.vue';
import SectionTypes from './views/section-type.vue';


const app = createApp({})

app.component('welcome', Welcome);
app.component('app-menu', Menu);
app.component('app-section', Section);
app.component('section-type', SectionTypes);
app.component('condition', Condition);

app.mount('#app');
