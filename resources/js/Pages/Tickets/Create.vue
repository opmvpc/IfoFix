<template>
    <AppLayout>
        <div class="flex justify-center ">
            <CreateTicket
            :devices="devices"
            :technicians="technicians"
            :clients="clients"
            :brands="brands"
            :types="types"
            class="m-6 max-w-4xl grow"
             />
        </div>

    </AppLayout>

</template>

<script setup ">
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateTicket from './CreateTicket.vue';


const props = defineProps({
    devices: Array,
    brands: Array,
    types: Array,
    clients: Array,
    technicians: Array,
});


</script>
