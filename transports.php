<?php

require_once 'include/init.php';

$title = 'Transports';
require_once 'include/head.php';

if (isset($_GET['reset_filtres'])) {
    unset($_SESSION['filtres_transports']);
    redirect('transports.php');
}

if (!isset($_SESSION['filtres_transports']['aller_retour'])) {
    $_SESSION['filtres_transports']['aller_retour'] = 'aller';
}
if (!isset($_SESSION['filtres_transports']['moyen_transport'])) {
    $_SESSION['filtres_transports']['moyen_transport'] = 'bus';
}

if (!empty($_POST['aller_retour'])) {
    $_SESSION['filtres_transports']['aller_retour'] = $_POST['aller_retour'];
}
if (isset($_POST['prepa'])) {
    $_SESSION['filtres_transports']['prepa'] = $_POST['prepa'];
}
if (!empty($_POST['moyen_transport'])) {
    $_SESSION['filtres_transports']['moyen_transport'] = $_POST['moyen_transport'];
}
if (!empty($_POST['ville'])) {
    $_SESSION['filtres_transports']['ville'] = $_POST['ville'];
}

$donnees = get_transports($_SESSION['filtres_transports']);
$_SESSION['donnees_transport'] = $donnees;

?>

<h2>Récapitulatif transports</h2>

<div class="form-group row">
    <div class="col-sm-6">
        <button type="button" class="btn btn-primary" onclick="location.href = 'exports/export_pdf.php?contexte=transports';">Exporter</button>
    </div>
</div>

<h4>Filtres</h4>

<form action="" method="POST">
    <div class="form-group row">
        <!-- FILTRE ALLER/RETOUR -->
        <label class="col-form-label col-sm-2" for="aller_retour">Aller / Retour</label>
        <div class="col-sm-2">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="aller_retour" id="typeA" value="aller" <?php echo (isset($_SESSION['filtres_transports']['aller_retour']) && $_SESSION['filtres_transports']['aller_retour'] == 'aller') ? 'checked' : ''; ?>> Aller
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="aller_retour" id="typeJ" value="retour" <?php echo (isset($_SESSION['filtres_transports']['aller_retour']) && $_SESSION['filtres_transports']['aller_retour'] == 'retour') ? 'checked' : ''; ?>> Retour
                </label>
            </div>
        </div>
        <!-- FILTRE PREPA -->
        <label class="col-form-label col-sm-2" for="prepa">Prépa ?</label>
        <div class="col-sm-3">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="prepa" id="prepa1" value="1" <?php echo (isset($_SESSION['filtres_transports']['prepa']) && $_SESSION['filtres_transports']['prepa'] == 1) ? 'checked' : ''; ?>> Oui
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="prepa" id="prepa0" value="0" <?php echo (isset($_SESSION['filtres_transports']['prepa']) && $_SESSION['filtres_transports']['prepa'] == 0) ? 'checked' : ''; ?>> Non
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <!-- FILTRE MOYEN TRANSPORT -->
        <label for="moyen_transport" class="col-md-2 col-form-label">Moyen de transport</label>
        <div class="col-md-2">
            <select class="form-control" name="moyen_transport">
                <option value="bus" <?php echo (!empty($_SESSION['filtres_transports']['moyen_transport']) && $_SESSION['filtres_transports']['moyen_transport'] == "bus") ? 'selected' : ''; ?>>Bus</option>
                <option value="train" <?php echo (!empty($_SESSION['filtres_transports']['moyen_transport']) && $_SESSION['filtres_transports']['moyen_transport'] == "train") ? 'selected' : ''; ?>>Train</option>
                <option value="voiture" <?php echo (!empty($_SESSION['filtres_transports']['moyen_transport']) && $_SESSION['filtres_transports']['moyen_transport'] == "voiture") ? 'selected' : ''; ?>>Voiture</option>
                <option value="sur_place" <?php echo (!empty($_SESSION['filtres_transports']['moyen_transport']) && $_SESSION['filtres_transports']['moyen_transport'] == "sur_place") ? 'selected' : ''; ?>>Sur place</option>
            </select>
        </div>
        <!-- FILTRE VILLE -->
        <label for="ville" class="col-md-2 col-form-label">Ville</label>
        <div class="col-md-2">
            <select class="form-control" name="ville">
                <option value="" id="aller_bus_villes" selected></option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
            <button type="submit" class="btn btn-primary">Filtrer</button>
        </div>
        <div class="col-sm-6">
            <button type="button" class="btn btn-secondary" onclick="location.href = 'transports.php?reset_filtres';">Reset filtres</button>
        </div>
    </div>
</form>

<h3>Données</h3>

Nombre de résultats: <?php echo sizeof($donnees); ?>

<table class="table table-sm table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Type</th>
            <th>Portable</th>
            <th>Moyen de transport</th>
            <th>Ville</th>
            <th>Date</th>
            <th>Heure</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($donnees as $participant) {

                switch ($participant['moyen_transport']) {
                    case 'sur_place':
                        $participant['moyen_transport'] = 'Sur place';
                        break;
                    default:
                        $participant['moyen_transport'] = ucfirst($participant['moyen_transport']);
                        break;
                }

                echo '<tr>
                        <td><a href="participants.php?action=edit&id='.$participant['id'].'&type='.strtolower($participant['type']).'">'.$participant['nom'].'</a></td>
                        <td>'.$participant['prenom'].'</td>
                        <td>'.$participant['type'].'</td>
                        <td>'.$participant['tel_portable'].'</td>
                        <td>'.$participant['moyen_transport'].'</td>
                        <td>'.$participant['ville'].'</td>
                        <td>'.convert_date($participant['date'], '-', '/').'</td>
                        <td>'.$participant['heure'].'</td>
                      </tr>';
            }
        ?>
    </tbody>
</table>

<script type="text/javascript">

    $(function() {
        $.ajax({
            type: 'POST',
            url: '/ajax/villes_bus.php',
            data: {
                'camp': <?php echo $_SESSION['camp'] ?>,
                'aller_retour': 'aller'
            },
            success: function(data){
                $("#aller_bus_villes").after(data);
            }
        });
    });

</script>

<?php

require_once 'include/foot.php';

?>