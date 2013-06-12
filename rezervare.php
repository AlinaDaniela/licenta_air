<?php require_once("config.php");?>
 <?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user'])) header("Location: cont.php");
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
					
				</div>
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
 									$sql = mysql_query("SELECT * FROM `clase`");
 									while($rand = mysql_fetch_array($sql)) {
 								?>
 								<option value="<?php echo $rand['id_clasa'];?>"><?php echo $rand['clasa'];?></option>
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
 									$sql = mysql_query("SELECT * FROM `tipuri_meniu`");
 									while($rand = mysql_fetch_array($sql)) {
 								?>
 								<option value="<?php echo $rand['id_meniu'];?>"><?php echo $rand['denumire'];?></option>
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
 									$sql = mysql_query("SELECT * FROM `tipuri_bagaj`");
 									while($rand = mysql_fetch_array($sql)) {
 								?>
 								<option value="<?php echo $rand['id_tip_bagaj'];?>"><?php echo $rand['tip_bagaj'];?></option>
 								<?php
 								}
 								?>	
 							</select>						
						</div>
						<div>
						<fieldset>
							   <legend>Selecteaza categoria de varsta</legend>
							   <p>
								  <label>Sub 2 ani</label>            
								  <input type = "radio" name = "radSize" checked = "checked" />
								  
								  <label for = "">2-10 ani</label>
								  <input type ="radio" name = "radSize" value = "medium" />
								  <label for ="">Adult</label>

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
			</section>
			<aside>
				
			</aside>
		</div>
	</div>

<?php include('footer.php'); ?> 