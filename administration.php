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

            if (isset($_SESSION['edit_ok'])) {
                echo '<script>swal("Fiche mise à jour avec succès !","","success")</script>';
                unset($_SESSION['edit_ok']);
            }

            $data = get_jeune($_GET['id']);

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

                if ($data['ancien']) {
                    $_POST['da_bn'] = 1;
                    $_POST['da_photo'] = 1;
                }

                if (age($data['date_naissance']) >= 18) {
                    $_POST['da_ap'] = 1;
                    $_POST['da_bn'] = 1;
                }

                if ($_POST['da_fsl'] && $_POST['da_ap'] && $_POST['da_di'] && $_POST['da_bn'] && $_POST['da_photo'] && $_POST['da_vaccins']) {
                    $_POST['da_complet'] = 1;
                    $_POST['da_a_relancer'] = 'NULL';
                }
                else {
                    $_POST['da_complet'] = 0;
                }

                if(empty($_POST['desistement'])) {
                    $_POST['desistement'] = 'NULL';
                }

                if (!empty($_POST['etudes_autre'])) {
                    $_POST['etudes'] = $_POST['etudes_autre'];
                    unset($_POST['etudes_autre']);
                }

                if (!empty($_POST['communication_autre'])) {
                    $_POST['communication'] = $_POST['communication_autre'];
                    unset($_POST['communication_autre']);
                }
                else {
                    unset($_POST['communication_autre']);
                }

                if (empty($_POST['da_reception'])) {
                    $_POST['da_reception'] = 'NULL';
                }
                if (empty($_POST['da_courrier_parents'])) {
                    $_POST['da_courrier_parents '] = 'NULL';
                }
                if (empty($_POST['da_relance_envoyee'])) {
                    $_POST['da_relance_envoyee '] = 'NULL';
                }
                if (empty($_POST['da_relance_pieces_manquantes'])) {
                    $_POST['da_relance_pieces_manquantes '] = 'NULL';
                }

                maj_administratif($_GET['id'], $_POST);
                $_SESSION['edit_ok'] = 1;
                redirect('/administration.php?action=edit&id='.$_GET['id']);

            }

