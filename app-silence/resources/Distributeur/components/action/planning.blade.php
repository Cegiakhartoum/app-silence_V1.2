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
            return "Correspond au numéro <br/> de la séquence à tourner.";

        case 2:
            return "Correspond au plan de <br/> la séquence à tourner.";

        case 3:
            return "Correspond au lieu de <br/> tournage.";

        case 4:
            return "Correspond au lieu dans le film.";

        case 5:
            return "Correspond à l'action des personnages dans le plan.<br/>
Il s'agit de tout ce qu'il va se passer à l'image, <br/>
c'est ce que le spectateur va voir à l'écran.
            ";

        case 6:
            return "Correspond aux personnages <br/> présents dans ta séquence.
            ";

        case 7:
            return "Correspond au temps de <br/> tournage prévue pour filmer le plan.";

        case 8:
            return "Correspond à l'heure où <br/> commence le tournage du plan.";

   
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
  
    PLANNING DE TOURNAGE 
    </h4>

    <br />

<div style=" letter-spacing:3px; font-weight: 300;">
  <form method="POST" action="/UpdtadePAT">
    @csrf
    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
    <input type="hidden" name="redirect_url"
        value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
    <input type="hidden" name="decoupage" value="" />
  <div style="text-align:left; ">
    P.A.T : 
    <input type="time" id="pat" name="pat" value="{{$action->pat}}">

    <button type="submit" class="btn btn-outline-primary">
                      <span>Enregistrer</span> 
     
      </div>  
      
  </form>

  <form id="action-form" class="flex-grow-1" style="overflow-y: scroll;" method="POST" action="/save-actionDecoupage">
    @csrf
    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
    <input type="hidden" name="redirect_url"
        value="/student/action?p={{ $action->projet_action_id }}&c={{ $nextChapterKey }}" />
        
        <input type="hidden" name="decoupage" value="" />

<br>
@foreach ($jours as $jour)

        <table>
            <tr>
                <td colspan="8"> {{$jour->jours}}</td>
            <tr>
            <tr>
                <td style="width:5%;" >
                    SÉQ N° {!! buildOrangePopover(1) !!}
                </td>
                <td style="width:5%;" >
                    Plan  {!! buildOrangePopover(2) !!}
                </td>
                <td style="width:15%;">
                    DÉCORS (LIEU DU SCENARIO) {!! buildOrangePopover(4) !!}
                </td>
                <td style="width:15%;" >
                    LIEU {!! buildOrangePopover(3) !!}
                </td>
               
            
                <td >
                DESCRIPTION DE L’ACTION 
                </td>
                <td style="width:15%;">
                PERSONNAGES{!! buildOrangePopover(6) !!}
                </td>
                <td style="width:10%;">
                HORAIRE DE TOURNAGE {!! buildOrangePopover(7) !!}
                </td>
                <td style="width:10%;">
                TEMPS DE TOURNAGE 
                </td>
            </tr>


            @php
            $h1 = strtotime($action->pat);
            $test = "O";
            $durée = "00:00:00";
            $trajet ="00:10:00";
            $limit  = 0;
            @endphp

        @foreach ($decoupages_p as $decoupage)

            @if($decoupage->jours == $jour->jours)

       
   
          
                <tr>
                    <td>{{$decoupage->sequence_id}}</td>
                    <td>{{$decoupage->plan}}</td>
                    <td>{{$decoupage->lieu}}</td>
                    <td>{{$decoupage->decors}}</td>
                        <td>
                    @php
                    $descriptions = json_decode($decoupage->description);
                    @endphp
                    @if(!empty($descriptions[0]))
                    {{$descriptions[0]}}
                    @endif
      
                    </td>
                    <td>
                    @php
                    $personnages = json_decode($decoupage->sur);
                    @endphp
                      @if(!empty($personnages))
                    @foreach ($personnages as $personnage)
                       
                    {{$personnage}}
                    <br>
                    @endforeach
                        @endif
                    </td>
                    <td>
                    @if($test == $decoupage->lieu && strtotime($h1) >= strtotime($action->pat) )
                    {{ ucfirst($h1 = gmdate("H:i:s", strtotime($h1) + strtotime($durée))) }}
                    @elseif(strtotime($h1) < strtotime($action->pat) ) 
                    {{ ucfirst($h1 = gmdate("H:i:s", strtotime($action->pat)  )) }}
                    @else
                    {{ ucfirst($h1 = gmdate("H:i:s", strtotime($h1) + strtotime($durée) + strtotime($trajet) )) }}
                    @endif
                    </td>
                    <td>
                    <input type="hidden" name="dec_update[]" value="{{$decoupage->id}}" />
                    <input type="datetime" name="durre_update[]" value="{{$decoupage->durée}}" />
                    @php

            $test = $decoupage->lieu;
            $durée = $decoupage->durée;
            $trajet = $decoupage->trajet;
 
            @endphp
                    </td>
                </tr>
                @endif
                @php 
                    $fin = gmdate("H:i:s", strtotime("01:00:00") + strtotime($h1));
                
                    @endphp
                @if($h1 > $action->déjeuner &&  $h1 < $fin && $limit == 0)
                    <tr>
                        <td colspan="8">
                        <br>
                        Pause déjeuner de {{$h1}} à {{$fin}}
                        <br>
                        <br>

                        </td>
                    </tr>
                    @php
                    $h1 = $fin;
                    $limit = 1;
                    @endphp
                @endif

            @endforeach
         
        </table>
        <br>
        <br>
      
