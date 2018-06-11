<?php

require_once 'include/init.php';

////////// AJOUT / EDITION / SUPPRESSION D'UN PARTICIPANT //////////

if (!empty($_GET['action'])) {
    switch ($_GET['action']) {
        case 'del':
            delete_participant($_GET['id_participant']);
            break;

        case 'edit':
            $donnees = get_participant($_GET['id_participant']);
            $donnees['activite_mardi_creative'] = get_historique($_GET['id_participant'], 'mardi', 'creative');
            $donnees['activite_mardi_sportive'] = get_historique($_GET['id_participant'], 'mardi', 'sportive');
            $donnees['activite_mercredi_creative'] = get_historique($_GET['id_participant'], 'mercredi', 'creative');
            $donnees['activite_mercredi_sportive'] = get_historique($_GET['id_participant'], 'mercredi', 'sportive');
            $donnees['activite_jeudi_creative'] = get_historique($_GET['id_participant'], 'jeudi', 'creative');
            $donnees['activite_jeudi_sportive'] = get_historique($_GET['id_participant'], 'jeudi', 'sportive');
            $donnees['activite_vendredi_creative'] = get_historique($_GET['id_participant'], 'vendredi', 'creative');
            $donnees['activite_vendredi_sportive'] = get_historique($_GET['id_participant'], 'vendredi', 'sportive');
            $titre = 'Fiche de '.$donnees['prenom'].' '.$donnees['nom'];
            break;

        case 'add':
            $donnees = array('id_participant'    => '',
                              'date_saisie'      => '',
                              'type'             => '',
                              'camp'             => 0,
                              'ancien'           => '',
                              'prepa'            => '',
                              'service'          => '',
                              'diplomes'         => '',
                              'civilite'         => '',
                              'nom'              => '',
                              'prenom'           => '',
                              'adresse'          => '',
                              'cp'               => '',
                              'ville'            => '',
                              'pays'             => '',
                              'tel_portable'     => '',
                              'mail'             => '',
                              'date_naissance'   => '',
                              'etudes'           => '',
                              'taille'           => 0,
                              'poids'            => 0,
                              'tel_fixe'         => '',
                              'parents_nom'      => '',
                              'parents_prenom'   => '',
                              'pere_portable'    => '',
                              'mere_portable'    => '',
                              'parents_mail'     => '',
                              'parents_adresse'  => '',
                              'aller_transport'  => '',
                              'aller_date'       => '',
                              'aller_heure'      => '',
                              'aller_ville'      => '',
                              'retour_transport' => '',
                              'retour_date'      => '',
                              'retour_heure'     => '',
                              'retour_ville'     => '',
                              'chambre_num'      => '',
                              'chambre_resp'     => '',
                              'pg_num'           => 0,
                              'pg_resp'          => '',
                              'inscrit_mardi'    => '',
                              'inscrit_mercredi' => '',
                              'inscrit_jeudi'    => '',
                              'inscrit_vendredi' => '',
                              'manquant'         => '');
            $titre = 'Ajout d\'un participant';
            break;

    }
    if (!empty($_POST) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')) {
        update_participant($_GET['action'], $_POST, $_GET['id_participant']);
    }

    $title = 'Participants';
    require_once 'include/head.php';

?>
    <h3><?php echo $titre; ?></h3>
    <a class="btn btn-default" href="participants.php" role="button">Retour</a>
    <a class="btn btn-default" href="participants.php?action=del&id_participant=<?php echo $_GET['id_participant']; ?>" role="button">Suprimer</a>
    <br><br>

    <form class="form-horizontal" action="" method="POST">
        <div class="form-group">
            <label for="date_inscription" class="col-md-2 control-label">Date d'inscription</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="date_inscription" value="<?php echo $donnees['date_saisie']; ?>" disabled>
            </div>
        </div>
        <div class="form-group">
            <label for="camp" class="col-md-2 control-label">Camp</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="camp" value="<?php echo $donnees['camp']; ?>" <?php echo ($_GET['action'] == 'edit') ? 'disabled' : ''; ?>>
            </div>
        </div>
        <div class="form-group">
            <label for="type" class="col-md-2 control-label">Type</label>
            <div class="col-md-3">
                <label class="radio-inline">
                    <input type="radio" name="type" value="jeune" <?php echo (!empty($donnees['type']) && $donnees['type'] == 'jeune') ? 'checked' : ''; ?>> Jeune
                </label>
                <label class="radio-inline">
                    <input type="radio" name="type" value="adulte" <?php echo (!empty($donnees['type']) && $donnees['type'] == 'adulte') ? 'checked' : ''; ?>> Adulte
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="ancien" class="col-md-2 control-label">Ancien</label>
            <div class="col-md-3">
                <label class="radio-inline">
                    <input type="radio" name="ancien" value="oui" <?php echo (!empty($donnees['ancien']) && $donnees['ancien'] == 'oui') ? 'checked' : ''; ?>> Oui
                </label>
                <label class="radio-inline">
                    <input type="radio" name="ancien" value="non" <?php echo (!empty($donnees['ancien']) && $donnees['ancien'] == 'non') ? 'checked' : ''; ?>> Non
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="prepa" class="col-md-2 control-label">Prépa</label>
            <div class="col-md-3">
                <label class="radio-inline">
                    <input type="radio" name="prepa" value="oui" <?php echo (!empty($donnees['prepa']) && $donnees['prepa'] == 'oui') ? 'checked' : ''; ?>> Oui
                </label>
                <label class="radio-inline">
                    <input type="radio" name="prepa" value="non" <?php echo (!empty($donnees['prepa']) && $donnees['prepa'] == 'non') ? 'checked' : ''; ?>> Non
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="service" class="col-md-2 control-label">Service</label>
            <div class="col-md-3">
                <select class="form-control" name="service">
                    <option value="" selected></option>
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
        <div class="form-group">
            <label for="diplomes" class="col-md-2 control-label">Diplômes</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="diplomes" value="<?php echo $donnees['diplomes']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="civilite" class="col-md-2 control-label">Civilité</label>
            <div class="col-md-3">
                <label class="radio-inline">
                    <input type="radio" name="civilite" value="H" <?php echo (!empty($donnees['civilite']) && $donnees['civilite'] == 'H') ? 'checked' : ''; ?>> Homme
                </label>
                <label class="radio-inline">
                    <input type="radio" name="civilite" value="F" <?php echo (!empty($donnees['civilite']) && $donnees['civilite'] == 'F') ? 'checked' : ''; ?>> Femme
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="nom" class="col-md-2 control-label">Nom</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="nom" value="<?php echo $donnees['nom']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="prenom" class="col-md-2 control-label">Prénom</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="prenom" value="<?php echo $donnees['prenom']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="adresse" class="col-md-2 control-label">Adresse</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="adresse" value="<?php echo $donnees['adresse']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="cp" class="col-md-2 control-label">Code postal</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="cp" value="<?php echo $donnees['cp']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="ville" class="col-md-2 control-label">Ville</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="ville" value="<?php echo $donnees['ville']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="pays" class="col-md-2 control-label">Pays</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="pays" value="<?php echo $donnees['pays']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="tel_portable" class="col-md-2 control-label">Portable</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="tel_portable" value="<?php echo $donnees['tel_portable']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="mail" class="col-md-2 control-label">Mail</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="mail" value="<?php echo $donnees['mail']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="date_naissance" class="col-md-2 control-label">Date de naissance (aaaa-mm-jj)</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="date_naissance" value="<?php echo $donnees['date_naissance']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="etudes" class="col-md-2 control-label">Etudes</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="etudes" value="<?php echo $donnees['etudes']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="taille" class="col-md-2 control-label">Taille</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="taille" value="<?php echo $donnees['taille']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="poids" class="col-md-2 control-label">Poids</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="poids" value="<?php echo $donnees['poids']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="tel_fixe" class="col-md-2 control-label">Téléphone fixe</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="tel_fixe" value="<?php echo $donnees['tel_fixe']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="parents_nom" class="col-md-2 control-label">Nom parents</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="parents_nom" value="<?php echo $donnees['parents_nom']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="parents_prenom" class="col-md-2 control-label">Prénom parents</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="parents_prenom" value="<?php echo $donnees['parents_prenom']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="pere_portable" class="col-md-2 control-label">Portable père</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="pere_portable" value="<?php echo $donnees['pere_portable']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="mere_portable" class="col-md-2 control-label">Portable mère</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="mere_portable" value="<?php echo $donnees['mere_portable']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="parents_mail" class="col-md-2 control-label">Mail parents</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="parents_mail" value="<?php echo $donnees['parents_mail']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="parents_adresse" class="col-md-2 control-label">Adresse parents</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="parents_adresse" value="<?php echo $donnees['parents_adresse']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="aller_transport" class="col-md-2 control-label">Transport aller</label>
            <div class="col-md-3">
                <select class="form-control" name="aller_transport">
                    <option value="bus" <?php echo (!empty($donnees['aller_transport']) && $donnees['aller_transport'] == 'bus') ? 'selected' : ''; ?>>Bus organisé par Fondacio</option>
                    <option value="train" <?php echo (!empty($donnees['aller_transport']) && $donnees['aller_transport'] == 'train') ? 'selected' : ''; ?>>Train</option>
                    <option value="voiture" <?php echo (!empty($donnees['aller_transport']) && $donnees['aller_transport'] == 'voiture') ? 'selected' : ''; ?>>Voiture personnelle</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="aller_date" class="col-md-2 control-label">Date aller (aaaa-mm-jj)</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="aller_date" value="<?php echo $donnees['aller_date']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="aller_heure" class="col-md-2 control-label">Heure aller</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="aller_heure" value="<?php echo $donnees['aller_heure']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="aller_ville" class="col-md-2 control-label">Ville aller</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="aller_ville" value="<?php echo $donnees['aller_ville']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="retour_transport" class="col-md-2 control-label">Transport retour</label>
            <div class="col-md-3">
                <select class="form-control" name="retour_transport">
                    <option value="bus" <?php echo (!empty($donnees['retour_transport']) && $donnees['retour_transport'] == 'bus') ? 'selected' : ''; ?>>Bus organisé par Fondacio</option>
                    <option value="train" <?php echo (!empty($donnees['retour_transport']) && $donnees['retour_transport'] == 'train') ? 'selected' : ''; ?>>Train</option>
                    <option value="voiture" <?php echo (!empty($donnees['retour_transport']) && $donnees['retour_transport'] == 'voiture') ? 'selected' : ''; ?>>Voiture personnelle</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="retour_date" class="col-md-2 control-label">Date retour (aaaa-mm-jj)</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="retour_date" value="<?php echo $donnees['retour_date']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="retour_heure" class="col-md-2 control-label">Heure retour</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="retour_heure" value="<?php echo $donnees['retour_heure']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="retour_ville" class="col-md-2 control-label">Ville retour</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="retour_ville" value="<?php echo $donnees['retour_ville']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="chambre_num" class="col-md-2 control-label">Numéro chambre</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="chambre_num" value="<?php echo $donnees['chambre_num']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="chambre_resp" class="col-md-2 control-label">Responsable chambre</label>
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
            <label for="pg_num" class="col-md-2 control-label">Numéro PG</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="pg_num" value="<?php echo $donnees['pg_num']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="pg_resp" class="col-md-2 control-label">Responsable PG</label>
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
            <label for="activite_mardi_creative" class="col-md-2 control-label">Acti créative mardi</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="activite_mardi_creative" id="activite_mardi_creative" value="<?php echo $donnees['activite_mardi_creative']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="activite_mardi_sportive" class="col-md-2 control-label">Acti sportive mardi</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="activite_mardi_sportive" id="activite_mardi_sportive" value="<?php echo $donnees['activite_mardi_sportive']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="activite_mercredi_creative" class="col-md-2 control-label">Acti créative mercredi</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="activite_mercredi_creative" id="activite_mercredi_creative" value="<?php echo $donnees['activite_mercredi_creative']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="activite_mercredi_sportive" class="col-md-2 control-label">Acti sportive mercredi</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="activite_mercredi_sportive" id="activite_mercredi_sportive" value="<?php echo $donnees['activite_mercredi_sportive']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="activite_jeudi_creative" class="col-md-2 control-label">Acti créative jeudi</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="activite_jeudi_creative" id="activite_jeudi_creative" value="<?php echo $donnees['activite_jeudi_creative']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="activite_jeudi_sportive" class="col-md-2 control-label">Acti sportive jeudi</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="activite_jeudi_sportive" id="activite_jeudi_sportive" value="<?php echo $donnees['activite_jeudi_sportive']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="activite_vendredi_creative" class="col-md-2 control-label">Acti creative vendredi</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="activite_vendredi_creative" id="activite_vendredi_creative" value="<?php echo $donnees['activite_vendredi_creative']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="activite_vendredi_sportive" class="col-md-2 control-label">Acti sportive vendredi</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="activite_vendredi_sportive" id="activite_vendredi_sportive" value="<?php echo $donnees['activite_vendredi_sportive']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="manquant" class="col-md-2 control-label">Manquant</label>
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

    <script>
    $(function() {
        $( "#activite_mardi_creative" ).autocomplete({
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
                foreach ($donnees as $id_participant => $data) {
                    $age = age($data['date_naissance']);
                    echo '<tr>
                            <td><a href="participants.php?action=edit&id_participant='.$id_participant.'">'.$data['nom'].'</a></td>
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