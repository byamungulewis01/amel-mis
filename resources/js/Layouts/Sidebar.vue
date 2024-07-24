<script setup>

import NavLink from '@/Components/NavLink.vue';

</script>
<template>
    <aside class="app-sidebar" id="sidebar">

        <!-- Start::main-sidebar-header -->
        <div class="main-sidebar-header">
            <a href="index.html" class="header-logo">
                <img src="/logo.png" alt="logo" class="desktop-logo">
                <img src="/logo.png" alt="logo" class="toggle-logo">
                <img src="/logo.png" alt="logo" class="desktop-dark">
                <img src="/logo.png" alt="logo" class="toggle-dark">
                <img src="/logo.png" alt="logo" class="toggle-white">
            </a>
        </div>
        <!-- End::main-sidebar-header -->

        <!-- Start::main-sidebar -->
        <div class="main-sidebar" id="sidebar-scroll">

            <!-- Start::nav -->
            <nav class="main-menu-container nav nav-pills flex-column sub-open">
                <div class="slide-left" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                        width="24" height="24" viewBox="0 0 24 24">
                        <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                    </svg></div>
                <ul class="main-menu">
                    <li class="slide">

                        <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            <i class="bx bx-home side-menu__icon"></i>
                            <span class="side-menu__label">Dashboards </span>
                        </NavLink>
                    </li>

                    <div v-if="$page.props.auth.user.department == 'manager' || $page.props.auth.user.department == 'admin'">
                        <li class="slide">
                            <NavLink :href="route('user.index')" :active="route().current('user.index')">
                                <i class="bx bx-user side-menu__icon"></i>
                                <span class="side-menu__label">Users </span>
                            </NavLink>
                        </li>
                        <li class="slide__category"><span class="category-name">Tenders</span></li>
                        <li class="slide">
                            <NavLink :href="route('tenders.list')" :active="route().current('tenders.list')">
                                <i class="bx bx-task side-menu__icon"></i>
                                <span class="side-menu__label">Tenders</span>
                            </NavLink>
                        </li>
                        <li class="slide">
                            <NavLink :href="route('contract.index')"
                            :active="route().current('contract.index')">
                                <i class="bx bx-book side-menu__icon"></i>
                                <span class="side-menu__label">Contracts</span>
                            </NavLink>
                        </li>
                        <li class="slide">
                            <NavLink :href="route('cashRequest.manager')" :active="route().current('cashRequest.manager')">
                                <i class="bx bx-bar-chart-square side-menu__icon"></i>
                                <span class="side-menu__label">Cash Requests</span>
                            </NavLink>
                        </li>
                        <li class="slide__category"><span class="category-name">Reports & Goals</span></li>

                        <li class="slide">
                            <NavLink :href="route('weekly_reports.list')"
                                :active="route().current('weekly_reports.list') || route().current('weekly-reports.show')">
                                <i class="bx bx-book side-menu__icon"></i>
                                <span class="side-menu__label">Reports</span>
                            </NavLink>
                        </li>

                    </div>
                    <div v-if="$page.props.auth.user.department == 'field'">
                        <li class="slide__category"><span class="category-name">Tenders</span></li>
                        <li class="slide">
                            <NavLink :href="route('contract.activeContracts')" :active="route().current('contract.activeContracts')">
                                <i class="bx bx-task side-menu__icon"></i>
                                <span class="side-menu__label">Tenders<span class="text-secondary text-[0.75em] rounded-sm badge !py-[0.25rem] !px-[0.45rem] !bg-secondary/10 ms-2">New</span></span>
                            </NavLink>
                        </li>
                        <li class="slide">
                            <NavLink :href="route('cashRequest.field')" :active="route().current('cashRequest.field')">
                                <i class="bx bx-bar-chart-square side-menu__icon"></i>
                                <span class="side-menu__label">Cash Requests</span>
                            </NavLink>
                        </li>

                        <li class="slide__category"><span class="category-name">Reports & Goals</span></li>

                        <li class="slide">
                            <NavLink :href="route('weekly-reports.index')"
                                :active="route().current('weekly-reports.index') || route().current('weekly-reports.create') || route().current('weekly-reports.edit') || route().current('weekly-reports.show')">
                                <i class="bx bx-book side-menu__icon"></i>
                                <span class="side-menu__label">Reports</span>
                            </NavLink>
                        </li>
                    </div>
                    <div v-if="$page.props.auth.user.department == 'finance'">
                        <li class="slide">
                            <NavLink :href="route('tenders.index')" :active="route().current('tenders.index')">
                                <i class="bx bx-task side-menu__icon"></i>
                                <span class="side-menu__label">Tenders</span>
                            </NavLink>
                        </li>

                    </div>
                    <div v-if="$page.props.auth.user.department == 'procurement'">
                        <li class="slide">
                            <NavLink :href="route('contract.index')"
                            :active="route().current('contract.index')">
                                <i class="bx bx-book side-menu__icon"></i>
                                <span class="side-menu__label">Contracts</span>
                            </NavLink>
                        </li>
                        <li class="slide">
                            <NavLink :href="route('monthly-tenders.index')" :active="route().current('monthly-tenders.index') || route().current('tenders.index') || route().current('tenders.create') || route().current('tenders.edit') || route().current('tenders.show')">
                                <i class="bx bx-task side-menu__icon"></i>
                                <span class="side-menu__label">Tenders</span>
                            </NavLink>
                        </li>

                    </div>

                </ul>

            </nav>
            <!-- End::nav -->

        </div>
        <!-- End::main-sidebar -->

    </aside>
</template>
