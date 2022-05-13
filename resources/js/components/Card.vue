<template>
    <div
        class="cursor-pointer font-body w-full shadow-lg shadow-gray-900 bg-zinc-800 border-2 rounded-lg cardMain py-3 px-5 my-2 mx-auto"
        :style="styles"
        @click="jump"
    >
        <img :src="'https://img.youtube.com/vi/' + VideoID + '/maxresdefault.jpg'" alt="" loading="lazy" class="my-4" />
        <div class="h-14 lg:h-16">
            <p class="text-md text-gray-200 textOmit">{{ title }}</p>
        </div>
        <p v-if="date != null" class="text-md text-gray-200 mt-5 mb-auto">
            予定時刻：
            {{ moment(date, "YYYY/MM/DD  a h:mm") }}
        </p>
        <div v-else>
            <p v-if="status == 1" class="text-md text-gray-200 mt-5 mb-auto">予定時刻：読み込み準備中</p>
            <p v-else class="text-lg text-red-400 font-bold text-emit-lg w-fit ml-5 mr-auto mt-3 mb-auto">LIVE</p>
        </div>
        <p class="text-sm text-gray-200 w-fit ml-auto mr-2">{{ member }}</p>
    </div>
</template>

<script>
import moment from "moment"

export default {
    methods: {
        moment(date, format) {
            return moment(date).format(format)
        },
        jump() {
            let url = "https://www.youtube.com/watch?v=" + this.VideoID
            window.open(url, "_blank")
        },
    },
    props: ["title", "VideoID", "date", "col", "member", "status"],
    computed: {
        styles() {
            return {
                "--col": this.col,
            }
        },
    },
}
</script>
<style scoped>
.textOmit {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.cardMain {
    border-color: var(--col);
}
</style>
