<?php require_once('config.php');?>
 <?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user']) or ($_SESSION['tip_user']!="admin" and $_SESSION['tip_user']!="agent")) header("Location: cont.php");
?>
<?php
	if(isset($_POST['cautare_factura1'])) {
		if(empty($_POST['nr_factura_f'])) $err['nr_factura_f'] = 'Va rugam sa introduceti numarul facturii';
		else {
			$sql = mysql_query("SELECT * FROM `facturi` WHERE `nr_factura`='".cinp($_POST['nr_factura_f'])."'LIMIT 1");
			if(mysql_num_rows($sql)==0)
				$err['nr_factura_f'] = 'Nu exista o factura cu acest numar in baza de date';
			else{
				$r = mysql_fetch_assoc($sql);
				$nr_factura = cinp($_POST['nr_factura_f']);
				$id_factura = cinp($r['id_factura']); //schimba cu rezultatul sql-ul-ului
				header("Location: modificare_factura.php?id_factura=".$id_factura);
			}
		}
	}
	if(isset($_POST['cautare_factura2'])) {
		if(empty($_POST['nr_rezervare_f'])) $err['nr_rezervare_f'] = 'Va rugam sa introduceti numarul rezervarii';
		else {
			$sql = mysql_query("SELECT `fct`.`id_factura` FROM `facturi` AS `fct` INNER JOIN `rezervari` AS `rz` ON `fct`.`id_rezervare`=`rz`.`id_rezervare`
								WHERE `rz`.`cod` = '".cinp($_POST['nr_rezervare_f'])."'");
			if(mysql_num_rows($sql)==0)
				$err['nr_rezervare_f'] = 'Nu exista o factura pentru acest cod al rezervarii in baza de date';
			else{
				$r = mysql_fetch_assoc($sql);
				$nr_rezervare = cinp($_POST['nr_rezervare_f']);
				$id_factura = cinp($r['id_factura']);
				header("Location: modificare_factura.php?id_factura=".$id_factura);
			}
		}
	}
	if(isset($_POST['toate_facturile'])) {
			header("Location: modificare_factura.php?do=toate_facturile");
	}
	
	if(isset($_GET['do']) and $_GET['do']=="toate_facturile" and isset($_GET['id_factura']) and isset($_GET['status'])) {
		mysql_query("UPDATE `facturi` SET `status`='".cinp($_GET['status'])."' WHERE `id_factura`='".cinp($_GET['id_factura'])."' LIMIT 1");
		header("Location: modificare_factura.php?do=toate_facturile&show=status_schimbat");
	}

	if(isset($_GET['id_factura'])) {
	
		$id_factura = $_GET['id_factura'];
		$s = mysql_query("SELECT * FROM `facturi` WHERE `id_factura`='".cinp($id_factura)."' LIMIT 1");
		$r = mysql_fetch_assoc($s);
		$titulatura = $r['id_titulatura'];
		$nume = $r['nume']; 
		$prenume = $r['prenume'];
		$adresa = $r['adresa'];
		$oras = $r['oras'];
		$tara = $r['tara'];
		$codPostal = $r['codPostal'];
		$telefon = $r['telefon'];
		$email = $r['email'];
		$pret_total = $r['pret_total'];
		$nr_factura = $r['nr_factura'];
		$id_rezervare = $r['id_rezervare'];
		$data_facturare = date("d/m/Y",$r['data_facturare']);
		$ora_facturare = date("G",$r['data_facturare']);
		$minut_facturare = date("i",$r['data_facturare']);
		$status = $r['status'];
			

	
	
	if(isset($_POST['edit_factura'])) {

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
 			else $email = $_POST['email'];
			
 			if(empty($_POST['telefon'])) $err['telefon'] = $lang['EROARE_TELEFON_EMPTY'];
 			elseif(strlen($_POST['telefon'])!=10 or !is_numeric($_POST['telefon'])) $err['telefon'] = $lang['EROARE_WRONG_TELEFON'];
 			else $telefon = $_POST['telefon'];
			
			if(empty($_POST['data_facturare']) or strlen($_POST['data_facturare'])!=10) $err['data_facturare'] = $lang['SELECTATI_DATA'];
			else if(!empty($_POST['data_facturare']) AND !preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$_POST['data_facturare'])) $err['data_facturare'] = $lang['SELECT_DATE_WRONG'];
			else $data_facturare = $_POST['data_facturare'];
			
			if(isset($_POST['status'])) $status = 1;
 			else $status = 0;
			
			if(isset($data_facturare)) $data_facturare_explode = explode("/",$data_facturare); 
			if(isset($data_facturare) ) { 
				$data_facturareM = mktime(0,0,0,$data_facturare_explode[1],$data_facturare_explode[0],$data_facturare_explode[2]); 
			}
			
			echo $data_facturare;
			echo $data_facturareM;
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
					echo ' here';
					echo $data_facturareM;
	 				$sql = "UPDATE `facturi` SET ";
					$sql .= "`data_facturare` = '".cinp($data_facturareM)."', ";
	 				$sql .= "`id_titulatura` = '".cinp($titulatura)."',";
					$sql .= "`nume` = '".cinp($nume)."',";
					$sql .= "`prenume` = '".cinp($prenume)."',";
					$sql .= "`adresa` = '".cinp($adresa)."',";
					$sql .= "`oras` = '".cinp($oras)."',";
					$sql .= "`tara` = '".cinp($tara)."',";
					$sql .= "`codPostal` = '".cinp($codPostal)."',";
					$sql .= "`telefon` = '".cinp($telefon)."',";
					$sql .= "`email` = '".cinp($email)."', ";
					$sql .= "`status` = '".cinp($status)."' ";
					$sql .= "WHERE `id_factura` = '".cinp($id_factura)."'";
	 				

	 				$query = mysql_query($sql);

					if($query) { 
						header("Location: modificare_factura.php?id_factura=".$id_factura."&show=succes");
						unset($titulatura,$nume,$prenume,$adresa,$oras,$tara,$codPostal,$telefon,$email,$pret_total,$nr_factura,$data_facturare,$id_rezervare,$status); 
					} 

 			}        
 		}    
		
	} 

