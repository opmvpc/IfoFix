<template>
    <Card class="h-full">
        <CardHeader>Marques</CardHeader>
        <CardContent>
            <Table>
                <TableHead>
                    <TableRow>
                        <TableHeader>Marques</TableHeader>
                    </TableRow>
                </TableHead>
                <TableBody>
                    <TableRow
                        v-for="brand in props.brands"
                        :key="brand.id"
                        @click="() => emit('brand-selected', brand)"
                    >
                        <TableCell>{{ brand.name }}</TableCell>
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
    brands: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["brand-selected"]);
</script>
