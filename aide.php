<?php

require_once 'include/init.php';

$title = 'Aide';
require_once 'include/head.php';

?>

<h1><b>Aide</b></h1>

<h4 style="color: red">Si problème, contacter Pierre: pleplat75@gmail.com / 06 12 19 22 92</h4>

<p>Bienvenue sur cette page d'aide à l'utilisation de ce nouvel outil pour la logistique et les activités.<br>
Son but est de faciliter l'utilisation de la base de données avec une interface plus conviviale, mais aussi de travailler à plusieurs en même temps surt une unique version de la base: la logistique peut tout à fait travailler de son côté pendant que les activités mettent en place leur planning. Les petits groupes et parrainages peuvent même être renseignés par le service concerné sans intervention de la logistique (si tout va bien).<br>
Voyons tout ça en détails !

<h2>Onglet "Accueil"</h2>
<p>L'onglet accueil est le premier sur lequel vous arrivez et contient les choses suivantes:
<ul>
    <li>Alertes transport: un récapitulatif des arrivées en train du jour et des personnes n'ayant pas de moyen de retour renseigné</li>
    <li>Effectifs repas du jour: son nom l'indique, le nombre de repas à servir midi et soir au jour le jour. Ne fonctionne pas forcément pour le moment</li>
    <li>Anniversaires: là aussi l'intitulé parle de lui-même, les anniversaires du jour</li>
    <li>Statistiques: quelques informations sur les effectifs du camp</li></ul></p>

<h2>Onglet Participants</h2>
<p>L'onglet participants est l'équivalent de l'ancienne base cogé. Voici les fonctionnalités qu'elle présente:<ul>
<li>Bouton Ajouter: Permet d'insérer un nouveau participant en cas d'inscription au dernier moment</li>
<li>Bouton Exporter: Permet l'export en CSV (Excel) de la liste des participants en fonction des filtres et des tris qui se trouvent juste en dessous. Ne contient que les champs jugés utiles au jour le jour, les champs à utilitié spécifique (type infos transports) sont utilisées dans un autre onglet</li>
<li>Bloc Filtres: Permet de filtrer l'affichage et l'export de la liste des participants avec plusieurs critéres validés en amont. Il faut cliquer sur le bouton "Filtrer" pour que l'action soit prise en compte</li>
<li>Bloc Tri: Permet de trier les résultats obtenus, en fonction de 2 champs. Tri 1 est pris en compte avant Tri 2, attention. Il faut cliquer sur le bouton "Trier" pour que l'action soit prise en compte</li>
<li>Bloc données: Les résultats, enfin! Le nombre total en fonction des filtres est affiché en haut de tableau. Les champs affichés ne sont que ceux utilisés couramment. Si vous souhaitez consulter toutes les informations d'un participant, cliquez simplement sur son nom. Vous pouvez éditer ses infromations dans la nouvelle interface, n'oublire pas de cliquer sur "Sauvegarder" au bas de la fiche pour que les modifications soient prises en compte.</li></ul></p>

<h2>Onglet Remplissage</h2>
<p>Cet onglet permet de remplir les Petits groupes, les chambres et les parrainages une fois qu'ils ont été faits par l'équipe concernée. Sélectionnez une donnée à remplir pour voir l'interface modifiée en fonction du besoin:<ul>
<li>Petits groupes: Il suffit de renseigner le numéro, le R1 et tous les membres. S'il y a moins de membres que de champs, laissez les champs restants vides sans soucis</li>
<li>Chambre: Comme pour les PG, il suffit de renseigner le numéro de la chambre ainsi que le responsable. Normalement aucune chambre n'a de capacité supérieure au nombre de champs. Encore une fois, laissez vide s'il y a plus de champs que de jeunes dans une chambre</li>
<li>Parrainages: Deux champs s'offrent à vous, parrain et filleul. Commencez à taper un nom dans un champ pour voir un système d'auto-complétion se mettre en place, qui ne renvoit que les résultats de votre camp. N'oubliez pas de cliquer sur Sauvegarder !</li></ul></p>

<h2>Onglet Exports</h2>
<p>Vous trouverez ici les exports nécessaires à la logistique, <b>ceux pour les activités se trouvent dans l'onglet correspondant</b>:<ul>
<li>Accueil Jeunes: la liste permettant de faire l'accueil des jeunes avec numéro de chambre et de PG, mais également les infos sur le trajet retour à vérifier avec le jeune</li>
<li>Accueil Adultes: même chose avec les adultes</li>
<li>Badges: Tout simplement le fichier pour générer les badges, trié par type (adulte ou jeune) puis par ordre alphabétique. Fini le publipostage !</li>
<li>Chambres: Le plan des chambres de jeunes, une fois rempli sur l'onglet remplissage</li>
<li>Parrainages: La liste des parrains et leurs filleuls. Les parrains ayant plusieurs filleuls seront renseignés plusieurs fois à la suite</li>
<li>Petits groupes: La liste des PG une fois remplis sur l'onglet Remplissage</li>
<li>Trombinoscope: La liste des participants avec des petits cadres pour mettre les photos</li></ul></p>

<h2>Onglet Transports</h2>

<p>Cet onglet présente simplement un récapitulatif des transports pour chaque particpant. En voici ses fonctionnalités:<ul>
<li>Boutons Exporter (format A4): Permet l'export en PDF de la liste des participants prenant le bus, avec une page par destination, le train ou la voiture (une page par moyen de transport). <b>Attention à bien filtrer avant d'exporter !</b> Contient également le total de participants par destination</li>
<li>Bloc Filtres: Permet de filtrer l'affichage de la liste des participants avec plusieurs critéres validés en amont. Il faut cliquer sur le bouton "Filtrer" pour que l'action soit prise en compte. Le filtre "Prépa ?" n'est activé que pour l'aller, pas pour le retour</li>
<li>Bloc données: Les résultats, enfin! Le nombre total en fonction des filtres est affiché en haut de tableau. Les champs affichés ne sont que ceux utilisés couramment. Si vous souhaitez consulter toutes les informations d'un participant, cliquez simplement sur son nom. Vous pouvez éditer ses infromations dans la nouvelle interface, n'oublire pas de cliquer sur "Sauvegarder" au bas de la fiche pour que les modifications soient prises en compte.</li></ul></p>

<h2>Onglet Activités</h2>

<p>In progress</p>

<br><br><br><p>Voilà pour ce document présentant l'utilisation de l'application. C'est une première version très fonctionnelle, pas forcément optimisée en terme d'ergonomie, mais qui devrait déjà simplifier beaucoup de choses. N'hésitez pas à me faire des retours par mail de préférence sur ce que vous aimeriez voir ajouté, retiré, modifié, et j'en prendrai note pour la version suivante!<br>
Je rappelle mes coordonnées si jamais vous avez un souci, je suis debout entre 9h et 2h environ, n'hésitez vraiment pas à me contacter plutôt que de rester bloqué: pleplat75@gmail.com / 06 12 19 22 92</p>
<p>Bon camp !<br>Pierre</p>

<?php

require_once 'include/foot.php';

?>