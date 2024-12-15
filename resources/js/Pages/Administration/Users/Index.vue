<template>
    <div class="flex gap-2 grow">
        <UsersList
            :users="usersList"
            :class="[
                'transition-all duration-300 ease-in-out',
                selectedUser ? 'w-2/3' : 'w-full',
            ]"
            @user-selected="setSelectedUser"
        />
        <UserProfile
            v-if="selectedUser"
            :user="selectedUser"
            @user-updated="fetchUsers"
            class="w-1/3 transition-all duration-300 ease-in-out"
        />
    </div>
</template>

<script setup>
import UsersList from "@/Pages/Administration/Users/Partials/List.vue";
import UserCreate from "@/Pages/Administration/Users/Partials/Create.vue";
import UserProfile from "@/Pages/Administration/Users/Partials/Show.vue";
import { defineProps, ref } from "vue";
import axios from "axios";

const { users } = defineProps({
    users: {
        type: Array,
    },
});

const usersList = ref(users);

const selectedUser = ref(null);

const setSelectedUser = (user) => {
    selectedUser.value = user;
    console.log(user);
};

const fetchUsers = () => {
    axios.get("/users").then((response) => {
        usersList.value = response.data;
    });
};
</script>
