<?php require_once("config.php");?>
 <?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user']) or $_SESSION['tip_user']!="admin") header("Location: cont.php");
?>


<?php 
if(isset($_GET['id_avion'])) {
	$id_avion = $_GET['id_avion'];
	$s = mysql_query("SELECT * FROM `companii` WHERE `id_avion`='".cinp($id_avion)."' LIMIT 1");
    $r = mysql_fetch_assoc($s);
	$serie = $r['serie'];
	$capacitate = $r['capacitate'];
	$tip_avion = $r['id_tip'];
} 
?>

 <?php  

 		if(isset($_POST['add_avion']) or isset($_POST['edit_avion'])){

 			
			if(empty($_POST['serie'])) $err['serie'] = $lang['EROARE_SERIE_EMPTY']; 
 			else if(!empty($_POST['serie']) && !preg_match("/^[a-z0-9.]/i",$_POST['serie'])) $err['serie'] = $lang['EROARE_WORNG_SERIE'];
 			else $serie = $_POST['serie'];
			
			if(empty($_POST['capacitate'])) $err['capacitate'] = $lang['EROARE_CAPACITATE_EMPTY']; 
			elseif(!is_numeric($_POST['capacitate'])) $err['capacitate'] = $lang['EROARE_WORNG_CAPACITATE'];
 			else $capacitate = $_POST['capacitate'];
			
			if(empty($_POST['tip_avion'])) $err['tip_avion'] = $lang['EROARE_TIP_AVION_EMPTY'];
 			else $tip_avion= $_POST['tip_avion'];

			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_avion'])) { 
				
	 				$sql = "INSERT INTO `avioane` SET ";
	 				$sql .= "`id_tip` = '".cinp($tip_avion)."',";
					$sql .= "`capacitate` = '".cinp($capacitate)."',";
					$sql .= "`serie` = '".cinp($serie)."'";

	 	
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: avioane.php?show=succes");
						unset($tip_avion,$capacitate,$serie); 
					} 
				}

				if(isset($_POST['edit_avion'])) { 
				
	 				$sql = "UPDATE `avioane` SET ";
	 				$sql .= "`id_tip` = '".cinp($tip_avion)."',";
					$sql .= "`capacitate` = '".cinp($capacitate)."',";
					$sql .= "`serie` = '".cinp($serie)."'";
	 				$sql .= " WHERE `id_avion` = '".cinp($id_avion)."' LIMIT 1";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: avioane.php?id_avion=".$id_avion."&show=succes");
						unset($tip_avion,$capacitate,$serie); 
					} 
				}

 			}        
 		}    
		

	if(isset($_POST['alege_avion'])) {
    if(empty($_POST['id_avion'])) $err['id_avion'] = "Va rugam avionul pe care doriti sa il modificati.";
    else {
        header("Location: avioane.php?id_avion=".$_POST['id_avion']);
    }
}
		//VALIDAREA FORMULARULUI DE INTRODUCERE TIP AVION NOU/ sau de editare
		
		if(isset($_GET['id_tip'])) {
			$id_tip = $_GET['id_tip'];
			$s = mysql_query("SELECT * FROM `tipuri_avion` WHERE `id_tip_avion`='".cinp($id_tip)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$tip = $r['tip'];
			$fabricant = $r['id_fabricant'];

		} 

 		if(isset($_POST['add_tip']) or isset($_POST['edit_tip'])){

 			
			if(empty($_POST['tip'])) $err['tip'] = $lang['EROARE_TIP_AVION_EMPTY']; 
 			else $tip = $_POST['tip'];
			
			if(empty($_POST['fabricant'])) $err['fabricant'] = $lang['EROARE_FABRICANT_EMPTY']; 
 			else $fabricant = $_POST['fabricant'];
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_meniu'])) { 
				
	 				$sql = "INSERT INTO `tipuri_avion` SET ";
	 				$sql .= "`id_fabricant` = '".cinp($fabricant)."',";
	 				$sql .= "`tip` = '".cinp($tip)."'";
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: avioane.php?id_avion=".$id_avion."&amp;do=adauga_tip?show=succes");
						unset($tip,$fabricant); 
					} 
				}

				if(isset($_POST['edit_tip'])) { 
				
	 				$sql = "UPDATE `tipuri_avion` SET ";
	 				$sql .= "`id_fabricant` = '".cinp($fabricant)."',";
	 				$sql .= "`tip` = '".cinp($tip)."'";
	 				$sql .= " WHERE `id_tip_avion` = '".cinp($id_tip)."' LIMIT 1";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: avioane.php?id_avion=".$id_avion."&amp;do=edit_tip?show=succes");
						unset($tip,$fabricant); 
					} 
				}					

 			}        
 		}    
		
		     
	//Formular de selectare a tipului de avion de modificat
	if(isset($_POST['alege_tip'])) {
    if(empty($_POST['id_tip'])) $err['id_tip'] = "Va rugam alegeti tipul de avion.";
    else {
        header("Location: avioane.php?id_tip=".$_POST['id_tip']);
    }
}

		//VALIDAREA FORMULARULUI DE ASOCIERE TIP
		
		

		

 ?>
 
 
