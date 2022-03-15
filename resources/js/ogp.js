import "./bootstrap"
import { createApp } from "vue"
import SharePage from "./Pages/SharePage.vue"

const app = createApp({
    components: {
        SharePage,
    },
}).mount("#app")
