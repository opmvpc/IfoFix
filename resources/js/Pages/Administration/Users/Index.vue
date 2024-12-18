<template>
    <div class="flex md:gap-2 grow">
        <UsersList
            :users="usersList"
            :class="[
                'transition-all duration-300 ease-in-out',
                selectedUser ? 'w-0 hidden md:w-2/3 md:block' : 'w-full',
            ]"
            @user-selected="setSelectedUser"
        />
        <UserProfile
            v-if="selectedUser"
            :user="selectedUser"
            @user-selected="setSelectedUser"
            class="w-1/3 transition-all duration-300 ease-in-out"
            :class="selectedUser ? 'w-full md:w-1/3' : 'w-0'"
        />
    </div>
</template>

<script setup>
import UsersList from "@/Pages/Administration/Users/Partials/List.vue";
import UserProfile from "@/Pages/Administration/Users/Partials/Show.vue";
import { ref, watch } from "vue";

const { users } = defineProps({
    users: {
        type: Array,
    },
});

const usersList = ref(users);

const selectedUser = ref(null);

const setSelectedUser = (user) => {
    console.log("setSelectedUser");

    selectedUser.value = user;
};

watch(
    () => users,
    (newUsers) => {
        usersList.value = newUsers;
    },
    { deep: true }
);
</script>
