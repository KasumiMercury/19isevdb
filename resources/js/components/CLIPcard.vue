<template>
    <div class="p-2 shadow-md shadow-zinc-900 rounded-md flex flex-col">
        <div v-if="status == 1">
            <div class="flex flex-row pb-3 lg:pb-0 lg:h-20 bg-stone-800">
                <a :href="url" target="_blank" class="grow cursor-pointer text-white p-1 overflow-hidden">
                    <p class="text-xxs lg:text-sm max-h-full textOmit">{{ title }}</p>
                </a>
                <div class="min-h-full flex-none bg-stone-800">
                    <div v-if="isLike" @click="$emit('disLikeEmit')" class="flex items-center cursor-pointer w-8 h-8">
                        <div class="w-2 h-2 mx-auto my-auto rounded-full bg-amber-500 box-emit text-amber-400 shadow-amber-400"></div>
                    </div>
                    <div v-else @click="$emit('addLikeEmit')" class="flex items-center cursor-pointer w-8 h-8">
                        <div class="w-2 h-2 mx-auto my-auto rounded-full bg-gray-500"></div>
                    </div>
                </div>
            </div>
            <div @click="jump" target="_blank" class="h-px bg-gradient-to-r from-stone-900 via-green-500 to-stone-900"></div>
        </div>
        <div v-else-if="status == 2">
            <div class="flex flex-row pb-3 lg:pb-0 lg:h-20 bg-stone-800">
                <a target="_blank" class="grow cursor-pointer text-gray-50 p-1 overflow-hidden">
                    <p class="text-xxs lg:text-sm max-h-full textOmit">{{ title }}</p>
                </a>
                <div class="min-h-full flex-none bg-stone-800">
                    <div v-if="isLike" @click="$emit('disLikeEmit')" class="flex items-center cursor-pointer w-8 h-8">
                        <div class="w-2 h-2 mx-auto my-auto rounded-full bg-amber-500 box-emit text-amber-400 shadow-amber-400"></div>
                    </div>
                    <div v-else @click="$emit('addLikeEmit')" class="flex items-center cursor-pointer w-8 h-8">
                        <div class="w-2 h-2 mx-auto my-auto rounded-full bg-gray-500"></div>
                    </div>
                </div>
            </div>
            <div target="_blank" class="h-px bg-gradient-to-r from-stone-900 via-zinc-900 to-stone-900"></div>
        </div>
        <div v-else>
            <div class="flex flex-row pb-3 lg:pb-0 lg:h-20 bg-stone-800">
                <a :href="url" target="_blank" class="grow cursor-pointer text-white p-1 overflow-hidden">
                    <p class="text-xxs lg:text-sm max-h-full textOmit">{{ title }}</p>
                </a>
                <div class="min-h-full flex-none bg-stone-800">
                    <div v-if="isLike" @click="$emit('disLikeEmit')" class="flex items-center cursor-pointer w-8 h-8">
                        <div class="w-2 h-2 mx-auto my-auto rounded-full bg-amber-500 box-emit text-amber-400 shadow-amber-400"></div>
                    </div>
                    <div v-else @click="$emit('addLikeEmit')" class="flex items-center cursor-pointer w-8 h-8">
                        <div class="w-2 h-2 mx-auto my-auto rounded-full bg-gray-500"></div>
                    </div>
                </div>
            </div>
            <div @click="jump" class="h-px bg-gradient-to-r from-stone-900 via-rose-500 to-stone-900"></div>
        </div>

        <div @click="jump" target="_blank" class="cursor-pointer flex flex-row mb-0 mt-1">
            <template v-if="status == 2">
                <div class="pl-3 text-gray-500">
                    <p class="text-xxs lg:text-sm">{{ moment(date, "YYYY/MM/DD") }}</p>
                </div>
            </template>
            <template v-else>
                <div class="pl-3 text-white">
                    <p class="text-xxs lg:text-sm">{{ moment(date, "YYYY/MM/DD") }}</p>
                </div>
            </template>

            <div
                v-if="status == 0"
                class="p-1 lg:p-2 w-6 h-6 lg:w-8 lg:h-8 mx-2 mr-0 ml-auto rounded-sm bg-gradient-radial from-[#d96870] via-[#d9646d] to-[#da1725] shadow-md shadow-[#DA1725]/80 border-[#d96870] border-x-[#e35d67] border"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-white" viewBox="0 0 576 512">
                    <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M256 64C256 46.33 270.3 32 288 32H415.1C415.1 32 415.1 32 415.1 32C420.3 32 424.5 32.86 428.2 34.43C431.1 35.98 435.5 38.27 438.6 41.3C438.6 41.35 438.6 41.4 438.7 41.44C444.9 47.66 447.1 55.78 448 63.9C448 63.94 448 63.97 448 64V192C448 209.7 433.7 224 416 224C398.3 224 384 209.7 384 192V141.3L214.6 310.6C202.1 323.1 181.9 323.1 169.4 310.6C156.9 298.1 156.9 277.9 169.4 265.4L338.7 96H288C270.3 96 256 81.67 256 64V64zM0 128C0 92.65 28.65 64 64 64H160C177.7 64 192 78.33 192 96C192 113.7 177.7 128 160 128H64V416H352V320C352 302.3 366.3 288 384 288C401.7 288 416 302.3 416 320V416C416 451.3 387.3 480 352 480H64C28.65 480 0 451.3 0 416V128z"
                    />
                </svg>
            </div>
            <div
                v-else-if="status == 1"
                class="p-1 lg:p-2 w-6 h-6 lg:w-8 lg:h-8 mx-2 mr-0 ml-auto rounded-sm bg-gradient-radial from-green-400 via-green-600 to-green-800 shadow-md shadow-green-800/80 border-green-500 border-x-green-600 border"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-white" viewBox="0 0 576 512">
                    <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M256 64C256 46.33 270.3 32 288 32H415.1C415.1 32 415.1 32 415.1 32C420.3 32 424.5 32.86 428.2 34.43C431.1 35.98 435.5 38.27 438.6 41.3C438.6 41.35 438.6 41.4 438.7 41.44C444.9 47.66 447.1 55.78 448 63.9C448 63.94 448 63.97 448 64V192C448 209.7 433.7 224 416 224C398.3 224 384 209.7 384 192V141.3L214.6 310.6C202.1 323.1 181.9 323.1 169.4 310.6C156.9 298.1 156.9 277.9 169.4 265.4L338.7 96H288C270.3 96 256 81.67 256 64V64zM0 128C0 92.65 28.65 64 64 64H160C177.7 64 192 78.33 192 96C192 113.7 177.7 128 160 128H64V416H352V320C352 302.3 366.3 288 384 288C401.7 288 416 302.3 416 320V416C416 451.3 387.3 480 352 480H64C28.65 480 0 451.3 0 416V128z"
                    />
                </svg>
            </div>
            <div v-else class="p-1 lg:p-2 w-6 h-6 lg:w-8 lg:h-8 mx-2 mr-0 ml-auto bg-gray-900 rounded-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-gray-500" viewBox="0 0 576 512">
                    <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M256 64C256 46.33 270.3 32 288 32H415.1C415.1 32 415.1 32 415.1 32C420.3 32 424.5 32.86 428.2 34.43C431.1 35.98 435.5 38.27 438.6 41.3C438.6 41.35 438.6 41.4 438.7 41.44C444.9 47.66 447.1 55.78 448 63.9C448 63.94 448 63.97 448 64V192C448 209.7 433.7 224 416 224C398.3 224 384 209.7 384 192V141.3L214.6 310.6C202.1 323.1 181.9 323.1 169.4 310.6C156.9 298.1 156.9 277.9 169.4 265.4L338.7 96H288C270.3 96 256 81.67 256 64V64zM0 128C0 92.65 28.65 64 64 64H160C177.7 64 192 78.33 192 96C192 113.7 177.7 128 160 128H64V416H352V320C352 302.3 366.3 288 384 288C401.7 288 416 302.3 416 320V416C416 451.3 387.3 480 352 480H64C28.65 480 0 451.3 0 416V128z"
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
        jump() {
            location.href = this.url
        },
    },
    props: ["title", "id", "date", "status", "url", "isLike"],
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
