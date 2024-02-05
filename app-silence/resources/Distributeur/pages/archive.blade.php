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

@php
        use App\Http\Controllers\ProjetActionController;
        use App\Models\Action;
        $projetActionCtrl = new ProjetActionController();
  
        $actions = Action::all();
        $projets_student = $projetActionCtrl->findProjetsStudentArchive(Auth::user()->id);
        $projets_group = $projetActionCtrl->findProjetsGroupStudentArchive(Auth::user()->id);
 	

        $current_projects_number = count($projets_student) + count($projets_group);

    @endphp



<div class="container-fluid" style="color: #FFF; padding-top: 32px;">

    <div class="row">
        <div class="col-md-12" style="margin-bottom: 16px;">
        <a href="/student/action">
            <span style="background: rgba(255,255,255,0.1); padding:8px 16px; color:#AAA; border-radius:4px;">
                <i class="fas fa-arrow-left"></i>
            </span>
        </a>

        </div>
        {{-- <div class="col-md-4">
            <div class="d-flex flex-column stat-box">
                <div class="align-self-center"><span class="main-number">12</span><span
                        class="sub-number">/14</span></div>
                <div class="sub-text align-self-end">Compte(s) utilisateur(s) actif(s)</div>
            </div>
        </div> --}}
        
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

    <div class="row mb-3">
        <div class="col-md-12" style="margin-top: 48px;">
            <h3 class="font-weight-bold">Projets archivé</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <table id="product-table" class="table table-sm table-bordered">
                <thead>
               		<th>Projet</th>
                    <th>Format</th>
                    <th>Type</th>
                    <th>Statut</th>
                    <th>Dernière modification</th>
                    <th></th>
  
                </thead>
                <tbody>
                @php
                $i=0;
                @endphp 
                @foreach ($projets_student as $projet)
                @if($i < 4)
                @php
                $i++;
                @endphp
                        <tr>
                            <td><a href="/student/action?p={{$projet->id}}&c=0">{{ $projet->nom }}</a></td>
                            <td><a href="/student/action?p={{$projet->id}}&c=0">Film de {{ $projet->type }}</a></td>
                            <td><a href="/student/action?p={{$projet->id}}&c=0">Individuel</a></td>
                            <td><a href="/student/action?p={{$projet->id}}&c=0">En cours</a></td>
                            <td><a href="/student/action?p={{$projet->id}}&c=0">
                            @foreach($actions as $action)
                                @if($action->projet_action_id ==  $projet->id )
                               @php echo date('d m Y H:i', strtotime($action->updated_at)); @endphp
                                @endif
                             @endforeach                      
                            </a></td>
                            <td><a href="#open-modal-archive{{$projet->id}}" style="color:#617A9A; text-align:center; font-size:15px;">  
                            <i style="color: #d5972b;" class="fas fa-box"></i>
                            </a>

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

            <form id="action-form" class="flex-grow-1" method="GET" action="/archive/0/{{$projet->id}}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Etes vous sur de vouloir archivé le projet : {{$projet->nom}} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Décompresser</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                            </td>
                        


                        </tr>
 
                  @endif
                   @endforeach

                   @php
                   $i=0;
                   @endphp 

                   @foreach ($projets_group as $proje)
                   @if($i < 5)
                   @php
                   $i++;
                   @endphp
                        <tr>
                        <td><a href="/student/action?p={{$proje->id}}&c=0">{{ $proje->nom }}</a></td>
                            <td><a href="/student/action?p={{$proje->id}}&c=0">Film de {{ $proje->type }}</a></td>
                            <td><a href="/student/action?p={{$proje->id}}&c=0">Groupe</a></td>
                            <td><a href="/student/action?p={{$proje->id}}&c=0">En cours</a></td>
                            <td>
                            @foreach($actions as $action)
                                @if($action->projet_action_id ==  $proje->id )
                               @php echo date('d m Y H:i', strtotime($action->updated_at)); @endphp
                                @endif
                             @endforeach 
                            </td>
                            <td><a href="#open-modal-archive{{$proje->id}}" style="color:#617A9A; text-align:center; font-size:15px;">  
                            <i style="color: #d5972b;" class="fas fa-box"></i>
                            </a>

 <!-- Modal ajouter decoupage  -->
 <div id="open-modal-archive{{$proje->id}}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: #d5972b;font-size: 120px; " class="fas fa-box"></i>
                   <br>
                    <br>

            <form id="action-form" class="flex-grow-1" method="GET" action="/archive/0/{{$proje->id}}" style="text-align:center;">
                @csrf
                  <p style="color:black;">  Etes vous sur de vouloir archivé le projet : {{$proje->nom}} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Décompresser</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                            </td>
                            
                     </tr>

                @endif
                @endforeach
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


</div>

@endsection