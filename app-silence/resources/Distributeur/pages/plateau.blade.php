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

        $projets_student = $projetActionCtrl->findProjetsStudent(Auth::user()->id);
        $projets_group = $projetActionCtrl->findProjetsGroupStudent(Auth::user()->id);

        $archive_student = $projetActionCtrl->findProjetsStudentArchive(Auth::user()->id);
        $archive_group = $projetActionCtrl->findProjetsGroupStudentArchive(Auth::user()->id);
 	

        $current_projects_number = count($projets_student) + count($projets_group);
        $archive_projects_number = count($archive_student) + count($archive_group);

    @endphp



<div class="container-fluid" style="color: #FFF; padding-top: 32px;">

    <div class="row">
        <div class="col-md-12" style="margin-bottom: 16px;">
            <h2 class="font-weight-bold">Tableau de bord, Mon Plateau</h2>
        </div>
        {{-- <div class="col-md-4">
            <div class="d-flex flex-column stat-box">
                <div class="align-self-center"><span class="main-number">12</span><span
                        class="sub-number">/14</span></div>
                <div class="sub-text align-self-end">Compte(s) utilisateur(s) actif(s)</div>
            </div>
        </div> --}}
         <div class="col-md-4">
            <div class="d-flex flex-column stat-box">
                <div class="align-self-center"><span class="main-number">{{ $current_projects_number }}  </span></div>
                <div class="sub-text align-self-center" style="padding-left: 12em;">Projets crées</div>
            </div>
        </div> 
        <div class="col-md-4">
            <div class="d-flex flex-column stat-box">
                <div class="align-self-center"><span class="main-number">{{ $archive_projects_number }} </span></div>
                <div class="sub-text align-self-center" style="padding-left: 12em;"><span>Projets archivés</span>
                </div>
            </div>
        </div>
    </div>

    <style>
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
            <h3 class="font-weight-bold">Les derniers projets en cours</h3>
        </div>
    </div>
@if ($projets_student->isEmpty() && $projets_student->isEmpty())
Aucun projet en cours
@else
    <div class="row">
        <div class="col-md-9">
            <table id="product-table" class="table table-sm table-bordered">
                <thead>
               		<th>Projet</th>
                    <th>Format</th>
                    <th>Type</th>
                    <th>Statut</th>
                    <th>Dernier projet créé </th>
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
                            <td><a href="/student/action?p={{$projet->id}}&c=0"> @php echo date('d m Y', strtotime($projet->created_at)); @endphp</a></td>
                                              
                        
                            <td>
                            @foreach($actions as $action)
                                @if($action->projet_action_id == $projet->id)
                            <a href="/report/silence?id={{ $action->id }}"style="color:#617A9A; text-align:left; font-size:15px;">  
                            <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/telecharger.png" alt="Télécharger" style=" height: 18px;padding-right:25px;" title="telecharger"/>
                           
                            </a>
                         @endif
                             @endforeach  
                          

                            </td>
                        </tr>
 
                  @endif
                   @endforeach

                   @php
                   $i=0;
                   @endphp 

                   @foreach ($projets_group as $proje)
                   @if($i < 4)
                   @php
                   $i++;
                   @endphp
                        <tr>
                        <td><a href="/student/action?p={{$proje->id}}&c=0">{{ $proje->nom }}</a></td>
                            <td><a href="/student/action?p={{$proje->id}}&c=0">Film de {{ $proje->type }}</a></td>
                            <td><a href="/student/action?p={{$proje->id}}&c=0">Groupe</a></td>
                            <td><a href="/student/action?p={{$proje->id}}&c=0">En cours</a></td>
                            <td><a href="/student/action?p={{$proje->id}}&c=0"> @php echo date('d m Y', strtotime($proje->created_at)); @endphp</a></td>
            
                            <td>
                            @foreach($actions as $action)
                                @if($action->projet_action_id == $proje->id)
                            <a href="/report/silence?id={{ $action->id }}"style="color:#617A9A; text-align:left; font-size:15px;">  
                            <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/telecharger.png" alt="Télécharger" style=" height: 18px;padding-right:25px;" title="telecharger"/>
                          
                            </a>
                         @endif
                             @endforeach 
                   

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
@endif
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