<template>
    <Button
        variant="custom"
        class="flex items-center gap-2 transition-colors group hover:bg-indigo-600"
        @click.prevent="goBack"
    >
        <font-awesome-icon
            icon="fa-solid fa-arrow-left"
            class="transition-transform group-hover:-translate-x-1"
        />
        <span>Retour</span>
    </Button>
</template>

<script setup>
import { Button } from "@/Components/ui/button";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    route: {
        type: String,
        required: false,
    },
});

const goBack = () => {
    router.visit(props.route ?? window.history.back());
};
</script>
