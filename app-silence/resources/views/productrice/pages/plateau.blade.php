@extends('productrice.layouts.page', array('contentBackground' => '#33395e') )

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
        use App\Http\Controllers\Productrice\ProjetActionController;
        use App\Models\Action;
        use App\Models\User;
        $projetActionCtrl = new ProjetActionController();
        $actions = Action::all();
        $users = User::all();
        $users = count($users);
        $projets_student = $projetActionCtrl->findProjetsStudent(Auth::user()->id);
        $projets_group = $projetActionCtrl->findProjetsGroupStudent(Auth::user()->id);
        $current_projects_number_perso = count($projets_student);
        $current_projects_number = count($projets_group);

    @endphp



<div class="container-fluid" style="color: #FFF; padding-top: 32px;">

    <div class="row">
        <div class="col-md-12" style="margin-bottom: 16px;">
            <h2 class="font-weight-bold">HELLO {{Auth::user()->name}} !</h2>
            <p style="color:#b9b9ba;font-size: 14px;">Ici tout ce que s'est passé dans la Silence !</p>
        </div>
   
    
        <div class="col-md-4" style=" padding-top: 10px;width:20%;">
            <div class="d-flex flex-column stat-box" style="background:#2d314b;color:#b9b9ba;">
                <div class="sub-text align-self-right" style="font-size: 16px;">UTILISATEURS</div>
                <div class="align-self-right"><span class="main-number" style="color:white;">{{$users}}</span></div>
                <hr>
                <div class="sub-text align-self-right" style="color:green;">+ 100 Par rapport à la semaine dernière</div>
            </div>
        </div> 
        <div class="col-md-4" style=" padding-top: 10px;width:20%;">
            <div class="d-flex flex-column stat-box" style="background:#2d314b;color:#b9b9ba;">
                <div class="sub-text align-self-right" style="font-size: 16px;">PROJETS EN COURS</div>
                <div class="align-self-right"><span class="main-number" style="color:white;">{{$current_projects_number}}</span></div>
                <hr>
                <div class="sub-text align-self-right" style="color:4a4c63;">PERSONNEL : {{$current_projects_number_perso}}</div>
            </div>
        </div> 
       {{-- <div class="col-md-4" style=" padding-top: 10px;width:20%;">
            <div class="d-flex flex-column stat-box" style="background:#2d314b;color:#b9b9ba;">
                <div class="sub-text align-self-right" style="font-size: 16px;">POST ATELIER</div>
                <div class="align-self-right"><span class="main-number" style="color:white;">{{$current_projects_number}}</span></div>
                <hr>
                <div class="sub-text align-self-right" style="color:4a4c63;"></div>
            </div>
        </div> --}}

      
    </div>

    <style>
        thead,th{
            padding: 12px 8px !important;
            vertical-align: middle;
            border-color:transparent;
            background-color: transparent;
            text-align:center;

        }
        td, tr{
           padding-left:10px; 

           text-align:center;
          
        }
    </style>

    <div class="row mb-3">
        <div class="col-md-12" style="margin-top: 48px;">
            <h3 class="font-weight-bold">PROJETS CLIENT EN COURS</h3>
        </div>
    </div>
    <div class="col-md-6 text-end" style="margin-bottom: 10px; float:right;width:30%;">
                <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
                    data-bs-target="#createProjetModal">
                    <i class="fas fa-plus-circle"></i>
                    Nouveau projet
                </button>
    </div>
    <div class="d-flex flex-column stat-box" style="background:#2d314b;color:#b9b9ba;width:70%;">
    
    <table>
         <thead> 
            <th>Nom <br> Projet</th>
            <th>Type(s) de projet</th>
            <th>Anné <br> Scolaire</th>
            <th>Ville</th>
            <th>Ecole</th>
            <th>Date de <br> Tournage</th>
            <th>Réalisateur*rice <br> Fais ton Film!</th>
         </thead >
        
         <tbody>
         @php
          $i=0;
          var_dump(Auth::user()->id);
          @endphp 
         @foreach ($projets_group as $projet)
         @if($i < 4)
         @php $i++; @endphp
         <tr style="background-color: #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
            <td>{{$projet->nom}}</td>
            <td>{{$projet->type}}</td>
            <td>{{$projet->année_scolaire}}</td>
            <td>{{$projet->ville}}</td>
            <td>{{$projet->ecole}}</td>
            <td>{{$projet->date_tournage}}</td>
            <td>        
                <img src="/images/{{$projet->réalisateur}}.png"  style="vertical-align: middle; margin-left: 8px;   border: 1px solid white; border-radius: 45%; width:30px;" >
            </td>
         </tr>
         @endif
        @endforeach
         </tbody>
    </table>

    </div>
    <br>
    <br>
    
    <br>
    <div class="row mb-3">
        <div class="col-md-12" style="margin-top: 48px;">
            <h3 class="font-weight-bold">PROJETS PERSONNEL EN COURS</h3>
        </div>
    </div>
    <div class="col-md-6 text-end" style="margin-bottom: 10px; float:right;width:30%;">
                <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
                    data-bs-target="#createProjetModal2">
                    <i class="fas fa-plus-circle"></i>
                    Nouveau projet
                </button>
    </div>
    <div class="d-flex flex-column stat-box" style="background:#2d314b;color:#b9b9ba;">
    <table>
         <thead> 
            <th>Projet</th>
            <th>Format</th>
            <th>Type</th>
            <th>Debut du <br> projet</th>
            <th>Dernnieres modification</th>
            <th></th>
         </thead>
        
         <tbody>
         @php
                $i=0;
                @endphp 
                @foreach ($projets_student as $projet)
                @if(empty($projet->ville))
                @if($i < 4)
                @php
                $i++;
                @endphp
                <tr style="background-color: #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
                            <td style="color: #947242;"><a href="/student/action?p={{$projet->id}}&c=0">{{ $projet->nom }}</a></td>
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
                  @endif
                   @endforeach
         </tr>
    
         </tbody>
    </table>

    </div>


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
                        NOUVEAU PROJET CLIENT
                    </h3>
                    <br>
                    <div style="width:100%;">
                <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
                    data-bs-target="#createProjetModalEnfant">
                    <i class="fas fa-plus-circle"></i>
                   Atelier Enfant
                </button>
             </div>
             <br>
             <div style="width:100%;">
                <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
                    data-bs-target="#createProjetModalAdos">
                    <i class="fas fa-plus-circle"></i>
                    Atelier Ados
                </button>
             </div>

                    

                </div>
            </div>
        </div>

    </div>
     <!-- Creer projet modal -->
     <!-- Creer projet modal -->
    <div class="modal fade" id="createProjetModalEnfant" tabindex="-1" role="dialog" aria-hidden="true">

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
                NOUVEAU PROJET CLIENT ENFANT
            </h3>
            <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px); padding:30px;">
            <form id="create_project_form" method="POST" action="/productrice/creer">    
                @csrf
                <input type="hidden" name="redirectUrl" value="/productrice/plateau" />
                <input type="hidden" name="owner_type" value="student" />
                <input type="hidden" name="classe" value="classe 1" /> 
               
                    <div class="form-group">

                        <input type="text" class="form-control text-orange" id="nameInput" name="nom"
                            placeholder="Nom du projet">
                    </div>
                    <br>
                    <div class="form-group">
                        <select name="type" id="type"  class="form-control text-orange">
                        <option value="fiction">fiction</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                    <select name="année-scolaire" id="année-scolaire" class="form-control text-orange">
                  
                        <option value="2023/2024">2023/2024</option>
                        <option value="2024/2025">2024/2025</option>
                        <option value="2025/2026">2025/2026</option>
                        <option value="2026/2027">2026/2027</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">      
                        <input type="text" class="form-control text-orange" id="ville" name="ville"
                            placeholder="Ville">
                    </div>
                    <br>
                    <div class="form-group">      
                        <input type="text" class="form-control text-orange" id="ecole" name="ecole"
                            placeholder="Ecole">
                    </div>
                    <br>

                    <div class="form-group">      
                        <input type="text" class="form-control text-orange" id="producteur" name="producteur"
                            placeholder="Producteur Associé">
                    </div>
                    <br>
                    <div class="form-group">      
                        <input type="text" class="form-control text-orange" id="animateur" name="animateur"
                            placeholder="Animateur">
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="date" class="form-control text-orange" id="date_tournage" name="date_tournage"
                            placeholder="Date de tournage">
                    </div>
                    <br>
                    <div class="form-group">
                    <select name="réalisateur" id="réalisateur" class="form-control text-orange">
                        <option value="Aminata">Aminata</option>
                        <option value="khartoum">Georgia</option>
                    </select>
                    </div>
                    <br>
                <div class="text-end">
                    <button type="submit" 
                        class="btn btn-orange rounded-pill">Créer</button>
                </div>
        </form>
            </div>


        </div>
    </div>
