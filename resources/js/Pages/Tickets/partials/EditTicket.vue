<template>
    <div class="p-4 bg-white border rounded-lg shadow">
        <div class="flex items-center justify-between mb-4">
            <BackButton v-if="params === '/tickets/create'" />
            <h2 class="text-lg font-semibold">
                Modifier Ticket #{{ ticket.id }}
            </h2>
            <Button
                variant="ghost"
                @click="$emit('close')"
                v-if="params !== '/tickets/create'"
            >
                <XIcon class="w-4 h-4" />
            </Button>
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <Label for="title">Titre</Label>
                <Input id="title" v-model="form.title" />
            </div>
            <div>
                <Label for="description">Description</Label>
                <Textarea
                    id="description"
                    v-model="form.description"
                    class="resize-none"
                />
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
                        class="justify-between w-full"
                    >
                        <span>{{
                            selectedDeviceName || "Sélectionner un appareil"
                        }}</span>
                        <font-awesome-icon icon="fa-solid fa-laptop" />
                    </Button>
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
                        class="justify-between w-full"
                    >
                        <span>{{
                            selectedClientName || "Sélectionner un client"
                        }}</span>
                        <font-awesome-icon icon="fa-solid fa-user" />
                    </Button>
                </div>
            </div>
            <div>
                <Label>Techniciens</Label>
                <Button
                    type="button"
                    variant="outline"
                    @click="openModal"
                    class="justify-between w-full"
                >
                    Sélectionner des techniciens
                    <font-awesome-icon icon="fa-solid fa-users" />
                </Button>

                <!-- Liste des techniciens sélectionnés -->
                <div
                    v-if="selectedTechnicians.length"
                    class="flex flex-wrap gap-2 mt-2"
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
                                class="w-3 h-3"
                            />
                        </button>
                    </div>
                </div>
            </div>
            <div>
                <Label for="images">Images</Label>
                <div
                    class="mt-2"
                    @dragenter.prevent="handleDragEnter"
                    @dragleave.prevent="handleDragLeave"
                    @dragover.prevent
                    @drop.prevent="handleFileDrop"
                >
                    <div class="flex items-center justify-center w-full">
                        <label
                            class="flex flex-col w-full h-32 transition-colors duration-200 border-2 border-dashed rounded-lg cursor-pointer"
                            :class="{
                                'border-primary bg-primary/10': isDragging,
                                'hover:bg-gray-50 border-gray-300': !isDragging,
                            }"
                        >
                            <div
                                class="flex flex-col items-center justify-center pt-5 pb-6"
                            >
                                <font-awesome-icon
                                    icon="fa-solid fa-cloud-arrow-up"
                                    class="w-8 h-8 mb-3 text-gray-400"
                                    :class="{ 'text-primary': isDragging }"
                                />
                                <p class="text-sm text-gray-500">
                                    {{
                                        isDragging
                                            ? "Déposez les images ici"
                                            : "Cliquez ou glissez des images ici"
                                    }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    (JPG, PNG, GIF jusqu'à 2MB)
                                </p>
                            </div>
                            <input
                                type="file"
                                class="hidden"
                                multiple
                                accept="image/*"
                                @change="handleImageUpload"
                            />
                        </label>
                    </div>
                    <!-- Prévisualisation des images -->
                    <div
                        v-if="imagePreviewUrls.length"
                        class="grid grid-cols-4 gap-4 mt-4"
                    >
                        <div
                            v-for="(url, index) in imagePreviewUrls"
                            :key="index"
                            class="relative"
                        >
                            <img
                                :src="url"
                                class="object-cover w-full h-24 rounded-lg"
                            />
                            <button
                                type="button"
                                @click="removeImage(index)"
                                class="absolute flex items-center justify-center w-5 h-5 text-xs text-white bg-red-500 rounded-full -top-2 -right-2 hover:bg-red-600"
                            >
                                <font-awesome-icon
                                    icon="fa-solid fa-times"
                                    class="w-3 h-3"
                                />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <Button type="submit" class="w-full">Mettre à jour</Button>
        </form>

        <CreateClientModal v-model="isNewClientModalOpen" />

        <CreateDeviceModal
            v-model="isNewDeviceModalOpen"
            :brands="brands"
            :types="types"
        />

        <TechniciansModal
            v-model="isModalOpen"
            :form="form"
            :technicians="technicians"
            @update:selectedTechnicians="updateSelectedTechnicians"
        />

        <ClientsModal
            v-model="isClientModalOpen"
            :form="form"
            :clients="clients"
            @update:selectedClientName="selectedClientName = $event"
        />

        <DeviceModal
            v-model="isDeviceModalOpen"
            :form="form"
            :devices="devices"
            @update:selectedDeviceName="selectedDeviceName = $event"
        />
    </div>
</template>

<script setup>
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Textarea } from "@/Components/ui/textarea";
import { XIcon } from "lucide-vue-next";
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import TechniciansModal from "./TechniciansModal.vue";
import ClientsModal from "./ClientsModal.vue";
import DeviceModal from "./DevicesModal.vue";
import CreateClientModal from "./CreateClientModal.vue";
import CreateDeviceModal from "./CreateDeviceModal.vue";
import BackButton from "@/Components/BackButton.vue";

const props = defineProps({
    ticket: Object,
    devices: Array,
    technicians: Array,
    techniciansIntervention: Array,
    clients: Array,
    brands: Array,
    types: Array,
});

// Modify form initialization
const form = useForm({
    title: props.ticket?.title || "",
    description: props.ticket?.description || "",
    deviceId: props.ticket?.device?.id || "",
    clientId: props.ticket?.client?.id || "",
    technicianIds: Array.isArray(props.techniciansIntervention)
        ? props.techniciansIntervention.map((tech) => tech.id)
        : [],
    images: [],
    existingImages: props.ticket?.images || [],
});

// Initialiser les noms sélectionnés
const selectedDeviceName = ref(props.ticket?.device?.name || "");
const selectedClientName = ref(
    props.ticket?.client
        ? `${props.ticket.client.firstName} ${props.ticket.client.lastName}`
        : ""
);

// Update the image handling functions
const imagePreviewUrls = ref(
    props.ticket?.images?.map((image) =>
        image.imageUrl.startsWith("public/")
            ? `/${image.imageUrl}`
            : `/storage/${image.imageUrl}`
    ) || []
);

const selectedImages = ref([]);
const existingImages = ref(props.ticket?.images || []);

const updateFormImages = () => {
    form.existingImages = existingImages.value;
    form.images = selectedImages.value;
};

const handleImageUpload = (event) => {
    const files = Array.from(event.target.files);
    files.forEach((file) => {
        if (file.size > 2 * 1024 * 1024) {
            alert("Chaque image ne doit pas dépasser 2MB");
            return;
        }
        selectedImages.value.push(file);
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreviewUrls.value.push(e.target.result);
        };
        reader.readAsDataURL(file);
    });
    updateFormImages();
};

