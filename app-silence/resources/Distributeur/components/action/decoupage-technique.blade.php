<?php

function buildSequencePersonnagesOptions($personnages, $selectedPersonnage)
{
    $result = '';
    foreach ($personnages as $personnage) {
        $checked = trim($personnage) === trim($selectedPersonnage) ? 'selected="selected"' : '';
        $result .= '<option value="' . trim($personnage) . '" ' . $checked . ' >' . trim($personnage) . '</option>';
    }
    return $result;
}

function getSequencePersonnages($sequence)
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



function buildOrangePopover($index){
    return '<i tabindex="' .
        $index .
        '" class="small-help-button fas fa-question-circle" data-bs-toggle="popover" data-bs-placement="top"
                        data-bs-content=\'' .
        getOrangePopoverContent($index) .
        '\' data-bs-template=\'' .
        getOrangePopoverTemplate() .
        '\' data-bs-trigger="focus" data-bs-title=" "></i>';
}

function getOrangePopoverTemplate(){
    return '<div class="popover popover-orange" role="tooltip"><div class="popover-body"></div></div>';
}

function getOrangePopoverContent($index)
{
    switch ($index) {
        case 1:
            return "Une séquence ou une scène, correspond à un lieu ou <br/>
                    une temporalité, elle représente une unité de temps, <br/>
                    de lieu et d’action. <br/>
                    Dès qu’il y a un changement de lieu ou de <br/>
                    temporalité, le numéro de séquence change.";

        case 2:
            return "Un plan est un bout de film. <br/>
                    C’est ce qu’on voit à l’écran. <br/>
                    Dès qu’il y a une coupure au sein même d’une séquence, <br/>
                    il y a un changement de plan. Ce sont ces plans <br/>
                    assemblés entre eux qui constituent une séquence. <br/>
                    Chaque plan se caractérise par son cadrage et sa durée. <br/>
                    Le cadrage peut varier et son utilisation a une <br/>
                    signification.";

        case 3:
            return "Correspond au lieu du film et au <br/>
                    nom de son propriétaire.";

        case 4:
            return "Correspond à l’action des <br/>
            personnages dans le plan. <br/>
            Il s’agit de tout ce qu’il va se passer <br/>
            à l’image, c’est ce que le spectateur <br/>
            va voir à l’écran.";

        case 5:
            return "Correspond à l’échelle de plan <br/>
            et l’angle choisi pour le plan.
            ";

        case 6:
             return "Correspond à l’échelle de plan <br/>
            et l’angle choisi pour le plan.
            ";
        
        case 7:
             return "Correspond à l’échelle de plan <br/>
            et l’angle choisi pour le plan.
            ";

        case 8:
            return "Correspond au mouvement de <br/>
            la caméra dans le plan.";

        case 9:
            return "Correspond au son <br/>
                    du plan.";

        case 10:
            return "Les raccords sont les éléments relatifs <br/>
                    à l’image et au son permettant de <br/>
                    relier deux plans ou deux séquences <br/>
                    entre eux.";
    }
}

?>

<style>

 /* Styling modal */
 .modal-window {
  position: fixed;
  font-family: 'Nunito';
  background-color: rgba(255, 255, 255, 0.4);
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 999;
  visibility: hidden;
  opacity: 0;
  pointer-events: none;
  transition: all 0.3s;
}
.modal-window:target {
  visibility: visible;
  opacity: 1;
  pointer-events: auto;
}
.modal-window > div {
  width:50%;
  border:#505050 1px solid;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 2em;
  text-align: left;
  background: white;
}
.modal-window header {
  font-weight: bold;
}
.modal-window h1 {
  font-size: 150%;
  margin: 0 0 15px;
}
.modal-close {
  color: #de813b;
  line-height: 50px;
  font-size: 16px;
  position: absolute;
  right: 0;
  text-align: center;
  top: 0;
  width: 70px;
  text-decoration: none;
}

.modal-close:hover {
  color: black;
}
/* Demo Styles */


