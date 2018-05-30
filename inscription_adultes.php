<?php

require_once 'include/init.php';

$title = 'Inscription Adultes';
require_once 'include/head.php';


if (!empty($_POST)) {

    enregistrer_inscription_adulte($_POST);

    echo '<br><br>Ton inscription a bien été enregistrée !<br><br>

Merci d\'envoyer dès que possible :<br><br>

- la <a target="_blank" href="http://www.jeunes.fondacio.fr/wp-content/uploads/2018/03/Convention-de-b%C3%A9n%C3%A9volat-2018-Fondacio-France.pdf">convention de bénévolat</a> complétée et signée<br>
- un document attestant que tu es à jour de tes vaccinations (copie du carnet de santé ou certificat médical)<br>
- <a target="_blank" href="http://www.jeunes.fondacio.fr/wp-content/uploads/2018/03/RSV_18_-Autorisation_relative_au_droit_a_l_image_-Personne-Majeure.pdf">l\'autorisation de photographie</a> complétée et signée<br>
- une copie de ton diplôme (BAFA, BAFD, infirmière, médecin, ...) si tu en possèdes un<br>
- une copie de ton carnet de stage BAFA/BAFD si tu es stagiaire<br>
- ton règlement (chèque à l\'ordre de Fondacio France) à :<br><br>

Fondacio camp RSV<br>
Inscription adulte<br>
23 rue de l\'Ermitage<br>
78000 VERSAILLES<br><br>

Si tu souhaites payer en ligne, clique <a target="_blank" href="http://bit.ly/1O6910a">ici</a><br><br>

A bientôt au Mourtis !';

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

                    $camps = get_camps_inscrptions();

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
            <label class="col-form-label col-sm-2" for="profession">Profession</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="profession" id="profession">
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
            <label class="col-form-label col-sm-6" for="ok_conduire">J'ai au moins 23 ans, je possède le permis de conduire depuis plus de 3 ans et je me sens capable de conduire en montagne un des véhicules de Fondacio, notamment pour transporter des jeunes</label>
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
            <label class="col-form-label col-sm-4" for="permis">Je possède un ou plusieurs diplôme(s)</label>
            <div class="col-sm-8">
                <div class="form-check form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="diplome_bafd" value="1" id="diplome_bafd">Titulaire du BAFD
                    </label>
                </div>
                <div class="form-check form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="diplome_bafa" value="1" id="diplome_bafa">Titulaire du BAFA
                    </label>
                </div>
                <div class="form-check form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="diplome_secouriste" value="1" id="diplome_secouriste">PSC1 ou PSCE1 ou secouriste
                    </label>
                </div>
                <div class="form-check form-check">
                    <label class="form-check-label col-sm-8">
                        <input class="form-check-input" type="checkbox" value="1">Si vous détenez ce diplôme, vous avez un diplôme de premiers secours : infirmier(ère), médecin, chirurgien(ne)-dentiste, pharmacien(ne), détenteur (trice) de l’AFPS, du BN ou le CSST. Si oui précisez lequel ou lesquels : <input type="text" class="form-control" name="diplome_ps" id="diplome_ps">
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-check-label col-sm-8">
                        <input class="form-check-input" type="checkbox" value="1" id="diplome_autre">Autre(s) diplôme(s) : <input type="text" class="form-control" name="diplome_autre" id="diplome_autre">
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
                    <option value="sur_place">Je serai déjà sur place</option>
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
            <label class="col-form-label col-sm-3" for="aller_train">Heure d'arrivée <span style="color: red">*</span> <img src="/include/icons/info.svg" alt="info" class="icon" data-toggle="tooltip" data-placement="top" data-html="true" title="Si impossible d'arriver à ces horaires, voir avec le responsable de camp</li></ul>"></label>
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
            <label class="col-form-label col-sm-3" for="aller_bus">Ville de départ <span style="color: red">*</span></label>
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
                    <option value="sur_place">Je reste sur place</option>
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
            <label class="col-form-label col-sm-3" for="retour_bus">Ville d'arrivée <span style="color: red">*</span></label>
            <div class="col-sm-3">
                <select class="form-control" name="retour_bus" id="retour_bus_clear">
                    <option value="" id="retour_bus_villes" selected></option>
                </select>
            </div>
        </div>

        <h4>Paiement</h4>

        <div class="form-group row">
            <label class="col-form-label col-sm-12">Afin de maintenir un prix le plus bas possible pour qu’un maximum de jeunes puissent participer aux camps, nous invitons les adultes présents sur les camps à participer librement à leurs frais d’hébergement et de nourriture.<br>
            Pour information, le coût de revient du camp s'élève à <b>420€</b> par jeune (le camp + la prépa revient à <b>480€</b>). A titre indicatif, les frais de restauration et d'hébergement s'élèvent à <b>30€</b> par jour.<br><br>

            A ce coût s'ajoute le prix du transport :<br>
            <b>75€</b> pour un trajet simple en bus<br>
            <b>150€</b> pour un aller-retour en bus<br>
            <b>20€</b> pour une navette Montréjeau-Le Mourtis (aller simple)<br>
            <b>40€</b> pour une navette Montréjeau-Le Mourtis (aller-retour)<br><br>

            Pour le camp 2 uniquement: nous proposons une fourchette <b>entre 50€ et 100€</b> pour chaque enfant qui correspond aux frais de restauration et des activités qu’ils vivront pendant la semaine.<br><br>

            A partir de ces repères, chacun est invité à participer de façon tout à fait libre, selon ses moyens et ce qui lui semble juste.<br>
            Dans le cas où vous ne pourriez pas participer, cela ne remet pas en cause votre présence sur le camp, nous vous invitons à en discuter avec le responsable vous ayant appelé.<br><br>

            Tout versement supérieur au coût de revient servira à financer la participation d'un jeune.</label>
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
        </div><br><br>

        <h4>Activités</h4><br>

        <h6>Concernant les activités</h6>

        <div class="form-group row">
            <label class="col-form-label col-sm-12">Les après-midis des camps Réussir Sa Vie sont consacrées à l’approfondissement et l’exploration des thématiques abordées durant les matinées à travers des activités sportives, créatives ou artistiques.<br>
            Chaque adulte sera sollicité afin d’animer et d’encadrer ces activités, tout au long de la semaine.<br>
            Dans l’optique de correspondre à la fois aux besoins des jeunes, aux choix pédagogiques des camps et également aux besoins et aux envies de chacun de vous, merci de remplir les questionnaires suivants.</label>
        </div>

        <h6>Activités sur site</h6>

        <div class="form-group row">
            <label class="col-form-label col-sm-12">Veuillez nous indiquer, parmi la liste suivante, les activités ou hobbies dans lesquels vous vous reconnaissez. Dans la mesure du possible, précisez : (ex : sports : karaté ; escalade ; équitation)</label>
        </div>

        <div class="form-group row">
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_arts_plastiques" id="act_arts_plastiques" value="1"> Arts plastiques
                    </label>
                </div>
            </div>
            <div class="col-sm-3">
                <label class="form-check-label">
                    Si possible, préciser <input type="text" class="form-control" name="act_arts_plastiques_p" id="act_arts_plastiques_p">
                </label>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_bd" id="act_bd" value="1"> Bande dessinée
                    </label>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_orient_pro" id="act_orient_pro" value="1"> Orientation professionelle
                    </label>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_cinema" id="act_cinema" value="1"> Cinéma
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_exp_corp" id="act_exp_corp" value="1"> Expressions corporelles
                    </label>
                </div>
            </div>
            <div class="col-sm-3">
                <label class="form-check-label">
                    Si possible, préciser <input type="text" class="form-control" name="act_exp_corp_p" id="act_exp_corp_p">
                </label>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_jeux_piste" id="act_jeux_piste" value="1"> Jeux de piste
                    </label>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_meditation" id="act_meditation" value="1"> Méditation
                    </label>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_arts_enigme" id="act_arts_enigme" value="1"> Énigmes
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_musiques" id="act_musiques" value="1"> Musiques
                    </label>
                </div>
            </div>
            <div class="col-sm-3">
                <label class="form-check-label">
                    Si possible, préciser <input type="text" class="form-control" name="act_musiques_p" id="act_musiques_p">
                </label>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_jeux_mem" id="act_jeux_mem" value="1"> Jeux de mémoire
                    </label>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_ecritures" id="act_ecritures" value="1"> Écritures/récits
                    </label>
                </div>
            </div>
            <div class="col-sm-3">
                <label class="form-check-label">
                    Si possible, préciser <input type="text" class="form-control" name="act_ecritures_p" id="act_ecritures_p">
                </label>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_danses" id="act_danses" value="1"> Danses
                    </label>
                </div>
            </div>
            <div class="col-sm-3">
                <label class="form-check-label">
                    Si possible, préciser <input type="text" class="form-control" name="act_danses_p" id="act_danses_p">
                </label>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_sculpture" id="act_sculpture" value="1"> Sculpture, modelage
                    </label>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_arts_rue" id="act_arts_rue" value="1"> Arts de la rue
                    </label>
                </div>
            </div>
            <div class="col-sm-3">
                <label class="form-check-label">
                    Si possible, préciser <input type="text" class="form-control" name="act_arts_rue_p" id="act_arts_rue_p">
                </label>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_chants" id="act_chants" value="1"> Chants
                    </label>
                </div>
            </div>
            <div class="col-sm-3">
                <label class="form-check-label">
                    Si possible, préciser <input type="text" class="form-control" name="act_chants_p" id="act_chants_p">
                </label>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_bijoux" id="act_bijoux" value="1"> Bijoux (bracelets, colliers etc...)
                    </label>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_sports" id="act_sports" value="1"> Sports
                    </label>
                </div>
            </div>
            <div class="col-sm-3">
                <label class="form-check-label">
                    Si possible, préciser <input type="text" class="form-control" name="act_sports_p" id="act_sports_p">
                </label>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_imagination" id="act_imagination" value="1"> Imagination
                    </label>
                </div>
            </div>
            <div class="col-sm-3">
                <label class="form-check-label">
                    Si possible, préciser le support <input type="text" class="form-control" name="act_imagination_p" id="act_imagination_p">
                </label>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_relaxation" id="act_relaxation" value="1"> Relaxation
                    </label>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_theatres" id="act_theatres" value="1"> Théâtres
                    </label>
                </div>
            </div>
            <div class="col-sm-3">
                <label class="form-check-label">
                    Si possible, préciser <input type="text" class="form-control" name="act_theatres_p" id="act_theatres_p">
                </label>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_arts_cirque" id="act_arts_cirque" value="1"> Arts du cirque
                    </label>
                </div>
            </div>
            <div class="col-sm-3">
                <label class="form-check-label">
                    Si possible, préciser <input type="text" class="form-control" name="act_arts_cirque_p" id="act_arts_cirque_p">
                </label>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_photo" id="act_photo" value="1"> Photographie
                    </label>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_illustrations" id="act_illustrations" value="1"> Illustrations
                    </label>
                </div>
            </div>
            <div class="col-sm-3">
                <label class="form-check-label">
                    Si possible, préciser <input type="text" class="form-control" name="act_illustrations_p" id="act_illustrations_p">
                </label>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-2">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_logique" id="act_logique" value="1"> Logique
                    </label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="act_strategie" id="act_strategie" value="1"> Stratégie
                    </label>
                </div>
            </div>
            <div class="col-sm-3">
                <label class="form-check-label">
                    Autres <input type="text" class="form-control" name="act_autres" id="act_autres">
                </label>
            </div>
        </div>

        <h6>Activités hors site (niveau débutant)</h6>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="act_rafting">Rafting <span style="color: red">*</span></label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_rafting" id="act_rafting2" value="2"> Je souhaite le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_rafting" id="act_rafting1" value="1"> Je peux le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_rafting" id="act_rafting0" value="0" required> Il m'est impossible de le faire
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="act_canyo">Canyoning <span style="color: red">*</span></label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_canyo" id="act_canyo" value="2"> Je souhaite le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_canyo" id="act_canyo1" value="1"> Je peux le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_canyo" id="act_canyo0" value="0" required> Il m'est impossible de le faire
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="act_descente">Descente VTT <span style="color: red">*</span></label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_descente" id="act_descente2" value="2"> Je souhaite le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_descente" id="act_descente1" value="1"> Je peux le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_descente" id="act_descente0" value="0" required> Il m'est impossible de le faire
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="act_mini_raid">Mini raid VTT <span style="color: red">*</span></label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_mini_raid" id="act_mini_raid2" value="2"> Je souhaite le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_mini_raid" id="act_mini_raid1" value="1"> Je peux le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_mini_raid" id="act_mini_raid0" value="0" required> Il m'est impossible de le faire
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="act_via_fe">Via Ferrata <span style="color: red">*</span></label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_via_fe" id="act_via_fe2" value="2"> Je souhaite le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_via_fe" id="act_via_fe1" value="1"> Je peux le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_via_fe" id="act_via_fe0" value="0" required> Il m'est impossible de le faire
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="act_grimp">Grimp'arbre <span style="color: red">*</span></label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_grimp" id="act_grimp2" value="2"> Je souhaite le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_grimp" id="act_grimp1" value="1"> Je peux le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_grimp" id="act_grimp0" value="0" required> Il m'est impossible de le faire
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="act_bike_park">Mourtis Bike Park <span style="color: red">*</span></label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_bike_park" id="act_bike_park2" value="2"> Je souhaite le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_bike_park" id="act_bike_park1" value="1"> Je peux le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_bike_park" id="act_bike_park0" value="0" required> Il m'est impossible de le faire
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="act_speed_chall">Mourtis Speed Challenge <span style="color: red">*</span></label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_speed_chall" id="act_speed_chall2" value="2"> Je souhaite le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_speed_chall" id="act_speed_chall1" value="1"> Je peux le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_speed_chall" id="act_speed_chall0" value="0" required> Il m'est impossible de le faire
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="act_biathlon">Biathlon <span style="color: red">*</span></label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_biathlon" id="act_biathlon2" value="2"> Je souhaite le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_biathlon" id="act_biathlon1" value="1"> Je peux le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_biathlon" id="act_biathlon0" value="0" required> Il m'est impossible de le faire
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="act_piscine">Piscine <span style="color: red">*</span></label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_piscine" id="act_piscine2" value="2"> Je souhaite le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_piscine" id="act_piscine1" value="1"> Je peux le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_piscine" id="act_piscine0" value="0" required> Il m'est impossible de le faire
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-sm-2" for="act_sports_co">Animation sports co <span style="color: red">*</span></label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_sports_co" id="act_sports_co2" value="2"> Je souhaite le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_sports_co" id="act_sports_co1" value="1"> Je peux le faire
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="act_sports_co" id="act_sports_co0" value="0" required> Il m'est impossible de le faire
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Valider l'inscription</button>
            </div>
        </div>
    </form>

    <script type="text/javascript">

        $(function() {

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
                }
                if (this.value == "train") {
                    $('#aller_bus_clear option').remove();
                    $('#aller_bus_clear').append('<option value="" id="aller_bus_villes" selected></option>');
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
                    $('#retour_bus_clear option').remove();
                    $('#retour_bus_clear').append('<option value="" id="retour_bus_villes" selected></option>');
                    $('#retour_voiture').show();
                    $('#retour_train').hide();
                    $('#retour_bus').hide();
                }
                if (this.value == "train") {
                    $('#retour_bus_clear option').remove();
                    $('#retour_bus_clear').append('<option value="" id="retour_bus_villes" selected></option>');
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

}

require_once 'include/foot.php';

?>