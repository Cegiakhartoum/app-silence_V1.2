<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FaisTonFilm') }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/Logos/favicon_silence_SF.png">
<link rel="icon" type="image/png" sizes="32x32" href="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/Logos/favicon_silence_SF.png">
<link rel="apple-touch-icon" sizes="180x180" href="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/Logos/favicon_silence_SF.png">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">


</head>

<body style="background: {{ $contentBackground }};">
    @guest
    @else
        <div style="padding: 8px 0;">
            @include('student.components.topbar')
        </div>
        <div id="app" class="container-fluid" style="padding: 32px;">

            <div class="row">

                <div class="atelier-sidebar-wrapper col-md-4">
                    @yield('sidebar')
                </div>

                <div class="col-md-7" style="padding: 0 16px 32px 32px;">
                    @yield('content')
                </div>
            </div>
        </div>
        <script>
 
 window.intercomSettings = {
   api_base: "https://api-iam.intercom.io",
   app_id: "pdecq750",
   user_id: <?php echo json_encode(Auth::user()->id) ?>, 
   name: <?php echo json_encode(Auth::user()->name) ?>, // Nom complet
   email: <?php echo json_encode(Auth::user()->email) ?>, // Adresse e-mail
   phone: <?php echo json_encode('0609268986') ?>, // Adresse e-mail
   created_at: "<?php echo strtotime(Auth::user()->created_at) ?>" // Date d’inscription en tant qu’horodatage Unix
 };
</script>



<script>
// We pre-filled your app ID in the widget URL: 'https://widget.intercom.io/widget/pdecq750'
(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/pdecq750';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(document.readyState==='complete'){l();}else if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
        @yield('before-end-body')

    @endguest
</body>

</html>
