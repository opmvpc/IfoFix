<template>
    <div>
        <Head />

        <Nav v-model="showNavigation" />

        <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Sidebar -->

            <!-- Main Content -->
            <div
                class="flex flex-col w-full h-full overflow-y-auto transition-all duration-300"
                :class="showNavigation ? 'ml-40 lg:ml-52' : 'ml-0'"
            >
                <!-- Page Heading -->
                <header
                    v-if="$slots.header"
                    class="bg-white shadow dark:bg-gray-800"
                >
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 w-full h-full overflow-hidden">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import Nav from "@/Layouts/Nav.vue";
import { ref, watch, onMounted } from "vue";

defineProps({
    title: String,
});

const showNavigation = ref(localStorage.getItem("navigationState") === "true");

watch(showNavigation, (newValue) => {
    localStorage.setItem("navigationState", newValue);
});
</script>
