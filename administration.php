<?php

require_once 'include/init.php';

$title = 'Administration';
require_once 'include/head.php';

if (empty($_SESSION['profil']['id'])) {

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
            redirect('/administration.php');
        }

        else {
            $login = get_infos_login($_POST['login']);
            $_SESSION['profil']['id'] = $login['id_utilisateur'];
            $_SESSION['profil']['role'] = $login['role'];
            redirect('/administration.php');
        }

    }

}

else {

?>

    <h2>Administration</h2><br>

    <h3>Liste des camps</h3><br>

    <?php

    $liste_camps = get_camps();

    echo '
    <table class="table table-sm table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Région(s)</th>
                <th scope="col">Date début</th>
                <th scope="col">Date fin</th>
                <th scope="col">Date prépa</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($liste_camps as $camp) {
        echo '
            <tr>
                <td>'.$camp['numero'].'</td>
                <td>'.$camp['regions'].'</td>
                <td>'.convert_date($camp['date_debut'], '-', '/').'</td>
                <td>'.convert_date($camp['date_fin'], '-', '/').'</td>
                <td>'.convert_date($camp['date_prepa'], '-', '/').'</td>
            </tr>
        ';
    }

    echo '
        </tbody>
    </table><br>';

    ?>

    <h3>Liste des inscrits</h3>

    <table class="table table-sm table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">DA complet</th>
                <th scope="col">DA à relancer</th>
                <th scope="col">Règlement reçu</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $inscrits = get_inscrits(1);

            foreach ($inscrits as $id_jeune => $data) {

                $color = '#39CA1A';

                if (!empty($data['desistement'])) {
                    $color = '#DC0B0B';
                }
                else if (!$data['da_complet'] || empty($data['rgt_recu'])) {
                    $color = '#EFEF07';
                }

                $da_complet = 'Non';
                if ($data['da_complet']) {
                    $da_complet = 'Oui';
                }

                echo '
                    <tr bgcolor="'.$color.'">
                        <td>'.$data['nom'].'</td>
                        <td>'.$data['prenom'].'</td>
                        <td>'.$da_complet.'</td>
                        <td>'.convert_date($data['da_a_relancer'], '-', '/').'</td>
                        <td>'.$data['rgt_recu'].'</td>
                    </tr>
                ';
            }

            ?>
        </tbody>
    </table>

<?php

}

require_once 'include/foot.php';

?>