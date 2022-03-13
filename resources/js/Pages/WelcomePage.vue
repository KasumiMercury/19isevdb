<template>
    <div>
        <Head>
            <meta name="description" content="個人Vtuberグループいせぶい非公式データベース　初めての方へ" />
        </Head>
        <app-layout title="Welcome" :chooseCate="false" NowPage="Welcome" NowCate="NONE" :isSub="true">
            <template #header>
                <h2 class="emitTitle">iseV</h2>
            </template>

            <template #default>
                <div class="flex flex-col text-center pt-10">
                    <p class="text-2xl lg:text-4xl text-gray-200 my-5">非公式いせぶいDBとは</p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">非公式いせぶいDBは「異世界転生してVになりました。」</p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">略して「いせぶい」に所属する各メンバーの可愛い声や面白いエピソード</p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">ファンが作った切り抜きやファンアートを集約するデータベース（DB)です。</p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">当サイトはYouTubeやTwitterを埋め込む形で直接共有します。</p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">当サイトでの再生・閲覧情報は直接、共有元にて計上されます。</p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">
                        誰でもAddDataページから登録が可能です。ストック感覚でお気軽にご登録いただければ幸いです。
                    </p>
                    <p class="text-xs lg:text-sm text-gray-200 mt-2 mb-8">
                        当サイトがいせぶいメンバーの応援になり、いせぶいファンの皆様のお役立てればと思います。
                    </p>

                    <p class="text-2xl lg:text-4xl text-gray-200 my-5">データ閲覧の仕方</p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">まず、CHOOSE MEMBERでメンバーを選択します。</p>
                    <img src="/img/MEMBER_sm.png" alt="" class="lg:hidden max-w-xs rounded-md border border-gray-200 mb-16 mx-auto w-4/5" />
                    <img src="/img/MEMBER.png" alt="" class="hidden lg:inline-block max-w-xs rounded-md border border-gray-200 mb-16 mx-auto w-4/5" />
                    <p class="text-xs lg:text-sm text-gray-200 my-2">さらにCHOOSE CATEGORYでカテゴリーを絞れます。</p>
                    <img src="/img/CATEGORY_sm.png" class="lg:hidden max-w-xs rounded-md border border-gray-200 mb-16 mx-auto w-4/5" alt="" />
                    <img
                        src="/img/CATEGORY.png"
                        class="hidden lg:inline-block max-w-xs rounded-md border border-gray-200 mb-16 mx-auto w-4/5"
                        alt=""
                    />
                    <p class="text-xs lg:text-sm text-gray-200 my-2">一覧に表示されるカードを選択してください。</p>
                    <p class="text-xs lg:text-sm text-gray-200 mt-2 mb-4">プレイヤーウィンドウが開くまたはプレイヤーページに遷移します。</p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">右下が青色のものはTwitterデータ、赤色のものはYouTubeデータ</p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">緑色のものはメン限動画、暗くなっているものは非公開になったデータです。</p>
                    <img src="/img/CARD.png" class="max-w-sm rounded-md border border-gray-200 mx-auto w-5/6" alt="" />
                    <p class="text-xs lg:text-sm text-gray-200 my-2">右上以外のどこをクリック・タップしても移動できます。</p>
                    <p class="text-xs lg:text-sm text-gray-200 mt-2 mb-16">右上をクリック・タップするとブックマークを操作できます（要ログイン）</p>
                    <p class="text-sm lg:text-md text-blue-200 my-2">データ追加はAddDataページから誰でも可能です。</p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">
                        いせぶいメンバーの動画から時間を設定して簡易切り抜きを作ったり、YouTubeやTwitterにアップロードした切り抜きを登録したり、Twitterに投稿したファンアを投稿することができます。
                    </p>
                </div>
            </template>
        </app-layout>
    </div>
</template>

<script>
import { defineComponent } from "vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import { Head, Link } from "@inertiajs/inertia-vue3"

export default defineComponent({
    components: {
        AppLayout,
        Link,
        Head,
    },
})
</script>
<style scoped>
.emitTitle {
    color: #f59e0b;
    text-shadow: 0px 0px 20px #f59e0b;
}
</style>
