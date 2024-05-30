<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>

    <div class="box-body !pb-[0.9rem]">
        <div class="sm:p-4 p-0">
            <h6 class="font-semibold mb-4 text-[1rem]">
                Reset Password
            </h6>
            <p class="text-[0.75rem] text-[#8c9097] dark:text-white/50 mb-5">Password should be
                min
                of <b class="text-success">8 digits<sup>*</sup></b>,atleast <b class="text-success">One Capital
                    letter<sup>*</sup></b> and <b class="text-success">One Special Character<sup>*</sup></b> included.
            </p>
            <form @submit.prevent="updatePassword">

                <div class="mb-2">
                    <InputLabel for="current_password" value="Current Password" />

                    <TextInput id="current_password" ref="currentPasswordInput" v-model="form.current_password"
                        type="password" class="mt-1 block w-full" autocomplete="current-password" />

                    <InputError :message="form.errors.current_password" class="mt-2" />
                </div>
                <div class="mb-2">
                    <InputLabel for="password" value="New Password" />
                    <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                        class="mt-1 block w-full" autocomplete="new-password" />

                    <InputError :message="form.errors.password" class="mt-2" />

                    <InputLabel for="password_confirmation" value="Confirm Password" />
                </div>
                <div class="mb-4">
                    <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                        class="mt-1 block w-full" autocomplete="new-password" />

                    <InputError :message="form.errors.password_confirmation" class="mt-2" />
                </div>

                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
            </form>

        </div>
    </div>
</template>
