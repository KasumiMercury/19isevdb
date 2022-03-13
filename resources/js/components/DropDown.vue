<template>
    <div class="relative">
        <div
            class="cursor-pointer z-10 border-2 rounded-sm relative flex items-center focus:outline-none select-none font-Raleway font-bold min-w-full"
            :class="classSet"
            @click="open = !open"
        >
            <span class="px-0 lg:px-2 py-0.5 lg:py-2 text-xxs lg:text-xs min-w-full">
                <div class="flex justify-items-center">
                    <div class="flex-grow">
                        <div class="min-w-full flex justify-center">
                            <div>
                                <slot name="button"></slot>
                            </div>
                        </div>
                    </div>
                    <svg class="w-4 h-4 flex-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path
                            d="M4.516 7.548c.436-.446 1.043-.481 1.576 0L10 11.295l3.908-3.747c.533-.481 1.141-.446 1.574 0 .436.445.408 1.197 0 1.615-.406.418-4.695 4.502-4.695 4.502a1.095 1.095 0 0 1-1.576 0S4.924 9.581 4.516 9.163c-.409-.418-.436-1.17 0-1.615z"
                        />
                    </svg>
                </div>
            </span>
        </div>

        <!-- to close when clicked on space around it in desktop-->
        <button class="z-10 fixed inset-0 h-full w-full cursor-default focus:outline-none" v-if="open" @click="open = false" tabindex="-1"></button>
        <!--dropdown content: desktop-->
        <transition
            enter-active-class="transition-all duration-200 ease-out"
            leave-active-class="transition-all duration-750 ease-in"
            enter-class="opacity-0 scale-75"
            enter-to-class="opacity-100 scale-100"
            leave-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-75"
        >
            <div
                class="z-20 hidden md:block absolute shadow-lg border w-48 rounded py-1 px-2 text-xs mt-4 bg-stone-200 left-44"
                :class="'-top-' + topOffset"
                v-if="open"
            >
                <slot name="content"></slot>
            </div>
        </transition>

        <!--dropdown content: mobile-->
        <transition
            enter-active-class="transition-all duration-200 ease-out"
            leave-active-class="transition-all duration-750 ease-in"
            enter-class="opacity-0 scale-75"
            enter-to-class="opacity-100 scale-100"
            leave-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-75"
        >
            <div class="z-50 md:hidden fixed inset-x-0 bottom-0 bg-stone-200 w-full px-2 py-2 shadow-2xl leading-loose" v-if="open">
                <slot name="content"></slot>
            </div>
        </transition>
        <!-- to close when clicked on space around it in mobile-->
        <div class="z-40 md:hidden fixed w-full h-full inset-0 bg-gray-900 opacity-50" @click="open = false" v-if="open"></div>
    </div>
</template>

<script>
export default {
    props: ["classSet", "topOffset"],
    data() {
        return {
            open: false,
        }
    },
}
</script>
