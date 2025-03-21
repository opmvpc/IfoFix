<template>
    <EditDialog
        v-model:isOpen="isDialogOpen"
        :initial-name="editingName"
        :initial-type="editingTypeId"
        :initial-brand="editingBrandId"
        :types="types"
        :brands="brands"
        item-type="Appareil"
        @save="updateDevice"
    />
    <div class="h-[calc(100vh-250px)] overflow-y-auto scrollbar-custom">
        <Table>
            <TableBody>
                <TableRow
                    v-for="device in props.devices"
                    :key="device.id"
                    @click="$emit('filter-device', device)"
                    class="transition-colors cursor-pointer group"
                    :class="{
                        'bg-indigo-300 dark:bg-indigo-900':
                            props.selectedDevice?.id === device.id,
                        'hover:bg-gray-100 dark:hover:bg-gray-800':
                            props.selectedDevice?.id !== device.id,
                    }"
                >
                    <TableCell class="flex items-center justify-between">
                        <span>{{ device.name }}</span>
                        <div class="items-center hidden gap-2 group-hover:flex">
                            <Button
                                variant="ghost"
                                size="sm"
                                @click.stop="$emit('device-selected', device)"
                            >
                                <font-awesome-icon
                                    icon="fa-solid fa-pen"
                                    class="w-4 h-4"
                                />
                            </Button>
                            <Button
                                variant="ghost"
                                size="sm"
                                @click.stop="deleteDevice(device)"
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
import EditDialog from "@/Components/EditDialog.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    devices: {
        type: Array,
        required: true,
    },
    selectedDevice: {
        type: Object,
        default: null,
    },
    types: {
        type: Array,
        required: true,
    },
    brands: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["device-selected", "filter-device"]);

const setSelected = (device) => {
    emit("device-selected", device);
};

const isDialogOpen = ref(false);
const editingId = ref(null);
const editingName = ref("");
const editingTypeId = ref(null);
const editingBrandId = ref(null);

const startEdit = (device) => {
    editingId.value = device.id;
    editingName.value = device.name;
    editingTypeId.value = device.typeId;
    editingBrandId.value = device.brandId;
    isDialogOpen.value = true;
};

const updateDevice = (data) => {
    if (!editingId.value) return;

    router.put(`/devices/${editingId.value}`, data, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            const updatedDevice = props.devices.find(
                (d) => d.id === editingId.value
            );
            if (updatedDevice) {
                updatedDevice.name = data.name;
                updatedDevice.typeId = data.typeId;
                updatedDevice.brandId = data.brandId;
            }
            editingId.value = null;
            isDialogOpen.value = false;
        },
    });
};

const deleteDevice = (device) => {
    if (confirm("Êtes-vous sûr de vouloir supprimer ce modèle ?")) {
        router.delete(`/devices/${device.id}`, {
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
