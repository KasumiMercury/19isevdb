<template>
    <div class="select-none p-2 shadow-md shadow-zinc-900 rounded-md flex flex-col">
        <div class="flex flex-row pb-3 lg:pb-0 lg:h-20 bg-stone-800">
            <div class="cursor-pointer grow text-white overflow-hidden p-1" @click="$emit('tweetShow')">
                <p class="text-xxs lg:text-sm max-h-full textOmit">{{ title }}</p>
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
            <div class="cursor-pointer pl-3 text-white" @click="$emit('tweetShow')">
                <p class="text-sm">{{ moment(date, "YYYY/MM/DD") }}</p>
            </div>
            <div class="cursor-pointer p-1 lg:p-2 w-6 h-6 lg:w-8 lg:h-8 mx-2 mr-0 ml-auto bg-[#1da1f2] rounded-sm" @click="$emit('tweetShow')">
                <svg class="fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"
                    />
                </svg>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment"

export default {
    methods: {
        moment(date, format) {
            return moment(date).format(format)
        },
    },
    props: ["title", "date", "isLike"],
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
