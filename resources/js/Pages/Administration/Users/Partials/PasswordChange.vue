<template>
    <Dialog :open="isOpen" @update:open="handleOpen">
        <DialogTrigger as-child>
            <!-- <font-awesome-icon
                icon="fa-solid fa-plus"
                class="text-xl text-gray-400 cursor-pointer hover:text-indigo-500"
            /> -->
            <Button variant="outline"> Changer le mot de passe </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle
                    >Modifier le mot de passe de
                    <span class="capitalize">
                        {{ user.firstName }}
                        {{ user.lastName }}
                    </span>
                </DialogTitle>
            </DialogHeader>
            <form @submit.prevent="onSubmit">
                <div class="grid grid-cols-1 gap-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="space-y-2">
                                <Label>Mot de passe</Label>
                                <Input
                                    type="password"
                                    placeholder="Mot de passe"
                                    v-model="form.password"
                                />
                                <p
                                    v-if="form.errors.password"
                                    class="text-sm text-red-500"
                                >
                                    {{ form.errors.password }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <div class="space-y-2">
                                <Label>Confirmer le mot de passe</Label>
                                <Input
                                    type="password"
                                    placeholder="Confirmation"
                                    v-model="form.password_confirmation"
                                />
                                <p
                                    v-if="form.errors.password_confirmation"
                                    class="text-sm text-red-500"
                                >
                                    {{ form.errors.password_confirmation }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <Button
                    type="submit"
                    class="inline-flex justify-center px-4 py-2 mt-6 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    :disabled="form.processing"
                >
                    Modifier
                </Button>
            </form>
        </DialogContent>
    </Dialog>
</template>

<script setup>
import { Button } from "@/Components/ui/button";
import {
    Dialog,
    DialogTrigger,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
} from "@/Components/ui/dialog";
import { Label } from "@/Components/ui/label";
import { Input } from "@/Components/ui/input";
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import { inject, ref } from "vue";

const props = defineProps({
    user: {
        type: Object,
        default: () => null,
    },
});

const form = useForm({
    id: props.user.id,
    password: "",
    password_confirmation: "",
});

const isOpen = ref(false);

const onSubmit = () => {
    form.put(route("users.edit.password"), {
        preserveScroll: true,
        onSuccess: () => {
            // emit("user-created");
            handleOpen(false);
        },
    });
};

const handleOpen = (value) => {
    isOpen.value = value;
    if (!value) {
        form.reset();
    }
};
</script>
