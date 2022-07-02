<template>
    <teleport to="body">
        <div v-if="!isFull" class="modal" @click="close"></div>
        <YouTube
            v-if="isFull && readyYT"
            :src="player.VideoID"
            @ready="onReady"
            @state-change="status"
            :vars="playerVars"
            ref="testYoutube"
            width="100%"
            height="100%"
            class="videoWindow-full"
        />
        <div v-else class="text-center bg-stone-800 modal-content mt-5">
            <div class="relative w-full aspect-video flex-none">
                <YouTube
                    v-if="readyYT"
                    :src="player.VideoID"
                    @ready="onReady"
                    @state-change="status"
                    :vars="playerVars"
                    ref="testYoutube"
                    width="100%"
                    height="100%"
                    class="videoWindow static"
                />
            </div>
            <div class="w-fit mx-auto py-2">
                <div class="flex flex-col">
                    <div class="flex flex-row justify-center items-start px-5 mt-1">
                        <div class="flex flex-col">
                            <button @click="SSMinus" class="m-2">
                                <svg class="fill-gray-100 w-4 h-4 lg: w-8 lg:h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M77.25 256l137.4-137.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-160 160c-12.5 12.5-12.5 32.75 0 45.25l160 160C175.6 444.9 183.8 448 192 448s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L77.25 256zM269.3 256l137.4-137.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-160 160c-12.5 12.5-12.5 32.75 0 45.25l160 160C367.6 444.9 375.8 448 384 448s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L269.3 256z"
                                    />
                                </svg>
                            </button>
                            <p class="text-xxs text-gray-100 mx-auto">-10s</p>
                        </div>
                        <div class="flex flex-col">
                            <button @click="SMinus" class="m-2">
                                <svg class="fill-gray-100 w-4 h-4 lg: w-8 lg:h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M192 448c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l137.4 137.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448z"
                                    />
                                </svg>
                            </button>
                            <p class="text-xxs text-gray-100 mx-auto">-1s</p>
                        </div>
                        <button v-if="!playStatus" @click="playVideo" class="m-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="fill-gray-100 w-4 h-4 lg: w-8 lg:h-8">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M361 215C375.3 223.8 384 239.3 384 256C384 272.7 375.3 288.2 361 296.1L73.03 472.1C58.21 482 39.66 482.4 24.52 473.9C9.377 465.4 0 449.4 0 432V80C0 62.64 9.377 46.63 24.52 38.13C39.66 29.64 58.21 29.99 73.03 39.04L361 215z"
                                />
                            </svg>
                        </button>
                        <button v-if="playStatus" @click="pauseVideo" class="m-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="fill-gray-100 w-4 h-4 lg: w-8 lg:h-8">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M272 63.1l-32 0c-26.51 0-48 21.49-48 47.1v288c0 26.51 21.49 48 48 48L272 448c26.51 0 48-21.49 48-48v-288C320 85.49 298.5 63.1 272 63.1zM80 63.1l-32 0c-26.51 0-48 21.49-48 48v288C0 426.5 21.49 448 48 448l32 0c26.51 0 48-21.49 48-48v-288C128 85.49 106.5 63.1 80 63.1z"
                                />
                            </svg>
                        </button>
                        <div class="flex flex-col">
                            <button @click="SPlus" class="m-2">
                                <svg class="fill-gray-100 w-4 h-4 lg: w-8 lg:h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"
                                    />
                                </svg>
                            </button>
                            <p class="text-xxs text-gray-100 mx-auto">+1s</p>
                        </div>
                        <div class="flex flex-col">
                            <button @click="SSPlus" class="m-2">
                                <svg class="fill-gray-100 w-4 h-4 lg: w-8 lg:h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M246.6 233.4l-160-160c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L178.8 256l-137.4 137.4c-12.5 12.5-12.5 32.75 0 45.25C47.63 444.9 55.81 448 64 448s16.38-3.125 22.62-9.375l160-160C259.1 266.1 259.1 245.9 246.6 233.4zM438.6 233.4l-160-160c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L370.8 256l-137.4 137.4c-12.5 12.5-12.5 32.75 0 45.25C239.6 444.9 247.8 448 256 448s16.38-3.125 22.62-9.375l160-160C451.1 266.1 451.1 245.9 438.6 233.4z"
                                    />
                                </svg>
                            </button>
                            <p class="text-xxs text-gray-100 mx-auto">+10s</p>
                        </div>
                    </div>
                    <div class="max-w-fit mx-auto flex flex-row px-5 mt-1">
                        <div class="flex flex-col" :class="middleStep != 0 ? 'visible' : 'invisible'">
                            <button @click="PrevTime" class="my-2 mx-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="fill-gray-100 w-4 h-4 lg: w-8 lg:h-8">
                                    <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M77.25 256l137.4-137.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-160 160c-12.5 12.5-12.5 32.75 0 45.25l160 160C175.6 444.9 183.8 448 192 448s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L77.25 256zM269.3 256l137.4-137.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-160 160c-12.5 12.5-12.5 32.75 0 45.25l160 160C367.6 444.9 375.8 448 384 448s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L269.3 256z"
                                    />
                                </svg>
                            </button>
                            <p class="text-xxs text-gray-100 mx-auto">PrevTime</p>
                        </div>
                        <div class="flex flex-col">
                            <button @click="redoPlayer" class="my-2 mx-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="fill-gray-100 w-4 h-4 lg: w-8 lg:h-8">
                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M480 256c0 123.4-100.5 223.9-223.9 223.9c-48.86 0-95.19-15.58-134.2-44.86c-14.14-10.59-17-30.66-6.391-44.81c10.61-14.09 30.69-16.97 44.8-6.375c27.84 20.91 61 31.94 95.89 31.94C344.3 415.8 416 344.1 416 256s-71.67-159.8-159.8-159.8C205.9 96.22 158.6 120.3 128.6 160H192c17.67 0 32 14.31 32 32S209.7 224 192 224H48c-17.67 0-32-14.31-32-32V48c0-17.69 14.33-32 32-32s32 14.31 32 32v70.23C122.1 64.58 186.1 32.11 256.1 32.11C379.5 32.11 480 132.6 480 256z"
                                    />
                                </svg>
                            </button>
                            <p class="text-xxs text-gray-100 mx-auto">Replay</p>
                        </div>
                        <div class="flex flex-col" :class="middleStep != middleArray.length / 2 ? 'visible' : 'invisible'">
                            <button @click="NextTime()" class="my-2 mx-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="fill-gray-100 w-4 h-4 lg: w-8 lg:h-8">
                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M246.6 233.4l-160-160c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L178.8 256l-137.4 137.4c-12.5 12.5-12.5 32.75 0 45.25C47.63 444.9 55.81 448 64 448s16.38-3.125 22.62-9.375l160-160C259.1 266.1 259.1 245.9 246.6 233.4zM438.6 233.4l-160-160c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L370.8 256l-137.4 137.4c-12.5 12.5-12.5 32.75 0 45.25C239.6 444.9 247.8 448 256 448s16.38-3.125 22.62-9.375l160-160C451.1 266.1 451.1 245.9 438.6 233.4z"
                                    />
                                </svg>
                            </button>
                            <p class="text-xxs text-gray-100 mx-auto">NextTime</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </teleport>
