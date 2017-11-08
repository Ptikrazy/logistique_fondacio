<?php

require_once 'include/init.php';

$title = 'Inscriptions';
require_once 'include/head.php';

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

if (isset($_POST['inscription'])) {

    inscrire($_SESSION['camp'], $_POST['id_jeune'], $_POST['nom_jeune'], array('creative' => $_POST[$day.'_crea'], 'sportive' => $_POST[$day.'_sport']), $day);

    echo '<script>swal("'.$_POST['nom_jeune'].' inscrit avec succès !","","success")</script>';

    unset($_POST['jeune']);

}

?>

<h2>Inscriptions pour <?php echo $day; ?></h2>
<a class="btn btn-default" href="export_pdf.php?contexte=activites" role="button">Exporter listes inscrits</a><br><br>

<?php

if (in_array($day, array('mardi', 'mercredi', 'jeudi', 'vendredi'))) {
    $non_inscrits = get_non_inscrits($day);
    echo '<button type="button" class="btn btn-link" id="button_non_inscrits">Afficher les jeunes non-inscrits</button><br><br>';

    echo '<table class="table table-bordered table-condensed" id="tableau_non_inscrits"><tr><th>Nom</th><th>Prénom</th><th>Service</th></tr>';
    foreach ($non_inscrits as $participant) {
        echo '<tr><td>'.$participant['nom'].'</td><td>'.$participant['prenom'].'</td><td>'.$participant['service'].'</td></tr>';
    }
    echo '</table>';

    $doublons = get_inscrits_doublon($day);
    echo '<button type="button" class="btn btn-link" id="button_inscrits_doublons">Afficher les jeunes en doublon</button><br><br>';

    echo '<table class="table table-bordered table-condensed" id="tableau_inscrits_doublons"><tr><th>Nom</th></tr>';
    foreach ($doublons as $participant) {
        echo '<tr><td>'.$participant['nom_jeune'].'</td></tr>';
    }
    echo '</table>';

    $donnees_rafting = get_donnees_mails('rafting');
    echo '<button type="button" class="btn btn-link" id="button_donnees_rafting">Afficher données rafting</button><br><br>';

    echo '<table class="table table-bordered table-condensed" id="tableau_donnees_rafting"><tr><th>Nom</th><th>Taille</th><th>Poids</th></tr>';
    foreach ($donnees_rafting as $participant) {
        echo '<tr><td>'.$participant['nom_jeune'].'</td><td>'.$participant['taille'].'</td><td>'.$participant['poids'].'</td>
              </tr>';
    }
    echo '</table>';

    $donnees_canyoning = get_donnees_mails('canyoning');
    echo '<button type="button" class="btn btn-link" id="button_donnees_canyoning">Afficher données canyoning</button><br><br>';

    echo '<table class="table table-bordered table-condensed" id="tableau_donnees_canyoning"><tr><th>Nom</th><th>Taille</th><th>Poids</th></tr>';
    foreach ($donnees_canyoning as $participant) {
        echo '<tr><td>'.$participant['nom_jeune'].'</td><td>'.$participant['taille'].'</td><td>'.$participant['poids'].'</td>
              </tr>';
    }
    echo '</table>';
}

?>

<form class="form-horizontal" action="" method="POST">
    <div class="form-group">
        <label for="jeune" class="col-md-1 control-label">Jeune</label>
        <div class="col-md-5">
            <input type="text" class="form-control" name="jeune" id="jeune" value="<?php echo $_POST['jeune'] ?>">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-default">Inscription</button>
        </div>
    </div>
</form>

<script>
$(function() {
    $( "#jeune" ).autocomplete({
        source: 'search.php?contexte=inscriptions_jeune',
        autoFocus: true
    });
    $( "#tableau_non_inscrits" ).hide();
    $( "#button_non_inscrits" ).click(function() {
        $('#tableau_non_inscrits').toggle("fade", 200);
    });
    $( "#tableau_inscrits_doublons" ).hide();
    $( "#button_inscrits_doublons" ).click(function() {
        $('#tableau_inscrits_doublons').toggle("fade", 200);
    });
    $( "#tableau_donnees_rafting" ).hide();
    $( "#button_donnees_rafting" ).click(function() {
        $('#tableau_donnees_rafting').toggle("fade", 200);
    });
    $( "#tableau_donnees_canyoning" ).hide();
    $( "#button_donnees_canyoning" ).click(function() {
        $('#tableau_donnees_canyoning').toggle("fade", 200);
    });
});
</script>

<?php

