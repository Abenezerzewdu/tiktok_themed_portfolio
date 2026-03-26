<script setup>
import TikTokLayout from "@/Layouts/TikTokLayout.vue";
import { reactive, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { Send, Github, Mail, MessageCircle, Linkedin } from "lucide-vue-next";

const form = reactive({
    name: "",
    email: "",
    message: "",
});

const isSubmitting = ref(false);
const showSuccess = ref(false);

const suggestions = [
    { text: "I wanna hire you", icon: "briefcase" },
    { text: "Let's talk", icon: "chat" },
    { text: "Got a project idea", icon: "bulb" },
    { text: "Just saying hi", icon: "wave" },
];

const socialLinks = [
    {
        name: "GitHub",
        icon: Github,
        url: "https://github.com/Abenezerzewdu",
        color: "hover:bg-[#333]",
    },
    {
        name: "Email",
        icon: Mail,
        url: "mailto:abenezerzewdu11@gmail.com",
        color: "hover:bg-primary",
    },
    {
        name: "Telegram",
        icon: MessageCircle,
        url: "https://t.me/Abenaww",
        color: "hover:bg-[#0088cc]",
    },
    {
        name: "LinkedIn",
        icon: Linkedin,
        url: "https://linkedin.com/in/yourusername",
        color: "hover:bg-[#0077b5]",
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
        <div class="message-container">
            <!-- Chat Window -->
            <div class="chat-window">
                <!-- Header -->
                <div class="chat-header">
                    <div class="avatar">
                        <span>Ab</span>
                    </div>
                    <div class="header-info">
                        <h2>Message Abenezer</h2>
                        <span class="status">
                            <span class="status-dot"></span>
                            Available for opportunities
                        </span>
                    </div>
                </div>

                <!-- Chat Body -->
                <div class="chat-body">
                    <!-- Welcome Message -->
                    <div class="message received">
                        <div class="message-bubble">
                            <p>
                                Hey there! Thanks for stopping by my portfolio.
                            </p>
                            <p class="mt-2">What brings you here today?</p>
                        </div>
                        <span class="message-time">Just now</span>
                    </div>

                    <!-- Success Message -->
                    <Transition name="slide">
                        <div v-if="showSuccess" class="message sent">
                            <div class="message-bubble sent-bubble">
                                <p>
                                    Message sent successfully! I'll get back to
                                    you soon.
                                </p>
                            </div>
                        </div>
                    </Transition>
                </div>

                <!-- Quick Suggestions -->
                <div class="suggestions-container">
                    <p class="suggestions-label">Quick replies</p>
                    <div class="suggestions">
                        <button
                            v-for="suggestion in suggestions"
                            :key="suggestion.text"
                            @click="selectSuggestion(suggestion)"
                            class="suggestion-chip"
                            :class="{
                                active: form.message === suggestion.text,
                            }"
                        >
                            {{ suggestion.text }}
                        </button>
                    </div>
                </div>

                <!-- Message Input Area -->
                <form @submit.prevent="submit" class="input-area">
                    <div class="input-row">
                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="Your name (optional)"
                            class="input-field name-field"
                        />
                        <input
                            v-model="form.email"
                            type="email"
                            placeholder="Your email *"
                            required
                            class="input-field email-field"
                        />
                    </div>
                    <div class="message-input-row">
                        <textarea
                            v-model="form.message"
                            placeholder="Type your message..."
                            rows="2"
                            required
                            class="message-input"
                        ></textarea>
                        <button
                            type="submit"
                            class="send-button"
                            :disabled="
                                isSubmitting || !form.email || !form.message
                            "
                            :class="{ sending: isSubmitting }"
                        >
                            <Send
                                class="send-icon"
                                :class="{ 'animate-pulse': isSubmitting }"
                            />
                        </button>
                    </div>
                </form>
            </div>

            <!-- Social Links -->
            <div class="social-section">
                <p class="social-label">Or reach out directly</p>
                <div class="social-links">
                    <a
                        v-for="link in socialLinks"
                        :key="link.name"
                        :href="link.url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="social-button"
                        :class="link.color"
                    >
                        <component :is="link.icon" class="social-icon" />
                        <span>{{ link.name }}</span>
                    </a>
                </div>
            </div>
        </div>
    </TikTokLayout>
</template>

<style scoped>
.message-container {
    width: 100%;
    max-width: 420px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    height: 100%;
    max-height: calc(100vh - 120px);
}

/* Chat Window */
.chat-window {
    background: hsl(var(--card));
    border-radius: 24px;
    border: 1px solid hsl(var(--border));
    overflow: hidden;
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 0;
}

/* Header */
.chat-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    border-bottom: 1px solid hsl(var(--border));
    background: hsl(var(--secondary));
}

.avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(
        135deg,
        hsl(var(--primary)),
        hsl(var(--accent))
    );
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    color: white;
}

