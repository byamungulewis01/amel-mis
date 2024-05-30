<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
defineProps({
    status: {
        type: String,
    },
});

</script>

<template>
    <div class="container">
        <div
            class="flex justify-center authentication authentication-basic items-center h-full text-defaultsize text-defaulttextcolor">
            <div class="grid grid-cols-12">
                <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-4 md:col-span-3 sm:col-span-2"></div>
                <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-4 md:col-span-6 sm:col-span-8 col-span-12">
                    <div class="my-[2.5rem] flex justify-center">
                        <a href="">
                            <img src="/logo.png" width="80" alt="logo" class="desktop-logo" />
                            <img src="/logo.png" width="80" alt="logo" class="desktop-dark" />
                        </a>
                    </div>
                    <div v-if="status" class="alert alert-warning flex items-center" role="alert">
                        <svg class="sm:flex-shrink-0 me-2 fill-warning" xmlns="http://www.w3.org/2000/svg"
                            enable-background="new 0 0 24 24" height="1.5rem" viewBox="0 0 24 24" width="1.5rem"
                            fill="#000000">
                            <g>
                                <rect fill="none" height="24" width="24" />
                            </g>
                            <g>
                                <g>
                                    <g>
                                        <path d="M12,5.99L19.53,19H4.47L12,5.99 M12,2L1,21h22L12,2L12,2z" />
                                        <polygon points="13,16 11,16 11,18 13,18" />
                                        <polygon points="13,10 11,10 11,15 13,15" />
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <div>
                            {{ status }}
                        </div>
                    </div>
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