.modal-window > div {
  border-radius: 1rem;
}
.modal-window div:not(:last-of-type) {
  margin-bottom: 15px;
}
.logo {
  max-width: 150px;
  display: block;
}
small {
  color: lightgray;
}
 /* Styling modal */
    th, td{
        border: 1px solid;
        padding: 5px;
    }

    th{
        font-weight: 400;
        font-size: 12px;
    }

    .small-help-button {
        color: #d5972b;
        font-size: 1.2rem;
        cursor: pointer;
        position: relative;
        bottom: 6px;
        right: 4px;
        margin-right: -8px;

    }
   

</style>
<div class="d-flex flex-column h-100" style="width:100%;text-align:center;float:right;">
    <h4 class="text-center font-weight-bolder action-title">
  
    Decoupage technique 
    </h4>
    <br />

<form id="action-form" class="flex-grow-1" style="overflow-y: scroll;" method="POST" action="/save-actionDecoupage">
    @csrf
    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
    <input type="hidden" name="redirect_url"
        value="/student/action?p={{ $action->projet_action_id }}&c={{ $nextChapterKey }}" />
        <input type="hidden" name="decoupage" value="" />
<div style=" letter-spacing:3px; font-weight: 300;">

        <table>
            <tr>

                <th style="width:3%;">
                    SÉQ N° {!! buildOrangePopover(1) !!}
                </th>
                <th style="width:3%;">
                    PLAN N° {!! buildOrangePopover(2) !!}
                </th>
            
                <th style="width:8%;">
                    LIEU {!! buildOrangePopover(3) !!}
                </th>
                <th style="width:15%;" >
                    DESCRIPTION DE L'ACTION {!! buildOrangePopover(4) !!}
                </th>
                <th style="width:8%;">
                    ÉCHELLE  {!! buildOrangePopover(5) !!}
                </th>
                <th style="width:8%;">
                    ANGLE {!! buildOrangePopover(6) !!}
                </th>
                <th style="width:15%;">
                    SUR {!! buildOrangePopover(7) !!}
                </th>
                <th style="width:8%;">
                    MOUVEMENT CAMÉRA {!! buildOrangePopover(8) !!}
                </th>
                <th style="width:8%;">
                    AUDIO {!! buildOrangePopover(9) !!}
                </th>
                <th style="width:8%;">
                    RACCORD {!! buildOrangePopover(10) !!}
                </th>
            </tr>
@if(empty($decoupages))  
@else


    @foreach ($decoupages as $decoupage)
            <tr>
           
                <td> 
<form id="action-form" class="flex-grow-1" method="POST" action="/DeleteDec">
    @csrf
    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
    <input type="hidden" name="redirect_url"
        value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
    <input type="hidden" name="decoupage" value="" />

