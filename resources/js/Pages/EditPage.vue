<template>
    <app-layout title="EditPage" :chooseCate="false" NowPage="Edit" NowCate="NONE" :isSub="false" shareUrl="https://isevdb.net">
        <template #header>
            <h2 class="emitTitle">iseV</h2>
        </template>

        <template #window>
            <div v-if="type == 'youtube'" class="relative w-full aspect-video mb-10 flex-none">
                <YouTube :src="player.VideoID" :vars="playerVars" ref="youtube" width="100%" height="100%" class="videoWindow static" />
            </div>
            <div v-else class="mx-0 min-w-full">
                <IMGwindow v-if="this.player.tweetType == 'photo'" :url="this.player.tweetUrl" class="min-w-full py-2"></IMGwindow>
                <TWwindow v-if="this.player.tweetType == 'video'" :url="this.player.tweetUrl" class="min-w-full"></TWwindow>
            </div>
        </template>

        <template #default>
            <template v-if="!isForm">
                <div class="flex flex-col justify-items-center text-center mt-16">
                    <p class="text-xl text-gray-200 mb-8">編集内容を選択してください</p>
                    <div v-if="type == 'youtube'" class="flex flex-col">
                        <button class="w-fit mx-auto w-40 px-5 py-1 text-gray-200 bg-green-700 text-md rounded-full my-2" @click="status(1)">
                            メン限報告
                        </button>
                        <button class="w-fit mx-auto w-40 px-5 py-1 text-gray-200 bg-gray-700 text-md rounded-full my-2" @click="status(2)">
                            非公開報告
                        </button>
                    </div>
                    <button class="w-fit mx-auto w-40 px-5 py-1 text-gray-200 bg-blue-700 text-md rounded-full mb-2 mt-8" @click="checkLogin">
                        内容を変更
                    </button>
                    <button class="w-fit mx-auto w-40 px-5 py-1 text-gray-200 bg-rose-700 text-md rounded-full my-2" @click="checkDelete">
                        削除申請
                    </button>

                    <div v-if="confirmDelete" class="w-fit mx-auto my-4 py-3 px-6 shadow-md shadow-gray-900 border border-gray-300 rounded-lg">
                        <template v-if="!$page.props.user">
                            <p class="text-xl text-gray-200 mb-8">登録時のハンドルネームを入力、またはログインしてください。</p>
                            <div class="w-full">
                                <label class="sr-only" for="HandleName"> HandleName </label>
                                <input
                                    v-model="createrHN"
                                    class="w-max-4xl py-1 my-4 text-sm border-2 border-gray-200 rounded"
                                    id="HandleName"
                                    type="text"
                                    placeholder="HN "
                                />
                                <button class="w-fit mx-2 px-5 py-1 text-gray-200 bg-rose-700 text-md rounded-full my-auto" @click="status(3)">
                                    送信
                                </button>
                            </div>
                            <Link as="button" :href="route('myLogin')" class="text-xl rounded-md bg-green-600 text-gray-100 px-5 py-1 my-10 mx-auto"
                                >ログイン</Link
                            >
                        </template>
                        <template v-else>
                            <p class="text-xl text-gray-200 mb-8">本当に削除しますか？</p>
                            <button class="w-fit mx-2 px-5 py-1 text-gray-200 bg-rose-700 text-md rounded-full my-auto" @click="status(3)">
                                削除
                            </button>
                        </template>
                    </div>

                    <div v-if="checkForm" class="w-fit mx-auto my-4 py-3 px-6 shadow-md shadow-gray-900 border border-gray-300 rounded-lg">
                        <p class="text-xl text-gray-200 mb-8">登録時のハンドルネームを入力、またはログインしてください。</p>
                        <div class="w-full">
                            <label class="sr-only" for="HandleName"> HandleName </label>
                            <input
                                v-model="createrHN"
                                class="w-max-4xl py-1 my-4 text-sm border-2 border-gray-200 rounded"
                                id="HandleName"
                                type="text"
                                placeholder="HN"
                            />
                            <button class="w-fit mx-2 px-5 py-1 text-gray-200 bg-rose-700 text-md rounded-full my-auto" @click="checkHN">送信</button>
                        </div>
                        <Link as="button" :href="route('myLogin')" class="text-xl rounded-md bg-green-600 text-gray-100 px-5 py-1 my-10 mx-auto"
                            >ログイン</Link
                        >
                    </div>
                </div>
            </template>
            <template v-if="isForm">
                <div class="flex flex-col justify-items-center text-center mt-16 text-center">
                    <p class="mx-auto mb-1 mt-3 text-md text-red-200">タイトル</p>
                    <label class="sr-only" for="Title"> Title </label>
                    <input
                        v-model="registerData['title']"
                        class="w-max-4xl py-1 my-4 text-sm border-2 border-gray-200 rounded"
                        id="Title"
                        type="text"
                        placeholder="Title"
                    />
                    <p class="mx-auto mb-1 mt-3 text-md text-red-200">メンバーを設定してください</p>
                    <select
                        class="mx-auto mb-1 mt-3 w-fit form-select form-select-md appearance-none block px-8 py-1 text-sm text-gray-700 bg-white border border-solid border-gray-300 rounded transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        aria-label="member"
                        name="member"
                        v-model="registerData['member_id']"
                    >
                        <option v-for="member in $page.props.setting.member" :key="'member' + member.id" :value="member.id">
                            {{ member.display }}
                        </option>
                    </select>
                    <p class="mx-auto mb-1 mt-3 text-md text-red-200">カテゴリーを設定してください</p>
                    <select
                        class="mx-auto mb-1 mt-3 w-fit form-select form-select-md appearance-none block px-8 py-1 text-sm text-gray-700 bg-white border border-solid border-gray-300 rounded transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        aria-label="member"
                        name="member"
                        v-model="registerData['cate_id']"
                    >
                        <option v-for="cate in $page.props.setting.category" :key="'cate' + cate.id" :value="cate.id">
                            {{ cate.title }}
                        </option>
                    </select>
                    <template v-if="player.twitter == null">
                        <p class="mx-3 my-auto mb-1 mt-3 text-md text-red-200">スタートタイム</p>
                        <label class="sr-only" for="Start"> Start </label>
                        <input
                            v-model="registerData['start']"
                            class="w-fit mx-auto py-1 my-4 text-sm border-2 border-gray-200 rounded"
                            id="Start"
                            type="time"
                            step="1"
                            placeholder="Start"
                        />
                        <p class="mx-3 my-auto mb-1 mt-3 text-md text-red-200">エンドタイム</p>
                        <label class="sr-only" for="End"> End </label>
                        <input
                            v-model="registerData['end']"
                            class="w-fit mx-auto py-1 my-4 text-sm border-2 border-gray-200 rounded"
                            id="End"
                            type="time"
                            step="1"
                            placeholder="End"
                        />
                    </template>
                    <button class="w-fit mx-auto px-5 py-1 text-gray-200 bg-rose-700 text-md rounded-full my-auto" @click="change">送信</button>
                </div>
            </template>
            <p v-if="complete" class="text-green-400 text-lg my-5 text-center">送信が完了しました。ご協力ありがとうございます！</p>
            <p v-if="completeDelete" class="text-green-400 text-lg my-5 text-center">
                間違えて削除した場合は復元できます。管理人に連絡してください。
            </p>
            <p v-if="errorMessage" class="text-red-400 text-lg my-5 text-center">
                照合に失敗しました。ハンドルネームを忘れた場合は管理人に連絡してください。
            </p>
        </template>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import YouTube from "vue3-youtube"