</template>

<script>
import { defineComponent } from "vue"
import YouTube from "vue3-youtube"

export default defineComponent({
    props: ["isVisible", "player", "isFull"],
    data() {
        return {
            playerVars: {
                autoplay: 0,
                controls: 1,
                start: this.player.start,
                iv_load_policy: 3,
            },
            playStatus: false,
            timer: null,
            NowTime: 0,
            middleArray: [],
            middleStep: 0,
            isMiddle: false,
            readyYT: false,
        }
    },
    created() {
        if (this.player.middle != null) {
            this.isMiddle = true
            this.middleArray = this.player.middle
        }
        this.readyYT = true
        console.log(this.player)
    },
    methods: {
        onReady() {
            this.$refs.testYoutube.playVideo()
        },
        playVideo() {
            this.YTplayer.playVideo()
            this.playStatus = true
        },
        pauseVideo() {
            this.YTplayer.pauseVideo()
            this.playStatus = false
        },
        SSPlus() {
            let time = this.YTplayer.getCurrentTime()
            this.YTplayer.seekTo(time + 10, true)
        },
        SSMinus() {
            let time = this.YTplayer.getCurrentTime()
            this.YTplayer.seekTo(time - 10, true)
        },
        SPlus() {
            let time = this.YTplayer.getCurrentTime()
            this.YTplayer.seekTo(time + 1, true)
        },
        SMinus() {
            let time = this.YTplayer.getCurrentTime()
            this.YTplayer.seekTo(time - 1, true)
        },
        status() {
            let NowStatus = this.YTplayer.getPlayerState()
            if (NowStatus == 1) {
                clearTimeout(this.timer)
                this.playStatus = true
                this.getTime()
            }
            if (NowStatus == 2) {
                this.playStatus = false
                clearTimeout(this.timer)
            }
            if (NowStatus == 0) {
                clearTimeout(this.timer)
                this.playStatus = false
                this.overlay = true
                this.endPlay()
            }
        },
        PlayAt(input) {
            this.YTplayer.seekTo(input, true)
        },
        getTime() {
            if (this.player.end != 0) {
                this.timer = setTimeout(this.getTime, 1000)
                if (Number(this.NowTime) > Number(this.player.end)) {
                    clearTimeout(this.timer)
                    this.overlay = true
                    this.endPlay()
                } else {
                    this.NowTime = this.YTplayer.getCurrentTime()
                    if (this.isMiddle) {
                        if (Number(this.NowTime) > Number(this.middleArray[this.middleStep * 2])) {
                            this.PlayAt(this.middleArray[this.middleStep * 2 + 1])
                            this.middleStep += 1
                            if (this.middleStep >= this.middleArray.length / 2) {
                                this.isMiddle = false
                            }
                        }
                    }
                }
            }
        },
        redoPlayer() {
            clearTimeout(this.timer)
            this.timer = null
            this.YTplayer.seekTo(this.player.start, true)
            this.NowTime = this.player.start
        },
        PrevTime() {
            this.PlayAt(this.middleArray[(this.middleStep - 1) * 2])
            this.middleStep -= 1
        },
        NextTime() {
            this.PlayAt(this.middleArray[this.middleStep * 2 + 1])
            this.middleStep += 1
        },
        endPlay() {
            this.YTplayer.pauseVideo()
            this.$emit("close")
        },
        close() {
            this.$emit("close")
        },
    },
    emits: ["close"],
    components: {
        YouTube,
    },
    computed: {
        YTplayer() {
            return this.$refs.testYoutube
        },
    },
    unmounted: function () {
        clearTimeout(this.timer)
    },
})
</script>

<style scoped>
.modal {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 50;
}

.modal-content {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    width: 80vw;
    max-width: 1024px;
    height: auto;
    border-radius: 20px;
    padding: 20px;
    z-index: 100;
}
.videoWindow {
    width: 100% !important;
    height: 100% !important;
    margin: 0;
}
.videoWindow-full {
    height: 0;
    overflow: hidden;
    max-width: 100%;
    padding-bottom: 56.25%;
    position: relative;
}
.videoWindow-full iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100% !important;
    height: 100% !important;
    margin: 0;
    padding: 0;
    z-index: 100;
}
</style>
