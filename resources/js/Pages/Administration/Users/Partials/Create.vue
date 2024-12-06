<template>
    <form action="#" method="post">
        <Card>
            <CardHeader>
                <CardTitle>Créer un utilisateur</CardTitle>
                <CardDescription
                    >Formulaire de création d'un utilisateur</CardDescription
                >
            </CardHeader>
            <CardContent>
                <div class="grid grid-cols-1 gap-6">
                    <div class="columns-2">
                        <div>
                            <Label for="firstName">Prénom</Label>
                            <Input
                                type="text"
                                name="firstName"
                                id="firstName"
                                autocomplete="given-name"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />
                        </div>
                        <div>
                            <Label for="lastName">Nom</Label>
                            <Input
                                type="text"
                                name="lastName"
                                id="lastName"
                                autocomplete="given-name"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />
                        </div>
                    </div>
                    <div>
                        <Label for="email">Email</Label>
                        <Input
                            type="email"
                            name="email"
                            id="email"
                            autocomplete="email"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        />
                    </div>
                    <div class="columns-2">
                        <div>
                            <Label for="password">Mot de passe</Label>
                            <Input
                                type="password"
                                name="password"
                                id="password"
                                autocomplete="new-password"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />
                        </div>
                        <div>
                            <Label for="password_confirmation"
                                >Confirmer le mot de passe</Label
                            >
                            <Input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                autocomplete="new-password"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />
                        </div>
                    </div>
                    <div>
                        <Label for="role">Rôle</Label>
                        <select
                            id="role"
                            name="role"
                            autocomplete="role"
                            class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        >
                            <option>Administrateur</option>
                            <option>Utilisateur</option>
                        </select>
                    </div>
                    <!-- <div>
                        <button
                            type="submit"
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Créer
                        </button>
                    </div> -->
                </div>
            </CardContent>
            <CardFooter>
                <button
                    type="submit"
                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Créer
                </button>
            </CardFooter>
        </Card>
    </form>
</template>
<script setup>
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter,
} from "@/Components/ui/card";
import { Label } from "@/Components/ui/label";
import { Input } from "@/Components/ui/input";
</script>
