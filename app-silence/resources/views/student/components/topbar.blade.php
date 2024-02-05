<div
    style="padding: 16px 24px; border-bottom: 1px solid #D5972B; display:flex; flex-direction: row; align-items:center; justify-content: space-between;">

    <div>
        <a href="/student/plateau" >
            <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/Logos/silence_contourSF.png" style="height: 45px; ">
        </a>
    </div>

    {{-- <a href="#" style="color: #EEE; font-size: 20px;">
        <i class="far fa-comment-dots"></i>
    </a>

    <a href="#" style="color: #EEE; margin-left: 32px; margin-right: 32px; font-size: 20px;">
        <i class="far fa-bell"></i>
    </a> --}}

    <a href="/student/profil" class="icon-wrapper d-flex flex-row">
        <div class="d-flex flex-column">
            <span>Bienvenue {{ Auth::user()->name }}</span>
       
        </div>
        <i class="fas fa-user-circle fa-3x" style="vertical-align: middle; margin-left: 8px;"></i>
    </a>

</div>
