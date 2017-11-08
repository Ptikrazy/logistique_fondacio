<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=logistique_fondacio;charset=utf8', 'root', 'warrior');
}
catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}
$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

?>