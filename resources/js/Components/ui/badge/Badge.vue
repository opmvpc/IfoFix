<script setup>
import { cn } from "@/lib/utils";
import { computed } from "vue";

const props = defineProps({
    variant: { type: String, required: false, default: "default" },
    class: { type: null, required: false },
});

const defaultClasses =
    "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium";

const variations = {
    default: "bg-gray-100 text-gray-800",
    primary: "bg-blue-100 text-blue-800",
    secondary: "bg-gray-100 text-gray-800",
    success: "bg-green-100 text-green-800",
    danger: "bg-red-100 text-red-800",
    warning: "bg-yellow-100 text-yellow-800",
    info: "bg-blue-100 text-blue-800",
};

const variantClass = computed(() => {
    return variations[props.variant] || variations.default;
});
</script>

<template>
    <div :class="cn(variantClass, props.class, defaultClasses)">
        <slot />
    </div>
</template>
