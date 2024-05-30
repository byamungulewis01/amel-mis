<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import Navbar from './Navbar.vue';

</script>

<template>
    <Navbar />
    <Sidebar />

    <!-- Start::content  -->

    <div class="content">

        <!-- Start::main-content -->
        <div class="main-content">
            <slot />
        </div>
    </div>
    <!-- End::content  -->

</template>
