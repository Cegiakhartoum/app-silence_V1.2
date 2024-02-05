<nav id="teacher-sidebar">

    <a href="/teacher/dashboard" class="icon-wrapper">
        <i class="fas fa-home"></i> Accueil
    </a>

    <a href="/teacher/students" class="icon-wrapper">
        <i class="fas fa-user-friends"></i> Mes élèves
    </a>
    <a href="/teacher/ateliers" class="icon-wrapper">
        <i class="fas fa-book"></i> Ateliers
    </a>
    <a href="/teacher/action" class="icon-wrapper">
        <i class="far fa-comment-dots"></i> ACTION !
    </a>


   
   <a href="/teacher/montage" class="icon-wrapper">

        <i class="fas fa-cut"></i> Montage
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

<script>
    $('.close-icon, .menu-icon').on('click', function() {
        $(".sidebar-wrapper").toggleClass("sidebar-wrapper-collapsed");
    });
</script>
