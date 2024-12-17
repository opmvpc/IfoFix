<template>
    <Dialog
        :open="modelValue"
        @update:open="$emit('update:modelValue', $event)"
    >
        <DialogContent class="sm:max-w-[500px] min-h-[500px]">
            <DialogHeader>
                <DialogTitle>Sélectionner un client</DialogTitle>
                <DialogDescription>
                    Recherchez et sélectionnez un client
                </DialogDescription>
            </DialogHeader>

            <div class="space-y-4">
                <Input
                    type="search"
                    placeholder="Rechercher un client..."
                    v-model="clientSearch"
                />

                <div class="h-[300px] overflow-y-auto space-y-2">
                    <RadioGroup v-model="props.form.clientId">
                        <div
                            v-for="client in filteredClients"
                            :key="client.id"
                            class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded"
                        >
                            <RadioGroupItem
                                :value="client.id"
                                :id="'client-' + client.id"
                            />
                            <Label
                                :for="'client-' + client.id"
                                class="flex-grow cursor-pointer"
                            >
                                {{ client.firstName }} {{ client.lastName }}
                            </Label>
                        </div>
                    </RadioGroup>
                </div>
            </div>

            <DialogFooter>
                <Button
                    type="button"
                    variant="secondary"
                    @click="closeClientModal"
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
import { Label } from "@/components/ui/label";
import { Button } from "@/Components/ui/button";
import { computed, ref } from "vue";

const props = defineProps({
    modelValue: Boolean, // Renommé de isClientModalOpen à modelValue
    form: Object,
    clients: Array,
});

const clientSearch = ref("");

const filteredClients = computed(() => {
    if (!clientSearch.value) return props.clients;
    return props.clients.filter((client) =>
        `${client.firstName} ${client.lastName}`
            .toLowerCase()
            .includes(clientSearch.value.toLowerCase())
    );
});

const emit = defineEmits(["update:modelValue"]);

const closeClientModal = () => {
    emit("update:modelValue", false);
};
</script>
