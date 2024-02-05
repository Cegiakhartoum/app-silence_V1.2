<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class MontageController extends Controller
{
    public function index()
    {
      $user = auth()->user();
$firstname = $user->name;

        // Récupérer l'e-mail de l'utilisateur authentifié dans votre système
    $email = auth()->user()->email;

    
    // Vérifier si l'utilisateur a déjà un compte WeVideo en utilisant son adresse e-mail
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Authorization' => 'WEVSIMPLE 8ZttxkX76gJNyjc333fMNdYYvjqk2EKMXE5iL280',
    ])->post('https://eu.wevideo.com/api/3/users', [
            'firstName' => $firstname,
            'email' => $email,
            'role' =>'lead',
    ]);

    if ($response->successful()) {

        
        // Vérifier si l'utilisateur a déjà un ID utilisateur WeVideo
        // Si c'est la première fois, vous pouvez créer un utilisateur WeVideo via l'appel API /api/3/users
        // et enregistrer un mappage entre votre ID utilisateur interne et l'ID utilisateur WeVideo
        
        // Générer un jeton de connexion unique en appelant /api/3/sso/auth
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'WEVSIMPLE 8ZttxkX76gJNyjc333fMNdYYvjqk2EKMXE5iL280',
        ])->post('https://eu.wevideo.com/api/3/sso/auth', [
            'firstName' => $firstname,
            'email' => $email,
            'role' =>'lead',// Utilisez l'e-mail de l'utilisateur authentifié
        ]);
 
        if ($response->successful()) {
            $token = $response->json('loginToken');
            
            // Rediriger l'utilisateur vers la page de l'éditeur avec le jeton de connexion
            return view('student.pages.montage', compact('token'));
        } else {
            // Gérer les erreurs de l'appel API /api/3/sso/auth
            return redirect()->back()->with('error', 'Erreur lors de la génération du jeton de connexion WeVideo.');
        }
    }
    else{
         // Vérifier si l'utilisateur a déjà un ID utilisateur WeVideo
        // Si c'est la première fois, vous pouvez créer un utilisateur WeVideo via l'appel API /api/3/users
        // et enregistrer un mappage entre votre ID utilisateur interne et l'ID utilisateur WeVideo
        
        // Générer un jeton de connexion unique en appelant /api/3/sso/auth
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'WEVSIMPLE 8ZttxkX76gJNyjc333fMNdYYvjqk2EKMXE5iL280',
        ])->post('https://eu.wevideo.com/api/3/sso/auth', [
            'firstName' => $firstname,
            'email' => $email,
            'role' =>'lead',// Utilisez l'e-mail de l'utilisateur authentifié
        ]);
 
        if ($response->successful()) {
            $token = $response->json('loginToken');
            
            // Rediriger l'utilisateur vers la page de l'éditeur avec le jeton de connexion
            return view('student.pages.montage', compact('token'));
        } else {
            // Gérer les erreurs de l'appel API /api/3/sso/auth
            return redirect()->back()->with('error', 'Erreur lors de la génération du jeton de connexion WeVideo.');
        }

    }
    }

    

}
