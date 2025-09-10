<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import type { Trip } from '@/types';
import { Link, router } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';

defineProps<{
    trips: Trip[];
}>();

const duplicateTrip = (id: number) => {
    router.post(`/trips/${id}/duplicate`);
};

const editTrip = (id: number) => {
    router.get(`/trips/${id}/edit`);
};
</script>

<template>
    <AppLayout>
        <div class="flex items-center">
            <div class="flex-1">
                <h1 class="text-lg font-semibold md:text-2xl">Trips</h1>
                <p class="text-sm text-muted-foreground">Here are the trips you have planned.</p>
            </div>

            <Link href="/trips/create">
                <Button>
                    <Plus class="mr-2 h-4 w-4" />
                    New Trip
                </Button>
            </Link>
        </div>

        <div class="mt-4 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <Card v-for="trip in trips" :key="trip.id">
                <CardHeader>
                    <CardTitle>{{ trip.name }}</CardTitle>
                    <CardDescription>{{ trip.destination }}</CardDescription>
                </CardHeader>
                <CardContent>
                    <p v-if="trip.start_date && trip.end_date">{{ trip.start_date }} - {{ trip.end_date }}</p>
                    <p v-if="trip.days_left !== null && trip.days_left >= 0">In {{ trip.days_left }} days</p>
                    <Link :href="`/trips/${trip.id}`" class="btn btn-secondary mt-4"> View Trip </Link>
                    <Button @click="editTrip(trip.id)" class="mt-4 ml-2"> Edit Trip </Button>
                    <Button @click="duplicateTrip(trip.id)" class="mt-4 ml-2"> Duplicate </Button>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
