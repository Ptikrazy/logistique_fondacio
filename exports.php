<?php

require_once 'include/init.php';

$title = 'Exports';
require_once 'include/head.php';

?>

<h2>Liste des exports</h2>

<button type="button" class="btn btn-primary" onclick="location.href = 'exports/export_pdf.php?contexte=accueil&type=jeune';">Accueil Jeunes</button><br><br>
<button type="button" class="btn btn-primary" onclick="location.href = 'exports/export_pdf.php?contexte=accueil&type=adulte';">Accueil Adultes</button><br><br>
<button type="button" class="btn btn-primary" onclick="location.href = 'exports/export_pdf.php?contexte=badges';">Badges</button><br><br>
<button type="button" class="btn btn-primary" onclick="location.href = 'exports/export_pdf.php?contexte=chambres';">Chambres</button><br><br>
<button type="button" class="btn btn-primary" onclick="location.href = 'exports/export_pdf.php?contexte=parrainages';">Parrainages</button><br><br>
<button type="button" class="btn btn-primary" onclick="location.href = 'exports/export_pdf.php?contexte=pg';">Petits groupes</button><br><br>
<button type="button" class="btn btn-primary" onclick="location.href = 'exports/export_pdf.php?contexte=trombi';">Trombinoscope</button><br><br>

<?php

require_once 'include/foot.php';

?>