<?php require_once('../config.php'); 

if(isset($_GET['id_companie'])) {
	$s = mysql_query("SELECT `a`.`id_avion`,`a`.`serie`,`ta`.`tip`,`f`.`fabricant` FROM `companie_avioane` AS `ca` 
		INNER JOIN `avioane` AS `a` ON `ca`.`id_avion`=`a`.`id_avion` 
		INNER JOIN `tipuri_avion` AS `ta` ON `a`.`id_tip_avion`=`ta`.`id_tip_avion` 
		INNER JOIN `fabricanti` AS `f` ON `ta`.`id_fabricant`=`f`.`id_fabricant` 
		WHERE `ca`.`id_companie`='".cinp($_GET['id_companie'])."'
		");
	$total = mysql_num_rows($s);
		echo '[ ';
	$nr = 1; 
	while($r = mysql_fetch_array($s)) {
		echo '{"optionValue": '.$r['id_avion'].', "optionDisplay": "'.$r['fabricant'].' '.$r['tip'].' '.$r['serie'].'"}';
		if($nr!=$total) echo ',';
		$nr++;
	}
		echo ']';

}


?>