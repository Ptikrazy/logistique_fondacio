<?php

require_once 'include/init.php';

$title = 'Transports';
require_once 'include/head.php';

$aller_retour = 'aller';
$prepa = 'oui';
$moyen_transport = '';
$ville = '';
if (empty($_POST['camp'])) {
    $_POST['camp'] = $_SESSION['camp'];
}

if (!empty($_POST['aller_retour'])) {
    $aller_retour = $_POST['aller_retour'];
}
if (!empty($_POST['prepa'])) {
    $prepa = $_POST['prepa'];
}
if (!empty($_POST['moyen_transport'])) {
    $moyen_transport = $_POST['moyen_transport'];
}
if (!empty($_POST['ville'])) {
    $ville = $_POST['ville'];
}
$donnees = get_transports($_POST['camp'], $aller_retour, $prepa, $moyen_transport, $ville);
$total = 0;
foreach ($donnees as $transport => $participants) {
    $total += sizeof($participants);
}
$_SESSION['donnees_transport'] = $donnees;

?>

<h2>Récapitulatif transports</h2>

<a class="btn btn-default" href="export_pdf.php?contexte=transports" role="button">Exporter listes transport</a>
<h3>Filtres</h3>

<form class="form-horizontal" action="" method="POST">
    <div class="form-group">
        <label for="camp" class="col-md-2 control-label">Camp</label>
        <div class="col-md-1">
            <select class="form-control" name="camp">
                <option value="1" <?php echo (!empty($_POST['camp']) && $_POST['camp'] == 1) ? 'selected' : ''; ?>>1</option>
                <option value="2" <?php echo (!empty($_POST['camp']) && $_POST['camp'] == 2) ? 'selected' : ''; ?>>2</option>
                <option value="3" <?php echo (!empty($_POST['camp']) && $_POST['camp'] == 3) ? 'selected' : ''; ?>>3</option>
                <option value="4" <?php echo (!empty($_POST['camp']) && $_POST['camp'] == 4) ? 'selected' : ''; ?>>4</option>
                <option value="5" <?php echo (!empty($_POST['camp']) && $_POST['camp'] == 5) ? 'selected' : ''; ?>>5</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="aller_retour" class="col-md-2 control-label">Aller / Retour</label>
        <div class="col-md-3">
            <label class="radio-inline">
                <input type="radio" name="aller_retour" value="aller" <?php echo (!empty($_POST['aller_retour']) && $_POST['aller_retour'] == 'aller') ? 'checked' : ''; ?> checked> Aller
            </label>
            <label class="radio-inline">
                <input type="radio" name="aller_retour" value="retour" <?php echo (!empty($_POST['aller_retour']) && $_POST['aller_retour'] == 'retour') ? 'checked' : ''; ?>> Retour
            </label>
        </div>
    </div>
    <div class="form-group">
        <label for="prepa" class="col-md-2 control-label">Prépa ?</label>
        <div class="col-md-3">
            <label class="radio-inline">
                <input type="radio" name="prepa" value="oui" <?php echo (!empty($_POST['prepa']) && $_POST['prepa'] == 'oui') ? 'checked' : ''; ?> checked> Oui
            </label>
            <label class="radio-inline">
                <input type="radio" name="prepa" value="non" <?php echo (!empty($_POST['prepa']) && $_POST['prepa'] == 'non') ? 'checked' : ''; ?>> Non
            </label>
        </div>
    </div>
    <div class="form-group">
        <label for="moyen_transport" class="col-md-2 control-label">Moyen de transport</label>
        <div class="col-md-2">
            <select class="form-control" name="moyen_transport">
                <option value="" selected></option>
                <option value="bus" <?php echo (!empty($_POST['moyen_transport']) && $_POST['moyen_transport'] == "bus") ? 'selected' : ''; ?>>Bus</option>
                <option value="train" <?php echo (!empty($_POST['moyen_transport']) && $_POST['moyen_transport'] == "train") ? 'selected' : ''; ?>>Train</option>
                <option value="voiture" <?php echo (!empty($_POST['moyen_transport']) && $_POST['moyen_transport'] == "voiture") ? 'selected' : ''; ?>>Voiture</option>
                <option value="sur_place" <?php echo (!empty($_POST['moyen_transport']) && $_POST['moyen_transport'] == "sur_place") ? 'selected' : ''; ?>>Sur place</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="ville" class="col-md-2 control-label">Ville</label>
        <div class="col-md-2">
            <select class="form-control" name="ville">
                <option value="" selected></option>
                <?php
                    foreach ($_SESSION['villes_transport'] as $ville) {
                        $selected = '';
                        if (!empty($_POST['ville']) && $_POST['ville'] == $ville) {
                            $selected = 'selected';
                        }
                        echo '<option value="'.$ville.'" '.$selected.'>'.$ville.'</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-3">
            <button type="submit" class="btn btn-default">Filtrer</button>
        </div>
    </div>
</form>

<h3>Données</h3>

Nombre de résultats: <?php echo $total; ?>

<table class="table table-hover">
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
    <?php
        foreach ($donnees as $transport => $participants) {
            foreach ($participants as $participant) {
                echo '<tr>
                        <td><a href="participants.php?action=edit&id_participant='.$participant['id_participant'].'">'.$participant['nom'].'</a></td>
                        <td>'.$participant['prenom'].'</td>
                        <td>'.ucfirst($participant['type']).'</td>
                        <td>'.$participant['tel_portable'].'</td>
                        <td>'.$participant['transport'].'</td>
                        <td>'.$participant['ville'].'</td>
                        <td>'.convert_date($participant['date']).'</td>
                        <td>'.$participant['heure'].'</td>
                      </tr>';
            }
        }
    ?>
</table>

<?php

require_once 'include/foot.php';

?>