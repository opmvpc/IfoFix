<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
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
import { Badge } from "@/Components/ui/badge";

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
    duration: props.intervention.duration || "00:00", // Set default value
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

const submitUpdate = () => {
    form.patch(route("interventions.update", props.intervention.id), {
        onSuccess: () => {
            // Optionnel : Afficher un message de succès
            console.log("Intervention mise à jour avec succès");
        },
    });
};
const submitCloture = () => {
    form.patch(route("interventions.cloturer", props.intervention.id), {
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

// Ajout des refs pour la gestion des images
const imagePreviewUrls = ref([]);
const selectedImages = ref([]);

const handleImageUpload = (event) => {
    const files = Array.from(event.target.files);
    files.forEach((file) => {
        if (file.size > 2 * 1024 * 1024) {
            alert("Chaque image ne doit pas dépasser 2MB");
            return;
        }
        selectedImages.value.push(file);
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreviewUrls.value.push(e.target.result);
        };
        reader.readAsDataURL(file);
    });
    form.images = selectedImages.value;
};

const removeImage = (index) => {
    imagePreviewUrls.value.splice(index, 1);
    selectedImages.value.splice(index, 1);
    form.images = selectedImages.value;
};
</script>

<template>
    <AppLayout title="Modifier l'intervention">
        <div class="p-6 space-y-6">
            <BackButton />
            <div>
                <form @submit.prevent="submit">
                    <Card>
                        <CardHeader>
                            <div class="flex items-center justify-between">
                                <CardTitle>Modifier l'intervention</CardTitle>
                            </div>
                            <CardDescription
                                class="text-sm italic text-gray-500"
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
                                        placeholder="00:00"
                                        :value="form.duration || '00:00'"
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
                                                    class="w-8 h-8"
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
                                    <div
                                        v-if="form.users.length > 0"
                                        class="flex flex-wrap gap-2"
                                    >
                                        <Badge
                                            v-for="user in form.users"
                                            :key="user.id"
                                        >
                                            <font-awesome-icon
                                                icon="fa-solid fa-user"
                                                class="w-3 h-3 mr-2"
                                            />
                                            {{ user.firstName }}
                                            {{ user.lastName }}
                                        </Badge>
                                    </div>
                                    <div v-else class="italic text-gray-500">
                                        Aucun intervenant sélectionné
                                    </div>
                                </div>

                                <div>
                                    <Label for="images">Images</Label>
                                    <label
                                        class="flex flex-col w-full h-32 border-2 border-dashed rounded-lg cursor-pointer hover:bg-gray-50"
                                    >
                                        <div
                                            class="flex flex-col items-center justify-center pt-5 pb-6"
                                        >
                                            <font-awesome-icon
                                                icon="fa-solid fa-cloud-arrow-up"
                                                class="w-8 h-8 mb-3 text-gray-400"
                                            />
                                            <p class="text-sm text-gray-500">
                                                Cliquez ou glissez des images
                                                ici
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                (JPG, PNG, GIF jusqu'à 2MB)
                                            </p>
                                        </div>
                                        <input
                                            type="file"
                                            class="hidden"
                                            multiple
                                            accept="image/*"
                                            @change="handleImageUpload"
                                        />
                                    </label>
                                    <!-- Prévisualisation des images -->
                                    <div
                                        v-if="imagePreviewUrls.length"
                                        class="grid grid-cols-4 gap-4 mt-4"
                                    >
                                        <div
                                            v-for="(
                                                url, index
                                            ) in imagePreviewUrls"
                                            :key="index"
                                            class="relative"
                                        >
                                            <img
                                                :src="url"
                                                class="object-cover w-full h-24 rounded-lg"
                                            />
                                            <button
                                                type="button"
                                                @click="removeImage(index)"
                                                class="absolute flex items-center justify-center w-5 h-5 text-xs text-white bg-red-500 rounded-full -top-2 -right-2 hover:bg-red-600"
                                            >
                                                <font-awesome-icon
                                                    icon="fa-solid fa-times"
                                                    class="w-3 h-3"
                                                />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                        <CardFooter class="flex justify-between space-x-2">
                            <Button
                                @click.prevent="submitCloture"
                                :href="route('interventions.index')"
                                class="self-start"
                            >
                                Clôturer l'intervention
                            </Button>
                            <div class="flex gap-2">
                                <Link
                                    :href="
                                        route(
                                            'tickets.show',
                                            intervention.ticketId
                                        )
                                    "
                                >
                                    <Button
                                        type="button"
                                        variant="outline"
                                        :href="route('interventions.index')"
                                    >
                                        Annuler
                                    </Button>
                                </Link>
                                <Button
                                    variant="outline"
                                    @click.prevent="submitUpdate"
                                    :disabled="form.processing"
                                >
                                    Modifier
                                </Button>
                            </div>
                        </CardFooter>
                    </Card>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