import TWwindow from "../components/TWwindow.vue"
import IMGwindow from "../components/IMGwindow.vue"
import { Link } from "@inertiajs/inertia-vue3"

export default defineComponent({
    props: {
        player: Object,
        id: String,
    },
    components: {
        AppLayout,
        YouTube,
        TWwindow,
        IMGwindow,
        Link,
    },
    data() {
        return {
            playerVars: {
                autoplay: 0,
                controls: 1,
                start: this.player.start,
                iv_load_policy: 3,
            },
            registerData: [],
            type: "",
            isForm: false,
            complete: false,
            sendArray: new FormData(),
            createrHN: "",
            confirmDelete: false,
            checkForm: false,
            errorMessage: false,
            completeDelete: false,
        }
    },
    created() {
        this.registerData = this.player
        if (this.player.twitter == null) {
            let Stime = this.player["start"]
            let SINTtime = Math.floor(Stime)
            let Shour = ("00" + Math.floor(SINTtime / 3600)).slice(-2)
            let Smin = ("00" + Math.floor((SINTtime % 3600) / 60)).slice(-2)
            let Srem = ("00" + (SINTtime % 60)).slice(-2)
            let SHMStime = Shour + ":" + Smin + ":" + Srem
            this.registerData["start"] = SHMStime

            let Etime = this.player["end"]
            let EINTtime = Math.floor(Etime)
            let Ehour = ("00" + Math.floor(EINTtime / 3600)).slice(-2)
            let Emin = ("00" + Math.floor((EINTtime % 3600) / 60)).slice(-2)
            let Erem = ("00" + (EINTtime % 60)).slice(-2)
            let EHMStime = Ehour + ":" + Emin + ":" + Erem
            this.registerData["end"] = EHMStime

            this.type = "youtube"
        } else {
            this.type = "twitter"
        }
        if (this.$page.props.user != null) {
            this.createrHN = this.$page.props.user.name
        } else {
            if (this.$cookies.get("createrHN") != null) {
                this.createrHN = this.$cookies.get("createrHN")
            }
        }
    },
    methods: {
        status(s) {
            let self = this
            this.sendArray.set("id", this.id)
            this.sendArray.set("status", s)
            if (s == 3 && this.createrHN != this.player.CreaterHN && this.createrHN != "admin") {
                this.errorMessage = true
            } else {
                this.errorMessage = false
                axios
                    .post("/api/status/player", this.sendArray, {
                        headers: {
                            "content-type": "multipart/form-data",
                            "X-HTTP-Method-Override": "PUT",
                        },
                    })
                    .then((response) => {
                        console.log(response)
                        self.complete = true
                        if (s == 3) {
                            self.completeDelete = true
                            self.confirmDelete = false
                        }
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            }
        },
        change() {
            let self = this
            this.sendArray.set("id", this.id)
            this.sendArray.set("title", this.registerData["title"])
            this.sendArray.set("member_id", this.registerData["member_id"])
            this.sendArray.set("cate_id", this.registerData["cate_id"])
            this.sendArray.set("type", this.type)
            if (this.type == "youtube") {
                let S_RowTIme = this.registerData["start"]
                let StimeArray = S_RowTIme.split(":")
                if (StimeArray.length == 2) {
                    let STimeM = StimeArray[0]
                    let STimeS = StimeArray[1]
                    let StimeSecond = Number(STimeM) * 60 + Number(STimeS)
                    this.sendArray.set("start", StimeSecond)
                } else {
                    let STimeH = StimeArray[0]
                    let STimeM = StimeArray[1]
                    let STimeS = StimeArray[2]
                    let StimeSecond = Number(STimeH) * 3600 + Number(STimeM) * 60 + Number(STimeS)
                    this.sendArray.set("start", StimeSecond)
                }
                let E_RowTIme = this.registerData["end"]
                let EtimeArray = E_RowTIme.split(":")
                if (EtimeArray.length == 2) {
                    let ETimeM = EtimeArray[0]
                    let ETimeS = EtimeArray[1]
                    let EtimeSecond = Number(ETimeM) * 60 + Number(ETimeS)
                    this.sendArray.set("end", EtimeSecond)
                } else {
                    let ETimeH = EtimeArray[0]
                    let ETimeM = EtimeArray[1]
                    let ETimeS = EtimeArray[2]
                    let EtimeSecond = Number(ETimeH) * 3600 + Number(ETimeM) * 60 + Number(ETimeS)
                    this.sendArray.set("end", EtimeSecond)
                }
            }
            axios
                .post("/api/edit/player", this.sendArray, {
                    headers: {
                        "content-type": "multipart/form-data",
                        "X-HTTP-Method-Override": "PUT",
                    },
                })
                .then((response) => {
                    console.log(response)
                    self.complete = true
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        checkLogin() {
            if (this.$page.props.user) {
                if (this.$page.props.user.name == this.player.CreaterHN) {
                    this.errorMessage = false
                    this.isForm = true
                } else {
                    this.errorMessage = true
                }
            } else {
                this.confirmDelete = false
                this.checkForm = true
            }
        },
        checkHN() {
            if (this.createrHN == this.player.CreaterHN) {
                this.errorMessage = false
                this.isForm = true
            } else {
                this.errorMessage = true
            }
        },
        checkDelete() {
            this.checkForm = false
            this.confirmDelete = true
        },
    },
    computed: {
        YTplayer() {
            return this.$refs.youtube
        },
    },
})
</script>
<style scoped>
.emitTitle {
    color: #f59e0b;
    text-shadow: 0px 0px 20px #f59e0b;
}
.videoWindow {
    width: 100% !important;
    height: 100% !important;
    margin: 0;
}
</style>
