<script setup lang="ts">
import type {
    ColumnFiltersState,
    ExpandedState,
    SortingState,
    VisibilityState,
} from "@tanstack/vue-table";
import { Button } from "@/Components/ui/button";

import {
    DropdownMenu,
    DropdownMenuCheckboxItem,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";
import { Input } from "@/Components/ui/input";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/Components/ui/table";
import { cn, valueUpdater } from "@/lib/utils";
import {
    createColumnHelper,
    FlexRender,
    getCoreRowModel,
    getExpandedRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    useVueTable,
} from "@tanstack/vue-table";

import { ArrowUpDown, ChevronDown } from "lucide-vue-next";
import { computed, h, ref, watch, watchEffect } from "vue";
import { Badge } from "@/Components/ui/badge";
import { router } from "@inertiajs/vue3";
import Switch from "@/Components/ui/switch/Switch.vue";
// import DropdownAction from "./DataTableDemoColumn.vue";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

export interface Payment {
    id: string;
    amount: number;
    status: "pending" | "processing" | "success" | "failed";
    email: string;
}

const props = defineProps({
    tickets: Array,
    technicians: Array,
    devices: Array,
    brands: Array,
    types: Array,
    clients: Array,
    pendingTickets: Boolean,
    deliveredTickets: Boolean,
});

const tickets = ref(props.tickets);
watchEffect(() => {
    tickets.value = props.tickets;
});

// refactoring filter btn
const selectedTechnician = ref(null);
const selectedDevice = ref(null);
const selectedBrand = ref(null);
const selectedType = ref(null);

const filteredTickets = computed(() => {
    let tickets = props.tickets;
    if (props.pendingTickets) {
        tickets = tickets.filter((ticket) => !ticket.isFinished);
    }
    if (props.deliveredTickets) {
        tickets = tickets.filter((ticket) => ticket.isDelivered);
    }
    if (selectedTechnician.value) {
        tickets = tickets.filter(
            (ticket) => ticket.user.id === selectedTechnician.value
        );
    }
    if (selectedDevice.value) {
        tickets = tickets.filter(
            (ticket) => ticket.device.id === selectedDevice.value
        );
    }
    if (selectedBrand.value) {
        tickets = tickets.filter(
            (ticket) => ticket.device.brandId === selectedBrand.value
        );
    }

    if (selectedType.value) {
        tickets = tickets.filter(
            (ticket) => ticket.device.typeId === selectedType.value
        );
    }
    return tickets;
});

const columns = [
    {
        accessorKey: "id",
        header: "id",
        cell: ({ row }) => {
            return h("p", row.getValue("id"));
        },
        enableSorting: false,
        enableHiding: false,
    },
    {
        accessorKey: "title",
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => ["Titre", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })]
            );
        },
        cell: ({ row }) =>
            h(
                "div",
                {
                    class: "capitalize cursor-pointer hover:text-blue-600",
                    onClick: () =>
                        router.visit(`/tickets/${row.getValue("id")}`),
                },
                row.getValue("title")
            ),
    },
    {
        accessorKey: "isFinished",
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => ["Status", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })]
            );
        },
        cell: ({ row }) => {
            const status = row.getValue("isFinished") ? "Terminé" : "En cours";
            return h(
                Badge,
                {
                    class:
                        status === "Terminé"
                            ? "px-2 py-1 bg-emerald-100 text-emerald-600"
                            : "px-2 py-1 bg-orange-100 text-orange-600",
                },
                () => status
            );
        },
    },

    {
        accessorKey: "interventions",
        header: "Assigné à",
        cell: ({ row }) => {
            const interventions = row.getValue("interventions");
            // Récupérer tous les utilisateurs de toutes les interventions
            const allUsers = interventions
                .flatMap((intervention) => intervention.users)
                .map((user) => user.firstName);
            // Supprimer les doublons et joindre les noms
            const uniqueUsers = Array.from(new Set(allUsers));

            return h(
                "div",
                { class: "flex flex-col gap-1" },
                uniqueUsers.join(", ") || "Non assigné"
            );
        },
    },
    {
        id: "actions",
        enableHiding: false,
        cell: ({ row }) => {
            return h(
                "div",
                {
                    class: "cursor-pointer text-gray-400 hover:text-red-900",
                    onClick: () => {
                        if (
                            confirm(
                                "Êtes-vous sûr de vouloir supprimer ce ticket ?"
                            )
                        ) {
                            router.delete(`/tickets/${row.getValue("id")}`);
                        }
                    },
                },
                [
                    h(FontAwesomeIcon, {
                        icon: "fa-solid fa-trash",
                        class: "h-4 w-4 px-4",
                    }),
                ]
            );
        },
    },
];

