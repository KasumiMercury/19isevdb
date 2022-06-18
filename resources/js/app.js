require("./bootstrap")

import { createApp, h } from "vue"
import { createInertiaApp } from "@inertiajs/inertia-vue3"
import { InertiaProgress } from "@inertiajs/progress"
import VueCookies from "vue-cookies"

const appName = window.document.getElementsByTagName("title")[0]?.innerText || "非公式いせぶいDB"

window.addEventListener("load", function () {
    if ("serviceWorker" in navigator) {
        navigator.serviceWorker
            .register("/service-worker.js", { scope: "/" })
            .then(function (registration) {
                console.log("serviceWorker registed.")
            })
            .catch(function (error) {
                console.warn("serviceWorker error.", error)
            })
    }
})

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VueCookies)
            .mixin({ methods: { route } })
            .mount(el)
    },
})

InertiaProgress.init({ color: "#4B5563" })
