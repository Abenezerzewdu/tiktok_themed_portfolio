<script setup>
import { ref, onMounted, watch } from "vue";
import { Link } from "@inertiajs/vue3";
import {
    Heart,
    MessageCircle,
    Share2,
    Bookmark,
    Play,
    Pause,
    Volume2,
    VolumeX,
    ExternalLink,
} from "lucide-vue-next";
import { computed } from "vue";

const props = defineProps({
    project: Object,
    isActive: Boolean,
});
const isExpanded = ref(false);
const maxLength = 20; // adjust based on your UI

const truncatedText = computed(() => {
    return props.project.description?.slice(0, maxLength);
});

const isLong = computed(() => {
    return props.project.description?.length > maxLength;
});

const toggleDescription = () => {
    isExpanded.value = !isExpanded.value;
};
const videoRef = ref(null);
const isPlaying = ref(false);
const isMuted = ref(true);
const showControls = ref(false);

// Intersection observer for auto-play
onMounted(() => {
    const observer = new IntersectionObserver(
        ([entry]) => {
            if (entry.isIntersecting) {
                playVideo();
            } else {
                pauseVideo();
            }
        },
        { threshold: 0.7 },
    );

    if (videoRef.value) {
        observer.observe(videoRef.value);
    }
});

const playVideo = () => {
    if (videoRef.value) {
        videoRef.value.play().catch(() => {});
        isPlaying.value = true;
    }
};

const pauseVideo = () => {
    if (videoRef.value) {
        videoRef.value.pause();
        isPlaying.value = false;
    }
};

const togglePlay = () => {
    if (isPlaying.value) {
        pauseVideo();
    } else {
        playVideo();
    }
};

const toggleMute = () => {
    if (videoRef.value) {
        videoRef.value.muted = !videoRef.value.muted;
        isMuted.value = videoRef.value.muted;
    }
};

// Interaction states
const liked = ref(false);
const saved = ref(false);
const likeCount = ref(Math.floor(Math.random() * 500) + 100);
const commentCount = ref(Math.floor(Math.random() * 100) + 10);

const toggleLike = () => {
    liked.value = !liked.value;
    likeCount.value += liked.value ? 1 : -1;
};

const toggleSave = () => {
    saved.value = !saved.value;
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
        // User cancelled share or not supported
    }
};

const formatCount = (num) => {
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + "M";
    } else if (num >= 1000) {
        return (num / 1000).toFixed(1) + "K";
    }
    return num.toString();
};
</script>

<template>
    <div class="card">
        <!-- Video Container -->
        <div
            class="video-container"
            @click="togglePlay"
            @mouseenter="showControls = true"
            @mouseleave="showControls = false"
        >
            <video
                ref="videoRef"
                :src="props.project.video_url"
                :muted="isMuted"
                loop
                playsinline
                class="video"
                :poster="props.project.thumbnail_url"
            ></video>

            <!-- Play/Pause overlay -->
            <Transition
                enter-active-class="transition-opacity duration-200"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div v-if="!isPlaying" class="play-overlay">
                    <div class="play-button">
                        <Play class="h-12 w-12 text-white fill-white" />
                    </div>
                </div>
            </Transition>

            <!-- Video Controls -->
            <Transition
                enter-active-class="transition-opacity duration-200"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div v-if="showControls" class="video-controls">
                    <button @click.stop="toggleMute" class="control-btn">
                        <Volume2 v-if="!isMuted" class="h-5 w-5" />
                        <VolumeX v-else class="h-5 w-5" />
                    </button>
                </div>
            </Transition>

            <!-- Content Overlay -->
            <div class="content-overlay">
                <!-- Creator info -->
                <div class="creator-info">
                    <div class="creator-avatar">
                        <span
                            class="text-sm font-bold text-primary-foreground"
                            >{{
                                props.project.title?.charAt(0)?.toUpperCase() ||
                                "P"
                            }}</span
                        >
                    </div>
                    <div class="creator-details">
                        <h3 class="creator-name">{{ props.project.title }}</h3>
                        <p class="creator-handle">@abe.dev</p>
                    </div>
                    <button class="follow-btn">Follow</button>
                </div>

                <!-- Description -->
                <!-- Description -->
                <div class="description-wrapper">
                    <p class="description">
                        {{
                            isExpanded
                                ? props.project.description
                                : truncatedText
                        }}
                        <span v-if="!isExpanded && isLong">...</span>
                    </p>

                    <button
                        v-if="isLong"
                        @click="toggleDescription"
                        class="toggle-btn"
                    >
                        {{ isExpanded ? "See less" : "See more" }}
                    </button>
                </div>

                <!-- Tech Stack -->
                <!-- <div v-if="props.project.tech_stack?.length" class="tech-stack">
                    <span
                        v-for="tech in project.tech_stack.slice(0, 4)"
                        :key="tech"
                        class="tech-tag"
                    >
                        #{{ tech }}
                    </span>
                </div> -->

                <!-- Links -->
                <div class="project-links">
                    <Link
                        :href="`/project/${project.slug}`"
                        class="link-btn primary"
                    >
                        <ExternalLink class="h-4 w-4" />
                        View Details
                    </Link>
                </div>
            </div>
        </div>

        <!-- Actions Sidebar -->
        <div class="actions">
            <!-- Profile -->
            <div class="action-item">
                <div class="avatar-ring">
                    <div class="action-avatar">
                        <span class="text-xs font-bold">A</span>
                    </div>
                </div>
            </div>

            <!-- Like -->
            <button class="action-item" @click="toggleLike">
                <div :class="['action-icon', { 'is-liked': liked }]">
                    <Heart :class="{ 'fill-current': liked }" />
                </div>
                <span class="action-count">{{ formatCount(likeCount) }}</span>
            </button>

            <!-- Comment -->
            <button class="action-item">
                <div class="action-icon">
                    <MessageCircle />
                </div>
                <span class="action-count">{{
                    formatCount(commentCount)
                }}</span>
            </button>

            <!-- Save -->
            <button class="action-item" @click="toggleSave">
                <div :class="['action-icon', { 'is-saved': saved }]">
                    <Bookmark :class="{ 'fill-current': saved }" />
                </div>
                <span class="action-count">Save</span>
            </button>

            <!-- Share -->
            <button class="action-item" @click="share">
                <div class="action-icon">
                    <Share2 />
                </div>
                <span class="action-count">Share</span>
            </button>

            <!-- Music disc animation -->
            <div class="music-disc">
                <div :class="['disc-inner', { 'is-spinning': isPlaying }]">
                    <div class="disc-image"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.card {
    position: relative;
    height: 100%;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
}

