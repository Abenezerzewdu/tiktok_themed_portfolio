<script setup>
import TikTokLayout from "@/Layouts/TikTokLayout.vue";
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";

const form = reactive({
    name: "",
    email: "",
    message: "",
});

const submit = () => {
    router.post("/message", form);
};
</script>
<template>
    <TikTokLayout>
        <div class="contact-panel">
            <!-- Header -->
            <div class="header">
                <h2>Contact Me</h2>
                <p>Let’s build something great</p>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <button>Email</button>
                <button>GitHub</button>
                <button>LinkedIn</button>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="form">
                <input v-model="form.name" placeholder="Your name" />
                <input v-model="form.email" placeholder="Your email" />
                <textarea
                    v-model="form.message"
                    placeholder="Your message"
                ></textarea>

                <button type="submit" class="submit-btn">Send Message</button>
            </form>
        </div>
    </TikTokLayout>
</template>

<style scoped>
.contact-panel {
    background: #0a0a0a;
    color: white;
    padding: 20px;
    border-radius: 20px;
    width: 100%;
    max-width: 400px;
}

/* Header */
.header h2 {
    font-size: 20px;
    font-weight: 600;
}

.header p {
    font-size: 12px;
    color: #aaa;
}

/* Quick Actions */
.quick-actions {
    display: flex;
    gap: 10px;
    margin: 15px 0;
}

.quick-actions button {
    flex: 1;
    background: #111;
    border: 1px solid #222;
    color: white;
    padding: 8px;
    border-radius: 10px;
}

/* Form */
.form input,
.form textarea {
    width: 100%;
    background: #111;
    border: 1px solid #222;
    color: white;
    padding: 10px;
    border-radius: 10px;
    margin-bottom: 10px;
}

.form textarea {
    min-height: 80px;
}

/* Submit Button */
.submit-btn {
    width: 100%;
    background: #ff2d55;
    color: white;
    padding: 12px;
    border-radius: 12px;
    font-weight: 600;
    border: none;
}
</style>
