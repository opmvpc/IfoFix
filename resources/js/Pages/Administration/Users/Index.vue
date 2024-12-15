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
            class="w-1/3 transition-all duration-300 ease-in-out"
        />
    </div>
</template>

<script setup>
import UsersList from "@/Pages/Administration/Users/Partials/List.vue";
import UserProfile from "@/Pages/Administration/Users/Partials/Show.vue";
import { provide, ref, watch } from "vue";
import axios from "axios";
import { usePage, router } from "@inertiajs/vue3";

const { users } = defineProps({
    users: {
        type: Array,
    },
});

const usersList = ref(users);

const fetchUsers = () => {
    // console.log("Fetching users...");
    axios.get("/users").then((response) => {
        console.log(response.data);
        usersList.value = response.data;
    });
};
provide("fetchUsers", fetchUsers);

const selectedUser = ref(null);

const setSelectedUser = (user) => {
    selectedUser.value = user;
    // console.log(user);
};
</script>
