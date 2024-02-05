<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FaisTonFilm') }}</title>

    <style>
        .form-control,
        .btn {
            box-shadow: none !important;
            outline: none !important;
        }

        .btn-check:checked+.btn-outline-primary {
            color: #FFF;
        }

        .action-sidebar .action-menu-item {
            padding: 12px 16px 12px 16px;
            width: 160px;
            text-align: center;
            line-height: 110%;
            font-size: 90%;
        }

        .action-sidebar .action-menu-item.active {
            border-left: 4px solid #d5972b;
            background: #e9d3ad;
            border-bottom-right-radius: 5px;
            border-top-right-radius: 5px;
            text-transform: uppercase;
            font-size: 78%;
        }

        .action-title {
            text-align: center;
            font-weight: bolder;
            font-size: 140%;
            text-transform: uppercase;
            font-family: Arial, Helvetica, sans-serif;
        }

        .action-subtitle {
            color: #999;
            font-size: 90%;
            text-align: center;
            font-weight: 500;
            margin-top: 64px;
            margin-bottom: 16px;
        }

        .action-textarea {
            border: 1px solid #eee;
            resize: none;
            padding: 8px;
        }

        .action-textarea:focus-visible {
            border: 1px solid rgba(74, 77, 119, 0.1);
            outline: none !important;
            box-shadow: 0 0 2px rgba(74, 77, 119, 0.3);
        }

        .help-button {
            color: #FFF;
            font-size: 3rem;
            cursor: pointer;
        }

        .small-help-button {
            color: #d5972b;
            font-size: 1.5rem;
            cursor: pointer;
            position: relative;
            bottom: 12px;
            right: 8px;
            margin-right: -8px;
        }

        .help-button[aria-describedby] {
            color: #7e82a2;
        }

        .popover {
            background: transparent;
            text-align: center;
            max-width: 600px;
        }

        .popover .arrow {
            display: none;
        }

        .popover-body {
            background: #c9cbd8;
            color: #000;
            border-radius: 5px;
        }

        .popover-orange .popover-body {
            background: #e7c384;
        }

        .modal-content {
            background: #9294aa;
            color: #FFF;
            border-radius: 24px;
        }

        .modal-backdrop.show {
            opacity: 0.97;
            background: #FFF;
        }

        .add-personnage-input {
            margin: 0 0 0 16px;
            display: inline-block;
            width: 300px;
        }

        .liste-personnage-item {
            display: inline-block;
        }
    </style>

    <style>
        @font-face {
            font-family: 'Courier';
            src: url({{ storage_path('fonts/CourierPrime-Regular.ttf') }}) format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Courier';
            src: url({{ storage_path('fonts/CourierPrime-Italic.ttf') }}) format("truetype");
            font-weight: normal;
            font-style: italic;
        }

        @font-face {
            font-family: 'Courier';
            src: url({{ storage_path('fonts/CourierPrime-Bold.ttf') }}) format("truetype");
            font-weight: bold;
            font-style: normal;
        }

        @font-face {
            font-family: 'Courier';
            src: url({{ storage_path('fonts/CourierPrime-BoldItalic.ttf') }}) format("truetype");
            font-weight: bold;
            font-style: italic;
        }

        @page {
            size: A4 portrait;
            margin: 32px 64px;
            height: 100%;
        }

        .sequence-scenario-container {
            padding: 32px 64px;
        }

        body {
            font-family: 'Courier', sans-serif;
        }

        .page-cover {
            text-align: center;
            height: 100%;
            position: relative;
        }

        .page-cover .title-container {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            height: 100px;

        }

        .titre-film {
            font-size: 30pt;
            font-family: 'Courier', sans-serif;
            text-transform: uppercase;
            margin-bottom: 8px;
            text-align: center;
            letter-spacing: 1px;
        }

        .ecrit-par {
            font-size: 13pt;
            font-family: 'Courier', sans-serif;
        }

        .page-break {
            page-break-after: always;
        }
    </style>

</head>



<body>
    @guest
    @else
        <div class="page-cover">
            <div class="title-container">
                <div class="titre-film">{{ $action->titre_oeuvre ?? "Titre de l'oeuvre" }}</div>
                <div class="ecrit-par">Écrit par : {{ $nom_auteur }}</div>
            </div>
        </div>

        <div style="clear:both;"></div>
        <div class="page-break"></div>

        <div style="font-size: 12pt;">

            <div id="scenario-container" class="d-flex flex-column h-100">

                <div id="sequences">

                   
               
                    <div class="titre-film">J'ORGANISE MON DISCOURS</div>
                    @php
                            $discours = json_decode($action->discours);
                    @endphp

                    <br><br>
                    @if(!empty($discours))
                    <table>

                    <tr>
                        <td>
                            <div>Situation Actuelle</div>
                          
                        </td>
                        <td>
                            <textarea name="situation" class="action-textarea w-100 h-100">{{$discours->situation}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Compétences et parcours scolaire</div>

                        </td>
                        <td>
                            <textarea name="compétences" class="action-textarea w-100 h-100">{{$discours->compétences}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Ce que tu apporterais dans l'entreprise</div>

                        </td>
                        <td>
                            <textarea name="apporterais" class="action-textarea w-100 h-100">{{$discours->apporterais}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Pourquoi tu veux rejoindre l'équipe</div>

                        </td>
                        <td>
                            <textarea name="pourquoi" class="action-textarea w-100 h-100">{{$discours->pourquoi}}</textarea>
                        </td>
                    </tr>

                </table>
                @endif
                 

                </div>
            </div>
        </div>
        
        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $page_number = $pdf->get_page_number();
                    if($PAGE_NUM > 1){
                        $pdf->text(520, 820, "Page ".($PAGE_NUM-1)."/".($PAGE_COUNT-1), "Courier", 12, array(0,0,0));
                    }
                ');
            }
        </script>

    @endguest

</body>

</html>
