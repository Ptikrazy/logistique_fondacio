<?php

/// NEW ///

function print_rh($data) {

    echo "<pre>\n";
    print_r($data);
    echo "</pre>\n";

}

function redirect($url) {

    if(!headers_sent()) {
        header('Location: '.$url);
        exit();
    }

    else {
        echo '<script type="text/javascript">window.location.href=\''.$url.'\'</script>';
        exit();
    }
    die();
}

function convert_date($date, $from, $to) {

    if (empty($date)) {
        $date = '';
    }
    else {
        $date = explode($from, $date);
        $date = $date[2].$to.$date[1].'/'.$date[0];
    }

    return($date);

}

function age($date) {

    $d1 = new DateTime($date);
    $d2 = new DateTime('2018-07-07');
    $diff = $d2->diff($d1);

    return $diff->y;

}

function check_password($login, $password) {

    global $bdd;

    $req = 'SELECT password FROM utilisateurs WHERE login = "'.$login.'"';
    $res = $bdd->query($req);
    $data = $res->fetchColumn();
    $res->closeCursor();

    return password_verify($password, $data);

}

function get_infos_login($login) {

    global $bdd;

    $req = 'SELECT id_utilisateur, role, login, camp FROM utilisateurs WHERE login = "'.$login.'"';
    $res = $bdd->query($req);
    $data = $res->fetch();
    $res->closeCursor();

    return $data;

}

function get_camps() {

    global $bdd;

    $req = 'SELECT * FROM camps ORDER BY numero';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[$d['id_camp']] = $d;
    }
    $res->closeCursor();

    return $data;

}

function get_camps_inscrptions() {

    global $bdd;

    $req = 'SELECT * FROM camps WHERE numero != 1 ORDER BY numero';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[$d['id_camp']] = $d;
    }
    $res->closeCursor();

    return $data;

}

function get_camp($camp) {

    global $bdd;

    $req = 'SELECT * FROM camps WHERE numero = '.$camp;
    $res = $bdd->query($req);
    $data = $res->fetch();
    $res->closeCursor();

    return $data;

}

function get_remplissage_camps() {

    global $bdd;

    $req = 'SELECT camp, COUNT(id_jeune) AS inscrits FROM jeunes WHERE desistement IS NULL GROUP BY camp ORDER BY camp';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[$d['camp']] = $d['inscrits'];
    }
    $res->closeCursor();

    return $data;

}

function get_totaux_transport($camp, $aller_retour, $transport) {

    global $bdd;

    $req = 'SELECT COUNT(id_jeune) AS total FROM jeunes WHERE desistement IS NULL AND camp = '.$camp.' AND '.$aller_retour.'_transport = "'.$transport.'"';
    $res = $bdd->query($req);
    $data = $res->fetchColumn();
    $res->closeCursor();

    return $data;

}

function get_villes_bus($aller_retour, $camp) {

    global $bdd;

    $req = 'SELECT villes_bus_'.$aller_retour.' AS villes FROM camps WHERE numero = '.$camp;
    $res = $bdd->query($req);
    $data = $res->fetch();
    $res->closeCursor();

    $data = explode(';', $data['villes']);

    return $data;

}

function get_inscrits_jeune($camp, $filtres = array(), $tri = '') {

    global $bdd;

    $where = FALSE;

    $req = 'SELECT id_jeune, nom, prenom, parents_mail, paiement_declare, da_a_relancer, da_complet, rgt_recu, rgt_montant, desistement FROM jeunes ';
    if (!empty($filtres)) {
        $req .= 'WHERE ';
        $where = TRUE;
        end($filtres);
        $last = key($filtres);
        reset($filtres);
        foreach ($filtres as $champ => $value) {
            if ($champ == 'rgt_recu') {
                if ($value) {
                    $req .= $champ.' IS NOT NULL';
                }
                else {
                    $req .= $champ.' IS NULL';
                }
            }
            elseif ($champ == 'da_a_relancer') {
                if ($value) {
                    $req .= $champ.' IS NOT NULL';
                }
                else {
                    $req .= $champ.' IS NULL';
                }
            }
            elseif ($champ == 'nom') {
                $req .= $champ.' LIKE "%'.$value.'%"';
            }
            else {
                $req .= $champ.' = "'.$value.'"';
            }
            if ($champ != $last) {
                $req .= ' AND ';
            }
        }
    }
    if ($_SESSION['profil']['role'] != 'admin') {
        if ($where) {
            $req .= ' AND camp = '.$camp.' ';
        }
        else {
            $req .= ' WHERE camp = '.$camp.' ';
        }
    }
    if (!empty($tri)) {
        $req .= ' ORDER BY '.$tri;
    }
    else {
        $req .= ' ORDER BY id_jeune';
    }
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[$d['id_jeune']] = $d;
    }
    $res->closeCursor();

    return $data;

}

function get_inscrits_adultes($camp, $filtres = '', $tri = '') {

    global $bdd;

    $req = 'SELECT id_adulte, nom, prenom, camp, mail, tel_portable, paiement_declare, da_complet, rgt_recu, rgt_montant, desistement FROM adultes ';
    if (!empty($filtres)) {
        $req .= 'WHERE ';
        $where = TRUE;
        end($filtres);
        $last = key($filtres);
        reset($filtres);
        foreach ($filtres as $champ => $value) {
            if ($champ == 'nom') {
                $req .= $champ.' LIKE "%'.$value.'%"';
            }
            if ($champ == 'diplome') {
                if (in_array($value, array('diplome_bafa', 'diplome_bafd', 'diplome_secouriste'))) {
                    $req .= $value.' = 1';
                }
                if (in_array($value, array('diplome_ps', 'diplome_autre'))) {
                    $req .= $value.' != ""';
                }
            }
            else {
                $req .= $champ.' = "'.$value.'"';
            }
            if ($champ != $last) {
                $req .= ' AND ';
            }
        }
    }
    if ($_SESSION['profil']['role'] != 'admin') {
        if ($where) {
            $req .= ' AND camp = '.$camp.' ';
        }
        else {
            $req .= ' WHERE camp = '.$camp.' ';
        }
    }
    if (!empty($tri)) {
        $req .= ' ORDER BY '.$tri;
    }
    else {
        $req .= ' ORDER BY id_adulte';
    }
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[$d['id_adulte']] = $d;
    }
    $res->closeCursor();

    return $data;

}

function get_jeune($id) {

    global $bdd;

    $req = 'SELECT * FROM jeunes WHERE id_jeune = '.$id;
    $res = $bdd->query($req);
    $data = $res->fetch();
    $res->closeCursor();

    return $data;

}

function get_adulte($id) {

    global $bdd;

    $req = 'SELECT * FROM adultes WHERE id_adulte = '.$id;
    $res = $bdd->query($req);
    $data = $res->fetch();
    $res->closeCursor();

    return $data;

}



