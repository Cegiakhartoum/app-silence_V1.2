<?php

$curl = curl_init();

$ark = "ark:/28048/silence";
$id_abonnement = $abonnement['id_abonnement'];

// $ark = "ark:/28048.p";
// $ark = "ark:/1657727558.p";

$xml = '<abonnement xmlns="http://www.atosworldline.com/wsabonnement/v1.0/">
    <idAbonnement>'. $abonnement['id_abonnement'].'</idAbonnement>
    <commentaireAbonnement>'. $abonnement['commentaireAbonnement'].'</commentaireAbonnement>
    <idDistributeurCom>877977389_0000000000000000</idDistributeurCom>
    <idRessource>'.$ark.'</idRessource>
    <typeIdRessource>ark</typeIdRessource>
    <libelleRessource>Silence FaisTonFilm</libelleRessource>
    <debutValidite>'. $abonnement['debutValidite'].'</debutValidite>
    <anneeFinValidite>'. $abonnement['anneeFinValidite'].'</anneeFinValidite>
    <uaiEtab>'. $abonnement['uaiEtab'].'</uaiEtab>
    <categorieAffectation>transferable</categorieAffectation>
    <typeAffectation>INDIV</typeAffectation>
    <nbLicenceGlobale>'. $abonnement['nbLicenceGlobale'].'</nbLicenceGlobale>
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
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}
