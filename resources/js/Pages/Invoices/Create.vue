<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    clients: Object,
    authUser: Object,
});

const saveInvoice = () => {
    form.post(route('invoices.store'), {
        onSuccess: () => form.reset(),
    });
};

const form = useForm({
    client_id: '',
    user_id: props.authUser.id,
    invoice_number: '',
    invoice_date: '',
    date_covered_start: '',
    date_covered_end: '',
    status: '',
    total: '',
    template: 'template_1',
});
</script>

<template>
    <Head title="Create Invoice" />

    <AuthenticatedLayout>
        <div class="flex justify-between items-center py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Create Invoice
            </h2>
        </div>
    <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <form class="max-w-2xl mx-auto space-y-4" @submit.prevent="saveInvoice">
            <div>
                <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                <select id="client_id" name="client_id" v-model="form.client_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option v-for="client in props.clients" :key="client.id" :value="client.id">
                        {{ client.name }}
                    </option>
                </select>
                <p v-if="form.errors.client_id" class="mt-2 text-sm text-red-600">{{ form.errors.client_id }}</p>
            </div>
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700">User</label>
                <input type="text" id="user_id" name="user_id" v-model="props.authUser.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm cursor-not-allowed bg-gray-300" disabled/>
                <p v-if="form.errors.user_id" class="mt-2 text-sm text-red-600">{{ form.errors.user_id }}</p>
            </div>
            <div>
                <label for="invoice_number" class="block text-sm font-medium text-gray-700">Invoice Number</label>
                <input type="text" id="invoice_number" name="invoice_number" v-model="form.invoice_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <p v-if="form.errors.invoice_number" class="mt-2 text-sm text-red-600">{{ form.errors.invoice_number }}</p>
            </div>
            <div>
                <label for="invoice_date" class="block text-sm font-medium text-gray-700">Invoice Date</label>
                <input type="date" id="invoice_date" name="invoice_date" v-model="form.invoice_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <p v-if="form.errors.invoice_date" class="mt-2 text-sm text-red-600">{{ form.errors.invoice_date }}</p>
            </div>
            <div>
                <label for="date_covered_start" class="block text-sm font-medium text-gray-700">Date Covered Start</label>
                <input type="date" id="date_covered_start" name="date_covered_start" v-model="form.date_covered_start" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <p v-if="form.errors.date_covered_start" class="mt-2 text-sm text-red-600">{{ form.errors.date_covered_start }}</p>
            </div>
            <div>
                <label for="date_covered_end" class="block text-sm font-medium text-gray-700">Date Covered End</label>
                <input type="date" id="date_covered_end" name="date_covered_end" v-model="form.date_covered_end" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <p v-if="form.errors.date_covered_end" class="mt-2 text-sm text-red-600">{{ form.errors.date_covered_end }}</p>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" v-model="form.status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="pending">Pending</option>
                    <option value="sent">Sent</option>
                    <option value="paid">Paid</option>
                </select>
                <p v-if="form.errors.status" class="mt-2 text-sm text-red-600">{{ form.errors.status }}</p>
            </div>
            <div>
                <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
                <input type="number" id="total" name="total" v-model="form.total" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                <p v-if="form.errors.total" class="mt-2 text-sm text-red-600">{{ form.errors.total }}</p>
            </div>
            <div>
                <label for="template" class="block text-sm font-medium text-gray-700">Template</label>
                <select id="template" name="template" v-model="form.template" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="template_1">Template 1</option>
                    <option value="template_2">Template 2</option>
                </select>
                <p v-if="form.errors.template" class="mt-2 text-sm text-red-600">{{ form.errors.template }}</p>
            </div>
            <button type="submit" :disabled="form.processing" class="mt-4 w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed">
                <span v-if="form.processing">Saving...</span>
                <span v-else>Create Invoice</span>
            </button>
        </form>
    </div>
    </AuthenticatedLayout>
</template>