<nav id="sidebar">

    <a href="/student/plateau" class="icon-wrapper">
        <img src="{{ asset('images/logo.svg') }}" style="height: 60px; display: inline-block; margin: auto;" />
    </a>


    {{-- <a href="/student/plateau" class="icon-wrapper">
        <i class="fas fa-search icon"></i>
    </a>


    <a href="/student/parcours" class="icon-wrapper">
        <i class="fas fa-chart-line icon"></i>
    </a>



    <a href="/student/actions" class="icon-wrapper">
        <i class="fas fa-video icon"></i>
    </a>


    <a href="/student/informations" class="icon-wrapper">
        <i class="far fa-lightbulb icon"></i>
    </a> --}}

    {{-- <a href="/student/profil" class="icon-wrapper" style="position: absolute; bottom: 16px;">
        <i class="fas fa-user-circle icon" style="font-size: 4.5rem;"></i>
    </a> --}}

    {{-- <a href="#" class="icon-wrapper" style="position: absolute; bottom: 16px;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-user-circle icon" style="font-size: 4.5rem;"></i>
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form> --}}

</nav>

<script>
    $('.close-icon, .menu-icon').on('click', function() {
        $(".sidebar-wrapper").toggleClass("sidebar-wrapper-collapsed");
    });
</script>
