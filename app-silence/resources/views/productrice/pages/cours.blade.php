@extends('student.layouts.page-atelier', ['contentBackground' => '#3b3d61'])
@php
$chapterKey = $_GET['c'];

use App\Http\Controllers\Productrice\AtelierController;
$AtelierCtrl = new AtelierController();
$cour = $AtelierCtrl->findCour($chapterKey);
$chapter = $AtelierCtrl->findChapter($cour['chapitre_id']);
$part = $AtelierCtrl->findParti($chapter['partie_id']);
$allChapters = $AtelierCtrl->findChapitre($part['id']); 
$nextChapterKey = null;
$foundCurrentChapter = false;

// Loop through all chapters to find the current chapter and the next chapter
foreach ($allChapters as $nextChapter) {
    if ($foundCurrentChapter) {
        $nextChapterKey = $nextChapter['cours_id']; // Utiliser la clé 'cours_id' du tableau associatif
     
        break;
    }
    
    if ($nextChapter['cours_id'] == $cour['id']) {
        $foundCurrentChapter = true;
    }
}

$passerLabel = "Passer au chapitre suivant";
$nextLabel = 'text';

if ($nextChapterKey !== null) {
    $nextcour = $AtelierCtrl->findCour($nextChapterKey);
    $nextchapter = $AtelierCtrl->findChapter($nextcour['chapitre_id']);
    $nextpart = $AtelierCtrl->findParti($nextchapter['partie_id']);

    if ($part['name'] != $nextpart['name']) {
        $nextLabel = $nextpart['name'];
    } elseif ($nextchapter['name'] == 'Le récap’') {
        $nextLabel = $nextpart['name']. ' - Le récap’';
    } else {
        $nextLabel = $nextchapter['name'];
    }

    if ($nextpart['name'] != $part['name']) {
        $passerLabel = "Passer à la partie suivante";
    }
    
    // Get the first chapter of the next part
    $nextPartChapters = $AtelierCtrl->findChapitre($nextpart['id']);
    $firstChapterOfNextPart = reset($nextPartChapters); // Get the first chapter using reset() function
    
    // Update $nextLabel with the name of the first chapter of the next part
    $nextLabel = $nextchapter['name'];

} else {
    // If there is no next chapter, handle it here
    
    // Find the current course
    $cour = $AtelierCtrl->findCour($chapter['cours_id']);
    
    // Find the current chapter
    $chapter = $AtelierCtrl->findChapter($cour['chapitre_id']);
    
    // Find the current part
    $part = $AtelierCtrl->findParti($chapter['partie_id']);

    try {
        // Find the first chapter of the next part
        $nextPartChapters = $AtelierCtrl->findFirstChapterOfNextPart($part['id']);
   
        if ($nextPartChapters) {
            $nextChapterKey = $nextPartChapters['cours_id'];
            // Get the first chapter using reset() function
            $firstChapterOfNextPart = $nextPartChapters;

            // Set the nextLabel based on chapter or part name
            if ($firstChapterOfNextPart['name'] == 'Le récap’') {
                $nextLabel = $part['name'] . ' - ' . $firstChapterOfNextPart['name'];
            } else {
                $nextLabel = $firstChapterOfNextPart['name'];
            }
        
            // Set the passerLabel based on whether the next part is different
            if ($firstChapterOfNextPart['partie_id'] != $part['id']) {
                $passerLabel = "Passer à la partie suivante";
            } else {
                $passerLabel = "Passer au chapitre suivant";
            }
        } else {
            // Handle the case when there is no next chapter
            $nextLabel = "No Next Chapter";
            $passerLabel = "No Next Part";
        }
    } catch (\Exception $e) {
        // Handle the error condition
        $nextLabel = "";
            $passerLabel = "";
    }
}


// Rest of your code remains unchanged
$actionMessage = $action->action_message ?? '';

if ($chapter['name'] == "Le récap'") {
    $actionMessage = $part['name'] . ' dans ACTION !';
}
@endphp


@section('sidebar')
@if (session('success'))
    <div class="alert alert-success">
   
        {{ session('success') }}

    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">


        {{ session('error') }}
    </div>
