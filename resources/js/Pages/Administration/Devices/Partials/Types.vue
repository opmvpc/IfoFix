<template>
    <div class="h-[calc(100vh-250px)] overflow-y-auto scrollbar-custom">
        <Table>
            <TableBody>
                <TableRow
                    v-for="type in types"
                    :key="type.id"
                    @click="$emit('filter-type', type)"
                    class="transition-colors cursor-pointer group"
                    :class="{
                        'bg-indigo-300 dark:bg-indigo-900':
                            props.selectedType?.id === type.id,
                        'hover:bg-gray-100 dark:hover:bg-gray-800':
                            props.selectedType?.id !== type.id,
                    }"
                >
                    <TableCell class="flex items-center justify-between">
                        <span>{{ type.name }}</span>
                        <div class="items-center hidden gap-2 group-hover:flex">
                            <Button
                                variant="ghost"
                                size="sm"
                                @click.stop="$emit('type-selected', type)"
                            >
                                <font-awesome-icon
                                    icon="fa-solid fa-pen"
                                    class="w-4 h-4"
                                />
                            </Button>
                            <Button
                                variant="ghost"
                                size="sm"
                                @click.stop="deleteType(type)"
                            >
                                <font-awesome-icon
                                    icon="fa-solid fa-trash"
                                    class="w-4 h-4 text-red-500"
                                />
                            </Button>
                        </div>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>

<script setup>
import { Table, TableBody, TableCell, TableRow } from "@/Components/ui/table";
import { Button } from "@/Components/ui/button";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    types: {
        type: Array,
        required: true,
    },
    selectedType: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(["type-selected", "filter-type"]);

const setSelected = (type) => {
    emit("type-selected", type);
};

const deleteType = (type) => {
    if (confirm("Êtes-vous sûr de vouloir supprimer ce type ?")) {
        router.delete(`/types/${type.id}`, {
            preserveScroll: true,
            preserveState: true,
        });
    }
};
</script>

<style scoped>
.scrollbar-custom {
    scrollbar-width: thin;
    scrollbar-color: hsl(var(--primary)) hsl(var(--muted));
    -webkit-overflow-scrolling: touch;
}

.scrollbar-custom::-webkit-scrollbar {
    width: 8px;
}

.scrollbar-custom::-webkit-scrollbar-track {
    background-color: hsl(var(--muted));
    @apply rounded-full;
}

.scrollbar-custom::-webkit-scrollbar-thumb {
    background-color: hsl(var(--primary));
    @apply rounded-full;
}

.scrollbar-custom::-webkit-scrollbar-thumb:hover {
    background-color: hsl(var(--primary) / 0.8);
}
</style>
