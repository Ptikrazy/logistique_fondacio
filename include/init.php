<?php

// Session
session_start();

// Error reporting
error_reporting(1);
ini_set('display_errors', 1);

// Date
setlocale(LC_TIME, "fr_FR");
$today = new DateTime('today');
$tomorrow = new DateTime('tomorrow');

// Set camp
if (empty($_SESSION['camp'])) {
    $_SESSION['camp'] = 1;
}

// Chargement des fichiers
require_once 'bdd.php';
require_once 'functions.php';

?>