<?php require_once("config.php");?>
 <?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user'])) header("Location: cont.php");


if(!isset($_SESSION['rezervare']['informatii']['aeroport_plecare']) 
	or !isset($_SESSION['rezervare']['informatii']['aeroport_sosire']) 
	or !isset($_SESSION['rezervare']['informatii']['data_plecare'])
	or !isset($_SESSION['rezervare']['informatii']['nr_persoane']))
		$err['eroare_rezervare'] = "Folositi formularul de mai sus pentru a cauta o ruta";
else {	
	$aeroport_plecare = $_SESSION['rezervare']['informatii']['aeroport_plecare'];
	
	$aeroport_sosire = $_SESSION['rezervare']['informatii']['aeroport_sosire'];
	
	$data_plecare = $_SESSION['rezervare']['informatii']['data_plecare'];
	$data_sosire = $_SESSION['rezervare']['informatii']['data_sosire'];
	
	$data_plecare_separat = explode("/",$_SESSION['rezervare']['informatii']['data_plecare']);
	if(isset($_SESSION['rezervare']['informatii']['data_sosire'])) $data_sosire_separat = explode("/",$_SESSION['rezervare']['informatii']['data_sosire']);
	
	$nr_persoane = $_SESSION['rezervare']['informatii']['nr_persoane'];
	
	$data_plecareF = mktime(0,0,0,$data_plecare_separat[1],$data_plecare_separat[0],$data_plecare_separat[2]);  //aici incepe ziua
	$data_plecareF_over = mktime(23,59,59,$data_plecare_separat[1],$data_plecare_separat[0],$data_plecare_separat[2]);  //aici se termina
	if(!empty($_SESSION['rezervare']['informatii']['data_sosire'])) {
		$data_sosireF = mktime(0,0,0,$data_sosire_separat[1],$data_sosire_separat[0],$data_sosire_separat[2]); 
		$data_sosireF_over = mktime(23,59,59,$data_sosire_separat[1],$data_sosire_separat[0],$data_sosire_separat[2]); 
	}
	
	if(!isset($_SESSION['rezervare']['pas'])) $_SESSION['rezervare']['pas'] = 1;
	
	
	//query-ul trebuie facut ca intrarea din baza de date sa fie itnre inceputul si sfarsitul zilei de ce? acum got it ? Nu ma prind :| 
	//data din baza ta de date este sub forma 111111155555 - ce inseamna sa zicem 2.iulie.2013 14:21:23
	// ca sa gasesti acea data, doar dandu-i ziua, trebuie sa cauti intre secunda 0 a zilei si ultima, adica 2. iulie.2013 23:59:59
	//got it ? da
	// deci, in seara asta, baga mai multe date de genul asta in baza de date
	//cu ore diferite, in aceeasi zi ok
	// WHERE `data_plecare`=>'".$data_plecareF."' AND `data_plecare`<='".$data_plecareF_over."'
	
	//scrie aici, ca sa ramana
	
	if(isset($_GET['flight'])) {
		$flight = $_GET['flight']; 
		if(!isset($_POST['info_zbor'])) { 
			if(isset($_SESSION['rezervare']['setari'])) {
			for($nr=1; $nr<=$nr_persoane; $nr++) {
					if(isset($_SESSION['rezervare']['setari']['persoane'][$nr]['titulatura'])) $_POST['titulatura'][$nr] = $_SESSION['rezervare']['setari']['persoane'][$nr]['titulatura'];
					if(isset($_SESSION['rezervare']['setari']['persoane'][$nr]['name'])) $_POST['name'][$nr] = $_SESSION['rezervare']['setari']['persoane'][$nr]['name'];
					if(isset($_SESSION['rezervare']['setari']['persoane'][$nr]['prenume'])) $_POST['prenume'][$nr] = $_SESSION['rezervare']['setari']['persoane'][$nr]['prenume'];			

				foreach($_SESSION['rezervare']['informatii']['tur']['id_zbor'] as $zborID) {
					if(isset($_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['clasa'])) $_POST['clasa'][$zborID][$nr] = $_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['clasa'];
					if(isset($_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['meniu'])) $_POST['meniu'][$zborID][$nr] = $_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['meniu'];
					if(isset($_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['bagaj'])){
						foreach($_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['bagaj'] as $id_tip_bagaj=>$valoare) {
								$_POST['bagaj'][$zborID][$nr][$id_tip_bagaj] = $valoare;
						}						
					}
					if(isset($_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['categorie'])) $_POST['categorie'][$zborID][$nr] = $_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['categorie'];
				}
				
				if(isset($_SESSION['rezervare']['informatii']['data_sosire']) AND !empty($_SESSION['rezervare']['informatii']['data_sosire']))	{
					foreach($_SESSION['rezervare']['informatii']['retur']['id_zbor'] as $zborID) {
						if(isset($_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['clasa'])) $_POST['clasa'][$zborID][$nr] = $_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['clasa'];
						if(isset($_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['meniu'])) $_POST['meniu'][$zborID][$nr] = $_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['meniu'];

						if(isset($_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['bagaj'])){
							foreach($_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['bagaj'] as $id_tip_bagaj=>$valoare) {
								$_POST['bagaj'][$zborID][$nr][$id_tip_bagaj] = $valoare;
							}
						}
						if(isset($_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['categorie'])) $_POST['categorie'][$zborID][$nr] = $_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['categorie'];		
									
					}
				}
				
			}//end count persoane
		}
		}
	}
	if(isset($_GET['date_facturare'])) {
		$date_facturare = $_GET['date_facturare']; //aici o sa fie un array cu info despre ruta alea.. practic, id-uri de zboruri
		if(!isset($_POST['contact_info']))  {
			if(isset($_SESSION['rezervare']['factura'])) {
			$_POST['titulatura'] = $_SESSION['rezervare']['factura']['titulatura'];
			$_POST['name'] = $_SESSION['rezervare']['factura']['name'];
			$_POST['prenume'] = $_SESSION['rezervare']['factura']['prenume'];
			$_POST['adresa'] = $_SESSION['rezervare']['factura']['adresa'];
			$_POST['oras'] = $_SESSION['rezervare']['factura']['oras'];
			$_POST['tara'] = $_SESSION['rezervare']['factura']['tara'];
			$_POST['codPostal'] = $_SESSION['rezervare']['factura']['codPostal'];
			$_POST['email'] = $_SESSION['rezervare']['factura']['email'];
			$_POST['telefon'] = $_SESSION['rezervare']['factura']['telefon'];
			}
		}
	}
	if(isset($_GET['date_rezervare'])) {
		$date_rezervare = $_GET['date_rezervare']; //aici o sa fie un array cu info despre ruta alea.. practic, id-uri de zboruri
	}
	
	if(!isset($_POST['select_zbor'])) { 
	if(isset($_SESSION['rezervare']['informatii']['tur']['id_zbor'])) {
		$nr_zboruri_tur = count($_SESSION['rezervare']['informatii']['tur']['id_zbor']);
		$post_zbor_tur = "";
		$count = 1; 
		foreach($_SESSION['rezervare']['informatii']['tur']['id_zbor'] as $id_zbor_tur) {
			$post_zbor_tur .= $id_zbor_tur; 
			if($nr_zboruri_tur!=$count) $post_zbor_tur .= ",";
			$count++;
		}
		$_POST['tur'] = $post_zbor_tur;
	}
	
	if(isset($_SESSION['rezervare']['informatii']['retur']['id_zbor'])) {
		$nr_zboruri_retur = count($_SESSION['rezervare']['informatii']['retur']['id_zbor']);
		$post_zbor_retur = "";
		$count = 1; 
		foreach($_SESSION['rezervare']['informatii']['retur']['id_zbor'] as $id_zbor_retur) {
			$post_zbor_retur .= $id_zbor_retur; 
			if($nr_zboruri_retur!=$count) $post_zbor_retur .= ",";
			$count++;
		}
		$_POST['retur'] = $post_zbor_retur;
	}
	}

	
	if(isset($_POST['select_zbor'])){
	
			if(!isset($_POST['tur']))
			$err['tur'] = "Va rugam sa selectati un zbor de plecare!";
			
			
			if(!empty($_SESSION['rezervare']['informatii']['data_sosire'])){
				if(!isset($_POST['retur'])){
				$err['retur'] = "Va rugam sa selectati un zbor de intoarcere!";
				}
			}
			
			
			if(count($err)==0 )
			{
				if(isset($_SESSION['rezervare']['informatii']['tur']['id_zbor']) and $_POST['tur']!=$_SESSION['rezervare']['informatii']['tur']['id_zbor']) { unset($_SESSION['rezervare']['informatii']['tur']['id_zbor']);  unset($_SESSION['rezervare']['setari']); }
				if(isset($_POST['tur'])) {
					$zboruri_tur = explode(',',$_POST['tur']);
					foreach($zboruri_tur as $key=>$value) {
						$_SESSION['rezervare']['informatii']['tur']['id_zbor'][] = $value;
					}
				}
				if(isset($_SESSION['rezervare']['informatii']['retur']['id_zbor']) and isset($_POST['retur']) and $_POST['retur']!=$_SESSION['rezervare']['informatii']['retur']['id_zbor']) unset($_SESSION['rezervare']['informatii']['retur']['id_zbor']);
				if(isset($_POST['retur'])) {
					$zboruri_retur = explode(',',$_POST['retur']);
					foreach($zboruri_retur as $key=>$value) {
						$_SESSION['rezervare']['informatii']['retur']['id_zbor'][] = $value;
					}
				}
		
				if($_SESSION['rezervare']['pas']<2) $_SESSION['rezervare']['pas'] = 2;
				header("Location: rezervare.php?flight=selected");
			}
	}
	
	if(isset($_POST['info_zbor'])){
		echo '<pre>';
	print_r($_POST);
	echo '</pre>';

		for($nr=1; $nr<=$nr_persoane; $nr++) {
				//echo $_POST['titulatura'][0];
			
				
				if($_POST['titulatura'][$nr]=="") $err['titulatura'][$nr] = $lang['EROARE_TITULATURA'];
				else $_SESSION['rezervare']['setari']['persoane'][$nr]['titulatura'] = $_POST['titulatura'][$nr];
				
				
				if(empty($_POST['name'][$nr])) $err['name'][$nr] = $lang['EROARE_NUME_EMPTY']; 
				else if(!empty($_POST['name'][$nr]) && !preg_match("/^[a-z ]/i",$_POST['name'][$nr])) $err['name'][$nr] = $lang['EROARE_WRONG_NAME'];
				else $_SESSION['rezervare']['setari']['persoane'][$nr]['name'] = $_POST['name'][$nr];
				
				if(empty($_POST['prenume'][$nr])) $err['prenume'][$nr] = $lang['EROARE_PRENUME_EMPTY']; 
				else if(!empty($_POST['prenume'][$nr]) && !preg_match("/^[a-z ]/i",$_POST['prenume'][$nr])) $err['prenume'][$nr] = $lang['EROARE_WRONG_PRENUME'];
				else $_SESSION['rezervare']['setari']['persoane'][$nr]['prenume'] = $_POST['prenume'][$nr];
			
				//$_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['titulatura'];
				//$_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['clasa'][$id_clasa]['meniu'][];
				
			
			
			foreach($_SESSION['rezervare']['informatii']['tur']['id_zbor'] as $zborID) {

				if(empty($_POST['clasa'][$zborID][$nr])) $err['clasa'][$zborID][$nr] = $lang['EROARE_CLASA_EMPTY'];  
				else $_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['clasa'] = $_POST['clasa'][$zborID][$nr];
				
				
				if(isset($_POST['clasa'][$zborID][$nr]) AND !empty($_POST['clasa'][$zborID][$nr]))
				{
					
					if(empty($_POST['meniu'][$zborID][$nr])) $err['meniu'][$zborID][$nr] = 'Va rugam sa selectati meniul dorit';
					else $_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['meniu'] = $_POST['meniu'][$zborID][$nr];
					
					//aici zice de eroare
					if(isset($_POST['bagaj'][$zborID][$nr])){
						foreach($_POST['bagaj'][$zborID][$nr] as $id_tip_bagaj=>$valoare) {
							if($valoare=="") $err['bagaj'][$zborID][$nr][$id_tip_bagaj] = 'Va rugam sa selectati bagajul dorit';
							$_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['bagaj'][$id_tip_bagaj] = $valoare;
						}
					}
					if(!isset($_POST['categorie'][$zborID][$nr])) $err['categorie'][$zborID][$nr] = 'Va rugam sa selectati categoria dorita';
					else $_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['categorie'] = $_POST['categorie'][$zborID][$nr];
					 
				}

			}
			
			if(isset($_SESSION['rezervare']['informatii']['data_sosire']) AND !empty($_SESSION['rezervare']['informatii']['data_sosire']))	{
				foreach($_SESSION['rezervare']['informatii']['retur']['id_zbor'] as $zborID) {

					if(empty($_POST['clasa'][$zborID][$nr])) $err['clasa'][$zborID][$nr] = $lang['EROARE_CLASA_EMPTY'];  
					else $_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['clasa'] = $_POST['clasa'][$zborID][$nr];
					
					
					if(isset($_POST['clasa'][$zborID][$nr]) AND !empty($_POST['clasa'][$zborID][$nr]))
					{
						
						if(empty($_POST['meniu'][$zborID][$nr])) $err['meniu'][$zborID][$nr] = 'Va rugam sa selectati meniul dorit';
						else $_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['meniu'] = $_POST['meniu'][$zborID][$nr];
						
						//aici zice de eroare
						if(isset($_POST['bagaj'][$zborID][$nr])){
							foreach($_POST['bagaj'][$zborID][$nr] as $id_tip_bagaj=>$valoare) {
								if($valoare=="") $err['bagaj'][$zborID][$nr][$id_tip_bagaj] = 'Va rugam sa selectati bagajul dorit';
								$_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['bagaj'][$id_tip_bagaj] = $valoare;
							}
						}
						if(!isset($_POST['categorie'][$zborID][$nr])) $err['categorie'][$zborID][$nr] = 'Va rugam sa selectati categoria dorita';
						else $_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['categorie'] = $_POST['categorie'][$zborID][$nr];

					}
				}
			}
			
			}//end count persoane
			
			print_r($_SESSION);
			print_r($_POST);
			if(count($err)==0){
				if($_SESSION['rezervare']['pas']<3) $_SESSION['rezervare']['pas'] = 3;
				header("Location: rezervare.php?date_facturare=selected");
			}
	}


	if(isset($_POST['contact_info'])){
	
		if(empty($_POST['titulatura'])) $err['titulatura'] = $lang['EROARE_TITULATURA'];
 		else $_SESSION['rezervare']['factura']['titulatura'] = $_POST['titulatura'];

 		if(empty($_POST['name'])) $err['name'] = $lang['EROARE_NUME_EMPTY']; 
 		else if(!empty($_POST['name']) && !preg_match("/^[a-z ]/i",$_POST['name'])) $err['name'] = $lang['EROARE_WRONG_NAME'];
 		else  $_SESSION['rezervare']['factura']['name'] = $_POST['name'];
 			
 		if(empty($_POST['prenume'])) $err['prenume'] = $lang['EROARE_PRENUME_EMPTY'];
 		else if(!empty($_POST['prenume']) && !preg_match("/^[a-z ]/i",$_POST['prenume'])) $err['prenume'] = $lang['EROARE_WRONG_PRENUME'];
 		else  $_SESSION['rezervare']['factura']['prenume'] = $_POST['prenume'];
 		
 		if(empty($_POST['adresa'])) $err['adresa'] = $lang['EROARE_ADRESA_EMPTY'];
 		else if(!empty($_POST['adresa']) && !preg_match("/^[a-z .,0-9]/i",$_POST['adresa'])) $err['adresa'] = $lang['EROARE_WRONG_ADRESA'];
 		else  $_SESSION['rezervare']['factura']['adresa'] = $_POST['adresa'];
 			
 		if(empty($_POST['oras'])) $err['oras'] = $lang['EROARE_ORAS_EMPTY'];
 		else if(!empty($_POST['oras']) && !preg_match("/^[a-z ]/i",$_POST['oras'])) $err['oras'] = $lang['EROARE_WRONG_ORAS'];
 		else  $_SESSION['rezervare']['factura']['oras'] = $_POST['oras'];
 			
 		if(empty($_POST['tara'])) $err['tara'] = $lang['EROARE_TARA_EMPTY'];
 		else  $_SESSION['rezervare']['factura']['tara']= $_POST['tara'];
 		
 		if(empty($_POST['codPostal'])) $err['codPostal'] = $lang['EROARE_CODPOSTAL_EMPTY'];
 		else if(!empty($_POST['codPostal']) && !preg_match("/^[0-9]/i",$_POST['codPostal']) or strlen($_POST['codPostal'])!=6) $err['codPostal'] = $lang['EROARE_WRONG_CODPOSTAL'];
 		else  $_SESSION['rezervare']['factura']['codPostal'] = $_POST['codPostal'];
 			
 		if(empty($_POST['email'])) $err['email'] = $lang['EROARE_EMAIL_EMPTY'];
 		elseif (!empty($_POST['email']) && !preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $_POST['email'])) $err['email'] = $lang['EROARE_WRONG_EMAIL'];
 		else  $_SESSION['rezervare']['factura']['email'] = $_POST['email'];
 			
 		if(empty($_POST['telefon'])) $err['telefon'] = $lang['EROARE_TELEFON_EMPTY'];
 		elseif(strlen($_POST['telefon'])!=10 or !is_numeric($_POST['telefon'])) $err['telefon'] = $lang['EROARE_WRONG_TELEFON'];
		else  $_SESSION['rezervare']['factura']['telefon'] = $_POST['telefon'];
		
		if(count($err)==0){
			if($_SESSION['rezervare']['pas']<4) $_SESSION['rezervare']['pas'] = 4;
			header("Location: rezervare.php?date_rezervare=selected");
		}
	}
	
	if(isset($_POST['confirm_rezervare'])) {
		//in primul rand, bagam in tabela `rezervari` - ca sa avem id_rezervare dupa
		
		$body = "Buna ziua,<br/><br/>";
		$body = $body."Rezervarea a fost realizata! Mai jos puteti vizualiza datele rezervarii!<br/><br/><br/>";
		foreach ($_SESSION['rezervare']['informatii'] as $key_info => $value_info) { 
								
			if($key_info=="tur") {
				$body = $body.'<br/><h4>TUR</h4>'.'<br/>';
				foreach($value_info['id_zbor'] as $key_zbor=>$value_zbor) {
							
				
					$s = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `rute` AS `rt` ON `zb`.`id_ruta` = `rt`.`id_ruta` 
							  WHERE `zb`.`id_zbor` = '".$value_zbor."'");
							$r = mysql_fetch_assoc($s);
											
					$sAP = mysql_query("SELECT * FROM `aeroporturi` AS `aeroP` INNER JOIN `rute` AS `rt` ON `rt`.`id_aeroport_plecare`= `aeroP`.`id_aeroport`
							  INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aeroP`.`id_tara`
							  WHERE `rt`.`id_ruta`='".$r['id_ruta']."'");
																  
					$sAS = mysql_query("SELECT * FROM `aeroporturi` AS `aeroS` INNER JOIN `rute` AS `rt` ON `rt`.`id_aeroport_sosire` = `aeroS`.`id_aeroport`
							  INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aeroS`.`id_tara`
							  WHERE `rt`.`id_ruta`='".$r['id_ruta']."'");
																	  
					$data_plecareZR = date("d/m/Y",$r['data_plecare']);
					$ora_plecareR = date("G",$r['data_plecare']);
					$minut_plecareR= date("i",$r['data_plecare']);
						
					$data_sosireZR = date("d/m/Y",$r['data_sosire']);
					$ora_sosireR = date("G",$r['data_sosire']);
					$minut_sosireR= date("i",$r['data_sosire']);
													
					$rAP = mysql_fetch_assoc($sAP);
					$rAS = mysql_fetch_assoc($sAS);
					
					$body = $body.'Plecare: '.' '.$data_plecareZR.", ".$ora_plecareR.":".$minut_plecareR." - Sosire: ".$data_sosireZR.", ".$ora_sosireR.":".$minut_sosireR."<br/>";
					$body = $body.'Aeroport plecare: '.$rAP['denumire'].", ".$rAP['oras'].", ".$rAP['tara'].'<br/>';
					$body = $body.'Aeroport sosire: '.$rAS['denumire'].", ".$rAS['oras'].", ".$rAS['tara'].'<br/>';										
													
					$body = $body.'<br/>';
				}
			} elseif($key_info=="retur") {
				$body = $body.'<br/><h4>RETUR</h4>'.'<br/>';
				foreach($value_info['id_zbor'] as $key_zbor=>$value_zbor) {
					//echo "ID zbor retur: ".$key_zbor."->".$value_zbor.'<br/>';
					$s = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `rute` AS `rt` ON `zb`.`id_ruta` = `rt`.`id_ruta` 
							  WHERE `zb`.`id_zbor` = '".$value_zbor."'");
					$r = mysql_fetch_assoc($s);
											
					$sAP = mysql_query("SELECT * FROM `aeroporturi` AS `aeroP` INNER JOIN `rute` AS `rt` ON `rt`.`id_aeroport_plecare` = `aeroP`.`id_aeroport`
							  INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aeroP`.`id_tara`
							  WHERE `rt`.`id_ruta`='".$r['id_ruta']."'");
												  
					$sAS = mysql_query("SELECT * FROM `aeroporturi` AS `aeroS` INNER JOIN `rute` AS `rt` ON `rt`.`id_aeroport_sosire` = `aeroS`.`id_aeroport`
							  INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aeroS`.`id_tara`
							  WHERE `rt`.`id_ruta`='".$r['id_ruta']."'");
															  
					$data_plecareZR = date("d/m/Y",$r['data_plecare']);
					$ora_plecareR = date("G",$r['data_plecare']);
					$minut_plecareR= date("i",$r['data_plecare']);
													
					$data_sosireZR = date("d/m/Y",$r['data_sosire']);
					$ora_sosireR = date("G",$r['data_sosire']);
					$minut_sosireR= date("i",$r['data_sosire']);
												
					$rAP = mysql_fetch_assoc($sAP);
					$rAS = mysql_fetch_assoc($sAS);
					$body = $body.'Aeroport plecare: '.$rAP['denumire'].", ".$rAP['oras'].", ".$rAP['tara'].'<br/>';
					$body = $body.'Aeroport sosire: '.$rAS['denumire'].", ".$rAS['oras'].", ".$rAS['tara'].'<br/>';										
					$body = $body.'Plecare: '.$data_plecareZR.", ".$ora_plecareR.":".$minut_plecareR." - Sosire:".$data_sosireZR.", ".$ora_sosireR.":".$minut_sosireR;
					$body = $body.'<br/>';
				}
			} else {
				
				if($key_info == 'aeroport_plecare'){
					$s = mysql_query ("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aero`.`id_tara`
										WHERE `id_aeroport`='".$value_info."'");
					$r = mysql_fetch_assoc($s);
					$body = $body.'Ruta: '.$r['denumire'].", ".$r['oras'].", ".$r['tara']." - ";
				}
				
				if($key_info == 'aeroport_sosire'){
					$s = mysql_query ("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aero`.`id_tara`
							WHERE `id_aeroport`='".$value_info."'");
					$r = mysql_fetch_assoc($s);
					$body = $body.$r['denumire'].", ".$r['oras'].", ".$r['tara']."<br/>";
				}
				
				if($key_info == 'data_plecare')
					$body = $body.'Data plecare: '.$value_info."<br/>";
				
				if($key_info == 'data_sosire' AND $value_info!="")
					$body = $body.'Data intoarcere: '.$value_info."<br/>";
				
				if($key_info == 'nr_persoane')
					$body = $body.'Numarul de persoane: '.$value_info."<br/>";
			}
		}
		 $pf = 0;
		 $body = $body.'<hr class="hr_rezervare"/>';
		 $body = $body.'<h2>Date persoane</h2>';
		 
		 $code = generate_password(10);
				while(mysql_num_rows(mysql_query("SELECT `id_rezervare` FROM `rezervari` WHERE `cod`='".cinp($code)."' LIMIT 1"))!=0) 
					$code = generate_password(10);
		 $ins_rezervare = mysql_query("INSERT INTO `rezervari` 
									   SET `id_utilizator`='".cinp($_SESSION['id_utilizator'])."',
									       `cod`='".$code."',
										   `status`='1',
										   `status_anulat`='0'");
		 if($ins_rezervare) { 
			$id_last_rezervare = mysql_insert_id();
			echo $id_last_rezervare;;
							 $i = 0;
							 $pret_rezervare = 0;
							 foreach($_SESSION['rezervare']['setari']['persoane'] as $key_persoana => $value_persoana) { 
								$i=$i+1;
										$pretP[$i] = 0;
										$s_pers = mysql_query("INSERT INTO `persoane` SET `id_titulatura`='".cinp($value_persoana['titulatura'])."',
																`nume` = '".cinp($value_persoana['name'])."',
																`prenume` = '".cinp($value_persoana['prenume'])."'");
										$id_last_persoana = mysql_insert_id();						
										
										$sT = mysql_query("SELECT * FROM `titulaturi` WHERE `id_titulatura` = '".cinp($value_persoana['titulatura'])."'");
										$r = mysql_fetch_assoc($sT);
										$body = $body.' Rezervarea pentru: '.cinp($r['titulatura']).' '.cinp($value_persoana['name']).' '.cinp($value_persoana['prenume']).'<br/>';
										$j=0;  
										foreach($_SESSION['rezervare']['setari']['id_zbor'] as $key_id_zbor=>$value_id_zbor) {  
											$j++; 
											$pretC[$i][$j] = 0; 
										  $pretB[$i][$j] = 0;
										  $reducere[$i][$j]=0;
										  $pretFinal[$i][$j] = 0;
										  $f = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `rute` AS `rt` ON `rt`.`id_ruta`=`zb`.`id_ruta`
																  WHERE `zb`.`id_zbor` = '".$key_id_zbor."' ");
										  $r = mysql_fetch_assoc($f);
										  $fAP = mysql_query("SELECT * FROM `aeroporturi` AS `aeroS` INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aeroS`.`id_tara`					   
																    WHERE `aeroS`.`id_aeroport`='".$r['id_aeroport_plecare']."'");
										  $rfAP = mysql_fetch_assoc($fAP);
										  $fAS = mysql_query("SELECT * FROM `aeroporturi` AS `aeroS` INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aeroS`.`id_tara`
																    WHERE `aeroS`.`id_aeroport`='".$r['id_aeroport_sosire']."'");
										  $rfAS = mysql_fetch_assoc($fAS);
																		
										  $body = $body.'<br/>'.'<h3 class="st_zb">Setari pentru zborul '.$rfAP['denumire'].", ".$rfAP['oras'].", ".$rfAP['tara']."  -  ".$rfAS['denumire'].", ".$rfAS['oras'].", ".$rfAS['tara'].'<br/>'.'</h3>';
												
												$cs = mysql_query("SELECT `cl`.`clasa`,`zc`.`pret_clasa` FROM `zbor_clasa` AS `zc` INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa` = `zc`.`id_clasa`
																   WHERE `zc`.`id_zbor_clasa`='".$value_id_zbor['persoane'][$key_persoana]['clasa']."'
																   GROUP BY `zc`.`id_zbor`");
												$rcs = mysql_fetch_assoc($cs);
												
												$body = $body.'<b>Clasa:</b>'.$rcs['clasa']." (".$rcs['pret_clasa']." LEI)";
												
												$body = $body.'<br/><b>Meniu:</b>';
												
												$cm = mysql_query("SELECT `tm`.`denumire` FROM `zbor_meniu_clasa` AS `zmc` INNER JOIN `tipuri_meniu` AS `tm` ON `tm`.`id_meniu` = `zmc`.`id_meniu`
													   WHERE `zmc`.`id_zbor_meniu_clasa`='".$value_id_zbor['persoane'][$key_persoana]['meniu']."' AND `zmc`.`id_zbor_clasa` = '".$value_id_zbor['persoane'][$key_persoana]['clasa']."'
													   GROUP BY `zmc`.`id_zbor_clasa`");
												$rcm = mysql_fetch_assoc($cm);
												
												$body = $body.$rcm['denumire'];
												$body = $body.'<br/><b>Bagaje:</b><br/>';
												foreach($value_id_zbor['persoane'][$key_persoana]['bagaj'] as $key_bagaj=>$value_bagaj) { 
														$body = $body.'<b>'; 
														$stb = mysql_query("SELECT *
																			FROM `tipuri_bagaj` AS `tb`
																			WHERE `tb`.`id_tip_bagaj` = '". $key_bagaj."'");
														$rtb = mysql_fetch_assoc($stb);
																					
														$body = $body.$rtb['tip_bagaj'].'</b>'; 
													     if($value_bagaj==0) $body = $body."nicio alegere"; else {
															$sb = mysql_query("SELECT * FROM `zbor_bagaje_clasa` AS `zbc` 
															WHERE `zbc`.`id_zbor_bagaje_clasa`='".$value_bagaj."'
															GROUP BY `zbc`.`id_zbor_clasa`");
															$rb = mysql_fetch_assoc($sb);
															
															$body = $body.$rb['descriere']." (".$rb['pret']." LEI)";
														}; 	
														$body = $body.'<br/>';										
												 }
												 
												$body = $body.'<b>Reducere:</b>';
												if($value_id_zbor['persoane'][$key_persoana]['categorie']==0) echo 'nicio alegere'; else{
														//echo $value_id_zbor['persoane'][$key_persoana]['categorie'];
														$cc = mysql_query("SELECT `cv`.`categorie`, `zrc`.`reducere`
																FROM `zbor_reduceri_clasa` AS `zrc`
																INNER JOIN `categorii_varsta` AS `cv` ON `cv`.`id_categorie_varsta` = `zrc`.`id_categorie_varsta`
																WHERE `zrc`.`id_zbor_reducere_clasa` ='".$value_id_zbor['persoane'][$key_persoana]['categorie']."' AND `zrc`.`id_zbor_clasa` = '".$value_id_zbor['persoane'][$key_persoana]['clasa']."'
																GROUP BY `zrc`.`id_zbor_clasa`");
														$rcc = mysql_fetch_assoc($cc);
														$body = $body.$rcc['categorie'].' ('.$rcc['reducere'].'%)';
													
												}
												
												$pretC[$i][$j] =  $pretC[$i][$j] + $rcs['pret_clasa'];				
												
												if($value_id_zbor['persoane'][$key_persoana]['categorie']!=0) {
														$cc = mysql_query("SELECT `cv`.`categorie`, `zrc`.`reducere`
																			FROM `zbor_reduceri_clasa` AS `zrc`
																			INNER JOIN `categorii_varsta` AS `cv` ON `cv`.`id_categorie_varsta` = `zrc`.`id_categorie_varsta`
																			WHERE `zrc`.`id_zbor_reducere_clasa` ='".$value_id_zbor['persoane'][$key_persoana]['categorie']."' AND `zrc`.`id_zbor_clasa` = '".$value_id_zbor['persoane'][$key_persoana]['clasa']."'
																			GROUP BY `zrc`.`id_zbor_clasa`");
														$rcc = mysql_fetch_assoc($cc);
														$reducere[$i][$j] = $reducere[$i][$j] + $rcc['reducere'];
												}
												
												mysql_query("INSERT INTO `rezervare_persoana_zbor` SET `id_rezervare`='".cinp($id_last_rezervare)."',
																	`id_persoana`='".cinp($id_last_persoana)."',
																	`id_meniu`='".cinp($value_id_zbor['persoane'][$key_persoana]['meniu'])."',
																	`id_categorie_varsta`='".cinp($value_id_zbor['persoane'][$key_persoana]['categorie'])."'");	
												//`id_zbor_clasa`='".cinp($value_id_zbor['persoane'][$key_persoana]['clasa'])."',
												$last_id_rez_pers_zbor = mysql_insert_id();															

												foreach($value_id_zbor['persoane'][$key_persoana]['bagaj'] as $key_bagaj=>$value_bagaj) { 
													$stb = mysql_query("SELECT *
																		FROM `tipuri_bagaj` AS `tb`
																		WHERE `tb`.`id_tip_bagaj` = '". $key_bagaj."'");
													$rtb = mysql_fetch_assoc($stb);
													if($value_bagaj!=0) {
															$sb = mysql_query("SELECT * FROM `zbor_bagaje_clasa` AS `zbc` 
																				WHERE `zbc`.`id_zbor_bagaje_clasa`='".$value_bagaj."'
																				GROUP BY `zbc`.`id_zbor_clasa`");
															$rb = mysql_fetch_assoc($sb);
															mysql_query("INSERT INTO `rezervare_persoana_bagaj` SET `id_rez_pers_zbor`='".cinp($last_id_rez_pers_zbor)."',`id_zbor_bagaje_clasa`='".$value_bagaj."'");
															$pretB[$i][$j] = $pretB[$i][$j] + $rb['pret'];
													} 								
												 } 
											   $pretFinal[$i][$j] = $pretB[$i][$j] + $pretC[$i][$j] - ($reducere[$i][$j]*$pretC[$i][$j]/100);
											   $pretP[$i] = $pretP[$i] + $pretFinal[$i][$j];
											   mysql_query("UPDATE `rezervare_persoana_zbor` SET `pret` = '".cinp($pretFinal[$i][$j])."' WHERE `id_rez_pers_zbor`='".$last_id_rez_pers_zbor."' LIMIT 1");
												
												mysql_query("UPDATE `zbor_clasa` SET `nr_locuri` = (`nr_locuri`-1 )
													WHERE `id_zbor_clasa` = '".$value_id_zbor['persoane'][$key_persoana]['clasa']."' LIMIT 1");
												$body = $body.'<br/><span style="font-size: 110%; font-style: italic;">Pret pe zbor: <b>'.$pretFinal[$i][$j].' LEI</b></span><br/>';
											}
										
										$pret_rezervare = $pret_rezervare + $pretP[$i];	
										$body = $body.'<br/><span style="font-size: 160%;">Pret final pe persoana: <b>'.$pretP[$i].' LEI</b></span>';
										$body = $body.'<hr class="hr_rezervare2"/>';
							 }//end foreach persoane
							
							 $body = $body.'<br/><span style="font-size: 160%;">Pret final rezervare: <b>'.$pret_rezervare.' LEI</b></span>';
							 $body = $body."<br/><br/> Aceasta rezervare are codul:".$code.". Va asteptam sa achitati rezervarea la una dintre agentiile noastre, in cazul in care rezervarea nu va fi achitata in 4 zile, aceasta se va anula!";
							 $body = $body."<br/><br/> Va multumim pentru ca ati ales ADG Air";
			$codeF = generate_password(10);
				while(mysql_num_rows(mysql_query("SELECT `id_factura` FROM `facturi` WHERE `nr_factura`='".cinp($codeF)."' LIMIT 1"))!=0) 
					$codeF = generate_password(10);				 
			//ultima dintre actiuni			
			echo $id_last_rezervare;
			mysql_query("INSERT INTO `facturi` SET 
						 `id_titulatura` = '".cinp($_SESSION['rezervare']['factura']['titulatura'])."',
						 `nume` = '".cinp($_SESSION['rezervare']['factura']['name'])."',
						 `prenume` = '".cinp($_SESSION['rezervare']['factura']['prenume'])."',
						 `adresa` = '".cinp($_SESSION['rezervare']['factura']['adresa'])."',
						 `oras` = '".cinp($_SESSION['rezervare']['factura']['oras'])."',
						 `id_tara` = '".cinp($_SESSION['rezervare']['factura']['tara'])."',
						 `codPostal` = '".cinp($_SESSION['rezervare']['factura']['codPostal'])."',
						 `email` = '".cinp($_SESSION['rezervare']['factura']['email'])."',
						 `telefon`  = '".cinp($_SESSION['rezervare']['factura']['telefon'])."',
						 `data_facturare` = '".time()."',
						 `pret_total`= '".cinp($pret_rezervare)."',
						 `nr_factura` = '".cinp($codeF)."',
						  `id_rezervare`  = '".cinp($id_last_rezervare)."',
						  `status`= '0'");
						 
			include_once('phpmailer/class.phpmailer.php');
			$mail = new PHPMailer();   
			
			if(is_smtp==1) {
				$mail->IsSMTP(); // enable SMTP
				$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
				$mail->SMTPAuth = true;  // authentication enabled
				$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
				$mail->Host = 'smtp.gmail.com';
				$mail->Port = 465; 
				$mail->Username = "AirADG.Reservation@gmail.com";  
				$mail->Password = "airadg1234";  
			}
				
				$subject = 'Rezervare - ADG Air';
				$mail->SetFrom("AirADG.Reservation@gmail.com", "ADG Air");
				$mail->Subject = $subject;
				$mail->MsgHTML($body); 
			
				$mail->AddAddress(cinp(($_SESSION['rezervare']['factura']['email'])),$lang['REG_MSG6']);           
				if($mail->Send()) {
					unset($_SESSION['rezervare'],$pret_rezervare);
					header("Location: rezervare.php?succes=rezervare_facuta");
				}
			
		 
		 }
		
		
	
	}//end confirm rezervare

}//end isset formular rezervare

?>


<?php include_once 'head.php'; ?>
<?php include('header.php'); ?> 

	<div class="main_content">
		<div class="wrap">
			<section class="full">
				<?php 
					if(isset($_GET['succes']) and $_GET['succes']=="rezervare_facuta") echo '<h2>Rezervare efectuata</h2><p>Puteti vedea detalii despre rezervarea facuta in contul dumneavoastra de utilizator</p>';
					else {
				?>
				<?php if(isset($err['eroare_rezervare'])) echo '<span class="eroare">'.$err['eroare_rezervare'].'</span>'; ?>			
				
				<div id="rezervare_menu">
					<ul id="rezervare_menu_ul">
						<li style="z-index: 4" class="<?php if(!isset($flight) and !isset($date_facturare) and !isset($date_rezervare)) echo 'selected';?>"><a href="<?php if($_SESSION['rezervare']['pas']>=1) echo 'rezervare.php'; else echo '#';?>"><?php echo $lang['SELECT_THE_FLIGHT'];?></a></li>
						<li style="z-index: 3" class="<?php if(isset($flight)) echo 'selected';?>"><a href="<?php if($_SESSION['rezervare']['pas']>=2) echo 'rezervare.php?flight=selected'; else echo '#';?>"><?php echo $lang['PASAGERI'];?></a></li>
						<li style="z-index: 2" class="informatii_de_contact <?php if(isset($date_facturare)) echo 'selected';?>"><a href="<?php if($_SESSION['rezervare']['pas']>=3) echo 'rezervare.php?date_facturare=selected'; else echo '#';?>"><?php echo $lang['INFO_CONTACT'];?></a></li>
						<li style="z-index: 1" class="<?php if(isset($date_rezervare)) echo 'selected';?>"><a href="<?php if($_SESSION['rezervare']['pas']>=4) echo 'rezervare.php?date_rezervare=selected'; else echo '#';?>"><?php echo $lang['REZUMAT'];?></a></li>
					</ul>
				</div>
				<?php if(!isset($flight) and !isset($date_facturare) and !isset($date_rezervare)) { ?>
				<div id="select_flight">
					<form action="" method="post" name="select_zbor" id="select_zbor" action="">
					<!-- De exemplu la clase, in loc 5 o sa fie nr de zboruri si in loc de 2 o sa fie nr de tipuri de bagaje de ex, sau nr persoanei -->
					<!-- ca o sa ai .. zborid =2 , pers 1, pers 2 dar, deci o sa trebuiasca si pt persoane, cred ca zbor->persoana->clasa->tip_bagaj->bagaj
																																		 ->meniu ..	-->
					
					
					<?php if(isset($err['tur'])) echo '<span class="eroare">'.$err['tur'].'</span>'; ?>
					<h3>TUR</h3>
					<?php 
					
				    $s = mysql_query("SELECT SUM(`zc`.`nr_locuri`) AS `locuri_disponibile`,`zb`.`id_zbor`, `zb`.`cod_zbor` , `av`.`serie`, `ta`.`tip`, `fb`.`fabricant`,
									`c_a`.`denumire`, `c_a`.`cod`, `c_a`.`descriere`, `aeroP`.`denumire` AS `aeroport_plecare`, `aeroP`.`oras` AS `oras_aeroport_plecare`,
									`tP`.`tara` AS `tara_aeroport_plecare`, `aeroS`.`denumire` AS `aeroport_sosire`, `aeroS`.`oras` AS `oras_aeroport_sosire`, `tS`.`tara` AS `tara_aeroport_sosire`
									FROM `zboruri` AS `zb`INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor` 
									INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa`
									INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa` = `cc`.`id_clasa`
									INNER JOIN `companie_avioane` AS `ca` ON `ca`.`id_avion` = `zb`.`id_avion`
									INNER JOIN `avioane` AS `av` ON `av`.`id_avion` = `ca`.`id_avion`
									INNER JOIN `tipuri_avion` AS `ta` ON `ta`.`id_tip_avion` = `av`.`id_tip_avion`
									INNER JOIN `fabricanti` AS `fb` ON `fb`.`id_fabricant` = `ta`.`id_fabricant`
									INNER JOIN `companii_aeriene` AS `c_a` ON `c_a`.`id_companie` = `ca`.`id_companie`
									INNER JOIN `rute` AS `rt` ON `rt`.`id_ruta` = `zb`.`id_ruta`
									INNER JOIN `aeroporturi` AS `aeroS` ON `aeroS`.`id_aeroport` = `rt`.`id_aeroport_sosire`
									INNER JOIN `tari` AS `tS` ON `tS`.`id_tara` = `aeroS`.`id_tara`
									INNER JOIN `aeroporturi` AS `aeroP` ON `aeroP`.`id_aeroport` = `rt`.`id_aeroport_plecare`
									INNER JOIN `tari` AS `tP` ON `tP`.`id_tara` = `aeroP`.`id_tara`
									WHERE `zb`.`status` = '1' AND `rt`.`id_aeroport_plecare` = '".$_SESSION['rezervare']['informatii']['aeroport_plecare']."' AND `rt`.`id_aeroport_sosire` = '".$_SESSION['rezervare']['informatii']['aeroport_sosire']."' 
									AND `zb`.`data_plecare` >= '".$data_plecareF."' AND `zb`.`data_plecare` <= '".$data_plecareF_over."'
									GROUP BY `zb`.`id_zbor`
									HAVING SUM(`zc`.`nr_locuri`) >=  '".$nr_persoane."'");

			
					while($r = mysql_fetch_array($s)){
							$sP = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` 
											   FROM `zbor_clasa` AS `zc` INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa` 
											   INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa` = `cc`.`id_clasa` WHERE `zc`.`id_zbor` ='".$r['id_zbor']."' 
											   GROUP BY `zc`.`id_zbor` ");
							$rP = mysql_fetch_assoc($sP);
							echo '<input type="radio" name="tur" value="'.$r['id_zbor'].'"';
														if(isset($_POST['tur']) and $_POST['tur']==$r['id_zbor']) echo ' checked="checked" ';
														echo ' />'.$r['aeroport_plecare'].', '.$r['oras_aeroport_plecare'].', '.$r['tara_aeroport_plecare'].' - '.$r['aeroport_sosire'].', '.$r['oras_aeroport_sosire'].', '.$r['tara_aeroport_sosire'].' - '.$rP['pret_plecare'].'<br>';
					}
					
					$sE1 = mysql_query("SELECT `rt`.`id_ruta` AS `ruta1`, `rt1`.`id_ruta`  AS `ruta2`, `rt`.`id_aeroport_sosire` AS `escala`
										FROM `rute` AS `rt` INNER JOIN `rute` AS `rt1` ON `rt`.`id_aeroport_sosire` = `rt1`.`id_aeroport_plecare`
										WHERE `rt`.`id_aeroport_plecare` = '".$_SESSION['rezervare']['informatii']['aeroport_plecare']."' AND `rt1`.`id_aeroport_sosire` = '".$_SESSION['rezervare']['informatii']['aeroport_sosire']."'");
					$vE1 = 0;
					while($rE1 = mysql_fetch_array($sE1)){
					
							$sEZ1 = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												WHERE `id_ruta`='".$rE1['ruta1']."' AND `data_plecare` >= '".$data_plecareF."' AND `data_plecare` <= '".$data_plecareF_over."' AND `status`= '1'
												GROUP BY `zb`.`id_zbor`
												HAVING SUM(`zc`.`nr_locuri`) >= '".$nr_persoane."'");
							
												
							$sEZ2 = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												 WHERE `id_ruta`='".$rE1['ruta2']."' AND `data_plecare` >= '".$data_plecareF."' AND `data_plecare` <= '".$data_plecareF_over."' AND `status`= '1'
												 GROUP BY `zb`.`id_zbor`
												 HAVING SUM(`zc`.`nr_locuri`) >= '".$nr_persoane."'");
							
							$sAP1 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$_SESSION['rezervare']['informatii']['aeroport_plecare']."'");
							$sAP2 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$rE1['escala']."'");
							$sAP3 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$_SESSION['rezervare']['informatii']['aeroport_sosire']."'");
												 
							$rAP1 = mysql_fetch_assoc($sAP1);
							$rAP2 = mysql_fetch_assoc($sAP2);
							$rAP3 = mysql_fetch_assoc($sAP3);

							while($rEZ1 = mysql_fetch_array($sEZ1)){
								while($rEZ2 = mysql_fetch_array($sEZ2)){
									if(($rEZ1['data_sosire']+30*60)<=$rEZ2['data_plecare']){
									
											$sP1 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																WHERE `zc`.`id_zbor`='".$rEZ1['id_zbor']."'");
											$rP1 = mysql_fetch_assoc($sP1);

											$sP2 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																WHERE `zc`.`id_zbor`='".$rEZ2['id_zbor']."'");
											$rP2 = mysql_fetch_assoc($sP2);
											
											$pret_plecare  = $rP1['pret_plecare'] + $rP2['pret_plecare'];
											
											
 											echo '<input type="radio" name="tur" value="'.$rEZ1['id_zbor'].','.$rEZ2['id_zbor'].'"';
														if(isset($_POST['tur']) and $_POST['tur']==$rEZ1['id_zbor'].','.$rEZ2['id_zbor']) echo ' checked="checked" ';
														echo ' />'.$rAP1['denumire'].', '.$rAP1['oras'].', '.$rAP1['tara'].' - '.
												 $rAP2['denumire'].', '.$rAP2['oras'].', '.$rAP2['tara'].' - '. $rAP3['denumire'].', '.$rAP3['oras'].', '.$rAP3['tara'].' :'.$pret_plecare.'<br>';
												 
											$vE1 = 1;
									}
									
								}
							}
							
					}

					$sE2 = mysql_query("SELECT `rt`.`id_ruta` AS `ruta1`, `rt1`.`id_ruta`  AS `ruta2`, `rt2`.`id_ruta` AS `ruta3`, `rt`.`id_aeroport_sosire` AS `escala1`, `rt1`.`id_aeroport_sosire` AS `escala2` 
										FROM `rute` AS `rt` INNER JOIN `rute` AS `rt1` ON `rt`.`id_aeroport_sosire` = `rt1`.`id_aeroport_plecare`
										INNER JOIN `rute` AS `rt2` ON `rt2`.`id_aeroport_plecare` = `rt1`.`id_aeroport_sosire`
										WHERE `rt`.`id_aeroport_plecare` = '".$_SESSION['rezervare']['informatii']['aeroport_plecare']."' AND `rt2`.`id_aeroport_sosire` = '".$_SESSION['rezervare']['informatii']['aeroport_sosire']."'");
					$vE2= 0;
					while($rE2 = mysql_fetch_array($sE2)){
					
							$sEZ1 = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												WHERE `id_ruta`='".$rE2['ruta1']."' AND `data_plecare` >= '".$data_plecareF."' AND `data_plecare` <= '".$data_plecareF_over."' AND `status`= '1'
												GROUP BY `zb`.`id_zbor`
												HAVING SUM(`zc`.`nr_locuri`) >= '".$nr_persoane."'");
												
							$sEZ2 = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												 WHERE `id_ruta`='".$rE2['ruta2']."' AND `data_plecare` >= '".$data_plecareF."' AND `data_plecare` <= '".$data_plecareF_over."' AND `status`= '1'
												 GROUP BY `zb`.`id_zbor`
												 HAVING SUM(`zc`.`nr_locuri`) >= '".$nr_persoane."'");
							$sEZ3 = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												 WHERE `id_ruta`='".$rE2['ruta3']."' AND `data_plecare` >= '".$data_plecareF."' AND `data_plecare` <= '".$data_plecareF_over."' AND `status`= '1'
												 GROUP BY `zb`.`id_zbor`
												 HAVING SUM(`zc`.`nr_locuri`) >= '".$nr_persoane."'");
							
							$nrZ1 = mysql_num_rows($sEZ1);
							$nrZ2 = mysql_num_rows($sEZ2);
							$nrZ3 = mysql_num_rows($sEZ3);
							
							$sAP1 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$_SESSION['rezervare']['informatii']['aeroport_plecare']."'");
							$sAP2 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$rE2['escala1']."'");
							$sAP3 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$rE2['escala2']."'");
							$sAP4 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$_SESSION['rezervare']['informatii']['aeroport_sosire']."'");
							$rAP1 = mysql_fetch_assoc($sAP1);
							$rAP2 = mysql_fetch_assoc($sAP2);
							$rAP3 = mysql_fetch_assoc($sAP3);
							$rAP4 = mysql_fetch_assoc($sAP4);
							
							while($rEZ1 = mysql_fetch_array($sEZ1)){
								while($rEZ2 = mysql_fetch_array($sEZ2)){
									while($rEZ3 = mysql_fetch_array($sEZ3))
									{

										if(($rEZ1['data_sosire']+30*60)<=$rEZ2['data_plecare'])
											if(($rEZ2['data_sosire']+30*60)<=$rEZ3['data_plecare'])
											{	$sP1 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																	WHERE `zc`.`id_zbor`='".$rEZ1['id_zbor']."'");
												$rP1 = mysql_fetch_assoc($sP1);
							
												$sP2 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																	WHERE `zc`.`id_zbor`='".$rEZ2['id_zbor']."'");
												$rP2 = mysql_fetch_assoc($sP2);
												
												$sP3 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																	WHERE `zc`.`id_zbor`='".$rEZ3['id_zbor']."'");
												$rP3 = mysql_fetch_assoc($sP3);
												
												$pret_plecare  = $rP1['pret_plecare'] + $rP2['pret_plecare'] + $rP3['pret_plecare'];
 												echo '<input type="radio" name="tur" value="'.$rEZ1['id_zbor'].','.$rEZ2['id_zbor'].','.$rEZ3['id_zbor'].'"';
														if(isset($_POST['tur']) and $_POST['tur']==$rEZ1['id_zbor'].','.$rEZ2['id_zbor'].','.$rEZ3['id_zbor']) echo ' checked="checked" ';
														echo ' />'.$rAP1['denumire'].', '.$rAP1['oras'].', '.$rAP1['tara'].' - '.
													 $rAP2['denumire'].', '.$rAP2['oras'].', '.$rAP2['tara'].' - '. $rAP3['denumire'].', '.$rAP3['oras'].', '.$rAP3['tara'].' - '. $rAP4['denumire'].', '.$rAP4['oras'].', '.
													 $rAP4['tara'].' :'.$pret_plecare.'<br>';
													 $vE2 = 1;
											}
									}
								}
							}
							
					}
					
					$sE3 = mysql_query("SELECT `rt`.`id_ruta` AS `ruta1`, `rt1`.`id_ruta`  AS `ruta2`, `rt2`.`id_ruta` AS `ruta3`, `rt3`.`id_ruta` AS `ruta4`,
										`rt`.`id_aeroport_sosire` AS `escala1`, `rt1`.`id_aeroport_sosire` AS `escala2`,`rt2`.`id_aeroport_sosire` AS `escala3` 
										FROM `rute` AS `rt` INNER JOIN `rute` AS `rt1` ON `rt`.`id_aeroport_sosire` = `rt1`.`id_aeroport_plecare`
										INNER JOIN `rute` AS `rt2` ON `rt2`.`id_aeroport_plecare` = `rt1`.`id_aeroport_sosire`
										INNER JOIN `rute` As `rt3` ON `rt3`.`id_aeroport_plecare` = `rt2`.`id_aeroport_sosire`
										WHERE `rt`.`id_aeroport_plecare` = '".$_SESSION['rezervare']['informatii']['aeroport_plecare']."' AND `rt3`.`id_aeroport_sosire` = '".$_SESSION['rezervare']['informatii']['aeroport_sosire']."'");
					$vE3 = 0;				
					while($rE3 = mysql_fetch_array($sE3)){
					
							$sEZ1 = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												WHERE `id_ruta`='".$rE3['ruta1']."' AND `data_plecare` >= '".$data_plecareF."' AND `data_plecare` <= '".$data_plecareF_over."' AND `status`= '1'
												GROUP BY `zb`.`id_zbor`
												HAVING SUM(`zc`.`nr_locuri`) >= '".$nr_persoane."'");
							$sEZ2 = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												 WHERE `id_ruta`='".$rE3['ruta2']."' AND `data_plecare` >= '".$data_plecareF."' AND `data_plecare` <= '".$data_plecareF_over."' AND `status`= '1'
												 GROUP BY `zb`.`id_zbor`
												 HAVING SUM(`zc`.`nr_locuri`) >= ('".$nr_persoane."')");
							$sEZ3 = mysql_query("SELECT * FROM  `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												 WHERE `id_ruta`='".$rE3['ruta3']."' AND `data_plecare` >= '".$data_plecareF."' AND `data_plecare` <= '".$data_plecareF_over."' AND `status`= '1'
												 GROUP BY `zb`.`id_zbor`
												 HAVING SUM(`zc`.`nr_locuri`) >= ('".$nr_persoane."')");
							$sEZ4 = mysql_query("SELECT * FROM  `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												 WHERE `id_ruta`='".$rE3['ruta4']."' AND `data_plecare` >= '".$data_plecareF."' AND `data_plecare` <= '".$data_plecareF_over."' AND `status`= '1'
												 GROUP BY `zb`.`id_zbor`
												 HAVING SUM(`zc`.`nr_locuri`) >= ('".$nr_persoane."')");
							
							$nrZ1 = mysql_num_rows($sEZ1);
							$nrZ2 = mysql_num_rows($sEZ2);
							$nrZ3 = mysql_num_rows($sEZ3);
							$nrZ4 = mysql_num_rows($sEZ4);
							
							
							$sAP1 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$_SESSION['rezervare']['informatii']['aeroport_plecare']."'");
							$sAP2 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$rE3['escala1']."'");
							$sAP3 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$rE3['escala2']."'");
							$sAP4 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$rE3['escala3']."'");
							$sAP5 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$_SESSION['rezervare']['informatii']['aeroport_sosire']."'");
							$rAP1 = mysql_fetch_assoc($sAP1);
							$rAP2 = mysql_fetch_assoc($sAP2);
							$rAP3 = mysql_fetch_assoc($sAP3);
							$rAP4 = mysql_fetch_assoc($sAP4);
							$rAP5 = mysql_fetch_assoc($sAP5);
							
							while($rEZ1 = mysql_fetch_array($sEZ1)){
								while($rEZ2 = mysql_fetch_array($sEZ2)){
									while($rEZ3 = mysql_fetch_array($sEZ3)){
										while($rEZ4 = mysql_fetch_array($sEZ4))
										{
											if(($rEZ1['data_sosire']+30*60)<=$rEZ2['data_plecare'])
												if(($rEZ2['data_sosire']+30*60)<=$rEZ3['data_plecare'])
													if(($rEZ3['data_sosire']+30*60)<=$rEZ4['data_plecare'])
													{	$sP1 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																			WHERE `zc`.`id_zbor`='".$rEZ1['id_zbor']."'");
														$rP1 = mysql_fetch_assoc($sP1);
									
														$sP2 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																			WHERE `zc`.`id_zbor`='".$rEZ2['id_zbor']."'");
														$rP2 = mysql_fetch_assoc($sP2);
														
														$sP3 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																			WHERE `zc`.`id_zbor`='".$rEZ3['id_zbor']."'");
														$rP3 = mysql_fetch_assoc($sP3);
														
														$sP4 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																			WHERE `zc`.`id_zbor`='".$rEZ4['id_zbor']."'");
														$rP4 = mysql_fetch_assoc($sP4);
														
														$pret_plecare  = $rP1['pret_plecare'] + $rP2['pret_plecare'] + $rP3['pret_plecare'] + $rP4['pret_plecare'];
														echo '<input type="radio" name="tur" value="'.$rEZ1['id_zbor'].','.$rEZ2['id_zbor'].','.$rEZ3['id_zbor'].','.$rEZ4['id_zbor'].'"';
														if(isset($_POST['tur']) and $_POST['tur']==$rEZ1['id_zbor'].','.$rEZ2['id_zbor'].','.$rEZ3['id_zbor'].','.$rEZ4['id_zbor']) echo ' checked="checked" ';
														echo ' />'.$rAP1['denumire'].', '.$rAP1['oras'].', '.$rAP1['tara'].' - '.
															 $rAP2['denumire'].', '.$rAP2['oras'].', '.$rAP2['tara'].' - '. $rAP3['denumire'].', '.$rAP3['oras'].', '.$rAP3['tara'].' - '. $rAP4['denumire'].', '.$rAP4['oras'].', '.
															 $rAP4['tara'].'-'.$rAP5['denumire'].', '.$rAP5['oras'].', '. $rAP5['tara'].' :'.$pret_plecare.'<br>';
														$vE3 = 1;
													}
										}
									}
								}
							}
							
					}
					
					if(mysql_num_rows($s) == 0 AND $vE1 == 0 AND $vE2 == 0 AND $vE3 == 0) {
						echo 'Ne pare rau, dar nu a fost gasit zbor de plecare in data specificata';
						$ret = 0;
					}
					?>
					
					<?php if(isset($err['retur'])) echo '<span class="eroare">'.$err['retur'].'</span>'; ?>
					<?php
					echo $_SESSION['rezervare']['informatii']['data_sosire'];
					if(isset($_SESSION['rezervare']['informatii']['data_sosire']) AND !empty($_SESSION['rezervare']['informatii']['data_sosire'])) {
					?>
					<br/></br>
					<h3>RETUR</h3>
					<?php
						 $s = mysql_query("SELECT SUM(`zc`.`nr_locuri`) AS `locuri_disponibile`,`zb`.`id_zbor`, `zb`.`cod_zbor` , `av`.`serie`, `ta`.`tip`, `fb`.`fabricant`,
									`c_a`.`denumire`, `c_a`.`cod`, `c_a`.`descriere`, `aeroP`.`denumire` AS `aeroport_plecare`, `aeroP`.`oras` AS `oras_aeroport_plecare`,
									`tP`.`tara` AS `tara_aeroport_plecare`, `aeroS`.`denumire` AS `aeroport_sosire`, `aeroS`.`oras` AS `oras_aeroport_sosire`, `tS`.`tara` AS `tara_aeroport_sosire`
									FROM `zboruri` AS `zb`INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor` 
									INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa`
									INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa` = `cc`.`id_clasa`
									INNER JOIN `companie_avioane` AS `ca` ON `ca`.`id_avion` = `zb`.`id_avion`
									INNER JOIN `avioane` AS `av` ON `av`.`id_avion` = `ca`.`id_avion`
									INNER JOIN `tipuri_avion` AS `ta` ON `ta`.`id_tip_avion` = `av`.`id_tip_avion`
									INNER JOIN `fabricanti` AS `fb` ON `fb`.`id_fabricant` = `ta`.`id_fabricant`
									INNER JOIN `companii_aeriene` AS `c_a` ON `c_a`.`id_companie` = `ca`.`id_companie`
									INNER JOIN `rute` AS `rt` ON `rt`.`id_ruta` = `zb`.`id_ruta`
									INNER JOIN `aeroporturi` AS `aeroS` ON `aeroS`.`id_aeroport` = `rt`.`id_aeroport_sosire`
									INNER JOIN `tari` AS `tS` ON `tS`.`id_tara` = `aeroS`.`id_tara`
									INNER JOIN `aeroporturi` AS `aeroP` ON `aeroP`.`id_aeroport` = `rt`.`id_aeroport_plecare`
									INNER JOIN `tari` AS `tP` ON `tP`.`id_tara` = `aeroP`.`id_tara`
									WHERE `zb`.`status` = '1' AND `rt`.`id_aeroport_plecare` = '".$_SESSION['rezervare']['informatii']['aeroport_sosire']."' AND `rt`.`id_aeroport_sosire` = '".$_SESSION['rezervare']['informatii']['aeroport_plecare']."' 
									AND `zb`.`data_plecare` >= '".$data_sosireF."' AND `zb`.`data_plecare` <= '".$data_sosireF_over."'
									GROUP BY `zb`.`id_zbor`
									HAVING SUM(`zc`.`nr_locuri`) >= ('".$nr_persoane."')");
						
						
						while($r = mysql_fetch_array($s)){
								$rP = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc` INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa`
													INNER JOIN `clase` AS `cl` ON  `cl`.`id_clasa` = `cc`.`id_clasa` GROUP BY `zc`.`id_clasa` ");
								echo '<input type="radio" name="retur" value="'.$r['id_zbor'].'"';
														if(isset($_POST['retur']) and $_POST['retur']==$r['id_zbor']) echo ' checked="checked" ';
														echo ' />'.$r['aeroport_plecare'].', '.$r['oras_aeroport_plecare'].', '.$r['tara_aeroport_plecare'].' - '.$r['aeroport_sosire'].', '.$r['oras_aeroport_sosire'].', '.$r['tara_aeroport_sosire'].'<br>';
						}
						
						$sE1 = mysql_query("SELECT `rt`.`id_ruta` AS `ruta1`, `rt1`.`id_ruta`  AS `ruta2`, `rt`.`id_aeroport_sosire` AS `escala`
										FROM `rute` AS `rt` INNER JOIN `rute` AS `rt1` ON `rt`.`id_aeroport_sosire` = `rt1`.`id_aeroport_plecare`
										WHERE `rt`.`id_aeroport_plecare` = '".$_SESSION['rezervare']['informatii']['aeroport_sosire']."' AND `rt1`.`id_aeroport_sosire` = '".$_SESSION['rezervare']['informatii']['aeroport_plecare']."'");
					$vE1 = 0;
					while($rE1 = mysql_fetch_array($sE1)){
					
							$sEZ1 = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												WHERE `id_ruta`='".$rE1['ruta1']."' AND `data_plecare` >= '".$data_sosireF."' AND `data_plecare` <= '".$data_sosireF_over."' AND `status`= '1'
												GROUP BY `zb`.`id_zbor`
												HAVING SUM(`zc`.`nr_locuri`) >= ('".$nr_persoane."')");
												
							$sEZ2 = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												 WHERE `id_ruta`='".$rE1['ruta2']."' AND `data_plecare` >= '".$data_sosireF."' AND `data_plecare` <= '".$data_sosireF_over."' AND `status`= '1'
												 GROUP BY `zb`.`id_zbor`
												 HAVING SUM(`zc`.`nr_locuri`) >= ('".$nr_persoane."')");

												 
							$nrZ1 = mysql_num_rows($sEZ1);
							$nrZ2 = mysql_num_rows($sEZ2);
							
							$sAP1 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$_SESSION['rezervare']['informatii']['aeroport_sosire']."'");
							$sAP2 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$rE1['escala']."'");
							$sAP3 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$_SESSION['rezervare']['informatii']['aeroport_plecare']."'");
												 
							$rAP1 = mysql_fetch_assoc($sAP1);
							$rAP2 = mysql_fetch_assoc($sAP2);
							$rAP3 = mysql_fetch_assoc($sAP3);

							while($rEZ1 = mysql_fetch_array($sEZ1)){
								while($rEZ2 = mysql_fetch_array($sEZ2)){
									if(($rEZ1['data_sosire']+30*60)<=$rEZ2['data_plecare']){
									
											$sP1 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																WHERE `zc`.`id_zbor`='".$rEZ1['id_zbor']."'");
											$rP1 = mysql_fetch_assoc($sP1);

											$sP2 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																WHERE `zc`.`id_zbor`='".$rEZ2['id_zbor']."'");
											$rP2 = mysql_fetch_assoc($sP2);
											
											$pret_plecare  = $rP1['pret_plecare'] + $rP2['pret_plecare'];
											
											
 											echo '<input type="radio" name="retur" value="'.$rEZ1['id_zbor'].','.$rEZ2['id_zbor'].'"';
														if(isset($_POST['retur']) and $_POST['retur']==$rEZ1['id_zbor'].','.$rEZ2['id_zbor']) echo ' checked="checked" ';
														echo ' />'.$rAP1['denumire'].', '.$rAP1['oras'].', '.$rAP1['tara'].' - '.
												 $rAP2['denumire'].', '.$rAP2['oras'].', '.$rAP2['tara'].' - '. $rAP3['denumire'].', '.$rAP3['oras'].', '.$rAP3['tara'].' :'.$pret_plecare.'<br>';
											$vE1=1;
									}
									
								}
							}
							
					}

					$sE2 = mysql_query("SELECT `rt`.`id_ruta` AS `ruta1`, `rt1`.`id_ruta`  AS `ruta2`, `rt2`.`id_ruta` AS `ruta3`, `rt`.`id_aeroport_sosire` AS `escala1`, `rt1`.`id_aeroport_sosire` AS `escala2` 
										FROM `rute` AS `rt` INNER JOIN `rute` AS `rt1` ON `rt`.`id_aeroport_sosire` = `rt1`.`id_aeroport_plecare`
										INNER JOIN `rute` AS `rt2` ON `rt2`.`id_aeroport_plecare` = `rt1`.`id_aeroport_sosire`
										WHERE `rt`.`id_aeroport_plecare` = '".$_SESSION['rezervare']['informatii']['aeroport_sosire']."' AND `rt2`.`id_aeroport_sosire` = '".$_SESSION['rezervare']['informatii']['aeroport_plecare']."'");
					
					$vE2=0;
					while($rE2 = mysql_fetch_array($sE2)){
					
							$sEZ1 = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												WHERE `id_ruta`='".$rE2['ruta1']."' AND `data_plecare` >= '".$data_sosireF."' AND `data_plecare` <= '".$data_sosireF_over."' AND `status`= '1'
												GROUP BY `zb`.`id_zbor`
												HAVING SUM(`zc`.`nr_locuri`) >= ('".$nr_persoane."')");
							$sEZ2 = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												 WHERE `id_ruta`='".$rE2['ruta2']."' AND `data_plecare` >= '".$data_sosireF."' AND `data_plecare` <= '".$data_sosireF_over."' AND `status`= '1'
												 GROUP BY `zb`.`id_zbor`
												 HAVING SUM(`zc`.`nr_locuri`) >= ('".$nr_persoane."')");
							$sEZ3 = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												 WHERE `id_ruta`='".$rE2['ruta3']."' AND `data_plecare` >= '".$data_sosireF."' AND `data_plecare` <= '".$data_sosireF_over."' AND `status`= '1'
												 GROUP BY `zb`.`id_zbor`
												 HAVING SUM(`zc`.`nr_locuri`) >= ('".$nr_persoane."')");
							
							$nrZ1 = mysql_num_rows($sEZ1);
							$nrZ2 = mysql_num_rows($sEZ2);
							$nrZ3 = mysql_num_rows($sEZ3);
							
							$sAP1 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$_SESSION['rezervare']['informatii']['aeroport_sosire']."'");
							$sAP2 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$rE2['escala1']."'");
							$sAP3 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$rE2['escala2']."'");
							$sAP4 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$_SESSION['rezervare']['informatii']['aeroport_plecare']."'");
							$rAP1 = mysql_fetch_assoc($sAP1);
							$rAP2 = mysql_fetch_assoc($sAP2);
							$rAP3 = mysql_fetch_assoc($sAP3);
							$rAP4 = mysql_fetch_assoc($sAP4);
							
							while($rEZ1 = mysql_fetch_array($sEZ1)){
								while($rEZ2 = mysql_fetch_array($sEZ2)){
									while($rEZ3 = mysql_fetch_array($sEZ3))
									{

										if(($rEZ1['data_sosire']+30*60)<=$rEZ2['data_plecare'])
											if(($rEZ2['data_sosire']+30*60)<=$rEZ3['data_plecare'])
											{	$sP1 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																	WHERE `zc`.`id_zbor`='".$rEZ1['id_zbor']."'");
												$rP1 = mysql_fetch_assoc($sP1);
							
												$sP2 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																	WHERE `zc`.`id_zbor`='".$rEZ2['id_zbor']."'");
												$rP2 = mysql_fetch_assoc($sP2);
												
												$sP3 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																	WHERE `zc`.`id_zbor`='".$rEZ3['id_zbor']."'");
												$rP3 = mysql_fetch_assoc($sP3);
												
												$pret_plecare  = $rP1['pret_plecare'] + $rP2['pret_plecare'] + $rP3['pret_plecare'];
 												echo '<input type="radio" name="retur" value="'.$rEZ1['id_zbor'].','.$rEZ2['id_zbor'].','.$rEZ3['id_zbor'].'"';
														if(isset($_POST['retur']) and $_POST['retur']==$rEZ1['id_zbor'].','.$rEZ2['id_zbor'].','.$rEZ3['id_zbor']) echo ' checked="checked" ';
														echo ' />'.$rAP1['denumire'].', '.$rAP1['oras'].', '.$rAP1['tara'].' - '.
													 $rAP2['denumire'].', '.$rAP2['oras'].', '.$rAP2['tara'].' - '. $rAP3['denumire'].', '.$rAP3['oras'].', '.$rAP3['tara'].' - '. $rAP4['denumire'].', '.$rAP4['oras'].', '.
													 $rAP4['tara'].' :'.$pret_plecare.'<br>';
													 
												$vE2=1;
											}
									}
								}
							}
							
					}
					
					$sE3 = mysql_query("SELECT `rt`.`id_ruta` AS `ruta1`, `rt1`.`id_ruta`  AS `ruta2`, `rt2`.`id_ruta` AS `ruta3`, `rt3`.`id_ruta` AS `ruta4`,
										`rt`.`id_aeroport_sosire` AS `escala1`, `rt1`.`id_aeroport_sosire` AS `escala2`,`rt2`.`id_aeroport_sosire` AS `escala3` 
										FROM `rute` AS `rt` INNER JOIN `rute` AS `rt1` ON `rt`.`id_aeroport_sosire` = `rt1`.`id_aeroport_plecare`
										INNER JOIN `rute` AS `rt2` ON `rt2`.`id_aeroport_plecare` = `rt1`.`id_aeroport_sosire`
										INNER JOIN `rute` As `rt3` ON `rt3`.`id_aeroport_plecare` = `rt2`.`id_aeroport_sosire`
										WHERE `rt`.`id_aeroport_plecare` = '".$_SESSION['rezervare']['informatii']['aeroport_sosire']."' AND `rt3`.`id_aeroport_sosire` = '".$_SESSION['rezervare']['informatii']['aeroport_plecare']."'");
					$vE3=0;					
					while($rE3 = mysql_fetch_array($sE3)){
					
							$sEZ1 = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												WHERE `id_ruta`='".$rE3['ruta1']."' AND `data_plecare` >= '".$data_sosireF."' AND `data_plecare` <= '".$data_sosireF_over."' AND `status`= '1'
												GROUP BY `zb`.`id_zbor`
												HAVING SUM(`zc`.`nr_locuri`) >= ('".$nr_persoane."')");
							$sEZ2 = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												 WHERE `id_ruta`='".$rE3['ruta2']."' AND `data_plecare` >= '".$data_sosireF."' AND `data_plecare` <= '".$data_sosireF_over."' AND `status`= '1'
												 GROUP BY `zb`.`id_zbor`
												 HAVING SUM(`zc`.`nr_locuri`) >= ('".$nr_persoane."')");
							$sEZ3 = mysql_query("SELECT * FROM  `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												 WHERE `id_ruta`='".$rE3['ruta3']."' AND `data_plecare` >= '".$data_sosireF."' AND `data_plecare` <= '".$data_sosireF_over."' AND `status`= '1'
												 GROUP BY `zb`.`id_zbor`
												 HAVING SUM(`zc`.`nr_locuri`) >= ('".$nr_persoane."')");
							$sEZ4 = mysql_query("SELECT * FROM  `zboruri` AS `zb` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor` = `zb`.`id_zbor`
												 WHERE `id_ruta`='".$rE3['ruta4']."' AND `data_plecare` >= '".$data_sosireF."' AND `data_plecare` <= '".$data_sosireF_over."' AND `status`= '1'
												 GROUP BY `zb`.`id_zbor`
												 HAVING SUM(`zc`.`nr_locuri`) >= ('".$nr_persoane."')");
							
							$nrZ1 = mysql_num_rows($sEZ1);
							$nrZ2 = mysql_num_rows($sEZ2);
							$nrZ3 = mysql_num_rows($sEZ3);
							$nrZ4 = mysql_num_rows($sEZ4);
							
							
							$sAP1 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$_SESSION['rezervare']['informatii']['aeroport_sosire']."'");
							$sAP2 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$rE3['escala1']."'");
							$sAP3 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$rE3['escala2']."'");
							$sAP4 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$rE3['escala3']."'");
							$sAP5 = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `aero`.`id_tara` = `tr`.`id_tara`
												 WHERE `id_aeroport` ='".$_SESSION['rezervare']['informatii']['aeroport_plecare']."'");
							$rAP1 = mysql_fetch_assoc($sAP1);
							$rAP2 = mysql_fetch_assoc($sAP2);
							$rAP3 = mysql_fetch_assoc($sAP3);
							$rAP4 = mysql_fetch_assoc($sAP4);
							$rAP5 = mysql_fetch_assoc($sAP5);
							
							while($rEZ1 = mysql_fetch_array($sEZ1)){
								while($rEZ2 = mysql_fetch_array($sEZ2)){
									while($rEZ3 = mysql_fetch_array($sEZ3)){
										while($rEZ4 = mysql_fetch_array($sEZ4))
										{
											if(($rEZ1['data_sosire']+30*60)<=$rEZ2['data_plecare'])
												if(($rEZ2['data_sosire']+30*60)<=$rEZ3['data_plecare'])
													if(($rEZ3['data_sosire']+30*60)<=$rEZ4['data_plecare'])
													{	$sP1 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																			WHERE `zc`.`id_zbor`='".$rEZ1['id_zbor']."'");
														$rP1 = mysql_fetch_assoc($sP1);
									
														$sP2 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																			WHERE `zc`.`id_zbor`='".$rEZ2['id_zbor']."'");
														$rP2 = mysql_fetch_assoc($sP2);
														
														$sP3 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																			WHERE `zc`.`id_zbor`='".$rEZ3['id_zbor']."'");
														$rP3 = mysql_fetch_assoc($sP3);
														
														$sP4 = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc`
																			WHERE `zc`.`id_zbor`='".$rEZ4['id_zbor']."'");
														$rP4 = mysql_fetch_assoc($sP4);
														
														$pret_plecare  = $rP1['pret_plecare'] + $rP2['pret_plecare'] + $rP3['pret_plecare'] + $rP4['pret_plecare'];
														echo '<input type="radio" name="retur" value="'.$rEZ1['id_zbor'].','.$rEZ2['id_zbor'].','.$rEZ3['id_zbor'].','.$rEZ4['id_zbor'].'"';
														if(isset($_POST['retur']) and $_POST['retur']==$rEZ1['id_zbor'].','.$rEZ2['id_zbor'].','.$rEZ3['id_zbor'].','.$rEZ4['id_zbor']) echo ' checked="checked" ';
														echo ' />'.$rAP1['denumire'].', '.$rAP1['oras'].', '.$rAP1['tara'].' - '.
															 $rAP2['denumire'].', '.$rAP2['oras'].', '.$rAP2['tara'].' - '. $rAP3['denumire'].', '.$rAP3['oras'].', '.$rAP3['tara'].' - '. $rAP4['denumire'].', '.$rAP4['oras'].', '.
															 $rAP4['tara'].'-'.$rAP5['denumire'].', '.$rAP5['oras'].', '. $rAP5['tara'].' :'.$pret_plecare.'<br>';
														$vE3= 1;	 
													}
										}
									}
								}
							}
							
					}
					if(mysql_num_rows($s) == 0 AND $vE1 == 0 AND $vE2 == 0 AND $vE3 == 0) {
						echo 'Ne pare rau, dar nu a fost gasit zbor de intoarcere in data specificata';
						$ret = 0;
					}
					} 
							
					?>
					<?php if(!isset($ret)) { ?>
					<div>
						<input type="submit" id="y"  name="select_zbor" value="Continua" />
					</div>
					<?php } else { ?>
						<br/></br>
						<h4>Nu au fost gasite zboruri pentru ambele directii, va rugam sa schimbati data sau sa cautati dupa alte date!</h4>
					<?php }?>
					
					</form>
				</div>
				<?php } //nu e $flight ?>
				<?php if(isset($flight)) { ?>
				<div class="pasageri">
					<form action="" method="post" name="info_zbor" id="info_zbor" action="">
					<?php for($i=1;$i<=$nr_persoane;$i++) {?>
						<a href="#" class="afiseaza_formular" ><h3><?php echo $lang['PASAGERI_HEADER'];?> pentru pasagerul nr. <?php echo $i; ?></h3></a>
						<div class="pasageri-in">
							
							<div>
								<?php if(isset($err['titulatura'][$i])) echo '<span class="eroare">'.$err['titulatura'][$i].'</span>'; ?>
								<label><?php echo $lang['TITULATURA']; ?></label>
								
								<select id="titulatura" name="titulatura[<?php echo $i;?>]" placeholder="<?php echo $lang['TITULATURA']; ?>"  autocomplete="off">
									<option></option>
									<?php 
										$sql = mysql_query("SELECT * FROM `titulaturi`");
										while($rand = mysql_fetch_array($sql)) {
									?>
									<option value="<?php echo $rand['id_titulatura'];?>" <?php if(isset($_POST['titulatura'][$i]) and $_POST['titulatura'][$i]==$rand['id_titulatura']) echo 'selected'; ?>><?php echo $rand['titulatura'];?></option>
									<?php
									}
									?>	
								</select>						
							</div>
							<div>
								<?php if(isset($err['name'][$i])) echo '<span class="eroare">'.$err['name'][$i].'</span>'; ?>
								<label><?php echo $lang['NUME']; ?></label>
								<input type="text" id="name" name="name[<?php echo $i;?>]"  placeholder="<?php echo $lang['NUME_PLH'];?>"; value="<?php if(isset($_POST['name'][$i])) echo $_POST['name'][$i]; ?>" autocomplete="off" required="required" />
							</div>
							
							<div>
								<?php if(isset($err['prenume'][$i])) echo '<span class="eroare">'.$err['prenume'][$i].'</span>'; ?>
								<label><?php echo $lang['PRENUME']; ?></label>
								<input type="text" id="prenume" name="prenume[<?php echo $i;?>]" placeholder="<?php echo $lang['PRENUME_PLH']; ?>" value="<?php if(isset($_POST['prenume'][$i])) echo $_POST['prenume'][$i]; ?>"  autocomplete="off" required="required" />
							</div>
							
							<?php //pt toate zborurile..? dar cum  ?>
							<h2>TUR</h2>
						<?php 
							foreach($_SESSION['rezervare']['informatii']['tur']['id_zbor'] as $cheie=>$id_zbor) {
							
							$g = mysql_query("SELECT `zb`.`id_ruta` FROM `zboruri` AS `zb` INNER JOIN `rute` AS `rt` ON `zb`.`id_ruta` = `rt`.`id_ruta`
											 WHERE `zb`.`id_zbor`='".$id_zbor."'");
							$rg = mysql_fetch_assoc($g);
							$gAP = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `rute` AS `rt` ON `rt`.`id_aeroport_plecare` = `aero`.`id_aeroport`
												INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aero`.`id_tara`
												WHERE `rt`.`id_ruta`='".$rg['id_ruta']."'");
							$gAS = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `rute` AS `rt` ON `rt`.`id_aeroport_sosire` = `aero`.`id_aeroport`
												INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aero`.`id_tara`
												WHERE `rt`.`id_ruta`='".$rg['id_ruta']."'");
							$rgAP = mysql_fetch_assoc($gAP);
							$rgAS = mysql_fetch_assoc($gAS);
											 
						?>	
							<h3>Tur - zborul <?php echo $rgAP['denumire'].", ".$rgAP['oras'].", ".$rgAP['tara'].' - '.$rgAS['denumire'].", ".$rgAS['oras'].", ".$rgAS['tara'];?></h3>
							<div>
								<?php if(isset($err['clasa'][$id_zbor][$i])) echo '<span class="eroare">'.$err['clasa'][$id_zbor][$i].'</span>'; ?>
								<label><?php echo $lang['CLASA']; ?></label>					
								<select name="clasa[<?php echo $id_zbor; ?>][<?php echo $i;?>]" placeholder="<?php echo $lang['CLASA']; ?>"  autocomplete="off" class="select_zbor_clasa" rel="<?php echo $i; ?>">
									<option value="0"></option>
									<?php
									
										$s = mysql_query("SELECT  `cl`.`clasa` ,  `zc`.`pret_clasa` ,  `zc`.`nr_locuri` ,  `zc`.`id_zbor_clasa` ,  `zc`.`id_clasa` 
														  FROM  `zbor_clasa` AS  `zc` 
														  INNER JOIN  `companie_clase` AS  `cc` ON  `cc`.`id_clasa` =  `zc`.`id_clasa` 
														  INNER JOIN  `clase` AS  `cl` ON  `cl`.`id_clasa` =  `cc`.`id_clasa` 
														  WHERE  `zc`.`id_zbor` =  '".$id_zbor."'
														  GROUP BY  `zc`.`id_zbor_clasa` ");
										
										while($rand = mysql_fetch_array($s)) {
										echo $rand;
									?>
									<option value="<?php echo $rand['id_zbor_clasa'];?>"  <?php if(isset($_POST['clasa'][$id_zbor][$i]) and $_POST['clasa'][$id_zbor][$i]==$rand['id_zbor_clasa']) echo 'selected'; ?> ><?php echo $rand['clasa'];?></option>
									<?php
									}
									?>	
								</select>						
							</div>
							
							<div class="informatii_zbor_clasa">
							<!-- TOATE MODIFICARILE DE AICI, TREBUIE SA FIE LA FEL SI IN includes/rezervare1.php si mai jos in RETUR!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
							<?php if(isset($_POST['clasa'][$id_zbor][$i])) { 
								$z = mysql_query("SELECT `id_zbor` FROM `zbor_clasa` 
												  WHERE `id_zbor_clasa`='".cinp($_POST['clasa'][$id_zbor][$i])."'");
								$rz = mysql_fetch_assoc($z);
								$idZbor = $rz['id_zbor'];
								$id_zbor_clasa = $_POST['clasa'][$id_zbor][$i];
								$nr = $i;
								//$_SESSION['rezervare']['factura']['NUMEPOST'] = $_POST['NUMEPOST'];
							?>
								<?php
									$sql = mysql_query("SELECT `tm`.`denumire`, `zmc`.`id_zbor_meniu_clasa` 
																		FROM `zbor_meniu_clasa` AS `zmc` INNER JOIN `zbor_clasa` AS `zc` ON `zmc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa` 
																		INNER JOIN `meniu_companie` AS `mc` ON `mc`.`id_meniu` = `zmc`.`id_meniu` 
																		INNER JOIN `tipuri_meniu` AS `tm` ON `tm`.`id_meniu` = `mc`.`id_meniu` 
																		INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa` 
																		INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa` = `cc`.`id_clasa` 
																		WHERE `zmc`.`id_zbor_clasa` = '".$id_zbor_clasa."' 
																		GROUP BY `zmc`.`id_zbor_meniu_clasa`");
									if(mysql_num_rows($sql)!=0) {?>
								<div>
									<?php if(isset($err['meniu'][$idZbor][$nr])) echo '<span class="eroare">'.$err['meniu'][$idZbor][$nr].'</span>'; ?>
											<label><?php echo $lang['MENIU']; ?></label>

											<select name="meniu[<?php echo $idZbor;?>][<?php echo $nr; ?>]" placeholder="<?php echo $lang['MENIU']; ?>"  autocomplete="off">
													<option value="" ></option>
													<?php 
													
													while($rand = mysql_fetch_array($sql)) {
													?>
													<option value="<?php echo $rand['id_zbor_meniu_clasa'];?>" <?php if(isset($_POST['meniu'][$idZbor][$nr]) and $_POST['meniu'][$idZbor][$nr]==$rand['id_zbor_meniu_clasa']) echo 'selected'; ?>><?php echo $rand['denumire'];?></option>
													<?php
														}
													?>	
											</select>						
								</div>
								
								<?php } ?>
								<div>
													
									<?php 
										$s = mysql_query("SELECT `tb`.`tip_bagaj`, `zbc`.`id_tip_bagaj`,`zbc`.`id_zbor_bagaje_clasa`, `cl`.`clasa`, `zbc`.`pret`, `zbc`.`descriere` 
														FROM `zbor_bagaje_clasa` AS `zbc` INNER JOIN `zbor_clasa` AS `zc` ON `zbc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa` 
														INNER JOIN `bagaje_companie` AS `bc` ON `bc`.`id_tip_bagaj` = `zbc`.`id_tip_bagaj` 
														INNER JOIN `tipuri_bagaj` AS `tb` ON `tb`.`id_tip_bagaj` = `bc`.`id_tip_bagaj` 
														INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa` 
														INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa`=`cc`.`id_clasa` WHERE `zbc`.`id_zbor_clasa` = '".$id_zbor_clasa."' 
														GROUP BY `zbc`.`id_tip_bagaj`");
										$nr_tipuri_bagaj = mysql_num_rows($s);
										$nr_tb = 0;

										while($rTB = mysql_fetch_array($s)) {
											$nr_tb++;
										?>
										<?php if(isset($err['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']])) echo '<span class="eroare">'.$err['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']].'</span>'; ?>
											
													<?php 

														$sql = mysql_query("SELECT `zbc`.`descriere`, `zbc`.`pret`, `zbc`.`id_zbor_bagaje_clasa`, `zbc`.`id_tip_bagaj`
																			FROM `zbor_bagaje_clasa` AS `zbc` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor_clasa` = `zbc`.`id_zbor_clasa`
																			WHERE `zbc`.`id_tip_bagaj` = '".$rTB['id_tip_bagaj']."' AND `zc`.`id_zbor` = '".$idZbor."' AND `zbc`.`id_zbor_clasa` = '".$id_zbor_clasa."'");
														if(mysql_num_rows($sql)!=0) {
													
													?>
													<label><?php echo $rTB['tip_bagaj']; ?></label>
											<select  name="bagaj[<?php echo $idZbor; ?>][<?php echo $nr; ?>][<?php echo $rTB['id_tip_bagaj']; ?>]" placeholder="<?php echo $lang['BAGAJ']; ?>"  autocomplete="off">
												<option value="" <?php if(!isset($_POST['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']]) or  $_POST['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']]=="") echo 'selected'; ?>></option>
												<option value="0" <?php if(isset($_POST['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']]) and $_POST['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']]=="0") echo 'selected'; ?> >Nici una dintre aceste optiuni</option>
													<?php
														while($rand = mysql_fetch_array($sql)) {
													?>
																															
												<option value="<?php echo $rand['id_zbor_bagaje_clasa'];?>" <?php if(isset($_POST['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']]) and $_POST['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']]==$rand['id_zbor_bagaje_clasa']) echo 'selected'; ?> ><?php echo $rand['descriere']." - ".$rand['pret'];?></option>
												<?php
													}
												?>
												</select>	
												<?php
													}
												?>	
											
												
										<?php 
										}
										?>
								</div>

								<?php
									$sql = mysql_query("SELECT `cv`.`categorie`, `zrc`.`id_zbor_reducere_clasa`, `cl`.`clasa`, `zrc`.`reducere` 
																FROM `zbor_reduceri_clasa` AS `zrc` INNER JOIN `zbor_clasa` AS `zc` ON `zrc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa`
																INNER JOIN `companie_reduceri_categorii` AS `crc` ON `crc`.`id_categorie_varsta` = `zrc`.`id_categorie_varsta`
																INNER JOIN `categorii_varsta` AS `cv` ON `cv`.`id_categorie_varsta` = `crc`.`id_categorie_varsta`
																INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa`
																INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa`=`cc`.`id_clasa`
																WHERE `zrc`.`id_zbor_clasa` = '".$id_zbor_clasa."'
																GROUP BY `zrc`.`id_zbor_reducere_clasa`");
									if(mysql_num_rows($sql)!=0) {
								?>
								<div class="fieldset">
									<fieldset class="cat_field">
									   <legend>Selecteaza categoria de varsta</legend>
									   <p>
										<?php if(isset($err['categorie'][$idZbor][$nr])) echo '<span class="eroare">'.$err['categorie'][$idZbor][$nr].'</span>'; ?>
										   <label>Nici una dintre aceste categorii</label>
										   										   <input type = "radio" name="categorie[<?php echo $idZbor;?>][<?php echo $nr;?>]" value="0" <?php if(isset($_POST['categorie'][$idZbor][$nr]) and $_POST['categorie'][$idZbor][$nr]==0) echo 'checked';  ?>/>

								   <?php 
																						
											while($rand = mysql_fetch_array($sql)) {
											?>
												<label><?php echo $rand['categorie'];?></label>            
												<input type = "radio"   
												name="categorie[<?php echo $idZbor;?>][<?php echo $nr;?>]" <?php if(isset($_POST['categorie'][$idZbor][$nr]) and $_POST['categorie'][$idZbor][$nr]==$rand['id_zbor_reducere_clasa']) echo 'checked';  ?>
												value="<?php echo $rand['id_zbor_reducere_clasa']; ?>"/>
											<?php
												}
											?>	
										</p>       
									</fieldset>     
								</div>
							
							
							<?php } else echo '<input type="hidden" name="categorie['.$idZbor.']['.$nr.']" value="0" />'; }  ?>
							</div><!-- end informatii_zbor_clasa -->
							<?php } ?>
							
							
						<?php 
						if(isset($_SESSION['rezervare']['informatii']['retur']['id_zbor'])) {?>
							<h2>RETUR</h2>
						<?php 
							foreach($_SESSION['rezervare']['informatii']['retur']['id_zbor'] as $id_zbor) {
							
							$g = mysql_query("SELECT `zb`.`id_ruta` FROM `zboruri` AS `zb` INNER JOIN `rute` AS `rt` ON `zb`.`id_ruta` = `rt`.`id_ruta`
											 WHERE `zb`.`id_zbor`='".$id_zbor."'");
							$rg = mysql_fetch_assoc($g);
							$gAP = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `rute` AS `rt` ON `rt`.`id_aeroport_plecare` = `aero`.`id_aeroport`
												INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aero`.`id_tara`
												WHERE `rt`.`id_ruta`='".$rg['id_ruta']."'");
							$gAS = mysql_query("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `rute` AS `rt` ON `rt`.`id_aeroport_sosire` = `aero`.`id_aeroport`
												INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aero`.`id_tara`
												WHERE `rt`.`id_ruta`='".$rg['id_ruta']."'");
							$rgAP = mysql_fetch_assoc($gAP);
							$rgAS = mysql_fetch_assoc($gAS);
											 
						?>	
							<h3>Retur - zborul <?php echo $rgAP['denumire'].", ".$rgAP['oras'].", ".$rgAP['tara'].' - '.$rgAS['denumire'].", ".$rgAS['oras'].", ".$rgAS['tara'];?></h3>
							<div>
								<?php if(isset($err['clasa'][$id_zbor][$i])) echo '<span class="eroare">'.$err['clasa'][$id_zbor][$i].'</span>'; ?>
								<label><?php echo $lang['CLASA']; ?></label>					
								<select name="clasa[<?php echo $id_zbor; ?>][<?php echo $i;?>]" placeholder="<?php echo $lang['CLASA']; ?>"  autocomplete="off" class="select_zbor_clasa" rel="<?php echo $i; ?>">
									<option value="0"></option>
									<?php
									
										$s = mysql_query("SELECT  `cl`.`clasa` ,  `zc`.`pret_clasa` ,  `zc`.`nr_locuri` ,  `zc`.`id_zbor_clasa` ,  `zc`.`id_clasa` 
														  FROM  `zbor_clasa` AS  `zc` 
														  INNER JOIN  `companie_clase` AS  `cc` ON  `cc`.`id_clasa` =  `zc`.`id_clasa` 
														  INNER JOIN  `clase` AS  `cl` ON  `cl`.`id_clasa` =  `cc`.`id_clasa` 
														  WHERE  `zc`.`id_zbor` =  '".$id_zbor."'
														  GROUP BY  `zc`.`id_zbor_clasa` ");
										
										while($rand = mysql_fetch_array($s)) {
									?>
									<option value="<?php echo $rand['id_zbor_clasa'];?>"  <?php if(isset($_POST['clasa'][$id_zbor][$i]) and $_POST['clasa'][$id_zbor][$i]==$rand['id_zbor_clasa']) echo 'selected'; ?> ><?php echo $rand['clasa'];?></option>
									<?php
									}
									?>	
								</select>						
							</div>
							
							<div class="informatii_zbor_clasa">
							<!-- TOATE MODIFICARILE DE AICI, TREBUIE SA FIE LA FEL SI IN includes/rezervare1.php si mai jos in RETUR!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
							<?php if(isset($_POST['clasa'][$id_zbor][$i])) { 
								$z = mysql_query("SELECT `id_zbor` FROM `zbor_clasa` 
												  WHERE `id_zbor_clasa`='".cinp($_POST['clasa'][$id_zbor][$i])."'");
								$rz = mysql_fetch_assoc($z);
								$idZbor = $rz['id_zbor'];
								$id_zbor_clasa = $_POST['clasa'][$id_zbor][$i];
								$nr = $i;
								//$_SESSION['rezervare']['factura']['NUMEPOST'] = $_POST['NUMEPOST'];
							?>
								<?php 
									$sql = mysql_query("SELECT `tm`.`denumire`, `zmc`.`id_zbor_meniu_clasa` 
																		FROM `zbor_meniu_clasa` AS `zmc` INNER JOIN `zbor_clasa` AS `zc` ON `zmc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa` 
																		INNER JOIN `meniu_companie` AS `mc` ON `mc`.`id_meniu` = `zmc`.`id_meniu` 
																		INNER JOIN `tipuri_meniu` AS `tm` ON `tm`.`id_meniu` = `mc`.`id_meniu` 
																		INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa` 
																		INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa` = `cc`.`id_clasa` 
																		WHERE `zmc`.`id_zbor_clasa` = '".$id_zbor_clasa."' 
																		GROUP BY `zmc`.`id_zbor_meniu_clasa`");
									if(mysql_num_rows($sql)!=0) {
									?>
								<div>
									<?php if(isset($err['meniu'][$idZbor][$nr])) echo '<span class="eroare">'.$err['meniu'][$idZbor][$nr].'</span>'; ?>
											<label><?php echo $lang['MENIU']; ?></label>

											<select name="meniu[<?php echo $idZbor;?>][<?php echo $nr; ?>]" placeholder="<?php echo $lang['MENIU']; ?>"  autocomplete="off">
													<option value=""></option>
													<?php 
													
													while($rand = mysql_fetch_array($sql)) {
													?>
													<option value="<?php echo $rand['id_zbor_meniu_clasa'];?>" <?php if(isset($_POST['meniu'][$idZbor][$nr]) and $_POST['meniu'][$idZbor][$nr]==$rand['id_zbor_meniu_clasa']) echo 'selected'; ?>><?php echo $rand['denumire'];?></option>
													<?php
														}
													?>	
											</select>						
								</div>
								
								<?php } ?>	
								<div>
													
									<?php 
										$s = mysql_query("SELECT `tb`.`tip_bagaj`, `zbc`.`id_tip_bagaj`,`zbc`.`id_zbor_bagaje_clasa`, `cl`.`clasa`, `zbc`.`pret`, `zbc`.`descriere` 
														FROM `zbor_bagaje_clasa` AS `zbc` INNER JOIN `zbor_clasa` AS `zc` ON `zbc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa` 
														INNER JOIN `bagaje_companie` AS `bc` ON `bc`.`id_tip_bagaj` = `zbc`.`id_tip_bagaj` 
														INNER JOIN `tipuri_bagaj` AS `tb` ON `tb`.`id_tip_bagaj` = `bc`.`id_tip_bagaj` 
														INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa` 
														INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa`=`cc`.`id_clasa` WHERE `zbc`.`id_zbor_clasa` = '".$id_zbor_clasa."' 
														GROUP BY `zbc`.`id_tip_bagaj`");
										$nr_tipuri_bagaj = mysql_num_rows($s);
										$nr_tb = 0;

										while($rTB = mysql_fetch_array($s)) {
											$nr_tb++;
										?>
										<?php if(isset($err['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']])) echo '<span class="eroare">'.$err['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']].'</span>'; ?>
											
													<?php 

														$sql = mysql_query("SELECT `zbc`.`descriere`, `zbc`.`pret`, `zbc`.`id_zbor_bagaje_clasa`, `zbc`.`id_tip_bagaj`
																			FROM `zbor_bagaje_clasa` AS `zbc` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor_clasa` = `zbc`.`id_zbor_clasa`
																			WHERE `zbc`.`id_tip_bagaj` = '".$rTB['id_tip_bagaj']."' AND `zc`.`id_zbor` = '".$idZbor."' AND `zbc`.`id_zbor_clasa` = '".$id_zbor_clasa."'");
													
														if(mysql_num_rows($sql)!=0) {
													
													?>
													<label><?php echo $rTB['tip_bagaj']; ?></label>
											<select  name="bagaj[<?php echo $idZbor; ?>][<?php echo $nr; ?>][<?php echo $rTB['id_tip_bagaj']; ?>]" placeholder="<?php echo $lang['BAGAJ']; ?>"  autocomplete="off">
												<option value="" <?php if(!isset($_POST['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']]) or  $_POST['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']]=="") echo 'selected'; ?>></option>
												<option value="0" <?php if(isset($_POST['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']]) and $_POST['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']]=="0") echo 'selected'; ?> >Nici una dintre aceste optiuni</option>
													<?php
														while($rand = mysql_fetch_array($sql)) {
													?>
																															
												<option value="<?php echo $rand['id_zbor_bagaje_clasa'];?>" <?php if(isset($_POST['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']]) and $_POST['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']]==$rand['id_zbor_bagaje_clasa']) echo 'selected'; ?> ><?php echo $rand['descriere']." - ".$rand['pret'];?></option>
												<?php
													}
												?>
												</select>	
												<?php
													}
												?>	
											
												
										<?php 
										}
										?>
								</div>
								<?php
									$sql = mysql_query("SELECT `cv`.`categorie`, `zrc`.`id_zbor_reducere_clasa`, `cl`.`clasa`, `zrc`.`reducere` 
																FROM `zbor_reduceri_clasa` AS `zrc` INNER JOIN `zbor_clasa` AS `zc` ON `zrc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa`
																INNER JOIN `companie_reduceri_categorii` AS `crc` ON `crc`.`id_categorie_varsta` = `zrc`.`id_categorie_varsta`
																INNER JOIN `categorii_varsta` AS `cv` ON `cv`.`id_categorie_varsta` = `crc`.`id_categorie_varsta`
																INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa`
																INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa`=`cc`.`id_clasa`
																WHERE `zrc`.`id_zbor_clasa` = '".$id_zbor_clasa."'
																GROUP BY `zrc`.`id_zbor_reducere_clasa`");
									if(mysql_num_rows($sql)!=0) {
								?>
								<div class="fieldset">
									<fieldset class="cat_field">
									   <legend>Selecteaza categoria de varsta</legend>
									   <p>
										<?php if(isset($err['categorie'][$idZbor][$nr])) echo '<span class="eroare">'.$err['categorie'][$idZbor][$nr].'</span>'; ?>
										   <label>Nici una dintre aceste categorii</label>
										   <input type = "radio" name="categorie[<?php echo $idZbor;?>][<?php echo $nr;?>]" value="0" <?php if(isset($_POST['categorie'][$idZbor][$nr]) and $_POST['categorie'][$idZbor][$nr]==0) echo 'checked';  ?>/>

								   <?php 
																						
											while($rand = mysql_fetch_array($sql)) {
											?>
												<label><?php echo $rand['categorie'];?></label>            
												<input type = "radio"   
												name="categorie[<?php echo $idZbor;?>][<?php echo $nr;?>]" <?php if(isset($_POST['categorie'][$idZbor][$nr]) and $_POST['categorie'][$idZbor][$nr]==$rand['id_zbor_reducere_clasa']) echo 'checked';  ?>
												value="<?php echo $rand['id_zbor_reducere_clasa']; ?>"/>
											<?php
												}
											?>	
										</p>       
									</fieldset>     
								</div>
							
							
							<?php } else echo '<input type="hidden" name="categorie['.$idZbor.']['.$nr.']" value="0" />'; }  ?>
							</div><!-- end informatii_zbor_clasa -->	
						
							
							<?php } ?>
							
								<?php } ?>
							</div>
						
					<?php } ?>
					<div>
							<input type="submit" name="info_zbor" id="info_zbor" value="" />
					</div>
					
					</form>
					
				</div>
				<?php } //end flight ?>
				<?php if(isset($date_facturare)) { ?>
				<div id="info_contact">
					<h1><?php echo $lang['DATE_OBLIGATORII']; ?></h1>
					<form action="" method="post" name="register_form" id="creare_cont" action="">
						
							<?php if(isset($succes)) echo '<span class="succes">'.$succes.'</span>'; ?>
							
							<div>
									<?php if(isset($err['titulatura'])) echo '<span class="eroare">'.$err['titulatura'].'</span>'; ?>
									<label><?php echo $lang['TITULATURA']; ?></label>

									<select id="titulatura" name="titulatura" placeholder="<?php echo $lang['TITULATURA']; ?>"  autocomplete="off">
										<option></option>
										<?php 
											$sql = mysql_query("SELECT * FROM `titulaturi`");
											while($rand = mysql_fetch_array($sql)) {
										?>
										<option value="<?php echo $rand['id_titulatura'];?>"><?php echo $rand['titulatura'];?></option>
										<?php
										}
										?>	
									</select>						
							</div>
							
							<div>
								<?php if(isset($err['name'])) echo '<span class="eroare">'.$err['name'].'</span>'; ?>
								<label><?php echo $lang['NUME']; ?></label>
								<input type="text" id="name" onBlur="validateNume();" name="name" placeholder="<?php echo $lang['NUME_PLH'];?>"; value="<?php if(isset($nume)) echo $nume;?>" autocomplete="off" required="required" />
							</div>


							<div>
								<?php if(isset($err['prenume'])) echo '<span class="eroare">'.$err['prenume'].'</span>'; ?>
								<label><?php echo $lang['PRENUME']; ?></label>
								<input type="text" id="prenume" onBlur="validatePrenume();" name="prenume" placeholder="<?php echo $lang['PRENUME_PLH']; ?>" value="<?php if(isset($prenume)) echo $prenume;?>"  autocomplete="off" required="required" />
							</div>

							<div>
								<?php if(isset($err['adresa'])) echo '<span class="eroare">'.$err['adresa'].'</span>'; ?>
								<label><?php echo $lang['ADRESA']; ?></label>
								<input type="text" name="adresa" id="adresa" onBlur="validateAdresa()" placeholder="<?php echo $lang['ADRESA_PLH']; ?>" value="<?php if(isset($adresa)) echo $adresa;?>" autocomplete="off" />
							</div>

							<div>
								<?php if(isset($err['oras'])) echo '<span class="eroare">'.$err['oras'].'</span>'; ?>
								<label><?php echo $lang['ORAS']; ?></label>
								<input type="text" name="oras"  id="oras" onBlur="validateOras()" placeholder="<?php echo $lang['ORAS_PLH']; ?>" value="<?php if(isset($oras)) echo $oras;?>" autocomplete="off" />
							</div>
							
							<div>
								<?php if(isset($err['tara'])) echo '<span class="eroare">'.$err['tara'].'</span>'; ?>
								<label><?php echo $lang['TARA']; ?></label>
								<select id="tara" onChange="slctemp()" onBlur="madeSelection()" name="tara" placeholder="<?php echo $lang['TARA_PLH']; ?>"  autocomplete="off">
										<option></option>
										<?php 
										$sql = mysql_query("SELECT * FROM `tari`");
											while($rand = mysql_fetch_array($sql)) {
										?>
										<option value="<?php echo $rand['id_tara'];?>"><?php echo $rand['tara'];?></option>
										<?php
										}
										?>	
									</select>
							</div>

							<div>
								<?php if(isset($err['codPostal'])) echo '<span class="eroare">'.$err['codPostal'].'</span>'; ?>
								<label><?php echo $lang['COD_POSTAL']; ?></label>
								<input type="text" name="codPostal" id="codPostal" onBlur="validateCodPostal()" placeholder="<?php echo $lang['COD_POSTAL_PLH']; ?>" value="<?php if(isset($codPostal)) echo $codPostal;?>" autocomplete="off" />
							</div>

							<div>
								<?php if(isset($err['email'])) echo '<span class="eroare">'.$err['email'].'</span>'; ?>
								<label><?php echo $lang['EMAIL']; ?></label>
								<input type="email" name="email" id="email" onBlur="validateEmail()" placeholder="<?php echo $lang['EMAIL_PLH']; ?>" value="<?php if(isset($email)) echo $email;?>" autocomplete="off" required="required" />
							</div>

							<div>
								<?php if(isset($err['telefon'])) echo '<span class="eroare">'.$err['telefon'].'</span>'; ?>
								<label><?php echo $lang['TELEFON']; ?></label>
								<input type="tel" id="telefon" name="telefon" onKeyup="isNumeric()" maxlength="10" splaceholder="<?php echo $lang['TELEFON_PLH']; ?>" value="<?php if(isset($telefon)) echo $telefon;?>" autocomplete="off" required="required"/>
							</div>

							<div>
								<input type="submit" id="x" name="contact_info" value="Continua" />
							</div>
					</form>
				</div>
				<?php } ?>
				<?php if(isset($date_rezervare)) { ?>
				<div id="rezumat_rezervare">
					<h3>Rezumatul rezervarii</h3>
					<form action="" method="post" class="rezumat_rezervare">
						<?php foreach ($_SESSION['rezervare']['informatii'] as $key_info => $value_info) { 
								
								if($key_info=="tur") {
									echo '<br/><h4>TUR</h4>'.'<br/><br/>';
									foreach($value_info['id_zbor'] as $key_zbor=>$value_zbor) {
										
										//echo "ID zbor tur: ".$key_zbor."->".$value_zbor.'<br/>';
										$s = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `rute` AS `rt` ON `zb`.`id_ruta` = `rt`.`id_ruta` 
														  WHERE `zb`.`id_zbor` = '".$value_zbor."'");
										$r = mysql_fetch_assoc($s);
										
										$sAP = mysql_query("SELECT * FROM `aeroporturi` AS `aeroP` INNER JOIN `rute` AS `rt` ON `rt`.`id_aeroport_plecare` = `aeroP`.`id_aeroport`
														  INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aeroP`.`id_tara`
														  WHERE `rt`.`id_ruta`='".$r['id_ruta']."'");
														  
										$sAS = mysql_query("SELECT * FROM `aeroporturi` AS `aeroS` INNER JOIN `rute` AS `rt` ON `rt`.`id_aeroport_sosire` = `aeroS`.`id_aeroport`
														  INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aeroS`.`id_tara`
														  WHERE `rt`.`id_ruta`='".$r['id_ruta']."'");
														  
											$data_plecareZR = date("d/m/Y",$r['data_plecare']);
											$ora_plecareR = date("G",$r['data_plecare']);
											$minut_plecareR= date("i",$r['data_plecare']);
											
											$data_sosireZR = date("d/m/Y",$r['data_sosire']);
											$ora_sosireR = date("G",$r['data_sosire']);
											$minut_sosireR= date("i",$r['data_sosire']);
										
										$rAP = mysql_fetch_assoc($sAP);
										$rAS = mysql_fetch_assoc($sAS);
										echo 'Plecare: '.' '.$data_plecareZR.", ".$ora_plecareR.":".$minut_plecareR." - Sosire: ".$data_sosireZR.", ".$ora_sosireR.":".$minut_sosireR."<br/>";
										echo 'Aeroport plecare: '.$rAP['denumire'].", ".$rAP['oras'].", ".$rAP['tara'].'<br/>';
										echo 'Aeroport sosire: '.$rAS['denumire'].", ".$rAS['oras'].", ".$rAS['tara'].'<br/>';										
										
										echo '<br/>';
									}
								} elseif($key_info=="retur") {
									echo '<br/><h4>RETUR</h4>'.'<br/>';
									foreach($value_info['id_zbor'] as $key_zbor=>$value_zbor) {
										//echo "ID zbor retur: ".$key_zbor."->".$value_zbor.'<br/>';
										$s = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `rute` AS `rt` ON `zb`.`id_ruta` = `rt`.`id_ruta` 
														  WHERE `zb`.`id_zbor` = '".$value_zbor."'");
										$r = mysql_fetch_assoc($s);
										
										$sAP = mysql_query("SELECT * FROM `aeroporturi` AS `aeroP` INNER JOIN `rute` AS `rt` ON `rt`.`id_aeroport_plecare` = `aeroP`.`id_aeroport`
														  INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aeroP`.`id_tara`
														  WHERE `rt`.`id_ruta`='".$r['id_ruta']."'");
														  
										$sAS = mysql_query("SELECT * FROM `aeroporturi` AS `aeroS` INNER JOIN `rute` AS `rt` ON `rt`.`id_aeroport_sosire` = `aeroS`.`id_aeroport`
														  INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aeroS`.`id_tara`
														  WHERE `rt`.`id_ruta`='".$r['id_ruta']."'");
														  
											$data_plecareZR = date("d/m/Y",$r['data_plecare']);
											$ora_plecareR = date("G",$r['data_plecare']);
											$minut_plecareR= date("i",$r['data_plecare']);
											
											$data_sosireZR = date("d/m/Y",$r['data_sosire']);
											$ora_sosireR = date("G",$r['data_sosire']);
											$minut_sosireR= date("i",$r['data_sosire']);
										
										$rAP = mysql_fetch_assoc($sAP);
										$rAS = mysql_fetch_assoc($sAS);
										echo 'Aeroport plecare: '.$rAP['denumire'].", ".$rAP['oras'].", ".$rAP['tara'].'<br/>';
										echo 'Aeroport sosire: '.$rAS['denumire'].", ".$rAS['oras'].", ".$rAS['tara'].'<br/>';										
										echo 'Plecare: '.$data_plecareZR.", ".$ora_plecareR.":".$minut_plecareR." - Sosire:".$data_sosireZR.", ".$ora_sosireR.":".$minut_sosireR;
										echo '<br/>';
									}
								} else {
									//echo  $key_info.'->'.$value_info.'</br>';
									if($key_info == 'aeroport_plecare')
										{
											$s = mysql_query ("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aero`.`id_tara`
																WHERE `id_aeroport`='".$value_info."'");
											$r = mysql_fetch_assoc($s);
											echo 'Ruta: '.$r['denumire'].", ".$r['oras'].", ".$r['tara']." - ";
										}
									if($key_info == 'aeroport_sosire')
										{
											$s = mysql_query ("SELECT * FROM `aeroporturi` AS `aero` INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aero`.`id_tara`
																WHERE `id_aeroport`='".$value_info."'");
											$r = mysql_fetch_assoc($s);
											echo $r['denumire'].", ".$r['oras'].", ".$r['tara']."<br/>";
										}
									if($key_info == 'data_plecare')
											echo 'Data plecare: '.$value_info."<br/>";
									if($key_info == 'data_sosire' AND $value_info!="")
											echo 'Data intoarcere: '.$value_info."<br/>";
									if($key_info == 'nr_persoane')
											echo 'Numarul de persoane: '.$value_info."<br/>";
								}
							 } 
							 echo '<hr class="hr_rezervare"/>';
							 echo '<h2>Date persoane</h2>';
							 $i = 0;
							 $pret_rezervare = 0;
							 foreach($_SESSION['rezervare']['setari']['persoane'] as $key_persoana => $value_persoana) { 
								$i=$i+1;?>
								<div class="persoana">
									<!-- <b>Titulatura:</b> --> <?php 
									 //$value_persoana['titulatura']; 
										$pretP[$i] = 0;
										$s = mysql_query("SELECT * FROM `titulaturi` WHERE `id_titulatura`='".$value_persoana['titulatura']."'");
										$r = mysql_fetch_assoc($s);
										echo "<h4>".$r['titulatura']." ";
									?>
									
									<!-- <b>Nume:</b>--> <?php  echo $value_persoana['name']." "; ?>
									<!-- <b>Prenume:</b>--> <?php  echo $value_persoana['prenume']."</h4>"; ?>
			
									<?php $j=0; ?>
									<?php foreach($_SESSION['rezervare']['setari']['id_zbor'] as $key_id_zbor=>$value_id_zbor) { ?>
										<?php $j++; ?>
										<br/><br/>
									<h3 class="st_zb">Setari zborul <?php
											$pretC[$i][$j] = 0; 
										  $pretB[$i][$j] = 0;
										  $reducere[$i][$j]=0;
										  $pretFinal[$i][$j] = 0;
										$f = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `rute` AS `rt` ON `rt`.`id_ruta`=`zb`.`id_ruta`
														  WHERE `zb`.`id_zbor` = '".$key_id_zbor."' ");
										$r = mysql_fetch_assoc($f);
										$fAP = mysql_query("SELECT * FROM `aeroporturi` AS `aeroS` INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aeroS`.`id_tara`
														   WHERE `aeroS`.`id_aeroport`='".$r['id_aeroport_plecare']."'");
										$rfAP = mysql_fetch_assoc($fAP);
										$fAS = mysql_query("SELECT * FROM `aeroporturi` AS `aeroS` INNER JOIN `tari` AS `tr` ON `tr`.`id_tara` = `aeroS`.`id_tara`
														   WHERE `aeroS`.`id_aeroport`='".$r['id_aeroport_sosire']."'");
										$rfAS = mysql_fetch_assoc($fAS);
										
										echo $rfAP['denumire'].", ".$rfAP['oras'].", ".$rfAP['tara']."  -  ".$rfAS['denumire'].", ".$rfAS['oras'].", ".$rfAS['tara']; ?>
									</h3>
									<div class="zbor">
										
										<div class="clasa_confort">
											<b>Clasa:</b>
											<?php 
											//echo $value_id_zbor['persoane'][$key_persoana]['clasa'];
												$cs = mysql_query("SELECT `cl`.`clasa`,`zc`.`pret_clasa` FROM `zbor_clasa` AS `zc` INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa` = `zc`.`id_clasa`
																   WHERE `zc`.`id_zbor_clasa`='".$value_id_zbor['persoane'][$key_persoana]['clasa']."'
																   GROUP BY `zc`.`id_zbor`");
												$rcs = mysql_fetch_assoc($cs);
												echo $rcs['clasa']." (".$rcs['pret_clasa']." LEI)";
												$pretC[$i][$j] =  $pretC[$i][$j] + $rcs['pret_clasa'];
											?> <!-- aici e id_zbor_clasa -->
											<?php if(isset($value_id_zbor['persoane'][$key_persoana]['meniu'])) { ?>
											<div class="meniu">
											<b>Meniu:</b>
											<?php 
												//echo $value_id_zbor['persoane'][$key_persoana]['meniu'];
												$cm = mysql_query("SELECT `tm`.`denumire` FROM `zbor_meniu_clasa` AS `zmc` INNER JOIN `tipuri_meniu` AS `tm` ON `tm`.`id_meniu` = `zmc`.`id_meniu`
																   WHERE `zmc`.`id_zbor_meniu_clasa`='".$value_id_zbor['persoane'][$key_persoana]['meniu']."' AND `zmc`.`id_zbor_clasa` = '".$value_id_zbor['persoane'][$key_persoana]['clasa']."'
																   GROUP BY `zmc`.`id_zbor_clasa`");
												$rcm = mysql_fetch_assoc($cm);
												echo $rcm['denumire'];
											?><!-- aici e id_zbor_meniu_clasa ? asa parca-->
											</div><!-- meniu -->
											<?php  } ?>
											<?php if(isset($value_id_zbor['persoane'][$key_persoana]['bagaj'])) { ?>
											<div class="bagaj">
											<b>Bagaje:</b><br/>
											<?php foreach($value_id_zbor['persoane'][$key_persoana]['bagaj'] as $key_bagaj=>$value_bagaj) { ?>
												<b><?php //echo $key_bagaj; 
												$stb = mysql_query("SELECT *
																	FROM `tipuri_bagaj` AS `tb`
																	WHERE `tb`.`id_tip_bagaj` = '". $key_bagaj."'");
												$rtb = mysql_fetch_assoc($stb);
												
												echo $rtb['tip_bagaj'];
																	//aici query-ul dupa id_tip_bagaj aici nu? da, cred. e in functie de ce ai pus in rezervare 1, tipu-ul principal ?>:</b> 
												<?php if($value_bagaj==0) echo "nicio alegere"; else {
														$sb = mysql_query("SELECT * FROM `zbor_bagaje_clasa` AS `zbc` 
																			WHERE `zbc`.`id_zbor_bagaje_clasa`='".$value_bagaj."'
																			GROUP BY `zbc`.`id_zbor_clasa`");
														$rb = mysql_fetch_assoc($sb);
														$pretB[$i][$j] = $pretB[$i][$j] + $rb['pret'];
														//echo $value_bagaj;
														echo $rb['descriere']." (".$rb['pret']." LEI)";
														}; //query dupa id_clasa_bagaj.. bla, stii tu "DAp; ?>	<br/>										
											<?php } ?>
											</div><!-- bagaj -->
											<?php } ?>
											<?php if(isset($value_id_zbor['persoane'][$key_persoana]['categorie'])) { ?>
											<div class="categorie">
											<b>Reducere:</b> <?php 
												if($value_id_zbor['persoane'][$key_persoana]['categorie']==0) echo 'nicio alegere'; else{
													//echo $value_id_zbor['persoane'][$key_persoana]['categorie'];
														$cc = mysql_query("SELECT `cv`.`categorie`, `zrc`.`reducere`
																			FROM `zbor_reduceri_clasa` AS `zrc`
																			INNER JOIN `categorii_varsta` AS `cv` ON `cv`.`id_categorie_varsta` = `zrc`.`id_categorie_varsta`
																			WHERE `zrc`.`id_zbor_reducere_clasa` ='".$value_id_zbor['persoane'][$key_persoana]['categorie']."' AND `zrc`.`id_zbor_clasa` = '".$value_id_zbor['persoane'][$key_persoana]['clasa']."'
																			GROUP BY `zrc`.`id_zbor_clasa`");
														$rcc = mysql_fetch_assoc($cc);
														echo $rcc['categorie'].' ('.$rcc['reducere'].'%)';
														$reducere[$i][$j] = $reducere[$i][$j] + $rcc['reducere'];
													}?>
											</div><!-- categorie -->
											<?php } ?>
										</div><!-- clasa_confort-->
										<?php //echo 'preturi '.$i." ".$j." - ".$pretC[$i][$j]." ";
										 //  echo 'pret bagaj'.$pretB[$i][$j]." ";
										 //  echo 'reducere'.$reducere[$i][$j].' ';
										   $pretFinal[$i][$j] = $pretB[$i][$j] + $pretC[$i][$j] - ($reducere[$i][$j]*$pretC[$i][$j]/100);
										  // echo 'pret final persoana zbor '.$pretFinal[$i][$j].'<br/>';
										   $pretP[$i] = $pretP[$i] + $pretFinal[$i][$j];
										   echo '<span style="font-size: 110%; font-style: italic;">Pret pe zbor: <b>'.$pretFinal[$i][$j].' LEI</b></span><br/>';
										   ?>
									<?php }
									echo '<br/><span style="font-size: 160%;">Pret final pe persoana: <b>'.$pretP[$i].' LEI</b></span>';
										$pret_rezervare = $pret_rezervare + $pretP[$i];
									echo '<hr class="hr_rezervare2"/>';
										?>
									
									</div><!-- zbor -->
									
									
								</div><!-- persoana-->
								<?php
							 }//end foreach persoane
							 echo $pret_rezervare;
							 echo '<hr class="hr_rezervare"/>';
							 echo "<h3>Date de contact</h3><br/>";
							 foreach($_SESSION['rezervare']['factura'] as $key_factura => $value_factura) { 
							  //echo '<b>'.$key_factura.'</b> '.$value_factura.'</br>';

								if($key_factura == 'titulatura'){
									$s = mysql_query("SELECT * FROM `titulaturi` WHERE `id_titulatura`='".$value_factura."'");
									$r = mysql_fetch_assoc($s);
									echo $r['titulatura']." ";
								}
								if($key_factura == 'name')
									echo $value_factura." ";
								if($key_factura == 'prenume')
									echo $value_factura." ";
								if($key_factura == 'adresa')
									echo '<br/>'."Adresa: ".$value_factura." ";
								if($key_factura == 'oras')
									echo '<br/>'."Oras: ".$value_factura." ";
								if($key_factura == 'tara'){
									$s = mysql_query("SELECT * FROM `tari` WHERE `id_tara` = '".$value_factura."'");
									$r = mysql_fetch_assoc($s);
									echo '<br/>'."Tara: ".$r['tara']." ";
								}
								if($key_factura == 'codPostal')
									echo '<br/>'."Cod Postal: ".$value_factura." ";
								if($key_factura == 'email')
									echo '<br/>'."Email: ".$value_factura." ";
								if($key_factura == 'telefon')
									echo '<br/>'."Telefon: ".$value_factura." ";
									
								
							 }
							 echo '<br/>';
						?>
						
						<br/>
						<p>Daca datele introduse sunt corecte, apasati butonul de mai jos. Daca nu, folositi meniul din partea de sus pentru a edita rezervarea.</p>
						<input type="submit" value="Confirmare" name="confirm_rezervare"/>
					</form>
				</div
				<?php } ?>
				<?php }//rezervare ?>
			</section>
		</div>
	</div>

<?php include('footer.php'); ?> 