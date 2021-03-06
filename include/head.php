<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title><?php echo $title; ?></title>

        <link href="include/css/bootstrap-4.0.0.min.css" rel="stylesheet">
        <link href="include/css/swal2.min.css" rel="stylesheet">
        <link href="include/css/jquery-ui-1.12.1.min.css" rel="stylesheet">
        <link href="include/css/main.css" rel="stylesheet">

        <script src="include/js/jquery-3.2.1.min.js"></script>
        <script src="include/js/jquery-ui-1.12.1.min.js"></script>
        <script src="include/js/popper-1.12.3.min.js"></script>
        <script src="include/js/bootstrap-4.0.0.min.js"></script>
        <script src="include/js/swal2.min.js"></script>
    </head>

    <body>

    <?php if (!in_array($_SERVER['SCRIPT_NAME'], array('/inscription.php', '/inscription_adultes.php'))) { ?>

    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
        <a class="navbar-brand" href="/"><img src="include/logo.png" width="150" height="30" alt=""></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="/">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="participants.php">Participants</a></li>
                <li class="nav-item"><a class="nav-link" href="remplissage.php">Remplissage</a></li>
                <li class="nav-item"><a class="nav-link" href="exports.php">Exports</a></li>
                <li class="nav-item"><a class="nav-link" href="transports.php">Transports</a></li>
                <li class="nav-item"><a class="nav-link" href="activites.php">Activités</a></li>
                <li class="nav-item"><a class="nav-link" href="inscriptions.php">Inscriptions</a></li>
                <?php if ($_SESSION['profil']['role'] != 'charge_insc_adulte') { ?>
                <li class="nav-item"><a class="nav-link" href="administration.php">Administration Jeunes</a></li>
                <?php } ?>
                <li class="nav-item"><a class="nav-link" href="administration_adultes.php">Administration Adultes</a></li>
                <li class="nav-item"><a class="nav-link" href="administration_camps.php">Gestion des camps</a></li>
				<li class="nav-item"><a class="nav-link" href="administration_codes.php">Gestion des codes</a></li>
                <li class="nav-item"><a class="nav-link" href="administration_utilisateurs.php">Gestion des utilisateurs</a></li>
                <li class="nav-item"><a class="nav-link" href="aide.php">Aide</a></li>
            </ul>
        </div>
    </nav>

    <?php } ?>
      <br><br><br>
      <div class="container">