@extends('student.layouts.page', ['contentBackground' => '#33395e'])

@section('content')
    <div class="container-fluid">

        <div style="font-weight: bolder; font-size: 20px; margin: 16px 0 0;  color: #b5bdda;"> Mon parcours </div>
        <div style="font-weight: lighter; font-size: 28px; margin-bottom: 16px;  color: #FFF;"> Cinéaste débutant </div>

        <div style="border-radius: 10px; border: 1px solid #D5972B; padding: 16px 32px;">
            <div style="font-weight: bolder; font-size: 20px; margin: 16px 0 0;  color: #FFF;"> Création d'un court métrage
                de fiction </div>
            <div style="font-weight: bolder; font-size: 14px; margin: 8px 0 16px;  color: #FFF;"> Comment créer un court
                métrage prêt à être envoyé en festival </div>

            <div class="row" style="margin-bottom: 32px;">

                <div class="col-md-4">
                    <a href="#" class="tuile-parcours">
                        <img src="{{ asset('images/movie.jpg') }}" />
                        <div class="titre">Le metier de réalisateur</div>
                        <div class="text">Découvrez le métier de réalisateur, études, salaire ...</div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="tuile-parcours">
                        <img src="{{ asset('images/movie.jpg') }}" />
                        <div class="titre">Gérez un court métrage</div>
                        <div class="text">Créez un court métrage de fiction digne des plus grands réalisateurs</div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="tuile-parcours">
                        <img src="{{ asset('images/movie.jpg') }}" />
                        <div class="titre">Interview de Julie</div>
                        <div class="text">Cheffe opératrice, elle nous explique son métier</div>
                    </a>
                </div>


            </div>

            <div class="row" style="margin-bottom: 32px;">

                <div class="col-md-4">
                    <a href="#" class="tuile-parcours">
                        <img src="{{ asset('images/movie.jpg') }}" />
                        <div class="titre">Termes cinématographiqes</div>
                        <div class="text">&nbsp;</div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="tuile-parcours">
                        <img src="{{ asset('images/movie.jpg') }}" />
                        <div class="titre">Atelier</div>
                        <div class="text">Pitcher une idée qui plaira à tous les coups!</div>
                    </a>
                </div>


            </div>

        </div>


    </div>
@endsection
