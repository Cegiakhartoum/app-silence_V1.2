@extends('student.layouts.page-action')

@php
    use App\Http\Controllers\Productrice\AtelierController;
    $AtelierCtrl = new AtelierController();
    $cours = $AtelierCtrl->getCours();
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

        #menuToggle input:checked~span {
            opacity: 1;
            transform: rotate(45deg) translate(-2px, -1px);
            background: #d5972b;
        }

        #menuToggle input:checked~span:nth-last-child(3) {
            opacity: 0;
            transform: rotate(0deg) scale(0.2, 0.2);
        }

        #menuToggle input:checked~span:nth-last-child(2) {
            transform: rotate(-45deg) translate(0, -1px);
        }

        #menu {
            position: absolute;
            width: 300px;
            height: 900px;
            max-height: calc(100vh - 30px);
            margin: -100px 0 0 -50px;
            padding: 50px;
            padding-top: 125px;
            background: #eee;
            list-style-type: none;
            -webkit-font-smoothing: antialiased;
            transform-origin: 0% 0%;
            transform: translate(-100%, 0);
            transition: transform 0.5s cubic-bezier(0.77, 0.2, 0.05, 1);
            overflow-y: auto;
            /* Pour Firefox */
            scrollbar-width: thin;
            scrollbar-color: #d5972b transparent;

            /* Pour les navigateurs Webkit (Chrome, Safari) */
            &::-webkit-scrollbar {
                width: 10px;
            }

            &::-webkit-scrollbar-track {
                background: transparent;
            }

            &::-webkit-scrollbar-thumb {
                background-color: #d5972b;
                border-radius: 5px;
            }
        }

        #menu .action-menu-item {
            font-size: 12px;
        }

        #menuToggle input:checked~.d-flex {
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
                {{ empty($action->titre_oeuvre) ? 'Mon cv vidéo' : $action->titre_oeuvre }}</a>
        </div>

        <div  class="action-menu-item {{ isActiveClass(30) }}">
            <a href="?c=30&p={{ $action->projet_action_id }}" data-href="?c=30&p={{ $action->projet_action_id }}">Mes idées</a>
        </div>

        <div class="action-menu-item {{ isActiveClass(31) }}">
            <a href="?c=31&p={{ $action->projet_action_id }}" data-href="?c=31&p={{ $action->projet_action_id }}">J'organise mon discours</a>
        </div>

        <div class="action-menu-item {{ isActiveClass(6) }}">
            <a href="?c=6&p={{ $action->projet_action_id }}" data-href="?c=6&p={{ $action->projet_action_id }}">Mise en page de ton scenario</a>
        </div>
        
        <div class="action-menu-item {{ isActiveClass(34) }}">
            <a href="?c=34&p={{ $action->projet_action_id }}" data-href="?c=34&p={{ $action->projet_action_id }}">Scénario</a>
        </div>
      
        <div class="action-menu-item {{ isActiveClass(35) }}">
        <a href="?c=35&p={{ $action->projet_action_id }}" data-href="?c=35&p={{ $action->projet_action_id }}">Découpage technique</a>
        </div>
       
        <div class="action-menu-item {{ isActiveClass(36) }}">
        <a href="?c=36&p={{ $action->projet_action_id }}" data-href="?c=36&p={{ $action->projet_action_id }}">Lieux de  tournage</a>
        </div>

         <div class="action-menu-item {{ isActiveClass(37) }}">
         <a href="?c=37&p={{ $action->projet_action_id }}" data-href="?c=37&p={{ $action->projet_action_id }}">Liste des  acteurs/actrices</a>
        </div>

        <div class="action-menu-item {{ isActiveClass(39) }}">
        <a href="?c=39&p={{ $action->projet_action_id }}" data-href="?c=39&p={{ $action->projet_action_id }}">Dépouillement personnages</a>
        </div>
        
        <div class="action-menu-item {{ isActiveClass(40) }}">
        <a href="?c=40&p={{ $action->projet_action_id }}" data-href="?c=40&p={{ $action->projet_action_id }}#open-modal">Planning de tournage</a>
        </div>

        <div class="action-menu-item {{ isActiveClass(41) }}">
        <a href="?c=41&p={{ $action->projet_action_id }}" data-href="?c=41&p={{ $action->projet_action_id }}">Feuille de script</a>
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
    @else
        @if ($chapterKey == 3)
            {{-- SCHEMA NARRATIF --}}
            <h4 class="text-center font-weight-bolder action-title"> {{ getActionTitle() }} </h4>

            <br>
            <form id="action-form" class="flex-grow-1" style="overflow-y: scroll;" method="POST" action="/save-action">
                @csrf
                <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                <input type="hidden" name="redirect_url"
                    value="/student/action?p={{ $action->projet_action_id }}&c={{ $nextChapterKey }}" />
                <table>
                    <tr>
                        <td>
                            <div>Situation initiale</div>
                            <div class="text-center">Qui? Où? Quand?</div>
                            <div>
                                Expose le contexte, présente le ou les personnages principaux, les lieux, l'environnement du
                                héros et des personnages
                            </div>
                        </td>
                        <td>
                            <textarea name="r1" class="action-textarea w-100 h-100">{{ $action->situtation_initiale ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Élément perturbateur</div>
                            <div>Est le problème auquel le personnage principal sera confronté</div>
                        </td>
                        <td>
                            <textarea name="r2" class="action-textarea w-100 h-100">{{ $action->element_pertubateur ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Péripéties</div>
                            <div>Ce sont les différentes actions que le personnage principal va devoir faire pour résoudre
                                son problème.
                                À la fin des péripéties vient le Climax, le moment le plus intense du film où le héros va
                                pouvoir résoudre son problème.
                            </div>
                        </td>
                        <td>
                            <textarea name="r3" class="action-textarea w-100 h-100">{{ $action->peripeties ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Élément de résolution</div>
                            <div>Moment où le héros va enfin trouver une solution pour résoudre son problème. </div>
                        </td>
                        <td>
                            <textarea name="r4" class="action-textarea w-100 h-100">{{ $action->element_resolution ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Situation finale</div>
                            <div>C’est la fin du film, le héros qui était malheureux redevient heureux...ou pas.</div>
                        </td>
                        <td>
                            <textarea name="r5" class="action-textarea w-100 h-100">{{ $action->situation_finale ?? '' }}</textarea>
                        </td>
                    </tr>
                </table>
            </form>
        @elseif($chapterKey < 6)
            <div class="d-flex flex-column h-100">
                <h4 class="text-center font-weight-bolder action-title"> {{ getActionTitle() }} </h4>
<br>
                <form id="action-form" class="flex-grow-1" method="POST" action="/save-action">
                    @csrf
                    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                    <input type="hidden" name="redirect_url"
                        value="/student/action?p={{ $action->projet_action_id }}&c={{ $nextChapterKey }}" />
                    <textarea name="r1" class="action-textarea w-100 h-100" cols="50">{{ $action->r1 ?? '' }}</textarea>
                </form>
            </div>
        @elseif($chapterKey == 30)
        {{-- SCHEMA NARRATIF --}}
        @include('student.components.cv_video.idees')
        @elseif($chapterKey == 31)
        {{-- SCHEMA NARRATIF --}}
        @include('student.components.cv_video.discours')
        @elseif($chapterKey == 32)
        {{-- SCHEMA NARRATIF --}}
        @include('student.components.cv_video.liste_technique')
        @elseif($chapterKey == 6)
            {{-- MISE EN PAGE SCENARIO --}}
            @include('student.components.cv_video.mise-en-page-scenario')
        @elseif($chapterKey == 34)
            {{-- SCENARIO --}}
            @include('student.components.cv_video.scenario')
        @elseif($chapterKey == 35)
            {{-- DECOUPAGE TECHNIQUE --}}
            @include('student.components.cv_video.decoupage-technique')
        @elseif($chapterKey == 36)
            {{-- LIEU DE TOURNAGE --}}
            @include('student.components.cv_video.lieu_tournage')
      
        @elseif($chapterKey == 37)
            {{-- Liste ACTEURS/ATRICES --}}   
            @include('student.components.cv_video.liste_acteurs')

        @elseif($chapterKey == 39)
            {{-- DEPOUILLEMENT --}}
            @include('student.components.cv_video.depouillement')

        @elseif($chapterKey == 40)
            {{-- PLANNING DE TOURNAGE --}}
            @include('student.components.cv_video.planning')

        @elseif($chapterKey == 41)
            {{-- FEUILLE DE SCRIPT --}}
            @include('student.components.cv_video.feuille_script')
        @else
        @endif
    @endif

@endsection


@section('help')

    <div style="text-align: LEFT; width: 200px; ">

    @if ($chapterKey == 34)
   
    <br>
    <button  id="saveIcon" type="submit" class="btn btn-orange rounded-pill" style="width:100%;">Enregistrer le projet</button>
    @endif
   @if ($chapterKey != 41 && $chapterKey != 34)
    <br>
    <button  id="saveModal-button" type="submit" class="btn btn-orange rounded-pill" style="width:100%;">Enregistrer le projet</button>
    @endif
    <br> 
   

    @if ($chapterKey == 34)
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


    @if ($chapterKey == 32)
    <a tabindex="0" data-bs-toggle="dropdown">
    <button type="submit" class="btn btn-orange rounded-pill" style="width:100%; background:#4A4D77; border-color:#617A9A; margin-right: 5px;margin-top:15px;">Ajouter un technicien</button>
    </a>
    <ul class="dropdown-menu">
                <li>
                <button type="button" id="ajouter-ligne">Ajouter une ligne</button>

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

    @if ($chapterKey == 35)
      <a tabindex="0" data-bs-toggle="dropdown">
    <button type="submit" class="btn btn-orange rounded-pill" style="width:100%; background:#4A4D77; border-color:#617A9A; margin-right: 5px;margin-top:15px;">Ajouter un plan</button>
    </a>
    <ul class="dropdown-menu">
                <li>
                    <a id="add-sequence-menu" class="dropdown-item" href="#open-modal">Ajouter un plan</a>
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

    @if ($chapterKey == 40)
    <a tabindex="0" data-bs-toggle="dropdown">
    <button type="submit" class="btn btn-orange rounded-pill" style="width:100%; background:#4A4D77; border-color:#617A9A; margin-right: 5px;margin-top:15px;">Gestion du planning</button>
    </a>
    <ul class="dropdown-menu">
                <li>
                    <a id="add-sequence-menu" class="dropdown-item" href="#open-modal">Ordre</a>
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
              <li><a class="dropdown-item" href="/report/cv?id={{ $action->id }}">Tout le projet</a></li>
              @if ($chapterKey != 0 || $chapterKey != 0) 
                <li><a class="dropdown-item" href="/report/{{ getActionTitle() }}?id={{ $action->id }}">{{ getActionTitle() }}</a></li>

              @endif      
                <li>
                    <hr class="dropdown-divider">
                </li>
   </ul>
   @if ($chapterKey == 34 or $chapterKey == 35)
            <br>
            <a style="color:#617A9A; text-align:left; font-size:15px;">
                <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/oeil.png" alt="Vue classique"
                    id="{{ $chapterKey == 34 ? 'scenario-vue-classique-btn' : 'decoupage-vue-classique-btn' }}"
                    style=" height: 18px;padding-right:25px;" />
                Vue classique
            </a>
        @endif
     <br>

     @foreach ($cours as $cour)
            @if (is_string($cour))
                {{-- Print out the string value to see what's causing the issue --}}
                <div>Error: $cour is a string with value: {{ $cour }}</div>
            @else
                @if ($chapterKey == $cour['action_id'])
                    <a href="/student/cours?c={{ $cour['id'] }}"
                        style="color:#617A9A; text-align:left; font-size:15px;">
                        <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/play.png"
                            alt="Aller au cours" style=" height: 18px; padding-right:25px;" />
                        Voir le chapitre
                    </a>
                @endif
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
    @if ($chapterKey == 34)
        <div style=" margin: 5px;">
            <div style="in">
                <button type="button" class="btn add-between-dialogue-scene-btn" style="background: #4a4d77;" disabled>
                </button>
                <p>Dialogue personnage</p>
            </div>
            <div>
                <button type="button" class="btn add-between-description-scene-btn" style="background: #d6982c"
                    disabled>
                </button>
                <p>Description de scène</p>
            </div>
        </div>
    @endif
@endsection


