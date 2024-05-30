<script setup>
import { ref } from 'vue';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';

import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Inertia } from "@inertiajs/inertia";

const status = {
    pending: {
        title: "Pending",
        class: "badge bg-outline-secondary"
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
const form = useForm({
    tender_name: '',
    request_amount: '',
    request_for: '',
    purchase_order: '',
    estimated_badge: '',
});

const submit = () => {
    form.post(route('tenders.store'),
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
// End Storing user information

// Update user information
const showUpdateModal = ref(false);
const selected = ref(null);

const editTender = (tender) => {
    selected.value = { ...tender, request_amount: tender.request_amount.toString() };
    showUpdateModal.value = true;
};
const updateTender = () => {
    const form = useForm({
        tender_name: selected.value.tender_name,
        request_amount: selected.value.request_amount,
        request_for: selected.value.request_for,
        purchase_order: selected.value?.purchase_order,
        estimated_badge: selected.value?.estimated_badge
    });

    Inertia.post(route('tenders.update', selected.value.id), {
        _method: "put",
        tender_name: form.tender_name,
        request_amount: form.request_amount,
        request_for: form.request_for,
        purchase_order: form.purchase_order,
        estimated_badge: form.estimated_badge
    });
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
// view single tender
const viewTenderModel = ref(false);
const selectedTender = ref(null);

const viewTender = (tender) => {
    selectedTender.value = { ...tender
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
                        <div class="flex flex-wrap gap-2">
                            <button data-hs-overlay="#addModel"
                                class="ti-btn ti-btn-primary-full !py-1 !px-2 !text-[0.75rem]">
                                <i class="ri-add-line  align-middle"></i>New Tender
                            </button>
                        </div>

                        <div id="addModel" class="hs-overlay hidden ti-modal">
                            <div
                                class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out lg:!max-w-4xl lg:w-full m-3 lg:!mx-auto">
                                <div class="ti-modal-content">
                                    <div class="ti-modal-header">
                                        <h6 class="modal-title text-[1rem] font-semibold">Tender Registration</h6>
                                        <button type="button"
                                            class="hs-dropdown-toggle !text-[1rem] !font-semibold !text-defaulttextcolor"
                                            data-hs-overlay="#addModel">
                                            <span class="sr-only">Close</span>
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                    <form @submit.prevent="submit">

                                        <div class="ti-modal-body">

                                            <div class="grid grid-cols-12 gap-4 px-3">
                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="purchase_order" class="form-label">Purchase Order
                                                        <span class="text-danger"> (Attachment file)</span></label>
                                                    <input type="file"
                                                        @input="form.purchase_order = $event.target.files[0]"
                                                        id="purchase_order" class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50
                                                        file:border-0
                                                        file:bg-light file:me-4
                                                        file:py-2 file:px-4
                                                        dark:file:bg-black/20 dark:file:text-white/50 cursor-pointer">
                                                    <InputError class="mt-2" :message="form.errors.purchase_order" />

                                                </div>
                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="estimated_badge" class="form-label">Estimate Badget
                                                        <span class="text-danger"> (Attachment file)</span></label>
                                                    <input type="file"
                                                        @input="form.estimated_badge = $event.target.files[0]"
                                                        id="estimated_badge" class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50
                                                        file:border-0
                                                        file:bg-light file:me-4
                                                        file:py-2 file:px-4
                                                        dark:file:bg-black/20 dark:file:text-white/50 cursor-pointer">
                                                    <InputError class="mt-2" :message="form.errors.estimated_badge" />

                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <hr>
                                                    <h5 class="text-center">CASH REQUEST FORM</h5>
                                                </div>

                                                <label for="tender_name"
                                                    class="sm:col-span-2 col-span-12 col-form-label">Tender Name</label>
                                                <div class="sm:col-span-10 col-span-12">
                                                    <div class="input-group">
                                                        <TextInput v-model="form.tender_name" type="text"
                                                            id="tender_name" placeholder="Tender name here" />
                                                        <InputError class="mt-2" :message="form.errors.tender_name" />

                                                    </div>
                                                </div>
                                                <label for="request_for"
                                                    class="sm:col-span-2 col-span-12 col-form-label">Request For</label>
                                                <div class="sm:col-span-10 col-span-12">
                                                    <div class="input-group">
                                                        <textarea v-model="form.request_for" id="request_for"
                                                            class="form-control"
                                                            placeholder="Describe request"></textarea>
                                                        <InputError class="mt-2" :message="form.errors.request_for" />

                                                    </div>
                                                </div>
                                                <label for="request_amount"
                                                    class="sm:col-span-2 col-span-12 col-form-label">Amount</label>
                                                <div class="sm:col-span-10 col-span-12">
                                                    <div class="input-group">
                                                        <TextInput v-model="form.request_amount" type="number" min="0"
                                                            id="request_amount" placeholder="Request Amount" />
                                                        <InputError class="mt-2"
                                                            :message="form.errors.request_amount" />

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
                                                :disabled="form.processing">Save
                                                Changes</PrimaryButton>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div v-if="showUpdateModal" id="editModel" class="hs-overlay hidden ti-modal">
                            <div
                                class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out lg:!max-w-4xl lg:w-full m-3 lg:!mx-auto">
                                <div class="ti-modal-content">
                                    <div class="ti-modal-header">
                                        <h6 class="modal-title text-[1rem] font-semibold">Tender Modification</h6>
                                        <button type="button"
                                            class="hs-dropdown-toggle !text-[1rem] !font-semibold !text-defaulttextcolor"
                                            data-hs-overlay="#editModel">
                                            <span class="sr-only">Close</span>
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                    <form @submit.prevent="updateTender">

                                        <div class="ti-modal-body">

                                            <div class="grid grid-cols-12 gap-4 px-3">
                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="purchase_order" class="form-label">Purchase Order
                                                        <span class="text-danger"> (Attachment file)</span></label>
                                                    <input type="file"
                                                        @input="selected.purchase_order = $event.target.files[0]"
                                                        id="purchase_order" class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50
                                                        file:border-0
                                                        file:bg-light file:me-4
                                                        file:py-2 file:px-4
                                                        dark:file:bg-black/20 dark:file:text-white/50 cursor-pointer">
                                                    <InputError class="mt-2"
                                                        :message="$page.props.errors.purchase_order" />

                                                </div>
                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="estimated_badge" class="form-label">Estimate Badget
                                                        <span class="text-danger"> (Attachment file)</span></label>
                                                    <input type="file"
                                                        @input="selected.estimated_badge = $event.target.files[0]"
                                                        id="estimated_badge" class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50
                                                        file:border-0
                                                        file:bg-light file:me-4
                                                        file:py-2 file:px-4
                                                        dark:file:bg-black/20 dark:file:text-white/50 cursor-pointer">
                                                    <InputError class="mt-2"
                                                        :message="$page.props.errors.estimated_badge" />

                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <hr>
                                                    <h5 class="text-center">CASH REQUEST FORM</h5>
                                                </div>

                                                <label for="tender_name"
                                                    class="sm:col-span-2 col-span-12 col-form-label">Tender Name</label>
                                                <div class="sm:col-span-10 col-span-12">
                                                    <div class="input-group">
                                                        <TextInput v-model="selected.tender_name" type="text"
                                                            id="tender_name" placeholder="Tender name here" />
                                                        <InputError class="mt-2"
                                                            :message="$page.props.errors.tender_name" />

                                                    </div>
                                                </div>
                                                <label for="request_for"
                                                    class="sm:col-span-2 col-span-12 col-form-label">Request For</label>
                                                <div class="sm:col-span-10 col-span-12">
                                                    <div class="input-group">
                                                        <textarea v-model="selected.request_for" id="request_for"
                                                            class="form-control"
                                                            placeholder="Describe request"></textarea>
                                                        <InputError class="mt-2"
                                                            :message="$page.props.errors.request_for" />

                                                    </div>
                                                </div>
                                                <label for="request_amount"
                                                    class="sm:col-span-2 col-span-12 col-form-label">Amount</label>
                                                <div class="sm:col-span-10 col-span-12">
                                                    <div class="input-group">
                                                        <TextInput v-model="selected.request_amount" type="number"
                                                            min="0" id="request_amount" placeholder="Request Amount" />
                                                        <InputError class="mt-2"
                                                            :message="$page.props.errors.request_amount" />

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ti-modal-footer">
                                            <button type="button"
                                                class="hs-dropdown-toggle ti-btn  ti-btn-secondary-full align-middle"
                                                data-hs-overlay="#editModel">
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
                                                    <TextInput disabled v-model="selectedTender.tender_name" type="text" id="name"/>
                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="request_amount" class="form-label">Request Amount</label>
                                                    <TextInput readonly v-model="selectedTender.request_amount" type="text" id="request_amount"/>
                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="request_for" class="form-label">Request For</label>
                                                    <TextInput readonly v-model="selectedTender.request_for" type="text" id="request_for"/>
                                                </div>

                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="sold_amount" class="form-label">Sold Amount</label>
                                                    <TextInput readonly type="number" v-model="selectedTender.sold_amount" id="selling_price"
                                                        required />

                                                </div>
                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="sales_amount" class="form-label">Sales Amount</label>
                                                    <TextInput readonly type="number" v-model="selectedTender.sales_amount" id="sales_amount"
                                                        required />
                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea readonly v-model="selectedTender.description" class="form-control w-full !rounded-md" id="description" rows="2"></textarea>
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
                                        <td>
                                            <a v-if="tenders[tenderKey].status == 'complete'"  @click="viewTender(tenders[tenderKey])" data-hs-overlay="#viewTender" aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-primary me-1">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a v-if="tenders[tenderKey].status == 'pending'"  aria-label="anchor" @click="editTender(tenders[tenderKey])"
                                                data-hs-overlay="#editModel" href="javascript:void(0);"
                                                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-info me-1">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <a v-if="tenders[tenderKey].status == 'pending'" aria-label="anchor" data-hs-overlay="#deleteModel"
                                                @click="deleteModel(tenders[tenderKey].id)" href="javascript:void(0);"
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
