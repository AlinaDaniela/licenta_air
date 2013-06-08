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
 			else if(!empty($_POST['fabricant']) && !preg_match("/^[a-z 0-9.]/i",$_POST['fabricant'])) $err['fabricant'] = $lang['EROARE_WORNG_FABRICANT'];
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

 ?>
<?php include_once 'head.php'; ?>
<?php include('header.php'); ?> 


	<div class="main_content">
		<div class="wrap">
			<section>
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
    				<label>Selectati fabricantul pe care doriti sa il modificati:</label><br />
                        <?php if(isset($err['id_fabricant'])) echo '<span class="eroare">'.$err['id_fabricant'].'</span>'; ?>
    					<select name="id_fabricant" id="id_fabricant">                            
    						<option value=""></option>		
                            <?php $s = mysql_query("SELECT * FROM `fabricanti` ORDER BY `fabricant` ASC");
                                while($r = mysql_fetch_array($s)) { 
                            ?>
                            <option value="<?php echo $r['id_fabricant'];?>" <?php if(isset($id_fabricant) and $id_fabricant =$r['id_fabricant']) echo 'selected'; ?> ><?php echo $r['fabricant'];?></option>		
                            <?php } ?>
    					</select><br/>
                        <input type="submit" name="alege_fabricant" value="Alege fabricant" />
                </form><br /><br />
			</section>
			<aside>
			</aside>
		</div>
	</div>

<?php include('footer.php'); ?> 