<?php

namespace App\Http\Controllers\Productrice;

use App\Models\Atelier;
use App\Models\AtelierParti;
use App\Models\Cour;
use App\Models\AtelierChapitre;
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
            return view('productrice.pages.error')->with('error', 'Error fetching data from the API');
        }
    
        // Now $ateliers is a PHP array containing the decoded JSON data
        return view('productrice.pages.ateliers', ['ateliers' => $ateliers]);
    }

   
   public function getCours()
    {
        // Appeler l'API pour récupérer les chapitres de la partie d'atelier avec l'ID spécifié
        try {
            $response = Http::get("https://api.faistonfilm.co/api/cours");
    
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

    public function show($id)
    {
        // Send the API request to fetch the atelier data
        try {
            $response = Http::get("https://api.faistonfilm.co/api/ateliers/{$id}");

            if ($response->successful()) {
                $atelierData = $response->json();
                
                // Extract the atelier and atelier_partis data from the API response
                $atelier = $atelierData['atelier'];
                $atelier_partis = $atelierData['atelier_partis'];

                return view('productrice.pages.parcours-film-fiction', ['atelier' => $atelier, 'atelier_partis' => $atelier_partis]);
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

 
   

   public function create(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'format' => 'required',
            'image' => 'required',
            'phrase_accroche' => 'required',
            // Add other validation rules for your request data fields here
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Prepare the data to be sent in the API request
        $data = [
            'format' => $request->input('format'),
            'image' => $request->input('image'),
            'phrase_accroche' => $request->input('phrase_accroche'),
            // Add other fields as needed based on your API endpoint requirements
        ];

        // Send the API request to create the atelier
        try {
            $response = Http::post('https://api.faistonfilm.co/api/ateliers', $data);

            if ($response->successful()) {
                // Atelier creation successful, handle the response if needed
                return redirect()->back()->with('success', 'Atelier created successfully.');
            } else {
                // Handle the case when the API request was not successful
                // You can handle different response codes (e.g., 4xx, 5xx) here
                return redirect()->back()->with('success', 'Atelier created successfully.');
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors that occurred during the API request
            return redirect()->back()->with('error', 'Error creating atelier: ' . $e->getMessage());
        }
    }

  
    public function updateCour(Request $request)
    {
        // Make an API call to update the chapitre in the specified API URL
        $apiUrl = 'https://api.faistonfilm.co/api/ateliers/cours/' . $request->cour_id; // Replace with your API URL
    
        // Prepare the data for the API call
        $response = Http::put($apiUrl, [
            'chapter' => $request->chapter,
            // Add any other data required by your API
        ]);
    
        // Check if the API call was successful
        if ($response->successful()) {
            // Handle success if needed
            // ...
    
            return redirect()->back()->with([
                'success' => 'Cours mis à jour avec succès',
                // Pass the entire response to the view
            ]);
        } else {
            // Handle error if needed
            $errorMessage = $response->json()['exception'] ?? 'Failed to update chapitre via API';
            return redirect()->back()->with([
                'error' => $errorMessage,
                // Pass the entire response to the view even in case of error
            ]);
        }
    }
    
 

public function delete($id)
{
    // Send the API request to delete the atelier
    try {
        $response = Http::delete("https://api.faistonfilm.co/api/ateliers/{$id}");

        if ($response->successful()) {
            // Atelier delete successful, handle the response if needed
            return redirect()->back()->with('success', 'Atelier deleted successfully.');
        } else {
            // Handle the case when the API request was not successful
            // You can handle different response codes (e.g., 4xx, 5xx) here
            return redirect()->back()->with('error', 'Error deleting atelier: ' . $response->status());
        }
    } catch (\Exception $e) {
        // Handle any exceptions or errors that occurred during the API request
        return redirect()->back()->with('error', 'Error deleting atelier: ' . $e->getMessage());
    }
}


function update(Request $request, $id)
    {
        // Validate the incoming request data if needed
        // ...

        // Prepare the data to be sent in the API request
        $data = [
            'format' => $request->input('format'),
            'image' => $request->input('image'),
            'phrase_accroche' => $request->input('phrase_accroche'),
            'cible' => $request->input('cible'),
            // Add other fields as needed based on your API endpoint requirements
        ];

        // Send the API request to update the atelier
        try {
            $response = Http::put("https://api.faistonfilm.co/api/ateliers/{$id}", $data);

            if ($response->successful()) {
                // Atelier update successful, handle the response if needed
                return redirect()->back()->with('success', 'Atelier updated successfully.');
            } else {
                // Handle the case when the API request was not successful
                // You can handle different response codes (e.g., 4xx, 5xx) here
               return redirect()->back()->with('success', 'Atelier created successfully.');
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors that occurred during the API request
            return redirect()->back()->with('error', 'Error updating atelier: ' . $e->getMessage());
        }
    }

    public function active(Request $request, $id)
    {
        // Send the API request to update the atelier's 'enligne' status
        try {
            $response = Http::put("https://api.faistonfilm.co/api/ateliers/{$id}/active", [
                'enligne' => $request->enligne,
            ]);

            if ($response->successful()) {
                // Atelier update successful, handle the response if needed
                return redirect()->back()->with('success', 'Atelier updated successfully.');
            } else {
                // Handle the case when the API request was not successful
                // You can handle different response codes (e.g., 4xx, 5xx) here
                return redirect()->back()->with('error', 'Error updating atelier: ' . $response->status());
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors that occurred during the API request
            return redirect()->back()->with('error', 'Error updating atelier: ' . $e->getMessage());
        }
    }

    public function cible(Request $request, $id)
    {
        // Envoyer la requête API pour mettre à jour le champ 'public_cible' de l'atelier
        try {
            $response = Http::put("https://api.faistonfilm.co/api/ateliers/{$id}/cible", [
                'cible' => $request->cible,
            ]);
    
            if ($response->successful()) {
                // Mise à jour de l'atelier réussie, gérer la réponse si nécessaire
                return redirect()->back()->with('success', 'Atelier mis à jour avec succès.');
            } else {
                // Gérer le cas où la requête API a échoué
                // Vous pouvez gérer différents codes de réponse (par exemple, 4xx, 5xx) ici
                return redirect()->back()->with('success', 'Atelier created successfully.');
            }
        } catch (\Exception $e) {
            // Gérer les exceptions ou les erreurs qui se sont produites pendant la requête API
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de l\'atelier : ' . $e->getMessage());
        }
    }

public function getChapters(Request $request)
{
    $partiId = $request->input('parti_id');
    
    // Retrieve the chapters based on the partiId
    $chapters = AtelierChapitre::where('partie_id', $partiId)->get();
    
    return response()->json($chapters);
}








    /**
     * CHAPITRE.
     */
    public function getPartieData($partieId)
    {
        try {
            // Faire l'appel à l'API
            $apiUrl = 'https://api.faistonfilm.co/api/ateliersParti/' . $partieId;
            $response = Http::get($apiUrl);

            // Vérifier la réponse de l'API
            if ($response->successful()) {
                // Si l'appel à l'API a réussi, récupérer les données renvoyées
                $chapitres = $response->json();

                // Retourner les chapitres en réponse JSON
                return response()->json($chapitres);
            } else {
                // Si l'appel à l'API a échoué, retourner un message d'erreur
                return response()->json(['error' => 'Error fetching chapitre data from API'], 500);
            }
        } catch (\Exception $e) {
            // Gérer les exceptions ou les erreurs qui se sont produites lors de l'appel à l'API
            return response()->json(['error' => 'Error calling API: ' . $e->getMessage()], 500);
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
  
  
   public function findFirstChapterOfNextPart($currentPartId)
    {
        try {
            // Make an API call to retrieve the chapters of the next part
            $response = Http::get("https://api.faistonfilm.co/api/ateliers/parties/{$currentPartId}/chapitre");
    
            if ($response->successful()) {
                $chapitres = json_decode($response->body(), true);
    
                if (!empty($chapitres)) {
                    // Find the first chapter of the next part
                    $firstChapterOfNextPart = $chapitres;
    
                    return $firstChapterOfNextPart;
                } else {
                    // Handle the case when the response is empty
                    return ['error' => 'No chapters found for the next part.'];
                }
            } else {
                // Handle the case when the API request was not successful
                return ['error' => 'Error fetching atelier chapitres: ' . $response->status()];
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors that occurred during the API request
            return ['error' => 'Error fetching atelier chapitres: ' . $e->getMessage()];
        }
    }
    
    

    public function createChapitre(Request $request)
    {
        
            try {
                // Récupérer les données à envoyer à l'API depuis la requête
                $name = $request->name;
                $duration = $request->duration;
                $description = $request->description;
                $ordre = $request->ordre_1;
                $partie_id = $request->partie_id;
                $public_cible = $request->public_cible;
        
                // Faire l'appel à l'API pour créer le chapitre d'atelier avec les nouvelles données
                $apiUrl = 'https://api.faistonfilm.co/api/ateliers/chapitres';
                $response = Http::post($apiUrl, [
                    'name' => $name,
                    'duration' => $duration,
                    'description' => $description,
                    'partie_id' => $partie_id,
                    'public_cible' => $public_cible,
                    'ordre' => $ordre
                ]);
        
                // Vérifier la réponse de l'API
                if ($response->successful()) {
                    // Si la création via l'API est réussie, rediriger l'utilisateur vers la page précédente
                    return back()->with('success', 'Chapitre d\'atelier créé avec succès');
                } else {
                    // Si la création via l'API a échoué, rediriger l'utilisateur vers la page précédente avec un message d'erreur
                    return back()->with('error', 'Erreur lors de la création du chapitre d\'atelier');
                }
            } catch (\Exception $e) {
                // Gérer les exceptions ou les erreurs qui se sont produites lors de l'appel à l'API
                return back()->with('error', 'Erreur lors de l\'appel à l\'API: ' . $e->getMessage());
            }
        
    
    }
    public function updateChapitre(Request $request)
    {

        // Make an API call to update the chapitre in the specified API URL
        $apiUrl = 'https://api.faistonfilm.co/api/ateliers/chapitres/'. $request->idchapitre; // Replace with your API URL
        // Prepare the data for the API call
        $response = Http::put($apiUrl, [
            'name' => $request->name,
            'duration' => $request->duration,
            'description' => $request->description,
            'cible' => $request->cible,
            'ordre_1' => $request->ordre_1,
            // Add any other data required by your API
        ]);

    

        // Check if the API call was successful
        if ($response->successful()) {
            // Handle success if needed
            // ...
        } else {
            // Handle error if needed
            $errorMessage = $response->json()['message'] ?? 'Failed to update chapitre via API';
            return redirect()->back()->with(['error' => $errorMessage]);

        }

        // Return a JSON response indicating success
        return redirect()->back()->with(['success' => 'Chapitre mis à jour avec succès'], 200);
    }

   
    
public function deleteChapitre($id)
{
    // Send the API request to delete the atelier
    try {
        $response = Http::delete("https://api.faistonfilm.co/api/ateliers/chapitres/{$id}");

        if ($response->successful()) {
            // Atelier delete successful, handle the response if needed
            return redirect()->back()->with('success', 'Atelier deleted successfully.');
        } else {
            // Handle the case when the API request was not successful
            // You can handle different response codes (e.g., 4xx, 5xx) here
            return redirect()->back()->with('error', 'Error deleting atelier: ' . $response->status());
        }
    } catch (\Exception $e) {
        // Handle any exceptions or errors that occurred during the API request
        return redirect()->back()->with('error', 'Error deleting atelier: ' . $e->getMessage());
    }
}






    /**
     * PARTI.
     */
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

    public function createParti(Request $request)
    {
        try {
            // Mettre à jour l'ordre des parties existantes
            AtelierParti::where('atelier_id', $request->atelier_id)
                ->where('ordre', '>', $request->ordre)
                ->increment('ordre');

            // Appeler l'API pour créer le nouvel enregistrement avec l'ordre spécifié
            $response = Http::post("https://api.faistonfilm.co/api/ateliers/parties", [
                'name' => $request->name,
                'ordre' => $request->ordre,
                'atelier_id' => $request->atelier_id,
                'public_cible' => $request->cible_partie,
            ]);

            if ($response->successful()) {
                // Rediriger vers l'URL spécifiée
                return redirect($request->redirect_url);
            } else {
                // Handle the case when the API request was not successful
                // You can handle different response codes (e.g., 4xx, 5xx) here
                return redirect()->back()->with('error', 'Error creating AtelierParti: ' . $response->status());
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors that occurred during the API request
            return redirect()->back()->with('error', 'Error creating AtelierParti: ' . $e->getMessage());
        }
    }

  
    public function updateParti(Request $request, $id)
    {
        // Récupérer les données du formulaire
        $ordre = $request->ordre;
        $name = $request->name;
        $cible = $request->cible_partie;
    
      
        $apiUrl = 'https://api.faistonfilm.co/api/ateliers/parties/' . $id;

        $response = Http::put($apiUrl, [
            'ordre' => $ordre,
            'name' => $name,
            'cible' => $cible,
        ]);

        // Vérifier la réponse de l'API
        if ($response->successful()) {
            // Si l'API a renvoyé un code de succès (200-299), la mise à jour a réussi
            return redirect()->back()->with('success', 'Parti mis à jour avec succès');
        } else {
            // Sinon, la mise à jour a échoué
            return redirect()->back()->with('error', 'La mise à jour du parti a échoué');
        }
    
    }

    
    public function deleteParti($id)
    {
        // Send the API request to delete the atelier
        try {
            $response = Http::delete("https://api.faistonfilm.co/api/ateliers/parties/{$id}");
    
            if ($response->successful()) {
                // Atelier delete successful, handle the response if needed
                return redirect()->back()->with('success', 'Atelier deleted successfully.');
            } else {
                // Handle the case when the API request was not successful
                // You can handle different response codes (e.g., 4xx, 5xx) here
                return redirect()->back()->with('error', 'Error deleting atelier: ' . $response->status());
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors that occurred during the API request
            return redirect()->back()->with('error', 'Error deleting atelier: ' . $e->getMessage());
        }
    }


  public function updateCour1(Request $request, $id)
  {
      $chapterData = $request->chapter;
  
      // Récupérer le cour existant depuis la base de données
      $cour = Cour::find($id);
  
      // Vérifier si le cour existe
      if (!$cour) {
          return new JsonResponse(['error' => 'Cour non trouvé'], 404);
      }
  
      try {
          // Mettre à jour les données du chapitre
          $updatedData = [
              'actionId' => isset($chapterData['liensId']) ? json_encode($chapterData['liensId']) : null,
              'emplacement_maquette' => isset($chapterData['emplacement_maquette']) ? json_encode($chapterData['emplacement_maquette']) : null,
              'video' => isset($chapterData['video']) ? json_encode($chapterData['video']) : null,
              'doc_recap' => isset($chapterData['doc_recap']) ? json_encode($chapterData['doc_recap']) : null,
              'fiche_recap_des_chapitres' => isset($chapterData['fiche_recap_des_chapitres']) ? json_encode($chapterData['fiche_recap_des_chapitres']) : null,
              'chapitre_par_ecrit' => isset($chapterData['chapitre_par_ecrit']) ? json_encode($chapterData['chapitre_par_ecrit']) : null,
              'tous_les_chapitres_par_ecrit' => isset($chapterData['tous_les_chapitres_par_ecrit']) ? $chapterData['tous_les_chapitres_par_ecrit'] : null,
              'integration' => isset($chapterData['integration']) ? json_encode($chapterData['integration']) : null,
              'commentaire' => isset($chapterData['commentaire']) ? json_encode($chapterData['commentaire']) : null,
              'action_message' => isset($chapterData['action_message']) ? json_encode($chapterData['action_message']) : null,
              'boite_idees' => null,
              'to_do_list' => null,
              'exemple' => null,
              'doc_a_completer' => null,
              'video_steps' => null,
          ];
  
          // Récupérer les champs "time" et "step" de boite_idees
          $boite_idees = $chapterData['boite_idees'];
          if (!empty($boite_idees)) {
              $timeArray = $boite_idees['time'];
              $stepArray = $boite_idees['step'];
              // Fusionner les valeurs de time et step en un tableau associatif
              $boite_ideesArray = [];
              for ($i = 0; $i < count($timeArray); $i++) {
                  if (!empty($timeArray[$i])) {
                      $time = $timeArray[$i];
                      $step = $stepArray[$i];
                      $boite_ideesArray[$time] = $step;
                  }
              }
              // Convertir le tableau associatif en JSON
              $updatedData['boite_idees'] = json_encode($boite_ideesArray);
          }
  
          // Récupérer les champs "time" et "step" de to_do_list
          $to_do_list = $chapterData['to_do_list'];
          if (!empty($to_do_list)) {
              $timeArray = $to_do_list['time'];
              $stepArray = $to_do_list['step'];
              // Fusionner les valeurs de time et step en un tableau associatif
              $to_do_listArray = [];
              for ($i = 0; $i < count($timeArray); $i++) {
                  if (!empty($timeArray[$i])) {
                      $time = $timeArray[$i];
                      $step = $stepArray[$i];
                      $to_do_listArray[$time] = $step;
                  }
              }
              // Convertir le tableau associatif en JSON
              $updatedData['to_do_list'] = json_encode($to_do_listArray);
          }
  
          // Récupérer les champs "time" et "step" de exemple
          $exemple = $chapterData['exemple'];
          if (!empty($exemple)) {
              $timeArray = $exemple['time'];
              $stepArray = $exemple['step'];
              // Fusionner les valeurs de time et step en un tableau associatif
              $exempleArray = [];
              for ($i = 0; $i < count($timeArray); $i++) {
                 if (!empty($timeArray[$i])) {
                    $time = $timeArray[$i];
                  $step = $stepArray[$i];
                  $exempleArray[$time] = $step;
              }
          }
          // Convertir le tableau associatif en JSON
          $updatedData['exemple'] = json_encode($exempleArray);
      }
  
      // Récupérer les champs "time" et "step" de doc_a_completer
      $doc_a_completer = $chapterData['doc_a_completer'];
      if (!empty($doc_a_completer)) {
          $timeArray = $doc_a_completer['time'];
          $stepArray = $doc_a_completer['step'];
          // Fusionner les valeurs de time et step en un tableau associatif
          $doc_a_completerArray = [];
          for ($i = 0; $i < count($timeArray); $i++) {
              if (!empty($timeArray[$i])) {
                  $time = $timeArray[$i];
                  $step = $stepArray[$i];
                  $doc_a_completerArray[$time] = $step;
              }
          }
          // Convertir le tableau associatif en JSON
          $updatedData['doc_a_completer'] = json_encode($doc_a_completerArray);
      }
  
      // Récupérer les champs "time" et "step" de video_steps
      $videoSteps = $chapterData['video_steps'];
      if (!empty($videoSteps)) {
          $timeArray = $videoSteps['time'];
          $stepArray = $videoSteps['step'];
          // Fusionner les valeurs de time et step en un tableau associatif
          $videoStepsArray = [];
          for ($i = 0; $i < count($timeArray); $i++) {
              if (!empty($timeArray[$i])) {
                  $time = $timeArray[$i];
                  $step = $stepArray[$i];
                  $videoStepsArray[$time] = $step;
              }
          }
          // Convertir le tableau associatif en JSON
          $updatedData['video_steps'] = json_encode($videoStepsArray);
      }
  
      // Mettre à jour le cour avec les nouvelles données
      $cour->update($updatedData);
  
      // Return a JSON response indicating success and the updated cour data
      return new JsonResponse(['success' => 'Cour mis à jour avec succès', 'updated_cour' => $cour], 200);
  } catch (\Exception $e) {
      // Handle any exceptions that occurred during the update process
      return new JsonResponse(['error' => 'Une erreur est survenue lors de la mise à jour du cour.', 'exception' => $e->getMessage()], 500);
  }
}

}
