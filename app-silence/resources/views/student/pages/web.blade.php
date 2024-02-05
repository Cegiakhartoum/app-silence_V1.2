@extends('student.layouts.page-action')

@php

    $chapterKey = isset($_GET['c']) ? $_GET['c'] : 0;
  
    $parts = config('z-actions');

    if ($chapterKey != 0) {
        $chapter = $parts[$chapterKey];
        $nextChapterKey = $chapterKey + 1;
    }

    function isActiveClass($chapter)
    {
        $chapterKey = $_GET['c'] ?? 1;
        return $chapterKey == $chapter ? 'active' : '';
    }

    function getActionTitle()
    {
        $chapterKey = $_GET['c'] ?? 1;
        $parts = config('z-actions');
        $chapter = $parts[$chapterKey];

        return $chapter['action_title'] ?? $chapter['name'];
    }

    function getActionSubTitle()
    {
        $subtitle = getActionTitle();
        $subtitle = str_replace('Le', 'ton', $subtitle);
        $subtitle = str_replace('La', 'ta', $subtitle);
        return $subtitle;
    }

@endphp


@section('sidebar')
<style>
#menuToggle {
  display: block;
  position: relative;
  top: 50px;
  left: 50px;
  z-index: 1;
  -webkit-user-select: none;
  user-select: none;

}

#menuToggle input {
  display: block;
  width: 40px;
  height: 32px;
  position: absolute;
  top: -7px;
  left: -5px;
  cursor: pointer;
  opacity: 0;
  z-index: 2;
  -webkit-touch-callout: none;

}

#menuToggle span {
  display: block;
  width: 33px;
  height: 4px;
  margin-bottom: 5px;
  position: relative;
  background: #d5972b;
  border-radius: 3px;
  z-index: 1;
  transform-origin: 4px 0px;
  transition: transform 0.5s cubic-bezier(0.77, 0.2, 0.05, 1),
    background 0.5s cubic-bezier(0.77, 0.2, 0.05, 1), opacity 0.55s ease;
}

#menuToggle span:first-child {
  transform-origin: 0% 0%;
}

#menuToggle span:nth-last-child(2) {
  transform-origin: 0% 100%;
}

#menuToggle input:checked ~ span {
  opacity: 1;
  transform: rotate(45deg) translate(-2px, -1px);
  background: #d5972b;
}

#menuToggle input:checked ~ span:nth-last-child(3) {
  opacity: 0;
  transform: rotate(0deg) scale(0.2, 0.2);
}

#menuToggle input:checked ~ span:nth-last-child(2) {
  transform: rotate(-45deg) translate(0, -1px);
}

#menu {
  
  position: absolute;
  width: 300px;
  height:900px;
  margin: -100px 0 0 -50px;
  padding: 50px;
  padding-top: 125px;
  background: #eee;
  list-style-type: none;
  -webkit-font-smoothing: antialiased;
  /* to prevent text flicker in safari */
  transform-origin: 0% 0%;
  transform: translate(-100%, 0);
  transition: transform 0.5s cubic-bezier(0.77, 0.2, 0.05, 1);
}

#menu .action-menu-item  {

  font-size: 12px;
}


#menuToggle input:checked ~ .d-flex {
  transform: none;
}
</style>



