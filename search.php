<?php

require_once 'include/init.php';

$data = array();

if ($_GET['contexte'] == 'remplissage') {
    $req = 'SELECT id_participant, nom, prenom FROM participants WHERE camp = '.$_SESSION['camp'].' AND (prenom LIKE "%'.$_GET['term'].'%" OR nom LIKE "%'.$_GET['term'].'%")';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[] = $d['nom'].' '.$d['prenom'].' - '.$d['id_participant'];
    }
}

if ($_GET['contexte'] == 'resp_activites') {
    $req = 'SELECT id_participant, nom, prenom FROM participants WHERE type = "adulte" AND camp = '.$_SESSION['camp'].' AND (prenom LIKE "%'.$_GET['term'].'%" OR nom LIKE "%'.$_GET['term'].'%")';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[] = $d['nom'].' '.$d['prenom'];
    }
}

if ($_GET['contexte'] == 'inscriptions_jeune') {
    $req = 'SELECT id_participant, nom, prenom FROM participants WHERE type = "jeune" AND camp = '.$_SESSION['camp'].' AND (prenom LIKE "%'.$_GET['term'].'%" OR nom LIKE "%'.$_GET['term'].'%")';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[] = $d['nom'].' '.$d['prenom'].' - '.$d['id_participant'];
    }
}

if ($_GET['contexte'] == 'inscriptions_activite') {
    $day = date('w')+1;
    switch ($day) {
        case 0:
            $day = 'dimanche';
            break;
        case 1:
            $day = 'lundi';
            break;
        case 2:
            $day = 'mardi';
            break;
        case 3:
            $day = 'mercredi';
            break;
        case 4:
            $day = 'jeudi';
            break;
        case 5:
            $day = 'vendredi';
            break;
        case 6:
            $day = 'samedi';
            break;
    }
    $req = 'SELECT nom FROM activites WHERE type = "'.$_GET['type'].'" AND '.$day.'_dispo = 1 AND nom LIKE "%'.$_GET['term'].'%"';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[] = $d['nom'];
    }
}

if ($_GET['contexte'] == 'modif_activite') {
    $req = 'SELECT nom FROM activites WHERE type = "'.$_GET['type'].'" AND nom LIKE "%'.$_GET['term'].'%"';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[] = $d['nom'];
    }
}

echo json_encode($data);

?>