<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';


const darkMode = ref(false);

const toggleDarkMode = () => {
    if (darkMode.value) {
        document.documentElement.classList.remove('dark');
        localStorage.removeItem('layout-theme');
        localStorage.removeItem('ynexdarktheme');
        localStorage.removeItem('ynexMenu');
        localStorage.removeItem('ynexHeader');
        localStorage.removeItem('darkBgRGB');
        localStorage.removeItem('bodyBgRGB');
        document.documentElement.setAttribute('data-menu-styles', 'dark');
        document.documentElement.setAttribute('data-header-styles', 'light');
        document.documentElement.style.removeProperty('--body-bg');
        document.documentElement.style.removeProperty('--dark-bg');
        document.documentElement.style.removeProperty('--body-bg-rgb');
        document.documentElement.style.removeProperty('--body-bg-rgb2');
        document.documentElement.style.removeProperty('--light');
        document.documentElement.style.removeProperty('--form-control-bg');
        document.documentElement.style.removeProperty('--input-border');

        if (localStorage.getItem('ynexlayout') === 'horizontal') {
            document.documentElement.setAttribute('data-menu-styles', 'light');
        }

        if (document.querySelector('#hs-overlay-switcher')) {
            document.getElementById('switcher-light-theme').checked = true;
        }
    } else {
        if (document.querySelector('#hs-overlay-switcher')) {
            document.getElementById('switcher-dark-theme').checked = true;
        }

        document.documentElement.setAttribute('class', 'dark');
        localStorage.setItem('layout-theme', 'dark');
        document.documentElement.setAttribute('data-header-styles', 'dark');
        document.documentElement.setAttribute('data-menu-styles', 'dark');
        localStorage.removeItem('ynexMenu');
        localStorage.removeItem('ynexHeader');
        localStorage.setItem('ynexdarktheme', true);
        localStorage.removeItem('ynexlighttheme');
        localStorage.setItem('ynexMenu', 'dark');
        localStorage.setItem('ynexHeader', 'dark');
    }
    darkMode.value = !darkMode.value;
};

</script>

