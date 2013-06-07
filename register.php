<?php require_once("config.php");?>
<?php include_once 'head.php'; ?>
<?php include('header.php'); ?> 

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

<?php include('footer.php'); ?> 