function enregistrer_inscription_jeune($data) {

    global $bdd;

    // Enregistrement en base

    $infos_camp = get_camp($data['camp']);

    $req  = 'INSERT INTO jeunes SET ';
    $req .= 'camp = '.$infos_camp['numero'].', ';
    $req .= 'ancien = '.$data['ancien'].', ';
    if (isset($data['prepa'])) {
        $req .= 'prepa = '.$data['prepa'].', ';
    }
    else {
        $req .= 'prepa = 0, ';
    }
    $req .= 'civilite = "'.$data['civilite'].'", ';
    $req .= 'nom = "'.strtoupper($data['jeune_nom']).'", ';
    $req .= 'prenom = "'.$data['jeune_prenom'].'", ';
    $req .= 'adresse = "'.$data['jeune_adresse'].'", ';
    $req .= 'cp = "'.$data['code_postal'].'", ';
    $req .= 'ville = "'.$data['ville'].'", ';
    $req .= 'pays = "'.$data['pays'].'", ';
    $req .= 'tel_portable = "'.$data['jeune_tel_portable'].'", ';
    $req .= 'tel_fixe = "'.$data['tel_fixe'].'", ';
    $req .= 'mail = "'.$data['jeune_mail'].'", ';
    $req .= 'date_naissance = "'.$data['date_naissance'].'", ';
    if (isset($data['etudes'])) {
        if ($data['etudes'] == 'Autre') {
            $req .= 'etudes = "'.$data['etudes_autre'].'", ';
        }
        else {
            $req .= 'etudes = "'.$data['etudes'].'", ';
        }
    }
    $req .= 'taille = '.$data['taille'].', ';
    $req .= 'poids = '.$data['poids'].', ';
    $req .= 'parents_nom = "'.$data['parents_nom'].'", ';
    $req .= 'parents_prenom = "'.$data['parents_prenom'].'", ';
    $req .= 'parents_adresse = "'.$data['parents_adresse'].'", ';
    $req .= 'mere_portable = "'.$data['mere_tel_portable'].'", ';
    $req .= 'pere_portable = "'.$data['pere_tel_portable'].'", ';
    $req .= 'parents_mail = "'.$data['parents_mail'].'", ';
    $req .= 'observations = "'.$data['observations'].'", ';
    $req .= 'paiement_declare = '.$data['paiement_declare'].', ';
    if (isset($data['attestation_inscription'])) {
        $req .= 'attestation_inscription = '.$data['attestation_inscription'].', ';
    }
    if (isset($data['attestation_presence'])) {
        $req .= 'attestation_presence = '.$data['attestation_presence'].', ';
    }
    $req .= 'ce_nom = "'.$data['ce_nom'].'", ';
    $req .= 'ce_mail = "'.$data['ce_mail'].'", ';
    $req .= 'ce_adresse = "'.$data['ce_adresse'].'", ';
    if (!empty($data['communication_autre'])) {
        $req .= 'communication = "'.$data['communication'].' : '.$data['communication_autre'].'", ';
    }
    else {
        $req .= 'communication = "'.$data['communication'].'", ';
    }
    $req .= 'aller_transport = "'.$data['aller_transport'].'", ';
    if (isset($data['prepa']) &&  $data['prepa']) {
        $req .= 'aller_date = "'.$infos_camp['date_prepa'].'", ';
    }
    else {
        $req .= 'aller_date = "'.$infos_camp['date_debut'].'", ';
    }
    if ($data['aller_transport'] == 'train') {
        $req .= 'aller_heure = "'.$data['aller_train'].'", ';
    }
    else {
        $req .= 'aller_heure = "13h", ';
    }
    $req .= 'aller_ville = "'.$data['aller_bus'].'", ';
    $req .= 'retour_transport = "'.$data['retour_transport'].'", ';
    $req .= 'retour_date = "'.$infos_camp['date_fin'].'", ';
    if ($data['retour_transport'] == 'bus') {
        $req .= 'retour_heure = "2h", ';
    }
    else {
        $req .= 'retour_heure = "12h", ';
    }
    $req .= 'retour_ville = "'.$data['retour_bus'].'", ';
    $req .= 'da_a_relancer = "'.date('Y-m-d', strtotime('+2 months')).'"';

    $res = $bdd->query($req);
    $res->closeCursor();

    // Envoi mail
    send_mail_confirmation_jeune($data, $infos_camp);

}

