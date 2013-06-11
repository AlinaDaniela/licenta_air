<?php require_once("config.php");?>
 <?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user']) or $_SESSION['tip_user']!="admin") header("Location: cont.php");
?>


<?php 
if(isset($_GET['id_fabricant'])) {
	$id_fabricant = $_GET['id_fabricant'];
	$s = mysql_query("SELECT * FROM `fabricanti` WHERE `id_fabricant`='".cinp($id_fabricant)."' LIMIT 1");
    $r = mysql_fetch_assoc($s);
	$fabricant = $r['fabricant'];
} 
?>

 <?php  

 		if(isset($_POST['add_fabricant']) or isset($_POST['edit_fabricant'])){

 			
			if(empty($_POST['fabricant'])) $err['fabricant'] = $lang['EROARE_FABRICANT_EMPTY']; 
 			else if(!empty($_POST['fabricant']) && !preg_match("/^[a-z 0-9.]/i",$_POST['fabricant'])) $err['fabricant'] = $lang['EROARE_WRONG_FABRICANT'];
 			else $fabricant = $_POST['fabricant'];
			
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_fabricant'])) { 
				
	 				$sql = "INSERT INTO `fabricanti` SET ";
	 				$sql .= "`fabricant` = '".cinp($fabricant)."'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: fabricanti_avioane.php?show=succes");
						unset($fabricant); 
					} 
				}

				if(isset($_POST['edit_fabricant'])) { 
				
	 				$sql = "UPDATE `fabricanti` SET ";
	 				$sql .= "`fabricant` = '".cinp($fabricant)."'";
	 				$sql .= " WHERE `id_fabricant` = '".cinp($id_fabricant)."' LIMIT 1";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: fabricanti_avioane.php?id_fabricant=".$id_fabricant."&show=succes");
						unset($fabricant); 
					} 
				}

 			}        
 		}    
		
		     
		
	if(isset($_POST['alege_fabricant'])) {
    if(empty($_POST['id_fabricant'])) $err['id_fabricant'] = "Va rugam alegeti fabricantul.";
    else {
        header("Location: fabricanti_avioane.php?id_fabricant=".$_POST['id_fabricant']);
    }
}
			
	//Formular tipuri avion
	
		if(isset($_GET['id_tip'])) {
			$id_tip = $_GET['id_tip'];
			$s = mysql_query("SELECT * FROM `tipuri_avion` WHERE `id_tip_avion`='".cinp($id_tip)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$id_fabricant = $r['id_fabricant'];
			$tip = $r['tip'];
		} 

 		if(isset($_POST['add_tip']) or isset($_POST['edit_tip'])){

 			
			if(empty($_POST['tip'])) $err['tip'] = $lang['EROARE_TIP_AVION_EMPTY']; 
 			else if(!empty($_POST['tip']) && !preg_match("/^[a-z 0-9.]/i",$_POST['tip'])) $err['tip'] = $lang['EROARE_TIP_AVION_EMPTY'];
 			else $tip = $_POST['tip'];
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_tip'])) { 
				
	 				$sql = "INSERT INTO `tipuri_avion` SET ";
	 				$sql .= "`tip` = '".cinp($tip)."',";
					$sql .= "`id_fabricant` = '".cinp($id_fabricant)."'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
	 					$last_id = mysql_insert_id();
						header("Location: fabricanti_avioane.php?id_fabricant=".$id_fabricant."&do=adauga_tip&id_tip=".$last_id."&show=succes");
						unset($tip); 
					} 
				}
				
				if(isset($_POST['edit_tip'])) { 
					
	 				$sql = "UPDATE `tipuri_avion` SET ";
	 				$sql .= "`tip` = '".cinp($tip)."',";
					$sql .= "`id_fabricant` = '".cinp($id_fabricant)."' ";
	 				$sql .= " WHERE `id_tip_avion` = '".cinp($id_tip)."' LIMIT 1";
	 				echo $sql;
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: fabricanti_avioane.php?id_fabricant=".$id_fabricant."&do=adauga_tip&id_tip=".$id_tip."&show=succes");
						unset($tip); 
					} 
				}					

 			}        
 		}    
		
		     
	//Formular de selectare a tipului de modificat
	if(isset($_POST['alege_tip'])) {
	    if(empty($_POST['id_tip'])) $err['id_tip'] = $lang['ALEGE_TIP_AVION'];
	    else {
	        header("Location: fabricanti_avioane.php?id_fabricant=".$id_fabricant."&do=adauga_tip&id_tip=".$_POST['id_tip']);
	    }
	}
		

 ?>
