<template>
    <Dialog v-model:open="isNewClientModalOpen">
        <DialogContent class="sm:max-w-[500px]">
            <DialogHeader>
                <DialogTitle>Créer un nouveau client</DialogTitle>
            </DialogHeader>

            <form @submit.prevent="submitNewClient" class="space-y-4">
                <div>
                    <Label for="newClientFirstName">Prénom</Label>
                    <Input
                        id="newClientFirstName"
                        v-model="newClientForm.firstName"
                    />
                </div>
                <div>
                    <Label for="newClientLastName">Nom</Label>
                    <Input
                        id="newClientLastName"
                        v-model="newClientForm.lastName"
                    />
                </div>
                <div>
                    <Label for="newClientEmail">Email</Label>
                    <Input
                        id="newClientEmail"
                        v-model="newClientForm.email"
                        type="email"
                    />
                </div>
                <div>
                    <Label for="newClientPhone">Téléphone</Label>
                    <Input id="newClientPhone" v-model="newClientForm.phone" />
                </div>
                <DialogFooter>
                    <Button
                        type="button"
                        variant="secondary"
                        @click="closeNewClientModal"
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
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogFooter,
} from "@/Components/ui/dialog";
import { computed } from "vue";

const props = defineProps({
    modelValue: Boolean,
    newClientForm: Object,
    form: Object,
});

const emit = defineEmits(["update:modelValue"]);

const isNewClientModalOpen = computed({
    get: () => props.modelValue,
    set: (value) => emit("update:modelValue", value),
});

const closeNewClientModal = () => {
    isNewClientModalOpen.value = false;
    newClientForm.reset();
};

const submitNewClient = () => {
    newClientForm.post(route("clients.store"), {
        preserveScroll: true,
        onSuccess: (response) => {
            closeNewClientModal();
            form.clientId = response.props.client.id;
        },
    });
};
</script>
