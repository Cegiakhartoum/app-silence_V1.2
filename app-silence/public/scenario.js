var vueClassqiue = false;
var scenarioDom;
var scenarioPersonnagesContainerHtml;
var sequencesHtml;

var sequenceToBeDeleted;

// The personnage to be deleted or edited
var selectedPersonnage;
var sequencePersonnageToBeDeleted;

function buildSequence() {
    var sequenceNumber = $(".sequence-scenario-container").length + 1;
    personnages = getPersonnagesScenario();
    personnagesOptions = "";
    personnages.forEach((personnage) => {
        personnagesOptions +=
            ' <option value="' +
            personnage.trim() +
            '">' +
            personnage.trim() +
            "</option>";
    });

    return `
    <div class="sequence-scenario-container" id="sequence-${sequenceNumber}">
        <div>
            ${sequenceNumber}.
            <div class="btn-group btn-group-sm" role="group" aria-label="Basic radio toggle button group">
                <div class="location" style="display: flex;">
                    <input type="radio" class="btn-check" name="location-${sequenceNumber}" id="btnradio1-${sequenceNumber}" value="EXT"
                        checked>
                    <label class="btn btn-outline-primary" for="btnradio1-${sequenceNumber}">EXT</label>
                    <span class="oblique-separator" style="margin: 0 4px;">/</span>
                    <input type="radio" class="btn-check" name="location-${sequenceNumber}" id="btnradio2-${sequenceNumber}" value="INT">
                    <label class="btn btn-outline-primary" for="btnradio2-${sequenceNumber}">INT</label>
                </div>
                <input type="text" name="lieu" class="form-control" style="margin: 0px 16px;"
                    placeholder="LIEU DE">

                <div class="time" style="display: flex;">
                    <input type="radio" class="btn-check" name="time-${sequenceNumber}" id="btnradio3-${sequenceNumber}" autocomplete="off"
                        checked value="JOUR">
                    <label class="btn btn-outline-primary" for="btnradio3-${sequenceNumber}">JOUR</label>
                    <span class="oblique-separator" style="margin: 0 4px;">/</span>
                    <input type="radio" class="btn-check" name="time-${sequenceNumber}" id="btnradio4-${sequenceNumber}" autocomplete="off"
                        value="NUIT">
                    <label class="btn btn-outline-primary" for="btnradio4-${sequenceNumber}">NUIT</label>
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
                <select class="personnage-select form-control">
                    ${personnagesOptions}
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
                <textarea name="description" class="description-textarea form-control" placeholder="description" rows="2"></textarea>
            </div>
        </div>
        <button type="button" class="btn add-dialogue-scene-btn" style="background: #4a4d77;">
            Dialogue de personnage &nbsp;<i class="fas fa-plus-circle" style="color: white;"></i>
        </button>
        <button type="button" class="btn add-description-scene-btn" style="background: #d6982c;">
            Description de scène &nbsp;<i class="fas fa-plus-circle" style="color: white;"></i>
        </button>
    </div>
    `;
}

function buildScenarioPersonnageListItem(nom) {
    return `
    <div class="liste-personnage-item">
        <button type="button" class="btn btn-outline-primary">
            <span> ${nom} </span>
        </button>
    </div>
    `;
}

function buildPersonnageListItem(nom) {
    // return '<div class="liste-personnage-item"> <span>' + nom + '</span>,&nbsp;</div>';
    return `
    <div class="liste-personnage-item">
        <button type="button" class="btn btn-outline-primary">
            <span> ${nom} </span>
        </button>
    ,&nbsp;</div>
    `;
}

