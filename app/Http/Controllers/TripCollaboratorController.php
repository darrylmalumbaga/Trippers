<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;
use App\Models\TripCollaborator;
use Illuminate\Http\Request;

class TripCollaboratorController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        if ($trip->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if ($trip->collaborators->contains($user) || $trip->user_id === $user->id) {
            return back()->withErrors(['email' => 'User is already a collaborator.']);
        }

        $trip->collaborators()->attach($user->id, ['role' => 'editor']);

        return back();
    }

    public function destroy(TripCollaborator $collaborator)
    {
        $trip = $collaborator->trip;

        if ($trip->user_id !== auth()->id()) {
            abort(403);
        }

        $collaborator->delete();

        return back();
    }
}
