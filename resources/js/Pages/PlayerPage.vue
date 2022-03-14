<template>
    <div>
        <Head>
            <meta
                name="description"
                :content="'個人Vtuberグループいせぶい所属' + currentMember.display + '非公式' + currentMember.display + 'DB　プレイヤーページ'"
            />
            <meta property="og:title" :content="'非公式' + currentMember.display + 'DB | PlayerPage'" />
            <meta property="og:type" content="article" />
            <meta property="og:url" :content="'https://isevdb.sakura.ne.jp/' + currentMember.name + '/player/' + id" />
            <meta property="og:image" :content="'https://i.ytimg.com/vi/' + player.VideoID + '/hqdefault.jpg'" />
            <meta property="og:site_name" :content="'非公式' + currentMember.display + 'DB'" />
            <meta
                property="og:description"
                :content="'非公式' + currentMember.display + 'DB No.' + player.id + '「' + player.title + '」プレイヤーページ'"
            />
            <meta property="og:locale" content="ja_JP" />

            <meta name="twitter:card" content="player" />
            <meta name="twitter:title" :content="'非公式' + currentMember.display + 'DB'" />
            <meta
                name="twitter:description"
                :content="'非公式' + currentMember.display + 'DB No.' + player.id + '「' + player.title + '」プレイヤーページ'"
            />
            <meta name="twitter:image" :content="'https://i.ytimg.com/vi/' + player.VideoID + '/hqdefault.jpg'" />
            <meta
                name="twitter:player"
                :content="
                    'https://www.youtube.com/embed/' +
                    player.VideoID +
                    '?rel=0&start=' +
                    player.start +
                    '&end=' +
                    player.end +
                    '&amp;controls=0&amp;showinfo=0'
                "
            />
            <meta name="twitter:player:width" content="640" />
            <meta name="twitter:player:height" content="360" />
        </Head>
        <app-layout
            :title="currentMember.display + '非公式DB'"
            :chooseCate="false"
            NowPage="Player"
            NowCate="NONE"
            :currentMember="currentMember"
            :isSub="true"
            :style="styles"
        >
            <template #header>
                <h2 class="emitTitle">{{ currentMember.ENname }}</h2>
            </template>

            <template #window>
                <div class="flex flex-col w-full">
                    <div class="ml-2 mr-auto max-w-max h-full left-0">
                        <button v-if="likes.includes(id)" class="max-w-max my-auto" @click="DisLike(this.currentIndex)">
                            <svg class="fill-yellow-400 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path d="M384 48V512l-192-112L0 512V48C0 21.5 21.5 0 48 0h288C362.5 0 384 21.5 384 48z" />
                            </svg>
                        </button>
                        <button v-else class="max-w-max my-auto" @click="addLike(id)">
                            <svg class="fill-gray-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path d="M384 48V512l-192-112L0 512V48C0 21.5 21.5 0 48 0h288C362.5 0 384 21.5 384 48z" />
                            </svg>
                        </button>
                    </div>
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
                    <Link
                        as="button"
                        :href="route('player.edit', { id: this.id })"
                        class="border border-gray-300 rounded-full text-xs w-fit mx-auto text-gray-300 px-5 py-1"
                        >メン限・非公開報告／編集・削除申請</Link
                    >
                </div>
            </template>

            <template #player>
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
                    <Link
                        as="button"
                        :href="route('member.latest', { member: currentMember.name })"
                        class="text-gray-300 rounded-full border border-gray-300 my-5 w-fit mx-auto text-sm lg:text-md py-2 px-8 shadow-md shadow-gray-900"
                        >このメンバーの非公式DBへ</Link
                    >
                </div>
            </template>

            <template #default>
                <div class="flex flex-col mx-0 mt-16">
                    <AccordionPanel v-if="list != null" class="mb-4" :default="false">
                        <template v-slot:title>
                            <span class="font-semibold text-xl text-gray-300">リスト</span>
                        </template>
                        <template v-slot:content>
                            <div class="flex flex-row flex-wrap">
                                <div v-for="item in list" :key="'list' + item.id" class="py-1 px-3 sm:px-6 lg:px-1 lg:px-1 h-fit w-full lg:w-1/3">
                                    <div v-if="item.twitter == null">
                                        <y-tcard
                                            :title="item.title"
                                            :date="item.date"
                                            :status="item.status"
                                            :url="
                                                '/' +
                                                item.name +
                                                '/player/' +
                                                item.id +
                                                '/?list=' +
                                                list_type +
                                                '&index=' +
                                                Number(listIndex.indexOf(item.id) - 1)
                                            "
                                            :isLike="likes.includes(item.id)"
                                            @disLikeEmit="DisLike(item.id)"
                                            @addLikeEmit="addLike(item.id)"
                                        ></y-tcard>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </AccordionPanel>
                    <AccordionPanel class="mb-4" :default="true">
                        <template v-slot:title>
                            <span class="font-semibold text-xl text-gray-300">関連動画</span>
                        </template>
                        <template v-slot:content>
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
                                            :isLike="likes.includes(item.id)"
                                            @disLikeEmit="DisLike(item.id)"
                                            @addLikeEmit="addLike(item.id)"
                                        ></y-tcard>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </AccordionPanel>
                </div>
                <LoginModal :isVisible="modalShow" @close="modalShow = false"></LoginModal>
                <TweetMaker :isVisible="TweetMake" :currentMember="currentMember" :player="player" @close="TweetMake = false"></TweetMaker>
            </template>
        </app-layout>
    </div>
