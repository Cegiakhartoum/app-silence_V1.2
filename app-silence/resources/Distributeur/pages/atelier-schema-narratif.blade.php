@extends('student.layouts.page-atelier', ['contentBackground' => '#161c30'])

@section('sidebar')
    <div>
        <a href="/student/parcours-film-fiction">
            <span style="background: rgba(255,255,255,0.1); padding:8px 16px; color:#AAA; border-radius:4px;">
                <i class="fas fa-arrow-left"></i>
            </span>
        </a>

        <span class="orange-text"
            style="margin-left: 16px; background: rgba(255,255,255,0.3); border-radius:4px; padding:1px 8px;">
            Cours
        </span>
    </div>
    <div style="font-weight: lighter; font-size: 20px; margin: 8px 0 32px 64px;  color: #FFF;"> Le schéma narratif </div>

    <div>
        <i class="fab fa-youtube orange-text fa-2x" style="margin-right: 5px; vertical-align: middle;"></i>
        <span class="orange-text"> Le schéma narratif </span>
    </div>

    <div style="padding: 8px 0px 8px 16px; color:#FFF;">
        <span style="margin-right: 5px; vertical-align: middle;"> 1,30'</span>
        <span class="orange-text"> Qu'est ce que le schéma narratif ?</span>
    </div>

    <div style="padding: 8px 0px 8px 16px; color:#FFF;">
        <span style="margin-right: 5px; vertical-align: middle;"> 2,30'</span>
        <span class="orange-text"> La situation initiale ?</span>
    </div>

    <div style="padding: 8px 0px 8px 16px; color:#FFF;">
        <span style="margin-right: 5px; vertical-align: middle;"> 3,00'</span>
        <span class="orange-text"> L'élément pertubateur ?</span>
    </div>

    <div style="padding: 8px 0px 8px 16px; color:#FFF;">
        <span style="margin-right: 5px; vertical-align: middle;"> 3,00'</span>
        <span class="orange-text"> Les péripéties</span>
    </div>

    <div style="padding: 8px 0px 8px 16px; color:#FFF;">
        <span style="margin-right: 5px; vertical-align: middle;"> 3,00'</span>
        <span class="orange-text"> Élement de résolution </span>
    </div>

    <div style="padding: 8px 0px 8px 16px; color:#FFF;">
        <span style="margin-right: 5px; vertical-align: middle;"> 3,00'</span>
        <span class="orange-text"> La situation finale</span>
    </div>

    <div style="padding: 8px 0px 8px 16px; color:#FFF;">
        <span style="margin-right: 5px; vertical-align: middle;"> 3,00'</span>
        <span class="orange-text"> Quelques conseils pour écrire un bon schéma narratif</span>
    </div>

    <div>
        <a href="/student/atelier-schema-narratif-recap">
            <i class="far fa-file fa-2x"
                style="margin-right: 5px; margin-bottom:8px; vertical-align: middle; background-color: #D5972B; color: #FFF; padding:4px; border-radius: 5px;"></i>
            <span class="orange-text"> Récap' schéma narratif </span>
        </a>
    </div>

    <div>
        <i class="far fa-file fa-2x"
            style="margin-right: 5px; vertical-align: middle; background-color: #5587b3; color: #FFF; padding:4px; border-radius: 5px;"></i>
        <span class="orange-text"> Schéma narratif à compléter </span>
    </div>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <img src="{{ asset('images/atelier-1.png') }}" style="width: 100%;" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div
                    style="color: #FFF; background-color: #c2a58d; padding: 16px; text-align:center; margin: 8px 0px; border-radius:5px; font-size:1.5rem;">
                    Écris ton schéma narratif dans ACTION !
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div
                    style="color: #FFF; background-color: #32325e; padding: 16px; text-align:center; margin: 8px 0px; border-radius:5px; font-size:1.5rem;">
                    <span style="font-size: 70%; display:block; opacity:70%;"> Passer au cours suivant</span>
                    Le synopsis
                </div>
            </div>
        </div>

    </div>
@endsection
