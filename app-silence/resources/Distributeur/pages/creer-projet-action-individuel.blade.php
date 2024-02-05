<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FaisTonFilm') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">


    <style>
        .type-block {
            border: 3px double #ccc;
            border-radius: 10px;
            padding: 64px 16px 0;
            font-size: 20px;
            text-align: center;
            width: calc(100% - 16px);
            margin-left: 8px;
            display: block;
            height: 500px;
        }

        .type-block div:nth-child(1) {
            font-size: 32px;
            margin-bottom: 64px;
        }

        .type-block div:nth-child(2) {
            font-style: italic;
        }

        .type-block.blured {
            filter: blur(8px);
        }

        .type-block.blured div:nth-child(2) {
            font-style: normal;
            text-align: left;
        }
    </style>

</head>

<body style="background: #222136;">
    <div id="app" class="container-fluid" style="padding: 8px 32px;">
        <div style="display: flex; flex-direction:row; padding: 16px 18px 32px 24px">
            <div style="flex-grow:1;">
                <a href="/student/plateau" class="icon-wrapper">
                    <img src="{{ asset('images/logo.svg') }}"
                        style="height: 30px; display: inline-block; margin: auto;" />
                    Retour plateau
                </a>
            </div>
            <div style="color: #FFF;">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Poser une question"
                    style="color:#AAA; padding: 4px 8px; background-color: #32325e; border:none; border-radius:5px; margin: 0 8px;" />
                <i class="fas fa-user-circle fa-2x" style="vertical-align: middle;"></i>
            </div>
        </div>
        <div class="container pb-5">

            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center fw-bolder lh-base" style="color: #FFF;">
                        Que souhaites-tu faire <br />
                        aujourd'hui ?
                    </h1>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-4 mt-4">
                    <a class="type-block" href="#" data-bs-toggle="modal" data-bs-target="#createFictionModal">
                        <div>
                            Un film de fiction
                        </div>
                        <div>
                            Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mt-4">
                    <a class="type-block blured" href="#">
                        <div>
                            Dans le vent
                        </div>
                        <div>
                            Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mt-4">
                    <a class="type-block blured" href="#">
                        <div>
                            Dans le vent
                        </div>
                        <div>
                            Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné
                        </div>
                    </a>
                </div>
            </div>

            <div class="row mt-5">

                <div class="col-md-4 mt-4">
                    <a class="type-block blured" href="#">
                        <div>
                            Dans le vent
                        </div>
                        <div>
                            Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mt-4">
                    <a class="type-block blured" href="#">
                        <div>
                            Dans le vent
                        </div>
                        <div>
                            Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mt-4">
                    <a class="type-block blured" href="#">
                        <div>
                            Dans le vent
                        </div>
                        <div>
                            Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné Créé un film de fiction sur la thématique
                            de ton choix en étant accompagné
                        </div>
                    </a>
                </div>

            </div>

        </div>
    </div>


    <!-- Create Fiction Modal -->
    <div class="modal fade" id="createFictionModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content pb-2" style="background: #3c3d5f;">
                <div class="modal-body text-white">
                    <div style="text-align: right;">
                        <button class="btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times text-white fa-2x"></i>
                        </button>
                    </div>
                    <h2 class="pt-3">
                        Créer un nouveau projet
                    </h2>

                    <form method="POST" action="/student/student-create">
                        @csrf
                        <input type="hidden" name="redirect_url" value="/student/creer-projet-action-individuel" />
                        <input type="hidden" name="owner_type" value="student" />
                        <input type="hidden" name="classe" value="classe 1" />
                        <input type="hidden" name="type" value="fiction" />
                        <label class="form-label mt-4 fs-5">Titre</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control rounded-3" name="nom" required>
                        </div>

                        <label class="form-label fs-5">Description</label>
                        <div class="input-group mb-3">
                            <textarea class="form-control rounded-3" rows=3 style="resize: none;"></textarea>
                        </div>

                        <div class="text-end mt-5">
                            <button type="submit" class="btn btn-orange btn-lg rounded-3">Suivant</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

    @if (request()->input('p', false))
        <!-- Modal -->
        <div class="modal fade" id="creationSuccessModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content pb-2" style="background: #3c3d5f;">
                    <div class="modal-body text-white">
                        <h2 class="mt-2">
                            Projet créé

                            <button class="btn float-end" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times text-white fa-2x"></i>
                            </button>
                        </h2>

                        <div class="text-center mt-5" style="margin-bottom: 64px;">
                            <i class="fas fa-check-circle fa-10x"
                                style="color: #de813b; background: radial-gradient(ellipse at center,  #FFF 50%, #3b3e5e 51%);"></i>
                            <div class="mt-3">
                                <span class="fs-1 d-block">Super !</span>
                                <span class="fs-4 d-block fw-light">Ton projet a été créé, tu peux commencer dès
                                    maintenant ou y revenir plus tard</span>
                            </div>
                        </div>

                        <div class="text-end">
                            <a class="btn btn-orange btn-lg rounded-3"
                                href="/student/action?c=0&p={{ request()->input('p') }}" style="margin-right: 48px;">Je
                                passe à l'ACTION!</a>
                            <button class="btn btn-lg btn-outline-light rounded-3"
                                data-bs-dismiss="modal">Terminé</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#creationSuccessModal").modal('show');
            });
        </script>
    @endif



</body>

</html>
