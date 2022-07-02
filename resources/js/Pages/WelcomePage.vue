<template>
    <div>
        <Head>
            <meta name="description" content="個人Vtuberグループいせぶい非公式データベース　初めての方へ" />
        </Head>
        <app-layout title="Welcome" :chooseCate="false" NowPage="Welcome" NowCate="NONE" :isSub="true" shareUrl="https://isevdb.net">
            <template #header>
                <h2 class="emitTitle">iseV</h2>
            </template>

            <template #default>
                <div class="flex flex-col text-center pt-10 px-3">
                    <p class="text-2xl lg:text-4xl text-gray-200 my-5">非公式いせぶいDBとは</p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">非公式いせぶいDBは「異世界転生してVになりました。」</p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">
                        <span class="inline-block">略して「いせぶい」に所属する</span
                        ><span class="inline-block">各メンバーの可愛い声や面白いエピソード</span>
                    </p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">
                        <span class="inline-block">ファンが作った切り抜きやファンアートを集約する</span
                        ><span class="inline-block">データベース（DB)です。</span>
                    </p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">当サイトはYouTubeやTwitterを埋め込む形で直接共有します。</p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">当サイトでの再生・閲覧情報は直接、共有元にて計上されます。</p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">
                        <span class="inline-block">誰でもAddDataページから登録が可能です。</span
                        ><span class="inline-block">ストック感覚でお気軽にご登録いただければ幸いです。</span>
                    </p>
                    <p class="text-xs lg:text-sm text-gray-200 mt-2 mb-8">
                        <span class="inline-block">当サイトがいせぶいメンバーの応援になり、</span
                        ><span class="inline-block">いせぶいファンの皆様のお役立てればと思います。</span>
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
                    <p class="text-xs lg:text-sm text-gray-200 mt-2 mb-4">
                        <span class="inline-block">プレイヤーウィンドウが開く</span
                        ><span class="inline-block">またはプレイヤーページに遷移します。</span>
                    </p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">右下が青色のものはTwitterデータ、赤色のものはYouTubeデータ</p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">
                        <span class="inline-block">緑色のものはメン限動画、</span
                        ><span class="inline-block">暗くなっているものは非公開になったデータです。</span>
                    </p>
                    <img src="/img/CARD.png" class="max-w-sm rounded-md border border-gray-200 mx-auto w-5/6" alt="" />
                    <p class="text-xs lg:text-sm text-gray-200 my-2">右上以外のどこをクリック・タップしても移動できます。</p>
                    <p class="text-xs lg:text-sm text-gray-200 mt-2 mb-16">
                        <span class="inline-block">右上をクリック・タップすると</span
                        ><span class="inline-block">ブックマークを操作できます（要ログイン）</span>
                    </p>
                    <p class="text-sm lg:text-md text-blue-200 my-2">データ追加はAddDataページから誰でも可能です。</p>
                    <p class="text-xs lg:text-sm text-gray-200 my-2">
                        <span class="inline-block"> いせぶいメンバーの動画から時間を設定して</span
                        ><span class="inline-block">簡易切り抜きを作ったり、</span
                        ><span class="inline-block">YouTubeやTwitterにアップロードした切り抜きを登録したり、</span
                        ><span class="inline-block">Twitterに投稿したファンアを投稿することができます。</span>
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
