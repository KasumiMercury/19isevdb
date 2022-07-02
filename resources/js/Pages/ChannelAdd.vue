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
                <div class="px-4">
                    <div class="flex flex-col text-center pt-10">
                        <p class="text-xs lg:text-sm text-gray-100 mt-2 mb-1 text-center mx-auto">
                            <span class="inline-block">登録されたチャンネルにアップロードされた動画を</span
                            ><span class="inline-block">自動的に非公式いせぶいDBに登録します。</span>
                        </p>
                        <p class="text-xs lg:text-sm text-gray-100 mt-1 mb-2 text-center mx-auto">
                            <span class="inline-block">登録されたデータは非公式いせぶいDBで閲覧可能となる他、</span
                            ><span class="inline-block">@unoff_IseVDBのbotで定期的にツイートされます。</span>
                        </p>
                    </div>
                    <div v-if="!$page.props.user" class="text-center flex flex-col justify-center my-8">
                        <p class="text-xxs lg:text-sm text-gray-100 mt-2 mb-1 text-center mx-auto">
                            アカウントをお持ちの方はログインをしてから進んでください。
                        </p>
                        <p class="text-xxs lg:text-sm text-gray-100 mt-1 mb-2 text-center mx-auto">
                            途中でログインを行うと編集中のデータが初期化されます。
                        </p>
                        <Link as="button" :href="route('myLogin')" class="text-lg my-5 bg-green-700 text-gray-200 px-5 py-1 rounded-md mx-auto"
                            >ログイン・登録はこちら</Link
                        >
                    </div>
                    <div class="flex flex-col text-center pt-15">
                        <p class="text-xs lg:text-sm text-gray-100 mt-2 mb-1 text-center mx-auto">あなたのチャンネルURLを入力してください。</p>
                        <p class="text-xs lg:text-sm text-gray-100 mt-1 mb-2 text-center mx-auto">
                            <span class="inline-block">末尾に23文字のアルファベットを含む、</span
                            ><span class="inline-block">「https://youtube.com/channel/」</span
                            ><span class="inline-block">から始まるURLのみ有効です。</span>
                        </p>
                        <p class="text-xxs text-gray-100 mt-1 mb-2 text-center mx-auto break-words">
                            例）https://www.youtube.com/channel/UCjlO0QCarccGehZqm6rhnSQ
                        </p>
                        <p class="text-xs lg:text-sm text-gray-100 mt-10 mb-2 text-center mx-auto">
                            <span class="inline-block">右上のアイコンから「チャンネル」を押して</span
                            ><span class="inline-block">ご自身のチャンネルに飛んでください。</span>
                        </p>
                        <p class="text-xs lg:text-sm text-gray-100 mt-1 mb-2 text-center mx-auto">アプリの場合は右上の︙から「共有」「コピー」を</p>
                        <p class="text-xs lg:text-sm text-gray-100 mt-1 mb-2 text-center mx-auto">
                            <span class="inline-block">PCの場合はそのページのURLをコピーしてください。</span
                            ><span class="inline-block">（「/featured」などは自動的に削除されます。）</span>
                        </p>

                        <div class="relative mt-5 lg:mt-10">
                            <label class="sr-only" for="channel"> YouTube </label>

                            <input
                                class="w-full py-3 pl-3 pr-12 text-xs lg:text-sm border-2 border-gray-200 rounded"
                                id="channel"
                                type="url"
                                placeholder="https://youtube.com/channel/"
                                v-model="urlInput"
                            />
                        </div>
                        <div class="mr-1 ml-auto w-fit mt-5 lg:mt-10">
                            <button class="bg-[#da1725] text-lg font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="addChannel">Add</button>
                        </div>
                    </div>
                    <div v-if="added" class="flex flex-col text-center pt-4">
                        <div class="flex flex-row w-fit mx-auto">
                            <img width="88" height="88" :src="results.thumbnails.default.url" alt="チャンネルサムネイル" />
                            <p class="mx-5 text-gray-100">{{ results.title }}</p>
                        </div>
                        <p class="text-xs lg:text-sm text-gray-100 mt-2 mb-1 text-center mx-auto">あなたのチャンネルですか？</p>
                        <div class="mr-1 ml-auto w-fit mt-5 flex flex-row">
                            <button class="bg-red-600 text-lg font-bold text-gray-50 px-5 mx-2 py-1 lg:py-2 rounded-md" @click="back">No</button>
                            <button
                                v-if="$page.props.user"
                                class="bg-green-600 text-lg font-bold text-gray-50 px-5 mx-2 py-1 lg:py-2 rounded-md"
                                @click="postChannel"
                            >
                                Yes
                            </button>
                            <button
                                v-else
                                class="bg-green-600 text-lg font-bold text-gray-50 px-5 mx-2 py-1 lg:py-2 rounded-md"
                                @click="HNinput = true"
                            >
                                Yes
                            </button>
                        </div>
                        <div v-if="HNinput" class="relative mt-5 lg:mt-10">
                            <p class="text-lg text-gray-100 my-2">ハンドルネームを設定してください。削除申請時の照合に使用します。</p>
                            <label class="sr-only" for="HandleName"> HandleName </label>

                            <input
                                class="w-full py-3 pl-3 pr-12 text-xs lg:text-sm border-2 border-gray-200 rounded"
                                id="HandleName"
                                type="text"
                                placeholder="HN"
                                v-model="createrHN"
                            />
                        </div>
                        <div v-if="!$page.props.user" class="mr-1 ml-auto w-fit mt-5 flex flex-row">
                            <button
                                v-if="createrHN != null && createrHN != ''"
                                class="bg-green-600 text-lg font-bold text-gray-50 px-5 mx-2 py-1 lg:py-2 rounded-md"
                                @click="postChannel"
                            >
                                Send
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-row justify-center" v-if="sending">
                        <svg
                            v-if="loading"
                            class="animate-spin h-8 w-8 ml-0 mr-3 fill-green-400"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512"
                        >
                            <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path
                                d="M304 48C304 74.51 282.5 96 256 96C229.5 96 208 74.51 208 48C208 21.49 229.5 0 256 0C282.5 0 304 21.49 304 48zM304 464C304 490.5 282.5 512 256 512C229.5 512 208 490.5 208 464C208 437.5 229.5 416 256 416C282.5 416 304 437.5 304 464zM0 256C0 229.5 21.49 208 48 208C74.51 208 96 229.5 96 256C96 282.5 74.51 304 48 304C21.49 304 0 282.5 0 256zM512 256C512 282.5 490.5 304 464 304C437.5 304 416 282.5 416 256C416 229.5 437.5 208 464 208C490.5 208 512 229.5 512 256zM74.98 437C56.23 418.3 56.23 387.9 74.98 369.1C93.73 350.4 124.1 350.4 142.9 369.1C161.6 387.9 161.6 418.3 142.9 437C124.1 455.8 93.73 455.8 74.98 437V437zM142.9 142.9C124.1 161.6 93.73 161.6 74.98 142.9C56.24 124.1 56.24 93.73 74.98 74.98C93.73 56.23 124.1 56.23 142.9 74.98C161.6 93.73 161.6 124.1 142.9 142.9zM369.1 369.1C387.9 350.4 418.3 350.4 437 369.1C455.8 387.9 455.8 418.3 437 437C418.3 455.8 387.9 455.8 369.1 437C350.4 418.3 350.4 387.9 369.1 369.1V369.1z"
                            />
                        </svg>
                        <p v-if="loading" class="my-3 text-2xl text-green-400">送信中</p>
                        <p v-if="complete" class="my-3 text-2xl text-green-400">
                            完了しました！ご協力ありがとうございます！<br />
                            登録状況はページ下部の「自動登録照合ページ」から確認できます。
                        </p>
                        <p v-if="sendError" class="my-3 text-2xl text-red-400">
                            エラーが発生しました。内容を確認し、時間を数十秒おいて再度登録してください。
                        </p>
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

