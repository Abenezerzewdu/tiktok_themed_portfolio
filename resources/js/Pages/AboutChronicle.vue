<script setup>
import TikTokLayout from "@/Layouts/TikTokLayout.vue";
import { ref, onMounted, computed } from "vue";
import { SkipForward, Feather } from "lucide-vue-next";

const props = defineProps({
    aboutText: {
        type: String,
        default: `In this chapter, I write of Abenezer — an Ethiopian web developer, shaped by curiosity and driven by the craft of building. With Laravel as a trusted tool and modern technologies as companions, I design and develop systems that are not only functional, but purposeful.

My work lives at the intersection of structure and creativity — from crafting seamless user interfaces to engineering the logic that powers them. Each project I take on is an opportunity to solve real problems, explore new ideas, and deliver experiences that feel both intuitive and refined.

Though the path is ever unfolding, I move forward with intention — learning, building, and improving with every step. In this ongoing chronicle, my code becomes the ink, and each solution a mark of progress toward something greater.`
    }
});

const displayedText = ref("");
const isTyping = ref(true);
const showCursor = ref(true);
const pageLoaded = ref(false);
const typingSpeed = ref(30);

let typingInterval = null;
let cursorInterval = null;

const skipAnimation = () => {
    if (typingInterval) {
        clearInterval(typingInterval);
    }
    displayedText.value = props.aboutText;
    isTyping.value = false;
};

const startTypewriter = () => {
    let index = 0;
    const text = props.aboutText;
    
    typingInterval = setInterval(() => {
        if (index < text.length) {
            displayedText.value += text.charAt(index);
            index++;
            
            // Vary speed slightly for natural feel
            if (text.charAt(index) === '.' || text.charAt(index) === ',') {
                typingSpeed.value = 80;
            } else if (text.charAt(index) === ' ') {
                typingSpeed.value = 20;
            } else {
                typingSpeed.value = 25 + Math.random() * 15;
            }
        } else {
            clearInterval(typingInterval);
            isTyping.value = false;
        }
    }, typingSpeed.value);
};

const startCursorBlink = () => {
    cursorInterval = setInterval(() => {
        showCursor.value = !showCursor.value;
    }, 530);
};

onMounted(() => {
    setTimeout(() => {
        pageLoaded.value = true;
    }, 100);
    
    setTimeout(() => {
        startTypewriter();
        startCursorBlink();
    }, 600);
});

const formattedText = computed(() => {
    return displayedText.value.split('\n\n').filter(p => p.trim());
});
</script>

<template>
    <TikTokLayout>
        <div class="chronicle-container" :class="{ 'loaded': pageLoaded }">
            <!-- Parchment -->
            <div class="parchment">
                <!-- Decorative corners -->
                <div class="corner corner-tl"></div>
                <div class="corner corner-tr"></div>
                <div class="corner corner-bl"></div>
                <div class="corner corner-br"></div>
                
                <!-- Header -->
                <header class="chronicle-header">
                    <div class="header-ornament">
                        <span class="ornament-line"></span>
                        <Feather class="feather-icon" />
                        <span class="ornament-line"></span>
                    </div>
                    <h1 class="chronicle-title">Chronicle of My Journey</h1>
                    <p class="chronicle-subtitle">A Developer&apos;s Tale</p>
                </header>

                <!-- Content -->
                <div class="chronicle-content">
                    <div class="text-container">
                        <p 
                            v-for="(paragraph, index) in formattedText" 
                            :key="index"
                            class="chronicle-paragraph"
                        >
                            {{ paragraph }}
                        </p>
                        <span 
                            v-if="isTyping || showCursor" 
                            class="cursor"
                            :class="{ 'blink': !isTyping }"
                        >|</span>
                    </div>
                </div>

                <!-- Skip Button -->
                <Transition name="fade">
                    <button 
                        v-if="isTyping" 
                        @click="skipAnimation"
                        class="skip-button"
                    >
                        <SkipForward class="skip-icon" />
                        <span>Skip Animation</span>
                    </button>
                </Transition>

                <!-- Footer ornament -->
                <div class="footer-ornament">
                    <span class="ornament-dot"></span>
                    <span class="ornament-dot"></span>
                    <span class="ornament-dot"></span>
                </div>
            </div>
        </div>
    </TikTokLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Cinzel:wght@400;500;600&display=swap');

.chronicle-container {
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.8s ease, transform 0.8s ease;
    overflow-y: auto;
}

.chronicle-container.loaded {
    opacity: 1;
    transform: translateY(0);
}

/* Parchment */
.parchment {
    position: relative;
    width: 100%;
    max-width: 700px;
    min-height: 500px;
    padding: 50px 45px;
    background: linear-gradient(
        135deg,
        #f5e6c8 0%,
        #f8f0dc 25%,
        #f2e4c4 50%,
        #ecdbb4 75%,
        #e8d4a8 100%
    );
    border-radius: 8px;
    box-shadow: 
        0 0 0 1px rgba(139, 90, 43, 0.2),
        0 4px 20px rgba(0, 0, 0, 0.15),
        inset 0 0 80px rgba(139, 90, 43, 0.08),
        inset 0 0 20px rgba(139, 90, 43, 0.05);
    
    /* Paper texture overlay */
    background-image: 
        url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E"),
        linear-gradient(135deg, #f5e6c8 0%, #f8f0dc 25%, #f2e4c4 50%, #ecdbb4 75%, #e8d4a8 100%);
    background-blend-mode: overlay, normal;
}

/* Vignette effect */
.parchment::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 8px;
    pointer-events: none;
    box-shadow: inset 0 0 100px rgba(139, 90, 43, 0.15);
}

