<template>
    <EditDialog
        v-model:isOpen="isDialogOpen"
        :initial-name="editingName"
        item-type="marque"
        @save="updateName"
    />
    <Table>
        <TableBody>
            <TableRow
                v-for="brand in props.brands"
                :key="brand.id"
                @click="setSelected(brand)"
                class="transition-colors cursor-pointer group"
                :class="{
                    'bg-indigo-300 dark:bg-indigo-900':
                        selectedBrand?.id === brand.id,
                    'hover:bg-gray-100 dark:hover:bg-gray-800':
                        selectedBrand?.id !== brand.id,
                }"
            >
                <TableCell class="flex items-center justify-between">
                    <span>{{ brand.name }}</span>
                    <div class="items-center hidden gap-2 group-hover:flex">
                        <Button
                            variant="ghost"
                            size="sm"
                            @click.stop="startEdit(brand)"
                        >
                            <font-awesome-icon
                                icon="fa-solid fa-pen"
                                class="w-4 h-4"
                            />
                        </Button>
                        <Button
                            variant="ghost"
                            size="sm"
                            @click.stop="deleteBrand(brand)"
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
import EditDialog from "@/Components/EditDialog.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

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

const isDialogOpen = ref(false);
const editingId = ref(null);
const editingName = ref("");

const startEdit = (brand) => {
    editingId.value = brand.id;
    editingName.value = brand.name;
    isDialogOpen.value = true;
};

const updateName = (data) => {
    if (!editingId.value) return;

    router.put(`/brands/${editingId.value}`, data, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            const updatedBrand = props.brands.find(
                (b) => b.id === editingId.value
            );
            if (updatedBrand) {
                updatedBrand.name = data.name;
            }
            editingId.value = null;
            isDialogOpen.value = false;
        },
    });
};

const deleteBrand = (brand) => {
    if (confirm("Êtes-vous sûr de vouloir supprimer cette marque ?")) {
        router.delete(`/brands/${brand.id}`, {
            preserveScroll: true,
            preserveState: true,
        });
    }
};
</script>
