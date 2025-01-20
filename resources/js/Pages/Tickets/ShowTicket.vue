<script setup>
import Button from "@/Components/ui/button/Button.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import CreateIntervention from "@/Components/Interventions/CreateIntervention.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import {
    Carousel,
    CarouselContent,
    CarouselItem,
    CarouselNext,
    CarouselPrevious,
} from "@/Components/ui/carousel";
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter,
} from "@/Components/ui/card";

import { Dialog, DialogContent } from "@/Components/ui/dialog";

import { Badge } from "@/Components/ui/badge";
import BackButton from "@/Components/BackButton.vue";
import InterventionsList from "./partials/InterventionsList.vue";
import { formatDate } from "@/lib/utils";
import EditTicket from "./partials/EditTicket.vue";

const props = defineProps({
    ticket: Object,
    devices: Array,
    clients: Array,
    brands: Array,
    types: Array,
    interventions: Array,
    technicians: Array,
    auth: Object,
});

const showCreateIntervention = ref(false);

const getUniqueTechnicians = (interventions) => {
    const technicianMap = new Map();

    interventions.forEach((intervention) => {
        intervention.users.forEach((user) => {
            technicianMap.set(user.id, user);
        });
    });

    return Array.from(technicianMap.values());
};

const uniqueTechnicians = computed(() =>
    getUniqueTechnicians(props.interventions)
);

// Ajoutez cette configuration pour le carousel
const carouselOptions = {
    align: "start",
};

const selectedImage = ref(null);

const openImageModal = (image) => {
    selectedImage.value = image;
};

const closeImageModal = () => {
    selectedImage.value = null;
};

const showEditForm = ref(false);
</script>

