<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import TikTokLayout from "@/Layouts/TikTokLayout.vue";
import {
    ArrowLeft,
    ExternalLink,
    Github,
    Heart,
    MessageCircle,
    Share2,
    Play,
    Pause,
    Calendar,
    Code,
} from "lucide-vue-next";

const props = defineProps({
    project: Object,
});

const videoRef = ref(null);
const isPlaying = ref(false);
const liked = ref(false);
const likeCount = ref(Math.floor(Math.random() * 500) + 100);

const togglePlay = () => {
    if (videoRef.value) {
        if (isPlaying.value) {
            videoRef.value.pause();
        } else {
            videoRef.value.play();
        }
        isPlaying.value = !isPlaying.value;
    }
};

const toggleLike = () => {
    liked.value = !liked.value;
    likeCount.value += liked.value ? 1 : -1;
};

const share = async () => {
    try {
        if (navigator.share) {
            await navigator.share({
                title: props.project.title,
                text: props.project.description,
                url: window.location.href,
            });
        }
    } catch (err) {
        // User cancelled
    }
};
</script>

<template>
    <TikTokLayout>
        <div class="detail-container">
            <!-- Back Button -->
            <Link href="/" class="back-btn">
                <ArrowLeft class="h-5 w-5" />
                <span>Back to Feed</span>
            </Link>

            <div class="detail-content">
                <!-- Video Section -->
                <div class="video-section">
                    <div class="video-wrapper" @click="togglePlay">
                        <video
                            ref="videoRef"
                            :src="project.video_url"
                            loop
                            playsinline
                            class="detail-video"
                        ></video>

                        <!-- Play/Pause Overlay -->
                        <div v-if="!isPlaying" class="play-overlay">
                            <div class="play-button">
                                <Play class="h-10 w-10 text-white fill-white" />
                            </div>
                        </div>
                    </div>

                    <!-- Video Actions -->
                    <div class="video-actions">
                        <button
                            @click="toggleLike"
                            :class="['action-btn', { 'is-active': liked }]"
                        >
                            <Heart :class="{ 'fill-current': liked }" />
                            <span>{{ likeCount }}</span>
                        </button>

                        <button class="action-btn">
                            <MessageCircle />
                            <span>Comments</span>
                        </button>

                        <button @click="share" class="action-btn">
                            <Share2 />
                            <span>Share</span>
                        </button>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="info-section">
                    <!-- Header -->
                    <div class="project-header">
                        <div class="creator-row">
                            <div class="creator-avatar">
                                <span class="text-lg font-bold text-primary-foreground">{{
                                    project.title?.charAt(0)?.toUpperCase() || "P"
                                }}</span>
                            </div>
                            <div class="creator-info">
                                <h1 class="project-title">{{ project.title }}</h1>
                                <p class="creator-handle">@abe.dev</p>
                            </div>
                            <button class="follow-btn">Follow</button>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="project-description">
                        <p>{{ project.description }}</p>
                    </div>

                    <!-- Tech Stack -->
                    <div v-if="project.tech_stack?.length" class="tech-section">
                        <div class="section-header">
                            <Code class="h-5 w-5 text-muted-foreground" />
                            <h3>Tech Stack</h3>
                        </div>
                        <div class="tech-grid">
                            <span
                                v-for="tech in project.tech_stack"
                                :key="tech"
                                class="tech-badge"
                            >
                                {{ tech }}
                            </span>
                        </div>
                    </div>

                    <!-- Project Links -->
                    <div class="links-section">
                        <a
                            v-if="project.github_url"
                            :href="project.github_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="project-link github"
                        >
                            <Github class="h-5 w-5" />
                            <span>View on GitHub</span>
                            <ExternalLink class="h-4 w-4 ml-auto opacity-50" />
                        </a>

                        <a
                            v-if="project.live_url"
                            :href="project.live_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="project-link live"
                        >
                            <ExternalLink class="h-5 w-5" />
                            <span>View Live Demo</span>
                            <ExternalLink class="h-4 w-4 ml-auto opacity-50" />
                        </a>
                    </div>

                    <!-- Meta Info -->
                    <div class="meta-section">
                        <div class="meta-item">
                            <Calendar class="h-4 w-4 text-muted-foreground" />
                            <span>Posted recently</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </TikTokLayout>
</template>

