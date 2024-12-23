<template>
    <div class="flex items-center gap-2">
        <Switch
            id="dark-mode"
            :checked="isDark"
            @update:checked="toggleDarkMode"
            class="data-[state=checked]:bg-indigo-400"
        />
        <Label for="dark-mode" class="text-sm">
            <font-awesome-icon
                :icon="isDark ? 'fa-solid fa-moon' : 'fa-solid fa-sun'"
                class="w-4 h-4"
            />
        </Label>
    </div>
</template>

<script setup>
import { Switch } from "@/Components/ui/switch";
import { Label } from "@/Components/ui/label";
import { useColorMode } from "@vueuse/core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { computed } from "vue";

const colorMode = useColorMode();

const isDark = computed(() => colorMode.value === "dark");

const toggleDarkMode = (checked) => {
    colorMode.value = checked ? "dark" : "light";
};
</script>
