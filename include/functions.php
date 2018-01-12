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

    $birthDate = explode('-', $date);
    return (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
    ? ((date("Y") - $birthDate[0]) - 1)
    : (date("Y") - $birthDate[0]));

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

    $req = 'SELECT id_utilisateur, role FROM utilisateurs WHERE login = "'.$login.'"';
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

function get_camp($camp) {

    global $bdd;

    $req = 'SELECT * FROM camps WHERE numero = '.$camp;
    $res = $bdd->query($req);
    $data = $res->fetch();
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

function get_inscrits($camp, $filtres = array(), $tri = '') {

    global $bdd;

    $req = 'SELECT id_jeune, nom, prenom, paiement_declare, da_a_relancer, da_complet, rgt_recu, rgt_montant, desistement FROM jeunes WHERE ';
    if (!empty($filtres)) {
        foreach ($filtres as $champ => $value) {
            if ($champ == 'rgt_recu') {
                $req .= $champ.' IS NULL';
            }
            elseif ($champ == 'da_a_relancer') {
                $req .= $champ.' IS NOT NULL';
            }
            elseif ($champ == 'da_complet') {
                $req .= $champ.' = 0';
            }
            elseif ($champ == 'nom') {
                $req .= $champ.' LIKE "%'.$value.'%"';
            }
            else {
                $req .= $champ.' = "'.$value.'"';
            }
            $req .= ' AND ';
        }
    }
    $req .= 'camp = '.$camp.'';
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

function get_jeune($id) {

    global $bdd;

    $req = 'SELECT * FROM jeunes WHERE id_jeune = '.$id;
    $res = $bdd->query($req);
    $data = $res->fetch();
    $res->closeCursor();

    return $data;

}


function enregistrer_inscription($data) {

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
    $req .= 'cp = '.$data['code_postal'].', ';
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

    $str = 'Bonjour,<br><br>

Votre demande d\'inscription pour votre enfant '.$data['jeune_prenom'].' au camp Réussir Sa Vie (camp n°'.$infos_camp['numero'].') qui aura lieu du '.date($infos_camp['date_debut'], '-', '/').' au '.date($infos_camp['date_fin'], '-', '/').' au Mourtis (31) a bien été enregistrée, et nous vous en remercions.

Pour confirmer son inscription, merci d\'envoyer le dossier administratif complet, accompagné de votre règlement (chèque à l\'ordre de Fondacio France) à :<br><br>

Fondacio camp RSV n°'.$infos_camp['numero'].'<br>
2 rue de l\'Esvière<br>
49100 ANGERS<br><br>

Les éléments du dossier administratif sont téléchargeables <a target="_blank" href="http://fondacio.fr/fondacio/spip.php?article539">en suivant ce lien</a>.<br>
Si vous souhaitez payer en ligne, <a target="_blank" href="http://www.fondacio.fr/fondacio/spip.php?page=produit&ref=CAMPS_RSV_ADOS&id_article=524">cliquez ici</a>.<br><br>';

    if (isset($data['prepa'])) {

        $str .= 'De plus, vous avez inscrit '.$data['jeune_prenom'].' à la prépa du camp. Vous retrouverez toutes les informations à ce ssujet en <a href="http://www.fondacio.fr/fondacio/spip.php?article870">cliquant ici</a>.';

    }

    $str .= 'Pour toute question concernant le camp, merci de ne pas répondre à cette adresse, mais d\'envoyer votre demande à <a href="mailto:jeunes.camps@fondacio.fr">l\'adresse suivante</a>.<br><br>

Au plaisir d\'accueillir votre enfant cet été au Mourtis !<br><br>

L\'équipe Fondacio Jeunes

PS : Vous trouverez ci-dessous les infos que vous venez de saisir.<br><br>';

if ($data['civilite'] == 'H') {
    $str .= 'Civilité: Homme<br>';
}
else {
    $str .= 'Civilité: Femme<br>';
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
Etudes actuelles: '.$data['etudes'].'<br>
Taille: '.$data['taille'].' cms<br>
Poids: '.$data['poids'].' kgs<br>
Nom des parents: '.$data['parents_nom'].'<br>
Prénom des parents: '.$data['parents_prenom'].'<br>
Tel portable de la mère: '.$data['mere_tel_portable'].'<br>
Tel portable du père: '.$data['pere_tel_portable'].'<br>
Courriel des parents: '.$data['parents_mail'].'<br>';
if ($data['ancien']) {
    $ancien = 'Oui';
}
else {
    $ancien = 'Non';
}
$str .= 'J\'ai déjà fait un camp "Réussir Sa Vie": '.$ancien.'<br>
J\'arriverai au Mourtis en: '.$data['aller_transport'].' (';
if ($data['aller_transport'] == 'bus') {
    $str .= $data['aller_bus'];
}
else if ($data['aller_transport'] == 'train') {
    $str .= 'navette de '.$data['aller_train'];
}
$str .= ')<br>
Je repartirai du Mourtis en: '.$data['retour_transport'].' (';
if ($data['retour_transport'] == 'bus') {
    $str .= $data['retour_bus'];
}
$str .= ')<br>
Je choisis de payer le montant suivant : '.$data['paiement_declare'].' €<br>
J\'ai connu ce camp par: '.$data['communication'].'<br>
Conditions de participation: Je m’engage à envoyer le dossier d’inscription COMPLET avec le règlement dans un délai de 15 jours à compter de la présente pré-inscription sur internet. Fondacio se réserve le droit d’annuler l’inscription du jeune si ce délai n’est pas respecté.<br>
Conditions d\'annulation: J’accepte les conditions d’annulation suivantes : pour toute annulation intervenant plus d’un mois avant le départ, les sommes payées seront intégralement remboursées par chèque bancaire ; pour toute annulation intervenant entre 7 jours et 30 jours avant le départ, 50% des sommes versées (transport compris) seront remboursées (100% si raison médicale, sur justificatif) ; pour toute annulation intervenant moins de 7 jours avant le départ (sauf raison médicale avec justificatif), l’intégralité des sommes versées est conservée par Fondacio.';

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    try {
        $mail->SMTPDebug = 2;
        $mail->CharSet = 'UTF-8';

        /*$mail->isSMTP();
        $mail->Host = 'smtp.sfr.fr';
        $mail->SMTPAuth = false;
        $mail->SMTPSecure = false;
        $mail->Port = 25;*/

        //Recipients
        $mail->setFrom('jeunes.camps@fondacio.fr', 'Fondacio Jeunes');
        $mail->addAddress($data['parents_mail'], $data['parents_prenom'].' '.$data['parents_nom']);
        $mail->addAddress('fondacio.camp'.$infos_camp['numero'].'@gmail.com', 'Fondacio');
        $mail->addReplyTo('fondacio.camp'.$infos_camp['numero'].'@gmail.com', 'Fondacio');

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Votre demande d\'inscription au camp "Réussir Sa Vie" n°'.$infos_camp['numero'];
        $mail->Body    = $str;

        $mail->send();
    }
    catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }

}

function maj_administratif($id, $data) {

    global $bdd;
    $req  = 'UPDATE jeunes SET ';
    end($data);
    $last = key($data);
    reset($data);
    foreach ($data as $champ => $value) {
        if ($champ == 'aller_bus') {
            $req .= 'aller_ville = "'.$value.'"';
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

function alertes_transports($raison) {

    global $bdd, $today;

    $data = array();

    switch ($raison) {
        case 'arrivees':
            $req = 'SELECT nom, prenom, tel_portable, aller_heure FROM participants WHERE aller_transport = "train" AND aller_date = "'.$today.'" ORDER BY aller_heure, nom';
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