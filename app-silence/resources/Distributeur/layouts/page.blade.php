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
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

</head>



<body style="background: #FFF;">
    <div id="app" style="padding: 0; background-color: #464d80; display:flex; flex-direction:column;">
        @include('student.components.topbar')
        <div style="display: flex; flex-grow: 1;">
            <div class="sidebar-wrapper sidebar-wrapper-teacher">
                @include('student.components.sidebar')
            </div>

            <div
                style="flex-grow:1; display:flex; flex-direction:column; padding: 0 16px 0 32px; background: {{ $contentBackground }}; overflow-y: scroll;">
                <div style="flex-grow: 1;">
                    @yield('content')
                </div>
                <div>
                    @include('student.components.footer')
                </div>
            </div>
        </div>
    </div>
<script>
  window.intercomSettings = {
    api_base: "https://api-iam.intercom.io",
    app_id: "pdecq750"
  };
</script>

<script>
// We pre-filled your app ID in the widget URL: 'https://widget.intercom.io/widget/pdecq750'
(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/pdecq750';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(document.readyState==='complete'){l();}else if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
    @yield('before-end-body')

</body>

</html>

