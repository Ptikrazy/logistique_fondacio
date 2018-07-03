<?php

require_once 'include/init.php';

$title = 'Remplissage';
require_once 'include/head.php';

if (!empty($_POST)) {

    if (!empty($_POST['parrain']) && !empty($_POST['filleul'])) {
        $parrain = explode(' - ', $_POST['parrain']);
        $filleul = explode(' - ', $_POST['filleul']);
        save_parrainage($parrain[0], $filleul[0]);
    }

    if (!empty($_POST['pg_num']) && !empty($_POST['pg_resp'])) {
        $jeunes = array();
        $pg_resp = explode(' - ', $_POST['pg_resp']);
        $jeunes[] = $pg_resp[1];
        if (!empty($_POST['jeune_1'])) {
            $jeune_1 = explode(' - ', $_POST['jeune_1']);
            $jeunes[] = $jeune_1[1];
        }
        else {
            $jeunes[] = '';
        }
        if (!empty($_POST['jeune_2'])) {
            $jeune_2 = explode(' - ', $_POST['jeune_2']);
            $jeunes[] = $jeune_2[1];
        }
        else {
            $jeunes[] = '';
        }
        if (!empty($_POST['jeune_3'])) {
            $jeune_3 = explode(' - ', $_POST['jeune_3']);
            $jeunes[] = $jeune_3[1];
        }
        else {
            $jeunes[] = '';
        }
        if (!empty($_POST['jeune_4'])) {
            $jeune_4 = explode(' - ', $_POST['jeune_4']);
            $jeunes[] = $jeune_4[1];
        }
        else {
            $jeunes[] = '';
        }
        save_pg($_POST['pg_num'], $jeunes);
    }

    if (!empty($_POST['chambre_num']) && !empty($_POST['chambre_resp'])) {
        $jeunes = array();
        $chambre_resp = explode(' - ', $_POST['chambre_resp']);
        $jeunes[] = $chambre_resp[1];
        if (!empty($_POST['jeune_1'])) {
            $jeune_1 = explode(' - ', $_POST['jeune_1']);
            $jeunes[] = $jeune_1[1];
        }
        else {
            $jeunes[] = '';
        }
        if (!empty($_POST['jeune_2'])) {
            $jeune_2 = explode(' - ', $_POST['jeune_2']);
            $jeunes[] = $jeune_2[1];
        }
        else {
            $jeunes[] = '';
        }
        if (!empty($_POST['jeune_3'])) {
            $jeune_3 = explode(' - ', $_POST['jeune_3']);
            $jeunes[] = $jeune_3[1];
        }
        else {
            $jeunes[] = '';
        }
        if (!empty($_POST['jeune_4'])) {
            $jeune_4 = explode(' - ', $_POST['jeune_4']);
            $jeunes[] = $jeune_4[1];
        }
        else {
            $jeunes[] = '';
        }
        save_chambre($_POST['chambre_num'], $jeunes);
    }

}

?>

<h2>Remplissage</h2>

<form action="" method="GET">
    <div class="form-group row">
        <div class="col-md-3">
            <select class="form-control" name="remplissage">
                <option value='pg' <?php echo (!empty($_GET['remplissage']) && $_GET['remplissage'] == 'pg') ? 'selected' : ''; ?>>Petits groupes</option>
                <option value='chambre' <?php echo (!empty($_GET['remplissage']) && $_GET['remplissage'] == 'chambre') ? 'selected' : ''; ?>>Chambres</option>
                <option value='parrainage' <?php echo (!empty($_GET['remplissage']) && $_GET['remplissage'] == 'parrainage') ? 'selected' : ''; ?>>Parrainages</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Remplir</button>
        </div>
    </div>
</form>

<?php

