<?php
									$sql = mysql_query("SELECT `tm`.`denumire`, `zmc`.`id_zbor_meniu_clasa` 
																		FROM `zbor_meniu_clasa` AS `zmc` INNER JOIN `zbor_clasa` AS `zc` ON `zmc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa` 
																		INNER JOIN `meniu_companie` AS `mc` ON `mc`.`id_meniu` = `zmc`.`id_meniu` 
																		INNER JOIN `tipuri_meniu` AS `tm` ON `tm`.`id_meniu` = `mc`.`id_meniu` 
																		INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa` 
																		INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa` = `cc`.`id_clasa` 
																		WHERE `zmc`.`id_zbor_clasa` = '".$id_zbor_clasa."' 
																		GROUP BY `zmc`.`id_zbor_meniu_clasa`");
									if(mysql_num_rows($sql)!=0) {?>
								<div>
									<?php if(isset($err['meniu'][$idZbor][$nr])) echo '<span class="eroare">'.$err['meniu'][$idZbor][$nr].'</span>'; ?>
											<label><?php echo $lang['MENIU']; ?></label>

											<select name="meniu[<?php echo $idZbor;?>][<?php echo $nr; ?>]" placeholder="<?php echo $lang['MENIU']; ?>"  autocomplete="off">
													<option value=""></option>
													<?php 
													
													while($rand = mysql_fetch_array($sql)) {
													?>
													<option value="<?php echo $rand['id_zbor_meniu_clasa'];?>" <?php if(isset($_POST['meniu'][$idZbor][$nr]) and $_POST['meniu'][$idZbor][$nr]==$rand['id_zbor_meniu_clasa']) echo 'selected'; ?>><?php echo $rand['denumire'];?></option>
													<?php
														}
													?>	
											</select>						
								</div>
								
								<?php } ?>
								<div>
													
									<?php 
										$s = mysql_query("SELECT `tb`.`tip_bagaj`, `zbc`.`id_tip_bagaj`,`zbc`.`id_zbor_bagaje_clasa`, `cl`.`clasa`, `zbc`.`pret`, `zbc`.`descriere` 
														FROM `zbor_bagaje_clasa` AS `zbc` INNER JOIN `zbor_clasa` AS `zc` ON `zbc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa` 
														INNER JOIN `bagaje_companie` AS `bc` ON `bc`.`id_tip_bagaj` = `zbc`.`id_tip_bagaj` 
														INNER JOIN `tipuri_bagaj` AS `tb` ON `tb`.`id_tip_bagaj` = `bc`.`id_tip_bagaj` 
														INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa` 
														INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa`=`cc`.`id_clasa` WHERE `zbc`.`id_zbor_clasa` = '".$id_zbor_clasa."' 
														GROUP BY `zbc`.`id_tip_bagaj`");
										$nr_tipuri_bagaj = mysql_num_rows($s);
										$nr_tb = 0;

										while($rTB = mysql_fetch_array($s)) {
											$nr_tb++;
										?>
										<?php if(isset($err['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']])) echo '<span class="eroare">'.$err['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']].'</span>'; ?>
											
													<?php 

														$sql = mysql_query("SELECT `zbc`.`descriere`, `zbc`.`pret`, `zbc`.`id_zbor_bagaje_clasa`, `zbc`.`id_tip_bagaj`
																			FROM `zbor_bagaje_clasa` AS `zbc` INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor_clasa` = `zbc`.`id_zbor_clasa`
																			WHERE `zbc`.`id_tip_bagaj` = '".$rTB['id_tip_bagaj']."' AND `zc`.`id_zbor` = '".$idZbor."' AND `zbc`.`id_zbor_clasa` = '".$id_zbor_clasa."'");
														if(mysql_num_rows($sql)!=0) {
													
													?>
													<label><?php echo $rTB['tip_bagaj']; ?></label>
											<select  name="bagaj[<?php echo $idZbor; ?>][<?php echo $nr; ?>][<?php echo $rTB['id_tip_bagaj']; ?>]" placeholder="<?php echo $lang['BAGAJ']; ?>"  autocomplete="off">
												<option value=""></option>
												<option value="0" <?php if(isset($_POST['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']]) and $_POST['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']]==0) echo 'selected'; ?> >Nici una dintre aceste optiuni</option>
													<?php
														while($rand = mysql_fetch_array($sql)) {
													?>
																															
												<option value="<?php echo $rand['id_zbor_bagaje_clasa'];?>" <?php if(isset($_POST['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']]) and $_POST['bagaj'][$idZbor][$nr][$rTB['id_tip_bagaj']]==$rand['id_zbor_bagaje_clasa']) echo 'selected'; ?> ><?php echo $rand['descriere']." - ".$rand['pret'];?></option>
												<?php
													}
												?>
												</select>	
												<?php
													}
												?>	
											
												
										<?php 
										}
										?>
								</div>

								<?php
									$sql = mysql_query("SELECT `cv`.`categorie`, `zrc`.`id_zbor_reducere_clasa`, `cl`.`clasa`, `zrc`.`reducere` 
																FROM `zbor_reduceri_clasa` AS `zrc` INNER JOIN `zbor_clasa` AS `zc` ON `zrc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa`
																INNER JOIN `companie_reduceri_categorii` AS `crc` ON `crc`.`id_categorie_varsta` = `zrc`.`id_categorie_varsta`
																INNER JOIN `categorii_varsta` AS `cv` ON `cv`.`id_categorie_varsta` = `crc`.`id_categorie_varsta`
																INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa`
																INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa`=`cc`.`id_clasa`
																WHERE `zrc`.`id_zbor_clasa` = '".$id_zbor_clasa."'
																GROUP BY `zrc`.`id_zbor_reducere_clasa`");
										echo mysql_num_rows($sql); 
									if(mysql_num_rows($sql)!=0) {
								?>
								<div class="fieldset">
									<fieldset class="cat_field">
									   <legend>Selecteaza categoria de varsta</legend>
									   <p>
										<?php if(isset($err['categorie'][$idZbor][$nr])) echo '<span class="eroare">'.$err['categorie'][$idZbor][$nr].'</span>'; ?>
										   <label>Nici una dintre aceste categorii</label>
										   <input type = "radio" name="categorie[<?php echo $idZbor;?>][<?php echo $nr;?>]" value="0"/>
								   <?php 
																						
											while($rand = mysql_fetch_array($sql)) {
											?>
												<label><?php echo $rand['categorie'];?></label>            
												<input type = "radio"   
												name="categorie[<?php echo $idZbor;?>][<?php echo $nr;?>]" <?php if(isset($_POST['categorie'][$idZbor][$nr]) and $_POST['categorie'][$idZbor][$nr]==$rand['id_zbor_reducere_clasa']) echo 'checked';  ?>
												value="<?php echo $rand['id_zbor_reducere_clasa']; ?>"/>
											<?php
												}
											?>	
										</p>       
									</fieldset>     
								</div>
							
							
							<?php }  ?>		  