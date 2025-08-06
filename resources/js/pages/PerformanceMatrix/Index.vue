<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Pagination from '@/components/Pagination.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select } from '@/components/ui/select';
import { TextArea } from '@/components/ui/text-area';
import Layout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { initDropdowns, Modal } from 'flowbite';
import { debounce } from 'lodash';
import { EllipsisVerticalIcon, EyeIcon, LoaderCircleIcon, SearchIcon, SquarePenIcon, TrashIcon, XIcon } from 'lucide-vue-next';
import Swal from 'sweetalert2';
import { onBeforeUnmount, onMounted, ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Performance Matrix',
        href: '/dashboard',
    },
];

const isLoading = ref(false);
onMounted(() => {
    initDropdowns();
    router.on('start', () => (isLoading.value = true));
    router.on('finish', () => (isLoading.value = false));
});

onBeforeUnmount(() => {});
const props = defineProps<{
    contracts: any;
    filters: {
        search?: string;
        per_page?: number;
    };
}>();
const filters = ref({
    search: props.filters.search ?? '',
    per_page: props.filters.per_page ?? 10,
});
const handleShowModal = (elementId: string) => {
    const $modalElement = document.querySelector(elementId) as HTMLElement | null;
    const modal = new Modal($modalElement);
    modal.show();
};

const handleCloseModal = (elementId: string) => {
    const $modalElement = document.querySelector(elementId) as HTMLElement | null;
    const modal = new Modal($modalElement);
    modal.hide();
};
const form = useForm({
    title: '',
    description: '',
    start_year: '',
    end_year: '',
});

const submit = () => {
    console.log(form);
    form.post(route('performance.store'), {
        preserveScroll: true,
        onSuccess: () => {
            handleCloseModal('#add_new_modal');
            form.reset();
            form.clearErrors();
        },
        onError: () => {
            console.log('error');
        },
    });
};

/*const handleSearch = () => {
    console.log('search');
    router.get(route('performance.index'), filters.value, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
};*/

function getData() {
    router.get(route('performance.index'), filters.value, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
}

const handleSearch = debounce(() => {
    getData();
}, 600);

const handleDelete = (id: number) => {
    Swal.fire({
        title: 'Are you sure?',
        text: ' You will not be able to recover this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            // Call your delete action
            // Swal.fire('Deleted!', 'Your item has been deleted.', 'success');
            router.delete(route('performance.destroy', id), {
                preserveScroll: true,
                preserveState: true,
                replace: true,
            });
        }
    });
};
</script>

