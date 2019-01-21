<?php

require_once 'include/init.php';

$title = 'Inscription';
require_once 'include/head.php';

if (!empty($_POST)) {

    if ($_POST['date_naissance'] > "2005-12-31") {
        echo 'Le camp est réservé aux jeunes qui auront au moins 14 ans lors du début du camp, votre inscription n\'a donc pas été enregistrée. Pour toute question, contactez-nous par mail: jeunes.camps@fondacio.fr';
    }

    else {

        enregistrer_inscription_jeune($_POST);

        echo '<br><br>Votre demande d\'inscription au camp Réussir Sa Vie a bien été enregistrée. Un mail de confirmation va vous être envoyé. Attention, il est possible qu\'il arrive dans votre dossier "Spam" ou "Courrier indésirable", pensez à vérifier ce dernier.<br><br>

    Pour confirmer l’inscription, merci d\'envoyer le dossier administratif complet, accompagné de votre règlement (chèque à l\'ordre de Fondacio France) à :<br><br>

    Fondacio camp RSV<br>
    2 rue de l\'Esvière<br>
    49100 ANGERS<br><br>

    Les éléments du dossier administratif sont téléchargeables <a target="_blank" href="http://www.jeunes.fondacio.fr/camps-reussir-sa-vie/dossier-administratif/">en suivant ce lien</a>.<br>
    Si vous souhaitez payer en ligne, <a target="_blank" href="http://www.fondacio.fr/fondacio/spip.php?page=produit&ref=CAMPS_RSV_ADOS&id_article=524">cliquez ici</a>.';
    }

}

