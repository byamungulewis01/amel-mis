<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import Navbar from './Navbar.vue';
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

const props = computed(() => page.props);

watch(props, (newProps) => {
  if (newProps.flash.message) {
    toast(newProps.flash.message, {
      theme: 'dark',
      type: 'success',
      dangerouslyHTMLString: true,
    });
  }
  if (newProps.flash.warning) {
    toast(newProps.flash.warning, {
      theme: 'dark',
      type: 'warning',
      dangerouslyHTMLString: true,
    });
  }
  if (newProps.flash.error) {
    toast(newProps.flash.error, {
      theme: 'dark',
      type: 'error',
      dangerouslyHTMLString: true,
    });
  }
}, { immediate: true });

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