function buildDescription(includeAddButtons = true) {
    let addButtonHTML = includeAddButtons
        ? `
        <div style="margin-top: 10px; margin-bottom: 10px;">
            <button type="button" class="btn add-between-dialogue-scene-btn"
                style="background: #4a4d77;"></button>
            <button type="button" class="btn add-between-description-scene-btn"
                style="background: #d6982c"></button>
        </div>
    `
        : "";

    return `
        <div class="description-container">
            <div style="flex: 1; margin-right: 10px;">
                <textarea name="description" class="description-textarea form-control" placeholder="description" rows="4"
                    style="width: 100%;"></textarea>
                ${addButtonHTML}
            </div>

            <button type="button" class="btn btn-danger delete-description-btn">
            <i class="fas fa-trash-alt" style="color: white;"></i>
            </button>
        </div>`;
}

function getPersonnagesScenario() {
    personnages = $("#liste-personnages-scenario span")
        .filter((e) => e.innerText != "")
        .map(function () {
            return $(this).text();
        })
        .get();

    return personnages;
}

function getPersonnagesSequence(sequenceJqueryObject) {
    personnages = sequenceJqueryObject
        .find(".liste-personnage-item")
        .map(function () {
            return $(this).children("span").text();
        })
        .get();
    return personnages;
}

function buildPersonnagesOptionsList() {
    var personnagesOptions = "";

    personnages = getPersonnagesScenario();

    personnagesOptions = personnages
        .map(function (n) {
            return '<option value="' + n + '">' + n + "</option>";
        })
        .join("");

    return personnagesOptions;
}

function buildDialoguePersonnage(includeAddButtons = true) {
    const personnagesOptions = buildPersonnagesOptionsList();

    if (personnagesOptions.trim() === "") {
        alert("Commencez par entrer des personnages");
        return;
    }

    let addButtonHTML = includeAddButtons
        ? `
        <div style="margin-bottom: 5px;">
            <button type="button" class="btn add-between-dialogue-scene-btn" style="background: #4a4d77;"></button>
            <button type="button" class="btn add-between-description-scene-btn" style="background: #d6982c"></button>
        </div>
    `
        : "";

    return `
        <div class="personnage-dialogue">
            <select name="personnage" class="personnage-select form-control" style="width:400px;">
                <option disabled selected>Selectionne un personnage</option>
                ${personnagesOptions}
            </select>
             <input type="hidden" class="perso form-control" style="margin: 0px 16px;"
               placeholder="perso"
               value="">
               <input type="text" class="form-control" style="margin: 0px 16px;"
               placeholder="Emotion"
               value="">
            <button type="button" class="btn btn-danger delete-dialogue-personnage-btn">
                <i class="fas fa-trash-alt" style="color: white;"></i>
            </button>
            <textarea class="dialogue-textarea form-control" placeholder="dialogue" rows="6"></textarea>
            ${addButtonHTML}
        </div>`;
}

function deleteDialoguePersonnage(elt) {
    $("#delete-dialogue-confirm-modal .btn-danger").off();
    $("#delete-dialogue-confirm-modal .btn-danger").on("click", function () {
        $(elt).parent().remove();
        $("#delete-dialogue-confirm-modal").modal("hide");
    });

    $("#delete-dialogue-confirm-modal").modal("show");
}

function deleteDescription(elt) {
    $("#delete-description-confirm-modal .btn-danger").off();
    $("#delete-description-confirm-modal .btn-danger").on("click", function () {
        $(elt).parent().remove();
        $("#delete-description-confirm-modal").modal("hide");
    });

    $("#delete-description-confirm-modal").modal("show");
}

function removePersonnageListItem() {
    $(".liste-personnage-item").remove();
}

function addPersonnage(elt, shouldShowWarning = true, shouldClearInput = true) {
    const nom = $(elt)
        .siblings(".add-personnage-input")
        .val()
        .trim()
        .toUpperCase();

    if (nom == "") {
        alert("Veuillez entrer le nom du personnage");
        return;
    }

    if (
        $(
            "#liste-personnages-scenario .liste-personnage-item span:contains('" +
                nom +
                "')",
        ).filter(function () {
            return $(this).text().trim().toUpperCase() === nom;
        }).length
    ) {
        if (shouldShowWarning) {
            alert("Le personnage a déjà été ajouté au scenario");
        }
        return;
    }

    // Update list personnages displayed
    $("#liste-personnages-scenario").append(
        buildScenarioPersonnageListItem(nom),
    );

    // Update list personnages select
    $(".personnage-select").each(function (index) {
        $(this).append($("<option>", { value: nom, text: nom }));
    });

    if (shouldClearInput) $(elt).siblings(".add-personnage-input").val("");
}

