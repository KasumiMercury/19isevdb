<template>
    <div>
        <button @click="toggleAccordion()" class="flex items-center justify-center mx-auto space-x-3 block w-full">
            <slot name="title" />

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
        <div
            class="transition-all duration-400 overflow-hidden"
            :class="{
                'max-h-fit': isOpen,
                'max-h-0': !isOpen,
            }"
        >
            <slot name="content" />
        </div>
    </div>
</template>

<script>
export default {
    props: ["default"],
    data() {
        return {
            isOpen: false,
        }
    },
    created() {
        this.isOpen = this.default
    },
    methods: {
        toggleAccordion() {
            this.isOpen = !this.isOpen
        },
    },
}
</script>
