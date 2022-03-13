<template>
    <div class="rounded-md border border-gray-200 flex flex-col p-1 my-2" :class="element.title == '' ? 'border-red-500' : 'border-gray-200'">
        <p class="text-xxs lg:text-sm text-gray-200 ml-3 mr-auto">{{ element.twitterURL }}</p>
        <div class="flex flex-row">
            <p class="ml-2 mr-1 mb-1 mt-3 text-md text-red-200">メンバーを設定してください：</p>
            <select
                class="ml-1 mr-auto mb-1 mt-3 w-fit form-select form-select-md appearance-none block px-8 py-1 text-sm text-gray-700 bg-white border border-solid border-gray-300 rounded transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                aria-label="member"
                name="member"
                :value="element.member_id"
                @change="$emit('update:twitterMember', $event.target.value)"
            >
                <option v-for="member in $page.props.setting.member" :key="'member' + member.id" :value="member.id">
                    {{ member.display }}
                </option>
            </select>
        </div>
        <div class="flex flex-row">
            <p class="ml-2 mr-1 mb-1 mt-3 text-md text-red-200">カテゴリーを設定してください：</p>
            <select
                class="ml-1 mr-auto mb-1 mt-3 w-fit form-select form-select-md appearance-none block px-8 py-1 text-sm text-gray-700 bg-white border border-solid border-gray-300 rounded transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                aria-label="member"
                name="member"
                :value="element.cate_id"
                @change="$emit('update:twitterCategory', $event.target.value)"
            >
                <option v-for="cate in $page.props.setting.category" :key="'cate' + cate.id" :value="cate.id">
                    {{ cate.title }}
                </option>
            </select>
        </div>
        <div class="flex flex-row w-full px-5">
            <div class="relative w-full my-1">
                <label class="sr-only" for="title"> Title </label>

                <input
                    :value="element.title"
                    @input="$emit('update:twitterTitle', $event.target.value)"
                    class="w-full py-1 text-sm border-2 border-gray-200 rounded"
                    id="title"
                    type="text"
                    placeholder="Title"
                />
            </div>
        </div>
        <div class="flex flex-row justify-end">
            <div class="mr-2 py-1 ml-auto my-auto">
                <button @click="$emit('check')" class="text-[#1da1f2] bg-transparent w-fit">確認する</button>
            </div>
            <div class="mx-2 py-1 my-auto">
                <button @click="$emit('delete')" class="text-red-400 bg-transparent w-fit">削除</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["twitter", "error"],
    data() {
        return {
            element: [],
        }
    },
    created() {
        this.element = this.twitter
    },
    emits: ["check", "update:twitterMember", "update:twitterCategory", "update:twitterTitle"],
}
</script>
