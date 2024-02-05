<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FaisTonFilm') }}</title>


    <style>
  
            form input {
                text-align: center;
                font-family: 'Ubuntu';
                border: none;
                border-bottom: 2px solid rgba(200, 200, 200, 0.2);
                width: 80%;
                caret-color: #3b3e5e;
            }

            form input:focus {
                outline: none;
                border-bottom: 2px solid rgba(74, 77, 119, 0.541);
            }

            form input:focus::placeholder {
                color: #FFF;
            }

            form input::placeholder {
                color: #000;
                opacity: 1;
            }

        
        @font-face {
            font-family: 'Ubuntu';
            src: url({{ storage_path('fonts/CourierPrime-Regular.ttf') }}) format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Ubuntu';
            src: url({{ storage_path('fonts/CourierPrime-Italic.ttf') }}) format("truetype");
            font-weight: normal;
            font-style: italic;
        }

        @font-face {
            font-family: 'Ubuntu';
            src: url({{ storage_path('fonts/CourierPrime-Bold.ttf') }}) format("truetype");
            font-weight: bold;
            font-style: normal;
        }

        @font-face {
            font-family: 'Ubuntu';
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
            font-family: 'Ubuntu', sans-serif;
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
            font-family: 'Ubuntu', sans-serif;
            text-transform: uppercase;
            margin-bottom: 8px;
            text-align: center;
            letter-spacing: 1px;
        }

        .ecrit-par {
            font-size: 13pt;
            font-family: 'Ubuntu', sans-serif;
        }

        .page-break {
            page-break-after: always;
        }
        table {
            width: 100%;
            height: 80%;
            font-family: 'Ubuntu', sans-serif;
            font-size: 12px;
            border-collapse: collapse;
        }

        table td {
            font-family: 'Ubuntu', sans-serif;
            font-size: 12px;
            border: 1px solid black;
            padding: 10px; /* Adjust the padding as needed */
        }

    </style>

</head>

<body>
    @guest
    @else
    <div class="page-cover">
            <div class="title-container">
           
                <div class="titre-film">Planning de tournage</div>
            
            </div>
        </div>

        <div style="clear:both;"></div>
        <div class="page-break"></div>
        @php
$t = 1;
@endphp
    @if(!empty($jours))
        @foreach ($jours as $jour)


        <div style="font-size: 12pt;">

            <div id="scenario-container" class="d-flex flex-column h-100">

                <div id="sequences">
                <div class="titre-film">Planning de tournage</div>
                    @php
                        $scenario = json_decode($action->scenario);
                        $sequences = $scenario->sequences;
                        $index = 0;
                        $limit = 0;
                    @endphp
               
             
                

<table>
    <tr>
        <td colspan="8"> Jour {{$t}} : {{ date('d/m/Y', strtotime($jour->jours)) }}</td>
    <tr>
    <tr>
        <td >
            SÉQ N° 
        </td>
        <td  >
        PLAN 
        </td>
        <td  >
        DÉCOR
        
        </td>
        <td>
        LIEU 
        </td>
    
        <td >
        DESCRIPTION DE L’ACTION 
        </td>
        <td >
        SUJET
        </td>
        <td >
        P.A.T
        </td>
        <td >
        TEMPS DE TOURNAGE 
        </td>
    </tr>


    @php
            $h1 = strtotime($action->pat);
            $test = "O";
            $durée = "00:00:00";
            $trajet ="00:10:00";
            $limit  = 0;
            @endphp

@foreach ($decoupages_p as $decoupage)
    @if($decoupage->jours == $jour->jours)
        <tr>
            <td>{{$decoupage->sequence_id}}</td>
            <td>{{$decoupage->plan}}</td>
            <td>{{$decoupage->lieu}}</td>
            <td>{{$decoupage->decors}}</td>
                <td>
            @php
            $descriptions = json_decode($decoupage->description);
            @endphp
            @if(!empty($descriptions[0]))
            {{$descriptions[0]}}
            @endif

            </td>
            <td>
            @php
            $personnages = json_decode($decoupage->sur);
            @endphp
              @if(!empty($personnages))
            @foreach ($personnages as $personnage)
               
            {{$personnage}}
            <br>
            @endforeach
                @endif
            </td>
            <td>
                    @if($test == $decoupage->lieu && strtotime($h1) >= strtotime($action->pat) )
                    {{ ucfirst($h1 = gmdate("H:i:s", strtotime($h1) + strtotime($durée))) }}
                    @elseif(strtotime($h1) < strtotime($action->pat) ) 
                    {{ ucfirst($h1 = gmdate("H:i:s", strtotime($action->pat)  )) }}
                    @else
                    {{ ucfirst($h1 = gmdate("H:i:s", strtotime($h1) + strtotime($durée) + strtotime($trajet) )) }}
                    @endif
                    </td>
                    <td>

                    {{$decoupage->durée}}
                    @php

            $test = $decoupage->lieu;
            $durée = $decoupage->durée;
            $trajet = $decoupage->trajet;
 
            @endphp
                    </td>
                </tr>
                @endif
                @php 
                    $fin = gmdate("H:i:s", strtotime("01:00:00") + strtotime($h1));
                
                    @endphp
                @if($h1 > $action->déjeuner &&  $h1 < $fin && $limit == 0)
                    <tr>
                        <td colspan="8">
                        <br>
                        Pause déjeuner de {{$h1}} à {{$fin}}
                        <br>
                        <br>

                        </td>
                    </tr>
                    @php
                    $h1 = $fin;
                    $limit = 1;
                    @endphp
                @endif

            @endforeach
         
        </table>
        <br>
        <br>
      

      

                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
 <div class="page-break"></div>

 @php
$t++;
@endphp 
@endforeach
@endif

        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $page_number = $pdf->get_page_number();
                    if($PAGE_NUM > 1){
                        $pdf->text(520, 820, "Page ".($PAGE_NUM-1)."/".($PAGE_COUNT-1), "Ubuntu", 12, array(0,0,0));
                    }
                ');
            }
        </script>

    @endguest

</body>

</html>

