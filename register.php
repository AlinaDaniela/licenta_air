<?php
include_once 'common.php';
?>
<?php require_once("config.php");?>

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
				<form action="" method="post" name="register_form">
					<table cellpadding="0" cellspacing="0" border="0" class="register_table">
						<tr>
							<td class="form-input-name"><?php echo $lang['USERNAME']; ?></td>
							<td class="input"><input type="text" id="user" name="user" onBlur="charlen(this.id)" maxlength="20" onKeyup="isAlphaNumeric()" placeholder="<?php echo $lang['USERNAME_PLH']; ?>" autocomplete="off" required="required" /></td>
							<td class=""><span id=user1></span></td>
						</tr>
						<tr>
							<td class="form-input-name"><?php echo $lang['NUME']; ?></td>
							<td class="input"><input type="text" id="name" onBlur="validateNume();" name="name" placeholder="<?php echo $lang['NUME_PLH']; ?>" autocomplete="off" required="required" /></td>
							<td class=""><span id="name1"></span></td>
						</tr>
						<tr>
							<td class="form-input-name"><?php echo $lang['PRENUME']; ?></td>
							<td class="input"><input type="text" id="prenume" onBlur="validatePrenume();" name="prenume" placeholder="<?php echo $lang['PRENUME_PLH']; ?>" autocomplete="off" required="required" /></td>
							<td class=""><span id="prenume1"></span></td>
						</tr>
						<tr>
							<td class="form-input-name"><?php echo $lang['ADRESA']; ?></td>
							<td class="input"><input type="text" name="adresa" id="adresa" onBlur="validateAdresa()" placeholder="<?php echo $lang['ADRESA_PLH']; ?>" autocomplete="off" /></td>
							<td class=""><span id="adresa1"></span></td>
						</tr>
						<tr>
							<td class="form-input-name"><?php echo $lang['ORAS']; ?></td>
							<td class="input"><input type="text" name="oras"  id="oras" onBlur="validateOras()" placeholder="<?php echo $lang['ORAS_PLH']; ?>" autocomplete="off" /></td>
							<td class=""><span id="oras1"></span></td>
						</tr>
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
						<tr>
							<td class="form-input-name"><?php echo $lang['COD_POSTAL']; ?></td>
							<td class="input"><input type="text" name="codPostal" id="codPostal" onBlur="validateCodPostal()" placeholder="<?php echo $lang['COD_POSTAL_PLH']; ?>" autocomplete="off" /></td>
							<td class=""><span id="codPostal1"></span></td>
						</tr>
						<tr>
							<td class="form-input-name"><?php echo $lang['EMAIL']; ?></td>
							<td class="input"><input type="email" name="email" id="email" onBlur="validateEmail()" placeholder="<?php echo $lang['EMAIL_PLH']; ?>" autocomplete="off" required="required" /></td>
							<td class=""><span id="email1"></span></td>
						</tr>
						<tr>
							<td class="form-input-name"><?php echo $lang['TELEFON']; ?></td>
							<td class="input"><input type="tel" id="telefon" name="telefon" onKeyup="isNumeric()" maxlength="10" splaceholder="<?php echo $lang['TELEFON_PLH']; ?>" autocomplete="off" required="required"/></td>
							<td class=""><span id="telefon1"></span></td>
						</tr>
						<tr>
							<td class="form-input-name"><?php echo $lang['PAROLA']; ?></td>
							<td class="input"><input type="password" id="pwd" name="pwd" onBlur="password()" placeholder="<?php echo $lang['PAROLA_PLH']; ?>" autocomplete="off" required="required" /></td>
							<td class=""><span id="pwd1"></span></td>
						</tr>
						<tr>
							<td class="form-input-name"><?php echo $lang['RESCRIERE_PAROLA']; ?></td>
							<td class="input"><input type="password" name="pwd_con" id="pwd_con" onBlur="pass()" placeholder="<?php echo $lang['RESCRIERE_PAROLA_PLH']; ?>" autocomplete="off" required="required" /></td>
							<td class=""><span id="pwdcon1"></span></td>
						</tr>
						<tr>
							<td class="form-input-name"></td>
							<td><input type="submit" id="x" onClick="chkform()" value="<?php echo $lang['INREGISTRARE']; ?>" /></td>
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