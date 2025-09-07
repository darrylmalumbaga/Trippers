<template>
    <div>
        <h1>Authenticating...</h1>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    code: String,
});

onMounted(() => {
    router.post('/authenticate', {
        code: props.code,
    });
});
</script>
