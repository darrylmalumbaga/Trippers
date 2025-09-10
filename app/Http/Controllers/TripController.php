<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $trips = $request->user()->trips()->latest()->get()->map(function ($trip) {
            $trip->days_left = $trip->start_date ? Carbon::now()->diffInDays(Carbon::parse($trip->start_date), false) : null;
            return $trip;
        });

        return Inertia::render('Trips/Index', [
            'trips' => $trips,
        ]);
    }

    public function create()
    {
        return Inertia::render('Trips/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'destination' => 'nullable|string|max:255',
            'trip_type' => 'nullable|string|max:255',
            'privacy_level' => 'required|string|in:private,public,shared',
        ]);

        $request->user()->trips()->create($validated);

        return redirect()->route('trips.index');
    }

    public function show(Trip $trip)
    {
        if ($trip->user_id !== auth()->id() && !$trip->collaborators->contains(auth()->user())) {
            abort(403);
        }

        $trip->load('user', 'tripCollaborators.user');

        return Inertia::render('Trips/Show', [
            'trip' => $trip,
        ]);
    }

    public function edit(Trip $trip)
    {
        if ($trip->user_id !== auth()->id()) {
            abort(403);
        }
        return Inertia::render('Trips/Edit', [
            'trip' => $trip,
        ]);
    }

    public function update(Request $request, Trip $trip)
    {
        if ($trip->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'destination' => 'nullable|string|max:255',
            'trip_type' => 'nullable|string|max:255',
            'privacy_level' => 'required|string|in:private,public,shared',
        ]);

        $trip->update($validated);

        return redirect()->route('trips.index');
    }

    public function destroy(Trip $trip)
    {
        if ($trip->user_id !== auth()->id()) {
            abort(403);
        }

        $trip->delete();

        return redirect()->route('trips.index');
    }

    public function duplicate(Request $request, Trip $trip)
    {
        if ($trip->user_id !== auth()->id()) {
            abort(403);
        }

        $newTrip = $trip->replicate();
        $newTrip->name = 'Copy of ' . $trip->name;
        $newTrip->created_at = now();
        $newTrip->updated_at = now();
        $newTrip->save();

        return redirect()->route('trips.index');
    }
}