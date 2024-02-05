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
        table {
            width: 100%;
            height: 80%;
            font-family: 'Courier', sans-serif;
            font-size: 12px;
            border-collapse: collapse;
        }

        table td {
            font-family: 'Courier', sans-serif;
            font-size: 12px;
            border: 1px solid black;
            padding: 10px; /* Adjust the padding as needed */
        }

    </style>

</head>


<body>
    @guest
    @else


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
                        {{ $index }}. {{ $sequence->location ?? '' }} - {{ $sequence->lieu }} - {{ $sequence->time ?? '' }}
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
                            <div style="padding-top: 32px; text-align: justify; page-break-inside: avoid;">
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