function send_mail_confirmation_jeune($data, $infos_camp) {

    $str = 'Bonjour,<br><br>

Votre demande d\'inscription pour votre enfant '.$data['jeune_prenom'].' au camp Réussir Sa Vie (camp n°'.$infos_camp['numero'].') qui aura lieu du '.convert_date($infos_camp['date_debut'], '-', '/').' au '.convert_date($infos_camp['date_fin'], '-', '/').' au Mourtis (31) a bien été enregistrée, et nous vous en remercions.

Pour confirmer son inscription, merci d\'envoyer le dossier administratif complet, accompagné de votre règlement (chèque à l\'ordre de Fondacio France) à :<br><br>';

    if ($infos_camp['numero'] == 3) {
        $str .= 'Christine Boulbès<br>
        Fondacio camp RSV n°3<br>
        Le Sénèque, Bât. B1<br>
        2 avenue Georges Brassens<br>
        13100 AIX-EN-PROVENCE<br><br>';
    }
    else {
        $str .= 'Fondacio camp RSV n°'.$infos_camp['numero'].'<br>
        2 rue de l\'Esvière<br>
        49100 ANGERS<br><br>';
    }

    $str .= 'Les éléments du dossier administratif sont téléchargeables <a target="_blank" href="http://www.jeunes.fondacio.fr/camps-reussir-sa-vie/dossier-administratif/">en suivant ce lien</a>.<br>
Si vous souhaitez payer en ligne, <a target="_blank" href="http://www.fondacio.fr/fondacio/spip.php?page=produit&ref=CAMPS_RSV_ADOS&id_article=524">cliquez ici</a>.<br><br>';

    if (isset($data['prepa']) && $data['prepa']) {

        $str .= 'De plus, vous avez inscrit '.$data['jeune_prenom'].' à la prépa du camp. Merci de lui demander de remplir le formulaire de souhaits en <a href="http://www.jeunes.fondacio.fr/camps-reussir-sa-vie/souhaits-prepa/">cliquant ici</a>.<br><br>';

    }

    $str .= 'Pour toute question concernant le camp, merci de ne pas répondre à cette adresse, mais d\'envoyer votre demande à <a href="mailto:jeunes.camps@fondacio.fr">l\'adresse suivante</a>.<br><br>

Au plaisir d\'accueillir votre enfant cet été au Mourtis !<br>
L\'équipe de la Mission Jeunes<br><br>

PS : Vous trouverez ci-dessous les infos que vous venez de saisir.<br><br>';

    if ($data['civilite'] == 'H') {
        $str .= 'Civilité: M.<br>';
    }
    else {
        $str .= 'Civilité: Mme<br>';
    }
    $str .= 'Nom du jeune: '.$data['jeune_nom'].'<br>
    Prénom du jeune: '.$data['jeune_prenom'].'<br>
    Adresse: '.$data['jeune_adresse'].'<br>
    Code postal: '.$data['code_postal'].'<br>
    Ville: '.$data['ville'].'<br>
    Pays: '.$data['pays'].'<br>
    Téléphone portable du jeune: '.$data['jeune_tel_portable'].'<br>
    Téléphone fixe: '.$data['tel_fixe'].'<br>
    Courriel du jeune: '.$data['jeune_mail'].'<br>
    Date de naissance: '.convert_date($data['date_naissance'], '-', '/').'<br>
    Etudes actuelles: '.$data['etudes'];
    if (isset($data['etudes_autres'])) {
        $str .= ' ('.$data['etudes_autres'].')';
    }
    $str .= '<br>Taille: '.$data['taille'].' cm<br>
    Poids: '.$data['poids'].' kg<br>
    Nom des parents: '.$data['parents_nom'].'<br>
    Prénom des parents: '.$data['parents_prenom'].'<br>
    Tel portable de la mère: '.$data['mere_tel_portable'].'<br>
    Tel portable du père: '.$data['pere_tel_portable'].'<br>
    Courriel des parents: '.$data['parents_mail'].'<br>
    Observations: '.$data['observations'].'<br>';
    if ($data['ancien']) {
        $ancien = 'Oui';
    }
    else {
        $ancien = 'Non';
    }
    $str .= 'J\'ai déjà fait un camp "Réussir Sa Vie": '.$ancien.'<br>';
    if (isset($data['prepa']) && $data['prepa']) {
        $str .= 'Je suis inscrit à la prépa du camp: Oui<br>';
    }
    $str .= 'J\'arriverai au Mourtis en: '.$data['aller_transport'].' (';
    if ($data['aller_transport'] == 'bus') {
        $str .= $data['aller_bus'];
    }
    else if ($data['aller_transport'] == 'train') {
        $str .= 'navette de '.$data['aller_heure'];
    }
    $str .= ')<br>
    Je repartirai du Mourtis en: '.$data['retour_transport'].' (';
    if ($data['retour_transport'] == 'bus') {
        $str .= $data['retour_bus'];
    }
    $str .= ')<br>
    Je choisis de payer le montant suivant : '.$data['paiement_declare'].' €<br>
    J\'ai connu ce camp par: '.$data['communication'];
    if (isset($data['communication_autre'])) {
        $str .= ' ('.$data['etudes_autres'].')';
    }
    if (isset($data['attestation_inscription'])) {
        $str .= '<br>Je souhaite recevoir pour mon CE une attestation d\'inscription, une fois que j\'aurais envoyé le dossier d\'inscription papier complet<br>';
    }
    if (isset($data['attestation_presence'])) {
        $str .= '<br>Je souhaite recevoir pour mon CE une attestation de présence et de paiement, après le camp<br>';
    }
    $str .= '<br>
    Conditions de participation: Je m’engage à envoyer le dossier d’inscription COMPLET avec le règlement dans un délai de 15 jours à compter de la présente pré-inscription sur internet. Fondacio se réserve le droit d’annuler l’inscription du jeune si ce délai n’est pas respecté.<br>
    Conditions d\'annulation: J’accepte les conditions d’annulation suivantes : pour toute annulation intervenant plus d’un mois avant le départ, les sommes payées seront intégralement remboursées par chèque bancaire ; pour toute annulation intervenant entre 7 jours et 30 jours avant le départ, 50% des sommes versées (transport compris) seront remboursées (100% si raison médicale, sur justificatif) ; pour toute annulation intervenant moins de 7 jours avant le départ (sauf raison médicale avec justificatif), l’intégralité des sommes versées est conservée par Fondacio.';

    $to       = $data['parents_mail'].',fondacio.camp'.$infos_camp['numero'].'@gmail.com';
    $subject  = 'Votre demande d\'inscription au camp "Réussir Sa Vie" n°'.$infos_camp['numero'];
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
    $headers .= 'From: Fondacio Jeunes <jeunes.camps@fondacio.fr>'."\r\n".
                'Reply-To: fondacio.camp'.$infos_camp['numero'].'@gmail.com';

    mail($to, $subject, $str, $headers);

}

function maj_administratif_jeune($id, $data) {

    global $bdd;

    $req  = 'UPDATE jeunes SET ';
    end($data);
    $last = key($data);
    reset($data);
    foreach ($data as $champ => $value) {
        if ($champ == 'aller_bus') {
            $req .= 'aller_ville = "'.$value.'"';
        }
        if ($champ == 'aller_train') {
            $req .= 'aller_heure = "'.$value.'"';
        }
        else {
            if ($value == 'NULL') {
                $req .= $champ.' = NULL';
            }
            else {
                $req .= $champ.' = "'.$value.'"';
            }
        }

        if ($champ != $last) {
            $req .= ', ';
        }
    }
    $req .= ' WHERE id_jeune = '.$id;
    $res = $bdd->query($req);
    $res->closeCursor();

}

function maj_administratif_adulte($id, $data) {

    global $bdd;

    $req  = 'UPDATE adultes SET ';
    end($data);
    $last = key($data);
    reset($data);
    foreach ($data as $champ => $value) {
        if ($champ == 'aller_bus') {
            $req .= 'aller_ville = "'.$value.'"';
        }
        if ($champ == 'aller_train') {
            $req .= 'aller_heure = "'.$value.'"';
        }
        else {
            if ($value == 'NULL') {
                $req .= $champ.' = NULL';
            }
            else {
                $req .= $champ.' = "'.$value.'"';
            }
        }

        if ($champ != $last) {
            $req .= ', ';
        }
    }
    $req .= ' WHERE id_adulte = '.$id;
    $res = $bdd->query($req);
    $res->closeCursor();

}

function enregistrer_inscription_adulte($data) {

    global $bdd;

    // Enregistrement en base

    $infos_camp = get_camp($data['camp']);


    $req  = 'INSERT INTO adultes SET ';
    $req .= 'camp = '.$infos_camp['numero'].', ';
    $req .= 'civilite = "'.$data['civilite'].'", ';
    $req .= 'nom = "'.strtoupper($data['nom']).'", ';
    $req .= 'nom_usage = "'.strtoupper($data['nom_usage']).'", ';
    $req .= 'prenom = "'.$data['prenom'].'", ';
    $req .= 'adresse = "'.$data['adresse'].'", ';
    $req .= 'cp = "'.$data['cp'].'", ';
    $req .= 'ville = "'.$data['ville'].'", ';
    $req .= 'pays = "'.$data['pays'].'", ';
    $req .= 'tel_portable = "'.$data['tel_portable'].'", ';
    $req .= 'tel_fixe = "'.$data['tel_fixe'].'", ';
    $req .= 'mail = "'.$data['mail'].'", ';
    $req .= 'date_naissance = "'.$data['date_naissance'].'", ';
    $req .= 'lieu_naissance = "'.$data['lieu_naissance'].'", ';
    $req .= 'profession = "'.$data['profession'].'", ';
    $req .= 'allergies = "'.$data['allergies'].'", ';
    $req .= 'permis = '.$data['permis'].', ';
    if (isset($data['ok_conduire'])) {
        $req .= 'ok_conduire = '.$data['ok_conduire'].', ';
    }
    if (isset($data['diplome_bafd'])) {
        $req .= 'diplome_bafd = '.$data['diplome_bafd'].', ';
    }
    if (isset($data['diplome_bafa'])) {
        $req .= 'diplome_bafa = '.$data['diplome_bafa'].', ';
    }
    if (isset($data['diplome_secouriste'])) {
        $req .= 'diplome_secouriste = '.$data['diplome_secouriste'].', ';
    }
    if (isset($data['diplome_ps'])) {
        $req .= 'diplome_ps = "'.$data['diplome_ps'].'", ';
    }
    if (isset($data['diplome_autre'])) {
        $req .= 'diplome_autre = "'.$data['diplome_autre'].'", ';
    }
    if (isset($data['stagiaire'])) {
        $req .= 'stagiaire = "'.$data['stagiaire'].'", ';
    }
    $req .= 'appele_par = "'.$data['appele_par'].'", ';
    $req .= 'we_formation = '.$data['we_formation'].', ';
    $req .= 'we_formation_refus = "'.$data['we_formation_refus'].'", ';
    $req .= 'urgence_nom = "'.$data['urgence_nom'].'", ';
    $req .= 'urgence_prenom = "'.$data['urgence_prenom'].'", ';
    $req .= 'urgence_portable = "'.$data['urgence_portable'].'", ';
    $req .= 'urgence_lien = "'.$data['urgence_lien'].'", ';
    $req .= 'paiement_declare = '.$data['paiement_declare'].', ';
    $req .= 'aller_transport = "'.$data['aller_transport'].'", ';
    $req .= 'aller_date = "'.$infos_camp['date_prepa'].'", ';
    if ($data['aller_transport'] == 'train') {
        $req .= 'aller_heure = "'.$data['aller_train'].'", ';
    }
    else {
        $req .= 'aller_heure = "13h", ';
    }
    $req .= 'aller_ville = "'.$data['aller_bus'].'", ';
    $req .= 'retour_transport = "'.$data['retour_transport'].'", ';
    $req .= 'retour_date = "'.$infos_camp['date_fin'].'", ';
    if ($data['retour_transport'] == 'bus') {
        $req .= 'retour_heure = "2h", ';
    }
    else {
        $req .= 'retour_heure = "12h", ';
    }
    $req .= 'retour_ville = "'.$data['retour_bus'].'", ';
    if (isset($data['act_arts_plastiques'])) {
        $req .= 'act_arts_plastiques = '.$data['act_arts_plastiques'].', ';
    }
    $req .= 'act_arts_plastiques_p = "'.$data['act_arts_plastiques_p'].'", ';
    if (isset($data['act_bd'])) {
        $req .= 'act_bd = '.$data['act_bd'].', ';
    }
    if (isset($data['act_orient_pro'])) {
        $req .= 'act_orient_pro = '.$data['act_orient_pro'].', ';
    }
    if (isset($data['act_cinema'])) {
        $req .= 'act_cinema = '.$data['act_cinema'].', ';
    }
    if (isset($data['act_exp_corp'])) {
        $req .= 'act_exp_corp = '.$data['act_exp_corp'].', ';
    }
    $req .= 'act_exp_corp_p = "'.$data['act_exp_corp_p'].'", ';
    if (isset($data['act_jeux_piste'])) {
        $req .= 'act_jeux_piste = '.$data['act_jeux_piste'].', ';
    }
    if (isset($data['act_illustrations'])) {
        $req .= 'act_illustrations = '.$data['act_illustrations'].', ';
    }
    $req .= 'act_illustrations_p = "'.$data['act_illustrations_p'].'", ';
    if (isset($data['act_jeux_mem'])) {
        $req .= 'act_jeux_mem = '.$data['act_jeux_mem'].', ';
    }
    if (isset($data['act_musiques'])) {
        $req .= 'act_musiques = '.$data['act_musiques'].', ';
    }
    $req .= 'act_musiques_p = "'.$data['act_musiques_p'].'", ';
    if (isset($data['act_ecritures'])) {
        $req .= 'act_ecritures = '.$data['act_ecritures'].', ';
    }
    $req .= 'act_ecritures_p = "'.$data['act_ecritures_p'].'", ';
    if (isset($data['act_danses'])) {
        $req .= 'act_danses = '.$data['act_danses'].', ';
    }
    $req .= 'act_danses_p = "'.$data['act_danses_p'].'", ';
    if (isset($data['act_arts_rue'])) {
        $req .= 'act_arts_rue = '.$data['act_arts_rue'].', ';
    }
    $req .= 'act_arts_rue_p = "'.$data['act_arts_rue_p'].'", ';
    if (isset($data['act_bijoux'])) {
        $req .= 'act_bijoux = '.$data['act_bijoux'].', ';
    }
    if (isset($data['act_sculpture'])) {
        $req .= 'act_sculpture = '.$data['act_sculpture'].', ';
    }
    if (isset($data['act_chants'])) {
        $req .= 'act_chants = '.$data['act_chants'].', ';
    }
    $req .= 'act_chants_p = "'.$data['act_chants_p'].'", ';
    if (isset($data['act_relaxation'])) {
        $req .= 'act_relaxation = '.$data['act_relaxation'].', ';
    }
    if (isset($data['act_sports'])) {
        $req .= 'act_sports = '.$data['act_sports'].', ';
    }
    $req .= 'act_sports_p = "'.$data['act_sports_p'].'", ';
    if (isset($data['act_imagination'])) {
        $req .= 'act_imagination = '.$data['act_imagination'].', ';
    }
    $req .= 'act_imagination_p = "'.$data['act_imagination_p'].'", ';
    if (isset($data['act_logique'])) {
        $req .= 'act_logique = '.$data['act_logique'].', ';
    }
    if (isset($data['act_theatres'])) {
        $req .= 'act_theatres = '.$data['act_theatres'].', ';
    }
    $req .= 'act_theatres_p = "'.$data['act_theatres_p'].'", ';
    if (isset($data['act_strategie'])) {
        $req .= 'act_strategie = '.$data['act_strategie'].', ';
    }
    if (isset($data['act_meditation'])) {
        $req .= 'act_meditation = '.$data['act_meditation'].', ';
    }
    if (isset($data['act_photo'])) {
        $req .= 'act_photo = '.$data['act_photo'].', ';
    }
    if (isset($data['act_arts_cirque'])) {
        $req .= 'act_arts_cirque = '.$data['act_arts_cirque'].', ';
    }
    $req .= 'act_arts_cirque_p = "'.$data['act_arts_cirque_p'].'", ';
    if (isset($data['act_arts_enigme'])) {
        $req .= 'act_arts_enigme = '.$data['act_arts_enigme'].', ';
    }
    $req .= 'act_autres = "'.$data['act_autres'].'", ';
    $req .= 'act_rafting = '.$data['act_rafting'].', ';
    $req .= 'act_canyo = '.$data['act_canyo'].', ';
    $req .= 'act_descente = '.$data['act_descente'].', ';
    $req .= 'act_mini_raid = '.$data['act_mini_raid'].', ';
    $req .= 'act_via_fe = '.$data['act_via_fe'].', ';
    $req .= 'act_grimp = '.$data['act_grimp'].', ';
    $req .= 'act_bike_park = '.$data['act_bike_park'].', ';
    $req .= 'act_speed_chall = '.$data['act_speed_chall'].', ';
    $req .= 'act_biathlon = '.$data['act_biathlon'].', ';
    $req .= 'act_piscine = '.$data['act_piscine'].', ';
    $req .= 'act_sports_co = '.$data['act_sports_co'];

    $res = $bdd->query($req);
    $res->closeCursor();

    // Envoi mail
    send_mail_confirmation_adulte($data, $infos_camp);

}

function send_mail_confirmation_adulte($data, $infos_camp) {

    $str = 'Bonjour '.$data['prenom'].',<br><br>

Ta demande d\'inscription à l\'un des camps Réussir sa Vie qui aura lieu au Mourtis (31) a bien été enregistrée, et nous t\'en remercions.<br><br>

Pour confirmer ton inscription, merci d\'envoyer le dossier administratif complet, accompagné de ton règlement (chèque à l\'ordre de Fondacio France) à :<br><br>

Fondacio camp RSV<br>
Inscription adulte<br>
23 rue de l’Ermitage<br>
78000 VERSAILLES<br><br>

Les éléments du dossier administratif sont téléchargeables sur la <a target="_blank" href="http://www.jeunes.fondacio.fr/camps-reussir-sa-vie/dossier-administratif-adultes/">page suivante</a>.<br>
Si vous souhaitez payer en ligne, <a target="_blank" href="http://bit.ly/1O6910a">cliquez ici</a>.<br><br>

Pour toute question concernant le camp, merci de ne pas répondre à cette adresse, mais d\'envoyer ta demande à : jeunes.camps@fondacio.fr<br><br>

A bientôt au Mourtis !<br>
La mission Jeunes de Fondacio<br><br>

PS : Tu trouveras ci-dessous les infos que tu viens de saisir.<br><br>';

    if ($data['civilite'] == 'H') {
        $str .= 'Civilité: M.<br>';
    }
    else {
        $str .= 'Civilité: Mme<br>';
    }
    $str .= 'Nom: '.$data['nom'].'<br>
    Nom d\'usage: '.$data['nom_usage'].'<br>
    Prénom: '.$data['prenom'].'<br>
    Adresse: '.$data['adresse'].'<br>
    Code postal: '.$data['postal'].'<br>
    Ville: '.$data['ville'].'<br>
    Pays: '.$data['pays'].'<br>
    Téléphone portable: '.$data['tel_portable'].'<br>
    Téléphone fixe: '.$data['tel_fixe'].'<br>
    Mail: '.$data['mail'].'<br>
    Date de naissance: '.convert_date($data['date_naissance'], '-', '/').'<br>
    Lieu de naissance: '.$data['lieu_naissance'].'<br>
    Profession: '.$data['profession'].'<br>
    Allergies/Intolérances: '.$data['allergies'].'<br>';
    if ($data['permis']) {
        $str .= 'J\'ai le permis B: Oui<br>';
    }
    else {
        $str .= 'J\'ai le permis B: Non<br>';
    }
    if ($data['ok_conduire']) {
        $str .= 'J\'ai au moins 23 ans, je possède le permis de conduire depuis plus de 3 ans et je me sens capable de conduire en montagne un des véhicules de Fondacio, notamment pour transporter des jeunes: Oui<br>';
    }
    else {
        $str .= 'J\'ai au moins 23 ans, je possède le permis de conduire depuis plus de 3 ans et je me sens capable de conduire en montagne un des véhicules de Fondacio, notamment pour transporter des jeunes: Non<br>';
    }
    if ($data['diplome_bafd']) {
        $str .= 'Je possède le BAFD: Oui<br>';
    }
    else {
        $str .= 'Je possède le BAFD: Non<br>';
    }
    if ($data['diplome_bafa']) {
        $str .= 'Je possède le BAFA: Oui<br>';
    }
    else {
        $str .= 'Je possède le BAFA: Non<br>';
    }
    if ($data['diplome_secouriste']) {
        $str .= 'Je possède le PSC1 ou PSCE1 ou secouriste: Oui<br>';
    }
    else {
        $str .= 'Je possède le PSC1 ou PSCE1 ou secouriste: Non<br>';
    }
    if ($data['diplome_ps']) {
        $str .= 'Je possède un diplôme de premiers secours: Oui<br>';
    }
    else {
        $str .= 'Je possède un diplôme de premiers secours: Non<br>';
    }
    if (!empty($data['diplome_autre'])) {
        $str .= 'Je possède un autre diplôme: '.$data['diplome_autre'].'<br>';
    }
    if (!empty($data['stagiaire'])) {
        $str .= 'Je suis stagiaire BAFA/BAFD: '.$data['stagiaire'].'<br>';
    }
    $str .= 'J\'ai été appelé par: '.$data['appele_par'].'
    Personne à contacter en cas d\'urgence: '.$data['urgence_nom'].'<br>
    Prénom: '.$data['urgence_prenom'].'<br>
    Portable: '.$data['urgence_portable'].'<br>
    Lien: '.$data['urgence_lien'].'<br>';
    if ($data['we_formation']) {
        $str .= 'Je serai présent au WE de formation<br>';
    }
    else {
        $str .= 'Je ne serai pas présent au WE de formation ('.$data['we_formation_refus'].')<br>';
    }
    $str .= 'J\'arriverai au Mourtis en: '.$data['aller_transport'].' (';
    if ($data['aller_transport'] == 'bus') {
        $str .= $data['aller_bus'];
    }
    else if ($data['aller_transport'] == 'train') {
        $str .= 'navette de '.$data['aller_heure'];
    }
    $str .= ')<br>
    Je repartirai du Mourtis en: '.$data['retour_transport'].' (';
    if ($data['retour_transport'] == 'bus') {
        $str .= $data['retour_bus'];
    }
    $str .= ')<br>
    Je choisis de payer le montant suivant : '.$data['paiement_declare'].' €<br>
    J\'ai indiqué me reconnaître dans les activités suivantes:<br><br>';
    if ($data['act_arts_plastiques']) {
        $str .= 'Arts plastiques ('.$data['act_arts_plastiques_p'].')<br>';
    }
    if ($data['act_bd']) {
        $str .= 'Bande dessinée<br>';
    }
    if ($data['act_orient_pro']) {
        $str .= 'Orientation professionelle<br>';
    }
    if ($data['act_cinema']) {
        $str .= 'Cinéma<br>';
    }
    if ($data['act_exp_corp']) {
        $str .= 'Expression corporelle ('.$data['act_exp_corp_p'].')<br>';
    }
    if ($data['act_jeux_piste']) {
        $str .= 'Jeux de piste<br>';
    }
    if ($data['act_illustrations']) {
        $str .= 'Illustrations ('.$data['act_illustrations_p'].')<br>';
    }
    if ($data['act_jeux_mem']) {
        $str .= 'Jeux de mémoire<br>';
    }
    if ($data['act_musiques']) {
        $str .= 'Musiques ('.$data['act_musiques_p'].')<br>';
    }
    if ($data['act_ecritures']) {
        $str .= 'Ecritures ('.$data['act_ecritures_p'].')<br>';
    }
    if ($data['act_danses']) {
        $str .= 'Danses ('.$data['act_danses_p'].')<br>';
    }
    if ($data['act_arts_plastiques']) {
        $str .= 'Arts plastiques ('.$data['act_arts_plastiques_p'].')<br>';
    }
    if ($data['act_arts_rue']) {
        $str .= 'Arts de la rue ('.$data['act_arts_rue_p'].')<br>';
    }
    if ($data['act_bijoux']) {
        $str .= 'Bijoux<br>';
    }
    if ($data['act_sculpture']) {
        $str .= 'Suclpture<br>';
    }
    if ($data['act_chants']) {
        $str .= 'Chants ('.$data['act_chants_p'].')<br>';
    }
    if ($data['act_relaxation']) {
        $str .= 'Relaxation<br>';
    }
    if ($data['act_sports']) {
        $str .= 'Sports ('.$data['act_sports_p'].')<br>';
    }
    if ($data['act_imagination']) {
        $str .= 'Imagination ('.$data['act_imagination'].')<br>';
    }
    if ($data['act_logique']) {
        $str .= 'Logique<br>';
    }
    if ($data['act_theatres']) {
        $str .= 'Théâtres ('.$data['act_theatres_p'].')<br>';
    }
    if ($data['act_strategie']) {
        $str .= 'Stratégie<br>';
    }
    if ($data['act_meditation']) {
        $str .= 'Méditation<br>';
    }
    if ($data['act_photo']) {
        $str .= 'Photo<br>';
    }
    if ($data['act_arts_cirque']) {
        $str .= 'Arts du cirque ('.$data['act_arts_cirque_p'].')<br>';
    }
    if ($data['act_arts_enigme']) {
        $str .= 'Enigmes<br>';
    }
    if (!empty($data['act_autres'])) {
        $str .= 'Autres: '.$data['act_autres'].'<br>';
    }
    $str .= '<br>J\'ai répondu comme suit pour les activités sportives:<br><br>';
    if ($data['act_rafting'] != 0) {
        if ($data['act_rafting'] == 2) {
            $reponse = 'Je souhaite le faire';
        }
        else {
            $reponse = 'Je peux le faire';
        }
    }
    else {
        $reponse = 'Il m\'est impossible de le faire';
    }
    $str .= 'Rafting: '.$reponse.'<br>';
    if ($data['act_canyo'] != 0) {
        if ($data['act_canyo'] == 2) {
            $reponse = 'Je souhaite le faire';
        }
        else {
            $reponse = 'Je peux le faire';
        }
    }
    else {
        $reponse = 'Il m\'est impossible de le faire';
    }
    $str .= 'Canyoning: '.$reponse.'<br>';
    if ($data['act_descente'] != 0) {
        if ($data['act_descente'] == 2) {
            $reponse = 'Je souhaite le faire';
        }
        else {
            $reponse = 'Je peux le faire';
        }
    }
    else {
        $reponse = 'Il m\'est impossible de le faire';
    }
    $str .= 'Descente VTT: '.$reponse.'<br>';
    if ($data['act_mini_raid'] != 0) {
        if ($data['act_mini_raid'] == 2) {
            $reponse = 'Je souhaite le faire';
        }
        else {
            $reponse = 'Je peux le faire';
        }
    }
    else {
        $reponse = 'Il m\'est impossible de le faire';
    }
    $str .= 'Mini raid VTT: '.$reponse.'<br>';
    if ($data['act_via_fe'] != 0) {
        if ($data['act_via_fe'] == 2) {
            $reponse = 'Je souhaite le faire';
        }
        else {
            $reponse = 'Je peux le faire';
        }
    }
    else {
        $reponse = 'Il m\'est impossible de le faire';
    }
    $str .= 'Via Ferrata: '.$reponse.'<br>';
    if ($data['act_grimp'] != 0) {
        if ($data['act_grimp'] == 2) {
            $reponse = 'Je souhaite le faire';
        }
        else {
            $reponse = 'Je peux le faire';
        }
    }
    else {
        $reponse = 'Il m\'est impossible de le faire';
    }
    $str .= 'Grimp\'arbre: '.$reponse.'<br>';
    if ($data['act_bike_park'] != 0) {
        if ($data['act_bike_park'] == 2) {
            $reponse = 'Je souhaite le faire';
        }
        else {
            $reponse = 'Je peux le faire';
        }
    }
    else {
        $reponse = 'Il m\'est impossible de le faire';
    }
    $str .= 'Mourtis Bike Park: '.$reponse.'<br>';
    if ($data['act_speed_chall'] != 0) {
        if ($data['act_speed_chall'] == 2) {
            $reponse = 'Je souhaite le faire';
        }
        else {
            $reponse = 'Je peux le faire';
        }
    }
    else {
        $reponse = 'Il m\'est impossible de le faire';
    }
    $str .= 'Mourtis Speed Challenge: '.$reponse.'<br>';
    if ($data['act_biathlon'] != 0) {
        if ($data['act_biathlon'] == 2) {
            $reponse = 'Je souhaite le faire';
        }
        else {
            $reponse = 'Je peux le faire';
        }
    }
    else {
        $reponse = 'Il m\'est impossible de le faire';
    }
    $str .= 'Biathlon: '.$reponse.'<br>';
    if ($data['act_piscine'] != 0) {
        if ($data['act_piscine'] == 2) {
            $reponse = 'Je souhaite le faire';
        }
        else {
            $reponse = 'Je peux le faire';
        }
    }
    else {
        $reponse = 'Il m\'est impossible de le faire';
    }
    $str .= 'Piscine: '.$reponse.'<br>';
    if ($data['act_sports_co'] != 0) {
        if ($data['act_sports_co'] == 2) {
            $reponse = 'Je souhaite le faire';
        }
        else {
            $reponse = 'Je peux le faire';
        }
    }
    else {
        $reponse = 'Il m\'est impossible de le faire';
    }
    $str .= 'Animation sports co: '.$reponse.'<br>';

    $to       = $data['mail'];
    $subject  = 'Votre demande d\'inscription au camp "Réussir Sa Vie" n°'.$infos_camp['numero'];
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
    $headers .= 'From: Fondacio Jeunes <adultes.camps@fondacio.fr>'."\r\n".
                'Reply-To: fondacio.camp'.$infos_camp['numero'].'@gmail.com';

    mail($to, $subject, $str, $headers);

}

function get_cheques() {

    global $bdd;

    $req = 'SELECT camp, nom, prenom, cheque1_montant, cheque1_numero, cheque1_date_encaissement, cheque2_montant, cheque2_numero, cheque2_date_encaissement, cheque3_montant, cheque3_numero, cheque3_date_encaissement, cheque4_montant, cheque4_numero, cheque4_date_encaissement, cheque5_montant, cheque5_numero, cheque5_date_encaissement, cheque6_montant, cheque6_numero, cheque6_date_encaissement FROM jeunes WHERE cheque1_montant > 0 ORDER BY cheque1_date_encaissement, cheque2_date_encaissement, cheque3_date_encaissement, cheque4_date_encaissement, cheque5_date_encaissement, cheque6_date_encaissement, nom, prenom';

    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[] = $d;
    }
    $res->closeCursor();

    return $data;

}

function alertes_transports($raison) {

    global $bdd, $today;

    $data = array();

    switch ($raison) {
        case 'arrivees':
            $req = 'SELECT nom, prenom, tel_portable, aller_heure FROM jeunes WHERE camp = '.$_SESSION['camp'].' AND aller_transport = "train" AND aller_date = "'.$today.'" ORDER BY aller_heure, nom';
            break;
        case 'arrivees_demain':
            $tomorrow = date('Y-m-d', strtotime(' +1 day'));
            $req = 'SELECT nom, prenom, tel_portable, aller_heure FROM participants WHERE aller_transport = "train" AND aller_date = "'.$tomorrow.'" ORDER BY aller_heure, nom';
            break;
        case 'departs':
            $req = 'SELECT nom, prenom, tel_portable, retour_heure, retour_transport FROM participants WHERE retour_transport != "bus" AND retour_date = "'.$today.'" ORDER BY retour_transport, retour_heure, nom';
            break;
        case 'departs_demain':
            $tomorrow = date('Y-m-d', strtotime(' +1 day'));
            $req = 'SELECT nom, prenom, tel_portable, retour_heure, retour_transport FROM participants WHERE retour_transport != "bus" AND retour_date = "'.$tomorrow.'" ORDER BY retour_transport, retour_heure, nom';
            break;
        case 'none':
            $req = 'SELECT nom, prenom, tel_portable FROM participants WHERE camp = '.$_SESSION['camp'].' AND retour_transport = "" ORDER BY nom';
            break;
        case 'train_heure':
            $req = 'SELECT nom, prenom, tel_portable, retour_date FROM participants WHERE camp = '.$_SESSION['camp'].' AND retour_transport = "train" AND retour_heure = "" ORDER BY retour_date, nom';
            break;
        case 'bus_ville':
            $req = 'SELECT nom, prenom, tel_portable, retour_date FROM participants WHERE camp = '.$_SESSION['camp'].' AND retour_transport = "bus" AND retour_ville = "" ORDER BY retour_date, nom';
            break;
    }

    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[] = $d;
    }
    $res->closeCursor();

    return $data;

}

