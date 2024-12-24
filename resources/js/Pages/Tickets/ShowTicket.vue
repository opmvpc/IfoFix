<script setup>
import Button from "@/Components/ui/button/Button.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import CreateIntervention from "@/Components/Interventions/CreateIntervention.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref, h, computed } from "vue";
import {
    Carousel,
    CarouselContent,
    CarouselItem,
    CarouselNext,
    CarouselPrevious,
} from "@/Components/ui/carousel";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";

import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from "@/Components/ui/dialog";

import { Badge } from "@/Components/ui/badge";
import BackButton from "@/Components/BackButton.vue";
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from "@/Components/ui/tooltip";

const props = defineProps({
    ticket: Object,
    interventions: Array,
    technicians: Array,
});

const showCreateIntervention = ref(false);

const formatDate = (date) => {
    return new Date(date).toLocaleDateString("fr-FR");
};

const formatTime = (time) => {
    return time ? time.slice(0, 5) : ""; // Format HH:mm
};

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
</script>

<template>
    <AppLayout>
        <Head :title="'Détails du Ticket #' + ticket.id" />
        <div class="p-6">
            <div class="flex flex-col gap-6">
                <!-- Colonne des détails du ticket -->
                <div class="flex-1 p-6 bg-white rounded-lg shadow-md">
                    <div class="flex flex-col gap-6">
                        <div class="pb-4 border-b">
                            <div class="flex items-start justify-between mb-4">
                                <BackButton />

                                <div class="flex flex-col items-end">
                                    <h2 class="text-3xl font-semibold">
                                        Ticket #{{ ticket.id }}
                                    </h2>
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm text-gray-500 italic">
                                            Créé par
                                            {{ ticket.user.firstName }} le
                                            {{ formatDate(ticket.created_at) }}
                                        </p>
                                    </div>

                                    <Badge
                                        class=""
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
                            </div>
                            <p class="font-semibold">Description</p>
                            <p class="text-gray-600">
                                {{ ticket.description }}
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex-1 min-w-[200px]">
                                    <p class="font-semibold mb-2">Appareil</p>
                                    <p>
                                        <span class="text-xs">Modèle : </span>
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
                                        >
                                        </span>
                                    </p>
                                    <p>
                                        <span class="text-xs">Marque : </span>
                                        {{
                                            ticket.device.brand?.name ||
                                            "Marque non spécifiée"
                                        }}
                                    </p>
                                    <p>
                                        <span class="text-xs">Type : </span>
                                        {{
                                            ticket.device.type?.name ||
                                            "Type non spécifié"
                                        }}
                                    </p>
                                </div>

                                <div class="flex-1 min-w-[200px]">
                                    <p class="font-semibold mb-2">Client</p>
                                    <p>
                                        <span class="text-xs">Prénom : </span>
                                        {{ ticket.client.firstName }}
                                    </p>
                                    <p>
                                        <span class="text-xs">Nom : </span>
                                        {{ ticket.client.lastName }}
                                    </p>
                                    <p>
                                        <span class="text-xs"
                                            >Téléphone :
                                        </span>
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
                        </div>
                        <!-- Ajout du carousel ici -->
                        <div
                            v-if="ticket.images && ticket.images.length > 0"
                            class="w-full mx-auto"
                        >
                            <Carousel
                                class="relative w-full"
                                :opts="carouselOptions"
                            >
                                <CarouselContent class="-ml-1">
                                    <CarouselItem
                                        v-for="image in ticket.images"
                                        :key="image.id"
                                        class="pl-1 basis-full sm:basis-1/2 md:basis-1/3 lg:basis-1/4"
                                    >
                                        <div
                                            class="p-1 cursor-pointer hover:opacity-90 transition-opacity"
                                            @click="openImageModal(image)"
                                        >
                                            <img
                                                :src="`/storage/${image.imageUrl}`"
                                                class="w-full h-48 object-cover rounded-lg"
                                                :alt="`Image ${image.id}`"
                                            />
                                        </div>
                                    </CarouselItem>
                                </CarouselContent>
                                <CarouselPrevious
                                    class="absolute left-0 top-1/2 -translate-y-1/2"
                                />
                                <CarouselNext
                                    class="absolute right-0 top-1/2 -translate-y-1/2"
                                />
                            </Carousel>
                        </div>
                        <div
                            v-else
                            class="text-gray-500 italic text-center py-4"
                        >
                            Aucune image pour ce ticket
                        </div>
                    </div>
                </div>
                <!-- Colonne du formulaire de création d'intervention -->
                <div v-if="showCreateIntervention" class="flex-1">
                    <CreateIntervention
                        :ticket-id="ticket.id"
                        :technicians="technicians"
                        @close="showCreateIntervention = false"
                    />
                </div>

                <!-- Section des interventions -->
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex items-center gap-3 mb-4">
                        <h2 class="text-xl font-bold">Interventions</h2>
                        <TooltipProvider>
                            <Tooltip>
                                <TooltipTrigger>
                                    <font-awesome-icon
                                        icon="fa-solid fa-plus"
                                        :class="`px-3 py-2 transition-all rounded-md ${
                                            ticket.isFinished
                                                ? 'text-gray-400 cursor-not-allowed'
                                                : 'cursor-pointer hover:bg-indigo-50'
                                        }`"
                                        @click="
                                            !ticket.isFinished &&
                                                (showCreateIntervention =
                                                    !showCreateIntervention)
                                        "
                                    />
                                </TooltipTrigger>
                                <TooltipContent v-if="ticket.isFinished">
                                    <p>
                                        Impossible de créer une intervention sur
                                        un ticket résolu
                                    </p>
                                </TooltipContent>
                            </Tooltip>
                        </TooltipProvider>
                    </div>

                    <div
                        v-if="interventions && interventions.length > 0"
                        class="space-y-4"
                    >
                        <div
                            v-for="intervention in interventions"
                            :key="intervention.id"
                            class="bg-gray-50 rounded-lg shadow-sm p-4 hover:bg-gray-100 duration-200"
                        >
                            <Link
                                :href="`/interventions/${intervention.id}/edit`"
                            >
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div
                                            class="flex gap-4 text-sm text-gray-600"
                                        >
                                            <span>
                                                <font-awesome-icon
                                                    icon="fa-solid fa-calendar"
                                                    class="mr-2"
                                                />
                                                {{
                                                    formatDate(
                                                        intervention.date
                                                    )
                                                }}
                                            </span>
                                            <span>
                                                <font-awesome-icon
                                                    icon="fa-solid fa-clock"
                                                    class="mr-2"
                                                />
                                                {{ intervention.duration }}
                                                {{
                                                    intervention.duration > 1
                                                        ? "minutes"
                                                        : "minute"
                                                }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex gap-3">
                                        <DropdownMenu
                                            v-if="intervention.users.length"
                                        >
                                            <DropdownMenuTrigger
                                                class="flex items-center px-3 py-1 text-sm text-blue-600 bg-blue-100 rounded-full hover:bg-blue-200"
                                            >
                                                <font-awesome-icon
                                                    icon="fa-solid fa-users"
                                                    class="mr-2"
                                                />
                                                {{ intervention.users.length }}
                                                technicien(s)
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent>
                                                <div class="p-2">
                                                    <div
                                                        v-for="user in intervention.users"
                                                        :key="user.id"
                                                        class="py-1"
                                                    >
                                                        {{ user.firstName }}
                                                        {{ user.lastName }}
                                                    </div>
                                                </div>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </div>
                                </div>
                            </Link>
                        </div>
                    </div>

                    <div v-else class="italic text-gray-500">
                        Aucune intervention pour ce ticket
                    </div>
                </div>

                <!-- Modal pour l'affichage en grand -->
                <Dialog :open="!!selectedImage" @update:open="closeImageModal">
                    <DialogContent
                        class="sm:max-w-[95vw] sm:max-h-[95vh] w-[95vw] h-[95vh] p-0 overflow-hidden flex items-center justify-center"
                    >
                        <div
                            class="relative w-full h-full flex items-center justify-center"
                        >
                            <img
                                v-if="selectedImage"
                                :src="`/storage/${selectedImage.imageUrl}`"
                                class="w-full h-auto max-w-[90%] max-h-[90%] object-contain"
                                :alt="`Image en plein écran`"
                            />
                        </div>
                    </DialogContent>
                </Dialog>
            </div>
        </div>
    </AppLayout>
</template>
