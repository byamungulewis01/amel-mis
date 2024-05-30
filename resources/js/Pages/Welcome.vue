<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const password = ref('');
const passwordVisible = ref(true);
const togglePasswordVisibility = () => {
    passwordVisible.value = !passwordVisible.value;
};

</script>

<template>

    <Head title="Welcome" />
    <div class="container">
        <div
            class="flex justify-center authentication authentication-basic items-center h-full text-defaultsize text-defaulttextcolor">
            <div class="grid grid-cols-12">
                <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-4 md:col-span-3 sm:col-span-2"></div>
                <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-4 md:col-span-6 sm:col-span-8 col-span-12">
                    <div class="my-[2.5rem] flex justify-center">
                        <a href="">
                            <img src="assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo" />
                            <img src="assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark" />
                        </a>
                    </div>
                    <div class="box">
                        <div class="box-body !p-[3rem]">
                            <p class="h5 font-semibold mb-2 text-center">Sign In</p>
                            <p class="mb-4 text-[#8c9097] dark:text-white/50 opacity-[0.7] font-normal text-center">
                                Welcome back Jhon !</p>
                            <div class="grid grid-cols-12 gap-y-4">
                                <div class="xl:col-span-12 col-span-12">
                                    <label for="signin-username" class="form-label text-default">User Name</label>
                                    <input type="text" class="form-control form-control-lg w-full !rounded-md"
                                        id="signin-username" placeholder="user name">
                                </div>
                                <div class="xl:col-span-12 col-span-12 mb-2">
                                    <label for="signin-password" class="form-label text-default block">Password<a
                                            href="" class="text-danger" style="float: right;">Forget password
                                            ?</a></label>
                                    <div class="input-group">
                                        <input :type="passwordVisible ? 'password' : 'text'" class="form-control form-control-lg !rounded-s-md"
                                            v-model="password" placeholder="password">
                                        <button aria-label="button" class="ti-btn ti-btn-light !rounded-s-none !mb-0"
                                            type="button" @click="togglePasswordVisibility">
                                            <i :class="passwordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"></i>
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        <div class="form-check !ps-0">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            <label
                                                class="form-check-label text-[#8c9097] dark:text-white/50 font-normal"
                                                for="defaultCheck1">
                                                Remember password ?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="xl:col-span-12 col-span-12 grid mt-2">
                                    <a href="" class="ti-btn ti-btn-primary !bg-primary !text-white !font-medium">Sign
                                        In</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