/// OLD ///

function count_participants($filtres) {

    global $bdd;

    $req = 'SELECT COUNT(*) FROM participants WHERE camp = '.$_SESSION['camp'];
    if (!empty($filtres)) {
        $req .= ' AND';
        end($filtres);
        $last = key($filtres);
        foreach ($filtres as $key => $value) {
            if (!empty($value)) {
                $req .= ' '.$key.' = "'.$value.'"';
                if ($key != $last) {
                    $req .= ' AND';
                }
            }
        }
    }
    $res = $bdd->query($req);
    $data = $res->fetchColumn();
    $res->closeCursor();

    return $data;
}

function get_participants($filtres) {

    global $bdd;

    $data = array();
    $req = 'SELECT id_participant, nom, prenom, type, tel_portable, date_naissance, civilite, ancien, prepa, service, pg_num, chambre_num FROM participants';
    if (!empty($filtres)) {
        $req .= ' WHERE';
        end($filtres);
        $last = key($filtres);
        foreach ($filtres as $key => $value) {
            if ($key != 'tri1' && $key != 'tri2') {
                if ($key == 'nom') {
                    $req .= ' (nom LIKE "%'.$value.'%" OR prenom LIKE "%'.$value.'%")';
                }
                else {
                    $req .= ' '.$key.' = "'.$value.'"';
                }
                if ($key != $last) {
                    $req .= ' AND';
                }
            }
        }
    }
    if (!empty($filtres['tri1'])) {
        $req .= ' ORDER BY '.$filtres['tri1'];
        if (!empty($filtres['tri2'])) {
            $req .= ', '.$filtres['tri2'];
        }
    }
    else {
        $req .= ' ORDER BY nom';
    }
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[$d['id_participant']] = $d;
    }
    $res->closeCursor();

    return $data;
}

