<template>
    <AppLayout title="Administration">
        <div class="container">
            <Head title="Administration" />
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Administration
            </h2>
            <Tabs default-value="stats" class="w-full">
                <TabsList class="justify-start w-full bg-gray-300">
                    <TabsTrigger value="stats"> Statistiques </TabsTrigger>
                    <TabsTrigger value="users"> Utilisateurs </TabsTrigger>
                    <TabsTrigger value="clients"> Clients </TabsTrigger>
                    <TabsTrigger value="devices"> Appareils </TabsTrigger>
                </TabsList>
                <TabsContent value="stats"> Stats page </TabsContent>
                <TabsContent value="users">
                    Users administration page
                </TabsContent>
                <TabsContent value="clients">
                    Clients administration page
                </TabsContent>
                <TabsContent value="devices">
                    Devices administration page
                </TabsContent>
            </Tabs>
        </div>
    </AppLayout>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/Components/ui/tabs";
</script>
