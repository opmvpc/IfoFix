<script setup lang="ts">
import Button from "@/Components/ui/button/Button.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    ticket: Object,
});
</script>

<template>
    <AppLayout>
        <div class="p-6">
            <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between gap-2 mb-6">
                    <h1 class="text-2xl font-bold">
                        Détails du Ticket #{{ ticket.id }}
                    </h1>
                    <Button>Créer une intervention</Button>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div class="border-b pb-4">
                        <h2 class="text-xl font-semibold mb-2">
                            {{ ticket.title }}
                        </h2>
                        <p class="text-gray-600">{{ ticket.description }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
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

                        <div class="space-y-2">
                            <p class="font-semibold">Technicien assigné</p>
                            <p v-if="ticket.user">
                                {{ ticket.user.firstName }}
                                {{ ticket.user.lastName }}
                            </p>
                            <p v-else class="text-gray-500">Non assigné</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <p class="font-semibold">Appareil</p>
                            <p>{{ ticket.device?.name || "Non spécifié" }}</p>
                        </div>

                        <div class="space-y-2">
                            <p class="font-semibold">Client</p>
                            <p>
                                {{ ticket.client.firstName }}
                                {{ ticket.client.lastName }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
