<x-mail::message>
# You have been invited to a trip!

{{ $user->name }} has invited you to join the trip "{{ $trip->name }}".

<x-mail::button :url="route('trips.show', $trip)">
View Trip
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>