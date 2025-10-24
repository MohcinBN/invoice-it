<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    clients: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="Clients List" />

    <AuthenticatedLayout>
        <div v-if="$page.props.flash?.success" class="mx-auto max-w-7xl sm:px-6 lg:px-8 pt-6">
            <div class="rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            {{ $page.props.flash.success }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-between items-center py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Clients List
            </h2>
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                <Link :href="route('clients.create')">
                    Create Client
                </Link>
            </button>
        </div>
    <div v-if="clients.data.length" class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="client in clients.data" :key="client.id">
                    <td>{{ client.name }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.phone }}</td>
                    <td>{{ client.address }}</td>
                    <td class="flex gap-2">
                        <Link :href="route('clients.edit', client.id)">
                            Edit
                        </Link>
                        <Link
                            :href="route('clients.remove', client.id)"
                            method="delete"
                            as="button"
                            class="text-red-500 hover:text-red-600"
                            onclick="return confirm('Are you sure you want to remove this client?')"
                        >
                            Remove
                        </Link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-else>
        No clients found.
    </div>
    </AuthenticatedLayout>
</template>