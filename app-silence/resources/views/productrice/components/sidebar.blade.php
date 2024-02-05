
<nav id="teacher-sidebar">

    <a href="/productrice/plateau" class="icon-wrapper">
        <i class="fas fa-home"></i> Mon plateau
    </a>
    <a href="/productrice/productions" class="icon-wrapper">
    <i class="fa fa-tasks"></i>Les productions
    </a>
    <a href="/productrice/ateliers" class="icon-wrapper">
        <i class="fas fa-book"></i> Les ateliers Edit
    </a>
  
    <a href="/student/ateliers" class="icon-wrapper">
        <i class="fas fa-book"></i> Les ateliers
    </a>
  

    <a href="/productrice/action" class="icon-wrapper">
        <i class="far fa-comment-dots"></i> Action!
    </a>

    <a href="/productrice/montage" class="icon-wrapper">

        <i class="fas fa-cut"></i> Wevideo
    </a>

 

    {{--  <a href="/productrice/dashboard" class="icon-wrapper">
    <i class="fas fa-help"></i>Help Center
    </a> --}}



    {{-- <a href="#" class="icon-wrapper" style="position: absolute; bottom: 16px;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-user-circle icon" style="font-size: 4.5rem;"></i>
    </a> --}}

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</nav>



