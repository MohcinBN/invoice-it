<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div>
        <nav class="flex justify-between">
            <div class="flex-1">
                <ul class="flex items-center">
                    <li v-for="link in links" :key="link.id">
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            class="px-4 py-2"
                        >
                            {{ link.label }}
                        </Link>
                        <span v-else class="px-4 py-2">
                            {{ link.label }}
                        </span>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>