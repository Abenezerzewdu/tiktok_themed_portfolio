<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="layout">
        <!-- LEFT SIDEBAR -->
        <aside class="sidebar">
            <h2 class="logo">Abe</h2>

            <nav>
                <Link href="/">Home</Link>
                <!-- <a href="/"></a> -->
                <Link href="/admin">Upload</Link>
                <Link href="#">Profile</Link>
            </nav>
        </aside>

        <!-- MAIN CONTENT (FEED) -->
        <main class="content">
            <slot />
        </main>
    </div>
</template>

<style scoped>
.layout {
    display: flex;
    height: 100vh;
    overflow: hidden;
    background: black;
}

/* LEFT SIDE */
.sidebar {
    width: 220px;
    background: black;
    color: white;
    padding: 20px;
    display: flex;
    flex-direction: column;
}

.logo {
    margin-bottom: 30px;
}

.sidebar a {
    display: block;
    margin-bottom: 15px;
    color: white;
    text-decoration: none;
    opacity: 0.8;
}

.sidebar a:hover {
    opacity: 1;
}

/* CENTER FEED */
.content {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    background: black; /* important */
}
</style>
