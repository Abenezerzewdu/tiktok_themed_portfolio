<script setup>
import Feed from "@/Components/Feed.vue";
import TikTokLayout from "@/Layouts/TikTokLayout.vue";
defineProps({
    projects: Array,
});
</script>

<template>
    <TikTokLayout>
        <Feed :projects="projects" />
    </TikTokLayout>
</template>
