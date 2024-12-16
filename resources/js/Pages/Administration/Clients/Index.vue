<template>
    <div class="flex gap-2 grow">
        <ClientsList
            :clients="clientsList"
            :class="[
                'transition-all duration-300 ease-in-out',
                selectedClient ? 'w-2/3' : 'w-full',
            ]"
            @client-selected="setSelectedClient"
        />
        <ClientProfile
            v-if="selectedClient"
            :client="selectedClient"
            class="w-1/3 transition-all duration-300 ease-in-out"
        />
    </div>
</template>

<script setup>
import ClientsList from "@/Pages/Administration/Clients/Partials/List.vue";
import ClientProfile from "@/Pages/Administration/Clients/Partials/Show.vue";
import { defineProps, ref, watch } from "vue";

const { clients } = defineProps({
    clients: {
        type: Array,
    },
});

const clientsList = ref(clients);

const selectedClient = ref(null);

const setSelectedClient = (client) => {
    selectedClient.value = client;
};

watch(
    () => clients,
    (newClients) => {
        clientsList.value = newClients;
    },
    { deep: true }
);
</script>
