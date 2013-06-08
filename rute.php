<?php require_once('config.php');?>
<?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user']) or $_SESSION['tip_user']!="admin") header("Location: cont.php");
?>


<?php 
if(isset($_GET['id_ruta'])) {
	$id_ruta = $_GET['id_ruta'];
	$s = mysql_query("SELECT * FROM `rute` WHERE `id_ruta`='".cinp($id_ruta)."' LIMIT 1");
    $r = mysql_fetch_assoc($s);
	$aeroport_sosire = $r['id_aeroport_sosire'];
	$aeroport_plecare = $r['id_aeroport_plecare'];
} 
?>

 <?php  

 		if(isset($_POST['add_ruta']) or isset($_POST['edit_ruta'])){

 			if(empty($_POST['aeroport_plecare'])) $err['aeroport_plecare'] = $lang['EROARE_AEROPORT_EMPTY']; 
 			else if(!empty($_POST['aeroport_plecare']) && !preg_match("/^[a-z 0-9.]/i",$_POST['aeroport_plecare'])) $err['aeroport_plecare'] = $lang['EROARE_WORNG_AEROPORT'];
 			else $aeroport_plecare = $_POST['aeroport_plecare'];
			
			if(empty($_POST['aeroport_sosire'])) $err['aeroport_sosire'] = $lang['EROARE_AEROPORT_EMPTY']; 
 			else if(!empty($_POST['aeroport_sosire']) && !preg_match("/^[a-z 0-9.]/i",$_POST['aeroport_sosire'])) $err['aeroport_sosire'] = $lang['EROARE_WORNG_AEROPORT'];
 			else $aeroport_sosire = $_POST['aeroport_sosire'];
			
			if($_POST['aeroport_plecare'] == $_POST['aeroport_sosire']) $err['aeroport_sosire'] = $lang['EROARE_AEROPORT_SAME'];
			else {
					$aeroport_plecare = $_POST['aeroport_plecare'];
					$aeroport_sosire = $_POST['aeroport_sosire'];
			}
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_ruta'])) { 
				
					
	 				$sql = "INSERT INTO `rute` SET ";
	 				$sql .= "`id_aeroport_plecare`='".cinp($aeroport_plecare)."',";
	 				$sql .= "`id_aeroport_sosire` = '".cinp($aeroport_sosire)."'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: rute.php?show=succes");
						unset($aeroport_plecare, $aeroport_sosire); 
					} 
				}

				if(isset($_POST['edit_ruta'])) { 
				
	 				$sql = "UPDATE `rute` SET ";
	 				$sql .= "`id_aeroport_plecare`='".cinp($aeroport_plecare)."',";
	 				$sql .= "`id_aeroport_sosire` = '".cinp($aeroport_sosire)."'";
	 				$sql .= " WHERE `id_ruta` = '".cinp($id_ruta)."' LIMIT 1";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: rute.php?id_ruta=".$id_ruta."&show=succes");
						unset($aeroport_plecare, $aeroport_sosire); 
					} 
				}

 			}        
 		}    
		
		     
		
	if(isset($_POST['alege_ruta'])) {
    if(empty($_POST['id_ruta'])) $err['id_ruta'] = "Va rugam alegeti ruta.";
    else {
        header("Location: rute.php?id_ruta=".$_POST['id_ruta']);
    }
}

 ?>
