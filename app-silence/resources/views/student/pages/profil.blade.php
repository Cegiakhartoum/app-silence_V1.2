@extends('student.layouts.page', array('contentBackground' => '#33395e') )

@section('content')
<form method="POST" action="profile/update">
    @csrf
    <div class="container-fluid">
        <div style="font-weight: bold; font-size: 34px; margin: 16px 0 32px -15px;  color: #FFF;">Mon profil </div>
        <div style="display: flex; color: #FFF; font-size: 1.2rem;">
            <div style="padding-right: 16px;">        
                <strong>Prénom :</strong> <br/><br/>
                <strong>Nom :</strong> <br/><br/>
                <strong>Email :</strong> <br/><br/>
            </div>
            <div class="flex-grow-1">
                : &nbsp;&nbsp; <input type="text" name="firstname" value="{{ Auth::user()->firtsname }}"> <br/><br/>
                : &nbsp;&nbsp; <input type="text" name="name" value="{{ Auth::user()->name }}"> <br/><br/>
                : &nbsp;&nbsp; <input type="text" name="email" value="{{ Auth::user()->email }}"> <br/><br/>
            </div>
        </div>
    </div>
    <br>
    <button type="submit" class="btn btn-success">{{ __('Modifier') }}</button>
</form>
<br>
<form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" 
    onclick="event.preventDefault();
    this.closest('form').submit();"
    style="background-color: red; color: white;">
    {{ __('Log Out') }}
</x-dropdown-link>
                        </form>

@endsection
