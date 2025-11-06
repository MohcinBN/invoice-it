<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    invoice: Object,
});

// Initialize form with existing items or empty array
const form = useForm({
    items: props.invoice.items.length > 0 
        ? props.invoice.items.map(item => ({
            id: item.id,
            name: item.name,
            description: item.description,
            number_of_days: item.number_of_days,
            number_of_hours: item.number_of_hours,
            day_rate: item.day_rate,
            details: item.details,
            total_amount: item.total_amount,
        }))
        : [{
            id: null,
            name: '',
            description: '',
            number_of_days: '',
            number_of_hours: '',
            day_rate: '',
            details: '',
            total_amount: 0,
        }],
});

// Add new item
const addItem = () => {
    form.items.push({
        id: null,
        name: '',
        description: '',
        number_of_days: '',
        number_of_hours: '',
        day_rate: '',
        details: '',
        total_amount: 0,
    });
};

// Remove item
const removeItem = (index) => {
    if (form.items.length > 1) {
        form.items.splice(index, 1);
    }
};

// Calculate total amount for an item
const calculateItemTotal = (index) => {
    const item = form.items[index];
    const days = parseFloat(item.number_of_days) || 0;
    const hours = parseFloat(item.number_of_hours) || 0;
    const rate = parseFloat(item.day_rate) || 0;
    
    // Calculate total: (days * rate) + (hours/8 * rate)
    const total = (days * rate) + ((hours / 8) * rate);
    form.items[index].total_amount = total.toFixed(2);
};

// Calculate invoice total
const invoiceTotal = computed(() => {
    return form.items.reduce((sum, item) => {
        return sum + (parseFloat(item.total_amount) || 0);
    }, 0).toFixed(2);
});

// Submit form
const updateItems = () => {
    form.put(route('invoices.items.update', props.invoice.id), {
        preserveScroll: true,
    });
};

// Export PDF
const exportPdf = () => {
    window.open(route('invoices.export.pdf', props.invoice.id), '_blank');
};

// Download PDF
const downloadPdf = () => {
    const link = document.createElement('a');
    link.href = route('invoices.export.pdf', props.invoice.id);
    link.download = `invoice-${props.invoice.invoice_number}.pdf`;
    link.click();
};
</script>