function get_participant($id) {

    global $bdd;

    $data = array();
    $req = 'SELECT * FROM participants WHERE id_participant = '.$id;
    $res = $bdd->query($req);
    $data = $res->fetch();
    $res->closeCursor();

    return $data;
}

function get_transports($camp, $aller_retour, $prepa, $moyen_transport, $ville) {

    global $bdd;

    $data = array();
    $req = 'SELECT id_participant, nom, prenom, type, tel_portable, mere_portable, pere_portable, '.$aller_retour.'_transport AS transport, '.$aller_retour.'_heure AS heure, '.$aller_retour.'_ville AS ville, '.$aller_retour.'_date AS date FROM participants WHERE camp = '.$camp;
    if ($aller_retour == 'aller') {
        $req .= ' AND prepa = "'.$prepa.'"';
    }
    if (!empty($moyen_transport)) {
        $req .= ' AND '.$aller_retour.'_transport = "'.$moyen_transport.'"';
    }
    if (!empty($ville)) {
        $req .= ' AND '.$aller_retour.'_ville = "'.$ville.'"';
    }
    $req .= ' ORDER BY date, heure, transport, ville, type, nom';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[$d['transport']][] = $d;
    }
    $res->closeCursor();

    return $data;
}

function get_activites() {

    global $bdd;

    $data = array();
    $req = 'SELECT * FROM activites ORDER BY code, nom';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[$d['id_activite']] = $d;
    }
    $res->closeCursor();

    return $data;
}

