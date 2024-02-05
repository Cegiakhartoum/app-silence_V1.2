$("form").on("submit", function () {
    let modifiedValue;
    let type;

    if ($(this).find('input[name="id_adid"]').length > 0) {
        modifiedValue = $(this).find('input[name="id_adid"]').val();
        type = "description";
    } else if ($(this).find('input[name="id_add_p"]').length > 0) {
        modifiedValue = $(this).find('input[name="id_add_p"]').val();
        type = "personnage";
    }

    if (modifiedValue && type) {
        localStorage.setItem("lastModifiedValue", modifiedValue);
        localStorage.setItem("lastModifiedType", type);
    }
});

$(document).ready(function () {
    // Define a variable to store the save delay timer
    var saveDelay;

    // Listen for changes on elements with the class 'personnage-select form-control'
    $(document).on("change", ".personnage-select.form-control", function () {
        // Clear the existing timer every time a change is detected
        clearTimeout(saveDelay);

        // Set a new timer to send the form data 5 seconds after the last detected change
        saveDelay = setTimeout(sendFormData, 5000); // 5 seconds = 5000 milliseconds
    });

    // Function to send the form data using AJAX
    function sendFormData() {
        $.ajax({
            url: $("#action-form").attr("action"), // Get the action URL from the form
            type: "POST",
            data: $("#action-form").serialize(), // Serialize the form data for submission
            beforeSend: startSavingAnimation,
            success: function (response) {
                console.log("Data submitted successfully!");
                // Call the success and revert animation function
                showSuccessAndRevert();
                // Handle other server responses here if needed
            },
            error: function (error) {
                console.log("Error during submission:", error);
                // You might want to add an error state for the button as well
            },
        });
    }

    // If you always want to disable the standard form submission
    $(".flex-grow-1.scroll-decoupage.decoupage-all").on("submit", function (e) {
        e.preventDefault(); // Prevent the default form submission
        sendFormData(); // Instead, send the form data using AJAX
    });
});

function startSavingAnimation() {
    $("#saveModal-button")
        .removeClass("save-btn")
        .addClass("saving-btn")
        .text("Sauvegarde en cours...");
    // Vous pouvez ajouter une icône de chargement ou autre chose si vous le souhaitez.
}

function showSuccessAndRevert() {
    $("#saveModal-button")
        .removeClass("saving-btn")
        .addClass("validated-icon")
        .text("✔ Sauvegardé");
    setTimeout(function () {
        $("#saveModal-button")
            .removeClass("validated-icon")
            .addClass("save-btn")
            .text("Enregistrer le projet");
    }, 2000); // L'icône de validation est affichée pendant 2 secondes avant de revenir à l'original.
}

function handleInput(e, dataListId, inputId, type) {
    const input = document.getElementById(inputId);
    const idx = inputId.split("-").pop();

    const displayDiv = document.getElementById(`selected-${type}-` + idx);
    const hiddenInput = document.getElementById(`${type}-values-` + idx);

    if (hiddenInput.value.split(",").includes(input.value)) {
        alert(`Ce ${type} est déjà sélectionné.`);
        input.value = "";
        return;
    }

    const span = document.createElement("span");
    span.innerHTML = `${input.value} <a href="#" style="color: black" onclick="removeElement(event, '${input.value}', '${idx}', '${type}')">x</a>`;
    displayDiv.appendChild(span);

    const currentValues = hiddenInput.value ? hiddenInput.value.split(",") : [];
    currentValues.push(input.value);
    hiddenInput.value = currentValues.join(",");

    input.value = "";
}

function removeElement(event, value, elementIndex, type) {
    event.preventDefault();

    const displayDiv = document.getElementById(
        "selected-" + type + "-" + elementIndex,
    );
    const hiddenInput = document.getElementById(
        type + "-values-" + elementIndex,
    );
    const values = hiddenInput.value.split(",");

    // Supprimer de la liste affichée
    displayDiv.removeChild(event.target.parentNode);

    // Supprimer de la valeur cachée
    const valueIndex = values.indexOf(value);
    if (valueIndex !== -1) {
        values.splice(valueIndex, 1);
    }
    hiddenInput.value = values.join(",");
}

$(document).ready(function () {
    let saveTimeout; // Variable pour stocker le setTimeout

    // Écoutez les modifications sur tous les éléments td
    $("td").on("DOMSubtreeModified", function () {
        // Annulez le setTimeout précédent pour empêcher la soumission
        clearTimeout(saveTimeout);

        // Configurez un nouveau délai de 5 secondes pour soumettre le formulaire
        saveTimeout = setTimeout(function () {
            $("#action-form").submit();
        }, 5000);
    });
});

$(document).ready(function () {
    let lastModifiedValue = localStorage.getItem("lastModifiedValue");
    let lastModifiedType = localStorage.getItem("lastModifiedType");

    let targetElement;

    if (lastModifiedType === "description") {
        targetElement = $(
            `input[name="id_adid"][value="${lastModifiedValue}"]`,
        ).parent();
    } else if (lastModifiedType === "personnage") {
        targetElement = $(
            `input[name="id_add_p"][value="${lastModifiedValue}"]`,
        ).parent();
    }

    if (targetElement && targetElement.length) {
        $(".scroll-decoupage").animate(
            {
                scrollTop: targetElement.offset().top,
            },
            1000,
        );
    }

    // Nettoyage du stockage local après utilisation
    localStorage.removeItem("lastModifiedValue");
    localStorage.removeItem("lastModifiedType");
});

