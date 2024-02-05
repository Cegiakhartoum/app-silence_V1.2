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

?>
<script type="application/javascript">
    isScenario = true;
</script>
<form id="action-form" class="flex-grow-1" method="POST" action="/save-action">
    @csrf
    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
    <input type="hidden" name="redirect_url"
        value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
    <input type="hidden" name="scenario" value="" />
</form>

<div id="scenario-container" class="d-flex flex-column h-100">

    <h4 class="text-center font-weight-bolder action-title">
        SCÉNARIO
    </h4>

    <br />
    <div id="scenario-personnages-container" class="personnages-container" style="padding: 8px 64px;">
        <span class="personnages-label">(NOM.S DU.ES PERSONNAGE.S)</span>
        <input type="text" class="form-control add-personnage-input" placeholder="Nom du personnage">
        <button type="button" class="btn btn-primary add-personnage-btn">
            <i class="fas fa-plus-circle" style="color: white;"></i>
        </button>

        <div id="liste-personnages-scenario" class="liste-personnages">
            @if (is_null($action->scenario))
            @else
                @php
                    $scenario = json_decode($action->scenario);
                    $index = 0;
                @endphp
                @foreach ($scenario->personnages as $personnage)
                    <div class="liste-personnage-item">
                        <button type="button" class="btn btn-outline-primary">
                            <span>{{ $personnage }}</span>
                        </button>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div id="sequences">
        @if (is_null($action->scenario))
            {{-- LE SCENARIO EST NOUVEAU --}}
            <div class="sequence-scenario-container">
                <div>
                    1.
                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic radio toggle button group">
                        <div class="location" style="display: flex;">
                            <input type="radio" class="btn-check" name="location" id="btnradio1" value="EXT"
                                checked>
                            <label class="btn btn-outline-primary" for="btnradio1">EXT</label>
                            <span class="oblique-separator" style="margin: 0 4px;">/</span>
                            <input type="radio" class="btn-check" name="location" id="btnradio2" value="INT">
                            <label class="btn btn-outline-primary" for="btnradio2">INT</label>
                        </div>
                        <input type="text" name="lieu" class="form-control" style="margin: 0px 16px;"
                            placeholder="LIEU DE">

                        <div class="time" style="display: flex;">
                            <input type="radio" class="btn-check" name="time" id="btnradio3" autocomplete="off"
                                checked value="JOUR">
                            <label class="btn btn-outline-primary" for="btnradio3">JOUR</label>
                            <span class="oblique-separator" style="margin: 0 4px;">/</span>
                            <input type="radio" class="btn-check" name="time" id="btnradio4" autocomplete="off"
                                value="NUIT">
                            <label class="btn btn-outline-primary" for="btnradio4">NUIT</label>
                        </div>
                    </div>
                </div>
                <div class="personnages-container">
                    <span class="personnages-label">(NOM.S DU.ES PERSONNAGE.S)</span>

                    <div class="add-existing-personnage-sequence">
                        <select class="personnage-select form-control">
                          <option  disabled selected>Selectionne un personnage</option>
                      </select>
                        <button type="button" class="btn btn-primary add-personnage-btn">
                            <i class="fas fa-plus-circle" style="color: white;"></i>
                        </button>
                    </div>

                    <div class="add-new-personnage-sequence">
                        <input type="text" class="form-control add-personnage-input" placeholder="Nom du personnage">
                        <button type="button" class="btn btn-primary add-personnage-btn">
                            <i class="fas fa-plus-circle" style="color: white;"></i>
                        </button>
                    </div>

                    <div class="liste-personnages">

                    </div>
                </div>
                <div class="dialogues-descriptions">
                    <div class="description-container">
                        <textarea name="description" class="description-textarea form-control" placeholder="description" rows="6"></textarea>
                    </div>
                </div>
                <button type="button" class="btn add-dialogue-scene-btn" style="background: #4a4d77;">
                    Dialogue de personnage &nbsp;<i class="fas fa-plus-circle" style="color: white;"></i>
                </button>
                <button type="button" class="btn add-description-scene-btn" style="background: #d6982c;">
                    Description de scène &nbsp;<i class="fas fa-plus-circle" style="color: white;"></i>
                </button>
            </div>
        @else
            {{-- ANCIEN SCENARIO --}}
            @foreach ($scenario->sequences as $sequence)
                @php $index++; @endphp
                <div id="sequence-{{ $index }}" class="sequence-scenario-container">

                    <div class="pb-3">
                        {{ $index }}.
                        <div class="btn-group btn-group-sm" role="group"
                            aria-label="Basic radio toggle button group">

                            <div class="location" style="display: flex;">
                                <input type="radio" class="btn-check" name="location-{{ $index }}"
                                    id="btnradio1-{{ $index }}" value="EXT"
                                    {{ ($sequence->location ?? '') === 'EXT' ? 'checked' : '' }} />
                                <label class="btn btn-outline-primary"
                                    for="btnradio1-{{ $index }}">EXT</label>

                                <span class="oblique-separator" style="margin: 0 4px;">/</span>

                                <input type="radio" class="btn-check" name="location-{{ $index }}"
                                    id="btnradio2-{{ $index }}" value="INT"
                                    {{ ($sequence->location ?? '') === 'INT' ? 'checked' : '' }} />
                                <label class="btn btn-outline-primary"
                                    for="btnradio2-{{ $index }}">INT</label>
                            </div>
                            <input type="text" name="lieu" class="form-control" style="margin: 0px 16px;"
                                placeholder="LIEU DE" value="{{ $sequence->lieu ?? "" }}">

                            <div class="time" style="display: flex;">
                                <input type="radio" class="btn-check" name="time-{{ $index }}"
                                    id="btnradio3-{{ $index }}" value="JOUR"
                                    {{ ($sequence->time ?? '') === 'JOUR' ? 'checked' : '' }} />
                                <label class="btn btn-outline-primary"
                                    for="btnradio3-{{ $index }}">JOUR</label>
                                <span class="oblique-separator" style="margin: 0 4px;">/</span>
                                <input type="radio" class="btn-check" name="time-{{ $index }}"
                                    id="btnradio4-{{ $index }}" value="NUIT"
                                    {{ ($sequence->time ?? '') === 'NUIT' ? 'checked' : '' }} />
                                <label class="btn btn-outline-primary"
                                    for="btnradio4-{{ $index }}">NUIT</label>
                            </div>

                            <div class="d-flex ps-5">
                                <button type="button" class="btn btn-danger delete-sequence-btn">
                                    <i class="fas fa-trash-alt" style="color: white;"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="personnages-container">
                        <span class="personnages-label">(NOM.S DU.ES PERSONNAGE.S)</span>

                        <div class="add-existing-personnage-sequence">
                            <select style="width:400px;" class="personnage-select form-control">
                              <option  disabled selected>Selectionne un personnage</option>
                              {!! buildSequencePersonnagesOptions($scenario->personnages, $dialogue_description->value->personnage ?? "") !!}
                          </select>
                            <button type="button" class="btn btn-primary add-personnage-btn">
                                <i class="fas fa-plus-circle" style="color: white;"></i>
                            </button>
                        </div>

                        <div class="add-new-personnage-sequence">
                            <input type="text" class="form-control add-personnage-input" placeholder="Nom du personnage">
                            <button type="button" class="btn btn-primary add-personnage-btn">
                                <i class="fas fa-plus-circle" style="color: white;"></i>
                            </button>
                        </div>

                        <div class="liste-personnages">
                            @foreach (getSequencePersonnages($sequence) as $personnage)
                                <div class="liste-personnage-item">
                                    <button type="button" class="btn btn-outline-primary">
                                        <span> {{ $personnage }} </span>
                                    </button>
                                </div>
                            @endforeach
                        </div>

                    </div>
                    
                    <div class="dialogues-descriptions">
                        @foreach ($sequence->dialogues_descriptions as $keyIndex => $dialogue_description)
                            @if ( ($dialogue_description->type) == 'description')
                                <div class="description-container">
                                    <textarea name="description" class="description-textarea form-control" placeholder="description" rows="4">{{ $dialogue_description->value->description ?? "" }}</textarea>
                                    @if ( $keyIndex != 0)
                                        <button type="button" class="btn btn-danger delete-description-btn">
                                            <i class="fas fa-trash-alt" style="color: white;" /></i>
                                        </button>
                                    @endif
                                </div>
                            @elseif ($dialogue_description->type == 'dialogue')
                                <div class="personnage-dialogue">
                                    <select name="personnage" class="personnage-select form-control" style="width:400px;"> 
                                      <option  disabled selected>Selectionne un personnage</option>
                                      {!! buildSequencePersonnagesOptions($scenario->personnages, $dialogue_description->value->personnage ?? "") !!} 
                                  </select>
                                    <input type="text" class="form-control" style="margin: 0px 16px;"
                                        placeholder="Emotion" value="{{ $dialogue_description->value->emotion ?? "" }}">
                                    <button type="button" class="btn btn-danger delete-dialogue-personnage-btn">
                                        <i class="fas fa-trash-alt" style="color: white;" /></i>
                                    </button>
                                    <textarea class="dialogue-textarea form-control" placeholder="dialogue" rows="6">{{ $dialogue_description->value->dialogue ?? "" }}</textarea>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <button type="button" class="btn add-dialogue-scene-btn" style="background: #4a4d77;">
                        Dialogue de personnage &nbsp;<i class="fas fa-plus-circle" style="color: white;"></i>
                    </button>
                    <button type="button" class="btn add-description-scene-btn" style="background: #d6982c">
                        Description de scène &nbsp;<i class="fas fa-plus-circle" style="color: white;"></i>
                    </button>
                </div>
            @endforeach
        @endif
    </div>

    <div id="sequences-vue-classique" class="sequences-vue-classique">

    </div>

    <!-- Modal editer personnage -->
    <div id="edit-personnage-modal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="p-3">
                    <ul class="nav nav-pills mb-1" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">Modifier le personnage</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab"
                                aria-controls="pills-profile" aria-selected="false">Supprimer le personnage</button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="modal-body">
                            Veuillez entrer le nouveau nom de "<span class="nom_personnage fw-bold"></span>" et cliquer sur enregistrer
                            <input type="text" class="form-control" id="newNomInput" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal"  onclick="editPersonnage()">Enregistrer</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                        aria-labelledby="pills-profile-tab">
                        <div class="modal-body">
                            <p>
                                Êtes vous sûr de vouloir supprimer le personnage "<span class="nom_personnage fw-bold"></span>". <br/>
                                <b>Supprimer un personnage entraîne la suppression de tous les dialogues associés.</b>
                              "<span class="nom_personnage fw-gray"></span>"
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="deletePersonnage()">Supprimer</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal confirmer suppresion de personnage de sequence -->
    <div id="delete-personnage-confirm-modal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Suppresion du personnage <span id="personnage-delete" style="font-weight: bold;"></span> de la séquence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes vous sûr de vouloir supprimer ce personnage de la sequence ? Tous ses dialogues seront également supprimés de la séquence</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="deletePersonnageSequence()">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal confirmer suppresion sequence -->
    <div id="delete-sequence-confirm-modal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Suppresion de sequence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes vous sûr de vouloir supprimer la séquence ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" onclick="deleteSequence()">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal confirmer suppresion dialogue -->
    <div id="delete-dialogue-confirm-modal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Suppresion de dialogue</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes vous sûr de vouloir supprimer ce dialogue ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal confirmer suppresion description -->
    <div id="delete-description-confirm-modal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Suppresion de description</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes vous sûr de vouloir supprimer cette description ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="/js/scenario.js"></script>
