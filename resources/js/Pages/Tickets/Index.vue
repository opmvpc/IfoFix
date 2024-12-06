<template>
    <AppLayout>
        <div class="flex justify-between items-center p-3 gap-5">
            <h1>Tickets</h1>
            <Input placeholder="Rechercher un ticket" />
            <Button>Ajouter un ticket</Button>
        </div>
        <hr />
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/ui/button/Button.vue";
import Input from "@/Components/ui/input/Input.vue";
</script>
