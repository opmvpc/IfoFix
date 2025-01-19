<template>
    <Dialog
        :open="isOpen"
        @update:open="closeDialog"
        :aria-description="`Formulaire de modification ${itemType}`"
    >
        <DialogContent>
            <DialogHeader>
                <DialogTitle>
                    {{ initialName ? "Modifier" : "Ajouter" }} {{ itemType }}
                </DialogTitle>
                <DialogDescription>
                    {{ initialName ? "Modifiez" : "Remplissez" }} les
                    informations ci-dessous et cliquez sur
                    {{ initialName ? "Enregistrer" : "Ajouter" }} pour valider.
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid items-center gap-4">
                    <Input v-model="editingName" placeholder="Nom" />

                    <!-- Additional fields for device editing -->
                    <template v-if="itemType === 'appareil'">
                        <div class="space-y-2">
                            <Label>Type</Label>
                            <Select v-model="selectedType">
                                <SelectTrigger>
                                    <SelectValue
                                        placeholder="Sélectionner un type"
                                    />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem
                                        v-for="type in types"
                                        :key="type.id"
                                        :value="type.id"
                                    >
                                        {{ type.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </div>

                        <div class="space-y-2">
                            <Label>Marque</Label>
                            <Select v-model="selectedBrand">
                                <SelectTrigger>
                                    <SelectValue
                                        placeholder="Sélectionner une marque"
                                    />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem
                                        v-for="brand in brands"
                                        :key="brand.id"
                                        :value="brand.id"
                                    >
                                        {{ brand.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                    </template>
                </div>
            </div>
            <DialogFooter>
                <Button variant="ghost" @click="closeDialog">Annuler</Button>
                <Button @click="handleSubmit">
                    {{ initialName ? "Enregistrer" : "Ajouter" }}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup>
import { ref, watch } from "vue";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/Components/ui/dialog";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";

const props = defineProps({
    isOpen: Boolean,
    initialName: String,
    itemType: String,
    initialType: Number,
    initialBrand: Number,
    types: Array,
    brands: Array,
});

const emit = defineEmits(["update:isOpen", "save"]);

const editingName = ref("");
const selectedType = ref(null);
const selectedBrand = ref(null);

watch(
    () => props.initialName,
    (newVal) => {
        editingName.value = newVal || "";
    },
    { immediate: true }
);

watch(
    () => props.initialType,
    (newVal) => {
        selectedType.value = newVal || null;
    },
    { immediate: true }
);

watch(
    () => props.initialBrand,
    (newVal) => {
        selectedBrand.value = newVal || null;
    },
    { immediate: true }
);

watch(
    () => props.isOpen,
    (newVal) => {
        if (!newVal) {
            editingName.value = "";
            selectedType.value = null;
            selectedBrand.value = null;
        }
    }
);

const closeDialog = () => {
    emit("update:isOpen", false);
};

const handleSubmit = () => {
    const data = {
        name: editingName.value,
        ...(props.itemType === "appareil" && {
            typeId: Number(selectedType.value),
            brandId: Number(selectedBrand.value),
        }),
    };
    emit("save", data);
};
</script>
