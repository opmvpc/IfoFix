<template>
    <div class="p-4 border rounded-lg bg-white shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Nouveau Ticket</h2>
            <Button variant="ghost" @click="$emit('close')">
                <XIcon class="h-4 w-4" />
            </Button>
        </div>

        <!-- Nouvelle Modal pour les techniciens -->
        <TechniciansModal
            :isModalOpen="isModalOpen"
            :form="form"
            :technicians="technicians"
            @update:isModalOpen="isModalOpen = $event"
        />

        <!-- Nouvelle Modal pour les clients -->
        <ClientsModal
            v-model="isClientModalOpen"
            :form="form"
            :clients="clients"
        />

        <!-- Nouvelle Modal pour les appareils -->
        <DeviceModal
            v-model="isDeviceModalOpen"
            :form="form"
            :devices="devices"
        />

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
                <Label for="device" class="flex items-center gap-2">
                    Appareil
                    <Button
                        type="button"
                        variant="ghost"
                        size="sm"
                        @click="openNewDeviceModal"
                    >
                        <font-awesome-icon icon="fa-solid fa-plus" />
                    </Button>
                </Label>
                <div class="flex flex-col gap-2">
                    <Button
                        type="button"
                        variant="outline"
                        @click="openDeviceModal"
                        class="w-full justify-between"
                    >
                        <span>{{
                            selectedDeviceName || "Sélectionner un appareil"
                        }}</span>
                        <font-awesome-icon icon="fa-solid fa-laptop" />
                    </Button>

                    <div
                        v-if="form.deviceId"
                        class="flex items-center justify-between p-2 bg-gray-50 rounded-md"
                    >
                        <span class="text-sm">
                            {{ selectedDeviceName }}
                        </span>
                        <button
                            type="button"
                            @click="form.deviceId = null"
                            class="text-gray-500 hover:text-gray-700"
                        >
                            <font-awesome-icon
                                icon="fa-solid fa-times"
                                class="h-3 w-3"
                            />
                        </button>
                    </div>
                </div>
            </div>
            <div>
                <Label for="client" class="flex items-center gap-2">
                    Client
                    <Button
                        type="button"
                        variant="ghost"
                        size="sm"
                        @click="openNewClientModal"
                    >
                        <font-awesome-icon icon="fa-solid fa-plus" />
                    </Button>
                </Label>
                <div class="flex flex-col gap-2">
                    <Button
                        type="button"
                        variant="outline"
                        @click="openClientModal"
                        class="w-full justify-between"
                    >
                        <span>{{
                            selectedClientName || "Sélectionner un client"
                        }}</span>
                        <font-awesome-icon icon="fa-solid fa-user" />
                    </Button>

                    <!-- Affichage du client sélectionné -->
                    <div
                        v-if="form.clientId"
                        class="flex items-center justify-between p-2 bg-gray-50 rounded-md"
                    >
                        <span class="text-sm">
                            {{ selectedClientName }}
                        </span>
                        <button
                            type="button"
                            @click="form.clientId = null"
                            class="text-gray-500 hover:text-gray-700"
                        >
                            <font-awesome-icon
                                icon="fa-solid fa-times"
                                class="h-3 w-3"
                            />
                        </button>
                    </div>
                </div>
            </div>
            <div>
                <Label>Techniciens</Label>
                <Button
                    type="button"
                    variant="outline"
                    @click="openModal"
                    class="w-full justify-between"
                >
                    Sélectionner des techniciens
                    <font-awesome-icon icon="fa-solid fa-users" />
                </Button>

                <!-- Liste des techniciens sélectionnés -->
                <div
                    v-if="selectedTechnicians.length"
                    class="mt-2 flex flex-wrap gap-2"
                >
                    <div
                        v-for="tech in selectedTechnicians"
                        :key="tech.id"
                        class="inline-flex items-center gap-1 rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground border-input bg-background hover:bg-accent hover:text-accent-foreground"
                    >
                        <span>{{ tech.firstName }} {{ tech.lastName }}</span>
                        <button
                            type="button"
                            @click="toggleTechnician(tech.id)"
                            class="ml-1 rounded-full outline-none hover:bg-muted-foreground/20 focus:bg-muted-foreground/20"
                        >
                            <font-awesome-icon
                                icon="fa-solid fa-times"
                                class="h-3 w-3"
                            />
                        </button>
                    </div>
                </div>
            </div>
            <Button type="submit" class="w-full">Créer</Button>
        </form>

        <!-- Modal de création de client -->
        <CreateClientModal
            v-model="isClientModalOpen"
            :newClientForm="newClientForm"
            :form="form"
        />

        <!-- Modal de création d'appareil -->
        <Dialog
            :open="isNewDeviceModalOpen"
            @update:open="isNewDeviceModalOpen = $event"
        >
            <DialogContent class="sm:max-w-[500px]">
                <DialogHeader>
                    <DialogTitle>Créer un nouvel appareil</DialogTitle>
                </DialogHeader>

                <form @submit.prevent="submitNewDevice" class="space-y-4">
                    <div>
                        <Label for="newDeviceName">Nom</Label>
                        <Input
                            id="newDeviceName"
                            v-model="newDeviceForm.name"
                        />
                    </div>
                    <div>
                        <Label for="newDeviceBrand">Marque</Label>
                        <Select v-model="newDeviceForm.brandId">
                            <SelectTrigger>
                                <SelectValue
                                    placeholder="Sélectionner une marque"
                                />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem
                                        v-for="brand in brands"
                                        :key="brand.id"
                                        :value="brand.id"
                                    >
                                        {{ brand.name }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                    </div>
                    <div>
                        <Label for="newDeviceType">Type</Label>
                        <Select v-model="newDeviceForm.typeId">
                            <SelectTrigger>
                                <SelectValue
                                    placeholder="Sélectionner un type"
                                />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem
                                        v-for="type in types"
                                        :key="type.id"
                                        :value="type.id"
                                    >
                                        {{ type.name }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                    </div>
                    <DialogFooter>
                        <Button
                            type="button"
                            variant="secondary"
                            @click="closeNewDeviceModal"
                        >
                            Annuler
                        </Button>
                        <Button type="submit">Créer</Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    </div>
</template>

<script setup>
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/components/ui/label";
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
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
    DialogFooter,
} from "@/Components/ui/dialog";
import TechniciansModal from "./partials/TechniciansModal.vue";
import ClientsModal from "./partials/ClientsModal.vue";
import DeviceModal from "./partials/DevicesModal.vue";
import CreateClientModal from "./partials/CreateClientModal.vue";

const props = defineProps({
    devices: Array,
    technicians: Array,
    clients: Array, // Nouvelle prop
    brands: Array, // Ajouter cette prop
    types: Array, // Ajouter cette prop
});

const emit = defineEmits(["close"]);

const isModalOpen = ref(false);

const form = useForm({
    title: "",
    description: "",
    deviceId: null,
    clientId: null, // Modifié de client à clientId
    technicianIds: [], // Modifié pour supporter plusieurs techniciens
});

const selectedTechnicians = computed(() => {
    return props.technicians.filter((tech) =>
        form.technicianIds.includes(tech.id)
    );
});

const openModal = () => {
    isModalOpen.value = true;
};

const isClientModalOpen = ref(false);

const openClientModal = () => {
    isClientModalOpen.value = true;
};

const selectedClientName = computed(() => {
    const selectedClient = props.clients.find((c) => c.id === form.clientId);
    return selectedClient
        ? `${selectedClient.firstName} ${selectedClient.lastName}`
        : "";
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

const isNewClientModalOpen = ref(false);
const newClientForm = useForm({
    firstName: "",
    lastName: "",
    email: "",
    phone: "",
});

const openNewClientModal = () => {
    isNewClientModalOpen.value = true;
};

const closeNewClientModal = () => {
    isNewClientModalOpen.value = false;
    newClientForm.reset();
};

const submitNewClient = () => {
    newClientForm.post(route("clients.store"), {
        preserveScroll: true,
        onSuccess: (response) => {
            closeNewClientModal();
            // Mettre à jour la liste des clients
            form.clientId = response.props.client.id;
        },
    });
};

const isNewDeviceModalOpen = ref(false);
const newDeviceForm = useForm({
    name: "",
    brandId: null,
    typeId: null,
});

const openNewDeviceModal = () => {
    isNewDeviceModalOpen.value = true;
};

const closeNewDeviceModal = () => {
    isNewDeviceModalOpen.value = false;
    newDeviceForm.reset();
};

const submitNewDevice = () => {
    newDeviceForm.post(route("devices.store"), {
        preserveScroll: true,
        onSuccess: (response) => {
            closeNewDeviceModal();
            // Mettre à jour la liste des appareils
            form.deviceId = response.props.device.id;
        },
    });
};

const isDeviceModalOpen = ref(false);

const selectedDeviceName = computed(() => {
    const selectedDevice = props.devices.find((d) => d.id === form.deviceId);
    return selectedDevice ? selectedDevice.name : "";
});

const openDeviceModal = () => {
    isDeviceModalOpen.value = true;
};
</script>
