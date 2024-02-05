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

        @php
                    $scenario = json_decode($action->scenario);
             
                @endphp
    @if(empty( $scenario->personnages))  
@else
   @foreach ($scenario->personnages as $personnage)
                @php
                $index = 0;
                @endphp
      

        <div style="font-size: 12pt;">

            <div id="scenario-container" class="d-flex flex-column h-100">

                <div id="sequences">

                   
               
                    <div class="titre-film">DÉPOUILLEMENT PERSONNAGE</div>
      
                    <br><br>
      
                    <table>
                <tr>
                    <td colspan="6">DÉPOUILLEMENT PERSONNAGE :  {{$personnage}}  
           
                    </td>
                </tr>
                <tr>
            
                    <td>N° SEQ </td>
                    <td>INT/EXT </td>
                    <td>JOUR/NUIT </td>
                    <td>DESCRIPTION DE L’ACTION</td>
                    <td>NOTES COSTUME ET ACCESSOIRES </td>
                    <td>NOTES MAQUILLAGE/COIFFURE</td>
                </tr>

                @foreach($scenario->sequences as $sequence)
                @php 
                $index++;
             
                 @endphp
                    @foreach(getSequencePersonnages($sequence) as $perso)
                    @php   $perso=trim($perso);
                            $personnage=trim($personnage);
                            $liste_acteurs = json_decode($action->depouillements);
                     @endphp
                    @if($perso == $personnage)
                                <tr>
                                    <td>{{ $index }}</td>
                                    <td>{{ $sequence->location}}</td>
                                    <td>{{  $sequence->time}}</td>
                                    <td>
                                  
                                            @foreach ($sequence->dialogues_descriptions as $keyIndex => $dialogue_description)
                                            @if ( ($dialogue_description->type) == 'description' )
                                                            {{$dialogue_description->value->description }}
                                                        @endif
                                            @endforeach
                                   

                                    </td>
      @if(empty($liste_acteurs)) 
   
                                  <td></td>
                                  <td></td>
                                  
                                </tr>

            @else
                @foreach($liste_acteurs as $depouille)
                    @php  
                    $perso=trim($depouille->personnage);
                    $personnage=trim($personnage);         
                    @endphp
                    @if($depouille->personnage == $personnage && $depouille->sequence_id == $index)
                    <td>{{$depouille->note_acs}}</td>
                    <td>{{$depouille->note_maq}}</td>
                     </tr>
                    @endif
                @endforeach
            @endif
      @endif
 @endforeach
  @endforeach
       
        </table>

        <br>
        <br>

                   

                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
 <div class="page-break"></div>

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
