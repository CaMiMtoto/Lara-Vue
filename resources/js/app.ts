import '../css/app.css';
import '../css/main.scss';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
//
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
// import VueSweetalert2 from 'vue-sweetalert2';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';
import DatePlugin from './plugins/date';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(DatePlugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#014D84FF',
    },
}).then((r) => {
    console.log(r);
});

// This will set light / dark mode on page load...
initializeTheme();
