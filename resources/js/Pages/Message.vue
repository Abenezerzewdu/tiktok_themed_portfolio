<script setup>
import TikTokLayout from "@/Layouts/TikTokLayout.vue";
import { reactive, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { Send, Github, Mail, MessageCircle, Linkedin, ArrowLeft } from "lucide-vue-next";

const form = reactive({
    name: "",
    email: "",
    message: "",
});

const isSubmitting = ref(false);
const showSuccess = ref(false);

const suggestions = [
    { text: "I wanna hire you" },
    { text: "Let's talk" },
    { text: "Got a project idea" },
    { text: "Just saying hi" },
    { text: "Collaboration?" },
];

const socialLinks = [
    { 
        name: "GitHub", 
        icon: Github, 
        url: "https://github.com/Abenezerzewdu", 
        color: "#333",
        hoverColor: "#24292e"
    },
    { 
        name: "Email", 
        icon: Mail, 
        url: "mailto:abenezerzewdu@example.com", 
        color: "hsl(var(--primary))",
        hoverColor: "hsl(var(--primary))"
    },
    { 
        name: "Telegram", 
        icon: MessageCircle, 
        url: "https://t.me/yourusername", 
        color: "#0088cc",
        hoverColor: "#006699"
    },
    { 
        name: "LinkedIn", 
        icon: Linkedin, 
        url: "https://linkedin.com/in/yourusername", 
        color: "#0077b5",
        hoverColor: "#005582"
    },
];

const selectSuggestion = (suggestion) => {
    form.message = suggestion.text;
};

const submit = () => {
    if (!form.email || !form.message) return;
    
    isSubmitting.value = true;
    router.post("/message", form, {
        onSuccess: () => {
            showSuccess.value = true;
            form.name = "";
            form.email = "";
            form.message = "";
            setTimeout(() => {
                showSuccess.value = false;
            }, 3000);
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
};
</script>

<template>
    <TikTokLayout>
        <div class="message-page">
            <!-- Left Panel - Contact Info (Desktop) -->
            <aside class="contact-sidebar">
                <div class="sidebar-content">
                    <!-- Profile Section -->
                    <div class="profile-section">
                        <div class="profile-avatar">
                            <span>Ab</span>
                        </div>
                        <h2 class="profile-name">Abenezer Zewdu</h2>
                        <p class="profile-title">Full Stack Developer</p>
                        <div class="status-badge">
                            <span class="status-dot"></span>
                            Available for work
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="social-section">
                        <h3 class="section-title">Connect with me</h3>
                        <div class="social-grid">
                            <a
                                v-for="link in socialLinks"
                                :key="link.name"
                                :href="link.url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="social-card"
                                :style="{ '--hover-bg': link.hoverColor }"
                            >
                                <component :is="link.icon" class="social-card-icon" />
                                <span class="social-card-name">{{ link.name }}</span>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Info -->
                    <div class="quick-info">
                        <p class="info-text">Response time: Within 24 hours</p>
                    </div>
                </div>
            </aside>

            <!-- Main Chat Area -->
            <main class="chat-main">
                <!-- Chat Header -->
                <header class="chat-header">
                    <div class="header-left">
                        <div class="header-avatar">
                            <span>Ab</span>
                        </div>
                        <div class="header-info">
                            <h1 class="header-title">New Message</h1>
                            <span class="header-subtitle">to Abenezer Zewdu</span>
                        </div>
                    </div>
                    <!-- Mobile Social Links -->
                    <div class="mobile-social">
                        <a
                            v-for="link in socialLinks"
                            :key="link.name"
                            :href="link.url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mobile-social-btn"
                        >
                            <component :is="link.icon" class="mobile-social-icon" />
                        </a>
                    </div>
                </header>

                <!-- Chat Messages Area -->
                <div class="chat-messages">
                    <!-- Welcome Message -->
                    <div class="message-group received">
                        <div class="message-avatar">
                            <span>Ab</span>
                        </div>
                        <div class="message-content">
                            <div class="message-bubble">
                                <p>Hey there! Thanks for stopping by my portfolio.</p>
                            </div>
                            <div class="message-bubble">
                                <p>I&apos;m always excited to connect with new people. Whether you have a project in mind, want to discuss opportunities, or just want to say hi - I&apos;d love to hear from you!</p>
                            </div>
                            <div class="message-bubble">
                                <p>What brings you here today?</p>
                            </div>
                            <span class="message-timestamp">Just now</span>
                        </div>
                    </div>

                    <!-- Success Message -->
                    <Transition name="message-slide">
                        <div v-if="showSuccess" class="message-group sent">
                            <div class="message-content">
                                <div class="message-bubble sent-bubble">
                                    <p>Message sent! I&apos;ll get back to you soon.</p>
                                </div>
                            </div>
                        </div>
                    </Transition>
                </div>

                <!-- Quick Suggestions -->
                <div class="suggestions-bar">
                    <div class="suggestions-scroll">
                        <button
                            v-for="suggestion in suggestions"
                            :key="suggestion.text"
                            @click="selectSuggestion(suggestion)"
                            class="suggestion-pill"
                            :class="{ 'active': form.message === suggestion.text }"
                        >
                            {{ suggestion.text }}
                        </button>
                    </div>
                </div>

                <!-- Input Area -->
                <div class="input-container">
                    <form @submit.prevent="submit" class="message-form">
                        <!-- User Info Row -->
                        <div class="user-info-row">
                            <input
                                v-model="form.name"
                                type="text"
                                placeholder="Your name (optional)"
                                class="info-input"
                            />
                            <input
                                v-model="form.email"
                                type="email"
                                placeholder="Your email *"
                                required
                                class="info-input email-input"
                            />
                        </div>
                        <!-- Message Row -->
                        <div class="compose-row">
                            <textarea
                                v-model="form.message"
                                placeholder="Write a message..."
                                rows="1"
                                required
                                class="compose-input"
                                @input="e => e.target.style.height = 'auto'; e.target.style.height = Math.min(e.target.scrollHeight, 120) + 'px'"
                            ></textarea>
                            <button
                                type="submit"
                                class="send-btn"
                                :disabled="isSubmitting || !form.email || !form.message"
                                :class="{ 'can-send': form.email && form.message }"
                            >
                                <Send class="send-btn-icon" :class="{ 'sending': isSubmitting }" />
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </TikTokLayout>
</template>

<style scoped>
/* Full Page Layout */
.message-page {
    width: 100%;
    height: 100vh;
    display: flex;
    background: hsl(var(--background));
    overflow: hidden;
}

/* Contact Sidebar - Desktop Only */
.contact-sidebar {
    width: 320px;
    background: hsl(var(--card));
    border-right: 1px solid hsl(var(--border));
    display: none;
    flex-direction: column;
}

@media (min-width: 1024px) {
    .contact-sidebar {
        display: flex;
    }
}

.sidebar-content {
    flex: 1;
    padding: 32px 24px;
    display: flex;
    flex-direction: column;
    gap: 32px;
    overflow-y: auto;
}

/* Profile Section */
.profile-section {
    text-align: center;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, hsl(var(--primary)), hsl(var(--accent)));
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 28px;
    color: white;
    margin: 0 auto 16px;
    box-shadow: 0 8px 32px hsl(var(--primary) / 0.3);
}

.profile-name {
    font-size: 20px;
    font-weight: 700;
    color: hsl(var(--foreground));
    margin: 0 0 4px;
}

.profile-title {
    font-size: 14px;
    color: hsl(var(--muted-foreground));
    margin: 0 0 16px;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: hsl(var(--secondary));
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    color: hsl(var(--foreground));
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #22c55e;
    animation: pulse-glow 2s ease-in-out infinite;
}

@keyframes pulse-glow {
    0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
    50% { opacity: 0.8; box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
}

/* Social Section */
.social-section {
    flex: 1;
}

.section-title {
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: hsl(var(--muted-foreground));
    margin: 0 0 16px;
}

.social-grid {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.social-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    background: hsl(var(--secondary));
    border-radius: 12px;
    color: hsl(var(--foreground));
    text-decoration: none;
    transition: all 0.2s ease;
}

.social-card:hover {
    background: var(--hover-bg);
    color: white;
    transform: translateX(4px);
}

.social-card-icon {
    width: 20px;
    height: 20px;
}

.social-card-name {
    font-size: 14px;
    font-weight: 500;
}

/* Quick Info */
.quick-info {
    padding-top: 16px;
    border-top: 1px solid hsl(var(--border));
}

.info-text {
    font-size: 13px;
    color: hsl(var(--muted-foreground));
    margin: 0;
}

/* Main Chat Area */
.chat-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-width: 0;
    background: hsl(var(--background));
}

/* Chat Header */
.chat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    background: hsl(var(--card));
    border-bottom: 1px solid hsl(var(--border));
    flex-shrink: 0;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.header-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, hsl(var(--primary)), hsl(var(--accent)));
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    color: white;
}

@media (min-width: 1024px) {
    .header-avatar {
        display: none;
    }
}

.header-info {
    display: flex;
    flex-direction: column;
}

.header-title {
    font-size: 16px;
    font-weight: 600;
    color: hsl(var(--foreground));
    margin: 0;
}

.header-subtitle {
    font-size: 13px;
    color: hsl(var(--muted-foreground));
}

/* Mobile Social Links */
.mobile-social {
    display: flex;
    gap: 8px;
}

@media (min-width: 1024px) {
    .mobile-social {
        display: none;
    }
}

.mobile-social-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: hsl(var(--secondary));
    display: flex;
    align-items: center;
    justify-content: center;
    color: hsl(var(--foreground));
    transition: all 0.2s ease;
}

