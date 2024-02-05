@extends('student.layouts.page', array('contentBackground' => '#33395e') )

@section('content')



<style>
   
        .creer-block {
            border: 1px solid #D5972B;
            border-radius: 10px;
            padding: 64px 0 96px;
            font-size: 24px;
            text-align: center;
            margin-left: 24px;
            margin-right: 24px;
            width: 300px;
            display: block;
        }

        .creer-block i {
            font-size: 64px;
            margin-bottom: 64px;
        }
    
    .main-number {
        color: #d5972b;
        font-weight: bold;
        font-size: 3em;
    }

    .sub-number {
        color: #8d641c;
        font-weight: bold;
        font-size: 1.5em;
    }

    .sub-text {
        font-size: 80%;
    }

    .stat-box {
        background: #d7dbec;
        border-radius: 8px;
        color: #333;
        padding: 16px;
    }

    .menu-box{
        background: #d5972b;
        border-radius: 8px;
        height: 120px;
        font-weight: bold;
    }

    #product-table thead{
        background: #FFF;

    }

    #product-table tbody{
        background: #4a4d77;
        color: #FFF;
    }

    #product-table , #product-table tbody *, #product-table thead *{
        border: none;
    }

</style>




<div class="container-fluid" style="color: #FFF; padding-top: 32px;">

    <div class="row">
    <div class="col-md-4" style="margin-bottom: 16px;">
        <a href="/student/action">
            <span style="background: rgba(255,255,255,0.1); padding:8px 16px; color:#AAA; border-radius:4px;">
                <i class="fas fa-arrow-left"></i>
            </span>
        </a>
        </div>
        <div class="col-md-4 text-end" style="margin-bottom: 16px; margin-left:30%;">
        <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal" data-bs-target="#createProjetModal">
            <i class="fas fa-plus-circle"></i>
            Nouveau projet
        </button>

       
    </div>
    </div>
    <style>


