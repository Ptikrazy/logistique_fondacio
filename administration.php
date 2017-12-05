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

    if (!empty($_GET['action'])) {

        if ($_GET['action'] == 'edit') {

            if (!empty($_POST)) {

                if (!isset($_POST['da_fsl'])) {
                    $_POST['da_fsl'] = 0;
                }
                if (!isset($_POST['da_ap'])) {
                    $_POST['da_ap'] = 0;
                }
                if (!isset($_POST['da_di'])) {
                    $_POST['da_di'] = 0;
                }
                if (!isset($_POST['da_bn'])) {
                    $_POST['da_bn'] = 0;
                }
                if (!isset($_POST['da_photo'])) {
                    $_POST['da_photo'] = 0;
                }
                if (!isset($_POST['da_vaccins'])) {
                    $_POST['da_vaccins'] = 0;
                }
                if ($_POST['da_fsl'] && $_POST['da_ap'] && $_POST['da_di'] && $_POST['da_bn'] && $_POST['da_photo'] && $_POST['da_vaccins']) {
                    $_POST['da_complet'] = 1;
                }
                else {
                    $_POST['da_complet'] = 0;
                }

                if(empty($_POST['desistement'])) {
                    $_POST['desistement'] = 'NULL';
                }


                maj_administratif($_GET['id'], $_POST);
                echo '<script>swal("Fiche mise à jour avec succès !","","success")</script>';


            }

            $data = get_infos_administrative($_GET['id']);

            //print_rh($data);

            // Gestion des checboxes pour les pièces du dossier

            $check_fsl     = '';
            $check_ap      = '';
            $check_di      = '';
            $check_bn      = '';
            $check_photo   = '';
            $check_vaccins = '';

            if ($data['da_fsl']) {
                $check_fsl = 'checked';
            }
            if ($data['da_ap']) {
                $check_ap = 'checked';
            }
            if ($data['da_di']) {
                $check_di = 'checked';
            }
            if ($data['da_bn']) {
                $check_bn = 'checked';
            }
            if ($data['da_photo']) {
                $check_photo = 'checked';
            }
            if ($data['da_vaccins']) {
                $check_vaccins = 'checked';
            }

?>

            <h2>Fiche de <?php echo $data['prenom'].' '.$data['nom'].' ('.age($data['date_naissance']).' ans)'; ?></h2>
            <a class="btn btn-secondary" href="administration.php" role="button">Retour</a><br><br>

            <h4>Administratif</h4><br>

            <form action="" method="POST">

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="da_reception">Dossier reçu le</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="da_reception" id="da_reception" value="<?php echo $data['da_reception']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">Pièces du dossier recues</div>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="da_fsl" id="da_fsl" value="1" <?php echo $check_fsl; ?>> FSL
                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="da_ap" id="da_ap" value="1" <?php echo $check_ap; ?>> AP
                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="da_di" id="da_di" value="1" <?php echo $check_di; ?>> DI
                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="da_bn" id="da_bn" value="1" <?php echo $check_bn; ?>> BN
                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="da_photo" id="da_photo" value="1" <?php echo $check_photo; ?>> Photo
                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="da_vaccins" id="da_vaccins" value="1" <?php echo $check_vaccins; ?>> Vaccins
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">Transports ?</div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="da_relance_pieces_manquantes">Relancé pièces manquantes le</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="da_relance_pieces_manquantes" id="da_relance_pieces_manquantes" value="<?php echo $data['da_relance_pieces_manquantes']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="da_commentaire">Commentaires</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="da_commentaire" id="da_commentaire" value="<?php echo $data['da_commentaire']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="da_courrier_parents">Courrier parents envoyé le</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="da_courrier_parents" id="da_courrier_parents" value="<?php echo $data['da_courrier_parents']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="desistement">Désistement le</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="desistement" id="desistement" value="<?php echo $data['desistement']; ?>">
                </div>
            </div>

            <h4>Financier</h4><br>

            In progress

            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>

            </form>

<?php

        }

    }

    else {

?>

    <h2>Administration</h2><br>

    <h3>Liste des camps</h3>

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
                else if (!$data['da_complet'] || empty($data['rgt_recu']) || ($data['paiement_declare'] > $data['rgt_montant'])) {
                    $color = '#EFEF07';
                }

                $da_complet = 'Non';
                if ($data['da_complet']) {
                    $da_complet = 'Oui';
                }

                echo '
                    <tr bgcolor="'.$color.'">
                        <td><a href="administration.php?action=edit&id='.$id_jeune.'">'.$data['nom'].'</a></td>
                        <td>'.$data['prenom'].'</td>
                        <td>'.$da_complet.'</td>
                        <td>'.convert_date($data['da_a_relancer'], '-', '/').'</td>
                        <td>'.convert_date($data['rgt_recu'], '-', '/').'</td>
                    </tr>
                ';
            }

            ?>
        </tbody>
    </table>

<?php

    }

}

require_once 'include/foot.php';

?>