<template>
    <Head title="Dashboard"/>
    <div class="">
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
            </template>

            <!-- If user is admin, display create user link and users index -->
            <div
                v-if="authIsAdmin"
            >
                <!-- Create user link -->
                <div class="w-full flex justify-end p-5">
                    <NavLink :href="route('user.create')" method="get" as="button" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Create User
                    </NavLink>
                </div>
                <UsersIndex
                    v-for="(user, i) in users"
                    :key="i"
                    :user="user"
                />
            </div>

        </AuthenticatedLayout>
    </div>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UsersIndex from '@/Pages/Resources/UsersIndex.vue';
import NavLink from '@/Components/NavLink.vue';

import { Head } from '@inertiajs/vue3';

const props = defineProps({
    users: Object,
    status: String,
    authIsAdmin: Boolean,
});
</script>
