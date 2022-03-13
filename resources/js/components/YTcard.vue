<template>
    <div class="p-2 shadow-md shadow-zinc-900 rounded-md flex flex-col">
        <div v-if="status == 1">
            <div class="flex flex-row pb-3 lg:pb-0 lg:h-20 bg-stone-800">
                <Link as="div" :href="url" class="grow cursor-pointer text-white p-1 overflow-hidden">
                    <p class="text-xxs lg:text-sm max-h-full textOmit">{{ title }}</p>
                </Link>
                <div class="min-h-full flex-none bg-stone-800">
                    <div v-if="isLike" @click="$emit('disLikeEmit')" class="flex items-center cursor-pointer w-8 h-8">
                        <div class="w-2 h-2 mx-auto my-auto rounded-full bg-amber-500 box-emit text-amber-400 shadow-amber-400"></div>
                    </div>
                    <div v-else @click="$emit('addLikeEmit')" class="flex items-center cursor-pointer w-8 h-8">
                        <div class="w-2 h-2 mx-auto my-auto rounded-full bg-gray-500"></div>
                    </div>
                </div>
            </div>
            <Link as="div" class="h-px bg-gradient-to-r from-stone-900 via-green-500 to-stone-900"></Link>
        </div>
        <div v-else-if="status == 2">
            <div class="flex flex-row pb-3 lg:pb-0 lg:h-20 bg-stone-800">
                <Link as="div" :href="url" class="grow cursor-pointer text-gray-50 p-1 overflow-hidden">
                    <p class="text-xxs lg:text-sm max-h-full textOmit">{{ title }}</p>
                </Link>
                <div class="min-h-full flex-none bg-stone-800">
                    <div v-if="isLike" @click="$emit('disLikeEmit')" class="flex items-center cursor-pointer w-8 h-8">
                        <div class="w-2 h-2 mx-auto my-auto rounded-full bg-amber-500 box-emit text-amber-400 shadow-amber-400"></div>
                    </div>
                    <div v-else @click="$emit('addLikeEmit')" class="flex items-center cursor-pointer w-8 h-8">
                        <div class="w-2 h-2 mx-auto my-auto rounded-full bg-gray-500"></div>
                    </div>
                </div>
            </div>
            <Link as="div" class="h-px bg-gradient-to-r from-stone-900 via-zinc-900 to-stone-900"></Link>
        </div>
        <div v-else>
            <div class="flex flex-row pb-3 lg:pb-0 lg:h-20 bg-stone-800">
                <Link as="div" :href="url" class="grow cursor-pointer text-white p-1 overflow-hidden">
                    <p class="text-xxs lg:text-sm max-h-full textOmit">{{ title }}</p>
                </Link>
                <div class="min-h-full flex-none bg-stone-800">
                    <div v-if="isLike" @click="$emit('disLikeEmit')" class="flex items-center cursor-pointer w-8 h-8">
                        <div class="w-2 h-2 mx-auto my-auto rounded-full bg-amber-500 box-emit text-amber-400 shadow-amber-400"></div>
                    </div>
                    <div v-else @click="$emit('addLikeEmit')" class="flex items-center cursor-pointer w-8 h-8">
                        <div class="w-2 h-2 mx-auto my-auto rounded-full bg-gray-500"></div>
                    </div>
                </div>
            </div>
            <Link as="div" class="h-px bg-gradient-to-r from-stone-900 via-rose-500 to-stone-900"></Link>
        </div>

        <Link as="div" :href="url" class="cursor-pointer flex flex-row mb-0 mt-1">
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
                class="p-1 w-8 h-8 mx-2 mr-0 ml-auto rounded-sm bg-gradient-radial from-[#d96870] via-[#d9646d] to-[#da1725] shadow-md shadow-[#DA1725]/80 border-[#d96870] border-x-[#e35d67] border"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-white" viewBox="0 0 576 512">
                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"
                    />
                </svg>
            </div>
            <div
                v-else-if="status == 1"
                class="p-1 w-8 h-8 mx-2 mr-0 ml-auto rounded-sm bg-gradient-radial from-green-400 via-green-600 to-green-800 shadow-md shadow-green-800/80 border-green-500 border-x-green-600 border"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-white" viewBox="0 0 576 512">
                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"
                    />
                </svg>
            </div>
            <div v-else class="p-1 w-8 h-8 mx-2 mr-0 ml-auto bg-gray-900 rounded-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-gray-500" viewBox="0 0 576 512">
                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"
                    />
                </svg>
            </div>
        </Link>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3"
import moment from "moment"

export default {
    methods: {
        moment(date, format) {
            return moment(date).format(format)
        },
    },
    props: ["title", "id", "date", "status", "url", "isLike"],
    components: {
        Link,
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