function addPersonnageToScenarioAndSequence(elt) {
    // Add personnage to scenario
    addPersonnage(elt, false, false);
    // Add personnage to sequence
    addPersonnageSequence(elt, true);
    // Clear input
    $(elt).siblings(".add-personnage-input").val("");
}

/**
 *
 * @param {*} elt : le bouton sur lequel l'utilisateur a cliqué
 * @param {*} shouldShowWarning : Booléen déterminant si le message d'erreur doit être affiché
 * @returns void
 * Cette fonction est utilisée pour ajouter un personnage à une séquence
 */
function addPersonnageSequence(elt, shouldShowWarning = true) {
    var nom = "";

    // Le personnage est ajouté depuis le champ de texte
    if ($(elt).siblings(".add-personnage-input").length > 0) {
        nom = $(elt)
            .siblings(".add-personnage-input")
            .val()
            .trim()
            .toUpperCase();
    }
    // Le personnage est ajouté depuis la liste déroulante
    else {
        nom = $(elt)
            .siblings(".personnage-select")
            .find(":selected")
            .val()
            .trim()
            .toUpperCase();
    }

    if (nom == "") {
        alert("Veuillez entrer le nom du personnage");
        return;
    }

    if (
        $(elt)
            .closest(".personnages-container")
            .find(".liste-personnage-item span:contains('" + nom + "')")
            .filter(function () {
                return $(this).text().trim().toUpperCase() === nom;
            }).length
    ) {
        if (shouldShowWarning) {
            alert("Le personnage a déjà été ajouté à la séquence");
        }
        return;
    }

    // Update list personnages displayed
    $(elt)
        .closest(".personnages-container")
        .find(".liste-personnages")
        .append(buildScenarioPersonnageListItem(nom));
}

// Change the name of the personnage
function editPersonnage() {
    const newNom = $("#newNomInput").val().trim().toUpperCase();

    if (newNom == "") {
        alert("Veuillez entrer le nom du personnage");
        return false;
    }

    // Edit the name of the personnage in the list
    $(".liste-personnage-item span").each(function (index, element) {
        if (
            $(this).text().trim().toUpperCase() ==
            selectedPersonnage.toUpperCase()
        ) {
            $(this).text(newNom);
        }
    });

    // Edit the name of the personnage in the select
    $('.personnage-select option[value="' + selectedPersonnage + '"]')
        .attr("value", newNom)
        .text(newNom);
    // $('.personnage-select option[value="' + selectedPersonnage + '"]').val(newNom);
}

// Delete the personnage from the scenario
function deletePersonnage() {
    // Delete dialogues of the personnage
    $(
        '.personnage-dialogue option[value="' +
            selectedPersonnage +
            '"]:selected',
    )
        .parent()
        .parent()
        .remove();

    // Delete the personnage from the list
    $(".liste-personnage-item span").each(function (index, element) {
        if ($(element).text().trim().toUpperCase() == selectedPersonnage) {
            $(this).parent().parent().remove();
        }
    });

    // Delete the personnage from the selects
    $('.personnage-select option[value="' + selectedPersonnage + '"]').remove();
}

// Delete the personnage from the sequence
function deletePersonnageSequence() {
    personnage = $(sequencePersonnageToBeDeleted).find("span").text().trim();

    // Delete dialogues of the personnage
    $(sequencePersonnageToBeDeleted)
        .closest(".sequence-scenario-container")
        .find(
            '.personnage-dialogue option[value="' + personnage + '"]:selected',
        )
        .parent()
        .parent()
        .remove();

    // Delete the personnage from the list of personnages of the sequence
    $(sequencePersonnageToBeDeleted).parent().remove();

    // Delete the personnage from the selects of the sequence
    $(sequencePersonnageToBeDeleted)
        .closest(".sequence-scenario-container")
        .find('.personnage-select option[value="' + personnage + '"]')
        .remove();
}

