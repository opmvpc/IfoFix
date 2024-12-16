<template>
    <div class="p-4 border rounded-lg bg-white shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Nouveau Ticket</h2>
            <Button variant="ghost" @click="$emit('close')">
                <XIcon class="h-4 w-4" />
            </Button>
        </div>

        <!-- Nouvelle Modal pour les techniciens -->
        <Dialog :open="isModalOpen" @update:open="isModalOpen = $event">
            <DialogContent class="sm:max-w-[500px] min-h-[500px]">
                <DialogHeader>
                    <DialogTitle>Sélectionner des techniciens</DialogTitle>
                    <DialogDescription>
                        Recherchez et sélectionnez un ou plusieurs techniciens
                    </DialogDescription>
                </DialogHeader>

                <div class="space-y-4">
                    <Input
                        type="search"
                        placeholder="Rechercher un technicien..."
                        v-model="technicianSearch"
                    />

                    <div class="h-[300px] overflow-y-auto space-y-2">
                        <div
                            v-for="tech in filteredTechnicians"
                            :key="tech.id"
                            class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded"
                        >
                            <Checkbox
                                :id="'tech-' + tech.id"
                                :checked="form.technicianIds.includes(tech.id)"
                                @update:checked="toggleTechnician(tech.id)"
                            />
                            <Label :for="'tech-' + tech.id" class="flex-grow">
                                {{ tech.firstName }} {{ tech.lastName }}
                            </Label>
                        </div>
                    </div>
                </div>

                <DialogFooter>
                    <Button
                        type="button"
                        variant="secondary"
                        @click="closeModal"
                    >
                        Confirmer
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>

        <!-- Nouvelle Modal pour les clients -->
        <Dialog
            :open="isClientModalOpen"
            @update:open="isClientModalOpen = $event"
        >
            <DialogContent class="sm:max-w-[500px] min-h-[500px]">
                <DialogHeader>
                    <DialogTitle>Sélectionner un client</DialogTitle>
                    <DialogDescription>
                        Recherchez et sélectionnez un client
                    </DialogDescription>
                </DialogHeader>

                <div class="space-y-4">
                    <Input
                        type="search"
                        placeholder="Rechercher un client..."
                        v-model="clientSearch"
                    />

                    <div class="h-[300px] overflow-y-auto space-y-2">
                        <RadioGroup v-model="form.clientId">
                            <div
                                v-for="client in filteredClients"
                                :key="client.id"
                                class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded"
                            >
                                <RadioGroupItem
                                    :value="client.id"
                                    :id="'client-' + client.id"
                                />
                                <Label
                                    :for="'client-' + client.id"
                                    class="flex-grow cursor-pointer"
                                >
                                    {{ client.firstName }} {{ client.lastName }}
                                </Label>
                            </div>
                        </RadioGroup>
                    </div>
                </div>

                <DialogFooter>
                    <Button
                        type="button"
                        variant="secondary"
                        @click="closeClientModal"
                    >
                        Confirmer
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>

        <!-- Nouvelle Modal pour les appareils -->
        <Dialog
            :open="isDeviceModalOpen"
            @update:open="isDeviceModalOpen = $event"
        >
            <DialogContent class="sm:max-w-[500px] min-h-[500px]">
                <DialogHeader>
                    <DialogTitle>Sélectionner un appareil</DialogTitle>
                    <DialogDescription>
                        Recherchez et sélectionnez un appareil
                    </DialogDescription>
                </DialogHeader>

                <div class="space-y-4">
                    <Input
                        type="search"
                        placeholder="Rechercher un appareil..."
                        v-model="deviceSearch"
                    />

                    <div class="h-[300px] overflow-y-auto space-y-2">
                        <RadioGroup v-model="form.deviceId">
                            <div
                                v-for="device in filteredDevices"
                                :key="device.id"
                                class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded"
                            >
                                <RadioGroupItem
                                    :value="device.id"
                                    :id="'device-' + device.id"
                                />
                                <Label
                                    :for="'device-' + device.id"
                                    class="flex-grow cursor-pointer"
                                >
                                    {{ device.name }}
                                </Label>
                            </div>
                        </RadioGroup>
                    </div>
                </div>

                <DialogFooter>
                    <Button
                        type="button"
                        variant="secondary"
                        @click="closeDeviceModal"
                    >
                        Confirmer
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>

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
        <Dialog
            :open="isNewClientModalOpen"
            @update:open="isNewClientModalOpen = $event"
        >
            <DialogContent class="sm:max-w-[500px]">
                <DialogHeader>
                    <DialogTitle>Créer un nouveau client</DialogTitle>
                </DialogHeader>

                <form @submit.prevent="submitNewClient" class="space-y-4">
                    <div>
                        <Label for="newClientFirstName">Prénom</Label>
                        <Input
                            id="newClientFirstName"
                            v-model="newClientForm.firstName"
                        />
                    </div>
                    <div>
                        <Label for="newClientLastName">Nom</Label>
                        <Input
                            id="newClientLastName"
                            v-model="newClientForm.lastName"
                        />
                    </div>
                    <div>
                        <Label for="newClientEmail">Email</Label>
                        <Input
                            id="newClientEmail"
                            v-model="newClientForm.email"
                            type="email"
                        />
                    </div>
                    <div>
                        <Label for="newClientPhone">Téléphone</Label>
                        <Input
                            id="newClientPhone"
                            v-model="newClientForm.phone"
                        />
                    </div>
                    <DialogFooter>
                        <Button
                            type="button"
                            variant="secondary"
                            @click="closeNewClientModal"
                        >
                            Annuler
                        </Button>
                        <Button type="submit">Créer</Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>

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
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
    DialogFooter,
} from "@/Components/ui/dialog";
import { Checkbox } from "@/Components/ui/checkbox";
import { RadioGroup, RadioGroupItem } from "@/Components/ui/radio-group";

