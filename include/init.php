<?php

// Session
session_start();

// Error reporting
error_reporting(1);
ini_set('display_errors', 1);

// Date
setlocale(LC_TIME, "fr_FR");
$today = new DateTime('2018-07-07');
$tomorrow = new DateTime('2018-07-09');

// Chargement des fichiers
require_once 'bdd.php';
require_once 'functions.php';

?>