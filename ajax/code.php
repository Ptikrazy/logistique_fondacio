<?php
require_once '../include/init.php';
if(isset($_POST['code'])){
	$code = (String) trim($_POST['code']);
	$req =get_code($code);
	foreach($req as $r){
		echo $r['code']. ',' . $r['montant'] . ',' . $r['utilise'];
	}
	
}

?>