<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';

import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
const props = defineProps({ tender_id: String, });
// store user into database
const form = useForm({
    tender_id: props.tender_id,
    tender_name: '',
    bid_security: '',
    tender_fees: '',
    other_fees: '',
    description: '',
    opening_date: '',
    closing_date: '',
    organisation_name: '',
    bid_documents: [{ name: '', filePath: '' }],

});


const submit = () => {
    form.post(route('tenders.store'),
        {
            onSuccess: () => {
                form.reset();

            },
            onError: (errors) => {
                console.log('error', errors);
                // Handle error responses or validation errors
            },
        }
    );
};
// End Storing user information

const addDocument = () => {
    form.bid_documents.push({ name: '', filePath: '' });
};

const removeDocument = (index) => {
    form.bid_documents.splice(index, 1);
};

</script>


<template>

    <Head title="Tenders" />

    <AuthenticatedLayout>
        <!-- Page Header -->
        <div class="block justify-between page-header md:flex"></div>
        <!-- Page Header Close -->
        <div class="grid grid-cols-12 gap-6">
            <div class="xl:col-span-10 col-span-12">
                <div class="box custom-box">
                    <div class="box-header">
                        <div class="box-title">
                            Create Tender
                        </div>
                    </div>
                    <div class="box-body">
                        <form @submit.prevent="submit">

                            <div class="grid grid-cols-12 gap-4 px-3 mb-3">

                                <label for="tender_name" class="sm:col-span-2 col-span-12 col-form-label">Tender
                                    Name</label>
                                <div class="sm:col-span-10 col-span-12">
                                    <div class="input-group">
                                        <TextInput v-model="form.tender_name" type="text" required id="tender_name"
                                            placeholder="Enter Tender name here" />
                                        <InputError class="mt-2" :message="form.errors.tender_name" />

                                    </div>
                                </div>
                                <label for="description" class="sm:col-span-2 col-span-12 col-form-label">Tender
                                    Description</label>
                                <div class="sm:col-span-10 col-span-12">
                                    <div class="input-group">
                                        <textarea v-model="form.description" id="description" rows="5"
                                            class="form-control" required
                                            placeholder="Description on tender"></textarea>
                                        <InputError class="mt-2" :message="form.errors.description" />

                                    </div>
                                </div>
                                <label for="organisation_name" class="sm:col-span-2 col-span-12 col-form-label">Organisation
                                    Name</label>
                                <div class="sm:col-span-10 col-span-12">
                                    <div class="input-group">
                                        <TextInput v-model="form.organisation_name" type="text" required id="organisation_name"
                                            placeholder="Enter Organisation Name" />
                                        <InputError class="mt-2" :message="form.errors.organisation_name" />

                                    </div>
                                </div>
                                <div class="xl:col-span-4 col-span-6">
                                    <label for="tender_fees" class="form-label">Tender Fees</label>
                                    <TextInput v-model="form.tender_fees" type="number" min="0" id="tender_fees"
                                        required placeholder="Tender Fees" />
                                    <InputError class="mt-2" :message="form.errors.tender_fees" />

                                </div>
                                <div class="xl:col-span-4 col-span-6">
                                    <label for="bid_security" class="form-label">Bid Security</label>
                                    <TextInput v-model="form.bid_security" type="number" min="0" id="bid_security"
                                        required placeholder="Bid Security" />
                                    <InputError class="mt-2" :message="form.errors.bid_security" />

                                </div>
                                <div class="xl:col-span-4 col-span-6">
                                    <label for="other_fees" class="form-label">Other Fees</label>
                                    <TextInput v-model="form.other_fees" type="number" min="0" id="other_fees"
                                        required placeholder="Other fees" />
                                    <InputError class="mt-2" :message="form.errors.other_fees" />

                                </div>
                                <div class="xl:col-span-6 col-span-6">
                                    <label for="opening_date" class="form-label">Opening Date</label>
                                    <TextInput v-model="form.opening_date" type="date" id="opening_date" required />
                                    <InputError class="mt-2" :message="form.errors.opening_date" />

                                </div>
                                <div class="xl:col-span-6 col-span-6">
                                    <label for="closing_date" class="form-label">Closing Date</label>
                                    <TextInput v-model="form.closing_date" type="date" id="closing_date" required />
                                    <InputError class="mt-2" :message="form.errors.closing_date" />

                                </div>
                                <div class="xl:col-span-12 col-span-12">
                                    <h5>Required Bidding Documents</h5>
                                </div>
                            </div>

                            <div v-for="(document, index) in form.bid_documents" :key="index"
                                class="grid grid-cols-12 gap-4 px-3 mb-3">
                                <div class="xl:col-span-6 col-span-12">
                                    <label for="name" class="text-muted mb-2">Document Name</label>
                                    <TextInput v-model="document.name" type="text" id="name" placeholder="Document name"
                                        required />

                                    <InputError class="mt-2" :message="form.errors[`bid_documents.${index}.name`]" />

                                </div>
                                <div class="xl:col-span-5 col-span-12">
                                    <label for="newPriceSchedule" class="text-muted mb-2">Document file</label>
                                    <input type="file" @input="document.filePath = $event.target.files[0]"
                                        id="newPriceSchedule" class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50
                                            file:border-0
                                            file:bg-light file:me-4
                                            file:py-2 file:px-4
                                            dark:file:bg-black/20 dark:file:text-white/50 cursor-pointer">
                                    <InputError class="mt-2"
                                        :message="form.errors[`bid_documents.${index}.filePath`]" />

                                </div>
                                <div class="xl:col-span-1 col-span-12">
                                    <button type="button" v-if="index === 0" @click="addDocument"
                                        class="ti-btn ti-btn-success mt-7"><i
                                            class="ri-add-line align-middle"></i></button>
                                    <button type="button" v-if="index !== 0" @click="removeDocument(index)"
                                        class="ti-btn ti-btn-danger mt-7"><i
                                            class="ri-close-line align-middle"></i></button>
                                </div>
                            </div>

                            <div class="box-footer">
                                <button class="ti-btn ti-btn-primary btn-wave ms-auto float-right">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
