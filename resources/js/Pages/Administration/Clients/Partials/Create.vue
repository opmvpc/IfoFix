<template>
    <Dialog :open="isOpen" @update:open="handleOpen">
        <DialogTrigger as-child>
            <font-awesome-icon
                icon="text-xl text-gray-400 cursor-pointer hover:text-indigo-500"
            />
        </DialogTrigger>
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Créer un client</DialogTitle>
                <DialogDescription>
                    Formulaire de création d'un client.
                </DialogDescription>
            </DialogHeader>
            <form @submit.prevent="onSubmit">
                <div class="grid grid-cols-1 gap-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="space-y-2">
                                <Label>Prénom</Label>
                                <Input
                                    type="text"
                                    placeholder="Prénom"
                                    v-model="form.firstName"
                                />
                                <InputError :message="form.errors.firstName" />
                            </div>
                        </div>
                        <div>
                            <div class="space-y-2">
                                <Label>Nom</Label>
                                <Input
                                    type="text"
                                    placeholder="Nom"
                                    v-model="form.lastName"
                                />
                                <InputError :message="form.errors.lastName" />
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <Label>Email</Label>
                        <Input
                            type="email"
                            placeholder="Email"
                            v-model="form.email"
                        />
                        <InputError :message="form.errors.email" />
                    </div>
                    <div class="space-y-2">
                        <Label>Téléphone</Label>
                        <Input
                            type="phone"
                            placeholder="Telephone"
                            v-model="form.phone"
                        />
                        <InputError :message="form.errors.phone" />
                    </div>
                </div>
                <Button
                    type="submit"
                    class="inline-flex justify-center px-4 py-2 mt-6 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    :disabled="form.processing"
                >
                    Créer
                </Button>
            </form>
        </DialogContent>
    </Dialog>
</template>

<script setup>
import { Button } from "@/Components/ui/button";
import {
    Dialog,
    DialogTrigger,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
} from "@/Components/ui/dialog";
import { Label } from "@/Components/ui/label";
import { Input } from "@/Components/ui/input";
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import { ref } from "vue";

const form = useForm({
    firstName: "",
    lastName: "",
    email: "",
    phone: "",
});

const isOpen = ref(false);

const onSubmit = () => {
    form.post("/clients", {
        preserveScroll: true,
        onSuccess: () => {
            handleOpen(false);
        },
    });
};

const handleOpen = (value) => {
    isOpen.value = value;
    if (!value) {
        form.reset();
    }
};
</script>
