<template>
    <app-layout title="Register" :chooseCate="false" NowPage="Log in" NowCate="NONE" :isSub="false">
        <template #header>
            <h2 class="emitTitle">iseV</h2>
        </template>
        <template #default>
            <div class="px-1 mt-4">
                <div class="text-center">
                    <p class="text-sm lg:text-xl text-gray-100 my-3">当サイトが取得する情報について</p>
                    <p class="text-xxs lg:text-sm text-gray-100">当サイトはハンドルネームとパスワードにてユーザーを識別しています。</p>
                    <p class="text-xxs lg:text-sm text-gray-100">
                        個人情報は扱いませんのでパスワードは簡易なもので結構ですが、識別のため8文字以上で設定してください。
                    </p>
                    <p class="text-xxs lg:text-sm text-gray-100">
                        なお、同一ハンドルネームでの登録はできません。また、ハンドルネームは管理人が見ることができます。
                    </p>
                    <p class="text-xxs lg:text-sm text-gray-100">パスワードは登録時に暗号化されるため管理人は実質見ることはできません。</p>
                    <p class="text-xxs lg:text-sm text-gray-100">
                        Googleログインでは、Googleユーザー名のみを取得しています。メールアドレスは取得していません。
                    </p>
                    <p class="text-xxs lg:text-sm text-gray-100 mt-5 mb-1">▼実際の登録データ（上が通常登録、下がGoogleアカウント利用）</p>
                    <img src="/img/DBsnap.png" />
                </div>
                <div class="max-w-3xl bg-gray-100 px-5 py-12 mx-auto mt-4 rounded-lg">
                    <jet-validation-errors class="mb-4" />

                    <form @submit.prevent="submit">
                        <div>
                            <jet-label for="name" value="Name" />
                            <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                        </div>

                        <div class="mt-4">
                            <jet-label for="password" value="Password" />
                            <jet-input
                                id="password"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                            />
                        </div>

                        <div class="mt-4">
                            <jet-label for="password_confirmation" value="Confirm Password" />
                            <jet-input
                                id="password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                            />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900"> Already registered? </Link>

                            <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Register </jet-button>
                        </div>
                    </form>
                    <div class="mx-auto mt-16 w-fit">
                        <Link
                            as="button"
                            :href="route('sns_login.redirect', 'google')"
                            class="px-16 py-5 rounded-md text-xl text-gray-50 bg-[#ea4335]"
                            >Googleでログイン</Link
                        >
                    </div>
                </div>
            </div>
        </template>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue"
import JetButton from "@/Jetstream/Button.vue"
import JetInput from "@/Jetstream/Input.vue"
import JetLabel from "@/Jetstream/Label.vue"
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue"
import { Link } from "@inertiajs/inertia-vue3"
import AppLayout from "@/Layouts/AppLayout.vue"

export default defineComponent({
    components: {
        JetButton,
        JetInput,
        JetLabel,
        JetValidationErrors,
        Link,
        AppLayout,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: "",
                password: "",
                password_confirmation: "",
                terms: false,
            }),
        }
    },

    methods: {
        submit() {
            this.form.post(this.route("register"), {
                onFinish: () => this.form.reset("password", "password_confirmation"),
            })
        },
    },
})
</script>
<style scoped>
.emitTitle {
    color: #f59e0b;
    text-shadow: 0px 0px 20px #f59e0b;
}
</style>
