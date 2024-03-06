<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    links: {
        type: Array,
    },
});
</script>

<template>
    <nav aria-label="Page navigation example">
        <ul class="flex items-center -space-x-px h-8 text-sm">
            <li v-for="link in links">
                <Link
                    :href="link.url?link.url:'#'"
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700"
                    :class="{'z-10 flex items-center justify-center px-3 h-8 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700': link.active }"
                    v-html="link.label"
                >
                </Link >
            </li>
        </ul>
    </nav>
</template>
