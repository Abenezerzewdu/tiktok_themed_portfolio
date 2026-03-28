<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import {
    Home,
    Compass,
    Users,
    Upload,
    User,
    MessageCircle,
    Menu,
    X,
    BookOpen,
} from "lucide-vue-next";

const page = usePage();
const mobileMenuOpen = ref(false);

const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
};
</script>

<template>
    <div class="flex h-screen overflow-hidden bg-background">
        <!-- Desktop Sidebar -->
        <aside
            class="hidden lg:flex w-[240px] flex-col border-r border-border bg-background"
        >
            <!-- Logo -->
            <div class="flex items-center gap-3 px-6 py-5">
                <div
                    class="flex h-10 w-30 items-center justify-center rounded-lg bg-primary"
                >
                    <span class="text-lg font-bold text-primary-foreground"
                        >Ab's</span
                    >
                </div>
                <span class="text-xl font-bold text-foreground">Portfolio</span>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4">
                <div class="space-y-1">
                    <Link
                        href="/"
                        class="group flex items-center gap-4 rounded-lg px-4 py-3 text-foreground transition-all duration-200 hover:bg-secondary"
                    >
                        <Home
                            class="h-6 w-6 text-muted-foreground group-hover:text-primary transition-colors"
                        />
                        <span class="font-medium">For You</span>
                    </Link>

                    <Link
                        href="#"
                        class="group flex items-center gap-4 rounded-lg px-4 py-3 text-foreground transition-all duration-200 hover:bg-secondary"
                    >
                        <Compass
                            class="h-6 w-6 text-muted-foreground group-hover:text-primary transition-colors"
                        />
                        <span class="font-medium">Explore</span>
                    </Link>

                    <Link
                        href="/me"
                        class="group flex items-center gap-4 rounded-lg px-4 py-3 text-foreground transition-all duration-200 hover:bg-secondary"
                    >
                        <BookOpen
                            class="h-6 w-6 text-muted-foreground group-hover:text-primary transition-colors"
                        />
                       
                    </Link>

                    <Link
                        href="/admin"
                        class="group flex items-center gap-4 rounded-lg px-4 py-3 text-foreground transition-all duration-200 hover:bg-secondary"
                    >
                        <Upload
                            class="h-6 w-6 text-muted-foreground group-hover:text-primary transition-colors"
                        />
                        <span class="font-medium">Upload</span>
                    </Link>

                    <Link
                        href="/message"
                        class="group flex items-center gap-4 rounded-lg px-4 py-3 text-foreground transition-all duration-200 hover:bg-secondary"
                    >
                        <MessageCircle
                            class="h-6 w-6 text-muted-foreground group-hover:text-primary transition-colors"
                        />
                        <span class="font-medium">Message</span>
                    </Link>
                </div>

                <!-- Divider -->
                <div class="my-4 border-t border-border"></div>

                <!-- Suggested accounts section -->
                <div class="px-4">
                    <h3
                        class="mb-3 text-sm font-semibold text-muted-foreground"
                    >
                        Suggested accounts
                    </h3>
                    <div class="space-y-3">
                        <div
                            class="flex items-center gap-3 cursor-pointer group"
                        >
                            <div
                                class="h-8 w-8 rounded-full bg-gradient-to-br from-primary to-accent"
                            ></div>
                            <div>
                                <p
                                    class="text-sm font-medium text-foreground group-hover:text-primary transition-colors"
                                >
                                    @developer
                                </p>
                                <p class="text-xs text-muted-foreground">
                                    10.2K followers
                                </p>
                            </div>
                        </div>
                        <div
                            class="flex items-center gap-3 cursor-pointer group"
                        >
                            <div
                                class="h-8 w-8 rounded-full bg-gradient-to-br from-accent to-primary"
                            ></div>
                            <div>
                                <p
                                    class="text-sm font-medium text-foreground group-hover:text-primary transition-colors"
                                >
                                    @designer
                                </p>
                                <p class="text-xs text-muted-foreground">
                                    8.5K followers
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Profile -->
            <div class="border-t border-border p-4">
                <Link
                    href="#"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-200 hover:bg-secondary"
                >
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-primary to-accent"
                    >
                        <User class="h-5 w-5 text-white" />
                    </div>
                    <div>
                        <p class="font-medium text-foreground">Abenezer</p>
                        <p class="text-xs text-muted-foreground">@abe.dev</p>
                    </div>
                </Link>
            </div>
        </aside>

        <!-- Mobile Header -->
        <div
            class="lg:hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-4 py-3 bg-background/80 backdrop-blur-lg border-b border-border"
        >
            <div class="flex items-center gap-2">
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary"
                >
                    <span class="text-sm font-bold text-primary-foreground"
                        >Ab</span
                    >
                </div>
                <span class="text-lg font-bold text-foreground">Portfolio</span>
            </div>
            <button
                @click="toggleMobileMenu"
                class="p-2 rounded-lg hover:bg-secondary transition-colors"
            >
                <Menu v-if="!mobileMenuOpen" class="h-6 w-6 text-foreground" />
                <X v-else class="h-6 w-6 text-foreground" />
            </button>
        </div>

        <!-- Mobile Menu Overlay -->
        <Transition
            enter-active-class="transition-opacity duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="mobileMenuOpen"
                class="lg:hidden fixed inset-0 z-40 bg-background/95 backdrop-blur-lg pt-16"
            >
                <nav class="px-6 py-8 space-y-2">
                    <Link
                        href="/"
                        @click="mobileMenuOpen = false"
                        class="flex items-center gap-4 rounded-xl px-4 py-4 text-foreground transition-all duration-200 hover:bg-secondary active:scale-95"
                    >
                        <Home class="h-6 w-6 text-primary" />
                        <span class="text-lg font-medium">For You</span>
                    </Link>

                    <Link
                        href="#"
                        @click="mobileMenuOpen = false"
                        class="flex items-center gap-4 rounded-xl px-4 py-4 text-foreground transition-all duration-200 hover:bg-secondary active:scale-95"
                    >
                        <Compass class="h-6 w-6 text-muted-foreground" />
                        <span class="text-lg font-medium">Explore</span>
                    </Link>

                    <Link
                        href="/admin"
                        @click="mobileMenuOpen = false"
                        class="flex items-center gap-4 rounded-xl px-4 py-4 text-foreground transition-all duration-200 hover:bg-secondary active:scale-95"
                    >
                        <Upload class="h-6 w-6 text-muted-foreground" />
                        <span class="text-lg font-medium">Upload</span>
                    </Link>

                    <Link
                        href="/about"
                        @click="mobileMenuOpen = false"
                        class="flex items-center gap-4 rounded-xl px-4 py-4 text-foreground transition-all duration-200 hover:bg-secondary active:scale-95"
                    >
                        <BookOpen class="h-6 w-6 text-muted-foreground" />
                        <span class="text-lg font-medium">Me</span>
                    </Link>
                </nav>
            </div>
        </Transition>

        <!-- Main Content -->
        <main
            class="flex-1 bg-background lg:pt-0 pt-14"
            :class="
                page.url === '/message'
                    ? 'flex items-stretch'
                    : 'flex justify-center items-center'
            "
        >
            <slot />
        </main>

        <!-- Mobile Bottom Navigation -->
        <nav
            class="lg:hidden fixed bottom-0 left-0 right-0 z-50 flex items-center justify-around py-2 bg-background/80 backdrop-blur-lg border-t border-border safe-area-bottom"
        >
            <Link
                href="/"
                class="flex flex-col items-center gap-1 px-4 py-2 transition-transform active:scale-90"
            >
                <Home class="h-6 w-6 text-primary" />
                <span class="text-xs text-foreground">Home</span>
            </Link>

            <Link
                href="#"
                class="flex flex-col items-center gap-1 px-4 py-2 transition-transform active:scale-90"
            >
                <Compass class="h-6 w-6 text-muted-foreground" />
                <span class="text-xs text-muted-foreground">Explore</span>
            </Link>

            <Link
                href="/admin"
                class="flex flex-col items-center gap-1 px-4 py-2 transition-transform active:scale-90"
            >
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-r from-accent to-primary"
                >
                    <Upload class="h-5 w-5 text-white" />
                </div>
            </Link>

            <Link
                href="#"
                class="flex flex-col items-center gap-1 px-4 py-2 transition-transform active:scale-90"
            >
                <MessageCircle class="h-6 w-6 text-muted-foreground" />
                <span class="text-xs text-muted-foreground">Inbox</span>
            </Link>

            <Link
                href="/about"
                class="flex flex-col items-center gap-1 px-4 py-2 transition-transform active:scale-90"
            >
                <BookOpen class="h-6 w-6 text-muted-foreground" />
                <span class="text-xs text-muted-foreground">Me</span>
            </Link>
        </nav>
    </div>
</template>

<style scoped>
.safe-area-bottom {
    padding-bottom: env(safe-area-inset-bottom, 8px);
}
</style>
