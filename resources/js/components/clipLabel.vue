<template>
    <div class="rounded-md border border-gray-100 flex flex-col p-1 my-2">
        <div class="flex flex-row my-1 justify-items-center">
            <img class="ml-3 w-24 object-contain mr-auto flex-none" :src="element.thumbnail" />
            <p class="flex-grow text-xxs lg:text-sm text-gray-200 ml-3">{{ element.title }}</p>
        </div>
        <div class="flex flex-row">
            <div class="flex flex-col">
                <p class="ml-3 mr-auto text-gray-200 text-xxs lg:text-sm">{{ element.date }} by {{ element.channel }}</p>
                <p class="ml-3 mr-auto text-gray-200">https://youtu.be/{{ element.VideoID }}</p>
            </div>
        </div>
        <p class="text-md text-gray-200 mr-10 ml-auto">設定メンバー：{{ member.display }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            member: "",
        }
    },
    created() {
        this.member = this.$page.props.setting.member.find((value) => value.id == this.element.member_id)
    },
    props: ["element"],
}
</script>
