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
                <Label for="technician">Technicien</Label>
                <Select id="technician" v-model="form.technician_id">
                    <SelectTrigger>
                        <SelectValue>
                            {{
                                technicians.find(
                                    (tech) => tech.id === form.technician_id
                                )
                                    ? `${
                                          technicians.find(
                                              (tech) =>
                                                  tech.id === form.technician_id
                                          ).firstName
                                      } ${
                                          technicians.find(
                                              (tech) =>
                                                  tech.id === form.technician_id
                                          ).lastName
                                      }`
                                    : "Sélectionner un technicien"
                            }}
                        </SelectValue>
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem
                                v-for="tech in technicians"
                                :key="tech.id"
                                :value="tech.id"
                            >
                                {{ tech.firstName }} {{ tech.lastName }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
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
import Select from "../ui/select/Select.vue";
import SelectTrigger from "../ui/select/SelectTrigger.vue";
import SelectValue from "../ui/select/SelectValue.vue";
import SelectContent from "../ui/select/SelectContent.vue";
import SelectGroup from "../ui/select/SelectGroup.vue";
import SelectItem from "../ui/select/SelectItem.vue";

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

const form = useForm({
    description: "",
    duration: null,
    date: null,
    ticket_id: props.ticketId,
    technician_id: null,
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
