<template>
    <AppLayout>
        <div class="h-full p-4">
            <h1>Devices</h1>
            <div class="grid grid-cols-1 gap-4 grow lg:grid-cols-3">
                <Types
                    :types="filteredTypes"
                    :selectedType="selectedType"
                    @type-selected="handleTypeSelect"
                />
                <Brands
                    :brands="filteredBrands"
                    @brand-selected="handleBrandSelect"
                />
                <Models
                    :devices="filteredDevices"
                    @device-selected="handleDeviceSelect"
                />
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Brands from "./Partials/Brands.vue";
import Models from "./Partials/Models.vue";
import Types from "./Partials/Types.vue";
import { ref, computed } from "vue";

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

// Computed properties for filtered data
const filteredTypes = computed(() => {
    if (selectedBrand.value) {
        // If a brand is selected, show only types that have devices of that brand
        const devicesByBrand = originalDevices.value.filter(
            (device) => device.brandId === selectedBrand.value
        );
        console.log(devicesByBrand);
        const typeIds = new Set(devicesByBrand.map((device) => device.typeId));
        console.log(typeIds);
        return originalTypes.value.filter((type) => typeIds.has(type.id));
    }
    return originalTypes.value;
});

const filteredBrands = computed(() => {
    if (selectedType.value) {
        // If a type is selected, show only brands that have devices of that type
        const devicesByType = originalDevices.value.filter(
            (device) => device.typeId === selectedType.value
        );
        const brandIds = new Set(devicesByType.map((device) => device.brandId));
        return originalBrands.value.filter((brand) => brandIds.has(brand.id));
    }
    return originalBrands.value;
});

const filteredDevices = computed(() => {
    return originalDevices.value.filter((device) => {
        const matchesType =
            !selectedType.value || device.typeId === selectedType.value;
        const matchesBrand =
            !selectedBrand.value || device.brandId === selectedBrand.value;
        return matchesType && matchesBrand;
    });
});

// Handler functions
const handleTypeSelect = (type) => {
    selectedType.value = type;
    if (
        selectedBrand.value &&
        !filteredBrands.value.find(
            (brand) => brand.id === selectedBrand.value.id
        )
    ) {
        selectedBrand.value = null;
    }
};

const handleBrandSelect = (brand) => {
    selectedBrand.value = brand;
    // Reset type selection if the selected type doesn't have devices of this brand
    if (
        selectedType.value &&
        !filteredTypes.value.find((type) => type.id === selectedType.value.id)
    ) {
        selectedType.value = null;
    }
};

const handleDeviceSelect = (device) => {
    selectedDevice.value = device.id;
};
</script>
