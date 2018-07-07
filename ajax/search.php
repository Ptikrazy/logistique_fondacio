<?php

require_once '../include/init.php';

$data = array();

if ($_GET['contexte'] == 'remplissage') {
    $req = 'SELECT id_'.$_GET['type'].', nom, prenom FROM '.$_GET['type'].'s WHERE camp = '.$_SESSION['camp'].' AND (prenom LIKE "%'.$_GET['term'].'%" OR nom LIKE "%'.$_GET['term'].'%")';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[] = $d['nom'].' '.$d['prenom'].' - '.$d['id_'.$_GET['type']];
    }
}

if ($_GET['contexte'] == 'inscriptions_activite') {
    $req = 'SELECT nom FROM activites WHERE type = "'.$_GET['type'].'" AND '.$_GET['day'].'_dispo = 1 AND nom LIKE "%'.$_GET['term'].'%"';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[] = $d['nom'];
    }
}

echo json_encode($data);

?>