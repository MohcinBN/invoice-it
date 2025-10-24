<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    address: '',
});

const saveClient = () => {
    form.post(route('clients.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Create Client" />

    <AuthenticatedLayout>
        <div class="flex justify-between items-center py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Create Client
            </h2>
        </div>
    <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <form class="max-w-2xl mx-auto space-y-4" @submit.prevent="saveClient">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" v-model="form.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <p v-if="form.errors.name" class="mt-2 text-sm text-red-600">{{ form.errors.name }}</p>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" v-model="form.email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email }}</p>
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="tel" id="phone" name="phone" v-model="form.phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <p v-if="form.errors.phone" class="mt-2 text-sm text-red-600">{{ form.errors.phone }}</p>
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" id="address" name="address" v-model="form.address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <p v-if="form.errors.address" class="mt-2 text-sm text-red-600">{{ form.errors.address }}</p>
            </div>
            <button type="submit" :disabled="form.processing" class="mt-4 w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed">
                <span v-if="form.processing">Saving...</span>
                <span v-else>Create Client</span>
            </button>
        </form>
    </div>
    </AuthenticatedLayout>
</template>