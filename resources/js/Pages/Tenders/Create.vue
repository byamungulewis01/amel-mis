<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';

import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';

// store user into database
const form = useForm({
    tender_name: '',
    bid_security: '',
    tender_fees: '',
    description: '',
    opening_date: '',
    submitted_date: '',
    bid_documents: { newPriceSchedule: '', bidSecurity: '', paymentDocument: '', registrationCert: '', taxClearance: '', vatCert: '' },

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


</script>


<template>

    <Head title="Tenders" />

    <AuthenticatedLayout>
        <!-- Page Header -->
        <div class="block justify-between page-header md:flex">
            <div>
                <h3
                    class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                    Tenders</h3>
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
                    Create Tender
                </li>
            </ol>
        </div>
        <!-- Page Header Close -->
        <div class="grid grid-cols-12 gap-6">
            <div class="xl:col-span-12 col-span-12">
                <div class="box custom-box">
                    <div class="box-header">
                        <div class="box-title">
                            Create Tender
                        </div>
                    </div>
                    <div class="box-body">
                        <form @submit.prevent="submit">

                            <div class="grid grid-cols-12 gap-4 px-3">

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
                                        <textarea v-model="form.description" id="description" rows="5" class="form-control"
                                            required placeholder="Description on tender"></textarea>
                                        <InputError class="mt-2" :message="form.errors.description" />

                                    </div>
                                </div>
                                <div class="xl:col-span-6 col-span-6">
                                    <label for="tender_fees" class="form-label">Tender Fees</label>
                                    <TextInput v-model="form.tender_fees" type="number" min="0" id="tender_fees"
                                        required placeholder="Tender Fees" />
                                    <InputError class="mt-2" :message="form.errors.tender_fees" />

                                </div>
                                <div class="xl:col-span-6 col-span-6">
                                    <label for="bid_security" class="form-label">Bid Security</label>
                                    <TextInput v-model="form.bid_security" type="number" min="0" id="bid_security"
                                        required placeholder="Bid Security" />
                                    <InputError class="mt-2" :message="form.errors.bid_security" />

                                </div>
                                <div class="xl:col-span-6 col-span-6">
                                    <label for="opening_date" class="form-label">Opening Date</label>
                                    <TextInput v-model="form.opening_date" type="date" id="opening_date" required />
                                    <InputError class="mt-2" :message="form.errors.opening_date" />

                                </div>
                                <div class="xl:col-span-6 col-span-6">
                                    <label for="submitted_date" class="form-label">Submitted
                                        Date</label>
                                    <TextInput v-model="form.submitted_date" type="date" id="submitted_date" required />
                                    <InputError class="mt-2" :message="form.errors.submitted_date" />

                                </div>
                                <div class="xl:col-span-12 col-span-12">
                                    <hr>
                                    <h5>Required Bidding Documents</h5>
                                </div>
                                <div class="xl:col-span-4 col-span-12">
                                    <label for="newPriceSchedule" class="text-muted mb-2">New Price
                                        Schedule</label>
                                    <input type="file"
                                        @input="form.bid_documents.newPriceSchedule = $event.target.files[0]"
                                        id="newPriceSchedule" class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50
        file:border-0
        file:bg-light file:me-4
        file:py-2 file:px-4
        dark:file:bg-black/20 dark:file:text-white/50 cursor-pointer">
                                    <InputError class="mt-2" :message="form.errors.newPriceSchedule" />

                                </div>
                                <div class="xl:col-span-4 col-span-12">
                                    <label for="bidSecurity" class="text-muted mb-2">Bid
                                        Security</label>
                                    <input type="file" @input="form.bid_documents.bidSecurity = $event.target.files[0]"
                                        id="bidSecurity" class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50
        file:border-0
        file:bg-light file:me-4
        file:py-2 file:px-4
        dark:file:bg-black/20 dark:file:text-white/50 cursor-pointer">
                                    <InputError class="mt-2" :message="form.errors.bidSecurity" />

                                </div>
                                <div class="xl:col-span-4 col-span-12">
                                    <label for="paymentDocument" class="text-muted mb-2">Payment for
                                        tender Document</label>
                                    <input type="file"
                                        @input="form.bid_documents.paymentDocument = $event.target.files[0]"
                                        id="paymentDocument" class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50
        file:border-0
        file:bg-light file:me-4
        file:py-2 file:px-4
        dark:file:bg-black/20 dark:file:text-white/50 cursor-pointer">
                                    <InputError class="mt-2" :message="form.errors.paymentDocument" />

                                </div>
                                <div class="xl:col-span-4 col-span-12">
                                    <label for="registrationCert" class="text-muted mb-2">Registration
                                        Certificate</label>
                                    <input type="file"
                                        @input="form.bid_documents.registrationCert = $event.target.files[0]"
                                        id="registrationCert" class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50
        file:border-0
        file:bg-light file:me-4
        file:py-2 file:px-4
        dark:file:bg-black/20 dark:file:text-white/50 cursor-pointer">
                                    <InputError class="mt-2" :message="form.errors.registrationCert" />

                                </div>
                                <div class="xl:col-span-4 col-span-12">
                                    <label for="taxClearance" class="text-muted mb-2">Tax Clearance
                                        Certificate</label>
                                    <input type="file" @input="form.bid_documents.taxClearance = $event.target.files[0]"
                                        id="taxClearance" class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50
        file:border-0
        file:bg-light file:me-4
        file:py-2 file:px-4
        dark:file:bg-black/20 dark:file:text-white/50 cursor-pointer">
                                    <InputError class="mt-2" :message="form.errors.taxClearance" />

                                </div>
                                <div class="xl:col-span-4 col-span-12">
                                    <label for="vatCert" class="text-muted mb-2">VAT Certificate</label>
                                    <input type="file" @input="form.bid_documents.vatCert = $event.target.files[0]"
                                        id="vatCert" class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50
        file:border-0
        file:bg-light file:me-4
        file:py-2 file:px-4
        dark:file:bg-black/20 dark:file:text-white/50 cursor-pointer">
                                    <InputError class="mt-2" :message="form.errors.vatCert" />

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
