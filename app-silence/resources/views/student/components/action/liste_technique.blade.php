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

<div class="d-flex flex-column h-100" style="width:100%;text-align:center;float:right;">
    <h4 class="text-center font-weight-bolder action-title">
        LISTE TECHNIQUE & ARTISTIQUE
    </h4>

    <br />

    <form id="action-form" class="flex-grow-1" style="overflow-y: scroll;" method="POST" action="/save-actionDecoupage">
        @csrf
        <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
        <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
        <input type="hidden" name="redirect_url" value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />

        <div style="letter-spacing:3px; font-weight: 300;">
            <table id="acteurs-table">
                <tr>
                    <td style="width:20%;">POSTE</td>
                    <td style="width:20%;">Prenom</td>
                    <td style="width:20%;">Nom</td>
                    <td style="width:30%;">Mails</td>
                    <td style="width:30%;">Telephone</td>
                </tr>

                @php
                    $liste_tec = json_decode($action->liste_tec, true);
                    $indexInput = 0;
                @endphp

                @if (!empty($liste_tec))
                    @foreach ($liste_tec as $index => $tec)
                        @php $indexInput++; @endphp

                        <tr>
                            <td>
                                <input list="role-datalist-{{ $indexInput }}" class="form-control"
                                       placeholder="POSTE"
                                       id="role-input-{{ $indexInput }}" style="width:100%;"
                                       onchange="handleInput(event, 'role-datalist-{{ $indexInput }}', 'role-input-{{ $indexInput }}', 'role')">

                                <datalist id="role-datalist-{{ $indexInput }}">
                                    @foreach ($roles as $role => $disabled)
                                        @if (!$disabled)
                                            <option value="{{ $role }}" {{ $tec['role'] == $role ? 'selected' : '' }}>
                                                {{ $role }}
                                            </option>
                                        @endif
                                    @endforeach
                                </datalist>

                                <div id="role-display-{{ $indexInput }}" style="margin-top: 10px;"></div>
                              <input type="hidden" id="role-values-{{ $indexInput }}" name="role_adi[]"
                                     value="{{ $tec['role'] }}">

                              <div id="selected-role-{{ $indexInput }}" style="margin-top: 10px;">
                                  @foreach (array_filter(explode(',', $tec['role'])) as $selectedRole)
                                      <div>
                                          {{ $selectedRole }}
                                        
                                          <a href="#" style="color: black" class="delete-icon-a"
                                              onclick="removeElement(event, '{{ $selectedRole }}', '{{ $indexInput }}', 'role')">x</a>
                                      </div>
                                  @endforeach
                              </div>


                                <input type="hidden" id="role-values-{{ $indexInput }}" name="role_adi[]"
                                       value="{{ $tec['role'] }}">
                            </td>

                            <!-- fin td de personnage du découpage -->
                            <td>
                                <input type="text" class="form-control" style="width:100%;" placeholder="prenom"
                                    name="prenom_acteur[]" value="{{ $tec['prenom'] }}">
                            </td>
                            <td>
                                <input type="text" class="form-control" style="width:100%;" placeholder="nom"
                                    name="nom_acteur[]" value="{{ $tec['nom'] }}">
                            </td>
                            <td>
                                <input type="email" class="form-control" style="width:100%;" placeholder="e-mails"
                                    name="mail_acteur[]" value="{{ $tec['mails'] }}">
                            </td>
                            <td>
                                <input type="tel" class="form-control" style="width:100%;" placeholder="telephone"
                                    name="telephone_acteur[]" value="{{ $tec['telephones'] }}">
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                       <td>
    <input list="role-datalist" class="form-control"
           placeholder="POSTE"
           id="role-input" style="width:100%;"
           onchange="handleInput(event, 'role-datalist', 'role-input', 'role')">

    <datalist id="role-datalist">
        @foreach ($roles as $role => $disabled)
            @if (!$disabled)
                <option value="{{ $role }}"></option>
            @endif
        @endforeach
    </datalist>

    <div id="role-display" style="margin-top: 10px;"></div>
    <div id="selected-role" style="margin-top: 10px;">
        <!-- Add your code to display selected roles here -->
    </div>

    <input type="hidden" id="role-values" name="role_adi[]" value="">
</td>



                        <!-- fin td de personnage du découpage -->
                        <td>
                            <input type="text" class="form-control" style="width:100%;" placeholder="prenom"
                                name="prenom_acteur[]" value="">
                        </td>
                        <td>
                            <input type="text" class="form-control" style="width:100%;" placeholder="nom"
                                name="nom_acteur[]" value="">
                        </td>
                        <td>
                            <input type="email" class="form-control" style="width:100%;" placeholder="e-mails"
                                name="mail_acteur[]" value="">
                        </td>
                        <td>
                            <input type="tel" class="form-control" style="width:100%;" placeholder="telephone"
                                name="telephone_acteur[]" value="">
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </form>
  <!-- Button to add a new row -->
<button type="button" onclick="addNewRow()">Add New Row</button>

</div>

<!-- Add your JavaScript script if 'handleInput' is defined -->

<script src="/js/decoupage.js"></script>

<script>
    // Function to add a new row to the table
    function addNewRow() {
        // Get the table element
        var table = document.getElementById("acteurs-table");

        // Create a new row
        var newRow = table.insertRow(table.rows.length);

        // Add cells to the new row
        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);
        var cell4 = newRow.insertCell(3);
        var cell5 = newRow.insertCell(4);

        // Populate cells with input elements
        cell1.innerHTML = '<input list="role-datalist" class="form-control" placeholder="POSTE" onchange="handleInput(event, \'role-datalist\', \'role-input\', \'role\')"><datalist id="role-datalist">...</datalist>';
        cell2.innerHTML = '<input type="text" class="form-control" style="width:100%;" placeholder="prenom" name="prenom_acteur[]">';
        cell3.innerHTML = '<input type="text" class="form-control" style="width:100%;" placeholder="nom" name="nom_acteur[]">';
        cell4.innerHTML = '<input type="email" class="form-control" style="width:100%;" placeholder="e-mails" name="mail_acteur[]">';
        cell5.innerHTML = '<input type="tel" class="form-control" style="width:100%;" placeholder="telephone" name="telephone_acteur[]">';
    }
</script>

