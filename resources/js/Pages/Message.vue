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
    max-width: 1200px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    height: calc(100vh - 0px);
    margin: 0 auto;
}

/* Chat Window */
.chat-window {
    background: hsl(var(--card));
    border-radius: 20px;
    border: 1px solid hsl(var(--border));
    overflow: hidden;
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 0;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

/* Header */
.chat-header {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px 24px;
    border-bottom: 1px solid hsl(var(--border));
    background: linear-gradient(135deg, hsl(var(--secondary)), hsl(var(--background)));
}

.avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(
        135deg,
        hsl(var(--primary)),
        hsl(var(--accent))
    );
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
    color: white;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
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
    font-size: 11px;
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
    background: hsl(var(--background));
}

.chat-body::-webkit-scrollbar {
    width: 6px;
}

.chat-body::-webkit-scrollbar-thumb {
    background: hsl(var(--border));
    border-radius: 99px;
}

.message {
    display: flex;
    flex-direction: column;
    gap: 4px;
    max-width: 75%;
}

.message.received {
    align-self: flex-start;
}

.message.sent {
    align-self: flex-end;
}

.message-bubble {
    background: hsl(var(--card));
    padding: 10px 14px;
    border-radius: 16px;
    border-bottom-left-radius: 4px;
    color: hsl(var(--foreground));
    font-size: 13px;
    line-height: 1.4;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
}

.sent-bubble {
    background: linear-gradient(
        135deg,
        hsl(var(--primary)),
        hsl(var(--primary) / 0.9)
    );
    color: white;
    border-bottom-left-radius: 16px;
    border-bottom-right-radius: 4px;
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.1);
}

.message-time {
    font-size: 10px;
    color: hsl(var(--muted-foreground));
    padding-left: 6px;
}

/* Quick Suggestions */
.suggestions-container {
    padding: 12px 16px;
    border-top: 1px solid hsl(var(--border));
    background: hsl(var(--card));
}

.suggestions-label {
    font-size: 10px;
    color: hsl(var(--muted-foreground));
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
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
    padding: 6px 12px;
    border-radius: 16px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
    font-weight: 400;
}

.suggestion-chip:hover {
    background: linear-gradient(
        135deg,
        hsl(var(--primary) / 0.12),
        hsl(var(--primary) / 0.08)
    );
    border-color: hsl(var(--primary));
    color: hsl(var(--primary));
    transform: translateY(-1px);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}

.suggestion-chip.active {
    background: hsl(var(--primary));
    border-color: hsl(var(--primary));
    color: white;
}

/* Input Area */
.input-area {
    padding: 10px 14px 14px;
    border-top: 1px solid hsl(var(--border));
    background: hsl(var(--card));
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.input-row {
    display: flex;
    gap: 6px;
}
.input-field {
    flex: 1;
    background: hsl(var(--secondary));
    border: 1px solid hsl(var(--border));
    border-radius: 12px;
    padding: 8px 12px;
    color: hsl(var(--foreground));
    font-size: 13px;
    outline: none;
    transition: all 0.2s ease;
}

.input-field:focus {
    border-color: hsl(var(--primary));
    box-shadow: 0 0 0 2px hsl(var(--primary) / 0.08);
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
    padding: 10px 14px;
    color: hsl(var(--foreground));
    font-size: 13px;
    resize: none;
    outline: none;
    min-height: 36px;
    max-height: 80px;
    transition: all 0.2s ease;
}

.message-input:focus {
    border-color: hsl(var(--primary));
    box-shadow: 0 0 0 2px hsl(var(--primary) / 0.08);
}

.message-input::placeholder {
    color: hsl(var(--muted-foreground));
}

.send-button {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(
        135deg,
        hsl(var(--primary)),
        hsl(var(--primary) / 0.9)
    );
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
}

.send-button:hover:not(:disabled) {
    transform: scale(1.05) translateY(-1px);
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
}

.send-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.send-button.sending {
    background: hsl(var(--accent));
}

.send-icon {
    width: 16px;
    height: 16px;
    color: white;
}

/* Social Section */
.social-section {
    text-align: center;
    padding: 10px 8px;
    background: hsl(var(--card));
    border-radius: 14px;
    border: 1px solid hsl(var(--border));
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}

.social-label {
    font-size: 10px;
    color: hsl(var(--muted-foreground));
    margin-bottom: 6px;
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
    background: hsl(var(--secondary));
    border: 1px solid hsl(var(--border));
    border-radius: 12px;
    padding: 8px 14px;
    color: hsl(var(--foreground));
    text-decoration: none;
    font-size: 12px;
    font-weight: 400;
    transition: all 0.2s ease;
}

.social-button:hover {
    border-color: transparent;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.12);
}

