<?php

namespace App\Http\Controllers;

use App\Models\Atelier;
use App\Models\AtelierParti;
use App\Models\AtelierChapitre;
use App\Models\Cour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AtelierController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        try {
            $response = Http::get('https://api.faistonfilm.co/api/ateliers');
            $ateliers = json_decode($response->body(), true);
        } catch (\Exception $e) {
            // Handle any errors from the API request
            return view('student.pages.error')->with('error', 'Error fetching data from the API');
        }
        return view('student.pages.ateliers', ['ateliers' => $ateliers]);  
    }

    public function show($id)
    {
        try {
            $response = Http::get("https://api.faistonfilm.co/api/ateliers/{$id}");

            if ($response->successful()) {
                $atelierData = $response->json();
                
                // Extract the atelier and atelier_partis data from the API response
                $atelier = $atelierData['atelier'];
                $atelier_partis = $atelierData['atelier_partis'];

                return view('student.pages.parcours-film-fiction', ['atelier' => $atelier, 'atelier_partis' => $atelier_partis]);
            } else {
                // Handle the case when the API request was not successful
                // You can handle different response codes (e.g., 4xx, 5xx) here
                return redirect()->back()->with('error', 'Error fetching atelier data: ' . $response->status());
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors that occurred during the API request
            return redirect()->back()->with('error', 'Error fetching atelier data: ' . $e->getMessage());
        }
    }


    
    public function findParti($id)
    {
        // Appeler l'API pour récupérer les chapitres de la partie d'atelier avec l'ID spécifié
        try {
            $response = Http::get("https://api.faistonfilm.co/api/ateliers/parties/{$id}/partis");
    
            if ($response->successful()) {
                $part = json_decode($response->body(), true); 
    
                return $part; // Return the $chapitres array directly
            } else {
                // Handle the case when the API request was not successful
                // You can handle different response codes (e.g., 4xx, 5xx) here
                return ['error' => 'Error fetching atelier chapitres: ' . $response->status()];
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors that occurred during the API request
            return ['error' => 'Error fetching atelier chapitres: ' . $e->getMessage()];
        }
    }

 /**
     * Remove the specified resource from storage.
     */
    
     public function findChapter($id)
     {
         try {
             // Appeler l'API pour récupérer les chapitres de la partie d'atelier avec l'ID spécifié
             $response = Http::get("https://api.faistonfilm.co/api/ateliers/parties/{$id}/chapitres1");
 
             if ($response->successful()) {
                 // La requête a réussi, récupérer les données des chapitres
                 $atelier_chapitres = json_decode($response->body(), true);
 
                 // Retourner la vue avec les données des chapitres
                 return $atelier_chapitres;
             } else {
                 // La requête a échoué, renvoyer une vue avec un message d'erreur
                 return view('student.pages.parcours-film-fiction', ['error' => 'Error fetching chapitre data']);
             }
         } catch (\Exception $e) {
             // Gérer les exceptions ou les erreurs qui se sont produites pendant la requête API
             return view('student.pages.parcours-film-fiction', ['error' => 'Error fetching chapitre data: ' . $e->getMessage()]);
         }
     }

        public function findCour($id)
        {
             // Appeler l'API pour récupérer les chapitres de la partie d'atelier avec l'ID spécifié
             try {
                $response = Http::get("https://api.faistonfilm.co/api/ateliers/parties/{$id}/cours");
        
                if ($response->successful()) {
                    $cour = json_decode($response->body(), true); 
        
                    return $cour; // Return the $chapitres array directly
                } else {
                    // Handle the case when the API request was not successful
                    // You can handle different response codes (e.g., 4xx, 5xx) here
                    return ['error' => 'Error fetching atelier chapitres: ' . $response->status()];
                }
            } catch (\Exception $e) {
                // Handle any exceptions or errors that occurred during the API request
                return ['error' => 'Error fetching atelier chapitres: ' . $e->getMessage()];
            }  
        }
   
        public function findChapitre($id)
        {
            // Appeler l'API pour récupérer les chapitres de la partie d'atelier avec l'ID spécifié
            try {
                $response = Http::get("https://api.faistonfilm.co/api/ateliers/parties/{$id}/chapitres");
        
                if ($response->successful()) {
                    $chapitres = json_decode($response->body(), true);
        
                    return $chapitres; // Return the $chapitres array directly
                } else {
                    // Handle the case when the API request was not successful
                    // You can handle different response codes (e.g., 4xx, 5xx) here
                    return ['error' => 'Error fetching atelier chapitres: ' . $response->status()];
                }
            } catch (\Exception $e) {
                // Handle any exceptions or errors that occurred during the API request
                return ['error' => 'Error fetching atelier chapitres: ' . $e->getMessage()];
            }
        }


   
}
