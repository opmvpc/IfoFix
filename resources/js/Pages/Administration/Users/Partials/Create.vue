<template>
    <Dialog @update:open="handleOpen">
        <DialogTrigger as-child>
            <Button variant="link">
                <font-awesome-icon icon="fa-solid fa-plus" />
            </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Créer un utilisateur</DialogTitle>
                <DialogDescription>
                    Formulaire de création d'un utilisateur.
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
                        <Label>Rôle</Label>
                        <Select v-model="form.role">
                            <SelectTrigger>
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="admin">
                                    Administrateur
                                </SelectItem>
                                <SelectItem value="technician">
                                    Technicien
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.role" />
                    </div>
                    <div class="space-y-2">
                        <Label>Statut</Label>
                        <Select v-model="form.isActive">
                            <SelectTrigger>
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="1"> Actif </SelectItem>
                                <SelectItem value="0"> Inactif </SelectItem>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.isActive" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2 grow">
                            <Label>Mot de passe</Label>
                            <Input
                                type="password"
                                placeholder="Mot de passe"
                                v-model="form.password"
                            />
                        </div>
                        <div class="space-y-2 grow">
                            <Label>Confirmation</Label>
                            <Input
                                type="password"
                                placeholder="Confirmation"
                                v-model="form.password_confirmation"
                            />
                        </div>
                        <InputError
                            class="col-span-2"
                            :message="form.errors.password"
                        />
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
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";

const form = useForm({
    firstName: "",
    lastName: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: "technician",
    isActive: "1",
});

const onSubmit = () => {
    form.post(route("users.store"), {
        onSuccess: () => form.reset(),
    });
};

const handleOpen = (value) => {
    if (!value) {
        form.reset();
    }
};
</script>
