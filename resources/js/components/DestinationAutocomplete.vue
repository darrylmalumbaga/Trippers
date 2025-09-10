<script setup lang="ts">
import { onMounted, ref } from 'vue';

defineProps<{
    modelValue: string | null;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string | null): void;
}>();

const autocomplete = ref<HTMLElement | null>(null);

onMounted(() => {
    const autocompleteElement = autocomplete.value;
    if (autocompleteElement) {
        autocompleteElement.addEventListener('gmp-placeselect', (event: any) => {
            const place = event.place;
            if (place) {
                emit('update:modelValue', place.formattedAddress);
            }
        });
    }
});
</script>

<template>
    <gmp-autocomplete ref="autocomplete" class="w-full">
        <input
            :value="modelValue"
            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50"
        />
    </gmp-autocomplete>
</template>
