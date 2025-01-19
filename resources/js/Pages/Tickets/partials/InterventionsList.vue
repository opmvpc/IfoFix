<template>
    <div class="bg-white rounded-lg shadow-md p-4">
        <div class="flex items-center gap-3 mb-4">
            <h2 class="text-xl font-bold">Interventions</h2>
            <TooltipProvider v-if="auth.user.role === 'admin'">
                <Tooltip>
                    <TooltipTrigger>
                        <font-awesome-icon
                            icon="fa-solid fa-plus"
                            :class="`px-3 py-2 transition-all rounded-md ${
                                props.ticket.isFinished
                                    ? 'text-gray-400 cursor-not-allowed'
                                    : 'cursor-pointer hover:bg-indigo-50'
                            }`"
                            @click="
                                !props.ticket.isFinished
                                    ? $emit('create-intervention')
                                    : ''
                            "
                        />
                    </TooltipTrigger>
                    <TooltipContent v-if="props.ticket.isFinished">
                        <p>
                            Impossible de créer une intervention sur un ticket
                            résolu
                        </p>
                    </TooltipContent>
                </Tooltip>
            </TooltipProvider>
        </div>

        <div
            v-if="props.interventions && props.interventions.length > 0"
            class="space-y-4"
        >
            <div
                v-for="intervention in props.interventions"
                :key="intervention.id"
                class="bg-gray-50 rounded-lg shadow-sm p-4 hover:bg-gray-100 duration-200"
            >
                <Link :href="getInterventionUrl(intervention)">
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
                        </div>
                    </div>
                </Link>
            </div>
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
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from "@/Components/ui/tooltip";
import { formatDate } from "@/lib/utils";
import { Link } from "@inertiajs/vue3";

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