function get_activite($id) {

    global $bdd;

    $data = array();
    $req = 'SELECT * FROM activites WHERE id_activite = '.$id;
    $res = $bdd->query($req);
    $data = $res->fetch();
    $res->closeCursor();

    return $data;
}

function update_participant ($action, $donnees, $id) {

    global $bdd;

    $req = 'participants SET ';
    end($donnees);
    $last = key($donnees);
    foreach ($donnees as $key => $value) {
        if (!in_array($key, array('activite_mardi_creative', 'activite_mardi_sportive', 'activite_mercredi_creative', 'activite_mercredi_sportive', 'activite_jeudi_creative', 'activite_jeudi_sportive', 'activite_vendredi_creative', 'activite_vendredi_sportive'))) {
            $req .= $key.' = "'.$value.'"';
            if ($key != $last) {
                $req .= ', ';
            }
        }
        else {
            if ($action != 'add') {
                $jour = explode('_', $key);
                $req2 = 'UPDATE inscriptions SET activite = "'.$value.'" WHERE id_jeune = '.$id.' AND jour = "'.$jour[1].'" AND type = "'.$jour[2].'"';
                $res2 = $bdd->query($req2);
                $res2->closeCursor();
            }
        }
    }
    if ($action == 'add') {
        $req = 'INSERT INTO '.$req;
    }
    else {
        $req = 'UPDATE '.$req.' WHERE id_participant = '.$id;
    }
    $res = $bdd->query($req);
    $res->closeCursor();

    if ($action == 'add') {
        $id = $bdd->lastInsertId();
    }
    header('Location: participants.php?action=edit&id_participant='.$id);

}

