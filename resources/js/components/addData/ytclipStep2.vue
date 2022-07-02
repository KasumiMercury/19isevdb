<template>
    <div class="flex flex-col">
        <p class="text-xs lg:text-sm text-gray-100 mt-2 mb-1 text-center mx-auto">ペーストボタンを押してクリップボードからペースト</p>
        <p class="text-xs lg:text-sm text-gray-100 my-1 text-center mx-auto">または入力欄にURLを入力してAddボタンを押してください。</p>
        <p class="text-xs lg:text-sm text-gray-100 mt-1 mb-2 text-center mx-auto">（ペーストボタンは初回時、ブラウザ許可が必要です。）</p>
        <p class="text-sm text-gray-100 mt-2 text-center mb-1 mx-auto">複数データの一括登録ができます。</p>
        <p class="text-sm text-gray-100 mt-1 text-center mb-2 mx-auto">メンバーを複数含む場合は、メンバー毎に設定してください。</p>

        <p v-if="isFirefox" class="text-sm text-red-500 my-1 text-center mb-2 mx-auto">Firefoxはペーストボタンを使用できません。</p>

        <div class="flex flex-row items-end mt-5 lg:mt-10 w-full">
            <div class="relative grow">
                <label class="sr-only" for="YTclip"> Youtube Clip </label>

                <input
                    class="w-full py-3 pl-3 pr-12 text-sm border-2 border-gray-200 rounded"
                    id="YTclip"
                    type="url"
                    placeholder="https://www.youtube.com/clip/"
                    v-model="urlInput"
                />
            </div>
            <div class="mx-1 w-fit" v-if="isFirefox === false">
                <button class="bg-gray-500 text-lg font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="paste">ペースト</button>
            </div>
        </div>
        <div class="mr-1 ml-auto w-fit mt-5">
            <button class="bg-[#da1725] text-lg font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="addYTclip">Add</button>
        </div>
        <div class="flex flex-col w-full">
            <div v-for="(data, index) in dataArray" :key="'data' + index">
                <ytclipForm
                    :ytclip="data"
                    @changeTitle="changeTitle(index, $event)"
                    @changeMember="changeMember(index, $event)"
                    @changeCategory="changeCategory(index, $event)"
                    @delete="dataDelete(index)"
                ></ytclipForm>
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
import ytclipForm from "./ytclipForm"
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
        ytclipForm,
    },
    methods: {
        format(date) {
            let formated = dayjs(date).format("YYYY-MM-DD HH:mm:ss")
            return formated
        },
        addYTclip() {
            let YTclipForm = {}

            YTclipForm.id = Math.floor(Math.random() * 101)
            YTclipForm.YTclipURL = this.urlInput
            YTclipForm.title = ""
            YTclipForm.date = this.format(new Date())
            YTclipForm.cate_id = 4
            YTclipForm.member_id = 1
            YTclipForm.status = 0
            this.dataArray.push(YTclipForm)
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
            }
            this.$emit("nextStep", this.dataArray)
        },
        paste() {
            if (navigator.clipboard) {
                let self = this
                navigator.clipboard.readText().then(function (text) {
                    self.urlInput = text
                    self.addYTclip()
                })
            }
        },
        emits: ["nextStep"],
    },
}
</script>
