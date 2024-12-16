<script setup>
import Button from "@/Components/ui/button/Button.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import CreateIntervention from "@/Components/Interventions/CreateIntervention.vue";
import { Link } from "@inertiajs/vue3";
import { ref, h } from "vue";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";

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
                                <p class="font-semibold">Technicien(s)</p>
                                <div v-if="interventions[0]?.users?.length > 0">
                                    <p
                                        v-for="technician in interventions[0]
                                            .users"
                                        :key="technician.id"
                                    >
                                        {{ technician.firstName }}
                                        {{ technician.lastName }}
                                    </p>
                                </div>
                                <div v-else class="text-gray-500">
                                    Non assigné
                                </div>
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
                        :technicians="technicians"
                        @close="showCreateIntervention = false"
                    />
                </div>
            </div>

            <!-- Section des interventions -->
            <div class="mt-8 ml-10">
                <h2 class="text-xl font-bold mb-4">Interventions</h2>

                <div
                    v-if="interventions && interventions.length > 0"
                    class="space-y-4"
                >
                    <div
                        v-for="intervention in interventions"
                        :key="intervention.id"
                        class="bg-white rounded-lg shadow-lg p-4"
                    >
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="flex gap-4 text-sm text-gray-600">
                                    <span>
                                        <font-awesome-icon
                                            icon="fa-solid fa-calendar"
                                            class="mr-2"
                                        />
                                        {{ formatDate(intervention.date) }}
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
                            <DropdownMenu v-if="intervention.users.length">
                                <DropdownMenuTrigger
                                    class="flex items-center px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200"
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
                            <div class="flex items-center gap-4">
                                <span
                                    :class="{
                                        'px-3 py-1 rounded-full text-sm': true,
                                        'bg-emerald-100 text-emerald-600':
                                            intervention.isFinished,
                                        'bg-orange-100 text-orange-600':
                                            !intervention.isFinished,
                                    }"
                                >
                                    {{
                                        intervention.isFinished
                                            ? "Terminé"
                                            : "En cours"
                                    }}
                                </span>
                                <Link
                                    :href="`/interventions/${intervention.id}/edit`"
                                >
                                    <Button variant="outline" size="sm">
                                        <font-awesome-icon
                                            icon="fa-solid fa-eye"
                                            class="mr-2"
                                        />
                                        Voir
                                    </Button>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="text-gray-500 italic">
                    Aucune intervention pour ce ticket
                </div>
            </div>
        </div>
    </AppLayout>
</template>
