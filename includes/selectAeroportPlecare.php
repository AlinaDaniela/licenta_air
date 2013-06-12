<?php require_once('../config.php'); 

if(isset($_GET['id_aeroport_plecare'])) {
	$s = mysql_query("SELECT `rt`.`id_ruta`,`tS`.`tara`, `aeroS`.`denumire`,`aeroS`.`oras`,`aeroS`.`id_aeroport` FROM `aeroporturi` AS `aeroS`  
					  INNER JOIN `tari` AS `tS` ON `tS`.`id_tara` = `aeroS`.`id_tara`
					  WHERE `aeroS`.`id_aeroport` != '".cinp($_GET['id_aeroport_plecare'])."'");
	$total = mysql_num_rows($s);
		echo '[ ';
	$nr = 1; 
	while($r = mysql_fetch_array($s)) {	
		echo '{"optionValue": '.$r['id_aeroport'].', "optionDisplay": "'.$r['denumire'].', '.$r['oras'].','.$r['tara'].'"}';
		if($nr!=$total) echo ',';
		$nr++;
	}
		echo ']';

}


?>