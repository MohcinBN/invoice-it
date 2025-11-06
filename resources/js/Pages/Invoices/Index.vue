<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
defineProps({
    invoices: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AuthenticatedLayout>
        <div v-if="$page.props.flash?.success" class="mx-auto max-w-7xl sm:px-6 lg:px-8 pt-6">
            <div class="rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Invoices List
            </h2>
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                <Link :href="route('invoices.create')">
                Create Invoice
                </Link>
            </button>
        </div>

        <div v-if="invoices.data.length" class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8 relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Invoice Number</th>
                        <th scope="col" class="px-6 py-3">Invoice Date</th>
                        <th scope="col" class="px-6 py-3">Date Covered</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="invoice in invoices.data" :key="invoice.id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ invoice.invoice_number }}</td>
                        <td class="px-6 py-4">{{ invoice.invoice_date }}</td>
                        <td class="px-6 py-4">{{ invoice.date_covered_start }} - {{ invoice.date_covered_end }}</td>
                        <td class="px-6 py-4">{{ invoice.status }}</td>
                        <td class="px-6 py-4">{{ invoice.total }}$</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2 flex-wrap">
                                <Link :href="route('invoices.edit', invoice.id)"
                                    class="text-blue-600 hover:text-blue-800 font-medium">
                                    Edit
                                </Link>
                                <Link :href="route('invoices.items.edit', invoice.id)"
                                    class="text-green-600 hover:text-green-800 font-medium">
                                    Edit Items
                                </Link>
                                <Link :href="route('invoices.export.pdf', invoice.id)"
                                    class="text-purple-600 hover:text-purple-800 font-medium"
                                    target="_blank">
                                    Export PDF
                                </Link>
                                <Link :href="route('invoices.remove', invoice.id)" method="delete" as="button"
                                    class="text-red-500 hover:text-red-600 font-medium"
                                    onclick="return confirm('Are you sure you want to remove this invoice?')">
                                    Remove
                                </Link>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination :links="invoices.links" />
        </div>
    </AuthenticatedLayout>
</template>