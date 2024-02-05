<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FaisTonFilm') }}</title>

    <?php
        
        function buildSequencePersonnagesOptions($personnages, $selectedPersonnage)
        {
            $result = '';
            foreach ($personnages as $personnage) {
                $checked = trim($personnage) === trim($selectedPersonnage) ? 'selected="selected"' : '';
                $result .= '<option value="' . trim($personnage) . '" ' . $checked . ' >' . trim($personnage) . '</option>';
            }
            return $result;
        }
        
        function getSequencePersonnages($sequence)
        {
            $personnages = [];
        
            foreach ($sequence->dialogues_descriptions as $dialogue) {
                if (isset($dialogue->value->personnage)) {
                    array_push($personnages, $dialogue->value->personnage);
                }
            }
        
            foreach ($sequence->personnages as $personnage) {
                array_push($personnages, $personnage);
            }
        
            return array_unique($personnages);
        }
        
       
        
        ?> 
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
           
                <div class="titre-film">{{ $action->titre_oeuvre ?? "Titre de l'oeuvre" }}</div>
            
            </div>
        </div>

        <div style="clear:both;"></div>
        <div class="page-break"></div>

        @php
$datas = json_decode($action->personna);
$i = 1;
@endphp
                <br>
                @if (!empty($datas))
            @foreach($datas as $data) 

        <div style="font-size: 12pt;">

            <div id="scenario-container" class="d-flex flex-column h-100">

                <div id="sequences">
               
     
      
       
<h4 class="text-center font-weight-bolder action-title"> Personna {{$i}} </h4>
<br>
            <table>
                 
                <tr>
                        <td>
                            <div>Nom</div>
                          
                        </td>
                        <td>
                          {{ $data->nom ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Sexe</div>

                        </td>
                        <td>
                           {{ $data->sexe ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Âge</div>
                          
                        </td>
                        <td>
                            {{ $data->age ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Situation géographique</div>

                        </td>
                        <td>
                           {{ $data->situation ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Profession</div>
                          
                        </td>
                        <td>
                           {{ $data->préparation ?? '' }}
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:140px;">
                            <div>Centres d'intérêt</div>

                        </td>
                        <td>
                           {{ $data->centre ?? '' }}
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:140px;">
                            <div>Problèmes</div>
                          
                        </td>
                        <td>
                            {{ $data->probléme ?? '' }}
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:140px;">
                            <div>Objectifs</div>

                        </td>
                        <td>
                           {{ $data->objectifs ?? '' }}
                        </td>
                    </tr>
                    <tr>
                    <td style="width: 30%; height:140px;">
                            <div>Comportement en ligne</div>
                        </td>
                        <td>
                            {{ $data->comportement ?? '' }}
                        </td>
                    </tr>
            </table>
            <br>
       

                </div>
            </div>
        </div>


        @php
                $i++;
                @endphp
                <div style="clear:both;"></div>
        <div class="page-break"></div>

        @endforeach
 @endif
        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $page_number = $pdf->get_page_number();
                    if($PAGE_NUM > 1){
                        $pdf->text(520, 820, "Page ".($PAGE_NUM-1)."/".($PAGE_COUNT-1), "ubuntu", 12, array(0,0,0));
                    }
                ');
            }
        </script>

    @endguest

</body>

</html>
