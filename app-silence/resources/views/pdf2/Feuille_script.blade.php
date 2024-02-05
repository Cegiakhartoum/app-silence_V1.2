<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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


    @if(!empty($jours))
        @php
            $f = 1;
        @endphp
        @foreach ($jours as $jour)
            @foreach ($decoupages_p as $decoupage)
                @if($decoupage->jours == $jour->jours)
                    @php  $l = 1; @endphp
                    <div style="font-size: 12pt;">
                        <div id="scenario-container" class="d-flex flex-column h-100">
                            <div id="sequences">
                                <br><br>
                                <table>
<tr style="text-align:center; height:70px;">
            <td colspan="7">FEUILLE DE SCRIPT  </td>
        </tr>
        <tr>
            <td colspan="1">Titre </td>
            <td colspan="5">{{$action->titre_oeuvre}} </td>
            <td colspan="1">MEILLEURE PRISE </td>
        </tr>
        <tr>

            
            <td colspan="1">Feuille de <br> tournage n° </td>

        <td colspan="1" > {{$f}}</td>
        @php $f = $f + 1; @endphp
            <td colspan="1">Séquence n°  </td>
            <td colspan="1"> {{ $decoupage->sequence_id }}</td>
            <td colspan="1">Carte mémoire n° </td>
            <td colspan="1" ></td>
            <td colspan="1" ></td>
        </tr>
        <tr>
            <td colspan="1">Date</td>
            <td colspan="1" >  {{date('d/m/Y', strtotime($decoupage->jours )) }}</td>
            <td colspan="1">Plan n° </td>
            <td colspan="1"> {{ $decoupage->plan }}</td>
            <td colspan="1">Décor</td>
            <td colspan="1" >  {{ $decoupage->lieu }}</td>
            <td colspan="1" style="border-top:1px solid  transparent;"></td>
        </tr>
    
      

        <tr>
            <td colspan="4">Description de l'action </td>
            <td colspan="1">Échelle  </td>
            <td colspan="1">Angle</td>
            <td colspan="1">Mouvement </td>
        </tr>

        <tr>
            <td colspan="4"> {{ $decoupage->description }}</td>
            <td colspan="1">{{ $decoupage->echelle }}</td>
            <td colspan="1">{{ $decoupage->angle }}</td>
            <td colspan="1">{{ $decoupage->mouvement }}</td>
        </tr>

        <tr style="text-align:center; height:100px;">
            <td colspan="7">  OBSERVATIONS (+/-) </td>
        </tr>
        <tr>
            <td colspan="1">PRISE N° </td>
            <td colspan="1">ACTION </td>
            <td colspan="1">IMAGE</td>
            <td colspan="1">SON</td>
            <td colspan="3">COMMENTAIRE</td>
        </tr>
@while($l < 16)
        <tr>
            <td colspan="1">{{$l}}</td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="3"></td>
        </tr>
       @php $l++; @endphp
       @endwhile
       </table>
                                <br><br>
                                <div style="clear:both;"></div>
                                <div class="page-break"></div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endforeach
    @endif


    <script type="text/php">
    if (isset($pdf)) {
        $pdf->page_script('
            $page_number = $pdf->get_page_number();
            if ($PAGE_NUM > 1 && $PAGE_NUM <= $PAGE_COUNT) {
                $pdf->text(520, 820, "Page " . ($PAGE_NUM - 1) . "/" . ($PAGE_COUNT - 1), "Ubuntu", 12, array(0, 0, 0));
            }
        ');
    }
</script>

    @endguest
</body>

</html>