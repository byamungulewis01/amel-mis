<script setup>
import { ref } from 'vue';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Inertia } from "@inertiajs/inertia";

const status = {
    requested: {
        title: "Requested",
        class: "badge bg-outline-secondary"
    },
    approved: {
        title: "Approved",
        class: "badge bg-outline-primary"
    },
    rejected: {
        title: "Rejected",
        class: "badge bg-outline-success"
    },
};

defineProps({
    cashrequests: Object,
});
</script>


<template>

    <Head title="Cash Requests" />

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
                            All Cash Requests
                        </div>
                    </div>
                    <div class="box-body !p-0">
                        <div class="table-responsive">

                            <table class="table table-hover whitespace-nowrap min-w-full">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-start">#</th>
                                        <th scope="col" class="text-start">Tender Name</th>
                                        <th scope="col" class="text-start">Attachements</th>
                                        <th scope="col" class="text-start">Amount</th>
                                        <th scope="col" class="text-start">Status</th>
                                        <th scope="col" class="text-start">Date</th>
                                        <th scope="col" class="text-start">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(cashrequest, index) in cashrequests.data" :key="cashrequest.id"
                                        class="border-t hover:bg-gray-200 dark:hover:bg-light">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ cashrequest.tender_name }}</td>
                                        <td>
                                            <a :href="'/storage/' + cashrequest.purchase_order_file" target="_blank"
                                                class="ti-btn !py-1 !px-2 !text-[0.75rem] ti-btn-primary-full btn-wave me-2">
                                                <i class="ri-download-2-line align-middle inline-block"></i>Purchase
                                                Order

                                            </a>


                                            <a :href="'/storage/' + cashrequest.estimated_badge_file" target="_blank"
                                                class="ti-btn !py-1 !px-2 !text-[0.75rem] ti-btn-success btn-wave">
                                                <i class="ri-download-2-line align-middle inline-block"></i>Estimate
                                                Badget

                                            </a>
                                        </td>
                                        <td>{{ cashrequest.request_amount.toLocaleString() }}</td>
                                        <td><span :class="status[cashrequest.status].class">{{
                                            status[cashrequest.status].title }}</span></td>


                                        <td><i class="bi bi-clock me-1"></i>
                                            {{ new
                                                Date(cashrequest.created_at).toLocaleDateString('en-US', {
                                                    month: 'short', day:
                                                        '2-digit', year: 'numeric'
                                                }) }}
                                        </td>
                                        <td>
                                            <Link :href="route('tenders.show', cashrequest.tender_id)"
                                                class="ti-btn ti-btn-primary me-1">
                                            <i class="ri-eye-line"></i> view
                                            </Link>

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
