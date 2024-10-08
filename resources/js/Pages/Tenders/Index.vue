<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';


import { ref, onMounted } from 'vue';
import TablePagination from '@/Components/TablePagination.vue';

const currentMonth = ref('');
const nextMonth = ref('');

const getMonthNames = () => {
    const now = new Date();
    const currentMonthIndex = now.getMonth(); // Get current month index (0-11)
    const nextMonthIndex = (currentMonthIndex + 1) % 12; // Get next month index (0-11)

    // Use Intl.DateTimeFormat to get month names
    const monthFormatter = new Intl.DateTimeFormat('en-US', { month: 'long' });

    currentMonth.value = monthFormatter.format(new Date(now.getFullYear(), currentMonthIndex));
    nextMonth.value = monthFormatter.format(new Date(now.getFullYear(), nextMonthIndex));
};

onMounted(() => {
    getMonthNames();
});

const status = {
    new: {
        title: "New",
        class: "badge bg-outline-secondary"
    },
    won: {
        title: "Won",
        class: "badge bg-outline-primary"
    },
    lost: {
        title: "Lost",
        class: "badge bg-outline-success"
    },
};
const form = useForm({
    choice: 'currentMonth',
});

const submit = () => {
    form.post(route('monthly-tenders.store'),
        {
            onSuccess: () => {
                form.reset();
                const closeButton = document.querySelector('.hs-dropdown-toggle[data-hs-overlay="#addModel"]');
                if (closeButton) {
                    closeButton.click();
                }

            },
            onError: (errors) => {
                console.log('error', errors);
                // Handle error responses or validation errors
            },
        }
    );
};



// delete user information
const showDeleteModal = ref(false);
const selectedId = ref(null);


const deleteModel = (id) => {
    selectedId.value = id;
    showDeleteModal.value = true;
};
const destroyTender = (id) => {
    // Assuming selectedUser contains the data of the user being updated
    const form = useForm({});
    form.delete(route('monthly-tenders.destroy', id), {
        onSuccess: () => {
            const closeButton = document.querySelector('.ti-btn[data-hs-overlay="#deleteModel"]');
            if (closeButton) {
                closeButton.click();
            }
        },
        onError: (errors) => {
            console.log('error', errors);
            // Handle error responses or validation errors
        },
    });
};


defineProps({
    monthlyTenders: Object,
});
</script>


