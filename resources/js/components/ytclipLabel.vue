<template>
    <div class="rounded-md border border-gray-100 flex flex-col p-1 my-2">
        <p class="text-xxs lg:text-sm text-gray-200 ml-3 mr-auto">{{ element.YTclipURL }}</p>
        <p class="text-xxs lg:text-sm text-gray-200 ml-3 mr-auto">{{ element.title }}</p>
        <p class="text-md text-gray-200 ml-3 mr-auto">設定メンバー：{{ member.display }}</p>
        <p class="text-md text-gray-200 ml-3 mr-auto">設定カテゴリー：{{ cate.title }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            member: "",
            cate: "",
        }
    },
    created() {
        this.member = this.$page.props.setting.member.find((value) => value.id == this.element.member_id)
        this.cate = this.$page.props.setting.category.find((value) => value.id == this.element.cate_id)
    },
    props: ["element"],
    emits: ["check"],
}
</script>
