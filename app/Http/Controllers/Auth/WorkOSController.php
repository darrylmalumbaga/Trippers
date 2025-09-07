<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkOSController extends Controller
{
    public function login()
    {
        $authorizationUrl = (new \WorkOS\SSO())
            ->getAuthorizationUrl([
                'clientId' => config('workos.client_id'),
                'redirectUri' => config('workos.redirect_uri'),
            ]);

        return redirect($authorizationUrl);
    }

    public function callback(Request $request)
    {
        return inertia('Authenticating', [
            'code' => $request->get('code'),
        ]);
    }

    public function handleCallback(Request $request)
    {
        $profile = (new \WorkOS\SSO())->getProfileAndToken([
            'code' => $request->get('code'),
            'clientId' => config('workos.client_id'),
        ])->profile;

        $user = \App\Models\User::where('workos_id', $profile->id)->first();

        if (!$user) {
            $user = new \App\Models\User();
            $user->name = $profile->firstName . ' ' . $profile->lastName;
            $user->email = $profile->email;
            $user->workos_id = $profile->id;
            $user->workos_organization_id = $profile->organizationId;
            $user->save();
        }

        auth()->login($user);

        return redirect('/');
    }
}
