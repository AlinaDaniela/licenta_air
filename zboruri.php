<?php require_once("config.php");?>
 <?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user']) or $_SESSION['tip_user']!="admin") header("Location: cont.php");
?>
<?php 
if(isset($_GET['id_zbor'])) {
	$id_zbor = $_GET['id_zbor'];
	$s = mysql_query("SELECT * FROM `zboruri` WHERE `id_zbor`='".cinp($id_zbor)."' LIMIT 1");
    $r = mysql_fetch_assoc($s);
	$cod_zbor = $r['cod_zbor'];
	$sCA = mysql_query("SELECT * FROM `companie_avioane` WHERE `id_avion`='".$r['id_avion']."'");
	$rCA = mysql_fetch_assoc($sCA);
	$sC = mysql_query("SELECT * FROM `companii_aeriene` WHERE `id_companie` = '".$rCA['id_companie']."'");
	$rC = mysql_fetch_assoc($sC);
	$zbor = $cod_zbor.", ".$rC['denumire'];
	$companie = $rC['id_companie']; 
	$avion = $r['id_avion'];
	$ruta = $r['id_ruta'];
	$data_plecare = date("d/m/Y",$r['data_plecare']);
	$ora_plecare = date("G",$r['data_plecare']);
	$minut_plecare = date("i",$r['data_plecare']);
	$data_sosire = date("d/m/Y",$r['data_sosire']);
	$ora_sosire = date("G",$r['data_plecare']);
	$minut_sosire = date("i",$r['data_plecare']);
	$status = $r['status'];
} 
?>
<?php  

 		if(isset($_POST['add_zbor']) or isset($_POST['edit_zbor'])) {

 			
			if(empty($_POST['cod_zbor'])) $err['cod_zbor'] = $lang['EROARE_COD_ZBOR_EMPTY']; 
 			else if(!is_numeric($_POST['cod_zbor'])) $err['cod_zbor'] = $lang['EROARE_WORNG_COD_ZBOR'];
 			else $cod_zbor = $_POST['cod_zbor'];
			
			if(empty($_POST['companie'])) $err['companie'] = $lang['EROARE_COMPANIE_EMPTY']; 
 			else $companie = $_POST['companie'];
			
			if(empty($_POST['avion'])) $err['avion'] = $lang['EROARE_AVION_EMPTY'];
 			else $avion= $_POST['avion'];

			if(empty($_POST['ruta'])) $err['ruta'] = $lang['EROARE_RUTA_EMPTY'];
 			else $ruta= $_POST['ruta'];
			
			if(empty($_POST['data_plecare']) or strlen($_POST['data_plecare'])!=10) $err['data_plecare'] = "Selectati data.";
			else $data_plecare = $_POST['data_plecare'];
			
			if(empty($_POST['minut_plecare'])) $err['minut_plecare'] = "Selectati minutul.";
			else $minut_plecare = $_POST['minut_plecare'];
			
			if(empty($_POST['ora_plecare'])) $err['ora_plecare'] = "Selectati ora.";
			else $ora_plecare = $_POST['ora_plecare'];
			
			if(empty($_POST['data_sosire']) or strlen($_POST['data_sosire'])!=10) $err['data_sosire'] = "Selectati data.";
			else $data_sosire = $_POST['data_sosire'];
			
			if(empty($_POST['minut_sosire'])) $err['minut_sosire'] = "Selectati minutul.";
			else $minut_sosire = $_POST['minut_sosire'];
			
			if(empty($_POST['ora_sosire'])) $err['ora_sosire'] = "Selectati ora.";
			else $ora_sosire = $_POST['ora_sosire'];
			
			if(isset($_POST['status'])) $status = 1;
 			else $status = 0;
			
			if(isset($data_plecare)) $data_plecare_separat = explode("/",$data_plecare); 
			if(isset($data_sosire)) $data_sosire_separat = explode("/",$data_sosire);
                
			//se foloseste functia mktime() pentru a crea data UNIX care va fi comparata cu cea din baza de date
			if(isset($data_plecare) and isset($data_sosire) and isset($ora_plecare) and isset($ora_sosire) and isset($minut_plecare) and isset($minut_sosire)) { 
			$data_plecareF = mktime($ora_plecare,$minut_plecare,0,$data_plecare_separat[0],$data_plecare_separat[1],$data_plecare_separat[2]); 
			$data_sosireF = mktime($ora_sosire,$minut_sosire,0,$data_sosire_separat[0],$data_sosire_separat[1],$data_sosire_separat[2]); 
			}
			
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_zbor'])) { 
					
	 				$sql = "INSERT INTO `zboruri` SET ";
	 				$sql .= "`cod_zbor` = '".cinp($cod_zbor)."',";
					$sql .= "`id_avion` = '".cinp($avion)."',";
					$sql .= "`id_ruta` = '".cinp($ruta)."',";
					$sql .= "`data_plecare` = '".cinp($data_plecareF)."',";
					$sql .= "`data_sosire` = '".cinp($data_sosireF)."',";
					$sql .= "`status` = '".cinp($status)."'";

					$query = mysql_query($sql);
	 				echo $query;
	 				if($query) { 
						header("Location: zboruri.php?show=succes");
						unset($cod_zbor,$companie,$avion,$ruta,$status,$data_plecare,$data_sosire,$minut_plecare,$minut_sosire,$ora_plecare,$ora_sosire); 
					} 
				}

				if(isset($_POST['edit_zbor'])) { 
				
	 				$sql = "UPDATE `zboruri` SET ";
	 				$sql .= "`cod_zbor` = '".cinp($cod_zbor)."',";
					$sql .= "`id_avion` = '".cinp($avion)."',";
					$sql .= "`id_ruta` = '".cinp($ruta)."',";
					$sql .= "`data_plecare` = '".cinp($data_plecareF)."',";
					$sql .= "`data_sosire` = '".cinp($data_sosireF)."',";
					$sql .= "`status` = '".cinp($status)."'";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: zboruri.php?id_zbor=".$id_zbor."&show=succes");
						unset($cod_zbor,$companie,$avion,$ruta,$status,$data_plecare,$data_sosire,$minut_plecare,$minut_sosire,$ora_plecare,$ora_sosire); 
					} 
				}

 			}        
 		}    
		
	if(isset($_POST['alege_zbor'])) {
    if(empty($_POST['id_zbor'])) $err['id_zbor'] = "Va rugam alegeti zborul pe care doriti sa il modificati.";
    else {
        header("Location: zboruri.php?id_zbor=".$_POST['id_zbor']);
    }
	}
	
	if(isset($_GET['id_clasa'])) {
			$id_clasa = $_GET['id_clasa'];
			$s = mysql_query("SELECT * FROM `clase` WHERE `id_clasa`='".cinp($id_clasa)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$clasa = $r['clasa'];
		} 
		
	//VALIDAREA FORMULARULUI DE ASOCIERE CLASA
		if(isset($_POST['asociaza_clasa'])) {
			if(empty($_POST['id_clasa'])) $err['id_clasa'] = $lang['EROARE_CLASA_EMPTY']; 
 			else $id_clasa = $_POST['id_clasa'];
			
			if(empty($_POST['pret_clasa'])) $err['pret_clasa'] = $lang['EROARE_PRET_EMPTY']; 
 			else $pret = $_POST['pret_clasa'];
			
			if(empty($_POST['locuri_clasa'])) $err['locuri_clasa'] = $lang['EROARE_LOCURI_EMPTY']; 
 			else $ilocuri = $_POST['locuri_clasa'];
			
 			if(count($err)==0) {
 					$sql = "INSERT INTO `zbor_clasa` SET ";
	 				$sql .= "`id_clasa` = '".cinp($id_clasa)."',";
	 				$sql .= "`id_zbor` = '".cinp($id_zbor)."',";
					$sql .= "`pret_clasa` = '".cinp($pret)."',";
					$sql .= "`nr_locuri` = '".cinp($locuri)."'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?id_companie=".$id_companie."&do=asociaza_meniu&show=succes");
					} 
 			}
		}

		