/* Video Container */
.video-container {
    position: relative;
    height: 100%;
    max-height: calc(100vh - 120px);
    aspect-ratio: 9/16;
    border-radius: 16px;
    overflow: hidden;
    background: hsl(var(--card));
    cursor: pointer;
}

@media (max-width: 640px) {
    .video-container {
        border-radius: 0;
        max-height: 100%;
        height: 100%;
    }

    .card {
        gap: 0;
    }
}

.video {
    height: 100%;
    width: 100%;
    object-fit: cover;
}

/* Play Overlay */
.play-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.2);
}

.play-button {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);
    transition:
        transform 0.2s ease,
        background 0.2s ease;
}

.play-button:hover {
    transform: scale(1.1);
    background: rgba(255, 255, 255, 0.25);
}

/* Video Controls */
.video-controls {
    position: absolute;
    top: 16px;
    right: 16px;
    display: flex;
    gap: 8px;
}

.control-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    transition: background 0.2s ease;
}

.control-btn:hover {
    background: rgba(0, 0, 0, 0.7);
}

/* Content Overlay */
.content-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 80px 16px 24px;
    background: linear-gradient(
        to top,
        rgba(0, 0, 0, 0.9) 0%,
        rgba(0, 0, 0, 0.5) 50%,
        transparent 100%
    );
}

/* Creator Info */
.creator-info {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
}

.creator-avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(
        135deg,
        hsl(var(--primary)),
        hsl(var(--accent))
    );
    flex-shrink: 0;
}

.creator-details {
    flex: 1;
    min-width: 0;
}

.creator-name {
    font-size: 15px;
    font-weight: 600;
    color: white;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.creator-handle {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.7);
}

.follow-btn {
    padding: 6px 16px;
    font-size: 13px;
    font-weight: 600;
    color: white;
    background: hsl(var(--primary));
    border-radius: 4px;
    transition: all 0.2s ease;
}

.follow-btn:hover {
    opacity: 0.9;
    transform: scale(1.02);
}

/* Description */
.description {
    font-size: 14px;
    line-height: 1.5;
    color: rgba(255, 255, 255, 0.9);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 12px;
}

.description-wrapper {
    position: relative;
}

/* .description {
    margin-bottom: 20px;
} */

.toggle-btn {
    position: absolute;
    right: 0;
    bottom: 0;
    background: none;
    border: none;
    color: black;
    font-weight: 600;
    cursor: pointer;
}
/* finished the description section */

/* Tech Stack */
.tech-stack {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
}

.tech-tag {
    font-size: 13px;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.9);
}

/* Project Links */
.project-links {
    display: flex;
    gap: 8px;
}

.link-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    font-size: 15px;
    font-weight: 500;
    border-radius: 999px;
    transition: all 0.2s ease;
}

.link-btn.primary {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);
    color: white;
}

.link-btn.primary:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-1px);
}

/* Actions Sidebar */
.actions {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    padding-bottom: 20px;
}

@media (max-width: 640px) {
    .actions {
        position: absolute;
        right: 8px;
        bottom: 120px;
        z-index: 10;
    }
}

/* Action Item */
.action-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    cursor: pointer;
}

.action-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: hsl(var(--secondary));
    color: hsl(var(--foreground));
    transition: all 0.2s ease;
}

.action-icon:hover {
    background: hsl(var(--muted));
    transform: scale(1.1);
}

.action-icon svg {
    width: 24px;
    height: 24px;
}

.action-icon.is-liked {
    color: hsl(var(--primary));
}

.action-icon.is-saved {
    color: hsl(var(--accent));
}

.action-count {
    font-size: 12px;
    font-weight: 500;
    color: hsl(var(--foreground));
}

/* Avatar */
.avatar-ring {
    padding: 2px;
    border-radius: 50%;
    background: linear-gradient(
        135deg,
        hsl(var(--primary)),
        hsl(var(--accent))
    );
}

.action-avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: hsl(var(--card));
    color: hsl(var(--foreground));
}

/* Music Disc */
.music-disc {
    margin-top: 8px;
}

.disc-inner {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1a1a1a, #333);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
}

.disc-inner.is-spinning {
    animation: spin 3s linear infinite;
}

.disc-image {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: linear-gradient(
        135deg,
        hsl(var(--primary)),
        hsl(var(--accent))
    );
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
