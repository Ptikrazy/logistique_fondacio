<?php

require_once 'include/init.php';

$title = 'Inscriptions';
require_once 'include/head.php';

if (isset($_POST['jour_inscription'])) {
    $_SESSION['jour_inscription'] = $_POST['jour_inscription'];
}

if (isset($_POST['inscription'])) {

    $activites = array();
    foreach ($_POST as $key => $value) {
        if (!in_array($key, array('inscription', 'id_jeune', 'nom_jeune'))) {
            $acti = explode('_', $key);
            if ($acti[1] == 'sport') {
                $activites[$acti[0].'_sportive'] = $value;
            }
            else {
                $activites[$acti[0].'_creative'] = $value;
            }
        }
    }

    inscrire($_POST['id_jeune'], $_POST['nom_jeune'], $activites);
    echo '<script>swal("'.$_POST['nom_jeune'].' inscrit avec succès !","","success")</script>';
    unset($_POST['jeune']);

}

?>

<h3>Choisir un jour</h3>

<form action="" method="POST">
    <div class="form-group row">
        <div class="col-md-3">
            <select class="form-control" name="jour_inscription">
                <option value="mardi" <?php echo (isset($_SESSION['jour_inscription']) && $_SESSION['jour_inscription'] == 'mardi') ? 'selected' : ''; ?>>Mardi</option>
                <option value="mercredi" <?php echo (isset($_SESSION['jour_inscription']) && $_SESSION['jour_inscription'] == 'mercredi') ? 'selected' : ''; ?>>Mercredi</option>
                <option value="jeudi" <?php echo (isset($_SESSION['jour_inscription']) && $_SESSION['jour_inscription'] == 'jeudi') ? 'selected' : ''; ?>>Jeudi</option>
                <option value="vendredi" <?php echo (isset($_SESSION['jour_inscription']) && $_SESSION['jour_inscription'] == 'vendredi') ? 'selected' : ''; ?>>Vendredi</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Sauvegarder</button>
        </div>
    </div>
</form>

