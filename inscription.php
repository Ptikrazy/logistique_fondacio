<?php

require_once 'include/init.php';

$title = 'Inscription';
require_once 'include/head.php';

?>

    <center><h2>Inscription au camp RSV</h2><br></center>

    <form action="" method="POST">

        <h4>Infos camp</h4><br>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="camp">Je m'inscris au camp</label>
            <div class="col-sm-3">
                <select class="form-control" name="camp" id="camp" required>
                    <option value="" selected></option>
                    <option value="1">Camp 1</option>
                    <option value="2">Camp 2</option>
                    <option value="3">Camp 3</option>
                    <option value="4">Camp 4</option>
                </select>
            </div>
        </div><br>

        <h4>Informations du jeune</h4><br>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="civilite">Civilité</label>
            <div class="col-sm-3">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="civilite" id="civiliteF" value="F"> Mme
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="civilite" id="civiliteH" value="H" required> Mr
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="nom_jeune">Nom du jeune</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="nom_jeune" id="nom_jeune" required>
            </div>
            <label class="col-form-label col-sm-2" for="prenom_jeune">Prénom du jeune</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="prenom_jeune" id="prenom_jeune" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="adresse_jeune">Adresse</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="adresse_jeune" id="adresse_jeune" required>
            </div>
            <label class="col-form-label col-sm-2" for="code_postal">Code postal</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="code_postal" id="code_postal" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="ville">Ville</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="ville" id="ville" required>
            </div>
            <label class="col-form-label col-sm-2" for="pays">Pays</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="pays" id="pays">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="tel_fixe">Téléphone fixe</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="tel_fixe" id="tel_fixe">
            </div>
            <label class="col-form-label col-sm-2" for="tel_portable_jeune">Téléphone portable du jeune</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="tel_portable_jeune" id="tel_portable_jeune" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="mail_jeune">Courriel du jeune</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="mail_jeune" id="mail_jeune" required>
            </div>
            <label class="col-form-label col-sm-2" for="date_naissance">Date de naissance</label>
            <div class="col-sm-3">
                <input type="date" class="form-control" name="date_naissance" id="date_naissance" required>
            </div>
        </div>


        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Valider l'inscription</button>
            </div>
        </div>
    </form>

<?php

require_once 'include/foot.php';

?>