const props = defineProps({
    devices: Array,
    technicians: Array,
    clients: Array, // Nouvelle prop
    brands: Array, // Ajouter cette prop
    types: Array, // Ajouter cette prop
});

const emit = defineEmits(["close"]);

const isModalOpen = ref(false);
const technicianSearch = ref("");

const filteredTechnicians = computed(() => {
    return props.technicians.filter(
        (tech) =>
            tech.firstName
                .toLowerCase()
                .includes(technicianSearch.value.toLowerCase()) ||
            tech.lastName
                .toLowerCase()
                .includes(technicianSearch.value.toLowerCase())
    );
});

const clientSearch = ref("");
const filteredClients = computed(() => {
    if (!clientSearch.value) return props.clients;
    return props.clients.filter((client) =>
        `${client.firstName} ${client.lastName}`
            .toLowerCase()
            .includes(clientSearch.value.toLowerCase())
    );
});

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

const toggleTechnician = (techId) => {
    const currentIds = [...form.technicianIds];
    const index = currentIds.indexOf(techId);

    if (index === -1) {
        currentIds.push(techId);
    } else {
        currentIds.splice(index, 1);
    }

    form.technicianIds = currentIds;
};

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const isClientModalOpen = ref(false);
const selectedClientName = computed(() => {
    const selectedClient = props.clients.find((c) => c.id === form.clientId);
    return selectedClient
        ? `${selectedClient.firstName} ${selectedClient.lastName}`
        : "";
});

const openClientModal = () => {
    isClientModalOpen.value = true;
};

const closeClientModal = () => {
    isClientModalOpen.value = false;
};

const selectClient = (clientId) => {
    closeClientModal();
};

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
const deviceSearch = ref("");

const filteredDevices = computed(() => {
    if (!deviceSearch.value) return props.devices;
    return props.devices.filter((device) =>
        device.name.toLowerCase().includes(deviceSearch.value.toLowerCase())
    );
});

const selectedDeviceName = computed(() => {
    const selectedDevice = props.devices.find((d) => d.id === form.deviceId);
    return selectedDevice ? selectedDevice.name : "";
});

const openDeviceModal = () => {
    isDeviceModalOpen.value = true;
};

const closeDeviceModal = () => {
    isDeviceModalOpen.value = false;
};
</script>
