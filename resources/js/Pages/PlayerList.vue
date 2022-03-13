<template>
    <div>
        <Head>
            <meta
                name="description"
                :content="'個人Vtuberグループいせぶい所属' + currentMember.display + '非公式' + currentMember.display + 'DB　データ一覧ページ'"
            />
            <meta property="og:title" :content="'非公式' + currentMember.display + 'DB'" />
            <meta property="og:type" content="article" />
            <meta property="og:url" :content="'https://isevdb.sakura.ne.jp/' + currentMember.name" />
            <meta property="og:site_name" :content="'非公式' + currentMember.display + 'DB'" />
            <meta property="og:description" :content="'非公式' + currentMember.display + 'DB　データ一覧ページ'" />
            <meta property="og:locale" content="ja_JP" />
        </Head>
        <app-layout
            :title="currentMember.display + '非公式DB'"
            :chooseCate="true"
            :NowPage="currentMember.ENname"
            :NowCate="cateName"
            :currentMember="currentMember"
            :isSub="false"
            :style="styles"
        >
            <template #header>
                <h2 class="emitTitle">{{ currentMember.ENname }}</h2>
            </template>

            <template #window>
                <div class="w-full flex flex-col" v-if="!tweetWindow">
                    <div class="shadow-2xl shadow-stone-900 min-w-full aspect-video shadow-xl rounded-lg">
                        <img
                            loading="lazy"
                            class="object-cover h-full w-full rounded-lg"
                            :src="'/img/' + currentMember.name + '.jpg'"
                            :alt="currentMember.name"
                        />
                    </div>

                    <Link
                        as="button"
                        :href="route('welcome.page')"
                        class="text-gray-300 rounded-full border border-gray-300 my-2 w-fit mx-auto text-sm lg:text-md py-2 px-8"
                        >初めての方へ</Link
                    >
                </div>
                <div v-else class="pb-2 mx-0 min-w-full flex flex-col">
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
                    <IMGwindow v-if="this.TWtype == 'photo'" :url="tweetUrl" class="min-w-full py-2"></IMGwindow>
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
                <div class="flex flex-col mx-0">
                    <div class="mx-1 lg:mx-20 mt-2 mb-5 lg:mb-10 pointer-events-auto flex flex-row">
                        <div class="relative flex-grow">
                            <label class="sr-only text-white pointer-events-none" for="search"> Search </label>

                            <input
                                class="w-full py-1 lg:py-2 pl-3 pr-16 text-xs text-white border-2 border-gray-500 rounded-lg bg-stone-700"
                                id="search"
                                type="text"
                                placeholder="Search"
                                v-model="searchInput"
                            />
                            <Link
                                as="button"
                                method="get"
                                :href="route(routeName, { member: currentMember.name, cate: cateRoute, searchWord: searchInput })"
                                class="absolute p-1 text-white -translate-y-1/2 rounded-full top-1/2 right-4"
                            >
                                <svg class="w-3 h-3 lg:w-4 lg:h-4 fill-gray-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7C401.8 87.79 326.8 13.32 235.2 1.723C99.01-15.51-15.51 99.01 1.724 235.2c11.6 91.64 86.08 166.7 177.6 178.9c53.8 7.189 104.3-6.236 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 0C515.9 484.7 515.9 459.3 500.3 443.7zM79.1 208c0-70.58 57.42-128 128-128s128 57.42 128 128c0 70.58-57.42 128-128 128S79.1 278.6 79.1 208z"
                                    />
                                </svg>
                            </Link>
                        </div>
                        <Link
                            v-if="searchWord"
                            as="button"
                            method="get"
                            :href="route(routeName, { member: currentMember.name, cate: cateRoute })"
                            class="ml-2 px-2 text-white text-xs rounded-md"
                        >
                            <svg class="w-3 h-3 lg:w-4 lg:h-4 fill-gray-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM175 208.1L222.1 255.1L175 303C165.7 312.4 165.7 327.6 175 336.1C184.4 346.3 199.6 346.3 208.1 336.1L255.1 289.9L303 336.1C312.4 346.3 327.6 346.3 336.1 336.1C346.3 327.6 346.3 312.4 336.1 303L289.9 255.1L336.1 208.1C346.3 199.6 346.3 184.4 336.1 175C327.6 165.7 312.4 165.7 303 175L255.1 222.1L208.1 175C199.6 165.7 184.4 165.7 175 175C165.7 184.4 165.7 199.6 175 208.1V208.1z"
                                />
                            </svg>
                        </Link>
                    </div>

                    <div class="flex flex-row justify-center mb-5 lg:mb-10">
                        <Link
                            :class="sortType == '' ? 'shadow-md shadow-zinc-900 text-gray-200 border-2 border-zinc-700 ' : 'text-gray-200'"
                            class="flex items-center mx-1 py-0.5 cursor-pointer rounded-md text-center focus:outline-none font-Raleway font-bold min-w-min"
                            as="div"
                            :href="
                                searchWord == ''
                                    ? route(routeName, { member: currentMember.name, cate: cateRoute })
                                    : route(routeName, { member: currentMember.name, cate: cateRoute, searchWord: searchInput })
                            "
                        >
                            <span class="text-xs mx-2 lg:mx-5 my-auto"> id </span>
                        </Link>
                        <Link
                            :class="sortType == 'date' ? 'shadow-md shadow-zinc-900 text-gray-200 border-2 border-zinc-700 ' : 'text-gray-200'"
                            class="flex items-center mx-1 py-0.5 cursor-pointer rounded-md text-center focus:outline-none font-Raleway font-bold min-w-min"
                            as="div"
                            :href="
                                searchWord == ''
                                    ? route(routeName, { member: currentMember.name, cate: cateRoute, sortType: 'date' })
                                    : route(routeName, { member: currentMember.name, cate: cateRoute, searchWord: searchInput, sortType: 'date' })
                            "
                        >
                            <span class="text-xs mx-2 lg:mx-5 my-auto"> date </span>
                        </Link>
                        <Link
                            :class="sortType == 'title' ? 'shadow-md shadow-zinc-900 text-gray-200 border-2 border-zinc-700 ' : 'text-gray-200'"
                            class="flex items-center mx-1 py-0.5 cursor-pointer rounded-md text-center focus:outline-none font-Raleway font-bold min-w-min"
                            as="div"
                            :href="
                                searchWord == ''
                                    ? route(routeName, { member: currentMember.name, cate: cateRoute, sortType: 'title' })
                                    : route(routeName, { member: currentMember.name, cate: cateRoute, searchWord: searchInput, sortType: 'title' })
                            "
                        >
                            <span class="text-xs mx-2 lg:mx-5 my-auto"> title </span>
                        </Link>

                        <div class="inline-flex ml-2">
                            <!-- active -->
                            <button
                                @click="sortReverse"
                                class="px-1 py-0.5 rounded-md"
                                :class="[
                                    orderSwitch
                                        ? 'shadow-md shadow-zinc-900 text-gray-200 border-2 border-zinc-700 pointer-events-none cursor-not-allowed'
                                        : 'text-gray-200',
                                ]"
                            >
                                <svg class="w-6 h-6 fill-gray-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M9.39 265.4l127.1-128C143.6 131.1 151.8 128 160 128s16.38 3.125 22.63 9.375l127.1 128c9.156 9.156 11.9 22.91 6.943 34.88S300.9 320 287.1 320H32.01c-12.94 0-24.62-7.781-29.58-19.75S.2333 274.5 9.39 265.4z"
                                    />
                                </svg>
                            </button>

                            <button
                                @click="sortReverse"
                                class="px-1 py-0.5 rounded-md"
                                :class="[
                                    !orderSwitch
                                        ? 'shadow-md shadow-zinc-900 text-gray-200 border-2 border-zinc-700 pointer-events-none cursor-not-allowed'
                                        : 'text-gray-200',
                                ]"
                            >
                                <svg class="w-6 h-6 fill-gray-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M310.6 246.6l-127.1 128C176.4 380.9 168.2 384 160 384s-16.38-3.125-22.63-9.375l-127.1-128C.2244 237.5-2.516 223.7 2.438 211.8S19.07 192 32 192h255.1c12.94 0 24.62 7.781 29.58 19.75S319.8 237.5 310.6 246.6z"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <PaginateBtn
                        class="mb-6 mx-auto"
                        :links="players.links"
                        :search="search"
                        :currentPage="players.current_page"
                        :sort="sort"
                        :order="orderPaginate"
                    />

                    <div class="flex flex-row flex-wrap">
                        <div v-for="item in DisplayPlayers" :key="'player' + item.id" class="py-1 px-10 lg:px-1 h-fit w-full lg:w-1/3">
                            <div v-if="item.twitter == null">
                                <y-tcard
                                    :title="item.title"
                                    :date="item.date"
                                    :status="item.status"
                                    :url="'/' + currentMember.name + '/player/' + item.id"
                                    :isLike="likes.includes(item.id)"
                                    @disLikeEmit="DisLike(item.id)"
                                    @addLikeEmit="addLike(item.id)"
                                ></y-tcard>
                            </div>
                            <div v-else>
                                <t-wcard
                                    :isLike="likes.includes(item.id)"
                                    :title="item.title"
                                    :date="item.date"
                                    @tweetShow="tweetShow(item.tweetUrl, item.tweetType, item.id)"
                                    @disLikeEmit="DisLike(item.id)"
                                    @addLikeEmit="addLike(item.id)"
                                ></t-wcard>
                            </div>
                        </div>
                    </div>
                </div>
                <LoginModal :isVisible="modalShow" @close="modalShow = false"></LoginModal>
            </template>
        </app-layout>
    </div>
