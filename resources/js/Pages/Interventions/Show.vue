<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Badge } from "@/Components/ui/badge";
import BackButton from "@/Components/BackButton.vue";
import { formatDate } from "@/lib/utils";

const props = defineProps({
    intervention: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AppLayout>
        <Head :title="'Détails de l intervention #' + intervention.id" />
        <div class="p-6">
            <div class="flex flex-col gap-6">
                <div class="flex-1 p-6 bg-white rounded-lg shadow-md">
                    <div class="flex flex-col gap-6">
                        <div class="pb-4 border-b">
                            <div class="flex items-start justify-between mb-4">
                                <BackButton />

                                <div class="flex flex-col items-end">
                                    <h2 class="text-3xl font-semibold">
                                        Détails de l'intervention #{{
                                            intervention.id
                                        }}
                                    </h2>
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm text-gray-500 italic">
                                            Créée le
                                            {{
                                                formatDate(
                                                    intervention.created_at
                                                )
                                            }}
                                        </p>
                                    </div>
                                    <Badge
                                        :variant="
                                            intervention.isFinished
                                                ? 'success'
                                                : 'warning'
                                        "
                                    >
                                        {{
                                            intervention.isFinished
                                                ? "Terminée"
                                                : "En cours"
                                        }}
                                    </Badge>
                                </div>
                            </div>
                            <p class="font-semibold">Description</p>
                            <p class="text-gray-600">
                                {{ intervention.description }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="flex-1 min-w-[200px]">
                                <p class="font-semibold mb-2">Informations</p>
                                <p>
                                    <span class="text-xs">Durée : </span>
                                    {{ intervention.duration }} minutes
                                </p>
                                <p>
                                    <span class="text-xs">Date : </span>
                                    {{ formatDate(intervention.date) }}
                                </p>
                            </div>

                            <div class="flex-1 min-w-[200px] space-y-2">
                                <p class="font-semibold">Techniciens</p>
                                <div class="flex flex-wrap gap-2">
                                    <Badge
                                        v-for="user in intervention.users"
                                        :key="user.id"
                                    >
                                        <font-awesome-icon
                                            icon="fa-solid fa-user"
                                            class="w-3 h-3 mr-2"
                                        />
                                        {{ user.firstName }} {{ user.lastName }}
                                    </Badge>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
