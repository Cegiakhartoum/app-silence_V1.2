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
                    <a href="/student/plateau" class="icon-wrapper">
                        <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/Logos/favicon_silence_contour_SF.png"
                            style="height: 50px; display: inline-block; margin: auto;  padding: 1px;" />
                    </a>
                </div>

                <div style="color: #FFF;">
                <a href="/student/plateau" class="icon-wrapper">
                    <i class="fas fa-user-circle fa-2x" style="vertical-align: middle; padding-right: 10px;"></i>
                    </a>


                </div>

            </div>

            <div class="d-flex flex-grow-1" style="margin: 0; overflow: hidden;">
                <div class="action-sidebar" >
                    @yield('sidebar')
                </div>

                <div class="flex-grow-1 scenario-section" style="padding: 64px 16px 32px 32px; overflow-y: scroll; font-family: Courier;">
                    @yield('content')
                </div>

                <div>
                    @yield('help')
                </div>
            </div>
        </div>


        @yield('before-end-body')

    @endguest

    <script src="/js/action.js"></script>
  <script>
   $(document).ready(function () {
            var saveDelay;

            $(document).on("input", ".form-control", function () {
                clearTimeout(saveDelay);
                saveDelay = setTimeout(sendFormData, 1000);
            });
            $(document).on("input", ".action-textarea", function () {
                clearTimeout(saveDelay);
                saveDelay = setTimeout(sendFormData, 1000);
            });

            function sendFormData() {
                $.ajax({
                    url: $("#action-form").attr("action"),
                    type: "POST",
                    data: $("#action-form").serialize(),
                    beforeSend: startSavingAnimation,
                    success: function (response) {
                        console.log("Data submitted successfully!");
                        showSuccessAndRevert();
                    },
                    error: function (error) {
                        console.log("Error during submission:", error);
                    },
                });
            }

            function startSavingAnimation() {
                $("#saveModal-button")
                    .removeClass("save-btn")
                    .addClass("saving-btn")
                    .text("Sauvegarde en cours...");
            }

            function showSuccessAndRevert() {
                $("#saveModal-button")
                    .removeClass("saving-btn")
                    .addClass("validated-icon")
                    .text("✔ Sauvegardé");
                setTimeout(function () {
                    $("#saveModal-button")
                        .removeClass("validated-icon")
                        .addClass("save-btn")
                        .text("Enregistrer le projet");
                }, 2000);
            }

            
        });

  </script>

</body>

</html>