const sorting = ref<SortingState>([]);
const columnFilters = ref<ColumnFiltersState>([]);
const columnVisibility = ref<VisibilityState>({});
const rowSelection = ref({});
const expanded = ref<ExpandedState>({});
const globalFilter = ref("");

// Ajouter cette fonction de filtrage personnalisée après la définition des colonnes
// const fuzzyFilter = (
//     row: any,
//     columnId: string,
//     value: string,
//     column: any
// ) => {
//     const searchValue = value.toLowerCase();
//     const rowData = row.original;

//     // Fonction récursive pour chercher dans les objets imbriqués
//     const searchInObject = (obj: any): boolean => {
//         if (!obj) return false;

//         return Object.keys(obj).some((key) => {
//             const val = obj[key];
//             if (typeof val === "object") {
//                 return searchInObject(val);
//             }
//             return String(val).toLowerCase().includes(searchValue);
//         });
//     };

//     return searchInObject(rowData);
// };

const table = useVueTable({
    data: filteredTickets,
    columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getExpandedRowModel: getExpandedRowModel(),
    onSortingChange: (updaterOrValue) => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: (updaterOrValue) =>
        valueUpdater(updaterOrValue, columnFilters),
    onColumnVisibilityChange: (updaterOrValue) =>
        valueUpdater(updaterOrValue, columnVisibility),
    onRowSelectionChange: (updaterOrValue) =>
        valueUpdater(updaterOrValue, rowSelection),
    onExpandedChange: (updaterOrValue) =>
        valueUpdater(updaterOrValue, expanded),
    onGlobalFilterChange: (updaterOrValue) =>
        valueUpdater(updaterOrValue, globalFilter),
    state: {
        get sorting() {
            return sorting.value;
        },
        get columnFilters() {
            return columnFilters.value;
        },
        get columnVisibility() {
            return columnVisibility.value;
        },
        get rowSelection() {
            return rowSelection.value;
        },
        get expanded() {
            return expanded.value;
        },
        get globalFilter() {
            return globalFilter.value;
        },
        columnPinning: {
            left: ["status"],
        },
    },
    // globalFilterFn: fuzzyFilter,
});
</script>

