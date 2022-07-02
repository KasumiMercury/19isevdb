<template>
    <div>
        <Head>
            <meta name="description" content="個人Vtuberグループいせぶい非公式データベース　初めての方へ" />
        </Head>
        <app-layout title="AutoRegister" :chooseCate="false" NowPage="Register" NowCate="Channel" :isSub="false" shareUrl="https://isevdb.net">
            <template #header>
                <h2 class="emitTitle">iseV</h2>
            </template>

            <template #default>
                <div v-if="$page.props.user == null && createrHN == null" class="text-center flex flex-col justify-center mt-5">
                    <p class="text-sm text-gray-100 mt-2 mb-1 text-center mx-auto">アカウントをお持ちの方はログインをしてください。</p>
                    <Link as="button" :href="route('myLogin')" class="text-lg my-5 bg-green-700 text-gray-200 px-5 py-1 rounded-md mx-auto"
                        >ログイン・登録はこちら</Link
                    >
                </div>
                <div v-if="createrHN == null" class="flex flex-col text-center pt-10">
                    <p class="text-sm text-gray-100 mt-2 mb-1 text-center mx-auto">登録時のハンドルネームを入力してください。</p>

                    <div class="relative mt-5 lg:mt-10">
                        <label class="sr-only" for="HN"> HN </label>

                        <input
                            class="w-full py-3 pl-3 pr-12 text-sm border-2 border-gray-200 rounded"
                            id="HN"
                            type="text"
                            placeholder="HN"
                            v-model="HNinput"
                        />
                    </div>
                    <div class="mr-1 ml-auto w-fit mt-5 lg:mt-10">
                        <button class="bg-gray-600 text-lg font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="setHN">Send</button>
                    </div>
                </div>
                <div v-if="loaded" class="w-full flex flex-col mt-6">
                    <div
                        v-for="item in player"
                        :key="item.stock.id"
                        class="w-full px-2 border-2 border-gray-50 text-gray-50 my-4 rounded-md flex flex-col"
                    >
                        <div class="flex flex-row">
                            <img :src="'https://img.youtube.com/vi/' + item.stock.VideoID + '/default.jpg'" class="w-16 mx-2 my-1" alt="" />
                            <p class="px-1">{{ item.stock.title }}</p>
                        </div>
                        <div class="w-fit mr-0 ml-auto">
                            <p v-if="item.stock.status == 0" class="text-gray-100">未処理</p>
                            <p v-else-if="item.stock.status == 3" class="text-red-400">処理済み・登録除外</p>
                            <p v-else-if="item.stock.status == 2" class="text-blue-400">処理済み・手動登録データ有</p>
                            <p v-else class="text-green-400">処理済み・自動登録</p>
                        </div>
                        <div v-if="item.stock.status == 1 || item.stock.status == 2">
                            <div
                                v-for="info in item.player"
                                :key="'player_' + info.id"
                                class="px-4 pt-2 pb-4 flex flex-col text-xxs lg:text-xs text-gray-50 border-t-2 border-gray-50"
                            >
                                <p>登録メンバー：{{ info.name }}</p>
                                <p>処理日：{{ format(info.created_at) }}</p>
                                <div class="mr-0 ml-auto w-fit">
                                    <Link
                                        as="a"
                                        class="underline decoration-solid text-blue-300 cursor-pointer mx-2"
                                        :href="'/auto/player/' + info.id"
                                        >プレイヤーページ</Link
                                    >
                                    <Link as="a" class="underline decoration-dotted text-blue-300 cursor-pointer mx-2" :href="'/edit/' + info.id"
                                        >編集ページ</Link
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </app-layout>
    </div>
</template>

<script>
import { defineComponent } from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import { Head, Link } from "@inertiajs/inertia-vue3"
import dayjs from "dayjs"
dayjs.locale("ja")

export default defineComponent({
    components: {
        AppLayout,
        Link,
        Head,
    },
    data() {
        return {
            createrHN: null,
            HNinput: null,
            player: null,
            loaded: false,
        }
    },
    created() {
        if (this.$page.props.user != null) {
            this.createrHN = this.$page.props.user.name
            this.getData()
        } else {
            if (this.$cookies.get("createrHN") != null) {
                this.createrHN = this.$cookies.get("createrHN")
            }
            this.getData()
        }
    },
    methods: {
        format(date) {
            let formated = dayjs(date).format("YYYY-MM-DD HH:mm:ss")
            return formated
        },
        setHN() {
            this.createrHN = this.HNinput
            this.getData()
        },
        getData() {
            let self = this
            axios
                .get("/api/channel/collation", {
                    params: {
                        user: this.createrHN,
                    },
                })
                .then((response) => {
                    self.player = response["data"]["player"]
                    console.log(self.player)
                    self.loaded = true
                })
                .catch((error) => {
                    console.log(error)
                })
        },
    },
})
</script>
<style scoped>
.emitTitle {
    color: #f59e0b;
    text-shadow: 0px 0px 20px #f59e0b;
}
</style>
