<script setup>
import TikTokLayout from "@/Layouts/TikTokLayout.vue";
</script>
<template>
    <!-- <TikTokLayout> -->
    <div class="paper-bg">
        <transition name="fade">
            <div class="paper-frame">
                <h1 class="title">Chronicle of My Journey</h1>

                <p class="chronicle-text">
                    {{ displayedText }}
                </p>
            </div>
        </transition>
    </div>
    <!-- </TikTokLayout> -->
</template>
<style scoped>
.paper-bg {
    background-image: url("/storage/images/blackPaper.jpg");
    background-size: cover;
    min-height: 100vh;
    padding: 40px;
}

.paper-frame {
    max-width: 700px;
    margin: auto;
    padding: 30px;
    background: rgba(255, 255, 255, 0.2);
    box-shadow: inset 0 0 40px rgba(0, 0, 0, 0.2);
}

.title {
    text-align: center;
    margin-bottom: 20px;
}

.chronicle-text {
    line-height: 1.8;
}

.fade-enter-active {
    transition: opacity 0.5s ease;
}
.fade-enter-from {
    opacity: 0;
}
</style>
