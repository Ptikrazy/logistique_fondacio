<?php

require_once 'include/init.php';

$title = 'Inscription';
require_once 'include/head.php';

?>

    <center><h2>Inscription aux camps RSV</h2>Les champs suivis d'un <span style="color: red">*</span> sont obligatoires</center>

    <form action="" method="POST">

        <h4>Infos camp</h4><br>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="camp">Je m'inscris au camp <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <select class="form-control" name="camp" id="camp" required>
                    <option value="" selected></option>
                    <option value="1">Camp 1</option>
                    <option value="2">Camp 2</option>
                    <option value="3">Camp 3</option>
                    <option value="4">Camp 4</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="ancien">J'ai déjà fait un camp "Réussir sa Vie" <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="ancien" id="ancien1" value="1"> Oui
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="ancien" id="ancien0" value="0" required> Non
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="prepa">Je m'inscris à la "prépa" <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="La prépa aura lieu du samedi 15 juillet 2017 à 14h jusqu'au début du camp, le lundi 17 juillet à 14h. Le coût de la prépa est de 55 euros."></label>
            <div class="col-sm-3">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="prepa" id="prepa1" value="1"> Oui
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="prepa" id="prepa0" value="0" required> Non
                    </label>
                </div>
            </div>
        </div><br>

        <h4>Informations du jeune</h4><br>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="civilite">Civilité <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="civilite" id="civiliteF" value="F"> Mme
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="civilite" id="civiliteH" value="H" required> Mr
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="nom_jeune">Nom du jeune <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="nom_jeune" id="nom_jeune" required>
            </div>
            <label class="col-form-label col-sm-2" for="prenom_jeune">Prénom du jeune <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="prenom_jeune" id="prenom_jeune" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="adresse_jeune">Adresse <span style="color: red">*</span></label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="adresse_jeune" id="adresse_jeune" required>
            </div>
            <label class="col-form-label col-sm-2" for="code_postal">Code postal <span style="color: red">*</span></label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="code_postal" id="code_postal" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="ville">Ville <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="ville" id="ville" required>
            </div>
            <label class="col-form-label col-sm-2" for="pays">Pays</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="pays" id="pays">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="tel_portable_jeune">Téléphone portable du jeune <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="A indiquer obligatoirement si le jeune vient en bus ou en train ; si le jeune n'en possède pas, indiquer celui du père ou de la mère"></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="tel_portable_jeune" id="tel_portable_jeune" required>
            </div>
            <label class="col-form-label col-sm-2" for="tel_fixe">Téléphone fixe</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="tel_fixe" id="tel_fixe">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="mail_jeune">Courriel personnel du jeune <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="Cette adresse nous servira à envoyer au jeune un message de bienvenue et d'éventuelles invitations aux futurs évènements."></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="mail_jeune" id="mail_jeune" required>
            </div>
            <label class="col-form-label col-sm-2" for="date_naissance">Date de naissance <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="date" class="form-control" name="date_naissance" id="date_naissance" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="etudes">Études actuelles</label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="etudes" id="etudes4" value="4ème"> 4ème
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="etudes" id="etudes3" value="3ème" required> 3ème
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="etudes" id="etudes2" value="2nde" required> 2nde
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="etudes" id="etudes1" value="1ère" required> 1ère
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="etudes" id="etudesT" value="Terminale" required> Terminale
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="etudes" id="etudesA" value="Autre" required> Autre
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="text" class="form-control" name="etudes_autre" id="etudesAT">
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="taille">Taille (en cms)<span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="La taille et le poids sont des informations qui nous sont indispensables pour l'inscription aux activités sportives (rafting, canyoning)"></label>
            <div class="col-sm-2">
                <input type="number" class="form-control" name="taille" id="taille" required>
            </div>
            <label class="col-form-label col-sm-2" for="poids">Poids (en kgs) <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="La taille et le poids sont des informations qui nous sont indispensables pour l'inscription aux activités sportives (rafting, canyoning)"></label>
            <div class="col-sm-2">
                <input type="number" class="form-control" name="poids" id="poids" required>
            </div>
        </div><br>

        <h4>Coordonnées des parents (ou du responsable légal)</h4><br>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="nom_parents">Nom des parents <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="nom_parents" id="nom_parents" required>
            </div>
            <label class="col-form-label col-sm-2" for="prenom_parents">Prénoms des parents <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="prenom_parents" id="prenom_parents" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="adresse_jeune">Adresse (seulement si différente de celle du jeune)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="adresse_jeune" id="adresse_jeune">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="tel_portable_mere">Téléphone portable de la mère <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="tel_portable_mere" id="tel_portable_mere" required>
            </div>
            <label class="col-form-label col-sm-2" for="tel_portable_pere">Téléphone portable du père</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="tel_portable_pere" id="tel_portable_pere">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="mail_parents">Courriel des parents <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="mail_parents" id="mail_parents" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="observations">Observations</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="observations" id="observations" rows="3"></textarea>
            </div>
        </div>

        <br>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Valider l'inscription</button>
            </div>
        </div>
    </form>

<?php

require_once 'include/foot.php';

?>