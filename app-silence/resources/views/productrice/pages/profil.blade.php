
@extends('productrice.layouts.page', ['contentBackground' => '#33395e'])

@section('content')
@if ( Session::has('success') )
<div class="alert alert-success" role="alert">
{{ Session::get('success') }}
</div>

@endif
<form method="POST" action="profile/update">
    @csrf
    <div class="container-fluid">
        <div style="font-weight: bold; font-size: 34px; margin: 16px 0 32px -15px;  color: #FFF;">Mon profil - {{ Auth::user()->role }}</div>
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

    @php
        use App\Models\User;

        $users = User::all();

    @endphp
<style>

/* Styling modal */
.modal-window {
 position: fixed;
 background-color: rgba(255, 255, 255, 0.4);
 top: 0;
 right: 0;
 bottom: 0;
 left: 0;
 z-index: 999;
 visibility: hidden;
 opacity: 0;
 pointer-events: none;
 transition: all 0.3s;
}
.modal-window:target {
 visibility: visible;
 opacity: 1;
 pointer-events: auto;
}
.modal-window > div {
 width:50%;
 border:#505050 1px solid;
 position: absolute;
 top: 50%;
 left: 50%;
 transform: translate(-50%, -50%);
 padding: 2em;
 text-align: center;
 background: white;
}
.modal-window header {
 font-weight: bold;
}
.modal-window h1 {
 font-size: 150%;
 margin: 0 0 15px;
}
.modal-close {
 color: #de813b;
 line-height: 50px;
 font-size: 16px;
 position: absolute;
 right: 0;
 text-align: center;
 top: 0;
 width: 70px;
 text-decoration: none;
}

.modal-close:hover {
 color: black;
}
/* Demo Styles */


.modal-window > div {
 border-radius: 1rem;
}
.modal-window div:not(:last-of-type) {
 margin-bottom: 15px;
}
.logo {
 max-width: 150px;
 display: block;
}
small {
 color: lightgray;
}
/* Styling modal */
   
   .small-help-button {
       color: #d5972b;
       font-size: 1.2rem;
       cursor: pointer;
       position: relative;
       bottom: 6px;
       right: 4px;
       margin-right: -8px;

   }
  


.dropbtn {
  background-color: transparent;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

.dropup {
  position: relative;
  display: inline-block;
}

.dropup-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  bottom: 50px;
  z-index: 1;
}

