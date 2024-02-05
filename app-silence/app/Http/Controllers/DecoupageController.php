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

class DecoupageController extends Controller
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
    public function convertirChampsJsonEnVarchar()
{
    // Sélectionnez tous les enregistrements avec decoupage->description en JSON valide
    $decoupages = Decoupage::whereRaw("JSON_VALID(decoupages.description)")->get();

    foreach ($decoupages as $decoupage) {
        // Convertissez le champ JSON en chaîne pour decoupages.description
        if (json_last_error() == JSON_ERROR_NONE) {
            $decodedArrayDescription = json_decode($decoupage->description, true);
            $convertedStringDescription = implode(', ', $decodedArrayDescription);

            // Mettez à jour le champ dans la base de données pour decoupages.description
            $decoupage->description = $convertedStringDescription;
            $decoupage->save();
        }
    }

    // Retournez une réponse, redirigez vers une vue, etc.
    return response()->json(['message' => 'Champs "description" mis à jour avec succès']);
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
   public function UpdtadePAT(Request $request)
   {
      $userId = $request->user()->id;
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
        

         $action->pat = $request->pat;
         $action->save();          
          return redirect($request->redirect_url);

     
     
   }
    public function UpdtadeOrdre(Request $request)
    {
        $userId = $request->user()->id;
         $projet = ProjetAction::where('id', $request->input('projet_action_id'))->first();

        $group = StudentGroup::where("id", $request->input('student_group_id'))->first();

        $action = Action::where(
            [
                'owner_id' => $group->id,
                'owner_type' => 'student_group',
                'projet_action_id' => $projet->id,
            ]
        )->first();


        
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

  
    public function AddDescription(Request $request)
    {
                                $decoupageser = Decoupage::find($request->id_adid);
                                $descriptios=json_decode($decoupageser->description);
                                $descriptony=array();
                            if(!empty($descriptios))
                            {
                                foreach($descriptios as $descriptio)
                                {
                               
                                        {
                                            $descriptony[]=$descriptio;

                                        }
                                }
                                if (in_array($request->add_descript, $descriptony)) 
                                {
                                	return back()
                                          ->with('error', 'Attention!! Vous avez deja ajouter cette description! Veuillez en selectionner un autre ');
                                    
                                }
                                else
                                {
                                 	$descriptony[]=$request->add_descript;
                                }
                               
                            }
                            else
                            {
                                $descriptony[]=$request->add_descript;

                            }
                                $decoupageser->description = json_encode($descriptony);
                                $decoupageser->save();
                             
         return redirect($request->redirect_url);
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
        $personnager = Decoupage::find($request->id_add_p);
        $personnages=json_decode($personnager->sur);
        $personnagy=array();
        if(!empty($personnages))
        {
           
            foreach($personnages as $perso)
            {

                        $personnagy[]=$perso;

                
            }
                if (in_array($request->add_personn, $personnagy)) 
                                {
                                	return back()
                                          ->with('error', 'Attention!! Vous avez deja ajouter ce personnage! Veuillez en selectionner un autre ');
                                    
                                }
                                else
                                {
                                 	$personnagy[]=$request->add_personn;
                                }

          
        }
        else
        {
            $personnagy[]=$request->add_personn;

        }

        $personnager->sur = json_encode($personnagy);
        $personnager->save();                 
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

        $group = StudentGroup::where("id", $request->input('student_group_id'))->first();

        $action = Action::where(
            [
                'owner_id' => $group->id,
                'owner_type' => 'student_group',
                'projet_action_id' => $projet->id,
            ]
        )->first();

        $chapter = $request->input('chapter_id');
        
		$rep=0;
     
        $scenarios = json_decode($action->scenario);
        
        $decoupage=Decoupage::find($request->id_delete_dec);
       $decoupage->delete();
                    return redirect($request->redirect_url);
    }
    
    
   public function saveActionDecoupage(Request $request)
    {
        $userId = $request->user()->id;
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
        
        $decoupages  = Decoupage::where('action_id', $projet->id)->orderBy('sequence_id')->get();
        $c = Decoupage::where('action_id', $projet->id)->count();

        $i = 0;
        if ($chapter == 16)
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
        if ($chapter == 17)
        {

            while ($i < $c){
                
                $decoupage = Decoupage::find($request->dec_update[$i]);
                $decoupage->durée = $request->durre_update[$i];
                $decoupage->save();
                $i++;
        
            }

        }
             
         
        if ($chapter == 18)
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
             
        if ($chapter == 29)
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
                          
                            "personnages" => $request->personnage_acteur[$i],
                            "prenom" => $request->prenom_acteur[$i],
                            "nom" => $request->nom_acteur[$i],
                            "mails"   => $request->mail_acteur[$i],
                            "telephones"  => $request->telephone_acteur[$i],
                        );
                        $liste_acteur[$i]=$test;
                        $i++;
                    }
                    $action->liste_acteur=json_encode($liste_acteur);   
                    $action->save();
        
                }
    }
    if ($chapter == 38)
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
                while ($i < $p)
                {
                    foreach($scenario as $scenari )
                    {
                        $index++;

                        if($index == $request->sequence_id[$i] )
                            {
                                $test=array(
                                    "sequence_id" => $request->sequence_id[$i],
                                    "personnage" => $request->personnage[$i],
                                    "note_acs" => $request->note_acs[$i],
                                    "note_maq" => $request->note_maq[$i],
                                );
                                $depouillemt[$i]=$test;

                            }
                    }
                    
                    $i++;      
                }
                $action->depouillements=json_encode($depouillemt);   
                $action->save();
    
            }
    }
     if ($chapter == 27)
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
                        
                                foreach(DecoupageController::getSequencePersonnages($sequence) as $perso)
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
   
    
    
}
