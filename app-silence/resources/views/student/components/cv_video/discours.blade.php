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
<style>
         table {
            width: 100%;
            height: 80%;
            font-family: 'Ubuntu', sans-serif;
            font-size: 12px;
            border-collapse: collapse;
        }

        table td {
            font-family: 'Ubuntu', sans-serif;
             height: 150px;
            font-size: 12px;
            border: 1px solid black;
            padding: 10px; /* Adjust the padding as needed */
        }
</style>

@php
                            $discours = json_decode($action->discours);
                        @endphp

<h4 class="text-center font-weight-bolder action-title"> J'ORGANISE MON DISCOURS</h4>

            <br>
            <form id="action-form" class="flex-grow-1" method="POST" action="/save-action">
    @csrf
    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
    <input type="hidden" name="redirect_url"
        value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
    <input type="hidden" name="scenario" value="" />
        
                <table>
                @if(!empty($discours))
                    <tr>
                        <td>
                            <div>Situation actuelle</div>
                          
                        </td>
                        <td>
                            <textarea name="situation" class="action-textarea w-100 h-100">{{$discours->situation}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Compétences et parcours scolaire</div>

                        </td>
                        <td>
                            <textarea name="compétences" class="action-textarea w-100 h-100">{{$discours->compétences}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Ce que tu apporterais dans l'entreprise</div>

                        </td>
                        <td>
                            <textarea name="apporterais" class="action-textarea w-100 h-100">{{$discours->apporterais}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Pourquoi tu veux rejoindre l'équipe</div>

                        </td>
                        <td>
                            <textarea name="pourquoi" class="action-textarea w-100 h-100">{{$discours->pourquoi}}</textarea>
                        </td>
                    </tr>

                </table>
                @else 
                  <tr>
                        <td>
                            <div>Situation actuelle</div>
                          
                        </td>
                        <td>
                            <textarea name="situation" class="action-textarea w-100 h-100"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Compétences et parcours scolaire</div>

                        </td>
                        <td>
                            <textarea name="compétences" class="action-textarea w-100 h-100"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Ce que tu apporterais dans l'entreprise</div>

                        </td>
                        <td>
                            <textarea name="apporterais" class="action-textarea w-100 h-100"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Pourquoi tu veux rejoindre l'équipe</div>

                        </td>
                        <td>
                            <textarea name="pourquoi" class="action-textarea w-100 h-100"></textarea>
                        </td>
                    </tr>
                   @endif

                </table>
                
            </form>
 