<template>
    <Dialog
        :open="modelValue"
        @update:open="$emit('update:modelValue', $event)"
    >
        <DialogContent class="sm:max-w-[425px] min-h-[500px]">
            <DialogHeader>
                <DialogTitle>Sélectionner des techniciens</DialogTitle>
                <DialogDescription>
                    Recherchez et sélectionnez un ou plusieurs techniciens
                </DialogDescription>
            </DialogHeader>

            <div class="space-y-4">
                <Input
                    type="search"
                    placeholder="Rechercher un technicien..."
                    v-model="technicianSearch"
                />

                <div class="h-[300px] overflow-y-auto space-y-2">
                    <div
                        v-for="tech in filteredTechnicians"
                        :key="tech.id"
                        class="flex items-center p-2 space-x-2 rounded hover:bg-gray-100"
                    >
                        <Checkbox
                            :id="'tech-' + tech.id"
                            :checked="
                                props.form.technicianIds.includes(tech.id)
                            "
                            @update:checked="toggleTechnician(tech.id)"
                        />
                        <Label :for="'tech-' + tech.id" class="flex-grow">
                            {{ tech.firstName }} {{ tech.lastName }}
                        </Label>
                    </div>
                </div>
            </div>

            <DialogFooter>
                <Button
                    type="button"
                    variant="secondary"
                    @click="confirmAndClose"
                >
                    Confirmer
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup>
import { computed, ref } from "vue";
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
    DialogFooter,
} from "@/Components/ui/dialog";
import { Input } from "@/Components/ui/input";
import { Checkbox } from "@/Components/ui/checkbox";
import { Label } from "@/Components/ui/label";
import { Button } from "@/Components/ui/button";

const props = defineProps({
    modelValue: Boolean,
    form: Object,
    technicians: Array,
});

const technicianSearch = ref("");

const filteredTechnicians = computed(() => {
    return props.technicians.filter(
        (tech) =>
            tech.firstName
                .toLowerCase()
                .includes(technicianSearch.value.toLowerCase()) ||
            tech.lastName
                .toLowerCase()
                .includes(technicianSearch.value.toLowerCase())
    );
});

const emit = defineEmits(["update:modelValue", "update:selectedTechnicians"]);

const toggleTechnician = (techId) => {
    const currentIds = [...props.form.technicianIds];
    const index = currentIds.indexOf(techId);

    if (index === -1) {
        currentIds.push(techId);
    } else {
        currentIds.splice(index, 1);
    }

    props.form.technicianIds = currentIds;

    // Émettre les techniciens sélectionnés
    const selectedTechs = props.technicians.filter((tech) =>
        currentIds.includes(tech.id)
    );
    emit("update:selectedTechnicians", selectedTechs);
};

const confirmAndClose = () => {
    emit("update:modelValue", false);
};
</script>
