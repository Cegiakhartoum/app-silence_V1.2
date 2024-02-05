<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Decoupage;
use App\Models\ProjetAction;
use App\Models\StudentGroup;
use App\Jobs\SilencePdfDownload;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Aws\S3\S3Client;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

use Barryvdh\DomPDF\Facade\Pdf;

class ReportController1 extends Controller
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

    public function mergePDFs($pdfUrls)
    {
        $pdfMerger = PDFMerger::init();
    
        // Ajoutez chaque PDF à fusionner depuis les URLs du tableau
        foreach ($pdfUrls as $pdfUrl) {
            $nom = pathinfo($pdfUrl, PATHINFO_BASENAME);
            $pdfMerger->addPDF("/Users/cegiacreations/Downloads/app-silence/storage/app/pdfs-stock/{$nom}", 'all');
        }
    
        $pdfMerger->merge();
    
        $outputPath = storage_path('merged.pdf');
        $pdfMerger->save($outputPath);
    
        return $outputPath;
    }
    
    

    public function webtvPdf(Request $request)
    {
    set_time_limit(3000);
        $action_id = $request->query('id',  false);

        try {

            $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }

            $action = Action::where("id", $action_id)->first();
            $projet = ProjetAction::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::where('action_id', $action_id)->distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('ordre')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['projet'] = $projet;
            $data['membres'] = $membres;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['decoupages_s'] = $decoupages_s;
            $data['jours'] = $jours;
            $data['decoupages_p'] = $decoupages_p;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.web_tv', $data);

            return $pdf->download("{$action->titre_oeuvre}.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
    public function cvPdf(Request $request)
    {
 set_time_limit(3000);
        $action_id = $request->query('id',  false);

        try {
            $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }

          

       
            $action = Action::where("id", $action_id)->first();

            $projet = ProjetAction::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action->projet_action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::where('action_id', $action->projet_action_id)->distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action->projet_action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action->projet_action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action->projet_action_id)->orderBy('ordre')->get();
                 
            $jourDecoupageData = [];
            foreach ($jours as $jour) {
                $jourDecoupageData[$jour->jours] = $decoupages_p->filter(function($decoupage) use ($jour) {
                    return $decoupage->jours == $jour->jours;
                })->values()->all();
            }

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['projet'] = $projet;
            $data['decoupages_l'] = $decoupages_l;
            $data['membres'] = $membres;
            $data['group'] = $group;
            $data['decoupages_s'] = $decoupages_s;
            $data['jours'] = $jours;
            $data['jourDecoupageData'] = $jourDecoupageData;
            $data['decoupages_p'] = $decoupages_p;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.cv_video', $data);

            return $pdf->download("{$action->titre_oeuvre}.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
    // App/YourController.php


    public function SilencePdf(Request $request)
    {
        // Appeler les fonctions PDF individuelles
        $thematiqueUrl = $this->thématiquePdf($request);
        $pitchUrl = $this->pitchPdf($request);
        $shemaUrl = $this->shémaPdf($request);
        $synopsisUrl = $this->synopsisPdf($request);
        $traitementUrl = $this->traitementPdf($request);
        $scénarioUrl = $this->scénarioPdf($request);
        $découpageUrl = $this->découpagePdf($request);
        $lieux_tUrl = $this->lieux_tPdf($request);
        $liste_acteurUrl = $this->liste_acteurPdf($request);
        $dépouillementUrl = $this->dépouillementPdf($request);
        $planningUrl = $this->planningPdf($request);
        $feuille_scriptUrl = $this->feuille_scriptPdf($request);

        // Ajoutez d'autres appels de fonctions pour les PDF restants
    
        // Liste des URL des PDF générés
        $pdfUrls = [
            'Thematique' => $thematiqueUrl,
            'Pitch' => $pitchUrl,
            'Shema' => $shemaUrl,
            'Synopsis' => $synopsisUrl,
            'Traitement' => $traitementUrl,
            'Scénario' => $scénarioUrl,
            'Découpage' => $découpageUrl,
            'Lieux_t' => $lieux_tUrl,
            'Liste_acteur' => $liste_acteurUrl,
            'Dépouillement' => $dépouillementUrl,
            'Planning' => $planningUrl,
            'Feuille_script' => $feuille_scriptUrl,
            // Ajoutez d'autres types de PDF avec leurs URL respectives
        ];
    
        // Appeler la fonction pour fusionner les PDF
        $mergedPDF = $this->mergePDFs($pdfUrls);
    
       // Set the response headers for download
    $headers = [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="silence_actiion.pdf"',
    ];

    // Return the downloadable file
    return response()->download($mergedPDF, 'silence_action.pdf', $headers);
    }
    
    

    public function thématiquePdf(Request $request)
    {

    
        $action_id = $request->query('id', false);
    
        try {
            $action = Action::where("id", $action_id)->first();
    
            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;
    
            $data['action'] = $action;
    
            $pdf = PDF::loadView('pdf2.Thématique', $data);
            $pdf->setOptions($options);
            $pdf->setPaper('A4', 'landscape');
    
            // Store the PDF locally
            $localPath = 'pdfs-stock/' . uniqid('pdf_') . '.pdf';
            Storage::put($localPath, $pdf->output());
    
            // Get the URL of the stored PDF
            $pdfUrl = asset(Storage::url($localPath));
    
            if ($request->wantsJson()) {
                return response()->json(['pdfUrl' => $pdfUrl]);
            }
    
            return $pdfUrl;
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
      
   
public function pitchPdf(Request $request)
{

    $action_id = $request->query('id', false);
    
    try {
        $action = Action::where("id", $action_id)->first();

        $options = ['isRemoteEnabled' => true];
        $options['isPhpEnabled'] = true;

        $data['action'] = $action;

        $pdf = PDF::loadView('pdf.Pitch', $data);
        $pdf->setOptions($options);
        $pdf->setPaper('A4', 'landscape');

        // Store the PDF locally
        $localPath = 'pdfs-stock/' . uniqid('pdf_') . '.pdf';
        Storage::put($localPath, $pdf->output());

        // Get the URL of the stored PDF
        $pdfUrl = asset(Storage::url($localPath));

        if ($request->wantsJson()) {
            return response()->json(['pdfUrl' => $pdfUrl]);
        }

        return $pdfUrl;
    } catch (ModelNotFoundException $e) {
        return "";
    }
}
    public function shémaPdf(Request $request)
    {

        $action_id = $request->query('id', false);
    
        try {
            $action = Action::where("id", $action_id)->first();
    
            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;
    
            $data['action'] = $action;
            // Generate the PDF
            $pdf = PDF::loadView('pdf2.Shéma', $data);
            $pdf->setOptions($options);
            $pdf->setPaper('A4', 'landscape');
    
            // Store the PDF locally
            $localPath = 'pdfs-stock/' . uniqid('pdf_') . '.pdf';
            Storage::put($localPath, $pdf->output());
    
            // Get the URL of the stored PDF
            $pdfUrl = asset(Storage::url($localPath));
    
            if ($request->wantsJson()) {
                return response()->json(['pdfUrl' => $pdfUrl]);
            }
    
            return $pdfUrl;
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
  
    public function synopsisPdf(Request $request)
    {
            $action_id = $request->query('id', false);
        
            try {
                $action = Action::where("id", $action_id)->first();
        
                $options = ['isRemoteEnabled' => true];
                $options['isPhpEnabled'] = true;
        
                $data['action'] = $action;
                // Generate the PDF
       // Generate the PDF
       $pdf = PDF::loadView('pdf2.Synopsis', $data);
       $pdf->setOptions($options);
            $pdf->setPaper('A4', 'landscape');
    
            // Store the PDF locally
            $localPath = 'pdfs-stock/' . uniqid('pdf_') . '.pdf';
            Storage::put($localPath, $pdf->output());
    
            // Get the URL of the stored PDF
            $pdfUrl = asset(Storage::url($localPath));
    
            if ($request->wantsJson()) {
                return response()->json(['pdfUrl' => $pdfUrl]);
            }
    
            return $pdfUrl;
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
  
    public function traitementPdf(Request $request)
    {
        $action_id = $request->query('id', false);
    
        try {
            $action = Action::where("id", $action_id)->first();
    
            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;
    
            $data['action'] = $action;
            // Generate the PDF
            $pdf = PDF::loadView('pdf2.Traitement', $data);
            $pdf->setOptions($options);
            $pdf->setPaper('A4', 'landscape');
    
            // Store the PDF locally
            $localPath = 'pdfs-stock/' . uniqid('pdf_') . '.pdf';
            Storage::put($localPath, $pdf->output());
    
            // Get the URL of the stored PDF
            $pdfUrl = asset(Storage::url($localPath));
    
            if ($request->wantsJson()) {
                return response()->json(['pdfUrl' => $pdfUrl]);
            }
    
            return $pdfUrl;
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
  
  
    public function scénarioPdf(Request $request)
    {
        $action_id = $request->query('id', false);
    
        try {
            $action = Action::where("id", $action_id)->first();
    
            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;
    
            $data['action'] = $action;
            // Generate the PDF
            $pdf = PDF::loadView('pdf2.Scenario', $data);
            $pdf->setOptions($options);
            $pdf->setPaper('A4', 'landscape');
    
            // Store the PDF locally
            $localPath = 'pdfs-stock/' . uniqid('pdf_') . '.pdf';
            Storage::put($localPath, $pdf->output());
    
            // Get the URL of the stored PDF
            $pdfUrl = asset(Storage::url($localPath));
    
            if ($request->wantsJson()) {
                return response()->json(['pdfUrl' => $pdfUrl]);
            }
    
            return $pdfUrl;
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
  
  
    public function découpagePdf(Request $request)
    {

        $action_id = $request->query('id', false);

        try {

            $action = Action::where("id", $action_id)->first();
            $decoupages_s = Decoupage::where('action_id', $action->projet_action_id)->orderBy('sequence_id', 'asc')->orderBy('plan', 'asc')->get();


            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;
            $data = [
                'action' => $action,
                'decoupages_s' => $decoupages_s,
            ];

            $pdf = PDF::loadView('pdf2.d_t', $data);
            $pdf->setOptions($options);
            $pdf->setPaper('A4', 'landscape');
    
            // Store the PDF locally
            $localPath = 'pdfs-stock/' . uniqid('pdf_') . '.pdf';
            Storage::put($localPath, $pdf->output());
    
            // Get the URL of the stored PDF
            $pdfUrl = asset(Storage::url($localPath));
    
            if ($request->wantsJson()) {
                return response()->json(['pdfUrl' => $pdfUrl]);
            }
    
            return $pdfUrl;
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }


  
    public function lieux_tPdf(Request $request)
    {

        $action_id = $request->query('id',  false);
 	
  
        try {

            $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }
           $action = Action::where("id", $action_id)->first();

            $decoupages_l  = Decoupage::where('action_id', $action->projet_action_id)->distinct()->get('lieu');
            $decoupages  = Decoupage::where('action_id', $action->projet_action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['membres'] = $membres;
            $data['group'] = $group;
            // Generate the PDF
            $pdf = PDF::loadView('pdf2.Lieux_t', $data);
            $pdf->setOptions($options);
            $pdf->setPaper('A4', 'landscape');
    
            // Store the PDF locally
            $localPath = 'pdfs-stock/' . uniqid('pdf_') . '.pdf';
            Storage::put($localPath, $pdf->output());
    
            // Get the URL of the stored PDF
            $pdfUrl = asset(Storage::url($localPath));
    
            if ($request->wantsJson()) {
                return response()->json(['pdfUrl' => $pdfUrl]);
            }
    
            return $pdfUrl;
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }

    public function liste_acteurPdf(Request $request)
    {
 set_time_limit(3000);
        $action_id = $request->query('id',  false);


  
        try {

            $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }
         
      		$action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action->projet_action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action->projet_action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action->projet_action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action->projet_action_id)->orderBy('lieu')->get();
         
            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['group'] = $group;
            $data['membres'] = $membres;
            $data['nom_auteur'] = $nom_auteur;

            // Generate the PDF
            $pdf = PDF::loadView('pdf2.Liste_acteur', $data);
            $pdf->setOptions($options);
            $pdf->setPaper('A4', 'landscape');
    
            // Store the PDF locally
            $localPath = 'pdfs-stock/' . uniqid('pdf_') . '.pdf';
            Storage::put($localPath, $pdf->output());
    
            // Get the URL of the stored PDF
            $pdfUrl = asset(Storage::url($localPath));
    
            if ($request->wantsJson()) {
                return response()->json(['pdfUrl' => $pdfUrl]);
            }
    
            return $pdfUrl;
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }

    public function introductionPdf(Request $request)
    {
 set_time_limit(3000);
        $action_id = $request->query('id',  false);

        try {
          $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action->projet_action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action->projet_action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action->projet_action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action->projet_action_id)->orderBy('lieu')->get();
         


            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['group'] = $group;
            $data['membres'] = $membres;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.conponents.introduction', $data);

            return $pdf->download("{$action->titre_oeuvre}_introduction.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }

    public function descriptionducontenuPdf(Request $request)
    {
  set_time_limit(3000);
        $action_id = $request->query('id',  false);

        try {
          $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['group'] = $group;
            $data['membres'] = $membres;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.conponents.descriptionducontenu', $data);

            return $pdf->download("{$action->titre_oeuvre}_description_du_contenu.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
    public function tonetstylePdf(Request $request)
    {
 set_time_limit(3000);
        $action_id = $request->query('id',  false);

        try {
          $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
          $data['group'] = $group;
            $data['membres'] = $membres;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.conponents.tonetstyle', $data);

            return $pdf->download("{$action->titre_oeuvre}_tonetstyle.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
    public function structuredesépisodesPdf(Request $request)
    {
 set_time_limit(3000);
        $action_id = $request->query('id',  false);

        try {
          $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;
          $data['group'] = $group;
            $data['membres'] = $membres;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.structuredesépisodes', $data);

            return $pdf->download("{$action->titre_oeuvre}_structuredesépisodes.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
    public function formatetduréePdf(Request $request)
    {
 set_time_limit(3000);
        $action_id = $request->query('id',  false);

        try {
          $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
          $data['group'] = $group;
            $data['membres'] = $membres;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.formatetdurée', $data);

            return $pdf->download("{$action->titre_oeuvre}_formatetdurée.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
    public function personnaPdf(Request $request)
    {
 set_time_limit(3000);
        $action_id = $request->query('id',  false);

        try {
          $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
          $data['group'] = $group;
            $data['membres'] = $membres;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.personna', $data);

            return $pdf->download("{$action->titre_oeuvre}_personna.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
    public function publicciblePdf(Request $request)
    {
 set_time_limit(3000);
        $action_id = $request->query('id',  false);

        try {
          $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
          $data['group'] = $group;
            $data['membres'] = $membres;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.publiccible', $data);

            return $pdf->download("{$action->titre_oeuvre}_publiccible.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
    public function conceptdelachainePdf(Request $request)
    {
 set_time_limit(3000);
        $action_id = $request->query('id',  false);

        try {
          $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.conceptdelachaine', $data);

            return $pdf->download("{$action->titre_oeuvre}conceptdelachaine.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }public function diffusionetpromotionPdf(Request $request)
    {
       set_time_limit(3000);

        $action_id = $request->query('id',  false);

        try {
          $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.diffusionetpromotion', $data);

            return $pdf->download("{$action->titre_oeuvre}_diffusionetpromotion.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
    public function conclusionPdf(Request $request)
    {
 set_time_limit(3000);
        $action_id = $request->query('id',  false);

        try {
          $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
          $data['group'] = $group;
            $data['membres'] = $membres;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.conclusion', $data);

            return $pdf->download("{$action->titre_oeuvre}_conclusion.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }

  
    public function dépouillementPdf(Request $request)
    {

    $action_id = $request->query('id',  false);

        try {

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;

            // Generate the PDF
            $pdf = PDF::loadView('pdf2.Depouillement', $data);
            $pdf->setOptions($options);
            $pdf->setPaper('A4', 'landscape');
    
            // Store the PDF locally
            $localPath = 'pdfs-stock/' . uniqid('pdf_') . '.pdf';
            Storage::put($localPath, $pdf->output());
    
            // Get the URL of the stored PDF
            $pdfUrl = asset(Storage::url($localPath));
    
            if ($request->wantsJson()) {
                return response()->json(['pdfUrl' => $pdfUrl]);
            }
    
            return $pdfUrl;
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
  
    public function planningPdf(Request $request)
    {
    $action_id = $request->query('id',  false);
        try {

            $action = Action::where("id", $action_id)->first();
            $jours  =Decoupage::where('action_id', $action->projet_action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_p  = Decoupage::where('action_id', $action->projet_action_id)->orderBy('ordre')->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
         
            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['jours'] = $jours;
            $data['decoupages_p'] = $decoupages_p;

            // Generate the PDF
            $pdf = PDF::loadView('pdf2.Planning', $data);
            $pdf->setOptions($options);
            $pdf->setPaper('A4', 'landscape');
    
            // Store the PDF locally
            $localPath = 'pdfs-stock/' . uniqid('pdf_') . '.pdf';
            Storage::put($localPath, $pdf->output());
    
            // Get the URL of the stored PDF
            $pdfUrl = asset(Storage::url($localPath));
    
            if ($request->wantsJson()) {
                return response()->json(['pdfUrl' => $pdfUrl]);
            }
    
            return $pdfUrl;
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
    public function feuille_scriptPdf(Request $request)
    {
          $action_id = $request->query('id',  false);

        try {
   
            $action = Action::where("id", $action_id)->first();
            $jours = Decoupage::where('action_id', $action->projet_action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_p = Decoupage::where('action_id', $action->projet_action_id)->orderBy('ordre')->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();

            if (!$action) {
                return "";
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['jours'] = $jours;
            $data['decoupages_p'] = $decoupages_p;

            // Generate the PDF
            $pdf = PDF::loadView('pdf2.Feuille_script', $data);
            $pdf->setOptions($options);
            $pdf->setPaper('A4', 'landscape');
    
            // Store the PDF locally
            $localPath = 'pdfs-stock/' . uniqid('pdf_') . '.pdf';
            Storage::put($localPath, $pdf->output());
    
            // Get the URL of the stored PDF
            $pdfUrl = asset(Storage::url($localPath));
    
            if ($request->wantsJson()) {
                return response()->json(['pdfUrl' => $pdfUrl]);
            }
    
            return $pdfUrl;
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }


    public function ideePdf(Request $request)
    {
        $action_id = $request->query('id',  false);

        try {
          $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $jours = Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_p = Decoupage::where('action_id', $action_id)->orderBy('ordre')->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages_s'] = $decoupages_s;
            $data['jours'] = $jours;
          $data['group'] = $group;
            $data['membres'] = $membres;
            $data['decoupages_p'] = $decoupages_p;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.Idee', $data);

            return $pdf->download("{$action->titre_oeuvre}_idee.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }

    public function discoursPdf(Request $request)
    {
 set_time_limit(3000);
        $action_id = $request->query('id',  false);


        try {

            $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $jours = Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_p = Decoupage::where('action_id', $action_id)->orderBy('ordre')->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages_s'] = $decoupages_s;
            $data['jours'] = $jours;
          $data['group'] = $group;
            $data['membres'] = $membres;
            $data['decoupages_p'] = $decoupages_p;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.discours', $data);

            return $pdf->download("{$action->titre_oeuvre}_discours.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
    public function ltaPdf(Request $request)
    {
      
 set_time_limit(3000);
        $action_id = $request->query('id',  false);



        try {

            $group=StudentGroup::where("projet_action_id", $action_id)->first();
            $membres = '';
            if(is_object($group)){
                $ids        = array_map('intval', json_decode($group->membres));
                $membres    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray() );
            }
           
 		$action = Action::where("projet_action_id", $action_id)->first();
        $action_id = $action->id;
              
            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id',$action->projet_action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $decoupages_s  = Decoupage::where('action_id', $action->projet_action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $jours = Decoupage::where('action_id', $action->projet_action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_p = Decoupage::where('action_id', $action->projet_action_id)->orderBy('ordre')->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages_s'] = $decoupages_s;
            $data['jours'] = $jours;
          $data['group'] = $group;
            $data['membres'] = $membres;
            $data['decoupages_p'] = $decoupages_p;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = PDF::loadView('pdf.conponents.Planning', $data);
            $pdf->setOptions($options);
            $pdf->setPaper('A4', 'landscape');
    
            // Store the PDF locally
            $localPath = 'pdfs-stock/' . uniqid('pdf_') . '.pdf';
            Storage::put($localPath, $pdf->output());
    
            // Get the URL of the stored PDF
            $pdfUrl = asset(Storage::url($localPath));
    
            if ($request->wantsJson()) {
                return response()->json(['pdfUrl' => $pdfUrl]);
            }
    
            return $pdfUrl;
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
    

    
    
}