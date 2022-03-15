<template>
    <div id="app">
        <div class="min-h-max bg-zinc-800" :style="styles">
            <!-- header -->
            <div class="bg-stone-800">
                <header>
                    <div class="flex justify-evenly max-w-5xl mx-auto bg-stone-800 pt-4 pb-2" id="siteTitle">
                        <h2 class="goldTitle font-Caveat text-xl sm:text-4xl my-auto">UNOFFICIAL</h2>
                        <div class="notGold font-Caveat text-2xl sm:text-5xl my-auto">
                            <h2 class="emitTitle">{{ currentMember.ENname }}</h2>
                        </div>
                        <h2 class="goldTitle font-Caveat text-xl sm:text-4xl my-auto">DATABASE</h2>
                    </div>
                </header>
            </div>
            <!-- header end -->

            <!-- Page Content -->
            <main>
                <div class="bg-zinc-800">
                    <div class="w-full m-0 h-px goldLine"></div>
                    <div class="py-1 lg:py-5 px-1 customSticky window max-w-full md:max-w-2xl lg:max-w-3xl mx-auto bg-zinc-800">
                        <div class="flex flex-col w-full">
                            <p class="text-xl lg:text-3xl text-gray-200 py-1 mx-auto">"{{ player.title }}"</p>
                            <div class="relative w-full aspect-video mb-10 flex-none">
                                <YouTube
                                    :src="player.VideoID"
                                    @ready="onReady"
                                    @state-change="status"
                                    :vars="playerVars"
                                    ref="youtube"
                                    width="100%"
                                    height="100%"
                                    class="videoWindow static"
                                />
                                <div v-if="overlay" class="overlay absolute w-full aspect-video bottom-0 rounded-xl flex items-center">
                                    <div class="mx-auto my-auto text-center flex flex-col justify-center">
                                        <p class="text-sm text-white">次の動画まで</p>
                                        <p class="text-4xl text-white">{{ countDisplay }}</p>
                                        <div class="max-w-fit flex flex-row">
                                            <div class="flex flex-col mx-1">
                                                <button @click="redoPlayer" class="m-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="fill-gray-100 w-8 h-8">
                                                        <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                        <path
                                                            d="M480 256c0 123.4-100.5 223.9-223.9 223.9c-48.86 0-95.19-15.58-134.2-44.86c-14.14-10.59-17-30.66-6.391-44.81c10.61-14.09 30.69-16.97 44.8-6.375c27.84 20.91 61 31.94 95.89 31.94C344.3 415.8 416 344.1 416 256s-71.67-159.8-159.8-159.8C205.9 96.22 158.6 120.3 128.6 160H192c17.67 0 32 14.31 32 32S209.7 224 192 224H48c-17.67 0-32-14.31-32-32V48c0-17.69 14.33-32 32-32s32 14.31 32 32v70.23C122.1 64.58 186.1 32.11 256.1 32.11C379.5 32.11 480 132.6 480 256z"
                                                        />
                                                    </svg>
                                                </button>
                                                <p class="text-xxs text-gray-100 mx-auto">Replay</p>
                                            </div>
                                            <div class="flex flex-col mx-1">
                                                <button @click="continuePlayer" class="m-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="fill-red-500 w-8 h-8">
                                                        <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                        <path
                                                            d="M361 215C375.3 223.8 384 239.3 384 256C384 272.7 375.3 288.2 361 296.1L73.03 472.1C58.21 482 39.66 482.4 24.52 473.9C9.377 465.4 0 449.4 0 432V80C0 62.64 9.377 46.63 24.52 38.13C39.66 29.64 58.21 29.99 73.03 39.04L361 215z"
                                                        />
                                                    </svg>
                                                </button>
                                                <p class="text-xxs text-red-500 mx-auto">Continue</p>
                                            </div>
                                            <div class="flex flex-col mx-1">
                                                <button @click="nextPlayer" class="m-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="fill-gray-100 w-8 h-8">
                                                        <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                        <path
                                                            d="M246.6 233.4l-160-160c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L178.8 256l-137.4 137.4c-12.5 12.5-12.5 32.75 0 45.25C47.63 444.9 55.81 448 64 448s16.38-3.125 22.62-9.375l160-160C259.1 266.1 259.1 245.9 246.6 233.4zM438.6 233.4l-160-160c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L370.8 256l-137.4 137.4c-12.5 12.5-12.5 32.75 0 45.25C239.6 444.9 247.8 448 256 448s16.38-3.125 22.62-9.375l160-160C451.1 266.1 451.1 245.9 438.6 233.4z"
                                                        />
                                                    </svg>
                                                </button>
                                                <p class="text-xxs text-gray-100 mx-auto">Next</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="customSticky stickContent flex flex-col">
                        <div class="h-0.5 w-full m-0 goldLine"></div>
                        <div class="bg-stone-800">
                            <!-- player -->
                            <div class="mx-auto w-full bg-stone-800">
                                <div class="w-fit mx-auto">
                                    <div class="flex flex-col">
                                        <div class="max-w-fit mx-auto flex flex-row px-5 mt-1">
                                            <div class="flex flex-col">
                                                <button @click="redoPlayer" class="m-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="fill-gray-100 w-8 h-8">
                                                        <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                        <path
                                                            d="M480 256c0 123.4-100.5 223.9-223.9 223.9c-48.86 0-95.19-15.58-134.2-44.86c-14.14-10.59-17-30.66-6.391-44.81c10.61-14.09 30.69-16.97 44.8-6.375c27.84 20.91 61 31.94 95.89 31.94C344.3 415.8 416 344.1 416 256s-71.67-159.8-159.8-159.8C205.9 96.22 158.6 120.3 128.6 160H192c17.67 0 32 14.31 32 32S209.7 224 192 224H48c-17.67 0-32-14.31-32-32V48c0-17.69 14.33-32 32-32s32 14.31 32 32v70.23C122.1 64.58 186.1 32.11 256.1 32.11C379.5 32.11 480 132.6 480 256z"
                                                        />
                                                    </svg>
                                                </button>
                                                <p class="text-xxs text-gray-100 mx-auto">Replay</p>
                                            </div>
                                            <div v-if="!overlay">
                                                <button v-if="!playStatus" @click="playVideo" class="m-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="fill-gray-100 w-8 h-8">
                                                        <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                        <path
                                                            d="M361 215C375.3 223.8 384 239.3 384 256C384 272.7 375.3 288.2 361 296.1L73.03 472.1C58.21 482 39.66 482.4 24.52 473.9C9.377 465.4 0 449.4 0 432V80C0 62.64 9.377 46.63 24.52 38.13C39.66 29.64 58.21 29.99 73.03 39.04L361 215z"
                                                        />
                                                    </svg>
                                                </button>
                                                <button v-if="playStatus" @click="pauseVideo" class="m-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="fill-gray-100 w-8 h-8">
                                                        <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                        <path
                                                            d="M272 63.1l-32 0c-26.51 0-48 21.49-48 47.1v288c0 26.51 21.49 48 48 48L272 448c26.51 0 48-21.49 48-48v-288C320 85.49 298.5 63.1 272 63.1zM80 63.1l-32 0c-26.51 0-48 21.49-48 48v288C0 426.5 21.49 448 48 448l32 0c26.51 0 48-21.49 48-48v-288C128 85.49 106.5 63.1 80 63.1z"
                                                        />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div v-if="overlay" class="flex flex-col">
                                                <button @click="continuePlayer" class="m-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="fill-red-500 w-8 h-8">
                                                        <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                        <path
                                                            d="M361 215C375.3 223.8 384 239.3 384 256C384 272.7 375.3 288.2 361 296.1L73.03 472.1C58.21 482 39.66 482.4 24.52 473.9C9.377 465.4 0 449.4 0 432V80C0 62.64 9.377 46.63 24.52 38.13C39.66 29.64 58.21 29.99 73.03 39.04L361 215z"
                                                        />
                                                    </svg>
                                                </button>
                                                <p class="text-xxs text-red-500 mx-auto">Continue</p>
                                            </div>
                                            <div class="flex flex-col">
                                                <button @click="nextPlayer" class="m-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="fill-gray-100 w-8 h-8">
                                                        <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                        <path
                                                            d="M246.6 233.4l-160-160c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L178.8 256l-137.4 137.4c-12.5 12.5-12.5 32.75 0 45.25C47.63 444.9 55.81 448 64 448s16.38-3.125 22.62-9.375l160-160C259.1 266.1 259.1 245.9 246.6 233.4zM438.6 233.4l-160-160c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L370.8 256l-137.4 137.4c-12.5 12.5-12.5 32.75 0 45.25C239.6 444.9 247.8 448 256 448s16.38-3.125 22.62-9.375l160-160C451.1 266.1 451.1 245.9 438.6 233.4z"
                                                        />
                                                    </svg>
                                                </button>
                                                <p class="text-xxs text-gray-100 mx-auto">Next</p>
                                            </div>
                                        </div>
                                        <button
                                            class="text-xl lg:text-2xl bg-[#1DA1F2] mx-auto w-fit px-5 py-1 mt-6 text-gray-200 rounded-full shadow-md shadow-gray-900"
                                            @click="TweetMake = true"
                                        >
                                            Tweet
                                        </button>
                                        <p class="text-gray-300 text-sm mt-5 mb-1">このページはシェア専用ページです。</p>
                                        <a
                                            :href="'/' + currentMember.name + '/player/' + id"
                                            class="text-gray-300 rounded-full border border-gray-300 w-fit mx-auto text-sm lg:text-md py-2 px-8 shadow-md shadow-gray-900"
                                            >プレイヤーページへ
                                        </a>
                                        <a
                                            :href="'/' + currentMember.name + '/latest'"
                                            class="text-gray-300 rounded-full border border-gray-300 my-5 w-fit mx-auto text-sm lg:text-md py-2 px-8 shadow-md shadow-gray-900"
                                            >このメンバーの非公式DBへ
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- player end -->

                            <div
                                id="MainContent"
                                class="px-0 sm:px-6 lg:px-8 pt-4 pb-20 lg:pb-10 lg:pt-6 mx-auto mt-0 min-w-full bg-stone-800 flex flex-col lg:flex-row"
                            >
                                <div class="flex-grow mx-0 mt-16">
                                    <div class="flex flex-row flex-wrap">
                                        <div
                                            v-for="item in related"
                                            :key="'related' + item.id"
                                            class="py-1 px-3 sm:px-6 lg:px-1 lg:px-1 h-fit w-full lg:w-1/3"
                                        >
                                            <div v-if="item.twitter == null">
                                                <y-tcard
                                                    :title="item.title"
                                                    :date="item.date"
                                                    :status="item.status"
                                                    :url="'/' + item.name + '/player/' + item.id"
                                                ></y-tcard>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
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
        <TweetMaker :isVisible="TweetMake" :currentMember="currentMember" :player="player" @close="TweetMake = false"></TweetMaker>
    </div>