const removeImage = (index) => {
    if (index < existingImages.value.length) {
        // Removing an existing image
        existingImages.value.splice(index, 1);
        imagePreviewUrls.value.splice(index, 1);
    } else {
        // Removing a newly uploaded image
        const newImageIndex = index - existingImages.value.length;
        imagePreviewUrls.value.splice(index, 1);
        selectedImages.value.splice(newImageIndex, 1);
    }
    updateFormImages();
};
const emit = defineEmits(["close"]);

// Update submit function
const submit = () => {
    if (!form.title || !form.description || !form.deviceId || !form.clientId) {
        alert("Veuillez remplir tous les champs obligatoires");
        return;
    }

    form.transform((data) => {
        // Create a new FormData object
        const formData = new FormData();

        // Basic fields
        formData.append("_method", "PUT");
        formData.append("title", form.title);
        formData.append("description", form.description);
        formData.append("deviceId", form.deviceId);
        formData.append("clientId", form.clientId);

        // Technicians
        if (form.technicianIds?.length) {
            form.technicianIds.forEach((id) => {
                formData.append("technicianIds[]", id);
            });
        }

        // Existing images
        if (existingImages.value?.length) {
            formData.append("images", JSON.stringify(existingImages.value));
        }

        // New images
        if (selectedImages.value?.length) {
            selectedImages.value.forEach((file, index) => {
                formData.append(`images[${index}]`, file);
            });
        }

        // Log the FormData entries
        for (let pair of formData.entries()) {
            console.log(pair[0] + ": " + pair[1]);
        }

        return formData;
    });

    form.post(route("tickets.update", props.ticket.id), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            console.log("Ticket mis à jour avec succès");
            emit("close");
        },
        onError: (errors) => {
            console.error("Erreur lors de la mise à jour:", errors);
        },
    });
};

const isModalOpen = ref(false);

const openModal = () => {
    isModalOpen.value = true;
};

const selectedTechnicians = ref(
    Array.isArray(props.techniciansIntervention)
        ? props.techniciansIntervention
        : []
);

const updateSelectedTechnicians = (techs) => {
    selectedTechnicians.value = techs;
    form.technicianIds = techs.map((tech) => tech.id);
};

const toggleTechnician = (techId) => {
    const currentIds = [...form.technicianIds];
    const index = currentIds.indexOf(techId);

    if (index === -1) {
        currentIds.push(techId);
    } else {
        currentIds.splice(index, 1);
    }

    form.technicianIds = currentIds;
    selectedTechnicians.value = props.technicians.filter((tech) =>
        currentIds.includes(tech.id)
    );
};

const isClientModalOpen = ref(false);

const openClientModal = () => {
    isClientModalOpen.value = true;
};

const isNewClientModalOpen = ref(false);

const openNewClientModal = () => {
    isNewClientModalOpen.value = true;
};

const isNewDeviceModalOpen = ref(false);

const openNewDeviceModal = () => {
    isNewDeviceModalOpen.value = true;
};

const isDeviceModalOpen = ref(false);

const openDeviceModal = () => {
    isDeviceModalOpen.value = true;
};

const isDragging = ref(false);
let dragCounter = ref(0);

const handleDragEnter = (e) => {
    e.preventDefault();
    dragCounter.value++;
    if (dragCounter.value === 1) {
        isDragging.value = true;
    }
};

const handleDragLeave = (e) => {
    e.preventDefault();
    dragCounter.value--;
    if (dragCounter.value === 0) {
        isDragging.value = false;
    }
};

const handleFileDrop = (event) => {
    isDragging.value = false;
    dragCounter.value = 0;
    const files = Array.from(event.dataTransfer.files).filter((file) =>
        file.type.startsWith("image/")
    );

    files.forEach((file) => {
        if (file.size > 2 * 1024 * 1024) {
            alert("Chaque image ne doit pas dépasser 2MB");
            return;
        }
        selectedImages.value.push(file);
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreviewUrls.value.push(e.target.result);
        };
        reader.readAsDataURL(file);
    });
    updateFormImages();
};

const params = window.location.pathname;
console.log(params);
</script>
