<template>
    <div class="my-1 w-full">
        <div
            class="px-2 border-dotted border-2 rounded-md w-full"
            :class="timeArray.length != 1 && timeArray.length % 2 !== 0 ? 'border-yellow-200' : 'border-gray-50'"
        >
            <div :class="timeArray.length == 0 ? 'py-4' : 'py-1'">
                <draggable v-model="timeArray" group="time" item-key="id" @remove="remove" @add="add" @sort="sorted" handle=".handle">
                    <template #item="{ element, index }">
                        <div class="mr-auto my-1 w-fit mr-1">
                            <div class="flex flex-row justify-center w-fit items-center">
                                <button class="mx-2 bg-transparent handle cursor-pointer" :class="index % 2 == 0 ? 'mr-1' : 'mr-6'">
                                    <svg class="fill-gray-50 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M512 255.1c0 8.188-3.125 16.41-9.375 22.66l-72 72C424.4 356.9 416.2 360 408 360c-18.28 0-32-14.95-32-32c0-8.188 3.125-16.38 9.375-22.62L402.8 288H288v114.8l17.38-17.38C311.6 379.1 319.8 376 328 376c18.28 0 32 14.95 32 32c0 8.188-3.125 16.38-9.375 22.62l-72 72C272.4 508.9 264.2 512 256 512s-16.38-3.125-22.62-9.375l-72-72C155.1 424.4 152 416.2 152 408c0-17.05 13.73-32 32-32c8.188 0 16.38 3.125 22.62 9.375L224 402.8V288H109.3l17.38 17.38C132.9 311.6 136 319.8 136 328c0 17.05-13.73 32-32 32c-8.188 0-16.38-3.125-22.62-9.375l-72-72C3.125 272.4 0 264.2 0 255.1s3.125-16.34 9.375-22.59l72-72C87.63 155.1 95.81 152 104 152c18.28 0 32 14.95 32 32c0 8.188-3.125 16.38-9.375 22.62L109.3 224H224V109.3L206.6 126.6C200.4 132.9 192.2 136 184 136c-18.28 0-32-14.95-32-32c0-8.188 3.125-16.38 9.375-22.62l72-72C239.6 3.125 247.8 0 256 0s16.38 3.125 22.62 9.375l72 72C356.9 87.63 360 95.81 360 104c0 17.05-13.73 32-32 32c-8.188 0-16.38-3.125-22.62-9.375L288 109.3V224h114.8l-17.38-17.38C379.1 200.4 376 192.2 376 184c0-17.05 13.73-32 32-32c8.188 0 16.38 3.125 22.62 9.375l72 72C508.9 239.6 512 247.8 512 255.1z"
                                        />
                                    </svg>
                                </button>
                                <div class="flex-grow max-w-sm">
                                    <label for="YTtime" class="form-label text-gray-700 sr-only">Time input</label>
                                    <input
                                        @change="changeTime(index)"
                                        v-model="element.displayTime"
                                        type="time"
                                        step="1"
                                        class="form-control block w-full px-1 py-0.5 text-xs text-gray-700 bg-white border border-solid border-gray-300 rounded m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        id="YTtime"
                                        placeholder="Time"
                                    />
                                </div>
                                <button
                                    @click="$emit('PlayAt', element.displayTime)"
                                    class="bg-transparent"
                                    :class="index % 2 == 0 ? 'ml-7' : 'ml-2'"
                                >
                                    <svg class="fill-red-400 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM176 168V344C176 352.7 180.7 360.7 188.3 364.9C195.8 369.2 205.1 369 212.5 364.5L356.5 276.5C363.6 272.1 368 264.4 368 256C368 247.6 363.6 239.9 356.5 235.5L212.5 147.5C205.1 142.1 195.8 142.8 188.3 147.1C180.7 151.3 176 159.3 176 168V168z"
                                        />
                                    </svg>
                                </button>
                                <button @click="timeDelete(index)" class="bg-transparent ml-6">
                                    <svg class="fill-red-400 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                        <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </draggable>
            </div>
        </div>
        <div v-if="timeArray.length == 0">
            <p class="text-gray-50 text-md text-center mx-auto py-1">&#9650; 新規グループ追加エリア</p>
        </div>
        <div v-if="timeArray.length != 0" class="w-fit mr-2 ml-auto my-2">
            <button @click="$emit('addTimeGroup')" class="rounded-md px-2 py-1 text-gray-900 bg-gray-300 w-fit text-xxs">現在時刻を追加</button>
        </div>
    </div>
</template>

<script>
import draggable from "vuedraggable"
import dayjs from "dayjs"
dayjs.locale("ja")

export default {
    props: ["data"],
    components: {
        draggable,
    },
    data() {
        return {
            timeArray: [],
        }
    },
    created() {
        this.updateTime()
    },
    methods: {
        updateTime() {
            this.timeArray = this.data.time
        },
        remove() {
            let warning = this.timeArray.length != 1 && this.timeArray.length % 2 !== 0
            this.$emit("removed", warning)
        },
        add() {
            let warning = this.timeArray.length != 1 && this.timeArray.length % 2 !== 0
            this.timeArray.sort((a, b) => a.rawTime - b.rawTime)
            this.$emit("added", warning)
        },
        sorted() {
            this.timeArray.sort((a, b) => a.rawTime - b.rawTime)
        },
        changeTime(index) {
            let changedTime = this.timeArray[index].displayTime
            let timeArray = changedTime.split(":")
            if (timeArray.length == 2) {
                let TimeM = timeArray[0]
                let TimeS = timeArray[1]
                let timeSecond = Number(TimeM) * 60 + Number(TimeS)
                this.timeArray[index].rawTime = timeSecond
            } else {
                let TimeH = timeArray[0]
                let TimeM = timeArray[1]
                let TimeS = timeArray[2]
                let timeSecond = Number(TimeH) * 3600 + Number(TimeM) * 60 + Number(TimeS)
                this.timeArray[index].rawTime = timeSecond
            }

            this.timeArray.sort((a, b) => a.rawTime - b.rawTime)
            this.$emit("updateData")
        },
        timeDelete(index) {
            this.timeArray.splice(index, 1)
            let warning = this.timeArray.length != 1 && this.timeArray.length % 2 !== 0
            this.$emit("removed", warning)
        },
    },
}
</script>
