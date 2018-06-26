<?php

require_once 'include/init.php';

////////// AJOUT / EDITION / SUPPRESSION D'UNE ACTIVITE //////////

if (!empty($_GET['action'])) {
    switch ($_GET['action']) {
        case 'edit':
            $donnees = get_activite($_GET['id_activite']);
            $titre = 'Fiche activité: '.$donnees['nom'];
            break;

        case 'add':
            $donnees = array('id_activite'        => '',
                              'code'              => '',
                              'type'              => '',
                              'nom'               => '',
                              'horaires'          => '',
                              'horaires_mercredi' => '',
                              'nb_jeunes'         => '',
                              'nb_adultes'        => '',
                              'infos_presta'      => '',
                              'mardi_dispo'       => '',
                              'mercredi_dispo'    => '',
                              'jeudi_dispo'       => '',
                              'vendredi_dispo'    => '',
                              'mardi_resp1'       => '',
                              'mardi_resp2'       => '',
                              'mercredi_resp1'    => '',
                              'mercredi_resp2'    => '',
                              'jeudi_resp1'       => '',
                              'jeudi_resp2'       => '',
                              'vendredi_resp1'    => '',
                              'vendredi_resp2'    => '');
            $titre = 'Ajout d\'une activité';
            break;

    }
    if (!empty($_POST) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')) {
        $donnees_envoyees = $_POST;
        foreach ($donnees_envoyees['dispos'] as $jour) {
            $donnees_envoyees[$jour.'_dispo'] = 1;
        }
        unset($donnees_envoyees['dispos']);
        clean_dispo($_GET['id_activite']);
        update_activite($_GET['action'], $donnees_envoyees, $_GET['id_activite']);
    }

    $title = 'Activités';
    require_once 'include/head.php';

?>
    <h3><?php echo $titre; ?></h3>
    <a class="btn btn-default" href="activites.php" role="button">Retour</a>
    <br><br>

    <form class="form-horizontal" action="" method="POST">
        <div class="form-group">
            <label for="code" class="col-md-3 col-form-label">Code couleur</label>
            <div class="col-md-3">
                <select class="form-control" name="code">
                    <option value="0"></option>
                    <option style="color: black" value="1" <?php echo (!empty($donnees['code']) && $donnees['code'] == '1') ? 'selected' : ''; ?>>Noir</option>
                    <option style="color: red" value="2" <?php echo (!empty($donnees['code']) && $donnees['code'] == '2') ? 'selected' : ''; ?>>Rouge</option>
                    <option style="color: blue" value="3" <?php echo (!empty($donnees['code']) && $donnees['code'] == '3') ? 'selected' : ''; ?>>Bleu</option>
                    <option style="color: green" value="4" <?php echo (!empty($donnees['code']) && $donnees['code'] == '4') ? 'selected' : ''; ?>>Vert</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="nom" class="col-md-3 col-form-label">Nom</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="nom" value="<?php echo $donnees['nom']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="type" class="col-md-3 col-form-label">Type</label>
            <div class="col-md-3">
                <select class="form-control" name="type">
                    <option value="creative" <?php echo (!empty($donnees['type']) && $donnees['type'] == 'creative') ? 'selected' : ''; ?>>Créative</option>
                    <option value="sportive" <?php echo (!empty($donnees['type']) && $donnees['type'] == 'sportive') ? 'selected' : ''; ?>>Sportive</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="horaires" class="col-md-3 col-form-label">Horaires (format: 14h-17h)</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="horaires" value="<?php echo $donnees['horaires']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="horaires_mercredi" class="col-md-3 col-form-label">Horaires mercredi (si différentes)</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="horaires_mercredi" value="<?php echo $donnees['horaires_mercredi']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="nb_adultes" class="col-md-3 col-form-label">Nombre d'adultes</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="nb_adultes" value="<?php echo $donnees['nb_adultes']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="nb_jeunes" class="col-md-3 col-form-label">Nombre de jeunes</label>
            <div class="col-md-3">
                <input type="text" class="form-control" name="nb_jeunes" value="<?php echo $donnees['nb_jeunes']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="infos_presta" class="col-md-3 col-form-label">Informations prestataire</label>
            <div class="col-md-3">
                <textarea class="form-control" name="infos_presta" rows="8"><?php echo $donnees['infos_presta']; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="dispos[]" class="col-md-3 col-form-label">Disponibilités</label>
            <div class="col-md-5">
                <label class="checkbox-inline">
                    <input type="checkbox" name="dispos[]" value="mardi" <?php echo ($donnees['mardi_dispo']) ? 'checked' : ''; ?>> Mardi
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" name="dispos[]" value="mercredi" <?php echo ($donnees['mercredi_dispo']) ? 'checked' : ''; ?>> Mercredi
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" name="dispos[]" value="jeudi" <?php echo ($donnees['jeudi_dispo']) ? 'checked' : ''; ?>> Jeudi
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" name="dispos[]" value="vendredi" <?php echo ($donnees['vendredi_dispo']) ? 'checked' : ''; ?>> Vendredi
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="mardi_resp1" class="col-md-3 col-form-label">Mardi Resp 1</label>
            <div class="col-md-3">
                <input type="text" class="form-control col-md-6" name="mardi_resp1" id="mardi_resp1" value="<?php echo $donnees['mardi_resp1']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="mardi_resp2" class="col-md-3 col-form-label">Mardi Resp 2</label>
            <div class="col-md-3">
                <input type="text" class="form-control col-md-6" name="mardi_resp2" id="mardi_resp2" value="<?php echo $donnees['mardi_resp2']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="mercredi_resp1" class="col-md-3 col-form-label">Mercredi Resp 1</label>
            <div class="col-md-3">
                <input type="text" class="form-control col-md-6" name="mercredi_resp1" id="mercredi_resp1" value="<?php echo $donnees['mercredi_resp1']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="mercredi_resp2" class="col-md-3 col-form-label">Mercredi Resp 2</label>
            <div class="col-md-3">
                <input type="text" class="form-control col-md-6" name="mercredi_resp2" id="mercredi_resp2" value="<?php echo $donnees['mercredi_resp2']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="jeudi_resp1" class="col-md-3 col-form-label">Jeudi Resp 1</label>
            <div class="col-md-3">
                <input type="text" class="form-control col-md-6" name="jeudi_resp1" id="jeudi_resp1" value="<?php echo $donnees['jeudi_resp1']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="jeudi_resp2" class="col-md-3 col-form-label">Jeudi Resp 2</label>
            <div class="col-md-3">
                <input type="text" class="form-control col-md-6" name="jeudi_resp2" id="jeudi_resp2" value="<?php echo $donnees['jeudi_resp2']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="vendredi_resp1" class="col-md-3 col-form-label">Vendredi Resp 1</label>
            <div class="col-md-3">
                <input type="text" class="form-control col-md-6" name="vendredi_resp1" id="vendredi_resp1" value="<?php echo $donnees['vendredi_resp1']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="vendredi_resp2" class="col-md-3 col-form-label">Vendredi Resp 2</label>
            <div class="col-md-3">
                <input type="text" class="form-control col-md-6" name="vendredi_resp2" id="vendredi_resp2" value="<?php echo $donnees['vendredi_resp2']; ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-10">
                <button type="submit" class="btn btn-default">Sauvegarder</button>
            </div>
        </div>
    </form>

    <script>
    $(function() {
        $( "#mardi_resp1" ).autocomplete({
            source: 'search.php?contexte=resp_activites',
            autoFocus: true
        });
        $( "#mardi_resp2" ).autocomplete({
            source: 'search.php?contexte=resp_activites',
            autoFocus: true
        });
        $( "#mercredi_resp1" ).autocomplete({
            source: 'search.php?contexte=resp_activites',
            autoFocus: true
        });
        $( "#mercredi_resp2" ).autocomplete({
            source: 'search.php?contexte=resp_activites',
            autoFocus: true
        });
        $( "#jeudi_resp1" ).autocomplete({
            source: 'search.php?contexte=resp_activites',
            autoFocus: true
        });
        $( "#jeudi_resp2" ).autocomplete({
            source: 'search.php?contexte=resp_activites',
            autoFocus: true
        });
        $( "#vendredi_resp1" ).autocomplete({
            source: 'search.php?contexte=resp_activites',
            autoFocus: true
        });
        $( "#vendredi_resp2" ).autocomplete({
            source: 'search.php?contexte=resp_activites',
            autoFocus: true
        });
    });
    </script>

<?php
}

