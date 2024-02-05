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


<form id="action-form" class="flex-grow-1" metdod="POST" action="/save-actionDecoupage">
    @csrf
    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
    <input type="hidden" name="redirect_url"
        value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
    <input type="hidden" name="decoupage" value="" />



<div class="d-flex flex-column h-100" style="width:100%;text-align:center;float:right;">
    <h4 class="text-center font-weight-bolder action-title">
  
    FEUILLE DE SERVICE 
    </h4>
    <br />
    
<div style=" letter-spacing:3px; font-weight: 300;">
        <table style="width:100%;">
        <tr>
            <td colspan="3">PRODUCTION <br><input type="text" name="" value="" /></td>
            <td colspan="3"><input type="text" name="" value="" /></td>
            <td colspan="3">PRODUCTION  <br><input type="text" name="" value="CEGIA CREATION" /></td>
        </tr>
        <tr style="text-align:center; height:70px;">
            <td colspan="9">FEUILLE DE SERVICE DU </td>
        </tr>
        <tr>
        <form action="" method="POST">
                            @csrf
            <td colspan="9">P.A.T (Prêt à tourner) : <input type="time" id="pat"  name="pat" 
                    value="">
                  
             
              <button >Submit</button>
                    
           
            </td>
        </form>
        </tr>
        <tr>
            <td colspan="9">PERSONNES À CONTACTER : <input type="text" name="" value="" /></td>
        </tr>
        <tr style="text-align:center; height:170px;">
            <td colspan="9">METEO : SOLEIL
<br>LIEU DE TOURNAGE : BOISSY SAINT LEGER
 <br> ADRESSE : 5 PLACE DE LA PINEDE
 <br>
 <br>
        <form action="" method="post" enctype="multipart/form-data">
          
           
            
                <input type="file" name="file" class="input-file" id="chooseFile">

     
            <button type="submit" name="submit" class="input-button">
                Upload Files
            </button>
        </form>
        <br>
        <br>
 
       

    </td>
        </tr>
        <tr style="text-align:center; height:100px;">
            <td colspan="9"></td>
        </tr>
        <tr style="text-align:center; height:70px;">
            <td colspan="9">CONVOCATION ÉQUIPE DE acteurNIQUE ET ARTISTIQUE</td>
        </tr>
        <tr>
            <td colspan="1">RÉAL</td>
            <td colspan="1">CHEF OP</td>
            <td colspan="1">IMAGE</td>
            <td colspan="1">SON</td>
            <td colspan="1">ELECTO</td>
            <td colspan="1">MACHINO</td>
            <td colspan="1">HMC</td>
            <td colspan="1">DÉCO</td>
            <td colspan="1">RÉGIE</td>
        </tr>
        <tr>
            <td colspan="1"><input type="text" name="" value="" /></td>
            <td colspan="1"><input type="text" name="" value="" /></td>
            <td colspan="1"><input type="text" name="" value="" /></td>
            <td colspan="1"><input type="text" name="" value="" /></td>
            <td colspan="1"><input type="text" name="" value="" /></td>
            <td colspan="1"><input type="text" name="" value="" /></td>
            <td colspan="1"><input type="text" name="" value="" /></td>
            <td colspan="1"><input type="text" name="" value="" /></td>
            <td colspan="1"><input type="text" name="" value="" /></td>
        </tr>
        <tr>
            <td colspan="2">COMÉDIENS</td>
            <td colspan="2">RÔLES</td>
            <td colspan="1">SEQ</td>
            <td colspan="2">ARRIVÉ</td>
            <td colspan="2">P.A.T</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2"></td>
             
            <td colspan="1">
                
            </td>
            
            <td colspan="2"><input type="text" name="" value="" /></td>
            <td colspan="2"><input type="text" name="" value="" /></td>
        </tr>

        </table>
        <br>
        <br>
</form>

    </div>
   
</div>



