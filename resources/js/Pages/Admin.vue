<script setup>
import { ref } from "vue";
import { router, Link } from "@inertiajs/vue3";
import TikTokLayout from "@/Layouts/TikTokLayout.vue";
import {
    Upload,
    FileVideo,
    Github,
    ExternalLink,
    Code,
    Type,
    FileText,
    ArrowLeft,
    CheckCircle,
    Loader2,
} from "lucide-vue-next";

const form = ref({
    title: "",
    description: "",
    tech_stack: "",
    github_url: "",
    live_url: "",
    video: null,
});

const videoPreview = ref(null);
const isUploading = ref(false);
const uploadSuccess = ref(false);
const dragActive = ref(false);

const handleVideoChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.value.video = file;
        videoPreview.value = URL.createObjectURL(file);
    }
};

const handleDrop = (e) => {
    e.preventDefault();
    dragActive.value = false;
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith("video/")) {
        form.value.video = file;
        videoPreview.value = URL.createObjectURL(file);
    }
};

const handleDragOver = (e) => {
    e.preventDefault();
    dragActive.value = true;
};

const handleDragLeave = () => {
    dragActive.value = false;
};

const submit = () => {
    isUploading.value = true;

    const data = new FormData();

    data.append("title", form.value.title);
    data.append("description", form.value.description);
    data.append("video", form.value.video); // 🔥 explicit
    data.append("github_url", form.value.github_url || "");
    data.append("live_url", form.value.live_url || "");
    data.append("tech_stack", form.value.tech_stack || "");

    router.post("/admin/projects", data, {
        forceFormData: true, // 🔥 critical for files
        onSuccess: () => {
            isUploading.value = false;
            uploadSuccess.value = true;

            setTimeout(() => {
                uploadSuccess.value = false;
            }, 3000);
        },
        onError: (errors) => {
            console.log(errors); // 🔥 SEE what's failing
            isUploading.value = false;
        },
    });
};

const isFormValid = () => {
    return form.value.title && form.value.description && form.value.video;
};
</script>

<template>
    <TikTokLayout>
        <div class="admin-container">
            <!-- Header -->
            <div class="admin-header">
                <Link href="/" class="back-btn">
                    <ArrowLeft class="h-5 w-5" />
                </Link>
                <div>
                    <h1 class="page-title">Upload Project</h1>
                    <p class="page-subtitle">
                        Lets Share my work with the community
                    </p>
                </div>
            </div>

            <!-- Success Message -->
            <Transition
                enter-active-class="transition-all duration-300"
                enter-from-class="opacity-0 -translate-y-4"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition-all duration-300"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-4"
            >
                <div v-if="uploadSuccess" class="success-banner">
                    <CheckCircle class="h-5 w-5" />
                    <span>Project uploaded successfully!</span>
                </div>
            </Transition>

            <div class="form-layout">
                <!-- Video Upload Section -->
                <div class="upload-section">
                    <div
                        :class="[
                            'upload-zone',
                            {
                                'drag-active': dragActive,
                                'has-video': videoPreview,
                            },
                        ]"
                        @drop="handleDrop"
                        @dragover="handleDragOver"
                        @dragleave="handleDragLeave"
                    >
                        <video
                            v-if="videoPreview"
                            :src="videoPreview"
                            class="video-preview"
                            controls
                            muted
                        ></video>

                        <div v-else class="upload-placeholder">
                            <div class="upload-icon">
                                <FileVideo class="h-12 w-12" />
                            </div>
                            <h3 class="upload-title">
                                Drag and drop video here
                            </h3>
                            <p class="upload-hint">or click to browse files</p>
                            <p class="upload-formats">
                                MP4, WebM, or MOV recommended
                            </p>
                        </div>

                        <input
                            type="file"
                            accept="video/*"
                            @change="handleVideoChange"
                            class="file-input"
                        />
                    </div>

                    <div v-if="videoPreview" class="video-actions">
                        <button
                            @click="
                                videoPreview = null;
                                form.video = null;
                            "
                            class="change-video-btn"
                        >
                            Change video
                        </button>
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="form-section">
                    <!-- Title -->
                    <div class="form-group">
                        <label class="form-label">
                            <Type class="h-4 w-4" />
                            <span>Title</span>
                        </label>
                        <input
                            v-model="form.title"
                            type="text"
                            placeholder="My Awesome Project"
                            class="form-input"
                        />
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label class="form-label">
                            <FileText class="h-4 w-4" />
                            <span>Description</span>
                        </label>
                        <textarea
                            v-model="form.description"
                            placeholder="Tell us about your project..."
                            rows="4"
                            class="form-textarea"
                        ></textarea>
                    </div>

                    <!-- Tech Stack -->
                    <div class="form-group">
                        <label class="form-label">
                            <Code class="h-4 w-4" />
                            <span>Tech Stack</span>
                        </label>
                        <input
                            v-model="form.tech_stack"
                            type="text"
                            placeholder="Vue, Laravel, Tailwind CSS"
                            class="form-input"
                        />
                        <p class="form-hint">
                            Separate technologies with commas
                        </p>
                    </div>

                    <!-- GitHub URL -->
                    <div class="form-group">
                        <label class="form-label">
                            <Github class="h-4 w-4" />
                            <span>GitHub URL</span>
                            <span class="optional-badge">Optional</span>
                        </label>
                        <input
                            v-model="form.github_url"
                            type="url"
                            placeholder="https://github.com/username/repo"
                            class="form-input"
                        />
                    </div>

                    <!-- Live URL -->
                    <div class="form-group">
                        <label class="form-label">
                            <ExternalLink class="h-4 w-4" />
                            <span>Live URL</span>
                            <span class="optional-badge">Optional</span>
                        </label>
                        <input
                            v-model="form.live_url"
                            type="url"
                            placeholder="https://myproject.com"
                            class="form-input"
                        />
                    </div>

                    <!-- Submit Button -->
                    <button
                        @click="submit"
                        :disabled="!isFormValid() || isUploading"
                        :class="['submit-btn', { 'is-loading': isUploading }]"
                    >
                        <Loader2
                            v-if="isUploading"
                            class="h-5 w-5 animate-spin"
                        />
                        <Upload v-else class="h-5 w-5" />
                        <span>{{
                            isUploading ? "Uploading..." : "Upload Project"
                        }}</span>
                    </button>
                </div>
            </div>
        </div>
    </TikTokLayout>
