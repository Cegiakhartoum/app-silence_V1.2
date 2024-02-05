<?php

function buildOrangePopover($index)
{
    return '<i tabindex="' .
        $index .
        '" class="small-help-button fas fa-question-circle" data-bs-toggle="popover" data-bs-placement="top"
                        data-bs-content=\'' .
        getOrangePopoverContent($index) .
        '\' data-bs-template=\'' .
        getOrangePopoverTemplate() .
        '\' data-bs-trigger="focus" data-bs-title=" "></i>';
}

function getOrangePopoverTemplate()
{
    return '<div class="popover popover-orange" role="tooltip"><div class="popover-body"></div></div>';
}

function getOrangePopoverContent($index)
{
    switch ($index) {
        case 1:
            return "La séquence représente une unité de temps, de lieu et d’action. Dès qu’il y a <br/>
                            un changement de lieu ou de temporalité, le numéro de séquence change. <br/>
                            Dans le scénario, il faut énumérer toutes les séquences et décrire ce qu’il <br/> s’y passe. <br/>
                            Page de garde Pour écrire un séquence, il faut commencer par écrire le numéro de la <br/> séquence. <br/>
                            Le numéro est indispensable pour préparer le découpage technique et le <br/>
                            plan de travail qui permettront d’organiser le tournage de la meilleure <br/>
                            manière possible";

        case 2:
            return "La mention EXT si la séquence se <br/>
                            déroule à l’extérieur et INT si la <br/>
                            séquence se déroule à l’intérieur.";

        case 3:
            return "Correspond au lieu du film et au nom <br/>
                            de son propriétaire.";

        case 4:
            return "Correspond au moment de la journée <br/>
                    où se déroule la séquence.";

        case 5:
            return 'Correspond aux noms des personnages <br/>
                présents dans la séquence. <br/>
                Cela va permettre de mettre en avant les <br/>
                personnages présents dans la séquence. <br/>
                Dès l’énoncé de la séquence, le lecteur va <br/>
                savoir directement les personnages présents <br/>
                dans la séquence.
                ';

        case 6:
            return "Correspond à la description des lieux, <br/>
                            des personnages présents dans la <br/>
                            séquence et leurs actions.";

        case 7:
            return 'Correspond au nom du personnage <br/>
                    qui parle.';

        case 8:
            return 'Didascalies';

        case 9:
            return 'Les dialogues sont les mots, les phrases, <br/>
                    les expressions, que vont dire les <br/>
                    personnages. <br/>
                    Il s’agit du texte parlé que les acteurs vont <br/>
                    devoir apprendre pour pouvoir interpréter <br/>
                    le personnage créé. <br/>
                    Pour l’écrire, il faut retranscrire <br/>
                    directement ce que les personnages <br/>
                    disent.';
    }
}

?>

<div class="d-flex flex-column h-100">
    <h4 class="text-center font-weight-bolder action-title">
        <br />
        LA MISE EN PAGE DE TON SCÉNARIO <br />
    </h4>
    <div style="padding: 128px 128px; letter-spacing:3px; font-size: 130%; font-weight: 300;">
        <div>
            1. {!! buildOrangePopover(1) !!}
            EXT/INT {!! buildOrangePopover(2) !!}
            - LIEU DE {!! buildOrangePopover(3) !!} –
            JOUR/NUIT {!! buildOrangePopover(4) !!}
        </div>
        <div style="margin-top: 8px;"> (NOM.S DU.ES PERSONNAGE.S) {!! buildOrangePopover(5) !!}<br /><br /></div>
        <div> Description {!! buildOrangePopover(6) !!}<br /><br /></div>
        <div style="padding-left: 128px;"> PERSONNAGE{!! buildOrangePopover(7) !!} (Didascalies)
            {!! buildOrangePopover(8) !!}</div>
        <div style="padding-left: 64px; margin-top:8px;"> Dialogues. {!! buildOrangePopover(9) !!} </div>
    </div>
</div>
