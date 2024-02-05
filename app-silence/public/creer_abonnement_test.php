<?php

$curl = curl_init();

$ark = "ark:/28048/silence.p";
$id_abonnement = "TESTS-2023-08-15_2023-02-07";
// $ark = "ark:/28048.p";
// $ark = "ark:/1657727558.p";

$xml = '<abonnement xmlns="http://www.atosworldline.com/wsabonnement/v1.0/">
    <idAbonnement>'. $id_abonnement .'</idAbonnement>
    <commentaireAbonnement>Abonnement khartoum</commentaireAbonnement>
    <idDistributeurCom>877977389_0000000000000000</idDistributeurCom>
    <idRessource>'.$ark.'</idRessource>
    <typeIdRessource>ark</typeIdRessource>
    <libelleRessource>Silence FaisTonFilm</libelleRessource>
    <debutValidite>2023-04-16T00:00:00</debutValidite>
    <anneeFinValidite>2022-2023</anneeFinValidite>
    <uaiEtab>9999997S</uaiEtab>
    <categorieAffectation>transferable</categorieAffectation>
    <typeAffectation>INDIV</typeAffectation>
    <nbLicenceGlobale>15</nbLicenceGlobale>
    <publicCible>ELEVE</publicCible>
    <publicCible>ENSEIGNANT</publicCible>
    <publicCible>DOCUMENTALISTE</publicCible>
    <publicCible>AUTRE PERSONNEL</publicCible>
</abonnement>';

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://abonnement.partenaire.test-gar.education.fr/$id_abonnement",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_POSTFIELDS => $xml,
    CURLOPT_SSLKEY => "keys/key_gar/server_1and1.pem",
    CURLOPT_SSLCERT => 'keys/faistonfilm.co.pem',
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
