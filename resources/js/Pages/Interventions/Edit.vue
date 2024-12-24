<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter,
} from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Textarea } from "@/Components/ui/textarea";
import { Label } from "@/Components/ui/label";
import { Switch } from "@/Components/ui/switch";
import { watch, ref } from "vue";
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/Components/ui/dialog";
import { Checkbox } from "@/Components/ui/checkbox";
import BackButton from "@/Components/BackButton.vue";
import { formatDate } from "@/lib/utils";

const props = defineProps({
    intervention: {
        type: Object,
        required: true,
    },
    allUsers: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    description: props.intervention.description,
    duration: props.intervention.duration,
    date: props.intervention.date,
    isFinished: props.intervention.isFinished,
    users: props.intervention.users,
});

// Assure que isFinished est toujours un boolean
watch(
    () => form.isFinished,
    (newValue) => {
        // Convertit en boolean si ce n'est pas déjà le cas
        form.isFinished = Boolean(newValue);
    }
);

// Pour s'assurer que la valeur initiale est aussi un boolean
form.isFinished = Boolean(form.isFinished);

const submit = () => {
    form.patch(route("interventions.update", props.intervention.id), {
        onSuccess: () => {
            // Optionnel : Afficher un message de succès
            console.log("Intervention mise à jour avec succès");
        },
    });
};

// Modifier la fonction pour gérer le changement d'état du switch
const toggleFinished = () => {
    form.isFinished = !form.isFinished;
};

const selectedUsers = ref(new Set(form.users.map((user) => user.id)));

const toggleUser = (userId) => {
    if (selectedUsers.value.has(userId)) {
        selectedUsers.value.delete(userId);
    } else {
        selectedUsers.value.add(userId);
    }

    // Mettre à jour form.users avec les utilisateurs sélectionnés
    form.users = props.allUsers.filter((user) =>
        selectedUsers.value.has(user.id)
    );
};
</script>

<template>
    <AppLayout title="Modifier l'intervention">
        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <form @submit.prevent="submit">
                    <Card>
                        <CardHeader>
                            <div class="flex items-center justify-between">
                                <BackButton />
                                <CardTitle>Modifier l'intervention</CardTitle>
                            </div>
                            <CardDescription
                                class="text-sm text-gray-500 italic text-right"
                            >
                                Créé le
                                {{ formatDate(intervention.created_at) }}
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="grid gap-6">
                                <div class="grid gap-2">
                                    <div
                                        class="flex items-center justify-start gap-3"
                                    >
                                        <Label for="description"
                                            >Description</Label
                                        >
                                        <span
                                            v-if="form.errors.description"
                                            class="text-xs text-red-500"
                                        >
                                            {{ form.errors.description }}
                                        </span>
                                    </div>
                                    <Textarea
                                        id="description"
                                        v-model="form.description"
                                        placeholder="Description de l'intervention"
                                        rows="5"
                                        class="resize-none"
                                    />
                                </div>

                                <div class="grid gap-2">
                                    <div
                                        class="flex items-center justify-start gap-3"
                                    >
                                        <Label for="duration"
                                            >Durée de l'intervention</Label
                                        >
                                        <span
                                            v-if="form.errors.duration"
                                            class="text-xs text-red-500"
                                        >
                                            {{ form.errors.duration }}
                                        </span>
                                    </div>
                                    <Input
                                        id="duration"
                                        type="time"
                                        v-model="form.duration"
                                        placeholder="Durée en minutes"
                                    />
                                </div>

                                <div class="grid gap-2">
                                    <div
                                        class="flex items-center justify-start gap-3"
                                    >
                                        <Label for="date">Date</Label>
                                        <span
                                            v-if="form.errors.date"
                                            class="text-xs text-red-500"
                                        >
                                            {{ form.errors.date }}
                                        </span>
                                    </div>
                                    <Input
                                        id="date"
                                        type="date"
                                        v-model="form.date"
                                    />
                                </div>

                                <div class="flex items-center space-x-2">
                                    <Switch
                                        id="isFinished"
                                        :checked="form.isFinished"
                                        @update:checked="toggleFinished"
                                    />
                                    <Label
                                        for="isFinished"
                                        class="cursor-pointer"
                                        >Intervention résolue</Label
                                    >
                                </div>

                                <div class="grid gap-2">
                                    <div class="flex items-center">
                                        <Label>Intervenants</Label>
                                        <Dialog>
                                            <DialogTrigger asChild>
                                                <Button
                                                    variant="ghost"
                                                    size="icon"
                                                    class="h-8 w-8"
                                                >
                                                    <font-awesome-icon
                                                        icon="fa-solid fa-plus"
                                                    />
                                                </Button>
                                            </DialogTrigger>
                                            <DialogContent>
                                                <DialogHeader>
                                                    <DialogTitle
                                                        >Sélectionner des
                                                        intervenants</DialogTitle
                                                    >
                                                </DialogHeader>
                                                <div class="grid gap-4 py-4">
                                                    <div
                                                        v-for="user in allUsers"
                                                        :key="user.id"
                                                        class="flex items-center space-x-2"
                                                    >
                                                        <Checkbox
                                                            :id="
                                                                'user-' +
                                                                user.id
                                                            "
                                                            :checked="
                                                                selectedUsers.has(
                                                                    user.id
                                                                )
                                                            "
                                                            @change="
                                                                toggleUser(
                                                                    user.id
                                                                )
                                                            "
                                                        />
                                                        <Label
                                                            :for="
                                                                'user-' +
                                                                user.id
                                                            "
                                                            >{{
                                                                user.firstName
                                                            }}
                                                            {{
                                                                user.lastName
                                                            }}</Label
                                                        >
                                                    </div>
                                                </div>
                                            </DialogContent>
                                        </Dialog>
                                    </div>
                                    <div class="mt-2 space-y-2">
                                        <div
                                            v-for="user in form.users"
                                            :key="user.id"
                                            class="flex items-center space-x-2"
                                        >
                                            <font-awesome-icon
                                                icon="fa-solid fa-user"
                                                class="text-gray-400"
                                            />
                                            <span>{{ user.firstName }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                        <CardFooter class="flex justify-end space-x-2">
                            <Button
                                type="button"
                                variant="outline"
                                :href="route('interventions.index')"
                            >
                                Annuler
                            </Button>
                            <Button type="submit" :disabled="form.processing">
                                Clôturer
                            </Button>
                        </CardFooter>
                    </Card>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
