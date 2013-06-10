<?php require_once('../config.php'); 

if(isset($_GET['id_fabricant'])) {
	$s = mysql_query("SELECT `ta`.`tip`,`ta`.`id_tip_avion`,`f`.`fabricant`,`f`.`id_fabricant` FROM `tipuri_avion` AS `ta` INNER JOIN `fabricanti` AS `f` ON `ta`.`id_fabricant`=`f`.`id_fabricant`
					  WHERE `ta`.`id_fabricant`='".cinp($_GET['id_fabricant'])."'");
	$total = mysql_num_rows($s);
		echo '[ ';
	$nr = 1; 
	while($r = mysql_fetch_array($s)) {	
		echo '{"optionValue": '.$r['id_tip_avion'].', "optionDisplay": "'.$r['fabricant'].' '.$r['tip'].'"}';
		if($nr!=$total) echo ',';
		$nr++;
	}
		echo ']';

}


?>