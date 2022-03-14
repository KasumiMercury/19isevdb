<template>
    <div v-if="pageLength > 3">
        <div class="flex flex-row">
            <Link
                v-if="currentPage == 1"
                class="mr-1 my-auto px-3 py-1 mx:px-4 md:py-2 text-sm rounded-full bg-stone-800 text-stone-800 pointer-events-none"
                :href="links[0].url + search + sort + order"
                v-html="'&laquo;'"
            />
            <Link
                v-else
                class="mr-1 my-auto px-3 py-1 mx:px-4 md:py-2 text-sm rounded-full text-gray-300 hover:bg-white hover:text-gray-900 focus:bg-white focus:text-gray-900"
                :href="links[0].url + search + sort + order"
                v-html="'&laquo;'"
            />

            <div class="w-52 lg:w-72 flex flex-row justify-center">
                <Link
                    class="mr-1 my-auto px-3 py-1 mx:px-4 md:py-2 text-xs rounded-full text-gray-300 hover:bg-white hover:text-gray-900 focus:bg-white focus:text-gray-900"
                    :class="{ 'box-emit shadow-gray-200': links[1].active }"
                    :href="links[1].url + search + sort + order"
                    v-html="'1'"
                />

                <Link
                    v-if="pageLength > 5 && currentPage > 3"
                    class="mr-1 my-auto px-3 py-1 mx:px-4 md:py-2 text-xs rounded-full text-gray-300 hover:bg-white hover:text-gray-900 focus:bg-white focus:text-gray-900"
                    :href="links[currentPage - 2].url + search + sort + order"
                    v-html="'&hellip;'"
                />

                <Link
                    v-for="(item, index) in paginateArray"
                    :key="index"
                    class="mr-1 my-auto px-3 py-1 mx:px-4 md:py-2 text-xs rounded-full text-gray-300 hover:bg-white hover:text-gray-900 focus:bg-white focus:text-gray-900"
                    :class="{ 'box-emit shadow-gray-200': links[item].active }"
                    :href="links[item].url + search + sort + order"
                    v-html="item"
                />

                <Link
                    v-if="pageLength > 5 && currentPage < pageLength - 4"
                    class="mr-1 my-auto px-3 py-1 mx:px-4 md:py-2 text-xs rounded-full text-gray-300 hover:bg-white hover:text-gray-900 focus:bg-white focus:text-gray-900"
                    :href="links[currentPage + 2].url + search + sort + order"
                    v-html="'&hellip;'"
                />

                <Link
                    class="mr-1 my-auto px-3 py-1 mx:px-4 md:py-2 text-xs rounded-full text-gray-300 hover:bg-white hover:text-gray-900 focus:bg-white focus:text-gray-900"
                    :class="{ 'box-emit shadow-gray-200': links[pageLength - 2].active }"
                    :href="links[pageLength - 2].url + search + sort + order"
                    v-html="String(pageLength - 2)"
                />
            </div>

            <Link
                v-if="currentPage == pageLength - 2"
                class="mr-1 my-auto px-3 py-1 mx:px-4 md:py-2 text-sm rounded-full bg-stone-800 text-stone-800 pointer-events-none"
                :href="links[pageLength - 1].url + search + sort + order"
                v-html="'&raquo;'"
            />
            <Link
                v-else
                class="mr-1 my-auto px-3 py-1 mx:px-4 md:py-2 text-sm rounded-full text-gray-300 hover:bg-white hover:text-gray-900 focus:bg-white focus:text-gray-900"
                :href="links[pageLength - 1].url + search + sort + order"
                v-html="'&raquo;'"
            />
        </div>
    </div>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3"
export default {
    props: ["links", "search", "sort", "currentPage", "order"],
    components: {
        Link,
    },
    data() {
        return {
            pageLength: 0,
            paginateArray: new Array(),
            disableClass: "bg-stone-800 text-stone-800 pointer-events-none",
        }
    },
    created() {
        this.pageLength = this.links.length
        if (this.pageLength < 6) {
            for (let i = 2; i < this.pageLength - 2; i++) {
                this.paginateArray.push(i)
            }
        } else {
            if (this.currentPage < 3) {
                this.paginateArray = [2, 3, 4]
            } else if (this.currentPage > this.pageLength - 4) {
                this.paginateArray = [Number(this.pageLength - 5), Number(this.pageLength - 4), Number(this.pageLength - 3)]
            } else {
                this.paginateArray = [this.currentPage - 1, this.currentPage, this.currentPage + 1]
            }
        }
    },
}
</script>
