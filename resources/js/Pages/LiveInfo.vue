<template>
    <div>
        <!-- header -->
        <div class="bg-stone-800 py-3">
            <header>
                <div class="flex justify-evenly max-w-5xl items-baseline mx-auto bg-stone-800">
                    <h2 class="goldTitle font-Caveat text-2xl sm:text-5xl emitRed h-fit">Live</h2>
                    <div class="notGold font-Caveat text-4xl sm:text-6xl h-fit">
                        <h2 class="emitTitle">iseV</h2>
                    </div>
                    <h2 class="goldTitle font-Caveat text-2xl sm:text-5xl emitRed h-fit">Info</h2>
                </div>
                <div class="flex flex-row justify-end pr-4 lg:pr-10 pb-2 bg-stone-800">
                    <Link
                        as="button"
                        :href="route('TopPage')"
                        class="flex flex-row font-body bg-transparent text-emerald-500 text-emit-lg shadow-emerald-400 text-xs md:text-lg"
                    >
                        非公式いせぶいDB
                    </Link>
                </div>
            </header>
        </div>
        <div class="w-full m-0 h-px goldLine"></div>
        <p class="text-md w-fit ml-auto mr-5 my-2 text-green-300" :class="load === true ? 'visible' : 'invisible'">Update</p>
        <div class="container mx-auto py-5 px-2">
            <p class="text-3xl text-gray-200 text-center my-4">Now Live</p>
            <div class="flex flex-row flex-wrap">
                <div v-for="item in Live" :key="'live' + item.id" class="py-1 px-1 sm:px-2 lg:px-1 w-full sm:w-1/2 lg:w-1/3 mx-auto">
                    <Card :title="item.title" :VideoID="item.VideoID" :date="null" :col="item.ImageCol" :member="item.display"></Card>
                </div>
            </div>
            <p class="text-3xl text-gray-200 text-center mt-6 mb-4">Live Schedule</p>
            <div class="flex flex-row flex-wrap">
                <div v-for="item in Schedule" :key="'schedule' + item.id" class="py-1 px-1 sm:px-2 lg:px-1 w-full sm:w-1/2 lg:w-1/3 mx-auto">
                    <Card :title="item.title" :VideoID="item.VideoID" :date="item.schedule" :col="item.ImageCol" :member="item.display"></Card>
                </div>
            </div>
        </div>
        <div class="w-full py-16 bg-stone-800 px-5">
            <div class="max-w-5xl mx-auto text-center">
                <p class="text-xxs lg-text-xs text-gray-100 mb-1">
                    <span>10分ごとにYouTubeのRSSから情報を取得し、</span>
                    <span>YouTubeAPIから状態を読み込んでいます。</span>
                </p>
                <p class="text-xxs lg-text-xs text-gray-100 mb-1">
                    <span>YouTubeの不具合や仕様で</span>
                    <span>反映されない場合があります。</span>
                </p>
            </div>
        </div>
        <div class="w-full pt-52 pb-16 bg-stone-800 px-5">
            <div class="max-w-5xl mx-auto text-center">
                <a class="text-xxs lg:text-xs text-gray-100" href="https://twitter.com/Mmazoku_media?s=20&t=aTPqq5WEuY9UgH-AKAKZTw"
                    >管理人：@Mmazoku_media</a
                >
                <p class="text-xxs lg-text-xs text-gray-100 mb-1">
                    ご意見・バグ報告は
                    <a class="text-blue-300" href="https://forms.gle/NrwdxsRVT9Q5XYkz9">Googleフォーム</a>
                    からでも可能です。
                </p>
                <p class="text-xxs lg:text-xs text-gray-100">当サイトは個人Vtuberグループ「いせぶい」のファンが制作した非公式サイトです。</p>
                <p class="text-xxs lg:text-xs text-gray-100">
                    <span>当サイトは完全非営利です。</span><span>ユーザー識別に使用している情報については</span
                    ><span>Registerページをご確認ください。</span>
                </p>
                <p class="text-xxs lg:text-xs text-gray-100">
                    <span>当サイト内の切り抜き・ファンアートの著作権は製作者に、</span
                    ><span>その他のコンテンツの著作権・肖像権はすべて「いせぶい」所属メンバーに帰属します。</span>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue"
import Card from "../components/Card.vue"
import { Head, Link } from "@inertiajs/inertia-vue3"

export default defineComponent({
    data() {
        return {
            Live: [],
            Schedule: [],
            Interval: undefined,
            load: false,
        }
    },
    mounted() {
        this.getStatus()
        this.Interval = setInterval(this.getStatus, 600000)
    },
    methods: {
        getStatus() {
            let self = this
            this.load = true
            axios
                .get("/api/liveinfo/status")
                .then((response) => {
                    self.Live = response["data"]["live"]
                    self.Schedule = response["data"]["schedule"]
                    self.load = false
                })
                .catch((error) => {
                    console.log(error)
                })
        },
    },
    unmounted: function () {
        clearTimeout(this.Interval)
    },
    components: {
        Card,
        Head,
        Link,
    },
})
</script>
<style scoped>
.emitTitle {
    color: #f59e0b;
    text-shadow: 0px 0px 20px #f59e0b;
}
.emitRed {
    color: #c4302b;
    text-shadow: 0px 0px 10px #d8c6c5;
}
.emitWhite {
    color: #dfc9c8;
    text-shadow: 0px 0px 20px #dfc9c8;
}
.goldLine {
    background: linear-gradient(45deg, #662f09 0%, #e49d2e 45%, #f2da97 70%, #e7c177 85%, #94591e 90% 100%);
    background: -moz-linear-gradient(45deg, #662f09 0%, #e49d2e 45%, #f2da97 70%, #e7c177 85%, #94591e 90% 100%);
    background: -webkit-linear-gradient(45deg, #662f09 0%, #e49d2e 45%, #f2da97 70%, #e7c177 85%, #94591e 90% 100%);
}
span {
    display: inline-block;
}
</style>
