<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Silence !') }}</title>

      <link rel="apple-touch-icon" sizes="180x180" href="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/Logos/favicon_silence_SF.png">
<link rel="icon" type="image/png" sizes="32x32" href="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/Logos/favicon_silence_SF.png">
<link rel="icon" type="image/png" sizes="16x16" href="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/Logos/favicon_silence_SF.png">

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

</head>
      <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('https://silence-2021.s3.eu-west-3.amazonaws.com/vignettes/4.png') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #ffffff;
            font-family: 'Ubuntu', sans-serif;
            text-align: center;
        }

        #clap-svg {
            max-width: 100%; /* Rendre l'image PNG responsive */
        }

        h1 {
            font-size: 26px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        p {
            font-size: 21px;
            margin-bottom: 20px;
        }

        small {
            font-size: 14px;
        }

        a {
            text-decoration: none;
            color: #ffffff;

            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
<body>
    <div class="container">
        <img id="clap-svg" src="/images/page erreur.png" alt="Clap Cassé" class="img-fluid rounded mx-auto d-block">
             <br>
      <h1>Ton clap s’est cassé !</h1>
        <br>
        <p>Ton régisseur a oublié d’en prévoir un supplémentaire, <br> il est parti en récupérer un autre.</p>

        <a href="/student/plateau" class="btn btn-orange btn-lg">
            L’équipe réorganise le tournage
            <br>
            Clique ici pour revenir au plateau
        </a>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>

