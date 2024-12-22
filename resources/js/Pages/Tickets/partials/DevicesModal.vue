<template>
    <Dialog
        :open="modelValue"
        @update:open="$emit('update:modelValue', $event)"
    >
        <DialogContent class="sm:max-w-[500px] min-h-[500px]">
            <DialogHeader>
                <DialogTitle>Sélectionner un appareil</DialogTitle>
                <DialogDescription>
                    Recherchez et sélectionnez un appareil
                </DialogDescription>
            </DialogHeader>

            <div class="space-y-4">
                <Input
                    type="search"
                    placeholder="Rechercher un appareil..."
                    v-model="deviceSearch"
                />

                <div class="h-[300px] overflow-y-auto space-y-2">
                    <RadioGroup v-model="props.form.deviceId">
                        <div
                            v-for="device in filteredDevices"
                            :key="device.id"
                            class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded"
                        >
                            <RadioGroupItem
                                :value="device.id"
                                :id="'device-' + device.id"
                            />
                            <Label
                                :for="'device-' + device.id"
                                class="flex-grow cursor-pointer"
                            >
                                {{ device.name }}
                            </Label>
                        </div>
                    </RadioGroup>
                </div>
            </div>

            <DialogFooter>
                <Button
                    type="button"
                    variant="secondary"
                    @click="closeDeviceModal"
                >
                    Confirmer
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup>
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
    DialogFooter,
} from "@/Components/ui/dialog";
import { Input } from "@/Components/ui/input";
import { RadioGroup, RadioGroupItem } from "@/Components/ui/radio-group";
import { Label } from "@/Components/ui/label";
import { Button } from "@/Components/ui/button";
import { computed, ref, watch } from "vue";

const props = defineProps({
    modelValue: Boolean, // Remplace isDeviceModalOpen
    form: Object,
    devices: Array,
});

const deviceSearch = ref("");

const filteredDevices = computed(() => {
    if (!deviceSearch.value) return props.devices;
    return props.devices.filter((device) =>
        device.name.toLowerCase().includes(deviceSearch.value.toLowerCase())
    );
});

const selectedDeviceName = computed(() => {
    const selectedDevice = props.devices.find(
        (d) => d.id === props.form.deviceId
    );
    return selectedDevice ? selectedDevice.name : "";
});

const emit = defineEmits(["update:modelValue", "update:selectedDeviceName"]);

const closeDeviceModal = () => {
    emit("update:modelValue", false);
    emit("update:selectedDeviceName", selectedDeviceName.value);
};

// Émettre la mise à jour du nom quand l'appareil change
watch(
    () => props.form.deviceId,
    () => {
        emit("update:selectedDeviceName", selectedDeviceName.value);
    }
);
</script>
