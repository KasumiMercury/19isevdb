<template>
    <div class="flex flex-col">
        <p v-if="isPaste == false" class="text-sm text-gray-200 text-center">▼ suk○スタンプなどのタイムスタンプから</p>
        <p v-if="isPaste == false" class="text-sm text-gray-200 text-center">データ用に変換します。</p>
        <button @click="isPaste = true" class="mt-2 mb-4 px-5 py-1 text-gray-900 bg-gray-300 rounded-md w-fit mx-auto">
            <span class="my-auto text-sm lg:text-base mr-1">貼り付けから取得</span>
        </button>

        <template v-if="isPaste == true">
            <div class="flex flex-col text-center mb-2">
                <p class="text-sm text-gray-200 mt-2">右側に時刻を含む文字列をペーストしてください。</p>
                <p class="text-sm text-gray-200">一行ずつ一つのデータとして変換されます。</p>
                <p class="text-sm text-gray-200">時刻とタイトルの間はスペースを開けてください。</p>
                <p class="text-sm text-gray-200 mb-2">全角半角問わず、suk○スタンプにも対応しています。</p>

                <button
                    v-if="isFirefox === false"
                    @click="pasteClip"
                    class="text-sm w-fit mx-auto py-1 px-6 my-3 bg-gray-200 text-gray-900 text-md rounded-md"
                >
                    ペースト
                </button>

                <div class="flex flex-row">
                    <div class="px-2 basis-1/2">
                        <label class="block mb-1 text-sm text-gray-200" for="example">Example</label>

                        <textarea
                            id="example"
                            class="w-full border px-4 py-2 rounded focus:border-blue-500 focus:shadow-outline outline-none"
                            rows="15"
                            readonly
                            :value="example"
                        ></textarea>
                    </div>
                    <div class="px-2 basis-1/2">
                        <label class="block mb-1 text-sm text-gray-200" for="PastedTime">Paste Time</label>

                        <textarea
                            id="PastedTime"
                            class="w-full border px-4 py-2 rounded focus:border-blue-500 focus:shadow-outline outline-none"
                            rows="15"
                            placeholder="Paste Time"
                            v-model="PastedTime"
                        ></textarea>
                    </div>
                </div>
                <button @click="PasteToTime" class="text-sm w-fit mx-auto py-1 px-6 my-2 bg-gray-200 text-gray-900 text-md rounded-md">変換</button>
                <button @click="isPaste = false" class="text-sm w-fit mx-auto py-1 px-6 my-2 bg-gray-200 text-gray-900 text-md rounded-md">
                    閉じる
                </button>
            </div>
        </template>

        <div
            v-for="(data, index) in dataArray"
            :key="'data' + index"
            class="w-full px-4 py-2 mb-4 rounded-md border border-gray-50"
            :class="errorArray[index] == true ? 'errorBorder' : ''"
        >
            <div class="flex flex-row" v-if="data.time.length != 0">
                <p class="text-left text-sm text-gray-50">グループ：{{ index + 1 }}</p>
                <button
                    @click="dataArray[index].switch = !data.switch"
                    class="bg-transparent my-1 mr-5 ml-auto flex flex-row justify-end justify-items-center"
                >
                    <svg
                        :class="dataArray[index].switch ? 'fill-green-500' : 'fill-green-900'"
                        class="w-3 h-3 mx-2 my-auto"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                    >
                        <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                        <path
                            d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"
                        />
                    </svg>
                    <p class="text-gray-200 text-xs my-auto">DBに追加</p>
                </button>
            </div>
            <draggableChild
                :data="data"
                @PlayAt="PlayAt($event)"
                @removed="removed(index, $event)"
                @added="added(index, $event)"
                @updateData="updateData(index)"
                @addTimeGroup="addTimeGroup(index)"
                ref="timedrag"
            ></draggableChild>
            <p v-if="warningArray[index] == true" class="text-yellow-200 text-sm text-right">
                中間タイムの個数に問題があるため、登録から除外されます。
            </p>
            <div v-if="data.time.length != 0">
                <AccordionPanel class="my-1" :default="true">
                    <template v-slot:title>
                        <span v-if="dataArray[index].title != ''" class="font-semibold text-sm text-gray-300">{{ dataArray[index].title }}</span>
                        <span v-else class="font-semibold text-sm text-gray-300">折りたたむ</span>
                    </template>
                    <template v-slot:content>
                        <div class="w-full my-1">
                            <label for="YTTitle" class="form-label text-gray-700 sr-only">Title input</label>
                            <input
                                v-model="dataArray[index].title"
                                @change="editTitle(index)"
                                type="text"
                                class="form-control block w-full px-3 py-1.5 text-sm text-gray-700 bg-white border border-solid border-gray-300 rounded m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                id="YTTitle"
                                placeholder="Title"
                            />
                        </div>
                        <div class="w-full flex flex-col lg:flex-row my-1">
                            <div class="basis-full lg:basis-1/2">
                                <div class="mb-1 lg:px-2 w-full">
                                    <label class="block mb-1 text-sm text-gray-200" for="select-member">Choose Member:</label>

                                    <div class="relative">
                                        <select
                                            class="w-full border px-4 pr-8 py-2 rounded focus:border-blue-500 focus:shadow-outline outline-none appearance-none"
                                            id="select-member"
                                            v-model="dataArray[index].member_id"
                                        >
                                            <option v-for="member in $page.props.setting.member" :key="'member' + member.id" :value="member.id">
                                                {{ member.display }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="basis-full lg:basis-1/2">
                                <div class="mb-1 lg:px-2 w-full">
                                    <label class="block mb-1 text-sm text-gray-200" for="select-category">Choose Category:</label>

                                    <div class="relative">
                                        <select
                                            class="w-full border px-4 pr-8 py-2 rounded focus:border-blue-500 focus:shadow-outline outline-none appearance-none"
                                            id="select-category"
                                            v-model="dataArray[index].cate_id"
                                        >
                                            <option
                                                v-for="category in $page.props.setting.category"
                                                :key="'category' + category.id"
                                                :value="category.id"
                                            >
                                                {{ category.title }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row mt-1 mb-2">
                            <!--
                            <button class="bg-transparent mr-1 ml-auto flex flex-row justify-end justify-items-center" @click="testPlay(index, true)">
                                <svg class="w-4 h-4 mx-2 my-auto fill-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path
                                        d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM111.1 208V432C111.1 440.8 119.2 448 127.1 448C136.8 448 143.1 440.8 143.1 432V208C143.1 199.2 136.8 192 127.1 192C119.2 192 111.1 199.2 111.1 208zM207.1 208V432C207.1 440.8 215.2 448 223.1 448C232.8 448 240 440.8 240 432V208C240 199.2 232.8 192 223.1 192C215.2 192 207.1 199.2 207.1 208zM304 208V432C304 440.8 311.2 448 320 448C328.8 448 336 440.8 336 432V208C336 199.2 328.8 192 320 192C311.2 192 304 199.2 304 208z"
                                    />
                                </svg>
                                <p class="text-red-500 my-auto text-xs lg:text-sm">全画面</p>
                            </button>
                            -->
                            <button
                                class="bg-transparent mr-5 ml-auto flex flex-row justify-end justify-items-center my-2"
                                @click="testPlay(index, false)"
                            >
                                <svg class="w-6 h-6 mx-2 my-auto fill-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM176 168V344C176 352.7 180.7 360.7 188.3 364.9C195.8 369.2 205.1 369 212.5 364.5L356.5 276.5C363.6 272.1 368 264.4 368 256C368 247.6 363.6 239.9 356.5 235.5L212.5 147.5C205.1 142.1 195.8 142.8 188.3 147.1C180.7 151.3 176 159.3 176 168V168z"
                                    />
                                </svg>
                                <p class="text-red-500 my-auto text-sm lg:text-sm">グループを再生</p>
                            </button>
                        </div>
                    </template>
                </AccordionPanel>
                <p v-if="errorArray[index] == true" class="text-red-300 text-xs text-center">タイトルが未入力です</p>
                <button class="mt-1 mb-2 bg-transparent mr-5 ml-auto flex flex-row justify-end justify-items-center" @click="dataDelete(index)">
                    <svg class="w-4 h-4 mx-2 my-auto fill-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                        <path
                            d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM111.1 208V432C111.1 440.8 119.2 448 127.1 448C136.8 448 143.1 440.8 143.1 432V208C143.1 199.2 136.8 192 127.1 192C119.2 192 111.1 199.2 111.1 208zM207.1 208V432C207.1 440.8 215.2 448 223.1 448C232.8 448 240 440.8 240 432V208C240 199.2 232.8 192 223.1 192C215.2 192 207.1 199.2 207.1 208zM304 208V432C304 440.8 311.2 448 320 448C328.8 448 336 440.8 336 432V208C336 199.2 328.8 192 320 192C311.2 192 304 199.2 304 208z"
                        />
                    </svg>
                    <p class="text-red-500 my-auto text-xs lg:text-sm">削除</p>
                </button>
            </div>
        </div>

        <p v-if="errorArray.includes(true) && dataArray.length != 1" class="text-lg font-bold text-red-300 px-5 py-1 lg:py-2 text-right">
            タイトルが入力されていないデータがあります。
        </p>
        <button
            v-if="!errorArray.includes(true) || dataArray.length == 1"
            class="bg-gray-200 text-lg font-bold text-gray-900 px-5 py-1 lg:py-2 rounded-md mr-1 ml-auto w-fit mt-5 lg:mt-10"
            @click="nextStep"
        >
            データ登録へ進む
        </button>
        <button
            v-if="dataArray.length != 1"
            class="bg-gray-200 text-lg font-bold text-gray-900 px-5 py-1 lg:py-2 rounded-md mr-1 ml-auto w-fit mt-5 lg:mt-10"
            @click="TimeStamp = true"
        >
            タイムスタンプを出力
        </button>
        <template v-if="TimeStamp == true">
            <div class="flex flex-col text-center my-5">
                <div class="text-center p-5 rounded-md border border-gray-300" id="target">
                    <ul style="list-style-type: none" class="text-center text-gray-50" v-for="data in dataArray" :key="'data' + data.title">
                        <template v-for="(time, index) in data.time" :key="'time' + index">
                            <li v-if="index % 2 === 0">
                                {{ time.displayTime }}<span v-if="index == 0">　{{ data.title }}</span> <span style="display: none">\n</span>
                            </li>
                        </template>
                    </ul>
                </div>
                <button @click="CopyStamp" class="text-md w-fit mx-auto py-3 px-6 my-3 bg-gray-200 text-gray-900 text-md rounded-md">コピー</button>
                <p v-if="pasteComplete" class="text-sm text-green-300 mx-auto">コピーしました！</p>
                <button @click="TimeStamp = false" class="text-sm w-fit mx-auto py-3 px-6 my-3 bg-gray-200 text-gray-900 text-md rounded-md">
                    閉じる
                </button>
            </div>
        </template>

        <ytCheckModal v-if="testPlayer" :isFull="isFull" :isVisible="testPlayer" @close="testPlayer = false" :player="player"></ytCheckModal>
    </div>
</template>

<script>
import draggableChild from "./draggableChild"
import ytCheckModal from "./ytCheckModal"
import AccordionPanel from "../../components/AccordionPanel"
import dayjs from "dayjs"
dayjs.locale("ja")

export default {
    props: ["youtubeInfo"],
    data() {
        return {
            dataArray: [],
            formatedArray: [],
            errorArray: [],
            warningArray: [],
            trash: [],
            isPaste: false,
            PastedTime: "",
            example: "4:31:16\n32:00\n1：4：07\n１:０９:０８\n2:01:01 テスト\n2:40:00　テスト全角\n3:00:05　テスト　複数",
            TimeStamp: false,
            pasteComplete: false,
            isFirefox: false,
            player: [],
            testPlayer: false,
            isFull: false,
        }
    },
    components: {
        draggableChild,
        ytCheckModal,
        AccordionPanel,
    },
    created() {
        let blank = []
        blank.time = []
        blank.title = ""
        blank.member_id = this.youtubeInfo.member_id
        blank.cate_id = 1
        blank.switch = true
        this.dataArray.push(blank)
        this.errorArray.push(false)
        this.warningArray.push(false)

        let agent = window.navigator.userAgent.toLowerCase()
        if (agent.indexOf("firefox") != -1) {
            this.isFirefox = true
        }
    },
    methods: {
        log: function (evt) {
            console.log(evt)
        },
        format(date) {
            let formated = dayjs(date).format("YYYY-MM-DD HH:mm:ss")
            return formated
        },
        PasteToTime() {
            let HalfPaste = this.PastedTime.replace(/[０-９：]/g, function (s) {
                return String.fromCharCode(s.charCodeAt(0) - 0xfee0)
            })
            let PastedArrayRaw = HalfPaste.replace("\r", "").split("\n")
            let InputPaste = PastedArrayRaw.filter((v) => v)
            let numTemp = InputPaste.length

            for (let i = 0; i < numTemp; i++) {
                let temp = []
                temp.time = []
                temp.title = ""
                temp.member_id = this.youtubeInfo.member_id
                temp.cate_id = 1
                temp.switch = true

                let pasteArray = InputPaste[i].replace(/　/g, " ")
                let timeArray = null
                if (pasteArray.includes(" ")) {
                    let pasteSplit = pasteArray.split(" ")
                    let pasteSplitClean = pasteSplit.filter((v) => v)

                    timeArray = pasteSplitClean[0].split(":")

                    if (pasteSplitClean.length == 2) {
                        temp.title = pasteSplitClean[1]
                    } else {
                        temp.title = pasteSplitClean[1]
                        for (let k = 2; k < pasteSplitClean.length; k++) {
                            temp.title = temp.title + " " + pasteSplitClean[k]
                        }
                    }
                    this.errorArray[this.dataArray.length - 1] = false
                } else {
                    timeArray = InputPaste[i].split(":")
                    temp.title = ""
                    this.errorArray[this.dataArray.length - 1] = true
                }

                if (timeArray.length == 2) {
                    let TimeM = timeArray[0]
                    let TimeS = timeArray[1]
                    let timeSecond = Number(TimeM) * 60 + Number(TimeS)

                    let min = ("00" + TimeM).slice(-2)
                    let rem = ("00" + TimeS).slice(-2)
                    let HMStime = "00:" + min + ":" + rem

                    temp.time.push({ id: Math.random().toString(36).slice(-8), rawTime: timeSecond, displayTime: HMStime })
                } else {
                    let TimeH = timeArray[0]
                    let TimeM = timeArray[1]
                    let TimeS = timeArray[2]
                    let timeSecond = Number(TimeH) * 3600 + Number(TimeM) * 60 + Number(TimeS)

                    let hour = ("00" + TimeH).slice(-2)
                    let min = ("00" + TimeM).slice(-2)
                    let rem = ("00" + TimeS).slice(-2)
                    let HMStime = hour + ":" + min + ":" + rem

                    temp.time.push({ id: Math.random().toString(36).slice(-8), rawTime: timeSecond, displayTime: HMStime })
                }
                this.dataArray[this.dataArray.length - 1] = temp

                let blank = []
                blank.time = []
                blank.title = ""
                blank.member_id = this.youtubeInfo.member_id
                blank.cate_id = 1
                blank.switch = true
                this.dataArray.push(blank)
                this.errorArray.push(false)
                this.warningArray.push(false)

                this.updateTime()
            }
        },
        addTime(timeArray) {
            let temp = []
            temp.time = []
            temp.time.push(timeArray)
            temp.title = ""
            temp.member_id = this.youtubeInfo.member_id
            temp.cate_id = 1
            temp.switch = true

            this.dataArray[this.dataArray.length - 1] = temp
            this.errorArray[this.dataArray.length - 1] = true

            let blank = []
            blank.time = []
            blank.title = ""
            blank.member_id = this.youtubeInfo.member_id
            blank.cate_id = 1
            blank.switch = true
            this.dataArray.push(blank)
            this.errorArray.push(false)
            this.warningArray.push(false)

            this.updateTime()
        },
        dataDelete(index) {
            this.dataArray.splice(index, 1)
            this.errorArray.splice(index, 1)
            this.warningArray.splice(index, 1)
            this.updateTime()
            console.log(this.dataArray)
            console.log(this.warningArray)
        },
        nextStep() {
            for (let i = 0; i < this.dataArray.length - 1; i++) {
                if (this.dataArray[i].switch == true) {
                    let timeArray = this.dataArray[i].time

                    if (timeArray.length % 2 === 0 || timeArray.length == 1) {
                        let middleTimeArray = []
                        for (let k = 1; k < timeArray.length - 1; k++) {
                            middleTimeArray.push(timeArray[k].rawTime)
                        }
                        let middleTimeString = middleTimeArray.join()

                        let endTime = 0
                        if (timeArray.length > 1) {
                            endTime = timeArray[timeArray.length - 1].rawTime
                        }
                        this.formatedArray.push({
                            title: this.dataArray[i].title,
                            date: this.format(this.youtubeInfo.date),
                            VideoID: this.youtubeInfo.VideoID,
                            start: timeArray[0].rawTime,
                            end: endTime,
                            middle: middleTimeString,
                            status: 0,
                            cate_id: this.dataArray[i].cate_id,
                            member_id: this.dataArray[i].member_id,
                        })
                    }
                }
            }
            this.$emit("nextStep", this.formatedArray)
        },
        PlayAt(e) {
            this.$emit("PlayAt", e)
        },
        editTitle(index) {
            if (this.dataArray[index]["title"] != "") {
                this.errorArray[index] = false
            } else {
                this.errorArray[index] = true
            }
        },
        removed(index, warning) {
            this.warningArray[index] = warning
            this.updateData(index)
        },
        added(index, warning) {
            if (index == this.dataArray.length - 1) {
                this.errorArray[index] = true
                let blank = []
                blank.time = []
                blank.title = ""
                blank.member_id = this.youtubeInfo.member_id
                blank.cate_id = 1
                blank.switch = true
                this.dataArray.push(blank)
                this.errorArray.push(false)
                this.warningArray.push(false)
            } else {
                this.warningArray[index] = warning
            }
        },
        updateTime() {
            this.$nextTick(function () {
                for (let i = 0; i < this.$refs.timedrag.length; i++) {
                    let ref = this.$refs.timedrag[i]
                    ref.updateTime()
                }
            })
        },
        updateData(index) {
            this.$nextTick(function () {
                for (let i = 0; i < this.$refs.timedrag.length; i++) {
                    let ref = this.$refs.timedrag[i]
                    this.dataArray[i].time = ref.timeArray
                }
                let timeLength = this.dataArray[index].time
                if (timeLength.length == 0) {
                    this.dataDelete(index)
                }
            })
        },
        addTimeGroup(index) {
            this.$emit("addTimeGroup", index)
        },
        groupPush(timeArray, index) {
            this.dataArray[index].time.push(timeArray)

            if (this.dataArray[index].title == "") {
                this.errorArray[index] = true
            } else {
                this.errorArray[index] = false
            }

            if (this.dataArray[index].time.length % 2 === 0 || this.dataArray[index].time.length == 1) {
                this.warningArray[index] = false
            } else {
                this.warningArray[index] = true
            }

            if (index == this.dataArray.length - 1) {
                let blank = []
                blank.time = []
                blank.title = ""
                blank.member_id = this.youtubeInfo.member_id
                blank.cate_id = 1
                blank.switch = true
                this.dataArray.push(blank)
                this.errorArray.push(false)
                this.warningArray.push(false)
            }

            this.updateTime()
        },
        pasteClip() {
            if (navigator.clipboard) {
                let self = this
                navigator.clipboard.readText().then(function (text) {
                    self.PastedTime = text
                })
            }
        },
        CopyStamp() {
            this.complete = false
            let self = this
            const copyText = this.$el.querySelector("#target").innerText
            navigator.clipboard
                .writeText(copyText)
                .then(() => {
                    self.pasteComplete = true
                })
                .catch((e) => {
                    alert(e)
                })
        },
        testPlay(index, full) {
            this.isFull = full
            this.player.VideoID = this.youtubeInfo.VideoID
            let timeArray = this.dataArray[index].time
            this.player.start = timeArray[0].rawTime
            if (timeArray.length >= 2) {
                this.player.end = timeArray[timeArray.length - 1].rawTime
            } else {
                this.player.end = 0
            }

            if (timeArray.length > 3) {
                let tempMiddle = []
                for (let k = 1; k < timeArray.length - 1; k++) {
                    tempMiddle.push(timeArray[k].rawTime)
                }
                this.player.middle = tempMiddle
            } else {
                this.player.middle = null
            }

            this.testPlayer = true
            console.log(this.player)
        },
        emits: ["nextStep"],
    },
}
</script>

<style scoped>
.errorBorder {
    border-color: #ef4444 !important;
}
</style>
