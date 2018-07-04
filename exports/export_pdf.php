<?php

require_once '../include/init.php';
require_once '../include/tcpdf/tcpdf.php';

if ($_GET['contexte'] == 'transports') {

    $donnees = $_SESSION['donnees_transport'];

    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetTitle('Transports '.$_SESSION['filtres_transports']['moyen_transport']);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);

    if ($_SESSION['filtres_transports']['moyen_transport'] == 'bus') {
        $participants = array();
        foreach ($donnees as $participant) {
                $participants[$participant['ville']][] = $participant;
        }
        $prepa = '';
        if (!empty($_SESSION['filtres_transports']['prepa'])) {
            $prepa = 'prépa';
        }

        foreach ($participants as $ville => $data) {

            $pdf->AddPage();
            $x = 50;
            $y = 5;

            $pdf->SetFont('helvetica', 'B', 25, '', true);
            $pdf->SetTextColor(255,0,0);
            $pdf->writeHTMLCell(0, 0, $x, $y, 'Bus '.$_SESSION['filtres_transports']['aller_retour'].' '.$prepa.' '.$ville);

            $pdf->SetFont('helvetica', '', 10, '', true);
            $pdf->SetTextColor(0,0,0);
            $x = 5;
            $y = 20;
            $i = 0;
            $j = 0;

            foreach ($data as $id_participant => $participant) {

                if ($i == 30) {
                    $x += 100;
                    $y = 20;
                    $i = 0;
                }

                $pdf->writeHTMLCell(80, 0, $x, $y, '<b>'.$participant['nom'].'</b> '.$participant['prenom'].' ('.$participant['tel_portable'].'/'.$participant['ref_portable'].')');
                $y += 8;
                ++$i;
                ++$j;

            }
            $pdf->writeHTMLCell(0, 0, $x, $y+5, '<b>TOTAL: '.$j);

        }
    }

    if ($_SESSION['filtres_transports']['moyen_transport'] == 'train' || $_SESSION['filtres_transports']['moyen_transport'] == 'voiture') {

        $pdf->AddPage();
        $x = 50;
        $y = 5;

        $prepa = '';
        if (!empty($_SESSION['filtres_transports']['prepa'])) {
            $prepa = 'prépa';
        }

        $pdf->SetFont('helvetica', 'B', 25, '', true);
        $pdf->SetTextColor(255,0,0);
        $pdf->writeHTMLCell(0, 0, $x, $y, ucfirst($_SESSION['filtres_transports']['moyen_transport']).' '.$_SESSION['filtres_transports']['aller_retour'].' '.$prepa);

        $pdf->SetFont('helvetica', '', 10, '', true);
        $pdf->SetTextColor(0,0,0);
        $x = 5;
        $y = 20;
        $i = 0;
        $j = 0;

        foreach ($donnees as $participant) {

            if ($i == 30) {
                $x += 100;
                $y = 20;
                $i = 0;
            }

            if ($transport == 'train') {
                $html = '<b>'.$participant['nom'].'</b> '.$participant['prenom'].' '.$participant['heure'].' ('.$participant['tel_portable'].'/'.$participant['ref_portable'].')';
            }
            else {
                $html = '<b>'.$participant['nom'].'</b> '.$participant['prenom'].' ('.$participant['tel_portable'].'/'.$participant['ref_portable'].')';
            }
            $pdf->writeHTMLCell(80, 0, $x, $y, $html);
            $y += 8;
            ++$i;
            ++$j;

        }
        $pdf->writeHTMLCell(0, 0, $x, $y+5, '<b>TOTAL: '.$j);

    }

    $pdf->Output('Transports '.$_SESSION['filtres_transports']['moyen_transport'].'.pdf', 'D');

}

