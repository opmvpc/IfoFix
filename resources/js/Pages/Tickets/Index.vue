<template>
    <AppLayout>
        <div class="p-3 flex flex-col gap-3">

            <div class="flex justify-between gap-3">

            </div>
            <div class="flex gap-3">
                <Select v-model="selectedTechnician">
                    <SelectTrigger>
                        <SelectValue placeholder="Technicien" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem :value="aucun"> Aucun </SelectItem>
                            <SelectItem
                                v-for="(technician, index) in technicians"
                                :key="index"
                                :value="technician.id"
                            >
                                {{ technician.firstName }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>

                <Select v-model="selectedDevice">
                    <SelectTrigger>
                        <SelectValue placeholder="Model" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem :value="aucun"> Aucun </SelectItem>
                            <SelectItem
                                v-for="(device, index) in devices"
                                :key="index"
                                :value="device.id"
                                >{{ device.name }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>

                <Select v-model="selectedBrand">
                    <SelectTrigger>
                        <SelectValue placeholder="Marque" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem :value="aucun"> Aucun </SelectItem>
                            <SelectItem
                                v-for="(brand, index) in brands"
                                :key="index"
                                :value="brand.id"
                                >{{ brand.name }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select v-model="selectedType">
                    <SelectTrigger>
                        <SelectValue placeholder="Type" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem :value="aucun"> Aucun </SelectItem>
                            <SelectItem
                                v-for="(type, index) in types"
                                :key="index"
                                :value="type.id"
                                >{{ type.name }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>

            <div class="flex gap-4 items-start">
                <div class="flex-1 p-4 border rounded-lg bg-white shadow">
                    <Test
                    :tickets="filteredTickets"
                    :clients="clients"
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
            @close="showCreateForm = false"
            class="w-96"
        />

            </div>
        </div>
    </AppLayout>
</template>

<script setup ">
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/ui/button/Button.vue";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import { computed, ref } from "vue";
import Test from "./Test.vue";
import CreateTicket from "./CreateTicket.vue";

const props = defineProps({
    tickets: Array,
    technicians: Array,
    devices: Array,
    brands: Array,
    types: Array,
    clients: Array,
});

const pendingTickets = ref(true);
const deliveredTickets = ref(false);
const selectedTechnician = ref(null);
const selectedDevice = ref(null);
const selectedBrand = ref(null);
const selectedType = ref(null);

const filteredTickets = computed(() => {
    let tickets = props.tickets;
    if (pendingTickets.value) {
        tickets = tickets.filter((ticket) => !ticket.isFinished);
    }
    if (deliveredTickets.value) {
        tickets = tickets.filter((ticket) => ticket.isDelivered);
    }
    if (selectedTechnician.value) {
        tickets = tickets.filter(
            (ticket) => ticket.user.id === selectedTechnician.value
        );
    }
    if (selectedDevice.value) {
        tickets = tickets.filter(
            (ticket) => ticket.device.id === selectedDevice.value
        );
    }
    if (selectedBrand.value) {
        tickets = tickets.filter(
            (ticket) => ticket.device.brandId === selectedBrand.value
        );
    }

    if (selectedType.value) {
        tickets = tickets.filter(
            (ticket) => ticket.device.typeId === selectedType.value
        );
    }
    return tickets;
});


const showCreateForm = ref(false);

const buttonClick = () => {
    showCreateForm.value = true;
};

</script>
