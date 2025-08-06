<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
const step = ref(1);

const initiative = ref('');
const kpis = ref([{ title: '', description: '' }]);
interface Activity {
    kpiIndex: number;
    title: string;
    baseline: number;
    target: number;
    unit: string;
    weight: number;
}
const activities = ref([
    { title: '', baseline: 0, target: 0, unit: '%', weight: 0 },
]);
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <div class="mb-4">
                <div class="mb-2 flex justify-between">
                    <span :class="step >= 1 ? 'font-bold text-blue-600' : ''">Initiative</span>
                    <span :class="step >= 2 ? 'font-bold text-blue-600' : ''">KPIs</span>
                    <span :class="step >= 3 ? 'font-bold text-blue-600' : ''">Activities</span>
                    <span :class="step >= 4 ? 'font-bold text-blue-600' : ''">Review</span>
                </div>
                <div class="h-1 rounded bg-gray-200">
                    <div class="h-1 rounded bg-blue-600 transition-all" :style="{ width: `${(step - 1) * 33}%` }"></div>
                </div>
            </div>

            <!-- Step 1: Initiative -->
            <div v-if="step === 1" class="space-y-4">
                <label class="block text-sm font-medium text-gray-700">Select Initiative</label>
                <input v-model="initiative" type="text" class="w-full rounded border px-3 py-2" placeholder="e.g. Bridge Regulatory Gaps" />
            </div>

            <!-- Step 2: Add KPIs -->
            <div v-if="step === 2">
                <div v-for="(kpi, index) in kpis" :key="index" class="mb-4 space-y-2 border-b pb-3">
                    <input v-model="kpi.title" placeholder="KPI Title" class="w-full rounded border px-2 py-1" />
                    <textarea v-model="kpi.description" placeholder="KPI Description" class="w-full rounded border px-2 py-1"></textarea>
                </div>
                <button class="text-sm text-blue-600" @click="kpis.push({ title: '', description: '' })">+ Add KPI</button>
            </div>

            <!-- Step 3: Add Activities -->
            <div v-if="step === 3">
                <div v-for="(activity, index) in activities" :key="index" class="mb-4 grid grid-cols-2 gap-4 border-b pb-4">
                    <input v-model="activity.title" class="rounded border px-2 py-1" placeholder="Activity Title" />
                    <input v-model.number="activity.baseline" type="number" class="rounded border px-2 py-1" placeholder="Baseline %" />
                    <input v-model.number="activity.target" type="number" class="rounded border px-2 py-1" placeholder="Target %" />
                    <input v-model="activity.unit" class="rounded border px-2 py-1" placeholder="Unit e.g. %" />
                    <input v-model.number="activity.weight" type="number" class="rounded border px-2 py-1" placeholder="Weight %" />
                </div>
                <button class="text-sm text-blue-600" @click="activities.push({ title: '', baseline: 0, target: 0, unit: '%', weight: 0 })">
                    + Add Activity
                </button>
            </div>

            <!-- Step 4: Review -->
            <div v-if="step === 4" class="space-y-4">
                <h3 class="text-lg font-semibold">Initiative: {{ initiative }}</h3>
                <div>
                    <h4 class="font-semibold">KPIs</h4>
                    <ul class="ml-5 list-disc">
                        <li v-for="(kpi, i) in kpis" :key="i">{{ kpi.title }} – {{ kpi.description }}</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold">Activities</h4>
                    <ul class="ml-5 list-disc">
                        <li v-for="(a, i) in activities" :key="i">
                            {{ a.title }} — Baseline: {{ a.baseline }}%, Target: {{ a.target }}%, Unit: {{ a.unit }}, Weight: {{ a.weight }}%
                        </li>
                    </ul>
                </div>
                <button class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Submit</button>
            </div>

            <!-- Navigation -->
            <div class="mt-6 flex justify-between">
                <button @click="step--" :disabled="step === 1" class="rounded bg-gray-200 px-4 py-2">Back</button>
                <button @click="step++" :disabled="step === 4" class="rounded bg-blue-500 px-4 py-2 text-white">Next</button>
            </div>
        </div>
    </AppLayout>
</template>
