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

import { Dialog, DialogContent } from "@/Components/ui/dialog";

import { Badge } from "@/Components/ui/badge";
import BackButton from "@/Components/BackButton.vue";
import InterventionsList from "./partials/InterventionsList.vue";
import { formatDate } from "@/lib/utils";

const props = defineProps({
    ticket: Object,
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
                                        Détails du ticket #{{ ticket.id }}
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
                <InterventionsList
                    :ticket="ticket"
                    :interventions="interventions"
                    :auth="auth"
                    @create-intervention="showCreateIntervention = true"
                />

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
