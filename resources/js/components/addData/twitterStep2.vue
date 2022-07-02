<template>
    <div class="flex flex-col">
        <p class="text-xs lg:text-sm text-gray-100 mt-2 mb-1 text-center mx-auto">ペーストボタンを押してクリップボードからペースト</p>
        <p class="text-xs lg:text-sm text-gray-100 my-1 text-center mx-auto">または入力欄にURLを入力してAddボタンを押してください。</p>
        <p class="text-xs lg:text-sm text-gray-100 mt-1 mb-2 text-center mx-auto">（ペーストボタンは初回時、ブラウザ許可が必要です。）</p>

        <p v-if="isFirefox" class="text-sm text-red-500 my-1 text-center mb-2 mx-auto">Firefoxはペーストボタンを使用できません。</p>

        <p class="text-sm text-gray-100 mt-2 text-center mb-1 mx-auto">複数データの一括登録ができます。</p>
        <p class="text-sm text-gray-100 mt-1 text-center mb-2 mx-auto">メンバーを複数含む場合は、メンバー毎に設定してください。</p>
        <p class="text-md text-red-300 text-bold text-center mb-2 mt-4 mx-auto">画像または動画を含むツイートのみ対応しています。</p>
        <p class="text-md text-red-300 text-bold text-center my-2 mx-auto">
            ツイート右下のボタン→「ツイートのリンクをコピー」から取得されるURLを入力してください。
        </p>

        <div class="flex flex-row items-end mt-5 lg:mt-10 w-full">
            <div class="relative grow">
                <label class="sr-only" for="twitter"> Twitter </label>

                <input
                    class="w-full py-3 pl-3 pr-12 text-sm border-2 border-gray-200 rounded"
                    id="twitter"
                    type="url"
                    placeholder="https://twitter.com/"
                    v-model="urlInput"
                />
            </div>
            <div class="mx-1 w-fit" v-if="isFirefox === false">
                <button class="bg-gray-500 text-lg font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="paste">ペースト</button>
            </div>
        </div>
        <div class="mr-1 ml-auto w-fit mt-5">
            <button class="bg-[#1da1f2] text-lg font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="addTW">Add</button>
        </div>
        <div class="flex flex-col w-full">
            <div v-for="(data, index) in dataArray" :key="'data' + index">
                <twForm
                    :twitter="data"
                    @changeTitle="changeTitle(index, $event)"
                    @changeMember="changeMember(index, $event)"
                    @changeCategory="changeCategory(index, $event)"
                    @delete="dataDelete(index)"
                    @check="check(index)"
                ></twForm>
            </div>
        </div>
        <button
            v-if="dataArray.length != 0"
            class="bg-gray-200 text-lg font-bold text-gray-900 px-5 py-1 lg:py-2 rounded-md mr-1 ml-auto w-fit mt-5 lg:mt-10"
            @click="nextStep"
        >
            Next
        </button>
    </div>
</template>

<script>
import twForm from "./twForm"
import dayjs from "dayjs"
dayjs.locale("ja")

export default {
    data() {
        return {
            dataArray: [],
            errorArray: [],
            urlInput: "",
            isFirefox: false,
        }
    },
    created() {
        let agent = window.navigator.userAgent.toLowerCase()
        if (agent.indexOf("firefox") != -1) {
            this.isFirefox = true
        }
    },
    components: {
        twForm,
    },
    methods: {
        format(date) {
            let formated = dayjs(date).format("YYYY-MM-DD HH:mm:ss")
            return formated
        },
        addTW() {
            let whereDomain = this.urlInput.indexOf("twitter.com/") + 12
            let whereName = this.urlInput.indexOf("/status/")
            let whereStatus = this.urlInput.indexOf("/status/") + 8
            let whereEnd = this.urlInput.indexOf("?s=")
            if (whereEnd == -1) {
                this.createTweet = this.urlInput.slice(whereStatus)
            } else {
                this.createTweet = this.urlInput.slice(whereStatus, whereEnd)
            }
            let screenName = this.urlInput.slice(whereDomain, whereName)
            let member = this.$page.props.setting.member.find((v) => v.TWaccount == screenName)

            this.tweetForm = {}

            this.tweetForm.id = Math.floor(Math.random() * 101)
            this.tweetForm.twitterURL = this.urlInput
            this.tweetForm.twitterId = this.createTweet
            this.tweetForm.title = ""
            this.tweetForm.cate_id = 5
            if (member) {
                this.tweetForm.member_id = member.id
            } else {
                this.tweetForm.member_id = 1
            }
            this.tweetForm.status = 0
            this.dataArray.push(this.tweetForm)
            this.errorArray.push(true)
        },
        changeTitle(index, event) {
            this.dataArray[index]["title"] = event
            if (this.dataArray[index].title == "") {
                this.errorArray[index] = true
            } else {
                this.errorArray[index] = false
            }
        },
        changeMember(index, event) {
            this.dataArray[index]["member_id"] = event
        },
        changeCategory(index, event) {
            this.dataArray[index]["cate_id"] = event
        },
        dataDelete(index) {
            this.dataArray.splice(index, 1)
            this.errorArray.splice(index, 1)
        },
        nextStep() {
            for (let k = 0; k < this.dataArray.length; k++) {
                delete this.dataArray[k].id
                delete this.dataArray[k].twitterURL
            }
            this.$emit("nextStep", this.dataArray)
        },
        check(index) {
            this.$emit("checkTW", this.dataArray[index].twitterURL)
        },
        paste() {
            if (navigator.clipboard) {
                let self = this
                navigator.clipboard.readText().then(function (text) {
                    self.urlInput = text
                    self.addTW()
                })
            }
        },
        emits: ["nextStep", "checkTW"],
    },
}
</script>
