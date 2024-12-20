<template>
    <div class="duration-300 animate-in slide-in-from-right">
        <form v-if="user" @submit.prevent="submit" class="">
            <Card class="h-full">
                <CardHeader>
                    <CardTitle class="flex justify-between">
                        <span> Profil </span>
                        <span>
                            <font-awesome-icon
                                icon="fa-solid fa-close"
                                class="text-gray-400 cursor-pointer hover:text-gray-600"
                                @click.prevent="emit('user-selected', null)"
                            />
                        </span>
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="grid grid-cols-1 gap-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <Input type="hidden" v-model="form.id" />
                                <div class="space-y-2">
                                    <Label>Prénom</Label>
                                    <Input
                                        type="text"
                                        placeholder="Prénom"
                                        v-model="form.firstName"
                                        class="capitalize"
                                    />
                                    <p
                                        v-if="form.errors.firstName"
                                        class="text-sm text-red-500"
                                    >
                                        {{ form.errors.firstName }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <div class="space-y-2">
                                    <Label>Nom</Label>
                                    <Input
                                        type="text"
                                        placeholder="Nom"
                                        v-model="form.lastName"
                                        class="capitalize"
                                    />
                                    <p
                                        v-if="form.errors.lastName"
                                        class="text-sm text-red-500"
                                    >
                                        {{ form.errors.lastName }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="space-y-2">
                                <Label>Email</Label>
                                <Input
                                    type="email"
                                    placeholder="Email"
                                    v-model="form.email"
                                />
                                <p
                                    v-if="form.errors.email"
                                    class="text-sm text-red-500"
                                >
                                    {{ form.errors.email }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <div class="space-y-2">
                                <Label>Rôle</Label>
                                <Select v-model="form.role">
                                    <SelectTrigger>
                                        <SelectValue
                                            placeholder="Selectionner un rôle"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="technician"
                                            >Technicien</SelectItem
                                        >
                                        <SelectItem value="admin"
                                            >Administrateur</SelectItem
                                        >
                                    </SelectContent>
                                </Select>
                                <p
                                    v-if="form.errors.role"
                                    class="text-sm text-red-500"
                                >
                                    {{ form.errors.role }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <div class="space-y-2">
                                <Label>Status</Label>
                                <Select v-model="form.isActive">
                                    <SelectTrigger>
                                        <SelectValue
                                            placeholder="Selectionner un statut"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem :value="'1'"
                                            >Actif</SelectItem
                                        >
                                        <SelectItem :value="'0'"
                                            >Inactif</SelectItem
                                        >
                                    </SelectContent>
                                </Select>
                                <p
                                    v-if="form.errors.isActive"
                                    class="text-sm text-red-500"
                                >
                                    {{ form.errors.isActive }}
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="space-y-2">
                                    <Label>Mot de passe</Label>
                                    <Input
                                        type="password"
                                        placeholder="Mot de passe"
                                        v-model="form.password"
                                    />
                                    <p
                                        v-if="form.errors.password"
                                        class="text-sm text-red-500"
                                    >
                                        {{ form.errors.password }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <div class="space-y-2">
                                    <Label>Confirmer le mot de passe</Label>
                                    <Input
                                        type="password"
                                        placeholder="Confirmation"
                                        v-model="form.passwordConfirmation"
                                    />
                                    <p
                                        v-if="form.errors.passwordConfirmation"
                                        class="text-sm text-red-500"
                                    >
                                        {{ form.errors.passwordConfirmation }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </CardContent>
                <CardFooter>
                    <Button type="submit" :disabled="form.processing"
                        >Mettre à jour</Button
                    >
                </CardFooter>
            </Card>
        </form>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Button } from "@/Components/ui/button";
import { Label } from "@/Components/ui/label";
import {
    Card,
    CardHeader,
    CardTitle,
    CardContent,
    CardFooter,
} from "@/Components/ui/card";
import { Input } from "@/Components/ui/input";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";

const props = defineProps({
    user: {
        type: Object,
        default: () => null,
    },
});

const emit = defineEmits(["user-selected"]);

const form = useForm({
    id: "",
    firstName: "",
    lastName: "",
    email: "",
    role: "",
    isActive: "",
    password: "",
    passwordConfirmation: "",
});

const user = ref(props.user);

watch(
    () => props.user,
    (newUser) => {
        if (newUser) {
            user.value = newUser;
            form.id = newUser.id;
            form.firstName = newUser.firstName;
            form.lastName = newUser.lastName;
            form.email = newUser.email;
            form.role = newUser.role;
            form.isActive = String(newUser.isActive);
        }
    },
    { immediate: true }
);

const submit = () => {
    if (user) {
        form.put(route("users.edit"), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                // toast.success("Utilisateur mis à jour avec succès");
            },
        });
    }
};
</script>
