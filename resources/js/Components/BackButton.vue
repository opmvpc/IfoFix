<template>
    <Button
        variant="custom"
        class="group flex items-center gap-2 hover:bg-indigo-600 transition-colors"
        @click.prevent="goBack"
    >
        <font-awesome-icon
            icon="fa-solid fa-arrow-left"
            class="group-hover:-translate-x-1 transition-transform"
        />
        <span>Retour</span>
    </Button>
</template>

<script setup>
import { Button } from "@/Components/ui/button";
import { router } from "@inertiajs/vue3";

const goBack = () => {
    router.visit(window.history.back());
};
</script>
