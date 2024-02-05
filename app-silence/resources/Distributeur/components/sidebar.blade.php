
<nav id="teacher-sidebar">

    <a href="/student/plateau" class="icon-wrapper">
        <i class="fas fa-home"></i> Accueil
    </a>

    <a href="/student/ateliers" class="icon-wrapper">
        <i class="fas fa-book"></i> Ateliers
    </a>

    <a href="/student/action" class="icon-wrapper">
        <i class="far fa-comment-dots"></i> ACTION !
    </a>

  <a href="/student/montage" class="icon-wrapper">

        <i class="fas fa-cut"></i> Montage
    </a>
    @if( Auth::user()->id  == 1 || Auth::user()->id  == 2 || Auth::user()->id  == 3)
   <a href="/student/abonnement" class="icon-wrapper">
        <i class="fas fa-plus"></i> Abonnement 
    </a>
       <a href="/productrice/productions" class="icon-wrapper">
    <i class="fa fa-tasks"></i>Les productions
    </a>
    <a href="/productrice/ateliers_pro" class="icon-wrapper">
        <i class="fas fa-book"></i> Ajouter ateliers
    </a>
    @endif
    {{--
    <a href="/student/vidéos" class="icon-wrapper">
        <i class="fas fa-book"></i> Mes vidéos
    </a>
    {{--
    <a href="/teacher/dashboard" class="icon-wrapper">
        <i class="fas fa-cog"></i> Paramètres
    </a> --}}

    {{-- <a href="#" class="icon-wrapper" style="position: absolute; bottom: 16px;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-user-circle icon" style="font-size: 4.5rem;"></i>
    </a> --}}

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</nav>