<?php include_once 'head.php'; ?>
<?php include('header.php'); ?> 


	<div class="main_content">
		<div class="wrap">
			<section>
			<?php if(!isset($_GET['do'])){ 
				?>
				<h1><?php echo $lang['FORMULAR_FABRICANTI']; ?></h1>
				<form action="" method="post" name="fabricant_form" id="creare_fabricant" action="">
 					
 						<?php if(isset($succes)) echo '<span class="succes">'.$succes.'</span>'; ?>
 						<?php if(isset($err['fabricant'])) echo '<span class="eroare">'.$err['fabricant'].'</span>'; ?>
 						<div>
 							<?php if(isset($err['fabricant'])) echo '<span class="eroare">'.$err['fabricant'].'</span>'; ?>
 							<label><?php echo $lang['FABRICANT']; ?></label>
 							<input type="text" id="fabricant" value="<?php if(isset($fabricant)) echo $fabricant;?>"  name="fabricant" placeholder="<?php echo $lang['FABRICANT']; ?>" autocomplete="off" required="required" />
 						</div>
						
 						<div>
 							<input type="submit" id="x" name="<?php if(isset($id_fabricant)) echo 'edit_fabricant'; else echo 'add_fabricant'; ?>" value="<?php if(isset($id_fabricant)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" />
 						</div>

 					</table>
				</form>
				
				<form name="alegere_fabricant" action="" method="post">
    				<label><?php echo $lang['SELECT_FABRICANT_MODIF']; ?></label><br />
                        <?php if(isset($err['id_fabricant'])) echo '<span class="eroare">'.$err['id_fabricant'].'</span>'; ?>
    					<select name="id_fabricant" id="id_fabricant">                            
    						<option value=""></option>		
                            <?php $s = mysql_query("SELECT * FROM `fabricanti` ORDER BY `fabricant` ASC");
                                while($r = mysql_fetch_array($s)) { 
                            ?>
                            <option value="<?php echo $r['id_fabricant'];?>" <?php if(isset($id_fabricant) and $id_fabricant==$r['id_fabricant']) echo 'selected'; ?> ><?php echo $r['fabricant'];?></option>		
                            <?php } ?>
    					</select><br/>
                        <input type="submit" name="alege_fabricant" value="<?php echo $lang['ALEGE_FABRICANT'];?>" />
                </form><br /><br />
				<?php } else { ?>
					<?php if(isset($id_fabricant)) { ?>
						<?php if($_GET['do']=="adauga_tip") { ?>
							<h1><?php echo $lang['FORMULAR_TIP_FABRICANT']; ?></h1>
							<form action="" method="post" name="tip_form" id="creare_tip" action="">
								
									<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.((isset($id_tip)) ? $lang['TIP_AVION_EDIT'] : $lang['TIP_AVION_ADD']).'</span>'; ?>
									<div>
										<?php if(isset($err['tip'])) echo '<span class="eroare">'.$err['tip'].'</span>'; ?>
										<label><?php echo $lang['TIP_AVION']; ?></label>
										<input type="text" id="tip" value="<?php if(isset($tip)) echo $tip;?>"  name="tip" placeholder="<?php echo $lang['TIP_AVION']; ?>" autocomplete="off" required="required" />
									</div>
									
									<div>
										<input type="submit" id="x" name="<?php if(isset($id_tip)) echo 'edit_tip'; else echo 'add_tip'; ?>" value="<?php if(isset($id_tip)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" />
									</div>

								</table>
							</form>
							
							<form name="alegere_tip" action="" method="post">
								<div>
								<label><?php echo $lang['SELECT_TIP_MODIF'];?></label><br />
									<?php if(isset($err['id_tip'])) echo '<span class="eroare">'.$err['id_tip'].'</span>'; ?>
									<select name="id_tip" id="id_tip">                            
										<option value=""></option>		
										<?php $s = mysql_query("SELECT * FROM `tipuri_avion` ORDER BY `tip` ASC");
											while($r = mysql_fetch_array($s)) { 
										?>
										<option value="<?php echo $r['id_tip_avion'];?>" <?php if(isset($id_tip) and $id_tip==$r['id_tip_avion']) echo 'selected'; ?> ><?php echo $r['tip'];?></option>		
										<?php } ?>
									</select><br/>
								</div>
								<div>
									<input type="submit" name="alege_tip" value="<?php echo $lang['ALEGE_TIP_AVION'];?>" />
								</div>
							</form><br /><br />
						

							<div class="rezultate_existente">
							<h3><?php echo $lang['TIPURI_AVION_FABRICANT'];?><?php echo $fabricant; ?></h3>
							<table>
								<tr class="table_head"><td><?php echo $lang['TIP_DE_AVION'];?></td>
								<?php 
									$s_tip = mysql_query("SELECT * FROM `tipuri_avion` WHERE id_fabricant='".cinp($id_fabricant)."'");
									while($r_tip = mysql_fetch_array($s_tip)) {
										echo '<tr>';
											echo '<td>'.$r_tip['tip'].'</td>';
										echo '</tr>';
									} 
								?>
							</table>
							</div>
						<?php } ?>
				<?php } ?>
			<?php } ?>
			</section>
			<aside>
				<?php if(isset($id_fabricant)) { ?>
				<span class="clear"></span>
					<ul class="admin_submenu"> 
					<li><a href="fabricanti_avioane.php?id_fabricant=<?php echo $id_fabricant;?>&amp;do=adauga_tip"><?php echo $lang['ASOCIAZA_TIP_AVION_FABRICANT'];?></a></li>
					</ul>
				<span class="clear"></span>
				<?php } ?>
				<?php include('includes/links_admin.php'); ?>
			</aside>
		</div>
	</div>

<?php include('footer.php'); ?> 