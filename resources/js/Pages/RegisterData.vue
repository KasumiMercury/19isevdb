<template>
    <div>
        <Head>
            <meta name="description" content="個人Vtuberグループいせぶい非公式データベース　データ追加ページ" />
        </Head>
        <app-layout title="AddPage" :chooseCate="false" NowPage="AddPage" NowCate="NONE" :isSub="false" shareUrl="https://isevdb.net">
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
                    <YouTube :src="youtubeInfo.VideoID" ref="youtube" width="100%" height="100%" class="videoWindow" @state-change="YTstatus" />
                </div>
            </template>

            <template #default>
                <div class="flex flex-col">
                    <!-- stepper -->
                    <div class="mt-4 lg:mt-0">
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
                                        :class="{ 'bg-gray-100 text-gray-900': step == 4 }"
                                    >
                                        3
                                    </span>

                                    <span class="hidden sm:block sm:ml-2"> Upload </span>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <!-- stepper end -->

                    <!-- select dataType-->
                    <div v-if="step == 1" class="justify-center pt-5">
                        <div v-if="!$page.props.user" class="text-center flex flex-col justify-center">
                            <p class="text-xxs lg:text-sm text-gray-100 mt-2 mb-1 text-center mx-auto">
                                アカウントをお持ちの方はログインをしてから進んでください。
                            </p>
                            <p class="text-xxs lg:text-sm text-gray-100 mt-1 mb-2 text-center mx-auto">
                                途中でログインを行うと編集中のデータが初期化されます。
                            </p>
                            <Link as="button" :href="route('myLogin')" class="text-lg my-5 bg-green-700 text-gray-200 px-5 py-1 rounded-md mx-auto"
                                >ログイン・登録はこちら</Link
                            >
                        </div>
                        <p class="my-10 w-fit mx-auto text-gray-50 text-sm text-emit-lg">登録するデータの種類を選択してください</p>
                        <div class="py-4 lg:py-8 w-full mx-auto px-4 lg:px-16 my-2">
                            <Link
                                as="button"
                                href="/autoregister/clip"
                                class="border-[#da1725] border-2 text-lg font-bold text-gray-50 w-full py-5 rounded-md shadow-md shadow-gray-900"
                            >
                                切り抜きチャンネル登録
                            </Link>
                        </div>
                        <div class="mx-auto w-fit">
                            <Link href="/autoregister/collation" class="text-base text-gray-50 text-center mb-1 lg:mb-2 mx-auto">
                                自動登録照合ページはこちら
                            </Link>
                        </div>
                        <div class="py-4 lg:py-8 w-full mx-auto px-4 lg:px-16">
                            <button
                                @click="setType('youtube')"
                                class="bg-[#da1725] text-lg font-bold text-gray-50 w-full py-5 rounded-md shadow-md shadow-gray-900"
                            >
                                YouTube
                            </button>
                        </div>
                        <div class="py-4 lg:py-8 w-full mx-auto px-4 lg:px-16">
                            <button
                                @click="setType('clip')"
                                class="bg-[#da1725] text-lg font-bold text-gray-50 w-full py-5 rounded-md shadow-md shadow-gray-900"
                            >
                                切り抜き（YouTube)
                            </button>
                        </div>
                        <div class="py-4 lg:py-8 w-full mx-auto px-4 lg:px-16">
                            <button
                                @click="setType('twitter')"
                                class="bg-[#1da1f2] text-lg font-bold text-gray-50 w-full py-5 rounded-md shadow-md shadow-gray-900"
                            >
                                Twitter
                            </button>
                        </div>
                        <div class="py-4 lg:py-8 w-full mx-auto px-4 lg:px-16">
                            <button
                                @click="setType('YTclip')"
                                class="bg-[#da1725] text-lg font-bold text-gray-50 w-full py-5 rounded-md shadow-md shadow-gray-900"
                            >
                                YouTube Clip
                            </button>
                        </div>
                    </div>
                    <!-- select dataType end-->

                    <!-- step2-->
                    <div v-if="step == 2" class="justify-center pt-5">
                        <template v-if="this.contentType == 'youtube'">
                            <p class="text-xs lg:text-sm text-gray-100 mt-2 mb-1 text-center mx-auto">
                                ペーストボタンを押してクリップボードからペースト
                            </p>
                            <p class="text-xs lg:text-sm text-gray-100 my-1 text-center mx-auto">
                                または入力欄にURLを入力してAddボタンを押してください。
                            </p>
                            <p class="text-xs lg:text-sm text-gray-100 mt-1 mb-2 text-center mx-auto">
                                （ペーストボタンは初回時、ブラウザ許可が必要です。）
                            </p>

                            <p v-if="isFirefox" class="text-sm text-red-500 my-1 text-center mb-2 mx-auto">
                                Firefoxはペーストボタンを使用できません。
                            </p>

                            <p class="text-xs lg:text-sm text-red-400 mt-4 mb-1 text-center mx-auto">下にあるドロップダウンから</p>
                            <p class="text-xs lg:text-sm text-red-400 mt-1 mb-2 text-center mx-auto">メンバーの最新動画を選択することもできます。</p>

                            <div class="flex flex-row items-end mt-5 lg:mt-10 w-full">
                                <div class="relative grow">
                                    <label class="sr-only" for="youtube"> YouTube </label>

                                    <input
                                        class="w-full py-3 pl-3 pr-12 text-sm border-2 border-gray-200 rounded"
                                        id="youtube"
                                        type="url"
                                        placeholder="https://youtu.be/"
                                        v-model="urlInput"
                                    />
                                </div>
                                <div class="mx-1 w-fit" v-if="isFirefox === false">
                                    <button class="bg-gray-500 text-lg font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="paste">
                                        ペースト
                                    </button>
                                </div>
                            </div>
                            <div class="mr-1 ml-auto w-fit mt-5">
                                <button class="bg-[#da1725] text-lg font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="addYoutube">
                                    Add
                                </button>
                            </div>
                            <div class="mx-auto w-fit mt-5 lg:mt-10 text-center">
                                <p class="text-gray-50 text-xs lg:text-sm">新着動画を表示します。</p>
                                <p class="text-gray-50 text-xs lg:text-sm">下のドロップダウンでメンバーを選択してください。</p>
                                <div class="flex flex-col">
                                    <p class="mx-auto mb-1 mt-3 text-xs lg:text-sm text-gray-50">メンバーを選択してください</p>
                                    <select
                                        class="mx-auto mb-1 mt-3 w-fit form-select form-select-md appearance-none block px-8 py-1 text-xs lg:text-sm text-gray-700 bg-white border border-solid border-gray-300 rounded transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-gray-600 focus:outline-none"
                                        aria-label="member"
                                        name="member"
                                        :value="videoMember"
                                        @change="videosList($event.target.value)"
                                    >
                                        <option :value="0">Choose Member</option>
                                        <option v-for="member in $page.props.setting.member" :key="'member' + member.id" :value="member.id">
                                            {{ member.display }}
                                        </option>
                                    </select>
                                </div>
                                <div class="mt-3" v-if="showVideos">
                                    <div
                                        v-for="item in videos"
                                        :key="item.id"
                                        @click="selectVideo(item.VideoID)"
                                        class="w-full px-2 cursor-pointer border-2 border-gray-50 text-gray-50 my-4 rounded-md flex flex-col"
                                    >
                                        <div class="flex flex-row">
                                            <img
                                                :src="'https://img.youtube.com/vi/' + item.VideoID + '/default.jpg'"
                                                class="w-16 h-auto mx-2 my-1"
                                                alt=""
                                            />
                                            <p class="px-1 text-xxs lg:text-xs">{{ item.title }}</p>
                                        </div>
                                        <p class="px-1 text-xs lg:text-sm">{{ item.publishedAt }}</p>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-if="this.contentType == 'clip'">
                            <clipStep2 @nextStep="setData($event)"></clipStep2>
                        </template>
                        <template v-if="this.contentType == 'twitter'">
                            <twitterStep2 @nextStep="setData($event)" @checkTW="checkTW($event)"></twitterStep2>
                        </template>
                        <template v-if="this.contentType == 'YTclip'">
                            <ytclipStep2 @nextStep="setData($event)"></ytclipStep2>
                        </template>
                    </div>
                    <!-- step2 end-->

                    <!-- step3-->
                    <div v-if="step == 3" class="justify-center pt-5">
                        <template v-if="this.contentType == 'youtube'">
                            <AccordionPanel class="mb-4" :default="false">
                                <template v-slot:title>
                                    <span class="font-semibold text-xl text-gray-300">画面説明</span>
                                </template>
                                <template v-slot:content>
                                    <div class="flex flex-col justify-items-center py-2 border border-gray-200">
                                        <p class="text-xxs lg:text-sm text-gray-200 mt-16 mb-2 text-center">現在時刻を取得し、追加します。</p>
                                        <div class="w-full flex justify-center px-5 my-3">
                                            <button @click="getTime" class="m-2 px-5 py-1 text-gray-900 bg-gray-300 flex flex-row rounded-md">
                                                <span class="my-auto text-base mr-1">現在時刻を取得</span>
                                            </button>
                                        </div>
                                        <p class="text-xxs lg:text-sm text-gray-200 mt-16 mb-2 text-center">
                                            suk○スタンプなど外部で取得されたデータから追加します。専用の画面が開きます。
                                        </p>
                                        <div class="w-full flex justify-center px-5 my-3">
                                            <button @click="switchPaste" class="m-2 px-5 py-1 text-gray-900 bg-gray-300 flex flex-row rounded-md">
                                                <span class="my-auto text-base mr-1">貼り付けで取得</span>
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
                                                        class="form-control block w-full px-3 py-1 text-base text-gray-700 bg-white border border-solid border-gray-300 rounded focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
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
                                                        class="form-control block w-full px-3 py-1 text-base text-gray-700 bg-white border border-solid border-gray-300 rounded focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
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
                            <p class="text-gray-50 text-center text-xs lg:text-sm my-2">
                                <span class="inline-block">現在時刻を取得」や「貼り付けで取得」から</span>
                                <span class="inline-block">時間を取得してください。</span>
                            </p>
                            <p class="text-gray-50 text-center text-xs lg:text-sm my-2">
                                <span class="inline-block">「時間ウィンドウ左のハンドルをつかんで</span>
                                <span class="inline-block">点線エリアにドラッグ＆ドロップしてください。</span>
                            </p>
                            <p class="text-gray-50 text-center text-xs lg:text-sm my-2">
                                <span class="inline-block">グループはそれぞれ一つのデータとして</span>
                                <span class="inline-block">扱われます。</span>
                            </p>
                            <p class="text-gray-50 text-center text-xs lg:text-sm mt-2 mb-6">
                                <span class="inline-block">複数タイムが含まれる場合、</span>
                                <span class="inline-block"> 自動でスタート・エンド・スキップタイム</span>
                                <span class="inline-block"> として登録されます。</span>
                            </p>
                            <youtubeList
                                ref="ytlist"
                                @PlayAt="PlayAt($event)"
                                @nextStep="setData($event)"
                                @addTimeGroup="addTimeGroup($event)"
                                @stopPlay="pauseVideo()"
                                :youtubeInfo="youtubeInfo"
                            ></youtubeList>
                        </template>
                    </div>
                    <!-- step3 end-->

                    <!-- step4-->
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
                        <div class="mx-auto ml-auto w-fit mt-5 lg:mt-10">
                            <button class="bg-transparent mt-5 mb-5 mx-auto flex flex-row justify-items-center" @click="showSwitch = !showSwitch">
                                <svg
                                    :class="showSwitch ? 'fill-green-400' : 'fill-green-800'"
                                    class="w-6 h-6 mx-2 my-auto"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512"
                                >
                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"
                                    />
                                </svg>
                                <p class="text-gray-200 my-auto">登録者表示を許可</p>
                            </button>
                            <button
                                :class="createrHN != '' ? 'bg-green-500 cursor-pointer' : 'bg-gray-500 pointer-events-none cursor-not-allowed'"
                                class="mx-auto text-2xl font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md"
                                @click="postData"
                            >
                                Upload
                            </button>
                        </div>
                        <div v-if="loading" class="flex flex-row justify-center">
                            <div class="ml-0 mr-3">
                                <svg class="animate-spin h-8 w-8 fill-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M304 48C304 74.51 282.5 96 256 96C229.5 96 208 74.51 208 48C208 21.49 229.5 0 256 0C282.5 0 304 21.49 304 48zM304 464C304 490.5 282.5 512 256 512C229.5 512 208 490.5 208 464C208 437.5 229.5 416 256 416C282.5 416 304 437.5 304 464zM0 256C0 229.5 21.49 208 48 208C74.51 208 96 229.5 96 256C96 282.5 74.51 304 48 304C21.49 304 0 282.5 0 256zM512 256C512 282.5 490.5 304 464 304C437.5 304 416 282.5 416 256C416 229.5 437.5 208 464 208C490.5 208 512 229.5 512 256zM74.98 437C56.23 418.3 56.23 387.9 74.98 369.1C93.73 350.4 124.1 350.4 142.9 369.1C161.6 387.9 161.6 418.3 142.9 437C124.1 455.8 93.73 455.8 74.98 437V437zM142.9 142.9C124.1 161.6 93.73 161.6 74.98 142.9C56.24 124.1 56.24 93.73 74.98 74.98C93.73 56.23 124.1 56.23 142.9 74.98C161.6 93.73 161.6 124.1 142.9 142.9zM369.1 369.1C387.9 350.4 418.3 350.4 437 369.1C455.8 387.9 455.8 418.3 437 437C418.3 455.8 387.9 455.8 369.1 437C350.4 418.3 350.4 387.9 369.1 369.1V369.1z"
                                    />
                                </svg>
                            </div>
                            <p class="my-3 text-2xl text-green-400">送信中</p>
                        </div>
                        <div v-if="complete" class="w-fit mx-auto">
                            <p class="mt-3 text-xl text-green-400">完了しました！ご協力ありがとうございます！</p>
                            <Link as="a" href="/" class="w-fit mx-auto mt-1 mb-3 text-blue-400 underline">トップページ</Link>
                        </div>
                        <div v-if="complete && contentType == 'youtube'" class="w-fit mx-auto">
                            <p class="mt-3 text-xl text-green-400">タイムスタンプ出力は下のBackボタンで戻ってください。</p>
                            <button class="mx-auto w-fit mt-3 text-gray-200 text-lg font-bold px-5 py-1 lg:py-2 rounded-md" @click="backStep">
                                Back
                            </button>
                        </div>
                        <p v-if="sendError" class="my-3 text-2xl text-red-400">
                            エラーが発生しました。内容を確認し、時間を数十秒おいて再度登録してください。
                        </p>
                        <button
                            v-if="sendError"
                            class="mx-auto w-fit mt-5 lg:mt-10 text-gray-200 text-lg font-bold px-5 py-1 lg:py-2 rounded-md"
                            @click="backStep"
                        >
                            Back
                        </button>
                    </div>
                    <!-- step4 end-->

                    <button
                        v-if="step != 1 && step != 4"
                        class="mr-auto ml-1 w-fit mt-5 lg:mt-10 text-gray-200 text-lg font-bold px-5 py-1 lg:py-2 rounded-md"
                        @click="backStep"
                    >
                        Back
                    </button>
                </div>
                <div
                    v-if="step == 1"
                    class="m-1 border-2 bg-stone-800 border-gray-50 rounded-full fixed bottom-8 right-8 md:bottom-12 md:right-12 p-4"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="w-4 h-4 md:w-6 md:h-6 fill-white animate-bounce">
                        <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                        <path
                            d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z"
                        />
                    </svg>
                </div>

                <div v-if="step == 3 && contentType == 'youtube'" class="z-50 fixed bottom-0 right-0 w-full bg-stone-800">
                    <div class="w-full h-px goldLine m-0"></div>
                    <div class="w-fit mx-auto">
                        <div class="w-full flex flex-row justify-center items-start px-5 mt-1">
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
                        <div class="w-full flex justify-center px-5 my-3">
                            <button @click="getTime" class="m-2 px-5 py-1 text-gray-900 bg-gray-300 flex flex-row rounded-md" data-hotkey="t">
                                <span class="my-auto text-sm lg:text-base mr-1">現在時刻を取得</span>
                            </button>
                        </div>
                        <div class="mb-4">
                            <div
                                class="transition-all duration-400 overflow-hidden"
                                :class="{
                                    'max-h-fit': isOpen,
                                    'max-h-0': !isOpen,
                                }"
                            >
                                <div class="flex flex-row justify-center my-auto h-fit">
                                    <p class="text-gray-300 my-auto">補正：</p>
                                    <div class="my-auto">
                                        <label for="fixSeconds" class="sr-only text-gray-700">Number input</label>
                                        <input
                                            v-model="fixSeconds"
                                            type="number"
                                            class="form-control w-16 px-3 py-1 text-base text-gray-700 bg-white border border-solid border-gray-300 rounded focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                            id="fixSeconds"
                                            placeholder="Number input"
                                        />
                                    </div>
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
                                                class="form-control block w-full px-3 py-1 text-base text-gray-700 bg-white border border-solid border-gray-300 rounded focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
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
                                                class="form-control block w-full px-3 py-1 text-base text-gray-700 bg-white border border-solid border-gray-300 rounded focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
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
                            <button @click="isOpen = !isOpen" class="flex items-center justify-center my-2 mx-auto space-x-3 block w-full">
                                <span class="font-semibold text-sm text-gray-300">拡張操作</span>

                                <svg
                                    class="w-3 transition-all duration-200 transform stroke-gray-200"
                                    :class="{
                                        'rotate-180': isOpen,
                                        'rotate-0': !isOpen,
                                    }"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 16 10"
                                >
                                    <path d="M15 1.2l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
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
import clipStep2 from "../components/addData/clipStep2"
import twitterStep2 from "../components/addData/twitterStep2"
import ytclipStep2 from "../components/addData/ytclipStep2"
import youtubeList from "../components/addData/youtubeList"
import AccordionPanel from "../components/AccordionPanel"
import TWwindow from "../components/TWwindow.vue"
import YouTube from "vue3-youtube"
import dayjs from "dayjs"
dayjs.locale("ja")

