<?php

require_once 'include/init.php';

////////// AJOUT / EDITION / SUPPRESSION D'UN PARTICIPANT //////////

if (!empty($_GET['action'])) {
    switch ($_GET['action']) {
        case 'del':
            delete_participant($_GET['id_participant']);
            break;

        case 'edit':
            $donnees = get_participant($_GET['id'], $_GET['type']);
            /*$donnees['activite_mardi_creative'] = get_historique($_GET['id_participant'], 'mardi', 'creative');
            $donnees['activite_mardi_sportive'] = get_historique($_GET['id_participant'], 'mardi', 'sportive');
            $donnees['activite_mercredi_creative'] = get_historique($_GET['id_participant'], 'mercredi', 'creative');
            $donnees['activite_mercredi_sportive'] = get_historique($_GET['id_participant'], 'mercredi', 'sportive');
            $donnees['activite_jeudi_creative'] = get_historique($_GET['id_participant'], 'jeudi', 'creative');
            $donnees['activite_jeudi_sportive'] = get_historique($_GET['id_participant'], 'jeudi', 'sportive');
            $donnees['activite_vendredi_creative'] = get_historique($_GET['id_participant'], 'vendredi', 'creative');
            $donnees['activite_vendredi_sportive'] = get_historique($_GET['id_participant'], 'vendredi', 'sportive');*/
            $titre = 'Fiche de '.$donnees['prenom'].' '.$donnees['nom'];
            break;

        case 'add':
            $titre = 'Ajout d\'un participant';
            break;

    }
    if (!empty($_POST) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')) {
        update_participant($_GET['action'], $_POST, $_GET['id_participant']);
    }

    $title = 'Participants';
    require_once 'include/head.php';

?>
    <h2><?php echo $titre; ?></h2>
    <a class="btn btn-secondary" href="participants.php" role="button">Retour</a>
    <a class="btn btn-danger" href="participants.php?action=del&id=<?php echo $_GET['id']; ?>&type=<?php echo $_GET['type']; ?>" role="button">Supprimer</a><br><br>

    <?php
        if ($_GET['type'] == 'adulte') {
    ?>

        <form action="" method="POST">
            <div class="form-group row">
                <label for="date_inscription" class="col-md-2 col-form-label">Date d'inscription</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="date_inscription" value="<?php echo $donnees['date_saisie']; ?>" disabled>
                </div>
                <label for="camp" class="col-md-1 col-form-label">Camp</label>
                <div class="col-md-1">
                    <input type="text" class="form-control" name="camp" value="<?php echo $donnees['camp']; ?>" <?php echo ($_GET['action'] == 'edit') ? 'disabled' : ''; ?>>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="prepa">Prépa</label>
                <div class="col-sm-3">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="prepa" id="prepa1" value="1" <?php echo ($donnees['prepa'] == 1) ? 'checked' : ''; ?>> Oui
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="prepa" id="prepa0" value="0" <?php echo ($donnees['prepa'] == 0) ? 'checked' : ''; ?>> Non
                        </label>
                    </div>
                </div>
                <label for="service" class="col-md-1 col-form-label">Service</label>
                <div class="col-md-3">
                    <select class="form-control" name="service">
                        <option value="" selected></option>
                        <option value="Direction" <?php echo (!empty($donnees['service']) && $donnees['service'] == 'Direction') ? 'selected' : ''; ?>>Direction</option>
                        <option value="Logistique" <?php echo (!empty($donnees['service']) && $donnees['service'] == 'Logistique') ? 'selected' : ''; ?>>Logistique</option>
                        <option value="Temps Fun" <?php echo (!empty($donnees['service']) && $donnees['service'] == 'Temps Fun') ? 'selected' : ''; ?>>Temps Fun</option>
                        <option value="Soirées" <?php echo (!empty($donnees['service']) && $donnees['service'] == 'Soirées') ? 'selected' : ''; ?>>Soirées</option>
                        <option value="Trame" <?php echo (!empty($donnees['service']) && $donnees['service'] == 'Trame') ? 'selected' : ''; ?>>Trame</option>
                        <option value="Resteau" <?php echo (!empty($donnees['service']) && $donnees['service'] == 'Resteau') ? 'selected' : ''; ?>>Resteau</option>
                        <option value="RAAR" <?php echo (!empty($donnees['service']) && $donnees['service'] == 'RAAR') ? 'selected' : ''; ?>>RAAR</option>
                        <option value="Chant et Musique" <?php echo (!empty($donnees['service']) && $donnees['service'] == 'Chant et Musique') ? 'selected' : ''; ?>>Chant et Musique</option>
                        <option value="Déco" <?php echo (!empty($donnees['service']) && $donnees['service'] == 'Déco') ? 'selected' : ''; ?>>Déco</option>
                        <option value="Compagnonage" <?php echo (!empty($donnees['service']) && $donnees['service'] == 'Compagnonage') ? 'selected' : ''; ?>>Compagnonage</option>
                        <option value="Sono/Vidéo" <?php echo (!empty($donnees['service']) && $donnees['service'] == 'Sono/Vidéo') ? 'selected' : ''; ?>>Sono/Vidéo</option>
                        <option value="Activités" <?php echo (!empty($donnees['service']) && $donnees['service'] == 'Activités') ? 'selected' : ''; ?>>Activités</option>
                        <option value="Santé" <?php echo (!empty($donnees['service']) && $donnees['service'] == 'Santé') ? 'selected' : ''; ?>>Santé</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="civilite">Civilité</label>
                <div class="col-sm-3">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="civilite" id="civiliteF" value="F" <?php echo ($donnees['civilite'] == 'F') ? 'checked' : ''; ?>> Mme
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="civilite" id="civiliteH" value="H" <?php echo ($donnees['civilite'] == 'H') ? 'checked' : ''; ?>> M.
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="nom">Nom</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="nom" id="nom" value="<?php echo $donnees['nom']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="nom_usage">Nom d'usage</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="nom_usage" id="nom_usage" value="<?php echo $donnees['nom_usage']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="prenom">Prénom</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="prenom" id="prenom" value="<?php echo $donnees['prenom']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="adresse">Adresse</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="adresse" id="adresse" value="<?php echo $donnees['adresse']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="cp">Code postal</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="cp" id="cp" value="<?php echo $donnees['cp']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="ville">Ville</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="ville" id="ville" value="<?php echo $donnees['ville']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="pays">Pays</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="pays" id="pays" value="<?php echo $donnees['pays']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="tel_portable">Téléphone portable</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="tel_portable" id="tel_portable" value="<?php echo $donnees['tel_portable']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="tel_fixe">Téléphone fixe</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="tel_fixe" id="tel_fixe" value="<?php echo $donnees['tel_fixe']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="mail">Adresse mail</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="mail" id="mail" value="<?php echo $donnees['mail']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="profession">Profession</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="profession" id="profession" value="<?php echo $donnees['profession']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="lieu_naissance">Lieu de naissance</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="lieu_naissance" id="lieu_naissance" value="<?php echo $donnees['lieu_naissance']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="date_naissance">Date de naissance</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="date_naissance" id="date_naissance" value="<?php echo $donnees['date_naissance']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="allergies">Allergies ou intolérances</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="allergies" id="allergies" value="<?php echo $donnees['allergies']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="appele_par">J'ai été appelé par</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="appele_par" id="appele_par" value="<?php echo $donnees['appele_par']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="permis">Ai-je le permis B?</label>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="permis" id="permisO" value="1" <?php echo ($donnees['permis'] == 1) ? 'checked' : ''; ?>> Oui
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="permis" id="permisN" value="0" <?php echo ($donnees['permis'] == 0) ? 'checked' : ''; ?>> Non
                        </label>
                    </div>
                </div>
                <label class="col-form-label col-sm-6" for="ok_conduire">J'ai au moins 23 ans, je possède le permis de conduire depuis plus de 3 ans et je me sens capable de conduire en montagne un des véhicules de Fondacio, notamment pour transporter des jeunes</label>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="ok_conduire" id="ok_conduireO" value="1" <?php echo ($donnees['ok_conduire'] == 1) ? 'checked' : ''; ?>> Oui
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="ok_conduire" id="ok_conduireN" value="0" <?php echo ($donnees['ok_conduire'] == 0) ? 'checked' : ''; ?>> Non
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-4" for="permis">Je possède un ou plusieurs diplôme(s)</label>
                <div class="col-sm-8">
                    <div class="form-check form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="diplome_bafd" value="1" id="diplome_bafd" <?php echo ($donnees['diplome_bafd'] == 1) ? 'checked' : ''; ?>>Titulaire du BAFD
                        </label>
                    </div>
                    <div class="form-check form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="diplome_bafa" value="1" id="diplome_bafa" <?php echo ($donnees['diplome_bafa'] == 1) ? 'checked' : ''; ?>>Titulaire du BAFA
                        </label>
                    </div>
                    <div class="form-check form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="diplome_secouriste" value="1" id="diplome_secouriste" <?php echo ($donnees['diplome_secouriste'] == 1) ? 'checked' : ''; ?>>PSC1 ou PSCE1 ou secouriste
                        </label>
                    </div>
                    <div class="form-check form-check">
                        <label class="form-check-label col-sm-8">
                            <input class="form-check-input" type="checkbox" value="1">Si vous détenez ce diplôme, vous avez un diplôme de premiers secours : infirmier(ère), médecin, chirurgien(ne)-dentiste, pharmacien(ne), détenteur (trice) de l’AFPS, du BN ou le CSST. Si oui précisez lequel ou lesquels : <input type="text" class="form-control" name="diplome_ps" id="diplome_ps" value="<?php $donnees['diplome_ps'] ?>">
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-check-label col-sm-8">
                            <input class="form-check-input" type="checkbox" value="1" id="diplome_autre">Autre(s) diplôme(s) : <input type="text" class="form-control" name="diplome_autre" id="diplome_autre" value="<?php $donnees['diplome_autre'] ?>">
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="stagiaire">Je suis</label>
                <div class="col-sm-3">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="stagiaire" id="stagiaireBAFA" value="BAFA" <?php echo ($donnees['stagiaire'] == "BAFA") ? 'checked' : ''; ?>> Stagiaire BAFA
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="stagiaire" id="stagiaireBAFD" value="BAFD" <?php echo ($donnees['stagiaire'] == "BAFD") ? 'checked' : ''; ?>> Stagiaire BAFD
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="urgence_nom">Nom urgence</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="urgence_nom" id="urgence_nom" value="<?php echo $donnees['urgence_nom']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="urgence_prenom">Prénom urgence</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="urgence_prenom" id="urgence_prenom" value="<?php echo $donnees['urgence_prenom']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="urgence_portable">Téléphone urgence</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="urgence_portable" id="urgence_portable" value="<?php echo $donnees['urgence_portable']; ?>">
                </div>
                <label class="col-form-label col-sm-2" for="urgence_lien">Lien urgence</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="urgence_lien" id="urgence_lien" value="<?php echo $donnees['urgence_lien']; ?>">
                </div>
            </div>

            <h4>Transport</h4><br>

            <h5>Aller</h5><br>

            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="aller_transport">J'arriverai au Mourtis en <span style="color: red">*</span></label>
                <div class="col-sm-3">
                    <select class="form-control" name="aller_transport" id="aller_transport" required>
                        <option value="sur_place" <?php echo ($donnees['aller_transport'] == 'sur_place') ? 'selected': ''; ?>>Je serai sur place</option>
                        <option value="voiture" <?php echo ($donnees['aller_transport'] == 'voiture') ? 'selected': ''; ?>>Voiture personnelle</option>
                        <option value="train" <?php echo ($donnees['aller_transport'] == 'train') ? 'selected': ''; ?>>Train</option>
                        <option value="bus" <?php echo ($donnees['aller_transport'] == 'bus') ? 'selected': ''; ?>>Bus organisé par Fondacio</option>
                    </select>
                </div>
            </div>

            <div class="form-group row" id="aller_train">
                <label class="col-form-label col-sm-2" for="aller_train">Heure d'arrivée (train)</label>
                <div class="col-sm-3">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="aller_train" id="aller_train11h25" value="11h25" <?php echo ($donnees['aller_transport'] == 'train' && $donnees['aller_heure'] == '11h25') ? 'checked': ''; ?>> 11h25 (recommandé)
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="aller_train" id="aller_train14h25" value="14h25" <?php echo ($donnees['aller_transport'] == 'train' && $donnees['aller_heure'] == '14h25') ? 'checked': ''; ?>> 14h25 (si impossible à 11h25)
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
                        <option value="voiture" <?php echo ($donnees['retour_transport'] == 'voiture') ? 'selected': ''; ?>>Voiture personnelle</option>
                        <option value="train" <?php echo ($donnees['retour_transport'] == 'train') ? 'selected': ''; ?>>Train</option>
                        <option value="bus" <?php echo ($donnees['retour_transport'] == 'bus') ? 'selected': ''; ?>>Bus organisé par Fondacio</option>
                    </select>
                </div>
            </div>

            <div class="form-group row" id="retour_train">
                <label class="col-form-label col-sm-2" for="retour_train">Heure de départ (train)</label>
                <div class="col-sm-3">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="retour_train" id="retour_train11h25" value="11h25" <?php echo ($donnees['retour_transport'] == 'train' && $donnees['retour_heure'] == '11h25') ? 'checked': ''; ?>> 11h25 (recommandé)
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="retour_train" id="retour_train14h25" value="14h25" <?php echo ($donnees['retour_transport'] == 'train' && $donnees['retour_heure'] == '14h25') ? 'checked': ''; ?>> 14h25 (si impossible à 11h25)
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

            <div class="form-group">
                <label for="chambre_num" class="col-md-2 col-form-label">Numéro chambre</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="chambre_num" value="<?php echo $donnees['chambre_num']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="chambre_resp" class="col-md-2 col-form-label">Responsable chambre</label>
                <div class="col-md-3">
                    <label class="radio-inline">
                        <input type="radio" name="chambre_resp" value="oui" <?php echo (!empty($donnees['chambre_resp']) && $donnees['chambre_resp'] == 'oui') ? 'checked' : ''; ?>> Oui
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="chambre_resp" value="non" <?php echo (!empty($donnees['chambre_resp']) && $donnees['chambre_resp'] == 'non') ? 'checked' : ''; ?>> Non
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="pg_num" class="col-md-2 col-form-label">Numéro PG</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="pg_num" value="<?php echo $donnees['pg_num']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="pg_resp" class="col-md-2 col-form-label">Responsable PG</label>
                <div class="col-md-3">
                    <label class="radio-inline">
                        <input type="radio" name="pg_resp" value="oui" <?php echo (!empty($donnees['pg_resp']) && $donnees['pg_resp'] == 'oui') ? 'checked' : ''; ?>> Oui
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="pg_resp" value="non" <?php echo (!empty($donnees['pg_resp']) && $donnees['pg_resp'] == 'non') ? 'checked' : ''; ?>> Non
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="activite_mardi_creative" class="col-md-2 col-form-label">Acti créative mardi</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="activite_mardi_creative" id="activite_mardi_creative" value="<?php echo $donnees['activite_mardi_creative']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="activite_mardi_sportive" class="col-md-2 col-form-label">Acti sportive mardi</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="activite_mardi_sportive" id="activite_mardi_sportive" value="<?php echo $donnees['activite_mardi_sportive']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="activite_mercredi_creative" class="col-md-2 col-form-label">Acti créative mercredi</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="activite_mercredi_creative" id="activite_mercredi_creative" value="<?php echo $donnees['activite_mercredi_creative']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="activite_mercredi_sportive" class="col-md-2 col-form-label">Acti sportive mercredi</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="activite_mercredi_sportive" id="activite_mercredi_sportive" value="<?php echo $donnees['activite_mercredi_sportive']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="activite_jeudi_creative" class="col-md-2 col-form-label">Acti créative jeudi</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="activite_jeudi_creative" id="activite_jeudi_creative" value="<?php echo $donnees['activite_jeudi_creative']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="activite_jeudi_sportive" class="col-md-2 col-form-label">Acti sportive jeudi</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="activite_jeudi_sportive" id="activite_jeudi_sportive" value="<?php echo $donnees['activite_jeudi_sportive']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="activite_vendredi_creative" class="col-md-2 col-form-label">Acti creative vendredi</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="activite_vendredi_creative" id="activite_vendredi_creative" value="<?php echo $donnees['activite_vendredi_creative']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="activite_vendredi_sportive" class="col-md-2 col-form-label">Acti sportive vendredi</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="activite_vendredi_sportive" id="activite_vendredi_sportive" value="<?php echo $donnees['activite_vendredi_sportive']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="manquant" class="col-md-2 col-form-label">Manquant</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="manquant" value="<?php echo $donnees['manquant']; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Sauvegarder</button>
                </div>
            </div>
        </form>

    <?php
        }

        else {

        }
    ?>

    <script>
    $(function() {

        // Gestion des activités

        /*$( "#activite_mardi_creative" ).autocomplete({
            source: 'search.php?contexte=modif_activite&type=creative',
            autoFocus: true
        });
        $( "#activite_mardi_sportive" ).autocomplete({
            source: 'search.php?contexte=modif_activite&type=sportive',
            autoFocus: true
        });
        $( "#activite_mercredi_creative" ).autocomplete({
            source: 'search.php?contexte=modif_activite&type=creative',
            autoFocus: true
        });
        $( "#activite_mercredi_sportive" ).autocomplete({
            source: 'search.php?contexte=modif_activite&type=sportive',
            autoFocus: true
        });
        $( "#activite_jeudi_creative" ).autocomplete({
            source: 'search.php?contexte=modif_activite&type=creative',
            autoFocus: true
        });
        $( "#activite_jeudi_sportive" ).autocomplete({
            source: 'search.php?contexte=modif_activite&type=sportive',
            autoFocus: true
        });
        $( "#activite_vendredi_creative" ).autocomplete({
            source: 'search.php?contexte=modif_activite&type=creative',
            autoFocus: true
        });
        $( "#activite_vendredi_sportive" ).autocomplete({
            source: 'search.php?contexte=modif_activite&type=sportive',
            autoFocus: true
        });*/

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
            if (this.value == "train" || this.value == "voiture" || this.value == "sur_place") {
                $('#aller_bus_clear option').remove();
                $('#aller_bus_clear').append('<option value="" id="aller_bus_villes" selected></option>');
            }
            if (this.value == "bus") {
                $.ajax({
                    type: 'POST',
                    url: '/ajax/villes_bus.php',
                    data: {
                        'camp': <?php echo $donnees['camp'] ?>,
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
            if (this.value == "train" || this.value == "voiture") {
                $('#retour_bus_clear option').remove();
                $('#retour_bus_clear').append('<option value="" id="retour_bus_villes" selected></option>');
            }
            if (this.value == "bus") {
                $.ajax({
                    type: 'POST',
                    url: '/ajax/villes_bus.php',
                    data: {
                        'camp': <?php echo $donnees['camp'] ?>,
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

else {

    ////////// LISTE DES PARTICIPANTS //////////

    $title = 'Participants';
    require_once 'include/head.php';

    if (isset($_GET['reset_filtres'])) {
        unset($_SESSION['filtres_participants']);
        redirect('participants.php');
    }

    if (!empty($_POST['nom'])) {
        $_SESSION['filtres_participants']['nom'] = $_POST['nom'];
    }

    if (!empty($_POST['type'])) {
        $_SESSION['filtres_participants']['type'] = $_POST['type'];
    }

    if (!empty($_POST['civilite'])) {
        $_SESSION['filtres_participants']['civilite'] = $_POST['civilite'];
    }

    if (!empty($_POST['aller_transport'])) {
        $_SESSION['filtres_participants']['aller_transport'] = $_POST['aller_transport'];
    }

    if (!empty($_POST['retour_transport'])) {
        $_SESSION['filtres_participants']['retour_transport'] = $_POST['retour_transport'];
    }

    if (isset($_POST['prepa'])) {
        $_SESSION['filtres_participants']['prepa'] = $_POST['prepa'];
    }

    if (isset($_POST['ancien'])) {
        $_SESSION['filtres_participants']['ancien'] = $_POST['ancien'];
    }

    $donnees = get_participants($_SESSION['filtres_participants']);

?>

    <h2>Liste des participants</h2>
    <div class="form-group row">
        <div class="col-sm-1">
            <button type="button" class="btn btn-primary" onclick="location.href = 'participants.php?action=add';">Ajouter</button>
        </div>
        <div class="col-sm-6">
            <button type="button" class="btn btn-secondary" onclick="location.href = 'export_csv.php?contexte=participants';">Exporter</button>
        </div>
    </div>

    <h4>Filtres</h4>

    <form action="" method="POST">
        <div class="form-group row">
            <!-- FILTRE NOM -->
            <label class="col-form-label col-sm-2" for="nom">Nom</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="nom" id="nom" value="<?php echo $_SESSION['filtres_participants']['nom']; ?>">
            </div>
            <!-- FILTRE TYPE -->
            <label class="col-form-label col-sm-1" for="type">Type</label>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="type" id="typeA" value="Adulte" <?php echo (isset($_SESSION['filtres_participants']['type']) && $_SESSION['filtres_participants']['type'] == 'Adulte') ? 'checked' : ''; ?>> Adulte
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="type" id="typeJ" value="Jeune" <?php echo (isset($_SESSION['filtres_participants']['type']) && $_SESSION['filtres_participants']['type'] == 'Jeune') ? 'checked' : ''; ?>> Jeune
                    </label>
                </div>
            </div>
            <!-- FILTRE CIVILITE -->
            <label class="col-form-label col-sm-1" for="civilite">Civilité</label>
            <div class="col-sm-3">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="civilite" id="civiliteF" value="F" <?php echo (isset($_SESSION['filtres_participants']['civilite']) && $_SESSION['filtres_participants']['civilite'] == 'F') ? 'checked' : ''; ?>> Femme
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="civilite" id="civiliteH" value="H" <?php echo (isset($_SESSION['filtres_participants']['civilite']) && $_SESSION['filtres_participants']['civilite'] == 'H') ? 'checked' : ''; ?>> Homme
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <!-- FILTRE TRANSPORT ALLER -->
            <label class="col-form-label col-sm-2" for="aller_transport">Transport aller</label>
            <div class="col-sm-3">
                <select class="form-control" name="aller_transport" id="aller_transport">
                    <option value=""></option>
                    <option value="sur_place" <?php echo (isset($_SESSION['filtres_participants']['aller_transport']) && $_SESSION['filtres_participants']['aller_transport'] == 'sur_place') ? 'selected' : ''; ?>>Je serai déjà sur place</option>
                    <option value="voiture" <?php echo (isset($_SESSION['filtres_participants']['aller_transport']) && $_SESSION['filtres_participants']['aller_transport'] == 'voiture') ? 'selected' : ''; ?>>Voiture personnelle</option>
                    <option value="train" <?php echo (isset($_SESSION['filtres_participants']['aller_transport']) && $_SESSION['filtres_participants']['aller_transport'] == 'train') ? 'selected' : ''; ?>>Train</option>
                    <option value="bus" <?php echo (isset($_SESSION['filtres_participants']['aller_transport']) && $_SESSION['filtres_participants']['aller_transport'] == 'bus') ? 'selected' : ''; ?>>Bus organisé par Fondacio</option>
                </select>
            </div>
            <!-- FILTRE TRANSPORT RETOUR -->
            <label class="col-form-label col-sm-2" for="retour_transport">Transport retour</label>
            <div class="col-sm-3">
                <select class="form-control" name="retour_transport" id="retour_transport">
                    <option value=""></option>
                    <option value="sur_place" <?php echo (isset($_SESSION['filtres_participants']['retour_transport']) && $_SESSION['filtres_participants']['retour_transport'] == 'sur_place') ? 'selected' : ''; ?>>Je serai déjà sur place</option>
                    <option value="voiture" <?php echo (isset($_SESSION['filtres_participants']['retour_transport']) && $_SESSION['filtres_participants']['retour_transport'] == 'voiture') ? 'selected' : ''; ?>>Voiture personnelle</option>
                    <option value="train" <?php echo (isset($_SESSION['filtres_participants']['retour_transport']) && $_SESSION['filtres_participants']['retour_transport'] == 'train') ? 'selected' : ''; ?>>Train</option>
                    <option value="bus" <?php echo (isset($_SESSION['filtres_participants']['retour_transport']) && $_SESSION['filtres_participants']['retour_transport'] == 'bus') ? 'selected' : ''; ?>>Bus organisé par Fondacio</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <!-- FILTRE PREPA -->
            <label class="col-form-label col-sm-1" for="prepa">Prépa ?</label>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="prepa" id="prepaO" value="1" <?php echo (isset($_SESSION['filtres_participants']['prepa']) && $_SESSION['filtres_participants']['prepa'] == 1) ? 'checked' : ''; ?>> Oui
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="prepa" id="prepaN" value="0" <?php echo (isset($_SESSION['filtres_participants']['prepa']) && $_SESSION['filtres_participants']['prepa'] == 0) ? 'checked' : ''; ?>> Non
                    </label>
                </div>
            </div>
            <!-- FILTRE ANCIEN -->
            <label class="col-form-label col-sm-1" for="ancien">Ancien ?</label>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="ancien" id="ancienO" value="1" <?php echo (isset($_SESSION['filtres_participants']['ancien']) && $_SESSION['filtres_participants']['ancien'] == 1) ? 'checked' : ''; ?>> Oui
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="ancien" id="ancienN" value="0" <?php echo (isset($_SESSION['filtres_participants']['ancien']) && $_SESSION['filtres_participants']['ancien'] == 0) ? 'checked' : ''; ?>> Non
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-1">
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </div>
            <div class="col-sm-6">
                <button type="button" class="btn btn-secondary" onclick="location.href = 'participants.php?reset_filtres';">Reset filtres</button>
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
                <th>Âge</th>
                <th>Civilité</th>
                <th>Ancien</th>
                <th>Prépa</th>
                <th>Service</th>
                <th>PG</th>
                <th>Chambre</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($donnees as $data) {
                    $age = age($data['date_naissance']);
                    echo '<tr>
                            <td><a href="participants.php?action=edit&id='.$data['id'].'&type='.$data['type'].'">'.$data['nom'].'</a></td>
                            <td>'.$data['prenom'].'</td>
                            <td>'.ucfirst($data['type']).'</td>
                            <td>'.$data['tel_portable'].'</td>
                            <td>'.$age.'</td>
                            <td>'.$data['civilite'].'</td>
                            <td>'.ucfirst($data['ancien']).'</td>
                            <td>'.ucfirst($data['prepa']).'</td>
                            <td>'.ucfirst($data['service']).'</td>
                            <td>'.$data['pg_num'].'</td>
                            <td>'.$data['chambre_num'].'</td>
                          </tr>';
                }
            ?>
        </tbody>
    </table>

<?php

}

require_once 'include/foot.php';

?>