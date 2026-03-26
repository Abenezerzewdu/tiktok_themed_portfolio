<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import ProjectCard from "./ProjectCard.vue";

defineProps({
    projects: Array,
});

const feedRef = ref(null);
const currentIndex = ref(0);

// Handle keyboard navigation
const handleKeydown = (e) => {
    if (!feedRef.value) return;

    const items = feedRef.value.querySelectorAll(".feed-item");
    if (e.key === "ArrowDown" || e.key === "j") {
        e.preventDefault();
        if (currentIndex.value < items.length - 1) {
            currentIndex.value++;
            items[currentIndex.value].scrollIntoView({ behavior: "smooth" });
        }
    } else if (e.key === "ArrowUp" || e.key === "k") {
        e.preventDefault();
        if (currentIndex.value > 0) {
            currentIndex.value--;
            items[currentIndex.value].scrollIntoView({ behavior: "smooth" });
        }
    }
};

onMounted(() => {
    window.addEventListener("keydown", handleKeydown);
});

onUnmounted(() => {
    window.removeEventListener("keydown", handleKeydown);
});
</script>

<template>
    <div ref="feedRef" class="feed">
        <div
            v-for="(project, index) in projects"
            :key="project.id"
            class="feed-item"
            :class="{ 'is-active': index === currentIndex }"
        >
            <ProjectCard
                :project="project"
                :isActive="index === currentIndex"
            />
        </div>

        <!-- Empty state -->
        <div v-if="!projects || projects.length === 0" class="empty-state">
            <div class="empty-icon">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-16 w-16 text-muted-foreground"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
                    />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-foreground mt-4">
                No projects yet
            </h3>
            <p class="text-muted-foreground mt-2">
                Upload your first project to get started
            </p>
        </div>
    </div>
</template>

<style scoped>
.feed {
    height: 100vh;
    width: 100%;
    max-width: 500px;
    overflow-y: scroll;
    scroll-snap-type: y mandatory;
    scroll-behavior: smooth;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.feed-item {
    height: 100vh;
    width: 100%;
    max-width: 450px;
    scroll-snap-align: start;
    scroll-snap-stop: always;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 8px;
}

@media (max-width: 640px) {
    .feed-item {
        max-width: 100%;
        padding: 0;
    }
}

.empty-state {
    height: 100vh;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 24px;
}

.empty-icon {
    padding: 24px;
    border-radius: 50%;
    background: hsl(var(--secondary));
}
</style>