</script>
  <input type="hidden" name="id_delete_dec" value="{{ $decoupage->id }}" />
                  
                  <button type="submit" class="btn btn-danger delete-sequence-btn">
                                    <i class="fas fa-trash-alt" style="color: white;"></i>
                                </button>
   </form>
                  
                  <input type="hidden" name="id_adi[]" value="{{ $decoupage->id }}" />{{ $decoupage->sequence_id }}</td>
                <td>
                  {{ $decoupage->plan }} </td>
                <td>{{ $decoupage->lieu}}</td>
                <td> 
                         @php
                            $descriptions = json_decode($decoupage->description);
                            $scenario = json_decode($action->scenario);
                            $index = 0;
                        @endphp
                                     <div class="add-existing-personnage-sequence">
                        <form method="POST" action="/AddDescription">
                            @csrf
                                <input type="hidden" name="redirect_url"
                                    value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
                                <input type="hidden" name="decoupage" value="" />

                                <input type="hidden" name="redirect_url"
                                    value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
                                            <input type="hidden" name="id_adid" value="{{$decoupage->id}}" />
                                <select class="personnage-select form-control" name="add_descript" style="width:60%;"> 
                                @foreach ($scenario->sequences as $scenario)
                                        @php $index++; @endphp
                                        @if($index == $decoupage->sequence_id)
                                            @foreach ($scenario->dialogues_descriptions as $keyIndex => $dialogue_description)
                                            @if ( ($dialogue_description->type) == 'description')
                                                            <option value=" {{$dialogue_description->value->description }}"> {{ $dialogue_description->value->description }}</option>
                                                        @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>

                                <button type="submit" class="btn btn-primary add-personnage-btn">
                                    <i class="fas fa-plus-circle" style="color: white;"></i>
                                </button>
                        </form>
                    </div>
                
                    <div class="liste-personnages">
                    @php $roue=0; @endphp
                    @if(!empty($descriptions))  
                                @foreach ($descriptions as $description)
                                    @php $roue++; @endphp
                                    <div class="liste-personnage-item">
                                        <button type="button" class="btn btn-outline-primary">
                                            <a href="#delete_description{{$decoupage->id}}_{{$roue}}" style="color:#0d6efd;"> <span> {{$description}}</span> </a>
                                        </button>
                                    </div>

                            <!-- Modal confirmer suppresion de description de sequence -->
                            <div id="delete_description{{$decoupage->id}}_{{$roue}}" class="modal-window">
                                <div>

                                    <a href="#" title="Close" class="modal-close">X</a>
                                            <br>
                                    <h3 style="Text-align:center;">Suprimer une personnage du decoupage</h3>   
                                            <hr>

                                        
                                            <p>Êtes vous sûr de vouloir supprimer cette description du decoupage ? </p>
                                    
                                        <div class="liste-personnage-item">
                                                            <button type="button" class="btn btn-outline-primary">
                                                                <span>  {{$description}} </span>
                                                            </button>
                                        </div>
                                        <br>
                                        <br>
                                        <form id="action-form" class="flex-grow-1" method="POST" action="/DeleteDescription">
                                            @csrf
                                                <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                                                <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                                                <input type="hidden" name="redirect_url"
                                                    value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
                                                <input type="hidden" name="decoupage" value="" />
                                                <input type="hidden" name="delete_descript" value="{{$description}}" />
                                                            <input type="hidden" name="id_delete" value="{{$decoupage->id}}" />

                                            <div style="float:right;"> 
                                                            <button type="submit" class="btn btn-primary">Suprimer</button>
                                            </div>
                                        </form>
                                </div>
                            </div>
                            <!-- Modal confirmer suppresion de description de sequence -->
                @endforeach
                @endif
                            
                            </div>
    
                </td>
                <td>
                    <select name="echelle_adi[]"  class="personnage-select form-control" style="width:100%;"> 
                    @if(empty($decoupage->echelle))
                    <option hidden>Select</option>
                    @else
                    <option value="{{$decoupage->echelle}}">{{ $decoupage->echelle }}</option>
                    @endif   
                    <option value="Très gros plan">Très gros plan</option>
                    <option value="Gros plan">Gros plan</option>
                    <option value="Rapproché épaule">Rapproché épaule</option>
                    <option value="Rapproché poitrine">Rapproché poitrine</option>
                    <option value="Rapproché taille">Rapproché taille</option>
                    <option value="Américain">Américain</option>
                    <option value="Italien">Italien</option>
                    <option value="Pied">Pied </option>
                    <option value="Large">Large</option>
                    <option value="Ensemble">Ensemble</option>
                    <option value="Insert">Insert</option>
                    <option value="Autre">Autre</option>
                    </select>
                </td>
                <td>
                    <select name="angle_adid[]" class="personnage-select form-control" style="width:100%;"> 
                    @if(empty($decoupage->angle))
                    <option hidden>Select</option>
                    @else
                    <option value="{{$decoupage->angle}}">{{$decoupage->angle}}</option>
                    @endif 
                      <option value="face">Face</option>
                                    <option value="3/4 face">3/4 face</option>
                                    <option value="plongée">Plongée</option>
                                    <option value="contre plongée">Contre plongée</option>
                                    <option value="profil">Profil</option>
                                    <option value="dos">Dos</option>
                                    <option value="Autre">Autre</option>
                    </select>
                </td>
                <td> 
                        @php
                        $personnages = json_decode($decoupage->sur);
                        $scenario = json_decode($action->scenario);
                                $index = 0;
                        @endphp
                    <div class="add-existing-personnage-sequence">
                    <form method="POST" action="/AddPersonnage">
                            @csrf
                                <input type="hidden" name="redirect_url"
                                    value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
                                <input type="hidden" name="decoupage" value="" />

                                <input type="hidden" name="redirect_url"
                                    value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
                                            <input type="hidden" name="id_add_p" value="{{$decoupage->id}}" />
                        <input type="text" class="form-control add-personnage-input" placeholder="Ajouter un objet" name="add_personn" style="width:70%;">
                        <button type="submit" class="btn btn-primary add-personnage-btn">
                                    <i class="fas fa-plus-circle" style="color: white;"></i>
                                </button>
        </form>
       <br>
                        <form method="POST" action="/AddPersonnage">
                            @csrf
                                <input type="hidden" name="redirect_url"
                                    value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
                                <input type="hidden" name="decoupage" value="" />

                                <input type="hidden" name="redirect_url"
                                    value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
                                            <input type="hidden" name="id_add_p" value="{{$decoupage->id}}" />
                                <select class="personnage-select form-control" name="add_personn" style="width:70%;"> 
                                @foreach ($scenario->sequences as $scenario)
                                @php $index++; @endphp
                                    @if($index == $decoupage->sequence_id)
                                        @foreach ($scenario->personnages as $personnage)  
                                                        <option value=" {{$personnage}}"> {{$personnage}}</option>
                                                
                                        @endforeach
                                    @endif
                                @endforeach
                                </select>

                                <button type="submit" class="btn btn-primary add-personnage-btn">
                                    <i class="fas fa-plus-circle" style="color: white;"></i>
                                </button>
                        </form>
                    </div>
                
                    <div class="liste-personnages">
                        @php $roue=0; @endphp
                        @if(!empty($personnages))  
                        @foreach ($personnages as $personnage)
                            @php $roue++; @endphp
                                    <div class="liste-personnage-item">
                                        <button type="button" class="btn btn-outline-primary">
                                            <a href="#delete_personnage{{$decoupage->id}}_{{$roue}}" style="color:#0d6efd;"> <span> {{$personnage}}</span> </a>
                                        </button>
                                    </div>

                            <!-- Modal confirmer suppresion de description de sequence -->
                            <div id="delete_personnage{{$decoupage->id}}_{{$roue}}" class="modal-window">
                                <div>

                                    <a href="#" title="Close" class="modal-close">X</a>
                                            <br>
                                    <h3 style="Text-align:center;">Suprimer une personnage du decoupage</h3>   
                                            <hr>

                                        
                                            <p>Êtes vous sûr de vouloir supprimer ce personnage du decoupage ? </p>
                                    
                                        <div class="liste-personnage-item">
                                                            <button type="button" class="btn btn-outline-primary">
                                                                <span>  {{$personnage}} </span>
                                                            </button>
                                        </div>
                                        <br>
                                        <br>
                                        <form id="action-form" class="flex-grow-1" method="POST" action="/DeletePersonnage">
                                            @csrf
                                                <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                                                <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                                                <input type="hidden" name="redirect_url"
                                                    value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
                                                <input type="hidden" name="decoupage" value="" />

                                            <input type="hidden" name="delete_perso" value="{{$personnage}}" />
                                            <input type="hidden" name="idp_delete" value="{{$decoupage->id}}" />

                                            <div style="float:right;"> 
                                                            <button type="submit" class="btn btn-primary">Suprimer</button>
                                            </div>
                                        </form>
                                </div>
                            </div>
                            <!-- Modal confirmer suppresion de description de sequence -->
                        @endforeach
                        @endif
                            
                            </div>
    
                </td>
                <td>
                <select name="mouvement_adid[]"  class="personnage-select form-control" style="width:100%;"> 
                @if(empty($decoupage->mouvement))
                    <option hidden>Select</option>
                    @else
                    <option value="{{ $decoupage->mouvement }}">{{ $decoupage->mouvement }}</option>
                    @endif 
                   <option value="fixe">Fixe</option>
                        <option value="panoramique horizontal">Panoramique horizontal</option>
                        <option value="panoramique vertical">Panoramique vertical</option>
                        <option value="travelling avant">Travelling avant</option>
                        <option value="travelling arriere">Travelling arriere</option>
                        <option value="Autre">Autre</option>
                </select>
                </td>
                
                <td>
                <select name="audio_adi[]" class="personnage-select form-control" style="width:100%;"> 
                @if(empty($decoupage->audio))
                    <option hidden>Select</option>
                    @else
                    <option value="{{ $decoupage->audio }}">{{ $decoupage->audio }}</option>
                    @endif 
                        <option value="dialogue">Dialogue</option>
                        <option value="Musique">Musique</option>
                        <option value="Autre">Autre</option>
                </select>
                </td>
                <td>
                <select name="raccord_adi[]"  class="personnage-select form-control" style="width:100%;"> 
                @if(empty($decoupage->audio))
                    <option hidden>Select</option>
                    @else
                    <option value="{{ $decoupage->raccord }}">{{ $decoupage->raccord }}</option>
                    @endif 
                        <option value="regard">Regard</option>
                        <option value="axe">Axe</option>
                        <option value="jeu">Jeu</option>
                        <option value="mouvement">Mouvement</option>
                        <option value="Autre">Autre</option>
                </select>
                </td>
            </tr>
            @endforeach
