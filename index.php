<?php

require_once 'include/init.php';

$title = 'Accueil';
require_once 'include/head.php';

?>

<h2 style="color: red"><b>Si problème, contacter Pierre: pleplat75@gmail.com / 06 12 19 22 92</b></h2><br>

<!-- <h3><b>Alertes transport</b></h3> -->

<?php

/*$donnees = alertes_transports('arrivees');
echo '<h4>Arrivées en train du jour ('.date('d/m/Y').')</h4>';
echo '<ul>';
foreach ($donnees as $data) {
    echo '<li><b>'.$data['nom'].'</b> '.$data['prenom'].': <b><span style="color: red">'.$data['aller_heure'].'</span></b> ('.$data['tel_portable'].')</li>';
}
echo '</ul>';

$donnees = alertes_transports('arrivees_demain');
echo '<h4>Arrivées en train de demain ('.date('d/m/Y', strtotime(' +1 day')).')</h4>';
echo '<ul>';
foreach ($donnees as $data) {
    echo '<li><b>'.$data['nom'].'</b> '.$data['prenom'].': <b><span style="color: red">'.$data['aller_heure'].'</span></b> ('.$data['tel_portable'].')</li>';
}
echo '</ul>';

$donnees = alertes_transports('departs');
echo '<h4>Départs du jour ('.date('d/m/Y').')</h4>';
echo '<ul>';
foreach ($donnees as $data) {
    echo '<li><b>'.$data['nom'].'</b> '.$data['prenom'].': <b><span style="color: red">'.$data['retour_transport'].' '.$data['retour_heure'].'</span></b> ('.$data['tel_portable'].')</li>';
}
echo '</ul>';

$donnees = alertes_transports('departs_demain');
echo '<h4>Départs de demain ('.date('d/m/Y', strtotime(' +1 day')).')</h4>';
echo '<ul>';
foreach ($donnees as $data) {
    echo '<li><b>'.$data['nom'].'</b> '.$data['prenom'].': <b><span style="color: red">'.$data['retour_transport'].' '.$data['retour_heure'].'</span></b> ('.$data['tel_portable'].')</li>';
}
echo '</ul>';

$donnees = alertes_transports('none');
echo '<h4>Absence de transport retour</h4>';
echo '<ul>';
foreach ($donnees as $data) {
	if ($data['nom'] != 'CHAUFFEUR') {
    	echo '<li><b>'.$data['nom'].'</b> '.$data['prenom'].' ('.$data['tel_portable'].')</li>';
    }
}
echo '</ul>';

$donnees = alertes_transports('train_heure');
echo '<h4>Absence d\'heure du train retour</h4>';
echo '<ul>';
foreach ($donnees as $data) {
    echo '<li><b>'.$data['nom'].'</b> '.$data['prenom'].': <b><span style="color: red">'.convert_date($data['retour_date']).'</span></b> ('.$data['tel_portable'].')</li>';
}
echo '</ul>';

$donnees = alertes_transports('bus_ville');
echo '<h4>Absence de ville du bus retour</h4>';
echo '<ul>';
foreach ($donnees as $data) {
    echo '<li><b>'.$data['nom'].'</b> '.$data['prenom'].': <b><span style="color: red">'.convert_date($data['retour_date']).'</span></b> ('.$data['tel_portable'].')</li>';
}
echo '</ul>';*/

?>

<!-- <h3><b>Anniversaires</b></h3><br> -->

<?php

/*$anniversaires = get_anniversaires();
foreach ($anniversaires as $anniv) {
    echo '- '.$anniv['prenom'].' '.$anniv['nom'].' ('.age($anniv['date_naissance']).' ans)<br>';
}*/

?>

<!-- <h3><b>Statistiques</b></h3><br> -->

<?php

/*$filtres = array();
echo '- Nombre total de participants: '.count_participants($filtres).'<br>';

$filtres = array('type' => 'jeune');
echo '- Nombre de jeunes: '.count_participants($filtres).'<br>';

$filtres = array('type' => 'jeune', 'prepa' => 'oui');
echo '- Nombre de jeunes prépa: '.count_participants($filtres).'<br>';

$filtres = array('type' => 'jeune', 'prepa' => 'non');
echo '- Nombre de jeunes nouveaux: '.count_participants($filtres).'<br>';

$filtres = array('type' => 'jeune', 'civilite' => 'F');
echo '- Nombre de jeunes filles: '.count_participants($filtres).'<br>';

$filtres = array('type' => 'jeune', 'civilite' => 'H');
echo '- Nombre de jeunes garçons: '.count_participants($filtres).'<br>';

$filtres = array('type' => 'adulte');
echo '- Nombre d\'adultes: '.count_participants($filtres);*/

?>

<?php

require_once 'include/foot.php';

?>