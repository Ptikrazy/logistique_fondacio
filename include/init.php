<?php

// Session
session_start();

// Error reporting
error_reporting(-1);
ini_set('display_errors', 'On');
//ini_set('display_startup_errors', 0);

// Date
setlocale(LC_TIME, "fr_FR");

// Connexion BDD
require_once 'bdd.php';

// Require
require_once 'functions.php';

// Choix du camp
$_SESSION['camp'] = 1;

?>