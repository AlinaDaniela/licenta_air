<?php require_once("config.php");?>
 <?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user'])) header("Location: cont.php");

if(!isset($_SESSION['rezervare']['informatii']['aeroport_plecare']) 
	or !isset($_SESSION['rezervare']['informatii']['aeroport_sosire']) 
	or !isset($_SESSION['rezervare']['informatii']['data_plecare'])
	or !isset($_SESSION['rezervare']['informatii']['nr_persoane']))
		$err = "Folositi formularul de mai sus pentru a cauta o ruta";
else {	
	$aeroport_plecare = $_SESSION['rezervare']['informatii']['aeroport_plecare'];
	
	$aeroport_sosire = $_SESSION['rezervare']['informatii']['aeroport_sosire'];
	
	$data_plecare = $_SESSION['rezervare']['informatii']['data_plecare'];
	$data_sosire = $_SESSION['rezervare']['informatii']['data_sosire'];
	
	$data_plecare_separat = explode("/",$_SESSION['rezervare']['informatii']['data_plecare']);
	if(isset($_SESSION['rezervare']['informatii']['data_sosire'])) $data_sosire_separat = explode("/",$_SESSION['rezervare']['informatii']['data_sosire']);
	
	$nr_persoane = $_SESSION['rezervare']['informatii']['nr_persoane'];
	
	$data_plecareF = mktime(0,0,0,$data_plecare_separat[0],$data_plecare_separat[1],$data_plecare_separat[2]);  //aici incepe ziua
	$data_plecareF_over = mktime(23,59,59,$data_plecare_separat[0],$data_plecare_separat[1],$data_plecare_separat[2]);  //aici se termina
	if(!empty($_SESSION['rezervare']['informatii']['data_sosire'])) {
		$data_sosireF = mktime(0,0,0,$data_sosire_separat[0],$data_sosire_separat[1],$data_sosire_separat[2]); 
		$data_sosireF_over = mktime(23,59,59,$data_sosire_separat[0],$data_sosire_separat[1],$data_sosire_separat[2]); 
	}
	
	
	//query-ul trebuie facut ca intrarea din baza de date sa fie itnre inceputul si sfarsitul zilei de ce? acum got it ? Nu ma prind :| 
	//data din baza ta de date este sub forma 111111155555 - ce inseamna sa zicem 2.iulie.2013 14:21:23
	// ca sa gasesti acea data, doar dandu-i ziua, trebuie sa cauti intre secunda 0 a zilei si ultima, adica 2. iulie.2013 23:59:59
	//got it ? da
	// deci, in seara asta, baga mai multe date de genul asta in baza de date
	//cu ore diferite, in aceeasi zi ok
	// WHERE `data_plecare`=>'".$data_plecareF."' AND `data_plecare`<='".$data_plecareF_over."'
	
	//scrie aici, ca sa ramana
	if(isset($_GET['flight'])) {
		$flight = $_GET['flight']; //aici o sa fie un array cu info despre ruta alea.. practic, id-uri de zboruri
		
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
				if(isset($_SESSION['rezervare']['informatii']['tur']['id_zbor'])) unset($_SESSION['rezervare']['informatii']['tur']['id_zbor']); 
				$_SESSION['rezervare']['informatii']['tur']['id_zbor'][] = $_POST['tur'];
				if(isset($_SESSION['rezervare']['informatii']['retur']['id_zbor'])) unset($_SESSION['rezervare']['informatii']['retur']['id_zbor']);
			    if(isset($_POST['retur'])) $_SESSION['rezervare']['informatii']['retur']['id_zbor'][] = $_POST['retur'];
			//cand apelezi, vei apela $_SESSION['rezervare']['informatii']['tur']['id_zbor'][0] pt id-ul zborului, daca sunt mai multe.. $_SESSION['rezervare']['informatii']['tur']['id_zbor'][1,2...] 
				header("Location: rezervare.php?flight=selected");
				//header("Location: rezervare.php?id_rezervare=".$id_rezervare."&do=info_zbor&id_zbor=".$_SESSION['rezervare']['informatii']['tur']['id_zbor'][1]);
			}
	}
	
	
	if(isset($_POST['info_zbor'])){
	
				
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';
		//SE STERGE DOAR CAND MERGE BINE!
		

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
				
				
			
			
		echo '<pre>';
		print_r($_SESSION['rezervare']);
		echo '</pre>';
			
			foreach($_SESSION['rezervare']['informatii']['tur']['id_zbor'] as $zborID) {

				if(empty($_POST['clasa'][$zborID][$nr])) $err['clasa'][$zborID][$nr] = $lang['EROARE_CLASA_EMPTY'];  
				else $_SESSION['rezervare']['setari']['id_zbor'][$zborID]['persoane'][$nr]['clasa'] = $_POST['clasa'][$zborID][$nr];
			}
		}
	}
	/*
		
		
		if(empty($_POST['clasa'])) $err['clasa'] = $lang['EROARE_CLASA_EMPTY']; 
 		else $clasa = $_POST['clasa'];
		
		if(empty($_POST['meniu'])) $err['meniu'] = $lang['EROARE_MENIU_EMPTY']; 
 		else $meniu = $_POST['meniu'];
		
		if(empty($_POST['bagaj'])) $err['bagaj'] = $lang['EROARE_BAGAJ_EMPTY']; 
 		else $bagaj = $_POST['bagaj'];
		
		if(empty($_POST['bagaj'])) $err['bagaj'] = $lang['EROARE_BAGAJ_EMPTY']; 
 		else $bagaj = $_POST['bagaj'];
		
		if(empty($_POST['categorie'])) $err['categorie'] = $lang['EROARE_CATEGORIE_EMPTY']; 
 		else $categorie = $_POST['categorie'];
	}
	
	if(isset($_POST['contact_info'])){
	
		if(empty($_POST['titulatura'])) $err['titulatura'] = $lang['EROARE_TITULATURA'];
 		else $titulatura= $_POST['titulatura'];
 			
 		if(empty($_POST['name'])) $err['name'] = $lang['EROARE_NUME_EMPTY']; 
 		else if(!empty($_POST['name']) && !preg_match("/^[a-z ]/i",$_POST['name'])) $err['name'] = $lang['EROARE_WRONG_NAME'];
 		else $name = $_POST['name'];
 			
 		if(empty($_POST['prenume'])) $err['prenume'] = $lang['EROARE_PRENUME_EMPTY'];
 		else if(!empty($_POST['prenume']) && !preg_match("/^[a-z ]/i",$_POST['prenume'])) $err['prenume'] = $lang['EROARE_WRONG_PRENUME'];
 		else $prenume = $_POST['prenume'];
 		
 		if(empty($_POST['adresa'])) $err['adresa'] = $lang['EROARE_ADRESA_EMPTY'];
 		else if(!empty($_POST['adresa']) && !preg_match("/^[a-z .,0-9]/i",$_POST['adresa'])) $err['adresa'] = $lang['EROARE_WRONG_ADRESA'];
 		else $adresa = $_POST['adresa'];
 			
 		if(empty($_POST['oras'])) $err['oras'] = $lang['EROARE_ORAS_EMPTY'];
 		else if(!empty($_POST['oras']) && !preg_match("/^[a-z ]/i",$_POST['oras'])) $err['oras'] = $lang['EROARE_WRONG_ORAS'];
 		else $oras = $_POST['oras'];
 			
 		if(empty($_POST['tara'])) $err['tara'] = $lang['EROARE_TARA_EMPTY'];
 		else $tara= $_POST['tara'];
 		
 		if(empty($_POST['codPostal'])) $err['codPostal'] = $lang['EROARE_CODPOSTAL_EMPTY'];
 		else if(!empty($_POST['codPostal']) && !preg_match("/^[0-9]/i",$_POST['codPostal']) or strlen($_POST['codPostal'])!=6) $err['codPostal'] = $lang['EROARE_WRONG_CODPOSTAL'];
 		else $codPostal = $_POST['codPostal'];
 			
 		if(empty($_POST['email'])) $err['email'] = $lang['EROARE_EMAIL_EMPTY'];
 		elseif (!empty($_POST['email']) && !preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $_POST['email'])) $err['email'] = $lang['EROARE_WRONG_EMAIL'];
 		elseif(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `email`='".mysql_real_escape_string($_POST['email'])."' LIMIT 1"))!=0) $err['email'] = $lang['EROARE_EXISTING_EMAIL'];
 		else $email = $_POST['email'];
 			
 		if(empty($_POST['telefon'])) $err['telefon'] = $lang['EROARE_TELEFON_EMPTY'];
 		elseif(strlen($_POST['telefon'])!=10 or !is_numeric($_POST['telefon'])) $err['telefon'] = $lang['EROARE_WRONG_TELEFON'];
		else $telefon = $_POST['telefon'];
	}
	*/
}//end isset formular rezervare

