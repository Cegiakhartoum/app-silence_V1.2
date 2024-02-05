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
            return "Correspond au numéro de la séquence.";

        case 2:
            return "Note INT si ta séquence<br/>
            se déroule à l'intérieur et EXT ,<br/>
            si ta séquence se déroule à l'extérieur.";

        case 3:
            return "Note si ta séquence se,<br/>
            déroule le jour ou la nuit";

        case 4:
            return "Correspond à l'action des personnages <br/>
            dans le plan.Il s'agit de tout ce qu'il va <br/>
            se passer à l'image, c'est ce que le  <br/>
            spectateur va voir à l'écran.
            ";

        case 5:
            return "Correspond aux informations  <br/>
            relatives aux costumes et aux accessoires.
            ";

        case 6:
            return "Correspond aux informations  <br/>
            relatives au maquillage et à la coiffure.";

      
    }
}

?>



<form id="action-form" class="flex-grow-1" method="POST" action="/save-actionDecoupage">
    @csrf
    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
    <input type="hidden" name="redirect_url"
        value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
    <input type="hidden" name="decoupage" value="" />


<div class="d-flex flex-column h-100" style="width:100%;text-align:center;float:right;">
    <h4 class="text-center font-weight-bolder action-title">
  
    DÉPOUILLEMENT PERSONNAGE 
    </h4>
    <br />
    
<div style=" letter-spacing:3px; font-weight: 300;">
@php
                    $scenario = json_decode($action->scenario);
             
                @endphp
    @if(empty( $scenario->personnages))  
@else
   @foreach ($scenario->personnages as $personnage)
                @php
                $index = 0;
                @endphp
        <table>
                <tr>
                    <td colspan="6">DÉPOUILLEMENT PERSONNAGE :  {{$personnage}}  
                    <input type="hidden" class="form-control" style=" width:100%;"
                            placeholder="note" name="personnage[]" value="{{$personnage}}">
                    </td>
                </tr>
                <tr>
            
                    <td>N° SEQ </td>
                    <td>INT/EXT </td>
                    <td>JOUR/NUIT </td>
                    <td>DESCRIPTION DE L’ACTION</td>
                    <td>NOTES COSTUME ET ACCESSOIRES </td>
                    <td>NOTES MAQUILLAGE/COIFFURE</td>
                </tr>

                @foreach($scenario->sequences as $sequence)
                @php 
                $index++;
             
                 @endphp
                    @foreach(getSequencePersonnages($sequence) as $perso)
                    @php   $perso=trim($perso);
                            $personnage=trim($personnage);
                            $liste_acteurs = json_decode($action->depouillements);
                     @endphp
                    @if($perso == $personnage)
                                <tr>
                                    <td>{{ $index }}</td>
                                    <td>{{ $sequence->location}}</td>
                                    <td>{{  $sequence->time}}</td>
                                    <td>
                                  
                                            @foreach ($sequence->dialogues_descriptions as $keyIndex => $dialogue_description)
                                            @if ( ($dialogue_description->type) == 'description' )
                                                            {{$dialogue_description->value->description }}
                                                        @endif
                                            @endforeach
                                   

                                    </td>
      @if(empty($liste_acteurs)) 
   
                                  <td>
                                    <input type="hidden" class="form-control" style=" width:100%;"
                            placeholder="note" name="sequence_id[]" value="">
                                        <input type="text" class="form-control" style=" width:100%;"
                            placeholder="note" name="note_acs[]" value=""></td>
                                    <td><input type="text" class="form-control" style=" width:100%;"
                            placeholder="note" name="note_maq[]" value=""></td>
                                </tr>

            @else
                @foreach($liste_acteurs as $depouille)
                    @php  
                    $perso=trim($depouille->personnage);
                    $personnage=trim($personnage);         
                    @endphp
                    @if($depouille->personnage == $personnage && $depouille->sequence_id == $index)
                    <td>

                                                <input type="text" class="form-control" style=" width:100%;"
                                    placeholder="note" name="note_acs[]" value="{{$depouille->note_acs}}"></td>
                                            <td><input type="text" class="form-control" style=" width:100%;"
                                    placeholder="note" name="note_maq[]" value="{{$depouille->note_maq}}"></td>
                                        </tr>
                    @endif
                @endforeach
            @endif
      @endif
 @endforeach
  @endforeach
       
        </table>

        <br>
        <br>
@endforeach
@endif
</form>
 </div>
   
</div>

