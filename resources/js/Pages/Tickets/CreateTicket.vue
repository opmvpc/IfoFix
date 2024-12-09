<template>
    <div class="p-4 border rounded-lg bg-white shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Nouveau Ticket</h2>
            <Button variant="ghost" @click="$emit('close')">
                <XIcon class="h-4 w-4" />
            </Button>
        </div>
        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <Label for="title">Titre</Label>
                <Input id="title" v-model="form.title" />
            </div>
            <div>
                <Label for="description">Description</Label>
                <Input id="description" v-model="form.description" />
            </div>
            <div>
                <Label for="device">Appareil</Label>
                <Select v-model="form.deviceId">
                    <SelectTrigger>
                        <SelectValue placeholder="Sélectionner un appareil" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem
                                v-for="device in devices"
                                :key="device.id"
                                :value="device.id"
                            >
                                {{ device.name }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>
            <div>
                <Label for="client">Client</Label>
                <div class="flex gap-2">
                    <Input
                        id="clientSearch"
                        v-model="clientSearch"
                        placeholder="Rechercher un client"
                    />
                    <Select v-model="form.clientId">
                        <SelectTrigger>
                            <SelectValue placeholder="Sélectionner" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem
                                    v-for="client in filteredClients"
                                    :key="client.id"
                                    :value="client.id"
                                >
                                    {{ client.firstName }} {{ client.lastName }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
            </div>
            <div>
                <Label for="technician">Technicien</Label>
                <div class="flex gap-2">
                    <Input
                        id="technicianSearch"
                        v-model="technicianSearch"
                        placeholder="Rechercher un technicien"
                    />
                    <Select v-model="form.technicianId">
                        <SelectTrigger>
                            <SelectValue placeholder="Sélectionner" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem
                                    v-for="technician in filteredTechnicians"
                                    :key="technician.id"
                                    :value="technician.id"
                                >
                                    {{ technician.firstName }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
            </div>
            <Button type="submit" class="w-full">Créer</Button>
        </form>
    </div>
</template>

<script setup>
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import { XIcon } from "lucide-vue-next";
import { reactive, ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    devices: Array,
    technicians: Array,
    clients: Array, // Nouvelle prop
});

defineEmits(["close"]);

const technicianSearch = ref("");
const filteredTechnicians = computed(() => {
    if (!technicianSearch.value) return props.technicians;
    return props.technicians.filter((tech) =>
        tech.name.toLowerCase().includes(technicianSearch.value.toLowerCase())
    );
});

const clientSearch = ref("");
const filteredClients = computed(() => {
    if (!clientSearch.value) return props.clients;
    return props.clients.filter((client) =>
        client.name.toLowerCase().includes(clientSearch.value.toLowerCase())
    );
});

const form = useForm({
    title: "",
    description: "",
    deviceId: null,
    clientId: null, // Modifié de client à clientId
    technicianId: null,
});

const submit = () => {
    form.post(route("tickets.store"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            emit("close");
        },
        onError: (errors) => {
            console.error("Erreur lors de la soumission:", errors);
        },
    });
};
</script>
