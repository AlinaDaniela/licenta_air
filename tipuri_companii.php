<?php require_once("config.php");?>
 <?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user']) or $_SESSION['tip_user']!="admin") header("Location: cont.php");
?>


<?php 
if(isset($_GET['id_tip'])) {
	$id_tip = $_GET['id_tip'];
	$s = mysql_query("SELECT * FROM `tipuri_companii` WHERE `id_tip_companie`='".cinp($id_tip)."' LIMIT 1");
    $r = mysql_fetch_assoc($s);
	$tip = $r['tip'];
} 
?>

 <?php  

 		if(isset($_POST['add_tip']) or isset($_POST['edit_tip'])){

 			
			if(empty($_POST['tip'])) $err['tip'] = $lang['EROARE_TIP_EMPTY']; 
 			else if(!empty($_POST['tip']) && !preg_match("/^[a-z 0-9.]/i",$_POST['tip'])) $err['tip'] = $lang['EROARE_WORNG_TIP'];
 			else $tip = $_POST['tip'];
			
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_tip'])) { 
				
	 				$sql = "INSERT INTO `tipuri_companii` SET ";
	 				$sql .= "`tip` = '".cinp($tip)."'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: tipuri_companii.php?show=succes");
						unset($tip); 
					} 
				}

				if(isset($_POST['edit_tip'])) { 
				
	 				$sql = "UPDATE `tipuri_companii` SET ";
	 				$sql .= "`tip` = '".cinp($tip)."'";
	 				$sql .= " WHERE `id_tip_companie` = '".cinp($id_tip)."' LIMIT 1";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: tipuri_companii.php?id_tip=".$id_tip."&show=succes");
						unset($fabricant); 
					} 
				}

 			}        
 		}    
		
		     
		
	if(isset($_POST['alege_tip'])) {
    if(empty($_POST['id_tip'])) $err['id_tip'] = "Va rugam alegeti tipul de companie aeriana.";
    else {
        header("Location: tipuri_companii.php?id_tip=".$_POST['id_tip']);
    }
}

 ?>
<?php include_once 'head.php'; ?>
<?php include('header.php'); ?> 


	<div class="main_content">
		<div class="wrap">
			<section>
				<h1><?php echo $lang['FORMULAR_TIP']; ?></h1>
				<form action="" method="post" name="tip_form" id="creare_tip" action="">
 					
 						<?php if(isset($succes)) echo '<span class="succes">'.$succes.'</span>'; ?>
 						<?php if(isset($err['tip'])) echo '<span class="eroare">'.$err['tip'].'</span>'; ?>
 						<div>
 							<?php if(isset($err['tip'])) echo '<span class="eroare">'.$err['tip'].'</span>'; ?>
 							<label><?php echo $lang['TIP']; ?></label>
 							<input type="text" id="tip" value="<?php if(isset($tip)) echo $tip;?>"  name="tip" placeholder="<?php echo $lang['TIP']; ?>" autocomplete="off" required="required" />
 						</div>
						
 						<div>
 							<input type="submit" id="x" name="<?php if(isset($id_tip)) echo 'edit_tip'; else echo 'add_tip'; ?>" value="<?php if(isset($id_tip)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" />
 						</div>

 					</table>
				</form>
				
				<form name="alegere_tip" action="" method="post">
    				<label>Selectati tipul de companie pe care doriti sa il modificati:</label><br />
                        <?php if(isset($err['id_tip'])) echo '<span class="eroare">'.$err['id_tip'].'</span>'; ?>
    					<select name="id_tip" id="id_tip">                            
    						<option value=""></option>		
                            <?php $s = mysql_query("SELECT * FROM `tipuri_companii` ORDER BY `tip` ASC");
                                while($r = mysql_fetch_array($s)) { 
                            ?>
                            <option value="<?php echo $r['id_tip_comapnie'];?>" <?php if(isset($id_tip) and $id_fabricant =$r['id_tip_comapnie']) echo 'selected'; ?> ><?php echo $r['tip'];?></option>		
                            <?php } ?>
    					</select><br/>
                        <input type="submit" name="alege_tip" value="Alege tip" />
                </form><br /><br />
			</section>
			<aside>
			</aside>
		</div>
	</div>

<?php include('footer.php'); ?> 