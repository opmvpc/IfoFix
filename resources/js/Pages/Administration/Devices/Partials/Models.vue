<template>
    <Table>
        <TableBody>
            <TableRow
                v-for="device in props.devices"
                :key="device.id"
                @click="() => emit('device-selected', device)"
                class="transition-colors cursor-pointer"
                :class="{
                    'bg-indigo-300 dark:bg-indigo-900':
                        selectedDevice?.id === device.id,
                    'hover:bg-gray-100 dark:hover:bg-gray-800':
                        selectedDevice?.id !== device.id,
                }"
            >
                <TableCell>{{ device.name }}</TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>

<script setup>
import { Table, TableBody, TableCell, TableRow } from "@/Components/ui/table";

const props = defineProps({
    devices: {
        type: Array,
        required: true,
    },
    selectedDevice: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(["device-selected"]);
</script>