if ($_GET['contexte'] == 'accueil') {

    $donnees = get_accueil($_GET['type']);

    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetTitle('Accueil');
    $pdf->SetFont('helvetica', '', 9, '', true);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);

    $pdf->AddPage();
    $x = 5;
    $y = 5;
    $i = 0;

    $html = '<table border="1"><tr><th></th><th height="30" style="text-align: center; color: red"><b>Nom</b></th><th height="30" style="text-align: center; color: red"><b>Prénom</b></th><th height="30" style="text-align: center; color: red"><b>Chambre</b></th><th height="30" style="text-align: center; color: red"><b>PG</b></th><th height="30" style="text-align: center; color: red"><b>Retour</b></th><th height="30" style="text-align: center; color: red"><b>Ville</b></th><th height="30" style="text-align: center; color: red"><b>Date</b></th><th height="30" style="text-align: center; color: red"><b>Heure</b></th><th height="30" style="text-align: center; color: red"><b>Docs</b></th><th height="30" style="text-align: center; color: red"><b>Obs</b></th></tr></table>';

    $pdf->writeHTMLCell(0, 0, $x, $y, $html);
    $y += 15;

    foreach ($donnees as $participant) {

        // Gestion des nouvelles pages
        if ($i == 17) {
            $pdf->AddPage();
            $x = 5;
            $y = 5;
            $i = 0;
            $j = 0;
            $html = '<table border="1"><tr><th></th><th height="30" style="text-align: center; color: red"><b>Nom</b></th><th height="30" style="text-align: center; color: red"><b>Prénom</b></th><th height="30" style="text-align: center; color: red"><b>Chambre</b></th><th height="30" style="text-align: center; color: red"><b>PG</b></th><th height="30" style="text-align: center; color: red"><b>Retour</b></th><th height="30" style="text-align: center; color: red"><b>Ville</b></th><th height="30" style="text-align: center; color: red"><b>Date</b></th><th height="30" style="text-align: center; color: red"><b>Heure</b></th><th height="30" style="text-align: center; color: red"><b>Docs</b></th><th height="30" style="text-align: center; color: red"><b>Obs</b></th></tr></table>';
            $pdf->writeHTMLCell(0, 0, $x, $y, $html);
            $y += 15;
        }

        $html = '<table border="1"><tr><td></td><td height="30" style="text-align: center;"><b>'.$participant['nom'].'</b></td><td height="30" style="text-align: center;">'.$participant['prenom'].'</td><td height="30" style="text-align: center;">'.$participant['chambre_num'].'</td><td height="30" style="text-align: center;">'.$participant['pg_num'].'</td><td height="30" style="text-align: center;">'.$participant['retour_transport'].'</td><td height="30" style="text-align: center;">'.$participant['retour_ville'].'</td><td height="30" style="text-align: center;">'.convert_date($participant['retour_date']).'</td><td height="30" style="text-align: center;">'.$participant['retour_heure'].'</td><td height="30" style="text-align: center;">'.$participant['manquant'].'</td><td></td></tr></table>';

        $pdf->writeHTMLCell(0, 0, $x, $y, $html);

        $y += 15;
        ++$i;
    }

    $pdf->Output('Accueil '.$_GET['type'].'.pdf', 'D');

}

if ($_GET['contexte'] == 'badges') {

    $donnees = get_badges();

    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetTitle('Badges');
    $pdf->SetFont('helvetica', '', 12, '', true);
    $pdf->setCellPadding(5, 5, 5, 0);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);

    $pdf->AddPage();
    $x = 5;
    $y = 2;
    $i = 0;
    $j = 0;

    foreach ($donnees as $participant) {

        if ($participant['nom'] != 'CHAUFFEUR') {
            $z = 0;
            while ($z < 6) {
                // Gestion des nouvelles pages
                if ($j == 16) {
                    $pdf->AddPage();
                    $x = 5;
                    $y = 2;
                    $i = 0;
                    $j = 0;
                }

                // Gestion des nouvelles lignes
                if ($i == 2) {
                    $i = 0;
                    $x = 5;
                    $y += 36;
                }


                $html = '<b>'.$participant['nom'].' '.$participant['prenom'].'</b><br>';
                if ($participant['type'] == 'jeune') {
                    $html .= 'Chambre: <b>'.$participant['chambre_num'].'</b><br>PG: <b>'.$participant['pg_num'].'</b>';
                }
                else {
                    $html .= 'Service: <b>'.$participant['service'].'</b>';
                }
                $pdf->writeHTMLCell('99,1', 0, $x, $y, $html);

                $x += '101,6';
                ++$i;
                ++$j;
                ++$z;
            }
        }
    }

    $pdf->Output('Badges.pdf', 'D');

}

