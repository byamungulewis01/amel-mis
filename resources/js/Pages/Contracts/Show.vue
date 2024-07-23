<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    contract: Object,
    cashrequests: Object,
});
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

// store user into database
const form = useForm({
    request_amount: '',
    request_for: '',
    purchase_order: '',
    estimated_badge: '',
});

const submit = () => {
    form.post(route('tender.cashRequest', contract.id),
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

    Inertia.post(route('tender.cashRequestUpdate', selected.value.id), {
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


const deleteModel = (tenderId) => {
    selectedId.value = tenderId;
    showDeleteModal.value = true;
};
const destroyTender = (tenderId) => {
    // Assuming selectedUser contains the data of the user being updated
    const form = useForm({});
    form.delete(route('tender.cashRequestDelete', tenderId), {
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
    selectedTender.value = {
        ...tender
        , request_amount: tender.request_amount.toString()
    }; // Create a copy to avoid modifying the original user data
    viewTenderModel.value = true;
};


</script>


<template>

    <Head title="Tenders" />

    <AuthenticatedLayout>
        <!-- Page Header -->
        <div class="block justify-between page-header md:flex"></div>
        <!-- Page Header Close -->

        <div class="grid grid-cols-12 gap-6">
            <div class="xl:col-span-9 col-span-12">
                <div class="box">
                    <div class="box-header justify-between">
                        <div class="box-title">Tender Summary</div>

                    </div>
                    <div class="box-body">
                        <h5 class="font-semibold mb-4 task-title text-[1.25rem]">
                            {{ contract.name }}
                        </h5>
                        <div class="text-[.9375rem] font-semibold mb-2">Tender Description :</div>
                        <p class="text-[#8c9097] dark:text-white/50 task-description">{{ contract.description }}</p>

                    </div>

                </div>
                <div class="box">
                    <div class="box-header justify-between">
                        <div class="box-title">Cash Requests</div>
                        <div v-if="$page.props.auth.user.department == 'field'" class="flex flex-wrap gap-2">
                            <button data-hs-overlay="#addModel"
                                class="ti-btn ti-btn-primary-full !py-1 !px-2 !text-[0.75rem]">
                                <i class="ri-add-line  align-middle"></i>New Request
                            </button>

                        </div>
                    </div>
                    <div class="box-body text-defaulttextcolor text-defaultsize">
                        <div class="table-responsive">

                            <table class="table table-hover whitespace-nowrap min-w-full">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-start">#</th>
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

                                            <div v-if="cashrequest.status == 'requested'">

                                                <a aria-label="anchor" @click="editTender(cashrequest)"
                                                    data-hs-overlay="#editModel" href="javascript:void(0);"
                                                    class="ti-btn ti-btn-icon ti-btn-sm ti-btn-info me-1">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <a aria-label="anchor" data-hs-overlay="#deleteModel"
                                                    @click="deleteModel(cashrequest.id)" href="javascript:void(0);"
                                                    class="ti-btn ti-btn-icon ti-btn-sm ti-btn-danger">
                                                    <i class="ri-delete-bin-line"></i>
                                                </a>
                                            </div>
                                            <a v-else @click="viewTender(cashrequest)" data-hs-overlay="#viewTender"
                                                aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn ti-btn-primary me-1">
                                                <i class="ri-eye-line"></i> view
                                            </a>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Models Request Cash -->
        <div id="addModel" class="hs-overlay hidden ti-modal">
            <div class="hs-overlay-open:mt-7  ti-modal-box mt-0 ease-out">
                <div class="ti-modal-content">
                    <div class="ti-modal-header">
                        <h6 class="modal-title text-[1rem] font-semibold">Cash Request Form</h6>
                        <button type="button" class="ti-btn !text-[1rem] !font-semibold !text-defaulttextcolor"
                            data-hs-overlay="#addModel">
                            <span class="sr-only">Close</span>
                            <i class="ri-close-line"></i>
                        </button>
                    </div>
                    <form @submit.prevent="submit">
                        <div class="ti-modal-body">

                            <div class="grid grid-cols-12 gap-4 px-3">
                                <div class="xl:col-span-12 col-span-12">
                                    <label for="request_amount" class="form-label">Amount</label>
                                    <TextInput v-model="form.request_amount" type="number" id="request_amount" required
                                        placeholder="Cash Request" />
                                    <InputError class="mt-2" :message="form.errors.request_amount" />

                                </div>
                                <div class="xl:col-span-12 col-span-12">
                                    <label for="request_for" class="form-label">Request for</label>
                                    <textarea placeholder="Description" v-model="form.request_for"
                                        class="form-control w-full !rounded-md" id="request_for"></textarea>
                                    <InputError class="mt-2" :message="form.errors.request_for" />

                                </div>
                                <div class="xl:col-span-12 col-span-12">
                                    <label for="purchase_order" class="form-label">Purchase Order
                                        <span class="text-danger"> (Attachment file)</span></label>
                                    <input type="file" @input="form.purchase_order = $event.target.files[0]"
                                        id="purchase_order" class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50
                                                        file:border-0
                                                        file:bg-light file:me-4
                                                        file:py-2 file:px-4
                                                        dark:file:bg-black/20 dark:file:text-white/50 cursor-pointer">
                                    <InputError class="mt-2" :message="form.errors.purchase_order" />

                                </div>
                                <div class="xl:col-span-12 col-span-12">
                                    <label for="estimated_badge" class="form-label">Estimate Badget
                                        <span class="text-danger"> (Attachment file)</span></label>
                                    <input type="file" @input="form.estimated_badge = $event.target.files[0]"
                                        id="estimated_badge" class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50
                                                        file:border-0
                                                        file:bg-light file:me-4
                                                        file:py-2 file:px-4
                                                        dark:file:bg-black/20 dark:file:text-white/50 cursor-pointer">
                                    <InputError class="mt-2" :message="form.errors.estimated_badge" />

                                </div>

                            </div>
                        </div>
                        <div class="ti-modal-footer">
                            <button type="button" class="hs-dropdown-toggle ti-btn  ti-btn-secondary-full align-middle"
                                data-hs-overlay="#addModel">
                                Close
                            </button>
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Submit
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div v-if="showUpdateModal" id="editModel" class="hs-overlay hidden ti-modal">
            <div class="hs-overlay-open:mt-7  ti-modal-box mt-0 ease-out">
                <div class="ti-modal-content">
                    <div class="ti-modal-header">
                        <h6 class="modal-title text-[1rem] font-semibold">Update Cash Request</h6>
                        <button type="button" class="ti-btn !text-[1rem] !font-semibold !text-defaulttextcolor"
                            data-hs-overlay="#editModel">
                            <span class="sr-only">Close</span>
                            <i class="ri-close-line"></i>
                        </button>
                    </div>
                    <form @submit.prevent="updateTender">
                        <div class="ti-modal-body">

                            <div class="grid grid-cols-12 gap-4 px-3">
                                <div class="xl:col-span-12 col-span-12">
                                    <label for="request_amount" class="form-label">Amount</label>
                                    <TextInput v-model="selected.request_amount" type="number" id="request_amount"
                                        required placeholder="Cash Request" />
                                    <InputError class="mt-2" :message="$page.props.errors.request_amount" />

                                </div>
                                <div class="xl:col-span-12 col-span-12">
                                    <label for="request_for" class="form-label">Request for</label>
                                    <textarea placeholder="Description" v-model="selected.request_for"
                                        class="form-control w-full !rounded-md" id="request_for"></textarea>
                                    <InputError class="mt-2" :message="$page.props.errors.request_for" />

                                </div>
                                <div class="xl:col-span-12 col-span-12">
                                    <label for="purchase_order" class="form-label">Purchase Order
                                        <span class="text-danger"> (Attachment file)</span></label>
                                    <input type="file" @input="selected.purchase_order = $event.target.files[0]"
                                        id="purchase_order" class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50
                                                        file:border-0
                                                        file:bg-light file:me-4
                                                        file:py-2 file:px-4
                                                        dark:file:bg-black/20 dark:file:text-white/50 cursor-pointer">
                                    <InputError class="mt-2" :message="$page.props.errors.purchase_order" />

                                </div>
                                <div class="xl:col-span-12 col-span-12">
                                    <label for="estimated_badge" class="form-label">Estimate Badget
                                        <span class="text-danger"> (Attachment file)</span></label>
                                    <input type="file" @input="selected.estimated_badge = $event.target.files[0]"
                                        id="estimated_badge" class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50
                                                        file:border-0
                                                        file:bg-light file:me-4
                                                        file:py-2 file:px-4
                                                        dark:file:bg-black/20 dark:file:text-white/50 cursor-pointer">
                                    <InputError class="mt-2" :message="$page.props.errors.estimated_badge" />

                                </div>

                            </div>
                        </div>
                        <div class="ti-modal-footer">
                            <button type="button" class="hs-dropdown-toggle ti-btn  ti-btn-secondary-full align-middle"
                                data-hs-overlay="#editModel">
                                Close
                            </button>
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Save Changes
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div v-if="showDeleteModal" id="deleteModel" class="hs-overlay hidden ti-modal">
            <div class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out min-h-[calc(100%-3.5rem)] flex items-center">
                <div class="ti-modal-content w-full">

                    <div class="ti-modal-body text-center">
                        <form @submit.prevent="destroyTender(selectedId)">
                            <div class="text-center px-5 pb-0">
                                <svg class="custom-alert-icon fill-warning inline-flex"
                                    xmlns="http://www.w3.org/2000/svg" height="5rem" viewBox="0 0 24 24" width="5rem"
                                    fill="#000000">
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
                        <h6 class="modal-title text-[1rem] font-semibold">Cash request Details</h6>
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
                                <label for="name" class="form-label">
                                    <span v-if="selectedTender.status === 'approved'">Approved By</span>
                                    <span v-else>Rejected By</span>
                                </label>

                                <TextInput disabled v-model="selectedTender.request_amount" type="text" id="name" />
                            </div>
                            <div class="xl:col-span-12 col-span-12">
                                <span v-if="selectedTender.status === 'approved'">Approved Date</span>
                                <span v-else>Rejected Date</span>
                                <TextInput disabled v-model="selectedTender.approveOrRejectDate" type="text"
                                    id="name" />
                            </div>

                            <div class="xl:col-span-12 col-span-12">
                                <label for="description" class="form-label">Comment</label>
                                <textarea readonly class="form-control w-full !rounded-md" id="description"
                                    rows="4">{{ selectedTender.comment }}</textarea>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
