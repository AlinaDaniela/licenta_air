<?php require_once("config.php");?>
 <?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user']) or $_SESSION['tip_user']!="admin") header("Location: cont.php");
?>
<?php 
if(isset($_GET['id_zbor'])) {
	$id_zbor = $_GET['id_zbor'];
	$s = mysql_query("SELECT * FROM `zboruri` WHERE `id_zbor`='".cinp($id_zbor)."' LIMIT 1");
    $r = mysql_fetch_assoc($s);
	$cod_zbor = $r['cod_zbor'];
	$sCA = mysql_query("SELECT * FROM `companie_avioane` WHERE `id_avion`='".$r['id_avion']."'");
	$rCA = mysql_fetch_assoc($sCA);
	$sC = mysql_query("SELECT * FROM `companii_aeriene` WHERE `id_companie` = '".$rCA['id_companie']."'");
	$rC = mysql_fetch_assoc($sC);
	$sA = mysql_query("SELECT `aP`.`denumire` AS `aeroport_plecare`, `tP`.`tara` AS `tara_plecare`, `aP`.`oras` AS `oras_plecare`, `aS`.`denumire` AS `aeroport_sosire`, `tS`.`tara` AS `tara_sosire`, `aS`.`oras` AS `oras_sosire`
						FROM `rute` AS  `rt` INNER JOIN `aeroporturi` AS `aP` ON `rt`.`id_aeroport_plecare` = `aP`.`id_aeroport` INNER JOIN `tari` AS `tP` ON  `tP`.`id_tara` = `aP`.`id_tara`
						INNER JOIN `aeroporturi` AS `aS` ON `rt`.`id_aeroport_sosire` = `aS`.`id_aeroport` INNER JOIN `tari` AS `tS` ON  `tS`.`id_tara` = `aS`.`id_tara` WHERE `rt`.`id_ruta` = '".$r['id_ruta']."'");
	$rA = mysql_fetch_assoc($sA);
	$zbor = $rC['cod'].$cod_zbor.", ".$rC['denumire']." : ".$rA['aeroport_plecare'].", ".$rA['oras_plecare'].", ".$rA['tara_plecare']." - ".$rA['aeroport_sosire'].", ".$rA['oras_sosire'].", ".$rA['tara_sosire'].", ".$rC['denumire'];
	$companie = $rC['id_companie']; 
	$avion = $r['id_avion'];
	$ruta = $r['id_ruta'];
	$data_plecare = date("d/m/Y",$r['data_plecare']);
	$ora_plecare = date("G",$r['data_plecare']);
	$minut_plecare = date("i",$r['data_plecare']);
	$data_sosire = date("d/m/Y",$r['data_sosire']);
	$ora_sosire = date("G",$r['data_plecare']);
	$minut_sosire = date("i",$r['data_plecare']);
	$status = $r['status'];
	
	if(isset($_GET['do']) and $status==1) header("Location: zboruri.php?id_zbor=".$id_zbor);
} 
?>
<?php  

 		if(isset($_POST['add_zbor']) or isset($_POST['edit_zbor'])) {

 			
			if(empty($_POST['cod_zbor'])) $err['cod_zbor'] = $lang['EROARE_COD_ZBOR_EMPTY']; 
 			else if(!is_numeric($_POST['cod_zbor'])) $err['cod_zbor'] = $lang['EROARE_WRONG_COD_ZBOR'];
 			else $cod_zbor = $_POST['cod_zbor'];
			
			if(empty($_POST['companie'])) $err['companie'] = $lang['EROARE_COMPANIE_EMPTY']; 
 			else $companie = $_POST['companie'];
			
			if(empty($_POST['avion'])) $err['avion'] = $lang['EROARE_AVION_EMPTY'];
 			else $avion= $_POST['avion'];

			if(empty($_POST['ruta'])) $err['ruta'] = $lang['EROARE_RUTA_EMPTY'];
 			else $ruta= $_POST['ruta'];
			
			if(empty($_POST['data_plecare']) or strlen($_POST['data_plecare'])!=10) $err['data_plecare'] = $lang['SELECTATI_DATA'];
			else if(!empty($_POST['data_plecare']) AND !preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$_POST['data_plecare'])) $err['data_plecare'] = $lang['SELECT_DATE_WRONG'];
			else $data_plecare = $_POST['data_plecare'];
			
			if(empty($_POST['minut_plecare'])) $err['minut_plecare'] = $lang['SELECTATI_MINUTUL'];
			else $minut_plecare = $_POST['minut_plecare'];
			
			if(empty($_POST['ora_plecare'])) $err['ora_plecare'] = $lang['SELECTATI_ORA'];
			else $ora_plecare = $_POST['ora_plecare'];
			
			if(empty($_POST['data_sosire']) or strlen($_POST['data_sosire'])!=10) $err['data_sosire'] = $lang['SELECTATI_DATA'];
			else if(!empty($_POST['data_sosire']) AND !preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$_POST['data_sosire'])) $err['data_sosire'] = $lang['SELECT_DATE_WRONG'];
			else $data_sosire = $_POST['data_sosire'];
			
			if(empty($_POST['minut_sosire'])) $err['minut_sosire'] = $lang['SELECTATI_MINUTUL'];
			else $minut_sosire = $_POST['minut_sosire'];
			
			if(empty($_POST['ora_sosire'])) $err['ora_sosire'] = $lang['SELECTATI_ORA'];
			else $ora_sosire = $_POST['ora_sosire'];
			
			if(isset($_POST['status'])) $status = 1;
 			else $status = 0;
			
			if(isset($data_plecare)) $data_plecare_separat = explode("/",$data_plecare); 
			if(isset($data_sosire)) $data_sosire_separat = explode("/",$data_sosire);
              
			 if(isset($data_plecare) and isset($data_sosire) and isset($ora_plecare) and isset($ora_plecare) and isset($minut_plecare) and isset($minut_sosire)){
			 
				$todays_date = date("MM/DD/YYYY");
				$today = strtotime($todays_date);
				$data_plecare_D = strtotime($data_plecare);
				$data_sosire_D = strtotime($data_sosire);
				$hour = date('H');
				$min = date('i');
				$Hour = (int)$hour;
				$MIN = (int)$min;
				
				if ($data_plecare_D < $today) 
					 $err['data_plecare'] = $lang['SELECT_DATE_PAST_WRONG'];
					 
				if ($data_sosire_D < $today) 
					 $err['data_sosire'] = $lang['SELECT_DATE_PAST_WRONG'];
				
				if ($data_sosire_D < $data_plecare_D) 
					 $err['data_sosire'] = $lang['SELECT_DATE_WRONG_WRONG'];
					 
				if(($data_sosire_D == $data_plecare_D) AND $ora_sosire < $ora_plecare)
					$err['data_plecare'] = $lang['SELECT_DATE_HOUR_WRONG'];
				
				if(($ora_sosire == $ora_plecare AND $data_sosire_D == $data_plecare_D) AND $minut_sosire <= ($minut_plecare) OR ($minut_sosire - $minut_plecare)<10)
					$err['data_plecare'] = $lang['SELECT_DATE_HOUR_WRONG'];
					
				if(($data_plecare_D == $today) AND $ora_plecare < $HOUR)
					$err['data_plecare'] = $lang['ORA_PLECARE_TODAY'];
				
				if(($data_plecare_D == $today) AND ($ora_plecare == $HOUR) AND $minut_plecare <= $MIN OR ($minut_plecare - $MIN) < 10)
					$err['data_plecare'] = $lang['MINUT_PLECARE_TODAY'];
					
				if(strlen($data_plecare_separat[0])!=2 OR $data_plecare_separat[0]<=0 OR $data_plecare_separat[0]>12)
				$err['data_plecare'] = $lang['SELECT_DATE_WRONG'];
				
				if(strlen($data_plecare_separat[1])!=2 OR $data_plecare_separat[1]<=0 OR $data_plecare_separat[1]>31)
				$err['data_plecare'] = $lang['SELECT_DATE_WRONG'];
				
				if(strlen($data_plecare_separat[2])!=4 OR $data_plecare_separat[2]<=0 OR $data_plecare_separat[0]>12)
				$err['data_plecare'] = $lang['SELECT_DATE_WRONG'];
				
				if(strlen($data_sosire_separat[0])!=2 OR $data_sosire_separat[0]<=0 OR $data_sosire_separat[0]>12)
				$err['data_sosire'] = $lang['SELECT_DATE_WRONG'];
				
				if(strlen($data_sosire_separat[1])!=2 OR $data_sosire_separat[1]<=0 OR $data_sosire_separat[1]>31)
				$err['data_sosire'] = $lang['SELECT_DATE_WRONG'];
				
				if(strlen($data_sosire_separat[2])!=4 OR $data_sosire_separat[2]<=0 OR $data_sosire_separat[0]>12)
				$err['data_sosire'] = $lang['SELECT_DATE_WRONG'];
			 }
		
			//se foloseste functia mktime() pentru a crea data UNIX care va fi comparata cu cea din baza de date
			if(isset($data_plecare) and isset($data_sosire) and isset($ora_plecare) and isset($ora_sosire) and isset($minut_plecare) and isset($minut_sosire)) { 
			$data_plecareF = mktime($ora_plecare,$minut_plecare,0,$data_plecare_separat[0],$data_plecare_separat[1],$data_plecare_separat[2]); 
			$data_sosireF = mktime($ora_sosire,$minut_sosire,0,$data_sosire_separat[0],$data_sosire_separat[1],$data_sosire_separat[2]); 
			}
			
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_zbor'])) { 
					
	 				$sql = "INSERT INTO `zboruri` SET ";
	 				$sql .= "`cod_zbor` = '".cinp($cod_zbor)."',";
					$sql .= "`id_avion` = '".cinp($avion)."',";
					$sql .= "`id_ruta` = '".cinp($ruta)."',";
					$sql .= "`data_plecare` = '".cinp($data_plecareF)."',";
					$sql .= "`data_sosire` = '".cinp($data_sosireF)."',";
					$sql .= "`status` = '".cinp($status)."'";

					$query = mysql_query($sql);
	 				echo $query;
	 				if($query) { 
						header("Location: zboruri.php?show=succes");
						unset($cod_zbor,$companie,$avion,$ruta,$status,$data_plecare,$data_sosire,$minut_plecare,$minut_sosire,$ora_plecare,$ora_sosire); 
					} 
				}

				if(isset($_POST['edit_zbor'])) { 
				
	 				$sql = "UPDATE `zboruri` SET ";
	 				$sql .= "`cod_zbor` = '".cinp($cod_zbor)."',";
					$sql .= "`id_avion` = '".cinp($avion)."',";
					$sql .= "`id_ruta` = '".cinp($ruta)."',";
					$sql .= "`data_plecare` = '".cinp($data_plecareF)."',";
					$sql .= "`data_sosire` = '".cinp($data_sosireF)."',";
					$sql .= "`status` = '".cinp($status)."'";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: zboruri.php?id_zbor=".$id_zbor."&show=succes");
						unset($cod_zbor,$companie,$avion,$ruta,$status,$data_plecare,$data_sosire,$minut_plecare,$minut_sosire,$ora_plecare,$ora_sosire); 
					} 
				}

 			}        
 		}    
		
	if(isset($_POST['alege_zbor'])) {
    if(empty($_POST['id_zbor'])) $err['id_zbor'] = $lang['ALEG_ZBOR_MODIF'];
    else {
        header("Location: zboruri.php?id_zbor=".$_POST['id_zbor']);
    }
	}
	
	
	
	if(isset($_GET['id_zbor_clasa'])) {
			$id_zbor_clasa = $_GET['id_zbor_clasa'];
			$s = mysql_query("SELECT * FROM `zbor_clasa` WHERE `id_zbor_clasa`='".cinp($id_zbor_clasa)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$pret_clasa = $r['pret_clasa'];
			$locuri_clasa = $r['nr_locuri'];
			$id_clasa = $r['id_clasa'];
			
			$s = mysql_query("SELECT * FROM `clase` WHERE `id_clasa`='".cinp($id_clasa)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$clasa = $r['clasa'];
	} 
		
	//VALIDAREA FORMULARULUI DE ASOCIERE CLASA
		if(isset($_POST['asociaza_clasa'])) {
			if(empty($_POST['id_clasa'])) $err['id_clasa'] = $lang['EROARE_CLASA_EMPTY']; 
 			else $id_clasa = $_POST['id_clasa'];
			
			if(empty($_POST['pret_clasa'])) $err['pret_clasa'] = $lang['EROARE_PRET_EMPTY']; 
			elseif(!empty($_POST['pret_clasa']) AND !is_float($_POST['pret_clasa']) OR $_POST['pret_clasa']<=0) $err['pret_clasa'] = $lang['EROARE_PRET_CL_WRONG_EMPTY']; 
 			else $pret_clasa = $_POST['pret_clasa'];
			
			if(empty($_POST['locuri_clasa'])) $err['locuri_clasa'] = $lang['EROARE_LOCURI_EMPTY']; 
			elseif(!empty($_POST['locuri_clasa']) AND  !is_int($_POST['locuri_clasa']) AND $_POST('locuri_clasa')<=0) $err['locuri_clasa'] = $lang['EROARE_LOCURI_INT_EMPTY']; 
			
			else {
				$s = mysql_query("SELECT `capacitate` FROM `avioane` WHERE `id_avion` = '".$avion."' LIMIT 1");
				$r = mysql_fetch_assoc($s);
				$cap_totala = $r['capacitate'];
							
				$sZ = mysql_query("SELECT SUM(`nr_locuri`) AS 'nr_locuri' FROM `zbor_clasa` WHERE `id_zbor` = '".$id_zbor."'");
				$rZ = mysql_fetch_assoc($sZ);
				$cap_ocupata = $rZ['nr_locuri'];
				$cap_ramasa  = $cap_totala-$cap_ocupata;
				if($_POST['locuri_clasa']>$cap_ramasa) $err['locuri_clasa'] = $lang['CAPACITATE_DEPASITA'];
				else $locuri_clasa = $_POST['locuri_clasa'];
			}
 			
 			if(count($err)==0) {
				if(!isset($id_zbor_clasa)) {
 					$sql = "INSERT INTO `zbor_clasa` SET ";
	 				$sql .= "`id_clasa` = '".cinp($id_clasa)."',";
	 				$sql .= "`id_zbor` = '".cinp($id_zbor)."',";
					$sql .= "`pret_clasa` = '".cinp($pret_clasa)."',";
					$sql .= "`nr_locuri` = '".cinp($locuri_clasa)."'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: zboruri.php?id_zbor=".$id_zbor."&do=asociaza_clasa&show=succes");
					} 
				} else {
					$sql = "UPDATE `zbor_clasa` SET ";
	 				$sql .= "`id_clasa` = '".cinp($id_clasa)."',";
					$sql .= "`pret_clasa` = '".cinp($pret_clasa)."',";
					$sql .= "`nr_locuri` = '".cinp($locuri_clasa)."'";
					$sql .= " WHERE `id_zbor_clasa`='".cinp($id_zbor_clasa)."' LIMIT 1";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: zboruri.php?id_zbor=".$id_zbor."&do=asociaza_clasa&show=succes_editare");
					} 
				}
 			}
		}
	
	//Sterge asociere clasa
	if(isset($_GET['id_zbor_clasa']) and isset($_GET['do']) and $_GET['do']=="del_zbor_clasa") {
			mysql_query("DELETE FROM `zbor_clasa`  WHERE `id_zbor_clasa`='".cinp($id_zbor_clasa)."' LIMIT 1");
			header("Location: zboruri.php?id_zbor=".$id_zbor."&do=asociaza_clasa&show=clasa_stearsa");
	}
	
	
	if(isset($_GET['id_zbor_bagaje_clasa'])) {
			$id_zbor_bagaje_clasa = $_GET['id_zbor_bagaje_clasa'];
			$s = mysql_query("SELECT * FROM `zbor_bagaje_clasa` WHERE `id_zbor_bagaje_clasa`='".cinp($id_zbor_bagaje_clasa)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$pret_bagaj = $r['pret'];
			$descriere_bagaj = $r['descriere'];
			$id_zbor_clasa = $r['id_zbor_clasa'];
			$id_tip_bagaj = $r['id_tip_bagaj'];
			
			$s = mysql_query("SELECT * FROM `tipuri_bagaj` WHERE `id_tip_bagaj`='".cinp($id_tip_bagaj)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$bagaj = $r['tip_bagaj'];
		} 
		
	//VALIDAREA FORMULARULUI DE ASOCIERE BAGAJ CLASA
		if(isset($_POST['asociaza_bagaj'])) {
			if(empty($_POST['id_tip_bagaj'])) $err['id_tip_bagaj'] = $lang['EROARE_BAGAJ_EMPTY']; 
 			else $id_tip_bagaj = $_POST['id_tip_bagaj'];
			
			if(empty($_POST['pret_bagaj'])) $err['pret_bagaj'] = $lang['EROARE_PRET_BAGAJ_EMPTY'];
			elseif(!empty($_POST['pret_bagaj']) AND !is_float($_POST['pret_bagaj']) OR $_POST['pret_bagaj']<0) $err['pret_bagaj'] = $lang['EROARE_PRET_BAGAJ_WRONG_EMPTY']; 			
 			else $pret_bagaj = $_POST['pret_bagaj'];
			
			if(empty($_POST['descriere_bagaj'])) $err['descriere_bagaj'] = $lang['EROARE_DESCRIERE_BAGAJ_EMPTY']; 
 			else $descriere_bagaj = $_POST['descriere_bagaj'];
			
 			if(count($err)==0) {
				if(!isset($id_zbor_bagaje_clasa)) {
 					$sql = "INSERT INTO `zbor_bagaje_clasa` SET ";
	 				$sql .= "`id_zbor_clasa` = '".cinp($id_zbor_clasa)."',";
	 				$sql .= "`id_tip_bagaj` = '".cinp($id_tip_bagaj)."',";
					$sql .= "`pret` = '".cinp($pret_bagaj)."',";
					$sql .= "`descriere` = '".cinp($descriere_bagaj)."'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: zboruri.php?id_zbor=".$id_zbor."&id_zbor_clasa=".$id_zbor_clasa."&do=asociaza_bagaj&show=succes");
					} 
				} else {
					$sql = "UPDATE `zbor_bagaje_clasa` SET ";
	 				$sql .= "`id_zbor_clasa` = '".cinp($id_zbor_clasa)."',";
	 				$sql .= "`id_tip_bagaj` = '".cinp($id_tip_bagaj)."',";
					$sql .= "`pret` = '".cinp($pret_bagaj)."',";
					$sql .= "`descriere` = '".cinp($descriere_bagaj)."' ";
					$sql .= " WHERE `id_zbor_bagaje_clasa`='".cinp($id_zbor_bagaje_clasa)."' LIMIT 1";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: zboruri.php?id_zbor=".$id_zbor."&id_zbor_clasa=".$id_zbor_clasa."&do=asociaza_bagaj&show=succes_editare");
					} 
				}
 			}
		}
	
	//Sterge asociere bagaj clasa
	if(isset($_GET['id_zbor_bagaje_clasa']) and isset($_GET['do']) and $_GET['do']=="del_zbor_bagaj_clasa") {
			mysql_query("DELETE FROM `zbor_bagaje_clasa`  WHERE `id_zbor_bagaje_clasa`='".cinp($id_zbor_bagaje_clasa)."' LIMIT 1");
			header("Location: zboruri.php?id_zbor=".$id_zbor."&id_zbor_clasa=".$id_zbor_clasa."&do=asociaza_bagaj&show=bagaj_sters");
	}
	
	
	if(isset($_GET['id_zbor_meniu_clasa'])) {
			$id_zbor_meniu_clasa = $_GET['id_zbor_meniu_clasa'];
			$s = mysql_query("SELECT * FROM `zbor_meniu_clasa` WHERE `id_zbor_meniu_clasa`='".cinp($id_zbor_meniu_clasa)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$id_zbor_clasa = $r['id_zbor_clasa'];
			$id_meniu = $r['id_meniu'];
			
			$s = mysql_query("SELECT * FROM `tipuri_meniu` WHERE `id_meniu`='".cinp($id_meniu)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$meniu = $r['denumire'];
		} 
		
	//VALIDAREA FORMULARULUI DE ASOCIERE MENIU CLASA
		if(isset($_POST['asociaza_meniu'])) {
			if(empty($_POST['id_meniu'])) $err['id_meniu'] = $lang['EROARE_MENIU_EMPTY']; 
 			else $id_meniu = $_POST['id_meniu'];
			

 			if(count($err)==0) {
				if(!isset($id_zbor_meniu_clasa)) {
 					$sql = "INSERT INTO `zbor_meniu_clasa` SET ";
	 				$sql .= "`id_zbor_clasa` = '".cinp($id_zbor_clasa)."',";
	 				$sql .= "`id_meniu` = '".cinp($id_meniu)."'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: zboruri.php?id_zbor=".$id_zbor."&id_zbor_clasa=".$id_zbor_clasa."&do=asociaza_meniu&show=succes");
					} 
				} 
 			}
		}
	
	//Sterge asociere bagaj clasa
	if(isset($_GET['id_zbor_meniu_clasa']) and isset($_GET['do']) and $_GET['do']=="del_zbor_meniu_clasa") {
			mysql_query("DELETE FROM `zbor_meniu_clasa`  WHERE `id_zbor_meniu_clasa`='".cinp($id_zbor_meniu_clasa)."' LIMIT 1");
			header("Location: zboruri.php?id_zbor=".$id_zbor."&id_zbor_clasa=".$id_zbor_clasa."&do=asociaza_meniu&show=meniu_sters");
	}
	
	
		if(isset($_GET['id_zbor_reduceri_clasa'])) {
			$id_zbor_reduceri_clasa = $_GET['id_zbor_reduceri_clasa'];
			$s = mysql_query("SELECT * FROM `zbor_reduceri_clasa` WHERE `id_zbor_reducere_clasa`='".cinp($id_zbor_reduceri_clasa)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$reducere = $r['reducere'];
			$id_zbor_clasa = $r['id_zbor_clasa'];
			$id_categorie_varsta = $r['id_categorie_varsta'];
			
			$s = mysql_query("SELECT * FROM `categorii_varsta` WHERE `id_categorie_varsta`='".cinp($id_categorie_varsta)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$categorie = $r['categorie'];
		} 
		
	//VALIDAREA FORMULARULUI DE ASOCIERE CATEGORIE DE VARSTA CLASA
		if(isset($_POST['asociaza_categorie'])) {
			if(empty($_POST['id_categorie_varsta'])) $err['id_categorie_varsta'] = $lang['EROARE_CATEGORIE_VARSTA_EMPTY']; 
 			else $id_categorie_varsta = $_POST['id_categorie_varsta'];
			
			if(empty($_POST['reducere'])) $err['reducere'] = $lang['EROARE_REDUCERE_EMPTY'];
			elseif(!empty($_POST['reducere']) AND !is_float($_POST['reducere']) OR $_POST['reducere']<=0 ) $err['reducere'] = $lang['EROARE_REDUCERE_CAT_WRONG_EMPTY']; 
 			else $reducere = $_POST['reducere'];
					
 			if(count($err)==0) {
				if(!isset($id_zbor_reduceri_clasa)) {
 					$sql = "INSERT INTO `zbor_reduceri_clasa` SET ";
	 				$sql .= "`id_zbor_clasa` = '".cinp($id_zbor_clasa)."',";
	 				$sql .= "`id_categorie_varsta` = '".cinp($id_categorie_varsta)."',";
					$sql .= "`reducere` = '".cinp($reducere)."'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: zboruri.php?id_zbor=".$id_zbor."&id_zbor_clasa=".$id_zbor_clasa."&do=asociaza_categorie&show=succes");
					} 
				} else {
					$sql = "UPDATE `zbor_reduceri_clasa` SET ";
	 				$sql .= "`id_zbor_clasa` = '".cinp($id_zbor_clasa)."',";
	 				$sql .= "`id_categorie_varsta` = '".cinp($id_categorie_varsta)."',";
					$sql .= "`reducere` = '".cinp($reducere)."' ";
					$sql .= " WHERE `id_zbor_reducere_clasa`='".cinp($id_zbor_reduceri_clasa)."' LIMIT 1";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: zboruri.php?id_zbor=".$id_zbor."&id_zbor_clasa=".$id_zbor_clasa."&do=asociaza_categorie&show=succes_editare");
					} 
				}
 			}
		}
	
	//Sterge asociere bagaj clasa
	if(isset($_GET['id_zbor_reduceri_clasa']) and isset($_GET['do']) and $_GET['do']=="del_zbor_categorie_clasa") {
			mysql_query("DELETE FROM `zbor_reduceri_clasa`  WHERE `id_zbor_reducere_clasa`='".cinp($id_zbor_reduceri_clasa)."' LIMIT 1");
			header("Location: zboruri.php?id_zbor=".$id_zbor."&id_zbor_clasa=".$id_zbor_clasa."&do=asociaza_categorie&show=categorie_stearsa");
	}
	
	
