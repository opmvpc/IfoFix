<template>
    <form @submit.prevent="submit">
        <Card>
            <CardHeader>
                <CardTitle>Créer un utilisateur</CardTitle>
                <CardDescription
                    >Formulaire de création d'un utilisateur</CardDescription
                >
            </CardHeader>
            <CardContent>
                <div class="grid grid-cols-1 gap-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <Label for="firstName">Prénom</Label>
                            <Input
                                id="firstName"
                                v-model="form.firstName"
                                type="text"
                                name="firstName"
                                autocomplete="given-name"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.firstName"
                            />
                        </div>
                        <div>
                            <Label for="lastName">Nom</Label>
                            <Input
                                id="lastName"
                                v-model="form.lastName"
                                type="text"
                                name="lastName"
                                autocomplete="given-name"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.lastName"
                            />
                        </div>
                    </div>
                    <div>
                        <Label for="email">Email</Label>
                        <Input
                            id="email"
                            v-model="form.email"
                            type="email"
                            name="email"
                            autocomplete="email"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="grow">
                            <Label for="password" class="text-nowrap"
                                >Mot de passe</Label
                            >
                            <Input
                                id="password"
                                v-model="form.password"
                                type="password"
                                name="password"
                                autocomplete="new-password"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />
                        </div>
                        <div class="grow">
                            <Label
                                for="password_confirmation"
                                class="text-nowrap"
                                >Confirmer le mot de passe</Label
                            >
                            <Input
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                name="password_confirmation"
                                autocomplete="new-password"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />
                        </div>
                        <InputError
                            class="col-span-2 mt-2"
                            :message="form.errors.password"
                        />
                    </div>
                    <div>
                        <Label for="role">Rôle</Label>
                        <!-- <select
                            id="role"
                            v-model="form.role"
                            name="role"
                            autocomplete="role"
                            class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        >
                            <option value="admin">Administrateur</option>
                            <option value="tecnician" selected>
                                Technicien
                            </option>
                        </select> -->
                        <Select name="role" v-model="form.role">
                            <SelectTrigger>
                                <SelectValue
                                    placeholder="Selectionner un rôle"
                                />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="technician">
                                    Technicien
                                </SelectItem>
                                <SelectItem value="admin">
                                    Administrateur
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <InputError class="mt-2" :message="form.errors.role" />
                    </div>
                </div>
            </CardContent>
            <CardFooter>
                <button
                    type="submit"
                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Créer
                </button>
            </CardFooter>
        </Card>
    </form>
</template>
<script setup>
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter,
} from "@/Components/ui/card";
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
    role: "",
});

const submit = () => {
    form.post(route("users.store"), {
        onSuccess: () => form.reset(),
    });
};
</script>
