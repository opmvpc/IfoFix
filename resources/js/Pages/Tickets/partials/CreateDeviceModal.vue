<template>
    <Dialog
        :open="modelValue"
        @update:open="$emit('update:modelValue', $event)"
    >
        <DialogContent class="sm:max-w-[500px]">
            <DialogHeader>
                <DialogTitle>Créer un nouvel appareil</DialogTitle>
            </DialogHeader>

            <form @submit.prevent="submitNewDevice" class="space-y-4">
                <div>
                    <Label for="newDeviceName">Nom</Label>
                    <Input id="newDeviceName" v-model="newDeviceForm.name" />
                </div>
                <div>
                    <Label for="newDeviceBrand">Marque</Label>
                    <Select v-model="newDeviceForm.brandId">
                        <SelectTrigger>
                            <SelectValue
                                placeholder="Sélectionner une marque"
                            />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem
                                    v-for="brand in props.brands"
                                    :key="brand.id"
                                    :value="brand.id"
                                >
                                    {{ brand.name }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <div>
                    <Label for="newDeviceType">Type</Label>
                    <Select v-model="newDeviceForm.typeId">
                        <SelectTrigger>
                            <SelectValue placeholder="Sélectionner un type" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem
                                    v-for="type in props.types"
                                    :key="type.id"
                                    :value="type.id"
                                >
                                    {{ type.name }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <DialogFooter>
                    <Button
                        type="button"
                        variant="secondary"
                        @click="closeNewDeviceModal"
                    >
                        Annuler
                    </Button>
                    <Button type="submit">Créer</Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>

<script setup>
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";

import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogFooter,
} from "@/Components/ui/dialog";

import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";

const props = defineProps({
    modelValue: {
        type: Boolean,
        required: true,
    },
    newDeviceForm: {
        type: Object,
        required: true,
    },
    brands: Array,
    types: Array,
});

const emit = defineEmits(["update:modelValue"]);

const closeNewDeviceModal = () => {
    emit("update:modelValue", false);
};

const submitNewDevice = () => {
    props.newDeviceForm.post(route("devices.store"), {
        preserveScroll: true,
        onSuccess: (response) => {
            closeNewDeviceModal();
        },
    });
};
</script>
