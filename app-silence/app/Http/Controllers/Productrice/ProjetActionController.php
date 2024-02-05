<?php

namespace App\Http\Controllers\Productrice;

use App\Models\Action;
use App\Models\User;
use App\Models\ProjetAction;
use App\Models\StudentGroup;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjetActionController extends Controller
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

    public function delete($id)
    {
        $projet=ProjetAction::where('id',$id)->first();
        $projet->delete();

        $actions=Action::where("projet_action_id", $id)->first();
        $actions->delete();
        return redirect()->back()->with('success', 'your message,here');   
    }

    public function archive($number, $id)
    {
        $projet=ProjetAction::find($id);
        $projet->archive = $number;
        $projet->save();
        return redirect()->back()->with('success', 'your message,here');   
    }

    public function creer(Request $request){
      

            $producteur = User::create([
                'firtsname' => 'vide',
                'name' => 'vide',
                'email' => $request->producteur,
                'password' => Hash::make('121201Ks'),
                'role' => 'producteur',
            ]);

            $producteur->save();

            $animateur = User::create([
                'firtsname' => 'vide',
                'name' => 'vide',
                'email' => $request->animateur,
                'password' => Hash::make('121201Ks'),
                'role' => 'animateur',
            ]);
            $animateur->save();

            $group = new StudentGroup();
            $group->nom = $request["ville"].$request["année_scolaire"];
            $group->projet_action_id = 0;
            $members = json_encode([$producteur->id,Auth::user()->id, $animateur->id]);

            $group->membres = $members;
            $group->save();


            $redirectUrl = $request->redirectUrl;

            $projet = new ProjetAction();
            $projet->nom = $request["nom"];
            $projet->type = $request["type"];
            $projet->année_scolaire = $request["année_scolaire"];
            $projet->ville = $request["ville"];
            $projet->ecole = $request["ecole"];
            $projet->producteur = $request["producteur"];
            $projet->animateur = $request["animateur"];
            $projet->date_tournage = $request["date_tournage"];
            $projet->réalisateur = $request["réalisateur"];
 
            $projet->description = $request->input("description", "");

            $projet->owner_type = "student_group";
            $projet->owner_id = $group->id;

            $projet->save();


            // Projet créé par un professeur pour des groupes d'élèves

                $group->projet_action_id = $projet->id;
                $group->save();

                $action = new Action();
                $action->owner_id = $group->id;
                $action->owner_type = "student_group";
                $action->projet_action_id = $projet->id;

                $action->save();
    


            DB::commit();
      

        return redirect($redirectUrl);
    }

    public function studentCreateProject(Request $request)
    {
        try {
            DB::beginTransaction();
            $redirectUrl = $request->redirect_url;

            $projet = new ProjetAction();
            $projet->nom = $request["nom"];
            $projet->type = $request["type"];

            $projet->classe = $request["classe"];
            $projet->description = $request->input("description", "");

            $projet->owner_type = $request["owner_type"];
            $projet->owner_id = Auth::user()->id;

            $projet->save();

            // Projet créé par l'élève lui même, creation de l'action
            $action = new Action();
            $action->owner_id = $projet->owner_id;
            $action->owner_type = "student";
            $action->projet_action_id = $projet->id;

            $action->save();

            $redirectUrl .= "?p=$projet->id";


            DB::commit();
        } catch (\Exception $e) {
            $redirectUrl .= "?error=1";
            DB::rollBack();
        }

        return redirect($redirectUrl);
    }

    public function joinProject(Request $request)
    {
        $action = new Action();
        $action->owner_id = $request->input("group_id");
        $action->owner_type = "student_group";
        $action->projet_action_id = $request->input("project_id");
        $action->save();
        return redirect("/productrice/action-dashboard");
    }

    public function findProjetsStudent($student_id)
    {
        return ProjetAction::where([
            'owner_type' => 'student',
            'owner_id' => $student_id,
            'archive' => 0
        ])->Orderby('updated_at','ASC')->get();
        // return ProjetAction::get();
    }



 

    public function findProjetsGroupStudent($student_id)
    {

        $groups = StudentGroup::where('membres', 'LIKE', '%"' . $student_id . '"%')->get()->toArray();

        $groups_ids = array_map(function ($m) {
            return $m["id"];
        }, $groups);
        $actions = Action::where("owner_type", "student_group")
        ->whereIn('owner_id', $groups_ids)
        ->orderBy('updated_at', 'ASC')
        ->get()
        ->toArray();


        $projets_ids = array_map(function ($m) {
            return $m["projet_action_id"];
        }, $actions);

        return ProjetAction::where([
            'id'=>    $projets_ids,
            'archive' => 0
        ])->get();
    
    }

    public function findProjetsStudentEcrit($student_id)
    {
        return ProjetAction::where([
            'owner_type' => 'student',
            'owner_id' => $student_id,
            'tournage' => 0,
            'archive' => 0
        ])->Orderby('updated_at','ASC')->get();
        // return ProjetAction::get();
    }

    public function findProjetsGroupStudentEcrit($student_id)
    {

        $groups = StudentGroup::where('membres', 'LIKE', '%"' . $student_id . '"%')->get()->toArray();

        $groups_ids = array_map(function ($m) {
            return $m["id"];
        }, $groups);

        $actions = Action::where("owner_type", "student_group")
            ->whereIn('owner_id', $groups_ids)
            ->Orderby('updated_at','ASC')
            ->get()->toArray();

        $projets_ids = array_map(function ($m) {
            return $m["projet_action_id"];
        }, $actions);

        return ProjetAction::where([
            'id'=>    $projets_ids,
            'tournage' => 0,
            'archive' => 0
        ]
        )->get();
    }
    public function findProjetsStudentTournage($student_id)
    {
        return ProjetAction::where([
            'owner_type' => 'student',
            'owner_id' => $student_id,
            'tournage' => 1,
            'archive' => 0
        ])->Orderby('updated_at','ASC')->get();
        // return ProjetAction::get();
    }

    public function findProjetsGroupStudentTournage($student_id)
    {

        $groups = StudentGroup::where('membres', 'LIKE', '%"' . $student_id . '"%')->get()->toArray();

        $groups_ids = array_map(function ($m) {
            return $m["id"];
        }, $groups);

        $actions = Action::where("owner_type", "student_group")
            ->whereIn('owner_id', $groups_ids)
            ->Orderby('updated_at','ASC')
            ->get()->toArray();

        $projets_ids = array_map(function ($m) {
            return $m["projet_action_id"];
        }, $actions);

        return ProjetAction::where([
            'id'=>    $projets_ids,
            'tournage' => 1,
            'archive' => 0
        ]
        )->get();
    }
    public function findProjetsStudentArchive($student_id)
    {
        return ProjetAction::where([
            'owner_type' => 'student',

            'owner_id' => $student_id,
            'archive' => 1
        ])->Orderby('updated_at','ASC')->get();
        // return ProjetAction::get();
    }

    public function findProjetsGroupStudentArchive($student_id)
    {

        $groups = StudentGroup::where('membres', 'LIKE', '%"' . $student_id . '"%')->get()->toArray();

        $groups_ids = array_map(function ($m) {
            return $m["id"];
        }, $groups);

        $actions = Action::where("owner_type", "student_group")
            ->whereIn('owner_id', $groups_ids)
            ->Orderby('updated_at','ASC')
            ->get()->toArray();

        $projets_ids = array_map(function ($m) {
            return $m["projet_action_id"];
        }, $actions);

        return ProjetAction::where([
            'id'=>    $projets_ids,
            'archive' => 1
        ]
        )->get();
    }

    public function countStudentsOfProject($project_id)
    {

        $number_students = 0;

        $actions = Action::where('projet_action_id', $project_id)->get();
        foreach ($actions as $action) {
            if ($action->owner_type == 'student') {
                $number_students++;
            } else {
                $std_grp = StudentGroup::where('id', $action["owner_id"])->get()->first();
                $number_students += substr_count($std_grp["membres"], ",") + 1;
            }
        }

        return $number_students;
    }

    public function findByProfesseur($professeur_id, $classe)
    {
        return ProjetAction::where(["owner_id" => $professeur_id, "owner_type" => "teacher", "classe" => $classe])->get();
    }

    public function findForCurrentProfesseur()
    {
        $classe = session('group');
        return $this->findByProfesseur(Auth::id(), $classe);
    }
}