</div>

</div>
<!-- Creer projet modal -->
 <!-- Creer projet modal -->
 <div class="modal fade" id="createProjetModalAdos" tabindex="-1" role="dialog" aria-hidden="true">

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
                NOUVEAU PROJET CLIENT ADOS
            </h3>
            <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px); padding:30px;">
                <form id="create_project_form" method="POST" action="/productrice/creer">    
                @csrf
                <input type="hidden" name="redirectUrl" value="/productrice/plateau" />
                <input type="hidden" name="owner_type" value="student" />
                <input type="hidden" name="classe" value="classe 1" />

              
                    <div class="form-group">

                        <input type="text" class="form-control text-orange" id="nameInput" name="nom"
                            placeholder="Nom du projet">
                    </div>
                    <br>
                    <div class="form-group">
                        <select name="type" id="type"  class="form-control text-orange">
                        <option value="fiction">fiction</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                    <select name="année_scolaire" id="année_scolaire" class="form-control text-orange">
                  
                        <option value="2023/2024">2023/2024</option>
                        <option value="2024/2025">2024/2025</option>
                        <option value="2025/2026">2025/2026</option>
                        <option value="2026/2027">2026/2027</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">      
                        <input type="text" class="form-control text-orange" id="ville" name="ville"
                            placeholder="Ville">
                    </div>
                    <br>

                    <div class="form-group">      
                        <input type="text" class="form-control text-orange" id="producteur" name="producteur"
                            placeholder="Producteur Associé">
                    </div>
                    <br>
                    <div class="form-group">      
                        <input type="text" class="form-control text-orange" id="animateur" name="animateur"
                            placeholder="Animateur">
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="date" class="form-control text-orange" id="date_tournage" name="date_tournage"
                            placeholder="Date de tournage">
                    </div>
                    <br>
                    <div class="form-group">
                    <select name="réalisateur" id="réalisateur" class="form-control text-orange">
                        <option value="Aminata">Aminata</option>
                        <option value="Georgia">Georgia</option>
                    </select>
                    </div>
                    <br>
                <div class="text-end">
                    <button type="submit" 
                        class="btn btn-orange rounded-pill">Créer</button>
                </div>
        </form>
            </div>


        </div>
    </div>
</div>

</div>
<!-- Creer projet modal -->
 
     <div class="modal fade" id="createProjetModal2" tabindex="-1" role="dialog" aria-hidden="true">

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
                NOUVEAU PROJET PERSONNEL
            </h3>
            <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px); padding:30px;">
                <form id="create_project_form" method="POST" action="/productrice/student-create">
                <input type="hidden" name="redirect_url" value="/productrice/action" />
                <input type="hidden" name="owner_type" value="student" />
                <input type="hidden" name="classe" value="classe 1" />
               
                    @csrf
                    <div class="form-group">

                        <input type="text" class="form-control text-orange" id="nameInput" name="nom"
                            placeholder="Nom du projet">
                    </div>
                    <br>
                    <div class="form-group">
                        <select name="type" id="type"  class="form-control text-orange">
                        <option value="fiction">fiction</option>
                        </select>
                    </div>
                    <br>
                      <div class="text-end">
                    <button type="submit" 
                        class="btn btn-orange rounded-pill">Créer</button>
                </div>
            </div>


        </div>
    </div>
</div>

</div>

</div>

@endsection
@yield('scripts')