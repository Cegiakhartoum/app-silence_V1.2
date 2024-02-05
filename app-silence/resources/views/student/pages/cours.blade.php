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
    <div>
        <a href="/student/parcours-film-fiction/{{$part['atelier_id']}}">
            <span style="background: rgba(255,255,255,0.1); padding:8px 16px; color:#AAA; border-radius:4px;">
                <i class="fas fa-arrow-left"></i>
            </span>
        </a>

        <span class="orange-text"
            style="margin-left: 16px; background: rgba(255,255,255,0.3); border-radius:4px; padding:1px 8px;">
            Chapitre
        </span>

  
   
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

      @if (is_array($cour['to_do_list']))
         @php
            $cours = json_decode($cour['to_do_list']);
     
            @endphp
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

          @if (is_array($cour['exemple']))
             @php
            $cours = json_decode($cour['exemple']);
            @endphp
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
        
        @if(is_array($cour['boite_idees']))
            @php
            $cours = json_decode($cour['boite_idees']);
            @endphp
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

    @if (is_array($cour['doc_a_completer']))
            @php
            $cours = json_decode($cour['doc_a_completer']);
            @endphp
            @foreach ($cours as $label => $link)
                <div style="margin-bottom: 8px;">
                    <a href="{{ $link }}" target="_blank">
                        <i class="far fa-file fa-2x"
                            style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; background-color: #5587b3; color: #FFF; padding:4px; border-radius: 5px;"></i>
                        <span class="orange-text"> {{ $label }} </span>
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



    </div>
@endsection
