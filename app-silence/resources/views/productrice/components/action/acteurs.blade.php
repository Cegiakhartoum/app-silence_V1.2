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
            return "Un plan est un bout de film. <br/>
                    C’est ce qu’on voit à l’écran. <br/>
                    Dès qu’il y a une coupure au sein même d’une séquence, <br/>
                    il y a un changement de plan. Ce sont ces plans <br/>
                    assemblés entre eux qui constituent une séquence. <br/>
                    Chaque plan se caractérise par son cadrage et sa durée. <br/>
                    Le cadrage peut varier et son utilisation a une <br/>
                    signification.";

        case 2:
            return "Une séquence ou une scène, correspond à un lieu ou <br/>
                    une temporalité, elle représente une unité de temps, <br/>
                    de lieu et d’action. <br/>
                    Dès qu’il y a un changement de lieu ou de <br/>
                    temporalité, le numéro de séquence change.";

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
  
    ACTEURS/ACTRICES </br>
    </h4>

<form id="action-form" class="flex-grow-1" style="overflow-y: scroll;" method="POST" action="/save-actionDecoupage">
    @csrf
    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
    <input type="hidden" name="redirect_url"
        value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
    <input type="hidden" name="decoupage" value="" />

        <table>
                <tr>
                <td>JOUR N° : </td>
                <td>SEQUENCE : </td>
                <td>JOUR/NUIT : </td>
                <td>EXT/INT : Interieur</td>
                <td>DÉCOR : </td>
                </tr>
                <tr>
                    <td colspan="5">DESCRIPTION DE L’ACTION:</td>
                </tr>
                <tr>
   
           
            <td colspan="3">
                PERSONNAGES:
            
                </td>
          

            <td colspan="2">FIGURATION: 

           

            </td>
    </tr>
    
    <tr>
            <td colspan="3">COSTUMES:
                
                 </td>
            <td colspan="2">MAQUILLAGE/COIFFURE: </td>
    </tr>
    <tr>
            <td colspan="3">DÉCORATION: </td>
            <td colspan="2">ACCESSOIRES: </td>
    </tr>
   
    <tr>
            <td colspan="3">IMAGE: </td>
            <td colspan="2">SON: </td>
    </tr>
    <tr>
            <td colspan="3">MACHINERIE: </td>
            <td colspan="2">ÉLECTRICITÉ: </td>
    </tr>
    <tr>
            <td colspan="3">RÉGIE: </td>
  
            <td colspan="2">VÉHICULES: </td>
    </tr>
  
    <tr>
            <td colspan="5">DIVERS: </td>
           
    </tr>
    <tr>
            <td colspan="5">NOTES: </td>
           
    </tr>

  
  
</table>
</form>



