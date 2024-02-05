@extends('student.layouts.page-atelier', ['contentBackground' => '#3b3d61'])

@php

$chapterKey = $_GET['c'];
$parts = config('z-courses');
$chapter = $parts[$chapterKey];

$nextChapterKey = $chapterKey + 1;

$passerLabel = "Passer au chapitre suivant";


if (isset($parts[$nextChapterKey])) {

    $nextChapter = $parts[$nextChapterKey];

    if ($chapter['partie'] != $nextChapter['partie']) {
        $nextLabel = $nextChapter['partie'];
    } elseif ($nextChapter['chapitre'] == 'Le recap’') {
        $nextLabel = $nextChapter['partie'] . ' - Le récap’';
    } else {
        $nextLabel = $nextChapter['chapitre'];
    }

    if($nextChapter["partie"] != $chapter["partie"]){
        $passerLabel = "Passer à la partie suivante";
    }

}

$actionMessage = $chapter['action_message'] ?? '';

if ($chapter['chapitre'] == "Le récap'") {
    $actionMessage = $chapter['partie'] . ' dans ACTION !';
}

@endphp

@section('sidebar')
    <div>
        <a href="/student/parcours-film-fiction">
            <span style="background: rgba(255,255,255,0.1); padding:8px 16px; color:#AAA; border-radius:4px;">
                <i class="fas fa-arrow-left"></i>
            </span>
        </a>

        <span class="orange-text"
            style="margin-left: 16px; background: rgba(255,255,255,0.3); border-radius:4px; padding:1px 8px;">
            Chapitre
        </span>
    </div>
    <div style="font-weight: lighter; font-size: 20px; margin: 16px 0 32px 64px;  color: #FFF; line-height: 100%;">
        <div style="font-size: 60%;"> {{ $chapter['partie'] }} </div>
        {{ $chapter['chapitre'] }}
    </div>

    <div style="padding-left: 8px;">
        @if (isset($chapter['video_steps']))
            <div>
                <i class="fab fa-youtube orange-text fa-2x" style="margin-right: 5px; vertical-align: middle;"></i>
                <span class="orange-text"> {{ $chapter['chapitre'] }} </span>
            </div>
            @foreach ($chapter['video_steps'] as $time => $step)
                <div style="padding: 8px 0px 8px 0; color:#FFF;">
                    <span style="margin-right: 12px; vertical-align: middle;"> {{ $time }}</span>
                    <span class="orange-text"> {{ $step }}</span>
                </div>
            @endforeach
            <br />
        @endif
        @if ($chapter['doc_recap'] != '')
            <div style="margin-bottom: 8px;">
                <a href="{{ $chapter['doc_recap'] }}" target="_blank">
                    <i class="far fa-file fa-2x"
                        style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; background-color: #D5972B; color: #FFF; padding:4px; border-radius: 5px;"></i>
                    <span class="orange-text"> Récap'
                        {{ $chapter['chapitre'] == "Le récap'" ? "Le récap' ".$chapter['partie'] : $chapter['chapitre'] }} </span>
                </a>
            </div>
        @endif
        @if (is_array($chapter['to_do_list']))
            @foreach ($chapter['to_do_list'] as $label => $link)
                <div style="margin-bottom: 8px;">
                    <a href="{{ $link }}" target="_blank">
                        <i class="far fa-file fa-2x"
                            style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; background-color: #D5972B; color: #FFF; padding:4px; border-radius: 5px;"></i>
                        <span class="orange-text"> {{ $label }} </span>
                    </a>
                </div>
            @endforeach
        @endif
        @if ($chapter['fiche_recap_des_chapitres'] != '')
            <div style="margin-bottom: 8px;">
                <a href="{{ $chapter['fiche_recap_des_chapitres'] }}" target="_blank">
                    <i class="far fa-file fa-2x"
                        style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; background-color: #D5972B; color: #FFF; padding:4px; border-radius: 5px;"></i>
                    <span class="orange-text"> Récap' - Tous les chapitres </span>
                </a>
            </div>
        @endif
        @if (is_array($chapter['exemple']))
            @foreach ($chapter['exemple'] as $label => $link)
                <div style="margin-bottom: 8px;">
                    <a href="{{ $link }}" target="_blank">
                        <i class="far fa-file fa-2x"
                            style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; background-color: #D5972B; color: #FFF; padding:4px; border-radius: 5px;"></i>
                        <span class="orange-text"> {{ $label }} </span>
                    </a>
                </div>
            @endforeach
        @endif
        @if (is_array($chapter['boite_idees']))
            @foreach ($chapter['boite_idees'] as $label => $link)
                <div style="margin-bottom: 8px;">
                    <a href="{{ $link }}" target="_blank">
                        <i class="far fa-file fa-2x"
                            style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; background-color: #D5972B; color: #FFF; padding:4px; border-radius: 5px;"></i>
                        <span class="orange-text"> Boites à idées - {{ $label }} </span>
                    </a>
                </div>
            @endforeach
        @endif
        @if (is_array($chapter['doc_a_completer']))
            @foreach ($chapter['doc_a_completer'] as $label => $link)
                <div style="margin-bottom: 8px;">
                    <a href="{{ $link }}" target="_blank">
                        <i class="far fa-file fa-2x"
                            style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; background-color: #5587b3; color: #FFF; padding:4px; border-radius: 5px;"></i>
                        <span class="orange-text"> {{ $label }} </span>
                    </a>
                </div>
            @endforeach
        @endif
        @if ($chapter['chapitre_par_ecrit'] != '')
            <div style="margin-bottom: 8px;">
                <a href="{{ $chapter['chapitre_par_ecrit'] }}" target="_blank">
                    <i class="fas fa-info-circle fa-2x"
                        style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; color: #5587b3; border: none; background-color: #FFF; border-radius: 50%;"></i>
                    <span class="orange-text"> Le chapitre par écrit </span>
                </a>
            </div>
        @endif
        @if ($chapter['tous_les_chapitres_par_ecrit'] != '')
            <div style="margin-bottom: 8px;">
                <a href="{{ $chapter['tous_les_chapitres_par_ecrit'] }}" target="_blank">
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
            @if (isset($chapter['video']))
                <div class="col-md-12">
                    <video controls style="width: 100%; border: 1px solid #FFF; background: #222136; border-radius: 16px;">
                        <source src="{{ $chapter['video'] }}" type="video/mp4">
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
