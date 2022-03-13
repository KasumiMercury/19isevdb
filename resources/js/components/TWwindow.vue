<template>
    <div :style="styles">
        <div v-if="openTweet">
            <blockquote
                class="twitter-tweet mx-auto shadow-2xl shadow-stone-900 shadow-xl rounded-lg"
                data-align="center"
                :data-height="TWheight"
                data-width="300"
                data-lang="ja"
                data-dnt="true"
                data-theme="dark"
            >
                <a :href="tweeturl"></a>
            </blockquote>
        </div>
    </div>
</template>
<script>
import { defineComponent } from "vue"

export default defineComponent({
    props: ["url"],
    data() {
        return {
            openTweet: false,
            tweeturl: undefined,
            TWheight: window.innerHeight * 0.7,
        }
    },
    created() {
        this.tweeturl = this.url
        console.log(this.TWheight)
        this.$nextTick(function () {
            this.openTweet = true
        })
        twttr.widgets.load()
    },
    methods: {
        handleResize: function () {
            this.TWheight = window.innerHeight * 0.7
        },
    },
    computed: {
        styles() {
            return {
                "--vh": this.TWheight,
            }
        },
    },
    mounted: function () {
        window.addEventListener("resize", this.handleResize)
    },
    unmounted: function () {
        window.removeEventListener("resize", this.handleResize)
    },
})
</script>
