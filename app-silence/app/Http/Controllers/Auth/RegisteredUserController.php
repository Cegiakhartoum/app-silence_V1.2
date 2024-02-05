<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
                // Send user data to Intercom
                $this->sendToIntercom($user);

        return redirect(RouteServiceProvider::HOME);
    }
    /**
     * Send user data to Intercom.
     */
    protected function sendToIntercom(User $user)
    {
        // Replace with your Intercom API credentials and endpoint
        $intercomApiToken = 'dG9rOmRiYzAwMzZkX2E2OGNfNDUxNV9hNmIzXzU0ODYzYzU0NDY5MToxOjA=';
        $intercomApiEndpoint = 'https://api.intercom.io/users';

        $userData = [
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            // Add other user data as needed
        ];

        try {
            Http::withHeaders([
                'Authorization' => 'Bearer ' . $intercomApiToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($intercomApiEndpoint, $userData);

            // You can add error handling and logging here if needed
        } catch (\Exception $e) {
            // Handle exceptions, e.g., log errors
        }
    }
}