function delete_participant ($id) {

    global $bdd;

    $req = 'DELETE FROM participants WHERE id_participant = '.$id;
    $res = $bdd->query($req);
    $res->closeCursor();
    header('Location: participants.php');

}

function update_activite ($action, $donnees, $id) {

    global $bdd;

    $req = 'activites SET ';
    end($donnees);
    $last = key($donnees);
    foreach ($donnees as $key => $value) {
        $req .= $key.' = "'.$value.'"';
        if ($key != $last) {
            $req .= ', ';
        }
    }
    if ($action == 'add') {
        $req = 'INSERT INTO '.$req;
    }
    else {
        $req = 'UPDATE '.$req.' WHERE id_activite = '.$id;
    }

    $res = $bdd->query($req);
    $res->closeCursor();

    if ($action == 'add') {
        $id = $bdd->lastInsertId();
    }
    header('Location: activites.php?action=edit&id_activite='.$id);

}

function get_anniversaires() {

    global $bdd;

    $data = array();
    $today = date('m-d');
    $req = 'SELECT id_participant, nom, prenom, date_naissance FROM participants WHERE date_naissance LIKE "%'.$today.'%" AND camp = '.$_SESSION['camp'];
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[$d['id_participant']] = $d;
    }
    $res->closeCursor();

    return $data;

}

function get_trombi() {

    global $bdd;

    $data = array();
    $req = 'SELECT nom, prenom FROM participants WHERE camp = '.$_SESSION['camp'].' ORDER BY type, nom';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[] = $d;
    }
    $res->closeCursor();

    return $data;

}