?>

            <h2>Fiche de <?php echo $data['prenom'].' '.$data['nom'].' ('.age($data['date_naissance']).' ans)'; ?></h2>
            <a class="btn btn-secondary" href="administration.php" role="button">Retour</a><br><br>

            <h4>Administratif</h4><br>

            <form action="" method="POST">

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="da_reception">Date d'inscription</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="date_saisie" id="date_saisie" value="<?php echo date('d/m/Y H:i:s', strtotime($data['date_saisie'])); ?>" disabled>
                </div>
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
                            <input class="form-check-input" type="checkbox" name="da_fsl" id="da_fsl" value="1" <?php echo ($data['da_fsl']) ? 'checked': ''; ?>> FSL
                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
                            if (age($data['date_naissance']) < 18) {
                        ?>
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="da_ap" id="da_ap" value="1" <?php echo ($data['da_ap']) ? 'checked': ''; ?>> AP
                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
                            }
                        ?>
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="da_di" id="da_di" value="1" <?php echo ($data['da_di']) ? 'checked': ''; ?>> DI
                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
                            if (!$data['ancien']) {
                                if (age($data['date_naissance']) < 18) {
                        ?>
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="da_bn" id="da_bn" value="1" <?php echo ($data['da_bn']) ? 'checked': ''; ?>> BN
                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
                                }
                        ?>
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="da_photo" id="da_photo" value="1" <?php echo ($data['da_photo']) ? 'checked': ''; ?>> Photo
                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
                            }
                        ?>
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="da_vaccins" id="da_vaccins" value="1" <?php echo ($data['da_vaccins']) ? 'checked': ''; ?>> Vaccins
                        </label>
                        <?php
                            if ($data['ancien']) {
                                echo '<label class="form-check-label">(Voir '.date('Y', strtotime('-1 year')).' pour BN + photo)</label>';
                            }
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="da_commentaire">Commentaires</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="da_commentaire" id="da_commentaire" value="<?php echo $data['da_commentaire']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="parents_mail">Mail des parents</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="parents_mail" id="parents_mail" value="<?php echo $data['parents_mail']; ?>" disabled>
                </div>
                <label class="col-form-label col-sm-2" for="da_a_relancer">A relancer le</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="da_a_relancer" id="da_a_relancer" value="<?php echo $data['da_a_relancer']; ?>" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="da_courrier_parents">Courrier parents envoyé le</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="da_courrier_parents" id="da_courrier_parents" value="<?php echo $data['da_courrier_parents']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="da_relance_envoyee">Relance envoyée le</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="da_relance_envoyee" id="da_relance_envoyee" value="<?php echo $data['da_relance_envoyee']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="da_relance_pieces_manquantes">Relancé pièces manquantes le</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="da_relance_pieces_manquantes" id="da_relance_pieces_manquantes" value="<?php echo $data['da_relance_pieces_manquantes']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="desistement">Désistement le</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="desistement" id="desistement" value="<?php echo $data['desistement']; ?>">
                </div>
            </div>

            <h4>Financier</h4><br>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="rgt_recu">Règlement reçu le</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="rgt_recu" id="rgt_recu" value="<?php echo $data['rgt_recu']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="rgt_montant">Montant reçu</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="rgt_montant" id="rgt_montant" value="<?php echo $data['rgt_montant']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="paiement_declare">Montant déclaré</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="paiement_declare" id="paiement_declare" value="<?php echo $data['paiement_declare']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="solde">Solde</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="solde" id="solde" value="<?php echo $data['rgt_montant']-$data['paiement_declare']; ?>" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="rgt_commentaire">Commentaires</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="rgt_commentaire" id="rgt_commentaire" value="<?php echo $data['rgt_commentaire']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="rgt_moyen">Moyen de règlement</label>
                <div class="col-sm-3">
                    <select class="form-control" name="rgt_moyen" id="rgt_moyen">
                        <option value=""></option>
                        <option value="cb" <?php echo ($data['rgt_moyen'] == 'cb') ? 'selected': ''; ?>>Carte bancaire</option>
                        <option value="cheque" <?php echo ($data['rgt_moyen'] == 'cheque') ? 'selected': ''; ?>>Chèque(s)</option>
                    </select>
                </div>
            </div>

            <div id="cheques">
                <h6>Chèque 1</h6>
                <div class="form-group row">
                    <label class="col-form-label col-sm-1" for="cheque1_montant">Montant</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" name="cheque1_montant" id="cheque1_montant" value="<?php echo $data['cheque1_montant']; ?>">
                    </div>
                    <label class="col-form-label col-sm-1" for="cheque1_numero">Numéro</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="cheque1_numero" id="cheque1_numero" value="<?php echo $data['cheque1_numero']; ?>">
                    </div>
                    <label class="col-form-label col-sm-2" for="cheque1_date_encaissement">Date d'encaissement</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" name="cheque1_date_encaissement" id="cheque1_date_encaissement" value="<?php echo $data['cheque1_date_encaissement']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-1" for="cheque1_emetteur">Emetteur</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="cheque1_emetteur" id="cheque1_emetteur" value="<?php echo $data['cheque1_emetteur']; ?>">
                    </div>
                    <label class="col-form-label col-sm-1" for="cheque1_banque">Banque</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="cheque1_banque" id="cheque1_banque" value="<?php echo $data['cheque1_banque']; ?>">
                    </div>
                </div>

                <h6>Chèque 2</h6>
                <div class="form-group row">
                    <label class="col-form-label col-sm-1" for="cheque2_montant">Montant</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" name="cheque2_montant" id="cheque2_montant" value="<?php echo $data['cheque2_montant']; ?>">
                    </div>
                    <label class="col-form-label col-sm-1" for="cheque2_numero">Numéro</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="cheque2_numero" id="cheque2_numero" value="<?php echo $data['cheque2_numero']; ?>">
                    </div>
                    <label class="col-form-label col-sm-2" for="cheque2_date_encaissement">Date d'encaissement</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" name="cheque2_date_encaissement" id="cheque2_date_encaissement" value="<?php echo $data['cheque2_date_encaissement']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-1" for="cheque2_emetteur">Emetteur</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="cheque2_emetteur" id="cheque2_emetteur" value="<?php echo $data['cheque2_emetteur']; ?>">
                    </div>
                    <label class="col-form-label col-sm-1" for="cheque2_banque">Banque</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="cheque2_banque" id="cheque2_banque" value="<?php echo $data['cheque2_banque']; ?>">
                    </div>
                </div>

                <h6>Chèque 3</h6>
                <div class="form-group row">
                    <label class="col-form-label col-sm-1" for="cheque3_montant">Montant</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" name="cheque3_montant" id="cheque3_montant" value="<?php echo $data['cheque3_montant']; ?>">
                    </div>
                    <label class="col-form-label col-sm-1" for="cheque3_numero">Numéro</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="cheque3_numero" id="cheque3_numero" value="<?php echo $data['cheque3_numero']; ?>">
                    </div>
                    <label class="col-form-label col-sm-2" for="cheque3_date_encaissement">Date d'encaissement</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" name="cheque3_date_encaissement" id="cheque3_date_encaissement" value="<?php echo $data['cheque3_date_encaissement']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-1" for="cheque3_emetteur">Emetteur</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="cheque3_emetteur" id="cheque3_emetteur" value="<?php echo $data['cheque3_emetteur']; ?>">
                    </div>
                    <label class="col-form-label col-sm-1" for="cheque3_banque">Banque</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="cheque3_banque" id="cheque3_banque" value="<?php echo $data['cheque3_banque']; ?>">
                    </div>
                </div>

                <h6>Chèque 4</h6>
                <div class="form-group row">
                    <label class="col-form-label col-sm-1" for="cheque4_montant">Montant</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" name="cheque4_montant" id="cheque4_montant" value="<?php echo $data['cheque4_montant']; ?>">
                    </div>
                    <label class="col-form-label col-sm-1" for="cheque4_numero">Numéro</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="cheque4_numero" id="cheque4_numero" value="<?php echo $data['cheque4_numero']; ?>">
                    </div>
                    <label class="col-form-label col-sm-2" for="cheque4_date_encaissement">Date d'encaissement</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" name="cheque4_date_encaissement" id="cheque4_date_encaissement" value="<?php echo $data['cheque4_date_encaissement']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-1" for="cheque4_emetteur">Emetteur</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="cheque4_emetteur" id="cheque4_emetteur" value="<?php echo $data['cheque4_emetteur']; ?>">
                    </div>
                    <label class="col-form-label col-sm-1" for="cheque4_banque">Banque</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="cheque4_banque" id="cheque4_banque" value="<?php echo $data['cheque4_banque']; ?>">
                    </div>
                </div>

                <h6>Chèque 5</h6>
                <div class="form-group row">
                    <label class="col-form-label col-sm-1" for="cheque5_montant">Montant</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" name="cheque5_montant" id="cheque5_montant" value="<?php echo $data['cheque5_montant']; ?>">
                    </div>
                    <label class="col-form-label col-sm-1" for="cheque5_numero">Numéro</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="cheque5_numero" id="cheque5_numero" value="<?php echo $data['cheque5_numero']; ?>">
                    </div>
                    <label class="col-form-label col-sm-2" for="cheque5_date_encaissement">Date d'encaissement</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" name="cheque5_date_encaissement" id="cheque5_date_encaissement" value="<?php echo $data['cheque5_date_encaissement']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-1" for="cheque5_emetteur">Emetteur</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="cheque5_emetteur" id="cheque5_emetteur" value="<?php echo $data['cheque5_emetteur']; ?>">
                    </div>
                    <label class="col-form-label col-sm-1" for="cheque5_banque">Banque</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="cheque5_banque" id="cheque5_banque" value="<?php echo $data['cheque5_banque']; ?>">
                    </div>
                </div>

                <h6>Chèque 6</h6>
                <div class="form-group row">
                    <label class="col-form-label col-sm-1" for="cheque6_montant">Montant</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" name="cheque6_montant" id="cheque6_montant" value="<?php echo $data['cheque6_montant']; ?>">
                    </div>
                    <label class="col-form-label col-sm-1" for="cheque6_numero">Numéro</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="cheque6_numero" id="cheque6_numero" value="<?php echo $data['cheque6_numero']; ?>">
                    </div>
                    <label class="col-form-label col-sm-2" for="cheque6_date_encaissement">Date d'encaissement</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" name="cheque6_date_encaissement" id="cheque6_date_encaissement" value="<?php echo $data['cheque6_date_encaissement']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-1" for="cheque6_emetteur">Emetteur</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="cheque6_emetteur" id="cheque6_emetteur" value="<?php echo $data['cheque6_emetteur']; ?>">
                    </div>
                    <label class="col-form-label col-sm-1" for="cheque6_banque">Banque</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="cheque6_banque" id="cheque6_banque" value="<?php echo $data['cheque6_banque']; ?>">
                    </div>
                </div>
            </div><br>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="cv_montant">Montant Chèques Vacances</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" name="cv_montant" id="cv_montant" value="<?php echo $data['cv_montant']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="cv_nom">Nom Chèques Vacances</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="cv_nom" id="cv_nom" value="<?php echo $data['cv_nom']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="caf_rgt">Règlement CAF</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" name="caf_rgt" id="caf_rgt" value="<?php echo $data['caf_rgt']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="caf_caution">Caution CAF</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" name="caf_caution" id="caf_caution" value="<?php echo $data['caf_caution']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="bourse">Bourse</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" name="bourse" id="bourse" value="<?php echo $data['bourse']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="autre">Autre (espèces, compte, permanent...)</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" name="autre" id="autre" value="<?php echo $data['autre']; ?>">
                </div>
            </div>

            <h4>Transport</h4><br>

            <h5>Aller</h5><br>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="aller_transport">J'arriverai au Mourtis en <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" data-html="true" title="Pour rejoindre le lieu de camp, 3 possibilités: <ul><li>Arriver en voiture</li><li>Venir en train jusqu'à la gare de Montréjeau-Gourdan Polignan, où une navette Fondacio attendra les jeunes pour les conduire sur le lieu de camp</li><li>Prendre le bus organisé par Fondacio</li></ul>"></label>
                <div class="col-sm-3">
                    <select class="form-control" name="aller_transport" id="aller_transport" required>
                        <option value="voiture" <?php echo ($data['aller_transport'] == 'voiture') ? 'selected': ''; ?>>Voiture personnelle</option>
                        <option value="train" <?php echo ($data['aller_transport'] == 'train') ? 'selected': ''; ?>>Train</option>
                        <option value="bus" <?php echo ($data['aller_transport'] == 'bus') ? 'selected': ''; ?>>Bus organisé par Fondacio</option>
                    </select>
                </div>
            </div>

            <div class="form-group row" id="aller_train">
                <label class="col-form-label col-sm-2" for="aller_train">Heure d'arrivée (train)</label>
                <div class="col-sm-3">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="aller_train" id="aller_train11h25" value="11h25" <?php echo ($data['aller_transport'] == 'train' && $data['aller_heure'] == '11h25') ? 'checked': ''; ?>> 11h25 (recommandé)
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="aller_train" id="aller_train14h25" value="14h25" <?php echo ($data['aller_transport'] == 'train' && $data['aller_heure'] == '14h25') ? 'checked': ''; ?>> 14h25 (si impossible à 11h25)
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row" id="aller_ville">
                <label class="col-form-label col-sm-2" for="aller_ville">Ville de départ (bus)</label>
                <div class="col-sm-3">
                    <select class="form-control" name="aller_ville" id="aller_bus_clear">
                        <option value="" id="aller_bus_villes"></option>
                    </select>
                </div>
            </div>

            <h5>Retour</h5><br>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="retour_transport">Je repartirai du Mourtis en <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <select class="form-control" name="retour_transport" id="retour_transport" required>
                        <option value="voiture" <?php echo ($data['retour_transport'] == 'voiture') ? 'selected': ''; ?>>Voiture personnelle</option>
                        <option value="train" <?php echo ($data['retour_transport'] == 'train') ? 'selected': ''; ?>>Train</option>
                        <option value="bus" <?php echo ($data['retour_transport'] == 'bus') ? 'selected': ''; ?>>Bus organisé par Fondacio</option>
                    </select>
                </div>
            </div>

            <div class="form-group row" id="retour_ville">
                <label class="col-form-label col-sm-2" for="retour_ville">Ville d'arrivée (bus)</label>
                <div class="col-sm-3">
                    <select class="form-control" name="retour_ville" id="retour_bus_clear">
                        <option value="" id="retour_bus_villes" selected></option>
                    </select>
                </div>
            </div>

            <h4>Attestation (CE)</h4><br>

            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="attestation_inscription" id="attestation_inscription" value="1" <?php echo ($data['attestation_inscription']) ? 'checked': ''; ?>> Je souhaite recevoir pour mon CE une attestation d'inscription, une fois que j'aurais envoyé le dossier d'inscription papier complet
                </label>
            </div>

            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="attestation_presence" id="attestation_presence" value="1" <?php echo ($data['attestation_presence']) ? 'checked': ''; ?>> Je souhaite recevoir pour mon CE une attestation de présence et de paiement, après le camp
                </label>
            </div><br><br>

