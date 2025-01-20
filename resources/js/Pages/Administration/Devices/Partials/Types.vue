<template>
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
