<?php require_once("config.php");?>
 <?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user']) or $_SESSION['tip_user']!="admin") header("Location: cont.php");
?>


<?php 
if(isset($_GET['id_avion'])) {
	$id_avion = $_GET['id_avion'];
	$s = mysql_query("SELECT * FROM `avioane` WHERE `id_avion`='".cinp($id_avion)."' LIMIT 1");
    $r = mysql_fetch_assoc($s);
	$serie = $r['serie'];
	$capacitate = $r['capacitate'];
	$tip_avion = $r['id_tip'];
} 
?>

 <?php  

 		if(isset($_POST['add_avion']) or isset($_POST['edit_avion'])){

 			
			if(empty($_POST['serie'])) $err['serie'] = $lang['EROARE_SERIE_EMPTY']; 
 			else if(!empty($_POST['serie']) && !preg_match("/^[a-z0-9.]/i",$_POST['serie'])) $err['serie'] = $lang['EROARE_WRONG_SERIE'];
 			else $serie = $_POST['serie'];
			
			if(empty($_POST['capacitate'])) $err['capacitate'] = $lang['EROARE_CAPACITATE_EMPTY']; 
			elseif(!is_numeric($_POST['capacitate']) OR !is_int($_POST['capacitate']) OR $_POST['capacitate']<=0) $err['capacitate'] = $lang['EROARE_WRONG_CAPACITATE'];
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
    if(empty($_POST['id_avion'])) $err['id_avion'] = $lang['EROARE_SELECT_AVION_MODIFICARE'];
    else {
        header("Location: avioane.php?id_avion=".$_POST['id_avion']);
    }
}
	
		
 ?>
 

<?php include_once 'head.php'; ?>
<?php include('header.php'); ?> 

	<div class="main_content">
		<div class="wrap">
			<section>
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
 							<?php if(isset($err['fabricant'])) echo '<span class="eroare">'.$err['fabricant'].'</span>'; ?>
 							<label for="fabricant"><?php echo $lang['FABRICANT']; ?></label>
 							<select id="fabricant" name="fabricant" placeholder="<?php echo $lang['FABRICANT']; ?>"  autocomplete="off">
								<option></option>
								<?php 
 								$sql = mysql_query("SELECT * FROM `fabricanti`");
									while($rand = mysql_fetch_array($sql)) {
								?>
								<option value="<?php echo $rand['id_fabricant'];?>" <?php if(isset($fabricant) and $fabricant==$rand['id_fabricant']) echo 'selected'; ?>><?php echo $rand['fabricant'];?></option>
								<?php
								}
								?>	
							</select>
 						</div>
						<div>
 							<?php if(isset($err['tip'])) echo '<span class="eroare">'.$err['tip'].'</span>'; ?>
 							<label for="tip"><?php echo $lang['TIP_AVION']; ?></label>
 							<select id="tip" name="tip" placeholder="<?php echo $lang['TIP_AVION']; ?>"  autocomplete="off">
								<option></option>
							</select>
 						</div>
 						<div>
 							<input type="submit" id="x" name="<?php if(isset($id_avion)) echo 'edit_avion'; else echo 'add_avion'; ?>" value="<?php if(isset($id_avion)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" />
 						</div>

 					</table>
				</form>
				
				<form name="alegere_avion" action="" method="post">
    				<label><?php echo $lang['SELECT_THE_AIRPLANE_TO_MODIFY']; ?></label><br />
                        <?php if(isset($err['id_avion'])) echo '<span class="eroare">'.$err['id_avion'].'</span>'; ?>
    					<select name="id_avion" id="id_avion">                            
    						<option value=""></option>		
                            <?php $s = mysql_query("SELECT * FROM `avioane` ORDER BY `id_avion` ASC");
                                while($r = mysql_fetch_array($s)) { 
									$sqlT = mysql_query("SELECT * FROM  `tipuri_avion` WHERE `id_tip_avion` = '".$r['id_tip']."' LIMIT 1");
									$rT = mysql_fetch_assoc($sqlT);
									$sqlF = mysql_query("SELECT * FROM `fabricanti` WHERE `id_fabricant`= '".$rT['id_fabricant']."' LIMIT 1");
									$rF = mysql_fetch_assoc($sqlF);
                            ?>
                            <option value="<?php echo $r['id_avion'];?>" <?php if(isset($id_avion) and $id_avion =$r['id_avion']) echo 'selected'; ?> ><?php echo $rF['fabricant']." - ".$rT['tip'].",".$r['serie'];?></option>		
                            <?php } ?>
    					</select><br/>
                        <input type="submit" name="alege_avion" value="<?php $lang['ALEGE_AVION']; ?>" />
                </form><br /><br />
			</section>
			<aside>
				<?php include('includes/links_admin.php');  ?>
			</aside>
		</div>
	</div>

<?php include('footer.php'); ?> 