function getSequenceDialoguesDescriptions(sequenceJqueryObject) {
    var results = [];

    sequenceJqueryObject
        .children(".dialogues-descriptions")
        .children()
        .each(function (index, element) {
            //console.log($(element));
            if ($(element).hasClass("description-container")) {
                results.push({
                    type: "description",
                    value: {
                        description: $(this)
                            .find(".description-textarea")
                            .first()
                            .val(),
                    },
                });
            } else if ($(element).hasClass("personnage-dialogue")) {
                results.push({
                    type: "dialogue",
                    value: {
                        personnage: $(this)
                            .children("select")
                            .children("option:checked")
                            .val(),
                        emotion: $(this).children("input").val(),
                        dialogue: $(this).children("textarea").val(),
                    },
                });
            }
        });

    return results;
}

function getSequencePersonnages(sequenceJqueryObject) {
    var results = [];

    sequenceJqueryObject
        .find(".liste-personnage-item span")
        .each(function (index, element) {
            results.push($(element).html().trim());
        });

    sequenceJqueryObject
        .find(".personnage-select option:selected span")
        .each(function (index, element) {
            results.push($(element).html().trim());
        });

    return results;
}

function switchToVueClassique() {
    if (vueClassqiue) {
        vueClassqiue = false;
        $("#scenario-container").removeClass("scenario-vue-classique");
        $("#sequences-vue-classique").html("");
        return;
    }

    vueClassqiue = true;

    // $("#scenario-personnages-container-vue-classique").html( $("#scenario-personnages-container").html() );
    sequencesHtml = $("#sequences").html();
    sequencesHtml = sequencesHtml.replaceAll('id="', 'id="seqVueC');
    sequencesHtml = sequencesHtml.replaceAll('for="', 'for="seqVueC');
    sequencesHtml = sequencesHtml.replaceAll('name="', 'name="seqVueC');

    $("#sequences-vue-classique").html(sequencesHtml);




    $("#sequences")
        .find("input")
        .each(function (idx) {
            $("#sequences-vue-classique")
                .find("input")
                .eq(idx)
                .val($(this).val());
        });

    $("#sequences")
        .find("textarea")
        .each(function (idx) {
            $("#sequences-vue-classique")
                .find("textarea")
                .eq(idx)
                .val($(this).val());
        });

    // Switch to vue classique
    $("#scenario-container").addClass("scenario-vue-classique");

    // replace the lieu input by a span
    $("#sequences-vue-classique input[name^='seqVueClieu']").each(
        function (index, element) {
            value = $(element).val();
            $(element).replaceWith("<span> - " + value + " - </span>");
        },
    );

    // Replace liste personnages buttons by spans
    $(
        "#sequences-vue-classique .personnages-container .liste-personnage-item",
    ).each(function (index, element) {
        personnage = $(element).find("span").text();
        $(element).replaceWith("<span>" + personnage + "</span>,&nbsp;");
    });

    // Check if the value of the hidden input with class 'perso' is empty
      var persoValue = $(".perso").val();
      if (persoValue === "") {
             // Replace selects of personnages by spans
    $("#sequences-vue-classique .personnage-dialogue select").each(function () {
        var selectedValue = $(this).val();
        var spanText = selectedValue === "Select" ? "" : selectedValue;
        // Hide the select box and add a new <span> element right after it with the selected value
        $(this)
            .hide()
            .after("<span class='temp-span'>" + spanText + "</span>");
    });
      } else {
            // Replace selects of personnages by spans
    $("#sequences-vue-classique .personnage-dialogue select").each(function () {
        var selectedValue = $(this).val();
        var spanText = selectedValue === "Select" ? "" : selectedValue;
        // Hide the select box and add a new <span> element right after it with the selected value
        $(this)
            .hide()
            .after("");
    });
      } 

    // Replace input emotions by spans
    $("#sequences-vue-classique .personnage-dialogue input").each(
        function (index, element) {
            value = $(element).val();
            $(element).replaceWith("<span>" + value + "</span>");
        },
    );

    // Replace textarea by divs
    $(
        "#sequences-vue-classique .personnage-dialogue textarea, #sequences-vue-classique .description-textarea",
    ).each(function (index, element) {
        value = $(element).val();
        $(element).replaceWith(
            "<div style='margin-bottom: 16px;'>" + value + "</div>",
        );
    });
}

