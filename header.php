<header class="clear">
	<div class="wrap">
		<div class="top"> 
			<div class="logo">
				<a href="index.php"><img src="images/airplane_logo.png" border="0" class="logoimage" />Air ADG</a>				
			</div>
			<div class="languages">
					<a href="<?php echo this_page();?>?lang=en"><img src="images/en.png" /></a>
					<a href="<?php echo this_page();?>?lang=ro"><img src="images/ro.png" /></a>
				</div>
		</div>
		<div id="menucont"> 
			  <div id="tabs">
				<ul class="taburi">
				  <li><a href="#tab-1"><?php echo $lang['REZERVARE_ZBOR'];?></a></li>
				  <li><a href="#tab-2"><?php echo $lang['INFORMATII'];?></a></li>
				  <li><a href="#tab-3"><?php echo $lang['Check-In'];?></a></li>
				  <li><a href="#tab-4"><?php echo $lang['MY_REZERVARE_ZBOR'];?></a></li>
				</ul>
				<div id="tab-1">
				
						<label class="from"><?php echo $lang['PLEACA_DIN'];?></label>
						<label class="to"><?php echo $lang['MERGE_CATRE'];?></label>
						
						<br/>
						<?php if(isset($err['aeroport_plecare'])) echo '<span class="eroare">'.$err['aeroport_plecare'].'</span>'; ?>
						
						<select id="aeroport_plecare" name="aeroport_plecare" placeholder="<?php echo $lang['FROM_PLH']; ?>"  autocomplete="off">
							<option></option>
							<?php 
 							$sql = mysql_query("SELECT * FROM `rute` AS `rt` INNER JOIN `aeroporturi` AS `aeroP` ON `rt`.`id_aeroport_plecare`=`aeroP`.`id_aeroport` 
												INNER JOIN `tari` AS `tp` ON `aeroP`.`id_tara` = `tp`.`id_tara` 
												GROUP BY `aeroP`.`id_aeroport`");
								while($rand = mysql_fetch_array($sql)) { // sunt 2 rute si de aia, pt fiecare ruta apare aeroportul ala. pai ti se pare ok ? nu :D
	
							?>
							<option value="<?php echo $rand['id_aeroport_plecare'];?>" <?php if(isset($from) and $from==$rand['id_aeroport_plecare']) echo 'selected'; ?>><?php echo $rand['denumire'].', '.$rand['oras'].", ".$rand['tara'];?></option>
							<?php
							}
							?>	
						</select>

						<?php if(isset($err['aeroport_sosire'])) echo '<span class="eroare">'.$err['aeroport_sosire'].'</span>'; ?>
 						<select id="aeroport_sosire" class="sel_to" name="aeroport_sosire" placeholder="<?php echo $lang['TO_PLH']; ?>"  autocomplete="off">
							<option></option>
						</select>
						<br/><br/>
							
						<label><?php echo $lang['DATA_SOSIRE'];?></label>
						<label class="data_pl"><?php echo $lang['DATA_PLECARE'];?></label>
						<label class="nr_pers"><?php echo $lang['NUMAR_PERSOANE'];?></label>
						
						<br />
						<?php if(isset($err['data_plecare'])) echo '<span class="eroare">'.$err['data_plecare'].'</span>'; ?>
						<input type="text" id="data_plecare" name="data_plecare" value="<?php if(isset($data_plecare)) echo $data_plecare;?>" class="date-pick tiny"/>
						
						<?php if(isset($err['data_sosire'])) echo '<span class="eroare">'.$err['data_sosire'].'</span>'; ?>
						<input class="data_pl_input" type="text" id="data_sosire" name="data_sosire" placeholder="<?php echo $lang['WAY'];?>" value="<?php if(isset($data_sosire)) echo $data_sosire;?>" class="date-pick tiny"/>

						<?php if(isset($err['nr_persoane'])) echo '<span class="eroare">'.$err['nr_persoane'].'</span>'; ?>
						<input class="data_pl_input" type="text" id="nr_persoane" name="nr_persoane" value="<?php if(isset($nr_persoane)) echo $nr_persoane;?>" />
						
						<br/><br/>
						<input type="submit" id="x" name="Cautare" value="<?php echo $lang['SEARCH'];?>" />
				</div>
				<div id="tab-2">
	
					<ul class="info">
						<li>
							<ul class="info1">
								<li><h3><?php echo $lang['INFORMATII'];?></h3></li>
								<li><a href="#"><?php echo $lang['HOW_REZ_ZBOR'];?></a></li>
								<li><a href="#"><?php echo $lang['CHECK_IN'];?></a></li>
								<li><a href="#"><?php echo $lang['HOW_PAY_ZBOR'];?></a></li>
							</ul>
						</li>
						<li>
							<ul class="info1">
								<li><h3><?php echo $lang['INFO_ZBOR'];?></h3></li>
								<li><a href="#"><?php echo $lang['DEST_EXIST'];?></a></li>
								<li><a href="#"><?php echo $lang['COMP_AER'];?></a></li>
							</ul>
						</li>
						<li>
							<ul class="info1">
								<li>Air ADG</li>
								<li><a href="#"><?php echo $lang['DATE_DESPRE_NOI'];?></a></li>
								<li><a href="#"><?php echo $lang['AGENTII'];?></a></li>
								<li><a href="#"><?php echo $lang['CONTACT_US'];?></a></li>
							</ul>
						</li>
					</ul>
	
					
				</div>
				<div id="tab-3">
					<label class="conf_number"><?php echo $lang['NUMAR_CONFIRMARE'];?></label>
					<label class="last_name"><?php echo $lang['NUME_REZERVARE'];?></label>
					
					<br/><br/>
					
					<input class="conf_number" type="text" id="nr_persoane" name="nr_persoane" value="<?php if(isset($nr_persoane)) echo $nr_persoane;?>" />
					<input class="last_name" type="text" id="nr_persoane" name="nr_persoane" value="<?php if(isset($nr_persoane)) echo $nr_persoane;?>" />
					
					<br/><br/>
					<input type="submit" id="x_b" name="Cautare" value="<?php echo $lang['SEARCH_BOOK'];?>" />
				</div>
				<div id="tab-4">
					<label class="conf_number"><?php echo $lang['NUMAR_CONFIRMARE'];?></label>
					<label class="last_name"><?php echo $lang['NUME_REZERVARE'];?></label>
					
					<br/><br/>
					
					<input class="conf_number" type="text" id="nr_persoane" name="nr_persoane" value="<?php if(isset($nr_persoane)) echo $nr_persoane;?>" />
					<input class="last_name" type="text" id="nr_persoane" name="nr_persoane" value="<?php if(isset($nr_persoane)) echo $nr_persoane;?>" />
					
					<br/><br/>
					<input type="submit" id="x_r" name="Cautare" value="<?php echo $lang['SEARCH_BOOK'];?>" />
				</div>
			  </div>
		</div>
			<div id="right_tab">
					<?php if(!isset($_SESSION['logat'])) { ?>
					<h2><?php echo $lang['LOGIN_TITLE'] ?> </h2>
					<p><?php echo $lang['AUTENTIFICARE_CREARE_CONT'];?></p>
					<a href="#" id="afiseaza_login" class="login_links"><?php echo $lang['LOGARE']; ?></a>
					<a href="register.php" class="login_links"><?php echo $lang['INREGISTRARE']; ?></a>
					<div id="loginform">  
						<form action="" name="formular_login" method="post" class="loginForm">  
							
								<?php if(isset($err['userName'])) echo '<span class="eroare">'.$err['userName'].'</span>'; ?>
								<div><label for="userName"><?php echo $lang['USERNAME']; ?></label>  
								<input id="userName" type="userName" name="userName" placeholder="<?php echo $lang['USERNAME']; ?>" required></div>
								<?php if(isset($err['passwordLogin'])) echo '<span class="eroare">'.$err['passwordLogin'].'</span>'; ?>								
								<div><label for="password"><?php echo $lang['PAROLA']; ?></label>  
								<input type="password" id="passwordLogin" name="passwordLogin" placeholder="<?php echo $lang['PAROLA']; ?>" required></div>  
								<div>  
									<input type="submit" name="loginForm" id="loginForm" value="<?php echo $lang['LOGARE']; ?>"> 
								</div> 
								<a href="resetare_parola.php"  class="login_links"><?php echo $lang['RECUPERARE_PAROLA']; ?></a>  
						</form>  
					</div> 
					<?php } else { ?>
					<p><?php echo $lang['LOGAT'] ?></p>
					
					<a href="edit_user.php"><?php echo $lang['MODIFY_USER'] ?></a><br/></br>
					<a href="logout.php">LOGOUT</a>
					<?php } ?>
			</div>
	</div>
	<span class="clear"></span>
</header>