</template>

<style scoped>
.admin-container {
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
    padding: 24px;
    overflow-y: auto;
    height: 100vh;
}

@media (max-width: 640px) {
    .admin-container {
        padding: 16px;
        padding-bottom: 100px;
    }
}

/* Header */
.admin-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 32px;
}

.back-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: hsl(var(--secondary));
    color: hsl(var(--foreground));
    transition: all 0.2s ease;
}

.back-btn:hover {
    background: hsl(var(--muted));
    transform: scale(1.05);
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: hsl(var(--foreground));
}

.page-subtitle {
    font-size: 14px;
    color: hsl(var(--muted-foreground));
    margin-top: 4px;
}

/* Success Banner */
.success-banner {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px;
    margin-bottom: 24px;
    background: hsla(142, 76%, 36%, 0.1);
    border: 1px solid hsla(142, 76%, 36%, 0.3);
    border-radius: 12px;
    color: hsl(142, 76%, 50%);
    font-weight: 500;
}

/* Form Layout */
.form-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 48px;
    align-items: start;
}

@media (max-width: 768px) {
    .form-layout {
        grid-template-columns: 1fr;
        gap: 32px;
    }
}

/* Upload Section */
.upload-section {
    position: sticky;
    top: 24px;
}

@media (max-width: 768px) {
    .upload-section {
        position: static;
    }
}

.upload-zone {
    position: relative;
    aspect-ratio: 9/16;
    max-height: 60vh;
    border: 2px dashed hsl(var(--border));
    border-radius: 16px;
    background: hsl(var(--card));
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
}

.upload-zone:hover {
    border-color: hsl(var(--primary));
    background: hsla(var(--primary), 0.05);
}

.upload-zone.drag-active {
    border-color: hsl(var(--primary));
    background: hsla(var(--primary), 0.1);
    transform: scale(1.01);
}

.upload-zone.has-video {
    border-style: solid;
    cursor: default;
}

.file-input {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
}

.has-video .file-input {
    display: none;
}

.video-preview {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.upload-placeholder {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 24px;
    text-align: center;
}

.upload-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: hsl(var(--secondary));
    color: hsl(var(--primary));
    margin-bottom: 16px;
}

.upload-title {
    font-size: 18px;
    font-weight: 600;
    color: hsl(var(--foreground));
    margin-bottom: 8px;
}

.upload-hint {
    font-size: 14px;
    color: hsl(var(--muted-foreground));
    margin-bottom: 8px;
}

.upload-formats {
    font-size: 12px;
    color: hsl(var(--muted-foreground));
    opacity: 0.7;
}

.video-actions {
    margin-top: 12px;
    text-align: center;
}

.change-video-btn {
    font-size: 14px;
    color: hsl(var(--primary));
    font-weight: 500;
    transition: opacity 0.2s ease;
}

.change-video-btn:hover {
    opacity: 0.8;
}

/* Form Section */
.form-section {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: hsl(var(--foreground));
}

.optional-badge {
    font-size: 11px;
    font-weight: 500;
    color: hsl(var(--muted-foreground));
    background: hsl(var(--secondary));
    padding: 2px 8px;
    border-radius: 999px;
    margin-left: auto;
}

.form-input,
.form-textarea {
    width: 100%;
    padding: 14px 16px;
    font-size: 15px;
    color: hsl(var(--foreground));
    background: hsl(var(--card));
    border: 1px solid hsl(var(--border));
    border-radius: 12px;
    transition: all 0.2s ease;
}

.form-input:focus,
.form-textarea:focus {
    outline: none;
    border-color: hsl(var(--primary));
    box-shadow: 0 0 0 3px hsla(var(--primary), 0.1);
}

.form-input::placeholder,
.form-textarea::placeholder {
    color: hsl(var(--muted-foreground));
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
}

.form-hint {
    font-size: 12px;
    color: hsl(var(--muted-foreground));
}

/* Submit Button */
.submit-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 16px 24px;
    font-size: 16px;
    font-weight: 600;
    color: hsl(var(--primary-foreground));
    background: hsl(var(--primary));
    border-radius: 12px;
    transition: all 0.2s ease;
    margin-top: 8px;
}

.submit-btn:hover:not(:disabled) {
    opacity: 0.9;
    transform: translateY(-2px);
}

.submit-btn:active:not(:disabled) {
    transform: scale(0.98);
}

.submit-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.submit-btn.is-loading {
    background: hsl(var(--secondary));
    color: hsl(var(--foreground));
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>