<template>
    <Head title="Edit Invoice Items" />
    
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Success Message -->
                <div v-if="$page.props.flash?.success" class="mb-6">
                    <div class="rounded-md bg-green-50 p-4 border border-green-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
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

                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">
                            Edit Invoice Items
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">
                            Invoice #{{ invoice.invoice_number }} - {{ invoice.client.name }}
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <Link 
                            :href="route('invoices.index')" 
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition"
                        >
                            Back to Invoices
                        </Link>
                        <button
                            @click="exportPdf"
                            type="button"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition flex items-center gap-2"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export PDF
                        </button>
                    </div>
                </div>

                <!-- Invoice Info Card -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Client</p>
                            <p class="font-semibold text-gray-800">{{ invoice.client.name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Invoice Date</p>
                            <p class="font-semibold text-gray-800">{{ invoice.invoice_date }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full"
                                :class="{
                                    'bg-green-100 text-green-800': invoice.status === 'paid',
                                    'bg-yellow-100 text-yellow-800': invoice.status === 'pending',
                                    'bg-blue-100 text-blue-800': invoice.status === 'sent',
                                    'bg-gray-100 text-gray-800': invoice.status === 'draft'
                                }">
                                {{ invoice.status }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form @submit.prevent="updateItems" class="space-y-6">
                    <!-- Items -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Invoice Items</h3>
                            <button
                                @click="addItem"
                                type="button"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm flex items-center gap-2"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Item
                            </button>
                        </div>

                        <!-- Items List -->
                        <div class="space-y-6">
                            <div 
                                v-for="(item, index) in form.items" 
                                :key="index"
                                class="border border-gray-200 rounded-lg p-6 relative"
                            >
                                <!-- Remove Button -->
                                <button
                                    v-if="form.items.length > 1"
                                    @click="removeItem(index)"
                                    type="button"
                                    class="absolute top-4 right-4 text-red-600 hover:text-red-800 transition"
                                    title="Remove item"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Name -->
                                    <div>
                                        <label :for="`item-name-${index}`" class="block text-sm font-medium text-gray-700 mb-1">
                                            Item Name *
                                        </label>
                                        <input
                                            :id="`item-name-${index}`"
                                            v-model="item.name"
                                            type="text"
                                            required
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="e.g., Web Development"
                                        />
                                        <p v-if="form.errors[`items.${index}.name`]" class="mt-1 text-sm text-red-600">
                                            {{ form.errors[`items.${index}.name`] }}
                                        </p>
                                    </div>

                                    <!-- Description -->
                                    <div>
                                        <label :for="`item-description-${index}`" class="block text-sm font-medium text-gray-700 mb-1">
                                            Description *
                                        </label>
                                        <input
                                            :id="`item-description-${index}`"
                                            v-model="item.description"
                                            type="text"
                                            required
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Brief description"
                                        />
                                        <p v-if="form.errors[`items.${index}.description`]" class="mt-1 text-sm text-red-600">
                                            {{ form.errors[`items.${index}.description`] }}
                                        </p>
                                    </div>

                                    <!-- Number of Days -->
                                    <div>
                                        <label :for="`item-days-${index}`" class="block text-sm font-medium text-gray-700 mb-1">
                                            Number of Days *
                                        </label>
                                        <input
                                            :id="`item-days-${index}`"
                                            v-model="item.number_of_days"
                                            @input="calculateItemTotal(index)"
                                            type="text"
                                            required
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="0"
                                        />
                                        <p v-if="form.errors[`items.${index}.number_of_days`]" class="mt-1 text-sm text-red-600">
                                            {{ form.errors[`items.${index}.number_of_days`] }}
                                        </p>
                                    </div>

                                    <!-- Number of Hours -->
                                    <div>
                                        <label :for="`item-hours-${index}`" class="block text-sm font-medium text-gray-700 mb-1">
                                            Number of Hours *
                                        </label>
                                        <input
                                            :id="`item-hours-${index}`"
                                            v-model="item.number_of_hours"
                                            @input="calculateItemTotal(index)"
                                            type="text"
                                            required
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="0"
                                        />
                                        <p v-if="form.errors[`items.${index}.number_of_hours`]" class="mt-1 text-sm text-red-600">
                                            {{ form.errors[`items.${index}.number_of_hours`] }}
                                        </p>
                                    </div>

                                    <!-- Day Rate -->
                                    <div>
                                        <label :for="`item-rate-${index}`" class="block text-sm font-medium text-gray-700 mb-1">
                                            Day Rate ($) *
                                        </label>
                                        <input
                                            :id="`item-rate-${index}`"
                                            v-model="item.day_rate"
                                            @input="calculateItemTotal(index)"
                                            type="text"
                                            required
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="0.00"
                                        />
                                        <p v-if="form.errors[`items.${index}.day_rate`]" class="mt-1 text-sm text-red-600">
                                            {{ form.errors[`items.${index}.day_rate`] }}
                                        </p>
                                    </div>

                                    <!-- Total Amount -->
                                    <div>
                                        <label :for="`item-total-${index}`" class="block text-sm font-medium text-gray-700 mb-1">
                                            Total Amount ($)
                                        </label>
                                        <input
                                            :id="`item-total-${index}`"
                                            v-model="item.total_amount"
                                            type="number"
                                            step="0.01"
                                            required
                                            class="w-full rounded-md border-gray-300 bg-gray-50 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-semibold"
                                            placeholder="0.00"
                                        />
                                        <p v-if="form.errors[`items.${index}.total_amount`]" class="mt-1 text-sm text-red-600">
                                            {{ form.errors[`items.${index}.total_amount`] }}
                                        </p>
                                    </div>

                                    <!-- Details (Full Width) -->
                                    <div class="md:col-span-2">
                                        <label :for="`item-details-${index}`" class="block text-sm font-medium text-gray-700 mb-1">
                                            Additional Details *
                                        </label>
                                        <textarea
                                            :id="`item-details-${index}`"
                                            v-model="item.details"
                                            rows="3"
                                            required
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Additional details about this item..."
                                        ></textarea>
                                        <p v-if="form.errors[`items.${index}.details`]" class="mt-1 text-sm text-red-600">
                                            {{ form.errors[`items.${index}.details`] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Summary -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex justify-between items-center text-lg">
                            <span class="font-semibold text-gray-700">Invoice Total:</span>
                            <span class="text-2xl font-bold text-indigo-600">${{ invoiceTotal }}</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end gap-3">
                        <Link 
                            :href="route('invoices.index')" 
                            class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition"
                        >
                            Cancel
                        </Link>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="form.processing">Saving...</span>
                            <span v-else>Save Items</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Additional custom styles if needed */
</style>
