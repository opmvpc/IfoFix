<template>
    <div v-if="item" class="duration-300 animate-in slide-in-from-right">
        <form @submit.prevent="handleSubmit">
            <Card>
                <CardHeader>
                    <CardTitle class="flex justify-between">
                        <span>{{ getItemTypeName() }}</span>
                        <span>
                            <font-awesome-icon
                                icon="fa-solid fa-close"
                                class="text-gray-400 cursor-pointer hover:text-indigo-600"
                                @click.prevent="$emit('item-selected', null)"
                            />
                        </span>
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="grid grid-cols-1 gap-6">
                        <div class="space-y-2">
                            <Label>Nom</Label>
                            <Input v-model="form.name" />
                        </div>

                        <div v-if="itemType === 'device'" class="space-y-4">
                            <div class="space-y-2">
                                <Label>Type</Label>
                                <Select v-model="form.typeId">
                                    <SelectTrigger>
                                        <SelectValue
                                            placeholder="Sélectionner un type"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem
                                            v-for="type in types"
                                            :key="type.id"
                                            :value="type.id"
                                        >
                                            {{ type.name }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                            <div class="space-y-2">
                                <Label>Marque</Label>
                                <Select v-model="form.brandId">
                                    <SelectTrigger>
                                        <SelectValue
                                            placeholder="Sélectionner une marque"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem
                                            v-for="brand in brands"
                                            :key="brand.id"
                                            :value="brand.id"
                                        >
                                            {{ brand.name }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>
                    </div>
                </CardContent>
                <CardFooter>
                    <Button type="submit" class="w-full">Mettre à jour</Button>
                </CardFooter>
            </Card>
        </form>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import {
    Card,
    CardHeader,
    CardTitle,
    CardContent,
    CardFooter,
} from "@/Components/ui/card";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    item: Object,
    itemType: {
        type: String,
        required: true,
        validator: (value) => ["type", "brand", "device"].includes(value),
    },
    types: Array,
    brands: Array,
});

const emit = defineEmits(["item-selected"]);

const form = ref({
    name: "",
    typeId: null,
    brandId: null,
});

watch(
    () => props.item,
    (newItem) => {
        if (newItem) {
            form.value = {
                name: newItem.name,
                typeId: newItem.typeId,
                brandId: newItem.brandId,
            };
        }
    },
    { immediate: true }
);

const getItemTypeName = () => {
    const types = {
        type: "Type",
        brand: "Marque",
        device: "Modèle",
    };
    return types[props.itemType];
};

const handleSubmit = () => {
    const routes = {
        type: `/types/${props.item.id}`,
        brand: `/brands/${props.item.id}`,
        device: `/devices/${props.item.id}`,
    };

    router.put(routes[props.itemType], form.value, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            emit('item-selected', null); // Close the panel after successful update
        }
    });
};
</script>
