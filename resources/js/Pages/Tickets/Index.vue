<template>
    <AppLayout>
        <div
            class="flex p-4 lg:flex-row"
            :class="showCreateForm ? 'gap-4' : ''"
        >
            <DataTable
                :tickets="props.tickets"
                :clients="clients"
                :devices="props.devices"
                :brands="props.brands"
                :types="props.types"
                :pendingTickets="pendingTickets"
                :deliveredTickets="deliveredTickets"
                @updateDeliveredTickets="deliveredTickets = $event"
                @updatePendingTickets="pendingTickets = $event"
                @button-click="buttonClick"
            />
            <CreateTicket
                :devices="devices"
                :technicians="technicians"
                :clients="clients"
                :brands="brands"
                :types="types"
                @close="showCreateForm = false"
                class="transition-all duration-500"
                :class="
                    showCreateForm
                        ? 'translate-x-0 w-full lg:w-96'
                        : 'translate-x-full opacity-0 w-0'
                "
            />
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import DataTable from "./DataTable.vue";
import CreateTicket from "./CreateTicket.vue";

const props = defineProps({
    tickets: Array,
    technicians: Array,
    devices: Array,
    brands: Array,
    types: Array,
    clients: Array,
    messages: String,
});

const pendingTickets = ref(true);
const deliveredTickets = ref(false);
const showCreateForm = ref(false);

const buttonClick = () => {
    showCreateForm.value = true;
};
</script>
