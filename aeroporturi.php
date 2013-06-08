<?php require_once('config.php');?>
<?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user']) or $_SESSION['tip_user']!="admin") header("Location: cont.php");
?>


<?php 
if(isset($_GET['id_aeroport'])) {
	$id_aeroport = $_GET['id_aeroport'];
	$s = mysql_query("SELECT * FROM `aeroporturi` WHERE `id_aeroport`='".cinp($id_aeroport)."' LIMIT 1");
    $r = mysql_fetch_assoc($s);
	$aeroport = $r['denumire'];
	$codIATA = $r['cod_iata'];
	$oras = $r['oras'];
	$tara = $r['id_tara'];
	$status = $r['status'];
} 
?>

 <?php  

 		if(isset($_POST['add_aeroport']) or isset($_POST['edit_aeroport'])){

 			if(empty($_POST['aeroport'])) $err['aeroport'] = $lang['EROARE_AEROPORT_EMPTY']; 
 			else if(!empty($_POST['aeroport']) && !preg_match("/^[a-z 0-9.]/i",$_POST['aeroport'])) $err['aeroport'] = $lang['EROARE_WORNG_AEROPORT'];
 			else $aeroport = $_POST['aeroport'];

			if(empty($_POST['codIATA'])) $err['codIATA'] = $lang['EROARE_CODIATA_EMPTY'];
 			else if(!empty($_POST['codIATA']) && !preg_match("/^[A-Z]/i",$_POST['codIATA']) or strlen($_POST['codIATA'])!=3) $err['codIATA'] = $lang['EROARE_WORNG_CODIATA'];
 			else $codIATA = $_POST['codIATA'];
 			
 			if(empty($_POST['oras'])) $err['oras'] = $lang['EROARE_ORAS_EMPTY'];
 			else if(!empty($_POST['oras']) && !preg_match("/^[a-z ]/i",$_POST['oras'])) $err['oras'] = $lang['EROARE_WORNG_ORAS'];
 			else $oras = $_POST['oras'];
 			
 			if(empty($_POST['tara'])) $err['tara'] = $lang['EROARE_TARA_EMPTY'];
 			else $tara= $_POST['tara'];

 			if(isset($_POST['status'])) $status = 1;
 			else $status = 0;

			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_aeroport'])) { 
				
	 				$sql = "INSERT INTO `aeroporturi` SET ";
	 				$sql .= "`denumire`='".cinp($aeroport)."',";
	 				$sql .= "`cod_iata` = '".cinp($codIATA)."',";
	 				$sql .= "`oras`='".cinp($oras)."',";
	 				$sql .= "`id_tara`='".cinp($tara)."',";
	 				$sql .= "`status`='".cinp($status)."'";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
	 					header("Location: aeroporturi.php?show=succes");
						unset($aeroport, $codIATA, $oras, $tara, $status); 
					} 
				}

				if(isset($_POST['edit_aeroport'])) { 
				
	 				$sql = "UPDATE `aeroporturi` SET ";
	 				$sql .= "`denumire`='".cinp($aeroport)."',";
	 				$sql .= "`cod_iata` = '".cinp($codIATA)."',";
	 				$sql .= "`oras`='".cinp($oras)."',";
	 				$sql .= "`id_tara`='".cinp($tara)."',";
	 				$sql .= "`status`='".cinp($status)."'";
	 				$sql .= " WHERE `id_aeroport` = '".cinp($id_aeroport)."' LIMIT 1";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: aeroporturi.php?id_aeroport=".$id_aeroport."&show=succes");
					} 
				}

 			}        
 		}    
		
		     
		
	if(isset($_POST['alege_aeroport'])) {
    if(empty($_POST['id_aeroport'])) $err['id_aeroport'] = "Va rugam alegeti aeroportul.";
    else {
        header("Location: aeroporturi.php?id_aeroport=".$_POST['id_aeroport']);
    }
}

 ?>
<?php include('head.php'); ?>
<?php include('header.php'); ?> 
		
	
	<div class="main_content">
		<div class="wrap">
			<div class="leftmenu">
				<ul>
					<li><a href="aeroporturi.php?pagina=adaugare_aeroport">Adaugare Aeroport</a></li>
					<li><a href="aeroporturi.php?pagina=edit_aeroport">Modificare Aeroport</a></li>
				</ul>
			</div><!-- leftmenu -->
				<form action="" method="post" name="add_aeroporturi_form" id="add_aeroport" action="">
 					<table cellpadding="0" cellspacing="0" border="0" class="add_aeroport">
 						<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.((isset($id_aeroport)) ? $lang['AEROPORT_EDIT'] : $lang['AEROPORT_ADD']).'</span>'; ?>
 						<?php if(isset($err['aeroport'])) echo '<span class="eroare">'.$err['aeroport'].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['AEROPORT']; ?></td>
 							<td class="input"><input type="text" id="aeroport" name="aeroport" placeholder="<?php echo $lang['AEROPORT']; ?>" value="<?php if(isset($aeroport)) echo $aeroport;?>" autocomplete="off" required="required" /></td>
 							<td class=""><span id="aeroport1"></span></td>
 						</tr>
 						<?php if(isset($err['codIATA'])) echo '<span class="eroare">'.$err['codIATA'].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['COD_IATA']; ?></td>
 							<td class="input"><input type="text" id="codIATA" maxlength="3" name="codIATA" placeholder="<?php echo $lang['COD_IATA'];?>" value="<?php if(isset($codIATA)) echo $codIATA;?>" autocomplete="off" required="required" /></td>
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
									<option value="<?php echo $rand['id_tara'];?>" <?php if(isset($tara) and $tara==$rand['id_tara']) echo 'selected'; ?>><?php echo $rand['tara'];?></option>
									<?php
									}
									?>	
								</select>	<br/>
 							<td class=""><span id="tara1"></span></td>
 						</tr>
 						<tr>
 							<td class="form-input-name">Activ</td>
 							<td class="input"><input type="checkbox" name="status" value="1" <?php if(isset($status) and $status==0) echo ''; else echo 'checked'; ?> /></td>
 							<td class=""><span id="oras1"></span></td>
 						</tr>
 						<tr>
 							<td class="form-input-name"></td>
 							<td><input type="submit" id="x" name="<?php if(isset($id_aeroport)) echo 'edit_aeroport'; else echo 'add_aeroport'; ?>" value="<?php if(isset($id_aeroport)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" /></td>
 						</tr>
 					</table>
				</form>
				

					<form name="alegere_aeroport" action="" method="post">
    				<label>Selectati aeroportul pe care doriti sa il modificati:</label><br />
                        <?php if(isset($err['id_aeroport'])) echo '<span class="eroare">'.$err['id_aeroport'].'</span>'; ?>
    					<select name="id_aeroport" id="id_aeroport">                            
    						<option value=""></option>		
                            <?php $s = mysql_query("SELECT * FROM `aeroporturi` ORDER BY `oras` ASC, `cod_iata` ASC");
                                while($r = mysql_fetch_array($s)) { 
                            ?>
                            <option value="<?php echo $r['id_aeroport'];?>" <?php if(isset($id_aeroport) and $id_aeroport =$r['id_aeroport']) echo 'selected'; ?> ><?php echo $r['denumire'].' '.$r['oras'].' ('.$r['cod_iata'].')';?></option>		
                            <?php } ?>
    					</select><br/>
                        <input type="submit" name="alege_aeroport" value="Alege Aeroport" />
                    </form><br /><br />
                
			</section>
			<aside>
			</aside>
		</div>
	</div>

<?php include('footer.php'); ?> 