<template>
    <AppLayout>
        <div class="p-3 space-y-3">
            <div class="flex justify-between items-center gap-3">
                <h1>Tickets</h1>
                <Button>Ajouter un ticket</Button>
            </div>
            <div class="flex gap-3">
                <Select>
                    <SelectTrigger>
                        <SelectValue placeholder="Technicien" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem value="apple"> Jojo </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select>
                    <SelectTrigger>
                        <SelectValue placeholder="Model" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem value="apple">Iphone </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select>
                    <SelectTrigger>
                        <SelectValue placeholder="Marque" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem value="apple">Apple </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select>
                    <SelectTrigger>
                        <SelectValue placeholder="Type" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem value="apple">Pc </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>
            <div class="flex justify-between gap-3">
                <Input
                    placeholder="Rechercher un ticket"
                    class="w-auto basis-1/2"
                />
                <div class="flex gap-3">
                    <div class="flex items-center space-x-2">
                        <Switch id="pending-mode" />
                        <Label for="pending-mode">en cours</Label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <Switch id="delivered-mode" />
                        <Label for="delivered-mode">rendu</Label>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/ui/button/Button.vue";
import Input from "@/Components/ui/input/Input.vue";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import { Switch } from "@/Components/ui/switch";
import { Label } from "@/Components/ui/label";
</script>