.header-info h2 {
    font-size: 16px;
    font-weight: 600;
    color: hsl(var(--foreground));
    margin: 0;
}

.status {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: hsl(var(--muted-foreground));
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #22c55e;
    animation: pulse 2s ease-in-out infinite;
}

/* Chat Body */
.chat-body {
    flex: 1;
    padding: 16px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.message {
    display: flex;
    flex-direction: column;
    gap: 4px;
    max-width: 85%;
}

.message.received {
    align-self: flex-start;
}

.message.sent {
    align-self: flex-end;
}

.message-bubble {
    background: hsl(var(--secondary));
    padding: 12px 16px;
    border-radius: 18px;
    border-bottom-left-radius: 4px;
    color: hsl(var(--foreground));
    font-size: 14px;
    line-height: 1.5;
}

.sent-bubble {
    background: hsl(var(--primary));
    color: white;
    border-bottom-left-radius: 18px;
    border-bottom-right-radius: 4px;
}

.message-time {
    font-size: 11px;
    color: hsl(var(--muted-foreground));
    padding-left: 8px;
}

/* Quick Suggestions */
.suggestions-container {
    padding: 12px 16px;
    border-top: 1px solid hsl(var(--border));
    background: hsl(var(--background));
}

.suggestions-label {
    font-size: 11px;
    color: hsl(var(--muted-foreground));
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.suggestions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.suggestion-chip {
    background: hsl(var(--secondary));
    border: 1px solid hsl(var(--border));
    color: hsl(var(--foreground));
    padding: 8px 14px;
    border-radius: 20px;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.suggestion-chip:hover {
    background: hsl(var(--primary) / 0.15);
    border-color: hsl(var(--primary));
    color: hsl(var(--primary));
}

.suggestion-chip.active {
    background: hsl(var(--primary));
    border-color: hsl(var(--primary));
    color: white;
}

/* Input Area */
.input-area {
    padding: 12px 16px 16px;
    border-top: 1px solid hsl(var(--border));
    background: hsl(var(--card));
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.input-row {
    display: flex;
    gap: 8px;
}

.input-field {
    flex: 1;
    background: hsl(var(--secondary));
    border: 1px solid hsl(var(--border));
    border-radius: 12px;
    padding: 10px 14px;
    color: hsl(var(--foreground));
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s ease;
}

.input-field:focus {
    border-color: hsl(var(--primary));
}

.input-field::placeholder {
    color: hsl(var(--muted-foreground));
}

.message-input-row {
    display: flex;
    gap: 10px;
    align-items: flex-end;
}

.message-input {
    flex: 1;
    background: hsl(var(--secondary));
    border: 1px solid hsl(var(--border));
    border-radius: 16px;
    padding: 12px 16px;
    color: hsl(var(--foreground));
    font-size: 14px;
    resize: none;
    outline: none;
    min-height: 44px;
    max-height: 100px;
    transition: border-color 0.2s ease;
}

.message-input:focus {
    border-color: hsl(var(--primary));
}

.message-input::placeholder {
    color: hsl(var(--muted-foreground));
}

.send-button {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: hsl(var(--primary));
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.send-button:hover:not(:disabled) {
    transform: scale(1.05);
    background: hsl(var(--primary) / 0.9);
}

.send-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.send-button.sending {
    background: hsl(var(--accent));
}

.send-icon {
    width: 20px;
    height: 20px;
    color: white;
}

/* Social Section */
.social-section {
    text-align: center;
}

.social-label {
    font-size: 12px;
    color: hsl(var(--muted-foreground));
    margin-bottom: 12px;
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}

.social-button {
    display: flex;
    align-items: center;
    gap: 8px;
    background: hsl(var(--card));
    border: 1px solid hsl(var(--border));
    border-radius: 12px;
    padding: 10px 16px;
    color: hsl(var(--foreground));
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.social-button:hover {
    border-color: transparent;
    color: white;
    transform: translateY(-2px);
}

.social-icon {
    width: 18px;
    height: 18px;
}

/* Transitions */
.slide-enter-active,
.slide-leave-active {
    transition: all 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
    opacity: 0;
    transform: translateY(10px);
}

/* Responsive */
@media (max-width: 480px) {
    .message-container {
        padding: 12px;
        max-height: calc(100vh - 140px);
    }

    .input-row {
        flex-direction: column;
    }

    .suggestions {
        gap: 6px;
    }

    .suggestion-chip {
        padding: 6px 12px;
        font-size: 12px;
    }

    .social-links {
        gap: 8px;
    }

    .social-button {
        padding: 8px 12px;
        font-size: 12px;
    }

    .social-button span {
        display: none;
    }

    .social-button {
        border-radius: 50%;
        padding: 12px;
    }
}
</style>