@endforeach
       
 </form>

    </div>
    <!-- Modal ajouter decoupage  -->
<div id="open-modal" class="modal-window">
     <div>

            <a href="#" title="Close" class="modal-close">X</a>
                    <br>
            <h3 style="Text-align:center;">Ordre de tournage</h3>   
                    <hr>

            <form method="POST" action="/UpdtadeOrdre">
    				@csrf
                    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                    <input type="hidden" name="redirect_url"
                        value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
                        
                        @php $max = count($decoupages_l) @endphp
                           @foreach($decoupages_l as $decoupage)
                           <input type="hidden" name="lieu[]" value="{{$decoupage->lieu}}" />
                           <input type="number" id="" name="ordre[]" min="1" max="{{$max}}"/> {{$decoupage->lieu}}  
                            <br>
                        @endforeach
                        
                        <div style="float:right;"> 
                                <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
             </form>
       
     </div>
</div>

<!-- End The Modal -->
  <!-- Modal ajouter decoupage  -->
  <div id="open-modal-trajet" class="modal-window">
     <div>

            <a href="#" title="Close" class="modal-close">X</a>
                    <br>
            <h3 style="Text-align:center;">Temp de trajet</h3>   
                    <hr>

            <form method="POST" action="/UpdtadeTrajet">
    				@csrf
                    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                    <input type="hidden" name="redirect_url"
                        value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
                        
                    
                           @foreach($decoupages_l as $decoupage)
                           @php $unq=0;@endphp
                           <input type="hidden" name="lieu[]" value="{{$decoupage->lieu}}" />
                           @foreach($decoupages as $decoupa)
                            @if($decoupa->lieu == $decoupage->lieu && $unq == 0)
                           <input type="time" id=""  name="trajet[]" value="{{$decoupa->trajet}}"/> 
                           @php $unq=1;@endphp
                            @endif
                           @endforeach
                           {{$decoupage->lieu}} 
                            <br>
                             @endforeach
                        
                        <div style="float:right;"> 
                                <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
             </form>
       
     </div>
</div>

<!-- End The Modal -->
  <!-- Modal ajouter decoupage  -->
  <div id="open-modal-déjeuner" class="modal-window">
     <div>

            <a href="#" title="Close" class="modal-close">X</a>
                    <br>
            <h3 style="Text-align:center;">Pause déjeuner</h3>   
                    <hr>

            <form method="POST" action="/UpdtadeDéjeuner">
    				@csrf
                    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                    <input type="hidden" name="redirect_url"
                        value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />

                           Pause déjeuner <br>

                           <input type="time" id="" name="déjeuner" value="{{$action->déjeuner}}">
                            <br>
                        
                        <div style="float:right;"> 
                                <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
             </form>
       
     </div>
</div>

<!-- End The Modal -->
   
</div>