.social-icon {
    width: 16px;
    height: 16px;
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
@media (max-width: 1024px) {
    .message-container {
        max-width: 100%;
        padding: 20px;
        height: calc(100vh - 0px);
    }

    .chat-header {
        padding: 16px 20px;
    }

    .chat-body {
        padding: 14px;
    }

    .suggestions-container {
        padding: 10px 16px;
    }

    .input-area {
        padding: 10px 16px 16px;
    }
}

@media (max-width: 768px) {
    .message-container {
        padding: 12px;
        height: calc(100vh - 56px);
        max-width: 100%;
    }

    .chat-header {
        padding: 12px 16px;
        gap: 12px;
    }

    .avatar {
        width: 40px;
        height: 40px;
        font-size: 12px;
    }

    .header-info h2 {
        font-size: 14px;
    }

    .status {
        font-size: 10px;
    }

    .chat-body {
        padding: 12px;
        gap: 10px;
    }

    .message {
        max-width: 85%;
    }

    .message-bubble {
        padding: 8px 12px;
        font-size: 12px;
        border-radius: 14px;
    }

    .sent-bubble {
        border-bottom-left-radius: 14px;
        border-bottom-right-radius: 4px;
    }

    .suggestions-container {
        padding: 8px 12px;
    }

    .suggestion-chip {
        padding: 4px 10px;
        font-size: 11px;
        border-radius: 14px;
    }

    .input-area {
        padding: 8px 12px 12px;
        gap: 8px;
    }

    .input-field {
        padding: 6px 10px;
        font-size: 12px;
        border-radius: 10px;
    }

    .message-input {
        padding: 8px 12px;
        font-size: 12px;
        min-height: 32px;
        max-height: 80px;
        border-radius: 14px;
    }

    .send-button {
        width: 32px;
        height: 32px;
    }

    .send-icon {
        width: 14px;
        height: 14px;
    }

    .social-section {
        padding: 12px;
    }

    .social-button {
        padding: 6px 12px;
        font-size: 11px;
        gap: 6px;
    }

    .social-icon {
        width: 14px;
        height: 14px;
    }

    .social-button span {
        display: none;
    }

    .social-button {
        border-radius: 50%;
        padding: 8px;
    }
}

@media (max-width: 480px) {
    .message-container {
        padding: 8px;
        height: calc(100vh - 56px);
    }

    .chat-header {
        padding: 10px 12px;
    }

    .avatar {
        width: 36px;
        height: 36px;
        font-size: 11px;
    }

    .header-info h2 {
        font-size: 13px;
    }

    .chat-body {
        padding: 10px;
        gap: 8px;
    }

    .message-bubble {
        padding: 6px 10px;
        font-size: 11px;
        border-radius: 12px;
    }

    .sent-bubble {
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 3px;
    }

    .suggestion-chip {
        padding: 3px 8px;
        font-size: 10px;
        border-radius: 12px;
    }

    .input-area {
        padding: 6px 10px 10px;
    }

    .message-input {
        padding: 6px 10px;
        font-size: 11px;
        min-height: 30px;
        border-radius: 12px;
    }

    .send-button {
        width: 30px;
        height: 30px;
    }

    .send-icon {
        width: 12px;
        height: 12px;
    }
}
</style>