<template>
    <Head title="Performance Matrix" />
    <Layout :breadcrumbs="breadcrumbs">
        <div class="relative overflow-x-auto border border-slate-200 p-4 shadow-xs sm:rounded-lg">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h4 class="text-2xl font-semibold text-gray-800 dark:text-white">Performance Matrix</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">This page will show you the performance matrix of your contracts.</p>
                </div>
                <div>
                    <button type="button" class="btn btn-default" @click="handleShowModal('#add_new_modal')">New Contract</button>
                </div>
            </div>

            <div class="flex-column flex flex-wrap items-center justify-between space-y-4 pb-4 sm:flex-row sm:space-y-0">
                <div>
                    <Select v-model="filters.per_page" @change="getData" class="rounded border px-5 py-2">
                        <option :value="10">10</option>
                        <option :value="20">20</option>
                        <option :value="50">50</option>
                        <option :value="100">100</option>
                    </Select>
                </div>
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3 rtl:right-0">
                        <SearchIcon class="h-5 w-5 text-gray-500 dark:text-gray-400" />
                    </div>
                    <Input
                        type="search"
                        @input="handleSearch"
                        v-model="filters.search"
                        id="table-search"
                        class="block w-80 p-2 ps-10 text-sm"
                        placeholder="Search for items"
                    />
                </div>
            </div>

            <table class="w-full text-left text-gray-600 rtl:text-right dark:text-gray-400" :class="{ 'opacity-50': isLoading }">
                <thead class="bg-gray-50 text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Created At</th>
                        <th scope="col" class="px-6 py-3">Title</th>
                        <th scope="col" class="px-6 py-3">Start Year</th>
                        <th scope="col" class="px-6 py-3">End Year</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Created By</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="contract in contracts.data"
                        :key="contract.id"
                        class="border-b border-gray-200 bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600"
                    >
                        <td class="px-6 py-1">{{ $formatDate(contract.created_at, 'MMM,DD - YYYY hh:mm A') }}</td>
                        <td class="px-6 py-1">{{ contract.title }}</td>
                        <td class="px-6 py-1">{{ contract.start_year }}</td>
                        <td class="px-6 py-1">{{ contract.end_year }}</td>
                        <td class="px-6 py-1">
                            <span class="inline-flex rounded-full px-2 text-xs leading-5 font-medium capitalize" :class="contract.status_color">
                                {{ contract.status }}
                            </span>
                        </td>
                        <td class="px-6 py-1">{{ contract.created_by?.name }}</td>
                        <td class="px-6 py-1">
                            <div>
                                <Button
                                    variant="ghost"
                                    :id="`dropdownRadioButton-${contract.id}`"
                                    :data-dropdown-toggle="`dropdownRadio-${contract.id}`"
                                    type="button"
                                >
                                    <EllipsisVerticalIcon class="h-5 w-5" aria-hidden="true" />
                                </Button>
                                <!-- Dropdown menu -->
                                <div
                                    :id="`dropdownRadio-${contract.id}`"
                                    class="z-10 hidden w-48 divide-y divide-gray-100 rounded-lg border border-gray-200 bg-white shadow-sm dark:divide-gray-600 dark:bg-gray-700"
                                    data-popper-placement="top"
                                    style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(522.5px, 3847.5px, 0px)"
                                >
                                    <ul class="space-y-1 p-3 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioButton">
                                        <li>
                                            <a href="#" class="dropdown-item">
                                                <EyeIcon class="h-5 w-5" aria-hidden="true" />
                                                View
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item">
                                                <SquarePenIcon class="h-5 w-5" aria-hidden="true" />
                                                Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" @click.prevent="handleDelete(contract.id)" class="dropdown-item">
                                                <TrashIcon class="h-5 w-5" aria-hidden="true" />
                                                Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr
                        v-if="contracts.data.length === 0"
                        class="bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600"
                    >
                        <td colspan="8" class="p-4">
                            <p class="text-center text-gray-500 dark:text-gray-400">
                                No data found, try to change the filters or search for something else.
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-4 flex justify-between" v-if="contracts.data.length > 0">
                <div>
                    <p>Showing {{ contracts.from }} to {{ contracts.to }} of {{ contracts.total }} results</p>
                </div>
                <Pagination :links="contracts.links" />
            </div>
        </div>

        <!-- Default Modal -->
        <div
            id="add_new_modal"
            tabindex="-1"
            class="fixed top-0 right-0 left-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-x-hidden overflow-y-auto p-4 md:inset-0"
        >
            <div class="relative max-h-full w-full max-w-lg">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b border-gray-200 p-4 md:p-5 dark:border-gray-600">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">New Contract</h3>
                        <button
                            type="button"
                            @click="handleCloseModal('#add_new_modal')"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="medium-modal"
                        >
                            <XIcon class="h-5 w-5" aria-hidden="true" />
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form @submit.prevent="submit">
                        <!-- Modal body -->
                        <div class="space-y-4 p-4 md:p-5">
                            <div class="grid gap-2">
                                <Label for="title">Title</Label>
                                <Input id="title" v-model="form.title" class="mt-1 block w-full" />
                                <InputError :message="form.errors.title" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="startYear">Start Year</Label>
                                <Input type="number" v-model="form.start_year" id="startYear" class="mt-1 block w-full" />
                                <InputError :message="form.errors.start_year" />
                            </div>
                            <div class="grid gap-2">
                                <Label for="endYear">End Year</Label>
                                <Input type="number" v-model="form.end_year" id="endYear" class="mt-1 block w-full" placeholder="" />
                                <InputError :message="form.errors.end_year" />
                            </div>
                            <div class="grid gap-2">
                                <Label for="description">Description</Label>
                                <TextArea id="description" v-model="form.description" class="mt-1 block w-full" />
                                <InputError :message="form.errors.description" />
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div
                            class="flex items-center justify-end gap-3 rounded-b border-t border-gray-200 bg-gray-50 p-4 md:p-5 dark:border-gray-600"
                        >
                            <Button variant="default" :disabled="form.processing" type="submit">
                                <LoaderCircleIcon v-if="form.processing" class="h-5 w-5 animate-spin" aria-hidden="true" />
                                Save Changes
                            </Button>
                            <Button variant="outline" type="button" @click="handleCloseModal('#add_new_modal')">Close </Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>