function deleteSequence() {
    var myModalEl = document.getElementById("delete-sequence-confirm-modal");
    var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);
    $("#" + sequenceToBeDeleted).remove();
    modal.hide();
}

function scenario_init() {
    $(document).on("click", ".remove-personnage-btn", function () {
        $(this).parent().remove();
    });

    initListeners();
}

function initListeners() {
    // Remove any previous click event listeners to avoid duplicates
    $("#add-sequence-menu").off();

    // Attach a new click event listener
    $("#add-sequence-menu").on("click", function () {
        // Store the sequence number to scroll to after the page reloads
        const sequenceNumber = $(".sequence-scenario-container").length + 1;
        sessionStorage.setItem("scrollToSequence", sequenceNumber);

        $("#sequences").append(buildSequence());

        setTimeout(() => {
            initListeners();

            // Scroll to the newly added sequence
            scrollToSequence(sequenceNumber);
        }, 1000);
    });

    // Supprimer une sequence
    $(".delete-sequence-btn").off();
    $(".delete-sequence-btn").on("click", function () {
        if ($(".sequence-scenario-container").length < 2) {
            alert("Vous devez avoir au moins une séquence");
            return;
        }

        var myModalEl = document.getElementById(
            "delete-sequence-confirm-modal",
        );
        var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);
        modal.show();

        sequenceToBeDeleted = $(this)
            .closest(".sequence-scenario-container")
            .attr("id");
    });

    $(".add-personnage-btn").off();

    // Ajouter personnage au scenario
    $("#scenario-personnages-container .add-personnage-btn").on(
        "click",
        function () {
            addPersonnage(this);
            setTimeout(() => {
                initListeners();
            }, 1000);
        },
    );

    // Ajouter personnage existant à une sequence on click
    $(".add-existing-personnage-sequence .add-personnage-btn").on(
        "click",
        function () {
            addPersonnageSequence(this);
            setTimeout(() => {
                initListeners();
            }, 1000);
        },
    );

    // Ajouter nouveau personnage à une sequence on click
    $(".add-new-personnage-sequence .add-personnage-btn").on(
        "click",
        function () {
            addPersonnageToScenarioAndSequence(this);
            setTimeout(() => {
                initListeners();
            }, 1000);
        },
    );



    // On click on a scenario personnage button, open modal and select the personnage
    $("#scenario-personnages-container .liste-personnage-item button").off();
    $("#scenario-personnages-container .liste-personnage-item button").on(
        "click",
        function () {
            selectedPersonnage = $(this).find("span").text().trim();
            $(".nom_personnage").text(selectedPersonnage);
            setTimeout(() => {
                $("#edit-personnage-modal").modal("show");
            }, 100);
            
        },
    );

    // On click on a sequence personnage button, open modal and select the personnage
    $("#sequences .liste-personnage-item button").off();
    $("#sequences .liste-personnage-item button").on("click", function () {
        sequencePersonnageToBeDeleted = this;
        $("#personnage-delete").text($(this).find("span").text().trim());
        setTimeout(() => {
            $("#delete-personnage-confirm-modal").modal("show");
        }, 100);
    });

    function addButtonsToElement(element) {
        // Si l'élément n'a pas déjà les boutons, ajoutez-les
        if (
            !element.find(
                ".add-between-dialogue-scene-btn, .add-between-description-scene-btn",
            ).length
        ) {
            element.find(".description-textarea, .dialogue-textarea").after(`
            <div style="margin-top: 10px; margin-bottom: 10px;">
                <button type="button" class="btn add-between-dialogue-scene-btn" style="background: #4a4d77;"></button>
                <button type="button" class="btn add-between-description-scene-btn" style="background: #d6982c"></button>
            </div>
            `);
        }
    }

    $(".add-description-scene-btn").off();
    $(".add-description-scene-btn").on("click", function () {
        const dialoguesDescriptions = $(this).siblings(
            ".dialogues-descriptions",
        );
        // Trouver le dernier "description-container" ou "personnage-dialogue"
        const lastElement = dialoguesDescriptions.children().last();

        // Ajouter les boutons à l'élément précédent si nécessaire
        if (lastElement.length > 0) {
            addButtonsToElement(lastElement);
        }
        // Ajouter la nouvelle "description-container" avec les boutons
        dialoguesDescriptions.append(buildDescription(false));

        setTimeout(() => {
            initListeners();
            scrollToPosition();
        }, 1000);
        triggeredByAutoSave = true;
        scenarioSave();
    });

    $(".add-between-description-scene-btn").off();
    $(".add-between-description-scene-btn").on("click", function () {
        if ($(this).parent().parent().hasClass("personnage-dialogue")) {
            $(this).parent().parent().after(buildDescription());
        } else {
            $(this).parent().parent().parent().after(buildDescription());
        }
        setTimeout(() => {
            initListeners();
            scrollToPosition();
        }, 1000);
        triggeredByAutoSave = true;
        scenarioSave();
    });

    // Add dialogue personnage on click
    $(".add-dialogue-scene-btn").off();
    $(".add-dialogue-scene-btn").on("click", function () {
        const dialoguesDescriptions = $(this).siblings(
            ".dialogues-descriptions",
        );

        // Find the last "description-container" or "personnage-dialogue"
        const lastElement = dialoguesDescriptions.children().last();

        // Add buttons to the previous element if necessary
        if (lastElement.length > 0) {
            addButtonsToElement(lastElement);
        }

        // Append the new "personnage-dialogue" with the buttons
        dialoguesDescriptions.append(buildDialoguePersonnage(false));

        setTimeout(() => {
            initListeners();
            scrollToPosition();
        }, 1000);
        triggeredByAutoSave = true;
        scenarioSave();
    });

    $(".add-between-dialogue-scene-btn").off();
    $(".add-between-dialogue-scene-btn").on("click", function () {
        if ($(this).parent().parent().hasClass("personnage-dialogue")) {
            $(this).parent().parent().after(buildDialoguePersonnage());
        } else {
            $(this).parent().parent().parent().after(buildDialoguePersonnage());
        }
        setTimeout(() => {
            initListeners();
            scrollToPosition();
        }, 1000);
        triggeredByAutoSave = true;
        scenarioSave();
    });

    // Delete dialogue personnage on click
    $(".delete-dialogue-personnage-btn").off();
    $(".delete-dialogue-personnage-btn").on("click", function () {
        deleteDialoguePersonnage(this);
    });

    // Delete description on click
    $(".delete-description-btn").off();
    $(".delete-description-btn").on("click", function () {
        deleteDescription(this);
    });
}