<?php
            if ($_SESSION['profil']['role'] == 'admin') {
?>
            <h4>Infos camp</h4><br>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="camp">Je m'inscris au camp <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <select class="form-control" name="camp" id="camp" required>
                        <option value="" selected></option>
                        <?php

                        $camps = get_camps();

                        foreach ($camps as $camp) {
                            if ($camp['numero'] == $data['camp']) {
                                $selected_camp = 'selected';
                            }
                            else {
                                $selected_camp = '';
                            }
                            echo '<option value="'.$camp['numero'].'" '.$selected_camp.'>Camp n°'.$camp['numero'].' ('.$camp['regions'].') du '.convert_date($camp['date_debut'], "-", "/").' au '.convert_date($camp['date_fin'], "-", "/").'</option>';
                        }

                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="ancien">J'ai déjà fait un camp "Réussir Sa Vie" <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="ancien" id="ancien1" value="1" <?php echo ($data['ancien']) ? 'checked' : ''; ?>> Oui
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="ancien" id="ancien0" value="0" <?php echo ($data['ancien']) ? '' : 'checked'; ?> required> Non
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row" id="prepa">
                <label class="col-form-label col-sm-2" for="prepa">Je m'inscris à la prépa <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="La prépa aura lieu du samedi précédant le camp à 14h jusqu'au début du camp. Le coût de la prépa est de 55 euros."></label>
                <div class="col-sm-3">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="prepa" id="prepa1" value="1" <?php echo ($data['prepa']) ? 'checked' : ''; ?>> Oui
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="prepa" id="prepa0" value="0" <?php echo ($data['prepa']) ? '' : 'checked'; ?>> Non
                        </label>
                    </div>
                </div>
            </div><br>

            <h4>Informations du jeune</h4><br>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="civilite">Civilité <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="civilite" id="civiliteF" value="F" <?php echo ($data['civilite'] == 'F') ? 'checked' : ''; ?>> Mme
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="civilite" id="civiliteH" value="H" <?php echo ($data['civilite'] == 'H') ? 'checked' : ''; ?> required> Mr
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="nom">Nom du jeune <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="nom" id="nom" value="<?php echo $data['nom']; ?>" required>
                </div>
                <label class="col-form-label col-sm-2" for="prenom">Prénom du jeune <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="prenom" id="prenom" value="<?php echo $data['prenom']; ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="adresse">Adresse <span style="color: red">*</span></label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="adresse" id="adresse" value="<?php echo $data['adresse']; ?>" required>
                </div>
                <label class="col-form-label col-sm-2" for="cp">Code postal <span style="color: red">*</span></label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="cp" id="cp" value="<?php echo $data['cp']; ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="ville">Ville <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="ville" id="ville" value="<?php echo $data['ville']; ?>" required>
                </div>
                <label class="col-form-label col-sm-2" for="pays">Pays</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="pays" id="pays" value="<?php echo $data['pays']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="tel_portable">Téléphone portable du jeune <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="A indiquer obligatoirement si le jeune vient en bus ou en train ; si le jeune n'en possède pas, indiquer celui du père ou de la mère"></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="tel_portable" id="tel_portable" value="<?php echo $data['tel_portable']; ?>" required>
                </div>
                <label class="col-form-label col-sm-2" for="tel_fixe">Téléphone fixe</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="tel_fixe" id="tel_fixe" value="<?php echo $data['tel_fixe']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="mail">Courriel personnel du jeune <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="Cette adresse nous servira à envoyer au jeune un message de bienvenue et d'éventuelles invitations aux futurs évènements."></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="mail" id="mail" value="<?php echo $data['mail']; ?>" required>
                </div>
                <label class="col-form-label col-sm-2" for="date_naissance">Date de naissance <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="date_naissance" id="date_naissance" value="<?php echo $data['date_naissance']; ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="etudes">Études actuelles</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="etudes" id="etudes4" value="4ème" <?php echo ($data['etudes'] == '4ème') ? 'checked' : ''; ?>> 4ème
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="etudes" id="etudes3" value="3ème" <?php echo ($data['etudes'] == '3ème') ? 'checked' : ''; ?>> 3ème
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="etudes" id="etudes2" value="2nde" <?php echo ($data['etudes'] == '2nde') ? 'checked' : ''; ?>> 2nde
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="etudes" id="etudes1" value="1ère" <?php echo ($data['etudes'] == '1ère') ? 'checked' : ''; ?>> 1ère
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="etudes" id="etudesT" value="Terminale" <?php echo ($data['etudes'] == 'Terminale') ? 'checked' : ''; ?>> Terminale
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="etudes" id="etudesA" value="Autre" <?php echo (!in_array($data['etudes'], array('4ème', '3ème', '2nde', '1ère', 'Terminale'))) ? 'checked' : ''; ?>> Autre
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="text" class="form-control" name="etudes_autre" id="etudesAT" value="<?php echo (!in_array($data['etudes'], array('4ème', '3ème', '2nde', '1ère', 'Terminale'))) ? $data['etudes'] : ''; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="taille">Taille (en cms)<span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="La taille et le poids sont des informations qui nous sont indispensables pour l'inscription aux activités sportives (rafting, canyoning)"></label>
                <div class="col-sm-2">
                    <input type="number" class="form-control" name="taille" id="taille" value="<?php echo $data['taille']; ?>" required>
                </div>
                <label class="col-form-label col-sm-2" for="poids">Poids (en kgs) <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="La taille et le poids sont des informations qui nous sont indispensables pour l'inscription aux activités sportives (rafting, canyoning)"></label>
                <div class="col-sm-2">
                    <input type="number" class="form-control" name="poids" id="poids" value="<?php echo $data['poids']; ?>" required>
                </div>
            </div><br>

            <h4>Coordonnées des parents (ou du responsable légal)</h4><br>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="parents_nom">Nom des parents <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="parents_nom" id="parents_nom" value="<?php echo $data['parents_nom']; ?>" required>
                </div>
                <label class="col-form-label col-sm-2" for="parents_prenom">Prénoms des parents <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="parents_prenom" id="parents_prenom" value="<?php echo $data['parents_prenom']; ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="parents_adresse">Adresse (seulement si différente de celle du jeune)</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="parents_adresse" id="parents_adresse" value="<?php echo $data['parents_adresse']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="mere_portable">Téléphone portable de la mère <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="mere_portable" id="mere_portable" value="<?php echo $data['mere_portable']; ?>" required>
                </div>
                <label class="col-form-label col-sm-2" for="pere_portable">Téléphone portable du père</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="pere_portable" id="pere_portable" value="<?php echo $data['pere_portable']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="parents_mail">Courriel des parents <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="parents_mail" id="parents_mail" value="<?php echo $data['parents_mail']; ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="observations">Observations <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="Indiquez ici ce que vous souhaitez nous signaler. Si vous souhaitez donner des informations concernant les traversées médicales et/ou psychologiques ou émotionnelles de votre enfant, afin de pouvoir l'accompagner de manière ajustée au travers de notre pédagogie et de la vie de groupe, vous pouvez le faire ici ou en envoyant un mail à jeunes.camp@fondacio.fr. Seuls le service inscriptions, les responsables et directeurs de camp et l'assistant sanitaire auront accès à ces informations."></label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="observations" id="observations" rows="3"><?php echo $data['observations']; ?></textarea>
                </div>
            </div><br>

            <h4>Paiement</h4>

            <div class="form-group row">
                <label class="col-form-label col-sm-4" for="paiement_declare">Je choisis de payer le montant suivant <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="Notez bien ce montant, il vous sera redemandé au moment du paiement.."></label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" name="paiement_declare" id="paiement_declare" value="<?php echo $data['paiement_declare']; ?>" required>
                </div>
            </div>

            <h4>Attestation (CE)</h4><br>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="ce_nom" id="ce_nom_libelle">Nom du comité d'entreprise</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="ce_nom" id="ce_nom" value="<?php echo $data['ce_nom']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="ce_mail"  id="ce_mail_libelle">Courriel du comité d'entreprise</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="ce_mail" id="ce_mail" value="<?php echo $data['ce_mail']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="ce_adresse"  id="ce_adresse_libelle">Adresse complète du comité d'entreprise</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="ce_adresse" id="ce_adresse" value="<?php echo $data['ce_adresse']; ?>">
                </div>
            </div>

            <h4>Communication</h4><br>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="communication">J'ai connu ce camp par <span style="color: red">*</span></label>
                <div class="col-sm-6">
                    <select class="form-control" name="communication" id="communication" required>
                        <option value="Une annonce dans la presse"  <?php echo ($data['communication'] == 'Une annonce dans la presse') ? 'selected': ''; ?>>Une annonce dans la presse (précisez le nom du media dans la zone "Autre")</option>
                        <option value="Le site Internet de Fondacio France"  <?php echo ($data['communication'] == 'Le site Internet de Fondacio France') ? 'selected': ''; ?>>Le site Internet de Fondacio France</option>
                        <option value="Ma famille ou des amis de mes parents"  <?php echo ($data['communication'] == 'Ma famille ou des amis de mes parents') ? 'selected': ''; ?>>Ma famille ou des amis de mes parents</option>
                        <option value="Un(e) ami(e) m'en a parlé"  <?php echo ($data['communication'] == 'Un(e) ami(e) m\'en a parlé') ? 'selected': ''; ?>>Un(e) ami(e) m'en a parlé</option>
                        <option value="Le catalogue Fondacio Jeunes"  <?php echo ($data['communication'] == 'Le catalogue Fondacio Jeunes') ? 'selected': ''; ?>>Le catalogue Fondacio Jeunes</option>
                        <option value="Un flyer reçu ou trouvé"  <?php echo ($data['communication'] == 'Un flyer reçu ou trouvé') ? 'selected': ''; ?>>Un flyer reçu ou trouvé</option>
                        <option value="Facebook"  <?php echo ($data['communication'] == 'Facebook') ? 'selected': ''; ?>>Facebook</option>
                        <option value="J'ai déjà fait un camp Réussir Sa Vie"  <?php echo ($data['communication'] == 'J\'ai déjà fait un camp Réussir Sa Vie') ? 'selected': ''; ?>>J'ai déjà fait un camp Réussir Sa Vie</option>
                        <option value="Autre"  <?php echo (!in_array($data['communication'], array('Une annonce dans la presse', 'Le site Internet de Fondacio France', 'Ma famille ou des amis de mes parents', 'Un(e) ami(e) m\'en a parlé', 'Le catalogue Fondacio Jeunes', 'Un flyer reçu ou trouvé', 'Facebook', 'J\'ai déjà fait un camp Réussir Sa Vie'))) ? 'selected': ''; ?>>Autre (précisez dans la zone "Autre")</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="communication_autre">Autre</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="communication_autre" id="communication_autre" value="<?php echo (!in_array($data['communication'], array('Une annonce dans la presse', 'Le site Internet de Fondacio France', 'Ma famille ou des amis de mes parents', 'Un(e) ami(e) m\'en a parlé', 'Le catalogue Fondacio Jeunes', 'Un flyer reçu ou trouvé', 'Facebook', 'J\'ai déjà fait un camp Réussir Sa Vie'))) ? $data['communication'] : ''; ?>">
                </div>
            </div><br>
<?php
            }
