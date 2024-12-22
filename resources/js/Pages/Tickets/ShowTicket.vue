<script setup>
import Button from "@/Components/ui/button/Button.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import CreateIntervention from "@/Components/Interventions/CreateIntervention.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref, h, computed } from "vue";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";
import { Badge } from "@/Components/ui/badge";

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
</script>

<template>
    <AppLayout>
        <Head :title="'Détails du Ticket #' + ticket.id" />
        <div class="p-6">
            <div class="flex flex-col gap-6 lg:flex-row">
                <!-- Colonne des détails du ticket -->
                <div class="flex-1 p-6 bg-white rounded-lg shadow-lg">
                    <!-- <div class="flex items-center justify-between gap-2 mb-6">
                        <h1 class="text-2xl font-bold">
                            Détails du Ticket #{{ ticket.id }}
                        </h1>

                    </div> -->

                    <div class="flex flex-col gap-6">
                        <div class="pb-4 border-b">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h2 class="text-3xl font-semibold">
                                        #{{ ticket.id }} {{ ticket.title }}
                                    </h2>
                                    <div class="flex items-center gap-2">
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
                                        <span class="text-sm text-gray-600">
                                            {{ formatDate(ticket.created_at) }}
                                        </span>
                                    </div>
                                </div>
                                <Button
                                    @click="
                                        showCreateIntervention =
                                            !showCreateIntervention
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
                            <p class="text-gray-600">
                                {{ ticket.description }}
                            </p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
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

                            <div class="flex-1 min-w-[200px] space-y-2">
                                <p class="font-semibold">Créé par</p>
                                <div class="flex items-center">
                                    <span>{{ ticket.user.firstName }}</span>
                                </div>
                            </div>
                            <!-- <div class="flex-1 min-w-[200px] space-y-2">
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
                            </div> -->

                            <div class="flex-1 min-w-[200px] space-y-2">
                                <p class="font-semibold">Technicien(s)</p>
                                <div
                                    v-if="uniqueTechnicians.length > 0"
                                    class="flex flex-wrap h-40 gap-2"
                                >
                                    <div
                                        v-for="technician in uniqueTechnicians"
                                        :key="technician.id"
                                        class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-sm font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80"
                                    >
                                        <font-awesome-icon
                                            icon="fa-solid fa-user"
                                            class="w-3 h-3 mr-2"
                                        />
                                        {{ technician.firstName }}
                                        {{ technician.lastName }}
                                    </div>
                                </div>
                                <div v-else class="text-gray-500">
                                    Non assigné
                                </div>
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
                <h2 class="mb-4 text-xl font-bold">Interventions</h2>

                <div
                    v-if="interventions && interventions.length > 0"
                    class="space-y-4"
                >
                    <div
                        v-for="intervention in interventions"
                        :key="intervention.id"
                        class="p-4 bg-white rounded-lg shadow-lg"
                    >
                        <div class="flex items-center justify-between">
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
                            <div class="flex gap-3">
                                <DropdownMenu v-if="intervention.users.length">
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
                                </div>
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

                <div v-else class="italic text-gray-500">
                    Aucune intervention pour ce ticket
                </div>
            </div>
        </div>
    </AppLayout>
</template>