if (!empty($_GET['remplissage'])) {
    if ($_GET['remplissage'] == 'parrainage') {

?>

        <form action="" method="POST">
            <div class="form-group">
                    <label for="parrain" class="col-md-1 col-form-label">Parrain</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="parrain" id="parrain">
                    </div>
                </div>
                <div class="form-group">
                    <label for="filleul" class="col-md-1 col-form-label">Filleul</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="filleul" id="filleul">
                    </div>
                </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-default">Sauvegarder</button>
                </div>
            </div>
        </form>

        <script>
        $(function() {
            $( "#parrain" ).autocomplete({
                source: 'search.php?contexte=remplissage',
                autoFocus: true
            });
            $( "#filleul" ).autocomplete({
                source: 'search.php?contexte=remplissage',
                autoFocus: true
            });
        });
        </script>

<?php
    }

    if ($_GET['remplissage'] == 'pg') {

?>

        <form action="" method="POST">
            <div class="form-group row">
                <label for="pg_num" class="col-md-1 col-form-label">N° PG</label>
                <div class="col-md-1">
                    <input type="text" class="form-control" name="pg_num" id="pg_num" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="pg_resp" class="col-md-1 col-form-label">Responsable</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="pg_resp" id="pg_resp">
                </div>
            </div>
            <div class="form-group row">
                <label for="jeune_1" class="col-md-1 col-form-label">Jeune 1</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="jeune_1" id="jeune_1">
                </div>
            </div>
            <div class="form-group row">
                <label for="jeune_2" class="col-md-1 col-form-label">Jeune 2</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="jeune_2" id="jeune_2">
                </div>
            </div>
            <div class="form-group row">
                <label for="jeune_3" class="col-md-1 col-form-label">Jeune 3</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="jeune_3" id="jeune_3">
                </div>
            </div>
            <div class="form-group row">
                <label for="jeune_4" class="col-md-1 col-form-label">Jeune 4</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="jeune_4" id="jeune_4">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                </div>
            </div>
        </form>

        <script>
        $(function() {
            $( "#pg_resp" ).autocomplete({
                source: 'ajax/search.php?contexte=remplissage&type=jeune',
                autoFocus: true
            });
            $( "#jeune_1" ).autocomplete({
                source: 'ajax/search.php?contexte=remplissage&type=jeune',
                autoFocus: true
            });
            $( "#jeune_2" ).autocomplete({
                source: 'ajax/search.php?contexte=remplissage&type=jeune',
                autoFocus: true
            });
            $( "#jeune_3" ).autocomplete({
                source: 'ajax/search.php?contexte=remplissage&type=jeune',
                autoFocus: true
            });
            $( "#jeune_4" ).autocomplete({
                source: 'ajax/search.php?contexte=remplissage&type=jeune',
                autoFocus: true
            });
        });
        </script>

<?php
    }

    if ($_GET['remplissage'] == 'chambre') {

?>

        <form action="" method="POST">
            <div class="form-group row">
                <label class="col-form-label col-sm-2" for="type">Type</label>
                <div class="col-sm-2">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="type" value="adulte"> Adulte
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="type" value="jeune"> Jeune
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="chambre_num" class="col-md-2 col-form-label">N° Chambre</label>
                <div class="col-md-1">
                    <input type="text" class="form-control" name="chambre_num" id="chambre_num">
                </div>
            </div>
            <div class="form-group row">
                <label for="chambre_resp" class="col-md-2 col-form-label">Responsable</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="chambre_resp" id="chambre_resp">
                </div>
            </div>
            <div class="form-group row">
                <label for="jeune_1" class="col-md-2 col-form-label">Jeune 1</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="jeune_1" id="jeune_1">
                </div>
            </div>
            <div class="form-group row">
                <label for="jeune_2" class="col-md-2 col-form-label">Jeune 2</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="jeune_2" id="jeune_2">
                </div>
            </div>
            <div class="form-group row">
                <label for="jeune_3" class="col-md-2 col-form-label">Jeune 3</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="jeune_3" id="jeune_3">
                </div>
            </div>
            <div class="form-group row">
                <label for="jeune_4" class="col-md-2 col-form-label">Jeune 4</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="jeune_4" id="jeune_4">
                </div>
            </div>
            <div class="form-group row">
                <label for="jeune_5" class="col-md-2 col-form-label">Jeune 5</label>
                <div class="col-md-5">
                        <input type="text" class="form-control" name="jeune_5" id="jeune_5">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                </div>
            </div>
        </form>

        <script>
        var type;
        $(function() {
            $('input[name=type]').change(function() {
                type = $(this).val();
            });
            $( "#chambre_resp" ).autocomplete({
                source: 'ajax/search.php?contexte=remplissage&type=' + type,
                autoFocus: true
            });
            $( "#jeune_1" ).autocomplete({
                source: 'ajax/search.php?contexte=remplissage&type=' + type,
                autoFocus: true
            });
            $( "#jeune_2" ).autocomplete({
                source: 'ajax/search.php?contexte=remplissage&type=' + type,
                autoFocus: true
            });
            $( "#jeune_3" ).autocomplete({
                source: 'ajax/search.php?contexte=remplissage&type=' + type,
                autoFocus: true
            });
            $( "#jeune_4" ).autocomplete({
                source: 'ajax/search.php?contexte=remplissage&type=' + type,
                autoFocus: true
            });
            $( "#jeune_5" ).autocomplete({
                source: 'ajax/search.php?contexte=remplissage&type=' + type,
                autoFocus: true
            });
        });
        </script>

<?php
    }
}

require_once 'include/foot.php';

?>