<template>
    <div class="flex gap-2">
        <div class="w-full">
            <div class="flex items-center gap-2">
                <h1 class="text-xl font-semibold">Tickets</h1>
                <font-awesome-icon
                    icon="fa-solid fa-plus"
                    class="h-4 w-4 cursor-pointer"
                    @click="$emit('buttonClick')"
                />
            </div>
            <div class="flex items-center gap-2 py-4">
                <Input
                    class="max-w-sm"
                    placeholder="Rechercher..."
                    :model-value="table.getState().globalFilter"
                    @update:model-value="table.setGlobalFilter"
                />
                <div class="flex gap-3 shrink-0">
                    <div class="flex items-center space-x-2">
                        <Switch
                            :checked="pendingTickets"
                            @update:checked="
                                (value) => $emit('updatePendingTickets', value)
                            "
                            id="pending-mode"
                        />
                        <Label for="pending-mode">en cours</Label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <Switch
                            :checked="deliveredTickets"
                            @update:checked="
                                (value) =>
                                    $emit('updateDeliveredTickets', value)
                            "
                            id="delivered-mode"
                        />
                        <Label for="delivered-mode">rendu</Label>
                    </div>
                </div>

                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="outline" class="ml-auto">
                            Columns <ChevronDown class="w-4 h-4 ml-2" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuCheckboxItem
                            v-for="column in table
                                .getAllColumns()
                                .filter((column) => column.getCanHide())"
                            :key="column.id"
                            class="capitalize"
                            :checked="column.getIsVisible()"
                            @update:checked="
                                (value) => {
                                    column.toggleVisibility(!!value);
                                }
                            "
                        >
                            {{ column.id }}
                        </DropdownMenuCheckboxItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
            <div class="mb-4 flex gap-2">
                <Select v-model="selectedTechnician">
                    <SelectTrigger>
                        <SelectValue placeholder="Technicien" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem :value="aucun"> Aucun </SelectItem>
                            <SelectItem
                                v-for="(technician, index) in props.technicians"
                                :key="index"
                                :value="technician.id"
                            >
                                {{ technician.firstName }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>

                <Select v-model="selectedDevice">
                    <SelectTrigger>
                        <SelectValue placeholder="Model" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem :value="aucun"> Aucun </SelectItem>
                            <SelectItem
                                v-for="(device, index) in props.devices"
                                :key="index"
                                :value="device.id"
                                >{{ device.name }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>

                <Select v-model="selectedBrand">
                    <SelectTrigger>
                        <SelectValue placeholder="Marque" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem :value="aucun"> Aucun </SelectItem>
                            <SelectItem
                                v-for="(brand, index) in props.brands"
                                :key="index"
                                :value="brand.id"
                                >{{ brand.name }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>

                <Select v-model="selectedType">
                    <SelectTrigger>
                        <SelectValue placeholder="Type" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem :value="aucun"> Aucun </SelectItem>
                            <SelectItem
                                v-for="(type, index) in props.types"
                                :key="index"
                                :value="type.id"
                                >{{ type.name }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>

            <div class="border rounded-md grow">
                <Table>
                    <TableHeader>
                        <TableRow
                            v-for="headerGroup in table.getHeaderGroups()"
                            :key="headerGroup.id"
                        >
                            <TableHead
                                v-for="header in headerGroup.headers"
                                :key="header.id"
                                :data-pinned="header.column.getIsPinned()"
                                :class="
                                    cn(
                                        {
                                            'sticky bg-background/95':
                                                header.column.getIsPinned(),
                                        },
                                        header.column.getIsPinned() === 'left'
                                            ? 'left-0'
                                            : 'right-0'
                                    )
                                "
                            >
                                <FlexRender
                                    v-if="!header.isPlaceholder"
                                    :render="header.column.columnDef.header"
                                    :props="header.getContext()"
                                />
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="table.getRowModel().rows?.length">
                            <template
                                v-for="row in table.getRowModel().rows"
                                :key="row.id"
                            >
                                <TableRow
                                    :data-state="
                                        row.getIsSelected() && 'selected'
                                    "
                                >
                                    <TableCell
                                        v-for="cell in row.getVisibleCells()"
                                        :key="cell.id"
                                        :data-pinned="cell.column.getIsPinned()"
                                        :class="
                                            cn(
                                                {
                                                    'sticky bg-background/95':
                                                        cell.column.getIsPinned(),
                                                },
                                                cell.column.getIsPinned() ===
                                                    'left'
                                                    ? 'left-0'
                                                    : 'right-0'
                                            )
                                        "
                                    >
                                        <FlexRender
                                            :render="cell.column.columnDef.cell"
                                            :props="cell.getContext()"
                                        />
                                    </TableCell>
                                </TableRow>
                                <TableRow v-if="row.getIsExpanded()">
                                    <TableCell
                                        :colspan="row.getAllCells().length"
                                    >
                                        {{ row.original }}
                                    </TableCell>
                                </TableRow>
                            </template>
                        </template>

                        <TableRow v-else>
                            <TableCell
                                :colspan="columns.length"
                                class="h-24 text-center"
                            >
                                No results.
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <div class="flex items-center justify-end py-4 space-x-2">
                <div class="flex-1 text-sm text-muted-foreground">
                    {{ table.getFilteredSelectedRowModel().rows.length }} of
                    {{ table.getFilteredRowModel().rows.length }} row(s)
                    selected.
                </div>
                <div class="space-x-2">
                    <Button
                        variant="outline"
                        size="sm"
                        :disabled="!table.getCanPreviousPage()"
                        @click="table.previousPage()"
                    >
                        Previous
                    </Button>
                    <Button
                        variant="outline"
                        size="sm"
                        :disabled="!table.getCanNextPage()"
                        @click="table.nextPage()"
                    >
                        Next
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>
