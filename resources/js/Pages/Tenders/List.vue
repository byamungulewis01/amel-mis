<script setup>
import { ref } from 'vue';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';
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


// delete user information
const showDeleteModal = ref(false);
const selectedId = ref(null);


const deleteModel = (user_id) => {
    selectedId.value = user_id;
    showDeleteModal.value = true;
};
const destroyTender = (user_id) => {
    // Assuming selectedUser contains the data of the user being updated
    const form = useForm({});
    form.delete(route('tenders.destroy', user_id), {
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


const props = defineProps({
    tenders: Object,
    tender:Object
});
const tender = props.tender.data;
</script>


<template>

    <Head title="Tenders" />

    <AuthenticatedLayout>
        <!-- Page Header -->
        <div class="block justify-between page-header md:flex"></div>
        <!-- Page Header Close -->

        <div class="grid grid-cols-12">
            <div class="xl:col-span-12 col-span-12">
                <div class="box  overflow-hidden">
                    <div class="box-body !p-0">
                        <div class="table-responsive">

                            <table class="table table-hover whitespace-nowrap min-w-full">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-start">Month</th>
                                        <th scope="col" class="text-start">Number of tenders</th>
                                        <th scope="col" class="text-start">Total Amount</th>
                                        <th scope="col" class="text-start">Amount Used</th>
                                        <th scope="col" class="text-start">Profit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t hover:bg-gray-200 dark:hover:bg-light">
                                        <td>{{ tender.month }}</td>
                                        <td>{{ tender.numberOfTenders }}</td>
                                        <td>{{ tender.totalAmount }}</td>
                                        <td>{{ tender.amountUsed }}</td>
                                        <td>{{ tender.profit }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Start::row-1 -->
        <div class="grid grid-cols-12">
            <div class="xl:col-span-12 col-span-12">
                <div class="box  overflow-hidden">
                    <div class="box-header justify-between">
                        <div class="box-title">
                            All Tenders in {{ tender.month }}
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <Link :href="route('tenders.create', { id: tender.id })"
                                class="ti-btn ti-btn-primary-full !py-1 !px-2 !text-[0.75rem]">
                            <i class="ri-add-line align-middle"></i>New Tender
                            </Link>
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
                                        <th scope="col" class="text-start">Tender Name</th>
                                        <th scope="col" class="text-start">Tender fees</th>
                                        <th scope="col" class="text-start">Bid Security</th>
                                        <th scope="col" class="text-start">Other fees</th>
                                        <th scope="col" class="text-start">Total Amount</th>
                                        <th scope="col" class="text-start">Opening Date</th>
                                        <th scope="col" class="text-start">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(tender, index) in tenders.data" :key="tender.id"
                                        class="border-t hover:bg-gray-200 dark:hover:bg-light">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ tender.tender_name }}</td>
                                        <td>{{ tender.tender_fees.toLocaleString() }}</td>
                                        <td>{{ tender.bid_security.toLocaleString() }}</td>
                                        <td>{{ tender.other_fees.toLocaleString() }}</td>
                                        <td>{{ tender.total_amount.toLocaleString() }}</td>
                                        <td>{{ tender.opening_date }}</td>

                                        <td>
                                            <Link :href="route('tenders.show', tender.id)"
                                                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-primary me-1">
                                            <i class="ri-eye-line"></i>
                                            </Link>
                                            <Link :href="route('tenders.edit', tender.id)"
                                                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-info me-1">
                                            <i class="ri-edit-line"></i>
                                            </Link>
                                            <a aria-label="anchor"
                                                data-hs-overlay="#deleteModel" @click="deleteModel(tender.id)"
                                                href="javascript:void(0);"
                                                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-danger">
                                                <i class="ri-delete-bin-line"></i>
                                            </a>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer border-t-0">
                        <div class="flex items-center flex-wrap overflow-auto">
                            <div class="mb-2 sm:mb-0">
                                Showing <b>1</b> to <b>10</b> of <b>10</b> entries <i
                                    class="bi bi-arrow-right ms-2 font-semibold"></i>
                            </div>
                            <div class="ms-auto">
                                <nav aria-label="Page navigation">
                                    <ul class="ti-pagination  mb-0">
                                        <li class="page-item disabled"><a class="page-link px-3 py-[0.375rem]"
                                                href="javascript:void(0);">Previous</a></li>
                                        <li class="page-item"><a class="page-link active px-3 py-[0.375rem]"
                                                href="javascript:void(0);">1</a></li>
                                        <li class="page-item"><a class="page-link px-3 py-[0.375rem]"
                                                href="javascript:void(0);">2</a></li>
                                        <li class="page-item"><a class="page-link px-3 py-[0.375rem]"
                                                href="javascript:void(0);">Next</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