/* Decorative corners */
.corner {
    position: absolute;
    width: 30px;
    height: 30px;
    border-color: #8b5a2b;
    opacity: 0.4;
}

.corner-tl {
    top: 15px;
    left: 15px;
    border-top: 2px solid;
    border-left: 2px solid;
}

.corner-tr {
    top: 15px;
    right: 15px;
    border-top: 2px solid;
    border-right: 2px solid;
}

.corner-bl {
    bottom: 15px;
    left: 15px;
    border-bottom: 2px solid;
    border-left: 2px solid;
}

.corner-br {
    bottom: 15px;
    right: 15px;
    border-bottom: 2px solid;
    border-right: 2px solid;
}

/* Header */
.chronicle-header {
    text-align: center;
    margin-bottom: 35px;
}

.header-ornament {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-bottom: 20px;
}

.ornament-line {
    width: 60px;
    height: 1px;
    background: linear-gradient(90deg, transparent, #8b5a2b, transparent);
}

.feather-icon {
    width: 24px;
    height: 24px;
    color: #8b5a2b;
    opacity: 0.7;
}

.chronicle-title {
    font-family: 'Cinzel', serif;
    font-size: 28px;
    font-weight: 500;
    color: #3d2914;
    letter-spacing: 2px;
    margin: 0 0 8px 0;
    text-shadow: 1px 1px 2px rgba(139, 90, 43, 0.1);
}

.chronicle-subtitle {
    font-family: 'Cormorant Garamond', serif;
    font-size: 16px;
    font-style: italic;
    color: #6b4423;
    margin: 0;
    letter-spacing: 1px;
}

/* Content */
.chronicle-content {
    position: relative;
}

.text-container {
    position: relative;
}

.chronicle-paragraph {
    font-family: 'Cormorant Garamond', serif;
    font-size: 18px;
    line-height: 1.9;
    color: #2d1f0f;
    text-align: justify;
    margin-bottom: 24px;
    text-indent: 30px;
}

.chronicle-paragraph:first-letter {
    font-size: 42px;
    float: left;
    line-height: 1;
    padding-right: 10px;
    padding-top: 4px;
    font-family: 'Cinzel', serif;
    color: #8b5a2b;
    text-indent: 0;
}

.chronicle-paragraph:first-child {
    text-indent: 0;
}

/* Cursor */
.cursor {
    display: inline;
    font-family: 'Cormorant Garamond', serif;
    font-size: 20px;
    color: #3d2914;
    animation: none;
}

.cursor.blink {
    animation: cursorBlink 1s infinite;
}

@keyframes cursorBlink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0; }
}

/* Skip Button */
.skip-button {
    position: absolute;
    bottom: 20px;
    right: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background: rgba(139, 90, 43, 0.1);
    border: 1px solid rgba(139, 90, 43, 0.3);
    border-radius: 6px;
    color: #6b4423;
    font-family: 'Cormorant Garamond', serif;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.skip-button:hover {
    background: rgba(139, 90, 43, 0.2);
    border-color: rgba(139, 90, 43, 0.5);
}

.skip-icon {
    width: 16px;
    height: 16px;
}

/* Footer ornament */
.footer-ornament {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 40px;
    padding-top: 20px;
}

.ornament-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #8b5a2b;
    opacity: 0.4;
}

.ornament-dot:nth-child(2) {
    opacity: 0.6;
}

/* Transitions */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .chronicle-container {
        padding: 16px;
        padding-top: 70px;
        padding-bottom: 90px;
        align-items: flex-start;
    }

    .parchment {
        padding: 35px 25px;
        min-height: auto;
    }

    .chronicle-title {
        font-size: 22px;
    }

    .chronicle-subtitle {
        font-size: 14px;
    }

    .chronicle-paragraph {
        font-size: 16px;
        line-height: 1.8;
        text-align: left;
    }

    .chronicle-paragraph:first-letter {
        font-size: 36px;
    }

    .ornament-line {
        width: 40px;
    }

    .skip-button {
        bottom: 15px;
        right: 15px;
        padding: 8px 14px;
        font-size: 13px;
    }
}

@media (max-width: 480px) {
    .parchment {
        padding: 30px 20px;
    }

    .chronicle-title {
        font-size: 20px;
        letter-spacing: 1px;
    }

    .chronicle-paragraph {
        font-size: 15px;
        margin-bottom: 20px;
        text-indent: 20px;
    }

    .corner {
        width: 20px;
        height: 20px;
    }

    .corner-tl, .corner-tr { top: 10px; }
    .corner-bl, .corner-br { bottom: 10px; }
    .corner-tl, .corner-bl { left: 10px; }
    .corner-tr, .corner-br { right: 10px; }
}
</style>
