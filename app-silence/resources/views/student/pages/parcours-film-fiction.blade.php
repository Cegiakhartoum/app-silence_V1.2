@extends('student.layouts.page-cours', ['contentBackground' => '#161c30'])



@section('content')
    <div class="container">

    <div class="row">
            <div class="col-md-12 text-center">
                <div>
                    <span class="orange-text" style="font-size: 1.3rem;"> Parcours {{$atelier['format']}} </span>
                </div>
                <div style="font-size: 3rem; color: #FFF;">
                {{$atelier['phrase_accroche']}}
                </div>
            </div>
        </div>

        <div class="row">
        @php
    use App\Http\Controllers\Productrice\AtelierController;
    $AtelierCtrl = new AtelierController();

@endphp
<div class="col-md-12">
@foreach ($atelier_partis as $p)
@if($p['public_cible'] == 'Tous public' || $p['public_cible'] == 'Hors Gar' )
        <div style="margin-top: 24px;">
            <span class="orange-text"> Partie </span>
        </div>
        <div style="font-size: 2rem; color: #FFF; margin: 8px 0;">
      {{ $p['name'] }} 
</div>
    @php
        $chapters = $AtelierCtrl->findChapitre($p['id']);
    @endphp
    @foreach ($chapters as $chapter)
    @if($chapter['public_cible'] == 'Tous public' || $chapter['public_cible'] == 'Hors Gar' )
        <a href="/student/cours?c={{$chapter['cours_id']}}"
                                style="{{ isset($chapter['isDisabled']) ? 'filter: blur(1.5px);' : '' }}">
        <div class="chapitre-cours">
                    <div>
                        <div>
                            <span style="margin-left: 2px; margin-right: 32px; background: rgba(255,255,255,0.3); border-radius:4px; padding:1px 8px;">
                                Chapitre
                            </span>
                            <span class="orange-text"> Durée : {{$chapter['duration'] }} </span>
                        </div>
                        <div style="font-size: 1.2rem; color: #FFF; margin-top: 8px;">
                            <div style="outline: none;">
                                {{$chapter['name'] }}
                            </div>
                        </div>
                        <div style="color: #aaa; margin-top: 8px;">
                            <div style="outline: none;">
                                {{$chapter['description'] }}
                            </div>
                        </div>
                    </div>
                   
                </div>
        </a>

            <div>
            </div>
                    <br>
       @endif
       @endforeach

       @endif
    @endforeach
</div>

                   
            </div>
        </div>

    </div>
@endsection