<?php
    if (isset($_SESSION['jour_inscription'])) {
?>

    <h3>Inscriptions pour <?php echo $_SESSION['jour_inscription']; ?></h3>
    <div class="form-group row">
        <div class="col-sm-6">
            <button type="button" class="btn btn-secondary" onclick="location.href = 'exports/export_pdf.php?contexte=activites';">Exporter listes inscrits</button>
        </div>
    </div><br>

    <?php

    if (in_array($_SESSION['jour_inscription'], array('mardi', 'mercredi', 'jeudi', 'vendredi'))) {
        $non_inscrits = get_non_inscrits();
        echo '<div class="form-group row"><button type="button" class="btn btn-link" id="button_non_inscrits">Afficher les jeunes non-inscrits</button></div>';

        echo '<table class="table table-sm table-bordered table-hover" id="tableau_non_inscrits"><tr><th>Nom</th><th>Prénom</th><th>Service</th></tr>';
        foreach ($non_inscrits as $participant) {
            echo '<tr><td>'.$participant['nom'].'</td><td>'.$participant['prenom'].'</td><td>'.$participant['service'].'</td></tr>';
        }
        echo '</table>';

        $donnees_rafting = get_donnees_mails('rafting');
        echo '<div class="form-group row"><button type="button" class="btn btn-link" id="button_donnees_rafting">Afficher données rafting</button></div>';

        echo '<table class="table table-sm table-bordered table-hover" id="tableau_donnees_rafting"><tr><th>Nom</th><th>Taille</th><th>Poids</th></tr>';
        foreach ($donnees_rafting as $participant) {
            echo '<tr><td>'.$participant['nom_jeune'].'</td><td>'.$participant['taille'].'</td><td>'.$participant['poids'].'</td>
                  </tr>';
        }
        echo '</table>';

        $donnees_canyoning = get_donnees_mails('canyon');
        echo '<div class="form-group row"><button type="button" class="btn btn-link" id="button_donnees_canyoning">Afficher données canyon</button></div>';

        echo '<table class="table table-sm table-bordered table-hover" id="tableau_donnees_canyoning"><tr><th>Nom</th><th>Taille</th><th>Poids</th></tr>';
        foreach ($donnees_canyoning as $participant) {
            echo '<tr><td>'.$participant['nom_jeune'].'</td><td>'.$participant['taille'].'</td><td>'.$participant['poids'].'</td>
                  </tr>';
        }
        echo '</table>';
    }

    ?>

    <form action="" method="POST">
        <div class="form-group row">
            <label for="jeune" class="col-md-1 col-form-label">Jeune</label>
            <div class="col-md-5">
                <input type="text" class="form-control" name="jeune" id="jeune" value="<?php echo $_POST['jeune'] ?>">
            </div>
            <div class="col-md-3">
                 <button type="submit" class="btn btn-default">Inscription</button>
            </div>
        </div>
    </form>

    <script>
    $(function() {
        $( "#jeune" ).autocomplete({
            source: 'ajax/search.php?contexte=remplissage&type=jeune',
            autoFocus: true
        });
        $( "#tableau_non_inscrits" ).hide();
        $( "#button_non_inscrits" ).click(function() {
            $('#tableau_non_inscrits').toggle("fade", 200);
        });
        $( "#tableau_inscrits_doublons" ).hide();
        $( "#button_inscrits_doublons" ).click(function() {
            $('#tableau_inscrits_doublons').toggle("fade", 200);
        });
        $( "#tableau_donnees_rafting" ).hide();
        $( "#button_donnees_rafting" ).click(function() {
            $('#tableau_donnees_rafting').toggle("fade", 200);
        });
        $( "#tableau_donnees_canyoning" ).hide();
        $( "#button_donnees_canyoning" ).click(function() {
            $('#tableau_donnees_canyoning').toggle("fade", 200);
        });
    });
    </script>

    <?php

    if (!empty($_POST['jeune'])) {
        $jeune = explode(' - ', $_POST['jeune']);
        $id_jeune = $jeune[1];
        $nom_jeune = $jeune[0];

    ?>

        <form action="" method="POST">
        <div class="row">
            <div class="col-md-5"><h3>Activités sportives</h3></div>
            <div class="col-md-6"><h3>Activités créatives</h3></div>
        </div>

        <div class="form-group row">
            <label for="mardi_sport" class="col-md-1 col-form-label">Mardi</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="mardi_sport" id="mardi_sport" value="<?php echo get_historique($id_jeune, 'mardi', 'sportive', $_SESSION['camp']) ?>">
            </div>
            <div class="col-md-1"></div>
            <label for="mardi_crea" class="col-md-1 col-form-label">Mardi</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="mardi_crea" id="mardi_crea" value="<?php echo get_historique($id_jeune, 'mardi', 'creative', $_SESSION['camp']) ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="mercredi_sport" class="col-md-1 col-form-label">Mercredi</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="mercredi_sport" id="mercredi_sport" value="<?php echo get_historique($id_jeune, 'mercredi', 'sportive', $_SESSION['camp']) ?>">
            </div>
            <div class="col-md-1"></div>
            <label for="mercredi_crea" class="col-md-1 col-form-label">Mercredi</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="mercredi_crea" id="mercredi_crea" value="<?php echo get_historique($id_jeune, 'mercredi', 'creative', $_SESSION['camp']) ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="jeudi_sport" class="col-md-1 col-form-label">Jeudi</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="jeudi_sport" id="jeudi_sport" value="<?php echo get_historique($id_jeune, 'jeudi', 'sportive', $_SESSION['camp']) ?>">
            </div>
            <div class="col-md-1"></div>
            <label for="jeudi_crea" class="col-md-1 col-form-label">Jeudi</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="jeudi_crea" id="jeudi_crea" value="<?php echo get_historique($id_jeune, 'jeudi', 'creative', $_SESSION['camp']) ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="vendredi_sport" class="col-md-1 col-form-label">Vendredi</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="vendredi_sport" id="vendredi_sport" value="<?php echo get_historique($id_jeune, 'vendredi', 'sportive', $_SESSION['camp']) ?>">
            </div>
            <div class="col-md-1"></div>
            <label for="vendredi_crea" class="col-md-1 col-form-label">Vendredi</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="vendredi_crea" id="vendredi_crea" value="<?php echo get_historique($id_jeune, 'vendredi', 'creative', $_SESSION['camp']) ?>">
            </div>
        </div>
        <div class="form-group">
            <input type="hidden" name="inscription" value="">
            <input type="hidden" name="id_jeune" value="<?php echo $id_jeune; ?>">
            <input type="hidden" name="nom_jeune" value="<?php echo $nom_jeune; ?>">
        </div>

        <div class="form-group row">
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Inscrire</button>
            </div>
        </div>
        </form>

        <script>
        $(function() {
            $( "#mardi_sport" ).autocomplete({
                source: 'ajax/search.php?contexte=inscriptions_activite&type=sportive&day=mardi',
                autoFocus: true
            });
            $( "#mardi_crea" ).autocomplete({
                source: 'ajax/search.php?contexte=inscriptions_activite&type=creative&day=mardi',
                autoFocus: true
            });
            $( "#mercredi_sport" ).autocomplete({
                source: 'ajax/search.php?contexte=inscriptions_activite&type=sportive&day=mercredi',
                autoFocus: true
            });
            $( "#mercredi_crea" ).autocomplete({
                source: 'ajax/search.php?contexte=inscriptions_activite&type=creative&day=mercredi',
                autoFocus: true
            });
            $( "#jeudi_sport" ).autocomplete({
                source: 'ajax/search.php?contexte=inscriptions_activite&type=sportive&day=jeudi',
                autoFocus: true
            });
            $( "#jeudi_crea" ).autocomplete({
                source: 'ajax/search.php?contexte=inscriptions_activite&type=creative&day=jeudi',
                autoFocus: true
            });
            $( "#vendredi_sport" ).autocomplete({
                source: 'ajax/search.php?contexte=inscriptions_activite&type=sportive&day=vendredi',
                autoFocus: true
            });
            $( "#vendredi_crea" ).autocomplete({
                source: 'ajax/search.php?contexte=inscriptions_activite&type=creative&day=vendredi',
                autoFocus: true
            });
        });
        </script>

<?php
    }
}

require_once 'include/foot.php';

?>