</template>

<script>
import { defineComponent } from "vue"
import YTcard from "../components/YTshareCard.vue"
import TweetMaker from "../components/TweetMaker"
import YouTube from "vue3-youtube"

export default defineComponent({
    props: ["id", "player", "related", "currentMember"],
    components: {
        YTcard,
        TweetMaker,
        YouTube,
    },
    data() {
        return {
            modalShow: false,
            TweetMake: false,
            playerVars: {
                autoplay: 0,
                controls: 1,
                start: this.player.start,
                iv_load_policy: 3,
            },
            playStatus: false,
            timer: null,
            count: null,
            NowTime: 0,
            countDisplay: 10,
            overlay: false,
            nextIndex: 0,
            listLength: 0,
            autoNext: true,
        }
    },
    created() {
        if (this.list != null) {
            this.listLength = Object.keys(this.list).length
            this.listIndex = this.list.map((item) => item.id)
        }
    },
    methods: {
        onReady() {
            this.$refs.youtube.playVideo()
        },
        playVideo() {
            this.YTplayer.playVideo()
            this.playStatus = true
        },
        pauseVideo() {
            this.YTplayer.pauseVideo()
            this.playStatus = false
        },
        status() {
            let NowStatus = this.YTplayer.getPlayerState()
            if (NowStatus == 1) {
                clearTimeout(this.timer)
                clearTimeout(this.count)
                this.playStatus = true
                if (this.autoNext) {
                    this.getTime()
                }
            }
            if (NowStatus == 2) {
                this.playStatus = false
                clearTimeout(this.timer)
            }
            if (NowStatus == 0) {
                this.playStatus = false
                this.countDown()
            }
        },
        nextPlayer() {
            if (this.list_type == null) {
                location.href = "/" + this.related[0].name + "/player/" + this.related[0].id
            } else {
                this.findNext()
                let nextId = this.list[this.nextIndex].id
                location.href =
                    "/" +
                    this.list[this.nextIndex].name +
                    "/player/" +
                    nextId +
                    "?list=" +
                    this.list_type +
                    "&index=" +
                    Number(this.listIndex.indexOf(nextId))
            }
        },
        findNext() {
            while (this.list[this.nextIndex].status == 2 || this.list[this.nextIndex].status == 3) {
                this.nextIndex++
                if (Number(this.nextIndex) > Number(this.listLength)) {
                    this.nextIndex = Number(this.nextIndex) - Number(this.listLength)
                }
            }
        },
        countDown() {
            this.count = setTimeout(this.countDown, 1000)
            this.countDisplay--
            console.log(this.countDisplay)
            if (this.countDisplay == 0) {
                clearTimeout(this.count)
                this.nextPlayer()
            }
        },
        getTime() {
            if (this.player.end != 0) {
                this.timer = setTimeout(this.getTime, 1000)
                if (Number(this.NowTime) > Number(this.player.end)) {
                    clearTimeout(this.timer)
                    this.overlay = true
                    this.countDown()
                } else {
                    this.NowTime = this.YTplayer.getCurrentTime()
                }
            }
        },
        continuePlayer() {
            this.overlay = false
            this.autoNext = false
            clearTimeout(this.count)
            clearTimeout(this.timer)
        },
        redoPlayer() {
            clearTimeout(this.count)
            this.count = null
            clearTimeout(this.timer)
            this.timer = null
            this.overlay = false
            this.countDisplay = 10
            this.YTplayer.seekTo(this.player.start, true)
            this.NowTime = this.player.start
        },
    },
    computed: {
        styles() {
            return {
                "--BtnCol": this.currentMember.BtnCol,
                "--MainCol": this.currentMember.MainCol,
                "--NavCol": this.currentMember.NavCol,
                "--ImgCol": this.currentMember.ImageCol,
            }
        },
        YTplayer() {
            return this.$refs.youtube
        },
    },
    unmounted: function () {
        clearTimeout(this.timer)
        clearTimeout(this.count)
    },
})
</script>
<style scoped>
.emitTitle {
    color: var(--ImgCol);
    text-shadow: 0px 0px 20px var(--ImgCol);
}
.videoWindow {
    width: 100% !important;
    height: 100% !important;
    margin: 0;
}
.overlay {
    z-index: 200;
    background: rgba(0, 0, 0, 0.8);
}
.isActive {
    background-color: #059669;
}
.goldTitle {
    background: linear-gradient(175deg, #f2da97 0%, #cd923d 50%, #a66a2a 70%, #662f09 100%); /* W3C */
    background: -moz-linear-gradient(-85deg, #f2da97 0%, #cd923d 50%, #a66a2a 70%, #662f09 100%); /* W3C */
    background: -webkit-linear-gradient(-85deg, #f2da97 0%, #cd923d 50%, #a66a2a 70%, #662f09 100%); /* W3C */

    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 700;
}
.notGOld {
    background: none;
}
.customSticky {
    display: flex;
    position: sticky;
    justify-content: center;
    position: -webkit-sticky;
    top: 0;
}
.window {
    z-index: 1;
}
.stickContent {
    z-index: 2;
}
.goldLine {
    background: linear-gradient(45deg, #662f09 0%, #e49d2e 45%, #f2da97 70%, #e7c177 85%, #94591e 90% 100%);
    background: -moz-linear-gradient(45deg, #662f09 0%, #e49d2e 45%, #f2da97 70%, #e7c177 85%, #94591e 90% 100%);
    background: -webkit-linear-gradient(45deg, #662f09 0%, #e49d2e 45%, #f2da97 70%, #e7c177 85%, #94591e 90% 100%);
}
span {
    display: inline-block;
}
</style>
