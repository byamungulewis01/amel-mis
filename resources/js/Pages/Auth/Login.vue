<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';


const password = ref('');
const passwordVisible = ref(true);
const togglePasswordVisibility = () => {
    passwordVisible.value = !passwordVisible.value;
};

defineProps({
    canResetPassword: {
        type: Boolean,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />

        <div class="box">
            <div class="box-body !p-[3rem]">
                <p class="h5 font-semibold mb-2 text-center">Sign In</p>
                <p class="mb-4 text-[#8c9097] dark:text-white/50 opacity-[0.7] font-normal text-center">
                    Welcome back to our App !</p>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-12 gap-y-4">
                        <div class="xl:col-span-12 col-span-12">
                            <label for="email" class="form-label text-default">Email</label>
                            <input type="email" class="form-control form-control-lg w-full !rounded-md" id="email"
                                v-model="form.email" required autofocus placeholder="user email">
                            <InputError class="mt-2" :message="form.errors.email" />

                        </div>
                        <div class="xl:col-span-12 col-span-12 mb-2">
                            <label for="signin-password" class="form-label text-default block">Password
                                <Link v-if="canResetPassword" :href="route('password.request')" class="text-danger"
                                    style="float: right;">Forget password
                                ?</Link>

                            </label>
                            <div class="input-group">
                                <input :type="passwordVisible ? 'password' : 'text'"
                                    class="form-control form-control-lg !rounded-s-md" v-model="form.password" required
                                    placeholder="password">
                                <button aria-label="button" class="ti-btn ti-btn-light !rounded-s-none !mb-0"
                                    type="button" @click="togglePasswordVisibility">
                                    <i :class="passwordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"></i>
                                </button>

                            </div>
                            <InputError class="mt-2" :message="form.errors.password" />
                            <div class="mt-2">
                                <div class="form-check !ps-0">
                                    <Checkbox name="remember" id="defaultCheck1" v-model:checked="form.remember" />

                                    <label class="form-check-label text-[#8c9097] dark:text-white/50 font-normal"
                                        for="defaultCheck1">
                                        Remember password ?
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="xl:col-span-12 col-span-12 grid mt-2">
                            <button class="ti-btn ti-btn-primary !bg-primary !text-white !font-medium"
                                :disabled="form.processing">Sign
                                In</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </GuestLayout>
</template>
