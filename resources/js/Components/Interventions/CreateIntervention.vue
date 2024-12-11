<template>
    <div class="p-4 border rounded-lg bg-white shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Nouvelle Intervention</h2>
            <Button variant="ghost" @click="$emit('close')">
                <XIcon class="h-4 w-4" />
            </Button>
        </div>
        <form @submit.prevent="submit" class="space-y-4">
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
            <Button type="submit" class="w-full">Créer l'intervention</Button>
        </form>
    </div>
</template>

<script setup>
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { XIcon } from "lucide-vue-next";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    ticketId: {
        type: Number,
        required: true,
    },
});

const emit = defineEmits(["close"]);

const form = useForm({
    description: "",
    duration: null,
    date: null,
    ticket_id: props.ticketId,
});

const submit = () => {
    form.post(route("interventions.store"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            emit("close");
        },
        onError: (errors) => {
            console.error("Erreur lors de la soumission:", errors);
        },
    });
};
</script>