$(document).ready(function () {
    $('form[action="/DeleteDescription"]').on("submit", function (e) {
        e.preventDefault();

        var form = $(this);
        var formData = form.serialize();

        $.ajax({
            url: form.attr("action"),
            method: "POST",
            data: formData,
            success: function (response) {
                form.closest(".modal-window")
                    .prev(".liste-personnage-item")
                    .remove();
                form.closest(".modal-window").remove();
            },
            error: function () {
                alert("Erreur réseau. Veuillez réessayer.");
            },
        });
    });

    $('form[action="/AddDescription"]').on("submit", function (e) {
        e.preventDefault();

        var form = $(this);
        var formData = form.serialize();

        $.ajax({
            url: form.attr("action"),
            method: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    var closestListePersonnages = form
                        .parent()
                        .siblings(".liste-personnages");
                    closestListePersonnages.append(
                        '<div class="liste-personnage-item">' +
                            '<span type="button" class="mb-2">' +
                            '<a href="#delete_description' +
                            response.id +
                            '" style="color:black;">' +
                            "<span>" +
                            response.description +
                            "</span>" +
                            "</a>" +
                            "</span>" +
                            "</div>",
                    );
                    form.find('input[name="add_descript"]').val("");
                } else if (response.status === "error") {
                    alert(response.message);
                }
            },
            error: function () {
                alert("Erreur réseau. Veuillez réessayer.");
            },
        });
    });

    $(".descriptionInput").on("input", function () {
        var currentInputValue = $(this).val();

        // Si la valeur est vide, sortez de la fonction.
        if (!currentInputValue.trim()) {
            return;
        }

        var matchingOptionExists = false;
        var datalistId = $(this).attr("list");
        var options = $("#" + datalistId + " option");

        options.each(function () {
            if ($(this).val() === currentInputValue) {
                matchingOptionExists = true;
                return false; // break out of the .each() loop
            }
        });

        if (matchingOptionExists) {
            $(this).closest("form").submit();
        }
    });
});
$('#add-personnage-form').on("submit", function (e) {
    e.preventDefault();

    var form = $(this);
    var formData = form.serialize();

    $.ajax({
        url: form.attr("action"),
        method: "POST",
        data: formData,
        dataType: "json",
        success: function (response) {
                      console.log(response);
            if (response.status === "success") {
                var closestListePersonnages = form
                    .parent()
                    .siblings(".liste-personnages");
                closestListePersonnages.append(
                    '<div class="liste-personnage-item">' +
                        '<span type="button" class=" mb-2">' +
                        '<a href="#delete_personnage' +
                        response.decoupage_id +
                        '" style="color:black;">' +
                        "<span>" +
                        response.personnage +
                        "</span>" +
                        "</a>" +
                        "</span>" +
                        "</div>",
                );
                form.find('input[name="add_personn"]').val("");
            } else if (response.status === "error") {
                alert(response.message);
            }
        },
        error: function () {
            alert("Erreur réseau. Veuillez réessayer.");
        },
    });
});

$(".input-personnage-object").on("input", function () {
    var currentInputValue = $(this).val();

    // Si la valeur est vide, sortez de la fonction.
    if (!currentInputValue.trim()) {
        return;
    }

    var matchingOptionExists = false;
    var datalistId = $(this).attr("list");
    var options = $("#" + datalistId + " option");

    options.each(function () {
        if ($(this).val() === currentInputValue) {
            matchingOptionExists = true;
            return false; // break out of the .each() loop
        }
    });

    if (matchingOptionExists) {
        $(this).closest("form").submit();
    }
});

$(document).on("submit", 'form[action="/DeletePersonnage"]', function (e) {
    e.preventDefault();

    var form = $(this);
    var formData = form.serialize();

    $.ajax({
        url: form.attr("action"),
        method: "POST",
        data: formData,
        success: function (response) {
            // Supprimer l'élément "personnage" de la liste
            form.closest(".modal-window")
                .prev(".liste-personnage-item")
                .remove();
            // Supprimer la fenêtre modale
            form.closest(".modal-window").remove();
        },
        error: function () {
            alert("Erreur réseau. Veuillez réessayer.");
        },
    });
});

$('form[action="/AddDecoupage"]').on("submit", function (e) {
    let sequenceId = document.getElementById("sequence_id").value;
    let plan = document.getElementById("plan").value;

    // Enregistrez les valeurs dans le stockage local
    localStorage.setItem("sequence_id", sequenceId);
    localStorage.setItem("plan", plan);
});

$(document).ready(function () {
    let sequenceId = localStorage.getItem("sequence_id");
    let plan = localStorage.getItem("plan");

    if (sequenceId && plan) {
        document.getElementById("sequence_id").value = sequenceId;
        document.getElementById("plan").value = plan;

        // Scroll vers data-sequence et data-plan
        $(".scroll-decoupage").animate({
            scrollTop:
                $(
                    "[data-sequence='" +
                        sequenceId +
                        "'][data-plan='" +
                        plan +
                        "']",
                ).offset().top - 250,
        });
    }

    // Nettoyage du stockage local après utilisation
    localStorage.removeItem("sequence_id");
    localStorage.removeItem("plan");
});