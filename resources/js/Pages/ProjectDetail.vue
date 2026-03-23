<script setup>
defineProps({
    project: Object,
});
</script>

<template>
    <div>
        <h1>{{ project.title }}</h1>

        <video :src="project.video_url" controls />

        <p>{{ project.description }}</p>

        <a :href="project.github_url">GitHub</a>
        <a :href="project.live_url">Live</a>
    </div>
</template>