<?php include_once 'head.php'; ?>
<?php include('header.php'); ?> 


	<div class="main_content">
		<div class="wrap">
			<section>
				<?php 
				//DACA SE INTRODUCE AVION
				if(!isset($_GET['do'])){ 
				?>
				<h1><?php echo $lang['FORMULAR_AVION']; ?></h1>
				
				<form action="" method="post" name="avioane_form" id="creare_avioane" action="">
 					
 						<?php if(isset($succes)) echo '<span class="succes">'.$succes.'</span>'; ?>
						<?php if(isset($err['serie'])) echo '<span class="eroare">'.$err['serie'].'</span>'; ?>
 						<div>
 							<?php if(isset($err['serie'])) echo '<span class="eroare">'.$err['serie'].'</span>'; ?>
 							<label><?php echo $lang['SERIE']; ?></label>
 							<input type="textarea" id="serie" value="<?php if(isset($serie)) echo $serie;?>"  name="serie" placeholder="<?php echo $lang['SERIE']; ?>" autocomplete="off" required="required" />
 						</div>
						<?php if(isset($err['capacitate'])) echo '<span class="eroare">'.$err['capacitate'].'</span>'; ?>
 						<div>
 							<?php if(isset($err['capacitate'])) echo '<span class="eroare">'.$err['capacitate'].'</span>'; ?>
 							<label><?php echo $lang['CAPACITATE']; ?></label>
 							<input type="textarea" id="capacitate" value="<?php if(isset($capacitate)) echo $capacitate;?>"  name="capacitate" placeholder="<?php echo $lang['CAPACITATE']; ?>" autocomplete="off" required="required" />
 						</div>
						<div>
							<?php if(isset($err['tip_avion'])) echo '<span class="eroare">'.$err['tip_avion'].'</span>'; ?>
							<label><?php echo $lang['TIP_AVION']; ?></label>
							<select id="tip_avion" name="tip_avion" placeholder="<?php echo $lang['TIP']; ?>"  autocomplete="off">
								<option></option>
								<?php 
 								$sql = mysql_query("SELECT * FROM `tipuri_avion`");
									while($rand = mysql_fetch_array($sql)) {
									
									$sqlF = mysql_query("SELECT * FROM  `fabricanti` WHERE `id_fabricant` = '".$rand['id_fabricant']."' LIMIT 1");
									$rF = mysql_fetch_assoc($sqlF);
								?>
								<option value="<?php echo $rand['id_tip_avion'];?>" <?php if(isset($tip_avion) and $tip_avion==$rand['id_tip_avion']) echo 'selected'; ?>><?php echo $rF['fabricant']," - ".$rand['tip'] ;?></option>
								<?php
								}
								?>	
							</select>
 						</div>
 						<div>
 							<input type="submit" id="x" name="<?php if(isset($id_avion)) echo 'edit_avion'; else echo 'add_avion'; ?>" value="<?php if(isset($id_avion)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" />
 						</div>

 					</table>
				</form>
				
				<?php if(isset($id_avion)) { ?>
					<a href="avioane.php?id_avion=<?php echo $id_avion;?>&amp;do=adauga_tip">Adaugat un nou tip de avion</a>
					<a href="avioane.php?id_avion=<?php echo $id_avion;?>&amp;do=asociaza_tip">Asociaza tipul de avion avionului</a>
				<?php } ?>
				
				<form name="alegere_avion" action="" method="post">
    				<label>Selectati avionul pe care doriti sa il modificati:</label><br />
                        <?php if(isset($err['id_avion'])) echo '<span class="eroare">'.$err['id_avion'].'</span>'; ?>
    					<select name="id_avion" id="id_avion">                            
    						<option value=""></option>		
                            <?php $s = mysql_query("SELECT * FROM `avioane` ORDER BY `id_avion` ASC");
                                while($r = mysql_fetch_array($s)) { 
									$sqlT = mysql_query("SELECT * FROM  `tipuri_avion` WHERE `id_tip_avion` = '".$rand['id_tip']."' LIMIT 1");
									$rT = mysql_fetch_assoc($sqlT);
									$sqlF = mysql_query("SELECT * FROM `fabricanti` WHERE `id_fabricant`= '".$rt['id_fabricant']."' LIMIT 1");
									$rF = mysql_fetch_assoc($sqlF);
                            ?>
                            <option value="<?php echo $r['id_avion'];?>" <?php if(isset($id_avion) and $id_avion =$r['id_avion']) echo 'selected'; ?> ><?php echo $rF['fabricant']." - ".$rT['tip'].",".$r['serie'];?></option>		
                            <?php } ?>
    					</select><br/>
                        <input type="submit" name="alege_avion" value="Alege avion" />
                </form><br /><br />
				<?php } else { ?>
					<?php if(isset($id_avion)) { ?>
						<?php if($_GET['do']=="adauga_tip") { ?>
						
							<!-- Formular pentru introducerea sau modificarea tipurilor de avioane-->
							<h1><?php echo $lang['FORMULAR_TIP_AVION']; ?></h1>
							<form action="" method="post" name="tip_avion_form" id="creare_tip_avion" action="">
								
									<?php if(isset($succes)) echo '<span class="succes">'.$succes.'</span>'; ?>
									<?php if(isset($err['tip_avion'])) echo '<span class="eroare">'.$err['tip_avion'].'</span>'; ?>
									<div>
										<?php if(isset($err['tip_avion'])) echo '<span class="eroare">'.$err['tip_avion'].'</span>'; ?>
										<label><?php echo $lang['TIP_AVION']; ?></label>
										<input type="text" id="tip_avion" value="<?php if(isset($tip_avion)) echo $tip_avion;?>"  name="tip_avion" placeholder="<?php echo $lang['TIP_AVION']; ?>" autocomplete="off" required="required" />
									</div>
									<div>
									<select name="id_fabricant" id="id_fabricant">                            
										<option value=""></option>		
										<?php $s = mysql_query("SELECT * FROM `fabricanti` ORDER BY `fabricant` ASC");
											while($r = mysql_fetch_array($s)) { 
												
										?>
										<option value="<?php echo $r['id_fabricant'];?>" <?php if(isset($id_fabricant) and $id_fabricant =$r['id_fabricant']) echo 'selected'; ?> ><?php echo $r['fabricant'];?></option>		
										<?php } ?>
									</select><br/>
									</div>
									<div>
										<input type="submit" id="x" name="<?php if(isset($id_tip)) echo 'edit_tip'; else echo 'add_tip'; ?>" value="<?php if(isset($id_tip)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" />
									</div>

								</table>
							</form>
							
							<form name="alegere_tip" action="" method="post">
								<label>Selectati tipul de avion pe care doriti sa il modificati:</label><br />
									<?php if(isset($err['id_tip'])) echo '<span class="eroare">'.$err['id_tip'].'</span>'; ?>
									<select name="id_tip" id="id_tip">                            
										<option value=""></option>		
										<?php $s = mysql_query("SELECT * FROM `tipuri_avion` ORDER BY `tip` ASC");
											while($r = mysql_fetch_array($s)) { 
												$sqlT = mysql_query("SELECT * FROM  `fabricanti` WHERE `id_fabricant` = '".$r['id_tip_avion']."' LIMIT 1");
												$rT = mysql_fetch_assoc($sqlT);
										?>
										<option value="<?php echo $r['id_tip_avion'];?>" <?php if(isset($id_tip_avion) and $id_tip_avion =$r['id_tip_avion']) echo 'selected'; ?> ><?php echo $r['tip'].", ".$rT['fabricant'];?></option>		
										<?php } ?>
									</select><br/>
									<input type="submit" name="alege_tip" value="Alege tip" />
							</form><br /><br />
						<?php } elseif($_GET['do']=="asociaza_tip") { ?>
							<form name="asociere_tip" action="" method="post">
								<label>Selectati tipul de avion pe care doriti sa il asociati avionului:</label><br />
									<?php if(isset($err['id_tip'])) echo '<span class="eroare">'.$err['id_tip'].'</span>'; ?>
									<select name="id_tip" id="id_tip">                            
										<option value=""></option>		
										<?php $s = mysql_query("SELECT * FROM `tipuri_avion` ORDER BY `tip` ASC");
											while($r = mysql_fetch_array($s)) { 
												$sqlF = mysql_query("SELECT * FROM  `fabricanti` WHERE `id_fabricant` = '".$r['id_tip_avion']."' LIMIT 1");
												$rF = mysql_fetch_assoc($sqlF);
										?>
										<option value="<?php echo $r['id_tip_avion'];?>" <?php if(isset($id_tip_avion) and $id_tip_avion =$r['id_tip_avion']) echo 'selected'; ?> ><?php echo $rF['fabricant']." - ".$r['tip'];?></option>		
										<?php } ?>
									</select><br/>
									<input type="submit" name="asociaza_tipul" value="Asociaza tipul" />
							</form><br /><br />
								<!--  
									...... 
									......
								-->
						<?php } ?>
					<?php } ?>
				<?php } ?>
				
			</section>
			<aside>
			</aside>
		</div>
	</div>

<?php include('footer.php'); ?> 