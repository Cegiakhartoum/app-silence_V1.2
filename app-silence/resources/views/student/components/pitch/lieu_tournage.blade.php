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
            return "Correspond au lieu du film et au <br/>
            nom de son propriétaire.";

        case 3:
            return "Correspond à la durée du plan.";

        case 4:
            return "Correspond au lieu du film et au <br/>
                    nom de son propriétaire.";

        case 5:
            return "Correspond à l’action des <br/>
            personnages dans le plan. <br/>
            Il s’agit de tout ce qu’il va se passer <br/>
            à l’image, c’est ce que le spectateur <br/>
            va voir à l’écran.
            ";

        case 6:
            return "Correspond à l’échelle de plan <br/>
            et l’angle choisi pour le plan.
            ";

        case 7:
            return "Correspond au mouvement de <br/>
            la caméra dans le plan.";

        case 8:
            return "Correspond au son <br/>
                    du plan.";

        case 9:
            return "Les raccords sont les éléments relatifs <br/>
                    à l’image et au son permettant de <br/>
                    relier deux plans ou deux séquences <br/>
                    entre eux.";
    }
}

?>
<div class="d-flex flex-column h-100" style="width:100%;text-align:center;float:right;">
    <h4 class="text-center font-weight-bolder action-title">
  
    LIEUX DE TOURNAGE 
    </h4>
    <br />
<form id="action-form" class="flex-grow-1" style="overflow-y: scroll;" method="POST" action="/save-actionDecoupage">
    @csrf
    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
    <input type="hidden" name="redirect_url"
        value="/student/action?p={{ $action->projet_action_id }}&c={{ $nextChapterKey }}" />
    
<div style=" letter-spacing:3px; font-weight: 300;">
        <table>
            <tr>
                <td style="width:10%;" >
                    SÉQ N° {!! buildOrangePopover(1) !!}
                </td>
                <td style="width:25%;">
                    DÉCOR (LIEU DU SCENARIO) {!! buildOrangePopover(2) !!}
                </td>
            
                <td >
                    LIEU 
                </td>
                <td style="width:15%;">
                    JOUR DE TOURNAGE 
                </td>
            </tr>
           
	@php
          $hop="";
          @endphp
            @foreach ($decoupages_l as $decoupage)
                <tr>
                    <td>
                 @foreach ($decoupages as $decoupag)
                
                    @if($decoupag->lieu == $decoupage->lieu && $hop != $decoupag->sequence_id )
                 		
                                {{ $decoupag->sequence_id}} 
                      @php
          $hop=$decoupag->sequence_id;
          @endphp
                     
                      
                    @endif
                    @endforeach

                    </td>
                    @php
                    $t=0;

                    @endphp
                    <td>{{ $decoupage->lieu}}

                    <input type="hidden" name="lieu_add[]" value="{{$decoupage->lieu}}">
                    </td>
                    @foreach ($decoupages as $decoupag)
                  
                    @if($t < 1 )
                    @if($decoupag->lieu == $decoupage->lieu)
                
                    <td> 
                        <input type="hidden" name="id_add[]" value="">
                         <input type="text" class="form-control" style=" width:100%;"
                        placeholder="lieu" name="decors_add[]" value="{{$decoupag->decors}}"></td>
                    <td>
                    <input type="date" class="form-control" style=" width:100%;"
                            placeholder="jours" name="jours_add[]" value="{{$decoupag->jours}}">
                    </td>
                    
                
                     @php
                    $t++;
                    @endphp
                    @endif
                    @endif
                    @endforeach
                    

                </tr>
            @endforeach
            
        </table>
        <br>
        <br>
    </form>
</div>
</div>




