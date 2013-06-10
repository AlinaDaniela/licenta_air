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
	$avion = $r['id_avion'];
	$ruta = $r['id_ruta'];
	$data_plecare = $r['data_plecare'];
	$data_sosire = $r['data_sosire'];
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
			$data_plecareF = mktime($data_plecare_separat[1],$data_plecare_separat[0],$data_plecare_separat[2],$ora_plecare,$minut_plecare,0); 
			$data_sosireF = mktime($data_sosire_separat[1],$data_sosire_separat[0],$data_sosire_separat[2],$ora_sosire,$minut_sosire,0); 
			}
			
			$sql = mysql_query("SELECT * FROM `companii_aeriene` WHERE `id_companie` ='".$companie." '");
			$r = mysql_fetch_assoc($sql);
			$cod_zborF = $r['cod'].$cod_zbor;
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_zbor'])) { 
					
	 				$sql = "INSERT INTO `zboruri` SET ";
	 				$sql .= "`cod_zbor` = '".cinp($cod_zborF)."',";
					$sql .= "`id_avion` = '".cinp($avion)."',";
					$sql .= "`id_ruta` = '".cinp($ruta)."',";
					$sql .= "`data_plecare` = '".cinp($data_plecareF)."',";
					$sql .= "`data_sosire` = '".cinp($data_sosireF)."',";
					$sql .= "`status` = '".cinp($status)."'";

	 				echo $sql;
					$query = mysql_query($sql);
	 				echo $query;
	 				if($query) { 
						header("Location: zboruri.php?show=succes");
						unset($cod_zbor,$companie,$avion,$ruta,$status,$data_plecare,$data_sosire,$minut_plecare,$minut_sosire,$ora_plecare,$ora_sosire); 
					} 
				}

				if(isset($_POST['edit_zbor'])) { 
				
	 				$sql = "UPDATE `companii_aeriene` SET ";
	 				$sql .= "`cod_zbor` = '".cinp($cod_zborF)."',";
					$sql .= "`id_avion` = '".cinp($avion)."',";
					$sql .= "`id_ruta` = '".cinp($ruta)."',";
					$sql .= "`data_plecare` = '".cinp($data_plecare)."',";
					$sql .= "`data_sosire` = '".cinp($data_sosire)."',";
					$sql .= "`status` = '".cinp($status)."' LIMIT 1";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: zboruri.php?id_zbor=".$id_companie."&show=succes");
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
?>
<?php include_once 'head.php'; ?>
<?php include('header.php'); ?> 


<div class="main_content">
	<div class="wrap">
		<section>
			<h1><?php echo $lang['FORMULAR_ZBOR']; ?></h1>
				<form action="" method="post" name="zboruri_form" id="creare_zbor" action="">
 					
 						<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.((isset($id_zbor)) ? $lang['ZBOR_EDIT'] : $lang['ZBOR_ADD']).'</span>'; ?>
 						<?php if(isset($err['cod_zbor'])) echo '<span class="eroare">'.$err['cod_zbor'].'</span>'; ?>
 						<div>
 							<?php if(isset($err['cod_zbor'])) echo '<span class="eroare">'.$err['cod_zbor'].'</span>'; ?>
 							<label><?php echo $lang['COD_ZBOR']; ?></label>
 							<input type="text" id="cod_zbor" maxlength="6" value="<?php if(isset($cod_zbor)) echo $cod_zbor;?>"  name="cod_zbor" placeholder="<?php echo $lang['COD_ZBOR']; ?>" autocomplete="off" required="required" />
 						</div>
					
						<?php if(isset($err['companie'])) echo '<span class="eroare">'.$err['companie'].'</span>'; ?>
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
	</div>
</div>
<?php include('footer.php'); ?> 