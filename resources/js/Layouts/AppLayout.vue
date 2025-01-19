<template>
    <div>
        <Head />

        <div class="relative flex min-h-screen">
            <div
                class="absolute w-full h-full -z-10 bg-gradient-to-b from-indigo-50 to-indigo-100 dark:from-indigo-950 dark:via-indigo-950 dark:to-indigo-950 dark:brightness-75"
            ></div>
            <Nav v-model="showNavigation" />
            <!-- Main Content -->
            <div
                class="flex flex-col w-full h-full overflow-y-auto transition-all duration-300"
                :class="showNavigation ? 'ml-0 md:ml-40 lg:ml-52' : 'ml-0'"
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
                <main
                    class="flex-1 w-full h-screen max-h-screen overflow-hidden"
                >
                    <slot />
                </main>
            </div>
        </div>

        <!-- Add Toaster component at root level -->
        <Toaster />
    </div>
</template>

<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import Nav from "@/Layouts/Nav.vue";
import { ref, watch } from "vue";
import { Toaster } from "@/Components/ui/toast";
import { useToast } from "@/Components/ui/toast/use-toast";

defineProps({
    title: String,
});

const { toast } = useToast();
const showNavigation = ref(localStorage.getItem("navigationState") !== "false");

watch(showNavigation, (newValue) => {
    localStorage.setItem("navigationState", newValue);
});

// Watch for flash messages from the backend
router.on("success", (event) => {
    if (event?.detail?.page?.props?.flash?.success) {
        toast({
            variant: "success",
            title: event.detail.page.props.flash.success,
        });
    }
});

router.on("error", (event) => {
    if (event?.detail?.page?.props?.flash?.error) {
        toast({
            variant: "destructive",
            title: event.detail.page.props.flash.error,
        });
    }
});
</script>
