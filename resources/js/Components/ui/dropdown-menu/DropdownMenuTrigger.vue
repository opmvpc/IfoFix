<script setup>
import { DropdownMenuTrigger, useForwardProps } from "radix-vue";

const props = defineProps({
    disabled: { type: Boolean, required: false },
    asChild: { type: Boolean, required: false },
    as: { type: null, required: false },
});

const forwardedProps = useForwardProps(props);
</script>

<template>
    <DropdownMenuTrigger
        class="outline-none text-muted-foreground bg-indigo-50/50 dark:bg-indigo-400/30 dark:text-white dark:hover:bg-indigo-400/40 hover:bg-indigo-50"
        v-bind="forwardedProps"
    >
        <slot />
    </DropdownMenuTrigger>
</template>
