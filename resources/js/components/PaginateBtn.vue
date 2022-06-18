<template>
    <div v-if="linkLength > 3" class="select-none">
        <div class="flex flex-row mx-auto w-fit pb-10 pt-2">
            <Link
                v-if="currentPage == 1"
                class="mr-1 my-auto inline-block text-center leading-7 w-7 h-7 text-sm rounded-full bg-stone-800 text-stone-800 pointer-events-none"
                :href="links[0].url + search + sort + order"
                v-html="'&laquo;'"
            />
            <Link
                v-else
                class="mr-1 my-auto inline-block text-center leading-7 w-7 h-7 text-sm rounded-full text-gray-300 hover:bg-white hover:text-gray-900 focus:bg-white focus:text-gray-900"
                :href="links[0].url + search + sort + order"
                v-html="'&laquo;'"
            />

            <div class="flex flex-row justify-center">
                <Link
                    class="mr-1 my-auto inline-block text-center leading-7 w-7 h-7 text-xs rounded-full text-gray-300 hover:bg-white hover:text-gray-900 focus:bg-white focus:text-gray-900"
                    :class="{ 'box-emit shadow-gray-200': links[1].active }"
                    :href="links[1].url + search + sort + order"
                    v-html="'1'"
                />

                <Link
                    v-if="pageLength > 5 && pageIndex > 3"
                    class="mr-1 my-auto inline-block text-center leading-7 w-7 h-7 text-xs rounded-full text-gray-300 hover:bg-white hover:text-gray-900 focus:bg-white focus:text-gray-900"
                    :href="links[pageIndex - 2].url + search + sort + order"
                    v-html="'&hellip;'"
                />

                <Link
                    v-for="(item, index) in paginateArray"
                    :key="index"
                    class="mr-1 my-auto inline-block text-center leading-7 w-7 h-7 text-xs rounded-full text-gray-300 hover:bg-white hover:text-gray-900 focus:bg-white focus:text-gray-900"
                    :class="{ 'box-emit shadow-gray-200': links[item].active }"
                    :href="links[item].url + search + sort + order"
                    v-html="links[item].label"
                />

                <Link
                    v-if="pageLength > 5 && pageIndex < linkLength - 4"
                    class="mr-1 my-auto inline-block text-center leading-7 w-7 h-7 text-xs rounded-full text-gray-300 hover:bg-white hover:text-gray-900 focus:bg-white focus:text-gray-900"
                    :href="links[pageIndex + 2].url + search + sort + order"
                    v-html="'&hellip;'"
                />

                <Link
                    class="mr-1 my-auto inline-block text-center leading-7 w-7 h-7 text-xs rounded-full text-gray-300 hover:bg-white hover:text-gray-900 focus:bg-white focus:text-gray-900"
                    :class="{ 'box-emit shadow-gray-200': links[linkLength - 2].active }"
                    :href="links[linkLength - 2].url + search + sort + order"
                    v-html="links[linkLength - 2].label"
                />
            </div>

            <Link
                v-if="pageIndex == linkLength - 2"
                class="mr-1 my-auto inline-block text-center leading-7 w-7 h-7 text-sm rounded-full bg-stone-800 text-stone-800 pointer-events-none"
                :href="links[linkLength - 1].url + search + sort + order"
                v-html="'&raquo;'"
            />
            <Link
                v-else
                class="mr-1 my-auto inline-block text-center leading-7 w-7 h-7 text-sm rounded-full text-gray-300 hover:bg-white hover:text-gray-900 focus:bg-white focus:text-gray-900"
                :href="links[linkLength - 1].url + search + sort + order"
                v-html="'&raquo;'"
            />
        </div>
    </div>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3"
export default {
    props: ["links", "search", "sort", "currentPage", "order", "pageLength"],
    components: {
        Link,
    },
    data() {
        return {
            linkLength: 0,
            pageIndex: 0,
            paginateArray: new Array(),
            disableClass: "bg-stone-800 text-stone-800 pointer-events-none",
        }
    },
    created() {
        this.linkLength = this.links.length
        if (this.currentPage < 8) {
            this.pageIndex = this.currentPage
        } else if (this.currentPage > this.pageLength - 6) {
            this.pageIndex = this.linkLength - (this.pageLength - this.currentPage + 2)
        } else {
            this.pageIndex = 7
        }

        if (this.pageLength < 6) {
            for (let i = 2; i < this.linkLength - 2; i++) {
                this.paginateArray.push(i)
            }
        } else {
            if (this.pageIndex < 3) {
                this.paginateArray = [2, 3, 4]
            } else if (this.pageIndex > this.linkLength - 4) {
                this.paginateArray = [Number(this.linkLength - 5), Number(this.linkLength - 4), Number(this.linkLength - 3)]
            } else {
                this.paginateArray = [this.pageIndex - 1, this.pageIndex, this.pageIndex + 1]
            }
        }
    },
}
</script>
