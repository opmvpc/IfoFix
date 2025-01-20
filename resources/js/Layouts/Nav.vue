<template>
    <Banner class="" />
    <nav
        class="absolute top-0 left-0 z-50 flex flex-col justify-between w-40 h-screen text-white transition-all duration-300 border-r shadow-lg border-border lg:w-52"
        :class="
            modelValue
                ? '-translate-x-full md:translate-x-0'
                : 'translate-x-0 md:-translate-x-full'
        "
    >
        <div
            class="absolute top-0 left-0 w-full h-full -z-10 bg-gradient-to-b from-indigo-600 dark:from-indigo-800 dark:via-indigo-950 to-indigo-900 dark:to-indigo-950 dark:brightness-50"
        ></div>
        <button
            class="absolute right-0 p-2 translate-x-full bg-indigo-600 rounded-r-lg md:hidden top-4 hover:bg-indigo-700"
            @click="toggleNavigation"
        >
            <font-awesome-icon
                icon="fa-solid fa-bars"
                class="w-6 h-6 text-white"
            />
        </button>

        <div
            class="flex items-center justify-center h-20 border-b dark:border-indigo-400"
        >
            <Link
                :href="route('dashboard')"
                class="flex gap-4 transition-transform hover:scale-105"
            >
                <figure class="px-4">
                    <img src="/images/logo_3.png" alt="" />
                </figure>
            </Link>
        </div>

        <div class="flex flex-col flex-1 px-2 mt-6 space-y-1">
            <NavLink
                :href="route('tickets.index')"
                :active="isActive(['tickets.*'])"
                class="flex items-center px-3 py-2 transition-all rounded-lg group"
            >
                <font-awesome-icon
                    icon="fa-solid fa-ticket"
                    class="w-4 h-4 mr-2 group-hover:text-white"
                />
                <span class="text-sm font-bold group-hover:text-white"
                    >Tickets</span
                >
            </NavLink>

            <div
                class="space-y-1 rounded-lg"
                v-if="$page.props.auth.user.role === 'admin'"
            >
                <div class="flex items-center px-3 py-2">
                    <font-awesome-icon
                        icon="fa-solid fa-users-gear"
                        class="w-4 h-4 mr-2"
                    />
                    <span class="text-sm font-bold">Administration</span>
                </div>

                <div class="pl-4 space-y-1">
                    <!-- <NavLink
                        :href="route('administration.stats')"
                        :active="isActive('administration.stats')"
                        class="flex items-center px-3 py-2 transition-all rounded-lg group"
                    >
                        <font-awesome-icon
                            icon="fa-solid fa-chart-line"
                            class="w-4 h-4 mr-2 group-hover:text-white"
                        />
                        <span class="text-sm font-bold group-hover:text-white"
                            >Statistiques</span
                        >
                    </NavLink> -->
                    <NavLink
                        :href="route('administration.users')"
                        :active="isActive(['administration.users'])"
                        class="flex items-center px-3 py-2 transition-all rounded-lg group"
                    >
                        <font-awesome-icon
                            icon="fa-solid fa-screwdriver-wrench"
                            class="w-4 h-4 mr-2 group-hover:text-white"
                        />
                        <span class="text-sm font-bold group-hover:text-white"
                            >Techniciens</span
                        >
                    </NavLink>
                    <NavLink
                        :href="route('administration.clients')"
                        :active="isActive('administration.clients')"
                        class="flex items-center px-3 py-2 transition-all rounded-lg group"
                    >
                        <font-awesome-icon
                            icon="fa-solid fa-users"
                            class="w-4 h-4 mr-2 group-hover:text-white"
                        />
                        <span class="text-sm font-bold group-hover:text-white"
                            >Clients</span
                        >
                    </NavLink>
                    <NavLink
                        :href="route('administration.devices')"
                        :active="isActive('administration.devices')"
                        class="flex items-center px-3 py-2 transition-all rounded-lg group"
                    >
                        <font-awesome-icon
                            icon="fa-solid fa-laptop"
                            class="w-4 h-4 mr-2 group-hover:text-white"
                        />
                        <span class="text-sm font-bold group-hover:text-white"
                            >Appareils</span
                        >
                    </NavLink>
                </div>
            </div>
        </div>

        <div class="p-4 mt-auto space-y-3">
            <!-- Profile Management -->

            <DarkModeButton />

            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <Button
                        variant="secondary"
                        class="justify-start w-full text-white bg-indigo-400 border-none hover:bg-indigo-300"
                    >
                        <div class="flex items-center">
                            <div
                                class="flex items-center justify-center w-8 h-8 mr-2 bg-indigo-300 rounded-full"
                            >
                                <font-awesome-icon
                                    icon="fa-solid fa-user"
                                    class="w-4 h-4 text-white"
                                />
                            </div>
                            <span class="text-sm font-medium truncate">
                                {{ $page.props.auth.user.firstName }}
                            </span>
                        </div>
                    </Button>
                </DropdownMenuTrigger>

                <DropdownMenuContent>
                    <DropdownMenuItem class="cursor-pointer">
                        <font-awesome-icon
                            icon="fa-solid fa-user-circle"
                            class="w-4 h-4 mr-2"
                        />
                        <Link :href="route('profile.show')">Profile</Link>
                    </DropdownMenuItem>

                    <DropdownMenuItem
                        v-if="$page.props.jetstream.hasApiFeatures"
                        class="cursor-pointer"
                    >
                        <font-awesome-icon
                            icon="fa-solid fa-key"
                            class="w-4 h-4 mr-2"
                        />
                        <Link :href="route('api-tokens.index')"
                            >API Tokens</Link
                        >
                    </DropdownMenuItem>

                    <DropdownMenuSeparator />

                    <DropdownMenuItem @click="logout" class="cursor-pointer">
                        <font-awesome-icon
                            icon="fa-solid fa-sign-out-alt"
                            class="w-4 h-4 mr-2"
                        />
                        <span>Log Out</span>
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>

            <!-- Team Management -->
            <DropdownMenu v-if="$page.props.jetstream.hasTeamFeatures">
                <DropdownMenuTrigger as-child>
                    <Button
                        variant="secondary"
                        class="justify-start w-full text-white bg-indigo-400 border-none hover:bg-indigo-300"
                    >
                        <div class="flex items-center">
                            <div
                                class="flex items-center justify-center w-8 h-8 mr-2 bg-indigo-300 rounded-full"
                            >
                                <font-awesome-icon
                                    icon="fa-solid fa-users"
                                    class="w-4 h-4 text-white"
                                />
                            </div>
                            <span class="text-sm font-medium truncate">
                                {{ $page.props.auth.user.current_team.name }}
                            </span>
                        </div>
                    </Button>
                </DropdownMenuTrigger>

                <DropdownMenuContent class="bg-white">
                    <DropdownMenuSeparator />
                    <DropdownMenuItem>
                        <Link
                            :href="
                                route(
                                    'teams.show',
                                    $page.props.auth.user.current_team
                                )
                            "
                        >
                            Team Settings
                        </Link>
                    </DropdownMenuItem>
                    <DropdownMenuItem
                        v-if="$page.props.jetstream.canCreateTeams"
                    >
                        <Link :href="route('teams.create')">
                            Create New Team
                        </Link>
                    </DropdownMenuItem>
                    <DropdownMenuSeparator
                        v-if="$page.props.auth.user.all_teams.length > 1"
                    />
                    <template v-if="$page.props.auth.user.all_teams.length > 1">
                        <DropdownMenuLabel>Switch Teams</DropdownMenuLabel>
                        <template
                            v-for="team in $page.props.auth.user.all_teams"
                            :key="team.id"
                        >
                            <form @submit.prevent="switchToTeam(team)">
                                <DropdownMenuItem as="button">
                                    <div class="flex items-center">
                                        <font-awesome-icon
                                            v-if="
                                                team.id ==
                                                $page.props.auth.user
                                                    .current_team_id
                                            "
                                            icon="fa-solid fa-check"
                                            class="text-green-400 me-2 size-5"
                                        />
                                        <div>{{ team.name }}</div>
                                    </div>
                                </DropdownMenuItem>
                            </form>
                        </template>
                    </template>
                </DropdownMenuContent>
            </DropdownMenu>
        </div>
    </nav>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Banner from "@/Components/Banner.vue";
import NavLink from "@/Components/NavLink.vue";
import {
    DropdownMenu,
    DropdownMenuTrigger,
    DropdownMenuContent,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuItem,
} from "@/Components/ui/dropdown-menu";
import { Button } from "@/Components/ui/button";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import DarkModeButton from "@/Components/DarkModeButton.vue";
// import logo from "@/assets/logo.svg";

// Add the improved helper functions
const isActive = (routeName, params = {}) => {
    if (typeof routeName === "string") {
        return (
            route().current(routeName) &&
            (!params.tab || route().params.tab === params.tab)
        );
    }
    return routeName.some((name) => route().current(name));
};

const props = defineProps({
    modelValue: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits(["update:modelValue"]);

const toggleNavigation = () => {
    emit("update:modelValue", !props.modelValue);
};

const switchToTeam = (team) => {
    router.put(
        route("current-team.update"),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        }
    );
};

const logout = () => {
    router.post(route("logout"));
};
</script>
