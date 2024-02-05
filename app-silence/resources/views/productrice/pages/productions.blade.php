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
        $projetActionCtrl = new ProjetActionController();
  
        $actions = Action::all();
        $projets_student = $projetActionCtrl->findProjetsStudent(Auth::user()->id);
        $projets_group = $projetActionCtrl->findProjetsGroupStudent(Auth::user()->id);
 	

        $current_projects_number = count($projets_student) + count($projets_group);

    @endphp



<div class="container-fluid" style="color: #FFF; padding-top: 32px;">



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
            <h3 class="font-weight-bold">LES PRODUCTIONS</h3>
        </div>
    </div>

    <div class="col-md-6 text-end" style="margin-bottom: 10px; float:right;width:100%;">
                <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
                    data-bs-target="#createProjetModal">
                    <i class="fas fa-plus-circle"></i>
                    Ajouter un abonnements
                </button>
                <br>
    <br>
    </div>


  
    <div class="col-md-6 text-end" style="margin-bottom: 10px; float:right;width:100%;">
                <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
                    data-bs-target="#createProjetModal" style="background-color:white;color:black;">
                    Enfant
                </button>
                <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
                    data-bs-target="#createProjetModal" style="background-color:white;color:black;">
                    
                    Ados
                </button>
                <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
                    data-bs-target="#createProjetModal">
             
                    Tous les projets
                </button>
                <br>
               
    </div>
    <div class="d-flex flex-column stat-box" style="background:#2d314b;color:#b9b9ba;">
    <table>
         <tr>
            <td >
                <p style="color: #947242;float:left;">ACTION!
              <H3 style="color:white;float:left;">  Les projets en cours </H3>
              </p>
            </td>
            <td style=" width:80%;">
            <table style="width:100%;">
         <thead> 
            <th>Anné <br> Scolaire</th>
            <th>Ville</th>
            <th>Type(s) de projet</th>
            <th>Debut du <br> projet</th>
            <th>Tournage</th>
            <th>Réalisateur*rice <br> Fais ton Film!</th>
            <th></th>
         </thead >
        
         <tbody>

         <tr style="background-color: #3a3f62; height:50px;border-radius: 50px; padding-top:5px;">
         <td style="color: #947242;">2022/2023</td>
            <td>Morangis</td>
            <td>Film de Fiction</td>
            <td>16/09/2022</td>
            <td>06/04/2023</td>
            <td><img src="/images/aminata.png"  style="vertical-align: middle; margin-left: 8px; border-radius: 50%; width:30px;" ></td>
            <th>
                
            </th>
         </tr>
    
         </tbody>
    </table>
            </td>
         </tr>
      
    </table>

  
    </div>


        </div>
   </div>




    <!-- Ajouter un cour dans un parti -->
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
                        Ajouter  Un Abonnement
                    </h3>
                    <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px);">
                    <form method="POST" action="/student/create-abonnememt">
