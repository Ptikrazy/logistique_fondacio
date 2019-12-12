<?php

require_once 'include/init.php';

$title = 'Administration codes';
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
            redirect('administration_codes.php');
        }

        else {
            $login = get_infos_login($_POST['login']);
            if ($login['role'] != 'admin') {
                $_SESSION['camp_admin'] = $login['camp'];
                redirect('administration_codes.php');
            }
            $_SESSION['profil']['id'] = $login['id_utilisateur'];
            $_SESSION['profil']['role'] = $login['role'];
            redirect('administration_codes.php');
        }

    }

}

else {

    if (!empty($_GET['delete'])) {
        delete_code($_GET['delete']);
    }
	
    if (!empty($_POST['code'])) {
        add_code(array(trim($_POST['code']), $_POST['montant']));
    }

    echo '<h2>Gestion des codes</h2>';

    $liste_codes = get_codes();

    echo '
    <table class="table table-sm table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Code</th>
                <th scope="col">Montant</th>
                <th scope="col">Utilisé</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>';

    foreach ($liste_codes as $code) {
        echo '
            <tr>
                <td>'.$code['code'].'</td>
                <td>'.$code['montant'].'</td>';
				if($code['utilise']==0){
					echo '<td>NON</td>';
				}
				else{
					echo '<td>OUI</td>';
				}
		echo '
                <td><a href="administration_codes.php?delete='.$code['id_code'].'"><img src="include/icons/delete.svg" alt="delete" class="icon" data-toggle="tooltip" data-placement="top" title="Supprimer"></a></td>
            </tr>
        ';
    }

    echo '
        </tbody>
    </table><br>';
?>

    <h3>Ajouter un code</h3><br>

    <form action="" method="POST">
        <div class="form-group row">
            <label class="col-sm-1 col-form-label" for="code">Code</label>
            <div class="col-sm-2 form-check">
                <input type="text" class="form-control" name="code" id="code" value=" " required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-1 col-form-label" for="montant">Montant</label>
            <div class="col-sm-2 form-check">
                <input type="number" class="form-control" name="montant" id="montant" required>
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