<template>

    <header class="app-header">
        <nav class="main-header !h-[3.75rem]" aria-label="Global">
            <div class="main-header-container ps-[0.725rem] pe-[1rem] ">

                <div class="header-content-left">
                    <!-- Start::header-element -->
                    <div class="header-element">
                        <div class="horizontal-logo">
                            <a href="index.html" class="header-logo">
                                <img src="/assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
                                <img src="/assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
                                <img src="/assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
                                <img src="/assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
                                <img src="/assets/images/brand-logos/desktop-white.png" alt="logo" class="desktop-white">
                                <img src="/assets/images/brand-logos/toggle-white.png" alt="logo" class="toggle-white">
                            </a>
                        </div>
                    </div>
                    <!-- End::header-element -->
                    <!-- Start::header-element -->
                    <div class="header-element md:px-[0.325rem] !items-center">
                        <a aria-label="Hide Sidebar"
                            class="sidemenu-toggle animated-arrow  hor-toggle horizontal-navtoggle inline-flex items-center"
                            href="javascript:void(0);"><span></span></a>
                    </div>
                    <!-- End::header-element -->
                </div>



                <div class="header-content-right">

                    <!-- light and dark theme -->
                    <div
                        class="header-element header-theme-mode hidden !items-center sm:block !py-[1rem] md:!px-[0.65rem] px-2">
                        <a aria-label="Toggle dark mode" href="javascript:void(0);" class="header-link-toggle"
                            @click="toggleDarkMode">
                            <i :class="darkMode ? 'bx bx-moon header-link-icon' : 'bx bx-sun header-link-icon'"></i>
                        </a>
                    </div>


                    <!--Header Notifictaion -->
                    <div
                        class="header-element py-[1rem] md:px-[0.65rem] px-2 notifications-dropdown header-notification hs-dropdown ti-dropdown !hidden md:!block [--placement:bottom-left]">
                        <button id="dropdown-notification" type="button"
                            class="hs-dropdown-toggle relative ti-dropdown-toggle !p-0 !border-0 flex-shrink-0  !rounded-full !shadow-none align-middle text-xs">
                            <i class="bx bx-bell header-link-icon  text-[1.125rem]"></i>
                            <span class="flex absolute h-5 w-5 -top-[0.25rem] end-0  -me-[0.6rem]">
                                <span
                                    class="animate-slow-ping absolute inline-flex -top-[2px] -start-[2px] h-full w-full rounded-full bg-secondary/40 opacity-75"></span>
                                <span
                                    class="relative inline-flex justify-center items-center rounded-full  h-[14.7px] w-[14px] bg-secondary text-[0.625rem] text-white"
                                    id="notification-icon-badge">5</span>
                            </span>
                        </button>
                        <div class="main-header-dropdown !-mt-3 !p-0 hs-dropdown-menu ti-dropdown-menu bg-white !w-[22rem] border-0 border-defaultborder hidden !m-0"
                            aria-labelledby="dropdown-notification">

                            <div class="ti-dropdown-header !m-0 !p-4 !bg-transparent flex justify-between items-center">
                                <p
                                    class="mb-0 text-[1.0625rem] text-defaulttextcolor font-semibold dark:text-[#8c9097] dark:text-white/50">
                                    Notifications</p>
                                <span
                                    class="text-[0.75em] py-[0.25rem/2] px-[0.45rem] font-[600] rounded-sm bg-secondary/10 text-secondary"
                                    id="notifiation-data">5 Unread</span>
                            </div>
                            <div class="dropdown-divider"></div>
                            <ul class="list-none !m-0 !p-0 end-0" id="header-notification-scroll">
                                <li class="ti-dropdown-item dropdown-item ">
                                    <div class="flex items-start">
                                        <div class="pe-2">
                                            <span
                                                class="inline-flex text-primary justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem] !bg-primary/10 !rounded-[50%]"><i
                                                    class="ti ti-gift text-[1.125rem]"></i></span>
                                        </div>
                                        <div class="grow flex items-center justify-between">
                                            <div>
                                                <p
                                                    class="mb-0 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50 text-[0.8125rem] font-semibold">
                                                    <a href="notifications.html">Your Order Has Been Shipped</a>
                                                </p>
                                                <span
                                                    class="text-[#8c9097] dark:text-white/50 font-normal text-[0.75rem] header-notification-text">Order
                                                    No: 123456
                                                    Has Shipped To Your Delivery Address</span>
                                            </div>
                                            <div>
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="min-w-fit text-[#8c9097] dark:text-white/50 me-1 dropdown-item-close1"><i
                                                        class="ti ti-x text-[1rem]"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="ti-dropdown-item dropdown-item !flex-none">
                                    <div class="flex items-start">
                                        <div class="pe-2">
                                            <span
                                                class="inline-flex text-secondary justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem]  bg-secondary/10 rounded-[50%]"><i
                                                    class="ti ti-discount-2 text-[1.125rem]"></i></span>
                                        </div>
                                        <div class="grow flex items-center justify-between">
                                            <div>
                                                <p
                                                    class="mb-0 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50 text-[0.8125rem]  font-semibold">
                                                    <a href="notifications.html">Discount Available</a>
                                                </p>
                                                <span
                                                    class="text-[#8c9097] dark:text-white/50 font-normal text-[0.75rem] header-notification-text">Discount
                                                    Available On Selected Products</span>
                                            </div>
                                            <div>
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="min-w-fit  text-[#8c9097] dark:text-white/50 me-1 dropdown-item-close1"><i
                                                        class="ti ti-x text-[1rem]"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="ti-dropdown-item dropdown-item">
                                    <div class="flex items-start">
                                        <div class="pe-2">
                                            <span
                                                class="inline-flex text-pink justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem]  bg-pink/10 rounded-[50%]"><i
                                                    class="ti ti-user-check text-[1.125rem]"></i></span>
                                        </div>
                                        <div class="grow flex items-center justify-between">
                                            <div>
                                                <p
                                                    class="mb-0 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50 text-[0.8125rem]  font-semibold">
                                                    <a href="notifications.html">Account Has Been Verified</a>
                                                </p>
                                                <span
                                                    class="text-[#8c9097] dark:text-white/50 font-normal text-[0.75rem] header-notification-text">Your
                                                    Account Has
                                                    Been Verified Sucessfully</span>
                                            </div>
                                            <div>
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="min-w-fit text-[#8c9097] dark:text-white/50 me-1 dropdown-item-close1"><i
                                                        class="ti ti-x text-[1rem]"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="ti-dropdown-item dropdown-item">
                                    <div class="flex items-start">
                                        <div class="pe-2">
                                            <span
                                                class="inline-flex text-warning justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem]  bg-warning/10 rounded-[50%]"><i
                                                    class="ti ti-circle-check text-[1.125rem]"></i></span>
                                        </div>
                                        <div class="grow flex items-center justify-between">
                                            <div>
                                                <p
                                                    class="mb-0 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50  text-[0.8125rem]  font-semibold">
                                                    <a href="notifications.html">Order Placed <span
                                                            class="text-warning">ID: #1116773</span></a>
                                                </p>
                                                <span
                                                    class="text-[#8c9097] dark:text-white/50 font-normal text-[0.75rem] header-notification-text">Order
                                                    Placed
                                                    Successfully</span>
                                            </div>
                                            <div>
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="min-w-fit text-[#8c9097] dark:text-white/50 me-1 dropdown-item-close1"><i
                                                        class="ti ti-x text-[1rem]"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="ti-dropdown-item dropdown-item">
                                    <div class="flex items-start">
                                        <div class="pe-2">
                                            <span
                                                class="inline-flex text-success justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem]  bg-success/10 rounded-[50%]"><i
                                                    class="ti ti-clock text-[1.125rem]"></i></span>
                                        </div>
                                        <div class="grow flex items-center justify-between">
                                            <div>
                                                <p
                                                    class="mb-0 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50  text-[0.8125rem]  font-semibold">
                                                    <a href="notifications.html">Order Delayed <span
                                                            class="text-success">ID: 7731116</span></a>
                                                </p>
                                                <span
                                                    class="text-[#8c9097] dark:text-white/50 font-normal text-[0.75rem] header-notification-text">Order
                                                    Delayed
                                                    Unfortunately</span>
                                            </div>
                                            <div>
                                                <a aria-label="anchor" href="javascript:void(0);"
                                                    class="min-w-fit text-[#8c9097] dark:text-white/50 me-1 dropdown-item-close1"><i
                                                        class="ti ti-x text-[1rem]"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <div class="p-4 empty-header-item1 border-t mt-2">
                                <div class="grid">
                                    <a href="notifications.html" class="ti-btn ti-btn-primary-full !m-0 w-full p-2">View
                                        All</a>
                                </div>
                            </div>
                            <div class="p-[3rem] empty-item1 hidden">
                                <div class="text-center">
                                    <span
                                        class="!h-[4rem]  !w-[4rem] avatar !leading-[4rem] !rounded-full !bg-secondary/10 !text-secondary">
                                        <i class="ri-notification-off-line text-[2rem]  "></i>
                                    </span>
                                    <h6
                                        class="font-semibold mt-3 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50 text-[1rem]">
                                        No New Notifications</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Header Notifictaion -->

                    <!-- Header Profile -->
                    <div
                        class="header-element md:!px-[0.65rem] px-2 hs-dropdown !items-center ti-dropdown [--placement:bottom-left]">

                        <button id="dropdown-profile" type="button"
                            class="hs-dropdown-toggle ti-dropdown-toggle !gap-2 !p-0 flex-shrink-0 sm:me-2 me-0 !rounded-full !shadow-none text-xs align-middle !border-0 !shadow-transparent ">
                            <img class="inline-block rounded-full " src="/assets/images/faces/9.jpg" width="32"
                                height="32" alt="Image Description">
                        </button>
                        <div class="md:block hidden dropdown-profile">
                            <p class="font-semibold mb-0 leading-none text-[#536485] text-[0.813rem] ">{{
                                $page.props.auth.user.name }}</p>
                            <span
                                class="opacity-[0.7] font-normal text-[#536485] block text-[0.6875rem] ">{{ $page.props.auth.user.department.toUpperCase() }}</span>
                        </div>
                        <div class="hs-dropdown-menu ti-dropdown-menu !-mt-3 border-0 w-[11rem] !p-0 border-defaultborder hidden main-header-dropdown  pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                            aria-labelledby="dropdown-profile">

                            <ul class="text-defaulttextcolor font-medium dark:text-[#8c9097] dark:text-white/50">
                                <li>
                                    <Link class="w-full ti-dropdown-item !text-[0.8125rem] !gap-x-0  !p-[0.65rem] !inline-flex"
                                    :href="route('profile.edit')">
                                        <i class="ti ti-user-circle text-[1.125rem] me-2 opacity-[0.7]"></i>Profile
                                    </Link>
                                </li>

                                <li><Link class="w-full ti-dropdown-item !text-[0.8125rem] !p-[0.65rem] !gap-x-0 !inline-flex"
                                    :href="route('logout')" method="post" as="button"><i
                                            class="ti ti-logout text-[1.125rem] me-2 opacity-[0.7]"></i>Log Out</Link></li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Header Profile -->
                </div>
            </div>
        </nav>
    </header>

</template>
