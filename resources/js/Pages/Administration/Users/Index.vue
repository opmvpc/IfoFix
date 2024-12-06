<template>
    <div class="flex gap-2 grow">
        <UsersList :users="users" class="w-2/3" />
        <UserCreate class="w-1/3" />
    </div>
</template>

<script setup>
import UsersList from "@/Pages/Administration/Users/Partials/List.vue";
import UserCreate from "@/Pages/Administration/Users/Partials/Create.vue";
import { defineProps } from "vue";

const { users } = defineProps({
    users: {
        type: Array,
    },
});
</script>
