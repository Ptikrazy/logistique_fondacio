<?php

require_once 'include/init.php';

$title = 'Administration';
require_once 'include/head.php';

if (empty($_SESSION['profil']['id']) || $_SESSION['profil']['role'] != 'admin') {

    if (empty($_POST['login'])) {

    ?>

        <h3>Login</h3><br>
        <form action="" method="POST">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="login">Identifiant</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="login" id="login" required>
                    </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="password">Mot de passe</label>
                <div class="col-sm-3">
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Connexion</button>
                </div>
            </div>
        </form>

    <?php

    }

    else {

        if (!check_password($_POST['login'], $_POST['password'])) {
            redirect('administration_camps.php');
        }

        else {
            $login = get_infos_login($_POST['login']);
            if ($login['role'] != 'admin') {
                $_SESSION['camp_admin'] = $login['camp'];
                redirect('administration_camps.php');
            }
            $_SESSION['profil']['id'] = $login['id_utilisateur'];
            $_SESSION['profil']['role'] = $login['role'];
            redirect('administration_camps.php');
        }

    }

}

else {

    if (!empty($_GET['delete'])) {
        delete_camp($_GET['delete']);
    }

    if (!empty($_GET['toggle'])) {
        toggle_camp($_GET['toggle']);
    }

    if (!empty($_POST['numero'])) {
        add_camp(array($_POST['numero'], $_POST['date_prepa'], $_POST['date_debut'], $_POST['date_fin'], $_POST['regions'], $_POST['villes_bus_aller'], $_POST['villes_bus_retour']));
    }

    echo '<h2>Gestion des camps</h2>';

    $liste_camps = get_camps();

    echo '
    <table class="table table-sm table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Région(s)</th>
                <th scope="col">Date prépa</th>
                <th scope="col">Date début</th>
                <th scope="col">Date fin</th>
                <th scope="col">Villes aller</th>
                <th scope="col">Villes retour</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>';

    foreach ($liste_camps as $camp) {
        $color = '#FFFFFF';
        if (!$camp['ouvert']) {
            $color = "#F25F5F";
        }
        echo '
            <tr bgcolor="'.$color.'">
                <td>'.$camp['numero'].'</td>
                <td>'.$camp['regions'].'</td>
                <td>'.convert_date($camp['date_prepa'], '-', '/').'</td>
                <td>'.convert_date($camp['date_debut'], '-', '/').'</td>
                <td>'.convert_date($camp['date_fin'], '-', '/').'</td>
                <td>'.$camp['villes_bus_aller'].'</td>
                <td>'.$camp['villes_bus_retour'].'</td>
                <td><a href="administration_camps.php?delete='.$camp['id_camp'].'"><img src="include/icons/delete.svg" alt="delete" class="icon" data-toggle="tooltip" data-placement="top" title="Supprimer"></a>&nbsp;<a href="administration_camps.php?toggle='.$camp['id_camp'].'"><img src="include/icons/transfer.svg" alt="toggle" class="icon" data-toggle="tooltip" data-placement="top" title="Ouvrir/Fermer"></a></td>
            </tr>
        ';
    }

    echo '
        </tbody>
    </table><br>';
?>

    <h3>Ajouter un camp</h3><br>

    <form action="" method="POST">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="numero">Numéro</label>
            <div class="col-sm-1 form-check">
                <input type="text" class="form-control" name="numero" id="numero" value=" " required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="date_prepa">Début de la prépa</label>
            <div class="col-sm-3 form-check">
                <input type="date" class="form-control" name="date_prepa" id="date_prepa" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="date_debut">Date de début</label>
            <div class="col-sm-3 form-check form-check-inline">
                <input type="date" class="form-control" name="date_debut" id="date_debut" required>
            </div>
            <label class="col-sm-2 col-form-label" for="date_fin">Date de fin</label>
            <div class="col-sm-3 form-check form-check-inline">
                <input type="date" class="form-control" name="date_fin" id="date_fin" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="regions">Région(s)</label>
            <div class="col-sm-3 form-check">
                <input type="text" class="form-control" name="regions" id="regions" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="villes_bus_aller">Villes bus aller (Ville1;Ville2...)</label>
            <div class="col-sm-3 form-check form-check-inline">
                <input type="text" class="form-control" name="villes_bus_aller" id="villes_bus_aller" required>
            </div>
            <label class="col-sm-2 col-form-label" for="villes_bus_retour">Villes bus retour (Ville1;Ville2...)</label>
            <div class="col-sm-3 form-check form-check-inline">
                <input type="text" class="form-control" name="villes_bus_retour" id="villes_bus_retour" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </form>

<?php
}

require_once 'include/foot.php';

?>