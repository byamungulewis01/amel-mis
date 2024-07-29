<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import TablePagination from '@/Components/TablePagination.vue';
// import { Inertia } from "@inertiajs/inertia";

const status = {
    active: {
        title: "Active",
        class: "badge !rounded-full bg-primary/10 text-primary"
    },
    inactive: {
        title: "Inactive",
        class: "badge !rounded-full bg-danger/10 text-danger"
    },
};
// store user into database
const form = useForm({
    email: '',
    name: '',
    phone: '',
    department: '',
});

const autoFillTenDigits = () => {
    // Ensure only digits are inputted and limit to 10 digits
    form.phone = form.phone.replace(/\D/g, '').slice(0, 10);
};

const submit = () => {
    form.post(route('user.store'),
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
const selectedUser = ref(null);

const editUser = (user) => {
    selectedUser.value = { ...user }; // Create a copy to avoid modifying the original user data
    showUpdateModal.value = true;
};
const updateUser = () => {
    // Assuming selectedUser contains the data of the user being updated
    const form = useForm({
        email: selectedUser.value.email,
        name: selectedUser.value.name,
        phone: selectedUser.value.phone,
        department: selectedUser.value.department,
        status: selectedUser.value.status,
    });
    form.put(route('user.update', selectedUser.value.id), {
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


const deleteUser = (user_id) => {
    selectedId.value = user_id;
    showDeleteModal.value = true;
};
const destroyUser = (user_id) => {
    // Assuming selectedUser contains the data of the user being updated
    const form = useForm({});
    form.delete(route('user.destroy', user_id), {
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
    users: Object,
});

</script>


<template>

    <Head title="Employees" />

    <AuthenticatedLayout>
        <!-- Page Header -->
        <div class="block justify-between page-header md:flex">
            <div>
                <h3
                    class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                    Employees List</h3>
            </div>
            <ol class="flex items-center whitespace-nowrap min-w-0">
                <li class="text-[0.813rem] ps-[0.5rem]">
                    <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                        href="javascript:void(0);">
                        Employees
                        <i
                            class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"></i>
                    </a>
                </li>
                <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 "
                    aria-current="page">
                    Employees List
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
                            All Employees List
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button data-hs-overlay="#addModel"
                                class="ti-btn ti-btn-primary-full !py-1 !px-2 !text-[0.75rem]">
                                <i class="ri-add-line  align-middle"></i>New Employee
                            </button>
                        </div>

                        <div id="addModel" class="hs-overlay hidden ti-modal">
                            <div class="hs-overlay-open:mt-7  ti-modal-box mt-0 ease-out">
                                <div class="ti-modal-content">
                                    <div class="ti-modal-header">
                                        <h6 class="modal-title text-[1rem] font-semibold">New Employee</h6>
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
                                                    <label for="email" class="form-label">Email</label>
                                                    <TextInput v-model="form.email" type="email" id="email" required
                                                        placeholder="Enter Email" />
                                                    <InputError class="mt-2" :message="form.errors.email" />

                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="phone" class="form-label">Phone No</label>
                                                    <TextInput v-model="form.phone" type="tel" id="phone" required
                                                        placeholder="Enter Phone Number" pattern="\d{10}" maxlength="10"
                                                        @input="autoFillTenDigits" />
                                                    <InputError class="mt-2" :message="form.errors.phone" />
                                                </div>

                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="department" class="form-label">Department</label>
                                                    <select v-model="form.department"
                                                        class="form-select rounded-sm !py-2 !px-3" id="department"
                                                        required>
                                                        <option disabled selected="" value="">-- Select --</option>
                                                        <option value="manager">Management Depart</option>
                                                        <option value="finance">Finance Depart</option>
                                                        <option value="field">Field Depart</option>
                                                        <option value="procurement">Procurement</option>
                                                    </select>
                                                    <InputError class="mt-2" :message="form.errors.department" />

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
                                        <h6 class="modal-title text-[1rem] font-semibold">Edit Employee</h6>
                                        <button type="button"
                                            class="hs-dropdown-toggle !text-[1rem] !font-semibold !text-defaulttextcolor"
                                            data-hs-overlay="#editModel">
                                            <span class="sr-only">Close</span>
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                    <form @submit.prevent="updateUser">
                                        <div class="ti-modal-body">

                                            <div class="grid grid-cols-12 gap-4 px-3">
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="name" class="form-label">Names</label>
                                                    <TextInput v-model="selectedUser.name" type="text" id="name"
                                                        required />
                                                    <InputError class="mt-2" :message="$page.props.errors.name" />

                                                </div>
                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="email" class="form-label">Email</label>
                                                    <TextInput v-model="selectedUser.email" type="email" id="email"
                                                        required placeholder="Enter Email" />
                                                    <InputError class="mt-2" :message="$page.props.errors.email" />

                                                </div>

                                                <div class="xl:col-span-12 col-span-12">
                                                    <label for="phone" class="form-label">Phone No</label>
                                                    <TextInput v-model="selectedUser.phone" type="tel" id="phone" required
                                                        placeholder="Enter Phone Number" pattern="\d{10}" maxlength="10"
                                                        @input="autoFillTenDigits" />
                                                    <InputError class="mt-2" :message="$page.props.errors.phone" />
                                                </div>


                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="department" class="form-label">Department</label>
                                                    <select v-model="selectedUser.department"
                                                        class="form-select rounded-sm !py-2 !px-3" id="department"
                                                        required>
                                                        <option value="manager">Management Depart</option>
                                                        <option value="finance">Finance Depart</option>
                                                        <option value="field">Field Depart</option>
                                                        <option value="procurement">Procurement</option>
                                                    </select>
                                                    <InputError class="mt-2" :message="$page.props.errors.department" />

                                                </div>
                                                <div class="xl:col-span-6 col-span-12">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select v-model="selectedUser.status"
                                                        class="form-select rounded-sm !py-2 !px-3" id="status"
                                                        required>
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
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
                                        <form @submit.prevent="destroyUser(selectedId)">
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
                                        <th scope="col" class="text-start">Employee</th>
                                        <th scope="col" class="text-start">Phone Number</th>
                                        <th scope="col" class="text-start">Department</th>
                                        <th scope="col" class="text-start">Status</th>
                                        <th scope="col" class="text-start">Joining Date</th>
                                        <th scope="col" class="text-start">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="user in users.data" :key="user.id"
                                        class="border-t hover:bg-gray-200 dark:hover:bg-light">
                                        <td>
                                            <div class="flex items-top flex-wrap">
                                                <div class="me-2">
                                                    <span
                                                        class="inline-flex items-center justify-center !w-[1.75rem] !h-[1.75rem] leading-[1.75rem] text-[0.65rem]  rounded-full text-primary bg-primary/10 font-semibold">
                                                        {{ user.name.split(' ').map(word =>
                                                            word.charAt(0)).join('').slice(0, 2).toUpperCase() }}
                                                    </span>
                                                </div>
                                                <div class="flex-grow">
                                                    <p class="font-semibold mb-[1.4px]  text-[0.813rem]">{{ user.name }}
                                                    </p>
                                                    <p class="text-[#8c9097] dark:text-white/50 text-[0.75rem]">
                                                        {{ user.email }}</p>
                                                </div>
                                            </div>

                                        </td>
                                        <td> {{ user.phone }}</td>
                                        <td>{{ user.department.toUpperCase() }}</td>
                                        <td><span :class="status[user.status].class">{{ status[user.status].title
                                                }}</span>
                                        </td>

                                        <td><i class="bi bi-clock me-1"></i>{{ new
                                            Date(user.created_at).toLocaleDateString('en-US', {
                                                month: 'short', day:
                                                    '2-digit', year: 'numeric'
                                            }) }}</td>
                                        <td>
                                            <!-- <a aria-label="anchor" href="javascript:void(0)"
                                                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-primary me-1">
                                                <i class="ri-eye-line"></i>
                                            </a> -->
                                            <a data-hs-overlay="#editModel" aria-label="anchor" @click="editUser(user)"
                                                href="javascript:void(0);"
                                                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-info me-1">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <a data-hs-overlay="#deleteModel" @click="deleteUser(user.id)"
                                                aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn ti-btn-icon ti-btn-sm ti-btn-danger">
                                                <i class="ri-delete-bin-line"></i>
                                            </a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                   <!-- Pagination -->
                   <TablePagination :links="users" />

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
