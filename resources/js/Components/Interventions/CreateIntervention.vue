<template>
    <div class="p-4 border rounded-lg bg-white shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Nouvelle Intervention</h2>
            <Button variant="ghost" @click="$emit('close')">
                <XIcon class="h-4 w-4" />
            </Button>
        </div>

        <!-- Modal déplacée en dehors du formulaire -->
        <Dialog :open="isModalOpen" @update:open="isModalOpen = $event">
            <DialogContent class="sm:max-w-[500px]">
                <DialogHeader>
                    <DialogTitle>Sélectionner des techniciens</DialogTitle>
                    <DialogDescription>
                        Recherchez et sélectionnez un ou plusieurs techniciens
                    </DialogDescription>
                </DialogHeader>

                <div class="space-y-4">
                    <Input
                        type="search"
                        placeholder="Rechercher un technicien..."
                        v-model="searchQuery"
                    />

                    <div class="max-h-[300px] overflow-y-auto space-y-2">
                        <div
                            v-for="tech in filteredTechnicians"
                            :key="tech.id"
                            class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded"
                        >
                            <Checkbox
                                :id="'tech-' + tech.id"
                                :checked="form.technicianId.includes(tech.id)"
                                @update:checked="toggleTechnician(tech.id)"
                            />
                            <Label :for="'tech-' + tech.id" class="flex-grow">
                                {{ tech.firstName }} {{ tech.lastName }}
                            </Label>
                        </div>
                    </div>
                </div>

                <DialogFooter>
                    <Button
                        type="button"
                        variant="secondary"
                        @click="closeModal"
                    >
                        Confirmer
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>

        <form @submit.prevent="submit" class="space-y-4">
            <Input type="hidden" v-model="form.ticketId" />

            <div>
                <Label>Techniciens</Label>
                <Button
                    type="button"
                    variant="outline"
                    @click="openModal"
                    class="w-full justify-between"
                >
                    Sélectionner des techniciens
                    <font-awesome-icon icon="fa-solid fa-users" />
                </Button>

                <!-- Liste des techniciens sélectionnés -->
                <div v-if="selectedTechnicians.length" class="mt-2 space-y-1">
                    <div
                        v-for="tech in selectedTechnicians"
                        :key="tech.id"
                        class="flex items-center gap-2 bg-gray-100 p-2 rounded"
                    >
                        <span>{{ tech.firstName }} {{ tech.lastName }}</span>
                        <Button
                            type="button"
                            variant="ghost"
                            size="sm"
                            @click="toggleTechnician(tech.id)"
                            class="h-6 w-6 p-0"
                        >
                            <font-awesome-icon icon="fa-solid fa-times" />
                        </Button>
                    </div>
                </div>
            </div>

            <div>
                <Label for="description">Description</Label>
                <Input id="description" v-model="form.description" />
            </div>
            <div>
                <Label for="duration">Durée (minutes)</Label>
                <Input type="number" id="duration" v-model="form.duration" />
            </div>
            <div>
                <Label for="date">Date</Label>
                <Input type="date" id="date" v-model="form.date" />
            </div>
            <div v-if="form.errors" class="space-y-2">
                <p
                    v-for="(error, key) in form.errors"
                    :key="key"
                    class="text-sm text-red-500"
                >
                    {{ error }}
                </p>
            </div>
            <Button type="submit" class="w-full" :disabled="form.processing">
                {{ form.processing ? "Création..." : "Créer l'intervention" }}
            </Button>
        </form>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { XIcon } from "lucide-vue-next";
import { useForm } from "@inertiajs/vue3";
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
    DialogFooter,
} from "@/Components/ui/dialog";
import { Checkbox } from "@/Components/ui/checkbox";

const props = defineProps({
    ticketId: {
        type: Number,
        required: true,
    },
    technicians: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["close"]);
const isModalOpen = ref(false);
const searchQuery = ref("");

const form = useForm({
    description: "",
    duration: null,
    date: null,
    ticketId: props.ticketId,
    technicianId: [], // C'est le seul tableau qu'on va utiliser
});

// On utilise directement form.technicianId pour le computed
const selectedTechnicians = computed(() => {
    return props.technicians.filter((tech) =>
        form.technicianId.includes(tech.id)
    );
});

const filteredTechnicians = computed(() => {
    return props.technicians.filter(
        (tech) =>
            tech.firstName
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase()) ||
            tech.lastName
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase())
    );
});

// Simplifié pour manipuler directement form.technicianId
const toggleTechnician = (techId) => {
    const currentIds = [...form.technicianId];
    const index = currentIds.indexOf(techId);

    if (index === -1) {
        currentIds.push(techId);
    } else {
        currentIds.splice(index, 1);
    }

    form.technicianId = currentIds;
    console.log("Techniciens sélectionnés:", form.technicianId);
};

// Le reste des méthodes reste identique
const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const submit = () => {
    form.post(route("interventions.store"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            emit("close");
        },
    });
};
</script>
