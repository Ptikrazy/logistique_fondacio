<?php

require_once 'include/init.php';

$title = 'Inscription';
require_once 'include/head.php';

if (!empty($_POST)) {

    enregistrer_inscription($_POST);

    echo '<br><br>Merci, un email de confirmation contenant les informations nécessaires va vous être envoyé.';

}

else {

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
            <label class="col-form-label col-sm-2" for="prepa">Je m'inscris à la prépa <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="La prépa aura lieu du samedi précédant le camp à 14h jusqu'au début du camp. Le coût de la prépa est de 55 euros."></label>
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
            <label class="col-form-label col-sm-2" for="jeune_nom">Nom du jeune <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="jeune_nom" id="jeune_nom" required>
            </div>
            <label class="col-form-label col-sm-2" for="jeune_prenom">Prénom du jeune <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="jeune_prenom" id="jeune_prenom" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="jeune_adresse">Adresse <span style="color: red">*</span></label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="jeune_adresse" id="jeune_adresse" required>
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
            <label class="col-form-label col-sm-2" for="jeune_tel_portable">Téléphone portable du jeune <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="A indiquer obligatoirement si le jeune vient en bus ou en train ; si le jeune n'en possède pas, indiquer celui du père ou de la mère"></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="jeune_tel_portable" id="jeune_tel_portable" required>
            </div>
            <label class="col-form-label col-sm-2" for="tel_fixe">Téléphone fixe</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="tel_fixe" id="tel_fixe">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="jeune_mail">Courriel personnel du jeune <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="Cette adresse nous servira à envoyer au jeune un message de bienvenue et d'éventuelles invitations aux futurs évènements."></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="jeune_mail" id="jeune_mail" required>
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
                        <input class="form-check-input" type="radio" name="etudes" id="etudes3" value="3ème"> 3ème
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="etudes" id="etudes2" value="2nde"> 2nde
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="etudes" id="etudes1" value="1ère"> 1ère
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="etudes" id="etudesT" value="Terminale"> Terminale
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="etudes" id="etudesA" value="Autre"> Autre
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
            <label class="col-form-label col-sm-2" for="parents_nom">Nom des parents <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="parents_nom" id="parents_nom" required>
            </div>
            <label class="col-form-label col-sm-2" for="parents_prenom">Prénoms des parents <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="parents_prenom" id="parents_prenom" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="parents_adresse">Adresse (seulement si différente de celle du jeune)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="parents_adresse" id="parents_adresse">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="mere_tel_portable">Téléphone portable de la mère <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="mere_tel_portable" id="mere_tel_portable" required>
            </div>
            <label class="col-form-label col-sm-2" for="pere_tel_portable">Téléphone portable du père</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="pere_tel_portable" id="pere_tel_portable">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="parents_mail">Courriel des parents <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="parents_mail" id="parents_mail" required>
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
            <label class="col-form-label col-sm-2" for="aller_bus">Ville de départ <span style="color: red">*</span></label>
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
            <label class="col-form-label col-sm-2" for="retour_bus">Ville d'arrivée <span style="color: red">*</span></label>
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

            Si vous décidez de participer à la prépa, son coût de revient (55€) sera également ajouté.<br><br>

            Le prix de revient total camp + transport est donc de 380 + <span class="cout_transport"></span> = <span id="cout_revient"></span> euros.<br>
            La fourchette de participation proposée est donc de (250 + <span class="cout_transport"></span> + <span class="cout_prepa"></span> =) <span id="cout_fourchette_basse"></span> euros à (1000 + <span class="cout_transport"></span> + <span class="cout_prepa"></span> =) <span id="cout_fourchette_haute"></span> euros.</label>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-4" for="paiement_declare">Je choisis de payer le montant suivant <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="Notez bien ce montant, il vous sera redemandé au moment du paiement.."></label>
            <div class="col-sm-3">
                <input type="number" class="form-control" name="paiement_declare" id="paiement_declare" required>
            </div>
        </div>

        <h5>Modalités de paiement</h5>

        <div class="form-group row">
            <label class="col-form-label col-sm-12">Vous pouvez régler la totalité de la somme due (camp + transport éventuel) par chèque (à l'ordre de Fondacio France), par CB en ligne (paiement sécurisé) ou en Chèques Vacances.<br><br>

            Si vous payez par chèque, vous pouvez échelonner vos paiements sur plusieurs mois (au plus tard octobre 2018), en indiquant au dos de chaque chèque la date (fin de mois) d'encaissement souhaitée.<br><br>

            Le camp "Réussir sa vie" est agréé Jeunesse et Sports, et nous acceptons les Aides aux Vacances Enfants de la CAF (dispositif AVE), sous réserve d’une inscription avant le 30 avril 2018. Si tel est le cas, vous devez nous envoyer 2 chèques (ou plus) : l'un correspondant au montant théorique que devra nous verser la CAF (si celle-ci règle directement Fondacio et non la famille) que nous garderons en caution, l'autre (ou les autres) correspondant au solde à régler (montant total dû - participation attendue de la CAF), que nous encaisserons à réception (ou à la date d'encaissement indiquée au dos du chèque).<br><br>

            N’hésitez pas à vérifier si vous pouvez bénéficier d’aides auprès de certains organismes (Conseil Général, CAF, CE, Mairie,...) et à contacter votre Caisse d’Allocations Familiales pour vérifier si elle attribue des aides aux vacances pour les centres de vacances.</label>
        </div>

        <h5>Bourses</h5>

        <div class="form-group row">
            <label class="col-form-label col-sm-12">Nous tenons à ce qu’aucune difficulté financière ne soit un obstacle à la participation d’un jeune. Si votre situation familiale ne vous permet pas de payer le montant minimum indiqué ci-dessus, vous pouvez demander une bourse auprès du Directeur du Camp en remplissant le formulaire de demande de bourse, accessible depuis la page où se trouve le dossier administratif. Une réponse vous sera apportée dans les plus brefs délais.</label>
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

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="ce_adresse">Adresse complète du comité d'entreprise</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="ce_adresse" id="ce_adresse">
            </div>
        </div>

        <h4>Communication</h4><br>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="camp">J'ai connu ce camp par <span style="color: red">*</span></label>
            <div class="col-sm-6">
                <select class="form-control" name="communication" id="communication" required>
                    <option value="" selected></option>
                    <option value="Une annonce dans la presse">Une annonce dans la presse (précisez le nom du media dans la zone "Autre")</option>
                    <option value="Le site Internet de Fondacio France">Le site Internet de Fondacio France</option>
                    <option value="Ma famille ou des amis de mes parents">Ma famille ou des amis de mes parents</option>
                    <option value="Un(e) ami(e) m'en a parlé">Un(e) ami(e) m'en a parlé</option>
                    <option value="Le catalogue Fondacio Jeunes">Le catalogue Fondacio Jeunes</option>
                    <option value="Un flyer reçu ou trouvé">Un flyer reçu ou trouvé</option>
                    <option value="Facebook">Facebook</option>
                    <option value="J'ai déjà fait un camp Réussir sa Vie">J'ai déjà fait un camp Réussir sa Vie</option>
                    <option value="Autre">Autre (précisez dans la zone "Autre")</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="communication_autre">Autre</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="communication_autre" id="communication_autre">
            </div>
        </div><br>

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
            var cout_prepa = 0;
            var cout_transport_aller = 0;
            var cout_transport_retour = 0;

            // Gestion cout prepa

            $('input[type=radio][name=prepa]').change(function() {
                if (this.value == 1) {
                    cout_prepa = 55;
                }
                else {
                    cout_prepa = 0;
                }
                $('.cout_transport').text(cout_transport);
                $('.cout_prepa').text(cout_prepa);
                $('#cout_revient').text(cout_transport+cout_prepa+380);
                $('#cout_fourchette_basse').text(cout_transport+cout_prepa+250);
                $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1000);
            });

            // Gestion des transports

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
                    cout_transport_aller = 15;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('.cout_prepa').text(cout_prepa);
                    $('#cout_revient').text(cout_transport+cout_prepa+380);
                    $('#cout_fourchette_basse').text(cout_transport+cout_prepa+250);
                    $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1000);
                }
                if (this.value == "bus") {
                    $('#aller_voiture').hide();
                    $('#aller_train').hide();
                    $('#aller_bus').show();
                    cout_transport_aller = 80;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('.cout_prepa').text(cout_prepa);
                    $('#cout_revient').text(cout_transport+cout_prepa+380);
                    $('#cout_fourchette_basse').text(cout_transport+cout_prepa+250);
                    $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1000);

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
                    $('.cout_prepa').text(cout_prepa);
                    $('#cout_revient').text(cout_transport+cout_prepa+380);
                    $('#cout_fourchette_basse').text(cout_transport+cout_prepa+250);
                    $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1000);
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
                    cout_transport_retour = 15;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('.cout_prepa').text(cout_prepa);
                    $('#cout_revient').text(cout_transport+cout_prepa+380);
                    $('#cout_fourchette_basse').text(cout_transport+cout_prepa+250);
                    $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1000);
                }
                if (this.value == "bus") {
                    $('#retour_voiture').hide();
                    $('#retour_train').hide();
                    $('#retour_bus').show();
                    cout_transport_retour = 80;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('.cout_prepa').text(cout_prepa);
                    $('#cout_revient').text(cout_transport+cout_prepa+380);
                    $('#cout_fourchette_basse').text(cout_transport+cout_prepa+250);
                    $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1000);

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
                    $('.cout_prepa').text(cout_prepa);
                    $('#cout_revient').text(cout_transport+cout_prepa+380);
                    $('#cout_fourchette_basse').text(cout_transport+cout_prepa+250);
                    $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1000);
                }
            });

            // Calcul du coût

            $('.cout_transport').text(cout_transport);
            $('.cout_prepa').text(cout_prepa);
            $('#cout_revient').text(cout_transport+cout_prepa+380);
            $('#cout_fourchette_basse').text(cout_transport+cout_prepa+250);
            $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1000);
        });

    </script>

<?php

}

require_once 'include/foot.php';

?>