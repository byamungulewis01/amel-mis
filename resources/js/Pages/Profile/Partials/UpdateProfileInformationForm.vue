<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    phone: user.phone,
});
</script>

<template>
    <div class="box-body !pb-[0.9rem]">
        <h6 class="font-semibold mb-4 text-[1rem]">
            Personal information
        </h6>
        <form @submit.prevent="form.patch(route('profile.update'))">
            <div class="sm:p-4 p-0">
                <h6 class="font-semibold mb-4 text-[1rem]">
                    Photo :
                </h6>
                <div class="mb-6 sm:flex items-center">
                    <div class="mb-0 me-[3rem]">
                        <span class="avatar avatar-xxl avatar-rounded">
                            <img src="assets/images/faces/9.jpg" alt="" id="profile-img">
                            <a aria-label="anchor" href="javascript:void(0);"
                                class="badge rounded-full bg-primary avatar-badge">
                                <input type="file" name="photo" class="absolute w-full h-full opacity-0"
                                    id="profile-image">
                                <i class="fe fe-camera !text-[0.65rem]"></i>
                            </a>
                        </span>
                    </div>
                    <div class="inline-flex">
                        <button type="button"
                            class="ti-btn bg-primary text-white !rounded-e-none !font-medium ">Change</button>
                        <button type="button" class="ti-btn ti-btn-light !font-medium !rounded-s-none">Remove</button>
                    </div>
                </div>

                <div class="sm:grid grid-cols-12 gap-6 mb-4">
                    <div class="xl:col-span-12 col-span-12">
                        <InputLabel for="name" value="Full Name :" />

                        <TextInput id="name" type="text" v-model="form.name" required autofocus autocomplete="name" />
                        <InputError class="mt-2" :message="form.errors.name" />

                    </div>
                    <div class="xl:col-span-12 col-span-12">
                        <InputLabel for="email" value="Email Address :" />

                        <TextInput id="email" type="email" v-model="form.email" required autocomplete="username" />
                        <InputError class="mt-2" :message="form.errors.email" />

                    </div>
                    <div class="xl:col-span-12 col-span-12">
                        <InputLabel for="phone" value="Contact Phone :" />
                        <TextInput id="phone" type="text" v-model="form.phone" required autocomplete="username" />
                        <InputError class="mt-2" :message="form.errors.phone" />

                    </div>
                </div>
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

            </div>
        </form>
    </div>
    <!-- <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section> -->
</template>