@endif



    <div>
   
        <a href="/productrice/parcours-film-fiction/{{$part['atelier_id']}}">
            <span style="background: rgba(255,255,255,0.1); padding:8px 16px; color:#AAA; border-radius:4px;">
                <i class="fas fa-arrow-left"></i>
            </span>
        </a>

        <span class="orange-text"
            style="margin-left: 16px; background: rgba(255,255,255,0.3); border-radius:4px; padding:1px 8px;">
            Chapitre
        </span>

        <span class="orange-text"
            style="margin-left: 16px; background: rgba(255,255,255,0.3); border-radius:4px; padding:1px 8px;">
            <a href=""  data-bs-toggle="modal" data-bs-target="#update">
        <i class="fas fa-edit"></i></a>
   
        </span>

    </div>
    <div style="font-weight: lighter; font-size: 20px; margin: 16px 0 32px 64px;  color: #FFF; line-height: 100%;">
        <div style="font-size: 60%;"> {{$part['name']}}</div>
        {{$chapter['name']}}
    </div>

    <div style="padding-left: 8px;">
    @if (isset($cour['video_steps']))
            <div>
                <i class="fab fa-youtube orange-text fa-2x" style="margin-right: 5px; vertical-align: middle;"></i>
                <span class="orange-text">{{$chapter['name']}}</span>
            </div>
            @php
            $steps = json_decode($cour['video_steps']);
            @endphp
            @foreach ($steps as $time => $step)
            <div style="padding: 8px 0px 8px 0; color:#FFF;">
                    <span style="margin-right: 12px; vertical-align: middle;">{{ $time }} </span>
                    <span class="orange-text"> {{ $step}}</span>
                </div>
            @endforeach
            <br />
            @endif

         @if ($cour['doc_recap']!= '')
            @php
            $url = json_decode($cour['doc_recap']);
            @endphp
            <div style="margin-bottom: 8px;">
                <a href="{{ $url }}" target="_blank">
                    <i class="far fa-file fa-2x"
                        style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; background-color: #D5972B; color: #FFF; padding:4px; border-radius: 5px;"></i>
                        <span class="orange-text"> Récap'
                        {{ $chapter['name'] == "Le récap'" ? "Le récap' ".$part['name'] : $chapter['name'] }} </span>
                </a>
            </div>
        @endif

 @if (isset($cour['to_do_list']))

@php
    $cours = json_decode($cour['to_do_list'], true);
@endphp

<div style="margin-bottom: 8px;">
    @foreach ($cours as $title => $url)
        <a href="{{ $url }}" target="_blank">
            <i class="far fa-file fa-2x"
                style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; background-color: #D5972B; color: #FFF; padding:4px; border-radius: 5px;"></i>
            <span class="orange-text"> {{ $title }} </span>
        </a>
    @endforeach
</div>

@endif



       @if ($cour['fiche_recap_des_chapitres']!= '')
            @php
            $cours = json_decode($cour['fiche_recap_des_chapitres']);
            @endphp

            <div style="margin-bottom: 8px;">
                <a href="{{ $cours }}" target="_blank">
                    <i class="far fa-file fa-2x"
                        style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; background-color: #D5972B; color: #FFF; padding:4px; border-radius: 5px;"></i>
                    <span class="orange-text"> Récap' - Tous les chapitres </span>
                </a>
            </div>
            @endif
@if (isset($cour['exemple']))
    @php
        $cours = json_decode($cour['exemple'], true); // Adding the second parameter `true` to return an associative array
    @endphp

    @if (is_array($cours))
        @foreach ($cours as $label => $link)
            <div style="margin-bottom: 8px;">
                <a href="{{ $link }}" target="_blank">
                    <i class="far fa-file fa-2x"
                        style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; background-color: #D5972B; color: #FFF; padding:4px; border-radius: 5px;"></i>
                    <span class="orange-text"> {{ $label }} </span>
                </a>
            </div>
        @endforeach

    @endif
@endif

        
@if (isset($cour['boite_idees']))
    @php
        $cours = json_decode($cour['boite_idees'], true); // Adding the second parameter `true` to return an associative array
    @endphp

    @if (is_array($cours))
        @foreach ($cours as $label => $link)
            <div style="margin-bottom: 8px;">
                <a href="{{ $link }}" target="_blank">
                    <i class="far fa-file fa-2x"
                        style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; background-color: #D5972B; color: #FFF; padding:4px; border-radius: 5px;"></i>
                    <span class="orange-text"> Boites à idées - {{ $label }} </span>
                </a>
            </div>
        @endforeach

    @endif
@endif

