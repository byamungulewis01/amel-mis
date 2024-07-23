<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head, useForm } from '@inertiajs/vue3';
const props = defineProps({
    week_dates: Object,
});

// import { Inertia } from "@inertiajs/inertia";
const form = useForm({
    date: props.week_dates,
    hours: [],
    activities: [],
    comment: [],
    used_money: '',
    transport: '',
    accommodation: '',
});


const submit = () => {
    form.post(route('weekly-reports.store'),
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

</script>


<template>

    <Head title="New Report" />

    <AuthenticatedLayout>

        <div class="block justify-between page-header md:flex">
            <div>
                <h3
                    class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                    New Report</h3>
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
                    New Report
                </li>
            </ol>
        </div>
        <!-- Page Header Close -->

        <div class="grid grid-cols-12 gap-6">
            <div class="xl:col-span-12  col-span-12">
                <div class="box">
                    <div class="box-body add-products !p-0">
                        <form @submit.prevent="submit">
                            <div class="p-6">
                                <div class="grid grid-cols-12 md:gap-x-[3rem] gap-0">
                                    <div
                                        class="xxl:col-span-12 xl:col-span-12 lg:col-span-12 md:col-span-6 col-span-12">
                                        <div v-for="n in 5">
                                            <div class="grid grid-cols-12 gap-5">
                                                <div class="xl:col-span-3 col-span-12">
                                                    <div class="mb-2">
                                                        <label for="date" class="form-label">Day/date (<span
                                                                class="text-warning">{{ week_dates[n].name
                                                                }}</span>)</label>
                                                        <input readonly type="date" v-model="week_dates[n].date"
                                                            class="form-control w-full !rounded-md" id="date">
                                                    </div>
                                                    <div>
                                                        <label for="hours" class="form-label">Hours</label>
                                                        <input type="number" v-model="form.hours[n - 1]" min="0"
                                                            max="24" class="form-control w-full !rounded-md" id="hours"
                                                            placeholder="1 Hour">
                                                    </div>
                                                </div>

                                                <div class="xl:col-span-5 col-span-12">
                                                    <label for="activities" class="form-label">Performed
                                                        Work</label>
                                                    <textarea v-model="form.activities[n - 1]"
                                                        class="form-control w-full !rounded-md" id="activities" rows="4"
                                                        placeholder="Brief description of work performed"></textarea>

                                                </div>
                                                <div class="xl:col-span-4 col-span-12">
                                                    <label for="comment" class="form-label">Comment</label>
                                                    <textarea v-model="form.comment[n - 1]"
                                                        class="form-control w-full !rounded-md" id="comment" rows="2"
                                                        placeholder="Comment here"></textarea>
                                                </div>

                                            </div>
                                            <hr class="m-5">
                                        </div>
                                        <div class="grid grid-cols-12 gap-5">

                                            <div class="xl:col-span-4 col-span-12">
                                                <label for="used_money" class="form-label">CASH USED</label>
                                                <input type="number" v-model="form.used_money" placeholder="100000"
                                                    class="form-control w-full !rounded-md" id="used_money">

                                            </div>
                                            <div class="xl:col-span-4 col-span-12">
                                                <label for="transport" class="form-label">TRANSPORT</label>
                                                <input type="number" v-model="form.transport" placeholder="100000"
                                                    class="form-control w-full !rounded-md" id="transport">

                                            </div>
                                            <div class="xl:col-span-4 col-span-12">
                                                <label for="accommodation" class="form-label">ACCOMMODATION</label>
                                                <input type="number" v-model="form.accommodation" placeholder="100000"
                                                    class="form-control w-full !rounded-md" id="accommodation">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="px-6 py-4 border-t border-dashed dark:border-defaultborder/10 sm:flex justify-end">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                    class="ti-btn ti-btn-success !font-medium m-1">Submit Report</PrimaryButton>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
