<template>
    <div>
        <h1>Authenticating...</h1>
    </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    code: String,
});

onMounted(() => {
    router.post('/authenticate', {
        code: props.code,
    });
});
</script>
