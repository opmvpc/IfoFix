<script setup lang="ts">
import Button from "@/Components/ui/button/Button.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import CreateIntervention from "@/Components/Interventions/CreateIntervention.vue";
import { ref } from "vue";

const props = defineProps({
    ticket: Object,
});

const showCreateIntervention = ref(false);

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString("fr-FR");
};
</script>

<template>
    <AppLayout>
        <div class="p-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Colonne des détails du ticket -->
                <div class="bg-white rounded-lg shadow-lg p-6 flex-1">
                    <div class="flex items-center justify-between gap-2 mb-6">
                        <h1 class="text-2xl font-bold">
                            Détails du Ticket #{{ ticket.id }}
                        </h1>
                        <Button
                            @click="
                                showCreateIntervention = !showCreateIntervention
                            "
                        >
                            <font-awesome-icon
                                icon="fa-solid fa-plus"
                                class="mr-2"
                            />
                            {{
                                showCreateIntervention
                                    ? "Masquer"
                                    : "Créer une intervention"
                            }}
                        </Button>
                    </div>

                    <div class="flex flex-col gap-6">
                        <div class="border-b pb-4">
                            <h2 class="text-xl font-semibold mb-2">
                                {{ ticket.title }}
                            </h2>
                            <p class="text-gray-600">
                                {{ ticket.description }}
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-4">
                            <div class="flex-1 min-w-[200px] space-y-2">
                                <p class="font-semibold">Créé par</p>
                                <div class="flex items-center">
                                    <span>{{ ticket.user.firstName }}</span>
                                </div>
                            </div>

                            <div class="flex-1 min-w-[200px] space-y-2">
                                <p class="font-semibold">Date de création</p>
                                <p>{{ formatDate(ticket.created_at) }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-4">
                            <div class="flex-1 min-w-[200px] space-y-2">
                                <p class="font-semibold">Status</p>
                                <div class="flex items-center">
                                    <span
                                        :class="{
                                            'px-3 py-1 rounded-full text-sm': true,
                                            'bg-emerald-100 text-emerald-600':
                                                ticket.isFinished,
                                            'bg-orange-100 text-orange-600':
                                                !ticket.isFinished,
                                        }"
                                    >
                                        {{
                                            ticket.isFinished
                                                ? "Terminé"
                                                : "En cours"
                                        }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex-1 min-w-[200px] space-y-2">
                                <p class="font-semibold">Technicien assigné</p>
                                <p v-if="ticket.user">
                                    {{ ticket.user.firstName }}
                                    {{ ticket.user.lastName }}
                                </p>
                                <p v-else class="text-gray-500">Non assigné</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-4">
                            <div class="flex-1 min-w-[200px] space-y-2">
                                <p class="font-semibold">Appareil</p>
                                <p>
                                    {{ ticket.device?.name || "Non spécifié" }}
                                </p>
                            </div>

                            <div class="flex-1 min-w-[200px] space-y-2">
                                <p class="font-semibold">Client</p>
                                <p>
                                    {{ ticket.client.firstName }}
                                    {{ ticket.client.lastName }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne du formulaire de création d'intervention -->
                <div v-if="showCreateIntervention" class="flex-1">
                    <CreateIntervention
                        :ticket-id="ticket.id"
                        @close="showCreateIntervention = false"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
