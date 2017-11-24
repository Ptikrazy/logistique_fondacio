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
                    <?php

                    $camps = get_camps();

                    foreach ($camps as $camp) {
                        echo '<option value="'.$camp['numero'].'">Camp n°'.$camp['numero'].' ('.$camp['regions'].') du '.convert_date($camp['date_debut'], "-", "/").' au '.convert_date($camp['date_fin'], "-", "/").'</option>';
                    }

                    ?>
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
            <label class="col-form-label col-sm-2" for="prepa">Je m'inscris à la "prépa" <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="La prépa aura lieu du samedi précédant le camp à 14h jusqu'au début du camp. Le coût de la prépa est de 55 euros."></label>
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
        </div><br>

        <h4>Transport</h4><br>

        <h5>Aller</h5><br>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="camp">J'arriverai au Mourtis en <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" data-html="true" title="Pour rejoindre le lieu de camp, 3 possibilités: <ul><li>Arriver en voiture</li><li>Venir en train jusqu'à la gare de Montréjeau-Gourdan Polignan, où une navette Fondacio attendra les jeunes pour les conduire sur le lieu de camp</li><li>Prendre le bus organisé par Fondacio</li></ul>"></label>
            <div class="col-sm-3">
                <select class="form-control" name="aller_transport" id="aller_transport" required>
                    <option value="" selected></option>
                    <option value="voiture">Voiture personnelle</option>
                    <option value="train">Train</option>
                    <option value="bus">Bus organisé par Fondacio</option>
                </select>
            </div>
        </div>

        <div class="form-group row" id="aller_voiture">
            <label class="col-form-label col-sm-12">Le camp démarre à 14h, un accueil sera assuré à partir de 13h pour les jeunes arrivant en voiture personnelle.</label>
        </div>

        <div class="form-group row" id="aller_train">
            <label class="col-form-label col-sm-2" for="aller_train">Heure d'arrivée <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="aller_train" id="aller_train11h25" value="11h25"> 11h25 (recommandé)
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="aller_train" id="aller_train14h25" value="11h25"> 14h25 (si impossible à 11h25)
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row" id="aller_bus">
            <label class="col-form-label col-sm-2" for="aller_bus">Ville de départ</label>
            <div class="col-sm-3">
                <select class="form-control" name="aller_bus">
                    <option value="" id="aller_bus_villes" selected></option>
                </select>
            </div>
        </div>

        <h5>Retour</h5><br>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="camp">Je repartirai du Mourtis en <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <select class="form-control" name="retour_transport" id="retour_transport" required>
                    <option value="" selected></option>
                    <option value="voiture">Voiture personnelle</option>
                    <option value="train">Train</option>
                    <option value="bus">Bus organisé par Fondacio</option>
                </select>
            </div>
        </div>

        <div class="form-group row" id="retour_voiture">
            <label class="col-form-label col-sm-12">Le camp termine dans la nuit du samedi au dimanche à 2h du matin. Un accueil sera assuré pour les jeunes repartant en voiture jusqu'au dimanche à 11h du matin.</label>
        </div>

        <div class="form-group row" id="retour_train">
            <label class="col-form-label col-sm-12">Le camp termine dans la nuit du samedi au dimanche à 2h du matin. Nous proposons une navette jusqu'à la gare pour le train de 11h25 le dimanche matin.</label>
        </div>

        <div class="form-group row" id="retour_bus">
            <label class="col-form-label col-sm-2" for="retour_bus">Ville d'arrivée</label>
            <div class="col-sm-3">
                <select class="form-control" name="retour_bus">
                    <option value="" id="retour_bus_villes" selected></option>
                </select>
            </div>
        </div>

        <h4>Paiement</h4>

        <div class="form-group row">
            <label class="col-form-label col-sm-12">Le coût de revient d’un camp (hébergement, restauration, activités, administratif, encadrement) est de 1000 euros. Fondacio France finance 62% du coût du camp par des dons (parrainage, bénévolat, mécénat). Les 38% restants, soit 380 euros, correspondent au prix demandé aux familles. Selon vos possibilités, nous proposons une participation entre 250 et 1000 euros.<br><br>

            A ce coût s'ajoute le prix du transport:<br>
            - Le service de navette que nous proposons de la gare de Montréjeau au Mourtis ajoute 15€ par voyage au coût du camp (donc 30€ si vous arrivez et repartez en train)<br>
            - Le voyage en bus ajoute 80€ par voyage au coût du camp (donc 160€ si vous arrivez et repartez en bus)<br><br>

            Le prix de revient total camp + transport est donc de 380 + x = y euros.<br>
            La fourchette de participation proposée est donc de (250 + x =) z euros à (1000 + x =) w euros.</label>
        </div>

        <h4>Attestation (CE)</h4><br>

        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="attestation_inscription" id="conditions_inscription" value="1"> Je souhaite recevoir pour mon CE une attestation d'inscription, une fois que j'aurais envoyé le dossier d'inscription papier complet
            </label>
        </div>

        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="attestation_presence" id="conditions_inscription" value="1"> Je souhaite recevoir pour mon CE une attestation de présence et de paiement, après le camp
            </label>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="ce_nom">Nom du comité d'entreprise</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="ce_nom" id="ce_nom">
            </div>
            <label class="col-form-label col-sm-2" for="ce_mail">Courriel du comité d'entreprise</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="ce_mail" id="ce_mail">
            </div>
        </div>

        <h4>Conditions d'inscription et d'annulation</h4><br>

        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" id="conditions_inscription" value="" required><span style="color: red">*</span> Je m’engage à envoyer le dossier d’inscription COMPLET avec le règlement dans un délai de 15 jours à compter de la présente pré-inscription sur internet. Fondacio se réserve le droit d’annuler l’inscription du jeune si ce délai n’est pas respecté.
            </label>
        </div>

        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" id="conditions_annulation" value="" required><span style="color: red">*</span> J’accepte les conditions d’annulation suivantes : pour toute annulation intervenant plus d’un mois avant le départ, les sommes payées seront intégralement remboursées par chèque bancaire ; pour toute annulation intervenant entre 7 jours et 30 jours avant le départ, 50% des sommes versées (transport compris) seront remboursées (100% si raison médicale, sur justificatif) ; pour toute annulation intervenant moins de 7 jours avant le départ (sauf raison médicale avec justificatif), l’intégralité des sommes versées est conservée par Fondacio.
            </label>
        </div><br>

        <br>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Valider l'inscription</button>
            </div>
        </div>
    </form>

    <script type="text/javascript">

        $(function() {

            $('#aller_voiture').hide();
            $('#aller_train').hide();
            $('#aller_bus').hide();
            $('#retour_voiture').hide();
            $('#retour_train').hide();
            $('#retour_bus').hide();

            $('#aller_transport').change(function() {
                if (this.value == "voiture") {
                    $('#aller_voiture').show();
                    $('#aller_train').hide();
                    $('#aller_bus').hide();
                }
                if (this.value == "train") {
                    $('#aller_voiture').hide();
                    $('#aller_train').show();
                    $('#aller_bus').hide();
                }
                if (this.value == "bus") {
                    $('#aller_voiture').hide();
                    $('#aller_train').hide();
                    $('#aller_bus').show();

                    $.ajax({
                        type: 'POST',
                        url: '/ajax/villes_bus.php',
                        data: {
                            'camp': $('#camp').find(":selected").val(),
                            'aller_retour': 'aller'
                        },
                        success: function(data){
                            $("#aller_bus_villes").after(data);
                        }
                    });
                }
                if (this.value == "") {
                    $('#aller_voiture').hide();
                    $('#aller_train').hide();
                    $('#aller_bus').hide();
                }
            });

            $('#retour_transport').change(function() {
                if (this.value == "voiture") {
                    $('#retour_voiture').show();
                    $('#retour_train').hide();
                    $('#retour_bus').hide();
                }
                if (this.value == "train") {
                    $('#retour_voiture').hide();
                    $('#retour_train').show();
                    $('#retour_bus').hide();
                }
                if (this.value == "bus") {
                    $('#retour_voiture').hide();
                    $('#retour_train').hide();
                    $('#retour_bus').show();

                    $.ajax({
                        type: 'POST',
                        url: '/ajax/villes_bus.php',
                        data: {
                            'camp': $('#camp').find(":selected").val(),
                            'aller_retour': 'retour'
                        },
                        success: function(data){
                            $("#retour_bus_villes").after(data);
                        }
                    });
                }
                if (this.value == "") {
                    $('#retour_voiture').hide();
                    $('#retour_train').hide();
                    $('#retour_bus').hide();
                }
            });
        });

    </script>

<?php

require_once 'include/foot.php';

?>