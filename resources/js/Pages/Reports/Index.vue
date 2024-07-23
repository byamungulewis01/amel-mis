<script setup>
import { ref } from 'vue';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';

const status = {
    sent: {
        title: "Submitted",
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

// delete user information
const showDeleteModal = ref(false);
const selectedId = ref(null);


const deleteModel = (report_id) => {
    selectedId.value = report_id;
    showDeleteModal.value = true;
};
const destroyReport = (report_id) => {
    // Assuming selectedUser contains the data of the user being updated
    const form = useForm({});
    form.delete(route('weekly-reports.destroy', report_id), {
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
    reports: Object,
});
</script>


<template>

    <Head title="Reports" />

    <AuthenticatedLayout>
        <!-- Page Header -->
        <div class="block justify-between page-header md:flex">
            <div>
                <h3
                    class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                    Reports</h3>
            </div>
            <ol class="flex items-center whitespace-nowrap min-w-0">
                <li class="text-[0.813rem] ps-[0.5rem]">
                    <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                        href="javascript:void(0);">
                        Weekly Work
                        <i
                            class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"></i>
                    </a>
                </li>
                <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 "
                    aria-current="page">
                    Reports
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
                            WEEKLY WORK REPORT
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <Link :href="route('weekly-reports.create')"
                                class="ti-btn ti-btn-primary-full !py-1 !px-2 !text-[0.75rem]">
                            <i class="ri-add-line align-middle"></i>Report
                            </Link>
                        </div>

                    </div>
                    <div class="box-body !p-0">
                        <div class="table-responsive">

                            <table class="table table-hover whitespace-nowrap min-w-full">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-start">#</th>
                                        <th scope="col" class="text-start">Week</th>
                                        <th scope="col" class="text-start">Date from</th>
                                        <th scope="col" class="text-start">Date to</th>
                                        <th scope="col" class="text-start">Cash used</th>
                                        <th scope="col" class="text-start">Status</th>
                                        <th scope="col" class="text-start">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(report, index) in reports" :key="index"
                                        class="border-t hover:bg-gray-200 dark:hover:bg-light">
                                        <td>{{ index + 1 }}</td>
                                        <td><span class="font-bold">Week {{ report.week_number }}
                                                Report</span></td>
                                        <td><i class="bi bi-clock me-1"></i>{{ report.date_from }}</td>
                                        <td><i class="bi bi-clock me-1"></i>{{ report.date_to }}</td>
                                        <td>{{ report.used_money.toLocaleString() }}</td>
                                        <td><span :class="status[report.status].class">{{
                                            status[report.status].title }}</span></td>

                                        <td>
                                            <Link aria-label="anchor"
                                                :href="route('weekly-reports.show', report.id)"
                                                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-success me-1">
                                            <i class="ri-eye-line"></i>
                                            </Link>
                                            <Link v-if="report.status == 'sent'" aria-label="anchor"
                                                :href="route('weekly-reports.edit', report.id)"
                                                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-info me-1">
                                            <i class="ri-edit-line"></i>
                                            </Link>
                                            <a v-if="report.status == 'sent'" @click="deleteModel(report.id)"
                                                aria-label="anchor" data-hs-overlay="#deleteModel"
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


        <div v-if="showDeleteModal" id="deleteModel" class="hs-overlay hidden ti-modal">
            <div class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out min-h-[calc(100%-3.5rem)] flex items-center">
                <div class="ti-modal-content w-full">

                    <div class="ti-modal-body text-center">
                        <form @submit.prevent="destroyReport(selectedId)">
                            <div class="text-center px-5 pb-0">
                                <svg class="custom-alert-icon fill-warning inline-flex"
                                    xmlns="http://www.w3.org/2000/svg" height="5rem" viewBox="0 0 24 24" width="5rem"
                                    fill="#000000">
                                    <path d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z">
                                    </path>
                                </svg>
                                <h4 class="text-[1.85rem] !font-medium">Are you sure to remove?</h4>
                                <p class="text-muted">This alert is warn you that action cannot be undone.</p>
                                <div class="mt-4">
                                    <button type="button" data-hs-overlay="#deleteModel"
                                        class="ti-btn !py-1 !px-2 !text-[0.75rem] !font-medium ti-btn-outline-secondary m-1">Back</button>
                                    <button
                                        class="ti-btn !py-1 !px-2 !text-[0.75rem] !font-medium bg-warning text-white m-1">Continue</button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>



    </AuthenticatedLayout>
</template>
