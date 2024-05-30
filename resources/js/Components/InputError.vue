<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
        <p v-show="message" class="text-danger text-[0.6875rem]">
            {{ message }}
        </p>
</template>
