<template>
    <Table>
        <TableBody>
            <TableRow
                v-for="brand in props.brands"
                :key="brand.id"
                @click="() => emit('brand-selected', brand)"
                class="transition-colors cursor-pointer"
                :class="{
                    'bg-indigo-300 dark:bg-indigo-900':
                        selectedBrand?.id === brand.id,
                    'hover:bg-gray-100 dark:hover:bg-gray-800':
                        selectedBrand?.id !== brand.id,
                }"
            >
                <TableCell>{{ brand.name }}</TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>

<script setup>
import { Table, TableBody, TableCell, TableRow } from "@/Components/ui/table";

const props = defineProps({
    brands: {
        type: Array,
        required: true,
    },
    selectedBrand: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(["brand-selected"]);
</script>
