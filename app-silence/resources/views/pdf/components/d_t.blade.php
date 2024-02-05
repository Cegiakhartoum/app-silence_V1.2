<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/action.css') }}" rel="stylesheet"> --}}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FaisTonFilm') }}</title>

    <style>
        table {
            width: 80%;
            height: 80%;
            font-size: 10px;
        }

        table td {
            height: 30px;
            padding: 5px;
            border: 1px solid black;
        }

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
        @page {
            size: A4 landscape;
            margin: 32px 64px;
            height: 100%;
        }

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
                <div class="titre-film">Decoupage technique
                    <script></script>
                </div>
            </div>
        </div>

        <div style="clear:both;"></div>

        @if (!empty($decoupages_s))
            <div class="page-break"></div>

            <div style="font-size: 12pt;">

                <div id="scenario-container" class="d-flex flex-column h-100">

                    <div id="sequences">

                        @php
                            $scenario = json_decode($action->scenario);
                            $sequences = $scenario->sequences;
                            $index = 0;
                        @endphp

                        <table style="width:100%;">
                            <tr>

                                <td style="width:5%;">
                                    SÉQ N°
                                </td>
                                <td style="width:5%;">
                                    PLAN N°
                                </td>

                                <td style="width:5%;">
                                    LIEU
                                </td>
                                <td style="width:10%;">
                                    DESCRIPTION DE L'ACTION
                                </td>
                                <td style="width:5%;">
                                    ÉCHELLE
                                </td>
                                <td style="width:5%;">
                                    ANGLE
                                </td>
                                <td style="width:5%;">
                                    SUR
                                </td>
                                <td style="width:10%;">
                                    MOUVEMENT CAMÉRA
                                </td>
                                <td style="width:5%;">
                                    AUDIO
                                </td>
                                <td style="width:5%;">
                                    RACCORD
                                </td>
                            </tr>
                            @foreach ($decoupages_s as $decoupage)
                                <tr>
                                    <td>
                                        @foreach (explode(',', $decoupage->sequence_id) as $item)
                                            {{ trim($item) }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach (explode(',', $decoupage->plan) as $item)
                                            {{ trim($item) }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach (explode(',', $decoupage->lieu) as $item)
                                            {{ trim($item) }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if (is_string($decoupage->description) && is_array(json_decode($decoupage->description, true)))
                                            @foreach (json_decode($decoupage->description, true) as $item)
                                                {{ $item }}<br>
                                            @endforeach
                                        @else
                                            {{ $decoupage->description }}
                                        @endif
                                    </td>
                                    <td>
                                        @foreach (explode(',', $decoupage->echelle) as $item)
                                            {{ trim($item) }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach (explode(',', $decoupage->angle) as $item)
                                            {{ trim($item) }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if (is_string($decoupage->sur) && is_array(json_decode($decoupage->sur, true)))
                                            @foreach (json_decode($decoupage->sur, true) as $item)
                                                {{ $item }}<br>
                                            @endforeach
                                        @else
                                            {{ $decoupage->sur }}
                                        @endif
                                    </td>
                                    <td>
                                        @foreach (explode(',', $decoupage->mouvement) as $item)
                                            {{ trim($item) }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach (explode(',', $decoupage->audio) as $item)
                                            {{ trim($item) }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach (explode(',', $decoupage->raccord) as $item)
                                            {{ trim($item) }}<br>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach

                        </table>

                    </div>
                </div>
            </div>
        @endif
        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $page_number = $pdf->get_page_number();
                    if($PAGE_NUM > 1){
                        $pdf->text(820, 520, "Page ".($PAGE_NUM-1)."/".($PAGE_COUNT-1), "Courier", 12, array(0,0,0));
                    }
                ');
            }
        </script>

    @endguest

</body>

</html>

