<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter,
} from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";

const props = defineProps({
    intervention: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AppLayout title="Détails de l'intervention">
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
                        <div class="grid gap-6">
                            <div class="grid gap-2">
                                <h3 class="font-medium">Description</h3>
                                <p class="text-gray-600">
                                    {{ intervention.description }}
                                </p>
                            </div>

                            <div class="grid gap-2">
                                <h3 class="font-medium">Durée</h3>
                                <p class="text-gray-600">
                                    {{ intervention.duration }} minutes
                                </p>
                            </div>

                            <div class="grid gap-2">
                                <h3 class="font-medium">Date</h3>
                                <p class="text-gray-600">
                                    {{ intervention.date }}
                                </p>
                            </div>

                            <div class="grid gap-2">
                                <h3 class="font-medium">Statut</h3>
                                <p class="text-gray-600">
                                    {{
                                        intervention.isFinished
                                            ? "Terminée"
                                            : "En cours"
                                    }}
                                </p>
                            </div>

                            <div class="grid gap-2">
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
                                        <span
                                            >{{ user.firstName }}
                                            {{ user.lastName }}</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                    <CardFooter class="flex justify-end">
                        <Button
                            variant="outline"
                            :href="route('interventions.index')"
                        >
                            Retour
                        </Button>
                    </CardFooter>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