<template>

    <Head title="Monthly Tenders" />

    <AuthenticatedLayout>
        <!-- Page Header -->
        <div class="block justify-between page-header md:flex">
            <div>
                <h3
                    class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                    Tenders List</h3>
            </div>
            <ol class="flex items-center whitespace-nowrap min-w-0">
                <li class="text-[0.813rem] ps-[0.5rem]">
                    <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                        href="javascript:void(0);">
                        Tenders
                        <i
                            class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"></i>
                    </a>
                </li>
                <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 "
                    aria-current="page">
                    Tenders List
                </li>
            </ol>
        </div>
        <!-- Page Header Close -->

        <!-- Start::row-1 -->
        <div class="grid grid-cols-12">
            <div class="xl:col-span-12 col-span-12">
                <div class="box  overflow-hidden">
                    <div class="box-header justify-between">
                        <div class="box-title">
                            All Tenders List
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button data-hs-overlay="#addModel"
                                class="ti-btn ti-btn-primary-full !py-1 !px-2 !text-[0.75rem]">
                                <i class="ri-add-line  align-middle"></i>New
                            </button>
                        </div>
                        <div id="addModel" class="hs-overlay hidden ti-modal">
                            <div class="hs-overlay-open:mt-7  ti-modal-box mt-0 ease-out">
                                <div class="ti-modal-content">
                                    <div class="ti-modal-header">
                                        <h6 class="modal-title text-[1rem] font-semibold">Monthly Tenders</h6>
                                        <button type="button"
                                            class="ti-btn !text-[1rem] !font-semibold !text-defaulttextcolor"
                                            data-hs-overlay="#addModel">
                                            <span class="sr-only">Close</span>
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                    <form @submit.prevent="submit">
                                        <div class="ti-modal-body">

                                            <div class="grid grid-cols-12 gap-4 px-3">
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="contract_number" class="form-label mb-5">Choose Month
                                                    </label>
                                                    <div class="flex gap-5 mt-3">

                                                        <div class="form-check form-check-lg">
                                                            <input class="form-check-input" v-model="form.choice"
                                                                type="radio" value="currentMonth" id="currentMonth"
                                                                checked>
                                                            <label class="form-check-label" for="currentMonth">
                                                                Current Month ({{ currentMonth }})
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-lg">
                                                            <input class="form-check-input" v-model="form.choice"
                                                                type="radio" value="nextMonth" id="nextMonth">
                                                            <label class="form-check-label" for="nextMonth">
                                                                Next Month ({{ nextMonth }})
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>



                                        </div>
                                        <div class="ti-modal-footer">
                                            <button type="button"
                                                class="hs-dropdown-toggle ti-btn  ti-btn-secondary-full align-middle"
                                                data-hs-overlay="#addModel">
                                                Close
                                            </button>
                                            <PrimaryButton :class="{ 'opacity-25': form.processing }"
                                                :disabled="form.processing">Submit</PrimaryButton>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div v-if="showDeleteModal" id="deleteModel" class="hs-overlay hidden ti-modal">
                            <div
                                class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out min-h-[calc(100%-3.5rem)] flex items-center">
                                <div class="ti-modal-content w-full">

                                    <div class="ti-modal-body text-center">
                                        <form @submit.prevent="destroyTender(selectedId)">
                                            <div class="text-center px-5 pb-0">
                                                <svg class="custom-alert-icon fill-warning inline-flex"
                                                    xmlns="http://www.w3.org/2000/svg" height="5rem" viewBox="0 0 24 24"
                                                    width="5rem" fill="#000000">
                                                    <path d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z">
                                                    </path>
                                                </svg>
                                                <h4 class="text-[1.85rem] !font-medium">Are you sure to remove?</h4>
                                                <p class="text-muted">This alert is warn you that action cannot be
                                                    undone.
                                                </p>
                                                <div class="mt-4">
                                                    <button type="button" data-hs-overlay="#deleteModel"
                                                        class="ti-btn !py-2 !px-3 !text-[0.75rem] !font-medium ti-btn-outline-secondary m-1">Back</button>

                                                    <button
                                                        class="ti-btn !py-2 !px-3 !text-[0.75rem] !font-medium ti-btn-outline-warning m-1">Continue</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="box-body !p-0">
                        <div class="table-responsive">

                            <table class="table table-hover whitespace-nowrap min-w-full">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-start">#</th>
                                        <th scope="col" class="text-start">Month</th>
                                        <th scope="col" class="text-start">Number of tenders</th>
                                        <th scope="col" class="text-start">Total Amount</th>
                                        <th scope="col" class="text-start">Amount Used</th>
                                        <th scope="col" class="text-start">Profit</th>
                                        <th scope="col" class="text-start">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(tender, index) in monthlyTenders.data" :key="tender.id"
                                        class="border-t hover:bg-gray-200 dark:hover:bg-light">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ tender.month }}</td>
                                        <td>{{ tender.numberOfTenders }}</td>
                                        <td>{{ tender.totalAmount.toLocaleString() }}</td>
                                        <td>{{ tender.amountUsed.toLocaleString() }}</td>
                                        <td>{{ tender.profit }}</td>
                                        <td>
                                            <Link :href="route('tenders.index', { id: tender.id })"
                                                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-primary me-1">
                                            <i class="ri-eye-line"></i>
                                            </Link>

                                            <a v-if="$page.props.auth.user.department == 'procurement'" aria-label="anchor" data-hs-overlay="#deleteModel"
                                                @click="deleteModel(tender.id)" href="javascript:void(0);"
                                                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-danger">
                                                <i class="ri-delete-bin-line"></i>
                                            </a>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <TablePagination :links="monthlyTenders.meta" />

                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
