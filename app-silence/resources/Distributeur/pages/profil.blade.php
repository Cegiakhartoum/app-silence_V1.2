@extends('student.layouts.page', array('contentBackground' => '#33395e') )

@section('content')

    <div class="container-fluid">

        <div style="font-weight: bold; font-size: 34px; margin: 16px 0 32px -15px;  color: #FFF;"> Mon profil - Élève</div>

        <div style="display: flex; color: #FFF; font-size: 1.2rem;">
            <div style="padding-right: 16px;">
                Nom <br/> <br/>
                Etablissement <br/> <br/> <br/>
                support@faistonfilm.co
                <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
            </div>
            <div class="flex-grow-1">
                : &nbsp;&nbsp; {{ Auth::user()->name }} <br/>  <br/>
                : &nbsp;&nbsp; {{ Auth::user()->etablissement_gar }} <br/>  <br/> <br/>
            </div>
        </div>

    </div>

@endsection
