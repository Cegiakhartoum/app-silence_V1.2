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
            return "Correspond à <br>
            l échelle du plan.";

        case 6:
            return "Correspond à <br> 
            l angle de la caméra.";

        case 7:
            return "Correspond au sujet filmé.";

        case 8:
            return "Correspond au mouvement de la caméra.";

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

    .modal-window>div {
        width: 50%;
        border: #505050 1px solid;
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
    .modal-window>div {
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
    th,
    td {
        border: 1px solid;
        padding: 5px;
    }

    th {
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

    <form id="action-form" class="flex-grow-1 scroll-decoupage decoupage-all" style="overflow-y: scroll;" method="POST"
        action="/save-actionDecoupage">
        @csrf
        <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
        <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
    <input type="hidden" name="redirect_url"
        value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
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
                    <th style="width:15%;">
                        DESCRIPTION DE L'ACTION {!! buildOrangePopover(4) !!}
                    </th>
                    <th style="width:8%;">
                        ÉCHELLE {!! buildOrangePopover(5) !!}
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
                @if (empty($decoupages))
                @else
                    @php
                        $allPersonnages = [];
                        foreach ($decoupages as $decoupage) {
                            $currentPersonnages = json_decode($decoupage->sur ?? '{}', true);

                            // If $currentPersonnages is not an array (possibly due to invalid JSON), make it an empty array
                            if (!is_array($currentPersonnages)) {
                                $currentPersonnages = [];
                            }

                            $allPersonnages = array_merge($allPersonnages, $currentPersonnages);
                        }
                        $personnages = array_unique($allPersonnages);
                        $indexInput = 0;
                    @endphp

                    @foreach ($decoupages as $decoupage)
                    @php $indexInput++; @endphp
                        <tr data-sequence="{{ $decoupage->sequence_id }}" data-plan="{{ $decoupage->plan }}">

                        <td> 

                        <!-- Bouton déclencheur avec data-target -->
                        <button type="button" class="btn delete-sequence-btn" data-bs-toggle="modal" data-bs-target="#deleteModal{{$decoupage->id}}">
                        <i class="fas fa-trash-alt" style="color: red; background-color: transparent;"></i>

                        </button>
                           <!-- Modal de suppression -->
                        <div class="modal fade" id="deleteModal{{$decoupage->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{$decoupage->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content" style="background-color: white;">
                                    <div class="modal-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="button" class="close btn btn-link" style="text-decoration: none;" data-bs-dismiss="modal" aria-label="Close">
                                                <i style="color: #d5972b; font-size: 1.5em;" class="fas fa-arrow-alt-circle-left"></i>
                                            </button>
                                            <button type="button" class="close btn btn-link" style="text-decoration: none;" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="color: #d5972b; font-size: 2rem;">&times;</span>
                                            </button>
                                        </div>

                                        <!-- Contenu du modal de suppression -->
                                        <h5 class="modal-title" id="deleteModalLabel{{$decoupage->id}}">Supprimer séquence {{ $decoupage->sequence_id }} plan  {{ $decoupage->plan }} ?</h5>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <form method="POST" action="/DeleteDec">
                                            @csrf
                                            <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                                            <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                                            <input type="hidden" name="redirect_url" value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
                                            <input type="hidden" name="decoupage" value="" />
                                            <input type="hidden" name="id_delete_dec" value="{{ $decoupage->id }}" />
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                                            <input type="hidden" name="id_adi[]" value="{{ $decoupage->id }}" />
                                            {{ $decoupage->sequence_id }}


                            </td>

                            <td>
                                {{ $decoupage->plan }} </td>
                            <td>{{ $decoupage->lieu }}
                          </td>
                            



 <td>
                            @php
                            $descriptions = json_decode($decoupage->description);
                            $scenario = json_decode($action->scenario);
                            $index = 0;
                        @endphp
                            <input list="description-list-{{ $indexInput }}" class="form-control"
                                    placeholder="description" id="description-input-{{ $indexInput }}"
                                    style="width:100%;"
                                    onchange="handleInput(event, 'description-list-{{ $indexInput }}', 'description-input-{{ $indexInput }}', 'description')">

                                <datalist id="description-list-{{ $indexInput }}">
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
                                </datalist>

                                <div id="description-display-{{ $indexInput }}" style="margin-top: 10px;"></div>
                                <div id="selected-description-{{ $indexInput }}" style="margin-top: 10px;">
                                 @foreach (array_filter(explode(',', $decoupage->description)) as $descriptionItem)
                                      <div>
                                          {!! htmlspecialchars($descriptionItem, ENT_QUOTES, 'UTF-8') !!}
                                          <a href="#" style="color: black" class="delete-icon-a"
                                              onclick="removeElement(event, '{{ htmlspecialchars($descriptionItem, ENT_QUOTES, 'UTF-8') }}', '{{ $indexInput }}', 'description')">x</a>
                                      </div>
                                 @endforeach



                                </div>

                                <input type="hidden" id="description-values-{{ $indexInput }}" name="description_adi[]"
                                    value="{{ $decoupage->description }}">
			
                               
                            </td>
							<!-- fin td de personnage du découpage -->


                            <td>
                                <input list="echelle-list-{{ $indexInput }}" class="form-control"
                                    placeholder="échelle"
                                    id="echelle-input-{{ $indexInput }}" style="width:100%;"
                                    onchange="handleInput(event, 'echelle-list-{{ $indexInput }}', 'echelle-input-{{ $indexInput }}', 'echelle')">

                                <datalist id="echelle-list-{{ $indexInput }}">
                                    <option value="Très gros plan">
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
                                </datalist>

                                <div id="echelle-display-{{ $indexInput }}" style="margin-top: 10px;"></div>
                                <div id="selected-echelle-{{ $indexInput }}" style="margin-top: 10px;">
                                    @foreach (array_filter(explode(',', $decoupage->echelle)) as $echelleItem)
                                        <div>
                                            {{ $echelleItem }}
                                            <a href="#" style="color: black" class="delete-icon-a"
                                                onclick="removeElement(event, '{{ $echelleItem }}', '{{ $indexInput }}', 'echelle')">x</a>
                                        </div>
                                    @endforeach
                                </div>

                                <input type="hidden" id="echelle-values-{{ $indexInput }}" name="echelle_adi[]"
                                    value="{{ $decoupage->echelle }}">

                            </td>
                            <td>
                                <input list="angle-list-{{ $indexInput }}" class="form-control"
                                    placeholder="angle" id="angle-input-{{ $indexInput }}"
                                    style="width:100%;"
                                    onchange="handleInput(event, 'angle-list-{{ $indexInput }}', 'angle-input-{{ $indexInput }}', 'angle')">

                                <datalist id="angle-list-{{ $indexInput }}">
                                    <option value="Face"></option>
                                    <option value="3/4 face"></option>
                                    <option value="Plongée"></option>
                                    <option value="Contre plongée"></option>
                                    <option value="Profil"></option>
                                    <option value="Dos"></option>
                                    <option value="Autre"></option>
                                </datalist>

                                <div id="angle-display-{{ $indexInput }}" style="margin-top: 10px;"></div>
                                <div id="selected-angle-{{ $indexInput }}" style="margin-top: 10px;">
                                    @foreach (array_filter(explode(',', $decoupage->angle)) as $angleItem)
                                        <div>
                                            {{ $angleItem }}
                                            <a href="#" style="color: black" class="delete-icon-a"
                                                onclick="removeElement(event, '{{ $angleItem }}', '{{ $indexInput }}', 'angle')">x</a>
                                        </div>
                                    @endforeach
                                </div>

                                <input type="hidden" id="angle-values-{{ $indexInput }}" name="angle_adid[]"
                                    value="{{ $decoupage->angle }}">
                            </td>

                            <!-- début td de personnage du découpage -->
                            <td>
                            @php
                                    $personnages = json_decode($decoupage->sur);
                                    $scenario = json_decode($action->scenario);
                                    $index = 0;
                                @endphp 
                            <input list="sur-list-{{ $indexInput }}" class="form-control"
                                    placeholder="sur" id="sur-input-{{ $indexInput }}"
                                    style="width:100%;"
                                    onchange="handleInput(event, 'sur-list-{{ $indexInput }}', 'sur-input-{{ $indexInput }}', 'sur')">

                                <datalist id="sur-list-{{ $indexInput }}">
                                @foreach ($scenario->sequences as $scenario)
                                                @php $index++; @endphp
                                                @if ($index == $decoupage->sequence_id)
                                                    @foreach ($scenario->personnages as $personnage)
                                                        <option value=" {{ $personnage }}"> {{ $personnage }} </option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                </datalist>

                                <div id="sur-display-{{ $indexInput }}" style="margin-top: 10px;"></div>
                                <div id="selected-sur-{{ $indexInput }}" style="margin-top: 10px;">
                                  @foreach (array_filter(explode(',', $decoupage->sur)) as $surItem)
                                        <div>
                                            {{ $surItem }}
                                            <a href="#" style="color: black" class="delete-icon-a"
                                                onclick="removeElement(event, '{{ $surItem }}', '{{ $indexInput }}', 'sur')">x</a>
                                        </div>
                                   @endforeach
                                </div>

                                <input type="hidden" id="sur-values-{{ $indexInput }}" name="sur_adi[]"
                                    value="{{ $decoupage->sur }}">
                            </td>
							<!-- fin td de personnage du découpage -->
                            <td>
                                <input list="mouvement-list-{{ $indexInput }}" class="form-control"
                                    placeholder="mouvement"
                                    id="mouvement-input-{{ $indexInput }}" style="width:100%;"
                                    onchange="handleInput(event, 'mouvement-list-{{ $indexInput }}', 'mouvement-input-{{ $indexInput }}', 'mouvement')">

                                <datalist id="mouvement-list-{{ $indexInput }}">
                                    <option value="Fixe"></option>
                                    <option value="Panoramique horizontal"></option>
                                    <option value="Panoramique vertical"></option>
                                    <option value="Travelling avant"></option>
                                    <option value="Travelling arriere"></option>
                                    <option value="Autre"></option>
                                </datalist>

                                <div id="mouvement-display-{{ $indexInput }}" style="margin-top: 10px;"></div>
                                <div id="selected-mouvement-{{ $indexInput }}" style="margin-top: 10px;">
                                    @foreach (array_filter(explode(',', $decoupage->mouvement)) as $mouvementItem)
                                        <div>
                                            {{ $mouvementItem }}
                                            <a href="#" style="color: black" class="delete-icon-a"
                                                onclick="removeElement(event, '{{ $mouvementItem }}', '{{ $indexInput }}', 'mouvement')">x</a>
                                        </div>
                                    @endforeach
                                </div>

                                <input type="hidden" id="mouvement-values-{{ $indexInput }}"
                                    name="mouvement_adid[]" value="{{ $decoupage->mouvement }}">
                            </td>

                            <td>
                                <input list="audio-list-{{ $indexInput }}" class="form-control"
                                    placeholder="audio"
                                    id="audio-input-{{ $indexInput }}" style="width:100%;"
                                    onchange="handleInput(event, 'audio-list-{{ $indexInput }}', 'audio-input-{{ $indexInput }}', 'audio')">

                                <datalist id="audio-list-{{ $indexInput }}">
                                    <option value="Dialogue"></option>
                                    <option value="Musique"></option>
                                    <option value="Autre"></option>
                                </datalist>

                                <div id="audio-display-{{ $indexInput }}" style="margin-top: 10px;"></div>
                                <div id="selected-audio-{{ $indexInput }}" style="margin-top: 10px;">
                                    @foreach (array_filter(explode(',', $decoupage->audio)) as $audioItem)
                                        <div>
                                            {{ $audioItem }}
                                            <a href="#" style="color: black" class="delete-icon-a"
                                                onclick="removeElement(event, '{{ $audioItem }}', '{{ $indexInput }}', 'audio')">x</a>
                                        </div>
                                    @endforeach
                                </div>

                                <input type="hidden" id="audio-values-{{ $indexInput }}" name="audio_adi[]"
                                    value="{{ $decoupage->audio }}">
                            </td>
                            <td>
                                <input list="raccord-list-{{ $indexInput }}" class="form-control"
                                    placeholder="accord"
                                    id="raccord-input-{{ $indexInput }}" style="width:100%;"
                                    onchange="handleInput(event, 'raccord-list-{{ $indexInput }}', 'raccord-input-{{ $indexInput }}', 'raccord')">

                                <datalist id="raccord-list-{{ $indexInput }}">
                                    <option value="Regard"></option>
                                    <option value="Axe"></option>
                                    <option value="Jeu"></option>
                                    <option value="Mouvement"></option>
                                    <option value="Autre"></option>
                                </datalist>

                                <div id="raccord-display-{{ $indexInput }}" style="margin-top: 10px;"></div>
                                <div id="selected-raccord-{{ $indexInput }}" style="margin-top: 10px;">
                                    @foreach (array_filter(explode(',', $decoupage->raccord)) as $raccordItem)
                                        <div>
                                            {{ $raccordItem }}
                                            <a href="#" style="color: black" class="delete-icon-a"
                                            onclick="removeElement(event, '{{ $raccordItem }}', '{{ $indexInput }}', 'raccord')">x</a>
                                        </div>
                                    @endforeach
                                </div>

                                <input type="hidden" id="raccord-values-{{ $indexInput }}" name="raccord_adi[]"
                                    value="{{ $decoupage->raccord }}">
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
            <h3 style="Text-align:center;">Ajouter un plan</h3>  
            <hr>

            <form id="action-form" class="flex-grow-1" method="POST" action="/AddDecoupage">
                @csrf
                <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
                <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />

    <input type="hidden" name="redirect_url"
        value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
                <input type="hidden" name="decoupage" value="" />
                <legende> Séquence :</legende>
                <select name="sequence_id" id="sequence_id" class="personnage-select form-control"
                    style="width:100%;">
                    <option hidden>Sélectionne une séquence</option>
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
                    <button id="submit-add-decoupage" type="submit" class="btn btn-primary">Ajouter</button>
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
                    <h5 class="modal-title">Suppresion du personnage <span id="personnage-delete"
                            style="font-weight: bold;"></span> de la séquence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <p>Êtes vous sûr de vouloir supprimer ce personnage du decoupage ? </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        onclick="deletePersonnageSequence()">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal confirmer suppresion de description de sequence -->
    <div id="delete-personnage-confirm-modal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Suppresion du personnage <span id="personnage-delete"
                            style="font-weight: bold;"></span> de la séquence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cette description du découpage ? </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        onclick="deletePersonnageSequence()">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

</div>

</div>

<script src="/js/decoupage.js"></script>

<script>
    $(document).ready(function() {
        $('#sequence_id').on('change', function() {
            let id = $(this).val();
            $('#plan').empty();
            $.ajax({
                type: 'GET',
                url: '/GetSubCatAgainstMainCatEdit/{{ $action->projet_action_id }}/' + id,
                success: function(response) {
                    var response = JSON.parse(response);
                    console.log(response);
                    $('#plan').empty();
                    response.forEach(element => {
                        $('#plan').append(
                            `<option value="${parseInt(element['plan'])+1}">${parseInt(element['plan']) + 1}</option>`
                        );
                    });
                }
            });
        });
    });
</script>