.mobile-social-btn:hover {
    background: hsl(var(--primary));
    color: white;
}

.mobile-social-icon {
    width: 18px;
    height: 18px;
}

/* Chat Messages */
.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 24px 20px;
    display: flex;
    flex-direction: column;
    gap: 24px;
}

@media (min-width: 768px) {
    .chat-messages {
        padding: 32px 48px;
    }
}

.message-group {
    display: flex;
    gap: 12px;
    max-width: 600px;
}

.message-group.received {
    align-self: flex-start;
}

.message-group.sent {
    align-self: flex-end;
    flex-direction: row-reverse;
}

.message-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, hsl(var(--primary)), hsl(var(--accent)));
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 12px;
    color: white;
    flex-shrink: 0;
}

.message-content {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.message-bubble {
    background: hsl(var(--card));
    border: 1px solid hsl(var(--border));
    padding: 12px 16px;
    border-radius: 18px;
    border-top-left-radius: 4px;
    color: hsl(var(--foreground));
    font-size: 15px;
    line-height: 1.5;
}

.message-bubble p {
    margin: 0;
}

.message-group.received .message-bubble:first-of-type {
    border-top-left-radius: 18px;
}

.sent-bubble {
    background: hsl(var(--primary));
    border-color: hsl(var(--primary));
    color: white;
    border-radius: 18px;
    border-top-right-radius: 4px;
}

.message-timestamp {
    font-size: 11px;
    color: hsl(var(--muted-foreground));
    padding-left: 4px;
    margin-top: 4px;
}

/* Suggestions Bar */
.suggestions-bar {
    padding: 12px 20px;
    background: hsl(var(--card));
    border-top: 1px solid hsl(var(--border));
    flex-shrink: 0;
}

@media (min-width: 768px) {
    .suggestions-bar {
        padding: 16px 48px;
    }
}

.suggestions-scroll {
    display: flex;
    gap: 8px;
    overflow-x: auto;
    padding-bottom: 4px;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}

.suggestions-scroll::-webkit-scrollbar {
    display: none;
}

.suggestion-pill {
    background: hsl(var(--secondary));
    border: 1px solid hsl(var(--border));
    color: hsl(var(--foreground));
    padding: 10px 18px;
    border-radius: 24px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
    flex-shrink: 0;
}

.suggestion-pill:hover {
    background: hsl(var(--primary) / 0.1);
    border-color: hsl(var(--primary));
    color: hsl(var(--primary));
}

.suggestion-pill.active {
    background: hsl(var(--primary));
    border-color: hsl(var(--primary));
    color: white;
}

/* Input Container */
.input-container {
    padding: 16px 20px 24px;
    background: hsl(var(--card));
    border-top: 1px solid hsl(var(--border));
    flex-shrink: 0;
}

@media (min-width: 768px) {
    .input-container {
        padding: 20px 48px 32px;
    }
}

@media (max-width: 1023px) {
    .input-container {
        padding-bottom: calc(24px + 72px); /* Account for mobile bottom nav */
    }
}

.message-form {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-width: 800px;
}

.user-info-row {
    display: flex;
    gap: 12px;
}

@media (max-width: 640px) {
    .user-info-row {
        flex-direction: column;
        gap: 10px;
    }
}

.info-input {
    flex: 1;
    background: hsl(var(--secondary));
    border: 1px solid hsl(var(--border));
    border-radius: 12px;
    padding: 12px 16px;
    color: hsl(var(--foreground));
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s ease;
}

.info-input:focus {
    border-color: hsl(var(--primary));
}

.info-input::placeholder {
    color: hsl(var(--muted-foreground));
}

.email-input {
    flex: 1.2;
}

.compose-row {
    display: flex;
    gap: 12px;
    align-items: flex-end;
}

.compose-input {
    flex: 1;
    background: hsl(var(--secondary));
    border: 1px solid hsl(var(--border));
    border-radius: 24px;
    padding: 14px 20px;
    color: hsl(var(--foreground));
    font-size: 15px;
    resize: none;
    outline: none;
    min-height: 52px;
    max-height: 120px;
    line-height: 1.4;
    transition: border-color 0.2s ease;
}

.compose-input:focus {
    border-color: hsl(var(--primary));
}

.compose-input::placeholder {
    color: hsl(var(--muted-foreground));
}

.send-btn {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: hsl(var(--secondary));
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.send-btn.can-send {
    background: hsl(var(--primary));
}

.send-btn:hover:not(:disabled).can-send {
    transform: scale(1.05);
    box-shadow: 0 4px 20px hsl(var(--primary) / 0.4);
}

.send-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.send-btn-icon {
    width: 22px;
    height: 22px;
    color: hsl(var(--muted-foreground));
    transition: color 0.2s ease;
}

.send-btn.can-send .send-btn-icon {
    color: white;
}

.send-btn-icon.sending {
    animation: pulse 1s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(0.9); }
}

/* Message Transitions */
.message-slide-enter-active,
.message-slide-leave-active {
    transition: all 0.3s ease;
}

.message-slide-enter-from,
.message-slide-leave-to {
    opacity: 0;
    transform: translateY(20px);
}
</style>