.dropup-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropup-content a:hover {background-color: #ccc}

.dropup:hover .dropup-content {
  display: block;
}

.dropup:hover .dropbtn {
  background-color: #2980B9;
}
</style>

<hr style="color:white;">
<hr style="color:white;">
<br>
<h1 style="color:white;">MON EQUIPE </h1>


<div class="container-fluid" style="color: #FFF; padding-top: 32px;">
<div class="row">
<div class="col-md-12" style="margin-bottom: 16px;">
<h2 class="font-weight-bold">Réalisateur !</h2>
  <p style="color:#b9b9ba;font-size: 14px;">Ici tout ce que s'est passé dans la Silence !</p>
  </div>
   <div class="d-flex flex-column stat-box" style="background:#2d314b;color:#b9b9ba;">

   <table>
    <thead>
        <th></th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Nb projet Pro</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        @foreach($users as $user)
        @if($user->role == 'réalisateur')
        <tr style="background-color: #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
            <td>
                <form method="POST" action="profile/delete/$user->id">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item" style="color:#617A9A; text-align:left; font-size:15px; background: none; border: none; padding: 0;">
                        <i style="color: #d5972b;" class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
            <form method="POST" action="compte/update/{{$user->id}}">
                    @csrf
       
                   
           
            <td> <input type="text" name="firtsname" value="{{ $user->firtsname }}"></td>
            <td><input type="text" name="name" value="{{ $user->name }}"></td>
            <td><input type="text" name="email" value="{{ $user->email }}"></td>
            <td>0</td>
            <td>
                    <button type="submit" class="dropdown-item" style="color:#617A9A; text-align:left; font-size:15px; background: none; border: none; padding: 0;">
                        <i style="color: #d5972b;" class="fas fa-edit"></i>
                    </button>
          
            </td>
            </form>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>


</div>
</div>
<hr style="color:white;">
<div class="container-fluid" style="color: #FFF; padding-top: 32px;">
<div class="row">
        <div class="col-md-12" style="margin-bottom: 16px;">
            <h2 class="font-weight-bold">Distributeur !</h2>
            <p style="color:#b9b9ba;font-size: 14px;">Ici tout ce que s'est passé dans la Silence !</p>
     
        </div>

        <div class="d-flex flex-column stat-box" style="background:#2d314b;color:#b9b9ba;">
        <table>
    <thead>
        <th></th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Nb projet Pro</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        @foreach($users as $user)
        @if($user->role == 'distributeur')
        <tr style="background-color: #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
            <td>
                <form method="POST" action="profile/delete/$user->id">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item" style="color:#617A9A; text-align:left; font-size:15px; background: none; border: none; padding: 0;">
                        <i style="color: #d5972b;" class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
            <form method="POST" action="compte/update/{{$user->id}}">
                    @csrf
      
                   
           
            <td> <input type="text" name="firtsname" value="{{ $user->firtsname }}"></td>
            <td><input type="text" name="name" value="{{ $user->name }}"></td>
            <td><input type="text" name="email" value="{{ $user->email }}"></td>
            <td>0</td>
            <td>
                    <button type="submit" class="dropdown-item" style="color:#617A9A; text-align:left; font-size:15px; background: none; border: none; padding: 0;">
                        <i style="color: #d5972b;" class="fas fa-edit"></i>
                    </button>
          
            </td>
            </form>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>

</div>
</div>

<hr style="color:white;">
<div class="container-fluid" style="color: #FFF; padding-top: 32px;">
<div class="row">
        <div class="col-md-12" style="margin-bottom: 16px;">
            <h2 class="font-weight-bold">Assistant Réalisateur !</h2>
            <p style="color:#b9b9ba;font-size: 14px;">Ici tout ce que s'est passé dans la Silence !</p>

        </div>

        <div class="d-flex flex-column stat-box" style="background:#2d314b;color:#b9b9ba;">
        <table>
    <thead>
        <th></th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Nb projet Pro</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        @foreach($users as $user)
        @if($user->role == 'assistant_real')
        <tr style="background-color: #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
            <td>
                <form method="POST" action="profile/delete/$user->id">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item" style="color:#617A9A; text-align:left; font-size:15px; background: none; border: none; padding: 0;">
                        <i style="color: #d5972b;" class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
            <form method="POST" action="compte/update/{{$user->id}}">
                    @csrf

                   
           
            <td> <input type="text" name="firtsname" value="{{ $user->firtsname }}"></td>
            <td><input type="text" name="name" value="{{ $user->name }}"></td>
            <td><input type="text" name="email" value="{{ $user->email }}"></td>
            <td>0</td>
            <td>
                    <button type="submit" class="dropdown-item" style="color:#617A9A; text-align:left; font-size:15px; background: none; border: none; padding: 0;">
                        <i style="color: #d5972b;" class="fas fa-edit"></i>
                    </button>
          
            </td>
            </form>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
</div>
</div>
<hr style="color:white;">
<div class="container-fluid" style="color: #FFF; padding-top: 32px;">
<div class="row">
        <div class="col-md-12" style="margin-bottom: 16px;">
            <h2 class="font-weight-bold">Assistant Production !</h2>
            <p style="color:#b9b9ba;font-size: 14px;">Ici tout ce que s'est passé dans la Silence !</p>

        </div>

        <div class="d-flex flex-column stat-box" style="background:#2d314b;color:#b9b9ba;">
        <table>
    <thead>
        <th></th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Nb projet Pro</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        @foreach($users as $user)
        @if($user->role == 'assistant_prod')
        <tr style="background-color: #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
            <td>
                <form method="POST" action="profile/delete/$user->id">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item" style="color:#617A9A; text-align:left; font-size:15px; background: none; border: none; padding: 0;">
                        <i style="color: #d5972b;" class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
            <form method="POST" action="compte/update/{{$user->id}}">
                    @csrf
              
                   
           
            <td> <input type="text" name="firtsname" value="{{ $user->firtsname }}"></td>
            <td><input type="text" name="name" value="{{ $user->name }}"></td>
            <td><input type="text" name="email" value="{{ $user->email }}"></td>
            <td>0</td>
            <td>
                    <button type="submit" class="dropdown-item" style="color:#617A9A; text-align:left; font-size:15px; background: none; border: none; padding: 0;">
                        <i style="color: #d5972b;" class="fas fa-edit"></i>
                    </button>
          
            </td>
            </form>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
</div>
</div>
<hr style="color:white;">
<div class="container-fluid" style="color: #FFF; padding-top: 32px;">
<div class="row">
        <div class="col-md-12" style="margin-bottom: 16px;">
            <h2 class="font-weight-bold">Chef Opération !</h2>
            <p style="color:#b9b9ba;font-size: 14px;">Ici tout ce que s'est passé dans la Silence !</p>

        </div>
   <div class="d-flex flex-column stat-box" style="background:#2d314b;color:#b9b9ba;">

   <table>
    <thead>
        <th></th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Nb projet Pro</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        @foreach($users as $user)
        @if($user->role == 'chef_op')
        <tr style="background-color: #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
            <td>
                <form method="POST" action="profile/delete/$user->id">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item" style="color:#617A9A; text-align:left; font-size:15px; background: none; border: none; padding: 0;">
                        <i style="color: #d5972b;" class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
            <form method="POST" action="compte/update/{{$user->id}}">
                    @csrf
           
                   
           
            <td> <input type="text" name="firtsname" value="{{ $user->firtsname }}"></td>
            <td><input type="text" name="name" value="{{ $user->name }}"></td>
            <td><input type="text" name="email" value="{{ $user->email }}"></td>
            <td>0</td>
            <td>
                    <button type="submit" class="dropdown-item" style="color:#617A9A; text-align:left; font-size:15px; background: none; border: none; padding: 0;">
                        <i style="color: #d5972b;" class="fas fa-edit"></i>
                    </button>
          
            </td>
            </form>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>

</div>
</div>
<hr style="color:white;">
<div class="container-fluid" style="color: #FFF; padding-top: 32px;">
<div class="row">
        <div class="col-md-12" style="margin-bottom: 16px;">
            <h2 class="font-weight-bold">Coach !</h2>
            <p style="color:#b9b9ba;font-size: 14px;">Ici tout ce que s'est passé dans la Silence !</p>

        </div>
   <div class="d-flex flex-column stat-box" style="background:#2d314b;color:#b9b9ba;">

   <table>
    <thead>
        <th></th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Nb projet Pro</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        @foreach($users as $user)
        @if($user->role == 'coach')
        <tr style="background-color: #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
            <td>
                <form method="POST" action="profile/delete/$user->id">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item" style="color:#617A9A; text-align:left; font-size:15px; background: none; border: none; padding: 0;">
                        <i style="color: #d5972b;" class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
            <form method="POST" action="compte/update/{{$user->id}}">
                    @csrf
             
                   
           
            <td> <input type="text" name="firtsname" value="{{ $user->firtsname }}"></td>
            <td><input type="text" name="name" value="{{ $user->name }}"></td>
            <td><input type="text" name="email" value="{{ $user->email }}"></td>
            <td>0</td>
            <td>
                    <button type="submit" class="dropdown-item" style="color:#617A9A; text-align:left; font-size:15px; background: none; border: none; padding: 0;">
                        <i style="color: #d5972b;" class="fas fa-edit"></i>
                    </button>
          
            </td>
            </form>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>

</div>
</div>
<hr style="color:white;">
<div class="container-fluid" style="color: #FFF; padding-top: 32px;">
<div class="row">
        <div class="col-md-12" style="margin-bottom: 16px;">
            <h2 class="font-weight-bold">Devops !</h2>
            <p style="color:#b9b9ba;font-size: 14px;">Ici tout ce que s'est passé dans la Silence !</p>

        </div>
   <div class="d-flex flex-column stat-box" style="background:#2d314b;color:#b9b9ba;">

   <table>
    <thead>
        <th></th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Nb projet Pro</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        @foreach($users as $user)
        @if($user->role == 'devops')
        <tr style="background-color: #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
            <td>
                <form method="POST" action="profile/delete/$user->id">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item" style="color:#617A9A; text-align:left; font-size:15px; background: none; border: none; padding: 0;">
                        <i style="color: #d5972b;" class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
            <form method="POST" action="compte/update/{{$user->id}}">
                    @csrf
               
                   
           
            <td> <input type="text" name="firtsname" value="{{ $user->firtsname }}"></td>
            <td><input type="text" name="name" value="{{ $user->name }}"></td>
            <td><input type="text" name="email" value="{{ $user->email }}"></td>
            <td>0</td>
            <td>
                    <button type="submit" class="dropdown-item" style="color:#617A9A; text-align:left; font-size:15px; background: none; border: none; padding: 0;">
                        <i style="color: #d5972b;" class="fas fa-edit"></i>
                    </button>
          
            </td>
            </form>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>

</div>
</div>
<br>

            <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
                data-bs-target="#createRéalisateur">
                <i class="fas fa-plus-circle"></i>
                Nouveaux 
            </button>
            <hr style="color:white;">
<hr style="color:white;">
            <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">{{ __('Déconnexion') }}</button>
                </form>
     
<!-- Creer projet modal -->
<div class="modal fade" id="createRéalisateur" tabindex="-1" role="dialog" aria-hidden="true">

<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background-color: #4a4d77;">
        <div class="modal-body">
            <div class="d-flex justify-content-between align-items-center">
                <button type="button" class="close btn btn-link" style="text-decoration: none;"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i style="color: #d5972b; font-size: 1.5em;" class="fas fa-arrow-alt-circle-left"></i>
                </button>
                <button type="button" class="close btn btn-link" style="text-decoration: none;"
                    data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: #d5972b; font-size: 2rem;">&times;</span>
                </button>
            </div>

            <h3 class="text-center text-white">
                Nouveau Compte interne
            </h3>
            <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px);">



<div class="card-body">
    <form method="POST" action="/productrice/create-compte">
        @csrf
        <input id="redirect_url" name="redirect_url" type="hidden" value="/compte_interne" >

        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('firtsname') }}</label>

            <div class="col-md-6">
                <input id="firtsname" type="text" class="form-control @error('firtsname') is-invalid @enderror" name="firtsname" value="{{ old('firtsname') }}" required autocomplete="firtsname" autofocus>

                @error('firtsname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
<br>
        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

<br>


        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
<br>
        <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>
<br>


        <div class="form-group row">
            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

            <div class="col-md-6">

                        <select class="form-control text-orange" id="role" name="role" >
                                        <option value="assistant" selected>Role</option>
                                        <option value="réalisateur">réalisateur</option>
                                        <option value="distributeur">distributeur</option>
                                        <option value="chef_op">chef opération</option>
                                        <option value="coach">coach</option>
                                        <option value="assistant_prod">assistant production</option>
                                        <option value="assistant_real">assistant réalisateur</option>
                                        <option value="devops">devops</option>
                                    </select>
            </div>
        </div>

<br>


        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                </button>
     
        </div>
    </form>
</div>
</div>
        </div>
    </div>
</div>


</div>
<!-- Creer projet modal -->

@endsection
