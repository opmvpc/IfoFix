<template>
    <Table>
        <TableBody>
            <TableRow
                v-for="type in types"
                :key="type.id"
                @click="() => selectType(type)"
                class="transition-colors cursor-pointer"
                :class="{
                    'bg-indigo-300 dark:bg-indigo-900':
                        selectedType?.id === type.id,
                    'hover:bg-gray-100 dark:hover:bg-gray-800':
                        selectedType?.id !== type.id,
                }"
            >
                <TableCell>{{ type.name }}</TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>

<script setup>
import { Table, TableBody, TableCell, TableRow } from "@/Components/ui/table";
import { ref, watch } from "vue";

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

const emit = defineEmits(["type-selected"]);

const selectType = (type) => {
    emit("type-selected", type);
};
</script>
