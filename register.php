<?php require_once("config.php");?>
 <?php  if(isset($_POST['register'])){
 			if(empty($_POST['user'])) $err['user'] = $lang['EROARE_USER_NAME'];
 			else if(!empty($_POST['user']) && !preg_match("/^[a-z0-9]/i",$_POST['user'])) $err['user'] = $lang['EROARE_WRONG_USER_NAME'];
 			else if(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `nume_utilizator` = '".mysql_real_escape_string($_POST['user'])."' LIMIT 1"))!=0) $err['user'] = $lang['EROARE_NOT_VALID_USER_NAME'];
 			else $user = $_POST['user'];
 			
 			if(empty($_POST['titulatura'])) $err['titulatura'] = $lang['EROARE_TITULATURA'];
 			else $titulatura= $_POST['titulatura'];
 			
 			if(empty($_POST['name'])) $err['name'] = $lang['EROARE_NUME_EMPTY']; 
 			else if(!empty($_POST['name']) && !preg_match("/^[a-z ]/i",$_POST['name'])) $err['name'] = $lang['EROARE_WORNG_NAME'];
 			else $name = $_POST['name'];
 			
 			if(empty($_POST['prenume'])) $err['prenume'] = $lang['EROARE_PRENUME_EMPTY'];
 			else if(!empty($_POST['prenume']) && !preg_match("/^[a-z ]/i",$_POST['prenume'])) $err['prenume'] = $lang['EROARE_WORNG_PRENUME'];
 			else $prenume = $_POST['prenume'];
 		
 			if(empty($_POST['adresa'])) $err['adresa'] = $lang['EROARE_ADRESA_EMPTY'];
 			else if(!empty($_POST['adresa']) && !preg_match("/^[a-z .,0-9]/i",$_POST['adresa'])) $err['adresa'] = $lang['EROARE_WORNG_ADRESA'];
 			else $adresa = $_POST['adresa'];
 			
 			if(empty($_POST['oras'])) $err['oras'] = $lang['EROARE_ORAS_EMPTY'];
 			else if(!empty($_POST['oras']) && !preg_match("/^[a-z ]/i",$_POST['oras'])) $err['oras'] = $lang['EROARE_WORNG_ORAS'];
 			else $oras = $_POST['oras'];
 			
 			if(empty($_POST['tara'])) $err['tara'] = $lang['EROARE_TARA_EMPTY'];
 			else $tara= $_POST['tara'];
 			
 			if(empty($_POST['codPostal'])) $err['codPostal'] = $lang['EROARE_CODPOSTAL_EMPTY'];
 			else if(!empty($_POST['codPostal']) && !preg_match("/^[0-9]/i",$_POST['codPostal']) or strlen($_POST['codPostal'])!=6) $err['codPostal'] = $lang['EROARE_WORNG_CODPOSTAL'];
 			else $codPostal = $_POST['codPostal'];
 			
 			if(empty($_POST['email'])) $err['email'] = $lang['EROARE_EMAIL_EMPTY'];
 			elseif (!empty($_POST['email']) && !preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $_POST['email'])) $err['email'] = $lang['EROARE_WORNG_EMAIL'];
 			elseif(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `email`='".mysql_real_escape_string($_POST['email'])."' LIMIT 1"))!=0) $err['email'] = $lang['EROARE_EXISTING_EMAIL'];
 			else $email = $_POST['email'];
 			
 			if(empty($_POST['telefon'])) $err['telefon'] = $lang['EROARE_TELEFON_EMPTY'];
 			elseif(strlen($_POST['telefon'])!=10 or !is_numeric($_POST['telefon'])) $err['telefon'] = $lang['EROARE_WRONG_TELEFON'];
 			else $telefon = $_POST['telefon'];
 					
 			if(empty($_POST['pwd'])) $err['pwd'] = $lang['EROARE_PAROLA_EMPTY'];
 			else $pwd = $_POST['pwd'];
 			
 			if(empty($_POST['pwd_con'])) $err['pwd_con'] = $lang['EROARE_CONFPWD_EMPTY'];
 			else if($_POST['pwd']!=$_POST['pwd_con']) $err['pwd_con']= $lang['EROARE_WRONG_PWD'];
 			else $pwd = $_POST['pwd_con'];
 			
			
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
				
				$code = generate_password(25);
				while(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `cod_confirmare`='".cinp($code)."' LIMIT 1"))!=0) 
					$code = generate_password(25);
					
 				$status = 0;
				$grup = 2;
 				if(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` LIMIT 1"))!=0) $grup = 2;
				else $grup=1;
				
 				$sql = "INSERT INTO `utilizatori` SET ";
 				$sql .= "`id_grup`='".cinp($grup)."',";
 				$sql .= "`id_titulatura` = '".cinp($titulatura)."',";
 				$sql .= "`nume_utilizator`='".cinp($user)."',";
 				$sql .= "`nume`='".cinp($name)."',";
 				$sql .= "`prenume`='".cinp($prenume)."',";
 				$sql .= "`adresa`='".cinp($adresa)."',";
 				$sql .= "`oras`='".cinp($oras)."',";
				$sql .= "`cod_postal`='".cinp($codPostal)."',";
 				$sql .= "`id_tara`='".cinp($tara)."',";
 				$sql .= "`email`='".cinp($email)."',";
 				$sql .= "`telefon`='".cinp($telefon)."',"; 
 				$sql .= "`data_creare`='".time()."',"; 
 				$sql .= "`parola`='".sha1($salt . $pwd)."',";
 				$sql .= "`status`='".cinp($status)."',";
				$sql .= "`cod_confirmare`='".cinp($code)."'";	
 				
 				$query = mysql_query($sql);
 				
 				if($query) { 

					include_once('phpmailer/class.phpmailer.php');
					$mail = new PHPMailer();
					
					
					 $body    = $lang['HELLO'] . "{$prenume},<br /> " . $lang['REG_MSG1']."<br /><br />".
					 $lang['REG_MSG2']. "<a href='".site."confirm.php?code={$code}&amp;email={$email}'>" . $lang['REG_MSG3']. "</a>.<br /><br />    
					
					<strong>".site."confirm.php?code={$code}&amp;email={$email}</strong><br /><br /><br /> " . $lang['REG_MSG4'];       
					
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
					
					$mail->SetFrom("AirADG.Reservation@gmail.com", "ADG Air");

					$mail->Subject = $lang['REG_MSG5'];
			
					$mail->MsgHTML($body); 
			
					$mail->AddAddress($email,$lang['REG_MSG6']);         
					if($mail->Send()) {
						//header("Location: congratulations.php");    
						echo 'sent';
					} 

 				}        
 			}    
 		}?>
<?php include_once 'head.php'; ?>
<?php include('header.php'); ?> 


	<div class="main_content">
		<div class="wrap">
			<section>
				<h1><?php echo $lang['FORMULAR_INREGISTRARE']; ?></h1>
				<form action="" method="post" name="register_form" id="creare_cont" action="">
 					
 						<?php if(isset($succes)) echo '<span class="succes">'.$succes.'</span>'; ?>
 						<?php if(isset($err['user'])) echo '<span class="eroare">'.$err['user'].'</span>'; ?>
 						<div>
 							<?php if(isset($err['username'])) echo '<span class="eroare">'.$err['username'].'</span>'; ?>
 							<label><?php echo $lang['USERNAME']; ?></label>
 							<input type="text" id="user" name="user" onBlur="charlen(this.id)" maxlength="20" onKeyup="isAlphaNumeric()" placeholder="<?php echo $lang['USERNAME_PLH']; ?>" autocomplete="off" required="required" />
 						</div>
 						
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
 							<?php if(isset($err['pwd'])) echo '<span class="eroare">'.$err['pwd'].'</span>'; ?>
 							<label><?php echo $lang['PAROLA']; ?></label>
 							<input type="password" id="pwd" name="pwd" onBlur="password()" placeholder="<?php echo $lang['PAROLA_PLH']; ?>"  value="<?php if(isset($pwd)) echo $pwd;?>" autocomplete="off" required="required" />
 						</div>

 						<div>
 							<?php if(isset($err['pwd_con'])) echo '<span class="eroare">'.$err['pwd_con'].'</span>'; ?>
 							<label><?php echo $lang['RESCRIERE_PAROLA']; ?></label>
 							<input type="password" name="pwd_con" id="pwd_con" onBlur="pass()" placeholder="<?php echo $lang['RESCRIERE_PAROLA_PLH']; ?>" autocomplete="off" value="<?php if(isset($pwd_con)) echo $pwd_con;?>" required="required" />
 						</div>

 						<div>
 							<input type="submit" id="x" onClick="chkform()" name="register" value="<?php echo $lang['INREGISTRARE']; ?>" />
 						</div>

 						
 					</table>
				</form>
			</section>
			<aside>
			</aside>
		</div>
	</div>

<?php include('footer.php'); ?> 