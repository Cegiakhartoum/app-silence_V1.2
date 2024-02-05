@extends('student.layouts.page', ['contentBackground' => '#33395e'])

@section('content')
    <link href="{{ asset('css/action_teacher.css') }}" rel="stylesheet">
    
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

    @php

        use App\Http\Controllers\ProjetActionController;
        use App\Models\Action;
     
  
        $actions = Action::all();

        $projetActionCtrl = new ProjetActionController();

        if (isset($_GET['error'])) {
            echo '<script>
                alert("Une erreur s\'est produite. Le projet n \'a pas été créé");
            </script>';
        }

    @endphp
    <style>
        thead,th{
            padding: 12px 8px !important;
            vertical-align: middle;
            border-color:transparent;
            background-color: transparent;
            text-align:center;

        }
        td, tr{
    

           text-align:center;
          
        }
        td{

           padding-top:10px; 

          
        }
    </style>

<div class="container-fluid" style="color: #FFF; padding-top: 32px;">

        <div class="row" style="margin-left:5%;">
            <div class="col-md-6" style="margin-bottom: 16px; ">
                <h2 class="font-weight-bold">Tableau de bord, ACTION !</h2>
            </div>
            <div class="col-md-6 text-end" style="margin-bottom: 16px;">
                <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
                    data-bs-target="#createProjetModal">
                    <i class="fas fa-plus-circle"></i>
                    Nouveau projet
                </button>
            </div>

        </div>


<br>
<br>
<br>

