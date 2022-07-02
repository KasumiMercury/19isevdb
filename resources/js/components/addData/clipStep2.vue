<template>
    <div class="flex flex-col">
        <p class="text-xs lg:text-sm text-gray-100 mt-2 mb-1 text-center mx-auto">ペーストボタンを押してクリップボードからペースト</p>
        <p class="text-xs lg:text-sm text-gray-100 my-1 text-center mx-auto">または入力欄にURLを入力してAddボタンを押してください。</p>
        <p class="text-xs lg:text-sm text-gray-100 mt-1 mb-2 text-center mx-auto">（ペーストボタンは初回時、ブラウザ許可が必要です。）</p>

        <p v-if="isFirefox" class="text-sm text-red-500 my-1 text-center mb-2 mx-auto">Firefoxはペーストボタンを使用できません。</p>

        <p class="text-sm text-gray-100 mt-2 text-center mb-1 mx-auto">複数データの一括登録ができます。</p>
        <p class="text-sm text-gray-100 my-1 text-center mx-auto">メンバーを複数含む場合は、メンバー毎に設定してください。</p>
        <p class="text-sm text-gray-100 mt-1 mb-2 text-center mx-auto">動画タイトル・概要欄内からメンバーを識別できた場合、自動セットされます。</p>

        <div class="flex flex-row items-end mt-5 lg:mt-10 w-full">
            <div class="relative grow">
                <label class="sr-only" for="clip"> YouTube </label>

                <input
                    class="w-full py-3 pl-3 pr-12 text-sm border-2 border-gray-200 rounded"
                    id="clip"
                    type="url"
                    placeholder="https://youtu.be/"
                    v-model="urlInput"
                />
            </div>
            <div class="mx-1 w-fit" v-if="isFirefox === false">
                <button class="bg-gray-500 text-lg font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="paste">ペースト</button>
            </div>
        </div>
        <div class="mr-1 ml-auto w-fit mt-5">
            <button class="bg-[#da1725] text-lg font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="addClip">Add</button>
        </div>
        <p v-if="error" class="text-sm text-red-200">取得に失敗しました。入力内容を確認してください。</p>
        <div class="flex flex-col w-full">
            <div v-for="(data, index) in dataArray" :key="'data' + index">
                <clipForm :clip="data" @changeMember="changeMember(index, $event)" @delete="dataDelete(index)"></clipForm>
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
import clipForm from "./clipForm"
import dayjs from "dayjs"
dayjs.locale("ja")

export default {
    data() {
        return {
            dataArray: [],
            urlInput: "",
            createID: "",
            params: {
                id: "",
                key: "AIzaSyCv9gZE-50Vj3fVj1dgk0IPv0O1MoDsiHI",
                part: "snippet",
            },
            memberSearch: [
                ["恋惡まよ", "まよすけ", "まよ抜き"],
                ["星降あめる", "あめる", "切り取るあめる"],
                ["綵てまり", "てまりん", "てまらいぶ"],
                ["心寧はな", "まぢかよはな"],
                ["羽奏こはく", "わかちこ", "羽奏を見よ"],
                ["泉谷このみ", "このみん"],
                ["勇未つかさ"],
                ["紅月うる", "うるち", "うるこま", "うるカット"],
                ["稲荷こまち", "いなこま", "うるこま", "いなこま切れ"],
                ["神白ニア", "ニア", "ニア刈り"],
            ],
            error: false,
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
        clipForm,
    },
    methods: {
        filterMember(text) {
            let memberIdArray = []
            for (let i = 0; i < this.memberSearch.length; i++) {
                let tempArray = this.memberSearch[i]
                for (let k = 0; k < tempArray.length; k++) {
                    let tempWord = tempArray[k]
                    if (text.indexOf(tempWord) !== -1) {
                        let isExist = memberIdArray.includes(i + 1)
                        if (isExist == false) {
                            memberIdArray.push(i + 1)
                        }
                    }
                }
            }
            return memberIdArray
        },
        format(date) {
            let formated = dayjs(date).format("YYYY-MM-DD HH:mm:ss")
            return formated
        },
        addClip() {
            console.log(this.urlInput)
            let isShort = this.urlInput.indexOf("watch")
            if (isShort != -1) {
                let WhereS = this.urlInput.indexOf("=") + 1
                let WhereTime = this.urlInput.indexOf("&t")
                if (WhereTime != -1) {
                    this.createID = this.urlInput.slice(WhereS, WhereTime)
                } else {
                    let whereQuery = this.urlInput.indexOf("&")
                    if (whereQuery != -1) {
                        this.createID = this.urlInput.slice(WhereS, whereQuery)
                    } else {
                        this.createID = this.urlInput.slice(WhereS)
                    }
                }
            } else {
                let WhereDomain = this.urlInput.indexOf("youtu.be/") + 9
                let WhereTime = this.urlInput.indexOf("?t=")
                if (WhereTime != -1) {
                    this.createID = this.urlInput.slice(WhereDomain, WhereTime)
                } else {
                    this.createID = this.urlInput.slice(WhereDomain)
                }
            }
            if (this.createID != "") {
                this.error = false
                this.params.id = this.createID
                let self = this
                axios
                    .get("https://www.googleapis.com/youtube/v3/videos", {
                        params: this.params,
                    })
                    .then(function (res) {
                        self.results = res.data.items[0].snippet
                        let textArray = [self.results.title, self.results.description]
                        let memberIdArray = self.filterMember(textArray.join(""))

                        if (memberIdArray == 0) {
                            memberIdArray = [1]
                        }

                        for (let i = 0; i < memberIdArray.length; i++) {
                            let clipForm = {}

                            clipForm.VideoID = self.createID
                            clipForm.title = self.results.title
                            clipForm.date = self.format(self.results.publishedAt)
                            clipForm.channel = self.results.channelTitle
                            clipForm.thumbnail = self.results.thumbnails.default.url
                            clipForm.member_id = memberIdArray[i]
                            clipForm.start = 0
                            clipForm.end = 0
                            clipForm.status = 0
                            clipForm.cate_id = 4
                            clipForm.id = Math.floor(Math.random() * 101)
                            self.dataArray.push(clipForm)
                        }
                        console.log(self.dataArray)
                    })
                    .catch((error) => {
                        console.log(error)
                        self.error = true
                    })
            } else {
                this.error = true
            }
        },
        changeMember(index, event) {
            this.dataArray[index]["member_id"] = event
        },
        dataDelete(index) {
            this.dataArray.splice(index, 1)
        },
        nextStep() {
            for (let k = 0; k < this.dataArray.length; k++) {
                delete this.dataArray[k].channel
                delete this.dataArray[k].thumbnail
                delete this.dataArray[k].id
            }
            this.$emit("nextStep", this.dataArray)
        },
        paste() {
            if (navigator.clipboard) {
                let self = this
                navigator.clipboard.readText().then(function (text) {
                    self.urlInput = text
                    self.addClip()
                })
            }
        },
        emits: ["nextStep"],
    },
}
</script>
