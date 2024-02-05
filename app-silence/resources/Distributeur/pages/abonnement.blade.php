@extends('student.layouts.page', array('contentBackground' => '#33395e') )

@section('content')
<h1 style="color:white;">Ajouter un Abonnement</h1>
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
@endsection