<?php include('head.php'); ?>
<?php include('header.php'); ?> 
		
	
	<div class="main_content">
		<div class="wrap">
			<div class="leftmenu">
				<ul>
					<li><a href="rute.php?pagina=adaugare_ruta">Adaugare Aeroport</a></li>
					<li><a href="rute.php?pagina=edit_ruta">Modificare Aeroport</a></li>
				</ul>
			</div><!-- leftmenu -->
				<form action="" method="post" name="add_rute_form" id="add_rute" action="">
 					<table cellpadding="0" cellspacing="0" border="0" class="add_ruta">
 						<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.((isset($id_ruta)) ? $lang['RUTA_EDIT'] : $lang['RUTE_ADD']).'</span>'; ?>
 						<?php if(isset($err['aeroport_plecare'])) echo '<span class="eroare">'.$err['aeroport_plecare'].'</span>'; ?>
						
						
						<tr>
 							<td class="form-input-name"><?php echo $lang['AEROPORT']; ?></td>
 							<td class="input">
								 <select name="aeroport_plecare" id="aeroport_plecare">                            
									<option></option>		
									<?php $s = mysql_query("SELECT * FROM `aeroporturi` ORDER BY `oras` ASC, `cod_iata` ASC");
										while($r = mysql_fetch_array($s)) { 
									?>
									<option value="<?php echo $r['id_aeroport'];?>" <?php if(isset($id_aeroport) and $id_aeroport =$r['id_aeroport']) echo 'selected'; ?>><?php echo $r['denumire'].' '.$r['oras'].' ('.$r['cod_iata'].')';?></option>		
									<?php } ?>
								</select><br/>
							</td>
 							<td class=""><span id="aeroport_plecare1"></span></td>
 						</tr>
						<?php if(isset($err['aeroport_sosire'])) echo '<span class="eroare">'.$err['aeroport_sosire'].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['AEROPORT']; ?></td>
 							<td class="input">
								 <select name="aeroport_sosire" id="aeroport_sosire">                            
									<option value=""></option>		
									<?php $s = mysql_query("SELECT * FROM `aeroporturi` ORDER BY `oras` ASC, `cod_iata` ASC");
										while($r = mysql_fetch_array($s)) { 
									?>
									<option value="<?php echo $r['id_aeroport'];?>" <?php if(isset($id_aeroport) and $id_aeroport =$r['id_aeroport']) echo 'selected'; ?> ><?php echo $r['denumire'].' '.$r['oras'].' ('.$r['cod_iata'].')';?></option>		
									<?php } ?>
								</select><br/>
							</td>
 							<td class=""><span id="aeroport_sosire1"></span></td>
 						</tr>
 						<tr>
 							<td class="form-input-name"></td>
 							<td><input type="submit" id="x" name="<?php if(isset($id_ruta)) echo 'edit_ruta'; else echo 'add_ruta'; ?>" value="<?php if(isset($id_ruta)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" /></td>
 						</tr>
 					</table>
				</form>
				

				<form name="alegere_ruta" action="" method="post">
    				<label>Selectati ruta pe care doriti sa o modificati:</label><br />
                        <?php if(isset($err['id_ruta'])) echo '<span class="eroare">'.$err['id_ruta'].'</span>'; ?>
    					<select name="id_ruta" id="id_ruta">                            
    						<option value=""></option>		
                            <?php $s = mysql_query("SELECT * FROM `rute`");
                                while($r = mysql_fetch_array($s)) { 
									$aer_plecare = $r['id_aeroport_plecare'];
									$aer_sosire = $r['id_aeroport_sosire'];
									$sqp = mysql_query("SELECT `denumire`,`oras` FROM `aeroporturi` WHERE `id_aeroport` = '".$aer_plecare."' LIMIT 1");
									$sqs = mysql_query("SELECT `denumire`,`oras` FROM `aeroporturi` WHERE `id_aeroport` = '".$aer_sosire."' LIMIT 1");
									$rp = mysql_fetch_assoc($sqp);
									$rs = mysql_fetch_assoc($sqs);
									echo $rp;
									echo $rs;
                            ?>
                            <option value="<?php echo $r['id_ruta'];?>" <?php if(isset($id_ruta) and $id_ruta =$r['id_ruta']) echo 'selected'; ?> ><?php echo $rp['denumire'].','.$rp['oras'].' - '.$rs['denumire'].', '.$rs['oras'];?></option>		
                            <?php } ?>
    					</select><br/>
                        <input type="submit" name="alege_ruta" value="Alege ruta" />

                </form><br /><br />
                
			</section>
			<aside>
			</aside>
		</div>
	</div>

<?php include('footer.php'); ?> 