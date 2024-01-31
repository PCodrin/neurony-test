import("./bootstrap");

import '../css/app.css';

import { createApp, h } from "vue";
import {createInertiaApp} from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

createInertiaApp({
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(Toast, {
        position: "bottom-right",
      })
      .mount(el);
  },
})