?>
<?php include('head.php'); ?>
<?php include('header.php'); ?> 
		
	
	<div class="main_content">
		<div class="wrap">
			<section class="full">
				<?php if(!isset($_GET['id_factura'])) { ?>
				<?php if(isset($_GET['show']) and $_GET['show']=="status_schimbat") echo '<span class="succes">Statusul facturii a fost schimbat</span>'; ?>
				<div>
					<form name="nr_fact_form" action="" method="post">
						<label>Cauta factura dupa numarul facturii</label>
						<?php if(isset($err['nr_factura_f'])) echo '<span class="eroare">'.$err['nr_factura_f'].'</span>'; ?>
						<input type="text" name="nr_factura_f"/>
						<input type="submit" name="cautare_factura1" value="Cauta">
					</form>
					<form name="nr_rez_form" action="" method="post">
						<label>Cauta factura dupa numarul rezervarii</label>
						<?php if(isset($err['nr_rezervare_f'])) echo '<span class="eroare">'.$err['nr_rezervare_f'].'</span>'; ?>
						<input type="text" name="nr_rezervare_f"/>
						<input type="submit" name="cautare_factura2" value="Cauta">
					</form>
					<form name="toate_fact_form" action="" method="post">
						<input type="submit" name='toate_facturile' value="Vizualizeaza toate facturile">
					</form>
				</div>
				<?php if(isset($_GET['do']) and $_GET['do']=="toate_facturile") { ?>
					<div class="rezultate_existente facturi">
						<h3>Facturi existente</h3>
							<table>
								<tr class="table_head"><td>Numar</td><td>Nume</td><td>Prenume</td><td>Valoare</td><td>Data</td><td>Status</td><td><?php echo $lang['OPERATIUNI'];?></td></td>
								<?php 
												 
									$s = mysql_query("SELECT * FROM `facturi` ORDER BY `data_facturare` DESC");
									while($r_factura = mysql_fetch_array($s)) { 
										$data_factura = date("d/m/Y",$r_factura['data_facturare']);
										$ora_factura = date("G",$r_factura['data_facturare']);
										$minut_factura = date("i",$r_factura['data_facturare']);
										echo '<tr>';
											echo '<td>'.$r_factura['nr_factura'].'</td>
												 <td>'.$r_factura['nume'].'</td>
												 <td>'.$r_factura['prenume'].'</td>
												 <td>'.$r_factura['pret_total'].'</td>
												 <td>'.$data_factura.' '.$ora_factura.':'.$minut_factura.'</td>
												 <td><a href="modificare_factura.php?do=toate_facturile&amp;id_factura='.$r_factura['id_factura'].'&amp;status='.(($r_factura['status']==1) ? "0" : "1").'">'.(($r_factura['status']==1) ? "ACHITATA" : "NEACHITAT").'</a></td>
												<td><a href="modificare_factura.php?id_factura='.$r_factura['id_factura'].'">Editeaza factura</a><br/></td>';
										echo '</tr>';
									} 
									?>
							</table>
					</div>
				<?php } ?>
				<?php } else { ?>
				<form action="" method="post" name="edit_factura">
						<h3>Editare factura</h3>
 						<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.('Factura a fost editata').'</span>'; ?>
						<div>
							<?php if(isset($err['titulatura'])) echo '<span class="eroare">'.$err['titulatura'].'</span>'; ?>
								<label><?php echo $lang['TITULATURA']; ?></label>

								<select  name="titulatura"  autocomplete="off">
									<option></option>
									<?php 
										$sql = mysql_query("SELECT * FROM `titulaturi`");
										while($rand = mysql_fetch_array($sql)) {
										?>
									 	<option value="<?php echo $rand['id_titulatura'];?>"<?php if(isset($titulatura) and $titulatura==$rand['id_titulatura']) echo 'selected'; ?>><?php echo $rand['titulatura'];?></option>

										<?php
										}
										?>	
									</select>						
							</div>
							
							<div>
								<?php if(isset($err['name'])) echo '<span class="eroare">'.$err['name'].'</span>'; ?>
								<label><?php echo $lang['NUME']; ?></label>
								<input type="text" name="name" value="<?php if(isset($nume)) echo $nume;?>" autocomplete="off" required="required" />
							</div>


							<div>
								<?php if(isset($err['prenume'])) echo '<span class="eroare">'.$err['prenume'].'</span>'; ?>
								<label><?php echo $lang['PRENUME']; ?></label>
								<input type="text" id="prenume" name="prenume" value="<?php if(isset($prenume)) echo $prenume;?>"  autocomplete="off" required="required" />
							</div>

							<div>
								<?php if(isset($err['adresa'])) echo '<span class="eroare">'.$err['adresa'].'</span>'; ?>
								<label><?php echo $lang['ADRESA']; ?></label>
								<input type="text" name="adresa" value="<?php if(isset($adresa)) echo $adresa;?>" autocomplete="off" />
							</div>

							<div>
								<?php if(isset($err['oras'])) echo '<span class="eroare">'.$err['oras'].'</span>'; ?>
								<label><?php echo $lang['ORAS']; ?></label>
								<input type="text" name="oras"  value="<?php if(isset($oras)) echo $oras;?>" autocomplete="off" />
							</div>
							
							<div>
								<?php if(isset($err['tara'])) echo '<span class="eroare">'.$err['tara'].'</span>'; ?>
								<label><?php echo $lang['TARA']; ?></label>
								<select id="tara" name="tara"  autocomplete="off">
										<option></option>
										<?php 
										$sql = mysql_query("SELECT * FROM `tari`");
											while($rand = mysql_fetch_array($sql)) {
										?>
										<option value="<?php echo $rand['id_tara'];?>" <?php if(isset($tara) and $tara==$rand['id_tara']) echo 'selected'; ?>><?php echo $rand['tara'];?></option>
										<?php
										}
										?>	
									</select>
							</div>

							<div>
								<?php if(isset($err['codPostal'])) echo '<span class="eroare">'.$err['codPostal'].'</span>'; ?>
								<label><?php echo $lang['COD_POSTAL']; ?></label>
								<input type="text" name="codPostal" value="<?php if(isset($codPostal)) echo $codPostal;?>" autocomplete="off" />
							</div>

							<div>
								<?php if(isset($err['email'])) echo '<span class="eroare">'.$err['email'].'</span>'; ?>
								<label><?php echo $lang['EMAIL']; ?></label>
								<input type="email" name="email" value="<?php if(isset($email)) echo $email;?>" autocomplete="off" required="required" />
							</div>

							<div>
								<?php if(isset($err['telefon'])) echo '<span class="eroare">'.$err['telefon'].'</span>'; ?>
								<label><?php echo $lang['TELEFON']; ?></label>
								<input type="tel"  name="telefon" maxlength="10"  value="<?php if(isset($telefon)) echo $telefon;?>" autocomplete="off" required="required"/>
							</div>
							
							<div>
								<?php if(isset($err['data_facturare'])) echo '<span class="eroare">'.$err['data_facturare'].'</span>'; ?>
								<label>Data facturare</label><br />
								<input type="text"  name="data_facturare" value="<?php if(isset($data_facturare)) echo $data_facturare;?>" class="date-pick tiny"/>
							</div>
							<div>
								<label>Achitata</label>
								<input type="checkbox" name="status" value="1" <?php if(isset($status) and $status==0) echo ''; else echo 'checked'; ?> /></td>
							</div>
							<div>
								<input type="submit" name="edit_factura" value="<?php  echo $lang['EDITEAZA']; ?>" />
							</div>
							<div>
								<a href="modificare_factura.php" class="button_like_submit">Inapoi</a>
							</div>
				</form>
				<?php } ?>
			</section>
		</div>
	</div>
<?php include('footer.php'); ?> 