?>
<?php include_once 'head.php'; ?>
<?php include('header.php'); ?> 


<div class="main_content">
	<div class="wrap">
		<section>
			<?php 
				//DACA SE INTRODUCE UN ZBOR
				if(!isset($_GET['do'])){ 
			?>
			<h1><?php if(isset($id_zbor)) echo $lang['FORMULAR_ZBOR_EDIT']; else echo $lang['FORMULAR_ZBOR']; ?></h1>
				<form action="" method="post" name="zboruri_form" id="creare_zbor" action="">
 					
 						<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.((isset($id_zbor)) ? $lang['ZBOR_EDIT'] : $lang['ZBOR_ADD']).'</span>'; ?>

 						<div>
 							<?php if(isset($err['cod_zbor'])) echo '<span class="eroare">'.$err['cod_zbor'].'</span>'; ?>
 							<label><?php echo $lang['COD_ZBOR']; ?></label>
 							<input type="text" id="cod_zbor" maxlength="6" value="<?php if(isset($cod_zbor)) echo $cod_zbor;?>"  name="cod_zbor" placeholder="<?php echo $lang['COD_ZBOR']; ?>" autocomplete="off" required="required" />
 						</div>
					
 						<div>
 							<?php if(isset($err['companie'])) echo '<span class="eroare">'.$err['companie'].'</span>'; ?>
 							<label for="companie"><?php echo $lang['COMPANIE']; ?></label>
 							<select id="companie" name="companie" placeholder="<?php echo $lang['COMPANIE']; ?>"  autocomplete="off">
								<option></option>
								<?php 
 								$sql = mysql_query("SELECT * FROM `companii_aeriene`");
									while($rand = mysql_fetch_array($sql)) {
								?>
								<option value="<?php echo $rand['id_companie'];?>" <?php if(isset($companie) and $companie==$rand['id_companie']) echo 'selected'; ?>><?php echo $rand['denumire'];?></option>
								<?php
								}
								?>	
							</select>
 						</div>
						<div>
 							<?php if(isset($err['avion'])) echo '<span class="eroare">'.$err['avion'].'</span>'; ?>
 							<label for="avion"><?php echo $lang['AVION']; ?></label>
 							<select id="avion" name="avion" placeholder="<?php echo $lang['AVION']; ?>"  autocomplete="off">
								<option></option>
								<?php if(isset($id_zbor)) { ?>
									<?php 
									$sql = mysql_query("SELECT `a`.`id_avion`,`a`.`serie`,`ta`.`tip`,`f`.`fabricant` FROM `companie_avioane` AS `ca` 
										INNER JOIN `avioane` AS `a` ON `ca`.`id_avion`=`a`.`id_avion` 
										INNER JOIN `tipuri_avion` AS `ta` ON `a`.`id_tip_avion`=`ta`.`id_tip_avion` 
										INNER JOIN `fabricanti` AS `f` ON `ta`.`id_fabricant`=`f`.`id_fabricant` 
										WHERE `ca`.`id_companie`='".cinp($companie)."'");
										while($rand = mysql_fetch_array($sql)) {
									?>
									<option value="<?php echo $rand['id_avion'];?>" <?php if(isset($avion) and $avion==$rand['id_avion']) echo 'selected'; ?>><?php echo $rand['fabricant'].' '.$rand['tip'].' '.$rand['serie'];?></option>
									<?php
									}
									?>
								<?php } ?>
							</select>
 						</div>
						<div>
 							<?php if(isset($err['ruta'])) echo '<span class="eroare">'.$err['ruta'].'</span>'; ?>
 							<label for="ruta"><?php echo $lang['RUTA']; ?></label>
 							<select id="ruta" name="ruta" placeholder="<?php echo $lang['RUTA']; ?>"  autocomplete="off">
								<option></option>
								<?php 
 								$sql = mysql_query("SELECT * FROM `rute`");
									while($rand = mysql_fetch_array($sql)) {
										$sqlP = mysql_query("SELECT * FROM `aeroporturi` WHERE `id_aeroport` ='".$rand['id_aeroport_plecare']."' LIMIT 1");
										echo $sqlP;
										$rP = mysql_fetch_assoc($sqlP);
										$sqlPT = mysql_query("SELECT * FROM `tari` WHERE `id_tara` ='".$rP['id_tara']."' LIMIT 1");
										$rPT = mysql_fetch_assoc($sqlPT);
										$sqlS = mysql_query("SELECT * FROM `aeroporturi` WHERE `id_aeroport` ='".$rand['id_aeroport_sosire']."' LIMIT 1");
										$rS = mysql_fetch_assoc($sqlS);
										$sqlST = mysql_query("SELECT * FROM `tari` WHERE `id_tara` ='".$rS['id_tara']."' LIMIT 1");
										$rST = mysql_fetch_assoc($sqlST);
								
								?>
								<option value="<?php echo $rand['id_ruta'];?>" <?php if(isset($ruta) and $ruta==$rand['id_ruta']) echo 'selected'; ?>><?php echo $rP['denumire'].", ".$rPT['tara']." - ".$rS['denumire'].", ".$rST['tara'];?></option>
								<?php
								}
								?>	
							</select>
 						</div>
						<div>
							<?php if(isset($err['data_plecare'])) echo '<span class="eroare">'.$err['data_plecare'].'</span>'; ?>
							<label><?php echo $lang['DATA_PLECARE'];?></label><br />
							<input type="text" id="data_plecare" name="data_plecare" value="<?php if(isset($data_plecare)) echo $data_plecare;?>" class="date-pick tiny"/>
							<?php if(isset($err['ora_plecare'])) echo '<span class="eroare">'.$err['ora_plecare'].'</span>'; ?>
							<select id="ora_plecare" name="ora_plecare" placeholder="<?php echo $lang['ORA']; ?>"  autocomplete="off" class="tiny ">
								<option></option>
								<?php for($i=0;$i<=23;$i++) {?>
									<option value="<?php echo $i; ?>" <?php if(isset($ora_plecare) and $ora_plecare==$i) echo 'selected';?> ><?php echo $i; ?></option>
								<?php } ?>
							</select>
							<?php if(isset($err['minut_plecare'])) echo '<span class="eroare">'.$err['minut_plecare'].'</span>'; ?>
							<select id="minut_plecare" name="minut_plecare" placeholder="<?php echo $lang['MINUT']; ?>"  autocomplete="off" class="tiny ">
								<option></option>
								<?php for($i=0;$i<=59;$i++) { ?>
									<option value="<?php echo $i; ?>" <?php if(isset($minut_plecare) and $minut_plecare==$i) echo 'selected';?>><?php echo $i; ?></option>
								<?php } ?>
							</select>
						</div>
						<div>
							<?php if(isset($err['data_sosire'])) echo '<span class="eroare">'.$err['data_sosire'].'</span>'; ?>
							<label><?php echo $lang['DATA_SOSIRE'];?></label><br /><input type="text" id="data_sosire" name="data_sosire" value="<?php if(isset($data_sosire)) echo $data_sosire;?>" class="date-pick tiny"/>
							<?php if(isset($err['ora_sosire'])) echo '<span class="eroare">'.$err['ora_sosire'].'</span>'; ?>
							<select id="ora_sosire" name="ora_sosire" placeholder="<?php echo $lang['ORA']; ?>"  autocomplete="off" class="tiny ">
								<option></option>
								<?php for($i=0;$i<=23;$i++) { ?>
									<option value="<?php echo $i; ?>" <?php if(isset($ora_sosire) and $ora_sosire==$i) echo 'selected';?> ><?php echo $i; ?></option>
								<?php } ?>
							</select>
							<?php if(isset($err['minut_sosire'])) echo '<span class="eroare">'.$err['minut_sosire'].'</span>'; ?>
							<select id="minut_sosire" name="minut_sosire" placeholder="<?php echo $lang['MINUT']; ?>"  autocomplete="off" class="tiny ">
								<option></option>
								<?php for($i=0;$i<=59;$i++) { ?>
									<option value="<?php echo $i; ?>" <?php if(isset($minut_sosire) and $minut_sosire==$i) echo 'selected';?> ><?php echo $i; ?></option>
								<?php } ?>
							</select>
						</div>
						<?php if(isset($id_zbor)) {?>
							<div>
								<label><?php echo $lang['ACTIV'];?></label>
								<input type="checkbox" name="status" value="1" <?php if(isset($status) and $status==0) echo ''; else echo 'checked'; ?> /></td>
							</div>
						<?php } ?>
 						<div>
 							<input type="submit" id="x" name="<?php if(isset($id_zbor)) echo 'edit_zbor'; else echo 'add_zbor'; ?>" value="<?php if(isset($id_zbor)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" />
 						</div>

 					</table>
				</form>
				
				<form name="alegere_zbor" action="" method="post">
    				<label><?php echo $lang['SELECT_THE_FLIGHT_MODIF'];?></label><br />
                        <?php if(isset($err['id_zbor'])) echo '<span class="eroare">'.$err['id_zbor'].'</span>'; ?>
    					<select name="id_zbor" id="id_zbor">                            
    						<option value=""></option>		
                            <?php $s = mysql_query("SELECT * FROM `zboruri` ORDER BY `data_plecare` ASC");
                                while($r = mysql_fetch_array($s)) { 
									$sR = mysql_query("SELECT * FROM `rute` WHERE `id_ruta` = '".$r['id_ruta']."'");
									$rR = mysql_fetch_assoc($sR);
									$sAP = mysql_query("SELECT * FROM `aeroporturi` WHERE `id_aeroport` = '".$rR['id_aeroport_plecare']."'");
									$rAP = mysql_fetch_assoc($sAP);
									$sTAP = mysql_query("SELECT * FROM `tari` WHERE `id_tara` = '".$rAP['id_tara']."'");
									$rTAP = mysql_fetch_assoc($sTAP);
									$sAS = mysql_query("SELECT * FROM `aeroporturi` WHERE `id_aeroport` = '".$rR['id_aeroport_sosire']."'");
									$rAS = mysql_fetch_assoc($sAS);
									$sTAS = mysql_query("SELECT * FROM `tari` WHERE `id_tara` = '".$rAS['id_tara']."'");
									$rTAS = mysql_fetch_assoc($sTAS);
									$sA = mysql_query("SELECT * FROM `companie_avioane` WHERE `id_avion`='".$r['id_avion']."'");
									$rA = mysql_fetch_assoc($sA);
									$sC = mysql_query("SELECT * FROM `companii_aeriene` WHERE `id_companie` = '".$rA['id_companie']."'");
									$rC = mysql_fetch_assoc($sC);
                            ?>
                            <option value="<?php echo $r['id_zbor'];?>" <?php if(isset($id_zbor) and $id_zbor ==$r['id_zbor']) echo 'selected'; ?> ><?php echo $r['cod_zbor'].", ".$rAP['denumire'].", ".$rAP['oras'].", ".$rTAP['tara']." - ".$rAS['denumire'].", ".$rAS['oras'].", ".$rTAS['tara']." - ".$rC['denumire'];?></option>		
                            <?php } ?>
    					</select><br/>
                        <input type="submit" name="alege_zbor" value="<?php echo $lang['ALEGE_ZBOR'];?>" />
                </form><br /><br />
				<?php } else { ?>
					<?php if(isset($id_zbor)) { ?>
						
						<?php if($_GET['do']=="asociaza_clasa") { ?>
							<form name="asociere_clasa" action="" method="post">								
								<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.$lang['CLASA_ASOCIERE'].'</span>'; ?>
								<?php if(isset($_GET['show']) and $_GET['show']=="succes_editare") echo '<span class="succes">Clasa a fost editata.</span>'; ?>
								<?php if(isset($_GET['show']) and $_GET['show']=="clasa_stearsa") echo '<span class="succes">Clasa a fost stearsa.</span>'; ?>
								<div>
								<label><?php echo $lang['SELECT_THE_CLASS_ASOC'];?></label><br />
									<?php if(isset($err['id_clasa'])) echo '<span class="eroare">'.$err['id_clasa'].'</span>'; ?>
									<select name="id_clasa" id="id_clasa">                            
										<option value=""></option>		
										<?php 
										
										$s = mysql_query("SELECT  `cl`.`clasa` ,  `cl`.`id_clasa` ,  `ca`.`id_companie` ,  `ca`.`denumire` ,`zb`.`id_zbor`
															FROM  `zboruri` AS  `zb` 
															INNER JOIN  `companie_avioane` AS  `c_a` ON  `zb`.`id_avion` =  `c_a`.`id_avion` 
															INNER JOIN  `companii_aeriene` AS  `ca` ON  `c_a`.`id_companie` =  `ca`.`id_companie` 
															INNER JOIN  `companie_clase` AS  `cc` ON  `ca`.`id_companie` =  `cc`.`id_companie` 
															INNER JOIN  `clase` AS  `cl` ON  `cc`.`id_clasa` =  `cl`.`id_clasa` 
															WHERE  `zb`.`id_zbor` =  '".$id_zbor."' AND `cc`.`status` = '1'");
										
										while($r = mysql_fetch_array($s)) { 
											if(!isset($id_zbor_clasa)) { 
												if(mysql_num_rows(mysql_query("SELECT `id_clasa` FROM `zbor_clasa` WHERE `id_clasa`='".$r['id_clasa']."' AND `id_zbor`='".cinp($id_zbor)."' LIMIT 1"))==0) {
										?>
												<option value="<?php echo $r['id_clasa'];?>" <?php if(isset($id_clasa) and $id_clasa ==$r['id_clasa']) echo 'selected'; ?> ><?php echo $r['clasa'];?></option>		
										<?php 	}
											} else { ?>	
												<option value="<?php echo $r['id_clasa'];?>" <?php if(isset($id_clasa) and $id_clasa ==$r['id_clasa']) echo 'selected'; ?> ><?php echo $r['clasa'];?></option>	
										<?php } 
										}//while?>
									</select><br/>
								</div>
								<div>
									<?php if(isset($err['pret_clasa'])) echo '<span class="eroare">'.$err['pret_clasa'].'</span>'; ?>
									<label><?php echo $lang['PRET']; ?></label>
									<input type="text" id="pret_clasa" maxlength="6" value="<?php if(isset($pret_clasa)) echo $pret_clasa;?>"  name="pret_clasa" placeholder="<?php echo $lang['PRET']; ?>" autocomplete="off" required="required" />
								</div>
								<div>
									<?php if(isset($err['locuri_clasa'])) echo '<span class="eroare">'.$err['locuri_clasa'].'</span>'; ?>
									<label><?php echo $lang['LOCURI']; ?></label>
									<input type="text" id="locuri_clasa" maxlength="6" value="<?php if(isset($locuri_clasa)) echo $locuri_clasa;?>"  name="locuri_clasa" placeholder="<?php echo $lang['LOCURI']; ?>" autocomplete="off" required="required" />
								</div>
								<div>
									<input type="submit" name="asociaza_clasa" value="<?php echo $lang['ASOCIAZA_CLASA'];?>" />
								</div>
							</form><br /><br />
						
							<div class="rezultate_existente">

							<h3><?php echo $lang['CLASE_ASOC_ZBOR'];?><?php echo $zbor; ?></h3>
							<table>
								<tr class="table_head"><td><?php echo $lang['CLASA'];?></td><td><?php echo $lang['PRET'];?></td><td><?php echo $lang['CLASA_CAPACITATE'];?></td><td><?php echo $lang['ADAUGARI'];?></td><td><?php echo $lang['OPERATIUNI'];?></td></td>
								<?php 
											 
									$s = mysql_query("SELECT `cl`.`clasa`,`cc`.`status`,`zc`.`id_zbor_clasa`,`cc`.`id_companie_clasa`,`zc`.`pret_clasa`,`zc`.`nr_locuri` FROM `zbor_clasa` AS `zc` INNER JOIN `zboruri` AS `zb` ON `zc`.`id_zbor` = `zb`.`id_zbor`
													  INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa` 
													  INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa` = `cc`.`id_clasa`
													  WHERE `zb`.`id_zbor` = '".cinp($id_zbor)."' GROUP BY `zc`.`id_zbor_clasa`");
									while($r_clasa = mysql_fetch_array($s)) { 
										echo '<tr>';
											echo '<td>'.$r_clasa['clasa'].'</td>
												 <td>'.$r_clasa['pret_clasa'].'</td>
												 <td>'.$r_clasa['nr_locuri'].'</td>';
											echo '<td><a href="zboruri.php?id_zbor='.$id_zbor.'&amp;id_zbor_clasa='.$r_clasa['id_zbor_clasa'].'&amp;do=asociaza_bagaj">'.$lang['ADAUGA_BAGAJE'].'</a><br/>
												<a href="zboruri.php?id_zbor='.$id_zbor.'&amp;id_zbor_clasa='.$r_clasa['id_zbor_clasa'].'&amp;do=asociaza_meniu">'.$lang['ADAUGA_MENIURI'].'</a><br/>
												<a href="zboruri.php?id_zbor='.$id_zbor.'&amp;id_zbor_clasa='.$r_clasa['id_zbor_clasa'].'&amp;do=asociaza_categorie">'.$lang['ADAUGA_REDUCERI'].'</a><br/>
												</td>';
											echo '<td>
													<a href="zboruri.php?id_zbor='.$id_zbor.'&amp;id_zbor_clasa='.$r_clasa['id_zbor_clasa'].'&do=asociaza_clasa">
														'.$lang['EDITEAZA'].'
													</a><br/>
													<a href="zboruri.php?id_zbor='.$id_zbor.'&amp;id_zbor_clasa='.$r_clasa['id_zbor_clasa'].'&do=del_zbor_clasa" class="delete">
														'.$lang['STERGE'].'
													</a>
												 </td>';
										echo '</tr>';
									} 
								?>
							</table>
							</div>
						<?php }  ?>
						
						<?php if(isset($_GET['do']) and  $_GET['do']=="asociaza_bagaj" and isset($id_zbor_clasa)) { ?>
							<h2><?php echo $lang['SE_ASOC_ZB']; ?><b><?php echo $zbor; ?></b>, <?php echo $lang['CLASA_'];?> <b><?php echo $clasa; ?></b></h2>
								<form name="asociere_bagaj" action="" method="post">								
									<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.$lang['BAGAJ_ASOCIERE'].'</span>'; ?>
									<?php if(isset($_GET['show']) and $_GET['show']=="succes_editare") echo '<span class="succes">'.$lang['BAGAJ_TIP_EDITAT'].'</span>'; ?>
									<?php if(isset($_GET['show']) and $_GET['show']=="bagaj_sters") echo '<span class="succes">'.$lang['BAGAJ_TIP_STERS'].'</span>'; ?>
									<div>
									<label><?php echo $lang['SELECT_BAGAJ_TO_ASSOC_CLASS'];?><b><?php echo $clasa; ?> </label><br />
										<?php if(isset($err['id_tip_bagaj'])) echo '<span class="eroare">'.$err['id_tip_bagaj'].'</span>'; ?>
										<select name="id_tip_bagaj" id="id_tip_bagaj">                            
											<option value=""></option>		
											<?php 
											
											$s = mysql_query("SELECT `tb`.`tip_bagaj`,`tb`.`id_tip_bagaj`, `c_a`.`id_companie`, `c_a`.`denumire` 
															FROM `zboruri` AS `zb`
															INNER JOIN `companie_avioane` AS `ca` ON `zb`.`id_avion` = `ca`.`id_avion`
															INNER JOIN `companii_aeriene` AS `c_a` ON `c_a`.`id_companie` = `ca`.`id_companie`
															INNER JOIN `bagaje_companie` AS `bc` ON `bc`.`id_companie` = `c_a`.`id_companie`
															INNER JOIN `tipuri_bagaj` AS `tb` ON `tb`.`id_tip_bagaj` = `bc`.`id_tip_bagaj`
															WHERE `zb`.`id_zbor` = '".$id_zbor."' AND `bc`.`status` = '1'");

											while($r = mysql_fetch_array($s)) { 
												if(!isset($pret_bagaj)) {
													//if(mysql_num_rows(mysql_query("SELECT `id_tip_bagaj` FROM `zbor_bagaje_clasa` WHERE `id_tip_bagaj`='".$r['id_tip_bagaj']."' AND `id_zbor_clasa`='".cinp($id_zbor_clasa)."' LIMIT 1")) == 0 ) {
											?>
													<option value="<?php echo $r['id_tip_bagaj'];?>" <?php if(isset($id_tip_bagaj) and $id_tip_bagaj ==$r['id_tip_bagaj']) echo 'selected'; ?> ><?php echo $r['tip_bagaj'];?></option>
											<?php //}
												} else { 
											?>
													<option value="<?php echo $r['id_tip_bagaj'];?>" <?php if(isset($id_tip_bagaj) and $id_tip_bagaj ==$r['id_tip_bagaj']) echo 'selected'; ?> ><?php echo $r['tip_bagaj'];?></option>
											<?php 	}
											}//while?>
										</select><br/>
									</div>
									<div>
										<?php if(isset($err['descriere_bagaj'])) echo '<span class="eroare">'.$err['descriere_bagaj'].'</span>'; ?>
										<label><?php echo $lang['DESCRIERE_BAGAJ']; ?></label>
										<input type="text" id="descriere_bagaj" value="<?php if(isset($descriere_bagaj)) echo $descriere_bagaj;?>"  name="descriere_bagaj" placeholder="<?php echo $lang['DESCRIERE_BAGAJ']; ?>" autocomplete="off" required="required" />
									</div>
									<div>
										<?php if(isset($err['pret_bagaj'])) echo '<span class="eroare">'.$err['pret_bagaj'].'</span>'; ?>
										<label><?php echo $lang['PRET_BAGAJ']; ?></label>
										<input type="text" id="pret_bagaj"  value="<?php if(isset($pret_bagaj)) echo $pret_bagaj;?>"  name="pret_bagaj" placeholder="<?php echo $lang['PRET_BAGAJ']; ?>" autocomplete="off" required="required" />
									</div>
									<div>
										<input type="submit" name="asociaza_bagaj" value="<?php echo $lang['ASOC_TIP_BAGAJ_CLASEI'];?>" />
									</div>
								</form><br /><br />
							
								<div class="rezultate_existente">

								<h3><?php echo $lang['TIP_BAGAJ_ASOC_ZB'];?><?php echo $zbor; ?> <?php echo $lang['CLASA_'];?> <?php echo $clasa ?></h3>
								<table>
									<tr class="table_head"><td><?php echo $lang['TIP_BAGAJ'];?></td><td><?php echo $lang['DESCRIERE_BAGAJ'];?></td><td><?php echo $lang['PRET'];?></td><td><?php echo $lang['OPERATIUNI'];?></td></td>
									<?php 

										$s = mysql_query("SELECT `zbc`.`id_zbor_bagaje_clasa`,`zbc`.`descriere`,`zbc`.`pret`,`tb`.`tip_bagaj`, `zc`.`id_zbor_clasa`, `bc`.`id_bagaje_companie` , `zb`.`status` AS `status_zbor`
														  FROM `zbor_bagaje_clasa` AS `zbc` INNER JOIN `zbor_clasa` AS `zc` ON `zbc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa`
														  INNER JOIN `zboruri` AS `zb` ON `zb`.`id_zbor` = `zc`.`id_zbor`
														  INNER JOIN `bagaje_companie` AS `bc` ON `bc`.`id_tip_bagaj`=`zbc`.`id_tip_bagaj`
														  INNER JOIN `tipuri_bagaj` AS `tb` ON `tb`.`id_tip_bagaj` = `bc`.`id_tip_bagaj`
														  WHERE `zb`.`id_zbor`  = '".cinp($id_zbor)."' AND `zc`.`id_zbor_clasa` = '".$id_zbor_clasa."' GROUP BY `zbc`.`id_zbor_bagaje_clasa` ");	 
										while($r_zbor = mysql_fetch_array($s)) { 
											echo '<tr>';
												echo '<td>'.$r_zbor['tip_bagaj'].'</td>';
												echo '<td>'.$r_zbor['descriere'].'</td>';
												echo '<td>'.$r_zbor['pret'].'</td>';
												echo '<td>
														<a href="zboruri.php?id_zbor='.$id_zbor.'&amp;id_zbor_clasa='.$r_zbor['id_zbor_clasa'].'&id_zbor_bagaje_clasa='.$r_zbor['id_zbor_bagaje_clasa'].'&do=asociaza_bagaj">
															'.$lang['EDITEAZA'].'
														</a><br/>
														<a href="zboruri.php?id_zbor='.$id_zbor.'&amp;id_zbor_clasa='.$r_zbor['id_zbor_clasa'].'&id_zbor_bagaje_clasa='.$r_zbor['id_zbor_bagaje_clasa'].'&do=del_zbor_bagaj_clasa" class="delete">
															'.$lang['STERGE'].'
														</a>
													 </td>';
												echo '</tr>';
										} 
									?>
								</table>
								</div>
						<?php } ?>
						
						<?php if(isset($_GET['do']) and  $_GET['do']=="asociaza_meniu" and isset($id_zbor_clasa)) { ?>
							<h2><?php echo $lang['SE_ASOC_ZB']; ?><b><?php echo $zbor; ?></b>, <?php echo $lang['CLASA_'];?> <b><?php echo $clasa; ?></b></h2>
								<form name="asociere_meniu" action="" method="post">								
									<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.$lang['MENIU_ASOCIERE'].'</span>'; ?>
									<?php if(isset($_GET['show']) and $_GET['show']=="meniu_sters") echo '<span class="succes">'.$lang['MENIU_F_STERS'].'</span>'; ?>
									<div>
									<label><?php echo $lang['SELECT_TIP_MENIU_ASOC_CLASA'];?><b><?php echo $clasa; ?> </label><br />
										<?php if(isset($err['id_meniu'])) echo '<span class="eroare">'.$err['id_meniu'].'</span>'; ?>
										<select name="id_meniu" id="id_meniu">                            
											<option value=""></option>		
											<?php 
											
											$s = mysql_query("SELECT `tm`.`id_meniu`, `tm`.`denumire`, `c_a`.`id_companie`,`c_a`.`denumire` AS `denumire_companie` 
															 FROM `zboruri` AS `zb`
															 INNER JOIN `companie_avioane` AS `ca` ON `zb`.`id_avion` = `ca`.`id_avion`
															 INNER JOIN `companii_aeriene` AS `c_a` ON `c_a`.`id_companie` = `ca`.`id_companie`
															 INNER JOIN `meniu_companie` AS `mc` ON `mc`.`id_companie` = `c_a`.`id_companie`
															 INNER JOIN `tipuri_meniu` AS `tm` ON `tm`.`id_meniu` = `mc`.`id_meniu`
															 WHERE `zb`.`id_zbor` = '".$id_zbor."' AND `mc`.`status` = '1'");

											
											while($r = mysql_fetch_array($s)) { 
													if(mysql_num_rows(mysql_query("SELECT `id_meniu` FROM `zbor_meniu_clasa` WHERE `id_meniu`='".$r['id_meniu']."' AND `id_zbor_clasa`='".cinp($id_zbor_clasa)."' LIMIT 1")) == 0 ) {
											?>
													<option value="<?php echo $r['id_meniu'];?>" <?php if(isset($id_meniu) and $id_meniu ==$r['id_meniu']) echo 'selected'; ?> ><?php echo $r['denumire'];?></option>		
											<?php 	}
											}//while?>
										</select><br/>
									</div>
									<div>
										<input type="submit" name="asociaza_meniu" value="<?php echo $lang['ASOC_TIP_MENIU'];?>" />
									</div>
								</form><br /><br />
							
								<div class="rezultate_existente">

								<h3><?php echo $lang['TIP_MENIU_ASOC_ZBOR'];?><?php echo $zbor; ?> <?php echo $lang['CLASA_'];?> <?php echo $clasa ?></h3>
								<table>
									<tr class="table_head"><td><?php echo $lang['TIP_MENIU'];?></td><td><?php echo $lang['OPERATIUNI'];?></td></td>

									<?php 
										$s = mysql_query("SELECT `zmc`.`id_zbor_meniu_clasa`, `tm`.`denumire`, `zc`.`id_zbor_clasa`, `mc`.`id_meniu_companie`, `zb`.`status` AS `status_zbor`
														  FROM `zbor_meniu_clasa` AS `zmc` INNER JOIN `zbor_clasa` AS `zc` ON  `zmc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa`
														  INNER JOIN `zboruri` AS `zb` ON `zb`.`id_zbor` = `zc`.`id_zbor`
														  INNER JOIN `meniu_companie` AS `mc` ON `mc`.`id_meniu`=`zmc`.`id_meniu`
														  INNER JOIN `tipuri_meniu` AS `tm` ON `tm`.`id_meniu` = `mc`.`id_meniu`
														  WHERE `zb`.`id_zbor`  = '".cinp($id_zbor)."' AND `zc`.`id_zbor_clasa` = '".$id_zbor_clasa."' LIMIT 1");
														  			  
										while($r_zbor = mysql_fetch_array($s)) { 
											echo '<tr>';
											echo '<td>'.$r_zbor['denumire'].'</td>';
											echo '<td>
													<a href="zboruri.php?id_zbor='.$id_zbor.'&amp;id_zbor_clasa='.$r_zbor['id_zbor_clasa'].'&id_zbor_meniu_clasa='.$r_zbor['id_zbor_meniu_clasa'].'&do=del_zbor_meniu_clasa" class="delete">
														'.$lang['STERGE'].'
													</a>
												 </td>';
											echo '</tr>';
										} 
									?>
								</table>
								</div>
						<?php } ?>
						<?php if(isset($_GET['do']) and  $_GET['do']=="asociaza_categorie" and isset($id_zbor_clasa)) { ?>
							<h2><?php echo $lang['SE_ASOC_ZB'];?><b><?php echo $zbor; ?></b>, <?php echo $lang['CLASA_'];?> <b><?php echo $clasa; ?></b></h2>
								<form name="asociere_categorie" action="" method="post">								
									<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.$lang['REDUCERE_ASOCIERE'].'</span>'; ?>
									<?php if(isset($_GET['show']) and $_GET['show']=="succes_editare") echo '<span class="succes">'.$lang['REDUCERE_CATEGORIE_EDIT'].'</span>'; ?>
									<?php if(isset($_GET['show']) and $_GET['show']=="categorie_stearsa") echo '<span class="succes">'.$lang['REDUCERE_CATEGORIE_STERS'].'</span>'; ?>
									<div>
									<label><?php echo $lang['SELECT_CAT_RED_CL'];?><b><?php echo $clasa; ?> </label><br />
										<?php if(isset($err['id_categorie_varsta'])) echo '<span class="eroare">'.$err['id_categorie_varsta'].'</span>'; ?>
										<select name="id_categorie_varsta" id="id_categorie_varsta">                            
											<option value=""></option>		
											<?php 
											
											
											$s = mysql_query("SELECT  `cv`.`categorie` ,`cv`.`id_categorie_varsta`, `c_a`.`id_companie`, `c_a`.`denumire`, `zb`.`id_zbor`
															FROM `zboruri` AS `zb`
															INNER JOIN `companie_avioane` AS `ca` ON `zb`.`id_avion` = `ca`.`id_avion`
															INNER JOIN `companii_aeriene` AS `c_a` ON `c_a`.`id_companie` = `ca`.`id_companie`
															INNER JOIN `companie_reduceri_categorii` AS  `crc` ON  `c_a`.`id_companie` =  `crc`.`id_companie` 
															INNER JOIN  `categorii_varsta` AS  `cv` ON  `crc`.`id_categorie_varsta` =  `cv`.`id_categorie_varsta` 
															WHERE  `zb`.`id_zbor` =  '".$id_zbor."' AND `crc`.`status` = '1'");
											
											while($r = mysql_fetch_array($s)) { 
												if(!isset($id_zbor_reduceri_clasa)) {
													if(mysql_num_rows(mysql_query("SELECT `id_categorie_varsta` FROM `zbor_reduceri_clasa` WHERE `id_categorie_varsta`='".$r['id_categorie_varsta']."' AND `id_zbor_clasa`='".cinp($id_zbor_clasa)."' LIMIT 1")) == 0 ) {
											?>
													<option value="<?php echo $r['id_categorie_varsta'];?>" <?php if(isset($id_categorie_varsta) and $id_categorie_varsta ==$r['id_categorie_varsta']) echo 'selected'; ?> ><?php echo $r['categorie'];?></option>		
											<?php 	}
												} else { ?>
												<option value="<?php echo $r['id_categorie_varsta'];?>" <?php if(isset($id_categorie_varsta) and $id_categorie_varsta ==$r['id_categorie_varsta']) echo 'selected'; ?> ><?php echo $r['categorie'];?></option>		
											<?php
												}
											}//while?>
										</select><br/>
									</div>
									<div>
										<?php if(isset($err['reducere'])) echo '<span class="eroare">'.$err['reducere'].'</span>'; ?>
										<label><?php echo $lang['REDUCERE_CATEGORIE']; ?></label>
										<input type="text" id="reducere"  value="<?php if(isset($reducere)) echo $reducere;?>"  name="reducere" placeholder="<?php echo $lang['REDUCERE']; ?>" autocomplete="off" required="required" />
									</div>
									<div>
										<input type="submit" name="asociaza_categorie" value="<?php echo $lang['ASSOC_RED_CAT_CL'];?>" />
									</div>
								</form><br /><br />
							
								<div class="rezultate_existente">

								<h3><?php echo $lang['REDUCERE_CATEGORIE_ZBOR'];?><?php echo $zbor; ?> <?php echo $lang['CLASA_'];?> <?php echo $clasa ?></h3>
								<table>
									<tr class="table_head"><td><?php echo $lang['CATEGORIA_DE_VARSTA'];?></td><td><?php echo $lang['DISCOUNT'];?></td><td><?php echo $lang['OPERATIUNI'];?></td></td>
									<?php 
										
										$s = mysql_query("SELECT `zrc`.`id_zbor_reducere_clasa`, `zrc`.`reducere`, `cv`.`categorie`, `zc`.`id_zbor_clasa`, `crc`.`id_comp_red_cat`, `zb`.`status` AS `status_zbor`
														  FROM `zbor_reduceri_clasa` AS `zrc` INNER JOIN `zbor_clasa` AS `zc` ON `zrc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa`
														  INNER JOIN `zboruri` AS `zb` ON `zb`.`id_zbor` = `zc`.`id_zbor`
														  INNER JOIN `companie_reduceri_categorii` AS `crc` ON `crc`.`id_categorie_varsta` = `zrc`.`id_categorie_varsta`
														  INNER JOIN `categorii_varsta` AS `cv` ON `cv`.`id_categorie_varsta` = `crc`.`id_categorie_varsta`
														  WHERE `zb`.`id_zbor` = '".cinp($id_zbor)."' AND `zc`.`id_zbor_clasa` = '".$id_zbor_clasa."'");
														  
										while($r_zbor = mysql_fetch_array($s)) { 
											echo '<tr>';
												echo '<td>'.$r_zbor['categorie'].'</td>';
												echo '<td>'.$r_zbor['reducere'].'</td>';
												echo '<td>
														<a href="zboruri.php?id_zbor='.$id_zbor.'&amp;id_zbor_clasa='.$r_zbor['id_zbor_clasa'].'&id_zbor_reduceri_clasa='.$r_zbor['id_zbor_reducere_clasa'].'&do=asociaza_categorie">
															'.$lang['EDITEAZA'].'
														</a><br/>
														<a href="zboruri.php?id_zbor='.$id_zbor.'&amp;id_zbor_clasa='.$r_zbor['id_zbor_clasa'].'&id_zbor_reduceri_clasa='.$r_zbor['id_zbor_reducere_clasa'].'&do=del_zbor_categorie_clasa" class="delete">
															'.$lang['STERGE'].'
														</a>
													 </td>';
												echo '</tr>';
										} 
									?>
								</table>
								</div>
						<?php } ?>
					<?php } ?>
				<?php } ?>
				</section>
				<aside>
				<?php if(isset($id_zbor)) { ?>
				<span class="clear"></span>
					<ul class="admin_submenu"> 
					<li><a href="zboruri.php?id_zbor=<?php echo $id_zbor;?>&amp;do=asociaza_clasa"><?php echo $lang['ASOC_CL_CONF_ZB'];?></a></li>
					</ul>
				<span class="clear"></span>
				<?php } ?>
				<?php include('includes/links_admin.php');  ?>

			</aside>
	</div>
	
</div>
<?php include('footer.php'); ?> 