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
    $introductions = json_decode($action->introduction);
@endphp

@section('sidebar')

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
        {{ empty($action->titre_oeuvre) ? 'Page de garde' : $action->titre_oeuvre }}</a>
</div>
<div class="action-menu-item {{ isActiveClass(42) }}">
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
                    value="{{ $action->titre_oeuvre }}" placeholder="TITRE DE CHAINE" style="font-size: 2.25rem;"
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
        @if ($chapterKey == 42)
            {{-- SCHEMA NARRATIF --}}
            <h4 class="text-center font-weight-bolder action-title"> {{ getActionTitle() }} </h4>
@php
$data = json_decode($action->introduction);
@endphp
<br>

            <form id="action-form" class="flex-grow-1" style="overflow-y: scroll;" method="POST" action="/save-action">
                @csrf
                <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                <input type="hidden" name="redirect_url"
                    value="/student/action?p={{ $action->projet_action_id }}&c={{ $nextChapterKey }}" />
                    <table>
                 
                <tr>
                <td style="width: 30%; height:140px;">
                            <div>Phrase d'accroche</div>
                          
                        </td>
                        <td>
                            <textarea name="phrase" class="action-textarea w-100 h-100">{{ $data->phrase ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:140px;">
                            <div>Nom et objectif</div>

                        </td>
                        <td>
                            <textarea name="nom" class="action-textarea w-100 h-100">{{ $data->nom ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:140px;">
                            <div>Ton et ambiance </div>

                        </td>
                        <td>
                            <textarea name="ton" class="action-textarea w-100 h-100">{{ $data->ton ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:140px;">
                            <div>Public cible</div>

                        </td>
                        <td>
                            <textarea name="public" class="action-textarea w-100 h-100">{{ $data->public ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:140px;">
                            <div>Unicité</div>

                        </td>
                        <td>
                            <textarea name="unicité" class="action-textarea w-100 h-100">{{ $data->unicité ?? '' }}</textarea>
                        </td>
                    </tr>
           

                </table>
                
            </form>
            @else
        @if ($chapterKey == 43)
            {{-- SCHEMA NARRATIF --}}
            <h4 class="text-center font-weight-bolder action-title"> {{ getActionTitle() }} </h4>
            @php
$data = json_decode($action->webtv_description);
@endphp

            <form id="action-form" class="flex-grow-1" style="overflow-y: scroll;" method="POST" action="/save-action">
                @csrf
                <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                <input type="hidden" name="redirect_url"
                    value="/student/action?p={{ $action->projet_action_id }}&c={{ $nextChapterKey }}" />
                    <table>
                 
                <tr>
                <td style="width: 30%; height:140px;">
                            <div>Contenu de la web télé</div>
                          
                        </td>
                        <td>
                            <textarea name="contenu" class="action-textarea w-100 h-100">{{ $data->contenu ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:140px;">
                            <div>Sujets et invités</div>

                        </td>
                        <td>
                            <textarea name="sujet" class="action-textarea w-100 h-100">{{ $data->sujet ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:140px;">
                            <div>Contenu visuel</div>

                        </td>
                        <td>
                            <textarea name="visuel" class="action-textarea w-100 h-100">{{ $data->visuel ?? '' }}</textarea>
                        </td>
                    </tr>
                    
                </table>
                
            </form>
            @else
        @if ($chapterKey == 44)
            {{-- SCHEMA NARRATIF --}}
            <h4 class="text-center font-weight-bolder action-title"> {{ getActionTitle() }} </h4>
            @php
$data = json_decode($action->ton_style);
@endphp
    
            <form id="action-form" class="flex-grow-1" style="overflow-y: scroll;" method="POST" action="/save-action">
                @csrf
                <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                <input type="hidden" name="redirect_url"
                    value="/student/action?p={{ $action->projet_action_id }}&c={{ $nextChapterKey }}" />
                    <table>
                 
                <tr>
                <td style="width: 30%; height:240px;">
                            <div>Le ton</div>
                          
                        </td>
                        <td>
                            <textarea name="ton" class="action-textarea w-100 h-100">{{ $data->ton ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:240px;">
                            <div>Le style</div>

                        </td>
                        <td>
                            <textarea name="style" class="action-textarea w-100 h-100">{{ $data->style ?? '' }}</textarea>
                        </td>
                    </tr>
 
                </table>
                
            </form>
            @else
            @if ($chapterKey == 45)
            {{-- SCHEMA NARRATIF --}}
            <div class="d-flex flex-column h-100">
                <h4 class="text-center font-weight-bolder action-title"> {{ getActionTitle() }} </h4>
<br>
                <form id="action-form" class="flex-grow-1" method="POST" action="/save-action">
                    @csrf
                    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                    <input type="hidden" name="redirect_url"
                        value="/student/action?p={{ $action->projet_action_id }}&c={{ $nextChapterKey }}" />
                    <textarea name="structure" class="action-textarea w-100 h-100" cols="50">{{ $action->structure ?? '' }}</textarea>
                </form>
            </div>
                
            </form>
            @else
            @if ($chapterKey == 46)
            {{-- SCHEMA NARRATIF --}}
            <div class="d-flex flex-column h-100">
                <h4 class="text-center font-weight-bolder action-title"> {{ getActionTitle() }} </h4>
<br>
                <form id="action-form" class="flex-grow-1" method="POST" action="/save-action">
                    @csrf
                    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                    <input type="hidden" name="redirect_url"
                        value="/student/action?p={{ $action->projet_action_id }}&c={{ $nextChapterKey }}" />
                    <textarea name="format_durée" class="action-textarea w-100 h-100" cols="50">{{ $action->format_durée ?? '' }}</textarea>
                </form>
            </div>
            @else
            @if ($chapterKey == 47)
            {{-- SCHEMA NARRATIF --}}

            @php
$datas = json_decode($action->personna);
$i=1;
@endphp

            <form id="action-form" class="flex-grow-1" style="overflow-y: scroll;" method="POST" action="/save-action">
                @csrf
                <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                <input type="hidden" name="redirect_url"
                    value="/student/action?p={{ $action->projet_action_id }}&c={{ $nextChapterKey }}" />
                    @if (!empty($datas))
            @foreach($datas as $data)   
<h4 class="text-center font-weight-bolder action-title"> {{ getActionTitle() }} {{$i}} </h4>
<br>
                    <table>
                 
                <tr>
                        <td>
                            <div>Nom</div>
                          
                        </td>
                        <td>
                            <textarea name="nom[{{$i}}]" class="action-textarea w-100 h-100">{{ $data->nom ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Sexe</div>

                        </td>
                        <td>
                            <textarea name="sexe[{{$i}}]" class="action-textarea w-100 h-100">{{ $data->sexe ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Âge</div>
                          
                        </td>
                        <td>
                            <textarea name="age[{{$i}}]" class="action-textarea w-100 h-100">{{ $data->age ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Situation géographique</div>

                        </td>
                        <td>
                            <textarea name="situation[{{$i}}]" class="action-textarea w-100 h-100">{{ $data->situation ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Profession</div>
                          
                        </td>
                        <td>
                            <textarea name="préparation[{{$i}}]" class="action-textarea w-100 h-100">{{ $data->préparation ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:140px;">
                            <div>Centres d'intérêt</div>

                        </td>
                        <td>
                            <textarea name="centre[{{$i}}]" class="action-textarea w-100 h-100">{{ $data->centre ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:140px;">
                            <div>Problèmes</div>
                          
                        </td>
                        <td>
                            <textarea name="probléme[{{$i}}]" class="action-textarea w-100 h-100">{{ $data->probléme ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:140px;">
                            <div>Objectifs</div>

                        </td>
                        <td>
                            <textarea name="objectifs[{{$i}}]" class="action-textarea w-100 h-100">{{ $data->objectifs ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:140px;">
                            <div>Comportement en ligne</div>
                        </td>
                        <td>
                            <textarea name="comportement[{{$i}}]" class="action-textarea w-100 h-100">{{ $data->comportement ?? '' }}</textarea>
                        </td>
                    </tr>

 
                </table>
                <br>
                @php
                $i++;
                @endphp
        @endforeach
 
        @else
        <h4 class="text-center font-weight-bolder action-title"> {{ getActionTitle() }} 1</h4>
        
        <table>
                 
                 <tr>
                         <td>
                             <div>Nom</div>
                           
                         </td>
                         <td>
                             <textarea name="nom[1]" class="action-textarea w-90 h-100"></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td>
                             <div>Sexe</div>
 
                         </td>
                         <td>
                             <textarea name="sexe[1]" class="action-textarea w-100 h-100"></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td>
                             <div>Âge</div>
                           
                         </td>
                         <td>
                             <textarea name="age[1]" class="action-textarea w-100 h-100"></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td>
                             <div>Situation géographique</div>
 
                         </td>
                         <td>
                             <textarea name="situation[1]" class="action-textarea w-100 h-100"></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td>
                             <div>Profession</div>
                           
                         </td>
                         <td>
                             <textarea name="préparation[1]" class="action-textarea w-100 h-100"></textarea>
                         </td>
                     </tr>
                     <tr>
                     <td style="width: 30%; height:140px;">
                             <div>Centres d'intérêt</div>
 
                         </td>
                         <td>
                             <textarea name="centre[1]" class="action-textarea w-100 h-100"></textarea>
                         </td>
                     </tr>
                     <tr>
                     <td style="width: 30%; height:140px;">
                             <div>Problèmes</div>
                           
                         </td>
                         <td>
                             <textarea name="probléme[1]" class="action-textarea w-100 h-100"></textarea>
                         </td>
                     </tr>
                     <tr>
                     <td style="width: 30%; height:140px;">
                             <div>Objectifs</div>
 
                         </td>
                         <td>
                             <textarea name="objectifs[1]" class="action-textarea w-100 h-100"></textarea>
                         </td>
                     </tr>
                     <tr>
                     <td style="width: 30%; height:140px;">
                             <div>Comportement en ligne</div>
                         </td>
                         <td>
                             <textarea name="comportement[1]" class="action-textarea w-100 h-100"></textarea>
                         </td>
                     </tr>
 
  
                 </table>
                 <br>
                 @php
                $i++;
                @endphp
        @endif
    
            </form>
            @else
            @if ($chapterKey == 48)
            {{-- SCHEMA NARRATIF --}}
            <h4 class="text-center font-weight-bolder action-title"> {{ getActionTitle() }} </h4>
            @php
$data = json_decode($action->public_cible);
@endphp
<br>

            <form id="action-form" class="flex-grow-1" style="overflow-y: scroll;" method="POST" action="/save-action">
                @csrf
                <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                <input type="hidden" name="redirect_url"
                    value="/student/action?p={{ $action->projet_action_id }}&c={{ $nextChapterKey }}" />
                    <table>
                 
                <tr>
                <td style="width: 30%; height:240px;">
                            <div>Caractéristiques démographiques</div>
                          
                        </td>
                        <td>
                            <textarea name="caracteristiques" class="action-textarea w-100 h-100">{{ $data->caracteristiques ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:240px;">
                            <div>Intérêt et attentes</div>

                        </td>
                        <td>
                            <textarea name="interet" class="action-textarea w-100 h-100">{{ $data->interet ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:240px;">
                            <div>Adaptation du contenu</div>

                        </td>
                        <td>
                            <textarea name="adaptation" class="action-textarea w-100 h-100">{{ $data->adaptation ?? '' }}</textarea>
                        </td>
                    </tr>
 
                </table>
                
            </form>
            @else
            @if ($chapterKey == 49)
            {{-- SCHEMA NARRATIF --}}
            <h4 class="text-center font-weight-bolder action-title"> {{ getActionTitle() }} </h4>
            @php
$data = json_decode($action->diffusion);
@endphp
            <br>
            <form id="action-form" class="flex-grow-1" style="overflow-y: scroll;" method="POST" action="/save-action">
                @csrf
                <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                <input type="hidden" name="redirect_url"
                    value="/student/action?p={{ $action->projet_action_id }}&c={{ $nextChapterKey }}" />
                    <table>
                 
                <tr>
                <td style="width: 30%; height:300px;">
                            <div>La diffusion </div>
                          
                        </td>
                        <td>
                            <textarea name="diffusion" class="action-textarea w-100 h-100"> {{ $data->diffusion ?? '' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:300px;">
                            <div>La promotion</div>

                        </td>
                        <td>
                            <textarea name="promotion" class="action-textarea w-100 h-100"> {{ $data->promotion ?? '' }}</textarea>
                        </td>
                    </tr>
                    
 
                </table>
                
            </form>
            @else
            @if ($chapterKey == 50)
            <div class="d-flex flex-column h-100">
             <br>
                <h4 class="text-center font-weight-bolder action-title"> {{ getActionTitle() }} </h4>
                <form id="action-form" class="flex-grow-1" method="POST" action="/save-action">
                    @csrf
                    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
  
    <input type="hidden" name="redirect_url"
        value="/teacher/student-action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
                    <textarea name="conclusion" class="action-textarea w-100 h-100" cols="50">{{ $action->conclusion ?? '' }}</textarea>
                </form>
            </div>

   @else($chapterKey == 51)
            <div class="d-flex flex-column h-100">
             <br>
                <h4 class="text-center font-weight-bolder action-title"> CONCEPT DE LA CHAINE :  "{{ $action->titre_oeuvre }}" </h4>
               
                    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />

    <input type="hidden" name="redirect_url"
        value="/teacher/student-action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
                 <div class="container mt-5">
  <div class="container mt-5">
@php
$data = json_decode($action->introduction);
@endphp
  <h1 class="mb-4">INTRODUCTION</h1>

  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">Phrase d'accroche</h5>
      <p>{{ $data->phrase ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">Nom et objectif</h5>
      <p>{{ $data->nom ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">Ton et ambiance</h5>
      <p>{{ $data->ton ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">Public cible</h5>
      <p>{{ $data->public ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">Unicité</h5>
      <p>{{ $data->unicité ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>
    
  </div>
    
    

  <!-- Ajoutez d'autres sections de données ici selon la même structure -->

</div>
  <div class="container mt-5">
@php
$data = json_decode($action->ton_style);
@endphp
  <h1 class="mb-4">TON ET STYLE</h1>

  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">Le ton</h5>
      <p>{{ $data->ton ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">Le style</h5>
      <p>{{ $data->style ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>
  <!-- Ajoutez d'autres sections de données ici selon la même structure -->
</div>
 <div class="container mt-5">
  <h1 class="mb-4">STRUCTURE DES ÉPISODES</h1>

  <div class="card mb-3">
    <div class="card-body">
      <p>{{ $action->structure ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>

  <!-- Ajoutez d'autres sections de données ici selon la même structure -->
</div>
<div class="container mt-5">
  <h1 class="mb-4">FORMAT ET DURÉE</h1>

  <div class="card mb-3">
    <div class="card-body">
      <p>{{ $action->format_durée ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>

  <!-- Ajoutez d'autres sections de données ici selon la même structure -->
</div>
                   
                   
 <div class="container mt-5">
  <h1 class="mb-4">DESCRIPTION DU CONTENU</h1>
@php
$data = json_decode($action->webtv_description);
@endphp
  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">Contenu de la web télé</h5>
      <p>{{ $data->contenu ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">Sujets et invités</h5>
      <p>{{ $data->sujet ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">Contenu visuel</h5>
      <p>{{ $data->visuel ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>

  <!-- Ajoutez d'autres sections de données ici selon la même structure -->

</div>
   <div class="container mt-5">
  <h1 class="mb-4">PUBLIC CIBLE</h1>
@php
$data = json_decode($action->public_cible);
@endphp
  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">Caractéristiques démographiques</h5>
      <p>{{ $data->caracteristiques ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">Intérêt et attentes</h5>
      <p>{{ $data->interet ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>
     
       <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">Adaptation du contenu</h5>
      <p>{{ $data->adaptation ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>
  <!-- Ajoutez d'autres sections de données ici selon la même structure -->
</div>    
 <div class="container mt-5">
  <h1 class="mb-4">DIFFUSION ET PROMOTION</h1>
@php
$data = json_decode($action->diffusion);
@endphp
  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">La diffusion</h5>
      <p>{{ $data->diffusion ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">La promotion</h5>
      <p>{{ $data->promotion ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>
     
  <!-- Ajoutez d'autres sections de données ici selon la même structure -->
</div> 
<div class="container mt-5">
  <h1 class="mb-4">CONCLUSION</h1>

  <div class="card mb-3">
    <div class="card-body">
      <p>{{ $action->conclusion ?? 'Aucune donnée disponible' }}</p>
    </div>
  </div>

  <!-- Ajoutez d'autres sections de données ici selon la même structure -->
</div>
          </div>           

        
            @endif   
 @endif 
 @endif 
    @endif
    @endif
    @endif
    @endif
    
    @endif
    @endif
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

    @if ($chapterKey == 47 )
 
       <button type="button"  class="btn btn-orange rounded-pill" style="width:100%; background:#4A4D77; border-color:#617A9A; margin-right: 5px;margin-top:15px;" onclick="creerTableau()">
        <i class="fas fa-plus-circle"></i>
        Nouveau Personna 
    </button>
    <script>
        var startingIndex = {{$i}}; // Assuming $i is a variable from your server-side code



        function creerTableau() {
            // Create a table element
            var tableau = document.createElement("table");
            var tbody = document.createElement("tbody");



            // Labels for the table rows
            var labels = ["Nom", "Sexe", "Age", "Situation géographique", "Préparation", "Centres d'intérêt", "Problèmes", "Objectifs", "Comportement en ligne"];
            var label = ["nom", "sexe", "age", "situation", "préparation", "centre", "probléme", "objectifs", "comportement"];

            var heights = ["70px", "70px", "70px", "70px", "70px", "140px", "140px", "140px", "140px"];  // Height values for the cells

            // Iterate over labels and create table rows
            for (var i = 0; i < labels.length; i++) {
                var row = document.createElement("tr");

                var cellLabel = document.createElement("td");
                cellLabel.style.height = heights[i];
                cellLabel.style.width = "30%";
                cellLabel.innerHTML = '<div>' + labels[i] + '</div>';
                row.appendChild(cellLabel);

                var cellTextarea = document.createElement("td");
                var textarea = document.createElement("textarea");
                textarea.name = label[i] + '[' + (startingIndex + i + 1) + ']';
                textarea.className = "action-textarea w-100 h-100";

                textarea.textContent = "";
                cellTextarea.appendChild(textarea);
                row.appendChild(cellTextarea);

                tbody.appendChild(row);
            }

          // Obtenir la référence de la balise div pour contenir le tableau          
          tableau.appendChild(tbody);

// Obtenir la référence de la balise div pour contenir le tableau
var divTableauContainer = document.getElementById("action-form");

// Ajouter le nouveau tableau à la fin du contenu existant
divTableauContainer.appendChild(tableau);
        }
    </script>
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
              <li><a class="dropdown-item" href="/report/webtv?id={{ $action->id }}">Tout le projet</a></li>
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
