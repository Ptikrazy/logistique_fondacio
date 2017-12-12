<?php

require_once '../include/init.php';

$villes = get_villes_bus($_POST['aller_retour'], $_POST['camp']);

$str = '';

foreach ($villes as $ville) {
    $selected = '';
    if (isset($_POST['select_ville']) && ($_POST['select_ville'] == $ville)) {
        $selected = 'selected';
    }
    $str .= '<option value="'.$ville.'" '.$selected.'>'.$ville.'</option>';
}

echo $str;

?>