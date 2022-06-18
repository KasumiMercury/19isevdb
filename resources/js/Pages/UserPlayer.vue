<template>
    <app-layout :title="Display" :chooseCate="false" :NowPage="Display" NowCate="NONE" :isSub="false" shareUrl="https://isevdb.net">
        <template #header>
            <h2 class="emitTitle">iseV</h2>
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
            </div>
        </template>

        <template #default>
            <div class="flex flex-col mx-0">
                <div class="mx-1 lg:mx-20 my-2 lg:mb-10 pointer-events-auto flex flex-row">
                    <form @submit.prevent="submit" class="relative flex-grow">
                        <label class="sr-only text-white pointer-events-none" for="search"> Search </label>

                        <input
                            class="w-full py-1 lg:py-2 pl-3 pr-16 text-xs text-white border-2 border-gray-500 rounded-lg bg-stone-700"
                            id="search"
                            type="text"
                            placeholder="Search"
                            v-model="searchInput"
                        />
                        <button type="submit" class="absolute p-1 text-white -translate-y-1/2 rounded-full top-1/2 right-4">
                            <svg class="w-3 h-3 lg:w-4 lg:h-4 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7C401.8 87.79 326.8 13.32 235.2 1.723C99.01-15.51-15.51 99.01 1.724 235.2c11.6 91.64 86.08 166.7 177.6 178.9c53.8 7.189 104.3-6.236 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 0C515.9 484.7 515.9 459.3 500.3 443.7zM79.1 208c0-70.58 57.42-128 128-128s128 57.42 128 128c0 70.58-57.42 128-128 128S79.1 278.6 79.1 208z"
                                />
                            </svg>
                        </button>
                    </form>
                    <Link v-if="searchWord" as="button" method="get" :href="route(routeType)" class="ml-2 px-2 text-white text-xs rounded-md">
                        <svg class="w-3 h-3 lg:w-4 lg:h-4 fill-gray-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path
                                d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM175 208.1L222.1 255.1L175 303C165.7 312.4 165.7 327.6 175 336.1C184.4 346.3 199.6 346.3 208.1 336.1L255.1 289.9L303 336.1C312.4 346.3 327.6 346.3 336.1 336.1C346.3 327.6 346.3 312.4 336.1 303L289.9 255.1L336.1 208.1C346.3 199.6 346.3 184.4 336.1 175C327.6 165.7 312.4 165.7 303 175L255.1 222.1L208.1 175C199.6 165.7 184.4 165.7 175 175C165.7 184.4 165.7 199.6 175 208.1V208.1z"
                            />
                        </svg>
                    </Link>
                </div>

                <div class="flex flex-row flex-wrap">
                    <div v-for="item in players.data" :key="'player' + item.id" class="py-1 px-3 sm:px-6 lg:px-1 lg:px-1 w-full lg:w-1/3">
                        <div v-if="item.twitter != null">
                            <t-wcard
                                :isLike="likes.includes(item.id)"
                                :title="item.title"
                                :date="item.date"
                                :tweetType="item.tweetType"
                                :photoMode="false"
                                :photoUrl="item.tweetUrl"
                                :memberName="item.name"
                                @tweetShow="tweetShow(item.tweetUrl, item.tweetType, item.id, item.twitter)"
                                @disLikeEmit="DisLike(item.id)"
                                @addLikeEmit="addLike(item.id)"
                            ></t-wcard>
                        </div>
                        <div v-else-if="item.YTclipUrl == null">
                            <y-tcard
                                :title="item.title"
                                :date="item.date"
                                :status="item.status"
                                :url="'/' + item.name + '/player/' + item.id"
                                :memberName="item.name"
                                :isLike="likes.includes(item.id)"
                                @disLikeEmit="DisLike(item.id)"
                                @addLikeEmit="addLike(item.id)"
                            ></y-tcard>
                        </div>
                        <div v-else>
                            <CLIPcard
                                :isLike="likes.includes(item.id)"
                                :title="item.title"
                                :date="item.date"
                                :status="item.status"
                                :url="item.YTclipUrl"
                                :memberName="item.name"
                                @disLikeEmit="DisLike(item.id)"
                                @addLikeEmit="addLike(item.id)"
                            ></CLIPcard>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #paginate>
            <PaginateBtn
                :links="players.links"
                :search="search"
                :sort="''"
                :currentPage="players.current_page"
                :pageLength="players.last_page"
                :order="''"
            />
        </template>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import { Link } from "@inertiajs/inertia-vue3"
import YTcard from "../components/YTcard.vue"
import TWcard from "../components/TWcard.vue"
import CLIPcard from "../components/CLIPcard.vue"
import TWwindow from "../components/TWwindow.vue"
import IMGwindow from "../components/IMGwindow.vue"
import PaginateBtn from "@/Components/PaginateBtn"

export default defineComponent({
    props: {
        players: Object,
        searchWord: String,
        routeType: String,
        Display: String,
        list_type: String,
    },
    components: {
        AppLayout,
        YTcard,
        TWcard,
        CLIPcard,
        TWwindow,
        IMGwindow,
        PaginateBtn,
        Link,
    },
    data() {
        return {
            searchInput: "",
            tweetWindow: false,
            tweetUrl: "",
            TWtype: "",
            twitterUrl: "",
            currentIndex: 0,
            likes: [],
        }
    },
    created() {
        this.searchInput = this.searchWord
        if (this.$page.props.setting.likesObj == null) {
            this.likes = []
        } else {
            this.likes = this.$page.props.setting.likesObj
        }
    },
    methods: {
        submit() {
            this.$inertia.get(route(this.routeType, { searchWord: this.searchInput }))
        },
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
        search() {
            if (this.searchInput == "") {
                return ""
            } else {
                return "&searchWord=" + this.searchInput
            }
        },
    },
})
</script>
<style scoped>
.emitTitle {
    color: #f59e0b;
    text-shadow: 0px 0px 20px #f59e0b;
}
</style>
