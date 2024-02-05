// Used to init popovers
function initPopovers() {
    // Enable popover
    var popoverTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="popover"]'),
    );
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl, {
            container: "body",
            html: true,
        });
    });
}

var leaveLink = "";
// Use to know if we should warn the user to save his job before leaving
var mustWarnUserToSave = false;

function init() {
    // Initialiser les popovers, Aide et "popovers de Mise en page de ton scenario"
    initPopovers();

    // Check if scenario init is defined as a function, call it if it is
    if (typeof scenario_init === "function") {
        scenario_init();
    }

    $("#validateIcon").on("click", function () {
        if (typeof isScenario !== "undefined") {
            scenarioValidate();
        } else {
            $("#validateModal").modal("show");
        }
    });

    $("#saveIcon").on("click", function () {
        var scrollPosition = $(".scenario-section").scrollTop();
        sessionStorage.setItem("scenarioScrollPosition", scrollPosition);
        if (typeof isScenario !== "undefined") {
            scenarioSave();
        } else $("#saveModal").modal("show");
    });

    $(document).ready(function () {
        if (sessionStorage.getItem("scenarioScrollPosition")) {
            $(".scenario-section").scrollTop(
                parseFloat(sessionStorage.getItem("scenarioScrollPosition")),
            );
            sessionStorage.removeItem("scenarioScrollPosition");
        }
    });

    $("#validate-button").on("click", function () {
        $("#action-form").submit();
    });

    $("#saveModal-button").on("click", function () {
        // Set the redirect url to the current relative url
        $("#action-form input[name='redirect_url']").val(
            window.location.pathname + window.location.search,
        );
        $("#action-form").submit();
    });

    $("#scenario-vue-classique-btn").on("click", function () {
        switchToVueClassique();
    });

    // Quand un utilisateur clique sur un menu de la barre de gauche
    // Lui demander de sauver avant de passer
    $(".action-menu-item a").on("click", function () {
        if (!mustWarnUserToSave) {
            window.location.href = $(this).data("href");
            return;
        }

        leaveLink = $(this).data("href");
        let myModalEl = document.getElementById("leave-confirm-modal");
        let modal = bootstrap.Modal.getOrCreateInstance(myModalEl);
        modal.show();
    });

    // On changes of input content, set mustWarnUserToSave to true
    $("input,textarea").on("input", function (e) {
        mustWarnUserToSave = true;
    });
}

function leavePage() {
    window.location.href = leaveLink;
    mustWarnUserToSave = false;
}

$(function () {
    init();
});

// This event listener ensures that the contained function will only run
// after the entire document's content is fully loaded.
document.addEventListener("DOMContentLoaded", function () {
    // Fetches the current page's URL
    var url = window.location.href;

    // Checks if the URL contains "student/action" and ends with "c=0"
    if (url.includes("student/action") && url.endsWith("c=0")) {
        // If both conditions are met, open the menu toggle
        openMenuToggle();
    }
});

// This function programmatically "clicks" the checkbox to toggle the menu
function openMenuToggle() {
    // Find the input checkbox inside the div with id menuToggle
    var menuToggleInput = document.querySelector(
        "#menuToggle input[type='checkbox']",
    );

    // Simulate a click event on the checkbox
    // This will toggle its checked state (on/off)
    menuToggleInput.click();
}

$("#decoupage-vue-classique-btn").on("click", function (e) {
    e.preventDefault();

    if ($(this).hasClass("toggled")) {
        // If the button has already been clicked, revert the changes

        // Show previously hidden elements
        $("tr[data-sequence] #action-form").show();
        $(".delete-sequence-btn").show();
        $(".add-existing-personnage-sequence").show();
        $(".btn.btn-outline-primary").show();
        $("select.personnage-select").show();
        $("td input[list]").show();
        $("table a").show();

        // Remove the temporary <span> elements that were added before
        $(".temp-span").remove();

        // Remove the 'toggled-display' class from the '.liste-personnage-item' elements
        $(".liste-personnage-item").removeClass("toggled-display");

        // Remove the 'toggled' class from the button
        $(this).removeClass("toggled");
    } else {
        // If it's the first click on the button, apply the changes

        // Hide desired elements
        $("tr[data-sequence] #action-form").hide();
        $(".delete-sequence-btn").hide();
        $(".add-existing-personnage-sequence").hide();
        $(".delete-icon-a").hide();

        // $(".btn.btn-outline-primary").each(function () {
        //     var spanContent = $(this).find("span").text();
        //     // Hide the button and add a new <span> element right after it with the extracted content
        //     $(this)
        //         .hide()
        //         .after("<span class='temp-span'>" + spanContent + "</span>");
        // });

        $("select.personnage-select").each(function () {
            var selectedValue = $(this).val();
            var spanText = selectedValue === "Select" ? "" : selectedValue;
            // Hide the select box and add a new <span> element right after it with the selected value
            $(this)
                .hide()
                .after("<span class='temp-span'>" + spanText + "</span>");
        });

        // Add the 'toggled-display' class to the '.liste-personnage-item' elements
        $(".liste-personnage-item").addClass("toggled-display");

        // Add the 'toggled' class to the button indicating it has been clicked
        $(this).addClass("toggled");

        // For each input element of type datalist inside a td
        $("td input[list]").each(function () {
            var inputValue = $(this).val();
            var spanText = inputValue.toUpperCase();
            // Hide the input and add a new <span> element right after it with the uppercase value
            $(this)
                .hide()
                .after("<span class='temp-span'>" + spanText + "</span>");
        });
    }
});