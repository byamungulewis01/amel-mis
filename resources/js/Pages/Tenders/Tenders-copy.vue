<script setup>
import { ref } from 'vue';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';

import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const status = {
    pending: {
        title: "Pending",
        class: "badge bg-outline-warning"
    },
    in_progress: {
        title: "Inprogress",
        class: "badge bg-outline-primary"
    },
    complete: {
        title: "Completed",
        class: "badge bg-outline-success"
    },
};

// store user into database
const form = useForm({});

// Update user information
const showClosingModal = ref(false);
const selectedTender = ref(null);

const closeTender = (tender) => {
    selectedTender.value = { ...tender
        ,sold_amount: ''
        ,sales_amount: ''
        ,description: ''
      }; // Create a copy to avoid modifying the original user data
    showClosingModal.value = true;
};
const tenderClosing = () => {
    // Assuming selectedTender contains the data of the user being updated
    const form = useForm({
        tender_name: selectedTender.value.tender_name,
        sold_amount: selectedTender.value.sold_amount,
        sales_amount: selectedTender.value.sales_amount,
        description: selectedTender.value.description,
    });
    form.put(route('tenders.closing', selectedTender.value.id), {
        onSuccess: () => {
            form.reset();
            const closeButton = document.querySelector('.hs-dropdown-toggle[data-hs-overlay="#showClosingModal"]');
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


// delete user information
const showApprovalModal = ref(false);
const selectedId = ref(null);


const tenderInstance = (tender_id) => {
    selectedId.value = tender_id;
    showApprovalModal.value = true;
};
const approveTender = (tender_id) => {
    // Assuming selectedTender contains the data of the user being updated
    const form = useForm({});
    form.put(route('tenders.approve', tender_id), {
        onSuccess: () => {
            const closeButton = document.querySelector('.ti-btn[data-hs-overlay="#approveModel"]');
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


// view model

// Update user information
const viewTenderModel = ref(false);
const selected = ref(null);

const viewTender = (tender) => {
    selected.value = { ...tender
        , request_amount: tender.request_amount.toString()
        ,sold_amount:  tender.sold_amount.toString()
        ,sales_amount:  tender.sales_amount.toString()
      }; // Create a copy to avoid modifying the original user data
      viewTenderModel.value = true;
};

defineProps({
    tenders: Object,
});
</script>


<template>

    <Head title="Tenders" />

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

                        <div v-if="showApprovalModal" id="approveModel" class="hs-overlay hidden ti-modal">
                            <div
                                class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out min-h-[calc(100%-3.5rem)] flex items-center">
                                <div class="ti-modal-content w-full">

                                    <div class="ti-modal-body text-center">
                                        <form @submit.prevent="approveTender(selectedId)">
                                            <div class="text-center px-5 pb-0">
                                                <svg class="custom-alert-icon fill-warning inline-flex"
                                                    xmlns="http://www.w3.org/2000/svg" height="5rem" viewBox="0 0 24 24"
                                                    width="5rem" fill="#000000">
                                                    <path d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z">
                                                    </path>
                                                </svg>
                                                <h4 class="text-[1.85rem] !font-medium">Are you sure to approve?</h4>
                                                <p class="text-muted">This alert is warn you that action can't be
                                                    undone.
                                                </p>
                                                <div class="mt-4">
                                                    <button type="button" data-hs-overlay="#approveModel"
                                                        class="ti-btn !py-2 !px-3 !text-[0.75rem] !font-medium ti-btn-outline-secondary m-1">Back</button>

                                                    <button
                                                        class="ti-btn !py-2 !px-3 !text-[0.75rem] !font-medium ti-btn-outline-warning m-1">Yes Approve</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div v-if="showClosingModal" id="showClosingModal" class="hs-overlay hidden ti-modal">
                            <div class="hs-overlay-open:mt-7  ti-modal-box mt-0 ease-out">
                                <div class="ti-modal-content">
                                    <div class="ti-modal-header">
                                        <h6 class="modal-title text-[1rem] font-semibold">Closing Tender</h6>
                                        <button type="button"
                                            class="hs-dropdown-toggle !text-[1rem] !font-semibold !text-defaulttextcolor"
                                            data-hs-overlay="#showClosingModal">
                                            <span class="sr-only">Close</span>
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                    <form @submit.prevent="tenderClosing">
                                        <div class="ti-modal-body">

                                            <div class="grid grid-cols-12 gap-4 px-3">
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="name" class="form-label">Tender Name</label>
                                                    <TextInput disabled v-model="selectedTender.tender_name" type="text" id="name" />
                                                </div>

                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="sold_amount" class="form-label">Sold Amount</label>
                                                    <TextInput placeholder="10,000" min="0" type="number" v-model="selectedTender.sold_amount" id="selling_price"
                                                        required />
                                                    <InputError class="mt-2" :message="$page.props.errors.sold_amount" />
                                                </div>
                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="sales_amount" class="form-label">Sales Amount</label>
                                                    <TextInput placeholder="10,000" min="0" type="number" v-model="selectedTender.sales_amount" id="sales_amount"
                                                        required />
                                                    <InputError class="mt-2" :message="$page.props.errors.sales_amount" />
                                                </div>

                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea  v-model="selectedTender.description" class="form-control w-full !rounded-md" placeholder="Description" id="description" rows="2"></textarea>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="ti-modal-footer">
                                            <button type="button"
                                                class="hs-dropdown-toggle ti-btn  ti-btn-secondary-full align-middle"
                                                data-hs-overlay="#showClosingModal">
                                                Close
                                            </button>
                                            <PrimaryButton :class="{ 'opacity-25': form.processing }"
                                                :disabled="form.processing">Save
                                                Changes</PrimaryButton>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div v-if="viewTenderModel" id="viewTender" class="hs-overlay hidden ti-modal">
                            <div class="hs-overlay-open:mt-7  ti-modal-box mt-0 ease-out">
                                <div class="ti-modal-content">
                                    <div class="ti-modal-header">
                                        <h6 class="modal-title text-[1rem] font-semibold">Tender Details</h6>
                                        <button type="button"
                                            class="hs-dropdown-toggle !text-[1rem] !font-semibold !text-defaulttextcolor"
                                            data-hs-overlay="#viewTender">
                                            <span class="sr-only">Close</span>
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                        <div class="ti-modal-body">

                                            <div class="grid grid-cols-12 gap-4 px-3">
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="name" class="form-label">Tender Name</label>
                                                    <TextInput disabled v-model="selected.tender_name" type="text" id="name"/>
                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="request_amount" class="form-label">Request Amount</label>
                                                    <TextInput readonly v-model="selected.request_amount" type="text" id="request_amount"/>
                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="request_for" class="form-label">Request For</label>
                                                    <TextInput readonly v-model="selected.request_for" type="text" id="request_for"/>
                                                </div>

                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="sold_amount" class="form-label">Sold Amount</label>
                                                    <TextInput readonly type="number" v-model="selected.sold_amount" id="selling_price"
                                                        required />

                                                </div>
                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="sales_amount" class="form-label">Sales Amount</label>
                                                    <TextInput readonly type="number" v-model="selected.sales_amount" id="sales_amount"
                                                        required />
                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea readonly v-model="selected.description" class="form-control w-full !rounded-md" id="description" rows="2"></textarea>
                                                </div>

                                            </div>

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
                                        <th scope="col" class="text-start">Attachements</th>
                                        <th scope="col" class="text-start">Amount</th>
                                        <th scope="col" class="text-start">Status</th>
                                        <th scope="col" class="text-start">Date</th>
                                        <th scope="col" class="text-start">Request By</th>
                                        <th scope="col" class="text-start">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(tenderKey, index) in Object.keys(tenders)" :key="index"
                                        class="border-t hover:bg-gray-200 dark:hover:bg-light">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ tenders[tenderKey].tender_name }}</td>
                                        <td>
                                            <a :href="'storage/' + tenders[tenderKey].purchase_order_file"
                                                target="_blank"
                                                class="ti-btn !py-1 !px-2 !text-[0.75rem] ti-btn-primary-full btn-wave me-2">
                                                <i class="ri-download-2-line align-middle inline-block"></i>Purchase
                                                Order

                                            </a>

                                            <a :href="'storage/' + tenders[tenderKey].estimated_badge_file"
                                                target="_blank"
                                                class="ti-btn !py-1 !px-2 !text-[0.75rem] ti-btn-success btn-wave">
                                                <i class="ri-download-2-line align-middle inline-block"></i>Estimate
                                                Badget

                                            </a>
                                        </td>
                                        <td>{{ tenders[tenderKey].request_amount.toLocaleString() }}</td>
                                        <td>
                                        <td><span :class="status[tenders[tenderKey].status].class">{{
                                                status[tenders[tenderKey].status].title }}</span></td>
                                        </td>


                                        <td><i class="bi bi-clock me-1"></i>
                                            {{ new
                                                Date(tenders[tenderKey].created_at).toLocaleDateString('en-US', {
                                                    month: 'short', day:
                                                        '2-digit', year: 'numeric'
                                                }) }}
                                        </td>
                                        <td>{{ tenders[tenderKey].user.name }}</td>
                                        <td>
                                            <button v-if="tenders[tenderKey].status == 'pending'"  @click="tenderInstance(tenders[tenderKey].id)"  data-hs-overlay="#approveModel" type="button" class="ti-btn ti-btn-warning-full !py-1 !px-2 !text-[0.75rem]">Approve</button>
                                            <button v-if="tenders[tenderKey].status == 'in_progress'" @click="closeTender(tenders[tenderKey])" data-hs-overlay="#showClosingModal" type="button" class="ti-btn ti-btn-primary-full !py-1 !px-2 !text-[0.75rem]">Closing</button>
                                            <button v-if="tenders[tenderKey].status == 'complete'" @click="viewTender(tenders[tenderKey])" data-hs-overlay="#viewTender" type="button" class="ti-btn ti-btn-success-full !py-1 !px-2 !text-[0.75rem]">View</button>

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
