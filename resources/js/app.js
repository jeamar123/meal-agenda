import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import Layouts from '@/Layouts'
import { route } from 'ziggy-js'

import '../sass/app.scss'

window.route = route

createInertiaApp({
  resolve: async (name) => {
    const page = await resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob('./Pages/**/*.vue'),
    )

    const layout = page?.default?.props?.layout?.default
    if (layout) {
      page.default.layout =
        Layouts[typeof layout === 'function' ? layout() : layout]
    } else {
      page.default.layout = Layouts.Default
    }

    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)
  },
})
