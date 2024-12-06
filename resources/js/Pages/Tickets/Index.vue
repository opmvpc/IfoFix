<template>
    <AppLayout>
        <div class="p-3 flex flex-col gap-3 h-screen overflow-hidden">
            <div class="flex justify-between items-center gap-3">
                <h1 class="text-xl font-semibold">Tickets</h1>
                <Button>Ajouter un ticket</Button>
            </div>
            <div class="flex justify-between gap-3">
                <Input placeholder="Rechercher un ticket" class="" />
                <div class="flex gap-3 shrink-0">
                    <div class="flex items-center space-x-2">
                        <Switch
                            v-model:checked="pendingTickets"
                            id="pending-mode"
                        />
                        <Label for="pending-mode">en cours</Label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <Switch
                            v-model:checked="deliveredTickets"
                            id="delivered-mode"
                        />
                        <Label for="delivered-mode">rendu</Label>
                    </div>
                </div>
            </div>
            <div class="flex gap-3">
                <Select v-model="selectedTechnician">
                    <SelectTrigger>
                        <SelectValue placeholder="Technicien" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
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
                <Select>
                    <SelectTrigger>
                        <SelectValue placeholder="Model" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem
                                v-for="(device, index) in devices"
                                :key="index"
                                :value="device.id"
                                >{{ device.name }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select>
                    <SelectTrigger>
                        <SelectValue placeholder="Marque" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem
                                v-for="(brand, index) in brands"
                                :key="index"
                                :value="brand.id"
                                >{{ brand.name }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select>
                    <SelectTrigger>
                        <SelectValue placeholder="Type" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
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
            <hr />
            <div class="overflow-scroll border-gray-300 rounded-lg">
                <table
                    class="w-full table-auto border-collapse bg-white rounded-lg"
                >
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left font-bold">Id</th>
                            <th class="px-4 py-2 text-left font-bold">Titre</th>
                            <th class="px-4 py-2 text-left font-bold">
                                Statut
                            </th>

                            <th class="px-4 py-2 text-left font-bold">
                                Assigné à
                            </th>

                            <th class="px-4 py-2 text-left font-bold">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="ticket in filteredTickets"
                            :key="ticket.id"
                            class="hover:bg-gray-50 border-t border-t-slate-200"
                        >
                            <td class="px-4 py-2">#{{ ticket.id }}</td>
                            <td class="px-4 py-2">{{ ticket.title }}</td>
                            <td
                                v-if="ticket.isFinished"
                                class="px-4 py-2 text-green-500 font-medium"
                            >
                                Terminé
                            </td>
                            <td
                                v-if="!ticket.isFinished"
                                class="px-4 py-2 text-orange-400 font-medium"
                            >
                                En cours
                            </td>

                            <td class="px-4 py-2">
                                {{ ticket.user.firstName }}
                            </td>

                            <td
                                class="px-4 py-2 text-center font-bold cursor-pointer"
                            >
                                ✖
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import { Switch } from "@/Components/ui/switch";
import { Label } from "@/Components/ui/label";
import { computed, ref } from "vue";

const props = defineProps({
    tickets: Array,
    technicians: Array,
    devices: Array,
    brands: Array,
    types: Array,
});

const pendingTickets = ref(true);
const deliveredTickets = ref(false);
const selectedTechnician = ref(null);

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
    return tickets;
});
</script>