<div id="menuToggle">

    <input type="checkbox" />

    <span></span>
    <span></span>
    <span></span>
 
    <div id="menu" class="d-flex flex-column align-items-left">

        <div class="action-menu-item {{ isActiveClass(0) }}">
            <a href="?c=0&p={{ $action->projet_action_id }}" data-href="?c=0&p={{ $action->projet_action_id }}" >
                {{ empty($action->titre_oeuvre) ? 'Page de garde' : $action->titre_oeuvre }}</a>
        </div>
        <div class="action-menu-item {{ isActiveClass(41 }}">
            <a href="?c=42&p={{ $action->projet_action_id }}" data-href="?c=42&p={{ $action->projet_action_id }}">Introduction</a>
        </div>
        <div  class="action-menu-item {{ isActiveClass(43) }}">
            <a href="?c=43&p={{ $action->projet_action_id }}" data-href="?c=43&p={{ $action->projet_action_id }}">Description du contenu</a>
        </div>
         <div class="action-menu-item {{ isActiveClass(44) }}">
            <a href="?c=44&p={{ $action->projet_action_id }}" data-href="?c=44&p={{ $action->projet_action_id }}">Ton et style</a>
        </div>
         <div class="action-menu-item {{ isActiveClass(45) }}">
            <a href="?c=45&p={{ $action->projet_action_id }}" data-href="?c=45&p={{ $action->projet_action_id }}">Structure des épisodes</a>
        </div>
         <div class="action-menu-item {{ isActiveClass(46) }}">
            <a href="?c=46&p={{ $action->projet_action_id }}" data-href="?c=46&p={{ $action->projet_action_id }}">Format et durée</a>
        </div>
        <div class="action-menu-item {{ isActiveClass(47) }}">
            <a href="?c=47&p={{ $action->projet_action_id }}" data-href="?c=47&p={{ $action->projet_action_id }}">Personna</a>
        </div>
        <div class="action-menu-item {{ isActiveClass(48) }}">
            <a href="?c=48&p={{ $action->projet_action_id }}" data-href="?c=48&p={{ $action->projet_action_id }}">Public cible</a>
        </div>
      
        <div class="action-menu-item {{ isActiveClass(49) }}">
        <a href="?c=49&p={{ $action->projet_action_id }}" data-href="?c=49&p={{ $action->projet_action_id }}">Diffusion et promotion</a>
        </div>
       
        <div class="action-menu-item {{ isActiveClass(50) }}">
        <a href="?c=50&p={{ $action->projet_action_id }}" data-href="?c=50&p={{ $action->projet_action_id }}">conclusion</a>
        </div>

        <div class="action-menu-item {{ isActiveClass(51) }}">
            <a href="?c=51&p={{ $action->projet_action_id }}" data-href="?c=51&p={{ $action->projet_action_id }}">Concept de la chaine</a>
        </div>
    </div>
</div> 

@endsection

@section('content')
@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
    @if ($chapterKey == 0)
        {{-- PAGE DE GARDE --}}
        <style>
            form input {
                text-align: center;
                border: none;
                border-bottom: 2px solid rgba(200, 200, 200, 0.2);
                width: 80%;
                caret-color: #3b3e5e;
            }

            form input:focus {
                outline: none;
                border-bottom: 2px solid rgba(74, 77, 119, 0.541);
            }

            form input:focus::placeholder {
                color: #FFF;
            }

            form input::placeholder {
                color: #000;
                opacity: 1;
            }
            
        </style>
     

        <form id="action-form" class="flex-grow-1 h-100" style="overflow-y: scroll;" method="POST" action="/save-action">
            @csrf



            <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
            <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
            <input type="hidden" name="redirect_url" value="/student/action?p={{ $action->projet_action_id }}&c=1" />

            <div class="d-flex flex-column justify-content-center align-items-center h-100">
                <input id="titreProjetInput" type="text" name="r1" style="font-size:30px; font-weight:bold;"
                    value="{{ $action->titre_oeuvre }}" placeholder="TITRE DU PROJET" style="font-size: 2.25rem;"
                    autocomplete="off" />
                <div class="text-center mt-5 mb-5" style="font-size:1.5em; font-weight: 400;">
                    {{ $projet->classe ?? "Classe" }} <br />
                    @if (is_object($group) && $group->id != 1  )
                        {{ $group->nom ?? "Groupe" }} <br />
                        {{ $membres ?? "Nom de.des auteur.es" }}
                    @else
                        {{ Auth::user()->name }}
                    @endif

                </div>
            </div>

        </form>
   
        @elseif($chapterKey == 41)
        {{-- SCHEMA NARRATIF --}}
        @include('student.components.webtv.introduction')
        @elseif($chapterKey == 6)
            {{-- MISE EN PAGE SCENARIO --}}
            @include('student.components.action.mise-en-page-scenario')
        @elseif($chapterKey == 7)
            {{-- SCENARIO --}}
            @include('student.components.action.scenario')
        @elseif($chapterKey == 16)
            {{-- DECOUPAGE TECHNIQUE --}}
            @include('student.components.action.decoupage-technique')
        @elseif($chapterKey == 18)
            {{-- LIEU DE TOURNAGE --}}
            @include('student.components.action.lieu_tournage')
      
        @elseif($chapterKey == 29)
            {{-- Liste ACTEURS/ATRICES --}}   
            @include('student.components.action.liste_acteurs')

        @elseif($chapterKey == 27)
            {{-- DEPOUILLEMENT --}}
            @include('student.components.action.depouillement')

        @elseif($chapterKey == 17)
            {{-- PLANNING DE TOURNAGE --}}
            @include('student.components.action.planning')

        @elseif($chapterKey == 21)
            {{-- FEUILLE DE SCRIPT --}}
            @include('student.components.action.feuille_script')
        @else
        @endif


@endsection


