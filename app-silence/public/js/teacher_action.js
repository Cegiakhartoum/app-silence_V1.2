var groups = [];

// var students = [
//     { "id": "1", "name": "Emmanuel" },
//     { "id": "2", "name": "Célia Lessalle" },
//     { "id": "3", "name": "Lessalle" },
//     { "id": "4", "name": "Camille" },
//     { "id": "5", "name": "Célia" },
//     { "id": "6", "name": "nadine" },
//     { "id": "7", "name": "Lessalle" },
//     { "id": "8", "name": "Sonia S" },
//     { "id": "9", "name": "Tito" },
//     { "id": "10", "name": "Berthelon Julie" },
//     { "id": "11", "name": "Alix SIMON" },
//     { "id": "12", "name": "Aaron LECLERCQ" },
//     { "id": "13", "name": "Eve LEGRAND" },
//     { "id": "14", "name": "Ana PIERRE" },
//     { "id": "15", "name": "Armand PICARD" },
//     { "id": "16", "name": "Alexandre FAURE" },
//     { "id": "17", "name": "SKULL04" }
// ];

var available_students = students;

var updatingGroupId;

function selectAllStudentsCreate() {
    $("#createGroupModal .student-button").prop("checked", $("#btn-check-all-create").prop("checked"));
}

function selectAllStudentsEdit() {
    $("#editGroupModal .student-button").prop("checked", $("#btn-check-all-edit").prop("checked"));
}

function openCreateGroupModal() {

    non_available_students = Array.prototype.concat.apply([], groups.map(g => g.members));
    available_students = students.filter(s => !non_available_students.includes(s));

    renderStudentsCreate();

    var myModalEl = document.getElementById("createGroupModal");
    var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);
    modal.show();
}

function openEditGroupModal(selectedMembers) {

    $("#editGroupModal .student-button").each(function () {
        $(this).prop("checked", false);
    })

    const non_available_students = Array.prototype.concat.apply([], groups.map(g => g.members));
    available_students = students.filter(s => !non_available_students.includes(s) || selectedMembers.includes(s));

    renderStudentsEdit(() => {

        $("#editGroupModal .student-button").each(function () {
            if (selectedMembers.map(m => m.id).includes($(this).val()))
                $(this).prop("checked", true);
        })

        var myModalEl = document.getElementById("editGroupModal");
        var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);
        modal.show();
    });

}

function closeCreateGroupModal() {
    var myModalEl = document.getElementById("createGroupModal");
    var modal = bootstrap.Modal.getInstance(myModalEl);
    modal.hide();
    $(".student-button").prop("checked", false);
    $("#btn-check-all-create").prop("checked", false);
}

function closeEditGroupModal() {
    var myModalEl = document.getElementById("editGroupModal");
    var modal = bootstrap.Modal.getInstance(myModalEl);
    modal.hide();
    $(".student-button").prop("checked", false);
    $("#btn-check-all-edit").prop("checked", false);
}

function createProject() {

    if (groups.length == 0) {
        alert("Veuillez rajouter au moins un groupe");
        return false;
    }

    if (groups.find(g => g.name == "")) {
        alert("Veuillez entrer un nom pour chaque groupe");
        return false;
    }

    if (groups.find(g => g.members.length == 0)) {
        alert("Veuillez entrer au moins un élève par groupe");
        return false;
    }

    $('#create_project_form input[name="groups"]').val(JSON.stringify(groups));
    $('#create_project_form').submit();

}
