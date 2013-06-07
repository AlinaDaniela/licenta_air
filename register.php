<?php require_once("config.php");?>
<?php
include_once 'common.php';
?>

<?php  if(isset($_POST['register'])){
		
			if(empty($_POST['user'])) $err['user'] = "Introduceti numele de utilizator dorit";
			else if(!empty($_POST['user']) && !preg_match("/^[a-z0-9]",$_POST['user'])) $err['user'] = "Numele de utilizator incorect!";
			else if(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `nume_utilizator` = '".mysql_real_escape_string($_POST['user'])."' LIMIT 1"))!=0) $err['user'] = "Acest nume de utilizator nu este valabil!";
			else $user = $_POST['user'];
			
			if(empty($_POST['titulatura'])) $err['titulatura'] = "Selectati titulatura";
			else $titulatura= $_POST['titulatura'];
			
			if(empty($_POST['name'])) $err['name'] = "Introduceti numele";
			else if(!empty($_POST['name']) && !preg_match("/^[a-z ]",$_POST['name'])) $err['name'] = "Numele incorect!";
			else $name = $_POST['name'];
			
			if(empty($_POST['prenume'])) $err['prenume'] = "Introduceti prenumele";
			else if(!empty($_POST['prenume']) && !preg_match("/^[a-z ]",$_POST['prenume'])) $err['prenume'] = "Prenume incorect!";
			else $prenume = $_POST['prenume'];
		
			if(empty($_POST['adresa'])) $err['adresa'] = "Introduceti adresa";
			else if(!empty($_POST['adresa']) && !preg_match("/^[a-z .,0-9]",$_POST['adresa'])) $err['adresa'] = "Adresa incorecta!";
			else $adresa = $_POST['adresa'];
			
			if(empty($_POST['oras'])) $err['oras'] = "Introduceti orasul";
			else if(!empty($_POST['oras']) && !preg_match("/^[a-z ]",$_POST['oras'])) $err['oras'] = "Oras incorect!";
			else $oras = $_POST['oras'];
			
			if(empty($_POST['tara'])) $err['tara'] = "Selectati tara";
			else $tara= $_POST['tara'];
			
			if(empty($_POST['codPostal'])) $err['codPostal'] = "Introduceti codul postal";
			else if(!empty($_POST['codPostal']) && !preg_match("/^[0-9]",$_POST['codPostal']) or strlen($_POST['codPostal'])!=6) $err['codPostal'] = "Cod postal incorect!";
			else $codPostal = $_POST['codPostal'];
			
			if(empty($_POST['email'])) $err['email'] = "Introduceti adresa de mail";
			elseif (!empty($_POST['email']) && !preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $_POST['email'])) $err['email'] = "Aceasta adresa de e-mail este incorecta.";
			elseif(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `email`='".mysql_real_escape_string($_POST['email'])."' LIMIT 1"))!=0) $err['email'] = "Aceasta adresa de e-mail exista deja in baza noastra de date.";
			else $email = $_POST['email'];
			
			if(empty($_POST['telefon'])) $err['telefon'] = "Introduceti telefon";
			elseif(strlen($_POST['telefon'])!=10 or !is_numeric($_POST['telefon'])) $err['telefon'] = "Telefonul trebuie sa fiu un numar format din 10 cifre.";
			else $telefon = $_POST['telefon'];
					
			if(empty($_POST['pwd'])) $err['pwd'] = "Introduceti parola";
			else $pwd = $_POST['pwd'];
			
			if(empty($_POST['pwd_con'])) $err['pwd_con'] = "Completati parola de confirmare!";
			else if($_POST['pwd']!=$_POST['pwd_con']) $err['pwd_con']="Parolele nu corespund!";
			else $pwd = $_POST['pwd_con'];
			
			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
				
				$status = 1;
				$grup=2;
				$sql = "INSERT INTO `utilizatori` SET ";
				$sql .= "`id_grup`='".$grup."',";
				$sql .= "`id_titulatura".mysql_real_escape_string($titulatura)."',";
				$sql .= "`nume_utilizator`='".mysql_real_escape_string($user)."',";
				$sql .= "`nume`='".mysql_real_escape_string($name)."',";
				$sql .= "`prenume`='".mysql_real_escape_string($prenume)."',";
				$sql .= "`adresa`='".mysql_real_escape_string($adresa)."',";
				$sql .= "`oras`='".mysql_real_escape_string($oras)."',";
				$sql .= "`id_tara`='".mysql_real_escape_string($tara)."',";
				$sql .= "`email`='".mysql_real_escape_string($email)."',";
				$sql .= "`telefon`='".mysql_real_escape_string($telefon)."',"; 
				$sql .= "`data_creare`='".time()."',"; 
				$sql .= "`parola`='".md5($pwd)."',";
				$sql .= "`status`='".$status."'";  
				
				
				$query = mysql_query($sql);
				
				if($query) {      
					$to  = 'alinadanielagheorghe@gmail.com'. ', '; 
					$to .= $email;
			
					$subject = 'Utilizator nou';
					
					$message = '
						User: '.$username.'
						Parola: '.$parola.'
					';
					
					$headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";

					mail($to, $subject, $message, $headers);
					
					unset($adresa, $name, $prenume, $user, $pwd, $pwd_con, $codPostal, $tara, $oras, $telefon, $email, $status, $grup, $titulatura);  
					
					$succes = "Utilizatorul a fost adaugat in baza de date.";
				}        
			}    
		}?>
