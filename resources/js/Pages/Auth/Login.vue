<template>
    <app-layout title="Log in" :chooseCate="false" NowPage="Log in" NowCate="NONE" :isSub="false">
        <template #header>
            <h2 class="emitTitle">iseV</h2>
        </template>
        <template #default>
            <div class="px-1 mt-4">
                <div class="max-w-3xl bg-gray-100 px-5 py-12 mx-auto rounded-lg">
                    <jet-validation-errors class="mb-4" />

                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit">
                        <div>
                            <jet-label for="name" value="name" />
                            <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
                        </div>

                        <div class="mt-4">
                            <jet-label for="password" value="Password" />
                            <jet-input
                                id="password"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                            />
                        </div>

                        <div class="block mt-4">
                            <label class="flex items-center">
                                <jet-checkbox name="remember" :checked="form.remember" />
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Log in </jet-button>
                        </div>
                    </form>
                    <div class="mx-auto mt-16 w-fit">
                        <Link
                            as="button"
                            :href="route('sns_login.redirect', 'google')"
                            class="px-16 py-2 rounded-md text-xl text-gray-50 bg-[#ea4335]"
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
import JetCheckbox from "@/Jetstream/Checkbox.vue"
import JetLabel from "@/Jetstream/Label.vue"
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue"
import { Link } from "@inertiajs/inertia-vue3"
import AppLayout from "@/Layouts/AppLayout.vue"

export default defineComponent({
    components: {
        JetButton,
        JetInput,
        JetCheckbox,
        JetLabel,
        JetValidationErrors,
        Link,
        AppLayout,
    },

    props: {
        canResetPassword: Boolean,
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: "",
                password: "",
                remember: false,
            }),
        }
    },

    methods: {
        submit() {
            this.form
                .transform((data) => ({
                    ...data,
                    remember: this.form.remember ? "on" : "",
                }))
                .post(this.route("login"), {
                    onFinish: () => this.form.reset("password"),
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