@endif
        </table>
        <br>
        <br>
</form>

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal" class="modal-window">
     <div>

            <a href="#" title="Close" class="modal-close">X</a>
                    <br>
            <h3 style="Text-align:center;">Ajouter une ligne de decoupage</h3>   
                    <hr>

            <form id="action-form" class="flex-grow-1" method="POST" action="/AddDecoupage">
                @csrf
                    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                    <input type="hidden" name="redirect_url"
                        value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
                    <input type="hidden" name="decoupage" value="" />
                            <legende> Sequence :</legende>
                            <select name="sequence_id" id="sequence_id" class="personnage-select form-control" style="width:100%;"> 
                            <option hidden>selectionne une sequence</option>
                                @foreach ($decoupages_d as $decoupage)
                                <option value="{{$decoupage->sequence_id}}">{{$decoupage->sequence_id}}</option>
                                @endforeach
                            </select>
                            <legende> Plan :</legende>
                            <select name="plan" id="plan" class="personnage-select form-control" style="width:100%;"> 
                               
                            </select>
                            <br>
                            <br>
                            <div style="float:right;"> 
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </div>
            </form>
     </div>
</div>
<!-- End The Modal -->

    <!-- Modal confirmer suppresion de personnage de sequence -->
    <div id="delete-personnage-confirm-modal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Suppresion du personnage <span id="personnage-delete" style="font-weight: bold;"></span> de la séquence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes vous sûr de vouloir supprimer ce personnage du decoupage ? </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="deletePersonnageSequence()">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal confirmer suppresion de description de sequence -->
    <div id="delete-personnage-confirm-modal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Suppresion du personnage <span id="personnage-delete" style="font-weight: bold;"></span> de la séquence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes vous sûr de vouloir supprimer cette description du decoupage ? </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="deletePersonnageSequence()">Supprimer</button>
                </div>
            </div>
        </div>
    </div>


 

 
    </div>
   
</div>


<script src="/js/decoupage.js"></script>

<script>
                                $(document).ready(function () {
                                $('#sequence_id').on('change', function () {
                                let id = $(this).val();
                                $('#plan').empty();
                                $.ajax({
                                type: 'GET',
                                url: '/GetSubCatAgainstMainCatEdit/{{$action->projet_action_id}}/'+ id,
                                success: function (response) {
                                var response = JSON.parse(response);
                                console.log(response);   
                                $('#plan').empty();
                                response.forEach(element => {
                                    $('#plan').append(`<option value="${parseInt(element['plan'])+1}">${parseInt(element['plan']) + 1}</option>`);
                                    });
                                                    }
                                                });
                                                });
                                    });
                                 </script>

    
      
