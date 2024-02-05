<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class AbonnementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function sendAbonnementData(Request $request)
{
$curl = curl_init();

$ark = "ark:/28048/silence";
    // Récupérez les données du formulaire
    $idAbonnement = $request->input('idAbonnement');
    $commentaireAbonnement = $request->input('commentaireAbonnement');
    $debutValidite = $request->input('debutValidite');
    $finValidite = $request->input('finValidite');
    $uaiEtab = $request->input('uaiEtab');
    $categorieAffectation = $request->get('categorieAffectation');
    $typeAffectation = $request->get('typeAffectation');
    $nbLicenceGlobale = $request->input('nbLicenceGlobaleAFE');
    $codeProjetRessource = $request->input('codeProjetRessource');

    // Construisez le XML de la demande d'abonnement
    $xml = '<abonnement xmlns="http://www.atosworldline.com/wsabonnement/v1.0/">
        <idAbonnement>'. $idAbonnement .'</idAbonnement>
        <commentaireAbonnement>'. $commentaireAbonnement .'</commentaireAbonnement>
        <idDistributeurCom>877977389_0000000000000000</idDistributeurCom>
        <idRessource>'.$ark.'</idRessource>
        <typeIdRessource>ark</typeIdRessource>
        <libelleRessource>Silence FaisTonFilm</libelleRessource>
        <debutValidite>'. $debutValidite .'</debutValidite>
        <finValidite>'. $finValidite .'</finValidite>
        <uaiEtab>'. $uaiEtab .'</uaiEtab>
        <categorieAffectation>'. $categorieAffectation .'</categorieAffectation>
        <typeAffectation>'. $typeAffectation .'</typeAffectation>
        <nbLicenceGlobale>'. $nbLicenceGlobale .'</nbLicenceGlobale>
        <publicCible>ELEVE</publicCible>
        <publicCible>ENSEIGNANT</publicCible>
        <publicCible>DOCUMENTALISTE</publicCible>
        <publicCible>AUTRE PERSONNEL</publicCible>
        <codeProjetRessource>'. $codeProjetRessource .'</codeProjetRessource>
    </abonnement>';

    // Effectuez la requête CURL pour envoyer les données
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://abonnement.gar.education.fr/$idAbonnement",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => $xml,
        CURLOPT_SSLKEY => "keys/key_gar/server_1and1_prod.pem",
        CURLOPT_SSLCERT => 'keys/faistonfilm.co-prod.pem',
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/xml;charset=utf-8",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
}
   public function updateAbonnementData(Request $request)
{
$curl = curl_init();

$ark = "ark:/28048/silence";
    // Récupérez les données du formulaire
    $idAbonnement = $request->input('idAbonnement');
    $commentaireAbonnement = $request->input('commentaireAbonnement');
    $debutValidite = $request->input('debutValidite');
    $finValidite = $request->input('finValidite');
    $categorieAffectation = $request->get('categorieAffectation');
    $typeAffectation = $request->get('typeAffectation');
    $nbLicenceGlobale = $request->input('nbLicenceGlobaleAFE');
    $codeProjetRessource = $request->input('codeProjetRessource');

    // Construisez le XML de la demande d'abonnement
    $xml = '<abonnement xmlns="http://www.atosworldline.com/wsabonnement/v1.0/">
        <idAbonnement>'. $idAbonnement .'</idAbonnement>
        <commentaireAbonnement>'. $commentaireAbonnement .'</commentaireAbonnement>
        <idDistributeurCom>877977389_0000000000000000</idDistributeurCom>
        <idRessource>'.$ark.'</idRessource>
        <typeIdRessource>ark</typeIdRessource>
        <libelleRessource>Silence FaisTonFilm</libelleRessource>
        <debutValidite>'. $debutValidite .'</debutValidite>
        <finValidite>'. $finValidite .'</finValidite>
        <categorieAffectation>'. $categorieAffectation .'</categorieAffectation>
        <typeAffectation>'. $typeAffectation .'</typeAffectation>
        <nbLicenceGlobale>'. $nbLicenceGlobale .'</nbLicenceGlobale>
        <publicCible>ELEVE</publicCible>
        <publicCible>ENSEIGNANT</publicCible>
        <publicCible>DOCUMENTALISTE</publicCible>
        <publicCible>AUTRE PERSONNEL</publicCible>
        <codeProjetRessource>'. $codeProjetRessource .'</codeProjetRessource>
    </abonnement>';

    // Effectuez la requête CURL pour envoyer les données
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://abonnement.gar.education.fr/$idAbonnement",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $xml,
        CURLOPT_SSLKEY => "keys/key_gar/server_1and1_prod.pem",
        CURLOPT_SSLCERT => 'keys/faistonfilm.co-prod.pem',
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/xml;charset=utf-8",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
}
public function deleteAbonnementData(Request $request)
{
    $curl = curl_init();

    $idAbonnement = $request->input('idAbonnement');

    // Effectuez la requête CURL pour envoyer les données
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://abonnement.gar.education.fr/$idAbonnement",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_SSLKEY => "keys/key_gar/server_1and1_prod.pem",
        CURLOPT_SSLCERT => 'keys/faistonfilm.co-prod.pem',
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/xml;charset=utf-8",
        ),
    ));

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } elseif ($httpCode === 204) {
        echo "Successfully deleted the abonnement with ID $idAbonnement.";
    } else {
        echo "Failed to delete the abonnement. HTTP Code: $httpCode, Response: $response";
    }
}


    function sendAbonnementDat(Request $request)
        {

            $curl = curl_init();

            $ark = "ark:/28048/silence";
     		$commentaireAbonnement = $request->commentaireAbonnement;
            $debutValidite = $request->debutValidite;
            $anneeFinValidite = $request->anneeFinValidite;
            $uaiEtab = $request->uaiEtab;
            $nbLicenceGlobale = $request->nbLicenceGlobale;
			
            $id_abonnement = "TESTS-2023-08-15_2023-06-06";
            // $ark = "ark:/28048.p";
            // $ark = "ark:/1657727558.p";

            $xml = '<abonnement xmlns="http://www.atosworldline.com/wsabonnement/v1.0/">
                <idAbonnement>'.$id_abonnement.'</idAbonnement>
                <commentaireAbonnement>'.$commentaireAbonnement.'</commentaireAbonnement>
                <idDistributeurCom>877977389_0000000000000000</idDistributeurCom>
                <idRessource>'.$ark.'</idRessource>
                <typeIdRessource>ark</typeIdRessource>
                <libelleRessource>Silence FaisTonFilm</libelleRessource>
                <debutValidite>2022-11-15T00:00:00</debutValidite>
                <anneeFinValidite>'.$anneeFinValidite.'</anneeFinValidite>
                <uaiEtab>9999999P</uaiEtab>
                <categorieAffectation>transferable</categorieAffectation>
                <typeAffectation>INDIV</typeAffectation>
                <nbLicenceGlobale>'.$nbLicenceGlobale.'</nbLicenceGlobale>
                <publicCible>ELEVE</publicCible>
                <publicCible>ENSEIGNANT</publicCible>
                <publicCible>DOCUMENTALISTE</publicCible>
                <publicCible>AUTRE PERSONNEL</publicCible>
            </abonnement>';

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://abonnement.gar.education.fr/$id_abonnement",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CUSTOMREQUEST => "PUT",
                CURLOPT_POSTFIELDS => $xml,
                CURLOPT_SSLKEY => "keys/key_gar/server_1and1_prod.pem",
                CURLOPT_SSLCERT => 'keys/faistonfilm.co-prod.pem',
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/xml;charset=utf-8",
                ),
            ));

            $response = curl_exec($curl);

            print_r($response);

            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo $uaiEtab."cURL Error #:" . $err;
  
            } else {
                echo $response;
         
            }

        }

    public function sendAbonnementDatas(Request $request)
    {
        $abonnement=array(
              
            "idAbonnement" => $request->idAbonnement,
            "commentaireAbonnement" =>  $request->commentaireAbonnement,
            "debutValidite" =>  $request->debutValidite,
            "anneeFinValidite"   =>  $request->anneeFinValidite,
            "uaiEtab"=>  $request->uaiEtab,
            "nbLicenceGlobale" =>  $request->nbLicenceGlobale,
        );

        return view('student.pages.cree-abonnememt', ['abonnement' => $abonnement]); 
    }
}
