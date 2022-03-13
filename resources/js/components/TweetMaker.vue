<template>
    <teleport to="body">
        <div class="modal" v-show="isVisible" @click="close"></div>
        <div class="modal-content mt-5 text-center justify-center flex flex-col" v-show="isVisible">
            <button class="bg-transparent mt-5 flex flex-row justify-items-center" @click="setTWtitle">
                <svg
                    :class="TWtitle ? 'fill-green-500' : 'fill-green-900'"
                    class="w-6 h-6 mx-2 my-auto"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"
                >
                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"
                    />
                </svg>
                <p class="text-gray-900 my-auto">データタイトル</p>
            </button>
            <button class="bg-transparent mt-5 flex flex-row justify-items-center" @click="changeTWurl()">
                <svg
                    :class="TWurl ? 'fill-green-500' : 'fill-green-900'"
                    class="w-6 h-6 mx-2 my-auto"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"
                >
                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"
                    />
                </svg>
                <p class="text-gray-900 my-auto">非公式DBのURL</p>
            </button>
            <button class="bg-transparent mt-5 mb-5 flex flex-row justify-items-center" @click="changeTWyt()">
                <svg
                    :class="TWyt ? 'fill-green-500' : 'fill-green-900'"
                    class="w-6 h-6 mx-2 my-auto"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"
                >
                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"
                    />
                </svg>
                <p class="text-gray-900 my-auto">元動画のURL</p>
            </button>
            <ShareNetwork
                network="twitter"
                :url="Tweet.url"
                :title="Tweet.title"
                :hashtags="Tweet.hash"
                :class="'text-decoration-none'"
                @click="close"
            >
                <button class="bg-[#1DA1F2] mx-auto w-fit px-5 py-1" style="color: #fff">Tweet</button>
            </ShareNetwork>
        </div>
    </teleport>
</template>

<script>
import { ShareNetwork } from "vue-social-sharing"
export default {
    props: ["isVisible", "currentMember", "player"],
    data() {
        return {
            TWtitle: true,
            TWurl: true,
            TWyt: false,
            Tweet: [],
        }
    },
    created() {
        this.Tweet["url"] = "https://isevdb.sakura.ne.jp/" + this.currentMember.name + "/share/" + this.player.id
        this.Tweet["title"] = "非公式" + this.currentMember.display + "DB No." + this.player.id + "　”" + this.player.title + "”"
        this.Tweet["hash"] = this.currentMember.display + "非公式DB," + this.currentMember.display
    },
    methods: {
        close() {
            this.$emit("close")
        },
        setTWtitle() {
            this.TWtitle = !this.TWtitle
            if (this.TWtitle == false) {
                this.Tweet["title"] = ""
            } else {
                this.Tweet["title"] = "非公式" + this.currentMember.display + "DB No." + this.player.id + "　”" + this.player.title + "”"
            }
        },
        setTWurl() {
            if (this.TWurl == false) {
                if (this.TWyt == false) {
                    this.Tweet["url"] = ""
                } else {
                    this.Tweet["url"] = "https://youtu.be/" + this.player.VideoID
                }
            } else {
                if (this.TWyt == false) {
                    this.Tweet["url"] = "https://isevdb.sakura.ne.jp/" + this.currentMember.name + "/share/" + this.player.id
                } else {
                    this.Tweet["url"] =
                        "https://isevdb.sakura.ne.jp/" +
                        this.currentMember.name +
                        "/share/" +
                        this.player.id +
                        "　https://youtu.be/" +
                        this.player.VideoID
                }
            }
        },
        changeTWurl() {
            this.TWurl = !this.TWurl
            this.setTWurl()
        },
        changeTWyt() {
            this.TWyt = !this.TWyt
            this.setTWurl()
        },
    },
    emits: ["close"],
    components: {
        ShareNetwork,
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