?>

 

<?php include_once 'head.php'; ?>
<?php include('header.php'); ?> 

	<div class="main_content">
		<div class="wrap">
			<section>
				<div id="rezervare_menu">
					<ul id="rezervare_menu_ul">
						<li><a href="#"><?php echo $lang['SELECT_THE_FLIGHT'];?></a></li>
						<li><a href="#"><?php echo $lang['PASAGERI'];?></a></li>
						<li><a href="#"><?php echo $lang['INFO_CONTACT'];?></a></li>
						<li><a href="#"><?php echo $lang['REZUMAT'];?></a></li>
					</ul>
				</div>
				<?php if(!isset($flight)) { ?>
				<div id="select_flight">
					<form action="" method="post" name="select_zbor" id="select_zbor" action="">
					<!-- De exemplu la clase, in loc 5 o sa fie nr de zboruri si in loc de 2 o sa fie nr de tipuri de bagaje de ex, sau nr persoanei -->
					<!-- ca o sa ai .. zborid =2 , pers 1, pers 2 dar, deci o sa trebuiasca si pt persoane, cred ca zbor->persoana->clasa->tip_bagaj->bagaj
																																		 ->meniu ..	-->
					
					
					<?php if(isset($err['tur'])) echo '<span class="eroare">'.$err['tur'].'</span>'; ?>
					<?php 
					
				    $sC = mysql_query("SELECT SUM(`zc`.`nr_locuri`) AS `locuri_disponibile`,`zb`.`id_zbor`, `zb`.`cod_zbor` , `av`.`serie`, `ta`.`tip`, `fb`.`fabricant`,
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
									HAVING SUM(`zc`.`nr_locuri`) >= ((SELECT COUNT(*) FROM `rezervare_persoana_zbor` AS `rpz` WHERE `rpz`.`id_zbor` = `zb`.`id_zbor`) + '".$nr_persoane."')");
					$s = mysql_query("SELECT * FROM `zboruri` AS `zb` INNER JOIN `rute` AS `rt` ON `zb`.`id_ruta` = `rt`.`id_ruta` 
									INNER JOIN `aeroporturi` AS `aeroP` ON `aeroP`.`id_aeroport` = `rt`.`id_aeroport_plecare`
									INNER JOIN `aeroporturi` AS `aeroS` ON `aeroS`.`id_aeroport` = `rt`.`id_aeroport_sosire`
									WHERE `zb`.`status` = '`' AND `rt`.`id_aeroport_plecare` = '".$_SESSION['rezervare']['informatii']['aeroport_plecare']."' AND `rt`.`id_aeroport_sosire` = '".$_SESSION['rezervare']['informatii']['aeroport_sosire']."'
									");
					echo "SELECT * FROM `zboruri` AS `zb` INNER JOIN `rute` AS `rt` ON `zb`.`id_ruta` = `rt`.`id_ruta` 
									INNER JOIN `aeroporturi` AS `aeroP` ON `aeroP`.`id_aeroport` = `rt`.`id_aeroport_plecare`
									INNER JOIN `aeroporturi` AS `aeroS` ON `aeroS`.`id_aeroport` = `rt`.`id_aeroport_sosire`
									WHERE `zb`.`status` = '`' AND `rt`.`id_aeroport_plecare` = '".$_SESSION['rezervare']['informatii']['aeroport_plecare']."' AND `rt`.`id_aeroport_sosire` = '".$_SESSION['rezervare']['informatii']['aeroport_sosire']."'
									AND `zb`.`data_plecare` >= '".$data_plecareF."' AND `zb`.`data_plecare` <= '".$data_plecareF_over."'";
					
					echo mysql_num_rows($s);
					
					while($r = mysql_fetch_array($s)){
							$rP = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc` INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa`
											    INNER JOIN `clase` AS `cl` ON  `cl`.`id_clasa` = `cc`.`id_clasa` GROUP BY `zc`.`id_clasa` ");
							echo '<input type="radio" name="tur" value="'.$r['id_zbor'].'">'.$r['aeroport_plecare'].', '.$r['oras_aeroport_plecare'].', '.$r['tara_aeroport_plecare'].' - '.$r['aeroport_sosire'].', '.$r['oras_aeroport_sosire'].', '.$r['tara_aeroport_sosire'].'<br>';
					}
					
					$sE1 = mysql_query("SELECT `rt`.`id_ruta` AS `ruta1`, `rt1`.`id_ruta`  AS `ruta2` FROM `rute` AS `rt` INNER JOIN `rute` AS `rt1` ON `rt`.`id_aeroport_sosire` = `rt1`.`id_aeroport_plecare`
										WHERE `rt`.`id_aeroport_plecare` = '".$_SESSION['rezervare']['informatii']['aeroport_plecare']."' AND `rt1`.`id_aeroport_sosire` = '".$_SESSION['rezervare']['informatii']['aeroport_sosire']."'");
					
			
					while($rE1 = mysql_fetch_array($sE1)){
					
							$sEZ1 = mysql_query("SELECT * FROM `zboruri` WHERE `id_ruta`='".$rE1['ruta1']."' AND `data_plecare` >= '".$data_plecareF."' AND `data_plecare` <= '".$data_plecareF_over."' AND `status`= '1'");
							$sEZ2 = mysql_query("SELECT * FROM `zboruri` WHERE `id_ruta`='".$rE1['ruta2']."' AND `data_plecare` >= '".$data_plecareF."' AND `data_plecare` <= '".$data_plecareF_over."' AND `status`= '1'");
							$sEZ3 = mysql_query("SELECT * FROM `zboruri` WHERE `id_ruta`='".$rE1['ruta3']."' AND `data_plecare` >= '".$data_plecareF."' AND `data_plecare` <= '".$data_plecareF_over."' AND `status`= '1'");
							
							$nrZ1 = mysql_num_rows($sEZ1);
							$nrZ2 = mysql_num_rows($sEZ2);
							$nrZ3 = mysql_num_rows($sEZ3);
							
							echo $nrZ1;
							echo $nrZ2;
							echo $nrZ3;
							
					}
					
					?>
					
					<?php if(isset($err['retur'])) echo '<span class="eroare">'.$err['retur'].'</span>'; ?>
					<?php
					echo $_SESSION['rezervare']['informatii']['data_sosire'];
					if(isset($_SESSION['rezervare']['informatii']['data_sosire']) AND !empty($_SESSION['rezervare']['informatii']['data_sosire'])) {
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
									WHERE `zb`.`status` = '1' AND `rt`.`id_aeroport_plecare` = '".$aeroport_sosire."' AND `rt`.`id_aeroport_sosire` = '".$aeroport_plecare."' 
									AND `zb`.`data_plecare` >= '".$data_sosireF."' AND `zb`.`data_plecare` <= '".$data_sosireF_over."'
									GROUP BY `zb`.`id_zbor`
									HAVING SUM(`zc`.`nr_locuri`) >= ((SELECT COUNT(*) FROM `rezervare_persoana_zbor` AS `rpz` WHERE `rpz`.`id_zbor` = `zb`.`id_zbor`) + '".$nr_persoane."')");
						
						while($r = mysql_fetch_array($s)){
								$rP = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc` INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa`
													INNER JOIN `clase` AS `cl` ON  `cl`.`id_clasa` = `cc`.`id_clasa` GROUP BY `zc`.`id_clasa` ");
								echo '<input type="radio" name="retur" value="'.$r['id_zbor'].'">'.$r['aeroport_plecare'].', '.$r['oras_aeroport_plecare'].', '.$r['tara_aeroport_plecare'].' - '.$r['aeroport_sosire'].', '.$r['oras_aeroport_sosire'].', '.$r['tara_aeroport_sosire'].'<br>';
						}
						
						if(mysql_num_rows($s) == 0) {
							echo 'Ne pare rau, dar nu a fost gasit zbor de intoarcere in data specificata';
						}
					} 
					
					//Aici, folosind datele din tabelul de sus, afiseaza cu <a href="#">....</a> toate posibilitatile. pt moment, doar zborurile directe, eventual cea mai scurta ruta.
					//datele le trimitem cu $_GET sau cu $_POST? cum vrei? cum o fi.. nu stiu cum e mai bine.. stai sa ma gandesc, ce implica.. ok. cu $_POST
					//spor la treaba.. foloseste $_SESSION['rezervare']['informatii']['....'] pentru interogari dar cum fac la aia cu selectarea zborului
					//adica incerc sa gasesc zborurile care au ruta aia si le afisez aici intr-un tabel? si cum pot sa iau data de acolo... adica ce obtin acolo
					// toate zborurile alea. si cum le pun in array? 

					//da, sa fie pregatit pt mai multe zboruri, cel mai scurt drum, bla. chiar daca nu merge acum, facem din start tot ca si cand ar merge alg ala
					// algoritmul ala, baga doar cel mai scurt, ca mergea. in caz ca nu gasesti mai bun, sa le ia pe toate, ala e suficient ca sa ai facute escalele 			
					?>
					<div>
						<input type="submit" id="y"  name="select_zbor" value="Continua" />
					</div>
					</form>
				</div>
				<?php } //nu e $flight ?>
				<?php if(isset($flight)) { ?>
				<div id="pasageri">
					<?php //da cred ca e ok aici si am gresit sus, ca astea raman la fel pt fiecare zbor, de la clasa incolo e cu zborul?>
					<form action="" method="post" name="info_zbor" id="info_zbor" action="">
					<?php for($i=1;$i<=$nr_persoane;$i++) {?>
					
					
						<h3><?php echo $lang['PASAGERI_HEADER'];?></h3>
						<div id="pasageri-in">
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
							
						<?php 
							foreach($_SESSION['rezervare']['informatii']['tur']['id_zbor'] as $id_zbor) {
							echo $i;
						?>
							<div>
								<?php if(isset($err['clasa'][$id_zbor][$i])) echo '<span class="eroare">'.$err['clasa'][$id_zbor][$i].'</span>'; ?>
								<label><?php echo $lang['CLASA']; ?></label>					
								<select id="clasa" name="clasa[<?php echo $i;?>]" placeholder="<?php echo $lang['CLASA']; ?>"  autocomplete="off">
									<option></option>
									<?php
									
										$s = mysql_query("SELECT DISTINCT `cl`.`clasa`, `zc`.`pret_clasa`,`zc`.`nr_locuri`, `zc`.`id_zbor_clasa`, `zc`.`id_clasa`
														FROM `zbor_clasa` AS `zc` INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa`=`zc`.`id_clasa` 
														INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa` = `cc`.`id_clasa`
														WHERE `zc`.`id_zbor`= '".$id_zbor."'");
										
										while($rand = mysql_fetch_array($s)) {
										echo $rand;
									?>
									<option value="<?php echo $rand['id_zbor_clasa'];?>"  <?php if(isset($_POST['clasa'][$i]) and $_POST['clasa'][$i]==$rand['id_zbor_clasa']) echo 'selected'; ?> ><?php echo $rand['clasa'];?></option>
									<?php
									}
									?>	
								</select>						
							</div>
							
							<?php } ?>
						<?php 
						if(isset($_SESSION['rezervare']['informatii']['retur']['id_zbor']))
							foreach($_SESSION['rezervare']['informatii']['retur']['id_zbor'] as $id_zbor) {
							echo $i;
						?>
							<div>
								<?php if(isset($err['clasa'][$id_zbor][$i])) echo '<span class="eroare">'.$err['clasa'][$id_zbor][$i].'</span>'; ?>
								<label><?php echo $lang['CLASA']; ?></label>					
								<select id="clasa" name="clasa[<?php echo $i;?>]" placeholder="<?php echo $lang['CLASA']; ?>"  autocomplete="off">
									<option></option>
									<?php
									
										$s = mysql_query("SELECT DISTINCT `cl`.`clasa`, `zc`.`pret_clasa`,`zc`.`nr_locuri`, `zc`.`id_zbor_clasa`, `zc`.`id_clasa`
														FROM `zbor_clasa` AS `zc` INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa`=`zc`.`id_clasa` 
														INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa` = `cc`.`id_clasa`
														WHERE `zc`.`id_zbor`= '".$id_zbor."'");
										
										while($rand = mysql_fetch_array($s)) {
										echo $rand;
									?>
									<option value="<?php echo $rand['id_zbor_clasa'];?>"  <?php if(isset($_POST['clasa'][$i]) and $_POST['clasa'][$i]==$rand['id_zbor_clasa']) echo 'selected'; ?> ><?php echo $rand['clasa'];?></option>
									<?php
									}
									?>	
								</select>						
							</div>
							
							<?php } ?>								
						</div>
					
					<?php } ?>
					<div>
							<input type="submit" name="info_zbor" id="info_zbor" value="" />
					</div>
					</form>
				</div>
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
								<input type="submit" id="x" name="contact_info" value="<?php echo $lang['INREGISTRARE']; ?>" />
							</div>

							
						</table>
					</form>
				</div>
				<div id="rezumat_rezervare">
				</div>
				<?php } //end flight ?>
			</section>
			<aside>
				
			</aside>
		</div>
	</div>

<?php include('footer.php'); ?> 