<?php

require_once 'include/init.php';

$title = 'Inscription Adultes';
require_once 'include/head.php';

if (!empty($_POST)) {

    enregistrer_inscription_adulte($_POST);

    echo '<br><br>Votre demande d\'inscription au camp Réussir Sa Vie a bien été enregistrée. Un mail de confirmation va vous être envoyé. Attention, il est possible qu\'il arrive dans votre dossier "Spam" ou "Courrier indésirable", pensez à vérifier ce dernier.<br><br>

Pour confirmer l’inscription, merci d\'envoyer le dossier administratif complet, accompagné de votre règlement (chèque à l\'ordre de Fondacio France) à :<br><br>

Fondacio camp RSV<br>
2 rue de l\'Esvière<br>
49100 ANGERS<br><br>

Les éléments du dossier administratif sont téléchargeables <a target="_blank" href="http://www.jeunes.fondacio.fr/camps-reussir-sa-vie/dossier-administratif/">en suivant ce lien</a>.<br>
Si vous souhaitez payer en ligne, <a target="_blank" href="http://www.fondacio.fr/fondacio/spip.php?page=produit&ref=CAMPS_RSV_ADOS&id_article=524">cliquez ici</a>.';

}

else {

?>

    <center><h2>Inscription aux camps RSV</h2>Les champs suivis d'un <span style="color: red">*</span> sont obligatoires<br>Les <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" > indiquent qu'une aide est disponible</center>

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
                        echo '<option value="'.$camp['numero'].'">Camp n°'.$camp['numero'].' ('.$camp['regions'].') du '.convert_date($camp['date_prepa'], "-", "/").' au '.convert_date($camp['date_fin'], "-", "/").'</option>';
                    }

                    ?>
                </select>
            </div>
        </div>

        <h4>Infos adulte</h4><br>

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
                        <input class="form-check-input" type="radio" name="civilite" id="civiliteH" value="H" required> M.
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="nom">Nom <span style="color: red">*</span></label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="nom" id="nom" required>
            </div>
            <label class="col-form-label col-sm-2" for="nom_usage">Nom d'usage</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="nom_usage" id="nom_usage">
            </div>
            <label class="col-form-label col-sm-2" for="prenom">Prénom <span style="color: red">*</span></label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="prenom" id="prenom" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="adresse">Adresse <span style="color: red">*</span></label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="adresse" id="adresse" required>
            </div>
            <label class="col-form-label col-sm-2" for="cp">Code postal <span style="color: red">*</span></label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="cp" id="cp" required>
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
            <label class="col-form-label col-sm-2" for="tel_portable">Téléphone portable <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="tel_portable" id="tel_portable" required>
            </div>
            <label class="col-form-label col-sm-2" for="tel_fixe">Téléphone fixe</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="tel_fixe" id="tel_fixe">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="mail">Courriel <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="mail" id="mail" required>
            </div>
            <label class="col-form-label col-sm-2" for="date_naissance">Date de naissance <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="date" class="form-control" name="date_naissance" id="date_naissance" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="lieu_naissance">Lieu de naissance <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="lieu_naissance" id="lieu_naissance" required>
            </div>
            <label class="col-form-label col-sm-2" for="profession">Profession <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="profession" id="profession" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="allergies">Allergies ou intolérances</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="allergies" id="allergies" rows="3"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="permis">Ai-je le permis B? <span style="color: red">*</span></label>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="permis" id="permisO" value="1"> Oui
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="permis" id="permisN" value="0" required> Non
                    </label>
                </div>
            </div>
            <label class="col-form-label col-sm-6" for="ok_conduire">J'ai au moins 23 ans, je possède le permis de conduire depuis plus de 3 ans et je me sens capable de conduire en montagne un des véhicules de Fondacio, notamment pour transporter des jeunes <span style="color: red">*</span></label>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="ok_conduire" id="ok_conduireO" value="1"> Oui
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="ok_conduire" id="ok_conduireN" value="0"> Non
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="permis">Je possède un ou plusieurs diplôme(s)</label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="permis" id="permisO" value="1"> Oui
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="permis" id="permisN" value="0"> Non
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="stagiaire">Je suis</label>
            <div class="col-sm-3">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="stagiaire" id="stagiaireBAFA" value="BAFA"> Stagiaire BAFA
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="stagiaire" id="stagiaireBAFD" value="BAFD"> Stagiaire BAFD
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="appele_par">J'ai été appelé par <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="appele_par" id="appele_par" required>
            </div>
        </div>

        <h5>WE de formation</h5>

        <div class="form-group row">
            <label class="col-form-label col-sm-12">
                Un week-end de formation aura lieu du vendredi 25 au dimanche 27 mai 2018, à l’Ermitage à Versailles.<br>
                Nous avons à cœur que chaque adulte venant sur un camp puisse avoir les outils nécessaires à l’encadrement de mineurs, et aussi, que ce week-end soit l’opportunité de rencontrer une majorité des personnes avec lesquelles vous serez dans cette aventure !<br>
                Nous souhaitons que toutes les personnes soient présentes qu’elles aient déjà été dans des équipes d’encadrement ou non (salariés, bénévoles, services civiques, …)
            </label>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="we_formation">Je serai présent au WE de formation <span style="color: red">*</span></label>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="we_formation" id="we_formationO" value="1"> Oui
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="we_formation" id="we_formationN" value="0" required> Non
                    </label>
                </div>
            </div>
            <label class="col-form-label col-sm-2" for="we_formation_refus">Si non, pourquoi ?</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="we_formation_refus" id="we_formation_refus">
            </div>
        </div>

        <h4>Coordonnées à contacter en cas d'urgence</h4><br>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="urgence_nom">Nom <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="urgence_nom" id="urgence_nom" required>
            </div>
            <label class="col-form-label col-sm-3" for="urgence_prenom">Prénom <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="urgence_prenom" id="urgence_prenom" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="urgence_portable">Téléphone portable <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="urgence_portable" id="urgence_portable" required>
            </div>
            <label class="col-form-label col-sm-3" for="urgence_lien">Lien avec la personne <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="urgence_lien" id="urgence_lien" required>
            </div>
        </div>

        <h4>Transport</h4><br>

        <h5>Aller</h5><br>

        <div class="form-group row">
            <label class="col-form-label col-sm-3" for="aller_transport">J'arriverai au Mourtis en <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" data-html="true" title="Pour rejoindre le lieu de camp, 3 possibilités: <ul><li>Arriver en voiture</li><li>Venir en train jusqu'à la gare de Montréjeau-Gourdan Polignan, où une navette Fondacio attendra les jeunes pour les conduire sur le lieu de camp</li><li>Prendre le bus organisé par Fondacio</li></ul>"></label>
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
            <label class="col-form-label col-sm-2" for="aller_train">Heure d'arrivée <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" data-html="true" title="Si impossible d'arriver à ces horaires, voir avec le responsable de camp</li></ul>"></label>
            <div class="col-sm-3">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="aller_train" id="aller_train11h25" value="11h25"> 11h25 (recommandé)
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="aller_train" id="aller_train14h25" value="14h25"> 14h25 (si impossible à 11h25)
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row" id="aller_bus">
            <label class="col-form-label col-sm-2" for="aller_bus">Ville de départ <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <select class="form-control" name="aller_bus" id="aller_bus_clear">
                    <option value="" id="aller_bus_villes" selected></option>
                </select>
            </div>
        </div>

        <h5>Retour</h5><br>

        <div class="form-group row">
            <label class="col-form-label col-sm-3" for="retour_transport">Je repartirai du Mourtis en <span style="color: red">*</span></label>
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
            <label class="col-form-label col-sm-12">Le camp termine dans la nuit du samedi au dimanche à 2h du matin. Vous pouvez repartir en voiture jusqu'au dimanche à 11h du matin.</label>
        </div>

        <div class="form-group row" id="retour_train">
            <label class="col-form-label col-sm-12">Le camp termine dans la nuit du samedi au dimanche à 2h du matin. Nous proposons une navette jusqu'à la gare pour le train de 11h25 le dimanche matin.</label>
        </div>

        <div class="form-group row" id="retour_bus">
            <label class="col-form-label col-sm-2" for="retour_bus">Ville d'arrivée <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <select class="form-control" name="retour_bus" id="retour_bus_clear">
                    <option value="" id="retour_bus_villes" selected></option>
                </select>
            </div>
        </div>

        <h4>Paiement</h4>

        <div class="form-group row">
            <label class="col-form-label col-sm-12">Le coût de revient d’un camp (hébergement, restauration, activités, administratif, encadrement) est de <b>1 100 euros</b>. Fondacio France finance 62% du coût du camp par des dons (parrainage, bénévolat, mécénat). Les 38% restants, soit <b>420 euros</b>, correspondent au prix demandé aux familles. Selon vos possibilités, nous proposons une participation entre <b style="color: red">270 et 1 100 euros.</b><br><br>

            A ce coût s'ajoute le prix du transport:<br>
            - Le service de navette que nous proposons de la gare de Montréjeau au Mourtis ajoute <b style="color: green">20€ par voyage</b> au coût du camp (donc 40€ si vous arrivez et repartez en train)<br>
            - Le voyage en bus ajoute <b style="color: green">75€ par voyage</b> au coût du camp (donc 150€ si vous arrivez et repartez en bus)<br><br>

            Le coût de revient de la <b>prépa</b> (<b style="color: blue">60€</b>) est également ajouté.<br><br>

            Le prix de revient total camp + transport est donc de <b>420 + <span class="cout_transport" style="color: green"></span> + <span style="color: blue">60</span> = <span id="cout_revient" style="color: red"></span> euros.</b><br>
            La fourchette de participation proposée est donc de <b>(270 + <span class="cout_transport" style="color: green"></span> + <span style="color: blue">60</span> =) <span id="cout_fourchette_basse" style="color: red"></span> euros à (1 100 + <span class="cout_transport" style="color: green"></span> + <span style="color: blue">60</span> =) <span id="cout_fourchette_haute" style="color: red"></span> euros.</b></label>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-4" for="paiement_declare">Je choisis de payer le montant suivant <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="Notez bien ce montant, il vous sera redemandé au moment du paiement."></label>
            <div class="col-sm-3">
                <input type="number" class="form-control" name="paiement_declare" id="paiement_declare" required>
            </div>
        </div>

        <h5>Modalités de paiement</h5>

        <div class="form-group row">
            <label class="col-form-label col-sm-12">Vous pouvez régler la totalité de la somme due (camp + transport éventuel) par chèque (à l'ordre de Fondacio France), par CB en ligne (paiement sécurisé) ou en Chèques Vacances.<br><br>

            Si vous payez par chèque, vous pouvez échelonner vos paiements sur plusieurs mois (au plus tard octobre 2018), en indiquant au dos de chaque chèque la date (fin de mois) d'encaissement souhaitée.<br><br>

            Le camp "Réussir Sa Vie" est agréé Jeunesse et Sports, et nous acceptons les Aides aux Vacances Enfants de la CAF (dispositif AVE), sous réserve d’une inscription avant le 30 avril 2018. Si tel est le cas, vous devez nous envoyer 2 chèques (ou plus) : l'un correspondant au montant théorique que devra nous verser la CAF (si celle-ci règle directement Fondacio et non la famille) que nous garderons en caution, l'autre (ou les autres) correspondant au solde à régler (montant total dû - participation attendue de la CAF), que nous encaisserons à réception (ou à la date d'encaissement indiquée au dos du chèque).<br><br>

            N’hésitez pas à vérifier si vous pouvez bénéficier d’aides auprès de certains organismes (Conseil Général, CAF, CE, Mairie,...) et à contacter votre Caisse d’Allocations Familiales pour vérifier si elle attribue des aides aux vacances pour les centres de vacances.</label>
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
        </div><br><br>

        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Valider l'inscription</button>
            </div>
        </div>
    </form>

    <script type="text/javascript">

        $(function() {

            // Initialisation variable pour le coût

            var cout_transport = 0;
            var cout_transport_aller = 0;
            var cout_transport_retour = 0;

            // Gestion des transports

            $('#aller_voiture').hide();
            $('#aller_train').hide();
            $('#aller_bus').hide();
            $('#retour_voiture').hide();
            $('#retour_train').hide();
            $('#retour_bus').hide();

            $('#aller_transport').change(function() {
                if (this.value == "voiture") {
                    $('#aller_bus_clear option').remove();
                    $('#aller_bus_clear').append('<option value="" id="aller_bus_villes" selected></option>');
                    $('#aller_voiture').show();
                    $('#aller_train').hide();
                    $('#aller_bus').hide();
                    cout_transport_aller = 0;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('#cout_revient').text(cout_transport+60+420);
                    $('#cout_fourchette_basse').text(cout_transport+60+270);
                    $('#cout_fourchette_haute').text(cout_transport+60+1100);
                }
                if (this.value == "train") {
                    $('#aller_bus_clear option').remove();
                    $('#aller_bus_clear').append('<option value="" id="aller_bus_villes" selected></option>');
                    $('#aller_voiture').hide();
                    $('#aller_train').show();
                    $('#aller_bus').hide();
                    cout_transport_aller = 20;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('#cout_revient').text(cout_transport+60+420);
                    $('#cout_fourchette_basse').text(cout_transport+60+270);
                    $('#cout_fourchette_haute').text(cout_transport+60+1100);
                }
                if (this.value == "bus") {
                    $('#aller_voiture').hide();
                    $('#aller_train').hide();
                    $('#aller_bus').show();
                    cout_transport_aller = 75;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('#cout_revient').text(cout_transport+60+420);
                    $('#cout_fourchette_basse').text(cout_transport+60+270);
                    $('#cout_fourchette_haute').text(cout_transport+60+1100);

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
                    cout_transport_aller = 0;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('#cout_revient').text(cout_transport+60+420);
                    $('#cout_fourchette_basse').text(cout_transport+60+270);
                    $('#cout_fourchette_haute').text(cout_transport+60+1100);
                }
            });

            $('#retour_transport').change(function() {
                if (this.value == "voiture") {
                    $('#retour_bus_clear option').remove();
                    $('#retour_bus_clear').append('<option value="" id="retour_bus_villes" selected></option>');
                    $('#retour_voiture').show();
                    $('#retour_train').hide();
                    $('#retour_bus').hide();
                    cout_transport_retour = 0;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('#cout_revient').text(cout_transport+60+420);
                    $('#cout_fourchette_basse').text(cout_transport+60+270);
                    $('#cout_fourchette_haute').text(cout_transport+60+1100);
                }
                if (this.value == "train") {
                    $('#retour_bus_clear option').remove();
                    $('#retour_bus_clear').append('<option value="" id="retour_bus_villes" selected></option>');
                    $('#retour_voiture').hide();
                    $('#retour_train').show();
                    $('#retour_bus').hide();
                    cout_transport_retour = 20;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('#cout_revient').text(cout_transport+60+420);
                    $('#cout_fourchette_basse').text(cout_transport+60+270);
                    $('#cout_fourchette_haute').text(cout_transport+60+1100);
                }
                if (this.value == "bus") {
                    $('#retour_voiture').hide();
                    $('#retour_train').hide();
                    $('#retour_bus').show();
                    cout_transport_retour = 75;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('#cout_revient').text(cout_transport+60+420);
                    $('#cout_fourchette_basse').text(cout_transport+60+270);
                    $('#cout_fourchette_haute').text(cout_transport+60+1100);

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
                    cout_transport_retour = 0;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('#cout_revient').text(cout_transport+60+420);
                    $('#cout_fourchette_basse').text(cout_transport+60+270);
                    $('#cout_fourchette_haute').text(cout_transport+60+1100);
                }
            });

            // Calcul du coût

            $('.cout_transport').text(cout_transport);
            $('#cout_revient').text(cout_transport+60+420);
            $('#cout_fourchette_basse').text(cout_transport+60+270);
            $('#cout_fourchette_haute').text(cout_transport+60+1100);

        });

    </script>

<?php

}

require_once 'include/foot.php';

?>