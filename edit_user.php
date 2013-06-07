<?php require_once("config.php");?>

<?php 

if(isset($_SESSION['id_utilizator'])) {  
    $s = mysql_query("SELECT * FROM `utilizatori` WHERE `id_utilizator`='".mysql_real_escape_string($_SESSION['id_utilizator'])."' LIMIT 1");
    $r = mysql_fetch_assoc($s);
	$nume_utilizator = $r['nume_utilizator'];
	$grup = $r['id_grup'];
	$titulatura = $r['id_titulatura'];
    $nume = $r['nume'];
    $prenume = $r['prenume'];
    $adresa = $r['adresa'];
	$oras = $r['oras'];
    $tara = $r['id_tara'];
    $email = $r['email'];
    $telefon = $r['telefon'];
    $status = $r['status'];
    $data_creare = $r['data_creare'];
    $parola = $r['parola'];
	
	if(isset($_POST['edit_user'])){
 			
 			if(empty($_POST['titulatura'])) $err['titulatura'] = "Selectati titulatura";
 			else $titulatura= $_POST['titulatura'];
 			
 			if(empty($_POST['name'])) $err['name'] = "Introduceti numele";
 			else if(!empty($_POST['name']) && !preg_match("/^[a-z ]/i",$_POST['name'])) $err['name'] = "Numele incorect!";
 			else $name = $_POST['name'];
 			
 			if(empty($_POST['prenume'])) $err['prenume'] = "Introduceti prenumele";
 			else if(!empty($_POST['prenume']) && !preg_match("/^[a-z ]/i",$_POST['prenume'])) $err['prenume'] = "Prenume incorect!";
 			else $prenume = $_POST['prenume'];
 		
 			if(empty($_POST['adresa'])) $err['adresa'] = "Introduceti adresa";
 			else if(!empty($_POST['adresa']) && !preg_match("/^[a-z .,0-9]/i",$_POST['adresa'])) $err['adresa'] = "Adresa incorecta!";
 			else $adresa = $_POST['adresa'];
 			
 			if(empty($_POST['oras'])) $err['oras'] = "Introduceti orasul";
 			else if(!empty($_POST['oras']) && !preg_match("/^[a-z ]/i",$_POST['oras'])) $err['oras'] = "Oras incorect!";
 			else $oras = $_POST['oras'];
 			
 			if(empty($_POST['tara'])) $err['tara'] = "Selectati tara";
 			else $tara= $_POST['tara'];
 			
 			if(empty($_POST['codPostal'])) $err['codPostal'] = "Introduceti codul postal";
 			else if(!empty($_POST['codPostal']) && !preg_match("/^[0-9]/i",$_POST['codPostal']) or strlen($_POST['codPostal'])!=6) $err['codPostal'] = "Cod postal incorect!";
 			else $codPostal = $_POST['codPostal'];
 			
 			if(empty($_POST['telefon'])) $err['telefon'] = "Introduceti telefon";
 			elseif(strlen($_POST['telefon'])!=10 or !is_numeric($_POST['telefon'])) $err['telefon'] = "Telefonul trebuie sa fiu un numar format din 10 cifre.";
 			else $telefon = $_POST['telefon'];
 					
 			if(empty($_POST['pwd'])) $err['pwd'] = "Introduceti parola";
 			else $pwd = $_POST['pwd'];
 			
 			if(empty($_POST['pwd_con'])) $err['pwd_con'] = "Completati parola de confirmare!";
 			else if($_POST['pwd']!=$_POST['pwd_con']) $err['pwd_con']="Parolele nu corespund!";
 			else $pwd = $_POST['pwd_con'];
 			
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
				
				$code = generate_password(25);
					
 				$status = 0;
				
 				$sql = "UPDATE `utilizatori` SET ";
 				$sql .= "`id_titulatura` = '".cinp($titulatura)."',";
 				$sql .= "`nume`='".cinp($name)."',";
 				$sql .= "`prenume`='".cinp($prenume)."',";
 				$sql .= "`adresa`='".cinp($adresa)."',";
 				$sql .= "`oras`='".cinp($oras)."',";
				$sql .= "`cod_postal`='".cinp($codPostal)."',";
 				$sql .= "`id_tara`='".cinp($tara)."',";
 				$sql .= "`telefon`='".cinp($telefon)."',"; 
 				$sql .= "`parola`='".sha1($salt . $pwd)."'";
 				 				
 				$query = mysql_query($sql);
 				     
 			}    
 		}
	}
