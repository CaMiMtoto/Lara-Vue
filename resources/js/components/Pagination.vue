<template>
    <nav v-if="links.length > 1" class="flex">

        <ul class="inline-flex -space-x-px">
            <li v-for="(link, i) in links" :key="i">
                <span v-if="!link.url" v-html="link.label"
                      class="px-3 py-2 leading-tight text-gray-400 bg-white border border-gray-300 cursor-default select-none"></span>
                <Link preserve-scroll v-else :href="link.url" :class="[
                          'px-3 py-2 leading-tight border border-gray-300',
                          link.active
                          ? 'z-10 text-blue-600 bg-blue-50 border-blue-300'
                          : 'text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700',
                          'transition-colors duration-150'
                      ]">

                <span v-html="link.label"></span>
                </Link>
            </li>
        </ul>
    </nav>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    links: Array<{
        url: string | null, label: string, active: boolean
    }>
}>();
</script>
