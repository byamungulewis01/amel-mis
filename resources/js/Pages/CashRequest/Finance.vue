<script setup>
import { ref } from "vue";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";

import { Head, Link, useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TablePagination from "@/Components/TablePagination.vue";
const form = useForm({ comment: '' });

const status = {
    requested: {
        title: "Requested",
        class: "badge bg-outline-secondary",
    },
    approved: {
        title: "Approved",
        class: "badge bg-outline-primary",
    },
    rejected: {
        title: "Rejected",
        class: "badge bg-outline-success",
    },
};

defineProps({
    cashrequests: Object,
});

// Update user information
const selected = ref('');
const approvalClick = (cashrequestId) => {
    selected.value = cashrequestId;
};
const approve = () => {

    form.put(route("cashRequest.financeApprove", selected.value), {
        onSuccess: () => {
            form.reset();
            const closeButton = document.querySelector(
                '.hs-dropdown-toggle[data-hs-overlay="#approvalModel"]'
            );
            if (closeButton) {
                closeButton.click();
            }
        },
        onError: (errors) => {
            console.log("error", errors);
            // Handle error responses or validation errors
        },
    });
};


</script>

<template>

    <Head title="Cash Requests" />

    <AuthenticatedLayout>
        <!-- Page Header -->
        <div class="block justify-between page-header md:flex">
            <div>
                <h3
                    class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                    Tenders List
                </h3>
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
                <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50"
                    aria-current="page">
                    Tenders List
                </li>
            </ol>
        </div>
        <!-- Page Header Close -->

        <!-- Start::row-1 -->
        <div class="grid grid-cols-12">
            <div class="xl:col-span-12 col-span-12">
                <div class="box overflow-hidden">
                    <div class="box-header justify-between">
                        <div class="box-title">All Cash Requests</div>
                    </div>
                    <div class="box-body !p-0">
                        <div class="table-responsive">
                            <table class="table table-hover whitespace-nowrap min-w-full">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-start">
                                            #
                                        </th>
                                        <th scope="col" class="text-start">
                                            Tender Name
                                        </th>
                                        <th scope="col" class="text-start">
                                            Attachements
                                        </th>
                                        <th scope="col" class="text-start">
                                            Amount
                                        </th>
                                        <th scope="col" class="text-start">
                                            Status
                                        </th>
                                        <th scope="col" class="text-start">
                                            Date
                                        </th>
                                        <th scope="col" class="text-start">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(
                                            cashrequest, index
                                        ) in cashrequests.data" :key="cashrequest.id"
                                        class="border-t hover:bg-gray-200 dark:hover:bg-light">
                                        <td>{{ (cashrequests.meta.current_page - 1) *
                                            cashrequests.meta.per_page + index + 1 }}</td>
                                        <td>{{ cashrequest.name }}</td>
                                        <td>
                                            <a :href="'/storage/' +
                                                cashrequest.purchase_order_file
                                                " target="_blank"
                                                class="ti-btn !py-1 !px-2 !text-[0.75rem] ti-btn-primary-full btn-wave me-2">
                                                <i class="ri-download-2-line align-middle inline-block"></i>Purchase
                                                Order
                                            </a>

                                            <a :href="'/storage/' +
                                                cashrequest.estimated_badge_file
                                                " target="_blank"
                                                class="ti-btn !py-1 !px-2 !text-[0.75rem] ti-btn-success btn-wave">
                                                <i class="ri-download-2-line align-middle inline-block"></i>Estimate
                                                Badget
                                            </a>
                                        </td>
                                        <td>
                                            {{
                                                cashrequest.request_amount.toLocaleString()
                                            }}
                                        </td>
                                        <td>
                                            <span :class="status[cashrequest.status]
                                                .class
                                                ">{{
                                                    status[cashrequest.status]
                                                        .title
                                                }}</span>
                                        </td>

                                        <td>
                                            <i class="bi bi-clock me-1"></i>
                                            {{
                                                new Date(
                                                    cashrequest.created_at
                                                ).toLocaleDateString("en-US", {
                                                    month: "short",
                                                    day: "2-digit",
                                                    year: "numeric",
                                                })
                                            }}
                                        </td>
                                        <td>
                                            <Link :href="route(
                                                'contract.show',
                                                cashrequest.contract_id
                                            )
                                                " class="ti-btn ti-btn-primary-full !py-1 !px-2 !text-[0.75rem] me-1">
                                            view
                                            </Link>
                                            <button v-if="cashrequest.status === 'approved'" type="button"
                                                aria-label="anchor" @click="approvalClick(cashrequest.id)"
                                                data-hs-overlay="#approvalModel"
                                                class="ti-btn ti-btn-success-full !py-1 !px-2 !text-[0.75rem] me-1">
                                                Approve
                                            </button>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <TablePagination :links="cashrequests.meta" />

                </div>
            </div>
        </div>


        <div id="approvalModel" class="hs-overlay hidden ti-modal">
            <div class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out min-h-[calc(100%-3.5rem)] flex items-center">
                <div class="ti-modal-content w-full">

                    <div class="ti-modal-body text-center">
                        <form @submit.prevent="approve()">
                            <div class="text-center px-5 pb-0">
                                <svg class="custom-alert-icon fill-warning inline-flex"
                                    xmlns="http://www.w3.org/2000/svg" height="5rem" viewBox="0 0 24 24" width="5rem"
                                    fill="#000000">
                                    <path d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z">
                                    </path>
                                </svg>
                                <h4 class="text-[1.85rem] !font-medium">Are you sure to approve?</h4>
                                <p class="text-muted">This alert is warn you that action can't be
                                    undone.
                                </p>
                                <div class="mt-4">
                                    <button type="button" data-hs-overlay="#approvalModel"
                                        class="ti-btn !py-2 !px-3 !text-[0.75rem] !font-medium ti-btn-outline-secondary m-1">Back</button>

                                    <button
                                        class="ti-btn !py-2 !px-3 !text-[0.75rem] !font-medium ti-btn-outline-warning m-1">Yes
                                        Approve</button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
