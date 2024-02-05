<?php

namespace App\Http\Controllers\Productrice;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class CompteController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function creer(Request $request)
{
    $validator = Validator::make($request->all(), [
        'firtsname' => ['required', 'string', 'max:255'],
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['required'],
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $user = new User();
    $user->firtsname = $request->firtsname;
    $user->name =  $request->name;
    $user->email =  $request->email;
    $user->password = Hash::make($request->password);
    $user->role = $request->role;
    $user->save();
    $user->assignRole($request->role)->save();

    return redirect($request->redirect_url);
}

/**
     * Update the user's profile information.
     */
    public function update(Request $request, $id)
{
    // Récupérer l'utilisateur connecté
    $user = User::find($id);

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
    return redirect()->back()->with('success', 'compte mis à jour avec succès');
}
   
}