if (!empty($_POST['jeune'])) {
    $jeune = explode(' - ', $_POST['jeune']);
    $id_jeune = $jeune[1];
    $nom_jeune = $jeune[0];
    $day = date('w');
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
    switch ($day) {
        case 'lundi':
            $mardi_sport    = '<input type="text" class="form-control" name="mardi_sport" id="mardi_sport" value="">';
            $mardi_crea     = '<input type="text" class="form-control" name="mardi_crea" id="mardi_crea" value="">';
            $mercredi_sport = '';
            $mercredi_crea  = '';
            $jeudi_sport    = '';
            $jeudi_crea     = '';
            $vendredi_sport = '';
            $vendredi_crea  = '';
            break;

        case 'mardi':
            $mardi_sport    = get_historique($id_jeune, 'mardi', 'sportive', $_SESSION['camp']);
            $mardi_crea     = get_historique($id_jeune, 'mardi', 'creative', $_SESSION['camp']);
            $mercredi_sport = '<input type="text" class="form-control" name="mercredi_sport" id="mercredi_sport" value="">';
            $mercredi_crea  = '<input type="text" class="form-control" name="mercredi_crea" id="mercredi_crea" value="">';
            $jeudi_sport    = '';
            $jeudi_crea     = '';
            $vendredi_sport = '';
            $vendredi_crea  = '';
            break;

        case 'mercredi':
            $mardi_sport    = get_historique($id_jeune, 'mardi', 'sportive', $_SESSION['camp']);
            $mardi_crea     = get_historique($id_jeune, 'mardi', 'creative', $_SESSION['camp']);
            $mercredi_sport = get_historique($id_jeune, 'mercredi', 'sportive', $_SESSION['camp']);
            $mercredi_crea  = get_historique($id_jeune, 'mercredi', 'creative', $_SESSION['camp']);
            $jeudi_sport    = '<input type="text" class="form-control" name="jeudi_sport" id="jeudi_sport" value="">';
            $jeudi_crea     = '<input type="text" class="form-control" name="jeudi_crea" id="jeudi_crea" value="">';
            $vendredi_sport = '';
            $vendredi_crea  = '';
            break;

        case 'jeudi':
            $mardi_sport    = get_historique($id_jeune, 'mardi', 'sportive', $_SESSION['camp']);
            $mardi_crea     = get_historique($id_jeune, 'mardi', 'creative', $_SESSION['camp']);
            $mercredi_sport = get_historique($id_jeune, 'mercredi', 'sportive', $_SESSION['camp']);
            $mercredi_crea  = get_historique($id_jeune, 'mercredi', 'creative', $_SESSION['camp']);
            $jeudi_sport    = get_historique($id_jeune, 'jeudi', 'sportive', $_SESSION['camp']);
            $jeudi_crea     = get_historique($id_jeune, 'jeudi', 'creative', $_SESSION['camp']);
            $vendredi_sport = '<input type="text" class="form-control" name="vendredi_sport" id="vendredi_sport" value="">';
            $vendredi_crea  = '<input type="text" class="form-control" name="vendredi_crea" id="vendredi_crea" value="">';
            break;

        default:
            $mardi_sport    = '';
            $mardi_crea     = '';
            $mercredi_sport = '';
            $mercredi_crea  = '';
            $jeudi_sport    = '';
            $jeudi_crea     = '';
            $vendredi_sport = '';
            $vendredi_crea  = '';
            break;
    }

?>

<form class="form-horizontal" action="" method="POST">
<div class="row">
    <div class="col-md-6"><h3>Activités sportives</h3></div>
    <div class="col-md-6"><h3>Activités créatives</h3></div>
</div>

<div class="form-group">
    <label for="mardi_sport" class="col-md-1 control-label">Mardi</label>
    <div class="col-md-3">
        <?php echo $mardi_sport; ?>
    </div>
    <label for="mardi_crea" class="col-md-1 col-md-offset-2 control-label">Mardi</label>
    <div class="col-md-3">
        <?php echo $mardi_crea; ?>
    </div>
</div>
<div class="form-group">
    <label for="mercredi_sport" class="col-md-1 control-label">Mercredi</label>
    <div class="col-md-3">
        <?php echo $mercredi_sport; ?>
    </div>
    <label for="mercredi_crea" class="col-md-1 col-md-offset-2 control-label">Mercredi</label>
    <div class="col-md-3">
        <?php echo $mercredi_crea; ?>
    </div>
</div>
<div class="form-group">
    <label for="jeudi_sport" class="col-md-1 control-label">Jeudi</label>
    <div class="col-md-3">
        <?php echo $jeudi_sport; ?>
    </div>
    <label for="jeudi_crea" class="col-md-1 col-md-offset-2 control-label">Jeudi</label>
    <div class="col-md-3">
        <?php echo $jeudi_crea; ?>
    </div>
</div>
<div class="form-group">
    <label for="vendredi_sport" class="col-md-1 control-label">Vendredi</label>
    <div class="col-md-3">
        <?php echo $vendredi_sport; ?>
    </div>
    <label for="vendredi_crea" class="col-md-1 col-md-offset-2 control-label">Vendredi</label>
    <div class="col-md-3">
        <?php echo $vendredi_crea; ?>
    </div>
</div>
<div class="form-group">
    <input type="hidden" name="inscription" value="">
    <input type="hidden" name="id_jeune" value="<?php echo $id_jeune; ?>">
    <input type="hidden" name="nom_jeune" value="<?php echo $nom_jeune; ?>">
</div>

<div class="row">
    <div class="col-md-3">
        <button type="submit" class="btn btn-default">Sauvegarder</button>
    </div>
</div>
</form>

<?php

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

?>

<script>
$(function() {
    $( "#<?php echo $day; ?>_sport" ).autocomplete({
        source: 'search.php?contexte=inscriptions_activite&type=sportive',
        autoFocus: true
    });
    $( "#<?php echo $day; ?>_crea" ).autocomplete({
        source: 'search.php?contexte=inscriptions_activite&type=creative',
        autoFocus: true
    });
});
</script>

<?php

}

require_once 'include/foot.php';

?>