<!DOCTYPE html>
<html>
<head>
<title>AirReservation</title>
<link type="text/css" href="css/style.css" rel="stylesheet" media="screen" />
<?php include_once 'head.php'; ?>
<script type="text/javascript">

	function isAlphaNumeric()
	{
	  var alphaExp = /^[0-9 a-zA-Z]+$/;
	  var usernam=document.register_form.user.value;
	  var ualt=document.getElementById('user1');
	  if(!usernam.match(alphaExp) && (usernam!=""))
	  {
		document.register_form.user.focus();
		ualt.innerHTML="<font color='red'> Nume de utilizator invalid </font>";
		return false;
	  }else{
			ualt.innerHTML="";
		return true;
	  } 
	}
	
	function  charlen()
	{
	  var userid=document.getElementById('user');
	  var uu=userid.value;
	  var chrlen=uu.length;
	  var ualt=document.getElementById('user1');
	  if(uu!="")
	  {
		if(chrlen<5)
		{
		  document.register_form.user.focus();
		  
		ualt.innerHTML="<font color='red'> Nume de utilizator prea scurt! </font>";
		   return false;
		}else {
		  ualt.innerHTML="";
		  return true;
		}
	   }
	   else if(chrlen==0)  {
		 ualt.innerHTML="<font color='red'> Va rugam sa completati campul!</font>";
		userid.focus();
	   return false;
		}

	}
	
	function validateNume()
	{
	  var alphaExp = /^[a-zA-Z]+$/;
	  var namee=document.register_form.name.value;
	  var nalt=document.getElementById('name1');
	  if(namee!="")
	   {
		  if(!namee.match(alphaExp))
		  {
		   nalt.innerHTML="<font color='red'> Caractere invalide </font>";
		   document.register_form.name.focus();
			document.register_form.name.value="";
			 return false; 	
		   }else{
			  nalt.innerHTML="";
				return true; 
			}
	   }
	  else  if(namee.length==0) {
	   nalt.innerHTML="<font color='red'>Va rugam sa completati campul!</font>";
		document.getElementById('name').focus();
	   return false;
		}
	  
	}
	
	function validatePrenume()
	{
	  var alphaExp = /^[a-z A-Z]+$/;
	  var namee=document.register_form.prenume.value;
	  var nalt=document.getElementById('prenume1');
	  if(namee!="")
	   {
		  if(!namee.match(alphaExp))
		  {
		   nalt.innerHTML="<font color='red'> Caractere invalide </font>";
		   document.register_form.prenume.focus();
			document.register_form.prenume.value="";
			 return false; 	
		   }else{
			  nalt.innerHTML="";
				return true; 
			}
	   }
	  else  if(namee.length==0) {
	   nalt.innerHTML="<font color='red'>Va rugam sa compeltati campul!</font>";
		document.getElementById('preume').focus();
	   return false;
		}
	  
	}
	
	function validateAdresa()
	{
	  var alphaExp = /^[0-9 a-zA-Z]+$/;
	  var usernam=document.register_form.adresa.value;
	  var ualt=document.getElementById('adresa1');
	  if(!usernam.match(alphaExp) && (!username="")|| (usernam=""))
	  {
		document.register_form.adresa.focus();
		ualt.innerHTML="<font color='red'> Adresa invalida </font>";
		return false;
	  }else{
			ualt.innerHTML="";
		return true;
	  } 
	}
	
	function validateOras()
	{
	  var alphaExp = /^[0-9 a-zA-Z]+$/;
	  var usernam=document.register_form.oras.value;
	  var ualt=document.getElementById('oras1');
	  if((!usernam.match(alphaExp) && usernam!="")|| (usernam=""))
	  {
		document.register_form.oras.focus();
		ualt.innerHTML="<font color='red'> Oras invalid </font>";
		return false;
	  }else{
			ualt.innerHTML="";
		return true;
	  } 
	}
	
	function slctemp()
	{
		var saalt=document.getElementById('tara1'); 
		saalt.innerHTML="";
	}
	 
	/*function madeselection()
	{
	   var selct=document.getElementById('tara');
	   var salt=document.getElementById('tara1'); 
	 
	   if(selct.value==""||selct.value="")//|| (userlen.value.length==0) || (phno.value.length==0)|| (pawd.value.length==0) || (pawdcon.value.length==0) || (nam.value.length==0))
	   {
		 salt.innerHTML="<font color='red'> Alegeti tara</font>";
		 selct.focus();
	     return false;
	   }
	   else{ 
		 return true;
	   }
	}
	*/
	
	function validateCodPostal()
	{
	  var elem=document.register_form.codPostal.value;
	  var nalt=document.getElementById('codPostal1');
	 if(elem!="")
	 {
		var numericExpression = /^[0-9]+$/;
		  if(elem.match(numericExpression))
		{
			 nalt.innerHTML="";
			 return true;
		   }
		
		else{
			
		nalt.innerHTML="<font color='red'> Doar valori numerice</font>";
			  document.register_form.codPostal.focus();
			  document.register_form.codPostal.value="";
		   return false;
		  }
	  }
	  else if(elem.length==0)  {
			nalt.innerHTML="<font color='red'> Va rugam sa compeltati campul</font>";
			document.register_form.codPostal.focus();;
			return false;
	  }

	}
	
	function validateEmail()
	{
	  var emal=document.register_form.email.value;
	  var ealt=document.getElementById('email1');
	  if(emal!="")
	  {
		var emailExp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([com\co\ro\it\.\in])+$/;
		if(!emal.match(emailExp))
		{
		   document.register_form.email.focus();
		
		ealt.innerHTML="<font color='red'> Email invalid</font>";
			 return false; 	
		  }else{
			 ealt.innerHTML="";
		 document.getElementById('email').focus();
		 return true;
		}
	  }    
	 else if(emal.length==0)
	 {
		  ealt.innerHTML="<font color='red'> Va rugam sa completati email-ul!/font>";
		 return false; 
	 }
	}
	
	function isNumeric()
	{
	  var elem=document.register_form.telefon.value;
	  var nalt=document.getElementById('telefon1');
	 if(elem!="")
	 {
		var numericExpression = /^[0-9]+$/;
		  if(elem.match(numericExpression))
		{
			 nalt.innerHTML="";
			 return true;
		   }
		
		else{
			
		nalt.innerHTML="<font color='red'> Doar valori numerice!!!</font>";
			  document.register_form.telefon.focus();
			  document.register_form.telefon.value="";
		   return false;
		  }
	  }
	  else if(elem.length==0)  {
		nalt.innerHTML="<font color='red'> Va rugam sa completati campul!</font>";
		 document.register_form.telefon.focus();;
	   return false;
		}
	}
	
	function password()
	{
	   var pawd1=document.getElementById('pwd');
	   var palt=document.getElementById('pwd1');
	 if(pawd1.value.length<5)
	  {
		palt.innerHTML="<font color='red'> Parola trebuie sa aiba minim 5 caractere</font>";
		document.getElementById('pwd').focus();
	   return false;
	  }
	 else
	  {
		palt.innerHTML="";
		return true;
	  }

	}
	
	function pass()
	{
	  var pawd1=document.getElementById('pwd');
	  var pawdcon2=document.getElementById('pwd_con');
	  var palt=document.getElementById('pwd1');
	  var pcalt=document.getElementById('pwdcon1');
	  
	 if(pawdcon2.value.length==0)  {
		pcalt.innerHTML="<font color='red'> Parola de confirmare invalida! </font>";
		pawdcon.focus();
	   return false;
		}
	   
	 else if(pawd1.value!=pawdcon2.value)
	  {
		pcalt.innerHTML="";
		palt.innerHTML="<font color='red'> Parolele nu corespund!</font>";
		return false;
	  }else{
		palt.innerHTML="";
		pcalt.innerHTML="";
		return true;
	  }
	}

