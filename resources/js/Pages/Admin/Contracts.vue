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
    name: '',
    item: '',
    quoting_price: '',
    market_price: '',
});

const submit = () => {
    form.post(route('contract.store'),
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
const selectedContract = ref(null);

const editContract = (contract) => {
    selectedContract.value = {
        ...contract
        , quoting_price: contract.quoting_price.toString()
        , market_price: contract.market_price.toString()
    }; // Create a copy to avoid modifying the original user data
    showUpdateModal.value = true;
};
const updateContract = () => {
    // Assuming selectedContract contains the data of the user being updated
    const form = useForm({
        name: selectedContract.value.name,
        item: selectedContract.value.item,
        quoting_price: selectedContract.value.quoting_price,
        market_price: selectedContract.value.market_price,
        status: selectedContract.value.status,
    });
    form.put(route('contract.update', selectedContract.value.id), {
        onSuccess: () => {
            form.reset();
            const closeButton = document.querySelector('.hs-dropdown-toggle[data-hs-overlay="#editModel"]');
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
const showDeleteModal = ref(false);
const selectedId = ref(null);


const deleteContract = (report_id) => {
    selectedId.value = report_id;
    showDeleteModal.value = true;
};
const destroyContract = (user_id) => {
    // Assuming selectedContract contains the data of the user being updated
    const form = useForm({});
    form.delete(route('contract.destroy', user_id), {
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
    contracts: Object,
});
</script>


<template>

    <Head title="Contracts" />

    <AuthenticatedLayout>
        <!-- Page Header -->
        <div class="block justify-between page-header md:flex">
            <div>
                <h3
                    class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                    Contracts List</h3>
            </div>
            <ol class="flex items-center whitespace-nowrap min-w-0">
                <li class="text-[0.813rem] ps-[0.5rem]">
                    <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                        href="javascript:void(0);">
                        Contracts
                        <i
                            class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"></i>
                    </a>
                </li>
                <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 "
                    aria-current="page">
                    Contracts List
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
                            All Contract List
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button data-hs-overlay="#addModel"
                                class="ti-btn ti-btn-primary-full !py-1 !px-2 !text-[0.75rem]">
                                <i class="ri-add-line  align-middle"></i>New Contract
                            </button>
                        </div>

                        <div id="addModel" class="hs-overlay hidden ti-modal">
                            <div class="hs-overlay-open:mt-7  ti-modal-box mt-0 ease-out">
                                <div class="ti-modal-content">
                                    <div class="ti-modal-header">
                                        <h6 class="modal-title text-[1rem] font-semibold">New Contract</h6>
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
                                                    <label for="name" class="form-label">Names</label>
                                                    <TextInput v-model="form.name" type="text" id="name" required
                                                        placeholder="Full Name" />
                                                    <InputError class="mt-2" :message="form.errors.name" />

                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="item" class="form-label">Item</label>
                                                    <TextInput v-model="form.item" type="text" id="item" required
                                                        placeholder="Enter Email" />
                                                    <InputError class="mt-2" :message="form.errors.item" />

                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="quoting_price" class="form-label">Quoting Price</label>
                                                    <TextInput v-model="form.quoting_price" type="number"
                                                        id="quoting_price" required placeholder="Quoting Price" />
                                                    <InputError class="mt-2" :message="form.errors.quoting_price" />
                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="market_price" class="form-label">Market Price</label>
                                                    <TextInput v-model="form.market_price" type="number"
                                                        id="market_price" required placeholder="Market Price" />
                                                    <InputError class="mt-2" :message="form.errors.market_price" />
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
                            <div class="hs-overlay-open:mt-7  ti-modal-box mt-0 ease-out">
                                <div class="ti-modal-content">
                                    <div class="ti-modal-header">
                                        <h6 class="modal-title text-[1rem] font-semibold">Edit Contract</h6>
                                        <button type="button"
                                            class="hs-dropdown-toggle !text-[1rem] !font-semibold !text-defaulttextcolor"
                                            data-hs-overlay="#editModel">
                                            <span class="sr-only">Close</span>
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                    <form @submit.prevent="updateContract">
                                        <div class="ti-modal-body">

                                            <div class="grid grid-cols-12 gap-4 px-3">
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="name" class="form-label">Names</label>
                                                    <TextInput v-model="selectedContract.name" type="text" id="name"
                                                        required />
                                                    <InputError class="mt-2" :message="$page.props.errors.name" />

                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="item" class="form-label">Item</label>
                                                    <TextInput v-model="selectedContract.item" type="text" id="item"
                                                        required />
                                                    <InputError class="mt-2" :message="$page.props.errors.item" />

                                                </div>

                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="quoting_price" class="form-label">Quoting Price</label>
                                                    <TextInput v-model="selectedContract.quoting_price" type="number"
                                                        id="quoting_price" required />
                                                    <InputError class="mt-2"
                                                        :message="$page.props.errors.quoting_price" />
                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="market_price" class="form-label">Market Price</label>
                                                    <TextInput v-model="selectedContract.market_price" type="number"
                                                        id="market_price" required />
                                                    <InputError class="mt-2"
                                                        :message="$page.props.errors.market_price" />
                                                </div>


                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select v-model="selectedContract.status"
                                                        class="form-select rounded-sm !py-2 !px-3" id="status" required>
                                                        <option value="pending">Pending</option>
                                                        <option value="in_progress">In Progress</option>
                                                        <option value="complete">Completed</option>
                                                    </select>
                                                    <InputError class="mt-2" :message="$page.props.errors.status" />

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
                                        <form @submit.prevent="destroyContract(selectedId)">
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
                                        <th scope="col" class="text-start">Contract Name</th>
                                        <th scope="col" class="text-start">Item</th>
                                        <th scope="col" class="text-start">Quoting Price</th>
                                        <th scope="col" class="text-start">Marketing Price</th>
                                        <th scope="col" class="text-start">Status</th>
                                        <th scope="col" class="text-start">Created At</th>
                                        <th scope="col" class="text-start">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(contractKey, index) in Object.keys(contracts)" :key="index"
                                        class="border-t hover:bg-gray-200 dark:hover:bg-light">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ contracts[contractKey].name }}</td>
                                        <td>{{ contracts[contractKey].item }}</td>
                                        <td>{{ contracts[contractKey].quoting_price.toLocaleString() }}</td>
                                        <td>{{ contracts[contractKey].market_price.toLocaleString() }}</td>
                                        <td><span :class="status[contracts[contractKey].status].class">{{
                                                status[contracts[contractKey].status].title }}</span></td>
                                        <td><i class="bi bi-clock me-1"></i>
                                            {{ new
                                                Date(contracts[contractKey].created_at).toLocaleDateString('en-US', {
                                                    month: 'short', day:
                                                        '2-digit', year: 'numeric'
                                                }) }}
                                        </td>
                                        <td>
                                            <a aria-label="anchor" @click="editContract(contracts[contractKey])"
                                                data-hs-overlay="#editModel" href="javascript:void(0);"
                                                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-info me-1">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <a @click="deleteContract(contracts[contractKey].id)" aria-label="anchor" data-hs-overlay="#deleteModel"
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

                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
