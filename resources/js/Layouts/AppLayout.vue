<script setup>
import { ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
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

defineProps({
    title: String,
});

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

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Sidebar -->
            <nav
                class="fixed top-0 left-0 z-10 flex flex-col justify-between w-40 h-screen bg-white border-r border-gray-100 dark:bg-gray-800 dark:border-gray-700"
            >
                <div
                    class="flex items-center justify-center h-16 border-b border-gray-100 dark:border-gray-700"
                >
                    <Link :href="route('dashboard')">
                        <ApplicationMark class="block w-auto h-9" />
                    </Link>
                </div>
                <div class="flex flex-col flex-1 mt-5">
                    <NavLink
                        :href="route('tickets.index')"
                        :active="route().current('tickets.*')"
                    >
                        Tickets
                    </NavLink>
                    <NavLink
                        :href="route('administration', { tab: 'users' })"
                        :active="route().current('administration.*')"
                    >
                        Administration
                    </NavLink>
                    <!-- Add more navigation links here -->
                </div>
                <div class="p-4 mt-auto">
                    <!-- Profile Management -->
                    <DropdownMenu>
                        <DropdownMenuTrigger as-child>
                            <Button variant="outline">
                                {{ $page.props.auth.user.firstName }}
                                <font-awesome-icon
                                    icon="fa-solid fa-chevron-up"
                                    class="ml-2"
                                />
                            </Button>
                        </DropdownMenuTrigger>

                        <DropdownMenuContent>
                            <DropdownMenuSeparator />
                            <DropdownMenuItem>
                                <Link :href="route('profile.show')">
                                    Profile
                                </Link>
                            </DropdownMenuItem>
                            <DropdownMenuItem
                                v-if="$page.props.jetstream.hasApiFeatures"
                                :href="route('api-tokens.index')"
                                >API Tokens</DropdownMenuItem
                            >
                            <DropdownMenuSeparator />
                            <form @submit.prevent="logout">
                                <DropdownMenuItem as="button"
                                    >Log Out</DropdownMenuItem
                                >
                            </form>
                        </DropdownMenuContent>
                    </DropdownMenu>
                    <!-- Team Management -->
                    <DropdownMenu v-if="$page.props.jetstream.hasTeamFeatures">
                        <DropdownMenuTrigger as-child>
                            <Button variant="outline">
                                {{ $page.props.auth.user.current_team.name }}
                                <font-awesome-icon
                                    icon="fa-solid fa-chevron-up"
                                    class="ml-2"
                                />
                            </Button>
                        </DropdownMenuTrigger>

                        <DropdownMenuContent>
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
                                v-if="
                                    $page.props.auth.user.all_teams.length > 1
                                "
                            />
                            <template
                                v-if="
                                    $page.props.auth.user.all_teams.length > 1
                                "
                            >
                                <DropdownMenuLabel
                                    >Switch Teams</DropdownMenuLabel
                                >
                                <template
                                    v-for="team in $page.props.auth.user
                                        .all_teams"
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

            <!-- Main Content -->
            <div class="flex flex-col w-full h-full ml-40 overflow-y-auto">
                <!-- Page Heading -->
                <header
                    v-if="$slots.header"
                    class="bg-white shadow dark:bg-gray-800"
                >
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 w-full h-full overflow-hidden">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
