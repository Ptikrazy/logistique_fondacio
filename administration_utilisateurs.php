<?php

require_once 'include/init.php';

$title = 'Administration utilisateurs';
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
        delete_utilisateur($_GET['delete']);
    }

    if (!empty($_POST['numero'])) {
        add_camp(array($_POST['numero'], $_POST['date_prepa'], $_POST['date_debut'], $_POST['date_fin'], $_POST['regions'], $_POST['villes_bus_aller'], $_POST['villes_bus_retour']));
    }

    echo '<h2>Gestion des utilisateurs</h2>';

    $liste_utilisateurs = get_utilisateurs();

    echo '
    <table class="table table-sm table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Role</th>
                <th scope="col">Login</th>
                <th scope="col">Camp</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>';

    foreach ($liste_utilisateurs as $user) {
        switch ($user['role']) {
            case 'admin':
                $role = 'Administrateur';
                break;
            case 'charge_insc':
                $role = 'Chargé d\'inscription';
                break;
            case 'resp_camp':
                $role = 'Responsable de camp';
                break;
        }
        echo '
            <tr>
                <td>'.$role.'</td>
                <td>'.$user['login'].'</td>
                <td>'.$user['camp'].'</td>
                <td><a href="administration_utilisateurs.php?delete='.$user['id_utilisateur'].'"><img src="include/icons/delete.svg" alt="delete" class="icon" data-toggle="tooltip" data-placement="top" title="Supprimer"></a>&nbsp;<a href="administration_utilisateurs.php?toggle='.$user['id_utilisateur'].'"><img src="include/icons/action-redo.svg" alt="toggle" class="icon" data-toggle="tooltip" data-placement="top" title="Ouvrir/Fermer"></a></td>
            </tr>
        ';
    }

    echo '
        </tbody>
    </table><br>';
?>

    <h3>Ajouter un utilisateur</h3><br>

    <form action="" method="POST">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="numero">Numéro</label>
            <div class="col-sm-1 form-check">
                <input type="text" class="form-control" name="numero" id="numero" value=" " required>
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