<template>
    <AppLayout title="Administration">
        <div class="container flex flex-col min-h-screen p-4 mx-auto">
            <Head title="Administration" />
            <Tabs
                :default-value="activeTab"
                class="flex flex-col w-full h-full grow"
            >
                <TabsList
                    class="flex justify-start w-full p-2 text-white bg-indigo-500 rounded-md"
                >
                    <TabsTrigger
                        value="stats"
                        class="px-4 py-2 rounded-md hover:bg-indigo-400"
                    >
                        Statistiques
                    </TabsTrigger>
                    <TabsTrigger
                        value="users"
                        class="px-4 py-2 rounded-md hover:bg-indigo-400"
                    >
                        Utilisateurs
                    </TabsTrigger>
                    <TabsTrigger
                        value="clients"
                        class="px-4 py-2 rounded-md hover:bg-indigo-400"
                    >
                        Clients
                    </TabsTrigger>
                    <TabsTrigger
                        value="devices"
                        class="px-4 py-2 rounded-md hover:bg-indigo-400"
                    >
                        Appareils
                    </TabsTrigger>
                </TabsList>
                <TabsContent value="stats" class=""> Stats page </TabsContent>
                <TabsContent
                    value="users"
                    class="flex flex-row overflow-hidden grow"
                >
                    <UsersPage :users="usersList" />
                </TabsContent>
                <TabsContent
                    value="clients"
                    class="p-4 bg-white rounded-md shadow-md"
                >
                    <ClientsPage :clients="clientsList" />
                </TabsContent>
                <TabsContent
                    value="devices"
                    class="p-4 bg-white rounded-md shadow-md"
                >
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
import UsersPage from "@/Pages/Administration/Users/Index.vue";
import ClientsPage from "@/Pages/Administration/Clients/Index.vue";

const props = defineProps({
    users: {
        type: Array,
        default: [],
    },
    clients: {
        type: Array,
        default: [],
    },
    activeTab: {
        type: String,
        default: "stats",
    },
});

import { usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
const page = usePage();

const usersList = ref(props.users);
const clientsList = ref(props.clients);

// Watch for flash messages
watch(
    () => page.props.flash,
    (newFlash) => {
        if (newFlash && typeof newFlash === "object" && newFlash.refresh) {
            if (newFlash.refresh === "users") {
                fetchUsers();
            } else if (newFlash.refresh === "clients") {
                fetchClients();
            }
        }
    },
    { deep: true }
);

const fetchUsers = () => {
    axios.get("/users").then((response) => {
        usersList.value = response.data;
    });
};

const fetchClients = () => {
    axios.get("/clients").then((response) => {
        clientsList.value = response.data;
    });
};
</script>
