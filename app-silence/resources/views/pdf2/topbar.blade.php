<div style="padding: 16px 24px; border-bottom: 1px solid #D5972B; display:flex; flex-direction: row; align-items:center; justify-content: space-between;">

    <a href="/teacher/dashboard">
        <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/Logos/silence_contourSF.png" style="height: 55px; ">
    </a>

    <a href="/student/plateau" style="text-align: center;">PROFIL ÉLEVE <br> <i id="scenario-vue-classique-btn" class="help-button fas fa-eye"></i></a>

    <a href="/teacher/profil" class="icon-wrapper d-flex flex-row">
        <div class="d-flex flex-column">
            <span>Bienvenue {{ Auth::user()->name }}</span>
            @if (session()->has('group'))
             @if (session('group') == Auth::user()->etablissement_gar)
               <span>Tous les élèves</span>
          	 @else
 				<span>Classe : {{ session('group') }}</span>
             @endif
          @endif
        </div>
        <i class="fas fa-user-circle fa-3x" style="vertical-align: middle; margin-left: 8px;"></i>
    </a>

</div>

