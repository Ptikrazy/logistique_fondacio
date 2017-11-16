<?php

session_start();
require_once 'include/functions.php';

header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="export_participants.csv"');

$f = fopen('php://output', 'w');
fprintf($f, chr(0xEF).chr(0xBB).chr(0xBF));

$legende = $_SESSION[$_GET['contexte'].'_legende'];
$donnees = $_SESSION[$_GET['contexte'].'_donnees'];

fputcsv($f, $legende, ';');

foreach ($donnees as $value) {
    $value['date_naissance'] = age($value['date_naissance']);
    fputcsv($f, $value, ';');
}

fclose($f);

?>