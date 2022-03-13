<template>
    <div>
        <Head>
            <meta name="description" content="個人Vtuberグループいせぶい非公式データベース　データ追加ページ" />
        </Head>
        <app-layout title="AddPage" :chooseCate="false" NowPage="AddPage" NowCate="NONE" :isSub="true">
            <template #header>
                <h2 class="emitTitle">iseV</h2>
            </template>

            <template #window>
                <div v-if="tweetWindow" class="pb-2 mx-0 min-w-full flex flex-col">
                    <div class="flex flex-row">
                        <button class="ml-auto mr-2 max-w-max" @click="tweetWindow = false">
                            <svg class="fill-red-600 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM175 208.1L222.1 255.1L175 303C165.7 312.4 165.7 327.6 175 336.1C184.4 346.3 199.6 346.3 208.1 336.1L255.1 289.9L303 336.1C312.4 346.3 327.6 346.3 336.1 336.1C346.3 327.6 346.3 312.4 336.1 303L289.9 255.1L336.1 208.1C346.3 199.6 346.3 184.4 336.1 175C327.6 165.7 312.4 165.7 303 175L255.1 222.1L208.1 175C199.6 165.7 184.4 165.7 175 175C165.7 184.4 165.7 199.6 175 208.1V208.1z"
                                />
                            </svg>
                        </button>
                    </div>
                    <TWwindow :url="tweetShowUrl" class="min-w-full"></TWwindow>
                </div>
                <div v-if="youtubeWindow" class="relative w-full aspect-video mb-10 flex-none">
                    <YouTube :src="youtubeInfo.VideoID" ref="youtube" width="100%" height="100%" class="videoWindow" />
                </div>
            </template>

            <template #player>
                <div v-if="step == 3 && contentType == 'youtube'">
                    <div class="w-full flex flex-row justify-center px-5 mt-1">
                        <div class="flex flex-col">
                            <button @click="SSMinus" class="m-2">
                                <svg class="fill-gray-100 w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
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
                                <svg class="fill-gray-100 w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M192 448c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l137.4 137.4c12.5 12.5 12.5 32.75 0 45.25C208.4 444.9 200.2 448 192 448z"
                                    />
                                </svg>
                            </button>
                            <p class="text-xxs text-gray-100 mx-auto">-1s</p>
                        </div>
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
                        <div class="flex flex-col">
                            <button @click="SPlus" class="m-2">
                                <svg class="fill-gray-100 w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
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
                                <svg class="fill-gray-100 w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M246.6 233.4l-160-160c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L178.8 256l-137.4 137.4c-12.5 12.5-12.5 32.75 0 45.25C47.63 444.9 55.81 448 64 448s16.38-3.125 22.62-9.375l160-160C259.1 266.1 259.1 245.9 246.6 233.4zM438.6 233.4l-160-160c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L370.8 256l-137.4 137.4c-12.5 12.5-12.5 32.75 0 45.25C239.6 444.9 247.8 448 256 448s16.38-3.125 22.62-9.375l160-160C451.1 266.1 451.1 245.9 438.6 233.4z"
                                    />
                                </svg>
                            </button>
                            <p class="text-xxs text-gray-100 mx-auto">+10s</p>
                        </div>
                    </div>
                    <div class="w-full flex justify-center px-5 my-3">
                        <button @click="getTime" class="m-2 px-5 py-1 text-gray-900 bg-gray-300 flex flex-row rounded-md">
                            <span class="my-auto text-md mr-1">現在時刻を取得</span>
                            <svg class="fill-gray-900 w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7c-12.23-91.55-87.28-166-178.9-177.6c-136.2-17.24-250.7 97.28-233.4 233.4c11.6 91.64 86.07 166.7 177.6 178.9c53.81 7.191 104.3-6.235 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 .0003C515.9 484.7 515.9 459.3 500.3 443.7zM288 232H231.1V288c0 13.26-10.74 24-23.1 24C194.7 312 184 301.3 184 288V232H127.1C114.7 232 104 221.3 104 208s10.74-24 23.1-24H184V128c0-13.26 10.74-24 23.1-24S231.1 114.7 231.1 128v56h56C301.3 184 312 194.7 312 208S301.3 232 288 232z"
                                />
                            </svg>
                        </button>
                    </div>
                    <div class="w-full flex justify-center px-5 my-3">
                        <button @click="switchPaste" class="m-2 px-5 py-1 text-gray-900 bg-gray-300 flex flex-row rounded-md">
                            <span class="my-auto text-md mr-1">貼り付けで取得</span>
                            <svg class="fill-gray-900 w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M336 64h-53.88C268.9 26.8 233.7 0 192 0S115.1 26.8 101.9 64H48C21.5 64 0 85.48 0 112v352C0 490.5 21.5 512 48 512h288c26.5 0 48-21.48 48-48v-352C384 85.48 362.5 64 336 64zM192 64c17.67 0 32 14.33 32 32c0 17.67-14.33 32-32 32S160 113.7 160 96C160 78.33 174.3 64 192 64zM272 224h-160C103.2 224 96 216.8 96 208C96 199.2 103.2 192 112 192h160C280.8 192 288 199.2 288 208S280.8 224 272 224z"
                                />
                            </svg>
                        </button>
                    </div>
                    <div class="w-full flex flex-row justify-center px-5 my-3">
                        <button @click="InputMinus" class="m-2 flex-none">
                            <svg class="fill-gray-100 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M77.25 256l137.4-137.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-160 160c-12.5 12.5-12.5 32.75 0 45.25l160 160C175.6 444.9 183.8 448 192 448s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L77.25 256zM269.3 256l137.4-137.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-160 160c-12.5 12.5-12.5 32.75 0 45.25l160 160C367.6 444.9 375.8 448 384 448s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L269.3 256z"
                                />
                            </svg>
                        </button>
                        <div class="flex-grow my-auto h-fit">
                            <div class="my-auto">
                                <label for="inputSeek" class="sr-only text-gray-700">Number input</label>
                                <input
                                    v-model="PMInput"
                                    type="number"
                                    class="form-control block w-full px-3 py-1 text-md text-gray-700 bg-white border border-solid border-gray-300 rounded focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    id="inputSeek"
                                    placeholder="Number input"
                                />
                            </div>
                        </div>
                        <button @click="InputPlus" class="m-2 flex-none">
                            <svg class="fill-gray-100 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M246.6 233.4l-160-160c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L178.8 256l-137.4 137.4c-12.5 12.5-12.5 32.75 0 45.25C47.63 444.9 55.81 448 64 448s16.38-3.125 22.62-9.375l160-160C259.1 266.1 259.1 245.9 246.6 233.4zM438.6 233.4l-160-160c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L370.8 256l-137.4 137.4c-12.5 12.5-12.5 32.75 0 45.25C239.6 444.9 247.8 448 256 448s16.38-3.125 22.62-9.375l160-160C451.1 266.1 451.1 245.9 438.6 233.4z"
                                />
                            </svg>
                        </button>
                    </div>
                    <div class="w-full flex flex-row justify-center px-5 my-3">
                        <div class="flex-grow my-auto h-fit">
                            <div class="my-auto">
                                <label for="inputSeek" class="sr-only text-gray-700">Time input</label>
                                <input
                                    v-model="SeekInput"
                                    type="text"
                                    class="form-control block w-full px-3 py-1 text-md text-gray-700 bg-white border border-solid border-gray-300 rounded focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    id="inputSeek"
                                    placeholder="Time input"
                                />
                            </div>
                        </div>
                        <button @click="InputSeek" class="m-2 flex-none">
                            <svg class="fill-gray-100 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M52.51 440.6l171.5-142.9V214.3L52.51 71.41C31.88 54.28 0 68.66 0 96.03v319.9C0 443.3 31.88 457.7 52.51 440.6zM308.5 440.6l192-159.1c15.25-12.87 15.25-36.37 0-49.24l-192-159.1c-20.63-17.12-52.51-2.749-52.51 24.62v319.9C256 443.3 287.9 457.7 308.5 440.6z"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </template>

            <template #default>
                <div class="flex flex-col">
                    <div>
                        <h2 class="sr-only">Steps</h2>

                        <div
                            v-if="contentType == 'youtube'"
                            class="relative after:inset-x-0 after:h-0.5 after:absolute after:top-1/2 after:-translate-y-1/2 after:block after:rounded-lg after:bg-gray-100"
                        >
                            <ol class="relative z-10 flex justify-between text-sm font-medium text-gray-300">
                                <li class="flex items-center p-2 bg-stone-800">
                                    <span
                                        class="w-6 h-6 text-[10px] font-bold leading-6 text-center text-white rounded-full"
                                        :class="{ 'bg-gray-100 text-gray-900': step == 1 }"
                                    >
                                        1
                                    </span>

                                    <span class="hidden sm:block sm:ml-2"> ChooseType </span>
                                </li>

                                <li class="flex items-center p-2 bg-stone-800">
                                    <span
                                        class="w-6 h-6 text-[10px] font-bold leading-6 text-center text-white rounded-full"
                                        :class="{ 'bg-gray-100 text-gray-900': step == 2 }"
                                    >
                                        2
                                    </span>

                                    <span class="hidden sm:block sm:ml-2"> AddVideo </span>
                                </li>

                                <li class="flex items-center p-2 bg-stone-800">
                                    <span
                                        class="w-6 h-6 text-[10px] font-bold leading-6 text-center text-white rounded-full"
                                        :class="{ 'bg-gray-100 text-gray-900': step == 3 }"
                                    >
                                        3
                                    </span>

                                    <span class="hidden sm:block sm:ml-2"> AddTime </span>
                                </li>

                                <li class="flex items-center p-2 bg-stone-800">
                                    <span
                                        class="w-6 h-6 text-[10px] font-bold leading-6 text-center text-white rounded-full"
                                        :class="{ 'bg-gray-100 text-gray-900': step == 4 }"
                                    >
                                        4
                                    </span>

                                    <span class="hidden sm:block sm:ml-2"> Upload </span>
                                </li>
                            </ol>
                        </div>
                        <div
                            v-else
                            class="relative after:inset-x-0 after:h-0.5 after:absolute after:top-1/2 after:-translate-y-1/2 after:block after:rounded-lg after:bg-gray-100"
                        >
                            <ol class="relative z-10 flex justify-between text-sm font-medium text-gray-300">
                                <li class="flex items-center p-2 bg-stone-800">
                                    <span
                                        class="w-6 h-6 text-[10px] font-bold leading-6 text-center text-white rounded-full"
                                        :class="{ 'bg-gray-100 text-gray-900': step == 1 }"
                                    >
                                        1
                                    </span>

                                    <span class="hidden sm:block sm:ml-2"> ChooseType </span>
                                </li>

                                <li class="flex items-center p-2 bg-stone-800">
                                    <span
                                        class="w-6 h-6 text-[10px] font-bold leading-6 text-center text-white rounded-full"
                                        :class="{ 'bg-gray-100 text-gray-900': step == 2 }"
                                    >
                                        2
                                    </span>

                                    <span class="hidden sm:block sm:ml-2"> Add </span>
                                </li>

                                <li class="flex items-center p-2 bg-stone-800">
                                    <span
                                        class="w-6 h-6 text-[10px] font-bold leading-6 text-center text-white rounded-full"
                                        :class="{ 'bg-gray-100 text-gray-900': step == 3 }"
                                    >
                                        3
                                    </span>

                                    <span class="hidden sm:block sm:ml-2"> Sort </span>
                                </li>

                                <li class="flex items-center p-2 bg-stone-800">
                                    <span
                                        class="w-6 h-6 text-[10px] font-bold leading-6 text-center text-white rounded-full"
                                        :class="{ 'bg-gray-100 text-gray-900': step == 4 }"
                                    >
                                        4
                                    </span>

                                    <span class="hidden sm:block sm:ml-2"> Upload </span>
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div v-if="step == 1" class="justify-center pt-5">
                        <div v-if="!$page.props.user" class="text-center flex flex-col justify-center">
                            <p class="text-sm text-gray-100 mt-2 mb-1 text-center mx-auto">
                                アカウントをお持ちの方はログインをしてから進んでください。
                            </p>
                            <p class="text-sm text-gray-100 mt-1 mb-2 text-center mx-auto">途中でログインを行うと編集中のデータが初期化されます。</p>
                            <Link as="button" :href="route('myLogin')" class="text-lg my-5 bg-green-700 text-gray-200 px-5 py-1 rounded-md mx-auto"
                                >ログイン・登録はこちら</Link
                            >
                        </div>
                        <div class="py-8 w-full mx-auto px-4 lg:px-16">
                            <button
                                @click="setType('youtube')"
                                class="bg-[#da1725] text-lg font-bold text-gray-50 w-full py-5 rounded-md shadow-md shadow-gray-900"
                            >
                                YouTube
                            </button>
                        </div>
                        <div class="py-8 w-full mx-auto px-4 lg:px-16">
                            <button
                                @click="setType('clip')"
                                class="bg-[#da1725] text-lg font-bold text-gray-50 w-full py-5 rounded-md shadow-md shadow-gray-900"
                            >
                                切り抜き（YouTube)
                            </button>
                        </div>
                        <div class="py-8 w-full mx-auto px-4 lg:px-16">
                            <button
                                @click="setType('twitter')"
                                class="bg-[#1da1f2] text-lg font-bold text-gray-50 w-full py-5 rounded-md shadow-md shadow-gray-900"
                            >
                                Twitter
                            </button>
                        </div>
                    </div>
                    <div v-if="step == 2" class="justify-center pt-5">
                        <template v-if="this.contentType == 'youtube'">
                            <div class="relative mt-5 lg:mt-10">
                                <label class="sr-only" for="youtube"> YouTube </label>

                                <input
                                    class="w-full py-3 pl-3 pr-12 text-sm border-2 border-gray-200 rounded"
                                    id="youtube"
                                    type="url"
                                    placeholder="https://youtu.be/"
                                    v-model="urlInput"
                                />
                            </div>
                            <div class="mr-1 ml-auto w-fit mt-5 lg:mt-10">
                                <button class="bg-[#da1725] text-lg font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="addYoutube">
                                    Add
                                </button>
                            </div>
                            <div class="mr-auto ml-1 w-fit mt-5 lg:mt-10">
                                <button class="text-gray-200 text-lg font-bold px-5 py-1 lg:py-2 rounded-md" @click="backStep(2)">Back</button>
                            </div>
                        </template>
                        <template v-if="this.contentType == 'clip'">
                            <p class="text-sm text-gray-100 mt-2 mb-1 text-center mx-auto">
                                いくつでも追加できます。登録順は次の画面で変更することができます。
                            </p>
                            <p class="text-sm text-gray-100 mt-1 mb-2 text-center mx-auto">
                                メンバーを複数含む場合は、メンバー毎に設定してください。
                            </p>

                            <div class="relative mt-5 lg:mt-10">
                                <label class="sr-only" for="clip"> YouTube </label>

                                <input
                                    class="w-full py-3 pl-3 pr-12 text-sm border-2 border-gray-200 rounded"
                                    id="clip"
                                    type="url"
                                    placeholder="https://youtu.be/"
                                    v-model="urlInput"
                                />
                            </div>
                            <div class="mr-1 ml-auto w-fit mt-5 lg:mt-10">
                                <button class="bg-[#da1725] text-lg font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="addClip">Add</button>
                            </div>
                            <div class="flex flex-col w-full">
                                <div v-for="(clip, index) in clipArray" :key="'clip' + index">
                                    <clipForm :clip="clip" @changeMember="changeClipMember(index, $event)" @delete="clipDelete(index)"></clipForm>
                                </div>
                            </div>
                            <div class="mr-1 ml-auto w-fit mt-5 lg:mt-10">
                                <button
                                    v-if="clipArray.length != 0"
                                    class="bg-gray-200 text-lg font-bold text-gray-900 px-5 py-1 lg:py-2 rounded-md"
                                    @click="nextStep(2)"
                                >
                                    Next
                                </button>
                            </div>
                            <div class="mr-auto ml-1 w-fit mt-5 lg:mt-10">
                                <button class="text-gray-200 text-lg font-bold px-5 py-1 lg:py-2 rounded-md" @click="backStep(2)">Back</button>
                            </div>
                        </template>
                        <template v-if="this.contentType == 'twitter'">
                            <p class="text-md text-red-300 text-bold text-center my-2 mx-auto">画像または動画を含むツイートのみ対応しています。</p>
                            <p class="text-sm text-gray-100 mt-2 text-center mb-1 mx-auto">
                                いくつでも追加できます。登録順は次の画面で変更することができます。
                            </p>
                            <p class="text-sm text-gray-100 mt-1 text-center mb-2 mx-auto">
                                メンバーを複数含む場合は、メンバー毎に設定してください。
                            </p>
                            <div class="relative mt-5 lg:mt-10">
                                <label class="sr-only" for="twitter"> Twitter </label>

                                <input
                                    class="w-full py-3 pl-3 pr-12 text-sm border-2 border-gray-200 rounded"
                                    id="twitter"
                                    type="url"
                                    placeholder="https://twitter.com/"
                                    v-model="urlInput"
                                />
                            </div>
                            <div class="mr-1 ml-auto w-fit mt-5 lg:mt-10">
                                <button class="bg-[#1da1f2] text-lg font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="addTweet">
                                    Add
                                </button>
                            </div>
                            <div class="flex flex-col w-full">
                                <div v-for="(twitter, index) in tweetArray" :key="'twitter' + index">
                                    <twForm
                                        :twitter="twitter"
                                        :error="errorTWArray[index]"
                                        @update:twitterMember="changeTwitterMember(index, $event)"
                                        @update:twitterCategory="changeTwitterCategory(index, $event)"
                                        @update:twitterTitle="changeTwitterTitle(index, $event)"
                                        @delete="tweetDelete(index)"
                                        @check="tweetCheck(index)"
                                    ></twForm>
                                </div>
                            </div>
                            <div class="mr-1 ml-auto w-fit mt-5 lg:mt-10">
                                <p v-if="errorTWArray.includes(true)" class="text-lg font-bold text-red-300 px-5 py-1 lg:py-2">
                                    タイトルが入力されていないデータがあります。
                                </p>
                                <button v-else class="bg-gray-200 text-lg font-bold text-gray-900 px-5 py-1 lg:py-2 rounded-md" @click="nextStep(2)">
                                    一括登録
                                </button>
                            </div>
                            <div class="mr-auto ml-1 w-fit mt-5 lg:mt-10">
                                <button class="text-gray-200 text-lg font-bold px-5 py-1 lg:py-2 rounded-md" @click="backStep(2)">Back</button>
                            </div>
                        </template>
                    </div>
                    <div v-if="step == 3" class="justify-center pt-5">
                        <template v-if="this.contentType == 'youtube'">
                            <AccordionPanel class="mb-4" :default="false">
                                <template v-slot:title>
                                    <span class="font-semibold text-xl text-gray-300">画面説明</span>
                                </template>
                                <template v-slot:content>
                                    <div class="flex flex-col justify-items-center">
                                        <p class="text-xxs lg:text-sm text-gray-200 mt-16 mb-2 text-center">現在時刻を取得し、追加します。</p>
                                        <div class="w-full flex justify-center px-5 my-3">
                                            <button @click="getTime" class="m-2 px-5 py-1 text-gray-900 bg-gray-300 flex flex-row rounded-md">
                                                <span class="my-auto text-md mr-1">現在時刻を取得</span>
                                                <svg class="fill-gray-900 w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                    <path
                                                        d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7c-12.23-91.55-87.28-166-178.9-177.6c-136.2-17.24-250.7 97.28-233.4 233.4c11.6 91.64 86.07 166.7 177.6 178.9c53.81 7.191 104.3-6.235 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 .0003C515.9 484.7 515.9 459.3 500.3 443.7zM288 232H231.1V288c0 13.26-10.74 24-23.1 24C194.7 312 184 301.3 184 288V232H127.1C114.7 232 104 221.3 104 208s10.74-24 23.1-24H184V128c0-13.26 10.74-24 23.1-24S231.1 114.7 231.1 128v56h56C301.3 184 312 194.7 312 208S301.3 232 288 232z"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-xxs lg:text-sm text-gray-200 mt-16 mb-2 text-center">
                                            suk○スタンプなど外部で取得されたデータから追加します。専用の画面が開きます。
                                        </p>
                                        <div class="w-full flex justify-center px-5 my-3">
                                            <button @click="switchPaste" class="m-2 px-5 py-1 text-gray-900 bg-gray-300 flex flex-row rounded-md">
                                                <span class="my-auto text-md mr-1">貼り付けで取得</span>
                                                <svg class="fill-gray-900 w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                    <path
                                                        d="M336 64h-53.88C268.9 26.8 233.7 0 192 0S115.1 26.8 101.9 64H48C21.5 64 0 85.48 0 112v352C0 490.5 21.5 512 48 512h288c26.5 0 48-21.48 48-48v-352C384 85.48 362.5 64 336 64zM192 64c17.67 0 32 14.33 32 32c0 17.67-14.33 32-32 32S160 113.7 160 96C160 78.33 174.3 64 192 64zM272 224h-160C103.2 224 96 216.8 96 208C96 199.2 103.2 192 112 192h160C280.8 192 288 199.2 288 208S280.8 224 272 224z"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-xxs lg:text-sm text-gray-200 mt-16 mb-2 text-center">入力された秒数分、前後に移動します。</p>
                                        <div class="w-fit flex flex-row justify-center px-5 mx-auto my-3">
                                            <button @click="InputMinus" class="m-2 flex-none">
                                                <svg class="fill-gray-100 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                    <path
                                                        d="M77.25 256l137.4-137.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-160 160c-12.5 12.5-12.5 32.75 0 45.25l160 160C175.6 444.9 183.8 448 192 448s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L77.25 256zM269.3 256l137.4-137.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-160 160c-12.5 12.5-12.5 32.75 0 45.25l160 160C367.6 444.9 375.8 448 384 448s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L269.3 256z"
                                                    />
                                                </svg>
                                            </button>
                                            <div class="flex-grow my-auto h-fit">
                                                <div class="my-auto">
                                                    <label for="inputSeek" class="sr-only text-gray-700">Number input</label>
                                                    <input
                                                        v-model="PMInput"
                                                        type="number"
                                                        class="form-control block w-full px-3 py-1 text-md text-gray-700 bg-white border border-solid border-gray-300 rounded focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                                        id="inputSeek"
                                                        placeholder="Number input"
                                                    />
                                                </div>
                                            </div>
                                            <button @click="InputPlus" class="m-2 flex-none">
                                                <svg class="fill-gray-100 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                    <path
                                                        d="M246.6 233.4l-160-160c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L178.8 256l-137.4 137.4c-12.5 12.5-12.5 32.75 0 45.25C47.63 444.9 55.81 448 64 448s16.38-3.125 22.62-9.375l160-160C259.1 266.1 259.1 245.9 246.6 233.4zM438.6 233.4l-160-160c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L370.8 256l-137.4 137.4c-12.5 12.5-12.5 32.75 0 45.25C239.6 444.9 247.8 448 256 448s16.38-3.125 22.62-9.375l160-160C451.1 266.1 451.1 245.9 438.6 233.4z"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-xxs lg:text-sm text-gray-200 mt-16 mb-2 text-center">
                                            入力された時刻までジャンプします。全角入力でも自動変換されます。
                                        </p>
                                        <div class="w-fit flex flex-row justify-center mx-auto px-5 my-3">
                                            <div class="flex-grow my-auto h-fit">
                                                <div class="my-auto">
                                                    <label for="inputSeek" class="sr-only text-gray-700">Time input</label>
                                                    <input
                                                        v-model="SeekInput"
                                                        type="text"
                                                        class="form-control block w-full px-3 py-1 text-md text-gray-700 bg-white border border-solid border-gray-300 rounded focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                                        id="inputSeek"
                                                        placeholder="Time input"
                                                    />
                                                </div>
                                            </div>
                                            <button @click="InputSeek" class="m-2 flex-none">
                                                <svg class="fill-gray-100 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                    <path
                                                        d="M52.51 440.6l171.5-142.9V214.3L52.51 71.41C31.88 54.28 0 68.66 0 96.03v319.9C0 443.3 31.88 457.7 52.51 440.6zM308.5 440.6l192-159.1c15.25-12.87 15.25-36.37 0-49.24l-192-159.1c-20.63-17.12-52.51-2.749-52.51 24.62v319.9C256 443.3 287.9 457.7 308.5 440.6z"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-xxs lg:text-sm text-gray-200 mt-16 mb-2 text-center">
                                            DBに登録される時刻です。手入力されると自動で時間順に並び替えされます。
                                        </p>
                                        <p class="text-xxs lg:text-sm text-gray-200 my-2 mx-auto text-center flex flex-row">
                                            <svg class="fill-red-400 w-6 h-6 mx-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path
                                                    d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM176 168V344C176 352.7 180.7 360.7 188.3 364.9C195.8 369.2 205.1 369 212.5 364.5L356.5 276.5C363.6 272.1 368 264.4 368 256C368 247.6 363.6 239.9 356.5 235.5L212.5 147.5C205.1 142.1 195.8 142.8 188.3 147.1C180.7 151.3 176 159.3 176 168V168z"
                                                />
                                            </svg>
                                            ボタンでその時刻までジャンプし、確認することができます。
                                        </p>
                                        <div class="flex flex-row justify-center">
                                            <div class="flex-grow max-w-xs">
                                                <label for="YTtime" class="form-label text-gray-700 sr-only">Time input</label>
                                                <input
                                                    type="time"
                                                    step="1"
                                                    class="form-control block w-full px-3 py-1.5 text-sm text-gray-700 bg-white border border-solid border-gray-300 rounded m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                                    id="YTtime"
                                                    placeholder="Time"
                                                />
                                            </div>
                                            <button class="mx-2 bg-transparent">
                                                <svg class="fill-red-400 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                    <path
                                                        d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM176 168V344C176 352.7 180.7 360.7 188.3 364.9C195.8 369.2 205.1 369 212.5 364.5L356.5 276.5C363.6 272.1 368 264.4 368 256C368 247.6 363.6 239.9 356.5 235.5L212.5 147.5C205.1 142.1 195.8 142.8 188.3 147.1C180.7 151.3 176 159.3 176 168V168z"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-xxs lg:text-sm text-gray-200 mt-16 mb-2 text-center">
                                            スタート時刻かエンド時刻か切り替えます。明るい緑色のとき、スタート時刻として扱われます。
                                        </p>
                                        <p class="text-xxs lg:text-sm text-gray-200 my-2 text-center">
                                            エンド時刻は任意ですが設定して頂けますと幸いです。設定がない場合動画の最後まで再生されます。
                                        </p>
                                        <button class="bg-transparent my-auto flex flex-row justify-end justify-items-center mx-auto">
                                            <svg class="w-6 h-6 mx-2 my-auto fill-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path
                                                    d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"
                                                />
                                            </svg>
                                            <p class="text-gray-200 my-auto">スタートタイム</p>
                                        </button>
                                        <p class="text-xxs lg:text-sm text-gray-200 mt-16 mb-2 text-center">
                                            データベースに登録するか切り替えます。明るい緑色のとき、データベースに登録されます。
                                        </p>
                                        <p class="text-xxs lg:text-sm text-gray-200 my-2 text-center">
                                            タイムスタンプのみに使用したい、または既に登録したデータの場合オフにしてください。
                                        </p>
                                        <button class="my-2 bg-transparent my-1 mx-auto flex flex-row justify-end justify-items-center">
                                            <svg class="w-6 h-6 mx-2 my-auto fill-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path
                                                    d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"
                                                />
                                            </svg>
                                            <p class="text-gray-200 my-auto">DBに追加</p>
                                        </button>
                                    </div>
                                </template>
                            </AccordionPanel>
                            <div class="mr-1 ml-auto w-fit mt-5 lg:mt-10">
                                <p v-if="errorYTArray.includes(true)" class="text-lg font-bold text-red-300 px-5 py-1 lg:py-2">
                                    タイトルが入力されていないデータがあります。
                                </p>
                                <button v-else class="bg-gray-200 text-lg font-bold text-gray-900 px-5 py-1 lg:py-2 rounded-md" @click="nextStep(3)">
                                    一括登録
                                </button>
                            </div>
                            <div class="mr-1 ml-auto w-fit mt-5 lg:mt-10">
                                <button
                                    class="bg-gray-200 mr-1 ml-auto text-lg font-bold text-gray-900 px-5 py-1 lg:py-2 rounded-md"
                                    @click="TimeStamp = true"
                                >
                                    タイムスタンプを出力
                                </button>
                            </div>
                            <template v-if="isPaste == true">
                                <div class="flex flex-col text-center">
                                    <p class="text-sm text-gray-200">右側に時刻を含む文字列をペーストしてください。</p>
                                    <p class="text-sm text-gray-200">一行ずつ一つのデータとして変換されます。</p>
                                    <p class="text-sm text-gray-200">時刻とタイトルの間はスペースを開けてください。</p>
                                    <p class="text-sm text-gray-200">全角半角問わず、suk○スタンプにも対応しています。</p>
                                    <div class="flex flex-row pb-4">
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
                                    <button
                                        @click="PasteToTime"
                                        class="text-md w-fit mx-auto py-3 px-6 my-3 bg-gray-200 text-gray-900 text-md rounded-md"
                                    >
                                        変換
                                    </button>
                                </div>
                            </template>
                            <template v-if="TimeStamp == true">
                                <div class="flex flex-col text-center my-5">
                                    <div class="text-center p-5 rounded-md border border-gray-300" id="target">
                                        <ul
                                            style="list-style-type: none"
                                            class="text-center"
                                            v-for="(time, index) in youtubeASC"
                                            :key="'time' + index"
                                        >
                                            <li v-if="youtubeASC[index].isStart == true" class="text-gray-300">
                                                {{ youtubeASC[index].time }}　{{ youtubeASC[index].title }} <span style="display: none">\n</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <button
                                        @click="CopyStamp"
                                        class="text-md w-fit mx-auto py-3 px-6 my-3 bg-gray-200 text-gray-900 text-md rounded-md"
                                    >
                                        コピー
                                    </button>
                                    <p v-if="pasteComplete" class="text-sm text-green-300 mx-auto">コピーしました！</p>
                                    <button
                                        @click="TimeStamp = false"
                                        class="text-sm w-fit mx-auto py-3 px-6 my-3 bg-gray-200 text-gray-900 text-md rounded-md"
                                    >
                                        閉じる
                                    </button>
                                </div>
                            </template>
                            <div
                                class="w-full flex flex-col px-5 my-2 border py-2 rounded-md"
                                v-for="(youtube, index) in youtubeArray"
                                :key="'youtube' + index"
                                :class="errorYTArray[index] == true ? 'errorBorder' : ''"
                            >
                                <div class="flex flex-row justify-between my-1">
                                    <div class="flex flex-row justify-center">
                                        <div class="flex-grow max-w-xs">
                                            <label for="YTtime" class="form-label text-gray-700 sr-only">Time input</label>
                                            <input
                                                @change="changeTime(index)"
                                                v-model="youtubeArray[index].time"
                                                type="time"
                                                step="1"
                                                class="form-control block w-full px-3 py-1.5 text-sm text-gray-700 bg-white border border-solid border-gray-300 rounded m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                                id="YTtime"
                                                placeholder="Time"
                                            />
                                        </div>
                                        <button @click="PlayAt(youtubeArray[index].time)" class="mx-2 bg-transparent">
                                            <svg class="fill-red-400 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path
                                                    d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM176 168V344C176 352.7 180.7 360.7 188.3 364.9C195.8 369.2 205.1 369 212.5 364.5L356.5 276.5C363.6 272.1 368 264.4 368 256C368 247.6 363.6 239.9 356.5 235.5L212.5 147.5C205.1 142.1 195.8 142.8 188.3 147.1C180.7 151.3 176 159.3 176 168V168z"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                    <button
                                        v-show="youtubeIsStart[index + 1] == true && index != Number(youtubeIsStart.length - 1)"
                                        class="bg-transparent my-auto flex flex-row justify-end justify-items-center mr-5"
                                        @click="editIsStart(index)"
                                    >
                                        <svg
                                            :class="youtubeIsStart[index] ? 'fill-green-500' : 'fill-green-900'"
                                            class="w-6 h-6 mx-2 my-auto"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 512 512"
                                        >
                                            <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                            <path
                                                d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"
                                            />
                                        </svg>
                                        <p class="text-gray-200 my-auto">スタートタイム</p>
                                    </button>
                                </div>
                                <div v-if="youtubeIsStart[index] == true">
                                    <div class="w-full my-1">
                                        <label for="YTTitle" class="form-label text-gray-700 sr-only">Title input</label>
                                        <input
                                            v-model="youtubeTitle[index]"
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
                                                        @change="editMember(index)"
                                                        v-model="youtubeMember[index]"
                                                    >
                                                        <option
                                                            v-for="member in $page.props.setting.member"
                                                            :key="'member' + member.id"
                                                            :value="member.id"
                                                        >
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
                                                        @change="editCate(index)"
                                                        v-model="youtubeCate[index]"
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
                                </div>
                                <button
                                    v-show="youtubeIsStart[index] == true"
                                    class="my-2 bg-transparent my-1 mr-5 ml-auto flex flex-row justify-end justify-items-center"
                                    @click="editSwitch(index)"
                                >
                                    <svg
                                        :class="youtubeSwitch[index] ? 'fill-green-500' : 'fill-green-900'"
                                        class="w-6 h-6 mx-2 my-auto"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512"
                                    >
                                        <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"
                                        />
                                    </svg>
                                    <p class="text-gray-200 my-auto">DBに追加</p>
                                </button>
                                <button
                                    class="my-2 bg-transparent my-1 mr-5 ml-auto flex flex-row justify-end justify-items-center"
                                    @click="youtubeDelete(index)"
                                >
                                    <svg class="w-4 h-4 mx-2 my-auto fill-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM111.1 208V432C111.1 440.8 119.2 448 127.1 448C136.8 448 143.1 440.8 143.1 432V208C143.1 199.2 136.8 192 127.1 192C119.2 192 111.1 199.2 111.1 208zM207.1 208V432C207.1 440.8 215.2 448 223.1 448C232.8 448 240 440.8 240 432V208C240 199.2 232.8 192 223.1 192C215.2 192 207.1 199.2 207.1 208zM304 208V432C304 440.8 311.2 448 320 448C328.8 448 336 440.8 336 432V208C336 199.2 328.8 192 320 192C311.2 192 304 199.2 304 208z"
                                        />
                                    </svg>
                                    <p class="text-red-500 my-auto text-sm">削除</p>
                                </button>
                            </div>
                        </template>
                        <template v-if="this.contentType == 'clip'">
                            <p class="text-sm text-gray-100 mt-2 mb-1 text-center mx-auto">ドラッグで登録順を並び替えることができます。</p>
                            <p class="text-sm text-gray-100 my-1 text-center mx-auto">上から順にデータベースに登録されます。</p>
                            <p class="text-sm text-gray-100 mt-1 mb-2 text-center mx-auto">登録データを変更したい場合はBackで戻ってください。</p>
                            <div class="relative mt-5 lg:mt-10">
                                <div class="mr-1 ml-auto w-fit mt-5 lg:mt-10">
                                    <button class="bg-gray-200 text-lg font-bold text-gray-900 px-5 py-1 lg:py-2 rounded-md" @click="nextStep(3)">
                                        Next
                                    </button>
                                </div>
                                <draggable v-model="clipArray" item-key="id" @start="drag = true" @update="dragClip" @end="drag = false">
                                    <template #item="{ element }">
                                        <clipLabel :element="element"></clipLabel>
                                    </template>
                                </draggable>
                            </div>
                            <div class="mr-auto ml-1 w-fit mt-5 lg:mt-10">
                                <button class="text-gray-200 text-lg font-bold px-5 py-1 lg:py-2 rounded-md" @click="backStep(3)">Back</button>
                            </div>
                        </template>
                        <template v-if="this.contentType == 'twitter'">
                            <p class="text-sm text-gray-100 mt-2 mb-1 text-center mx-auto">ドラッグで登録順を並び替えることができます。</p>
                            <p class="text-sm text-gray-100 my-1 text-center mx-auto">上から順にデータベースに登録されます。</p>
                            <p class="text-sm text-gray-100 mt-1 mb-2 text-center mx-auto">登録データを変更したい場合はBackで戻ってください。</p>
                            <div class="relative mt-5 lg:mt-10">
                                <div class="mr-1 ml-auto w-fit mt-5 lg:mt-10">
                                    <button class="bg-gray-200 text-lg font-bold text-gray-900 px-5 py-1 lg:py-2 rounded-md" @click="nextStep(3)">
                                        Next
                                    </button>
                                </div>
                                <draggable v-model="tweetArray" item-key="id" @start="drag = true" @update="dragClip" @end="drag = false">
                                    <template #item="{ element }">
                                        <twLabel :element="element" @check="tweetCheckEmit($event)"></twLabel>
                                    </template>
                                </draggable>
                            </div>
                            <div class="mr-auto ml-1 w-fit mt-5 lg:mt-10">
                                <button class="text-gray-200 text-lg font-bold px-5 py-1 lg:py-2 rounded-md" @click="backStep(3)">Back</button>
                            </div>
                        </template>
                    </div>
                    <div v-if="step == 4" class="justify-center pt-5">
                        <div v-if="$page.props.user" class="relative mt-5 lg:mt-10">
                            <p class="text-lg text-gray-100 my-2">アップロードボタンを押して送信してください。</p>
                        </div>
                        <div v-else class="relative mt-5 lg:mt-10">
                            <p class="text-lg text-gray-100 my-2">ハンドルネームを設定してください。削除申請時の照合に使用します。</p>
                            <label class="sr-only" for="HandleName"> HandleName </label>

                            <input
                                class="w-full py-3 pl-3 pr-12 text-sm border-2 border-gray-200 rounded"
                                id="HandleName"
                                type="text"
                                placeholder="HN"
                                v-model="createrHN"
                            />
                        </div>
                        <template v-if="this.contentType == 'youtube'">
                            <div class="mx-auto ml-auto w-fit mt-5 lg:mt-10">
                                <button class="bg-green-500 text-2xl font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="postYoutube">
                                    Update
                                </button>
                            </div>
                        </template>
                        <template v-if="this.contentType == 'clip'">
                            <div class="mx-auto ml-auto w-fit mt-5 lg:mt-10">
                                <button class="bg-green-500 text-2xl font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="postClip">
                                    Update
                                </button>
                            </div>
                        </template>
                        <template v-if="this.contentType == 'twitter'">
                            <div class="mx-auto ml-auto w-fit mt-5 lg:mt-10">
                                <button class="bg-green-500 text-2xl font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="postTweet">
                                    Update
                                </button>
                            </div>
                        </template>
                        <div class="flex flex-row justify-center">
                            <svg
                                v-if="loading"
                                class="animate-spin h-8 w-8 ml-0 mr-3 fill-green-400"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"
                            >
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M304 48C304 74.51 282.5 96 256 96C229.5 96 208 74.51 208 48C208 21.49 229.5 0 256 0C282.5 0 304 21.49 304 48zM304 464C304 490.5 282.5 512 256 512C229.5 512 208 490.5 208 464C208 437.5 229.5 416 256 416C282.5 416 304 437.5 304 464zM0 256C0 229.5 21.49 208 48 208C74.51 208 96 229.5 96 256C96 282.5 74.51 304 48 304C21.49 304 0 282.5 0 256zM512 256C512 282.5 490.5 304 464 304C437.5 304 416 282.5 416 256C416 229.5 437.5 208 464 208C490.5 208 512 229.5 512 256zM74.98 437C56.23 418.3 56.23 387.9 74.98 369.1C93.73 350.4 124.1 350.4 142.9 369.1C161.6 387.9 161.6 418.3 142.9 437C124.1 455.8 93.73 455.8 74.98 437V437zM142.9 142.9C124.1 161.6 93.73 161.6 74.98 142.9C56.24 124.1 56.24 93.73 74.98 74.98C93.73 56.23 124.1 56.23 142.9 74.98C161.6 93.73 161.6 124.1 142.9 142.9zM369.1 369.1C387.9 350.4 418.3 350.4 437 369.1C455.8 387.9 455.8 418.3 437 437C418.3 455.8 387.9 455.8 369.1 437C350.4 418.3 350.4 387.9 369.1 369.1V369.1z"
                                />
                            </svg>
                            <p v-if="loading" class="my-3 text-2xl text-green-400">送信中</p>
                            <p v-if="complete" class="my-3 text-2xl text-green-400">完了しました！ご協力ありがとうございます！</p>
                            <p v-if="sendError" class="my-3 text-2xl text-red-400">
                                エラーが発生しました。内容を確認し、時間を数十秒おいて再度登録してください。
                            </p>
                        </div>
                        <div class="mr-auto ml-1 w-fit mt-5 lg:mt-10">
                            <button class="text-gray-200 text-lg font-bold px-5 py-1 lg:py-2 rounded-md" @click="backStep(4)">Back</button>
                        </div>
                    </div>
                </div>
            </template>
        </app-layout>
    </div>
