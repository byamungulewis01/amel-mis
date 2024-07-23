<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head } from '@inertiajs/vue3';

// import { Inertia } from "@inertiajs/inertia";
const props = defineProps({
    report: Object,
});

</script>


<template>

    <Head title="Show Report" />

    <AuthenticatedLayout>

        <div class="block justify-between page-header md:flex">
            <div>
                <h3
                    class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                    Show Report</h3>
            </div>
            <ol class="flex items-center whitespace-nowrap min-w-0">
                <li class="text-[0.813rem] ps-[0.5rem]">
                    <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                        href="javascript:void(0);">
                        Weekly Work
                        <i
                            class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"></i>
                    </a>
                </li>
                <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 "
                    aria-current="page">
                    Show Report
                </li>
            </ol>
        </div>
        <!-- Page Header Close -->



        <div class="grid grid-cols-12 gap-6">
            <div class="xl:col-span-12 col-span-12">
                <div class="box">
                    <div class="box-header justify-between">
                        <div class="box-title">Week {{ report.week_number }} Report</div>
                    </div>
                    <div class="box-footer">
                        <div class="flex items-center justify-between gap-2 flex-wrap">
                            <div>
                                <span class="block text-[#8c9097] dark:text-white/50 text-[0.75rem]">Week Date </span>
                                <div class="flex items-center flex-wrap">

                                    <span
                                        class="block text-[.875rem] dark:text-defaulttextcolor/70 font-semibold">{{ report.date_from }} - {{ report.date_to }}</span>
                                </div>
                            </div>
                            <div>
                                <span class="block text-[#8c9097] dark:text-white/50 text-[0.75rem]">Cash Used</span>
                                <span
                                    class="block text-[.875rem] font-semibold dark:text-defaulttextcolor/70">{{ report.used_money.toLocaleString() }}</span>
                            </div>
                            <div>
                                <span class="block text-[#8c9097] dark:text-white/50 text-[0.75rem]">Transport</span>
                                <span class="block text-[.875rem] font-semibold dark:text-defaulttextcolor/70">{{ report.transport.toLocaleString() }}</span>
                            </div>
                            <div>
                                <span class="block text-[#8c9097] dark:text-white/50 text-[0.75rem]">Accommodation</span>
                                <span class="block text-[.875rem] font-semibold dark:text-defaulttextcolor/70">{{ report.accommodation.toLocaleString() }}
                                    </span>
                            </div>
                            <div>
                                <span class="block text-[#8c9097] dark:text-white/50 text-[0.75rem]">Report Date</span>
                                <span class="block text-[.875rem] font-semibold dark:text-defaulttextcolor/70">
                                    {{ new Date(report.created_at).toLocaleDateString('en-US', { month: 'short', day:'2-digit', year: 'numeric'}) }}</span>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header justify-between">
                        <div class="box-title">Weekly Performances</div>

                    </div>
                    <div class="box-body text-defaulttextcolor text-defaultsize">
                        <div class="table-responsive">

                            <table class="table table-hover whitespace-nowrap min-w-full">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-start">Day</th>
                                        <th scope="col" class="text-start">Date</th>
                                        <th scope="col" class="text-start">Performed Work</th>
                                        <th scope="col" class="text-start">Hours</th>
                                        <th scope="col" class="text-start">Comment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="detail in report.details" :key="detail.id"  class="border-t hover:bg-gray-200 dark:hover:bg-light">
                                        <td>{{ detail.day_name }}</td>
                                        <td>{{ detail.date }}</td>
                                        <td>{{ detail.activities }}</td>
                                        <td>{{ detail.hours }}</td>
                                        <td>{{ detail.comment }}</td>
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
