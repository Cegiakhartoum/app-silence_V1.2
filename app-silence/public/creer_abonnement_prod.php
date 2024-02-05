<?php

$curl = curl_init();

$ark = "ark:/28048/silence";
$id_abonnement = "PROD-2023-08-15_2022-11-15";
// $ark = "ark:/28048.p";
// $ark = "ark:/1657727558.p";

$xml = '<abonnement xmlns="http://www.atosworldline.com/wsabonnement/v1.0/">
    <idAbonnement>'. $id_abonnement .'</idAbonnement>
    <commentaireAbonnement>Abonnement khartoum </commentaireAbonnement>
    <idDistributeurCom>877977389_0000000000000000</idDistributeurCom>
    <idRessource>'.$ark.'</idRessource>
    <typeIdRessource>ark</typeIdRessource>
    <libelleRessource>Silence FaisTonFilm</libelleRessource>
    <debutValidite>2023-09-15T00:00:00</debutValidite>
    <anneeFinValidite>2023-2024</anneeFinValidite>
    <uaiEtab>0571994H</uaiEtab>
    <uaiEtab>9999999P</uaiEtab>
    <categorieAffectation>transferable</categorieAffectation>
    <typeAffectation>INDIV</typeAffectation>
    <nbLicenceGlobale>15</nbLicenceGlobale>
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
    CURLOPT_SSLCERT => 'keys/faistonfilm.co-prod.pem',
    CURLOPT_SSLKEY => "keys/key_gar/faistonfilm.co-prod.pem",
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/xml;charset=utf-8",
    ),
));

$response = curl_exec($curl);

print_r($response);

$err = curl_error($curl);

curl_close($curl);
if ($err) {
    echo "Erreur cURL : $err";
} else {
    if ($http_code >= 200 && $http_code < 300) {
        echo "Requête réussie. Réponse :\n$response";
    } else {
        echo "Erreur HTTP : $http_code. Réponse :\n$response";
    }
}