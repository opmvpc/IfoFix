<template>
    <Card class="h-full">
        <CardHeader>Types</CardHeader>
        <CardContent>
            <Table>
                <TableHead>
                    <TableRow>
                        <TableHeader>Type</TableHeader>
                    </TableRow>
                </TableHead>
                <TableBody>
                    <TableRow
                        v-for="type in props.types"
                        :key="type.id"
                        @click="
                            () => {
                                selectType(type);
                            }
                        "
                        class="cursor-pointer"
                        :class="
                            selectedType && selectedType.id === type.id
                                ? 'bg-indigo-300 text-indigo-100 dark:bg-indigo-900'
                                : ''
                        "
                    >
                        <TableCell>{{ type.name }}</TableCell>
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
import { ref, watch } from "vue";

const props = defineProps({
    types: {
        type: Array,
        required: true,
    },
});

const selectType = (type) => {
    if (selectedType.value && selectedType.value.id === type.id) {
        selectedType.value = null;
        emit("type-selected", null);
        return;
    }
    emit("type-selected", type);
    selectedType.value = type;
};

const selectedType = ref(null);

const emit = defineEmits(["type-selected"]);
</script>
