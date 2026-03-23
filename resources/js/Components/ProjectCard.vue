<script setup>
import { ref, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";
import { Heart, MessageCircle, Share2 } from "lucide-vue-next";
const props = defineProps({
    project: Object,
});

const videoRef = ref(null);

onMounted(() => {
    const observer = new IntersectionObserver(
        ([entry]) => {
            if (entry.isIntersecting) {
                videoRef.value.play();
            } else {
                videoRef.value.pause();
            }
        },
        { threshold: 0.7 },
    );

    observer.observe(videoRef.value);
});

const togglePlay = () => {
    if (videoRef.value.paused) {
        videoRef.value.play();
    } else {
        videoRef.value.pause();
    }
};

const liked = ref(false);
const likeCount = ref(120); // temporary static

const toggleLike = () => {
    liked.value = !liked.value;
    likeCount.value += liked.value ? 1 : -1;
};
</script>
<!-- we will use these cards for videos -->
<template>
    <div class="card">
        <!-- the video that shows up -->
        <!-- VIDEO WRAPPER -->
        <div class="video-wrapper">
            <video
                @click="togglePlay"
                ref="videoRef"
                :src="project.video_url"
                muted
                loop
                playsinline
                class="video"
            ></video>

            <!-- below the video title description... -->
            <div class="overlay">
                <h2>{{ project.title }}</h2>

                <p class="description">
                    {{ project.description }}
                </p>

                <div class="stack">
                    <span v-for="tech in project.tech_stack" :key="tech">
                        {{ tech }}
                    </span>
                </div>

                <Link :href="`/project/${project.slug}`" class="details-btn">
                    View Details
                </Link>
            </div>
        </div>
        <!-- right side  -->
        <div class="actions">
            <!-- PROFILE -->
            <div class="action">
                <div class="avatar"></div>
            </div>

            <!-- LIKE -->
            <div class="action" @click="toggleLike">
                <Heart :class="{ liked: liked }" />
                <span>{{ likeCount }}</span>
            </div>

            <!-- COMMENT -->
            <div class="action">
                <MessageCircle />
                <span>45</span>
            </div>

            <!-- SHARE -->
            <div class="action">
                <Share2 />
                <span>Share</span>
            </div>
        </div>
    </div>
</template>
<style scoped>
/* ===== CARD ===== */
.card {
    position: relative;
    height: 100vh;
    width: 100%;

    display: flex;
    justify-content: center;
    align-items: center;

    background: black; /* helps visibility */
}

/* ===== VIDEO ===== */
.video {
    height: 100%;
    width: auto;
    max-width: 400px;

    object-fit: cover;
    border-radius: 12px;
}

/* ===== OVERLAY ===== */
.overlay {
    position: absolute;
    bottom: 0;

    width: 400px;
    left: 50%;
    transform: translateX(-50%);

    padding: 20px;
    color: white;

    background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
}

/* ===== ACTIONS ===== */
.actions {
    position: absolute;

    /* 🔥 TEMP: force visible first */
    right: 20px;
    bottom: 120px;

    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;

    z-index: 10; /* 🔥 ensure it's above video */
}

/* ===== ACTION ITEM ===== */
.action {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: white;
    cursor: pointer;
}

.action span {
    font-size: 11px;
    margin-top: 4px;
}

/* ===== ICONS ===== */
.action svg {
    width: 28px;
    height: 28px;
    transition:
        transform 0.15s ease,
        color 0.2s ease;
}

.action:hover svg {
    transform: scale(1.15);
}

/* ===== LIKE ===== */
.liked {
    color: #ff2d55;
    transform: scale(1.2);
}

/* ===== AVATAR ===== */
.avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: gray;
    border: 2px solid white;
}

/* ===== BUTTON ===== */
.details-btn {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 14px;
    font-size: 13px;
    border-radius: 999px;

    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);

    color: white;
    text-decoration: none;

    transition: all 0.2s ease;
}

.details-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-1px);
}

.details-btn:active {
    transform: scale(0.95);
}
</style>
