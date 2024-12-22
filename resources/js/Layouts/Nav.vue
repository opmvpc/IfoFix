<template>
    <Banner class="" />
    <nav
        class="fixed top-0 left-0 z-10 flex flex-col justify-between w-40 h-screen text-white border-r shadow-lg bg-gradient-to-b from-indigo-600 to-indigo-900 lg:w-52"
    >
        <div
            class="flex items-center justify-center h-20 border-b border-indigo-400"
        >
            <Link
                :href="route('dashboard')"
                class="flex gap-4 transition-transform hover:scale-105"
            >
                <ApplicationMark class="block w-auto h-9" />
                <span class="text-4xl">
                    <span class="font-black">IFO</span>
                    <span>fix</span>
                </span>
            </Link>
        </div>

        <div class="flex flex-col flex-1 px-2 mt-6 space-y-1">
            <NavLink
                :href="route('tickets.index')"
                :active="route().current('tickets.*')"
                class="flex items-center px-3 py-2 transition-all rounded-lg hover:bg-indigo-400 group"
            >
                <font-awesome-icon
                    icon="fa-solid fa-ticket"
                    class="w-4 h-4 mr-2 group-hover:text-white"
                />
                <span class="text-sm font-bold group-hover:text-white"
                    >Tickets</span
                >
            </NavLink>

            <NavLink
                :href="route('administration', { tab: 'stats' })"
                :active="route().current('administration*')"
                class="flex items-center px-3 py-2 transition-all rounded-lg hover:bg-indigo-400 group"
            >
                <font-awesome-icon
                    icon="fa-solid fa-users-gear"
                    class="w-4 h-4 mr-2 group-hover:text-white"
                />
                <span class="text-sm font-bold group-hover:text-white"
                    >Administration</span
                >
            </NavLink>
        </div>

        <div class="p-4 mt-auto space-y-3">
            <!-- Profile Management -->
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

                <DropdownMenuContent class="bg-white">
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
import { ref } from "vue";
const showingNavigationDropdown = ref(false);

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