<div class="d-flex flex-column stat-box" style="background:#2d314b;color:#b9b9ba;margin-left:5%;">

    <table>
         <tr>
            <td>
                <p style="color: #d5972b;text-align:left;"></p> <br>
                <H3 style="color:white;text-align:left;">Les écrits</H3>

            </td>
            <td style=" width:60%;">
            @if($projetActionCtrl->findProjetsStudentEcrit(Auth::user()->id)->isEmpty() && $projetActionCtrl->findProjetsGroupStudentEcrit(Auth::user()->id)->isEmpty() )
            Aucun ecrit en cours
            @else
            <table style="width:100%;">
         <thead> 
                         <th>PROJET</th>
                        <th>FORMAT</th>
                        <th>TYPE</th>
                        <th>STATUT</th>
                        <th>DERNIÈRE MODIFICATION</th>
                        <th></th>
                        <th></th>
         </thead >
        
         <tbody>


         @foreach ($projetActionCtrl->findProjetsStudentEcrit(Auth::user()->id) as $projetAction)
         <tr style="background-color:  #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
                            <td ><a style="color: #d5972b;" href="/student/action?p={{ $projetAction['id'] }}&c=0">{{ $projetAction['nom'] }}</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">{{ $projetAction['type'] }}</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">Individuel</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">En cours</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">
                            @foreach($actions as $action)
                                @if($action->projet_action_id ==  $projetAction['id'] )
                               @php echo date('d m Y H:i', strtotime($action->updated_at)); @endphp
                                @endif
                             @endforeach                       
                            </a></td>
                            <td><a href="/report/silence?id={{ $projetAction['id'] }}"style="color:#617A9A; text-align:center; font-size:15px;">  
                            <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/telecharger.png" alt="Télécharger" style=" height: 18px;padding-right:25px;" title="telecharger"/>
                            </a>
                            </td>
                            <td>
                            <a tabindex="0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                         </a>
    <ul class="dropdown-menu">
          
               <li><a class="dropdown-item"  href="#open-modal-archive{{ $projetAction['id'] }}" style="color:#617A9A; text-align:left; font-size:15px;">  
                            <i style="color: #d5972b;" class="fas fa-box"></i> Archiver
                            </a>
                     </li>
                     <li><a class="dropdown-item"  href="#open-modal-delete{{ $projetAction['id'] }}" style="color: red; text-align:left; font-size:15px;">  
                            <i style="color: red;" class="fas fa-trash"></i> Supprimer
                            </a>
                     </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
   </ul>
                            
                                

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-archive{{ $projetAction['id'] }}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: #d5972b;font-size: 120px; " class="fas fa-box"></i>
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/archive/1/{{ $projetAction['id'] }}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Archiver le projet : {{ $projetAction['nom'] }} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Archiver</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                         

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-delete{{ $projetAction['id'] }}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: red;font-size: 120px; " class="fas fa-trash"></i>
                  
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/delete/{{ $projetAction['id'] }}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Supprimer le projet : {{ $projetAction['nom'] }} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Supprimer</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                            </td>
                            
                            </tr>
        @endforeach

        @foreach ($projetActionCtrl->findProjetsGroupStudentEcrit(Auth::user()->id) as $projetAction)
        <tr style="background-color: #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
                            <td><a style="color: #d5972b;" href="/student/action?p={{ $projetAction['id'] }}&c=0">{{ $projetAction['nom'] }}</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">Film de {{ $projetAction['type'] }}</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">Groupe</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">En cours</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">
                         
                               @php echo date('d m Y H:i', strtotime( $projetAction['updated_at'])); @endphp
                                              
                            </a>
                            </td>
                            <td><a href="/report/silence?id={{ $projetAction['id'] }}"style="color:#617A9A; text-align:center; font-size:15px;">  
                            <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/telecharger.png" alt="Télécharger" style=" height: 18px;padding-right:25px;" title="telecharger"/>
                            </a>
                            </td>
                            <td>
                            <a tabindex="0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                         </a>
    <ul class="dropdown-menu">
          
               <li><a class="dropdown-item"  href="#open-modal-archive{{ $projetAction['id'] }}" style="color:#617A9A; text-align:left; font-size:15px;">  
                            <i style="color: #d5972b;" class="fas fa-box"></i> Archiver
                            </a>
                     </li>
                     <li><a class="dropdown-item"  href="#open-modal-delete{{ $projetAction['id'] }}" style="color: red; text-align:left; font-size:15px;">  
                            <i style="color: red;" class="fas fa-trash"></i> Supprimer
                            </a>
                     </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
   </ul>
                            
                                

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-archive{{ $projetAction['id'] }}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: #d5972b;font-size: 120px; " class="fas fa-box"></i>
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/archive/1/{{ $projetAction['id'] }}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Archiver le projet : {{ $projetAction['nom'] }} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Archiver</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                         

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-delete{{ $projetAction['id'] }}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: red;font-size: 120px; " class="fas fa-trash"></i>
                  
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/delete/{{ $projetAction['id'] }}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Supprimer le projet : {{ $projetAction['nom'] }} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Supprimer</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                            </td>
   
    </tr>
    @endforeach
    </tbody>
    </table>
    @endif
    </td>
    </tr>
    </table>
    <table>
         <tr>
            <td>

                <H3 style="color:white;text-align:left;">Les préparations <br>de tournage</H3>

            </td>
            <td style=" width:60%;">
            @if($projetActionCtrl->findProjetsStudentTournage(Auth::user()->id)->isEmpty() && $projetActionCtrl->findProjetsStudentTournage(Auth::user()->id)->isEmpty() )
            Aucune préparation de tournage en cours
            @else
            <table style="width:100%;">
         <thead> 
                         <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
         </thead >
        
         <tbody>


         @foreach ($projetActionCtrl->findProjetsStudentTournage(Auth::user()->id) as $projetAction)
         <tr style="background-color:  #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
                            <td ><a style="color: #d5972b;" href="/student/action?p={{ $projetAction['id'] }}&c=0">{{ $projetAction['nom'] }}</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">{{ $projetAction['type'] }}</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">Individuel</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">En cours</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">
                            @foreach($actions as $action)
                                @if($action->projet_action_id ==  $projetAction['id'] )
                               @php echo date('d m Y H:i', strtotime($action->updated_at)); @endphp
                                @endif
                             @endforeach                       
                            </a></td>
                            <td><a href="/report/silence?id={{ $projetAction['id'] }}"style="color:#617A9A; text-align:center; font-size:15px;">  
                            <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/telecharger.png" alt="Télécharger" style=" height: 18px;padding-right:25px;" title="telecharger"/>
                            </a>
                            </td>
                            <td>
                            <a tabindex="0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                         </a>
    <ul class="dropdown-menu">
          
               <li><a class="dropdown-item"  href="#open-modal-archive{{ $projetAction['id'] }}" style="color:#617A9A; text-align:left; font-size:15px;">  
                            <i style="color: #d5972b;" class="fas fa-box"></i> Archiver
                            </a>
                     </li>
                     <li><a class="dropdown-item"  href="#open-modal-delete{{ $projetAction['id'] }}" style="color: red; text-align:left; font-size:15px;">  
                            <i style="color: red;" class="fas fa-trash"></i> Supprimer
                            </a>
                     </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
   </ul>
                            
                                

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-archive{{ $projetAction['id'] }}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: #d5972b;font-size: 120px; " class="fas fa-box"></i>
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/archive/1/{{ $projetAction['id'] }}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Archiver le projet : {{ $projetAction['nom'] }} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Archiver</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                         

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-delete{{ $projetAction['id'] }}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: red;font-size: 120px; " class="fas fa-trash"></i>
                  
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/delete/{{ $projetAction['id'] }}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Supprimer le projet : {{ $projetAction['nom'] }} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Supprimer</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                            </td>
                            
                            </tr>
        @endforeach

         @foreach ($projetActionCtrl->findProjetsGroupStudentTournage(Auth::user()->id) as $projetAction)
        <tr style="background-color: #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
                            <td><a style="color: #d5972b;" href="/student/action?p={{ $projetAction['id'] }}&c=0">{{ $projetAction['nom'] }}</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">Film de {{ $projetAction['type'] }}</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">Groupe</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">En cours</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">
                         
                               @php echo date('d m Y H:i', strtotime( $projetAction['updated_at'])); @endphp
                                              
                            </a>
                            </td>
                            <td><a href="/report/silence?id={{ $projetAction['id'] }}"style="color:#617A9A; text-align:center; font-size:15px;">  
                            <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/telecharger.png" alt="Télécharger" style=" height: 18px;padding-right:25px;" title="telecharger"/>
                            </a>
                            </td>
                            <td>
                            <a tabindex="0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                         </a>
    <ul class="dropdown-menu">
          
               <li><a class="dropdown-item"  href="#open-modal-archive{{ $projetAction['id'] }}" style="color:#617A9A; text-align:left; font-size:15px;">  
                            <i style="color: #d5972b;" class="fas fa-box"></i> Archiver
                            </a>
                     </li>
                     <li><a class="dropdown-item"  href="#open-modal-delete{{ $projetAction['id'] }}" style="color: red; text-align:left; font-size:15px;">  
                            <i style="color: red;" class="fas fa-trash"></i> Supprimer
                            </a>
                     </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
   </ul>
                            
                                

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-archive{{ $projetAction['id'] }}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: #d5972b;font-size: 120px; " class="fas fa-box"></i>
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/archive/1/{{ $projetAction['id'] }}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Archiver le projet : {{ $projetAction['nom'] }} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Archiver</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                         

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-delete{{ $projetAction['id'] }}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: red;font-size: 120px; " class="fas fa-trash"></i>
                  
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/delete/{{ $projetAction['id'] }}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Supprimer le projet : {{ $projetAction['nom'] }} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Supprimer</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                            </td>
   
    </tr>
    @endforeach
    </tbody>
    </table>
    @endif
    </td>
    </tr>
    </table>
