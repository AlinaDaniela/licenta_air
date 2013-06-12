<?php require_once("config.php");?>
 <?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user'])) header("Location: cont.php");

if(!isset($_SESSION['rezervare']) 
	or (!isset($_POST['aeroport_plecare']) or empty($_POST['aeroport_plecare'])
	    or !isset($_POST['aeroport_sosire'])  or empty($_POST['aeroport_sosire'])
		or !isset($_POST['data_plecare'])  or empty($_POST['data_plecare'])
		or !isset($_POST['nr_persoane']) or empty($_POST['nr_persoane'])
		)
	) //daca s-a inceput o rezervare si se revine la zbor, e ok; daca s-a actionat formular de rezervare, e ok.
	$err = "Folositi formularul de mai sus pentru a cauta o ruta";
else {
	if(isset($_POST['aeroport_plecare'])) $_SESSION['rezervare']['informatii']['aeroport_plecare'] = $_POST['aeroport_plecare'];
	if(isset($_POST['aeroport_sosire'])) $_SESSION['rezervare']['informatii']['aeroport_sosire'] =  $_POST['aeroport_sosire'];
	if(isset($_POST['data_plecare'])) $_SESSION['rezervare']['informatii']['data_plecare']  = $_POST['data_plecare'];
	if(isset($_POST['data_sosire'])) $_SESSION['rezervare']['informatii']['data_sosire']  = $_POST['data_sosire'];
	if(isset($_POST['nr_persoane'])) $_SESSION['rezervare']['informatii']['nr_persoane']  = $_POST['nr_persoane'];
	
	
	$aeroport_plecare = $_SESSION['rezervare']['informatii']['aeroport_plecare'];
	
	$aeroport_sosire = $_SESSION['rezervare']['informatii']['aeroport_sosire'];
	
	$data_plecare_separat = explode("/",$_SESSION['rezervare']['informatii']['data_plecare']);
	$data_sosire_separat = explode("/",$_SESSION['rezervare']['informatii']['data_sosire']);
	
	$nr_persoane = explode("/",$_SESSION['rezervare']['informatii']['nr_persoane']);
	
	$data_plecareF = mktime(0,0,0,$data_plecare_separat[0],$data_plecare_separat[1],$data_plecare_separat[2]);  //aici incepe ziua
	$data_plecareF_over = mktime(23,59,59,$data_plecare_separat[0],$data_plecare_separat[1],$data_plecare_separat[2]);  //aici se termina
	$data_sosireF = mktime(0,0,0,$data_sosire_separat[0],$data_sosire_separat[1],$data_sosire_separat[2]); 
	$data_sosireF_over = mktime(23,59,59,$data_sosire_separat[0],$data_sosire_separat[1],$data_sosire_separat[2]); 
	//query-ul trebuie facut ca intrarea din baza de date sa fie itnre inceputul si sfarsitul zilei de ce? acum got it ? Nu ma prind :| 
	//data din baza ta de date este sub forma 111111155555 - ce inseamna sa zicem 2.iulie.2013 14:21:23
	// ca sa gasesti acea data, doar dandu-i ziua, trebuie sa cauti intre secunda 0 a zilei si ultima, adica 2. iulie.2013 23:59:59
	//got it ? da
	// deci, in seara asta, baga mai multe date de genul asta in baza de date
	//cu ore diferite, in aceeasi zi ok
	// WHERE `data_plecare`=>'".$data_plecareF."' AND `data_plecare`<='".$data_plecareF_over."'
	
	//scrie aici, ca sa ramana
	if(isset($_GET['flight'])) {
		$flight = $_GET['flight']; //aici o sa fie un array cu info despre ruta alea.. practic, id-uri de zboruri ok ceva nu e bine. stai
		
	}
	


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
				
				<div id="select_flight">
					<table>
						<tr class="table_head"><td><?php echo $lang['COD_ZBOR'];?></td><td><?php echo $lang['RUTA'];?></td><td><?php echo $lang['PRET_DE_PLECARE'];?></td></td>
					<?php 
					
					$s = mysql_query("SELECT SUM(`zc`.`nr_locuri`) AS `locuri_disponibile`,`zb`.`id_zbor`, `zb`.`cod_zbor` , `av`.`serie`, `ta`.`tip`, `fb`.`fabricant`, 
								    `c_a`.`denumire`, `c_a`.`cod`, `c_a`.`descriere`, `aeroP`.`denumire` AS `aeroport_plecare`, `aeroP`.`oras` AS `oras_aeroport_plecare`
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
									WHERE `zb`.`status` = '1' AND `rt`.`id_aeroport_plecare` = '".$aeroport_plecare."' AND `rt`.`id_aeroport_sosire` = '".$aeroport_sosire."' 
									AND `zb`.`data_plecare` => '".$data_plecareF."' AND `zb`.`data_plecare` <= '".$data_plecareF_over."'
									GROUP BY `zb`.`id_zbor`
									HAVING SUM(`zc`.`nr_locuri`) >= ((SELECT COUNT(*) FROM `rezervare_persoana_zbor` AS `rpz` WHERE `rpz`.`id_zbor` = `zb`.`id_zbor`) + '".$nr_persoane."'");
					
						
					while($r = mysql_fetch_array($s)){
							$rP = mysql_query("SELECT MIN(`zc`.`pret_clasa`) AS `pret_plecare` FROM `zbor_clasa` AS `zc` INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa`
											    INNER JOIN `clase` AS `cl` ON  `cl`.`id_clasa` = `cc`.`id_clasa` GROUP BY `zc`.`id_clasa` ");
							echo '<tr>';
							echo '<td>'.$r['cod'].$r['cod_zbor'].'</td>';
							echo '<td>'.$r['aeroport_plecare'].", ".$r['oras_aeroport_plecare'].", ".$r['tara_aeroport_plecare']." - ".$r['aeroport_sosire'].", ".$r['oras_aeroport_sosire'].", ".$r['tara_aeroport_sosire'].'</td>';
							echo '<td>'.$r['pret_plecare'].'</td>';
							echo '</tr>';
					}
					
					
					//Aici, folosind datele din tabelul de sus, afiseaza cu <a href="#">....</a> toate posibilitatile. pt moment, doar zborurile directe, eventual cea mai scurta ruta.
					//datele le trimitem cu $_GET sau cu $_POST? cum vrei? cum o fi.. nu stiu cum e mai bine.. stai sa ma gandesc, ce implica.. ok. cu $_POST
					//spor la treaba.. foloseste $_SESSION['rezervare']['informatii']['....'] pentru interogari dar cum fac la aia cu selectarea zborului
					//adica incerc sa gasesc zborurile care au ruta aia si le afisez aici intr-un tabel? si cum pot sa iau data de acolo... adica ce obtin acolo
					// toate zborurile alea. si cum le pun in array? 
					
					//dupa ce faci query-ul, care reprezinta, toate rutele din ziua aia, le afisezi asa:
					//<a href="rezervare.php?flight=[id_zbor1],[id_zbor2],[id_zbor3]"> Numele legaturii/rutei/zborului, cum vrei sa apara</a> si tot asa preiau si celelalte date, 
					//ah, stai, ca doar de id am nevoie
					//da, sa fie pregatit pt mai multe zboruri, cel mai scurt drum, bla. chiar daca nu merge acum, facem din start tot ca si cand ar merge alg ala
					// sper sa mearga :( scrie eh, nimic :( da ma simt asa varza acum si inaintez ca melcul
					// ti-am zis ca nu e gata miercuri
					// algoritmul ala, baga doar cel mai scurt, ca mergea. in caz ca nu gasesti mai bun, sa le ia pe toate, ala e suficient ca sa ai facute escalele 
					//dap, ai dreptate. Da oare pana duminica reusesc sa termin? 
					// da, vineri o sa fie gata in mare
					// sambata si duminica stai si-l aranjezi si testezi si repari
					//a , si iti fac engleza. ti-ar ideea grozava cu 2 limbi :| mda.. acum am si tradus o groaza, am stat aseara si pff cat mi-a luat
					//sa nu ma asculti tu pe mine :| nu ii intereseaza 10 limbi m-am gandit ca e mai dragut..
					// asta e, hai, fa interogari
					//ok, sper sa functioneze macar o particica din ce fac eu, dar iti zic sigur ca te voi mai stresa :( sorry
					// tu fa query-u ala lung, sa gaseasca in functie de data si aeroporturi, si locuri ok
					
					?>
					</table>
				</div>
				<?php if(isset($flight)) { ?>
				<div id="pasageri">
					<h3><?php echo $lang['PASAGERI_HEADER'];?></h3>
					<div id="pasageri-in">
						<div>
 							<?php if(isset($err['titulatura'])) echo '<span class="eroare">'.$err['titulatura'].'</span>'; ?>
 							<label><?php echo $lang['TITULATURA']; ?></label>

 							<select id="tara" name="titulatura" placeholder="<?php echo $lang['TITULATURA']; ?>"  autocomplete="off">
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
 							<?php if(isset($err['clasa'])) echo '<span class="eroare">'.$err['clasa'].'</span>'; ?>
 							<label><?php echo $lang['CLASA']; ?></label>
							
							
 							<select id="clasa" name="clasa" placeholder="<?php echo $lang['CLASA']; ?>"  autocomplete="off">
 								<option></option>
 								<?php
									$s = mysql_query("SELECT `cl`.`clasa`, `zc`.`pret_clasa`,`zc`.`nr_locuri`, `zc`.`id_zbor_clasa`, `zc`.`id_clasa`
													  FROM `zbor_clasa` AS `zc` INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa`=`zc`.`id_clasa` 
													  INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa` = `cc`.`id_clasa`
													  WHERE `zc`.`id_zbor='".$id_zbor."'`");
									
 									while($rand = mysql_fetch_array($s)) {
 								?>
 								<option value="<?php echo $rand['id_zbor_clasa'];?>"><?php echo $rand['clasa'];?></option>
 								<?php
 								}
 								?>	
 							</select>						
						</div>
						<div>
 							<?php if(isset($err['meniu'])) echo '<span class="eroare">'.$err['meniu'].'</span>'; ?>
 							<label><?php echo $lang['MENIU']; ?></label>

 							<select id="meniu" name="meniu" placeholder="<?php echo $lang['MENIU']; ?>"  autocomplete="off">
 								<option></option>
 								<?php 
 									$sql = mysql_query("SELECT `tm`.`denumire`, `zmc`.`id_zbor_meniu_clasa`, `cl`.`clasa` 
														FROM `zbor_meniu_clasa` AS `zmc` INNER JOIN `zbor_clasa` AS `zc` ON `zmc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa`
														INNER JOIN `meniu_companie` AS `mc` ON `mc`.`id_meniu` = `zmc`.`id_meniu`
														INNER JOIN `tipuri_meniu` AS `tm` ON `tm`.`id_meniu` = `mc`.`id_meniu`
														INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa`
														INNER JOIN `clase` AS `cl`.`id_clasa`=`cc`.`id_clasa`
														WHERE `zmc`.`id_zbor_clasa` = '".$id_zbor_clasa."'");
 									while($rand = mysql_fetch_array($s)) {
 								?>
 								<option value="<?php echo $rand['id_zbor_meniu_clasa'];?>"><?php echo $rand['denumire'];?></option>
 								<?php
 								}
 								?>	
 							</select>						
						</div>
						<div>
 							<?php if(isset($err['bagaj'])) echo '<span class="eroare">'.$err['bagaj'].'</span>'; ?>
 							<label><?php echo $lang['BAGAJ']; ?></label>

 							<select id="bagaj" name="bagaj" placeholder="<?php echo $lang['BAGAJ']; ?>"  autocomplete="off">
 								<option></option>
 								<?php 
 	
 									$sql = mysql_query("SELECT `tb`.`tip_bagaj`, `zbc`.`id_zbor_bagaje_clasa`, `cl`.`clasa`, `zbc`.`pret`, `zbc`.`descriere` 
														FROM `zbor_bagaje_clasa` AS `zbc` INNER JOIN `zbor_clasa` AS `zc` ON `zbc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa`
														INNER JOIN `bagaje_companie` AS `bc` ON `bc`.`id_tip_bagaj` = `zbc`.`id_bagaj`
														INNER JOIN `tipuri_bagaj` AS `tb` ON `tb`.`id_bagaj` = `bc`.`id_tip_bagaj`
														INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa`
														INNER JOIN `clase` AS `cl`.`id_clasa`=`cc`.`id_clasa`
														WHERE `zbc`.`id_zbor_clasa` = '".$id_zbor_clasa."'");
 									while($rand = mysql_fetch_array($sql)) {
 								?>
 								<option value="<?php echo $rand['id_zbor_bagaje_clasa'];?>"><?php echo $rand['tip_bagaj']." - ".$rand['pret'];?></option>
 								<?php
 								}
 								?>	
 							</select>						
						</div>
						<div>
						<fieldset>
							   <legend>Selecteaza categoria de varsta</legend>
							   <p>
								   <?php 
		
										$sql = mysql_query("SELECT `cv`.`categorie`, `zrc`.`id_zbor_reducere_clasa`, `cl`.`clasa`, `zrc`.`reducere` 
															FROM `zbor_reduceri_clasa` AS `zrc` INNER JOIN `zbor_clasa` AS `zc` ON `zrc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa`
															INNER JOIN `companie_reduceri_categorii` AS `crc` ON `crc`.`id_categorie_varsta` = `zrc`.`id_categorie_varsta`
															INNER JOIN `categorii_varsta` AS `cv` ON `cv`.`id_categorie_varsta` = `crc`.`id_categorie_varsta`
															INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa`
															INNER JOIN `clase` AS `cl`.`id_clasa`=`cc`.`id_clasa`
															WHERE `zrc`.`id_zbor_clasa` = '".$id_zbor_clasa."'");
										while($rand = mysql_fetch_array($sql)) {
									?>
								    <label><?php echo $rand['categorie'];?></label>            
								    <input type = "radio" name="radSize" checked = "" />
									<?php
									}
									?>	
								</p>       
							  </fieldset>     
						</div>
					</div>
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
								<input type="submit" id="x" onClick="chkform()" name="register" value="<?php echo $lang['INREGISTRARE']; ?>" />
							</div>

							
						</table>
					</form>
				</div>
				<?php } //end flight ?>
			</section>
			<aside>
				
			</aside>
		</div>
	</div>

<?php include('footer.php'); ?> 