export default defineComponent({
    components: {
        AppLayout,
        Link,
        Head,
    },
    data() {
        return {
            urlInput: "",
            channelID: "",
            results: undefined,
            params: {
                id: "",
                key: "AIzaSyCv9gZE-50Vj3fVj1dgk0IPv0O1MoDsiHI",
                part: "snippet",
            },
            added: false,
            sending: false,
            loading: false,
            complete: false,
            sendError: false,
            sendArray: [],
            createrHN: null,
            HNinput: false,
        }
    },
    created() {
        if (this.$page.props.user != null) {
            this.createrHN = this.$page.props.user.name
        } else {
            if (this.$cookies.get("createrHN") != null) {
                this.createrHN = this.$cookies.get("createrHN")
            }
        }
    },
    methods: {
        addChannel() {
            let whereID = this.urlInput.indexOf("/channel/") + 9
            let tempID = this.urlInput.slice(whereID)
            let isExtra = tempID.indexOf("/")
            if (isExtra == -1) {
                this.channelID = tempID
            } else {
                this.channelID = tempID.slice(0, isExtra)
            }
            if (this.channelID != "") {
                this.params.id = this.channelID
                let self = this
                axios
                    .get("https://www.googleapis.com/youtube/v3/channels", {
                        params: this.params,
                    })
                    .then(function (res) {
                        self.results = res.data.items[0].snippet
                        self.added = true
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            }
        },
        back() {
            this.channelID = ""
            this.results = undefined
            this.added = false
            this.urlInput = ""
        },
        postChannel() {
            this.sending = true
            if (this.$page.props.user == null) {
                this.sendArray = []
                this.sendArray.push({
                    channelID: this.channelID,
                    createrHN: this.createrHN,
                    created_at: new Date(),
                    updated_at: new Date(),
                })
            } else {
                this.sendArray = []
                this.sendArray.push({
                    channelID: this.channelID,
                    createrHN: this.createrHN,
                    created_at: new Date(),
                    updated_at: new Date(),
                })
            }
            console.log(this.sendArray)
            let self = this
            this.loading = true
            axios({
                method: "post",
                url: "/api/add/autoregister",
                dataType: "json",
                data: this.sendArray,
            })
                .then((response) => {
                    console.log(response)
                    self.loading = false
                    self.complete = true
                })
                .catch((error) => {
                    self.loading = false
                    self.sendError = false
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
