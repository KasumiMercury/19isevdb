<template>
    <div>
        <Head title="アンケート"></Head>
        <div class="w-fit mx-auto mt-32 text-center">
            <p class="text-gray-200 text-md md:text-lg">いつも当サイトをご利用いただきありがとうございます。</p>
            <p class="text-gray-200 text-md md:text-lg mt-2">
                データ登録時に設定いただいたハンドルネーム・ユーザー登録時に設定いただいたハンドルネーム
            </p>
            <p class="text-gray-200 text-md md:text-lg">これらについて、削除申請時の識別・ユーザー識別に使用としていましたが、</p>
            <p class="text-gray-200 text-md md:text-lg">データ共有時に登録者として名前を表示する際にも使用することとしました。</p>
            <p class="text-gray-200 text-md md:text-lg">なお、表示は選択性で匿名で登録したい方は引き続き登録者表示なしとすることができます。</p>
            <p class="text-gray-200 text-md md:text-lg mt-4">
                登録者表示について、今までご登録いただいた方に表示の希望・希望しないをお尋ねしたく存じます。
            </p>
            <p class="text-gray-200 text-md md:text-lg mt-8">主な表示箇所は</p>
            <p class="text-gray-200 text-xs md:text-sm my-1">プレイヤーページ</p>
            <p class="text-gray-200 text-xs md:text-sm my-1">共有ツイート</p>
            <p class="text-gray-200 text-xs md:text-sm my-1">非公式いせぶいDBTwitterアカウントでのツイート</p>
            <p class="text-gray-200 text-md md:text-lg">です。</p>
            <p class="text-gray-200 text-md md:text-lg mt-4">このページで設定していない場合、デフォルトでは登録者表示なしとなっています。</p>
            <Link
                v-if="!$page.props.user"
                as="button"
                :href="route('myLogin')"
                class="text-sm md:text-lg rounded-md bg-green-600 text-gray-100 px-4 md:px-8 py-3 mt-6 mb-2 mx-auto"
                >ログインはこちら</Link
            >

            <div class="my-16">
                <input
                    v-if="!$page.props.user"
                    v-model="CreaterHN"
                    class="w-full py-1 text-sm border-2 border-gray-200 rounded"
                    id="HN"
                    type="text"
                    placeholder="HN"
                />
                <button class="bg-transparent mt-5 mb-5 mx-auto flex flex-row justify-items-center" @click="showSwitch = !showSwitch">
                    <svg
                        :class="showSwitch ? 'fill-green-400' : 'fill-green-800'"
                        class="w-6 h-6 mx-2 my-auto"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                    >
                        <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                        <path
                            d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"
                        />
                    </svg>
                    <p class="text-gray-200 my-auto">登録者表示を許可</p>
                </button>
                <div class="mx-auto ml-auto w-fit mt-5 lg:mt-10">
                    <button class="bg-green-500 text-2xl font-bold text-gray-50 px-5 py-1 lg:py-2 rounded-md" @click="post">送信</button>
                </div>
                <div v-if="complete">
                    <p class="text-green-400 text-sm">完了しました。ありがとうございます！</p>
                    <Link :href="route('TopPage')" class="text-green-400 text-sm">トップページ</Link>
                </div>
            </div>
            <Link as="a" :href="route('TopPage')" class="mx-auto w-fit text-green-400 text-sm">トップページに戻る</Link>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue"
import { Head, Link } from "@inertiajs/inertia-vue3"

export default defineComponent({
    data() {
        return {
            CreaterHN: "",
            isShow: 1,
            showSwitch: true,
            complete: false,
        }
    },
    created() {
        if (this.$page.props.user) {
            this.CreaterHN = this.$page.props.user.name
        }
    },
    methods: {
        post() {
            let self = this
            if (this.showSwitch) {
                this.isShow = 1
            } else {
                this.isShow = 0
            }
            axios({
                method: "post",
                url: "/api/questionnaire",
                dataType: "json",
                data: {
                    CreaterHN: this.CreaterHN,
                    isShow: this.isShow,
                },
            })
                .then((response) => {
                    console.log(response)
                    self.complete = true
                })
                .catch((error) => {
                    console.log(error)
                })
        },
    },
    components: {
        Head,
        Link,
    },
})
</script>
