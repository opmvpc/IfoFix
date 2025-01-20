<template>
    <div class="">
        <div
            v-if="props.interventions && props.interventions.length > 0"
            class="space-y-4"
        >
            <card
                v-for="intervention in props.interventions"
                :key="intervention.id"
                class="p-4 duration-200 rounded-lg shadow-sm bg-gradient-to-b from-indigo-50 to-indigo-100 dark:from-indigo-950 dark:via-indigo-950 dark:to-indigo-950 dark:brightness-75 hover:bg-gray-100"
            >
                <Link :href="getInterventionUrl(intervention)">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex gap-4 text-sm">
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
                        </div>
                    </div>
                </Link>
            </card>
        </div>

        <div v-else class="italic text-gray-500">
            Aucune intervention pour ce ticket
        </div>
    </div>
</template>

<script setup>
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";

import { formatDate } from "@/lib/utils";
import { Link } from "@inertiajs/vue3";
import { Card } from "@/Components/ui/card";

const props = defineProps({
    ticket: Object,
    interventions: Array,
    auth: Object,
});
const emit = defineEmits(["create-intervention"]);

const getInterventionUrl = (intervention) => {
    const canEdit =
        props.auth.user.role === "admin" ||
        intervention.users.some((user) => user.id === props.auth.user.id);

    return `/interventions/${intervention.id}/${canEdit ? "edit" : ""}`;
};
</script>
