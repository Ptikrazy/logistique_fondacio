<?php

require_once 'include/init.php';

$title = 'Accueil';
require_once 'include/head.php';

if (empty($_SESSION['camp'])) {
    $_SESSION['camp'] = 1;
}
if (!empty($_POST['camp'])) {
    $_SESSION['camp'] = $_POST['camp'];
}
?>

<h2 style="color: red"><b>Si problème, contacter Pierre: pleplat75@gmail.com / 06 12 19 22 92</b></h2><br>

<form action="" method="POST">
    <div class="form-group row">
        <label class="col-form-label col-sm-1" for="camp"><h3>Camp: </h3></label>
        <div class="col-sm-1">
            <select class="form-control" name="camp" id="camp">
                <?php
                    $camps = get_camps();
                    foreach ($camps as $camp) {
                        $selected = '';
                        if ($_SESSION['camp'] == $camp['numero']) {
                            $selected = 'selected';
                        }
                        echo '<option value="'.$camp['numero'].'" '.$selected.'>'.$camp['numero'].'</option>';
                    }
                ?>
            </select>
        </div>
        <div class="col-sm-2">
            <button type="submit" class="btn btn-primary">Sauvegarder</button>
        </div>
    </div>
</form>

<h3><b>Alertes transport</b></h3>

<?php

$donnees = alertes_transports('arrivees');
echo '<h4>Arrivées en train du jour ('.$today->format('d/m/Y').'): '.count($donnees).'</h4>';
echo '<table class="table table-sm table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Type</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Heure d\'arrivée</th>
                <th scope="col">Portable</th>
            </tr>
        </thead>';
foreach ($donnees as $data) {
    echo '<tr>
            <td>'.$data['type'].'</td>
            <td>'.$data['nom'].'</td>
            <td>'.$data['prenom'].'</td>
            <td color="red">'.$data['aller_heure'].'</td>
            <td>'.$data['tel_portable'].'</td>
          </tr>';
}
echo '</table>';

$donnees = alertes_transports('arrivees_demain');
echo '<h4>Arrivées en train de demain ('.$tomorrow->format('d/m/Y').'): '.count($donnees).'</h4>';
echo '<table class="table table-sm table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Type</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Heure d\'arrivée</th>
                <th scope="col">Portable</th>
            </tr>
        </thead>';
foreach ($donnees as $data) {
    echo '<tr>
            <td>'.$data['type'].'</td>
            <td>'.$data['nom'].'</td>
            <td>'.$data['prenom'].'</td>
            <td color="red">'.$data['aller_heure'].'</td>
            <td>'.$data['tel_portable'].'</td>
          </tr>';
}
echo '</table>';

$donnees = alertes_transports('departs');
echo '<h4>Départs en train du jour ('.$today->format('d/m/Y').'): '.count($donnees).'</h4>';
echo '<table class="table table-sm table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Type</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Heure de départ</th>
                <th scope="col">Portable</th>
            </tr>
        </thead>';
foreach ($donnees as $data) {
    echo '<tr>
            <td>'.$data['type'].'</td>
            <td>'.$data['nom'].'</td>
            <td>'.$data['prenom'].'</td>
            <td color="red">'.$data['retour_heure'].'</td>
            <td>'.$data['tel_portable'].'</td>
          </tr>';
}
echo '</table>';

$donnees = alertes_transports('departs_demain');
echo '<h4>Départs en train de demain ('.$tomorrow->format('d/m/Y').'): '.count($donnees).'</h4>';
echo '<table class="table table-sm table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Type</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Heure de départ</th>
                <th scope="col">Portable</th>
            </tr>
        </thead>';
foreach ($donnees as $data) {
    echo '<tr>
            <td>'.$data['type'].'</td>
            <td>'.$data['nom'].'</td>
            <td>'.$data['prenom'].'</td>
            <td color="red">'.$data['retour_heure'].'</td>
            <td>'.$data['tel_portable'].'</td>
          </tr>';
}
echo '</table>';

$donnees = alertes_transports('bus_ville');
echo '<h4>Absence de ville bus retour: '.count($donnees).'</h4>';
echo '<table class="table table-sm table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Type</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Heure de départ</th>
                <th scope="col">Portable</th>
            </tr>
        </thead>';
foreach ($donnees as $data) {
    echo '<tr>
            <td>'.$data['type'].'</td>
            <td>'.$data['nom'].'</td>
            <td>'.$data['prenom'].'</td>
            <td color="red">'.$data['retour_heure'].'</td>
            <td>'.$data['tel_portable'].'</td>
          </tr>';
}
echo '</table>';

?>

<h3><b>Anniversaires du jour (<?php echo $today->format('d/m/Y'); ?>)</b></h3><br>

<?php

$anniversaires = get_anniversaires();
foreach ($anniversaires as $anniv) {
    echo '- '.$anniv['prenom'].' '.$anniv['nom'].' ('.age($anniv['date_naissance']).' ans)<br>';
}

?>

<h3><b>Statistiques</b></h3><br>

<?php

echo '- Nombre total de participants: '.(get_totaux_jeunes($_SESSION['camp'], '1') + get_totaux_adultes($_SESSION['camp'], '1')).'<br>';
echo '- Nombre de jeunes: '.get_totaux_jeunes($_SESSION['camp'], '1').'<br>';
echo '- Nombre de jeunes prépa: '.get_totaux_jeunes($_SESSION['camp'], 'prepa = 1').'<br>';
echo '- Nombre de jeunes nouveaux: '.get_totaux_jeunes($_SESSION['camp'], 'ancien = 0').'<br>';
echo '- Nombre de jeunes filles: '.get_totaux_jeunes($_SESSION['camp'], 'civilite = "F"').'<br>';
echo '- Nombre de jeunes garçons: '.get_totaux_jeunes($_SESSION['camp'], 'civilite = "H"').'<br>';
echo '- Nombre d\'adultes: '.get_totaux_adultes($_SESSION['camp'], '1');

?>

<?php

require_once 'include/foot.php';

?>