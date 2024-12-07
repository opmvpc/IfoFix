<template>
    <AppLayout>
        <div class="p-3 flex flex-col gap-3 h-screen overflow-hidden">
            <div class="flex justify-between items-center gap-3">
                <h1 class="text-xl font-semibold">Ajouter un ticket</h1>
                <Link :href="route('tickets.index')"
                    ><Button>Retour</Button></Link
                >
            </div>

            <!-- Formulaire -->
            <div class="flex flex-col gap-3">
                <div class="flex gap-3">
                    <Input placeholder="Nom" />
                    <Input placeholder="Prénom" />
                </div>
                <Input placeholder="Email" />
                <Input placeholder="Téléphone" />
                <Input placeholder="Adresse" />
                <Input placeholder="Code postal" />
                <Input placeholder="Ville" />
                <Input placeholder="Pays" />
                <Input placeholder="Description" />
                <Button>Ajouter</Button>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import Button from "@/Components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
</script>
