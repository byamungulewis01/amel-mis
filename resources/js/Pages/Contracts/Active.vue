<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
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

                                        <td>
                                            <Link :href="route('contract.show', contract.id)"
                                                class="ti-btn ti-btn-primary me-1">
                                            More Details
                                            </Link>
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
