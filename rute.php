<?php require_once('config.php');?>

 <?php  if(isset($_POST['add_aeroport'])){

 			if(empty($_POST['aeroport_plecare'])) $err['aeroport_plecare'] = $lang['EROARE_AEROPORT_EMPTY']; 
 			else if(!empty($_POST['aeroport_plecare']) && !preg_match("/^[a-z 0-9.]/i",$_POST['aeroport_plecare'])) $err['aeroport_plecare'] = $lang['EROARE_WORNG_AEROPORT'];
 			else $aeroport_plecare = $_POST['aeroport_plecare'];

			if(empty($_POST['codIATA'])) $err['codIATA'] = $lang['EROARE_CODIATA_EMPTY'];
 			else if(!empty($_POST['codIATA']) && !preg_match("/^[A-Z]/i",$_POST['codIATA']) or strlen($_POST['codIATA'])!=3) $err['codIATA'] = $lang['EROARE_WORNG_CODIATA'];
 			else $codIATA = $_POST['codIATA'];
 			
 			if(empty($_POST['oras'])) $err['oras'] = $lang['EROARE_ORAS_EMPTY'];
 			else if(!empty($_POST['oras']) && !preg_match("/^[a-z ]/i",$_POST['oras'])) $err['oras'] = $lang['EROARE_WORNG_ORAS'];
 			else $oras = $_POST['oras'];
 			
 			if(empty($_POST['tara'])) $err['tara'] = $lang['EROARE_TARA_EMPTY'];
 			else $tara= $_POST['tara'];

			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
				
					
 				$status = 1;
				
 				$sql = "INSERT INTO `aeroporturi` SET ";
 				$sql .= "`denumire`='".cinp($aeroport)."',";
 				$sql .= "`cod_iata` = '".cinp($codIATA)."',";
 				$sql .= "`oras`='".cinp($oras)."',";
 				$sql .= "`id_tara`='".cinp($tara)."',";
 				$sql .= "`status`='".cinp($status)."'";
 				
 				$query = mysql_query($sql);
 				
 				if($query) { 
					$succes =  $lang['AEROPORT_ADD'];
					unset($aeroport, $codIATA, $oras, $tara, $status); 
				} 

 			}        
 		}    
 ?>
<?php include('head.php'); ?>
<?php include('header.php'); ?> 
		
	
	<div class="main_content">
		<div class="wrap">
				<form action="" method="post" name="add_aeroporturi_form" id="add_aeroport" action="">
 					<table cellpadding="0" cellspacing="0" border="0" class="add_aeroport">
 						<?php if(isset($succes)) echo '<span class="succes">'.$succes.'</span>'; ?>
 						<?php if(isset($err['aeroport'])) echo '<span class="eroare">'.$err['aeroport'].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['AEROPORT']; ?></td>
 							<td class="input"><input type="text" id="aeroport" name="aeroport" placeholder="<?php echo $lang['AEROPORT']; ?>" autocomplete="off" required="required" /></td>
 							<td class=""><span id=aeroport1></span></td>
 						</tr>
 						<?php if(isset($err['codIATA'])) echo '<span class="eroare">'.$err['codIATA'].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['COD_IATA']; ?></td>
 							<td class="input"><input type="text" id="codIATA" maxlength="3" name="codIATA" placeholder="<?php echo $lang['COD_IATA'];?>"; value="<?php if(isset($codIATA)) echo $codIATA;?>" autocomplete="off" required="required" /></td>
 							<td class=""><span id="name1"></span></td>
 						</tr>
 						<?php if(isset($err['oras'])) echo '<span class="eroare">'.$err['oras'].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['ORAS']; ?></td>
 							<td class="input"><input type="text" name="oras"  placeholder="<?php echo $lang['ORAS']; ?>" value="<?php if(isset($oras)) echo $oras;?>" autocomplete="off" /></td>
 							<td class=""><span id="oras1"></span></td>
 						</tr>
						<?php if(isset($err['tara'])) echo '<span class="eroare">'.$err['tara'].'</span>'; ?>
 						<tr>
							<td class="form-input-name"><?php echo $lang['TARA']; ?></td>
							<td class="input">
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
								</select>	<br/>
 							<td class=""><span id="tara1"></span></td>
 						</tr>
 						<tr>
 							<td class="form-input-name"></td>
 							<td><input type="submit" id="x" name="add_aeroport" value="<?php echo $lang['ADAUGA']; ?>" /></td>
 						</tr>
 					</table>
			</section>
			<aside>
			</aside>
		</div>
	</div>

<?php include('footer.php'); ?> 