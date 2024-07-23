<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    tender: Object,
});
const tender = props.tender.data;


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
                    View Tender
                </li>
            </ol>
        </div>
        <!-- Page Header Close -->

        <div class="grid grid-cols-12 gap-6">
            <div class="xl:col-span-8 col-span-12">
                <div class="box">
                    <div class="box-header justify-between">
                        <div class="box-title">Tender Summary</div>

                    </div>
                    <div class="box-body">
                        <h5 class="font-semibold mb-4 task-title text-[1.25rem]">
                            {{ tender.tender_name }}
                        </h5>
                        <div class="text-[.9375rem] font-semibold mb-2">Tender Description :</div>
                        <p class="text-[#8c9097] dark:text-white/50 task-description">{{ tender.description }}</p>

                    </div>
                    <div class="box-footer">
                        <div class="flex items-center justify-start gap-8 flex-wrap">
                            <div>
                                <span class="block text-[#8c9097] dark:text-white/50 text-[0.75rem]">Assigned By</span>
                                <div class="flex items-center flex-wrap">
                                    <div class="me-2 leading-none">
                                        <span class="avatar avatar-xs avatar-rounded">
                                            <img src="/assets/images/faces/9.jpg" alt="">
                                        </span>
                                    </div>
                                    <span class="block text-[.875rem] dark:text-defaulttextcolor/70 font-semibold">{{
                                        tender.stored_by_name }}</span>
                                </div>
                            </div>
                            <div>
                                <span class="block text-[#8c9097] dark:text-white/50 text-[0.75rem]">Opening Date</span>
                                <span class="block text-[.875rem] font-semibold dark:text-defaulttextcolor/70">{{
                                    tender.opening_date }}</span>
                            </div>



                        </div>
                    </div>
                </div>

            </div>
            <div class="xl:col-span-4 col-span-12">
                <div class="box">
                    <div class="box-header">
                        <div class="box-title">
                            Tender Finance fees
                        </div>
                    </div>
                    <div class="box-body !p-0">
                        <div class="table-responsive">
                            <table class="table whitespace-nowrap min-w-full">
                                <tbody>
                                    <tr class="border-b border-defaultborder">
                                        <td><span class="font-semibold">Tender Fees :</span></td>
                                        <td>{{ tender.tender_fees.toLocaleString() }} Frw</td>
                                    </tr>
                                    <tr class="border-b border-defaultborder">
                                        <td><span class="font-semibold">Bid Security :</span></td>
                                        <td>{{ tender.bid_security.toLocaleString() }} Frw</td>
                                    </tr>
                                    <tr class="border-b border-defaultborder">
                                        <td><span class="font-semibold">Other Fees :</span></td>
                                        <td>{{ tender.other_fees.toLocaleString() }} Frw</td>
                                    </tr>
                                    <tr class="border-b border-defaultborder">
                                        <td><span class="font-semibold">Total Amount :</span></td>
                                        <td>{{ tender.total_amount.toLocaleString()  }} Frw</td>
                                    </tr>


                                    <!-- <tr class="border-b border-defaultborder">
                                        <td><span class="font-semibold">Tender Status :</span></td>
                                        <td>
                                            <span :class="tenderStatus[tender.status].class">{{
                                                tenderStatus[tender.status].title }}</span>
                                        </td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="box overflow-hidden">
                    <div class="box-header !border-b-0">
                        <div class="box-title">
                            Attachments
                        </div>
                    </div>
                    <div class="box-body !p-0">
                        <ul class="list-group list-group-flush">
                            <li v-for="(document,index) in tender.documents" :key="index" class="list-group-item">
                                <div class="flex items-center flex-wrap">

                                    <div class="flex-grow">
                                        <a target="_blank" :href="'/storage/' + document.filePath"><span
                                                class="block font-semibold">{{ document.name }}</span></a>
                                        <span
                                            class="block text-[#8c9097] dark:text-white/50 text-[0.75rem] font-normal">Document file</span>
                                    </div>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>



        </div>


    </AuthenticatedLayout>
</template>
