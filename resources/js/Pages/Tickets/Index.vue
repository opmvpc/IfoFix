<template>
    <AppLayout>
        <div class="flex flex-col gap-3 p-3">
            <div class="flex items-start gap-4">
                <div class="flex-1 p-4 bg-white border rounded-lg shadow">
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
                    @button-click="buttonClick" />
                </div>
                <CreateTicket
            v-if="showCreateForm"
            :devices="devices"
            :technicians="technicians"
            :clients="clients"
            :brands="brands"
            :types="types"
            @close="showCreateForm = false"
            class="w-96"
        />
            </div>
        </div>
    </AppLayout>
</template>

<script setup ">
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