@csrf

    <div class="form-group">
        <label style="color:white;" for="idAbonnement">Identifiant abonnement</label>
        <input type="text" class="form-control" id="idAbonnement" name="idAbonnement" aria-describedby="idAbonnementHelp" placeholder="Enter Identifiant abonnement">
        <small id="idAbonnementHelp" class="form-text text-muted">Exemple : "TESTS-2023-08-15_2023-02-07" </small>
    </div>
    <div class="form-group">
        <label style="color:white;" for="commentaireAbonnement">Commentaire Abonnement</label>
        <input type="text" class="form-control" id="commentaireAbonnement" name="commentaireAbonnement" aria-describedby="commentaireAbonnementHelp" placeholder="Enter Commentaire Abonnement">
        <small id="commentaireAbonnementHelp" class="form-text text-muted">Exemple : "Abonnement test de khartoum" </small>
    </div>
    <div class="form-group">
        <label style="color:white;" for="debutValidite">Debut de Validite</label>
        <input type="text" class="form-control" id="debutValidite" name="debutValidite" aria-describedby="debutValiditeHelp" placeholder="Enter Debut de Validite">
        <small id="debutValiditeHelp" class="form-text text-muted">Exemple : "2023-04-16T00:00:00" </small>
    </div>
    <div class="form-group">
        <label style="color:white;" for="anneeFinValidite">Annee Fin Validite</label>
        <input type="text" class="form-control" id="anneeFinValidite" name="anneeFinValidite" aria-describedby="anneeFinValiditeHelp" placeholder="Enter Annee Fin Validite">
        <small id="anneeFinValiditeHelp" class="form-text text-muted">Exemple : "2022-2023" </small>
    </div>
    <div class="form-group">
        <label style="color:white;" for="uaiEtab">UAI Etablissement</label>
        <input type="text" class="form-control" id="uaiEtab" name="uaiEtab" aria-describedby="uaiEtabHelp" placeholder="Enter UAI Etablissement">
        <small id="uaiEtabHelp" class="form-text text-muted">Exemple : "9999997S" </small>
    </div>
    <div class="form-group">
        <label style="color:white;" for="uaiEtab">Categorie Affectation </label>
        <select class="form-control" id="categorieAffectation" name="categorieAffectation">
      <option value="transferable">transferable</option>
      <option value="non transferable">non transferable</option>
    </select>
    </div>
    <br>
    <div class="form-group">
        <label style="color:white;" for="uaiEtab">Type Affectation</label>
        <select class="form-control" id="typeAffectation" name="typeAffectation">
      <option value="INDIV">INDIV</option>
      <option value="ETABL">ETABL</option>
    </select>
    </div>
    <br>
    <div class="form-group">
        <label style="color:white;" for="nbLicenceGlobale">Nombre Licence Globale</label>
        <input type="text" class="form-control" id="nbLicenceGlobale" name="nbLicenceGlobale" aria-describedby="nbLicenceGlobaleHelp" placeholder="Enter Nombre Licence Globale">
        <small id="nbLicenceGlobaleHelp" class="form-text text-muted">Exemple : "15" </small>
    </div>

    <div class="form-group">
        <label style="color:white;" for="nbLicenceGlobale">Nombre Licence Ensegnant</label>
        <input type="text" class="form-control" id="nbLicenceGlobale" name="nbLicenceGlobale" aria-describedby="nbLicenceGlobaleHelp" placeholder="Enter Nombre Licence Ensegnant">
        <small id="nbLicenceGlobaleHelp" class="form-text text-muted">Exemple : "15" </small>
    </div>
    <div class="form-group">
        <label style="color:white;" for="nbLicenceGlobale">Nombre Licence Eleve</label>
        <input type="text" class="form-control" id="nbLicenceGlobale" name="nbLicenceGlobale" aria-describedby="nbLicenceGlobaleHelp" placeholder="Enter Nombre Licence Eleve">
        <small id="nbLicenceGlobaleHelp" class="form-text text-muted">Exemple : "15" </small>
    </div>

    <div class="form-group">
        <label style="color:white;" for="nbLicenceGlobale">Nombre Licence Documentaliste</label>
        <input type="text" class="form-control" id="nbLicenceGlobale" name="nbLicenceGlobale" aria-describedby="nbLicenceGlobaleHelp" placeholder="Enter Nombre Licence Documentaliste">
        <small id="nbLicenceGlobaleHelp" class="form-text text-muted">Exemple : "15" </small>
    </div>
    <div class="form-group">
        <label style="color:white;" for="nbLicenceGlobale">Nombre Licence Autre personnel</label>
        <input type="text" class="form-control" id="nbLicenceGlobale" name="nbLicenceGlobale" aria-describedby="nbLicenceGlobaleHelp" placeholder="Enter Nombre Autre personnel">
        <small id="nbLicenceGlobaleHelp" class="form-text text-muted">Exemple : "15" </small>
    </div>

    <div class="form-group">
        <label style="color:white;" for="nbLicenceGlobale">Code projet ressources</label>
        <input type="text" class="form-control" id="nbLicenceGlobale" name="nbLicenceGlobale" aria-describedby="nbLicenceGlobaleHelp" placeholder="Enter Code projet ressources">
        <small id="nbLicenceGlobaleHelp" class="form-text text-muted">Exemple : "SA2021" </small>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
                </div>
            </div>
        </div>

    </div>

    <!-- Ajouter un cour dans un parti -->
    </div>
    </div>
@endsection