?>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
            </form>

            <script type="text/javascript">

            $(function() {

                // Gestion des transports

                if ($('#aller_transport').val() == 'bus') {
                    $.ajax({
                        type: 'POST',
                        url: '/ajax/villes_bus.php',
                        data: {
                            'camp': $('#camp').find(":selected").val(),
                            'aller_retour': 'aller',
                            'select_ville': <?php echo (!empty($data['aller_ville'])) ? '\''.$data['aller_ville'].'\'' : '\'\''; ?>
                        },
                        success: function(data){
                            $("#aller_bus_villes").after(data);
                        }
                    });
                };

                $('#aller_transport').change(function() {
                    if (this.value == "voiture") {
                        $('#aller_bus_clear option').remove();
                        $('#aller_bus_clear').append('<option value="" id="aller_bus_villes" selected></option>');
                    }
                    if (this.value == "train") {
                        $('#aller_bus_clear option').remove();
                        $('#aller_bus_clear').append('<option value="" id="aller_bus_villes" selected></option>');
                    }
                    if (this.value == "bus") {
                        $.ajax({
                            type: 'POST',
                            url: '/ajax/villes_bus.php',
                            data: {
                                'camp': $('#camp').find(":selected").val(),
                                'aller_retour': 'aller',
                                'select_ville': <?php echo (!empty($data['aller_ville'])) ? '\''.$data['aller_ville'].'\'' : '\'\''; ?>
                            },
                            success: function(data){
                                $("#aller_bus_villes").after(data);
                            }
                        });
                    }
                });

                if ($('#retour_transport').val() == 'bus') {
                    $.ajax({
                        type: 'POST',
                        url: '/ajax/villes_bus.php',
                        data: {
                            'camp': $('#camp').find(":selected").val(),
                            'aller_retour': 'retour',
                            'select_ville': <?php echo (!empty($data['retour_ville'])) ? '\''.$data['retour_ville'].'\'' : '\'\''; ?>
                        },
                        success: function(data){
                            $("#retour_bus_villes").after(data);
                        }
                    });
                }

                $('#retour_transport').change(function() {
                    if (this.value == "voiture") {
                        $('#retour_bus_clear option').remove();
                        $('#retour_bus_clear').append('<option value="" id="retour_bus_villes" selected></option>');
                    }
                    if (this.value == "train") {
                        $('#retour_bus_clear option').remove();
                        $('#retour_bus_clear').append('<option value="" id="retour_bus_villes" selected></option>');
                    }
                    if (this.value == "bus") {
                        $.ajax({
                            type: 'POST',
                            url: '/ajax/villes_bus.php',
                            data: {
                                'camp': $('#camp').find(":selected").val(),
                                'aller_retour': 'retour',
                                'select_ville': <?php echo (!empty($data['retour_ville'])) ? '\''.$data['retour_ville'].'\'' : '\'\''; ?>
                            },
                            success: function(data){
                                $("#retour_bus_villes").after(data);
                            }
                        });
                    }
                });

                $('#cheques').hide();
                if ($('#rgt_moyen').val() == 'cheque') {
                    $('#cheques').show();
                }
                $('#rgt_moyen').change(function() {
                    if (this.value == "cheque") {
                        $('#cheques').show();
                    }
                    else {
                        $('#cheques').hide();
                    }
                });
            });

        </script>
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

    <h3>Liste des inscrits</h3><br>

    <form action="" method="POST">

    <h4>Filtres</h4>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="nom">Nom du jeune</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="nom" id="nom" value="<?php echo $_POST['nom']; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="da_complet">DA incomplet ?</label>
            <div class="col-sm-3">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input position-static" type="checkbox" name="da_complet" id="da_complet" value="1" <?php echo ($_POST['da_complet']) ? 'checked': ''; ?>>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="da_a_relancer">DA à relancer ?</label>
            <div class="col-sm-3">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input position-static" type="checkbox" name="da_a_relancer" id="da_a_relancer" value="1" <?php echo ($_POST['da_a_relancer']) ? 'checked': ''; ?>>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="rgt_recu">Règlement non reçu ?</label>
            <div class="col-sm-3">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input position-static" type="checkbox" name="rgt_recu" id="rgt_recu" value="1" <?php echo ($_POST['rgt_recu']) ? 'checked': ''; ?>>
                    </label>
                </div>
            </div>
        </div>

    <h4>Tri</h4>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="tri">Trier par</label>
            <div class="col-sm-3">
                <select class="form-control" name="tri" id="tri">
                    <option value="" selected></option>
                    <option value="nom" <?php echo (!empty($_POST['tri']) && $_POST['tri'] == 'nom') ? 'selected' : ''; ?>>Nom</option>
                    <option value="prenom" <?php echo (!empty($_POST['tri']) && $_POST['tri'] == 'prenom') ? 'selected' : ''; ?>>Prénom</option>
                    <option value="da_complet" <?php echo (!empty($_POST['tri']) && $_POST['tri'] == 'da_complet') ? 'selected' : ''; ?>>DA Complet</option>
                    <option value="da_a_relancer" <?php echo (!empty($_POST['tri']) && $_POST['tri'] == 'da_a_relancer') ? 'selected' : ''; ?>>DA à relancer</option>
                    <option value="rgt_recu" <?php echo (!empty($_POST['tri']) && $_POST['tri'] == 'rgt_recu') ? 'selected' : ''; ?>>Règlement reçu</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Filtrer / Trier</button>
            </div>
        </div>

    </form>

    <table class="table table-sm table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">DA complet</th>
                <th scope="col">DA à relancer</th>
                <th scope="col">Règlement reçu</th>
                <th scope="col">Solde</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $filtres = array();

            if (!empty($_POST['nom'])) {
                $filtres['nom'] = $_POST['nom'];
            }
            if (!empty($_POST['da_complet'])) {
                $filtres['da_complet'] = $_POST['da_complet'];
            }
            if (!empty($_POST['da_a_relancer'])) {
                $filtres['da_a_relancer'] = $_POST['da_a_relancer'];
            }
            if (!empty($_POST['rgt_recu'])) {
                $filtres['rgt_recu'] = $_POST['rgt_recu'];
            }

            $inscrits = get_inscrits(1, $filtres, $_POST['tri']);

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
                        <td>'.($data['rgt_montant']-$data['paiement_declare']).'</td>
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