</template>

<script>
import { defineComponent } from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import { Head, Link } from "@inertiajs/inertia-vue3"
import draggable from "vuedraggable"
import clipLabel from "../components/clipLabel"
import clipForm from "../components/clipForm"
import twForm from "../components/twForm"
import twLabel from "../components/twLabel"
import TWwindow from "../components/TWwindow.vue"
import AccordionPanel from "../components/AccordionPanel"
import YouTube from "vue3-youtube"

export default defineComponent({
    data() {
        return {
            isPaste: false,
            TimeStamp: false,
            SeekInput: "5:04",
            PMInput: 15,
            step: 1,
            contentType: "",
            urlInput: "",
            YTurl: "",
            Tweeturl: "",
            youtubeInfo: [],
            clipArray: [],
            clipMember: [],
            tweetForm: [],
            tweetArray: [],
            youtubeArray: new Array(),
            youtubeForm: new Object(),
            youtubeIsStart: new Array(),
            youtubeTitle: new Array(),
            youtubeCate: new Array(),
            youtubeMember: new Array(),
            youtubeSwitch: new Array(),
            PastedTime: "",
            sendArray: [],
            tweetWindow: false,
            youtubeWindow: false,
            tweetShowUrl: "",
            createID: "",
            params: {
                id: "",
                key: "AIzaSyCv9gZE-50Vj3fVj1dgk0IPv0O1MoDsiHI",
                part: "snippet",
            },
            example: "4:31:16\n32:00\n1：4：07\n１:０９:０８\n2:01:01 テスト\n2:40:00　テスト全角\n3:00:05　テスト　複数",
            createrHN: "",
            playStatus: false,
            errorTWArray: new Array(),
            errorYTArray: new Array(),
            loading: false,
            complete: false,
            sendError: false,
            pasteComplete: false,
        }
    },
    methods: {
        nextStep(n) {
            this.step = n + 1
            if (n == 2 && this.contentType == "clip") {
                if (this.clipArray.length == 1) {
                    this.step = 4
                }
            }
            if (n == 2 && this.contentType == "twittter") {
                if (this.tweetArray.length == 1) {
                    this.step = 4
                }
            }
        },
        backStep(n) {
            if (n == 2) {
                this.contentType = ""
                this.urlInput = ""
                this.clipArray = []
                this.clipMember = []
                this.tweetArray = []
                this.youtubeInfo = []
            }
            if (n == 4) {
                this.loading = false
                this.complete = false
                this.sendError = false
            }
            this.step = n - 1
        },
        setType(type) {
            this.contentType = type
            this.step = 2
        },
        addYoutube() {
            this.YTurl = this.urlInput
            let isShort = this.YTurl.indexOf("watch")
            if (isShort != -1) {
                let WhereS = this.YTurl.indexOf("=") + 1
                let WhereTime = this.YTurl.indexOf("&t")
                if (WhereTime != -1) {
                    this.createID = this.YTurl.slice(WhereS, WhereTime)
                } else {
                    this.createID = this.YTurl.slice(WhereS)
                }
            } else {
                let WhereDomain = this.YTurl.indexOf("youtu.be/") + 9
                let WhereTime = this.YTurl.indexOf("?t=")
                if (WhereTime != -1) {
                    this.createID = this.YTurl.slice(WhereDomain, WhereTime)
                } else {
                    this.createID = this.YTurl.slice(WhereDomain)
                }
            }
            if (this.createID != "") {
                this.params.id = this.createID
                let self = this
                axios
                    .get("https://www.googleapis.com/youtube/v3/videos", {
                        params: this.params,
                    })
                    .then(function (res) {
                        self.results = res.data.items[0].snippet

                        self.youtubeInfo.VideoID = self.createID
                        self.youtubeInfo.title = self.results.title
                        self.youtubeInfo.date = self.results.publishedAt
                        self.youtubeInfo.channnel = self.results.channelId
                        self.youtubeInfo.thumbnail = self.results.thumbnails.default.url
                        self.youtubeInfo.member_id = 1
                        self.step = 3
                        self.youtubeWindow = true
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            }
        },
        addClip() {
            this.YTurl = this.urlInput
            let isShort = this.YTurl.indexOf("watch")
            if (isShort != -1) {
                let WhereS = this.YTurl.indexOf("=") + 1
                let WhereTime = this.YTurl.indexOf("&t")
                if (WhereTime != -1) {
                    this.createID = this.YTurl.slice(WhereS, WhereTime)
                } else {
                    this.createID = this.YTurl.slice(WhereS)
                }
            } else {
                let WhereDomain = this.YTurl.indexOf("youtu.be/") + 9
                let WhereTime = this.YTurl.indexOf("?t=")
                if (WhereTime != -1) {
                    this.createID = this.YTurl.slice(WhereDomain, WhereTime)
                } else {
                    this.createID = this.YTurl.slice(WhereDomain)
                }
            }
            if (this.createID != "") {
                this.params.id = this.createID
                let self = this
                axios
                    .get("https://www.googleapis.com/youtube/v3/videos", {
                        params: this.params,
                    })
                    .then(function (res) {
                        self.results = res.data.items[0].snippet
                        let clipForm = []

                        clipForm.VideoID = self.createID
                        clipForm.title = self.results.title
                        clipForm.date = self.results.publishedAt
                        clipForm.channel = self.results.channelTitle
                        clipForm.thumbnail = self.results.thumbnails.default.url
                        clipForm.member_id = 1
                        clipForm.id = Math.floor(Math.random() * 101)
                        self.clipMember.push(1)
                        self.clipArray.push(clipForm)
                        console.log(self.clipArray)
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            }
        },
        dragClip() {
            this.clipMember = this.clipArray.map((item) => item["member_id"])
        },
        changeClipMember(index, event) {
            this.clipArray[index]["member_id"] = event
        },
        clipDelete(index) {
            this.clipArray.splice(index, 1)
            this.clipMember.splice(index, 1)
        },
        addTweet() {
            this.Tweeturl = this.urlInput
            let whereStatus = this.Tweeturl.indexOf("/status/") + 8
            let whereEnd = this.Tweeturl.indexOf("?s=")
            //this.createTweet = this.Tweeturl.slice(whereStatus, 16)
            this.createTweet = this.Tweeturl.slice(whereStatus, whereEnd)

            this.tweetForm = []

            this.tweetForm.id = Math.floor(Math.random() * 101)
            this.tweetForm.twitterURL = this.Tweeturl
            this.tweetForm.twitterId = this.createTweet
            this.tweetForm.title = ""
            this.tweetForm.cate_id = 5
            this.tweetForm.member_id = 1
            this.tweetArray.push(this.tweetForm)
            this.errorTWArray.push(true)
        },
        changeTwitterMember(index, event) {
            this.tweetArray[index]["member_id"] = event
        },
        changeTwitterCategory(index, event) {
            this.tweetArray[index]["cate_id"] = event
        },
        changeTwitterTitle(index, event) {
            this.tweetArray[index]["title"] = event
            if (this.tweetArray[index].title == "") {
                this.errorTWArray[index] = true
            } else {
                this.errorTWArray[index] = false
            }
        },
        tweetDelete(index) {
            this.tweetArray.splice(index, 1)
            this.errorTWArray.splice(index, 1)
        },
        tweetCheck(index) {
            this.tweetWindow = false
            this.tweetShowUrl = this.tweetArray[index].twitterURL
            this.$nextTick(function () {
                this.tweetWindow = true
            })
        },
        tweetCheckEmit(event) {
            this.tweetShowUrl = event
            this.tweetWindow = true
        },
        postTweet() {
            this.complete = false
            if (this.$page.props.user == null) {
                this.sendArray = []
                for (let i = 0; i < Object.keys(this.tweetArray).length; i++) {
                    this.sendArray.push({
                        title: this.tweetArray[i].title,
                        date: new Date(),
                        status: 0,
                        cate_id: this.tweetArray[i].cate_id,
                        member_id: this.tweetArray[i].member_id,
                        twitter: this.tweetArray[i].twitterURL,
                        twitterId: this.tweetArray[i].twitterId,
                        tweetUrl: "",
                        tweetType: "",
                        created_at: new Date(),
                        updated_at: new Date(),
                        createrHN: this.createrHN,
                    })
                }
            } else {
                this.sendArray = []
                for (let i = 0; i < Object.keys(this.tweetArray).length; i++) {
                    this.sendArray.push({
                        title: this.tweetArray[i].title,
                        date: new Date(),
                        status: 0,
                        cate_id: this.tweetArray[i].cate_id,
                        member_id: this.tweetArray[i].member_id,
                        twitter: this.tweetArray[i].twitterURL,
                        twitterId: this.tweetArray[i].twitterId,
                        tweetUrl: "",
                        tweetType: "",
                        created_at: new Date(),
                        updated_at: new Date(),
                        createrHN: this.$page.props.user.name,
                    })
                }
            }
            console.log(this.sendArray)
            let self = this
            this.loading = true
            axios({
                method: "post",
                url: "/api/add/twitter",
                dataType: "json",
                data: this.sendArray,
            })
                .then((response) => {
                    console.log(response)
                    self.loading = false
                    self.complete = true
                })
                .catch((error) => {
                    self.loading = false
                    self.sendError = false
                    console.log(error)
                })
        },
        postClip() {
            this.complete = false
            if (this.$page.props.user == null) {
                this.sendArray = []
                for (let i = 0; i < Object.keys(this.clipArray).length; i++) {
                    this.sendArray.push({
                        title: this.clipArray[i].title,
                        date: this.clipArray[i].date,
                        VideoID: this.clipArray[i].VideoID,
                        start: 0,
                        end: 0,
                        status: 0,
                        cate_id: 4,
                        member_id: this.clipArray[i].member_id,
                        created_at: new Date(),
                        updated_at: new Date(),
                        createrHN: this.createrHN,
                    })
                }
            } else {
                this.sendArray = []
                for (let i = 0; i < Object.keys(this.clipArray).length; i++) {
                    this.sendArray.push({
                        title: this.clipArray[i].title,
                        date: this.clipArray[i].date,
                        VideoID: this.clipArray[i].VideoID,
                        start: 0,
                        end: 0,
                        status: 0,
                        cate_id: 4,
                        member_id: this.clipArray[i].member_id,
                        created_at: new Date(),
                        updated_at: new Date(),
                        createrHN: this.$page.props.user.name,
                    })
                }
            }
            let self = this
            this.loading = true
            axios({
                method: "post",
                url: "/api/add/clip",
                dataType: "json",
                data: this.sendArray,
            })
                .then((response) => {
                    console.log(response)
                    self.loading = false
                    self.complete = true
                })
                .catch((error) => {
                    self.loading = false
                    self.sendError = false
                    console.log(error)
                })
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
        InputMinus() {
            let PMtemp = this.PMInput.replace(/[０-９]/g, function (s) {
                return String.fromCharCode(s.charCodeAt(0) - 0xfee0)
            })
            let time = this.YTplayer.getCurrentTime()
            this.YTplayer.seekTo(time - Number(PMtemp), true)
        },
        InputPlus() {
            let PMtemp = this.PMInput.replace(/[０-９]/g, function (s) {
                return String.fromCharCode(s.charCodeAt(0) - 0xfee0)
            })
            let time = this.YTplayer.getCurrentTime()
            this.YTplayer.seekTo(time + Number(PMtemp), true)
        },
        InputSeek() {
            let InputTimeTemp = this.SeekInput.replace(/[０-９：]/g, function (s) {
                return String.fromCharCode(s.charCodeAt(0) - 0xfee0)
            })
            let SetHMS = InputTimeTemp.split(":")
            if (SetHMS.length == 2) {
                let TimeM = SetHMS[0]
                let TimeS = SetHMS[1]
                let SeekTime = Number(TimeM) * 60 + Number(TimeS)
                this.YTplayer.seekTo(SeekTime, true)
            } else {
                let TimeH = SetHMS[0]
                let TimeM = SetHMS[1]
                let TimeS = SetHMS[2]
                let SeekTime = Number(TimeH) * 3600 + Number(TimeM) * 60 + Number(TimeS)
                this.YTplayer.seekTo(SeekTime, true)
            }
        },
        PlayAt(input) {
            let InputTimeTemp = input
            let SetHMS = InputTimeTemp.split(":")
            console.log(SetHMS)
            if (SetHMS.length == 2) {
                let TimeM = SetHMS[0]
                let TimeS = SetHMS[1]
                let SeekTime = Number(TimeM) * 60 + Number(TimeS)
                this.YTplayer.seekTo(SeekTime, true)
            } else {
                let TimeH = SetHMS[0]
                let TimeM = SetHMS[1]
                let TimeS = SetHMS[2]
                let SeekTime = Number(TimeH) * 3600 + Number(TimeM) * 60 + Number(TimeS)
                this.YTplayer.seekTo(SeekTime, true)
            }
        },
        getTime() {
            this.isPaste = false
            this.youtubeForm = []
            let time = this.YTplayer.getCurrentTime()
            let INTtime = Math.floor(time)
            let hour = ("00" + Math.floor(INTtime / 3600)).slice(-2)
            let min = ("00" + Math.floor((INTtime % 3600) / 60)).slice(-2)
            let rem = ("00" + (INTtime % 60)).slice(-2)
            let HMStime = hour + ":" + min + ":" + rem

            this.youtubeForm.rowTime = Math.floor(time)
            this.youtubeForm.time = HMStime
            this.youtubeForm.title = ""
            this.youtubeForm.isStart = true
            this.youtubeForm.member_id = 1
            this.youtubeForm.cate_id = 1
            this.youtubeForm.switch = true
            this.youtubeForm.error = true

            this.youtubeArray.push(this.youtubeForm)
            this.youtubeArray.sort((a, b) => b.rowTime - a.rowTime)
            console.log(this.youtubeArray)

            this.youtubeIsStart = this.youtubeArray.map((item) => item["isStart"])
            this.youtubeCate = this.youtubeArray.map((item) => item["cate_id"])
            this.youtubeTitle = this.youtubeArray.map((item) => item["title"])
            this.youtubeMember = this.youtubeArray.map((item) => item["member_id"])
            this.youtubeSwitch = this.youtubeArray.map((item) => item["switch"])
            this.errorYTArray = this.youtubeArray.map((item) => item["error"])
        },
        PasteToTime() {
            let HalfPaste = this.PastedTime.replace(/[０-９：]/g, function (s) {
                return String.fromCharCode(s.charCodeAt(0) - 0xfee0)
            })
            let PastedArrayRaw = HalfPaste.split("\n")
            let InputPaste = PastedArrayRaw.filter((v) => v)
            let numTemp = InputPaste.length

            for (let i = 0; i < numTemp; i++) {
                this.youtubeForm = []
                let pasteArray = InputPaste[i].replace(/　/g, " ")
                let timeArray = 0
                if (pasteArray.includes(" ")) {
                    let pasteSplit = pasteArray.split(" ")
                    let pasteSplitClean = pasteSplit.filter((v) => v)

                    timeArray = pasteSplitClean[0].split(":")

                    if (pasteSplitClean.length == 2) {
                        this.youtubeForm.title = pasteSplitClean[1]
                    } else {
                        this.youtubeForm.title = pasteSplitClean[1]
                        for (let k = 1; k < pasteSplitClean.length - 1; k++) {
                            this.youtubeForm.title = this.youtubeForm.title + " " + pasteSplitClean[k]
                        }
                    }
                    this.youtubeForm.error = false
                } else {
                    timeArray = InputPaste[i].split(":")
                    this.youtubeForm.title = ""
                    this.youtubeForm.error = true
                }

                if (timeArray.length == 2) {
                    let TimeM = timeArray[0]
                    let TimeS = timeArray[1]
                    let timeSecond = Number(TimeM) * 60 + Number(TimeS)

                    let min = ("00" + TimeM).slice(-2)
                    let rem = ("00" + TimeS).slice(-2)
                    let HMStime = "00:" + min + ":" + rem

                    this.youtubeForm.rowTime = timeSecond
                    this.youtubeForm.time = HMStime
                    this.youtubeForm.isStart = true
                    this.youtubeForm.member_id = 1
                    this.youtubeForm.cate_id = 1
                    this.youtubeForm.switch = true

                    this.youtubeArray.push(this.youtubeForm)
                } else {
                    let TimeH = timeArray[0]
                    let TimeM = timeArray[1]
                    let TimeS = timeArray[2]
                    let timeSecond = Number(TimeH) * 3600 + Number(TimeM) * 60 + Number(TimeS)

                    let hour = ("00" + TimeH).slice(-2)
                    let min = ("00" + TimeM).slice(-2)
                    let rem = ("00" + TimeS).slice(-2)
                    let HMStime = hour + ":" + min + ":" + rem

                    this.youtubeForm.rowTime = timeSecond
                    this.youtubeForm.time = HMStime
                    this.youtubeForm.isStart = true
                    this.youtubeForm.member_id = 1
                    this.youtubeForm.cate_id = 1
                    this.youtubeForm.switch = true

                    this.youtubeArray.push(this.youtubeForm)
                }

                this.youtubeArray.sort((a, b) => b.rowTime - a.rowTime)

                this.youtubeIsStart = this.youtubeArray.map((item) => item["isStart"])
                this.youtubeCate = this.youtubeArray.map((item) => item["cate_id"])
                this.youtubeTitle = this.youtubeArray.map((item) => item["title"])
                this.youtubeMember = this.youtubeArray.map((item) => item["member_id"])
                this.youtubeSwitch = this.youtubeArray.map((item) => item["switch"])
                this.errorYTArray = this.youtubeArray.map((item) => item["error"])
            }
        },
        switchPaste() {
            this.isPaste = !this.isPaste
            this.$nextTick(function () {
                document.getElementById("MainContent").scrollIntoView(true)
            })
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
        changeTime(index) {
            let changeRowTIme = this.youtubeArray[index].time
            let timeArray = changeRowTIme.split(":")
            if (timeArray.length == 2) {
                let TimeM = timeArray[0]
                let TimeS = timeArray[1]
                let timeSecond = Number(TimeM) * 60 + Number(TimeS)
                this.youtubeArray[index].rowTime = timeSecond
            } else {
                let TimeH = timeArray[0]
                let TimeM = timeArray[1]
                let TimeS = timeArray[2]
                let timeSecond = Number(TimeH) * 3600 + Number(TimeM) * 60 + Number(TimeS)
                this.youtubeArray[index].rowTime = timeSecond
            }

            this.youtubeArray.sort((a, b) => b.rowTime - a.rowTime)

            this.youtubeIsStart = this.youtubeArray.map((item) => item["isStart"])
            this.youtubeCate = this.youtubeArray.map((item) => item["cate_id"])
            this.youtubeTitle = this.youtubeArray.map((item) => item["title"])
            this.youtubeMember = this.youtubeArray.map((item) => item["member_id"])
            this.youtubeSwitch = this.youtubeArray.map((item) => item["switch"])
            this.errorYTArray = this.youtubeArray.map((item) => item["error"])
        },
        editIsStart(index) {
            this.youtubeIsStart[index] = !this.youtubeIsStart[index]
            this.youtubeArray[index]["isStart"] = this.youtubeIsStart[index]
            this.checkYTerror(index)
        },
        editTitle(index) {
            this.youtubeArray[index]["title"] = this.youtubeTitle[index]
            this.checkYTerror(index)
        },
        editCate(index) {
            this.youtubeArray[index]["cate_id"] = this.youtubeCate[index]
        },
        editMember(index) {
            this.youtubeArray[index]["member_id"] = this.youtubeMember[index]
        },
        editSwitch(index) {
            this.youtubeSwitch[index] = !this.youtubeSwitch[index]
            this.youtubeArray[index]["switch"] = this.youtubeSwitch[index]
            this.checkYTerror(index)
        },
        youtubeDelete(index) {
            this.youtubeArray.splice(index, 1)
            this.youtubeIsStart.splice(index, 1)
            this.youtubeTitle.splice(index, 1)
            this.youtubeCate.splice(index, 1)
            this.youtubeMember.splice(index, 1)
            this.youtubeSwitch.splice(index, 1)
            this.errorYTArray.splice(index, 1)
        },
        postYoutube() {
            this.complete = false
            if (this.$page.props.user == null) {
                this.sendArray = []
                let SendLength = 0
                for (let i = 0; i < Object.keys(this.youtubeASC).length; i++) {
                    if (this.youtubeASC[i].isStart == true) {
                        if (this.youtubeASC[i].switch == true) {
                            this.sendArray.push({
                                title: this.youtubeASC[i].title,
                                date: this.youtubeInfo.date,
                                VideoID: this.youtubeInfo.VideoID,
                                start: this.youtubeASC[i].rowTime,
                                end: 0,
                                status: 0,
                                cate_id: this.youtubeASC[i].cate_id,
                                member_id: this.youtubeASC[i].member_id,
                                created_at: new Date(),
                                updated_at: new Date(),
                                createrHN: this.createrHN,
                            })
                            SendLength = SendLength++
                        }
                    } else {
                        if (this.youtubeASC[i - 1].isStart == false) {
                            this.sendArray.push({
                                title: this.youtubeASC[i].title,
                                date: this.youtubeInfo.date,
                                VideoID: this.youtubeInfo.VideoID,
                                start: this.youtubeASC[i].rowTime,
                                end: 0,
                                status: 0,
                                cate_id: this.youtubeASC[i].cate_id,
                                member_id: this.youtubeASC[i].member_id,
                                created_at: new Date(),
                                updated_at: new Date(),
                                createrHN: this.createrHN,
                            })
                            SendLength = SendLength++
                        } else {
                            this.sendArray[SendLength].end = this.youtubeASC[i].rowTime
                        }
                    }
                }
            } else {
                this.sendArray = []
                let SendLength = 0
                for (let i = 0; i < Object.keys(this.youtubeASC).length; i++) {
                    if (this.youtubeASC[i].isStart == true) {
                        if (this.youtubeASC[i].switch == true) {
                            this.sendArray.push({
                                title: this.youtubeASC[i].title,
                                date: this.youtubeInfo.date,
                                VideoID: this.youtubeInfo.VideoID,
                                start: this.youtubeASC[i].rowTime,
                                end: 0,
                                status: 0,
                                cate_id: this.youtubeASC[i].cate_id,
                                member_id: this.youtubeASC[i].member_id,
                                created_at: new Date(),
                                updated_at: new Date(),
                                createrHN: this.$page.props.user.name,
                            })
                            SendLength = SendLength++
                        }
                    } else {
                        if (this.youtubeASC[i - 1].isStart == false) {
                            this.sendArray.push({
                                title: this.youtubeASC[i].title,
                                date: this.youtubeInfo.date,
                                VideoID: this.youtubeInfo.VideoID,
                                start: this.youtubeASC[i].rowTime,
                                end: 0,
                                status: 0,
                                cate_id: this.youtubeASC[i].cate_id,
                                member_id: this.youtubeASC[i].member_id,
                                created_at: new Date(),
                                updated_at: new Date(),
                                createrHN: this.createrHN,
                            })
                            SendLength = SendLength++
                        } else {
                            this.sendArray[SendLength].end = this.youtubeASC[i].rowTime
                        }
                    }
                }
            }
            let self = this
            this.loading = true
            axios({
                method: "post",
                url: "/api/add/youtube",
                dataType: "json",
                data: this.sendArray,
            })
                .then((response) => {
                    console.log(response)
                    self.loading = false
                    self.complete = true
                })
                .catch((error) => {
                    self.loading = false
                    self.sendError = false
                    console.log(error)
                })
        },
        checkYTerror(index) {
            if (this.youtubeTitle[index] == "" && this.youtubeIsStart[index] == true && this.youtubeSwitch[index] == true) {
                this.errorYTArray[index] = true
                this.youtubeArray[index]["error"] = true
            } else {
                this.errorYTArray[index] = false
                this.youtubeArray[index]["error"] = false
            }
        },
    },
    components: {
        AppLayout,
        Link,
        draggable,
        clipLabel,
        clipForm,
        twForm,
        twLabel,
        TWwindow,
        YouTube,
        Head,
        AccordionPanel,
    },
    computed: {
        YTplayer() {
            return this.$refs.youtube
        },
        youtubeASC() {
            return this.youtubeArray.slice().reverse()
        },
    },
})
</script>
<style scoped>
.emitTitle {
    color: #f59e0b;
    text-shadow: 0px 0px 20px #f59e0b;
}
.videoWindow {
    width: 100% !important;
    height: 100% !important;
    margin: 0;
}
.errorBorder {
    border-color: #ef4444;
}
</style>