/* Styling modal */
.modal-window {
 position: fixed;
 font-family: 'Nunito';
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
  
        td, th{
            padding: 12px 8px !important;
            vertical-align: middle;
        }
        tr:hover{
        background-color: #A0A0A0;
        }
    </style>
    <div class="row" >
    <div class="col-md-4" style="margin-bottom: 16px;">
        <h2 class="font-weight-bold">Projets "{{$projet->nom}}"</h2>
    </div>

    <div class="col-md-4" style="margin-bottom: 16px;">
    <div class="d-flex align-items-center justify-content-between">
        <a href="/student/action?p={{ $projet->id }}&c=0">
            <span style="background: rgba(255,255,255,0.1); padding: 8px 16px; color: white; border-radius: 4px;">
                CONCEPT DE LA WEB TELE
            </span>
        </a>
        <a href="/report/silence?id={{ $projet->id }}" style="color: #617A9A; text-align: center; font-size: 15px; margin-left: 10px;">  
            <img src="/Icones Tableau de bord 2/Icones Orange/telecharger_orange.png" alt="Télécharger" style="height: 18px;" title="Télécharger"/>
        </a>
        <i class="fas fa-ellipsis-v"></i>
    </div>
                    
    <ul class="dropdown-menu">
          
               <li><a class="dropdown-item"  href="#open-modal-archive{{$projet->id}}" style="color:#617A9A; text-align:left; font-size:15px;">  
                            <i style="color: #d5972b;" class="fas fa-box"></i> Archiver
                            </a>
                     </li>
                     <li><a class="dropdown-item"  href="#open-modal-delete{{$projet->id}}" style="color: red; text-align:left; font-size:15px;">  
                            <i style="color: red;" class="fas fa-trash"></i> Suprimer
                            </a>
                     </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
   </ul>
                            
                                

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-archive{{$projet->id}}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: #d5972b;font-size: 120px; " class="fas fa-box"></i>
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/archive/1/{{$projet->id}}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Etes vous sur de vouloir archivé le projet : {{$projet->nom}}? </p>
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
 <div id="open-modal-delete{{$projet->id}}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: red;font-size: 120px; " class="fas fa-trash"></i>
                  
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/delete/{{$projet->id}}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Etes vous sur de vouloir suprimer le projet : {{$projet->nom}} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Suprimer</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                            
    </div>

   
</div>

  

    <div class="row">
        <div class="col-md-9">
            <table id="product-table" class="table table-sm table-bordered" style="width:130%;">
                <thead>
               		<th>Episode3 - Le succès de barbie</th>
                    <th>Format</th>
                    <th>Membres du projet</th>
                    <th>Derniere étape validée</th>
                    <th>Dernière modification</th>
                    <th>
    <div class="d-flex align-items-center">
        <a href="/report/silence?id=" style="color:#617A9A; text-align:center; font-size:15px; margin-right: 10px;">  
            <img src="/Icones Tableau de bord 2/Icones Orange/ajouter-un-bouton_orange.png" alt="Télécharger" style="height: 18px;" title="Télécharger"/>
        </a>
        <a href="/report/silence?id=" style="color:#617A9A; text-align:center; font-size:15px; margin-right: 10px;">  
            <img src="/Icones Tableau de bord 2/Icones Orange/telecharger_orange.png" alt="Télécharger" style="height: 18px;" title="Télécharger"/>
        </a>
        <i class="fas fa-ellipsis-v" style="color:orange;"></i>
    </div>
</th>
  
                </thead>
                <tbody>
                <tr>
                    <td>Barbie, un succès attendu</td>
                    <td>Emission</td>
                    <td>Georgia LESSALE, Néhémi JULIE,...</td>
                    <td>Planning de tournage</td>
                    <td>30/07/2023 12:17:50</td>
                 
                    <td>
                    <div class="d-flex align-items-center">
                        <a href="/report/silence?id=" style="color:#617A9A; text-align:center; font-size:15px;">  
                            <img src="/Icones Tableau de bord 2/Icones Orange/telecharger_orange.png" alt="Télécharger" style="height: 18px;" title="Télécharger"/>
                        </a>
                        <i class="fas fa-ellipsis-v ms-2" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                    
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a class="dropdown-item" href="#open-modal-archive{{$projet->id}}" style="color:#617A9A; text-align:left; font-size:12px;">  
                                <img src="/Icones Tableau de bord 2/Icones Violet/renommer_violet.png" alt="Modifier" style="height: 18px;" title="Modifier"/> Modifier
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#open-modal-archive{{$projet->id}}" style="color:#617A9A; text-align:left; font-size:12px;">  
                                <img src="/Icones Tableau de bord 2/Icones Violet/ajouter_violet.png" alt="Ajouter" style="height: 18px;" title="Ajouter"/> Ajouter un élève
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#open-modal-archive{{$projet->id}}" style="color:#617A9A; text-align:left; font-size:12px;">  
                                <img src="/Icones Tableau de bord 2/Icones Violet/déverrouillé_violet.png" alt="Déverrouiller" style="height: 18px;" title="Déverrouiller"/> Déverrouiller
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#open-modal-archive{{$projet->id}}" style="color:#617A9A; text-align:left; font-size:12px;">  
                                <img src="/Icones Tableau de bord 2/Icones Violet/archiver_violet.png" alt="Archiver" style="height: 18px;" title="Archiver"/> Archiver
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#open-modal-delete{{$projet->id}}" style="color: #617A9A; text-align:left; font-size:12px;">  
                                <img src="/Icones Tableau de bord 2/Icones Violet/poubelle_violet.png" alt="Supprimer" style="height: 18px;" title="Supprimer"/> Supprimer
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                                                
                
                    <!-- Modal ajouter decoupage  -->
                    <div id="open-modal-archive{{$projet->id}}" class="modal-window" >
                        <div>
                    
                                <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
                                <br>
                                        <br>
                                        <br>
                                        <i style="color: #d5972b;font-size: 120px; " class="fas fa-box"></i>
                                    <br>
                                        <br>
                    
                                <form id="action-form" class="flex-grow-1" method="GET" action="/archive/1/{{$projet->id}}" style="text-align:center;">
                                    @csrf
                                    <p style="color:black;">  Etes vous sur de vouloir archivé le projet : {{$projet->nom}}? </p>
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
                 <div id="open-modal-delete{{$projet->id}}" class="modal-window" >
                     <div>
                
                            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
                            <br>
                                    <br>
                                    <br>
                                    <i style="color: red;font-size: 120px; " class="fas fa-trash"></i>
                                  
                                   <br>
                                    <br>
                
                            <form id="action-form" class="flex-grow-1" method="GET" action="/delete/{{$projet->id}}" style="text-align:center;">
                                @csrf
                                  <p style="color:black;">  Etes vous sur de vouloir suprimer le projet : {{$projet->nom}} ? </p>
                                    <br>
                                           
                                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Suprimer</button>
                                                <br>
                                                <br>
                                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 
                
                            </form>
                     </div>
                </div>
                <!-- End The Modal -->
    </td>
                     
                </tr>                
             
                </tbody>
            </table>
        </div>
        <div class="col-md-3">

        </div>
    </div>

    <div class="row" style="padding: 32px;">
        {{-- <div class="col-md-3">
            <div class="d-flex flex-column justify-content-center align-items-center menu-box">
                Ressources
            </div>
        </div> --}}
        {{-- <div class="col-md-3">
            <div class="d-flex flex-column justify-content-center align-items-center menu-box">
                Les ateliers
            </div>
        </div> --}}
        {{-- <div class="col-md-3">
            <div class="d-flex flex-column justify-content-center align-items-center menu-box">
                Les vidéos
            </div>
        </div> --}}
        {{-- <div class="col-md-3">
            <div class="d-flex flex-column justify-content-center align-items-center menu-box">
                Les projets
            </div>
        </div> --}}
        {{-- <div class="col-md-12">
            <div style="padding: 32px; text-align:center; background:#524b57; margin-top:32px; font-size:1.2rem; font-weight: bold;">
                Fais ton Film ! Vous accompagne
            </div>
        </div> --}}
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
                Nouvel épisode
        </h3>
            <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px);">
                <form id="create_project_form" method="POST" action="/student/student-create">
                <input type="hidden" name="redirect_url" value="/student/action" />
                <input type="hidden" name="owner_type" value="student" />
                <input type="hidden" name="classe" value="classe 1" />
               
                    @csrf
                    <div class="form-group">
                        <label class="text-white" for="nameInput">Nom de l'épisode</label>
                        <input type="text" class="form-control text-orange" id="nameInput" name="nom"
                            placeholder="Nom du projet" style="font-size:12px;">
                    </div>

                    <div class="form-group">
                    <label class="text-white" for="nameInput">Lier à un nouveau projet</label>
                    <button type="button" class="btn btn-white btn-lg" data-bs-toggle="modal" data-bs-target="#createProjetModal" style="color:orange; width:100%; background-color:white; text-align:left;font-size:12px;">

            <img src="/Icones Tableau de bord 2/Icones Orange/ajouter-un-bouton_orange.png" alt="Télécharger" style="height: 18px;" title="Télécharger"/>

            Lier à un projet existant
        </button>
                    </div>

                    <div class="form-group">
                    <label class="text-white" for="nameInput">Nom de l'épisode</label>
                    <button type="button" class="btn btn-white btn-lg" data-bs-toggle="modal" data-bs-target="#createProjetModal" style="color:orange; width:100%; background-color:white; text-align:left;font-size:12px;">

            <img src="/Icones Tableau de bord 2/Icones Orange/ajouter-un-bouton_orange.png" alt="Télécharger" style="height: 18px;" title="Télécharger"/>

           Ajouter un projet existant
        </button>
                    </div>
                 <div class="form-group">
                    <label class="text-white" for="nameInput">Les projets de mon emission</label>
                    
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
<script>
    $(document).ready(function() {
        $('#dropdownMenuButton').dropdown();
    });
</script>


@endsection