@if (isset($cour['doc_a_completer']) && $cour['doc_a_completer'] !== null && $cour['doc_a_completer'] !== "")
    @php
        $cours = json_decode($cour['doc_a_completer'], true);
    @endphp

    @foreach ($cours as $thematique => $url)
        <div style="margin-bottom: 8px;">
            <a href="{{ $url }}" target="_blank">
                <i class="far fa-file fa-2x"
                    style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; background-color: #5587b3; color: #FFF; padding:4px; border-radius: 5px;"></i>
                <span class="orange-text">{{ $thematique }}</span>
            </a>
        </div>
    @endforeach
@endif

    @if ($cour['chapitre_par_ecrit']!= '')
        @php
            $cours = json_decode($cour['chapitre_par_ecrit']);
            @endphp

            <div style="margin-bottom: 8px;">
                <a href="{{ $cours}}" target="_blank">
                    <i class="fas fa-info-circle fa-2x"
                        style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; color: #5587b3; border: none; background-color: #FFF; border-radius: 50%;"></i>
                    <span class="orange-text"> Le chapitre par écrit </span>
                </a>
            </div>
        @endif

        @if ($cour['tous_les_chapitres_par_ecrit'] != '')
            @php
            $cours = json_decode($cour['tous_les_chapitres_par_ecrit']);
            @endphp
            <div style="margin-bottom: 8px;">
                <a href="{{ $cours}}" target="_blank">
                    <i class="fas fa-info-circle fa-2x"
                        style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; color: #5587b3; border: none; background-color: #FFF; border-radius: 50%;"></i>
                    <span class="orange-text"> Tous les chapitres par écrit </span>
                </a>
            </div>
        @endif

        {{-- @if ($chapter['type'] == 'info')
            <div style="margin-bottom: 8px;">
                <a href="{{ $chapter['link'] }}" target="_blank">
                    <i class="fas fa-info-circle fa-2x"
                        style="margin-right: 5px; vertical-align: middle; color: #5587b3; border: none; background-color: #FFF; border-radius: 50%;"></i>
                    <span class="orange-text"> {{ $chapter['name'] }} </span>
                </a>
            </div>
        @endif
        @if ($chapter['type'] == 'quizz')
            <div style="margin-bottom: 8px;">
                <a href="{{ $chapter['link'] }}" target="_blank">
                    <i class="fas fa-list-ol fa-2x"
                        style="margin-right: 5px; vertical-align: middle; color: #dee289; border: none; background-color: #FFF; border-radius: 50%;"></i>
                    <span class="orange-text"> {{ $chapter['name'] }} </span>
                </a>
            </div>
        @endif --}}
    </div>
@endsection

@section('content')
    <div class="container-fluid">

    <div class="row">
            @if (isset($cour['video']))
            @php
            $cours = json_decode($cour['video']);
            @endphp
                <div class="col-md-12">
                    <video controls style="width: 100%; border: 1px solid #FFF; background: #222136; border-radius: 16px;">
                        <source src="{{$cours}}" type="video/mp4">
                        Votre navigateur ne supporte pas le tag video
                    </video>
                </div>
            @else
                <div class="col-md-12" style="height: 60vh;">
                    <div class="d-flex align-items-center justify-content-center"
                        style="height: 100%; border: 1px solid #FFF; background: #222136; border-radius: 16px;">
                        <i class="fas fa-play-circle fa-8x" style="color: #FFF; padding:4px; border-radius: 5px;"></i>
                    </div>
                </div>
            @endif
        </div>


        <div class="row">
            <div class="col-md-12">
                <a href="{{ isset($chapter['isDisabled']) ? '' : '/student/action-dashboard' }}"
                    style="{{ isset($chapter['isDisabled']) ? 'filter: blur(1.5px);' : '' }}">
                    <div
                        style="color: #FFF; background-color: #c2a58d; padding: 16px; text-align:center; margin: 8px 0px; border-radius:30px; font-size:1.5rem;">
                        @if ($actionMessage != '')
                            {{ $actionMessage }}
                        @else
                            Écris dans ACTION !
                        @endif
                    </div>
                </a>
            </div>
        </div>

        @if (isset($nextLabel))
            <div class="row">
                <div class="col-md-12">
                    <a href="cours?c={{ $nextChapterKey }}">
                        <div
                            style="color: #FFF; background-color: #32325e; padding: 4px 16px; text-align:center; margin: 8px 0px; border-radius:30px; font-size:1.5rem;">
                            <span style="font-size: 70%; display:block; opacity:70%;"> {{ $passerLabel }}</span>
                            {{ $nextLabel }}
                        </div>
                    </a>
                </div>
            </div>
        @endif


        
