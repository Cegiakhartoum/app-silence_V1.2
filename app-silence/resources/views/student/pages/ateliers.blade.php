@extends('student.layouts.page', ['contentBackground' => '#161c30'])

@section('content')

    <div class="container-fluid">

        <div class="text-center" style="padding: 64px 0 32px; color: #FFF; font-size: 32px;">
            Votre espace d'apprentissage, <span style="color: #eb5887">{{ Auth::user()->name }}</span>
        </div>

        <div style="font-weight: lighter; font-size: 34px; margin: 16px 0 32px; color: #FFF;"> Les ateliers ! </div>

        <div class="row">

            @foreach($ateliers as $atelier)
                @if($atelier['enligne'] == 1 && ($atelier['public_cible'] == 'Tous public' || $atelier['public_cible'] == 'Hors Gar'))
                    <div class="col-md-4 mb-3">
                        <a href="/teacher/parcours-film-fiction/{{$atelier['id']}}" class="tuile-ateliers">
                            <div class="titre">{{$atelier['phrase_accroche']}}</div>
                            <img src="{{$atelier['image']}}" class="img-fluid" alt="{{$atelier['phrase_accroche']}}">
                        </a>
                    </div>
                @endif
            @endforeach

            @foreach($ateliers as $atelier)
                @if($atelier['enligne'] == 0 && ($atelier['public_cible'] == 'Tous public' || $atelier['public_cible'] == 'Hors Gar'))
                    <div class="col-md-4 mb-3">
                        <a href="#" class="tuile-ateliers">
                            <div class="titre">{{$atelier['phrase_accroche']}}</div>
                            <img src="{{asset("images/student-blur.jpg")}}" class="img-fluid" alt="{{$atelier['phrase_accroche']}}">
                        </a>
                    </div>
                @endif
            @endforeach

        </div>

    </div>

@endsection