function get_parrainages() {

    global $bdd;

    $data = array();
    $req = 'SELECT parrain, filleul FROM parrainages WHERE camp = '.$_SESSION['camp'].' ORDER BY parrain, filleul';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[] = array($d['parrain'], $d['filleul']);
    }
    $res->closeCursor();

    return $data;

}

function get_pg() {

    global $bdd;

    $data = array();
    $req = 'SELECT nom, prenom, pg_num, pg_resp FROM participants WHERE camp = '.$_SESSION['camp'].' AND type = "jeune" ORDER BY pg_num, pg_resp, nom, prenom';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[$d['pg_num']][] = $d['nom'].' '.$d['prenom'].' - '.$d['pg_resp'];
    }
    $res->closeCursor();

    return $data;

}

function get_chambres() {

    global $bdd;

    $data = array();
    $req = 'SELECT nom, prenom, chambre_num FROM participants WHERE camp = '.$_SESSION['camp'].' ORDER BY chambre_num, nom, prenom';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[$d['chambre_num']][] = $d['nom'].' '.$d['prenom'];
    }
    $res->closeCursor();

    return $data;

}


function get_badges() {

    global $bdd;

    $data = array();
    $req = 'SELECT nom, prenom, type, pg_num, chambre_num, service FROM participants WHERE camp = '.$_SESSION['camp'].' ORDER BY type, nom';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[] = $d;
    }
    $res->closeCursor();

    return $data;

}

function get_accueil($type) {

    global $bdd;

    $data = array();
    $req = 'SELECT nom, prenom, chambre_num, pg_num, retour_transport, retour_date, retour_heure, retour_ville, manquant FROM participants WHERE camp = '.$_SESSION['camp'].' AND type = "'.$type.'" ORDER BY nom';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[] = $d;
    }
    $res->closeCursor();

    return $data;

}

function save_parrainage($parrain, $filleul) {

    global $bdd;

    $req = 'INSERT INTO parrainages VALUES ("'.$parrain.'", "'.$filleul.'", '.$_SESSION['camp'].')';
    $bdd->query($req);

    return 0;

}

function save_pg($num, $jeunes) {

    global $bdd;

    $i = 1;
    foreach ($jeunes as $jeune) {
        $req = 'UPDATE participants SET pg_num = '.$num.' WHERE id_participant = '.$jeune;
        if ($i == 1) {
            $req2 = 'UPDATE participants SET pg_resp = "oui" WHERE id_participant = '.$jeune;
        }
        $bdd->query($req);
        ++$i;
    }
    $bdd->query($req2);

    return 0;
}

function save_chambre($num, $jeunes) {

    global $bdd;

    $i = 1;
    foreach ($jeunes as $jeune) {
        $req = 'UPDATE participants SET chambre_num = "'.$num.'" WHERE id_participant = '.$jeune;
        if ($i == 1) {
            $req2 = 'UPDATE participants SET chambre_resp = "oui" WHERE id_participant = '.$jeune;
        }
        $bdd->query($req);
        ++$i;
    }
    $bdd->query($req2);

    return 0;
}

function get_historique($jeune, $jour, $type) {

    global $bdd;

    $data = array();
    $req = 'SELECT activite FROM inscriptions WHERE id_jeune = "'.$jeune.'" AND jour = "'.$jour.'" AND type = "'.$type.'"';
    $res = $bdd->query($req);
    $data = $res->fetchColumn();
    $res->closeCursor();

    return $data;

}

function inscrire($camp, $id, $nom, $activites, $jour) {

    global $bdd;

    foreach ($activites as $type => $activite) {
        $req = 'INSERT INTO inscriptions SET camp = '.$camp.', id_jeune = '.$id.', nom_jeune = "'.$nom.'", activite = "'.$activite.'", jour = "'.$jour.'", type = "'.$type.'"';
        $bdd->query($req);
    }

    $req = 'UPDATE participants SET inscrit_'.$jour.' = 1 WHERE id_participant = '.$id;
    $bdd->query($req);

    return 0;

}

function clean_dispo($id) {

    global $bdd;
    $req = 'UPDATE activites SET mardi_dispo = 0, mercredi_dispo = 0, jeudi_dispo = 0, vendredi_dispo = 0 WHERE id_activite = '.$id;
    $bdd->query($req);

    return 0;

}

function get_non_inscrits($jour) {

    global $bdd;

    $req = 'SELECT nom, prenom, service FROM participants WHERE camp = '.$_SESSION['camp'].' AND type = "jeune" AND inscrit_'.$jour.' = 0 ORDER BY service';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[] = $d;
    }
    $res->closeCursor();

    return $data;

}

function get_inscrits_doublon($jour) {

    global $bdd;

    $req = 'SELECT nom_jeune, COUNT(*) AS compte FROM inscriptions WHERE camp = '.$_SESSION['camp'].' AND jour = "'.$jour.'" GROUP BY nom_jeune';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        if($d['compte'] > 2) {
            $data[] = $d;
        }
    }
    $res->closeCursor();

    return $data;

}

function get_inscriptions() {

    global $bdd;

    $day = date('w')+1;
    switch ($day) {
        case 0:
            $day = 'dimanche';
            break;
        case 1:
            $day = 'lundi';
            break;
        case 2:
            $day = 'mardi';
            break;
        case 3:
            $day = 'mercredi';
            break;
        case 4:
            $day = 'jeudi';
            break;
        case 5:
            $day = 'vendredi';
            break;
        case 6:
            $day = 'samedi';
            break;
    }

    $req = 'SELECT i.activite, p.type, i.nom_jeune FROM inscriptions i, participants p WHERE i.id_jeune = p.id_participant AND p.camp = '.$_SESSION['camp'].' AND i.jour = "'.$day.'"';

    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[$d['activite']][$d['type']][] = $d['nom_jeune'];
    }
    $res->closeCursor();

    foreach ($data as $acti => $donnees_osef) {

        $req = 'SELECT '.$day.'_resp1, '.$day.'_resp2 FROM activites WHERE nom = "'.$acti.'"';
        $res = $bdd->query($req);
        while ($d = $res->fetch()) {
            if (!empty($d[$day.'_resp2'])) {
                $resps = $d[$day.'_resp1'].' / '.$d[$day.'_resp2'];
            }
            else {
                $resps = $d[$day.'_resp1'];
            }
            $data[$acti]['adulte'][] = $resps;
        }
    $res->closeCursor();

    }

    return $data;

}

function get_donnees_mails($activite) {

    global $bdd;

    $day = date('w')+1;
    switch ($day) {
        case 0:
            $day = 'dimanche';
            break;
        case 1:
            $day = 'lundi';
            break;
        case 2:
            $day = 'mardi';
            break;
        case 3:
            $day = 'mercredi';
            break;
        case 4:
            $day = 'jeudi';
            break;
        case 5:
            $day = 'vendredi';
            break;
        case 6:
            $day = 'samedi';
            break;
    }

    $req = 'SELECT i.nom_jeune, p.taille, p.poids FROM inscriptions i, participants p WHERE i.id_jeune = p.id_participant AND i.camp = '.$_SESSION['camp'].' AND activite = "'.$activite.'" AND jour = "'.$day.'"';
    $res = $bdd->query($req);
    while ($d = $res->fetch()) {
        $data[] = $d;
    }
    $res->closeCursor();

    return $data;

}

?>