var triggeredByAutoSave = false;

function scenarioValidate() {
    sequences = new Array();

    personnages = getPersonnagesScenario();

    $(".sequence-scenario-container").each(function (index, element) {
        sequence = {
            location: $(element).find('input[name^="location"]:checked').val(),
            time: $(element).find('input[name^="time"]:checked').val(),
            lieu: $(element).find('input[name^="lieu"]').val(),
            dialogues_descriptions: new Array(),
            personnages: new Array(),
        };

        sequence.dialogues_descriptions = getSequenceDialoguesDescriptions(
            $(element),
        );
        sequence.personnages = getSequencePersonnages($(element));

        sequences.push(sequence);
    });

    data = {
        personnages,
        sequences,
    };

    console.log(data);
    $("#action-form input[name='scenario']").val(JSON.stringify(data));

    // Ici, nous utilisons AJAX pour envoyer les données du formulaire
    $.ajax({
        url: $("#action-form").attr("action"),
        type: "POST",
        data: $("#action-form").serialize(),
        beforeSend: startSavingAnimation, // Commence l'animation de sauvegarde
        success: function (response) {
            console.log("Données soumises avec succès !");
            showSuccessAndRevert(); // Montre la validation et revient à l'original
        },
        error: function (error) {
            console.log("Erreur lors de la soumission :", error);
            // Gérez l'erreur comme vous le souhaitez (peut-être en montrant une alerte ou en changeant la couleur du bouton).
        },
    });
}

