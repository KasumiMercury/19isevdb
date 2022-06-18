<template>
    <div class="select-none p-2 shadow-md shadow-zinc-900 rounded-md flex flex-col">
        <div class="flex flex-row pb-3 lg:pb-0 lg:h-20 bg-stone-800">
            <div class="cursor-pointer grow text-white overflow-hidden p-1 flex" @click="$emit('tweetShow')">
                <div v-if="photoMode == false && tweetType == 'photo'" class="flex items-center mr-2">
                    <img class="rounded object-contain mx-0 w-12 h-12 md:w-16 md:h-16" :src="tweeturl[0]" :alt="title" loading="lazy" />
                </div>
                <p class="text-xxs lg:text-sm max-h-full textOmit grow">{{ title }}</p>
            </div>
            <div class="min-h-full flex-none bg-stone-800">
                <div v-if="isLike" @click="$emit('disLikeEmit')" class="flex items-center cursor-pointer w-8 h-8">
                    <div class="w-2 h-2 mx-auto rounded-full bg-amber-500 box-emit text-amber-400 shadow-amber-400"></div>
                </div>
                <div v-else @click="$emit('addLikeEmit')" class="flex items-center cursor-pointer w-8 h-8">
                    <div class="w-2 h-2 mx-auto rounded-full bg-gray-500"></div>
                </div>
            </div>
        </div>
        <div @click="$emit('tweetShow')" class="h-px bg-gradient-to-r from-stone-900 via-[#1da1f2] to-stone-900"></div>

        <div class="flex flex-row mb-0 mt-1">
            <div class="cursor-pointer pl-3 text-white flex flex-row" @click="$emit('tweetShow')">
                <p class="text-xxs lg:text-sm">{{ moment(date, "YYYY/MM/DD") }}</p>
                <p v-if="memberName" class="text-xxs lg:text-sm mr-auto ml-5">{{ memberName }}</p>
            </div>
            <div class="cursor-pointer p-1 lg:p-2 w-6 h-6 lg:w-8 lg:h-8 mx-2 mr-0 ml-auto bg-[#1da1f2] rounded-sm" @click="$emit('tweetShow')">
                <svg v-if="tweetType == 'photo'" class="fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M447.1 32h-384C28.64 32-.0091 60.65-.0091 96v320c0 35.35 28.65 64 63.1 64h384c35.35 0 64-28.65 64-64V96C511.1 60.65 483.3 32 447.1 32zM111.1 96c26.51 0 48 21.49 48 48S138.5 192 111.1 192s-48-21.49-48-48S85.48 96 111.1 96zM446.1 407.6C443.3 412.8 437.9 416 432 416H82.01c-6.021 0-11.53-3.379-14.26-8.75c-2.73-5.367-2.215-11.81 1.334-16.68l70-96C142.1 290.4 146.9 288 152 288s9.916 2.441 12.93 6.574l32.46 44.51l93.3-139.1C293.7 194.7 298.7 192 304 192s10.35 2.672 13.31 7.125l128 192C448.6 396 448.9 402.3 446.1 407.6z"
                    />
                </svg>
                <svg v-else class="fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"
                    />
                </svg>
            </div>
        </div>
        <div class="mt-1" v-if="photoMode">
            <img
                @click="$emit('tweetShow')"
                class="cursor-pointer object-contain max-h-72 mx-auto rounded"
                :src="tweeturl[0]"
                :alt="title"
                loading="”lazy”"
            />
        </div>
    </div>
</template>

<script>
import moment from "moment"

export default {
    props: ["title", "date", "isLike", "tweetType", "photoMode", "photoUrl", "memberName"],
    data() {
        return {
            tweeturl: new Array(),
        }
    },
    created() {
        if (this.tweetType == "photo") {
            this.tweeturl = this.photoUrl.split(",")
        }
    },
    methods: {
        moment(date, format) {
            return moment(date).format(format)
        },
    },
}
</script>
<style>
.textOmit {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
