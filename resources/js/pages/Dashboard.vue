<script setup lang="ts">
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem, type Trip } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    trips: Trip[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="flex items-center">
                <div class="flex-1">
                    <h1 class="text-lg font-semibold md:text-2xl">Recent Trips</h1>
                    <p class="text-sm text-muted-foreground">Here are your 3 most recent trips.</p>
                </div>
            </div>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <Card v-for="trip in trips" :key="trip.id">
                    <CardHeader>
                        <CardTitle>{{ trip.name }}</CardTitle>
                        <CardDescription>{{ trip.destination }}</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <p v-if="trip.start_date && trip.end_date">{{ trip.start_date }} - {{ trip.end_date }}</p>
                        <p v-if="trip.days_left !== null && trip.days_left >= 0">In {{ trip.days_left }} days</p>
                        <Link :href="`/trips/${trip.id}`" class="btn btn-secondary mt-4"> View Trip </Link>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>