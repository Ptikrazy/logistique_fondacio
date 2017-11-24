<?php

require_once '../include/init.php';

$villes = get_villes_bus($_POST['aller_retour'], $_POST['camp']);

$str = '';

foreach ($villes as $ville) {
    $str .= '<option value="'.$ville.'">'.$ville.'</option>';
}

echo $str;

?>