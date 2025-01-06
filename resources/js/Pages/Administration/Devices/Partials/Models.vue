<template>
    <Card class="h-full">
        <CardHeader>Modeles</CardHeader>
        <CardContent>
            <Table>
                <TableHead>
                    <TableRow>
                        <TableHeader>Modeles</TableHeader>
                    </TableRow>
                </TableHead>
                <TableBody>
                    <TableRow
                        v-for="device in props.devices"
                        :key="device.id"
                        @click="() => emit('device-selected', device)"
                    >
                        <TableCell>{{ device.name }}</TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </CardContent>
    </Card>
</template>

<script setup>
import { Card, CardHeader } from "@/Components/ui/card";
import CardContent from "@/Components/ui/card/CardContent.vue";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/Components/ui/table";

const props = defineProps({
    devices: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["device-selected"]);
</script>
