<template>
    <div>
        <Head title="LIVE info">
            <meta
                name="description"
                content="個人Vtuberグループ、異世界転生してVになりました、略して「いせぶい」に所属する恋惡まよ、心寧はな、星降あめる、綵てまり、羽奏こはく、泉谷このみ、紅月うる、稲荷こまち、神白ニア、各メンバーのリアルタイムライブ配信状況"
            />
            <meta property="og:title" :content="'非公式いせぶいDBリアルタイムライブ状況'" />
            <meta property="og:type" content="article" />
            <meta property="og:url" content="https://isevdb.net/" />
            <meta property="og:site_name" content="非公式いせぶいDB" />
            <meta
                property="og:description"
                content="個人Vtuberグループ、異世界転生してVになりました、略して「いせぶい」に所属する恋惡まよ、心寧はな、星降あめる、綵てまり、羽奏こはく、泉谷このみ、紅月うる、稲荷こまち、神白ニア、各メンバーのリアルタイムライブ配信状況"
            />
            <meta property="og:locale" content="ja_JP" />
        </Head>
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
                <div class="flex flex-row justify-start pr-4 lg:pr-10 pb-2 bg-stone-800">
                    <Link
                        as="button"
                        :href="route('TopPage')"
                        class="mr-auto ml-3 lg:ml-5 font-body bg-transparent text-emerald-500 text-emit-lg shadow-emerald-400 text-xs md:text-lg"
                    >
                        非公式いせぶいDB
                    </Link>
                </div>
            </header>
        </div>
        <div class="w-full m-0 h-px goldLine"></div>
        <div class="w-full pt-5 bg-stone-800 px-5 relative">
            <div class="max-w-5xl mx-auto text-center pb-5">
                <p class="text-xxs lg-text-xs text-gray-100 mb-1">
                    <span>2分ごとにYouTubeのRSSから情報を取得し、</span>
                    <span>YouTubeAPIから状態を読み込んでいます。</span>
                </p>
                <p class="text-xxs lg-text-xs text-gray-100 mb-1">
                    <span>YouTubeの不具合や仕様で</span>
                    <span>反映されない場合があります。</span>
                </p>
                <p class="text-xxs lg-text-xs text-red-400 mb-1">ページの再読み込みは不要です。</p>
                <p class="text-xxs lg-text-xs text-gray-100 mb-1">それぞれのカードをクリックすると新規タブで開きます。</p>
            </div>
            <div class="absolute bottom-0 left-0 w-full">
                <transition>
                    <p v-show="load == true" class="text-xxs lg-text-xs text-green-300 mb-1 w-fit mx-auto">Updated</p>
                </transition>
            </div>
        </div>
        <div class="container mx-auto pb-5 px-2 flex flex-col">
            <div>
                <p class="text-3xl text-gray-200 text-center mb-4">Now Live</p>
                <div class="flex flex-row flex-wrap">
                    <div v-for="item in Live" :key="'live' + item.id" class="py-1 px-1 sm:px-2 lg:px-1 w-full sm:w-1/2 lg:w-1/3 mx-auto">
                        <Card
                            :title="item.title"
                            :status="item.status"
                            :VideoID="item.VideoID"
                            :date="null"
                            :col="item.ImageCol"
                            :member="item.display"
                        ></Card>
                    </div>
                </div>
            </div>
            <div>
                <p class="text-3xl text-gray-200 text-center mt-6 mb-4">Live Schedule</p>
                <div class="flex flex-row flex-wrap">
                    <div v-for="item in Schedule" :key="'schedule' + item.id" class="py-1 px-1 sm:px-2 lg:px-1 w-full sm:w-1/2 lg:w-1/3 mx-auto">
                        <Card
                            :title="item.title"
                            :status="item.status"
                            :VideoID="item.VideoID"
                            :date="item.schedule"
                            :col="item.ImageCol"
                            :member="item.display"
                        ></Card>
                    </div>
                </div>
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
        this.Interval = setInterval(this.getStatus, 120000)
    },
    methods: {
        getStatus() {
            let self = this
            axios
                .get("/api/liveinfo/status")
                .then((response) => {
                    self.Live = response["data"]["live"]
                    self.Schedule = response["data"]["schedule"]
                    self.load = true
                    setTimeout(() => {
                        self.load = false
                    }, 1)
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
.v-leave-active {
    transition: opacity 5s;
}
.v-leave {
    opacity: 1;
}

.v-leave-to {
    opacity: 0;
}
</style>
