<template>
    <div>
        <Head :title="title" />

        <div class="min-h-max bg-zinc-800">
            <!-- header -->
            <div class="bg-stone-800">
                <header>
                    <Link
                        as="div"
                        :href="route('TopPage')"
                        class="cursor-pointer flex justify-evenly max-w-5xl mx-auto bg-stone-800 pt-4 pb-2"
                        id="siteTitle"
                    >
                        <h2 class="goldTitle font-Caveat text-xl sm:text-4xl my-auto">UNOFFICIAL</h2>
                        <div class="notGold font-Caveat text-2xl sm:text-5xl my-auto">
                            <slot name="header"></slot>
                        </div>
                        <h2 class="goldTitle font-Caveat text-xl sm:text-4xl my-auto">DATABASE</h2>
                    </Link>
                    <div class="flex flex-row justify-end pr-4 lg:pr-10 pb-2 bg-stone-800" id="playerTop">
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
                    <div class="customSticky stickContent flex flex-col" id="MainContent">
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
                                class="px-0 sm:px-6 lg:px-8 pt-4 pb-20 lg:pb-10 lg:pt-6 mx-auto mt-0 min-w-full bg-stone-800 flex flex-col lg:flex-row"
                            >
                                <!-- common btn-->
                                <div class="flex flex-col py-2 lg:py-0 lg:mr-10 lg:w-44 flex-none">
                                    <div class="min-w-full flex flex-row justify-around lg:flex-col mx-auto">
                                        <template v-if="!chooseCate">
                                            <div class="flex flex-col lg:mx-0 lg:w-full my-1 lg:my-0">
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
                                            <div class="flex flex-col lg:mx-0 lg:w-full my-1 lg:mt-4 lg:my-0">
                                                <div
                                                    class="text-xs lg:text-sm min-w-max mr-1 lg:mx-0 my-auto lg:my-2 text-emit-lg text-amber-600 shadow-amber-400/50"
                                                >
                                                    <p>CHOOSE CATEGORY <span class="lg:hidden">：</span></p>
                                                </div>
                                                <div class="min-w-max lg:min-w-full mt-0">
                                                    <DropDown
                                                        classSet="text-orange-200  bg-gradient-radial from-amber-600 via-amber-800 to-amber-900
                                                                shadow-lg shadow-amber-800/80 border-amber-500 border-x-amber-600"
                                                        :topOffset="0"
                                                    >
                                                        <template v-slot:button>
                                                            <span class="mx-2">{{ NowCate }}</span>
                                                        </template>

                                                        <template v-slot:content>
                                                            <div v-for="(category, index) in $page.props.setting.category" :key="'category' + index">
                                                                <Link
                                                                    as="a"
                                                                    v-bind:class="{ isActive: activeCategory === category.title }"
                                                                    @mouseover="activeCategory = category.title"
                                                                    @mouseout="activeCategory = ''"
                                                                    class="flex w-full justify-between items-center rounded px-2 py-2 my-1 hover:text-white"
                                                                    :href="'/all/' + category.id"
                                                                >
                                                                    {{ category.title }}
                                                                </Link>
                                                            </div>
                                                        </template>
                                                    </DropDown>
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div class="flex flex-col lg:mx-0 lg:w-full my-1 lg:my-0">
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
                                            <div class="flex flex-col lg:mx-0 lg:w-full my-1 lg:mt-4 lg:my-0">
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
                                    <Link
                                        v-if="chooseCate"
                                        as="div"
                                        :href="route('TopPage')"
                                        class="w-fit lg:w-full text-center cursor-pointer px-10 lg:px-5 mx-auto lg:mx-0 mb-2 mt-4 lg:mt-6 lg:mb-6 border-2 rounded-sm items-center focus:outline-none font-Raleway font-bold text-orange-200 bg-gradient-radial from-amber-500 via-amber-700 to-amber-800 shadow-lg shadow-amber-800/80 border-amber-500 border-x-amber-600"
                                    >
                                        <span class="px-0 lg:px-2 py-1 lg:py-2 inline-flex items-center text-xxs lg:text-xs">
                                            <span class="mx-2 lg:mx-5">TopPage</span>
                                        </span>
                                    </Link>
                                    <!-- PC btn -->
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
                                    <!-- PC btn end -->
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
            <div class="w-full pb-16 bg-stone-800 px-5">
                <slot name="paginate"></slot>
                <JukeNumber class="mx-auto"></JukeNumber>
                <div class="pt-5 h-fit flex flex-row mb-12 max-w-2xl mx-auto">
                    <a
                        class="grow border border-[#00ACEE] h-fit my-auto mx-1 py-1 rounded-md"
                        :href="'https://twitter.com/share?url=' + shareUrl + '&text=非公式いせぶいDB'"
                        target="_blank"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 md:w-6 h-4 md:h-6 fill-[#00ACEE] mx-auto">
                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path
                                d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"
                            />
                        </svg>
                    </a>
                    <a
                        class="grow border border-[#1877f1] h-fit my-auto mx-1 py-1 rounded-md"
                        :href="'https://www.facebook.com/share.php?u=' + shareUrl"
                        rel="nofollow"
                        target="_blank"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="w-4 md:w-6 h-4 md:h-6 fill-[#1877f1] mx-auto">
                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path
                                d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"
                            />
                        </svg>
                    </a>
                    <a
                        :href="'https://social-plugins.line.me/lineit/share?url=' + shareUrl"
                        target="_blank"
                        rel="nofollow"
                        class="grow border border-[#6CC655] h-fit my-auto mx-1 py-1 rounded-md"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 md:w-6 h-4 md:h-6 fill-[#6CC655] mx-auto">
                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path
                                d="M272.1 204.2v71.1c0 1.8-1.4 3.2-3.2 3.2h-11.4c-1.1 0-2.1-.6-2.6-1.3l-32.6-44v42.2c0 1.8-1.4 3.2-3.2 3.2h-11.4c-1.8 0-3.2-1.4-3.2-3.2v-71.1c0-1.8 1.4-3.2 3.2-3.2H219c1 0 2.1.5 2.6 1.4l32.6 44v-42.2c0-1.8 1.4-3.2 3.2-3.2h11.4c1.8-.1 3.3 1.4 3.3 3.1zm-82-3.2h-11.4c-1.8 0-3.2 1.4-3.2 3.2v71.1c0 1.8 1.4 3.2 3.2 3.2h11.4c1.8 0 3.2-1.4 3.2-3.2v-71.1c0-1.7-1.4-3.2-3.2-3.2zm-27.5 59.6h-31.1v-56.4c0-1.8-1.4-3.2-3.2-3.2h-11.4c-1.8 0-3.2 1.4-3.2 3.2v71.1c0 .9.3 1.6.9 2.2.6.5 1.3.9 2.2.9h45.7c1.8 0 3.2-1.4 3.2-3.2v-11.4c0-1.7-1.4-3.2-3.1-3.2zM332.1 201h-45.7c-1.7 0-3.2 1.4-3.2 3.2v71.1c0 1.7 1.4 3.2 3.2 3.2h45.7c1.8 0 3.2-1.4 3.2-3.2v-11.4c0-1.8-1.4-3.2-3.2-3.2H301v-12h31.1c1.8 0 3.2-1.4 3.2-3.2V234c0-1.8-1.4-3.2-3.2-3.2H301v-12h31.1c1.8 0 3.2-1.4 3.2-3.2v-11.4c-.1-1.7-1.5-3.2-3.2-3.2zM448 113.7V399c-.1 44.8-36.8 81.1-81.7 81H81c-44.8-.1-81.1-36.9-81-81.7V113c.1-44.8 36.9-81.1 81.7-81H367c44.8.1 81.1 36.8 81 81.7zm-61.6 122.6c0-73-73.2-132.4-163.1-132.4-89.9 0-163.1 59.4-163.1 132.4 0 65.4 58 120.2 136.4 130.6 19.1 4.1 16.9 11.1 12.6 36.8-.7 4.1-3.3 16.1 14.1 8.8 17.4-7.3 93.9-55.3 128.2-94.7 23.6-26 34.9-52.3 34.9-81.5z"
                            />
                        </svg>
                    </a>
                    <a
                        :href="'https://getpocket.com/edit?url=' + shareUrl"
                        target="_blank"
                        rel="nofollow"
                        class="grow border border-[#F03E51] h-fit my-auto mx-1 py-1 rounded-md"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 md:w-6 h-4 md:h-6 fill-[#F03E51] mx-auto">
                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path
                                d="M407.6 64h-367C18.5 64 0 82.5 0 104.6v135.2C0 364.5 99.7 464 224.2 464c124 0 223.8-99.5 223.8-224.2V104.6c0-22.4-17.7-40.6-40.4-40.6zm-162 268.5c-12.4 11.8-31.4 11.1-42.4 0C89.5 223.6 88.3 227.4 88.3 209.3c0-16.9 13.8-30.7 30.7-30.7 17 0 16.1 3.8 105.2 89.3 90.6-86.9 88.6-89.3 105.5-89.3 16.9 0 30.7 13.8 30.7 30.7 0 17.8-2.9 15.7-114.8 123.2z"
                            />
                        </svg>
                    </a>
                    <p class="grow border border-gray-400 h-fit my-auto mx-1 py-1 rounded-md cursor-pointer" @click="copyToClipboard(this.shareUrl)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 md:w-6 h-4 md:h-6 fill-gray-400 mx-auto">
                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path
                                d="M384 96L384 0h-112c-26.51 0-48 21.49-48 48v288c0 26.51 21.49 48 48 48H464c26.51 0 48-21.49 48-48V128h-95.1C398.4 128 384 113.6 384 96zM416 0v96h96L416 0zM192 352V128h-144c-26.51 0-48 21.49-48 48v288c0 26.51 21.49 48 48 48h192c26.51 0 48-21.49 48-48L288 416h-32C220.7 416 192 387.3 192 352z"
                            />
                        </svg>
                    </p>
                </div>
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
import JukeNumber from "../components/JukeNumber"

export default defineComponent({
    props: {
        title: String,
        NowPage: String,
        NowCate: String,
        isSub: Boolean,
        chooseCate: Boolean,
        currentMember: Object,
        shareUrl: String,
    },
    components: {
        Head,
        DropDown,
        Link,
        LoginModal,
        JukeNumber,
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
        copyToClipboard(text) {
            navigator.clipboard
                .writeText(text)
                .then(() => {
                    console.log("copied!")
                    alert(this.shareUrl + "をコピーしました！")
                })
                .catch((e) => {
                    console.error(e)
                })
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