</div>
<br>
<br>
@if( Auth::user()->id  == 1 || Auth::user()->id  == 2 || Auth::user()->id  == 3 || Auth::user()->id  == 10)
<div class="d-flex flex-column stat-box" style="background:#2d314b;color:#b9b9ba;margin-left:5%;">

    <table>
         <tr>
            <td>
                <p style="color: #d5972b;text-align:left;">Web Tv</p> <br>
                <H3 style="color:white;text-align:left;">Les écrits</H3>

            </td>
            <td style=" width:60%;">
            @if($projetActionCtrl->findProjetsStudentEcritWebtv(Auth::user()->id)->isEmpty() && $projetActionCtrl->findProjetsGroupStudentEcritWebtv(Auth::user()->id)->isEmpty() )
            Aucun ecrit en cours
            @else
            <table style="width:100%;">
         <thead> 
                         <th>PROJET</th>
                        <th>FORMAT</th>
                        <th>TYPE</th>
                        <th>STATUT</th>
                        <th>DERNIÈRE MODIFICATION</th>
                        <th></th>
                        <th></th>
         </thead >
        
         <tbody>


         @foreach ($projetActionCtrl->findProjetsStudentEcritWebtv(Auth::user()->id) as $projetAction)
         <tr style="background-color:  #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
                            <td ><a style="color: #d5972b;" href="/student/webtv/{{ $projetAction['id'] }}">{{ $projetAction['nom'] }}</a></td>
                            <td><a href="/student/webtv/{{ $projetAction['id'] }}">{{ $projetAction['type'] }}</a></td>
                            <td><a href="/student/webtv/{{ $projetAction['id'] }}">Individuel</a></td>
                            <td><a href="/student/webtv/{{ $projetAction['id'] }}">En cours</a></td>
                            <td><a href="/student/webtv/{{ $projetAction['id'] }}">
                            @foreach($actions as $action)
                                @if($action->projet_action_id ==  $projetAction['id'] )
                               @php echo date('d m Y H:i', strtotime($action->updated_at)); @endphp
                                @endif
                             @endforeach                       
                            </a></td>
                            <td><a href="/report/silence?id={{ $projetAction['id'] }}"style="color:#617A9A; text-align:center; font-size:15px;">  
                            <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/telecharger.png" alt="Télécharger" style=" height: 18px;padding-right:25px;" title="telecharger"/>
                            </a>
                            </td>
                            <td>
                            <a tabindex="0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                         </a>
    <ul class="dropdown-menu">
          
               <li><a class="dropdown-item"  href="#open-modal-archive{{ $projetAction['id'] }}" style="color:#617A9A; text-align:left; font-size:15px;">  
                            <i style="color: #d5972b;" class="fas fa-box"></i> Archiver
                            </a>
                     </li>
                     <li><a class="dropdown-item"  href="#open-modal-delete{{ $projetAction['id'] }}" style="color: red; text-align:left; font-size:15px;">  
                            <i style="color: red;" class="fas fa-trash"></i> Supprimer
                            </a>
                     </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
   </ul>
                            
                                

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-archive{{ $projetAction['id'] }}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: #d5972b;font-size: 120px; " class="fas fa-box"></i>
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/archive/1/{{ $projetAction['id'] }}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Archiver le projet  : {{ $projetAction['nom'] }} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Archiver</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                         

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-delete{{ $projetAction['id'] }}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: red;font-size: 120px; " class="fas fa-trash"></i>
                  
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/delete/{{ $projetAction['id'] }}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Supprimer le projet : {{ $projetAction['nom'] }} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Supprimer</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                            </td>
                            
                            </tr>
        @endforeach

        @foreach ($projetActionCtrl->findProjetsGroupStudentEcritWebtv(Auth::user()->id) as $projetAction)
        <tr style="background-color: #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
                            <td><a style="color: #d5972b;" href="/student/webtv/{{ $projetAction['id'] }}&c=0">{{ $projetAction['nom'] }}</a></td>
                            <td><a href="/student/webtv/{{ $projetAction['id'] }}">Film de {{ $projetAction['type'] }}</a></td>
                            <td><a href="/student/webtv/{{ $projetAction['id'] }}">Groupe</a></td>
                            <td><a href="/student/webtv/{{ $projetAction['id'] }}">En cours</a></td>
                            <td><a href="/student/webtv/{{ $projetAction['id'] }}">
                         
                               @php echo date('d m Y H:i', strtotime( $projetAction['updated_at'])); @endphp
                                              
                            </a>
                            </td>
                            <td><a href="/report/silence?id={{ $projetAction['id'] }}"style="color:#617A9A; text-align:center; font-size:15px;">  
                            <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/telecharger.png" alt="Télécharger" style=" height: 18px;padding-right:25px;" title="telecharger"/>
                            </a>
                            </td>
                            <td>
                            <a tabindex="0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                         </a>
    <ul class="dropdown-menu">
          
               <li><a class="dropdown-item"  href="#open-modal-archive{{ $projetAction['id'] }}" style="color:#617A9A; text-align:left; font-size:15px;">  
                            <i style="color: #d5972b;" class="fas fa-box"></i> Archiver
                            </a>
                     </li>
                     <li><a class="dropdown-item"  href="#open-modal-delete{{ $projetAction['id'] }}" style="color: red; text-align:left; font-size:15px;">  
                            <i style="color: red;" class="fas fa-trash"></i> Supprimer
                            </a>
                     </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
   </ul>
                            
                                

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-archive{{ $projetAction['id'] }}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: #d5972b;font-size: 120px; " class="fas fa-box"></i>
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/archive/1/{{ $projetAction['id'] }}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Archiver le projet  : {{ $projetAction['nom'] }} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Archiver</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                         

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-delete{{ $projetAction['id'] }}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: red;font-size: 120px; " class="fas fa-trash"></i>
                  
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/delete/{{ $projetAction['id'] }}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Supprimer le projet  : {{ $projetAction['nom'] }} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Supprimer</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                            </td>
   
    </tr>
    @endforeach
    </tbody>
    </table>
    @endif
    </td>
    </tr>
    </table>
    <table>
         <tr>
            <td>

                <H3 style="color:white;text-align:left;">Les préparations <br>de tournage</H3>

            </td>
            <td style=" width:60%;">
            @if($projetActionCtrl->findProjetsStudentTournageWebtv(Auth::user()->id)->isEmpty() && $projetActionCtrl->findProjetsStudentTournageWebtv(Auth::user()->id)->isEmpty() )
            Aucune préparation de tournage en cours
            @else
            <table style="width:100%;">
         <thead> 
                         <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
         </thead >
        
         <tbody>


         @foreach ($projetActionCtrl->findProjetsStudentTournageWebtv(Auth::user()->id) as $projetAction)
         <tr style="background-color:  #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
                            <td ><a style="color: #d5972b;" href="/student/webtv/{{ $projetAction['id'] }}">{{ $projetAction['nom'] }}</a></td>
                            <td><a href="/student/webtv/{{ $projetAction['id'] }}">{{ $projetAction['type'] }}</a></td>
                            <td><a href="/student/webtv/{{ $projetAction['id'] }}">Individuel</a></td>
                            <td><a href="/student/webtv/{{ $projetAction['id'] }}">En cours</a></td>
                            <td><a href="/student/webtv/{ $projetAction['id'] }}">
                            @foreach($actions as $action)
                                @if($action->projet_action_id ==  $projetAction['id'] )
                               @php echo date('d m Y H:i', strtotime($action->updated_at)); @endphp
                                @endif
                             @endforeach                       
                            </a></td>
                            <td><a href="/report/silence?id={{ $projetAction['id'] }}"style="color:#617A9A; text-align:center; font-size:15px;">  
                            <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/telecharger.png" alt="Télécharger" style=" height: 18px;padding-right:25px;" title="telecharger"/>
                            </a>
                            </td>
                            <td>
                            <a tabindex="0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                         </a>
    <ul class="dropdown-menu">
          
               <li><a class="dropdown-item"  href="#open-modal-archive{{ $projetAction['id'] }}" style="color:#617A9A; text-align:left; font-size:15px;">  
                            <i style="color: #d5972b;" class="fas fa-box"></i> Archiver
                            </a>
                     </li>
                     <li><a class="dropdown-item"  href="#open-modal-delete{{ $projetAction['id'] }}" style="color: red; text-align:left; font-size:15px;">  
                            <i style="color: red;" class="fas fa-trash"></i> Supprimer
                            </a>
                     </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
   </ul>
                            
                                

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-archive{{ $projetAction['id'] }}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: #d5972b;font-size: 120px; " class="fas fa-box"></i>
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/archive/1/{{ $projetAction['id'] }}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Etes vous sur de vouloir archiver le projet : {{ $projetAction['nom'] }} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Archiver</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                         

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-delete{{ $projetAction['id'] }}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: red;font-size: 120px; " class="fas fa-trash"></i>
                  
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/delete/{{ $projetAction['id'] }}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Etes vous sur de vouloir supprimer le projet : {{ $projetAction['nom'] }} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Supprimer</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                            </td>
                            
                            </tr>
        @endforeach

         @foreach ($projetActionCtrl->findProjetsGroupStudentTournageWebtv(Auth::user()->id) as $projetAction)
        <tr style="background-color: #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
                            <td><a style="color: #d5972b;" href="/student/webtv/{{ $projetAction['id'] }}">{{ $projetAction['nom'] }}</a></td>
                            <td><a href="/student/webtv/{{ $projetAction['id'] }}">Film de {{ $projetAction['type'] }}</a></td>
                            <td><a href="/student/webtv/{{ $projetAction['id'] }}">Groupe</a></td>
                            <td><a href="/student/webtv/{{ $projetAction['id'] }}">En cours</a></td>
                            <td><a href="/student/webtv/{{ $projetAction['id'] }}">
                         
                               @php echo date('d m Y H:i', strtotime( $projetAction['updated_at'])); @endphp
                                              
                            </a>
                            </td>
                            <td><a href="/report/silence?id={{ $projetAction['id'] }}"style="color:#617A9A; text-align:center; font-size:15px;">  
                            <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/telecharger.png" alt="Télécharger" style=" height: 18px;padding-right:25px;" title="telecharger"/>
                            </a>
                            </td>
                            <td>
                            <a tabindex="0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                         </a>
    <ul class="dropdown-menu">
          
               <li><a class="dropdown-item"  href="#open-modal-archive{{ $projetAction['id'] }}" style="color:#617A9A; text-align:left; font-size:15px;">  
                            <i style="color: #d5972b;" class="fas fa-box"></i> Archiver
                            </a>
                     </li>
                     <li><a class="dropdown-item"  href="#open-modal-delete{{ $projetAction['id'] }}" style="color: red; text-align:left; font-size:15px;">  
                            <i style="color: red;" class="fas fa-trash"></i> Supprimer
                            </a>
                     </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
   </ul>
                            
                                

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-archive{{ $projetAction['id'] }}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: #d5972b;font-size: 120px; " class="fas fa-box"></i>
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/archive/1/{{ $projetAction['id'] }}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Archiver le projet  : {{ $projetAction['nom'] }} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Archiver</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                         

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-delete{{ $projetAction['id'] }}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: red;font-size: 120px; " class="fas fa-trash"></i>
                  
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/delete/{{ $projetAction['id'] }}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Supprimer le projet :  : {{ $projetAction['nom'] }} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Supprimer</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                            </td>
   
    </tr>
    @endforeach
    </tbody>
    </table>
    @endif
    </td>
    </tr>
    </table>
