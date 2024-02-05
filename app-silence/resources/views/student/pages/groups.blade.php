 @extends('student.layouts.page', ['contentBackground' => '#33395e'])

@section('content')
    <div class="container mt-5">
        <form method="post" action="/student/addMember" class="mt-4">
            @csrf
            <div class="form-group">
                <label for="project">Rechercher un projet :</label>
                <input type="text" name="searchProject" id="searchProject" class="form-control" placeholder="Entrez le nom du projet" required>
                <!-- Ajoutez une section pour afficher les résultats de la recherche pour les projets -->
                <div id="searchProjectResults" class="mt-3"></div>
            </div>
            <div class="form-group">
                <label for="searchUser">Rechercher un utilisateur :</label>
                <input type="text" name="searchUser" id="searchUser" class="form-control" placeholder="Entrez le nom d'utilisateur" required>
                <!-- Ajoutez une section pour afficher les résultats de la recherche pour les utilisateurs -->
                <div id="searchUserResults" class="mt-3"></div>
            </div>
            <button type="submit" class="btn btn-success">Ajouter</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Project search
        $('#searchProject').on('input', function () {
            var searchTerm = $(this).val();
            $.ajax({
                type: 'POST',
                url: '/student/searchProjects',
                data: { '_token': '{{ csrf_token() }}', 'searchProject': searchTerm }, // Update variable name
                dataType: 'json',
                success: function (data) {
                    // Afficher les résultats de la recherche dans la section searchProjectResults
                    $('#searchProjectResults').html('');
                    if (data.searchResults.groups.length > 0) {
                        // Construire le tableau Bootstrap avec la colonne "Action" pour les projets
                        var tableHtml = '<table class="table table-bordered table-light"><thead><tr><th>ID</th><th>Nom</th><th>Type</th><th>Action</th></tr></thead><tbody>';
                        $.each(data.searchResults.groups, function (index, project) {
                            tableHtml += '<tr><td>' + project.id + '</td><td>' + project.nom + '</td><td>' + project.type + '</td><td><button type="Submit" class="btn btn-sm btn-success">Ajouter</button></td></tr>';
                        });
                        tableHtml += '</tbody></table>';
                        $('#searchProjectResults').html(tableHtml);
                    } else {
                        $('#searchProjectResults').html('<p>Aucun résultat trouvé.</p>');
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

            // Gestion de l'événement de changement de la zone de recherche pour les utilisateurs
            $('#searchUser').on('input', function () {
                // Récupérer la valeur de la zone de recherche pour les utilisateurs
                var searchTerm = $(this).val();

                // Faire une requête Ajax vers votre route de recherche d'utilisateurs
                $.ajax({
                    type: 'POST',
                    url: '/student/searchUsers',
                    data: { '_token': '{{ csrf_token() }}', 'searchUser': searchTerm },
                    dataType: 'json',
                    success: function (data) {
                        // Afficher les résultats de la recherche dans la section searchUserResults
                        $('#searchUserResults').html('');
                        if (data.searchResults.length > 0) {
                            // Construire le tableau Bootstrap avec la colonne "Action" pour les utilisateurs
                            var tableHtml = '<table class="table table-bordered table-light"><thead><tr><th>ID</th><th>Nom</th><th>Email</th><th>Action</th></tr></thead><tbody>';
                            $.each(data.searchResults, function (index, user) {
                                tableHtml += '<tr><td>' + user.id + '</td><td>' + user.name + '</td><td>' + user.email + '</td><td><button type="Submit" class="btn btn-sm btn-success">Ajouter</button></td></tr>';
                            });
                            tableHtml += '</tbody></table>';
                            $('#searchUserResults').html(tableHtml);
                        } else {
                            $('#searchUserResults').html('<p>Aucun résultat trouvé.</p>');
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection
