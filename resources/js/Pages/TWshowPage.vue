<template>
    <div>
        <Head>
            <meta
                name="description"
                :content="'個人Vtuberグループいせぶい所属' + currentMember.display + '非公式' + currentMember.display + 'DB　データ一覧ページ'"
            />
            <meta property="og:title" :content="'非公式' + currentMember.display + 'DB'" />
            <meta property="og:type" content="article" />
            <meta property="og:url" :content="'https://isevdb.net/' + currentMember.name" />
            <meta property="og:site_name" :content="'非公式' + currentMember.display + 'DB'" />
            <meta property="og:description" :content="'非公式' + currentMember.display + 'DB　データ一覧ページ'" />
            <meta property="og:locale" content="ja_JP" />
        </Head>
        <app-layout
            :title="currentMember.display + '非公式DB'"
            :chooseCate="false"
            NowPage="Player"
            NowCate="NONE"
            :currentMember="currentMember"
            :isSub="true"
            :style="styles"
            :shareUrl="'https://isevdb.net/' + this.currentMember.name + '/latest'"
        >
            <template #header>
                <h2 class="emitTitle">{{ currentMember.ENname }}</h2>
            </template>

            <template #player>
                <Link
                    as="button"
                    :href="route('member.latest', { member: currentMember.name })"
                    class="text-gray-300 rounded-full border border-gray-300 my-5 w-fit mx-auto text-sm lg:text-md py-2 px-8 shadow-md shadow-gray-900"
                    >このメンバーの非公式DBへ</Link
                >
            </template>

            <template #window>
                <div v-if="tweetWindow" class="pb-2 mx-0 min-w-full flex flex-col">
                    <div class="flex flex-row">
                        <div class="ml-2 mr-auto max-w-max">
                            <button v-if="likes.includes(currentIndex)" class="max-w-max" @click="DisLike(this.currentIndex)">
                                <svg class="fill-yellow-400 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path d="M384 48V512l-192-112L0 512V48C0 21.5 21.5 0 48 0h288C362.5 0 384 21.5 384 48z" />
                                </svg>
                            </button>
                            <button v-else class="max-w-max" @click="addLike(this.currentIndex)">
                                <svg class="fill-gray-500 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path d="M384 48V512l-192-112L0 512V48C0 21.5 21.5 0 48 0h288C362.5 0 384 21.5 384 48z" />
                                </svg>
                            </button>
                        </div>
                        <button class="ml-auto mr-2 max-w-max" @click="tweetWindow = false">
                            <svg class="fill-red-600 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM175 208.1L222.1 255.1L175 303C165.7 312.4 165.7 327.6 175 336.1C184.4 346.3 199.6 346.3 208.1 336.1L255.1 289.9L303 336.1C312.4 346.3 327.6 346.3 336.1 336.1C346.3 327.6 346.3 312.4 336.1 303L289.9 255.1L336.1 208.1C346.3 199.6 346.3 184.4 336.1 175C327.6 165.7 312.4 165.7 303 175L255.1 222.1L208.1 175C199.6 165.7 184.4 165.7 175 175C165.7 184.4 165.7 199.6 175 208.1V208.1z"
                                />
                            </svg>
                        </button>
                    </div>
                    <IMGwindow v-if="this.TWtype == 'photo'" :url="tweetUrl" :tweet="twitterUrl" class="min-w-full py-2"></IMGwindow>
                    <TWwindow v-if="this.TWtype == 'video'" :url="tweetUrl" class="min-w-full"></TWwindow>
                    <Link
                        as="button"
                        :href="route('player.edit', { id: this.currentIndex })"
                        class="border border-gray-300 rounded-full text-xs w-fit mx-auto text-gray-300 px-5 py-1"
                        >編集・削除申請</Link
                    >
                </div>
            </template>

            <template #default>
                <div class="flex flex-col mx-0 mt-16">
                    <AccordionPanel class="mb-4" :default="true">
                        <template v-slot:title>
                            <span class="font-semibold text-xl text-gray-300">関連</span>
                        </template>
                        <template v-slot:content>
                            <div class="flex flex-row flex-wrap">
                                <div
                                    v-for="item in related"
                                    :key="'related' + item.id"
                                    class="py-1 px-3 sm:px-6 lg:px-1 lg:px-1 h-fit w-full lg:w-1/3"
                                >
                                    <t-wcard
                                        :isLike="likes.includes(item.id)"
                                        :title="item.title"
                                        :date="item.date"
                                        :tweetType="item.tweetType"
                                        :photoMode="false"
                                        :photoUrl="item.tweetUrl"
                                        :memberName="null"
                                        @tweetShow="tweetShow(item.tweetUrl, item.tweetType, item.id, item.twitter)"
                                        @disLikeEmit="DisLike(item.id)"
                                        @addLikeEmit="addLike(item.id)"
                                    ></t-wcard>
                                </div>
                            </div>
                        </template>
                    </AccordionPanel>
                </div>
                <LoginModal :isVisible="modalShow" @close="modalShow = false"></LoginModal>
            </template>
        </app-layout>
    </div>
</template>

<script>
import { defineComponent } from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import YTcard from "../components/YTcard.vue"
import LoginModal from "../components/LoginModal"
import AccordionPanel from "../components/AccordionPanel"
import { Head, Link } from "@inertiajs/inertia-vue3"
import TWcard from "../components/TWcard.vue"
import TWwindow from "../components/TWwindow.vue"
import IMGwindow from "../components/IMGwindow.vue"

export default defineComponent({
    props: {
        player: Object,
        id: String,
        related: Object,
        currentMember: Object,
    },
    components: {
        AppLayout,
        YTcard,
        LoginModal,
        AccordionPanel,
        Link,
        Head,
        TWcard,
        TWwindow,
        IMGwindow,
    },
    data() {
        return {
            likes: [],
            modalShow: false,
            tweetWindow: false,
            tweetUrl: "",
            TWtype: "",
            twitterUrl: "",
            currentIndex: 0,
        }
    },
    created() {
        if (this.$page.props.setting.likesObj == null) {
            this.likes = []
        } else {
            this.likes = this.$page.props.setting.likesObj
        }
        this.tweetShow(this.player.tweetUrl, this.player.tweetType, this.id, this.player.twitter)
    },
    methods: {
        tweetShow(url, type, id, twitter) {
            this.tweetWindow = false
            this.tweetUrl = url
            this.TWtype = type
            this.twitterUrl = twitter
            this.$nextTick(function () {
                this.tweetWindow = true
                this.currentIndex = id
            })
            this.$nextTick(function () {
                document.getElementById("playerTop").scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                })
            })
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