if ($_GET['contexte'] == 'chambres') {

    $donnees = get_chambres();

    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetTitle('Chambres');
    $pdf->SetFont('helvetica', '', 12, '', true);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);

    $pdf->AddPage();
    $x = 5;
    $y = 5;
    $i = 0;
    $j = 0;

    foreach ($donnees as $chambre_num => $membres) {

        if ($j == 8) {
            $pdf->AddPage();
            $x = 5;
            $y = 5;
            $i = 0;
            $j = 0;
        }

        // Gestion des nouvelles colonnes
        if ($i == 2) {
            $i = 0;
            $x = 5;
            $y += 50;
        }

        $html = '<div style="color: red; font-weight: bold; font-size: 16;">Chambre '.$chambre_num.'</div>';
        foreach ($membres as $membre) {
            $html .= '<br>'.$membre;
        }

        $pdf->writeHTMLCell(120, 50, $x, $y, $html);

        $x += 90;
        ++$i;
        ++$j;
    }

    $pdf->Output('Chambres.pdf', 'D');

}

/// OLD

if ($_GET['contexte'] == 'trombi') {

    $donnees = get_trombi();

    $pdf = new TCPDF('L', 'mm', 'A3', true, 'UTF-8');
    $pdf->SetTitle('Trombinoscope');
    $pdf->SetFont('helvetica', '', 12, '', true);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);

    $pdf->AddPage();
    $x = 5;
    $y = 5;
    $i = 0;
    $j = 0;

    foreach ($donnees as $participant) {

        if ($participant['nom'] != 'CHAUFFEUR') {
            // Gestion des nouvelles pages
            if ($j == 35) {
                $pdf->AddPage();
                $x = 5;
                $y = 5;
                $i = 0;
                $j = 0;
            }

            // Gestion des nouvelles lignes
            if ($i == 7) {
                $i = 0;
                $x = 5;
                $y += 55;
            }

            $pdf->writeHTMLCell(50, 40, $x, $y, '<table border="1"><tr><td width="130" height="110"></td></tr></table>'.$participant['nom'].' '.$participant['prenom']);

            $x += 60;
            ++$i;
            ++$j;
        }
    }

    $pdf->Output('Trombinoscope.pdf', 'D');

}

if ($_GET['contexte'] == 'parrainages') {

    $donnees = get_parrainages();

    $pdf = new TCPDF('L', 'mm', 'A3', true, 'UTF-8');
    $pdf->SetTitle('Parrainages');
    $pdf->SetFont('helvetica', '', 12, '', true);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);

    $pdf->AddPage();
    $x = 5;
    $y = 5;
    $i = 0;

    foreach ($donnees as $participant) {

        // Gestion des nouvelles colonnes
        if ($i == 13) {
            $i = 0;
            $x += 75;
            $y = 5;
        }

        $pdf->writeHTMLCell(100, 30, $x, $y, '<b>P: '.$participant[0].'</b><br>F: '.$participant[1]);

        $y += 20;
        ++$i;
    }

    $pdf->Output('Parrainages.pdf', 'D');

}

