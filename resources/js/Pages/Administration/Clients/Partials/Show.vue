<template>
    <div class="duration-300 animate-in slide-in-from-right">
        <form v-if="isClientSelected && client" @submit.prevent="submit">
            <Card>
                <CardHeader>
                    <CardTitle class="flex justify-between">
                        <span> Profil </span>
                        <span>
                            <font-awesome-icon
                                icon="fa-solid fa-close"
                                class="text-gray-400 cursor-pointer hover:text-gray-600"
                                @click.prevent="emit('client-selected', null)"
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
                        <div class="space-y-2">
                            <Label>Téléphone</Label>
                            <Input
                                type="phone"
                                placeholder="Téléphone"
                                v-model="form.phone"
                            />
                            <p
                                v-if="form.errors.email"
                                class="text-sm text-red-500"
                            >
                                {{ form.errors.email }}
                            </p>
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
import { ref, computed, watch, inject } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Button } from "@/Components/ui/button";
import { Label } from "@/components/ui/label";
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

const emit = defineEmits(["client-selected"]);

const props = defineProps({
    client: {
        type: Object,
        default: () => null,
    },
});

// Reactive form using Inertia's useForm
const form = useForm({
    id: "",
    firstName: "",
    lastName: "",
    email: "",
    phone: "",
    isActive: "",
});

// Watch for changes in the user prop and update form
watch(
    () => props.client,
    (newUser) => {
        if (newUser) {
            form.id = newUser.id;
            form.firstName = newUser.firstName;
            form.lastName = newUser.lastName;
            form.email = newUser.email;
            form.phone = newUser.phone;
            form.isActive = String(newUser.isActive);
        }
    },
    { immediate: true }
);

// Computed property to check if a client is selected
const isClientSelected = computed(() => props.client !== null);

const submit = () => {
    if (props.client?.id) {
        form.put(route("clients.edit"), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                // toast.success("Utilisateur mis à jour avec succès");
            },
        });
    }
};
</script>