</template>

<script>
import { defineComponent } from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import { Head, Link } from "@inertiajs/inertia-vue3"
import YTcard from "../components/YTcard.vue"
import TWcard from "../components/TWcard.vue"
import TWwindow from "../components/TWwindow.vue"
import IMGwindow from "../components/IMGwindow.vue"
import LoginModal from "../components/LoginModal"
import PaginateBtn from "@/Components/PaginateBtn"

export default defineComponent({
    props: {
        players: Object,
        currentMember: Object,
        cate: Number,
        searchWord: String,
        sortType: String,
        order: Boolean,
    },
    components: {
        AppLayout,
        YTcard,
        TWcard,
        TWwindow,
        IMGwindow,
        PaginateBtn,
        Link,
        Head,
        LoginModal,
    },
    data() {
        return {
            cateName: "",
            searchInput: "",
            cateRoute: "",
            routeName: "",
            tweetWindow: false,
            tweetUrl: "",
            TWtype: "",
            orderSwitch: false,
            DisplayPlayers: [],
            currentIndex: 0,
            likes: [],
            modalShow: false,
        }
    },
    created() {
        if (this.cate == 0) {
            this.cateName = "Latest"
            this.cateRoute = "latest"
            this.routeName = "member.latest"
        } else {
            let tempCate = this.$page.props.setting.category.filter((u) => u.id === this.cate)
            this.cateName = tempCate[0].title
            this.cateRoute = this.cate
            this.routeName = "member.cate"
        }
        this.searchInput = this.searchWord
        this.orderSwitch = this.order
        this.DisplayPlayers = this.players.data

        if (this.$page.props.setting.likesObj == null) {
            this.likes = []
        } else {
            this.likes = this.$page.props.setting.likesObj
        }

        if (this.cate != 0) {
            this.$nextTick(function () {
                document.getElementById("MainContent").scrollIntoView(true)
            })
        }
    },
    methods: {
        tweetShow(url, type, id) {
            this.tweetWindow = false
            this.tweetUrl = url
            this.TWtype = type
            this.$nextTick(function () {
                this.tweetWindow = true
                this.currentIndex = id
            })
            this.$nextTick(function () {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth",
                })
            })
        },
        sortReverse() {
            let orderType = null
            if (this.orderSwitch) {
                orderType = "desc"
            } else {
                orderType = "asc"
            }
            let transURL = "/" + this.currentMember.name + "/" + this.cateRoute + "/?orderType=" + orderType

            if (this.sort) {
                transURL = transURL + this.sort
            }
            if (this.search) {
                transURL = transURL + this.search
            }
            this.$inertia.get(transURL)
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
        search() {
            if (this.searchInput == "") {
                return ""
            } else {
                return "&searchWord=" + this.searchInput
            }
        },
        sort() {
            if (this.sortType == "" || this.sortType == null) {
                return ""
            } else {
                return "&sortType=" + this.sortType
            }
        },
        orderPaginate() {
            if (this.order) {
                return "&sortType=asc"
            } else {
                return "&sortType=desc"
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
</style>