</template>

<script>
import { defineComponent } from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import YTcard from "../components/YTcard.vue"
import LoginModal from "../components/LoginModal"
import TweetMaker from "../components/TweetMaker"
import AccordionPanel from "../components/AccordionPanel"
import YouTube from "vue3-youtube"
import { Head, Link } from "@inertiajs/inertia-vue3"

export default defineComponent({
    props: {
        player: Object,
        id: String,
        list: Object,
        related: Object,
        currentMember: Object,
        list_id: Number,
        list_type: String,
    },
    components: {
        AppLayout,
        YTcard,
        LoginModal,
        TweetMaker,
        AccordionPanel,
        YouTube,
        Link,
        Head,
    },
    data() {
        return {
            likes: [],
            listIndex: [],
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

        if (this.$page.props.setting.likesObj == null) {
            this.likes = []
        } else {
            this.likes = this.$page.props.setting.likesObj
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
                this.$inertia.get("/" + this.related[0].name + "/player/" + this.related[0].id)
            } else {
                this.findNext()
                let nextId = this.list[this.nextIndex].id
                this.$inertia.get(
                    "/" +
                        this.list[this.nextIndex].name +
                        "/player/" +
                        nextId +
                        "?list=" +
                        this.list_type +
                        "&index=" +
                        Number(this.listIndex.indexOf(nextId))
                )
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
        addLike(id) {
            if (this.$page.props.user) {
                let self = this
                axios({
                    method: "post",
                    url: "/api/add/" + id + "/like",
                    dataType: "json",
                    data: {
                        player_id: id,
                        user_id: this.$page.props.user.id,
                        created_at: new Date(),
                        updated_at: new Date(),
                    },
                })
                    .then((response) => {
                        console.log(response)
                        self.likes.push(id)
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            } else {
                this.modalShow = true
            }
        },
        DisLike(id) {
            let self = this
            axios({
                method: "post",
                url: "/api/delete/" + id + "/dislike",
                dataType: "json",
                data: {
                    player_id: id,
                    user_id: this.$page.props.user.id,
                },
            })
                .then((response) => {
                    console.log(response)
                    self.likes.splice(self.likes.indexOf(id), 1)
                })
                .catch((error) => {
                    console.log(error)
                })
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
</style>
