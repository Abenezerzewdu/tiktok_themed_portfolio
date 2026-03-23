<script setup>
defineProps({
    projects: Array,
});
</script>
<!-- smooth scroll for the cards that have got the videos -->
<template>
    <div class="feed">
        <div v-for="project in projects" :key="project.id" class="feed-item">
            <ProjectCard :project="project" />
        </div>
    </div>
</template>

<script>
import ProjectCard from "./ProjectCard.vue";
export default { components: { ProjectCard } };
</script>

<style scoped>
.feed {
    height: 100vh;
    overflow-y: scroll;
    scroll-snap-type: y mandatory;

    display: flex;
    flex-direction: column;
    align-items: center;
}

.feed-item {
    height: 100vh;
    width: 400px; /* TikTok-style narrow feed */
    scroll-snap-align: start;
}
</style>
