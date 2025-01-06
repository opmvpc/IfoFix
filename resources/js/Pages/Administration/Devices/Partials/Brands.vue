<template>
    <Card class="h-full">
        <CardHeader>Marques</CardHeader>
        <CardContent>
            <Table>
                <TableBody>
                    <TableRow
                        v-for="brand in props.brands"
                        :key="brand.id"
                        @click="() => setSelected(brand)"
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
import { ref } from "vue";

const props = defineProps({
    brands: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["brand-selected"]);

const selectedBrand = ref(null);

const setSelected = (brand) => {
    if (selectedBrand.value && selectedBrand.value.id === brand.id) {
        selectedBrand.value = null;
        emit("brand-selected", null);
        return;
    }
    emit("brand-selected", brand);
    selectedBrand.value = brand;
};
</script>
