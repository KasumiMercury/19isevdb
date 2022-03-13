<template>
    <div class="flex flex-col">
        <div class="flex flex-row" :style="styles">
            <div v-if="currentPage == 0" class="cursor-pointer mt-20 mx-1 flex-none" @click="currentPage = pageLength - 1">
                <svg class="fill-gray-400 w-6 md:w-12 h-6 md:h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M137.4 406.6l-128-127.1C3.125 272.4 0 264.2 0 255.1s3.125-16.38 9.375-22.63l128-127.1c9.156-9.156 22.91-11.9 34.88-6.943S192 115.1 192 128v255.1c0 12.94-7.781 24.62-19.75 29.58S146.5 415.8 137.4 406.6z"
                    />
                </svg>
            </div>
            <div v-else class="cursor-pointer mt-20 mx-1 flex-none" @click="currentPage--">
                <svg class="fill-white w-6 md:w-12 h-6 md:h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M137.4 406.6l-128-127.1C3.125 272.4 0 264.2 0 255.1s3.125-16.38 9.375-22.63l128-127.1c9.156-9.156 22.91-11.9 34.88-6.943S192 115.1 192 128v255.1c0 12.94-7.781 24.62-19.75 29.58S146.5 415.8 137.4 406.6z"
                    />
                </svg>
            </div>
            <div class="flex-grow">
                <div v-for="(url, index) in tweeturl" :key="index">
                    <img class="imgResize mx-auto" v-if="index == currentPage" :src="url" alt="" />
                </div>
            </div>
            <div v-if="currentPage == Number(pageLength) - 1" class="cursor-pointer mt-20 mx-1 flex-none" @click="currentPage = 0">
                <svg class="fill-gray-400 w-6 md:w-12 h-6 md:h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M118.6 105.4l128 127.1C252.9 239.6 256 247.8 256 255.1s-3.125 16.38-9.375 22.63l-128 127.1c-9.156 9.156-22.91 11.9-34.88 6.943S64 396.9 64 383.1V128c0-12.94 7.781-24.62 19.75-29.58S109.5 96.23 118.6 105.4z"
                    />
                </svg>
            </div>
            <div v-else class="cursor-pointer mt-20 mx-1 flex-none" @click="currentPage++">
                <svg class="fill-white w-6 md:w-12 h-6 md:h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M118.6 105.4l128 127.1C252.9 239.6 256 247.8 256 255.1s-3.125 16.38-9.375 22.63l-128 127.1c-9.156 9.156-22.91 11.9-34.88 6.943S64 396.9 64 383.1V128c0-12.94 7.781-24.62 19.75-29.58S109.5 96.23 118.6 105.4z"
                    />
                </svg>
            </div>
        </div>
        <p class="mr-3 ml-auto text-sm text-gray-200">{{ currentPage + 1 }}/{{ pageLength }}</p>
    </div>
</template>
<script>
import { defineComponent } from "vue"

export default defineComponent({
    props: ["url"],
    data() {
        return {
            openTweet: false,
            tweeturl: new Array(),
            currentPage: 0,
            pageLength: 0,
            height: window.innerHeight + "px",
        }
    },
    created() {
        this.tweeturl = this.url.split(",")
        this.pageLength = this.tweeturl.length
        this.$nextTick(function () {
            this.openTweet = true
        })
        twttr.widgets.load()
    },
    methods: {
        next() {
            this.currentPage++
        },
        prev() {
            this.currentPage--
        },
        handleResize: function () {
            this.height = window.innerHeight + "px"
        },
    },
    computed: {
        styles() {
            return {
                "--vh": this.height,
            }
        },
    },
    mounted: function () {
        window.addEventListener("resize", this.handleResize)
    },
    beforeDestroy: function () {
        window.removeEventListener("resize", this.handleResize)
    },
})
</script>
<style scoped>
.imgResize {
    max-height: 80vh;
    max-height: calc(var(--vh) * 0.8) !important;
    max-width: 90%;
}
</style>
