<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\ProjetAction;
use App\Models\StudentGroup;
use App\Models\Decoupage;
use App\Models\Story_image;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class ActionController extends Controller
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

    public function getSequencePersonnages($sequence)
    {
        $personnages = [];

    foreach ($sequence->dialogues_descriptions as $dialogue) {
        if (isset($dialogue->value->personnage)) {
            array_push($personnages, $dialogue->value->personnage);
        }
    }

    foreach ($sequence->personnages as $personnage) {
        array_push($personnages, $personnage);
    }

    return array_unique($personnages);
}
    public function UpdtadeOrdre(Request $request)
    {
        $userId = $request->user()->id;
        $projet = ProjetAction::where('id', $request->input('projet_action_id'))->first();

        $actionAndGroup = ActionController::findActionOfProjetAndStudent($projet, $userId);
        $action = $actionAndGroup["action"];
        $decoupages_l  = Decoupage::where('action_id', $projet->id)->distinct()->get('lieu');
        $chapter = $request->input('chapter_id');
        $i=0;
        $c=count($decoupages_l);
        while($i < $c)
        {
            $decoupages  = Decoupage::where('action_id', $projet->id)->where('lieu', $request->lieu[$i])->orderBy('sequence_id')->get();
            foreach($decoupages as $decoupage)
            {

                        $decoupage->ordre = $request->ordre[$i];
                        $decoupage->save();
            }
            $i++;

        }
       
         
          return redirect($request->redirect_url);

    }
    public function UpdtadeTrajet(Request $request)
    {
        $userId = $request->user()->id;
        $projet = ProjetAction::where('id', $request->input('projet_action_id'))->first();

        $actionAndGroup = ActionController::findActionOfProjetAndStudent($projet, $userId);
        $action = $actionAndGroup["action"];
        $decoupages_l  = Decoupage::where('action_id', $projet->id)->distinct()->get('lieu');
        $chapter = $request->input('chapter_id');
        $i=0;
        $c=count($decoupages_l);
        while($i < $c)
        {
            $decoupages  = Decoupage::where('action_id', $projet->id)->where('lieu', $request->lieu[$i])->orderBy('sequence_id')->get();
            foreach($decoupages as $decoupage)
            {

                        $decoupage->trajet = $request->trajet[$i];
                        $decoupage->save();
            }
            $i++;

        }
       
         
          return redirect($request->redirect_url);

    }

  public function  GetSubCatAgainstMainCatEdit($action_id , $id){
        echo json_encode(DB::table('decoupages')
        ->where('action_id', $action_id)
        ->where('sequence_id', $id)
        ->Orderby('plan', 'DESC')
        ->limit(1)
        ->get());
      }

    public function DeleteDescription(Request $request)
    {
                                $decoupageser = Decoupage::find($request->id_delete);
                                $descriptios=json_decode($decoupageser->description);
                                $descriptony=array();
                                foreach($descriptios as $descriptio)
                                {
                                  $descriptio=trim($descriptio);
                                  $testy=trim($request->delete_descript);
                                    if( $descriptio != $testy)
                                        {
                                            $descriptony[]=$descriptio;

                                        }
                                }

                                $decoupageser->description = json_encode($descriptony);
                                $decoupageser->save();
                             
         return redirect($request->redirect_url);
    }

   public function UpdtadePAT(Request $request)
   {
      $userId = $request->user()->id;
        $projet = ProjetAction::where('id', $request->input('projet_action_id'))->first();

        $actionAndGroup = ActionController::findActionOfProjetAndStudent($projet, $userId);
        $action = $actionAndGroup["action"];
        $decoupages  = Decoupage::where('action_id', $projet->id)->orderBy('sequence_id')->get();

        $chapter = $request->input('chapter_id');

         $action->pat = $request->pat;
         $action->save();          
          return redirect($request->redirect_url);

     
     
   }
   public function UpdtadeDéjeuner(Request $request)
   {
      $userId = $request->user()->id;
        $projet = ProjetAction::where('id', $request->input('projet_action_id'))->first();

        $actionAndGroup = ActionController::findActionOfProjetAndStudent($projet, $userId);
        $action = $actionAndGroup["action"];
        $decoupages  = Decoupage::where('action_id', $projet->id)->orderBy('sequence_id')->get();

        $chapter = $request->input('chapter_id');

         $action->déjeuner = $request->déjeuner;
         $action->save();          
          return redirect($request->redirect_url);

     
     
   }
   
  public function AddDescription(Request $request)
   {
       $decoupageser = Decoupage::find($request->id_adid);
       $descriptions = json_decode($decoupageser->description);
       $descriptionArray = [];

       if (!empty($descriptions)) {
           foreach ($descriptions as $description) {
               $descriptionArray[] = $description;
           }

           if (in_array($request->add_descript, $descriptionArray)) {
               return response()->json([
                   'status' => 'error',
                   'message' => 'Attention!! Vous avez déjà ajouté cette description! Veuillez en sélectionner une autre.',
               ]);
           } else {
               $descriptionArray[] = $request->add_descript;
           }
       } else {
           $descriptionArray[] = $request->add_descript;
       }

       $decoupageser->description = json_encode($descriptionArray);
       $decoupageser->save();

       return response()->json([
           'status' => 'success',
           'description' => $request->add_descript,
           'id' => $decoupageser->id,
       ]);
   }

     public function DeletePersonnage(Request $request)
    {
                        $personnager = Decoupage::find($request->idp_delete);
                        $personnages=json_decode($personnager->sur);
                        $personnagy=array();
                        foreach($personnages as $perso)
                        {
                          $perso=trim($perso);
                          $testy=trim($request->delete_perso);
                            if( $perso != $testy)
                                {
                                    $personnagy[]=$perso;

                                }
                        }
                       

                        $personnager->sur = json_encode($personnagy);
                        $personnager->save();
                     
                     
            return redirect($request->redirect_url);
    }
    public function AddPersonnage(Request $request)
{
    $decoupage = Decoupage::find($request->id_add_p);
    $existingPersonnages = json_decode($decoupage->sur);
    $updatedPersonnages = [];

    if (!empty($existingPersonnages)) {
        foreach ($existingPersonnages as $personnage) {
            $updatedPersonnages[] = $personnage;
        }

        if (in_array($request->add_personn, $updatedPersonnages)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Attention!! Vous avez déjà ajouté ce personnage! Veuillez en sélectionner un autre'
            ]);
        } else {
            $updatedPersonnages[] = $request->add_personn;
        }
    } else {
        $updatedPersonnages[] = $request->add_personn;
    }

    $decoupage->sur = json_encode($updatedPersonnages);
    $decoupage->save();

    // En retour, nous donnons le nom du personnage et l'ID de l'objet "decoupage"
    // pour pouvoir le supprimer ultérieurement.
    return response()->json([
        'status' => 'success',
        'personnage' => $request->add_personn,
        'decoupage_id' => $decoupage->id,
        'content' => $decoupage
    ]);
}

 public function saveAction(Request $request)
    {
        $userId = $request->user()->id;
        $projet = ProjetAction::where('id', $request->input('projet_action_id'))->first();

        $actionAndGroup = ActionController::findActionOfProjetAndStudent($projet, $userId);
        $action = $actionAndGroup["action"];
        $decoupages  = Decoupage::where('action_id', $projet->id)->orderBy('sequence_id')->get();
      $rapp = 1;

        $chapter = $request->input('chapter_id');

    
        if ($chapter == 0)
            $action->titre_oeuvre = $request->input('r1');

        if ($chapter == 30 || $chapter == 52 )
            $action->idées = $request->input('idées');

         if ($chapter == 31)
         {
             $test=array(     
                 "situation" => $request->situation,
                 "compétences" => $request->compétences,
                 "apporterais" => $request->apporterais,
                 "pourquoi"  => $request->pourquoi,
             );
             $action->discours =json_encode($test);   
             $action->save();
          }

          if ($chapter == 42)
          {
              $test=array(     
                  "phrase" => $request->phrase,
                  "nom" => $request->nom,
                  "ton" => $request->ton,
                  "public"  => $request->public,
                  "unicité"  => $request->unicité,
              );
              $action->introduction =json_encode($test);   
              $action->save();
           }
           if ($chapter == 43)
          {
              $test=array(     
                  "contenu" => $request->contenu,
                  "sujet" => $request->sujet,
                  "visuel" => $request->visuel,
              );
              $action->webtv_description =json_encode($test);   
              $action->save();
           }
           if ($chapter == 44)
           {
               $test=array(     
                   "ton" => $request->ton,
                   "style" => $request->style,
               );
               $action->ton_style =json_encode($test);   
               $action->save();
            }
        if ($chapter == 45)
            $action->structure = $request->input('structure');

        if ($chapter == 46)
            $action->format_durée = $request->input('format_durée');

        if ($chapter == 47) {
                // Assuming $request->nom is an array of JSON strings
                $nomCount = count($request->nom);
                $test = array(); // Initialize the $test array
                $i =1; 

                while ($i < $nomCount+1) {

                    // Decode the JSON string into an associative array
      
            
                    $test[$i] = array(
                        "nom" => $request->nom[$i],
                        "sexe" => $request->sexe[$i],
                        "age" => $request->age[$i],
                        "situation" => $request->situation[$i],
                        "préparation" => $request->préparation[$i],
                        "centre" => $request->centre[$i],
                        "probléme" => $request->probléme[$i],
                        "objectifs" => $request->objectifs[$i],
                        "comportement" => $request->comportement[$i],
                    );
                    // You can now use the variables ($nom, $sexe, etc.) as needed
            
                    // Assuming $action is retrieved based on your application's logic
                    // Update $action with the correct instance of your model
            
                    // Assuming $action is an instance of your model, you can save the persona data
                    $i++;
                    
                }
                $action->personna = json_encode($test);
                    $action->save();
            }
        if ($chapter == 48)
            {
                $test=array(     
                    "caracteristiques" => $request->caracteristiques,
                    "interet" => $request->interet,
                    "adaptation" => $request->adaptation,
                );
                $action->public_cible =json_encode($test);   
                $action->save();
            }
        if ($chapter == 49)
            {
                $test=array(     
                    "diffusion" => $request->diffusion,
                    "promotion" => $request->promotion,
                );
                $action->diffusion =json_encode($test);   
                $action->save();
            }
        if ($chapter == 50)
            $action->conclusion = $request->input('conclusion');

        if ($chapter == 1)
            $action->thematique = $request->input('r1');

        if ($chapter == 2)
            $action->pitch = $request->input('r1');

        if ($chapter == 3) {
            $action->situtation_initiale    = $request->input('r1');
            $action->element_pertubateur    = $request->input('r2');
            $action->peripeties             = $request->input('r3');
            $action->element_resolution     = $request->input('r4');
            $action->situation_finale       = $request->input('r5');
        }

        if ($chapter == 4)
            $action->synopsis = $request->input('r1');

     if ($chapter == 5 || $chapter == 54)
            $action->traitement = $request->input('r1');

            if ($chapter == 7 || $chapter == 34)
            {
                $action->scenario = $request->input('scenario');
                $scenarios = json_decode($action->scenario);
    
    
                $index = 0;
              $rat = 0;
              $rapp=1;
                $dec=array();
                  $sena=array();
                  $sequencesDuScenario = array();
                  $tar = 0;
                
          foreach ($scenarios as $scenario) {
              $sequencesDuScenario[] = $tar++; 
          }
          
          // Parcourir les découpages
          foreach ($decoupages as $decoupage) {
              $sequenceId = $decoupage->sequence_id;
          
              // Si le découpage est lié à une séquence qui n'est plus dans le scénario, supprimez-le
              if (!in_array($sequenceId, $sequencesDuScenario)) {
                  $decoupage->delete();
              }
          }
          
                  
          
                      foreach ($decoupages as $decoupag)
                      { 
                          $dec[] =$decoupag->sequence_id;
                      } 
                    foreach ($scenarios as $scenario)
                      { 
                          $sena[] = $rat++; 
                      } 
                 
                     
                      foreach ($scenarios->sequences as $scenario)
                      {
                          $index++; 
          
                          if (in_array($index, $dec)) 
                          {
                              foreach ($decoupages as $decoupage)
                              { 
                                  if( $index == $decoupage->sequence_id)
                                  {
                                      $decoupage->action_id = $projet->id;
                                      $decoupage->sequence_id = $index;
                                      $decoupage->lieu = $scenario->lieu;
                                      $decoupage->save();
                                      $test = 1;
          
                                  }
                              }
                           }
                           else
                           {
                              $decoupa = new Decoupage();
                              $decoupa->action_id = $projet->id;
                              $decoupa->sequence_id = $index;
                              $decoupa->plan = 1;
                              $decoupa->lieu = $scenario->lieu;
                              $decoupa->save();
          
                           }
                      }
                        $action->save();
                    
                $liste_acteur = json_decode($action->liste_acteur, true);
            $liste_acteurs = [];
            $scenario = json_decode($action->scenario);
            $existingIds = [];
            
            // Collecter les IDs existants
            foreach ($liste_acteur as $acteur) {
                $existingIds[] = $acteur['id'];
            }
            
            $i = 0;
            
            foreach ($scenario->personnages as $personnage) {
                // Chercher l'acteur par son ID
                $acteurKey = array_search($i, array_column($liste_acteur, 'id'));
            
                if ($acteurKey !== false) {
                    // Mettre à jour les détails de l'acteur existant
                    $liste_acteur[$acteurKey]['personnages'] = $personnage;
                    $liste_acteur[$acteurKey]['prenom'] = $liste_acteur[$acteurKey]['prenom'];
                    $liste_acteur[$acteurKey]['nom'] = $liste_acteur[$acteurKey]['nom'];
                    $liste_acteur[$acteurKey]['mails'] = $liste_acteur[$acteurKey]['mails'];
                    $liste_acteur[$acteurKey]['telephones'] = $liste_acteur[$acteurKey]['telephones'];
                    $liste_acteur[$acteurKey]['id'] = $liste_acteur[$acteurKey]['id'];
                    $liste_acteurs[] = $liste_acteur[$acteurKey];
            

                } else {
                    // Si l'acteur n'existe pas, créer une nouvelle entrée
                    $entry = [
                        'personnages' => $personnage,
                        'prenom' => "",
                        'nom' => "",
                        'mails' => "",
                        'telephones' => "",
                        'id' => $i,
                    ];
            
                    $liste_acteurs[] = $entry;
                }
            
                $i++;
            }
            

            // Encoder le tableau liste_acteurs mis à jour en JSON
            $action->liste_acteur = json_encode($liste_acteurs);
            $action->save();
                           

// Assuming $action->depouillements is a JSON-encoded array of objects
$depouillements = json_decode($action->depouillements, true);
$scenario = json_decode($action->scenario);
$sequenceIndex = 1;  // Initialize the index counter

foreach ($scenario->sequences as $sequence) {
    $personnages = $this->getSequencePersonnages($sequence);

    foreach ($personnages as $personnage) {
        $existingEntry = null;

        // Check if the personnage already exists in depouillements
        foreach ($depouillements as $dep) {
            if ($dep['sequence_id'] == $sequenceIndex && $dep['personnage'] === $personnage) {
                $existingEntry = $dep;
                break;
            }
        }

        if ($existingEntry === null) {
            // If the personnage doesn't exist, create a new entry
            $entry = [
                'note_acs' => null,
                'note_maq' => null,
                'personnage' => $personnage,
                'sequence_id' => $sequenceIndex, // Add the index to the entry
            ];

            $depouillements[] = $entry;
        }
    }

    $sequenceIndex++;  // Increment the index for the next sequence
}

// Encode the updated depouillements array to JSON
$action->depouillements = json_encode($depouillements);
       }
      $action->save();

         
    return redirect($request->redirect_url);
    }
    public function AddDecoupage(Request $request)
    {
        $userId = $request->user()->id;
        $projet = ProjetAction::where('id', $request->input('projet_action_id'))->first();
      	$decoupages  = Decoupage::where('action_id', $projet->id)->orderBy('sequence_id')->get();
        $actionAndGroup = ActionController::findActionOfProjetAndStudent($projet, $userId);
        $action = $actionAndGroup["action"];
		$rep=0;
        $chapter = $request->input('chapter_id');
        $scenarios = json_decode($action->scenario);
       
                    $index=1;
                    foreach ($scenarios->sequences as $scenario)
                    {
                        if ( $index == $request->sequence_id)
                            {
                                foreach ($decoupages as $decoupage)
                                {
                                    if($request->sequence_id == $decoupage->sequence_id && $request->plan == $decoupage->plan)
                                    {
                                          $rep=1;
                                          return back()
                                          ->with('error', 'Attention!! Vous avez deja cree se plan! Veuillez en selectionner un autre plan');
                                    }
                                }
                                 
                                if($rep==0)
                                    {
                                      $decoupag = new Decoupage();
                                      $decoupag->action_id = $projet->id;
                                      $decoupag->sequence_id = $request->sequence_id;
                                      $decoupag->plan = $request->plan;
                                      $decoupag->lieu = $scenario->lieu;
                                      $decoupag->save();
                                    }
                            }
                            $index++; 
                    }
                    return redirect($request->redirect_url);
    }
      public function DeleteDec(Request $request)
    {
        $userId = $request->user()->id;
        $projet = ProjetAction::where('id', $request->input('projet_action_id'))->first();
      	
        
        $actionAndGroup = ActionController::findActionOfProjetAndStudent($projet, $userId);
        $action = $actionAndGroup["action"];
		$rep = 0;
    $chapter = $request->input('chapter_id');
    $scenarios = json_decode($action->scenario);

    $decoupage = Decoupage::find($request->id_delete_dec);

    // Récupérer tous les découpages associés à la même séquence et action
    $decoupageSeq = Decoupage::where('sequence_id', $decoupage->sequence_id)
        ->where('action_id', $decoupage->action_id)
        ->get();

    // Vérifier s'il y a plus d'un résultat
    if ($decoupageSeq->count() > 1) {
        // Supprimer le découpage
        $decoupage->delete();
    } else {
        // Si une seule occurrence, renvoyer un message d'erreur
        $errorMessage = 'Attention ! Une séquence doit comporter au moins un plan.';
        return redirect($request->redirect_url)->with('error', $errorMessage);
    }
     // Récupérer tous les découpages associés à la même séquence et action
    $decoupageSeq = Decoupage::where('sequence_id', $decoupage->sequence_id)
        ->where('action_id', $decoupage->action_id)
        ->orderBy('plan', 'asc') // Assure l'ordre croissant des plans
        ->get();

    // Réorganiser les numéros de plan
    $index = 1;
    foreach ($decoupageSeq as $dec) {
        $dec->plan = $index;
        $dec->save();
        $index++;
    }

    return redirect($request->redirect_url);
}

    public function saveActionDecoupage(Request $request)
    {
        $userId = $request->user()->id;
        $projet = ProjetAction::where('id', $request->input('projet_action_id'))->first();
        $projet->tournage = 1 ; 
        $projet->updated_at = date('Y-m-d H:i:s') ; 
        $projet->save();

        $actionAndGroup = ActionController::findActionOfProjetAndStudent($projet, $userId);
        $action = $actionAndGroup["action"];

        $chapter = $request->input('chapter_id');
        $decoupages  = Decoupage::where('action_id', $projet->id)->orderBy('sequence_id')->get();
        $c = Decoupage::where('action_id', $projet->id)->count();

        $i = 0;
        if ($chapter == 16|| $chapter == 35 || $chapter == 52)
        {

            while ($i < $c){
                
                $decoupage = Decoupage::find($request->id_adi[$i]);
                $decoupage->echelle = $request->echelle_adi[$i];
                $decoupage->angle = $request->angle_adid[$i];
                $decoupage->mouvement = $request->mouvement_adid[$i];
                $decoupage->audio = $request->audio_adi[$i];
                $decoupage->raccord = $request->raccord_adi[$i];
                $decoupage->sur = $request->sur_adi[$i];
                $decoupage->description = $request->description_adi[$i];
                $decoupage->save();
                $i++;
        
            }

        }
        $i = 0;
        if ($chapter == 17  || $chapter == 40 )
        {

            while ($i < $c){
                
                $decoupage = Decoupage::find($request->dec_update[$i]);
                $decoupage->durée = $request->durre_update[$i];
                $decoupage->save();
                $i++;
        
            }

        }
             
         
        if ($chapter == 18 || $chapter == 36 )
        {
                $i=0;
                $decors=Decoupage::where('action_id', $projet->id)->distinct()->get('lieu');

                foreach($decors as $decord )
                {
          
             
                    foreach($decoupages as $decoupage )
                    {
                        if($decoupage->lieu == $decord->lieu )
                        {
                         
                            $decoupage->decors = $request->decors_add[$i];
                            $decoupage->jours = $request->jours_add[$i];
                            $decoupage->save();
                          


                        }
                    }

                    $i++;

                }
        }
      if ($chapter == 32 || $chapter == 38 || $chapter == 57) {
    $liste_acteur = [];

    $numberOfInputs = count($request->input('prenom_acteur'));

    if ($numberOfInputs > 0) {
        for ($i = 0; $i < $numberOfInputs; $i++) {
            // Use the null coalescing operator to provide an empty array if 'role' is null
            $roles = $request->input('role')[$i] ?? [];

            $roles_json = is_array($roles) ? json_encode($roles) : $roles;

            $test = [
                "prenom" => $request->input('prenom_acteur')[$i],
                "nom" => $request->input('nom_acteur')[$i],
                "mails" => $request->input('mail_acteur')[$i],
                "telephones" => $request->input('telephone_acteur')[$i],
                "role" => $request->role_adi[$i],
            ];

            $liste_acteur[] = $test;
        }

        $action->liste_tec = json_encode($liste_acteur);
        $action->save();
    }
}

             
        if ($chapter == 29 || $chapter == 37 || $chapter == 58)
        {
            $scenario = json_decode($action->scenario);
            if(!empty($scenario))
                {
                    $liste_acteur=array();
                    $test=array();
                    $p=count($scenario->personnages);
                    $i=0;
                    while ($i < $p)
                    {
                        $test=array(
                        "personnages" => isset($request->personnage_acteur[$i]) ? $request->personnage_acteur[$i] : "",
                        "prenom" => isset($request->prenom_acteur[$i]) ? $request->prenom_acteur[$i] : "",
                        "nom" => isset($request->nom_acteur[$i]) ? $request->nom_acteur[$i] : "",
                        "mails" => isset($request->mail_acteur[$i]) ? $request->mail_acteur[$i] : "",
                        "telephones" => isset($request->telephone_acteur[$i]) ? $request->telephone_acteur[$i] : "",
                        "id" => isset($request->id_acteur[$i]) ? $request->id_acteur[$i] : "",
                        );
                        $liste_acteur[$i]=$test;
                        $i++;
                    }
                    $action->liste_acteur=json_encode($liste_acteur);   
                    $action->save();
        
                }
    }
    
    if ($chapter == 27 || $chapter == 39 || $chapter == 59)
    {
        $i=0;
        $scenario = json_decode($action->scenario);
      
        
        if(!empty($scenario))
            {

                $depouillemt=array();
                $test=array();
                $p=count($scenario->personnages);
                $i=0;
                $index=0;
                foreach($scenario->personnages as $personnage )
                    {
                        $index=0;
                        foreach($scenario->sequences as $sequence)
                        {
                            $index++;
                        
                                foreach(ActionController::getSequencePersonnages($sequence) as $perso)
                            {
                                $perso=trim($perso);
                                $personnage=trim($personnage);
                            
                                if( $perso == $personnage )
                                {
                                
                                $test=array(
                                    "sequence_id" => $index,
                                    "personnage" => $personnage,
                                    "note_acs" => $request->note_acs[$i],
                                    "note_maq" => $request->note_maq[$i],
                                );

                                $depouillemt[$i]=$test;
                                $i++;  
                         
                                }
              
                            }
              


                        }

                    }

      
                $action->depouillements=json_encode($depouillemt);   
                $action->save();
    
            }
    }
         
    return redirect($request->redirect_url);
    }
    public function saveActionTeacher(Request $request)
    {

        $projet = ProjetAction::where('id', $request->input('projet_action_id'))->first();

        $group = StudentGroup::where("id", $request->input('student_group_id'))->first();

        $action = Action::where(
            [
                'owner_id' => $group->id,
                'owner_type' => 'student_group',
                'projet_action_id' => $projet->id,
            ]
        )->first();

        $chapter = $request->input('chapter_id');

        if ($chapter == 0)
            $action->titre_oeuvre = $request->input('r1');

        if ($chapter == 1)
            $action->thematique = $request->input('r1');

        if ($chapter == 2)
            $action->pitch = $request->input('r1');

        if ($chapter == 3) {
            $action->situtation_initiale    = $request->input('r1');
            $action->element_pertubateur    = $request->input('r2');
            $action->peripeties             = $request->input('r3');
            $action->element_resolution     = $request->input('r4');
            $action->situation_finale       = $request->input('r5');
        }

        if ($chapter == 4)
            $action->synopsis = $request->input('r1');

        if ($chapter == 5)
            $action->traitement = $request->input('r1');

        if ($chapter == 7)
            $action->scenario = $request->input('scenario');
          
       

        return redirect($request->redirect_url);
    }
    static public function findActionOfProjetAndStudent($projet, $student_id)
    {

        $action = false;
        $group  = false;

        if ($projet->owner_type == "student") {
            // Projet créé par l'élève lui meme
            $action = Action::where(
                [
                    'owner_id' => $student_id,
                    'owner_type' => 'student',
                    'projet_action_id' => $projet->id,
                ]
            )->first();
        } else {
            // Projet créé par le professeur
            $group = StudentGroup::where('projet_action_id', $projet->id)
                ->where(
                    'membres',
                    'LIKE',
                    '%"' . $student_id . '"%'
                )
                ->first();
            $action = Action::where(
                [
                    'owner_id' => $group->id,
                    'owner_type' => 'student_group',
                    'projet_action_id' => $projet->id,
                ]
            )->first();
        }

        return ["action" => $action, "group" => $group];
    }
    public function index(Request $request)
    {

        $projetActionId = $request->query('p',  false);

        if (!$projetActionId) {
            redirect("student/action-dashboard");
        }

        try {

            $userId = $request->user()->id;
            $projet = ProjetAction::where('id', $projetActionId)->firstOrFail();
         
            $actionAndGroup = ActionController::findActionOfProjetAndStudent($projet, $userId);
            $action = $actionAndGroup["action"];
            $actions = Action::all();
            $group  = $actionAndGroup["group"];
            $decoupages_d  = Decoupage::where('action_id', $projetActionId)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::where('action_id', $projetActionId)->distinct()->get('lieu');
            $jours  =Decoupage::where('action_id', $projetActionId)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages  = Decoupage::where('action_id', $projetActionId)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $projetActionId)->orderBy('ordre')->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $images = Story_image::orderBy('group')->get();

            if (!$action) {
                return redirect("student/action-dashboard");
            }

            $chapter = $request->query('c', 0);

            if ($chapter == 1)
                $action->r1 = $action->thematique;

            if ($chapter == 2)
                $action->r1 = $action->pitch;

            if ($chapter == 4)
                $action->r1 = $action->synopsis;

            if ($chapter == 5)
                $action->r1 = $action->traitement;

            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }
			if($projet->type == "fiction")
            {
                return view('student.pages.action', ['actions' => $actions,'action' => $action,'jours' => $jours,'decoupages_l'=>$decoupages_l,'decoupages_d'=>$decoupages_d,'images' => $images,'decoupages_p' => $decoupages_p,'decoupages' => $decoupages, 'projet' => $projet, "group" => $group, 'membres' => $membres]);
            }
            if($projet->type == "web tv")
            {
                return view('student.pages.web_tv', ['actions' => $actions,'action' => $action,'jours' => $jours,'decoupages_l'=>$decoupages_l,'decoupages_d'=>$decoupages_d,'images' => $images,'decoupages_p' => $decoupages_p,'decoupages' => $decoupages, 'projet' => $projet, "group" => $group, 'membres' => $membres]);
            }
            if($projet->type == "cv video")
            {
                return view('student.pages.cv_video', ['actions' => $actions,'action' => $action,'jours' => $jours,'decoupages_l'=>$decoupages_l,'decoupages_d'=>$decoupages_d,'images' => $images,'decoupages_p' => $decoupages_p,'decoupages' => $decoupages, 'projet' => $projet, "group" => $group, 'membres' => $membres]);

            }
            if($projet->type == "pitch")
            {
                return view('student.pages.pitch', ['actions' => $actions,'action' => $action,'jours' => $jours,'decoupages_l'=>$decoupages_l,'decoupages_d'=>$decoupages_d,'images' => $images,'decoupages_p' => $decoupages_p,'decoupages' => $decoupages, 'projet' => $projet, "group" => $group, 'membres' => $membres]);

            }
        } catch (ModelNotFoundException $e) {
            return redirect('student/action-dashboard');
        }
    }
    public function indexTeacher(Request $request)
    {

        $projetActionId = $request->query('p', false);

        // Recuperer le groupe dont le professeur consulte l'action
        $groupId = $request->query('g', false);
        $group   = StudentGroup::where("id", $groupId)->firstOrFail();

        // Constituer la liste des noms des membres du groupe
        $ids        = array_map('intval', json_decode($group->membres));
        $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );


        if (!$projetActionId || !$groupId) {
            return view('teacher.pages.action');
        }

        try {

            $action = Action::where(
                [
                    'owner_id' => $groupId,
                    'owner_type' => 'student_group',
                    'projet_action_id' => $projetActionId,
                ]
            )->firstOrFail();

            if (!$action) {
                $action = (object) [
                    'owner_id' => $groupId,
                    'owner_type' => 'student_group',
                    'projet_action_id' => $projetActionId,
                    'titre_oeuvre' => "AUCUN TITRE ENTRE",
                    'thematique' => '',
                    'pitch' => '',
                    'situtation_initiale' => '',
                    'element_pertubateur' => '',
                    'peripeties' => '',
                    'element_resolution' => '',
                    'situation_finale' => '',
                    'synopsis' => '',
                    'titre_film' => '',
                    'scenario' => null,
                    'traitement' => ''
                ];
            }

            $chapter = $request->query('c', 0);

            if ($chapter == 1)
                $action->r1 = $action->thematique;

            if ($chapter == 2)
                $action->r1 = $action->pitch;

            if ($chapter == 4)
                $action->r1 = $action->synopsis;

            if ($chapter == 5)
                $action->r1 = $action->traitement;

            return view('teacher.pages.student-action', ['action' => $action, 'group' => $group, 'membres' => $membres]);
        } catch (ModelNotFoundException $e) {
            return view('teacher.pages.action');
        }
    }
    public function dashboard(Request $request)
    {
        $projet_action_ctrl = new ProjetActionController();
        $projets_student = $projet_action_ctrl->findProjetsStudent($request->user()->id);
        $projets_student_group = $projet_action_ctrl->findProjetsGroupStudent($request->user()->id);
        return view('student.pages.action-dashboard', ['projets_student' => $projets_student, 'projets_student_group' => $projets_student_group]);
    }
    public function downloadScenarioPdf(Request $request)
    {
        $pdf = PDF::loadView('pdf.Silence', ["id" => 5]);
        return $pdf->download('invoice.pdf');
    }

}