<!-- Modal delete chapitre -->
<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color: #4a4d77;">
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="close btn btn-link" style="text-decoration: none;"
                        data-bs-dismiss="modal" aria-label="Close">
                        <i style="color: #d5972b; font-size: 1.5em;" class="fas fa-arrow-alt-circle-left"></i>
                    </button>
                    <button type="button" class="close btn btn-link" style="text-decoration: none;"
                        data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: #d5972b; font-size: 2rem;">&times;</span>
                    </button>
                </div>

                <h3 class="text-center text-white">
                    Ajouter  Une Partie
                </h3>
                <div class="d-flex flex-column overflow-scroll">
                    <form method="POST" action="/productrice/update-cour">
                        @csrf
                        <input type="hidden" name="cour_id" value="{{$cour['id']}}">

                        <div class="form-group">
                        @php
                            $liens = config('z-actions');
                            var_dump($liens);  // or print_r($liens);
                        @endphp

                            <label class="text-white" for="liensId">Liens ID : {{$cour['action_id'] }}</label>
                            <br>
                            <select name="chapter[liensId]" id="liensId">
                                    @foreach ($liens as $key => $lien)
                                        <option value="{{ $key }}">{{ $lien['partie'] }}: {{ $lien['name'] }}</option>
                                    @endforeach
                            </select>


                        </div>
                        <br>
                        <div class="form-group">
                            <label class="text-white" for="emplacement_maquette">emplacement_maquette</label>
                            @php
                                $cours = json_decode($cour['emplacement_maquette']);    
                            @endphp
                            @if (is_array($cour['emplacement_maquette']))
                                @foreach ($cours as $cour)
                                    <textarea class="form-control" name="chapter[emplacement_maquette][]">{{$cour}}</textarea>
                                    
                                @endforeach
                            @else
                                <textarea class="form-control" name="chapter[emplacement_maquette]">{{$cours}}</textarea>
                                
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="text-white" for="video">video</label>
                            @php
                                $cours = json_decode($cour['video']);
                           
                            @endphp
                            @if (is_array($cour['video']))
                                @foreach ($cours as $cour)
                                    <textarea class="form-control" name="chapter[video][]">{{$cour}}</textarea>
                                  
                                @endforeach
                            @else
                                <textarea class="form-control" name="chapter[video]">{{$cours}}</textarea>

                            @endif
                        </div>

                        <div class="form-group">
                            <label class="text-white" for="doc_recap">doc_recap</label>
                            @php
                                $cours = json_decode($cour['doc_recap']);
                           
                            @endphp
                            @if (is_array($cour['doc_recap']))
                                @foreach ($cours as $cour)
                                    <textarea class="form-control" name="chapter[doc_recap][]">{{$cour}}</textarea>
                              
                                @endforeach
                            @else
                                <textarea class="form-control" name="chapter[doc_recap]">{{$cours}}</textarea>
                             
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="text-white" for="fiche_recap_des_chapitres">fiche_recap_des_chapitres</label>
                            @php
                                $cours = json_decode($cour['fiche_recap_des_chapitres']);
                          
                            @endphp
                            @if (is_array($cour['fiche_recap_des_chapitres']))
                                @foreach ($cours as $cour)
                                    <textarea class="form-control" name="chapter[fiche_recap_des_chapitres][]">{{$cour}}</textarea>
                              
                                @endforeach
                            @else
                                <textarea class="form-control" name="chapter[fiche_recap_des_chapitres]">{{$cours}}</textarea>
                            
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="text-white" for="chapitre_par_ecrit">chapitre_par_ecrit</label>
                            @php
                                $cours = json_decode($cour['chapitre_par_ecrit']);
                          
                            @endphp
                            @if (is_array($cour['chapitre_par_ecrit']))
                                @foreach ($cours as $cour)
                                    <textarea class="form-control" name="chapter[chapitre_par_ecrit][]">{{$cour}}</textarea>
                                   
                                @endforeach
                            @else
                                <textarea class="form-control" name="chapter[chapitre_par_ecrit]">{{$cours}}</textarea>
                             
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="text-white" for="tous_les_chapitres_par_ecrit">tous_les_chapitres_par_ecrit</label>
                            @php
                                $cours = json_decode($cour['tous_les_chapitres_par_ecrit']);
                               
                            @endphp
                            @if (is_array($cour['tous_les_chapitres_par_ecrit']))
                                @foreach ($cours as $cour)
                            <textarea class="form-control" name="chapter[tous_les_chapitres_par_ecrit][]">{{$cour['tous_les_chapitres_par_ecrit']}}</textarea>
                           
                            @endforeach
                            @else
                                <textarea class="form-control" name="chapter[tous_les_chapitres_par_ecrit]">{{$cours}}</textarea>
                                
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="text-white" for="integration">integration</label>
                            @php
                                $cours = json_decode($cour['integration']);
                              
                            @endphp
                            @if (is_array($cour['integration']))
                                @foreach ($cours as $cour)
                            <textarea class="form-control" name="chapter[integration][]">{{$cour['integration']}}</textarea>
                        
                            @endforeach
                            @else
                                <textarea class="form-control" name="chapter[integration]">{{$cours}}</textarea>
                             
                            @endif
                        </div>