</div>
@endif
<div class="col-md-4" style="padding-top: 10px;width:20%;margin-left:5%;">
<div class="d-flex flex-column stat-box" style="background:#2d314b;color:#b9b9ba;">
    <table>
         <tr>
            <td>
             Les projets archivés
            </td>
            <td>

            <a href="/student/archive">
                <i style="color: #d5972b; font-size: 36px" class="fas fa-box"></i>
            </a>
            </td>
        </tr>
    </table>
    </div>
</div>

    <!-- Creer projet modal -->
    <div class="modal fade" id="createProjetModal" tabindex="-1" role="dialog" aria-hidden="true">

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
                        Nouveau projet
                    </h3>
                    <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px);">
                        <form id="create_project_form" method="POST" action="/student/student-create">
                        <input type="hidden" name="redirect_url" value="/student/action" />
                        <input type="hidden" name="owner_type" value="student" />
                        <input type="hidden" name="classe" value="classe 1" />
                       
                            @csrf
                            <div class="form-group">
                                <label class="text-white" for="nameInput">Nom du projet</label>
                                <input type="text" class="form-control text-orange" id="nameInput" name="nom"
                                    placeholder="Nom du projet">
                            </div>
                            <div class="form-group">
                                <label class="text-white">Type de projet</label> <br />
                                <select class="form-control" name="type" >
                                    <option value="fiction"> fiction</option>
                                    <option value="cv video"> cv video</option>
                                           <option value="web tv"> web tv </option>
                                     @if( Auth::user()->id  == 1 || Auth::user()->id  == 2 || Auth::user()->id  == 3 || Auth::user()->id  == 10)
                 
                           
                                    <option value="pitch"> pitch </option>
                                    @endif
                                </select>
                                </div>
                            </div>
                        

      

                        <div class="text-end">
                            <button type="submit" 
                                class="btn btn-orange rounded-pill">Créer</button>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
    @if (request()->input('p', false))
        <!-- Modal -->
        <div class="modal fade" id="creationSuccessModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content pb-2" style="background: #3c3d5f;">
                    <div class="modal-body text-white">
                        <h2 class="mt-2">
                            Projet créé

                            <button class="btn float-end" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times text-white fa-2x"></i>
                            </button>
                        </h2>

                        <div class="text-center mt-5" style="margin-bottom: 64px;">
                            <i class="fas fa-check-circle fa-10x"
                                style="color: #de813b; background: radial-gradient(ellipse at center,  #FFF 50%, #3b3e5e 51%);"></i>
                            <div class="mt-3">
                                <span class="fs-1 d-block">Super !</span>
                                <span class="fs-4 d-block fw-light">Ton projet a été créé, tu peux commencer dès
                                    maintenant ou y revenir plus tard</span>
                            </div>
                        </div>

                        <div class="text-end">
                            <a class="btn btn-orange btn-lg rounded-3"
                                href="/student/action?c=0&p={{ request()->input('p') }}" style="margin-right: 48px;">Je
                                passe à l'ACTION!</a>
                            <button class="btn btn-lg btn-outline-light rounded-3"
                                data-bs-dismiss="modal">Terminé</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

            <!-- ARCHIVE projet modal -->

                <!-- Creer projet modal -->
                    <!-- DELETE projet modal -->

                        <!-- Creer projet modal -->
        <script type="text/javascript">
            $(document).ready(function() {
                $("#creationSuccessModal").modal('show');
            });
        </script>
    @endif


    <script src="/js/teacher_action.js"></script>
@endsection