export default defineComponent({
    data() {
        return {
            step: 1,
            contentType: "",
            tweetWindow: false,
            youtubeWindow: false,
            youtubeInfo: [],
            dataArray: [],
            urlInput: "",
            tweetShowUrl: "",
            videoMember: 0,
            showVideos: false,
            videos: [],
            params: {
                id: "",
                key: "AIzaSyCv9gZE-50Vj3fVj1dgk0IPv0O1MoDsiHI",
                part: "snippet",
            },
            playStatus: false,
            isPaste: false,
            TimeStamp: false,
            SeekInput: "5:04",
            fixSeconds: 0,
            PMInput: 15,
            sendArray: [],
            loading: false,
            complete: false,
            sendError: false,
            showSwitch: false,
            createrHN: "",
            isOpen: false,
            isFirefox: false,
        }
    },
    created() {
        if (this.$page.props.user != null) {
            this.createrHN = this.$page.props.user.name
        } else {
            if (this.$cookies.get("createrHN") != null) {
                this.createrHN = this.$cookies.get("createrHN")
            }
        }

        let agent = window.navigator.userAgent.toLowerCase()
        if (agent.indexOf("firefox") != -1) {
            this.isFirefox = true
        }
    },
    methods: {
        backStep() {
            this.step--
        },
        setType(type) {
            this.contentType = type
            this.step = 2
        },
        videosList(id) {
            let self = this
            axios
                .get("/api/get/videos/" + id)
                .then((response) => {
                    self.videoMember = id
                    self.videos = response["data"]["videos"]
                    console.log(self.videos)
                    self.$nextTick(function () {
                        self.showVideos = true
                    })
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        selectVideo(VideoID) {
            this.params.id = VideoID
            let self = this
            axios
                .get("https://www.googleapis.com/youtube/v3/videos", {
                    params: this.params,
                })
                .then(function (res) {
                    let results = res.data.items[0].snippet

                    self.youtubeInfo.VideoID = VideoID
                    self.youtubeInfo.title = results.title
                    self.youtubeInfo.date = self.format(results.publishedAt)
                    self.youtubeInfo.channnel = results.channelId
                    self.youtubeInfo.thumbnail = results.thumbnails.default.url
                    let member = self.$page.props.setting.member.find((v) => v.ChannelID == results.channelId)
                    self.youtubeInfo.member_id = member.id
                    self.step = 3
                    self.youtubeWindow = true
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        setData(e) {
            if (this.contentType == "youtube") {
                this.YTplayer.pauseVideo()
                this.youtubeWindow = false
            }
            this.dataArray = e
            console.log("setData")
            console.log(this.dataArray)
            let self = this
            if (this.$page.props.user) {
                axios
                    .get("/api/register/show/" + this.$page.props.user.id)
                    .then((response) => {
                        if (response["data"]["isShow"] == 1) {
                            self.showSwitch = true
                        } else {
                            self.showSwitch = false
                        }
                        self.step = 4
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            } else {
                this.showSwitch = 1
                this.step = 4
            }
        },
        addYoutube() {
            let createID = ""
            let isShort = this.urlInput.indexOf("watch")
            if (isShort != -1) {
                let WhereS = this.urlInput.indexOf("=") + 1
                let WhereTime = this.urlInput.indexOf("&t")
                if (WhereTime != -1) {
                    createID = this.urlInput.slice(WhereS, WhereTime)
                } else {
                    let whereQuery = this.urlInput.indexOf("&")
                    if (whereQuery != -1) {
                        createID = this.urlInput.slice(WhereS, whereQuery)
                    } else {
                        createID = this.urlInput.slice(WhereS)
                    }
                }
            } else {
                let WhereDomain = this.urlInput.indexOf("youtu.be/") + 9
                let WhereTime = this.urlInput.indexOf("?t=")
                if (WhereTime != -1) {
                    createID = this.urlInput.slice(WhereDomain, WhereTime)
                } else {
                    createID = this.urlInput.slice(WhereDomain)
                }
            }
            if (createID != "") {
                this.params.id = createID
                let self = this
                axios
                    .get("https://www.googleapis.com/youtube/v3/videos", {
                        params: this.params,
                    })
                    .then(function (res) {
                        let results = res.data.items[0].snippet

                        self.youtubeInfo.VideoID = createID
                        self.youtubeInfo.title = results.title
                        self.youtubeInfo.date = self.format(results.publishedAt)
                        self.youtubeInfo.channnel = results.channelId
                        self.youtubeInfo.thumbnail = results.thumbnails.default.url
                        let member = self.$page.props.setting.member.find((v) => v.ChannelID == results.channelId)
                        if (member) {
                            self.youtubeInfo.member_id = member.id
                        } else {
                            self.youtubeInfo.member_id = 1
                        }
                        self.step = 3
                        self.youtubeWindow = true
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            }
        },
        checkTW(e) {
            console.log(e)
            this.tweetShowUrl = e
            this.tweetWindow = true
            this.$nextTick(function () {
                document.getElementById("playerTop").scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                })
            })
        },
        YTstatus() {
            let NowStatus = this.YTplayer.getPlayerState()
            if (NowStatus == 1) {
                this.playStatus = true
            } else {
                this.playStatus = false
            }
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
            let time = this.YTplayer.getCurrentTime()
            this.YTplayer.seekTo(time - Number(this.PMInput), true)
        },
        InputPlus() {
            let time = this.YTplayer.getCurrentTime()
            this.YTplayer.seekTo(time + Number(this.PMInput), true)
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

            let time = this.YTplayer.getCurrentTime()
            let INTtime = Math.floor(time)
            if (INTtime != 0) {
                INTtime = INTtime + this.fixSeconds
            }
            let hour = ("00" + Math.floor(INTtime / 3600)).slice(-2)
            let min = ("00" + Math.floor((INTtime % 3600) / 60)).slice(-2)
            let rem = ("00" + (INTtime % 60)).slice(-2)
            let HMStime = hour + ":" + min + ":" + rem

            let timeForm = []
            timeForm.id = Math.random().toString(36).slice(-8)
            timeForm.rawTime = Math.floor(time)
            timeForm.displayTime = HMStime

            this.$refs.ytlist.addTime(timeForm)
        },
        addTimeGroup(index) {
            this.isPaste = false

            let time = this.YTplayer.getCurrentTime()
            let INTtime = Math.floor(time)
            if (INTtime != 0) {
                INTtime = INTtime + this.fixSeconds
            }
            let hour = ("00" + Math.floor(INTtime / 3600)).slice(-2)
            let min = ("00" + Math.floor((INTtime % 3600) / 60)).slice(-2)
            let rem = ("00" + (INTtime % 60)).slice(-2)
            let HMStime = hour + ":" + min + ":" + rem

            let timeForm = []
            timeForm.id = Math.random().toString(36).slice(-8)
            timeForm.rawTime = Math.floor(time)
            timeForm.displayTime = HMStime

            this.$refs.ytlist.groupPush(timeForm, index)
        },
        format(date) {
            let formated = dayjs(date).format("YYYY-MM-DD HH:mm:ss")
            return formated
        },
        postData() {
            this.$cookies.set("createrHN", this.createrHN, "1m")
            if (this.contentType == "twitter") {
                this.complete = false
                this.sendArray = []
                for (let i = 0; i < this.dataArray.length; i++) {
                    let objArray = {}
                    objArray = this.dataArray[i]
                    objArray.date = this.format(new Date())
                    objArray.created_at = this.format(new Date())
                    objArray.updated_at = this.format(new Date())
                    objArray.createrHN = this.createrHN
                    this.sendArray.push(objArray)
                }
                console.log("sendArray")
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
                        self.dataArray = []
                    })
                    .catch((error) => {
                        self.loading = false
                        self.sendError = false
                        console.log(error)
                    })
            } else {
                let isShow = 1
                if (this.showSwitch) {
                    isShow = 1
                } else {
                    isShow = 0
                }
                this.complete = false
                this.sendArray = []
                for (let i = 0; i < this.dataArray.length; i++) {
                    let objArray = {}
                    objArray = this.dataArray[i]
                    objArray.created_at = this.format(new Date())
                    objArray.updated_at = this.format(new Date())
                    objArray.createrHN = this.createrHN
                    objArray.isShow = isShow
                    this.sendArray.push(objArray)
                }
                console.log("sendArray")
                console.log(this.sendArray)
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
                        self.dataArray = []
                    })
                    .catch((error) => {
                        self.loading = false
                        self.sendError = true
                        console.log(error)
                    })
            }
        },
        paste() {
            if (navigator.clipboard) {
                let self = this
                navigator.clipboard.readText().then(function (text) {
                    self.urlInput = text
                    self.addYoutube()
                })
            }
        },
    },
    components: {
        AppLayout,
        Link,
        TWwindow,
        YouTube,
        Head,
        clipStep2,
        twitterStep2,
        ytclipStep2,
        youtubeList,
        AccordionPanel,
    },
    computed: {
        YTplayer() {
            return this.$refs.youtube
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
.goldLine {
    background: linear-gradient(45deg, #662f09 0%, #e49d2e 45%, #f2da97 70%, #e7c177 85%, #94591e 90% 100%);
    background: -moz-linear-gradient(45deg, #662f09 0%, #e49d2e 45%, #f2da97 70%, #e7c177 85%, #94591e 90% 100%);
    background: -webkit-linear-gradient(45deg, #662f09 0%, #e49d2e 45%, #f2da97 70%, #e7c177 85%, #94591e 90% 100%);
}
</style>
