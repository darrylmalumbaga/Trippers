<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import type { Trip } from '@/types';
import { useForm, router } from '@inertiajs/vue3';

const props = defineProps<{
    trip: Trip;
}>();

const inviteForm = useForm({
    email: '',
});

const inviteCollaborator = () => {
    inviteForm.post(`/trips/${props.trip.id}/collaborators`);
};

const removeCollaborator = (id: number) => {
    router.delete(`/trips/collaborators/${id}`);
};
</script>

<template>
    <AppLayout>
        <div class="flex items-center">
            <div class="flex-1">
                <h1 class="text-lg font-semibold md:text-2xl">
                    {{ trip.name }}
                </h1>
                <p class="text-sm text-muted-foreground">
                    {{ trip.destination }}
                </p>
            </div>
        </div>

        <Card class="mt-4">
            <CardHeader>
                <CardTitle>Trip Details</CardTitle>
            </CardHeader>
            <CardContent>
                <div v-if="trip.start_date && trip.end_date">
                    <p><strong>Dates:</strong> {{ trip.start_date }} - {{ trip.end_date }}</p>
                </div>
                <p><strong>Description:</strong> {{ trip.description }}</p>
            </CardContent>
        </Card>

        <Card class="mt-4">
            <CardHeader>
                <CardTitle>Collaborators</CardTitle>
            </CardHeader>
            <CardContent>
                <div>
                    <p><strong>Owner:</strong> {{ trip.user.name }}</p>
                </div>
                <div class="mt-4">
                    <h3 class="font-semibold">Collaborators</h3>
                    <ul>
                        <li v-for="collaborator in trip.trip_collaborators" :key="collaborator.id" class="flex items-center justify-between">
                            <span>{{ collaborator.user.name }}</span>
                            <Button @click="removeCollaborator(collaborator.id)" variant="destructive" size="sm"> Remove </Button>
                        </li>
                    </ul>
                </div>
                <div class.bind="mt-4">
                    <h3 class="font-semibold">Invite a collaborator</h3>
                    <form @submit.prevent="inviteCollaborator">
                        <div class="flex gap-2">
                            <Input type="email" v-model="inviteForm.email" placeholder="Email address" />
                            <Button type="submit">Invite</Button>
                        </div>
                    </form>
                </div>
            </CardContent>
        </Card>
    </AppLayout>
</template>
