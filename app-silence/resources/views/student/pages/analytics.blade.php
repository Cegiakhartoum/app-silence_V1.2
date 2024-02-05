<!-- resources/views/student/page/analytics.blade.php -->

@extends('student.layouts.page', ['contentBackground' => '#33395e'])

@section('content')
    <div class="container mt-5">
        <h1 class="text-white">Analytics</h1>
      
        <!-- Filtres -->
<form id="filterForm" class="mb-4">
    <div class="row">
        <div class="col-md-3">
            <label for="platformFilter" class="form-label text-white">Plateforme :</label>
            <select id="platformFilter" class="form-select" onchange="updateCharts()">
                <option value="app">APP</option>
         
            </select>
        </div>
        <div class="col-md-3">
            <label for="yearFilter" class="form-label text-white">Année :</label>
            <select id="yearFilter" class="form-select">
                @for ($year = 2023; $year <= 2033; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>
    </div>
</form>
        
        <!-- Graphique pour le nombre d'utilisateurs créés par trimestre -->
        <div class="card mt-4">
            <div class="card-body">
                <canvas id="usersChart"></canvas>
            </div>
        </div>

        <!-- Graphique pour le nombre de projets individuels créés par trimestre -->
        <div class="card mt-4">
            <div class="card-body">
                <canvas id="individualProjectsChart"></canvas>
            </div>
        </div>

        <!-- Graphique pour le nombre de projets de groupe créés par trimestre -->
        <div class="card mt-4">
            <div class="card-body">
                <canvas id="groupProjectsChart"></canvas>
            </div>
        </div>
    </div>

<!-- Ajoutez le script pour initialiser les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> <!-- Ajout de jQuery -->

<script>
    // Récupérez les données passées depuis le contrôleur
    var usersByQuarter = {!! json_encode($usersByQuarter) !!};
    var individualProjectsByQuarter = {!! json_encode($individualProjectsByQuarter) !!};
    var groupProjectsByQuarter = {!! json_encode($groupProjectsByQuarter) !!};

    // Fonction pour convertir le numéro du trimestre en dates de début et fin
    function getQuarterDates(quarter, year) {
        switch (quarter) {
            case 1:
                return { start: year + '-01-01', end: year + '-04-30' };
            case 2:
                return { start: year + '-05-01', end: year + '-08-31' };
            case 3:
                return { start: year + '-09-01', end: year + '-12-31' };
            default:
                return { start: '', end: '' };
        }
    }

    // Créez des graphiques avec Chart.js
    // Vous devrez adapter ces scripts en fonction de vos données exactes
    // Voir la documentation de Chart.js pour plus d'options : https://www.chartjs.org/docs/latest/

    // Graphique pour le nombre d'utilisateurs créés par trimestre
    var usersChart = new Chart(document.getElementById('usersChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: usersByQuarter.map(item => {
                const quarterDates = getQuarterDates(item.quarter, item.year);
                return quarterDates.start + ' - ' + quarterDates.end;
            }),
            datasets: [{
                label: 'Nombre d\'utilisateurs',
                data: usersByQuarter.map(item => item.user_count),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Graphique pour le nombre de projets individuels créés par trimestre
    var individualProjectsChart = new Chart(document.getElementById('individualProjectsChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: individualProjectsByQuarter.map(item => {
                const quarterDates = getQuarterDates(item.quarter, item.year);
                return quarterDates.start + ' - ' + quarterDates.end;
            }),
            datasets: [{
                label: 'Nombre de projets individuels',
                data: individualProjectsByQuarter.map(item => item.project_count),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Graphique pour le nombre de projets de groupe créés par trimestre
    var groupProjectsChart = new Chart(document.getElementById('groupProjectsChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: groupProjectsByQuarter.map(item => {
                const quarterDates = getQuarterDates(item.quarter, item.year);
                return quarterDates.start + ' - ' + quarterDates.end;
            }),
            datasets: [{
                label: 'Nombre de projets de groupe',
                data: groupProjectsByQuarter.map(item => item.project_count),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

       // Attacher la fonction updateCharts à l'événement onchange du filtre d'année
    $('#yearFilter').on('change', function () {
      
        // Mettre à jour les graphiques en fonction de l'année sélectionnée
        var selectedYear = this.value;
        updateCharts(selectedYear);
    });

    function updateCharts(selectedYear) {
      console.log('Updating charts for year:', selectedYear);
        // Mettre à jour les graphiques en fonction de l'année sélectionnée
        // Exemple pour le nombre d'utilisateurs créés par trimestre
        $.ajax({
            url: `/student/analytics/${selectedYear}`,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
               console.log('Received data:', data);
                // Mettre à jour les graphiques avec les nouvelles données
                updateUsersChart(data.usersByQuarter);
                updateIndividualProjectsChart(data.individualProjectsByQuarter);
                updateGroupProjectsChart(data.groupProjectsByQuarter);
            }
        });
    }

    function updateUsersChart(updatedUsersByQuarter) {
        // Code pour mettre à jour le graphique des utilisateurs
        usersChart.data.labels = updatedUsersByQuarter.map(item => {
            const quarterDates = getQuarterDates(item.quarter, item.year);
            return quarterDates.start + ' - ' + quarterDates.end;
        });
        usersChart.data.datasets[0].data = updatedUsersByQuarter.map(item => item.user_count);
        usersChart.update();
    }

    function updateIndividualProjectsChart(updatedIndividualProjectsByQuarter) {
        // Code pour mettre à jour le graphique des projets individuels
        individualProjectsChart.data.labels = updatedIndividualProjectsByQuarter.map(item => {
            const quarterDates = getQuarterDates(item.quarter, item.year);
            return quarterDates.start + ' - ' + quarterDates.end;
        });
        individualProjectsChart.data.datasets[0].data = updatedIndividualProjectsByQuarter.map(item => item.project_count);
        individualProjectsChart.update();
    }

    function updateGroupProjectsChart(updatedGroupProjectsByQuarter) {
        // Code pour mettre à jour le graphique des projets de groupe
        groupProjectsChart.data.labels = updatedGroupProjectsByQuarter.map(item => {
            const quarterDates = getQuarterDates(item.quarter, item.year);
            return quarterDates.start + ' - ' + quarterDates.end;
        });
        groupProjectsChart.data.datasets[0].data = updatedGroupProjectsByQuarter.map(item => item.project_count);
        groupProjectsChart.update();
    }

    // Initialiser les graphiques avec les données initiales
    updateCharts($('#yearFilter').val());
</script>

@endsection


