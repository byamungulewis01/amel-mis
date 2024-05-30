<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
const toast = useToast();

const showSuccess = () => {
    toast.add({ severity: 'success', summary: 'Success Message', detail: 'Message Content', life: 3000 });
};
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <!-- Page Header -->
        <div class="block justify-between page-header md:flex">
            <div>
                <h3
                    class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                    Home</h3>
            </div>
            <ol class="flex items-center whitespace-nowrap min-w-0">
                <li class="text-[0.813rem] ps-[0.5rem]">
                    <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                        href="javascript:void(0);">
                        Dashboards
                        <i
                            class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] px-[0.5rem] overflow-visible dark:text-white/50 rtl:rotate-180"></i>
                    </a>
                </li>
                <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 "
                    aria-current="page">
                    Home
                </li>
            </ol>
        </div>
        <!-- Page Header Close -->
        <div class="grid grid-cols-12 gap-x-6">
            <div class="xxxl:col-span-6 col-span-12">
                <div class="grid grid-cols-12 gap-x-6">
                    <div class="xxl:col-span-4 md:col-span-6 col-span-12">
                        <div class="box">
                            <div class="box-body !pb-[0.9rem]">
                                <div class="flex items-start">
                                    <div class="me-4 gap-0">
                                        <span class="avatar avatar-md p-2 bg-primary">
                                            <svg class="svg-white" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 0 24 24" width="24px" fill="#000000">
                                                <path d="M0 0h24v24H0V0z" fill="none" />
                                                <path
                                                    d="M12 5.9c1.16 0 2.1.94 2.1 2.1s-.94 2.1-2.1 2.1S9.9 9.16 9.9 8s.94-2.1 2.1-2.1m0 9c2.97 0 6.1 1.46 6.1 2.1v1.1H5.9V17c0-.64 3.13-2.1 6.1-2.1M12 4C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 9c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex mb-1 items-start justify-between">
                                            <h5 class="font-semibold mb-0 leading-none text-[1.25rem]">5</h5>
                                            <div class="text-danger font-semibold"><i
                                                    class="ri-arrow-down-s-fill me-1 align-middle"></i>-1.05%</div>
                                        </div>
                                        <p
                                            class="mb-0 text-[0.625rem] opacity-[0.7] text-[#8c9097] dark:text-white/50 font-semibold">
                                            TOTAL EMPLOYERS</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="xxl:col-span-4 md:col-span-6 col-span-12">
                        <div class="box">
                            <div class="box-body !pb-[0.9rem]">
                                <div class="flex items-start">
                                    <div class="me-4">
                                        <span class="avatar avatar-md p-2 bg-secondary">
                                            <svg class="svg-white" xmlns="http://www.w3.org/2000/svg"
                                                enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24"
                                                width="24px" fill="#000000">
                                                <rect fill="none" height="24" width="24" />
                                                <g>
                                                    <path
                                                        d="M4,13c1.1,0,2-0.9,2-2c0-1.1-0.9-2-2-2s-2,0.9-2,2C2,12.1,2.9,13,4,13z M5.13,14.1C4.76,14.04,4.39,14,4,14 c-0.99,0-1.93,0.21-2.78,0.58C0.48,14.9,0,15.62,0,16.43V18l4.5,0v-1.61C4.5,15.56,4.73,14.78,5.13,14.1z M20,13c1.1,0,2-0.9,2-2 c0-1.1-0.9-2-2-2s-2,0.9-2,2C18,12.1,18.9,13,20,13z M24,16.43c0-0.81-0.48-1.53-1.22-1.85C21.93,14.21,20.99,14,20,14 c-0.39,0-0.76,0.04-1.13,0.1c0.4,0.68,0.63,1.46,0.63,2.29V18l4.5,0V16.43z M16.24,13.65c-1.17-0.52-2.61-0.9-4.24-0.9 c-1.63,0-3.07,0.39-4.24,0.9C6.68,14.13,6,15.21,6,16.39V18h12v-1.61C18,15.21,17.32,14.13,16.24,13.65z M8.07,16 c0.09-0.23,0.13-0.39,0.91-0.69c0.97-0.38,1.99-0.56,3.02-0.56s2.05,0.18,3.02,0.56c0.77,0.3,0.81,0.46,0.91,0.69H8.07z M12,8 c0.55,0,1,0.45,1,1s-0.45,1-1,1s-1-0.45-1-1S11.45,8,12,8 M12,6c-1.66,0-3,1.34-3,3c0,1.66,1.34,3,3,3s3-1.34,3-3 C15,7.34,13.66,6,12,6L12,6z" />
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex mb-1 items-start justify-between">
                                            <h5 class="font-semibold mb-0 leading-none text-[1.25rem]">240</h5>
                                            <div class="text-success font-semibold"><i
                                                    class="ri-arrow-up-s-fill me-1 align-middle"></i>+0.40%</div>
                                        </div>
                                        <p
                                            class="mb-0 text-[0.625rem] opacity-[0.7] text-[#8c9097] dark:text-white/50  font-semibold">
                                            TOTAL CONTRACTS</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="xxl:col-span-4 md:col-span-6 col-span-12">
                        <div class="box">
                            <div class="box-body !pb-[0.9rem]">
                                <div class="flex items-start">
                                    <div class="me-3">
                                        <span class="avatar avatar-md p-2 bg-warning">
                                            <svg class="svg-white" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 0 24 24" width="24px" fill="#000000">
                                                <path d="M0 0h24v24H0V0z" fill="none" />
                                                <path
                                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM4 12c0-.61.08-1.21.21-1.78L8.99 15v1c0 1.1.9 2 2 2v1.93C7.06 19.43 4 16.07 4 12zm13.89 5.4c-.26-.81-1-1.4-1.9-1.4h-1v-3c0-.55-.45-1-1-1h-6v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41C17.92 5.77 20 8.65 20 12c0 2.08-.81 3.98-2.11 5.4z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex mb-1 items-start justify-between">
                                            <h5 class="font-semibold mb-0 leading-none text-[1.25rem]">48</h5>
                                            <div class="text-success font-semibold"><i
                                                    class="ri-arrow-up-s-fill me-1 align-middle"></i>+0.82%</div>
                                        </div>
                                        <p
                                            class="mb-0 text-[0.625rem] opacity-[0.7] text-[#8c9097] dark:text-white/50 font-semibold">
                                            TOTAL TENDERS</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="xl:col-span-8 col-span-12">
                <div class="box">
                    <div class="box-header justify-between">
                        <div class="box-title">
                            Recent Tenders
                        </div>

                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table whitespace-nowrap table-bordered min-w-full">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-start">#</th>
                                        <th scope="col" class="text-start">Tender Name</th>
                                        <th scope="col" class="text-start">Amount</th>
                                        <th scope="col" class="text-start">Status</th>
                                        <th scope="col" class="text-start">Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t border-defaultborder dark:border-defaultborder/10">
                                        <td>
                                            01
                                        </td>
                                        <td>
                                            Tender A
                                        </td>
                                        <td>
                                            12,000
                                        </td>
                                        <td>
                                            <span class="badge bg-warning/10 text-warning">Pending</span>
                                        </td>
                                        <td>
                                            29-05-2023
                                        </td>

                                    </tr>
                                    <tr class="border-t border-defaultborder dark:border-defaultborder/10">
                                        <td>
                                            02
                                        </td>
                                        <td>
                                            Tender B
                                        </td>
                                        <td>
                                            12,000
                                        </td>
                                        <td>
                                            <span class="badge bg-primary/10 text-primary">In Progress</span>
                                        </td>
                                        <td>
                                            29-05-2023
                                        </td>

                                    </tr>
                                    <tr class="border-t border-defaultborder dark:border-defaultborder/10">
                                        <td>
                                            03
                                        </td>
                                        <td>
                                            Tender C
                                        </td>
                                        <td>
                                            12,000
                                        </td>
                                        <td>
                                            <span class="badge bg-warning/10 text-warning">Pending</span>
                                        </td>
                                        <td>
                                            29-05-2023
                                        </td>

                                    </tr>
                                    <tr class="border-t border-defaultborder dark:border-defaultborder/10">
                                        <td>
                                            04
                                        </td>
                                        <td>
                                            Tender D
                                        </td>
                                        <td>
                                            12,000
                                        </td>
                                        <td>
                                            <span class="badge bg-success/10 text-success">Complete</span>
                                        </td>
                                        <td>
                                            29-05-2023
                                        </td>

                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="sm:flex items-center">
                            <div class="text-defaulttextcolor dark:text-defaulttextcolor/70">
                                Showing 5 Entries <i class="bi bi-arrow-right ms-2 font-semibold"></i>
                            </div>
                            <div class="ms-auto">
                                <nav aria-label="Page navigation" class="pagination-style-4">
                                    <ul class="ti-pagination mb-0">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="javascript:void(0);">
                                                Prev
                                            </a>
                                        </li>
                                        <li class="page-item"><a class="page-link active"
                                                href="javascript:void(0);">1</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                        <li class="page-item">
                                            <a class="page-link !text-primary" href="javascript:void(0);">
                                                next
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xl:col-span-4 col-span-12">
                    <div class="box">
                        <div class="box-header justify-between">
                            <div class="box-title">
                                Recent Reports
                            </div>
                            <div class="hs-dropdown ti-dropdown">
                                <a href="javascript:void(0);"
                                    class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                    aria-expanded="false">
                                    View All<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                </a>
                                <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu" style="">
                                    <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                            href="javascript:void(0);">Download</a></li>
                                    <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                            href="javascript:void(0);">Import</a></li>
                                    <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                            href="javascript:void(0);">Export</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="box-body">
                            <ul class="list-none project-transactions-card">
                                <li>
                                    <div class="flex items-start">
                                        <div class="me-3">
                                            <span
                                                class="avatar avatar-rounded font-bold avatar-md !text-primary bg-primary/10">
                                                S
                                            </span>
                                        </div>
                                        <div class="flex-grow">
                                            <span class="block font-semibold">Simon Cowall</span>
                                            <span class="block text-[#8c9097] dark:text-white/50 text-[0.6875rem]">Feb
                                                28,2023 - 12:54PM</span>
                                        </div>

                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-start">
                                        <div class="me-3">
                                            <span
                                                class="avatar avatar-rounded font-bold avatar-md !text-secondary bg-secondary/10">
                                                M
                                            </span>
                                        </div>
                                        <div class="flex-grow">
                                            <span class="block font-semibold">Melissa Blue</span>
                                            <span class="block text-[#8c9097] dark:text-white/50 text-[0.6875rem]">Mar
                                                28,2023 - 10:14AM</span>
                                        </div>

                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-start">
                                        <div class="me-3">
                                            <span
                                                class="avatar avatar-rounded font-bold avatar-md !text-success bg-success/10">
                                                G
                                            </span>
                                        </div>
                                        <div class="flex-grow">
                                            <span class="block font-semibold">Gabriel Shin</span>
                                            <span class="block text-[#8c9097] dark:text-white/50 text-[0.6875rem]">Mar
                                                16,2023 - 05:27PM</span>
                                        </div>

                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-start">
                                        <div class="me-3">
                                            <span
                                                class="avatar avatar-rounded font-bold avatar-md !text-warning bg-warning/10">
                                                Y
                                            </span>
                                        </div>
                                        <div class="flex-grow">
                                            <span class="block font-semibold">Yohasimi Nakiyaro</span>
                                            <span class="block text-[#8c9097] dark:text-white/50 text-[0.6875rem]">Mar
                                                19,2023 - 04:45PM</span>
                                        </div>

                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-start">
                                        <div class="me-3">
                                            <span
                                                class="avatar avatar-rounded font-bold avatar-md !text-info bg-info/10">
                                                B
                                            </span>
                                        </div>
                                        <div class="flex-grow">
                                            <span class="block font-semibold">Brenda Lynn</span>
                                            <span class="block text-[#8c9097] dark:text-white/50 text-[0.6875rem]">Mar
                                                10,2023 - 05:25PM</span>
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