function scenarioSave() {
    scenarioValidate();
}

var saveDelay;

$(document).on("change", ".personnage-select", function () {
    // Clear the existing timer every time a change is detected
    clearTimeout(saveDelay);

    // Stocker la référence à $(this) pour pouvoir l'utiliser à l'intérieur de la fonction de temporisation
    var selectElement = $(this);

    // Set a new timer to send the form data 1 second after the last detected change
    saveDelay = setTimeout(function () {
        // Get the selected value from the select
        var selectedPersonnage = selectElement.val();

        // Find the corresponding input with the class '.perso' and update its value
        selectElement.closest('.personnage-dialogue').find('.perso').val(selectedPersonnage);

        // Call the scenarioSave function
        scenarioSave();
    }, 1000);
});


$(document).on(
    "keyup",
    ".sequence-scenario-container textarea, .sequence-scenario-container input .sequence-scenario-container select",
    function () {
        triggeredByAutoSave = true;
        clearTimeout(saveDelay);
        saveDelay = setTimeout(scenarioSave, 1000);
    },
);

$(document).on("click", ".add-personnage-btn", function () {

    triggeredByAutoSave = true;
    scenarioSave();
});

// Désactivez la soumission standard du formulaire pour seulement le comportement autosave
$("#action-form").on("submit", function (e) {
    if (triggeredByAutoSave) {
        e.preventDefault();
        triggeredByAutoSave = false; // Réinitialiser le flag
    }
});

function startSavingAnimation() {
    $("#saveIcon")
        .removeClass("save-btn")
        .addClass("saving-btn")
        .text("Sauvegarde en cours...");
    // Vous pouvez ajouter une icône de chargement ou autre chose si vous le souhaitez.
}

function showSuccessAndRevert() {
    $("#saveIcon")
        .removeClass("saving-btn")
        .addClass("validated-icon")
        .text("✔ Sauvegardé");
    setTimeout(function () {
        $("#saveIcon")
            .removeClass("validated-icon")
            .addClass("save-btn")
            .text("Enregistrer le projet");
    }, 2000); // L'icône de validation est affichée pendant 2 secondes avant de revenir à l'original.
}

function scrollToSequence(sequenceId) {
    const targetElement = $(`#sequence-${sequenceId}`);
    if (targetElement.length > 0) {
        $(".scenario-section").animate(
            {
                scrollTop:
                    targetElement.offset().top -
                    $(".scenario-section").offset().top +
                    $(".scenario-section").scrollTop(),
            },
            100,
        );
    }
}

function scrollToPosition() {
    // Récupérer la position actuelle du scroll
    const currentScrollTop = $(".scenario-section").scrollTop();

    // Ajouter 500 pixels à la position actuelle du scroll
    const newScrollTop = currentScrollTop + 500;

    // Animer le défilement vers la nouvelle position
    $(".scenario-section").animate(
        {
            scrollTop: newScrollTop
        },
        100
    );
}


$(document).ready(function () {
    // Retrieve the saved sequence ID from sessionStorage
    const savedSequenceId = sessionStorage.getItem("scrollToSequence");

    if (savedSequenceId) {
        scrollToSequence(savedSequenceId);
                                                                                               
        // Clear the saved sequence ID in sessionStorage
        sessionStorage.removeItem("scrollToSequence");
    }
});
