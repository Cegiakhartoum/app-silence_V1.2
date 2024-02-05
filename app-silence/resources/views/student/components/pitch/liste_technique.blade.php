<?php
// Exemple de tableau avec tous les rôles disponibles et leur statut "disabled"
$roles = [
    "technicien.ne" => false,
    "mise_en_scene" => true,
    "realisateur.realisatrice" => false,
    "assistant_realisateur" => false,
    "scripte" => false,
    "regie" => true,
    "regisseur.regisseuse" => false,
    "image" => true,
    "cadreur.cadreuse" => false,
    "electricite" => true,
    "electricien.electricienne" => false,
    "machinerie" => true,
    "machiniste" => false,
    "son" => false,
    "perchiste" => false,
    "hmc" => true,
    "costumier.costumiere" => false,
    "maquilleur.maquilleuse" => false,
    "coiffeur.coiffeuse" => false,
    "decors" => true,
    "decorateur.decoratrice" => false,
    "accessoiriste" => false
];
?>


<style>
    .selected-role {
    font-weight: bold;
    color: blue; /* Choisissez la couleur que vous souhaitez */
    }
    .select2-container--bootstrap-5 .select2-dropdown {
        z-index: 1000; /* Utilisez une valeur inférieure à celle du menu principal */
    }

 </style>

<div class="d-flex flex-column h-100" style="width:100%;text-align:center;float:right;">
    <h4 class="text-center font-weight-bolder action-title">
  
    LISTE TECHNIQUE & ARTISTIQUE
    </h4>

    <br />

<form id="action-form" class="flex-grow-1" style="overflow-y: scroll;" method="POST" action="/save-actionDecoupage">
    @csrf
    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
    <input type="hidden" name="redirect_url"
        value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
    
<div style=" letter-spacing:3px; font-weight: 300;">

<table id="acteurs-table">
    <tr>
        <td style="width:20%;">POSTE</td>
        <td style="width:20%;">Prenom</td>
        <td style="width:20%;">Nom</td>
        <td style="width:30%;">Mails</td>
        <td style="width:30%;">Telephone</td>
    </tr>

    @php
        $liste_acteurs = json_decode($action->liste_tec);
        $scenario = json_decode($action->scenario);
    @endphp

    @if (!empty($liste_acteurs))
        @foreach ($liste_acteurs as $index => $liste_acteur)
            @php
                $arr = (array) $liste_acteur;
                // Vérifier si $arr['role'] est une chaîne JSON
                if (is_string($arr['role']) && is_array(json_decode($arr['role'], true))) {
                    $selectedRoles = json_decode($arr['role'], true);
                } else {
                    $selectedRoles = (array) $arr['role']; // Convertir en tableau même s'il n'y a qu'un seul élément
                }
            @endphp

            <tr>
            <td style="width:40%;">
            <select class="form-select form-control" id="multiple-select-field" name="role[{{ $index }}][]" style="width:100%;" multiple>

                 <!-- Boucle foreach pour afficher les options -->
                 @foreach ($roles as $role => $disabled)
                            <!-- Vérifier si l'option n'est pas "disabled" -->
                            @if (!$disabled)
                                <!-- Vérifier si l'option est sélectionnée -->
                                @if (in_array($role, $selectedRoles))
                                    <!-- Option sélectionnée -->
                                    <option value="{{ $role }}" selected>{{ $role }}</option>
                                @else
                                    <!-- Option non sélectionnée -->
                                    <option value="{{ $role }}">{{ $role }}</option>
                                @endif
                            @else
                                <!-- Option "disabled" -->
                                <option value="{{ $role }}" disabled>{{ $role }}</option>
                            @endif
                        @endforeach
             </select>

                </td>

                <td>
                    <input type="text" class="form-control" style="width:100%;" placeholder="prenom"
                        name="prenom_acteur[]" value="{{ $arr['prenom'] }}">
                </td>
                <td>
                    <input type="text" class="form-control" style="width:100%;" placeholder="nom"
                        name="nom_acteur[]" value="{{ $arr['nom'] }}">
                </td>
                <td>
                    <input type="email" class="form-control" style="width:100%;" placeholder="e-mails"
                        name="mail_acteur[]" value="{{ $arr['mails'] }}">
                </td>
                <td>
                    <input type="tel" class="form-control" style="width:100%;" placeholder="telephone"
                        name="telephone_acteur[]" value="{{ $arr['telephones'] }}">
                </td>
                
            </tr>
        @endforeach
    @else
        <tr>
            <td style="width:40%;">
            <select class="form-select form-control" id="multiple-select-field" data-placeholder="Choose anything" name="role[{{ $index }}][]" style="width:100%;" multiple>
                    <!-- Boucle foreach pour afficher les options -->
                    @foreach ($roles as $role => $disabled)
                        <!-- Vérifier si l'option n'est pas "disabled" -->
                        @if (!$disabled)
                            <!-- Vérifier si l'option n'est pas déjà sélectionnée -->
                                <!-- Option active -->
                                <option value="{{ $role }}">{{ $role }}</option>
                       
                        @else
                            <!-- Option "disabled" -->
                            <optgroup label="{{ $role }}">

                        @endif
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" class="form-control" style="width:100%;" placeholder="prenom" name="prenom_acteur[]" value="">
            </td>
            <td>
                <input type="text" class="form-control" style="width:100%;" placeholder="nom" name="nom_acteur[]" value="">
            </td>
            <td>
                <input type="email" class="form-control" style="width:100%;" placeholder="e-mails" name="mail_acteur[]" value="">
            </td>
            <td>
                <input type="tel" class="form-control" style="width:100%;" placeholder="telephone" name="telephone_acteur[]" value="">
            </td>
        </tr>
    @endif
</table>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
  $( '#multiple-select-field' ).select2( {
      theme: "bootstrap-5",
      width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
      placeholder: $( this ).data( 'placeholder' ),
      closeOnSelect: false,
  } );
  </script>
</form>

</div>
   
</div>