else {

?>

    <center><h2>Inscription aux camps Réussir Sa Vie</h2>Les champs suivis d'un <span style="color: red">*</span> sont obligatoires<br>Les <img src="include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" > indiquent qu'une aide est disponible</center>

    <form action="" method="POST">

        <h4>Infos camp</h4><br>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="camp">Je m'inscris au camp <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <select class="form-control" name="camp" id="camp" required>
                    <option value="" selected></option>
                    <?php

                    $camps = get_camps(1);

                    foreach ($camps as $camp) {
                        echo '<option value="'.$camp['numero'].'">Camp n°'.$camp['numero'].' ('.$camp['regions'].') du '.convert_date($camp['date_debut'], "-", "/").' au '.convert_date($camp['date_fin'], "-", "/").'</option>';
                    }

                    ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="ancien">J'ai déjà fait un camp "Réussir Sa Vie" <span style="color: red">*</span></label>
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

        <div class="form-group row" id="prepa">
            <label class="col-form-label col-sm-2" for="prepa">Je m'inscris à la prépa <span style="color: red">*</span> <img src="include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="La prépa aura lieu du samedi précédant le camp à 14h jusqu'au début du camp. Le coût de la prépa est de 60 euros."></label>
            <div class="col-sm-3">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="prepa" id="prepa1" value="1"> Oui
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="prepa" id="prepa0" value="0"> Non
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
                        <input class="form-check-input" type="radio" name="civilite" id="civiliteH" value="H" required> M.
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
            <label class="col-form-label col-sm-2" for="jeune_tel_portable_radio" id="jeune_tel_portable_libelle">Téléphone portable du jeune</label>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="jeune_tel_portable_radio" id="jeune_tel_portable1" value="1"> Oui
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="jeune_tel_portable_radio" id="jeune_tel_portable0" value="0"> Non
                    </label>
                </div>
            </div>
            <div class="col-sm-3" id="jeune_tel_portable_id">
                <input type="text" class="form-control" name="jeune_tel_portable" id="jeune_tel_portable">
            </div>
            <label class="col-form-label col-sm-2" for="tel_fixe">Téléphone fixe</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="tel_fixe" id="tel_fixe">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="jeune_mail">Courriel personnel du jeune <span style="color: red">*</span> <img src="include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="Cette adresse nous servira à envoyer au jeune un message de bienvenue et d'éventuelles invitations aux futurs évènements."></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="jeune_mail" id="jeune_mail" required>
            </div>
            <label class="col-form-label col-sm-2" for="date_naissance">Date de naissance <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <input type="date" class="form-control" name="date_naissance" id="date_naissance" required><span style="font-size: 12px; color: red" id="date_naissance_alerte"></span>
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
            <label class="col-form-label col-sm-2" for="taille">Taille (en cm)<span style="color: red">*</span> <img src="include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="La taille et le poids sont des informations qui nous sont indispensables pour l'inscription aux activités sportives (rafting, canyoning)"></label>
            <div class="col-sm-2">
                <input type="number" class="form-control" name="taille" id="taille" required>
            </div>
            <label class="col-form-label col-sm-2" for="poids">Poids (en kg) <span style="color: red">*</span> <img src="include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="La taille et le poids sont des informations qui nous sont indispensables pour l'inscription aux activités sportives (rafting, canyoning)"></label>
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
            <label class="col-form-label col-sm-2" for="parents_mail2">Courriel secondaire</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="parents_mail2" id="parents_mail2">
            </div>
        </div>

        Observations / Informations que nous devrions connaître (Indiquez ici ce que vous souhaitez nous signaler pour que nous puissions accueillir votre enfant au mieux. Vous pouvez nous y donner des informations médicales, nous faire part d’éventuelles difficultés psychologiques, relationnelles ou émotionnelles. Il n’y a pas de risque que nous refusions l’inscription de votre enfant, cela nous aidera simplement à l’accompagner d’une manière plus ajustée et à prendre soin de lui pour que chacun vive le camp au mieux. Merci d’avance de votre confiance ! Vous pouvez également envoyer un mail à jeunes.camps@fondacio.fr Seuls le service inscriptions, les responsables et directeurs ainsi que l’assistant sanitaire auront accès à ces informations.)<br><br>

        <div class="form-group row">
            <div class="col-sm-7">
                <textarea class="form-control" name="observations" id="observations" rows="3"></textarea>
            </div>
        </div><br>

        <h4>Transport</h4><br>

        <h5>Aller</h5><br>

        Il y a trois façons d'arriver au Mourtis:<br><br>

        – <b>En bus</b> : des bus sont organisés pour chacun des camps : en fonction de la région attribuée à la semaine, ils desserviront plusieurs grandes villes en France (Lille, Paris, Versailles, Brive, Toulouse, Lyon, Marseille, Montpellier, Valence, Nantes, Angers, Poitiers, Bordeaux, …). Il faut compter 150 € l’aller-retour, soit 75€ par trajet. Le nombre de places est limité (si le choix n'apparait pas, c'est que le bus est plein).<br><br>

        – <b>En train</b> : la gare la plus proche est Montréjeau-Gourdan-Polignan. Un service de navette Fondacio sera mis en place entre la gare et le lieu du camp à l’aller et au retour : il faut compter 40€ pour l’aller-retour, soit 20€ par trajet. A l’aller, navettes à 11h30 ou 14h30 (si impossible à 11h30). Au retour, arrivée des navettes à la gare à 11h maximum (une ou plusieurs navettes en fonction des horaires de départ des différents trains). En fonction du remplissage des navettes, il est possible qu’il y ait de l’attente en gare de Montréjeau-Gourdan-Pollignan. Si vous rencontrez un problème avec les horaires de train ou souhaitez avoir plus d’informations sur la navette, merci de nous contacter par mail.<br><br>

        – <b>En voiture</b> : directement sur le lieu du camp entre 12h30 et 13h le lundi avec un pique-nique (de même pour la prépa le samedi précédent). L’accueil pour le départ le dimanche est assuré jusqu’à 11h.<br><br>

        <div class="form-group row">
            <label class="col-form-label col-sm-3" for="aller_transport">J'arriverai au Mourtis en <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <select class="form-control" name="aller_transport" id="aller_transport" required>
                    <option value="" selected></option>
                    <option value="voiture">Voiture personnelle</option>
                    <option value="train">Train</option>
                    <option value="bus" id="transport_aller_bus">Bus organisé par Fondacio</option>
                </select>
            </div>
        </div>

        <div class="form-group row" id="aller_train">
            <label class="col-form-label col-sm-3" for="aller_train_value">Heure d'arrivée du train <img src="include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="Si je n'ai pas encore mon horaire de train, je m'engage à l'envoyer dès que je l'ai à jeunes.camps@fondacio.fr"></label>
            <div class="col-sm-3">
                <input type="time" class="form-control" name="aller_train_value" id="aller_train_value"> (La navette sera celle de <span id="aller_train_navette"></span>)
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
            <label class="col-form-label col-sm-12">Le camp termine dans la nuit du samedi au dimanche à 2h du matin. Un accueil sera assuré pour les jeunes repartant en voiture jusqu'au dimanche à 11h du matin.</label>
        </div>

        <div class="form-group row" id="retour_train">
            <label class="col-form-label col-sm-3" for="retour_train_value">Heure de départ du train <img src="include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="Si je n'ai pas encore mon horaire de train, je m'engage à l'envoyer dès que je l'ai à jeunes@fondacio.fr"></label>
            <div class="col-sm-3">
                <input type="time" class="form-control" name="retour_train_value" id="retour_train_value"> (Nous organisons deux départs de navette Fondacio le dimanche matin, il est donc possible de prendre un billet à compter de 7h du matin)
            </div>
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
            <label class="col-form-label col-sm-12">Le coût de revient d’un camp (hébergement, restauration, activités, administratif, encadrement) est de <b>1 100 euros</b>. Fondacio France finance 61% du coût du camp par des dons (parrainage, bénévolat, mécénat). Les 39% restants, soit <b>430 euros</b>, correspondent au prix demandé aux familles. Selon vos possibilités, nous proposons une participation entre <b style="color: red">270 et 1 100 euros.</b><br><br>

            A ce coût s'ajoute le prix du transport:<br>
            - Le service de navette que nous proposons de la gare de Montréjeau au Mourtis ajoute <b style="color: green">20€ par voyage</b> au coût du camp (donc 40€ si vous arrivez et repartez en train)<br>
            - Le voyage en bus ajoute <b style="color: green">75€ par voyage</b> au coût du camp (donc 150€ si vous arrivez et repartez en bus)<br><br>

            Si vous décidez de participer à la <b>prépa</b>, son coût de revient (<b style="color: blue">60€</b>) sera également ajouté.<br><br>

            Le prix de revient total camp + transport est donc de <b>430 + <span class="cout_transport" style="color: green"></span> + <span class="cout_prepa" style="color: blue"></span> = <span id="cout_revient" style="color: red"></span> euros.</b><br>
            La fourchette de participation proposée est donc de <b>(270 + <span class="cout_transport" style="color: green"></span> + <span class="cout_prepa" style="color: blue"></span> =) <span id="cout_fourchette_basse" style="color: red"></span> euros à (1 100 + <span class="cout_transport" style="color: green"></span> + <span class="cout_prepa" style="color: blue"></span> =) <span id="cout_fourchette_haute" style="color: red"></span> euros.</b></label>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-4" for="paiement_declare">Je choisis de payer le montant suivant <span style="color: red">*</span> <img src="include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" title="Notez bien ce montant, il vous sera redemandé au moment du paiement.."></label>
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

        <h5>Bourses</h5>

        <div class="form-group row">
            <label class="col-form-label col-sm-12">Nous tenons à ce qu’aucune difficulté financière ne soit un obstacle à la participation d’un jeune. Si votre situation familiale ne vous permet pas de payer le montant minimum indiqué ci-dessus, vous pouvez demander une bourse auprès du Directeur du Camp en remplissant le formulaire de demande de bourse, accessible depuis la page où se trouve le dossier administratif. Une réponse vous sera apportée dans les plus brefs délais.</label>
        </div>

        <h4>Attestation (CE)</h4><br>

        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="attestation_inscription" id="attestation_inscription" value="1"> Je souhaite recevoir pour mon CE une attestation d'inscription, une fois que j'aurais envoyé le dossier d'inscription papier complet
            </label>
        </div>

        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="attestation_presence" id="attestation_presence" value="1"> Je souhaite recevoir pour mon CE une attestation de présence et de paiement, après le camp
            </label>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="ce_nom" id="ce_nom_libelle">Nom du comité d'entreprise</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="ce_nom" id="ce_nom">
            </div>
            <label class="col-form-label col-sm-2" for="ce_mail"  id="ce_mail_libelle">Courriel du comité d'entreprise</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="ce_mail" id="ce_mail">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="ce_adresse"  id="ce_adresse_libelle">Adresse complète du comité d'entreprise</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="ce_adresse" id="ce_adresse">
            </div>
        </div>

        <h4>Communication</h4><br>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="communication">J'ai connu ce camp par <span style="color: red">*</span></label>
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
                    <option value="J'ai déjà fait un camp Réussir Sa Vie">J'ai déjà fait un camp Réussir Sa Vie</option>
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
                <input class="form-check-input" type="checkbox" id="conditions_inscription" value="" required><span style="color: red">*</span> Je m’engage à envoyer le dossier d’inscription COMPLET avec le règlement dans un délai de 15 jours à compter de la présente inscription sur internet. Fondacio se réserve le droit d’annuler l’inscription du jeune si ce délai n’est pas respecté.
            </label>
        </div>

        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" id="conditions_annulation" value="" required><span style="color: red">*</span> J’accepte les conditions d’annulation suivantes : pour toute annulation intervenant plus d’un mois avant le départ, les sommes payées seront intégralement remboursées par chèque bancaire ; pour toute annulation intervenant entre 7 jours et 30 jours avant le départ, 50% des sommes versées (transport compris) seront remboursées (100% si raison médicale, sur justificatif) ; pour toute annulation intervenant moins de 7 jours avant le départ (sauf raison médicale avec justificatif), l’intégralité des sommes versées est conservée par Fondacio.
            </label>
        </div><br><br>

        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" id="conditions_inscription" value="">Les données collectées via ce formulaire seront utilisées dans le cadre de l’organisation de ces événements, avant, pendant et après. Elles seront également utilisées par les associations de Fondacio en France afin vous présenter nos activités et nos projets, par voie email et postal. Nous vous proposons de recevoir des informations adaptées de la part de Fondacio en France afin de vous présenter nos autres activités et projets. Cochez si vous acceptez.<br>
                Conformément à la Loi Informatique et Libertés du 06 janvier 1978 et au Règlement (UE) N)2016/679, vous bénéficiez d’un droit d’accès, de rectification, d’effacement, de limitation, de portabilité, d’opposition et d’édiction de directives anticipées, que vous pouvez faire valoir en nous écrivant par email à mesdonnees@fondacio.fr ou bien par courrier à l’adresse Fondacio France – DPD, 2 rue de l’Esvière, 49100 ANGERS
            </label>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Valider l'inscription</button>
            </div>
        </div>
    </form>

    <script type="text/javascript">

        $(function() {

            $('#prepa').hide();

            // Initialisation variable pour le coût

            var cout_transport = 0;
            var cout_prepa = 0;
            var cout_transport_aller = 0;
            var cout_transport_retour = 0;

            // Affichage prépa

            $('input[type=radio][name=ancien]').change(function() {
                if (this.value == 1) {
                    $('#prepa').show();
                    $('#prepa').prop('required',true);
                }
                else {
                    $('#prepa').hide();
                    $('#prepa').prop('required',false);
                }
            });

            // Gestion cout prepa

            $('input[type=radio][name=prepa]').change(function() {
                if (this.value == 1) {
                    cout_prepa = 60;
                }
                else {
                    cout_prepa = 0;
                }
                $('.cout_transport').text(cout_transport);
                $('.cout_prepa').text(cout_prepa);
                $('#cout_revient').text(cout_transport+cout_prepa+430);
                $('#cout_fourchette_basse').text(cout_transport+cout_prepa+270);
                $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1100);
            });

            // Gestion des transports

            $('#aller_train').hide();
            $('#aller_bus').hide();
            $('#retour_voiture').hide();
            $('#retour_train').hide();
            $('#retour_bus').hide();

            $('#aller_transport').change(function() {
                if (this.value == "voiture") {
                    $('#aller_bus_clear option').remove();
                    $('#aller_bus_clear').append('<option value="" id="aller_bus_villes" selected></option>');
                    $('#aller_train').hide();
                    $('#aller_bus').hide();
                    cout_transport_aller = 0;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('.cout_prepa').text(cout_prepa);
                    $('#cout_revient').text(cout_transport+cout_prepa+430);
                    $('#cout_fourchette_basse').text(cout_transport+cout_prepa+270);
                    $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1100);
                }
                if (this.value == "train") {
                    $('#aller_bus_clear option').remove();
                    $('#aller_bus_clear').append('<option value="" id="aller_bus_villes" selected></option>');
                    $('#aller_train').show();
                    $('#aller_bus').hide();
                    cout_transport_aller = 20;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('.cout_prepa').text(cout_prepa);
                    $('#cout_revient').text(cout_transport+cout_prepa+430);
                    $('#cout_fourchette_basse').text(cout_transport+cout_prepa+270);
                    $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1100);
                }
                if (this.value == "bus") {
                    $('#aller_train').hide();
                    $('#aller_bus').show();
                    cout_transport_aller = 75;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('.cout_prepa').text(cout_prepa);
                    $('#cout_revient').text(cout_transport+cout_prepa+430);
                    $('#cout_fourchette_basse').text(cout_transport+cout_prepa+270);
                    $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1100);

                    $.ajax({
                        type: 'POST',
                        url: 'ajax/villes_bus.php',
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
                    $('#aller_train').hide();
                    $('#aller_bus').hide();
                    cout_transport_aller = 0;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('.cout_prepa').text(cout_prepa);
                    $('#cout_revient').text(cout_transport+cout_prepa+430);
                    $('#cout_fourchette_basse').text(cout_transport+cout_prepa+270);
                    $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1100);
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
                    $('.cout_prepa').text(cout_prepa);
                    $('#cout_revient').text(cout_transport+cout_prepa+430);
                    $('#cout_fourchette_basse').text(cout_transport+cout_prepa+270);
                    $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1100);
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
                    $('.cout_prepa').text(cout_prepa);
                    $('#cout_revient').text(cout_transport+cout_prepa+430);
                    $('#cout_fourchette_basse').text(cout_transport+cout_prepa+270);
                    $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1100);
                }
                if (this.value == "bus") {
                    $('#retour_voiture').hide();
                    $('#retour_train').hide();
                    $('#retour_bus').show();
                    cout_transport_retour = 75;
                    cout_transport = cout_transport_aller+cout_transport_retour;
                    $('.cout_transport').text(cout_transport);
                    $('.cout_prepa').text(cout_prepa);
                    $('#cout_revient').text(cout_transport+cout_prepa+430);
                    $('#cout_fourchette_basse').text(cout_transport+cout_prepa+270);
                    $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1100);

                    $.ajax({
                        type: 'POST',
                        url: 'ajax/villes_bus.php',
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
                    $('#cout_revient').text(cout_transport+cout_prepa+430);
                    $('#cout_fourchette_basse').text(cout_transport+cout_prepa+270);
                    $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1100);
                }
            });

            $('#aller_train_value').change(function() {
                if (this.value <= "11:30") {
                    $('#aller_train_navette').text('11h30');
                }
                else {
                    $('#aller_train_navette').text('14h30');
                }
            });

            $('#date_naissance').change(function() {
                console.log(this.value);
                if (this.value < "2001-01-01") {
                    $('#date_naissance_alerte').text('Ce camp est à destination des jeunes de 14 à 18 ans. Nous acceptons exceptionnellement des jeunes plus âgés s’ils ne sont pas scolarisés en études supérieures. Merci de nous contacter pour en parler: jeunes.camps@fondacio.fr. Par ailleurs, nous proposons un Forum 18/30 ans pour les jeunes étudiants ou professionnels.');
                }
                else if (this.value > "2005-12-31") {
                    $('#date_naissance_alerte').text('Ce camp est réservé aux jeunes ayant au moins 14 ans au début du camp. Votre inscription ne sera donc pas prise en compte.');
                }
                else {
                    $('#date_naissance_alerte').text('');
                }
            });

            // Affichage portable

            $('#jeune_tel_portable').hide();
            $('input[name="jeune_tel_portable_radio"]').change(function() {
                if (this.value == 1) {
                    $('#jeune_tel_portable').show();
                    $("#jeune_tel_portable").prop('required',true);
                    $("#jeune_tel_portable_libelle").html('Téléphone portable du jeune <span style="color: red">*</span>');
                }
                else {
                    $('#jeune_tel_portable').hide();
                    $("#jeune_tel_portable").prop('required',false);
                    $("#jeune_tel_portable_libelle").html('Téléphone portable du jeune');
                }
            });

            // Calcul du coût

            $('.cout_transport').text(cout_transport);
            $('.cout_prepa').text(cout_prepa);
            $('#cout_revient').text(cout_transport+cout_prepa+430);
            $('#cout_fourchette_basse').text(cout_transport+cout_prepa+270);
            $('#cout_fourchette_haute').text(cout_transport+cout_prepa+1100);

            // CE Obligatoire

            $('#attestation_inscription').change(function() {
                if($('#attestation_inscription').prop('checked') || $('#attestation_presence').prop('checked')) {
                    $("#ce_nom").prop('required',true);
                    $("#ce_mail").prop('required',true);
                    $("#ce_adresse").prop('required',true);
                    $("#ce_nom_libelle").html('Nom du comité d\'entreprise <span style="color: red">*</span>');
                    $("#ce_mail_libelle").html('Courriel du comité d\'entreprise <span style="color: red">*</span>');
                    $("#ce_adresse_libelle").html('Adresse complète du comité d\'entreprise <span style="color: red">*</span>');
                }
                else {
                    $("#ce_nom").prop('required',false);
                    $("#ce_mail").prop('required',false);
                    $("#ce_adresse").prop('required',false);
                    $("#ce_nom_libelle").html('Nom du comité d\'entreprise');
                    $("#ce_mail_libelle").html('Courriel du comité d\'entreprise');
                    $("#ce_adresse_libelle").html('Adresse complète du comité d\'entreprise');
                };
            });

            $('#attestation_presence').change(function() {
                if($('#attestation_inscription').prop('checked') || $('#attestation_presence').prop('checked')) {
                    $("#ce_nom").prop('required',true);
                    $("#ce_mail").prop('required',true);
                    $("#ce_adresse").prop('required',true);
                    $("#ce_nom_libelle").html('Nom du comité d\'entreprise <span style="color: red">*</span>');
                    $("#ce_mail_libelle").html('Courriel du comité d\'entreprise <span style="color: red">*</span>');
                    $("#ce_adresse_libelle").html('Adresse complète du comité d\'entreprise <span style="color: red">*</span>');
                }
                else {
                    $("#ce_nom").prop('required',false);
                    $("#ce_mail").prop('required',false);
                    $("#ce_adresse").prop('required',false);
                    $("#ce_nom_libelle").html('Nom du comité d\'entreprise');
                    $("#ce_mail_libelle").html('Courriel du comité d\'entreprise');
                    $("#ce_adresse_libelle").html('Adresse complète du comité d\'entreprise');
                };
            });
        });

    </script>

<?php

}

require_once 'include/foot.php';

?>