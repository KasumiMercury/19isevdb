<template lang="pug">
    <teleport to="body">
        <div class="modal" v-show="isVisible" @click="close"></div>
        <div class="modal-content mt-5 text-center" v-show="isVisible">
            <p class="text-xs lg:text-sm">この機能はログインユーザーのみ使用可能です。</p>
            <p class="text-xs lg:text-sm">ハンドルネームとパスワード、</p>
            <p class="text-xs lg:text-sm">またはGoogleアカウントのみで登録できます。</p>
            <Link as="button" :href="route('myLogin')" class="text-lg rounded-md bg-green-600 text-gray-100 px-8 py-3 mt-6 mb-2 mx-auto">ログイン・登録はこちら</Link>
            <Link as="button" :href="route('sns_login.redirect', 'google')" class="text-lg rounded-md bg-red-600 text-gray-100 px-8 py-3 mt-2 mb-10 mx-auto">Googleでログイン</Link>
        </div>
    </teleport>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3"
export default {
    props: {
        isVisible: {
            required: true,
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {}
    },
    methods: {
        close() {
            this.$emit("close")
        },
    },
    emits: ["close"],
    components: {
        Link,
    },
}
</script>

<style scoped>
.modal {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 50;
}

.modal-content {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    background-color: white;
    width: 80vw;
    max-width: 600px;
    height: auto;
    border-radius: 20px;
    padding: 20px;
    z-index: 100;
}
</style>
