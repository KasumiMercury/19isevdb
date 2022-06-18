<template>
    <div class="w-fit px-10 py-10 mb-5 bg-stone-900 flex flex-col shadow-inner shadow-gray-900 rounded select-none">
        <div
            @click="back()"
            class="w-56 mx-auto h-14 my-1 text-center border-2 rounded-sm font-Raleway font-bold bg-zinc-900 border-amber-500 shadow-inner shadow-[#000000]"
        >
            <p class="mx-auto py-1 pl-8 text-3xl tracking-[1.5em] text-amber-500 text-emit-md">{{ displayNum }}</p>
        </div>
        <div class="flex flex-row items-end">
            <div class="flex flex-col">
                <div v-for="n in 3" :key="n" class="flex flex-row w-fit">
                    <div
                        v-for="p in 3"
                        :key="p"
                        @click="inputNum((n - 1) * 3 + p)"
                        class="w-10 h-10 m-1 text-center cursor-pointer border-2 rounded-sm focus:outline-none font-Raleway font-bold text-orange-200 bg-gradient-radial from-amber-500 via-amber-700 to-amber-800 shadow-lg shadow-amber-800/80 border-amber-500 border-x-amber-600"
                    >
                        <p class="py-1 text-md">{{ (n - 1) * 3 + p }}</p>
                    </div>
                </div>
                <div
                    @click="inputNum(0)"
                    class="grow h-10 m-1 text-center cursor-pointer border-2 rounded-sm focus:outline-none font-Raleway font-bold text-orange-200 bg-gradient-radial from-amber-500 via-amber-700 to-amber-800 shadow-lg shadow-amber-800/80 border-amber-500 border-x-amber-600"
                >
                    <p class="py-1 text-md">0</p>
                </div>
            </div>
            <div class="flex flex-col">
                <div
                    @click="back()"
                    class="grow h-10 m-1 text-center cursor-pointer border-2 rounded-sm focus:outline-none font-Raleway font-bold text-orange-200 bg-gradient-radial from-amber-500 via-amber-700 to-amber-800 shadow-lg shadow-amber-800/80 border-amber-500 border-x-amber-600"
                >
                    <p class="py-1 px-3 text-md">Back</p>
                </div>
                <Link
                    as="div"
                    :href="'/juke/player/' + Number(targetId)"
                    class="w-fit h-10 m-1 text-center cursor-pointer border-2 rounded-sm focus:outline-none font-Raleway font-bold text-orange-200 bg-gradient-radial from-amber-500 via-amber-700 to-amber-800 shadow-lg shadow-amber-800/80 border-amber-500 border-x-amber-600"
                >
                    <p class="py-1 px-3 text-md">Enter</p>
                </Link>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue"
import { Link } from "@inertiajs/inertia-vue3"

export default defineComponent({
    components: {
        Link,
    },
    data() {
        return {
            digit: 0,
            targetId: 1,
        }
    },
    methods: {
        back() {
            if (this.digit == 0 || this.digit == 1) {
                this.targetId = 1
                this.digit = 0
            } else {
                let temp = String(this.targetId).slice(0, -1)
                this.targetId = Number(temp)
                this.digit--
            }
        },
        inputNum(num) {
            if (this.digit == 0) {
                this.targetId = Number(num)
                this.digit = 1
            } else if (this.digit == 3) {
                let temp = String(this.targetId).slice(1, 3)
                this.targetId = Number(temp * 10 + Number(num))
                this.digit = 3
            } else {
                let temp = Number(this.targetId)
                this.targetId = Number(temp * 10 + Number(num))
                this.digit++
            }
        },
    },
    computed: {
        displayNum() {
            return ("000" + this.targetId).slice(-3)
        },
    },
})
</script>