<br>
                        <div class="form-group">
                            <label class="text-white" for="commentaire">commentaire</label>
                            @php
                                $cours = json_decode($cour['commentaire']);
                                if (is_string($cours))
                            {
                                $cours = json_decode($cours, true); // Utilisation du deuxième argument true pour obtenir un tableau associatif
                            }
                            @endphp
                            @if (is_array($cour['commentaire']))
                                @foreach ($cours as $cour)
                            <textarea class="form-control" name="chapter[commentaire][]">{{$cour['commentaire']}}</textarea>
                           
                            @endforeach
                            @else
                            <textarea class="form-control" name="chapter[commentaire]">{{$cours}}</textarea>
                     
                            @endif
                        </div>

                        <br>
                        @php
                            $cours = $cour['action_message'];
                            if (is_string($cours))
                            {
                                $cours = json_decode($cours, true); // Utilisation du deuxième argument true pour obtenir un tableau associatif
                            }
                        @endphp
                        <div class="form-group">
                            <label class="text-white" for="action_message">action_message</label>
                            @if (is_array($cours))
                                @foreach ($cours as $time => $step)
                                    <textarea class="form-control" name="chapter[action_message][]">{{$step}}</textarea>
                    
                                    <br>
                                @endforeach
                            @else
                                <textarea class="form-control" name="chapter[action_message]">{{$cours}}</textarea>
                             
                            @endif
                        </div>

                        <br>
                       
                        @php
                            $cours = $cour['boite_idees'];
                            if (is_string($cours)) {
                                $cours = json_decode($cours, true); // Utilisation du deuxième argument true pour obtenir un tableau associatif
                            }
                        @endphp
                        <div class="form-group-video_steps">
                            <label class="text-white" for="video_steps">boite_idees</label>
                            @if (is_array($cours))
                                @foreach ($cours as $time => $step)
                                <textarea class="form-control" name="chapter[boite_idees][time][]">{{ $time }}</textarea>
                                <textarea class="form-control" name="chapter[boite_idees][step][]">{{ $step }}</textarea>
                            
                            <br>
                                <br>
                                @endforeach
                            @else
                            <textarea class="form-control" name="chapter[boite_idees][time][]"></textarea>
                            <textarea class="form-control" name="chapter[boite_idees][step][]"></textarea>

                            <br>
                            @endif
                        </div>

                        <button type="button" id="addTextarea-video_steps">Add</button>

                        <br>
                       
                        @php
                            $cours = $cour['video_steps'];
                            if (is_string($cours)) {
                                $cours = json_decode($cours, true); // Utilisation du deuxième argument true pour obtenir un tableau associatif
                            }
                        @endphp
                        <div class="form-group-video_steps">
                            <label class="text-white" for="video_steps">video_steps</label>
                            @if (is_array($cours))
                                @foreach ($cours as $time => $step)
                                <textarea class="form-control" name="chapter[video_steps][time][]">{{ $time }}</textarea>
                                <textarea class="form-control" name="chapter[video_steps][step][]">{{ $step }}</textarea>
                            
                            <br>
                                <br>
                                @endforeach
                            @else
                            <textarea class="form-control" name="chapter[video_steps][time][]"></textarea>
                            <textarea class="form-control" name="chapter[video_steps][step][]"></textarea>

                            <br>
                            @endif
                        </div>

                        <button type="button" id="addTextarea-video_steps">Add</button>

                        <br>
                        @php
                            $cours = $cour['to_do_list'];
                            if (is_string($cours)) {
                                $cours = json_decode($cours, true); // Utilisation du deuxième argument true pour obtenir un tableau associatif
                            }
                        @endphp
                        <div class="form-group-to_do_list">
                            <label class="text-white" for="to_do_list">to_do_list</label>
                            @if (is_array($cours))
                                @foreach ($cours as $time => $step)
                                    <textarea class="form-control" name="chapter[to_do_list][time][]">{{$time}}</textarea>
                                    <textarea class="form-control" name="chapter[to_do_list][step][]">{{$step}}</textarea>
                                    <br>
                                @endforeach
                            @else
                            <textarea class="form-control" name="chapter[to_do_list][time][]"></textarea>
                                    <textarea class="form-control" name="chapter[to_do_list][step][]"></textarea>
                                <br>
                            @endif
                           
                        </div>
                        <button type="button" id="addTextarea-to_do_list">Add </button>
                        <br>
                        @php
                            $cours = $cour['exemple'];
                            if (is_string($cours)) {
                                $cours = json_decode($cours, true); // Utilisation du deuxième argument true pour obtenir un tableau associatif
                            }
                        @endphp
                        <div class="form-group-exemple">
                            <label class="text-white" for="exemple">exemple</label>
                            @if (is_array($cours))
                                @foreach ($cours as $time => $step)
                                    <textarea class="form-control" name="chapter[exemple][time][]">{{$time}}</textarea>
                                    <textarea class="form-control" name="chapter[exemple][step][]">{{$step}}</textarea>
                                    <br>
                                @endforeach
                            @else
                            <textarea class="form-control" name="chapter[exemple][time][]"></textarea>
                                    <textarea class="form-control" name="chapter[exemple][step][]"></textarea>
                                <br>
                            @endif
                           
                        </div>
                        <button type="button" id="addTextarea-exemple">Add </button>
                        <br>
                        @php
                            $cours = $cour['doc_a_completer'];
                            if (is_string($cours)) {
                                $cours = json_decode($cours, true); // Utilisation du deuxième argument true pour obtenir un tableau associatif
                            }
                        @endphp
                        <div class="form-group-doc_a_completer">
                            <label class="text-white" for="doc_a_completer">doc_a_completer</label>
                            @if (is_array($cours))

                                @foreach ($cours as $time => $step)
                                <textarea class="form-control" name="chapter[doc_a_completer][time][]">{{$time}}</textarea>
                                <textarea class="form-control" name="chapter[doc_a_completer][step][]">{{$step}}</textarea>

                                    <br>
                                @endforeach
                            @else
                            <textarea class="form-control" name="chapter[doc_a_completer][time][]"></textarea>
                                <textarea class="form-control" name="chapter[doc_a_completer][step][]"></textarea>

                                <br>
                            @endif
                           
                        </div>
                        <button type="button" id="addTextarea-doc_a_completer">Add </button>
                        <br>

                        <!-- Ajoutez ici les autres champs JSON -->

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
              

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#addTextarea-doc_a_completer').click(function() {
            var newTextarea = '<textarea class="form-control" name="chapter[doc_a_completer][time][]"></textarea><textarea class="form-control" name="chapter[doc_a_completer][step][]"></textarea> <br>';
            $('div.form-group-doc_a_completer').append(newTextarea);
        });
        $('#addTextarea-exemple').click(function() {
        var newTextarea = '<textarea class="form-control" name="chapter[exemple][time][]"></textarea><textarea class="form-control" name="chapter[exemple][step][]"></textarea> <br>';
            $('div.form-group-exemple').append(newTextarea);
        });
        $('#addTextarea-to_do_list').click(function() {
            var newTextarea = '<textarea class="form-control" name="chapter[to_do_list][time][]"></textarea><textarea class="form-control" name="chapter[to_do_list][step][]"></textarea> <br>';
            $('div.form-group-to_do_list').append(newTextarea);
        });
        $('#addTextarea-video_steps').click(function() {
        var newTextarea = '<textarea class="form-control" name="chapter[video_steps][time][]"></textarea><textarea class="form-control" name="chapter[video_steps][step][]"></textarea> <br>';
            $('div.form-group-video_steps').append(newTextarea);
        });
    });
    </script>
    

    <!-- Ajoutez ici les autres champs JSON -->
    

</form>


            </div>
        </div>
    </div>
</div>

</div>
<!-- End The Modal -->


    </div>
@endsection
