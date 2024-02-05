<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" sizes="16x16" href="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/Logos/favicon_silence_SF.png">
<link rel="icon" type="image/png" sizes="32x32" href="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/Logos/favicon_silence_SF.png">
<link rel="apple-touch-icon" sizes="180x180" href="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/Logos/favicon_silence_SF.png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FaisTonFilm') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/action.css') }}" rel="stylesheet">
    <script type='text/javascript'>
function whizzzz(){
foo=document.getElementById('scrollValue');
bar=parseInt(document.body.scrollTop)
foo.value=bar
foo.style.top=50+bar+"px"
}
</script>

</head>

<body onscroll="whizzzz()" style="background: #FFF;">
    @guest
    @else
        <div id="app" class="d-flex flex-column" style="height: 100vh; ">

            <div style="display: flex; flex-direction:row; padding: 16px 24px 16px 16px; background: #4a4d77; border-bottom: 3px solid #D5972B;">
                <div style="flex-grow:1;">
                    <a href="/distributeur/plateau" class="icon-wrapper">
                        <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/Logos/favicon_silence_contour_SF.png"
                            style="height: 50px; display: inline-block; margin: auto;  padding: 1px;" />
                    </a>
                </div>

                <div style="color: #FFF;">
                <a href="/distributeur/plateau" class="icon-wrapper">
                    <i class="fas fa-user-circle fa-2x" style="vertical-align: middle; padding-right: 10px;"></i>
                    </a>
          

                </div>

            </div>

            <div class="d-flex flex-grow-1" style="margin: 0; overflow: hidden;">
                <div class="action-sidebar" >
                    @yield('sidebar')
                </div>

                <div class="flex-grow-1" style="padding: 64px 16px 32px 32px; overflow-y: scroll; font-family: Courier;">
                    @yield('content')
                </div>

                <div>
                    @yield('help')
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

    @endguest

    <script src="/js/action.js"></script>

</body>

</html>
