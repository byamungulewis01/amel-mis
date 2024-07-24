<script setup>
import { ref } from 'vue';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Inertia } from "@inertiajs/inertia";

const status = {
    active: {
        title: "Active",
        class: "badge bg-outline-secondary"
    },
    expired: {
        title: "Expired",
        class: "badge bg-outline-danger"
    },
    terminated: {
        title: "Terminated",
        class: "badge bg-outline-success"
    },
};

// store user into database
const form = useForm({
    contract_number: '',
    name: '',
    value: '',
    type: '',
    signed_date: '',
    status: '',
    description: '',
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
        , value: contract.value.toString()
    }; // Create a copy to avoid modifying the original user data
    showUpdateModal.value = true;
};
const updateContract = () => {
    // Assuming selectedContract contains the data of the user being updated
    const form = useForm({
        contract_number: selectedContract.value.contract_number,
        name: selectedContract.value.name,
        value: selectedContract.value.value,
        type: selectedContract.value.type,
        signed_date: selectedContract.value.signed_date,
        status: selectedContract.value.status,
        description: selectedContract.value.description,
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
                        <div v-if="$page.props.auth.user.department == 'procurement'" class="flex flex-wrap gap-2">
                            <button data-hs-overlay="#addModel"
                                class="ti-btn ti-btn-primary-full !py-1 !px-2 !text-[0.75rem]">
                                <i class="ri-add-line  align-middle"></i>New Contract
                            </button>
                        </div>

                        <div id="addModel" class="hs-overlay hidden ti-modal">
                            <div class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out md:!max-w-2xl md:w-full m-3 md:mx-auto">
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
                                                    <label for="contract_number" class="form-label">Contract
                                                        Number</label>
                                                    <TextInput v-model="form.contract_number" type="text"
                                                        id="contract_number" required placeholder="Contract Number" />
                                                    <InputError class="mt-2" :message="form.errors.contract_number" />

                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="name" class="form-label">Contract Name</label>
                                                    <TextInput v-model="form.name" type="text" id="name" required
                                                        placeholder="Contract Name" />
                                                    <InputError class="mt-2" :message="form.errors.name" />

                                                </div>
                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="value" class="form-label">Contract Value</label>
                                                    <TextInput v-model="form.value" type="number" min="0" id="value"
                                                        required placeholder="Contact Value" />
                                                    <InputError class="mt-2" :message="form.errors.value" />

                                                </div>
                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="type" class="form-label">Contract Type</label>
                                                    <select v-model="form.type"
                                                        class="form-select rounded-sm !py-2 !px-3" id="type" required>
                                                        <option disabled selected="" value="">-- Select --</option>
                                                        <option value="current">Current</option>
                                                        <option value="framework">Framework</option>
                                                    </select>
                                                    <InputError class="mt-2" :message="form.errors.type" />

                                                </div>
                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="signed_date" class="form-label">Signed Date</label>
                                                    <TextInput v-model="form.signed_date" type="date" id="signed_date"
                                                        required />
                                                    <InputError class="mt-2" :message="form.errors.signed_date" />

                                                </div>
                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select v-model="form.status"
                                                        class="form-select rounded-sm !py-2 !px-3" id="status" required>
                                                        <option disabled selected="" value="">-- Select --</option>
                                                        <option value="active">Active</option>
                                                        <option value="expired">Expired</option>
                                                        <option value="terminated">Terminated</option>
                                                    </select>
                                                    <InputError class="mt-2" :message="form.errors.status" />

                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea placeholder="Contract Description" rows="5"
                                                        v-model="form.description"
                                                        class="form-control w-full !rounded-md"
                                                        id="description"></textarea>
                                                    <InputError class="mt-2" :message="form.errors.description" />

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

                        <div v-if="showUpdateModal" id="editModel" class="hs-overlay hidden ti-modal">
                            <div class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out md:!max-w-2xl md:w-full m-3 md:mx-auto">
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
                                                    <label for="contract_number" class="form-label">Contract
                                                        Number</label>
                                                    <TextInput v-model="selectedContract.contract_number" type="text"
                                                        id="contract_number" required placeholder="Contract Number" />
                                                    <InputError class="mt-2" :message="$page.props.errors.contract_number" />

                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="name" class="form-label">Contract Name</label>
                                                    <TextInput v-model="selectedContract.name" type="text" id="name"
                                                        required placeholder="Contract Name" />
                                                    <InputError class="mt-2" :message="$page.props.errors.name" />

                                                </div>
                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="value" class="form-label">Contract Value</label>
                                                    <TextInput v-model="selectedContract.value" type="number" min="0"
                                                        id="value" required placeholder="Contact Value" />
                                                    <InputError class="mt-2" :message="$page.props.errors.value" />

                                                </div>
                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="type" class="form-label">Contract Type</label>
                                                    <select v-model="selectedContract.type"
                                                        class="form-select rounded-sm !py-2 !px-3" id="type" required>
                                                        <option disabled selected="" value="">-- Select --</option>
                                                        <option value="current">Current</option>
                                                        <option value="framework">Framework</option>
                                                    </select>
                                                    <InputError class="mt-2" :message="$page.props.errors.type" />

                                                </div>
                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="signed_date" class="form-label">Signed Date</label>
                                                    <TextInput v-model="selectedContract.signed_date" type="date"
                                                        id="signed_date" required />
                                                    <InputError class="mt-2" :message="$page.props.errors.signed_date" />

                                                </div>
                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select v-model="selectedContract.status"
                                                        class="form-select rounded-sm !py-2 !px-3" id="status" required>
                                                        <option disabled selected="" value="">-- Select --</option>
                                                        <option value="active">Active</option>
                                                        <option value="expired">Expired</option>
                                                        <option value="terminated">Terminated</option>
                                                    </select>
                                                    <InputError class="mt-2" :message="$page.props.errors.status" />

                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea placeholder="Contract Description" rows="5"
                                                        v-model="selectedContract.description"
                                                        class="form-control w-full !rounded-md"
                                                        id="description"></textarea>
                                                    <InputError class="mt-2"
                                                        :message="$page.props.errors.description" />

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
                                        <th scope="col" class="text-start">Contract Number</th>
                                        <th scope="col" class="text-start">Contract Name</th>
                                        <th scope="col" class="text-start">Contact Type</th>
                                        <th scope="col" class="text-start">Value</th>
                                        <th scope="col" class="text-start">Signed Date</th>
                                        <th scope="col" class="text-start">Status</th>
                                        <th scope="col" class="text-start">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(contract, index) in contracts" :key="contract.id"
                                        class="border-t hover:bg-gray-200 dark:hover:bg-light">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ contract.contract_number }}</td>
                                        <td>{{ contract.name }}</td>
                                        <td>{{ contract.type.toUpperCase() }}</td>
                                        <td>{{ contract.value.toLocaleString() }}</td>
                                        <td><i class="bi bi-clock me-1"></i> {{ contract.signed_date }}</td>
                                        <td><span :class="status[contract.status].class">{{
                                            status[contract.status].title }}</span></td>

                                        <td>
                                            <Link :href="route('contract.show', contract.id)"
                                                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-primary me-1">
                                                <i class="ri-eye-line"></i>
                                            </Link>
                                            <div v-if="$page.props.auth.user.department == 'procurement'">
                                            <a aria-label="anchor" @click="editContract(contract)"
                                                data-hs-overlay="#editModel" href="javascript:void(0);"
                                                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-info me-1">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <a @click="deleteContract(contract.id)" aria-label="anchor"
                                                data-hs-overlay="#deleteModel" href="javascript:void(0);"
                                                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-danger">
                                                <i class="ri-delete-bin-line"></i>
                                            </a></div>
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