else {

    $title = 'Activités';
    require_once 'include/head.php';

    ////////// LISTE DES ACTIVITES //////////

    $donnees = get_activites();

?>

    <h2>Liste des activités</h2>
    <a class="btn btn-default" href="activites.php?action=add" role="button">Ajouter</a>
    <br>

    <h3>Données</h3>

    Nombre de résultats: <?php echo sizeof($donnees); ?>
    <table class="table table-hover">
        <tr>
            <th>Code</th>
            <th>Nom</th>
            <th>Type</th>
            <th>Horaires</th>
            <th>Nb Adultes</th>
            <th>Nb Jeunes</th>
            <th>Dispos</th>
        </tr>
        <?php
            foreach ($donnees as $id_activite => $data) {
                switch ($data['code']) {
                    case 0:
                        $color = 'white';
                        break;
                    case 1:
                        $color = 'black';
                        break;
                    case 2:
                        $color = 'red';
                        break;
                    case 3:
                        $color = 'blue';
                        break;
                    case 4:
                        $color = 'green';
                        break;
                }

                $tmp = array();
                $dispos = '';
                if ($data['mardi_dispo']) {
                    $tmp[] = 'Mardi';
                }
                if ($data['mercredi_dispo']) {
                    $tmp[] = 'Mercredi';
                }
                if ($data['jeudi_dispo']) {
                    $tmp[] = 'Jeudi';
                }
                if ($data['vendredi_dispo']) {
                    $tmp[] = 'Vendredi';
                }

                $i = 0;
                $len = count($tmp);
                foreach ($tmp as $jour) {
                    $dispos .= $jour;
                    if ($i != $len - 1) {
                        $dispos .= ' / ';
                    }
                    ++$i;
                }

                echo '<tr>
                        <td style="background-color: '.$color.'"></td>
                        <td><a href="activites.php?action=edit&id_activite='.$id_activite.'">'.$data['nom'].'</a></td>
                        <td>'.ucfirst($data['type']).'</td>
                        <td>'.$data['horaires'].' (Mercredi: '.$data['horaires_mercredi'].')</td>
                        <td>'.$data['nb_adultes'].'</td>
                        <td>'.$data['nb_jeunes'].'</td>
                        <td>'.$dispos.'</td>
                      </tr>';
            }
        ?>
    </table>

<?php

}

require_once 'include/foot.php';

?>