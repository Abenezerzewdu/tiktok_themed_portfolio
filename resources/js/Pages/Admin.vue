<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const form = ref({
    title: "",
    description: "",
    tech_stack: "",
    github_url: "",
    live_url: "",
    video: null,
});

const submit = () => {
    const data = new FormData();

    Object.keys(form.value).forEach((key) => {
        data.append(key, form.value[key]);
    });

    router.post("/admin/projects", data);
};
</script>

<template>
    <div class="admin">
        <h1>Upload Project</h1>

        <input v-model="form.title" placeholder="Title" />
        <textarea
            v-model="form.description"
            placeholder="Description"
        ></textarea>
        <input v-model="form.tech_stack" placeholder="Vue,Laravel" />

        <input v-model="form.github_url" placeholder="GitHub URL" />
        <input v-model="form.live_url" placeholder="Live URL" />

        <input type="file" @change="(e) => (form.video = e.target.files[0])" />

        <button @click="submit">Upload</button>
    </div>
</template>
<style scoped>
.admin {
    max-width: 500px;
    margin: auto;
    padding: 20px;
}

input,
textarea {
    width: 100%;
    margin-bottom: 10px;
    padding: 8px;
}

button {
    padding: 10px;
    width: 100%;
    background: black;
    color: white;
}
</style>