</script>

</head>
<body>



	<header class="clear">
		<div class="wrap">
			<?php include('header.php'); ?> 
		</div>
	</header>
	<div class="main_content">
		<div class="wrap">
				<form action="" method="post" name="register_form" id="creare_cont" action="">
					
					<table cellpadding="0" cellspacing="0" border="0" class="register_table">
						<?php if(isset($succes)) echo '<span class="succes">'.$succes.'</span>'; ?>
						<?php if(isset($err['user'])) echo '<span class="eroare">'.$err['user'].'</span>'; ?>
						<tr>
							<td class="form-input-name"><?php echo $lang['USERNAME']; ?></td>
							<td class="input"><input type="text" id="user" name="user" onBlur="charlen(this.id)" maxlength="20" onKeyup="isAlphaNumeric()" placeholder="<?php echo $lang['USERNAME_PLH']; ?>" autocomplete="off" required="required" /></td>
							<td class=""><span id=user1></span></td>
						</tr>
						<?php if(isset($err['titulatura'])) echo '<span class="eroare">'.$err['titulatura'].'</span>'; ?>
						<tr>
							<td class="form-input-name">Titulatura</td>
							<td class="input">
								<select id="tara" name="titulatura" placeholder="titulatura"  autocomplete="off">
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
    					</select><br/>
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
								<select id="tara" onChange="slctemp()" onBlur="madeSelection()" name="tara" placeholder="<?php echo $lang['ORAS_PLH']; ?>"  autocomplete="off">
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
    					</select><br/>
							</td>
							<td class=""><span id="tara1"></span></td>
						</tr>
						<?php if(isset($err['codPostal'])) echo '<span class="eroare">'.$err['codPostal'].'</span>'; ?>
						<tr>
							<td class="form-input-name"><?php echo $lang['COD_POSTAL']; ?></td>
							<td class="input"><input type="text" name="codPostal" id="codPostal" onBlur="validateCodPostal()" placeholder="<?php echo $lang['COD_POSTAL_PLH']; ?>" value="<?php if(isset($codPostal)) echo $codPostal;?>" autocomplete="off" /></td>
							<td class=""><span id="codPostal1"></span></td>
						</tr>
						<?php if(isset($err['email'])) echo '<span class="eroare">'.$err['email'].'</span>'; ?>
						<tr>
							<td class="form-input-name"><?php echo $lang['EMAIL']; ?></td>
							<td class="input"><input type="email" name="email" id="email" onBlur="validateEmail()" placeholder="<?php echo $lang['EMAIL_PLH']; ?>" value="<?php if(isset($email)) echo $email;?>" autocomplete="off" required="required" /></td>
							<td class=""><span id="email1"></span></td>
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
							<td class="input"><input type="password" id="pwd" name="pwd" onBlur="password()" placeholder="<?php echo $lang['PAROLA_PLH']; ?>"  value="<?php if(isset($pwd)) echo $pwd;?>" autocomplete="off" required="required" /></td>
							<td class=""><span id="pwd1"></span></td>
						</tr>
						<?php if(isset($err['pwd_con'])) echo '<span class="eroare">'.$err['pwd_con'].'</span>'; ?>
						<tr>
							<td class="form-input-name"><?php echo $lang['RESCRIERE_PAROLA']; ?></td>
							<td class="input"><input type="password" name="pwd_con" id="pwd_con" onBlur="pass()" placeholder="<?php echo $lang['RESCRIERE_PAROLA_PLH']; ?>" autocomplete="off" value="<?php if(isset($pwd_con)) echo $pwd_con;?>" required="required" /></td>
							<td class=""><span id="pwdcon1"></span></td>
						</tr>
						<tr>
							<td class="form-input-name"></td>
							<td><input type="submit" id="x" onClick="chkform()" name="register" value="<?php echo $lang['INREGISTRARE']; ?>" /></td>
						</tr>
					</table>
                </form>
			</section>
			<aside>
			</aside>
		</div>
	</div>

	<footer>
		<div class="wrap">
		
		</div>
	</footer>
</body>

</html>