?>
<?php include_once 'head.php'; ?>
<?php include('header.php'); ?> 


	<div class="main_content">
		<div class="wrap">
				<form action="" method="post" name="register_form" id="creare_cont" action="">
 					<table cellpadding="0" cellspacing="0" border="0" class="register_table">
 						<?php if(isset($succes)) echo '<span class="succes">'.$succes.'</span>'; ?>
 						<?php if(isset($err['titulatura'])) echo '<span class="eroare">'.$err['titulatura'].'</span>'; ?>
 						<tr>
 							<td class="form-input-name">Titulatura</td>
 							<td class="input">
 								<select id="tara" name="titulatura" placeholder="titulatura"  autocomplete="off">
 									<?php 
 										$sql = mysql_query("SELECT * FROM `titulaturi` INNER JOIN `utilizatori` ON `titulaturi`.`id_titulatura`=`utilizatori`.`id_titulatura`");
 										while($rand = mysql_fetch_array($sql)) {
 									?>
 									<option value="<?php echo $rand['id_titulatura'];?>"><?php echo $rand['titulatura'];?></option>
 									<?php
 									}
 									?>	
 								</select>						
							<br/>
 							</td>
 							<td class=""><span id="titulatura1"></span></td>
 						</tr>
 						<?php if(isset($err['name'])) echo '<span class="eroare">'.$err['name'].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['NUME']; ?></td>
 							<td class="input"><input type="text" id="name" onBlur="validateNume();" name="name" placeholder="<?php echo $lang['NUME_PLH'];?>"; value="<?php if(isset($nume)) echo $nume;?>" autocomplete="off" required="required" /></td>
 							<td class=""><span id="name1"></span></td>
 						</tr>
 						<?php if(isset($err['prenume'])) echo '<span class="eroare">'.$err['prenume'].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['PRENUME']; ?></td>
 							<td class="input"><input type="text" id="prenume" onBlur="validatePrenume();" name="prenume" placeholder="<?php echo $lang['PRENUME_PLH']; ?>" value="<?php if(isset($prenume)) echo $prenume;?>"  autocomplete="off" required="required" /></td>
 							<td class=""><span id="prenume1"></span></td>
 						</tr>
 						<?php if(isset($err['adresa'])) echo '<span class="eroare">'.$err['adresa'].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['ADRESA']; ?></td>
 							<td class="input"><input type="text" name="adresa" id="adresa" onBlur="validateAdresa()" placeholder="<?php echo $lang['ADRESA_PLH']; ?>" value="<?php if(isset($adresa)) echo $adresa;?>" autocomplete="off" /></td>
 							<td class=""><span id="adresa1"></span></td>
 						</tr>
 						<?php if(isset($err['oras'])) echo '<span class="eroare">'.$err['oras'].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['ORAS']; ?></td>
 							<td class="input"><input type="text" name="oras"  id="oras" onBlur="validateOras()" placeholder="<?php echo $lang['ORAS_PLH']; ?>" value="<?php if(isset($oras)) echo $oras;?>" autocomplete="off" /></td>
 							<td class=""><span id="oras1"></span></td>
 						</tr>
						<?php if(isset($err['tara'])) echo '<span class="eroare">'.$err['tara'].'</span>'; ?>
 						<tr>
							<td class="form-input-name"><?php echo $lang['TARA']; ?></td>
							<td class="input">
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
								</select>	<br/>
 							<td class=""><span id="tara1"></span></td>
 						</tr>
 						<?php if(isset($err['codPostal'])) echo '<span class="eroare">'.$err['codPostal'].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['COD_POSTAL']; ?></td>
 							<td class="input"><input type="text" name="codPostal" id="codPostal" onBlur="validateCodPostal()" placeholder="<?php echo $lang['COD_POSTAL_PLH']; ?>" value="<?php if(isset($codPostal)) echo $codPostal;?>" autocomplete="off" /></td>
 							<td class=""><span id="codPostal1"></span></td>
 						</tr>
 						<?php if(isset($err['telefon'])) echo '<span class="eroare">'.$err['telefon'].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['TELEFON']; ?></td>
 							<td class="input"><input type="tel" id="telefon" name="telefon" onKeyup="isNumeric()" maxlength="10" splaceholder="<?php echo $lang['TELEFON_PLH']; ?>" value="<?php if(isset($telefon)) echo $telefon;?>" autocomplete="off" required="required"/></td>
 							<td class=""><span id="telefon1"></span></td>
 						</tr>
 						<?php if(isset($err['pwd'])) echo '<span class="eroare">'.$err['pwd'].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['PAROLA']; ?></td>
 							<td class="input"><input type="password" id="pwd" name="pwd" onBlur="password()" placeholder="<?php echo $lang['PAROLA_PLH']; ?>" autocomplete="off" required="required" /></td>
 							<td class=""><span id="pwd1"></span></td>
 						</tr>
 						<?php if(isset($err['pwd_con'])) echo '<span class="eroare">'.$err['pwd_con'].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['RESCRIERE_PAROLA']; ?></td>
 							<td class="input"><input type="password" name="pwd_con" id="pwd_con" onBlur="pass()" placeholder="<?php echo $lang['RESCRIERE_PAROLA_PLH']; ?>" autocomplete="off" required="required" /></td>
 							<td class=""><span id="pwdcon1"></span></td>
 						</tr>
 						<tr>
 							<td class="form-input-name"></td>
 							<td><input type="submit" id="edit_user" name="edit_user" value="<?php echo $lang['INREGISTRARE']; ?>" /></td>
 						</tr>
 					</table>
			</section>
			<aside>
			</aside>
		</div>
	</div>
<?php include('footer.php'); ?> 