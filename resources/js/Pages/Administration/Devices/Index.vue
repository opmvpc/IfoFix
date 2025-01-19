<template>
    <AppLayout>
        <div class="h-full p-4">
            <Card class="h-full">
                <CardHeader>
                    <div class="flex items-center gap-2">
                        <h1 class="text-2xl font-bold">Liste des Appareils</h1>
                    </div>
                </CardHeader>

                <CardContent class="flex flex-col gap-4">
                    <!-- Search Section -->
                    <div class="flex items-center space-x-2">
                        <div class="relative flex-1 max-w-52">
                            <Input
                                v-model="searchQuery"
                                placeholder="Rechercher un appareil..."
                                class="pl-10"
                            />
                            <font-awesome-icon
                                icon="fa-solid fa-search"
                                class="absolute text-gray-500 -translate-y-1/2 left-3 top-1/2"
                            />
                        </div>
                    </div>
                    <!-- Main Content -->
                    <div class="grid grid-cols-1 gap-4 grow lg:grid-cols-3">
                        <div>
                            <h3 class="mb-2 text-lg font-semibold">Types</h3>
                            <Types
                                :types="filteredTypes"
                                :selectedType="selectedType"
                                @type-selected="handleTypeSelect"
                            />
                        </div>

                        <div>
                            <h3 class="mb-2 text-lg font-semibold">Marques</h3>
                            <Brands
                                :brands="filteredBrands"
                                :selectedBrand="selectedBrand"
                                @brand-selected="handleBrandSelect"
                            />
                        </div>

                        <div>
                            <h3 class="mb-2 text-lg font-semibold">Modèles</h3>
                            <Models
                                :devices="filteredDevices"
                                :selectedDevice="selectedDevice"
                                @device-selected="handleDeviceSelect"
                            />
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>

<script setup>
import { Input } from "@/Components/ui/input";
import AppLayout from "@/Layouts/AppLayout.vue";
import Brands from "./Partials/Brands.vue";
import Models from "./Partials/Models.vue";
import Types from "./Partials/Types.vue";
import { ref, computed } from "vue";
import { Card, CardHeader } from "@/Components/ui/card";
import CardContent from "@/Components/ui/card/CardContent.vue";

const props = defineProps({
    types: {
        type: Array,
        required: true,
    },
    brands: {
        type: Array,
        required: true,
    },
    devices: {
        type: Array,
        required: true,
    },
});

// Store the original data
const originalTypes = ref(props.types);
const originalBrands = ref(props.brands);
const originalDevices = ref(props.devices);

// Track selected items
const selectedType = ref(null);
const selectedBrand = ref(null);
const selectedDevice = ref(null);

// Add search query ref
const searchQuery = ref("");

// Computed properties for filtered data
const filteredDevices = computed(() => {
    return originalDevices.value.filter((device) => {
        // Type and brand filters
        const matchesType =
            !selectedType.value || device.typeId === selectedType.value.id;
        const matchesBrand =
            !selectedBrand.value || device.brandId === selectedBrand.value.id;

        // Search filter
        const matchesSearch =
            searchQuery.value === "" ||
            device.name.toLowerCase().includes(searchQuery.value.toLowerCase());

        return matchesType && matchesBrand && matchesSearch;
    });
});

const filteredBrands = computed(() => {
    let filtered = originalBrands.value;

    if (searchQuery.value) {
        const matchingDevices = originalDevices.value.filter((device) =>
            device.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
        const brandIds = [
            ...new Set(matchingDevices.map((device) => device.brandId)),
        ];
        filtered = filtered.filter((brand) => brandIds.includes(brand.id));
    }

    if (selectedType.value) {
        // Get all devices of selected type
        const devicesOfType = originalDevices.value.filter(
            (device) => device.typeId === selectedType.value.id
        );
        // Get unique brand IDs from these devices
        const brandIds = [
            ...new Set(devicesOfType.map((device) => device.brandId)),
        ];
        // Filter brands
        filtered = filtered.filter((brand) => brandIds.includes(brand.id));
    }

    return filtered;
});

const filteredTypes = computed(() => {
    let filtered = originalTypes.value;

    if (searchQuery.value) {
        const matchingDevices = originalDevices.value.filter((device) =>
            device.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
        const typeIds = [
            ...new Set(matchingDevices.map((device) => device.typeId)),
        ];
        filtered = filtered.filter((type) => typeIds.includes(type.id));
    }

    if (selectedBrand.value) {
        // Get all devices of selected brand
        const devicesOfBrand = originalDevices.value.filter(
            (device) => device.brandId === selectedBrand.value.id
        );
        // Get unique type IDs from these devices
        const typeIds = [
            ...new Set(devicesOfBrand.map((device) => device.typeId)),
        ];
        // Filter types
        filtered = filtered.filter((type) => typeIds.includes(type.id));
    }

    return filtered;
});

// Handler functions
const handleTypeSelect = (type) => {
    if (selectedType.value?.id === type?.id) {
        selectedType.value = null;
    } else {
        selectedType.value = type;
    }
};

const handleBrandSelect = (brand) => {
    if (selectedBrand.value?.id === brand?.id) {
        selectedBrand.value = null;
    } else {
        selectedBrand.value = brand;
    }
};

const handleDeviceSelect = (device) => {
    selectedDevice.value = device.id;
};
</script>
