<template>
    <Card class="flex flex-col">
        <CardContent class="flex-1 p-6">
            <div class="flex">
                <h1 class="text-2xl font-bold">Liste des clients</h1>
                <UserCreate />
            </div>
            <div class="flex items-center gap-2 py-4">
                <Input
                    type="search"
                    class="max-w-52"
                    placeholder="Rechercher..."
                    :model-value="table.getState().globalFilter"
                    @update:model-value="table.setGlobalFilter"
                />
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
                                (value) => column.toggleVisibility(!!value)
                            "
                        >
                            {{ column.id }}
                        </DropdownMenuCheckboxItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>

            <div class="border rounded-md">
                <Table class="">
                    <TableHeader>
                        <TableRow
                            v-for="headerGroup in table.getHeaderGroups()"
                            :key="headerGroup.id"
                        >
                            <TableHead
                                v-for="header in headerGroup.headers"
                                :key="header.id"
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
                            <TableRow
                                v-for="row in table.getRowModel().rows"
                                :key="row.id"
                                @click="selectClient(row.original)"
                                class="cursor-pointer hover:bg-blue-100"
                            >
                                <TableCell
                                    v-for="cell in row.getVisibleCells()"
                                    :key="cell.id"
                                >
                                    <FlexRender
                                        :render="cell.column.columnDef.cell"
                                        :props="cell.getContext()"
                                    />
                                </TableCell>
                            </TableRow>
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
        </CardContent>
    </Card>
</template>

<script setup>
import { Button } from "@/Components/ui/button";
import {
    DropdownMenu,
    DropdownMenuCheckboxItem,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from "@/Components/ui//dropdown-menu";
import { Input } from "@/Components/ui//input";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/Components/ui//table";
import { valueUpdater } from "@/lib/utils";
import {
    FlexRender,
    getCoreRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    useVueTable,
} from "@tanstack/vue-table";
import { ArrowUpDown, ChevronDown } from "lucide-vue-next";
import { h, ref, watch } from "vue";
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter,
} from "@/Components/ui//card";
import { Badge } from "@/Components/ui//badge";
import UserCreate from "@/Pages/Administration/Users/Partials/Create.vue";

const emit = defineEmits(["client-selected"]);

const props = defineProps({
    clients: {
        type: Array,
        required: true,
    },
});

const columns = [
    {
        accessorKey: "firstName",
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => ["Prénom", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })]
            );
        },
        cell: ({ row }) =>
            h("div", { class: "capitalize" }, row.original.firstName),
    },
    {
        accessorKey: "lastName",
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => ["Nom", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })]
            );
        },
        cell: ({ row }) =>
            h("div", { class: "capitalize" }, row.original.lastName),
    },
    {
        accessorKey: "email",
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => ["Email", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })]
            );
        },
    },
    {
        accessorKey: "phone",
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => ["Phone", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })]
            );
        },
    },
];

const sorting = ref([]);
const columnFilters = ref([]);
const columnVisibility = ref({});
const globalFilter = ref("");

const table = useVueTable({
    get data() {
        return props.clients;
    },
    get columns() {
        return columns;
    },
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    onSortingChange: (updaterOrValue) => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: (updaterOrValue) =>
        valueUpdater(updaterOrValue, columnFilters),
    onColumnVisibilityChange: (updaterOrValue) =>
        valueUpdater(updaterOrValue, columnVisibility),
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
        get globalFilter() {
            return globalFilter.value;
        },
    },
});

const selectClient = (client) => {
    emit("client-selected", client);
};
</script>
