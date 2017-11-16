<?php

require_once 'include/init.php';

$title = 'Exports';
require_once 'include/head.php';

?>

<h2>Liste des exports</h2>

<a class="btn btn-default" href="export_pdf.php?contexte=accueil&type=jeune" role="button">Accueil Jeunes</a><br><br>
<a class="btn btn-default" href="export_pdf.php?contexte=accueil&type=adulte" role="button">Accueil Adultes</a><br><br>
<a class="btn btn-default" href="export_pdf.php?contexte=badges" role="button">Badges</a><br><br>
<a class="btn btn-default" href="export_pdf.php?contexte=chambres" role="button">Chambres</a><br><br>
<a class="btn btn-default" href="export_pdf.php?contexte=parrainages" role="button">Parrainages</a><br><br>
<a class="btn btn-default" href="export_pdf.php?contexte=pg" role="button">Petits groupes</a><br><br>
<a class="btn btn-default" href="export_pdf.php?contexte=trombi" role="button">Trombinoscope</a><br><br>

<?php

require_once 'include/foot.php';

?>