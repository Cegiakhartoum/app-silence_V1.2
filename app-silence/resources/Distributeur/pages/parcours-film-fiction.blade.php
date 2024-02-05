@extends('student.layouts.page-cours', ['contentBackground' => '#161c30'])

@php

// $parts = config('z-courses');
$cours = config('z-courses');

$parts = array();

foreach ($cours as $key => $item) {
   $parts[$item['partie']][$key] = $item;
}

@endphp

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12 text-center">
                <div>
                    <span class="orange-text" style="font-size: 1.3rem;"> Parcours film de fiction </span>
                </div>
                <div style="font-size: 3rem; color: #FFF;">
                    Créer un film de fiction digne des plus grands réalisateurs
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @foreach ($parts as $p => $chapters)
                    <div style="margin-top: 24px;">
                        <span class="orange-text"> Partie </span>
                    </div>
                    <div style="font-size: 2rem; color: #FFF; margin: 8px 0;">
                        {{ $p }}
                    </div>
                    @foreach ($chapters as $c => $chapter)
                        @if (isset($chapter['isAction']))
                        @else
                            <a href="{{ isset($chapter['isDisabled']) ? '' : '/student/cours?c=' . $c }}"
                                style="{{ isset($chapter['isDisabled']) ? 'filter: blur(1.5px);' : '' }}">
                                <div class="chapitre-cours">
                                    <div>
                                        <div>
                                            <span
                                                style="margin-left: 2px; margin-right: 32px; background: rgba(255,255,255,0.3); border-radius:4px; padding:1px 8px;">
                                                Chapitre
                                            </span>
                                            <span class="orange-text"> Durée : {{ $chapter['duration'] }} </span>
                                        </div>
                                        <div style="font-size: 1.2rem; color: #FFF; margin-top: 8px;">
                                            {{ $chapter['chapitre'] }}
                                        </div>
                                        <div style="color: #aaa; margin-top: 8px;">
                                            {{ $chapter['description'] ?? "" }}
                                        </div>
                                    </div>
                                    {{-- <div class="avancement-cours">
                                {{$chapter["completion"]}}%
                            </div> --}}
                                </div>
                            </a>
                        @endif
                    @endforeach
                @endforeach

            </div>
        </div>

    </div>
@endsection
