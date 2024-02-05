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
                <div class="titre-film">{{ $action->titre_oeuvre ?? "$projet->nom" }}</div>
  
            </div>
        </div>

        <div style="clear:both;"></div>
      
        <div class="page-break"></div>

 <div class="page-cover">
            <div class="title-container">
                <div class="titre-film">MES IDEES</div>
            </div>
        </div>

        <div style="clear:both;"></div>
        <div class="page-break"></div>

        <div style="font-size: 12pt;">

            <div id="scenario-container" class="d-flex flex-column h-100">

                <div id="sequences">         
      
                <br><br>
                <pre style="white-space: pre-wrap; font-family: 'Ubuntu', sans-serif;">{{ $action->idées ?? '' }}</pre>
                   

                </div>
            </div>
        </div>
<div style="clear:both;"></div>

<div class="page-break"></div>
        <div class="page-cover">
                    <div class="title-container">
                        <div class="titre-film">J'ORGANISE MON DISCOURS</div>
                    </div>
         </div>

        <div style="clear:both;"></div>
        <div class="page-break"></div>

        <div style="font-size: 12pt;">

            <div id="scenario-container" class="d-flex flex-column h-100">

                <div id="sequences">

            
   
      
                @php
                            $discours = json_decode($action->discours);
                    @endphp

                    <br><br>
                    @if(!empty($discours))
                    <table>

                    <tr>
                        <td>
                            <div>Situation actuelle</div>
                          
                        </td>
                        <td>
{{$discours->situation}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Compétences et parcours scolaire</div>

                        </td>
                        <td>
{{$discours->compétences}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Ce que tu apporterais dans l'entreprise</div>

                        </td>
                        <td>
{{$discours->apporterais}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Pourquoi tu veux rejoindre l'équipe</div>

                        </td>
                        <td>
{{$discours->pourquoi}}
                        </td>
                    </tr>

                </table>
                @endif

                </div>
            </div>
        </div>
<div style="clear:both;"></div>
@if (!empty($action->scenario))
            <div class="page-break"></div>

            <div class="page-cover">
                <div class="title-container">
                    <div class="titre-film">Scenario</div>
                    <div class="ecrit-par">Écrit par : {{ $nom_auteur }}</div>
                </div>
            </div>

            <div style="clear:both;"></div>

            <div class="page-break"></div>

            <div style="font-size: 12pt;">

                <div id="scenario-container" class="d-flex flex-column h-100">

                    <div id="sequences">

                        <br><br>
                        @php
                            $scenario = json_decode($action->scenario);
                            $sequences = $scenario->sequences;
                            $index = 0;
                        @endphp

                        @foreach ($sequences as $sequence)
                            @php $index++; @endphp
                            <div id="sequence-{{ $index }}" class="sequence-scenario-container">
                                <div class="pb-3">
                                    <div style="page-break-inside: avoid;">
                                        <div style="text-transform: uppercase; margin-bottom: 8px;">
                                            {{ $index }}. {{ $sequence->location ?? '' }} - {{ $sequence->lieu }}
                                            - {{ $sequence->time ?? '' }}
                                        </div>
                                        <div>
                                            (<span style="text-transform: uppercase;">
                                                {{ implode(', ', $sequence->personnages) }}
                                            </span>)
                                        </div>
                                    </div>
                                    @foreach ($sequence->dialogues_descriptions as $dialogue_description)
                                        @if ($dialogue_description->type === 'description')
                                            @if (isset($dialogue_description->value->description) && !empty($dialogue_description->value->description))
                                                <div
                                                    style="padding-top: 32px; text-align: justify; page-break-inside: avoid;">
                                                    {{ $dialogue_description->value->description }}
                                                </div>
                                            @endif
                                        @elseif ($dialogue_description->type === 'dialogue')
                                            <div style="padding-top: 32px; page-break-inside: avoid;">
                                                <div style="padding: 0 16px 0 64px;">
                                                    <div style="padding-left: 32px; margin-bottom: 10px;">
                                                        <span
                                                            style="text-transform: uppercase;">{{ $dialogue_description->value->personnage }}
                                                        </span>
                                                        @if (isset($dialogue_description->value->emotion) && !empty($dialogue_description->value->emotion))
                                                            (<em>{{ $dialogue_description->value->emotion }}</em>)
                                                        @endif
                                                    </div>
                                                    <div>
                                                        {{ $dialogue_description->value->dialogue }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div style="clear:both;"></div>
            <div class="page-break"></div>

        <div class="page-cover">
            <div class="title-container">
            <div class="titre-film">LIEUX DE TOURNAGE</div>
            </div>
        </div>

        <div style="clear:both;"></div>

            <div class="page-break"></div>
            <div style="font-size: 12pt;">

            <div id="scenario-container" class="d-flex flex-column h-100">

                <div id="sequences">
      
                    <br><br>
                    <table>
            <tr>
                <td style="width:10%;" >
                    SÉQ N° 
                </td>
                <td style="width:25%;">
                    DÉCOR
                </td>
            
                <td >
                    LIEU 
                </td>
                <td style="width:15%;">
                    JOUR DE TOURNAGE 
                </td>
            </tr>
           
	@php
          $hop="";
          @endphp
            @foreach ($decoupages_l as $decoupage)
                <tr>
                    <td>
                 @foreach ($decoupages_s as $decoupag)
                
                    @if($decoupag->lieu == $decoupage->lieu && $hop != $decoupag->sequence_id )
                 		
                                {{ $decoupag->sequence_id}} 
                      @php
          $hop=$decoupag->sequence_id;
          @endphp
                     
                      
                    @endif
                    @endforeach

                    </td>
                    @php
                    $t=0;

                    @endphp
                    <td>{{ $decoupage->lieu}}

                    <input type="hidden" name="lieu_add[]" value="{{$decoupage->lieu}}">
                    </td>
                    @foreach ($decoupages_s as $decoupag)
                  
                    @if($t < 1 )
                    @if($decoupag->lieu == $decoupage->lieu)
                
                    <td> 
                      {{$decoupag->decors}}
                    <td>
                   {{$decoupag->jours}}
                    </td>
                    
                
                     @php
                    $t++;
                    @endphp
                    @endif
                    @endif
                    @endforeach
                    

                </tr>
            @endforeach
            
        </table>

                    </div>
                </div>
            </div>

            <div style="clear:both;"></div>
        @endif
 

        @php
            $liste_acteurs = json_decode($action->liste_acteur);
            
        @endphp
        @if (!empty($liste_acteurs))
        <div class="page-break"></div>
        <div class="page-cover">
            <div class="title-container">
            <div class="titre-film">LISTE DES ACTEURS/ACTRICES</div>
            </div>
        </div>
        <div style="clear:both;"></div>

            <div class="page-break"></div>

            <div style="font-size: 12pt;">

                <div id="scenario-container" class="d-flex flex-column h-100">

                    <div id="sequences">

                        <br><br>
                        <table>
                            <tr>
                                <td style="width:10%;">
                                    Personnage
                                </td>
                                <td style="width:25%;">
                                    Prenom
                                </td>

                                <td>
                                    Nom
                                </td>
                                <td style="width:15%;">
                                    Mails
                                </td>

                                <td style="width:15%;">
                                    Telephone
                                </td>
                            </tr>

                            @foreach ($liste_acteurs as $liste_acteur)
                                <tr>
                                    <td style="width:10%;">
                                        {{ $liste_acteur->personnages }}
                                    </td>
                                    <td style="width:25%;">
                                        {{ $liste_acteur->prenom }}
                                    </td>

                                    <td>
                                        {{ $liste_acteur->nom }}
                                    </td>
                                    <td style="width:15%;">
                                        {{ $liste_acteur->mails }}
                                    </td>

                                    <td style="width:15%;">
                                        {{ $liste_acteur->telephones }}
                                    </td>
                                </tr>
                            @endforeach

                        </table>

                    </div>
                </div>

                <div style="clear:both;"></div>
        @endif


        @if (empty($scenario->personnages))
        @else
        <div class="page-break"></div>
        <div class="page-cover">
            <div class="title-container">
            <div class="titre-film">DÉPOUILLEMENT PERSONNAGE</div>
            </div>
        </div>

        <div style="clear:both;"></div>

                <div class="page-break"></div>
            @foreach ($scenario->personnages as $personnage)
                @php
                    $index = 0;
                @endphp
          

                <div style="font-size: 12pt;">

                    <div id="scenario-container" class="d-flex flex-column h-100">

                        <div id="sequences">

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

        @if (!empty($jours))
        <div class="page-cover">
            <div class="title-container">
            <div class="titre-film">PLANNING DE TOURNAGE</div>
            </div>
        </div>
        <div class="page-break"></div>
            @foreach ($jours as $jour)
  

        <div style="clear:both;"></div>
                <div style="font-size: 12pt;">

                    <div id="scenario-container" class="d-flex flex-column h-100">

                        <div id="sequences">

                            @php
                                $scenario = json_decode($action->scenario);
                                $sequences = $scenario->sequences;
                                $index = 0;
                            @endphp

                           

                            <br><br>

                            <table>
                                <tr>
                                    <td colspan="8"> Jours {{ $jour->jours }}</td>
                                <tr>
                                <tr>
                                    <td>
                                        SÉQ N°
                                    </td>
                                    <td>
                                        Plan
                                    </td>
                                    <td>
                                    DÉCOR
                                   
                                    </td>
                                    <td>
                                    LIEU
                                    </td>

                                    <td>
                                        DESCRIPTION DE L’ACTION
                                    </td>
                                    <td>
                                        SUJET
                                    </td>
                                    <td>
                                        P.A.T
                                    </td>
                                    <td>
                                        TEMPS DE TOURNAGE
                                    </td>
                                </tr>

                                @php
                                    $h1 = strtotime($action->pat);
                                    $test = 'O';
                                    $durée = '00:00:00';
                                @endphp

                                @foreach ($decoupages_p as $decoupage)
                                    @if ($decoupage->jours == $jour->jours)
                                        <tr>
                                            <td>{{ $decoupage->sequence_id }}</td>
                                            <td>{{ $decoupage->plan }}</td>
                                            <td>{{ $decoupage->lieu }}</td>
                                            <td>{{ $decoupage->decors }}</td>
                                            <td>
                                                @php
                                                    $descriptions = json_decode($decoupage->description);
                                                @endphp
                                                @if (!empty($descriptions[0]))
                                                    {{ $descriptions[0] }}
                                                @endif

                                            </td>
                                            <td>
                                                @php
                                                    $personnages = json_decode($decoupage->sur);
                                                @endphp
                                                @if (!empty($personnages))
                                                    @foreach ($personnages as $personnage)
                                                        {{ $personnage }}
                                                        <br>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                @if ($test == $decoupage->lieu && strtotime($h1) >= strtotime($action->pat))
                                                    {{ ucfirst($h1 = gmdate('H:i:s', strtotime($h1) + strtotime($durée))) }}
                                                @elseif(strtotime($h1) < strtotime($action->pat))
                                                    {{ ucfirst($h1 = gmdate('H:i:s', strtotime($action->pat))) }}
                                                @else
                                                    {{ ucfirst($h1 = gmdate('H:i:s', strtotime($h1) + strtotime($durée) + strtotime('00:20:00'))) }}
                                                @endif
                                            </td>
                                            <td>{{ $decoupage->durée }}

                                            </td>
                                        </tr>
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
            @endforeach
        @endif


        @if (!empty($jours))
            @php
                $f = 1;
            @endphp
            <div class="page-cover">
            <div class="title-container">
            <div class="titre-film">FEUILLE DE SCRIPT</div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <div class="page-break"></div>
            @foreach ($jourDecoupageData as $jour => $decoupagesForJour)
                @foreach ($decoupagesForJour as $decoupage)

                    <div style="font-size: 12pt;">

                        <div id="scenario-container" class="d-flex flex-column h-100">

                            <div id="sequences">

                                @php
                                    $scenario = json_decode($action->scenario);
                                    $sequences = $scenario->sequences;
                                    $index = 0;
                                @endphp

                                <br><br>
                                <table>
                                    <tr style="text-align:center; height:70px;">
                                        <td colspan="7">FEUILLE DE SCRIPT </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">Titre </td>
                                        <td colspan="5">{{ $action->titre_oeuvre }} </td>
                                        <td colspan="1">MEILLEURE PRISE </td>
                                    </tr>
                                    <tr>

                                        <td colspan="1">Feuille de <br> tournage n° </td>

                                        <td colspan="1"> {{ $f }}</td>
                                        @php $f = $f + 1; @endphp
                                        <td colspan="1">Séquence n° </td>
                                        <td colspan="1"> {{ $decoupage->sequence_id }}</td>
                                        <td colspan="1">Carte mémoire n° </td>
                                        <td colspan="1"></td>
                                        <td colspan="1"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">Date</td>
                                        <td colspan="1"> {{date('d/m/Y', strtotime($decoupage->jours )) }}</td>
                                        <td colspan="1">Plan n° </td>
                                        <td colspan="1"> {{ $decoupage->plan }}</td>
                                        <td colspan="1">DÉCOR</td>
                                        <td colspan="1"> {{ $decoupage->lieu }}</td>
                                        <td colspan="1" style="border-top:1px solid  transparent;"></td>
                                    </tr>

                                    <tr>
                                        <td colspan="4">Description de l'action </td>
                                        <td colspan="1">Échelle </td>
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
                                        <td colspan="7"> OBSERVATIONS (+/-) </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">PRISE N° </td>
                                        <td colspan="1">ACTION </td>
                                        <td colspan="1">IMAGE</td>
                                        <td colspan="1">SON</td>
                                        <td colspan="3">COMMENTAIRE</td>
                                    </tr>
                                    @for ($l = 1; $l < 16; $l++)
                                        <tr>
                                            <td colspan="1">{{ $l }}</td>
                                            <td colspan="1"></td>
                                            <td colspan="1"></td>
                                            <td colspan="1"></td>
                                            <td colspan="3"></td>
                                        </tr>
                                    @endfor
                                </table>
                                <br>
                                <br>
                                <div style="clear:both;"></div>
                                <div class="page-break"></div>
                @endforeach
            @endforeach
        @endif

        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $page_number = $pdf->get_page_number();
                    if($PAGE_NUM > 1){
                        $pdf->text(820, 520, "Page ".($PAGE_NUM-1)."/".($PAGE_COUNT-1), "Ubuntu", 12, array(0,0,0));
                    }
                ');
            }
        </script>
    @endguest

</body>

</html>

