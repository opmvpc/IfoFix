<template>
    <Form @submit="onSubmit">
        <Dialog>
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
                <div class="grid grid-cols-1 gap-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <FormField
                                v-slot="{ componentField }"
                                name="firstName"
                            >
                                <FormItem>
                                    <FormLabel>Prénom</FormLabel>
                                    <FormControl>
                                        <Input
                                            type="text"
                                            placeholder="Prénom"
                                            v-bind="componentField"
                                        />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>
                        <div>
                            <FormField
                                v-slot="{ componentField }"
                                name="lastName"
                            >
                                <FormItem>
                                    <FormLabel>Nom</FormLabel>
                                    <FormControl>
                                        <Input
                                            type="text"
                                            placeholder="Nom"
                                            v-bind="componentField"
                                        />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>
                    </div>
                    <div>
                        <FormField v-slot="{ componentField }" name="email">
                            <FormItem>
                                <FormLabel>Email</FormLabel>
                                <FormControl>
                                    <Input
                                        type="email"
                                        placeholder="Email"
                                        v-bind="componentField"
                                    />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="grow">
                            <FormField
                                v-slot="{ componentField }"
                                name="password"
                            >
                                <FormItem>
                                    <FormLabel>Mot de passe</FormLabel>
                                    <FormControl>
                                        <Input
                                            type="password"
                                            placeholder="Mot de passe"
                                            v-bind="componentField"
                                        />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>
                        <div class="grow">
                            <FormField
                                v-slot="{ componentField }"
                                name="password_confirmation"
                            >
                                <FormItem>
                                    <FormLabel>Confirmation</FormLabel>
                                    <FormControl>
                                        <Input
                                            type="password"
                                            placeholder="Confirmation"
                                            v-bind="componentField"
                                        />
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            </FormField>
                        </div>
                    </div>
                    <div>
                        <FormField v-slot="{ componentField }" name="role">
                            <FormItem>
                                <FormLabel>Rôle</FormLabel>
                                <FormControl>
                                    <Select v-bind="componentField">
                                        <SelectTrigger>
                                            <SelectValue />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="admin">
                                                Administrateur
                                            </SelectItem>
                                            <SelectItem value="user"
                                                >Utilisateur</SelectItem
                                            >
                                        </SelectContent>
                                    </Select>
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                    </div>
                    <div>
                        <FormField v-slot="{ componentField }" name="status">
                            <FormItem>
                                <FormLabel>Statut</FormLabel>
                                <FormControl>
                                    <Select v-bind="componentField">
                                        <SelectTrigger>
                                            <SelectValue />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="active">
                                                Actif
                                            </SelectItem>
                                            <SelectItem value="inactive">
                                                Inactif
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                    </div>
                </div>
                <Button
                    type="submit"
                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Créer
                </Button>
            </DialogContent>
        </Dialog>
    </Form>
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
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter,
} from "@/Components/ui/card";
import {
    Form,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
    FormControl,
} from "@/Components/ui/form";
// import { Label } from "@/Components/ui/label";
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
import { ref } from "vue";

const form = useForm({
    firstName: "",
    lastName: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: "",
});

const onSubmit = (values) => {
    form.post(route("users.store"), {
        onSuccess: () => form.reset(),
    });
};
</script>
