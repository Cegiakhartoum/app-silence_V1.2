@extends('student.layouts.page', array('contentBackground' => '#161c30') )

@section('content')

    <div class="container-fluid">

        <div style="text-align: center; padding: 64px 0 32px; color: #FFF; font-size: 32px;">
            Votre espace d'apprentissage, <span style="color: #eb5887">{{ Auth::user()->name }}</span>
        </div>

        <div style="font-weight: lighter; font-size: 34px; margin: 16px 0 32px;  color: #FFF;"> Les ateliers ! </div>

        <div>

            <div class="row" style="margin-bottom: 32px;">

                <div class="col-md-4">
                    <a href="/student/parcours-film-fiction" class="tuile-ateliers">
                        <div class="titre">Créer un film de fiction digne des plus <br/> grands réalisateurs</div>
                        <img src="{{asset("images/vignette - Scotty & georgia .jpg")}}"/>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="tuile-ateliers">
                        <div class="titre">Réaliser une interview comme au JT</div>
                        <img src="{{asset("images/student-blur.jpg")}}"/>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="tuile-ateliers">
                        <div class="titre">Réaliser un CV vidéo, embauche garantie!</div>
                        <img src="{{asset("images/student-blur.jpg")}}"/>
                    </a>
                </div>

            </div>

            <div class="row" style="margin-bottom: 32px;">

                <div class="col-md-4">
                    <a href="#" class="tuile-ateliers">
                        <div class="titre">Pitcher comme un pro</div>
                        <img src="{{asset("images/student-blur.jpg")}}"/>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="tuile-ateliers">
                        <div class="titre">Une web TV comme les plus grandes chaînes <br/> de télévision!</div>
                        <img src="{{asset("images/student-blur.jpg")}}"/>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="tuile-ateliers">
                        <div class="titre">Montrer à tous ce que je fais !</div>
                        <img src="{{asset("images/student-blur.jpg")}}"/>
                    </a>
                </div>

            </div>

        </div>


    </div>

@endsection
