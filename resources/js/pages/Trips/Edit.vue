<script setup lang="ts">
import DestinationAutocomplete from '@/components/DestinationAutocomplete.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import type { Trip } from '@/types';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    trip: Trip;
}>();

const form = useForm({
    name: props.trip.name,
    destination: props.trip.destination,
    start_date: props.trip.start_date,
    end_date: props.trip.end_date,
    description: props.trip.description,
    trip_type: props.trip.trip_type,
    privacy_level: props.trip.privacy_level,
});

const submit = () => {
    form.put('/trips/' + props.trip.id);
};
</script>

<template>
    <AppLayout>
        <h1 class="text-lg font-semibold md:text-2xl">Edit trip</h1>

        <Card class="mt-4">
            <CardHeader>
                <CardTitle>Trip Details</CardTitle>
                <CardDescription> Update the details below. </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit">
                    <div class="grid gap-4">
                        <div class="grid gap-2">
                            <label for="name">Name</label>
                            <Input id="name" v-model="form.name" />
                            <div v-if="form.errors.name" class="text-sm text-red-500">
                                {{ form.errors.name }}
                            </div>
                        </div>
                        <div class="grid gap-2">
                            <label for="destination">Destination</label>
                            <DestinationAutocomplete id="destination" v-model="form.destination" />
                            <div v-if="form.errors.destination" class="text-sm text-red-500">
                                {{ form.errors.destination }}
                            </div>
                        </div>
                        <div class="grid gap-2">
                            <label for="trip_type">Trip Type</label>
                            <select id="trip_type" v-model="form.trip_type" class="w-full rounded-md border px-3 py-2">
                                <option value="">Select a trip type</option>
                                <option value="solo">Solo</option>
                                <option value="group">Group</option>
                                <option value="business">Business</option>
                                <option value="road_trip">Road Trip</option>
                            </select>
                            <div v-if="form.errors.trip_type" class="text-sm text-red-500">
                                {{ form.errors.trip_type }}
                            </div>
                        </div>
                        <div class="grid gap-2">
                            <label for="privacy_level">Privacy</label>
                            <select id="privacy_level" v-model="form.privacy_level" class="w-full rounded-md border px-3 py-2">
                                <option value="private">Private</option>
                                <option value="public">Public</option>
                                <option value="shared">Shared</option>
                            </select>
                            <div v-if="form.errors.privacy_level" class="text-sm text-red-500">
                                {{ form.errors.privacy_level }}
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="grid gap-2">
                                <label for="start_date">Start Date</label>
                                <Input id="start_date" type="date" v-model="form.start_date" class="w-full" />
                                <div v-if="form.errors.start_date" class="text-sm text-red-500">
                                    {{ form.errors.start_date }}
                                </div>
                            </div>
                            <div class="grid gap-2">
                                <label for="end_date">End Date</label>
                                <Input id="end_date" type="date" v-model="form.end_date" class="w-full" />
                                <div v-if="form.errors.end_date" class="text-sm text-red-500">
                                    {{ form.errors.end_date }}
                                </div>
                            </div>
                        </div>
                        <div class="grid gap-2">
                            <label for="description">Description</label>
                            <Textarea id="description" v-model="form.description" />
                            <div v-if="form.errors.description" class="text-sm text-red-500">
                                {{ form.errors.description }}
                            </div>
                        </div>
                        <Button type="submit" :disabled="form.processing"> Update Trip </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </AppLayout>
</template>
