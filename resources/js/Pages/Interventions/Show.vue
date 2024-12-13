<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
} from "@/Components/ui/card";

const props = defineProps({
    intervention: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AppLayout title="Détails de l'intervention">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Intervention #{{ intervention.id }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle>Détails de l'intervention</CardTitle>
                        <CardDescription>
                            Créée le {{ intervention.created_at }}
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="grid gap-4">
                            <div>
                                <h3 class="font-medium">Description</h3>
                                <p class="text-gray-600">
                                    {{
                                        intervention.description ||
                                        "Aucune description"
                                    }}
                                </p>
                            </div>

                            <div>
                                <h3 class="font-medium">Durée</h3>
                                <p class="text-gray-600">
                                    {{
                                        intervention.duration || "Non spécifiée"
                                    }}
                                </p>
                            </div>

                            <div>
                                <h3 class="font-medium">Date</h3>
                                <p class="text-gray-600">
                                    {{
                                        intervention.date
                                            ? intervention.date
                                            : "Non spécifiée"
                                    }}
                                </p>
                            </div>

                            <div>
                                <h3 class="font-medium">Statut</h3>
                                <p class="text-gray-600">
                                    <span
                                        :class="
                                            intervention.isFinished
                                                ? 'text-green-600'
                                                : 'text-yellow-600'
                                        "
                                    >
                                        {{
                                            intervention.isFinished
                                                ? "Terminée"
                                                : "En cours"
                                        }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <h3 class="font-medium">Intervenants</h3>
                                <div class="mt-2 space-y-2">
                                    <div
                                        v-for="user in intervention.users"
                                        :key="user.id"
                                        class="flex items-center space-x-2"
                                    >
                                        <font-awesome-icon
                                            icon="fa-solid fa-user"
                                            class="text-gray-400"
                                        />
                                        <span>{{ user.firstName }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