<template>
    <AppLayout>
        <Head :title="'Détails du Ticket #' + ticket.id" />
        <div class="flex h-full">
            <!-- Main content -->
            <div class="flex-1 p-4" :class="showEditForm ? 'pr-0' : ''">
                <div class="flex flex-col gap-6">
                    <BackButton
                        class="self-start"
                        :route="route('tickets.index')"
                    />

                    <!-- Ticket details card -->
                    <Card class="flex-1">
                        <CardHeader class="border-b border-border">
                            <div class="flex items-center gap-4">
                                <h2 class="text-3xl font-semibold">
                                    Détails du ticket #{{ ticket.id }}
                                </h2>
                                <Button
                                    variant="ghost"
                                    size="icon"
                                    @click="showEditForm = true"
                                >
                                    <font-awesome-icon
                                        icon="fa-solid fa-pen-to-square"
                                        class="w-4 h-4"
                                    />
                                </Button>
                            </div>
                            <div class="flex items-center gap-2">
                                <p class="text-sm italic text-gray-500">
                                    Créé par
                                    {{ ticket.user.firstName }} le
                                    {{ formatDate(ticket.created_at) }}
                                </p>
                                <Badge
                                    :variant="
                                        ticket.isFinished
                                            ? 'success'
                                            : 'warning'
                                    "
                                >
                                    {{
                                        ticket.isFinished
                                            ? "Terminé"
                                            : "En cours"
                                    }}
                                </Badge>
                            </div>
                        </CardHeader>
                        <CardContent class="flex flex-col gap-4 pt-4">
                            <div>
                                <p class="font-semibold">Description</p>
                                <p class="text-gray-600">
                                    {{ ticket.description }}
                                </p>
                            </div>

                            <div
                                class="grid grid-cols-1 gap-4 pb-4 border-b md:grid-cols-3 border-border"
                            >
                                <div class="flex-1 min-w-[200px]">
                                    <p class="mb-2 font-semibold">Appareil</p>
                                    <p>
                                        <span class="text-xs">Modèle :</span>
                                        {{
                                            ticket.device?.name ||
                                            "Non spécifié"
                                        }}
                                        <span
                                            v-if="
                                                ticket.device?.brand ||
                                                ticket.device?.type
                                            "
                                            class="text-gray-500"
                                        ></span>
                                    </p>
                                    <p>
                                        <span class="text-xs">Marque :</span>
                                        {{
                                            ticket.device.brand?.name ||
                                            "Marque non spécifiée"
                                        }}
                                    </p>
                                    <p>
                                        <span class="text-xs">Type :</span>
                                        {{
                                            ticket.device.type?.name ||
                                            "Type non spécifié"
                                        }}
                                    </p>
                                </div>

                                <div class="flex-1 min-w-[200px]">
                                    <p class="mb-2 font-semibold">Client</p>
                                    <p>
                                        <span class="text-xs">Prénom :</span>
                                        {{ ticket.client.firstName }}
                                    </p>
                                    <p>
                                        <span class="text-xs">Nom :</span>
                                        {{ ticket.client.lastName }}
                                    </p>
                                    <p>
                                        <span class="text-xs">Téléphone :</span>
                                        {{ ticket.client.phone }}
                                    </p>
                                </div>

                                <div class="flex-1 min-w-[200px] space-y-2">
                                    <p class="font-semibold">
                                        Technicien(s) désigné(s)
                                    </p>
                                    <div
                                        v-if="uniqueTechnicians.length > 0"
                                        class="flex flex-wrap gap-2"
                                    >
                                        <Badge
                                            v-for="technician in uniqueTechnicians"
                                            :key="technician.id"
                                        >
                                            <font-awesome-icon
                                                icon="fa-solid fa-user"
                                                class="w-3 h-3 mr-2"
                                            />
                                            {{ technician.firstName }}
                                            {{ technician.lastName }}
                                        </Badge>
                                    </div>
                                    <div v-else class="text-gray-500">
                                        Non assigné
                                    </div>
                                </div>
                            </div>
                            <!-- Ajout du carousel ici -->
                            <div
                                v-if="ticket.images && ticket.images.length > 0"
                                class="w-full mx-auto"
                            >
                                <p class="mb-2 font-semibold">Images</p>
                                <Carousel
                                    class="relative w-full"
                                    :opts="carouselOptions"
                                >
                                    <CarouselContent>
                                        <CarouselItem
                                            v-for="image in ticket.images"
                                            :key="image.id"
                                            class="basis-full sm:basis-1/2 md:basis-1/3 lg:basis-1/4"
                                        >
                                            <div
                                                class="transition-opacity border rounded-lg cursor-pointer hover:opacity-90 border-border"
                                                @click="openImageModal(image)"
                                            >
                                                <img
                                                    :src="`/storage/${image.imageUrl}`"
                                                    class="object-cover w-full h-48 rounded-lg"
                                                    :alt="`Image ${image.id}`"
                                                />
                                            </div>
                                        </CarouselItem>
                                    </CarouselContent>
                                    <CarouselPrevious
                                        class="absolute left-0 -translate-y-1/2 top-1/2"
                                    />
                                    <CarouselNext
                                        class="absolute right-0 -translate-y-1/2 top-1/2"
                                    />
                                </Carousel>
                            </div>
                            <div
                                v-else
                                class="py-4 italic text-center text-gray-500"
                            >
                                Aucune image pour ce ticket
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Interventions section -->
                    <Card>
                        <CardHeader>
                            <div class="flex flex-row items-center gap-2">
                                <h2 class="text-xl font-bold">Interventions</h2>
                                <font-awesome-icon
                                    v-if="
                                        auth.user.role === 'admin' &&
                                        !props.ticket.isFinished
                                    "
                                    icon="fa-solid fa-plus"
                                    class="transition-all rounded-md"
                                    :class="
                                        props.ticket.isFinished
                                            ? 'text-gray-400 cursor-not-allowed'
                                            : 'cursor-pointer hover:bg-indigo-50'
                                    "
                                    @click="showCreateIntervention = true"
                                />
                            </div>
                        </CardHeader>
                        <CardContent>
                            <div v-if="showCreateIntervention" class="flex-1">
                                <CreateIntervention
                                    :ticket-id="ticket.id"
                                    :technicians="technicians"
                                    @close="showCreateIntervention = false"
                                />
                            </div>
                            <InterventionsList
                                :ticket="ticket"
                                :interventions="interventions"
                                :auth="auth"
                                @create-intervention="
                                    showCreateIntervention = true
                                "
                            />
                        </CardContent>
                    </Card>
                </div>

                <!-- Image modal -->
                <Dialog :open="!!selectedImage" @update:open="closeImageModal">
                    <DialogContent
                        class="sm:max-w-[95vw] sm:max-h-[95vh] w-[95vw] h-[95vh] p-0 overflow-hidden flex items-center justify-center"
                    >
                        <div
                            class="relative flex items-center justify-center w-full h-full"
                        >
                            <img
                                v-if="selectedImage"
                                :src="
                                    selectedImage.imageUrl.startsWith('public/')
                                        ? `/${selectedImage.imageUrl}`
                                        : `/storage/${selectedImage.imageUrl}`
                                "
                                class="w-full h-auto max-w-[90%] max-h-[90%] object-contain"
                                :alt="`Image en plein écran`"
                            />
                        </div>
                    </DialogContent>
                </Dialog>
            </div>

            <!-- Sliding panel -->
            <div
                class="transition-all duration-300 ease-in-out"
                :class="
                    showEditForm
                        ? 'translate-x-0 w-full lg:w-96'
                        : 'translate-x-full opacity-0 w-0'
                "
            >
                <EditTicket
                    v-if="showEditForm"
                    :ticket="ticket"
                    :devices="devices"
                    :technicians="technicians"
                    :techniciansIntervention="uniqueTechnicians"
                    :clients="clients"
                    :brands="brands"
                    :types="types"
                    @close="showEditForm = false"
                    class="h-full"
                />
            </div>
        </div>
    </AppLayout>
</template>