?>
<?php include_once 'head.php'; ?>
<?php include('header.php'); ?> 


<div class="main_content">
	<div class="wrap">
		<section>
			<?php 
				//DACA SE INTRODUCE UN ZBOR
				if(!isset($_GET['do'])){ 
			?>
			<h1><?php echo $lang['FORMULAR_ZBOR']; ?></h1>
				<form action="" method="post" name="zboruri_form" id="creare_zbor" action="">
 					
 						<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.((isset($id_zbor)) ? $lang['ZBOR_EDIT'] : $lang['ZBOR_ADD']).'</span>'; ?>

 						<div>
 							<?php if(isset($err['cod_zbor'])) echo '<span class="eroare">'.$err['cod_zbor'].'</span>'; ?>
 							<label><?php echo $lang['COD_ZBOR']; ?></label>
 							<input type="text" id="cod_zbor" maxlength="6" value="<?php if(isset($cod_zbor)) echo $cod_zbor;?>"  name="cod_zbor" placeholder="<?php echo $lang['COD_ZBOR']; ?>" autocomplete="off" required="required" />
 						</div>
					
 						<div>
 							<?php if(isset($err['companie'])) echo '<span class="eroare">'.$err['companie'].'</span>'; ?>
 							<label for="companie"><?php echo $lang['COMPANIE']; ?></label>
 							<select id="companie" name="companie" placeholder="<?php echo $lang['COMPANIE']; ?>"  autocomplete="off">
								<option></option>
								<?php 
 								$sql = mysql_query("SELECT * FROM `companii_aeriene`");
									while($rand = mysql_fetch_array($sql)) {
								?>
								<option value="<?php echo $rand['id_companie'];?>" <?php if(isset($companie) and $companie==$rand['id_companie']) echo 'selected'; ?>><?php echo $rand['denumire'];?></option>
								<?php
								}
								?>	
							</select>
 						</div>
						<div>
 							<?php if(isset($err['avion'])) echo '<span class="eroare">'.$err['avion'].'</span>'; ?>
 							<label for="avion"><?php echo $lang['AVION']; ?></label>
 							<select id="avion" name="avion" placeholder="<?php echo $lang['AVION']; ?>"  autocomplete="off">
								<option></option>
								<?php if(isset($id_zbor)) { ?>
									<?php 
									$sql = mysql_query("SELECT `a`.`id_avion`,`a`.`serie`,`ta`.`tip`,`f`.`fabricant` FROM `companie_avioane` AS `ca` 
										INNER JOIN `avioane` AS `a` ON `ca`.`id_avion`=`a`.`id_avion` 
										INNER JOIN `tipuri_avion` AS `ta` ON `a`.`id_tip_avion`=`ta`.`id_tip_avion` 
										INNER JOIN `fabricanti` AS `f` ON `ta`.`id_fabricant`=`f`.`id_fabricant` 
										WHERE `ca`.`id_companie`='".cinp($companie)."'
										");
										while($rand = mysql_fetch_array($sql)) {
									?>
									<option value="<?php echo $rand['id_avion'];?>" <?php if(isset($avion) and $avion==$rand['id_avion']) echo 'selected'; ?>><?php echo $rand['fabricant'].' '.$rand['tip'].' '.$rand['serie'];?></option>
									<?php
									}
									?>
								<?php } ?>
							</select>
 						</div>
						<div>
 							<?php if(isset($err['ruta'])) echo '<span class="eroare">'.$err['ruta'].'</span>'; ?>
 							<label for="ruta"><?php echo $lang['RUTA']; ?></label>
 							<select id="ruta" name="ruta" placeholder="<?php echo $lang['RUTA']; ?>"  autocomplete="off">
								<option></option>
								<?php 
 								$sql = mysql_query("SELECT * FROM `rute`");
									while($rand = mysql_fetch_array($sql)) {
										$sqlP = mysql_query("SELECT * FROM `aeroporturi` WHERE `id_aeroport` ='".$rand['id_aeroport_plecare']."' LIMIT 1");
										echo $sqlP;
										$rP = mysql_fetch_assoc($sqlP);
										$sqlPT = mysql_query("SELECT * FROM `tari` WHERE `id_tara` ='".$rP['id_tara']."' LIMIT 1");
										$rPT = mysql_fetch_assoc($sqlPT);
										$sqlS = mysql_query("SELECT * FROM `aeroporturi` WHERE `id_aeroport` ='".$rand['id_aeroport_sosire']."' LIMIT 1");
										$rS = mysql_fetch_assoc($sqlS);
										$sqlST = mysql_query("SELECT * FROM `tari` WHERE `id_tara` ='".$rS['id_tara']."' LIMIT 1");
										$rST = mysql_fetch_assoc($sqlST);
								
								?>
								<option value="<?php echo $rand['id_ruta'];?>" <?php if(isset($ruta) and $ruta==$rand['id_ruta']) echo 'selected'; ?>><?php echo $rP['denumire'].", ".$rPT['tara']." - ".$rS['denumire'].", ".$rST['tara'];?></option>
								<?php
								}
								?>	
							</select>
 						</div>
						<div>
							<?php if(isset($err['data_plecare'])) echo '<span class="eroare">'.$err['data_plecare'].'</span>'; ?>
							<label>Data plecare</label><br />
							<input type="text" id="data_plecare"name="data_plecare" value="<?php if(isset($data_plecare)) echo $data_plecare;?>" class="date-pick tiny"/>
							<?php if(isset($err['ora_plecare'])) echo '<span class="eroare">'.$err['ora_plecare'].'</span>'; ?>
							<select id="ora_plecare" name="ora_plecare" placeholder="<?php echo $lang['ORA']; ?>"  autocomplete="off" class="tiny ">
								<option></option>
								<?php for($i=0;$i<=23;$i++) {?>
									<option value="<?php echo $i; ?>" <?php if(isset($ora_plecare) and $ora_plecare==$i) echo 'selected';?> ><?php echo $i; ?></option>
								<?php } ?>
							</select>
							<?php if(isset($err['minut_plecare'])) echo '<span class="eroare">'.$err['minut_plecare'].'</span>'; ?>
							<select id="minut_plecare" name="minut_plecare" placeholder="<?php echo $lang['MINUT']; ?>"  autocomplete="off" class="tiny ">
								<option></option>
								<?php for($i=0;$i<=59;$i++) { ?>
									<option value="<?php echo $i; ?>" <?php if(isset($minut_plecare) and $minut_plecare==$i) echo 'selected';?>><?php echo $i; ?></option>
								<?php } ?>
							</select>
						</div>
						<div>
							<?php if(isset($err['data_sosire'])) echo '<span class="eroare">'.$err['data_sosire'].'</span>'; ?>
							<label>Data sosire</label><br /><input type="text" id="data_sosire" name="data_sosire" value="<?php if(isset($data_sosire)) echo $data_sosire;?>" class="date-pick tiny"/>
							<?php if(isset($err['ora_sosire'])) echo '<span class="eroare">'.$err['ora_sosire'].'</span>'; ?>
							<select id="ora_sosire" name="ora_sosire" placeholder="<?php echo $lang['ORA']; ?>"  autocomplete="off" class="tiny ">
								<option></option>
								<?php for($i=0;$i<=23;$i++) { ?>
									<option value="<?php echo $i; ?>" <?php if(isset($ora_sosire) and $ora_sosire==$i) echo 'selected';?> ><?php echo $i; ?></option>
								<?php } ?>
							</select>
							<?php if(isset($err['minut_sosire'])) echo '<span class="eroare">'.$err['minut_sosire'].'</span>'; ?>
							<select id="minut_sosire" name="minut_sosire" placeholder="<?php echo $lang['MINUT']; ?>"  autocomplete="off" class="tiny ">
								<option></option>
								<?php for($i=0;$i<=59;$i++) { ?>
									<option value="<?php echo $i; ?>" <?php if(isset($minut_sosire) and $minut_sosire==$i) echo 'selected';?> ><?php echo $i; ?></option>
								<?php } ?>
							</select>
						</div>
						<?php if(isset($id_zbor)) {?>
							<div>
								<label>Activ</label>
								<input type="checkbox" name="status" value="1" <?php if(isset($status) and $status==0) echo ''; else echo 'checked'; ?> /></td>
							</div>
						<?php } ?>
 						<div>
 							<input type="submit" id="x" name="<?php if(isset($id_zbor)) echo 'edit_zbor'; else echo 'add_zbor'; ?>" value="<?php if(isset($id_zbor)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" />
 						</div>

 					</table>
				</form>
				
				<form name="alegere_zbor" action="" method="post">
    				<label>Selectati zborul pe care doriti sa il modificati:</label><br />
                        <?php if(isset($err['id_zbor'])) echo '<span class="eroare">'.$err['id_zbor'].'</span>'; ?>
    					<select name="id_zbor" id="id_zbor">                            
    						<option value=""></option>		
                            <?php $s = mysql_query("SELECT * FROM `zboruri` ORDER BY `data_plecare` ASC");
                                while($r = mysql_fetch_array($s)) { 
									$sR = mysql_query("SELECT * FROM `rute` WHERE `id_ruta` = '".$r['id_ruta']."'");
									$rR = mysql_fetch_assoc($sR);
									$sAP = mysql_query("SELECT * FROM `aeroporturi` WHERE `id_aeroport` = '".$rR['id_aeroport_plecare']."'");
									$rAP = mysql_fetch_assoc($sAP);
									$sTAP = mysql_query("SELECT * FROM `tari` WHERE `id_tara` = '".$rAP['id_tara']."'");
									$rTAP = mysql_fetch_assoc($sTAP);
									$sAS = mysql_query("SELECT * FROM `aeroporturi` WHERE `id_aeroport` = '".$rR['id_aeroport_sosire']."'");
									$rAS = mysql_fetch_assoc($sAS);
									$sTAS = mysql_query("SELECT * FROM `tari` WHERE `id_tara` = '".$rAS['id_tara']."'");
									$rTAS = mysql_fetch_assoc($sTAS);
									$sA = mysql_query("SELECT * FROM `companie_avioane` WHERE `id_avion`='".$r['id_avion']."'");
									$rA = mysql_fetch_assoc($sA);
									$sC = mysql_query("SELECT * FROM `companii_aeriene` WHERE `id_companie` = '".$rA['id_companie']."'");
									$rC = mysql_fetch_assoc($sC);
                            ?>
                            <option value="<?php echo $r['id_zbor'];?>" <?php if(isset($id_zbor) and $id_zbor ==$r['id_zbor']) echo 'selected'; ?> ><?php echo $r['cod_zbor'].", ".$rAP['denumire'].", ".$rAP['oras'].", ".$rTAP['tara']." - ".$rAS['denumire'].", ".$rAS['oras'].", ".$rTAS['tara']." - ".$rC['denumire'];?></option>		
                            <?php } ?>
    					</select><br/>
                        <input type="submit" name="alege_zbor" value="Alege zbor" />
                </form><br /><br />
				<?php } else { ?>
					<?php if(isset($id_zbor)) { ?>
						
						<?php if($_GET['do']=="asociaza_clasa") { ?>
							<form name="asociere_clasa" action="" method="post">								
								<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.$lang['CLASA_ASOCIERE'].'</span>'; ?>
								<div>
								<label>Selectati clasa de comfort pe care doriti sa o asociati zborului:</label><br />
									<?php if(isset($err['id_clasa'])) echo '<span class="eroare">'.$err['id_clasa'].'</span>'; ?>
									<select name="id_clasa" id="id_clasa">                            
										<option value=""></option>		
										<?php 
										$sZ = mysql_query("SELECT * FROM `zboruri` WHERE `id_zbor`='".$id_zbor."'");
										$rZ = mysql_fetch_assoc($sZ);
										$sC = mysql_query("SELECT `ca`.`denumire`,`ca`.`id_companie` FROM `companii_aeriene` AS `ca` INNER JOIN `companie_avioane` AS `c_a` 
														 ON `ca`.`id_companie` = `c_a`.`id_companie` WHERE `c_a`.`id_avion` = '".$rZ['id_avion']."'");
										$rC = mysql_fetch_assoc($sC);
										$s = mysql_query("SELECT `cl`.`clasa`,`cl`.`id_clasa` FROM `companie_clase` AS `cc` INNER JOIN `clase` AS `cl` 
														 ON `cc`.`id_clasa` = `cl`.`id_casa` WHERE `cc`.`id_companie`='".$rC['id_companie']."' ORDER BY `clasa` ASC");
										while($r = mysql_fetch_array($s)) { 
												if(mysql_num_rows(mysql_query("SELECT `id_clasa` FROM `companie_clase` WHERE `id_clasa`='".$r['id_clasa']."' AND `id_companie`='".$rC['id_companie']."' LIMIT 1"))==0) {
										?>
										<option value="<?php echo $r['id_clasa'];?>" <?php if(isset($id_clasa) and $id_clasa ==$r['id_clasa']) echo 'selected'; ?> ><?php echo $r['clasa'];?></option>		
										<?php 	} 
											} ?>
									</select><br/>
								</div>
								<div>
									<?php if(isset($err['pret_clasa'])) echo '<span class="eroare">'.$err['pret_clasa'].'</span>'; ?>
									<label><?php echo $lang['CLASA']; ?></label>
									<input type="text" id="pret_clasa" maxlength="6" value="<?php if(isset($pret_clasa)) echo $pret_clasa;?>"  name="pret_clasa" placeholder="<?php echo $lang['CLASA']; ?>" autocomplete="off" required="required" />
								</div>
								<div>
									<?php if(isset($err['locuri_clasa'])) echo '<span class="eroare">'.$err['locuri_clasa'].'</span>'; ?>
									<label><?php echo $lang['LOCURI']; ?></label>
									<input type="text" id="locuri_clasa" maxlength="6" value="<?php if(isset($locuri_clasa)) echo $locuri_clasa;?>"  name="locuri_clasa" placeholder="<?php echo $lang['CLASA']; ?>" autocomplete="off" required="required" />
								</div>
								<div>
									<input type="submit" name="asociaza_clasa" value="Asociaza clasa" />
								</div>
							</form><br /><br />
						
							<div class="rezultate_existente">

							<h3>Clase asociate zborului <?php echo $zbor; ?></h3>
							<table>
								<tr class="table_head"><td>Clasa</td><td>Adaugari</td><td>Operatiuni</td><td>Status</td></td>
								<?php 
									$s_clasa = mysql_query("SELECT `cl`.`clasa`, `cc`.`id_companie_clasa`,`cc`.`status`, FROM `zboruri` AS `zb` INNER JOIN `companie_avioane` AS `ca` ON `ca`.`id_avion` = `zb`.`id_avion`'
											 INNER JOIN `companii_aeriene` AS `c_a` ON `c_a`.`id_companie` = `ca`.`id_companie` 
											 INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_companie` = `c_a`.`id_companie`
											 INNER JOIN `clase` AS `cl` ON `cc`.`id_clasa` = `c.a`.`id_clasa`
											 WHERE `zb`.`id_zbor`='".cinp($id_zbor)."'");
											 
									$s = mysql_query("SELECT `cl`.`clasa`,`cl`.`status`,`zc`.`id_zbor_clasa`,`cc`.`id_companie_clasa` FROM `zbor_clasa` AS `zc` INNER JOIN `zboruri` AS `zb` ON `zc`.`id_zbor` = `zb`.`id_zbor`
													  INNER JOIN `companie_clase` AS `cc` ON `cc`.`id_clasa` = `zc`.`id_clasa` 
													  INNER JOIN `clase` AS `cl` ON `cl`.`id_clasa` = `cc`.`id_clasa`
													  WHERE `zb`.`id_zbor` = '".cinp($id_zbor)."' LIMIT 1");
									while($r_clasa = mysql_fetch_array($s)) { 
										echo '<tr>';
											echo '<td>'.$r_clasa['clasa'].'</td>';
											echo '<td><a href="zboruri.php?id_zbor='.$id_zbor.'&amp;id_zbor_clasa='.$r_class['id_zbor_clasa'].'&amp;do=asociaza_bagaj">Adauga bagaje</a><br/>
												<a href="zboruri.php?id_zbor='.$id_zbor.'&amp;id_zbor_clasa='.$r_class['id_zbor_clasa'].'&amp;do=asociaza_meniu">Adauga meniuri</a><br/>
												<a href="zboruri.php?id_zbor='.$id_zbor.'&amp;id_zbor_clasa='.$r_class['id_zbor_clasa'].'&amp;do=asociaza_reduceri">Adauga reduceri</a><br/>
												</td>';
											echo '<td><a href="....">Editeaza</a><a href="...&do=sterge_asociere">Sterge</a></td>';
											echo '<td><a href="zboruri.php?id_zbor='.$id_zbor.'&amp;do=asociaza_clasa&amp;id_companie_clasa='.$r_clasa['id_companie_clasa'].'&amp;status='.(($r_clasa['status']==1) ? "0" : "1").'">'.(($r_clasa['status']==1) ? "activ" : "inactiv").'</a></td>';
										echo '</tr>';
									} 
								?>
							</table>
							</div>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</aside>
				<aside>
				<?php if(isset($id_zbor)) { ?>
				<span class="clear"></span>
					<ul class="admin_submenu"> 
					<li><a href="zboruri.php?id_zbor=<?php echo $id_zbor;?>&amp;do=asociaza_clasa">Asociaza clase de comfort zborului</a></li>
					</ul>
				<span class="clear"></span>
				<?php } ?>

			</aside>
	</div>
	
</div>
<?php include('footer.php'); ?> 