@section('help')

    <div style="text-align: LEFT; width: 200px; ">

    @if ($chapterKey == 7)
   
    <br>
    <button  id="saveIcon" type="submit" class="btn btn-orange rounded-pill" style="width:100%;">Enregistrer le projet</button>
    @endif
   @if ($chapterKey != 21 && $chapterKey != 7)

    <br>
    <button  id="saveModal-button" type="submit" class="btn btn-orange rounded-pill" style="width:100%;">Enregistrer le projet</button>
    @endif
    <br> 
   

    @if ($chapterKey == 7)
    <a tabindex="0" data-bs-toggle="dropdown">
    <button type="submit" class="btn btn-orange rounded-pill" style="width:100%; background:#4A4D77; border-color:#617A9A; margin-right: 5px;margin-top:15px;">Ajouter une séquence</button>
    </a>
    <ul class="dropdown-menu">
                <li>
                    <a id="add-sequence-menu" class="dropdown-item" href="#">Ajouter une séquence</a>
                </li>
                {{-- <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Separated link</a></li> --}}
   </ul>
      
    <br>    
    @endif

    @if ($chapterKey == 16)
      <a tabindex="0" data-bs-toggle="dropdown">
    <button type="submit" class="btn btn-orange rounded-pill" style="width:100%; background:#4A4D77; border-color:#617A9A; margin-right: 5px;margin-top:15px;">Ajouter un découpage</button>
    </a>
    <ul class="dropdown-menu">
                <li>
                    <a id="add-sequence-menu" class="dropdown-item" href="#open-modal">Ajouter un découpage</a>
                </li>
                {{-- <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Separated link</a></li> --}}
   </ul>
    
    <br>      
    @endif

    @if ($chapterKey == 17 )
    <a tabindex="0" data-bs-toggle="dropdown">
    <button type="submit" class="btn btn-orange rounded-pill" style="width:100%; background:#4A4D77; border-color:#617A9A; margin-right: 5px;margin-top:15px;">Gestion du planning</button>
    </a>
    <ul class="dropdown-menu">
                <li>
                    <a id="add-sequence-menu" class="dropdown-item" href="#open-modal">Ordre</a>
                </li>
                <li>
                    <a id="add-sequence-menu" class="dropdown-item" href="#open-modal-trajet">Temps de trajet</a>
                </li>
                <li>
                    <a id="add-sequence-menu" class="dropdown-item" href="#open-modal-déjeuner">Pause dejeuner</a>
                </li>
          
                {{-- <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Separated link</a></li> --}}
   </ul>
   
    <br>    
    @endif

    <br>
    <br>
    <br>
    <br>

    <a tabindex="0" data-bs-toggle="dropdown" style="color:#617A9A; text-align:left; font-size:15px;">
    <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/telecharger.png" alt="Télécharger" style=" height: 18px;padding-right:25px;"/>
    Télécharger 
    </a>

    <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/report/silence?id={{ $action->id }}">Tout le projet</a></li>
              @if ($chapterKey != 0) 
                <li><a class="dropdown-item" href="/report/{{ getActionTitle() }}?id={{ $action->id }}">{{ getActionTitle() }}</a></li>

              @endif      
                <li>
                    <hr class="dropdown-divider">
                </li>
   </ul>


     @if ($chapterKey == 7)
     <br>
     <a style="color:#617A9A; text-align:left; font-size:15px;">  
    <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/oeil.png" alt="Vue classique" id="scenario-vue-classique-btn" style=" height: 18px;padding-right:25px;"/>
    Vue classique
    </a>

     @endif
     <br>

      @foreach($cours as $cour)

      @if($chapterKey  == $cour['action_id'] )
     <a href="/student/cours?c={{ $cour['id']}}"style="color:#617A9A; text-align:left; font-size:15px;">  
    <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/play.png" alt="Aller au cours" style=" height: 18px;padding-right:25px;"/>
        Voir le chapitre
        </a>

       @endif
      @endforeach
   


        </div>

    


    <!-- Modal save and go to next section -->
    <div class="modal fade scenario-blue-modal" id="validateModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-right">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: #ebba16;">&times;</span>
                        </button>
                    </div>
                    <div class="text-center"
                        style="margin-bottom: 32px; margin-top: 24px; font-weight: bold; color: #FFF; font-size: 150%;">
                        Tu souhaites passer au document suivant ?
                    </div>
                    <div class="text-center" style="margin-bottom: 24px;">
                        {{ isset($nextChapter) ? $nextChapter['name'] : '' }}
                    </div>

                    <div class="text-center">
                        <button id="validate-button" type="button" class="btn btn-primary">OUI</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
