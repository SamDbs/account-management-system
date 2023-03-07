<template>
    <Head title="Dashboard"/>
    <div class="">
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">You're logged in!</div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
        <UsersIndex
            v-for="(user, i) in users"
            :key="i"
            :user="user"
        />
    </div>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UsersIndex from '@/Pages/Resources/UsersIndex.vue';

import { Head } from '@inertiajs/vue3';

const props = defineProps({
    users: {
        type: Object,
        default: () => ({}),
    },
    status: {
        type: String,
        default: '',
    }
});
</script>