if ($_GET['contexte'] == 'pg') {

    $donnees = get_pg();

    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetTitle('Petits Groupes');
    $pdf->SetFont('helvetica', '', 12, '', true);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);

    $pdf->AddPage();
    $x = 5;
    $y = 5;
    $i = 0;
    $j = 0;

    foreach ($donnees as $pg_num => $membres) {

        if ($j == 10) {
            $pdf->AddPage();
            $x = 5;
            $y = 5;
            $i = 0;
            $j = 0;
        }

        // Gestion des nouvelles colonnes
        if ($i == 2) {
            $i = 0;
            $x = 5;
            $y += 50;
        }

        $html = '<div style="color: red; font-weight: bold; font-size: 16;">PG N°'.$pg_num.'</div>';
        foreach ($membres as $membre) {
            $membre = explode(' - ', $membre);
            if ($membre[1] == 1) {
                $html .= '<br><b>R1: '.$membre[0].'</b>';
            }
            else {
                $html .= '<br>'.$membre[0];
            }
        }

        $pdf->writeHTMLCell(120, 0, $x, $y, $html);

        $x += 100;
        ++$i;
        ++$j;
    }

    $pdf->Output('Petits Groupes.pdf', 'D');

}

if ($_GET['contexte'] == 'transports_train') {

    $donnees = get_retour_train();

    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetTitle('Transports Train');
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);

    $pdf->AddPage();
    $x = 50;
    $y = 5;

    $pdf->SetFont('helvetica', 'B', 25, '', true);
    $pdf->SetTextColor(255,0,0);
    $pdf->writeHTMLCell(0, 0, $x, $y, 'Retours en train');

    $pdf->SetFont('helvetica', '', 10, '', true);
    $pdf->SetTextColor(0,0,0);
    $x = 20;
    $y += 15;
    $i = 0;
    $j = 0;

    foreach ($donnees as $date => $heures) {

        $pdf->writeHTMLCell(0, 0, $x, $y, '<b>'.convert_date($date).'</b>');
        $y += 10;
        foreach ($heures as $heure => $participants) {
            $pdf->writeHTMLCell(0, 0, $x, $y, '<b>'.$heure.'</b>');
            $y += 5;
            foreach ($participants as $participant) {
                if ($i == 10) {
                    $x += 100;
                    $y = 20;
                    $i = 0;
                }
                $pdf->writeHTMLCell(0, 0, $x, $y, $participant);
                $y += 5;
                ++$i;
                ++$j;
            }
            $y += 5;
        }
        $y += 5;

    }

    $pdf->writeHTMLCell(0, 0, $x, $y, '<b>TOTAL: '.$j);

    $pdf->Output('Transports Train.pdf', 'D');

}

if ($_GET['contexte'] == 'activites') {

    $donnees = get_inscriptions();

    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetTitle('Inscriptions');
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);

    foreach ($donnees as $activite => $participants) {

        if ($activite != '') {
            $pdf->AddPage();
            $x = 20;
            $y = 20;
            $i = 0;

            $pdf->SetFont('helvetica', 'B', 25, '', true);
            $pdf->SetTextColor(255,0,0);
            $pdf->writeHTMLCell(0, 0, $x, $y, $activite.' '.date('d/m/Y'));

            $y += 10;

            foreach ($participants as $type => $noms) {
                if ($type == 'adulte') {
                    $y += 20;
                    $pdf->SetFont('helvetica', 'B', 25, '', true);
                    $pdf->SetTextColor(0,0,0);
                    $pdf->writeHTMLCell(0, 0, $x, $y, 'Adulte(s): '.$noms[0]);
                }

                else {
                    $pdf->SetFont('helvetica', '', 20, '', true);
                    $pdf->SetTextColor(0,0,0);
                    $total = sizeof($noms);
                    foreach ($noms as $nom) {
                        if ($i == 20) {
                            $x += 100;
                            $y = 30;
                            $i = 0;
                        }
                        $y += 10;
                        $pdf->writeHTMLCell(0, 0, $x, $y, $nom);
                        ++$i;
                    }
                    $pdf->SetFont('helvetica', 'B', 20, '', true);
                    $y += 10;
                    $pdf->writeHTMLCell(0, 0, $x, $y, 'Total: '.$total);
                }
            }
        }

    }

    $pdf->Output('Inscriptions.pdf', 'D');

}

?>