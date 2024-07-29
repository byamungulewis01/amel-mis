<script setup>
import { ref } from "vue";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";

import { Head, Link, useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Inertia } from "@inertiajs/inertia";
import TablePagination from "@/Components/TablePagination.vue";
const form = useForm({comment: ''});

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

    form.put(route("cashRequest.approve", selected.value), {
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

const rejectClick = (cashrequestId) => {
    selected.value = cashrequestId;
};
const reject = () => {

    form.put(route("cashRequest.reject", selected.value), {
        onSuccess: () => {
            form.reset();
            const closeButton = document.querySelector(
                '.hs-dropdown-toggle[data-hs-overlay="#rejectModal"]'
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
                    class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold"
                >
                    Tenders List
                </h3>
            </div>
            <ol class="flex items-center whitespace-nowrap min-w-0">
                <li class="text-[0.813rem] ps-[0.5rem]">
                    <a
                        class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                        href="javascript:void(0);"
                    >
                        Tenders
                        <i
                            class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"
                        ></i>
                    </a>
                </li>
                <li
                    class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50"
                    aria-current="page"
                >
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
                            <table
                                class="table table-hover whitespace-nowrap min-w-full"
                            >
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
                                    <tr
                                        v-for="(
                                            cashrequest, index
                                        ) in cashrequests.data"
                                        :key="cashrequest.id"
                                        class="border-t hover:bg-gray-200 dark:hover:bg-light"
                                    >
                                        <td>{{ (cashrequests.meta.current_page - 1) *
                                                cashrequests.meta.per_page + index + 1 }}</td>
                                        <td>{{ cashrequest.name }}</td>
                                        <td>
                                            <a
                                                :href="
                                                    '/storage/' +
                                                    cashrequest.purchase_order_file
                                                "
                                                target="_blank"
                                                class="ti-btn !py-1 !px-2 !text-[0.75rem] ti-btn-primary-full btn-wave me-2"
                                            >
                                                <i
                                                    class="ri-download-2-line align-middle inline-block"
                                                ></i
                                                >Purchase Order
                                            </a>

                                            <a
                                                :href="
                                                    '/storage/' +
                                                    cashrequest.estimated_badge_file
                                                "
                                                target="_blank"
                                                class="ti-btn !py-1 !px-2 !text-[0.75rem] ti-btn-success btn-wave"
                                            >
                                                <i
                                                    class="ri-download-2-line align-middle inline-block"
                                                ></i
                                                >Estimate Badget
                                            </a>
                                        </td>
                                        <td>
                                            {{
                                                cashrequest.request_amount.toLocaleString()
                                            }}
                                        </td>
                                        <td>
                                            <span
                                                :class="
                                                    status[cashrequest.status]
                                                        .class
                                                "
                                                >{{
                                                    status[cashrequest.status]
                                                        .title
                                                }}</span
                                            >
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
                                            <Link
                                                :href="
                                                    route(
                                                        'contract.show',
                                                        cashrequest.contract_id
                                                    )
                                                "
                                                class="ti-btn ti-btn-primary-full !py-1 !px-2 !text-[0.75rem] me-1"
                                                >view
                                            </Link>
                                                <button v-if="cashrequest.status === 'requested'"
                                                    type="button"
                                                    aria-label="anchor"
                                                    @click="approvalClick(cashrequest.id)"
                                                    data-hs-overlay="#approvalModel"
                                                    class="ti-btn ti-btn-success-full !py-1 !px-2 !text-[0.75rem] me-1"
                                                >
                                                    Approve
                                                </button>
                                                <button v-if="cashrequest.status === 'requested'"
                                                    type="button"
                                                    aria-label="anchor"
                                                    @click="rejectClick(cashrequest.id)"
                                                    data-hs-overlay="#rejectModal"
                                                    class="ti-btn ti-btn-danger-full !py-1 !px-2 !text-[0.75rem] me-1"
                                                >
                                                    Reject
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

        <!-- Approval Model -->
        <div id="approvalModel" class="hs-overlay hidden ti-modal">
            <div class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out">
                <div class="ti-modal-content">
                    <div class="ti-modal-header">
                        <h6 class="modal-title text-[1rem] font-semibold">
                            Cash Request Approval
                        </h6>
                        <button
                            type="button"
                            class="ti-btn !text-[1rem] !font-semibold !text-defaulttextcolor"
                            data-hs-overlay="#approvalModel"
                        >
                            <span class="sr-only">Close</span>
                            <i class="ri-close-line"></i>
                        </button>
                    </div>
                    <form @submit.prevent="approve">
                        <div class="ti-modal-body">
                            <div class="grid grid-cols-12 gap-4 px-3">
                                <div class="xl:col-span-12 col-span-12">
                                    <label for="comment" class="form-label"
                                        >Comment</label
                                    >
                                    <textarea
                                        placeholder="Provide additional comment"
                                        v-model="form.comment"
                                        class="form-control w-full !rounded-md"
                                        id="comment"
                                    ></textarea>
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.comment"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="ti-modal-footer">
                            <button
                                type="button"
                                class="hs-dropdown-toggle ti-btn ti-btn-secondary-full align-middle"
                                data-hs-overlay="#approvalModel"
                            >
                                Close
                            </button>
                            <PrimaryButton
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Submit
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Reject Model -->
        <div id="rejectModal" class="hs-overlay hidden ti-modal">
            <div class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out">
                <div class="ti-modal-content">
                    <div class="ti-modal-header">
                        <h6 class="modal-title text-[1rem] font-semibold">
                            Cash Request Rejected
                        </h6>
                        <button
                            type="button"
                            class="ti-btn !text-[1rem] !font-semibold !text-defaulttextcolor"
                            data-hs-overlay="#rejectModal"
                        >
                            <span class="sr-only">Close</span>
                            <i class="ri-close-line"></i>
                        </button>
                    </div>
                    <form @submit.prevent="reject">
                        <div class="ti-modal-body">
                            <div class="grid grid-cols-12 gap-4 px-3">
                                <div class="xl:col-span-12 col-span-12">
                                    <label for="comment" class="form-label"
                                        >Comment</label
                                    >
                                    <textarea
                                        placeholder="Cash request reject comment"
                                        v-model="form.comment"
                                        class="form-control w-full !rounded-md"
                                        id="comment"
                                    ></textarea>
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.comment"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="ti-modal-footer">
                            <button
                                type="button"
                                class="hs-dropdown-toggle ti-btn ti-btn-secondary-full align-middle"
                                data-hs-overlay="#rejectModal"
                            >
                                Close
                            </button>
                            <PrimaryButton
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Submit
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
