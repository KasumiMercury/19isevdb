<template>
    <div>
        <Head :title="title" />

        <div class="min-h-max bg-zinc-800">
            <!-- header -->
            <div class="bg-stone-800">
                <header>
                    <div class="flex justify-evenly max-w-5xl mx-auto bg-stone-800 pt-4 pb-2" id="siteTitle">
                        <h2 class="goldTitle font-Caveat text-xl sm:text-4xl my-auto">UNOFFICIAL</h2>
                        <div class="notGold font-Caveat text-2xl sm:text-5xl my-auto">
                            <slot name="header"></slot>
                        </div>
                        <h2 class="goldTitle font-Caveat text-xl sm:text-4xl my-auto">DATABASE</h2>
                    </div>
                    <div class="flex flex-row justify-end pr-4 lg:pr-10 pb-2 bg-stone-800">
                        <Link
                            as="button"
                            href="/live/info"
                            class="flex flex-row font-Caveast bg-transparent text-red-400 text-emit-lg shadow-red-200 text-xs md:text-lg mr-auto ml-3 lg:ml-5"
                        >
                            LIVE info
                        </Link>
                        <Link
                            as="button"
                            :href="route('myLogin')"
                            v-if="!$page.props.user"
                            class="flex flex-row font-Caveast bg-transparent text-emerald-500 text-emit-lg shadow-emerald-400 text-xs md:text-lg ml-auto mr-3 lg:mr-5"
                        >
                            <svg class="h-3 w-3 lg:h-4 lg:w-4 fill-emerald-500 my-auto mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M344.7 238.5l-144.1-136C193.7 95.97 183.4 94.17 174.6 97.95C165.8 101.8 160.1 110.4 160.1 120V192H32.02C14.33 192 0 206.3 0 224v64c0 17.68 14.33 32 32.02 32h128.1v72c0 9.578 5.707 18.25 14.51 22.05c8.803 3.781 19.03 1.984 26-4.594l144.1-136C354.3 264.4 354.3 247.6 344.7 238.5zM416 32h-64c-17.67 0-32 14.33-32 32s14.33 32 32 32h64c17.67 0 32 14.33 32 32v256c0 17.67-14.33 32-32 32h-64c-17.67 0-32 14.33-32 32s14.33 32 32 32h64c53.02 0 96-42.98 96-96V128C512 74.98 469 32 416 32z"
                                />
                            </svg>
                            Login
                        </Link>
                        <Link
                            as="button"
                            :href="route('register')"
                            v-if="!$page.props.user"
                            class="flex flex-row font-Caveast bg-transparent text-emerald-500 text-emit-lg shadow-emerald-400 text-xs md:text-lg"
                        >
                            <svg class="h-3 w-3 lg:h-4 lg:w-4 fill-emerald-500 my-auto mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3C0 496.5 15.52 512 34.66 512h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM616 200h-48v-48C568 138.8 557.3 128 544 128s-24 10.75-24 24v48h-48C458.8 200 448 210.8 448 224s10.75 24 24 24h48v48C520 309.3 530.8 320 544 320s24-10.75 24-24v-48h48C629.3 248 640 237.3 640 224S629.3 200 616 200z"
                                />
                            </svg>
                            Register
                        </Link>
                        <button
                            @click="logout"
                            v-if="$page.props.user"
                            class="flex flex-row justify-items-center font-Caveast bg-transparent text-emerald-500 text-emit-lg shadow-emerald-400 text-xs md:text-lg"
                        >
                            <svg class="h-3 w-3 lg:h-4 lg:w-4 fill-emerald-500 my-auto mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M96 480h64C177.7 480 192 465.7 192 448S177.7 416 160 416H96c-17.67 0-32-14.33-32-32V128c0-17.67 14.33-32 32-32h64C177.7 96 192 81.67 192 64S177.7 32 160 32H96C42.98 32 0 74.98 0 128v256C0 437 42.98 480 96 480zM504.8 238.5l-144.1-136c-6.975-6.578-17.2-8.375-26-4.594c-8.803 3.797-14.51 12.47-14.51 22.05l-.0918 72l-128-.001c-17.69 0-32.02 14.33-32.02 32v64c0 17.67 14.34 32 32.02 32l128 .001l.0918 71.1c0 9.578 5.707 18.25 14.51 22.05c8.803 3.781 19.03 1.984 26-4.594l144.1-136C514.4 264.4 514.4 247.6 504.8 238.5z"
                                />
                            </svg>
                            Logout
                        </button>
                    </div>
                </header>
            </div>
            <!-- header end -->

            <!-- Page Content -->
            <main>
                <div class="bg-zinc-800">
                    <div class="w-full m-0 h-px goldLine"></div>
                    <div class="py-1 lg:py-5 px-1 customSticky window max-w-full md:max-w-2xl lg:max-w-3xl mx-auto bg-zinc-800">
                        <slot name="window"></slot>
                    </div>
                    <div class="customSticky stickContent flex flex-col">
                        <div class="h-0.5 w-full m-0 goldLine"></div>
                        <div class="bg-stone-800">
                            <!-- player -->
                            <div v-if="isSub" class="mx-auto w-full bg-stone-800">
                                <div class="w-fit mx-auto">
                                    <slot name="player"></slot>
                                </div>
                            </div>
                            <!-- player end -->

                            <div
                                id="MainContent"
                                class="px-0 sm:px-6 lg:px-8 pt-4 pb-20 lg:pb-10 lg:pt-6 mx-auto mt-0 min-w-full bg-stone-800 flex flex-col lg:flex-row"
                            >
                                <!-- common btn-->
                                <div class="flex flex-col py-2 lg:py-0 lg:mr-10 lg:w-44 flex-none">
                                    <div class="lg:min-w-full flex flex-col mx-auto">
                                        <template v-if="!chooseCate">
                                            <div class="flex flex-row lg:flex-col lg:mx-0 lg:w-full my-1 lg:my-0">
                                                <div
                                                    class="animate-bounce text-xs lg:text-sm min-w-max mr-1 lg:mx-0 my-auto lg:my-2 text-emit-lg text-amber-500 shadow-amber-400/50"
                                                >
                                                    <p>CHOOSE MEMBER<span class="lg:hidden">：</span></p>
                                                </div>
                                                <div class="min-w-max mt-0">
                                                    <DropDown
                                                        classSet="text-amber-300  bg-gradient-radial from-amber-500 via-amber-700 to-amber-800
                                                                shadow-lg shadow-amber-700/80 border-amber-500 border-x-amber-600"
                                                        :topOffset="96"
                                                    >
                                                        <template v-slot:button>
                                                            <span class="mx-2 lg:mx-5">{{ NowPage }}</span>
                                                        </template>

                                                        <template v-slot:content>
                                                            <Link
                                                                as="a"
                                                                v-bind:class="{ isActive: activeMember === 'top' }"
                                                                @mouseover="activeMember = 'top'"
                                                                @mouseout="activeMember = ''"
                                                                class="flex w-full justify-between items-center rounded px-2 py-2 my-1 hover:text-white"
                                                                href="/"
                                                            >
                                                                トップページ
                                                            </Link>
                                                            <div v-for="member in $page.props.setting.member" :key="member.name">
                                                                <Link
                                                                    as="a"
                                                                    v-bind:class="{ isActive: activeMember === member.name }"
                                                                    @mouseover="activeMember = member.name"
                                                                    @mouseout="activeMember = ''"
                                                                    class="flex w-full justify-between items-center rounded px-2 py-2 my-1 hover:text-white"
                                                                    :href="'/' + member.name + '/latest'"
                                                                >
                                                                    {{ member.display }}
                                                                </Link>
                                                            </div>
                                                        </template>
                                                    </DropDown>
                                                </div>
                                            </div>
                                            <div class="flex flex-row lg:flex-col mx-auto lg:mx-0 lg:w-full my-1 lg:mt-4 lg:my-0">
                                                <div class="text-xxs lg:text-xs min-w-max mr-1 lg:mx-0 my-auto lg:my-2 text-amber-800">
                                                    <p>CHOOSE CATEGORY <span class="lg:hidden">：</span></p>
                                                </div>
                                                <div class="min-w-max lg:min-w-full mt-0">
                                                    <DropDown
                                                        classSet="text-amber-600 pointer-events-none  bg-gradient-radial from-amber-700 via-amber-800 to-amber-900
                                                            shadow-none shadow-amber-700/80 border-amber-800 border-x-amber-900"
                                                        :topOffset="0"
                                                    >
                                                        <template v-slot:button>
                                                            <span class="mx-2 lg:mx-5">{{ NowCate }}</span>
                                                        </template>

                                                        <template v-slot:content>
                                                            <a
                                                                href="#"
                                                                class="flex w-full justify-between items-center rounded px-2 py-2 my-1 hover:bg-indigo-600 hover:text-white"
                                                            >
                                                                NONE</a
                                                            >
                                                        </template>
                                                    </DropDown>
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div class="flex flex-row lg:flex-col lg:mx-0 lg:w-full my-1 lg:my-0">
                                                <div
                                                    class="text-xs lg:text-sm min-w-max mr-1 lg:mx-0 my-auto lg:my-2 text-emit-lg text-amber-600 shadow-amber-400/50"
                                                >
                                                    <p>CHOOSE MEMBER<span class="lg:hidden">：</span></p>
                                                </div>
                                                <div class="min-w-max mt-0">
                                                    <DropDown
                                                        classSet="text-orange-200  bg-gradient-radial from-amber-600 via-amber-800 to-amber-900
                                                                shadow-lg shadow-amber-800/80 border-amber-500 border-x-amber-600"
                                                        :topOffset="96"
                                                    >
                                                        <template v-slot:button>
                                                            <span class="mx-2 lg:mx-5">{{ NowPage }}</span>
                                                        </template>

                                                        <template v-slot:content>
                                                            <Link
                                                                as="a"
                                                                v-bind:class="{ isActive: activeMember === 'top' }"
                                                                @mouseover="activeMember = 'top'"
                                                                @mouseout="activeMember = ''"
                                                                class="flex w-full justify-between items-center rounded px-2 py-2 my-1 hover:text-white"
                                                                :href="'/'"
                                                            >
                                                                トップページ
                                                            </Link>
                                                            <div v-for="member in $page.props.setting.member" :key="member.name">
                                                                <Link
                                                                    as="a"
                                                                    v-bind:class="{ isActive: activeMember === member.name }"
                                                                    @mouseover="activeMember = member.name"
                                                                    @mouseout="activeMember = ''"
                                                                    class="flex w-full justify-between items-center rounded px-2 py-2 my-1 hover:text-white"
                                                                    :href="'/' + member.name + '/latest'"
                                                                >
                                                                    {{ member.display }}
                                                                </Link>
                                                            </div>
                                                        </template>
                                                    </DropDown>
                                                </div>
                                            </div>
                                            <div class="flex flex-row lg:flex-col lg:mx-0 mx-auto lg:w-full my-1 lg:mt-4 lg:my-0">
                                                <div
                                                    class="text-xs lg:text-sm min-w-max mr-1 lg:mx-0 my-auto lg:my-2 text-emit-lg text-amber-500 shadow-amber-400/50"
                                                >
                                                    <p>CHOOSE CATEGORY <span class="lg:hidden">：</span></p>
                                                </div>
                                                <div class="min-w-max lg:min-w-full mt-0">
                                                    <DropDown
                                                        classSet="text-orange-200  bg-gradient-radial from-amber-500 via-amber-700 to-amber-800
                                                                shadow-lg shadow-amber-800/80 border-amber-500 border-x-amber-600"
                                                        :topOffset="0"
                                                    >
                                                        <template v-slot:button>
                                                            <span class="mx-2">{{ NowCate }}</span>
                                                        </template>

                                                        <template v-slot:content>
                                                            <Link
                                                                as="a"
                                                                v-bind:class="{ isActive: activeCategory === 'latest' }"
                                                                @mouseover="activeCategory = 'latest'"
                                                                @mouseout="activeCategory = ''"
                                                                class="flex w-full justify-between items-center rounded px-2 py-2 my-1 hover:text-white"
                                                                :href="'/' + currentMember.name + '/latest'"
                                                            >
                                                                Latest
                                                            </Link>
                                                            <div v-for="(category, index) in $page.props.setting.category" :key="'category' + index">
                                                                <Link
                                                                    as="a"
                                                                    v-bind:class="{ isActive: activeCategory === category.title }"
                                                                    @mouseover="activeCategory = category.title"
                                                                    @mouseout="activeCategory = ''"
                                                                    class="flex w-full justify-between items-center rounded px-2 py-2 my-1 hover:text-white"
                                                                    :href="'/' + currentMember.name + '/' + category.id"
                                                                >
                                                                    {{ category.title }}
                                                                </Link>
                                                            </div>
                                                        </template>
                                                    </DropDown>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="lg:min-w-full hidden md:inline-block mx-auto">
                                        <div class="flex flex-row lg:flex-col">
                                            <Link
                                                as="div"
                                                :href="route('data.add')"
                                                class="animate-flicker lg:w-full text-center cursor-pointer mx-5 lg:mx-0 my-2 lg:mt-6 lg:mb-6 border-2 rounded-sm items-center focus:outline-none font-Raleway font-bold text-emerald-300 bg-gradient-radial from-emerald-600 via-emerald-800 to-emerald-900 shadow-xl shadow-emerald-800/80 border-emerald-600 border-x-emerald-700"
                                            >
                                                <span class="px-0 lg:px-2 py-1 lg:py-2 inline-flex items-center text-xxs lg:text-xs">
                                                    <span class="mx-2 lg:mx-5">AddData</span>
                                                </span>
                                            </Link>
                                            <Link
                                                v-if="$page.props.user"
                                                as="div"
                                                :href="route('user.book')"
                                                class="lg:w-full text-center cursor-pointer mx-5 lg:mx-0 my-2 lg:mt-0 lg:mb-4 border-2 rounded-sm items-center focus:outline-none font-Raleway font-bold text-cyan-300 bg-gradient-radial from-cyan-600 via-cyan-800 to-cyan-900 shadow-lg shadow-cyan-800/80 border-cyan-600 border-x-cyan-700"
                                            >
                                                <span class="px-0 lg:px-2 py-1 lg:py-2 inline-flex items-center text-xxs lg:text-xs">
                                                    <span class="mx-2 lg:mx-5">BookMark</span>
                                                </span>
                                            </Link>
                                            <div
                                                v-else
                                                @click="modalShow = true"
                                                class="lg:w-full text-center cursor-pointer mx-5 lg:mx-0 my-2 lg:mt-0 lg:mb-4 border-2 rounded-sm items-center focus:outline-none font-Raleway font-bold text-cyan-300 bg-gradient-radial from-cyan-600 via-cyan-800 to-cyan-900 shadow-lg shadow-cyan-800/80 border-cyan-600 border-x-cyan-700"
                                            >
                                                <span class="px-0 lg:px-2 py-1 lg:py-2 inline-flex items-center text-xxs lg:text-xs">
                                                    <span class="mx-2 lg:mx-5">BookMark</span>
                                                </span>
                                            </div>
                                            <Link
                                                v-if="$page.props.user"
                                                as="div"
                                                :href="route('user.added')"
                                                class="lg:w-full text-center cursor-pointer mx-5 lg:mx-0 my-2 lg:mt-0 lg:mb-0 border-2 rounded-sm items-center focus:outline-none font-Raleway font-bold text-cyan-300 bg-gradient-radial from-cyan-600 via-cyan-800 to-cyan-900 shadow-lg shadow-cyan-800/80 border-cyan-600 border-x-cyan-700"
                                            >
                                                <span class="px-0 lg:px-2 py-1 lg:py-2 inline-flex items-center text-xxs lg:text-xs">
                                                    <span class="mx-2 lg:mx-5">YourData</span>
                                                </span>
                                            </Link>
                                            <div
                                                v-else
                                                @click="modalShow = true"
                                                class="lg:w-full text-center cursor-pointer mx-5 lg:mx-0 my-2 lg:mt-0 lg:mb-4 border-2 rounded-sm items-center focus:outline-none font-Raleway font-bold text-cyan-300 bg-gradient-radial from-cyan-600 via-cyan-800 to-cyan-900 shadow-lg shadow-cyan-800/80 border-cyan-600 border-x-cyan-700"
                                            >
                                                <span class="px-0 lg:px-2 py-1 lg:py-2 inline-flex items-center text-xxs lg:text-xs">
                                                    <span class="mx-2 lg:mx-5">YourData</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- common btn end -->

                                <div class="flex-grow">
                                    <slot></slot>
                                </div>

                                <!-- SP btn -->
                                <div class="fixed bottom-0 inset-x-0 mx-0 w-full z-10 md:hidden shadow-xl shadow-stone-900">
                                    <div class="w-full h-px goldLine m-0"></div>
                                    <div class="flex flex-row bg-stone-800 mx-0 w-full">
                                        <Link
                                            v-if="$page.props.user"
                                            as="div"
                                            :href="route('user.book')"
                                            class="flex-1 py-1 cursor-pointer text-center focus:outline-none font-Raleway font-bold min-w-max text-cyan-300 bg-gradient-radial from-cyan-600 via-cyan-800 to-cyan-900 border-cyan-600 border-x-cyan-700"
                                        >
                                            <span class="px-auto py-0.5 text-xs">
                                                <span class="mx-2 lg:mx-5">BookMark</span>
                                            </span>
                                        </Link>
                                        <div
                                            v-else
                                            @click="modalShow = true"
                                            class="flex-1 py-1 cursor-pointer text-center focus:outline-none font-Raleway font-bold min-w-max text-cyan-300 bg-gradient-radial from-cyan-600 via-cyan-800 to-cyan-900 border-cyan-600 border-x-cyan-700"
                                        >
                                            <span class="px-auto py-0.5 text-xs mx-auto my-auto">
                                                <span class="mx-2 lg:mx-5">BookMark</span>
                                            </span>
                                        </div>
                                        <div class="h-full w-px bg-gray-900 m-0 p-0"></div>
                                        <Link
                                            v-if="$page.props.user"
                                            as="div"
                                            :href="route('user.added')"
                                            class="flex-1 py-1 cursor-pointer text-center focus:outline-none font-Raleway font-bold min-w-max text-cyan-300 bg-gradient-radial from-cyan-600 via-cyan-800 to-cyan-900 border-cyan-600 border-x-cyan-700"
                                        >
                                            <span class="px-auto py-0.5 text-xs mx-auto my-auto">
                                                <span class="mx-2 lg:mx-5">YourData</span>
                                            </span>
                                        </Link>
                                        <div
                                            v-else
                                            @click="modalShow = true"
                                            class="flex-1 py-1 cursor-pointer text-center focus:outline-none font-Raleway font-bold min-w-max text-cyan-300 bg-gradient-radial from-cyan-600 via-cyan-800 to-cyan-900 border-cyan-600 border-x-cyan-700"
                                        >
                                            <span class="px-auto py-0.5 text-xs mx-auto my-auto">
                                                <span class="mx-2 lg:mx-5">YourData</span>
                                            </span>
                                        </div>
                                        <div class="h-full w-px bg-gray-900 m-0 p-0"></div>
                                        <Link
                                            as="div"
                                            :href="route('data.add')"
                                            class="flex-1 py-1 animate-flicker cursor-pointer text-center focus:outline-none font-Raleway font-bold min-w-max text-emerald-300 bg-gradient-radial from-emerald-600 via-emerald-800 to-emerald-900 border-emerald-600 border-x-emerald-700"
                                        >
                                            <span class="px-auto py-0.5 text-xs mx-auto my-auto">
                                                <span class="mx-2 lg:mx-5">AddData</span>
                                            </span>
                                        </Link>
                                    </div>
                                </div>
                                <!-- SP btn end -->
                            </div>
                        </div>
                    </div>
                </div>
                <LoginModal :isVisible="modalShow" @close="modalShow = false"></LoginModal>
            </main>
            <div class="w-full pt-52 pb-16 bg-stone-800 px-5">
                <div class="max-w-5xl mx-auto text-center flex flex-col">
                    <a class="text-xxs lg-text-xs text-blue-300 mb-1" href="https://isevdb.net/matome">まよすけまとめ（ネタページ）</a>
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
    </div>
</template>

<script>
import { defineComponent } from "vue"
import DropDown from "@/components/DropDown.vue"
import { Head, Link } from "@inertiajs/inertia-vue3"
import LoginModal from "../components/LoginModal"

export default defineComponent({
    props: {
        title: String,
        NowPage: String,
        NowCate: String,
        isSub: Boolean,
        chooseCate: Boolean,
        currentMember: Object,
    },
    components: {
        Head,
        DropDown,
        Link,
        LoginModal,
    },
    data() {
        return {
            activeMember: "",
            activeCategory: "",
            modalShow: false,
        }
    },

    methods: {
        logout() {
            this.$inertia.post(route("logout"))
        },
    },
})
</script>
<style scoped>
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
