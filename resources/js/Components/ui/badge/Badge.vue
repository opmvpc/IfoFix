<script setup>
import { cn } from "@/lib/utils";
import { badgeVariants } from ".";

const props = defineProps({
    variant: { type: null, required: false },
    class: { type: null, required: false },
});
</script>

<template>
    <div :class="cn(badgeVariants({ variant }), props.class)">
        <slot />
    </div>
</template>

<style>
.badge-default {
    @apply bg-gray-100 text-gray-600 dark:bg-gray-600 dark:text-gray-100;
}
.badge-primary {
    @apply bg-blue-100 text-blue-600 dark:bg-blue-600 dark:text-blue-100;
}
.badge-secondary {
    @apply bg-gray-100 text-gray-600 dark:bg-gray-600 dark:text-gray-100;
}
.badge-success {
    @apply bg-emerald-100 text-emerald-600 dark:bg-emerald-600 dark:text-emerald-100;
}
.badge-danger {
    @apply bg-red-100 text-red-600 dark:bg-red-600 dark:text-red-100;
}
.badge-warning {
    @apply bg-orange-100 text-orange-600 dark:bg-orange-600 dark:text-orange-100;
}
.badge-info {
    @apply bg-blue-100 text-blue-600 dark:bg-blue-600 dark:text-blue-100;
}
</style>
