<?php

namespace App\Http\Controllers\Productrice;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
{
    // Récupérer l'utilisateur connecté
    $user = Auth::user();

    // Valider les données du formulaire
    $validatedData = $request->validate([
        'firstname' => 'required',
        'name' => 'required',
        'email' => 'required|email',
    ]);

    // Mettre à jour les informations du profil
    $user->firtsname = $validatedData['firstname'];
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->save();

    // Rediriger l'utilisateur vers une page appropriée (par exemple, la page de profil mise à jour)
    return redirect()->back()->with('success', 'Profil mis à jour avec succès');
}



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
