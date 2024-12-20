<template>
    <div class="flex gap-2 grow">
        <ClientsList
            :clients="clientsList"
            :class="[
                'transition-all duration-300 ease-in-out',
                selectedClient
                    ? 'w-0 invisible opacity-0 md:w-2/3 md:visible md:opacity-100'
                    : 'w-full',
            ]"
            @client-selected="setSelectedClient"
        />
        <ClientProfile
            v-if="selectedClient"
            :client="selectedClient"
            @client-selected="setSelectedClient"
            class="w-1/3 transition-all duration-300 ease-in-out"
            :class="selectedClient ? 'w-full md:w-1/3' : 'w-0'"
        />
    </div>
</template>

<script setup>
import ClientsList from "@/Pages/Administration/Clients/Partials/List.vue";
import ClientProfile from "@/Pages/Administration/Clients/Partials/Show.vue";
import { ref, watch } from "vue";

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
