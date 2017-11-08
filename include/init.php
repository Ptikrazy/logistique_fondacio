<?php

// Error reporting

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// Session

session_start();

// Date

setlocale(LC_TIME, "fr_FR");

// Connexion BDD

require_once 'bdd.php';

// Require

require_once 'functions.php';

// Choix du camp

$today = date('Y-m-d');
$today = date('Y-m-d', strtotime($today));

$dates_camp = array(
                '1' => array(
                    'debut' => date('Y-m-d', strtotime('2017-07-09')),
                    'fin'   => date('Y-m-d', strtotime('2017-07-15')),
                    'prepa' => date('Y-m-d', strtotime('2017-07-08')),
                ),
                '2' => array(
                    'debut' => date('Y-m-d', strtotime('2017-07-16')),
                    'fin'   => date('Y-m-d', strtotime('2017-07-22')),
                    'prepa' => date('Y-m-d', strtotime('2017-07-15')),

                ),
                '3' => array(
                    'debut' => date('Y-m-d', strtotime('2017-07-23')),
                    'fin'   => date('Y-m-d', strtotime('2017-07-29')),
                    'prepa' => date('Y-m-d', strtotime('2017-07-22')),

                ),
                '4' => array(
                    'debut' => date('Y-m-d', strtotime('2017-07-30')),
                    'fin'   => date('Y-m-d', strtotime('2017-08-05')),
                    'prepa' => date('Y-m-d', strtotime('2017-07-29')),

                ),
                '5' => array(
                    'debut' => date('Y-m-d', strtotime('2017-08-06')),
                    'fin'   => date('Y-m-d', strtotime('2017-08-13')),
                    'prepa' => date('Y-m-d', strtotime('2017-08-05')),

                ),
              );

$_SESSION['camp'] = 1;
switch ($today) {
    case ($today >= $dates_camp['1']['debut']) && ($today <= $dates_camp['1']['fin']):
        $_SESSION['camp'] = 1;
        break;

    case ($today >= $dates_camp['2']['debut']) && ($today <= $dates_camp['2']['fin']):
        $_SESSION['camp'] = 2;
        break;

    case ($today >= $dates_camp['3']['debut']) && ($today <= $dates_camp['3']['fin']):
        $_SESSION['camp'] = 3;
        break;

    case ($today >= $dates_camp['4']['debut']) && ($today <= $dates_camp['4']['fin']):
        $_SESSION['camp'] = 4;
        break;

    case ($today >= $dates_camp['5']['debut']) && ($today <= $dates_camp['5']['fin']):
        $_SESSION['camp'] = 5;
        break;
}

switch ($_SESSION['camp']) {
    case 1:
        $_SESSION['villes_transport'] = array('BRIVE', 'LILLE', 'PARIS', 'TOULOUSE');
        break;
    case 2:
        $_SESSION['villes_transport'] = array('PARIS', 'LILLE', 'BRIVE');
        break;
    case 3:
        $_SESSION['villes_transport'] = array('BRIVE', 'PARIS', 'TOULOUSES', 'VERSAILLES');
        break;
    case 4:
        $_SESSION['villes_transport'] = array('PARIS', 'LILLE', 'BRIVE');
        break;
    case 5:
        $_SESSION['villes_transport'] = array('PARIS', 'LILLE', 'BRIVE');
        break;
}

?>