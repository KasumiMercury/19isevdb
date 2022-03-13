<template>
    <div class="rounded-md border border-gray-200 flex flex-col p-1 my-2">
        <div class="flex flex-row my-1 justify-items-center">
            <img class="ml-3 w-24 object-contain mr-auto flex-none" :src="element.thumbnail" />
            <p class="flex-grow text-xxs lg:text-sm text-gray-200 ml-3">{{ element.title }}</p>
        </div>
        <div class="flex flex-col">
            <p class="ml-3 mr-auto text-gray-200">{{ element.date }} by {{ element.channel }}</p>
            <p class="ml-3 mr-auto text-gray-200">https://youtu.be/{{ element.VideoID }}</p>
        </div>
        <div class="flex flex-row">
            <p class="ml-2 mr-1 mb-1 mt-3 text-md text-red-200">メンバーを設定してください：</p>
            <select
                class="ml-1 mr-auto mb-1 mt-3 w-fit form-select form-select-md appearance-none block px-8 py-1 text-sm text-gray-700 bg-white border border-solid border-gray-300 rounded transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                aria-label="member"
                name="member"
                v-model="element.member_id"
                @change="changeClipMember"
            >
                <option v-for="member in $page.props.setting.member" :key="'member' + member.id" :value="member.id">
                    {{ member.display }}
                </option>
            </select>
        </div>
        <div class="mr-2 py-1 ml-auto my-auto">
            <button @click="$emit('delete')" class="text-red-400 bg-transparent w-fit">削除</button>
        </div>
    </div>
</template>

<script>
export default {
    props: ["clip"],
    data() {
        return {
            element: [],
        }
    },
    created() {
        this.element = this.clip
    },
    changeClipMember(e) {
        this.$emit("changeMember", e)
    },
    emits: ["delete", "changeMember"],
}
</script>
