<?php

require_once 'include/init.php';

$title = 'Administration Adultes';
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
            redirect('/administration_adultes.php');
        }

        else {
            $login = get_infos_login($_POST['login']);
            if ($login['role'] != 'admin') {
                $_SESSION['camp'] = $login['camp'];
            }
            $_SESSION['profil']['id'] = $login['id_utilisateur'];
            $_SESSION['profil']['role'] = $login['role'];
            redirect('/administration_adultes.php');
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

            $data = get_adulte($_GET['id']);

            if (!empty($_POST)) {

                if(empty($_POST['desistement'])) {
                    $_POST['desistement'] = 'NULL';
                }

                maj_administratif_jeune($_GET['id'], $_POST);
                $_SESSION['edit_ok'] = 1;
                redirect('/administration_adultes.php?action=edit&id='.$_GET['id']);

            }

?>

            <h2>Fiche de <?php echo $data['prenom'].' '.$data['nom'].' '; ?></h2>
            <a class="btn btn-secondary" href="administration_adultes.php" role="button">Retour</a><br><br>

            <h4>Administratif</h4><br>

            <form action="" method="POST">

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
                <label class="col-form-label col-sm-2" for="da_reception">Date d'inscription</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="date_saisie" id="date_saisie" value="<?php echo date('d/m/Y H:i:s', strtotime($data['date_saisie'])); ?>" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="desistement">Désistement le</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="desistement" id="desistement" value="<?php echo $data['desistement']; ?>">
                </div>
            </div>

            <h4>Transport</h4><br>

            <h5>Aller</h5><br>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="aller_transport">J'arriverai au Mourtis en <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <select class="form-control" name="aller_transport" id="aller_transport" required>
                        <option value="sur_place" <?php echo ($data['aller_transport'] == 'sur_place') ? 'selected': ''; ?>>Je serai sur place</option>
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

            <div class="form-group row" id="retour_train">
                <label class="col-form-label col-sm-2" for="retour_train">Heure de départ (train)</label>
                <div class="col-sm-3">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="retour_train" id="retour_train11h25" value="11h25" <?php echo ($data['retour_transport'] == 'train' && $data['retour_heure'] == '11h25') ? 'checked': ''; ?>> 11h25 (recommandé)
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="retour_train" id="retour_train14h25" value="14h25" <?php echo ($data['retour_transport'] == 'train' && $data['retour_heure'] == '14h25') ? 'checked': ''; ?>> 14h25 (si impossible à 11h25)
                        </label>
                    </div>
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

            <h4>Informations</h4><br>

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
                            <input class="form-check-input" type="radio" name="civilite" id="civiliteH" value="H" <?php echo ($data['civilite'] == 'H') ? 'checked' : ''; ?> required> M.
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="nom">Nom <span style="color: red">*</span></label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="nom" id="nom" value="<?php echo $data['nom']; ?>" required>
                </div>
                <label class="col-form-label col-sm-2" for="nom_usage">Nom d'usage</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="nom_usage" id="nom_usage" value="<?php echo $data['nom_usage']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="prenom">Prénom <span style="color: red">*</span></label>
                <div class="col-sm-2">
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
                <label class="col-form-label col-sm-2" for="tel_portable">Téléphone portable <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="tel_portable" id="tel_portable" value="<?php echo $data['tel_portable']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="tel_fixe">Téléphone fixe</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="tel_fixe" id="tel_fixe" value="<?php echo $data['tel_fixe']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="mail">Adresse mail <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="mail" id="mail" value="<?php echo $data['mail']; ?>" required>
                </div>
                <label class="col-form-label col-sm-2" for="profession">Profession</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="profession" id="profession" value="<?php echo $data['profession']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="lieu_naissance">Lieu de naissance <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="lieu_naissance" id="lieu_naissance" value="<?php echo $data['lieu_naissance']; ?>" required>
                </div>
                <label class="col-form-label col-sm-2" for="date_naissance">Date de naissance <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="date_naissance" id="date_naissance" value="<?php echo $data['date_naissance']; ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="allergies">Allergies ou intolérances</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="allergies" id="allergies" value="<?php echo $data['allergies']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="appele_par">J'ai été appelé par</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="appele_par" id="appele_par" value="<?php echo $data['appele_par']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="permis">Ai-je le permis B? <span style="color: red">*</span></label>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="permis" id="permisO" value="1" <?php echo ($data['permis'] == 1) ? 'checked' : ''; ?>> Oui
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="permis" id="permisN" value="0" <?php echo ($data['permis'] == 0) ? 'checked' : ''; ?> required> Non
                        </label>
                    </div>
                </div>
                <label class="col-form-label col-sm-6" for="ok_conduire">J'ai au moins 23 ans, je possède le permis de conduire depuis plus de 3 ans et je me sens capable de conduire en montagne un des véhicules de Fondacio, notamment pour transporter des jeunes</label>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="ok_conduire" id="ok_conduireO" value="1" <?php echo ($data['ok_conduire'] == 1) ? 'checked' : ''; ?>> Oui
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="ok_conduire" id="ok_conduireN" value="0" <?php echo ($data['ok_conduire'] == 0) ? 'checked' : ''; ?>> Non
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-4" for="permis">Je possède un ou plusieurs diplôme(s)</label>
                <div class="col-sm-8">
                    <div class="form-check form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="diplome_bafd" value="1" id="diplome_bafd" <?php echo ($data['diplome_bafd'] == 1) ? 'checked' : ''; ?>>Titulaire du BAFD
                        </label>
                    </div>
                    <div class="form-check form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="diplome_bafa" value="1" id="diplome_bafa" <?php echo ($data['diplome_bafa'] == 1) ? 'checked' : ''; ?>>Titulaire du BAFA
                        </label>
                    </div>
                    <div class="form-check form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="diplome_secouriste" value="1" id="diplome_secouriste" <?php echo ($data['diplome_secouriste'] == 1) ? 'checked' : ''; ?>>PSC1 ou PSCE1 ou secouriste
                        </label>
                    </div>
                    <div class="form-check form-check">
                        <label class="form-check-label col-sm-8">
                            <input class="form-check-input" type="checkbox" value="1">Si vous détenez ce diplôme, vous avez un diplôme de premiers secours : infirmier(ère), médecin, chirurgien(ne)-dentiste, pharmacien(ne), détenteur (trice) de l’AFPS, du BN ou le CSST. Si oui précisez lequel ou lesquels : <input type="text" class="form-control" name="diplome_ps" id="diplome_ps" value="<?php $data['diplome_ps'] ?>">
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-check-label col-sm-8">
                            <input class="form-check-input" type="checkbox" value="1" id="diplome_autre">Autre(s) diplôme(s) : <input type="text" class="form-control" name="diplome_autre" id="diplome_autre" value="<?php $data['diplome_autre'] ?>">
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="stagiaire">Je suis</label>
                <div class="col-sm-3">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="stagiaire" id="stagiaireBAFA" value="BAFA" <?php echo ($data['stagiaire'] == "BAFA") ? 'checked' : ''; ?>> Stagiaire BAFA
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="stagiaire" id="stagiaireBAFD" value="BAFD" <?php echo ($data['stagiaire'] == "BAFD") ? 'checked' : ''; ?>> Stagiaire BAFD
                        </label>
                    </div>
                </div>
            </div>

            <h5>WE de formation</h5>

            <div class="form-group row">
                <label class="col-form-label col-sm-12">
                    Un week-end de formation aura lieu du vendredi 25 au dimanche 27 mai 2018, à l’Ermitage à Versailles.<br>
                    Nous avons à cœur que chaque adulte venant sur un camp puisse avoir les outils nécessaires à l’encadrement de mineurs, et aussi, que ce week-end soit l’opportunité de rencontrer une majorité des personnes avec lesquelles vous serez dans cette aventure !<br>
                    Nous souhaitons que toutes les personnes soient présentes qu’elles aient déjà été dans des équipes d’encadrement ou non (salariés, bénévoles, services civiques, …)
                </label>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="we_formation">Je serai présent au WE de formation <span style="color: red">*</span></label>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="we_formation" id="we_formationO" value="1" <?php echo ($data['we_formation'] == 1) ? 'checked' : ''; ?>> Oui
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="we_formation" id="we_formationN" value="0" <?php echo ($data['we_formation'] == 0) ? 'checked' : ''; ?> required> Non
                        </label>
                    </div>
                </div>
                <label class="col-form-label col-sm-2" for="we_formation_refus">Si non, pourquoi ?</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="we_formation_refus" id="we_formation_refus" value="<?php $data['we_formation_refus'] ?>">
                </div>
            </div>

            <h4>A contacter en cas d'urgence</h4><br>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="urgence_nom">Nom <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="urgence_nom" id="urgence_nom" value="<?php echo $data['urgence_nom']; ?>" required>
                </div>
                <label class="col-form-label col-sm-2" for="urgence_prenom">Prénom <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="urgence_prenom" id="urgence_prenom" value="<?php echo $data['urgence_prenom']; ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="urgence_portable">Téléphone <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="urgence_portable" id="urgence_portable" value="<?php echo $data['urgence_portable']; ?>" required>
                </div>
                <label class="col-form-label col-sm-2" for="urgence_lien">Lien <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="urgence_lien" id="urgence_lien" value="<?php echo $data['urgence_lien']; ?>" required>
                </div>
            </div>

            <h4>Paiement</h4>

            <div class="form-group row">
                <label class="col-form-label col-sm-4" for="paiement_declare">Je choisis de payer le montant suivant <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="Notez bien ce montant, il vous sera redemandé au moment du paiement.."></label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" name="paiement_declare" id="paiement_declare" value="<?php echo $data['paiement_declare']; ?>" required>
                </div>
            </div>

            <h4>Activités</h4>

            <h6>Activités sur site</h6>

            <div class="form-group row">
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_arts_plastiques" id="act_arts_plastiques" value="1" <?php echo ($data['act_arts_plastiques'] == 1) ? 'checked' : ''; ?>> Arts plastiques
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-check-label">
                        Si possible, préciser <input type="text" class="form-control" name="act_arts_plastiques_p" id="act_arts_plastiques_p" value="<?php echo $data['act_arts_plastiques_p'] ?>">
                    </label>
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_bd" id="act_bd" value="1" <?php echo ($data['act_bd'] == 1) ? 'checked' : ''; ?>> Bande dessinée
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_orient_pro" id="act_orient_pro" value="1" <?php echo ($data['act_orient_pro'] == 1) ? 'checked' : ''; ?>> Orientation professionelle
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_cinema" id="act_cinema" value="1" <?php echo ($data['act_cinema'] == 1) ? 'checked' : ''; ?>> Cinéma
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_exp_corp" id="act_exp_corp" value="1" <?php echo ($data['act_exp_corp'] == 1) ? 'checked' : ''; ?>> Expressions corporelles
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-check-label">
                        Si possible, préciser <input type="text" class="form-control" name="act_exp_corp_p" id="act_exp_corp_p" value="<?php echo $data['act_exp_corp_p'] ?>">
                    </label>
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_jeux_piste" id="act_jeux_piste" value="1" <?php echo ($data['act_jeux_piste'] == 1) ? 'checked' : ''; ?>> Jeux de piste
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_meditation" id="act_meditation" value="1" <?php echo ($data['act_meditation'] == 1) ? 'checked' : ''; ?>> Méditation
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_arts_enigme" id="act_arts_enigme" value="1" <?php echo ($data['act_arts_enigme'] == 1) ? 'checked' : ''; ?>> Énigmes
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_musiques" id="act_musiques" value="1" <?php echo ($data['act_musiques'] == 1) ? 'checked' : ''; ?>> Musiques
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-check-label">
                        Si possible, préciser <input type="text" class="form-control" name="act_musiques_p" id="act_musiques_p" value="<?php echo $data['act_musiques_p'] ?>">
                    </label>
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_jeux_mem" id="act_jeux_mem" value="1" <?php echo ($data['act_jeux_mem'] == 1) ? 'checked' : ''; ?>> Jeux de mémoire
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_ecritures" id="act_ecritures" value="1" <?php echo ($data['act_ecritures'] == 1) ? 'checked' : ''; ?>> Écritures/récits
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-check-label">
                        Si possible, préciser <input type="text" class="form-control" name="act_ecritures_p" id="act_ecritures_p" value="<?php echo $data['act_ecritures_p'] ?>">
                    </label>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_danses" id="act_danses" value="1" <?php echo ($data['act_danses'] == 1) ? 'checked' : ''; ?>> Danses
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-check-label">
                        Si possible, préciser <input type="text" class="form-control" name="act_danses_p" id="act_danses_p" value="<?php echo $data['act_danses_p'] ?>">
                    </label>
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_sculpture" id="act_sculpture" value="1" <?php echo ($data['act_sculpture'] == 1) ? 'checked' : ''; ?>> Sculpture, modelage
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_arts_rue" id="act_arts_rue" value="1" <?php echo ($data['act_arts_rue'] == 1) ? 'checked' : ''; ?>> Arts de la rue
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-check-label">
                        Si possible, préciser <input type="text" class="form-control" name="act_arts_rue_p" id="act_arts_rue_p" value="<?php echo $data['act_arts_rue_p'] ?>">
                    </label>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_chants" id="act_chants" value="1" <?php echo ($data['act_chants'] == 1) ? 'checked' : ''; ?>> Chants
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-check-label">
                        Si possible, préciser <input type="text" class="form-control" name="act_chants_p" id="act_chants_p" value="<?php echo $data['act_chants_p'] ?>">
                    </label>
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_bijoux" id="act_bijoux" value="1" <?php echo ($data['act_bijoux'] == 1) ? 'checked' : ''; ?>> Bijoux (bracelets, colliers etc...)
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_sports" id="act_sports" value="1" <?php echo ($data['act_sports'] == 1) ? 'checked' : ''; ?>> Sports
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-check-label">
                        Si possible, préciser <input type="text" class="form-control" name="act_sports_p" id="act_sports_p" value="<?php echo $data['act_sports_p'] ?>">
                    </label>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_imagination" id="act_imagination" value="1" <?php echo ($data['act_imagination'] == 1) ? 'checked' : ''; ?>> Imagination
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-check-label">
                        Si possible, préciser le support <input type="text" class="form-control" name="act_imagination_p" id="act_imagination_p" value="<?php echo $data['act_imagination_p'] ?>">
                    </label>
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_relaxation" id="act_relaxation" value="1" <?php echo ($data['act_relaxation'] == 1) ? 'checked' : ''; ?>> Relaxation
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_theatres" id="act_theatres" value="1" <?php echo ($data['act_theatres'] == 1) ? 'checked' : ''; ?>> Théâtres
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-check-label">
                        Si possible, préciser <input type="text" class="form-control" name="act_theatres_p" id="act_theatres_p" value="<?php echo $data['act_theatres_p'] ?>">
                    </label>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_arts_cirque" id="act_arts_cirque" value="1" <?php echo ($data['act_arts_cirque'] == 1) ? 'checked' : ''; ?>> Arts du cirque
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-check-label">
                        Si possible, préciser <input type="text" class="form-control" name="act_arts_cirque_p" id="act_arts_cirque_p" value="<?php echo $data['act_arts_cirque_p'] ?>">
                    </label>
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_photo" id="act_photo" value="1" <?php echo ($data['act_photo'] == 1) ? 'checked' : ''; ?>> Photographie
                        </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_illustrations" id="act_illustrations" value="1" <?php echo ($data['act_illustrations'] == 1) ? 'checked' : ''; ?>> Illustrations
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-check-label">
                        Si possible, préciser <input type="text" class="form-control" name="act_illustrations_p" id="act_illustrations_p" value="<?php echo $data['act_illustrations_p'] ?>">
                    </label>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_logique" id="act_logique" value="1" <?php echo ($data['act_logique'] == 1) ? 'checked' : ''; ?>> Logique
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="act_strategie" id="act_strategie" value="1" <?php echo ($data['act_strategie'] == 1) ? 'checked' : ''; ?>> Stratégie
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-check-label">
                        Autres <input type="text" class="form-control" name="act_autres" id="act_autres" value="<?php echo $data['act_autres'] ?>">
                    </label>
                </div>
            </div>

            <h6>Activités hors site (niveau débutant)</h6>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="act_rafting">Rafting <span style="color: red">*</span></label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_rafting" id="act_rafting2" value="2" <?php echo ($data['act_rafting'] == 2) ? 'checked' : ''; ?>> Je souhaite le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_rafting" id="act_rafting1" value="1" <?php echo ($data['act_rafting'] == 1) ? 'checked' : ''; ?>> Je peux le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_rafting" id="act_rafting0" value="0" <?php echo ($data['act_rafting'] == 0) ? 'checked' : ''; ?> required> Il m'est impossible de le faire
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="act_canyo">Canyoning <span style="color: red">*</span></label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_canyo" id="act_canyo" value="2" <?php echo ($data['act_canyo'] == 2) ? 'checked' : ''; ?>> Je souhaite le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_canyo" id="act_canyo1" value="1" <?php echo ($data['act_canyo'] == 1) ? 'checked' : ''; ?>> Je peux le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_canyo" id="act_canyo0" value="0" <?php echo ($data['act_canyo'] == 0) ? 'checked' : ''; ?> required> Il m'est impossible de le faire
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="act_descente">Descente VTT <span style="color: red">*</span></label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_descente" id="act_descente2" value="2" <?php echo ($data['act_descente'] == 2) ? 'checked' : ''; ?>> Je souhaite le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_descente" id="act_descente1" value="1" <?php echo ($data['act_descente'] == 1) ? 'checked' : ''; ?>> Je peux le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_descente" id="act_descente0" value="0" <?php echo ($data['act_descente'] == 0) ? 'checked' : ''; ?> required> Il m'est impossible de le faire
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="act_mini_raid">Mini raid VTT <span style="color: red">*</span></label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_mini_raid" id="act_mini_raid2" value="2" <?php echo ($data['act_mini_raid'] == 2) ? 'checked' : ''; ?>> Je souhaite le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_mini_raid" id="act_mini_raid1" value="1" <?php echo ($data['act_mini_raid'] == 1) ? 'checked' : ''; ?>> Je peux le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_mini_raid" id="act_mini_raid0" value="0" <?php echo ($data['act_mini_raid'] == 0) ? 'checked' : ''; ?> required> Il m'est impossible de le faire
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="act_via_fe">Via Ferrata <span style="color: red">*</span></label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_via_fe" id="act_via_fe2" value="2" <?php echo ($data['act_rafting'] == 2) ? 'checked' : ''; ?>> Je souhaite le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_via_fe" id="act_via_fe1" value="1" <?php echo ($data['act_via_fe'] == 1) ? 'checked' : ''; ?>> Je peux le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_via_fe" id="act_via_fe0" value="0" <?php echo ($data['act_via_fe'] == 0) ? 'checked' : ''; ?> required> Il m'est impossible de le faire
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="act_grimp">Grimp'arbre <span style="color: red">*</span></label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_grimp" id="act_grimp2" value="2" <?php echo ($data['act_grimp'] == 2) ? 'checked' : ''; ?>> Je souhaite le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_grimp" id="act_grimp1" value="1" <?php echo ($data['act_grimp'] == 1) ? 'checked' : ''; ?>> Je peux le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_grimp" id="act_grimp0" value="0" <?php echo ($data['act_grimp'] == 0) ? 'checked' : ''; ?> required> Il m'est impossible de le faire
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="act_bike_park">Mourtis Bike Park <span style="color: red">*</span></label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_bike_park" id="act_bike_park2" value="2" <?php echo ($data['act_bike_park'] == 2) ? 'checked' : ''; ?>> Je souhaite le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_bike_park" id="act_bike_park1" value="1" <?php echo ($data['act_bike_park'] == 1) ? 'checked' : ''; ?>> Je peux le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_bike_park" id="act_bike_park0" value="0" <?php echo ($data['act_bike_park'] == 0) ? 'checked' : ''; ?> required> Il m'est impossible de le faire
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="act_speed_chall">Mourtis Speed Challenge <span style="color: red">*</span></label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_speed_chall" id="act_speed_chall2" value="2" <?php echo ($data['act_rafting'] == 2) ? 'checked' : ''; ?>> Je souhaite le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_speed_chall" id="act_speed_chall1" value="1" <?php echo ($data['act_speed_chall'] == 1) ? 'checked' : ''; ?>> Je peux le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_speed_chall" id="act_speed_chall0" value="0" <?php echo ($data['act_speed_chall'] == 0) ? 'checked' : ''; ?> required> Il m'est impossible de le faire
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="act_biathlon">Biathlon <span style="color: red">*</span></label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_biathlon" id="act_biathlon2" value="2" <?php echo ($data['act_biathlon'] == 2) ? 'checked' : ''; ?>> Je souhaite le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_biathlon" id="act_biathlon1" value="1" <?php echo ($data['act_biathlon'] == 1) ? 'checked' : ''; ?>> Je peux le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_biathlon" id="act_biathlon0" value="0" <?php echo ($data['act_biathlon'] == 0) ? 'checked' : ''; ?> required> Il m'est impossible de le faire
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="act_piscine">Piscine <span style="color: red">*</span></label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_piscine" id="act_piscine2" value="2" <?php echo ($data['act_piscine'] == 2) ? 'checked' : ''; ?>> Je souhaite le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_piscine" id="act_piscine1" value="1" <?php echo ($data['act_piscine'] == 1) ? 'checked' : ''; ?>> Je peux le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_piscine" id="act_piscine0" value="0" <?php echo ($data['act_piscine'] == 0) ? 'checked' : ''; ?> required> Il m'est impossible de le faire
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="act_sports_co">Animation sports co <span style="color: red">*</span></label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_sports_co" id="act_sports_co2" value="2" <?php echo ($data['act_sports_co'] == 2) ? 'checked' : ''; ?>> Je souhaite le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_sports_co" id="act_sports_co1" value="1" <?php echo ($data['act_sports_co'] == 1) ? 'checked' : ''; ?>> Je peux le faire
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="act_sports_co" id="act_sports_co0" value="0" <?php echo ($data['act_sports_co'] == 0) ? 'checked' : ''; ?> required> Il m'est impossible de le faire
                        </label>
                    </div>
                </div>
            </div>

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
                    $('#aller_train').hide();
                };

                if ($('#aller_transport').val() == 'train') {
                    $('#aller_train').show();
                    $('#aller_ville').hide();
                }

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
                    $('#retour_train').hide();
                }

                if ($('#retour_transport').val() == 'train') {
                    $('#retour_train').show();
                    $('#retour_ville').hide();
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
            });

        </script>
<?php
        }

    }

    else {

?>

    <h2>Administration</h2><br>

    <h3>Liste des inscrits</h3><br>

    <form action="" method="POST">

    <h4>Filtres</h4>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="nom">Nom</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="nom" id="nom" value="<?php echo $_POST['nom']; ?>">
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
                <th scope="col">Camp</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $filtre = '';

            if (!empty($_POST['nom'])) {
                $filtre = $_POST['nom'];
            }

            $inscrits = get_inscrits_adultes($_SESSION['camp'], $filtre, $_POST['tri']);

            foreach ($inscrits as $id_adulte => $data) {

                $color = '#FFFFFF';

                if (!empty($data['desistement'])) {
                    $color = '#DC0B0B';
                }

                echo '
                    <tr bgcolor="'.$color.'">
                        <td><a href="administration_adultes.php?action=edit&id='.$id_adulte.'">'.$data['nom'].'</a></td>
                        <td>'.$data['prenom'].'</td>
                        <td>'.$data['camp'].'</td>
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