<style scoped>
.detail-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 24px;
    overflow-y: auto;
    height: 100vh;
}

@media (max-width: 640px) {
    .detail-container {
        padding: 16px;
        padding-bottom: 100px;
    }
}

/* Back Button */
.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    margin-bottom: 24px;
    font-size: 14px;
    font-weight: 500;
    color: hsl(var(--foreground));
    background: hsl(var(--secondary));
    border-radius: 999px;
    transition: all 0.2s ease;
}

.back-btn:hover {
    background: hsl(var(--muted));
    transform: translateX(-4px);
}

/* Content Layout */
.detail-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 48px;
    align-items: start;
}

@media (max-width: 1024px) {
    .detail-content {
        grid-template-columns: 1fr;
        gap: 32px;
    }
}

/* Video Section */
.video-section {
    position: sticky;
    top: 24px;
}

@media (max-width: 1024px) {
    .video-section {
        position: static;
    }
}

.video-wrapper {
    position: relative;
    aspect-ratio: 9/16;
    max-height: 70vh;
    border-radius: 16px;
    overflow: hidden;
    background: hsl(var(--card));
    cursor: pointer;
}

.detail-video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.play-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.3);
}

.play-button {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);
    transition: transform 0.2s ease;
}

.play-button:hover {
    transform: scale(1.1);
}

/* Video Actions */
.video-actions {
    display: flex;
    justify-content: center;
    gap: 16px;
    margin-top: 16px;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    font-size: 14px;
    font-weight: 500;
    color: hsl(var(--foreground));
    background: hsl(var(--secondary));
    border-radius: 999px;
    transition: all 0.2s ease;
}

.action-btn:hover {
    background: hsl(var(--muted));
    transform: scale(1.02);
}

.action-btn.is-active {
    color: hsl(var(--primary));
}

.action-btn svg {
    width: 20px;
    height: 20px;
}

/* Info Section */
.info-section {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

/* Project Header */
.project-header {
    padding-bottom: 24px;
    border-bottom: 1px solid hsl(var(--border));
}

.creator-row {
    display: flex;
    align-items: center;
    gap: 16px;
}

.creator-avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, hsl(var(--primary)), hsl(var(--accent)));
    flex-shrink: 0;
}

.creator-info {
    flex: 1;
    min-width: 0;
}

.project-title {
    font-size: 24px;
    font-weight: 700;
    color: hsl(var(--foreground));
    line-height: 1.2;
}

.creator-handle {
    font-size: 14px;
    color: hsl(var(--muted-foreground));
    margin-top: 4px;
}

.follow-btn {
    padding: 10px 24px;
    font-size: 14px;
    font-weight: 600;
    color: hsl(var(--primary-foreground));
    background: hsl(var(--primary));
    border-radius: 8px;
    transition: all 0.2s ease;
}

.follow-btn:hover {
    opacity: 0.9;
    transform: scale(1.02);
}

/* Description */
.project-description {
    font-size: 16px;
    line-height: 1.6;
    color: hsl(var(--foreground));
}

/* Tech Section */
.tech-section {
    padding: 20px;
    background: hsl(var(--card));
    border-radius: 16px;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 16px;
}

.section-header h3 {
    font-size: 14px;
    font-weight: 600;
    color: hsl(var(--foreground));
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.tech-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tech-badge {
    padding: 8px 16px;
    font-size: 13px;
    font-weight: 500;
    color: hsl(var(--foreground));
    background: hsl(var(--secondary));
    border-radius: 999px;
    transition: all 0.2s ease;
}

.tech-badge:hover {
    background: hsl(var(--muted));
    transform: translateY(-2px);
}

/* Links Section */
.links-section {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.project-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px;
    font-size: 15px;
    font-weight: 500;
    color: hsl(var(--foreground));
    background: hsl(var(--card));
    border-radius: 12px;
    border: 1px solid hsl(var(--border));
    transition: all 0.2s ease;
}

.project-link:hover {
    background: hsl(var(--secondary));
    border-color: hsl(var(--muted));
    transform: translateX(4px);
}

.project-link.live:hover {
    border-color: hsl(var(--primary));
}

/* Meta Section */
.meta-section {
    padding-top: 24px;
    border-top: 1px solid hsl(var(--border));
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: hsl(var(--muted-foreground));
}
</style>
