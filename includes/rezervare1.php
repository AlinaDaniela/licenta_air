<div>
	<?php if(isset($err['meniu'])) echo '<span class="eroare">'.$err['meniu'].'</span>'; ?>
								<label><?php echo $lang['MENIU']; ?></label>

								<select id="meniu" name="meniu[]" placeholder="<?php echo $lang['MENIU']; ?>"  autocomplete="off">
									<option></option>
									<?php 
										$sql = mysql_query("SELECT `tm`.`denumire`, `zmc`.`id_zbor_meniu_clasa`, `cl`.`clasa` 
															FROM `zbor_meniu_clasa` AS `zmc` INNER JOIN `zbor_clasa` AS `zc` ON `zmc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa`
															INNER JOIN `meniu_companie` AS `mc` ON `mc`.`id_meniu` = `zmc`.`id_meniu`
															INNER JOIN `tipuri_meniu` AS `tm` ON `tm`.`id_meniu` = `mc`.`id_meniu`
															INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa`
															INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa` = `cc`.`id_clasa`
															WHERE `zmc`.`id_zbor_clasa` = '".$r['id_zbor_clasa']."'");
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

								<select id="bagaj" name="bagaj[]" placeholder="<?php echo $lang['BAGAJ']; ?>"  autocomplete="off">
									<option></option>
									<?php 
		
										$sql = mysql_query("SELECT `tb`.`tip_bagaj`, `zbc`.`id_zbor_bagaje_clasa`, `cl`.`clasa`, `zbc`.`pret`, `zbc`.`descriere` 
															FROM `zbor_bagaje_clasa` AS `zbc` INNER JOIN `zbor_clasa` AS `zc` ON `zbc`.`id_zbor_clasa` = `zc`.`id_zbor_clasa`
															INNER JOIN `bagaje_companie` AS `bc` ON `bc`.`id_tip_bagaj` = `zbc`.`id_tip_bagaj`
															INNER JOIN `tipuri_bagaj` AS `tb` ON `tb`.`id_tip_bagaj` = `bc`.`id_tip_bagaj`
															INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa`
															INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa`=`cc`.`id_clasa`
															WHERE `zbc`.`id_zbor_clasa` = '".$r['id_zbor_clasa']."'");
										while($rand = mysql_fetch_array($sql)) {
									?>
										<!-- Pt fiecare tip de bagaj -->
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
																INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa`=`cc`.`id_clasa`
																WHERE `zrc`.`id_zbor_clasa` = '".$id_zbor_clasa."'");
											while($rand = mysql_fetch_array($sql)) {
										?>
										<label><?php echo $rand['categorie'];?></label>            
										<input type = "radio" name="categorie[]" />
										<?php
										}
										?>	
									</p>       
								  </fieldset>     
								  </div>