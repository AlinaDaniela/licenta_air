<?php require_once("config.php");?>
 <?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user']) or $_SESSION['tip_user']!="admin") header("Location: cont.php");
?>


<?php 
if(isset($_GET['id_companie'])) {
	$id_companie = $_GET['id_companie'];
	$s = mysql_query("SELECT * FROM `companii_aeriene` WHERE `id_companie`='".cinp($id_companie)."' LIMIT 1");
    $r = mysql_fetch_assoc($s);
	$denumire = $r['denumire'];
	$cod = $r['cod'];
	$descriere = $r['descriere'];
	$tara = $r['id_tara'];
	$id_tip_companie = $r['id_tip_companie'];
	$status = $r['status'];
} 
?>

 <?php  

 		if(isset($_POST['add_companie']) or isset($_POST['edit_companie'])){

 			
			if(empty($_POST['denumire'])) $err['denumire'] = $lang['EROARE_COMPANIE_EMPTY']; 
 			else if(!empty($_POST['denumire']) && !preg_match("/^[a-z 0-9.]/i",$_POST['denumire'])) $err['denumire'] = $lang['EROARE_WRONG_COMPANIE'];
 			else $denumire = $_POST['denumire'];
			
			if(empty($_POST['cod'])) $err['cod'] = $lang['EROARE_COD_COMPANIE_EMPTY'];
			else if(!empty($_POST['cod']) && (!preg_match("/^[AZ]/i",$_POST['cod']) OR !is_numeric($_POST['cod'])))  $err['cod'] = $lang['EROARE_WRONG_COD_COMPANIE'];
 			else $cod = $_POST['cod'];
			
			if(empty($_POST['descriere'])) $err['descriere'] = $lang['EROARE_DESCRIERE_EMPTY']; 
 			else $descriere = $_POST['descriere'];
			
			if(empty($_POST['tara'])) $err['tara'] = $lang['EROARE_TARA_EMPTY'];
 			else $tara= $_POST['tara'];

			if(empty($_POST['id_tip_companie'])) $err['id_tip_companie'] = $lang['EROARE_TIP_COMPANIE_EMPTY'];
 			else $id_tip_companie= $_POST['id_tip_companie'];
			
 			if(isset($_POST['status'])) $status = 1;
 			else $status = 0;
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_companie'])) { 
				
	 				$sql = "INSERT INTO `companii_aeriene` SET ";
	 				$sql .= "`denumire` = '".cinp($denumire)."',";
					$sql .= "`cod` = '".cinp($cod)."',";
					$sql .= "`descriere` = '".cinp($descriere)."',";
					$sql .= "`id_tara` = '".cinp($tara)."',";
					$sql .= "`id_tip_companie` = '".cinp($id_tip_companie)."',";
					$sql .= "`status` = '".cinp($status)."'";

	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?show=succes");
						unset($denumire,$descriere,$tara,$id_tip_companie,$status); 
					} 
				}

				if(isset($_POST['edit_companie'])) { 
				
	 				$sql = "UPDATE `companii_aeriene` SET ";
	 				$sql .= "`denumire` = '".cinp($denumire)."',";
					$sql .= "`cod` = '".cinp($cod)."',";
					$sql .= "`descriere` = '".cinp($descriere)."',";
					$sql .= "`id_tara` = '".cinp($tara)."',";
					$sql .= "`id_tip_companie` = '".cinp($id_tip_companie)."',";
					$sql .= "`status` = '".cinp($status)."'";
	 				$sql .= " WHERE `id_companie` = '".cinp($id_companie)."' LIMIT 1";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?id_companie=".$id_companie."&show=succes");
						unset($denumire,$descriere,$tara,$tip_companie,$status); 
					} 
				}

 			}        
 		}    
		
 	//ALEGE COMPANIE
	if(isset($_POST['alege_companie'])) {
	    if(empty($_POST['id_companie'])) $err['id_companie'] = $lang['COMPANIE_AERIANA_ALEGE'];
	    else {
	        header("Location: companii.php?id_companie=".$_POST['id_companie']);
	    }
	}


		//VALIDAREA FORMULARULUI DE INTRODUCERE MENIU NOU/ sau de editare		
		if(isset($_GET['id_meniu'])) {
			$id_meniu = $_GET['id_meniu'];
			$s = mysql_query("SELECT * FROM `tipuri_meniu` WHERE `id_meniu`='".cinp($id_meniu)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$meniu = $r['denumire'];
		} 

 		if(isset($_POST['add_meniu']) or isset($_POST['edit_meniu'])){
 			
			if(empty($_POST['meniu'])) $err['meniu'] = $lang['EROARE_MENIU_EMPTY']; 
 			else if(!empty($_POST['meniu']) && !preg_match("/^[a-z 0-9.]/i",$_POST['meniu'])) $err['meniu'] = $lang['EROARE_WRONG_MENIU'];
 			else $meniu = $_POST['meniu'];
			
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_meniu'])) { 
				
	 				$sql = "INSERT INTO `tipuri_meniu` SET ";
	 				$sql .= "`denumire` = '".cinp($meniu)."'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
	 					$last_id = mysql_insert_id();
						header("Location: companii.php?id_companie=".$id_companie."&do=asociaza_meniu&id_meniu=".$last_id);
						unset($meniu); 
					} 
				}

				if(isset($_POST['edit_meniu'])) { 
				
	 				$sql = "UPDATE `tipuri_meniu` SET ";
	 				$sql .= "`denumire` = '".cinp($meniu)."'";
	 				$sql .= " WHERE `id_meniu` = '".cinp($id_meniu)."' LIMIT 1";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?id_companie=".$id_companie."&do=adauga_meniu&id_meniu=".$id_meniu."&show=succes");
						unset($meniu); 
					} 
				}					

 			}        
 		}    
		
		     
		//Formular de selectare a meniului de modificat
		if(isset($_POST['alege_meniu'])) {
		    if(empty($_POST['id_meniu'])) $err['id_meniu'] = $lang['ALEGERE_TIP_MENIU'];
		    else {
		        header("Location: companii.php?id_companie=".$id_companie."&do=adauga_meniu&id_meniu=".$_POST['id_meniu']);
		    }
		}

		//VALIDAREA FORMULARULUI DE ASOCIERE MENIU
		if(isset($_POST['asociaza_meniu'])) {
			if(empty($_POST['id_meniu'])) $err['id_meniu'] = $lang['EROARE_MENIU_EMPTY']; 
 			else $id_meniu = $_POST['id_meniu'];

 			if(count($err)==0) {
 					$sql = "INSERT INTO `meniu_companie` SET ";
	 				$sql .= "`id_companie` = '".cinp($id_companie)."',";
	 				$sql .= "`id_meniu` = '".cinp($id_meniu)."',";
	 				$sql .= "`status` = '1'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?id_companie=".$id_companie."&do=asociaza_meniu&show=succes");
					} 
 			}
		}

		//SCHIMBA STATUS MENIU
		if(isset($_GET['id_meniu_companie']) and isset($_GET['status'])) {
			mysql_query("UPDATE `meniu_companie` SET `status`='".cinp($_GET['status'])."' WHERE `id_meniu_companie`='".cinp($_GET['id_meniu_companie'])."' LIMIT 1");
			header("Location: companii.php?id_companie=".$id_companie."&do=asociaza_meniu");
		}
		
		
	//VALIDAREA FORMULARULUI DE INTRODUCERE BAGAJ NOU/ sau de editare		
		if(isset($_GET['id_tip_bagaj'])) {
			$id_tip_bagaj = $_GET['id_tip_bagaj'];
			$s = mysql_query("SELECT * FROM `tipuri_bagaj` WHERE `id_tip_bagaj`='".cinp($id_tip_bagaj)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$tip_bagaj = $r['tip_bagaj'];
		} 

 		if(isset($_POST['add_tip_bagaj']) or isset($_POST['edit_tip_bagaj'])){
 			
			if(empty($_POST['tip_bagaj'])) $err['tip_bagaj'] = $lang['EROARE_BAGAJ_EMPTY']; 
 			else if(!empty($_POST['tip_bagaj']) && !preg_match("/^[a-z 0-9.]/i",$_POST['tip_bagaj'])) $err['tip_bagaj'] = $lang['EROARE_WRONG_BAGAJ'];
 			else $tip_bagaj = $_POST['tip_bagaj'];
			
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_tip_bagaj'])) { 
				
	 				$sql = "INSERT INTO `tipuri_bagaj` SET ";
	 				$sql .= "`tip_bagaj` = '".cinp($tip_bagaj)."'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
	 					$last_id = mysql_insert_id();
						header("Location: companii.php?id_companie=".$id_companie."&do=asociaza_tip_bagaj&id_tip_bagaj=".$last_id);
						unset($tip_bagaj); 
					} 
				}

				if(isset($_POST['edit_tip_bagaj'])) { 
				
	 				$sql = "UPDATE `tipuri_bagaj` SET ";
	 				$sql .= "`tip_bagaj` = '".cinp($tip_bagaj)."'";
	 				$sql .= " WHERE `id_tip_bagaj` = '".cinp($id_tip_bagaj)."' LIMIT 1";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?id_companie=".$id_companie."&do=adauga_tip_bagaj&id_tip_bagaj=".$id_tip_bagaj."&show=succes");
						unset($tip_bagaj); 
					} 
				}					

 			}        
 		}      
		
		     
		//Formular de selectare a bagajului de modificat
		if(isset($_POST['alege_tip_bagaj'])) {
		    if(empty($_POST['id_tip_bagaj'])) $err['id_tip_bagaj'] = $lang['ALEGERE_TIP_BAGAJ'];
		    else {
		        header("Location: companii.php?id_companie=".$id_companie."&do=adauga_tip_bagaj&id_tip_bagaj=".$_POST['id_tip_bagaj']);
		    }
		}

		//VALIDAREA FORMULARULUI DE ASOCIERE BAGAJ
		if(isset($_POST['asociaza_tip_bagaj'])) {
			if(empty($_POST['id_tip_bagaj'])) $err['id_tip_bagaj'] = $lang['EROARE_BAGAJ_EMPTY']; 
 			else $id_tip_bagaj = $_POST['id_tip_bagaj'];

 			if(count($err)==0) {
 					$sql = "INSERT INTO `bagaje_companie` SET ";
	 				$sql .= "`id_companie` = '".cinp($id_companie)."',";
	 				$sql .= "`id_tip_bagaj` = '".cinp($id_tip_bagaj)."',";
	 				$sql .= "`status` = '1'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?id_companie=".$id_companie."&do=asociaza_tip_bagaj&show=succes");
					} 
 			}
		}

		//SCHIMBA STATUS BAGAJ
		if(isset($_GET['id_bagaje_companie']) and isset($_GET['status'])) {
			mysql_query("UPDATE `bagaje_companie` SET `status`='".cinp($_GET['status'])."' WHERE `id_bagaje_companie`='".cinp($_GET['id_bagaje_companie'])."' LIMIT 1");
			header("Location: companii.php?id_companie=".$id_companie."&do=asociaza_tip_bagaj");
		}



		//VALIDAREA FORMULARULUI DE INTRODUCERE CLASA NOU/ sau de editare		
		if(isset($_GET['id_clasa'])) {
			$id_clasa = $_GET['id_clasa'];
			$s = mysql_query("SELECT * FROM `clase` WHERE `id_clasa`='".cinp($id_clasa)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$clasa = $r['clasa'];
		} 

 		if(isset($_POST['add_clasa']) or isset($_POST['edit_clasa'])){
 			
			if(empty($_POST['clasa'])) $err['clasa'] = $lang['EROARE_CLASA_EMPTY']; 
 			else if(!empty($_POST['clasa']) && !preg_match("/^[a-z 0-9.]/i",$_POST['clasa'])) $err['clasa'] = $lang['EROARE_WRONG_CLASA'];
 			else $clasa = $_POST['clasa'];
			
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_clasa'])) { 
				
	 				$sql = "INSERT INTO `clase` SET ";
	 				$sql .= "`clasa` = '".cinp($clasa)."'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
	 					$last_id = mysql_insert_id();
						header("Location: companii.php?id_companie=".$id_companie."&do=asociaza_clasa&id_clasa=".$last_id);
						unset($clasa); 
					} 
				}

				if(isset($_POST['edit_clasa'])) { 
				
	 				$sql = "UPDATE `clase` SET ";
	 				$sql .= "`clasa` = '".cinp($clasa)."'";
	 				$sql .= " WHERE `id_clasa` = '".cinp($id_clasa)."' LIMIT 1";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?id_companie=".$id_companie."&do=adauga_clasa&id_clasa=".$id_clasa."&show=succes");
						unset($clasa); 
					} 
				}					

 			}        
 		}      
		
		
		     
	//Formular de selectare a clasei de modificat
		if(isset($_POST['alege_clasa'])) {
		    if(empty($_POST['id_clasa'])) $err['id_clasa'] = $lang['ALEGERE_CLASA'];
		    else {
		        header("Location: companii.php?id_companie=".$id_companie."&do=adauga_clasa&id_clasa=".$_POST['id_clasa']);
		    }
		}

		//VALIDAREA FORMULARULUI DE ASOCIERE CLASA
		if(isset($_POST['asociaza_clasa'])) {
			if(empty($_POST['id_clasa'])) $err['id_clasa'] = $lang['EROARE_CLASA_EMPTY']; 
 			else $id_clasa = $_POST['id_clasa'];

 			if(count($err)==0) {
 					$sql = "INSERT INTO `companie_clase` SET ";
	 				$sql .= "`id_companie` = '".cinp($id_companie)."',";
	 				$sql .= "`id_clasa` = '".cinp($id_clasa)."',";
	 				$sql .= "`status` = '1'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?id_companie=".$id_companie."&do=asociaza_clasa&show=succes");
					} 
 			}
		}

		//SCHIMBA STATUS CLASA
		if(isset($_GET['id_companie_clasa']) and isset($_GET['status'])) {
			mysql_query("UPDATE `companie_clase` SET `status`='".cinp($_GET['status'])."' WHERE `id_companie_clasa`='".cinp($_GET['id_companie_clasa'])."' LIMIT 1");
			header("Location: companii.php?id_companie=".$id_companie."&do=asociaza_clasa");
		}




		
	//VALIDAREA FORMULARULUI DE INTRODUCERE CATEGORIE VARSTA NOU/ sau de editare		
		if(isset($_GET['id_categorie_varsta'])) {
			$id_categorie_varsta = $_GET['id_categorie_varsta'];
			$s = mysql_query("SELECT * FROM `categorii_varsta` WHERE `id_categorie_varsta`='".cinp($id_categorie_varsta)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$categorie = $r['categorie'];
		} 

 		if(isset($_POST['add_categorie_varsta']) or isset($_POST['edit_categorie_varsta'])){
 			
			if(empty($_POST['categorie'])) $err['categorie'] = $lang['EROARE_VARSTA_EMPTY']; 
 			else if(!empty($_POST['categorie']) && !preg_match("/^[a-z 0-9.]/i",$_POST['categorie'])) $err['categorie'] = $lang['EROARE_WRONG_VARSTA'];
 			else $categorie = $_POST['categorie'];		
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_categorie_varsta'])) { 
				
	 				$sql = "INSERT INTO `categorii_varsta` SET ";
	 				$sql .= "`categorie` = '".cinp($categorie)."'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
	 					$last_id = mysql_insert_id();
						header("Location: companii.php?id_companie=".$id_companie."&do=asociaza_categorie_varsta&id_categorie_varsta=".$last_id);
						unset($categorie); 
					} 
				}

				if(isset($_POST['edit_categorie_varsta'])) { 
				
	 				$sql = "UPDATE `categorii_varsta` SET ";
	 				$sql .= "`categorie` = '".cinp($categorie)."'";
	 				$sql .= " WHERE `id_categorie_varsta` = '".cinp($id_categorie_varsta)."' LIMIT 1";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?id_companie=".$id_companie."&do=adauga_categorie_varsta&id_categorie_varsta=".$id_categorie_varsta."&show=succes");
						unset($categorie); 
					} 
				}					

 			}        
 		}  
		
		     
	//Formular de selectare a categoriei de varsta de modificat
		if(isset($_POST['alege_categorie_varsta'])) {
		    if(empty($_POST['id_categorie_varsta'])) $err['id_categorie_varsta'] = $lang['ALEGERE_CATEGORIE_VARSTA'];
		    else {
		        header("Location: companii.php?id_companie=".$id_companie."&do=adauga_categorie_varsta&id_categorie_varsta=".$_POST['id_categorie_varsta']);
		    }
		}

		//VALIDAREA FORMULARULUI DE ASOCIERE CATEGORIE VARSTA
		if(isset($_POST['asociaza_categorie_varsta'])) {
			if(empty($_POST['id_categorie_varsta'])) $err['id_categorie_varsta'] = $lang['EROARE_VARSTA_EMPTY']; 
 			else $id_categorie_varsta = $_POST['id_categorie_varsta'];

 			if(count($err)==0) {
 					$sql = "INSERT INTO `companie_reduceri_categorii` SET ";
	 				$sql .= "`id_companie` = '".cinp($id_companie)."',";
	 				$sql .= "`id_categorie_varsta` = '".cinp($id_categorie_varsta)."',";
	 				$sql .= "`status` = '1'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?id_companie=".$id_companie."&do=asociaza_categorie_varsta&show=succes");
					} 
 			}
		}

		//SCHIMBA STATUS CATEGORIE VARSTA
		if(isset($_GET['id_comp_red_cat']) and isset($_GET['status'])) {
			mysql_query("UPDATE `companie_reduceri_categorii` SET `status`='".cinp($_GET['status'])."' WHERE `id_comp_red_cat`='".cinp($_GET['id_comp_red_cat'])."' LIMIT 1");
			header("Location: companii.php?id_companie=".$id_companie."&do=asociaza_categorie_varsta");
		}

	
 ?>
 
 
<?php include_once 'head.php'; ?>
<?php include('header.php'); ?> 


	<div class="main_content">
		<div class="wrap">
			<section>
				<?php 
				//DACA SE INTRODUCE COMPANIE
				if(!isset($_GET['do'])){ 
				?>
				<h1><?php if(isset($id_companie)) echo $lang['FORMULAR_COMPANIE_EDIT']; else echo $lang['FORMULAR_COMPANIE'];?></h1>
				
				<form action="" method="post" name="companie_form" id="creare_companie" action="">
 					
 						<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.((isset($id_companie)) ? $lang['COMPANIE_EDITED'] : $lang['COMPANIE_ADDED']).'</span>'; ?>
 						<?php if(isset($err['denumire'])) echo '<span class="eroare">'.$err['denumire'].'</span>'; ?>
 						<div>
 							<?php if(isset($err['denumire'])) echo '<span class="eroare">'.$err['denumire'].'</span>'; ?>
 							<label><?php echo $lang['COMPANIE']; ?></label>
 							<input type="text" id="denumire" value="<?php if(isset($denumire)) echo $denumire;?>"  name="denumire" placeholder="<?php echo $lang['COMPANIE_PLH']; ?>" autocomplete="off" required="required" />
 						</div>
						<?php if(isset($err['cod'])) echo '<span class="eroare">'.$err['cod'].'</span>'; ?>
 						<div>
 							<?php if(isset($err['cod'])) echo '<span class="eroare">'.$err['cod'].'</span>'; ?>
 							<label><?php echo $lang['COD_COMPANIE']; ?></label>
 							<input type="text" id="cod" value="<?php if(isset($cod)) echo $cod;?>"  name="cod" placeholder="<?php echo $lang['COD_COMPANIE_PLH']; ?>" autocomplete="off" required="required" />
 						</div>
						<?php if(isset($err['descriere'])) echo '<span class="eroare">'.$err['descriere'].'</span>'; ?>
 						<div>
 							<?php if(isset($err['descriere'])) echo '<span class="eroare">'.$err['descriere'].'</span>'; ?>
 							<label><?php echo $lang['DESCRIERE_COMP']; ?></label>
 							<input type="textarea" id="descriere" value="<?php if(isset($descriere)) echo $descriere;?>"  name="descriere" placeholder="<?php echo $lang['DESCRIERE_COMP_PLH']; ?>" autocomplete="off" required="required" />
 						</div>
						<div>
							<?php if(isset($err['tara'])) echo '<span class="eroare">'.$err['tara'].'</span>'; ?>
							<label><?php echo $lang['TARA']; ?></label>
							<select id="tara" name="tara" placeholder="<?php echo $lang['TARA_PLH']; ?>"  autocomplete="off">
								<option></option>
								<?php 
 								$sql = mysql_query("SELECT * FROM `tari`");
									while($rand = mysql_fetch_array($sql)) {
								?>
								<option value="<?php echo $rand['id_tara'];?>" <?php if(isset($tara) and $tara==$rand['id_tara']) echo 'selected'; ?>><?php echo $rand['tara'];?></option>
								<?php
								}
								?>	
							</select>
 						</div>
						<div>
							<?php if(isset($err['id_tip_companie'])) echo '<span class="eroare">'.$err['id_tip_companie'].'</span>'; ?>
							<label><?php echo $lang['TIP']; ?></label>
							<select id="tip" name="id_tip_companie" placeholder="<?php echo $lang['COMPANIE']; ?>"  autocomplete="off">
								<option></option>
								<?php 
 								$sql = mysql_query("SELECT * FROM `tipuri_companii`");
									while($rand = mysql_fetch_array($sql)) {
								?>
								<option value="<?php echo $rand['id_tip_companie'];?>" <?php if(isset($id_tip_companie) and $id_tip_companie==$rand['id_tip_companie']) echo 'selected'; ?>><?php echo $rand['tip'];?></option>
								<?php
								}
								?>	
							</select>
 						</div>
						<div>
 							<label><?php echo $lang['ACTIV']; ?></label>
 							<input type="checkbox" name="status" value="1" <?php if(isset($status) and $status==0) echo ''; else echo 'checked'; ?> /></td>
 						</div>
 						<div>
 							<input type="submit" id="x" name="<?php if(isset($id_companie)) echo 'edit_companie'; else echo 'add_companie'; ?>" value="<?php if(isset($id_companie)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" />
 						</div>
				</form>
				
				
				
				<form name="alegere_companie" action="" method="post">
    				<label><?php echo $lang['SELECT_COMPANIE_DE_MODIFICAT'];?></label><br />
                        <?php if(isset($err['id_companie'])) echo '<span class="eroare">'.$err['id_companie'].'</span>'; ?>
    					<select name="id_companie" id="id_companie">                            
    						<option value=""></option>		
                            <?php $s = mysql_query("SELECT * FROM `companii_aeriene` ORDER BY `denumire` ASC");
                                while($r = mysql_fetch_array($s)) { 
                            ?>
                            <option value="<?php echo $r['id_companie'];?>" <?php if(isset($id_companie) and $id_companie ==$r['id_companie']) echo 'selected'; ?> ><?php echo $r['denumire'];?></option>		
                            <?php } ?>
    					</select><br/>
                        <input type="submit" name="alege_companie" value="<?php echo $lang['ALEGE_COMPANIE'];?>" />
                </form><br /><br />
				<?php } else { ?>

					<?php if(isset($id_companie)) { ?>

						<?php if($_GET['do']=="adauga_meniu") { ?>
							<h1><?php if(isset($id_meniu)) echo $lang['FORMULAR_MENIU_EDIT']; else echo $lang['FORMULAR_MENIU']; ?></h1>
							<form action="" method="post" name="meniu_form" id="creare_meniu" action="">
								
									<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.((isset($id_meniu)) ? $lang['MENIU_EDIT'] : $lang['MENIU_ADD']).'</span>'; ?>
									<div>
										<?php if(isset($err['meniu'])) echo '<span class="eroare">'.$err['meniu'].'</span>'; ?>
										<label><?php echo $lang['MENIU']; ?></label>
										<input type="text" id="meniu" value="<?php if(isset($meniu)) echo $meniu;?>"  name="meniu" placeholder="<?php echo $lang['MENIU']; ?>" autocomplete="off" required="required" />
									</div>
									
									<div>
										<input type="submit" id="x" name="<?php if(isset($id_meniu)) echo 'edit_meniu'; else echo 'add_meniu'; ?>" value="<?php if(isset($id_meniu)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" />
									</div>

								</table>
							</form>
							
							<form name="alegere_meniu" action="" method="post">
								<div>
								<label><?php echo $lang['SELECTATI_MENIUL']?></label><br />
									<?php if(isset($err['id_meniu'])) echo '<span class="eroare">'.$err['id_meniu'].'</span>'; ?>
									<select name="id_meniu" id="id_meniu">                            
										<option value=""></option>		
										<?php $s = mysql_query("SELECT * FROM `tipuri_meniu` ORDER BY `denumire` ASC");
											while($r = mysql_fetch_array($s)) { 
										?>
										<option value="<?php echo $r['id_meniu'];?>" <?php if(isset($id_meniu) and $id_meniu==$r['id_meniu']) echo 'selected'; ?> ><?php echo $r['denumire'];?></option>		
										<?php } ?>
									</select><br/>
								</div>
								<div>
									<input type="submit" name="alege_meniu" value="<?php echo $lang['ALEGE_MENIU'];?>" />
								</div>
							</form><br /><br />
							<!--AICI AI UN FORMULAR DE INTRODUCERE SI DE EDITARE
								- aici se introduc chestii noi in tip_meniu, independent de compania asta in care esti acum, e ca si cum ai avea un fisier meniuri.php
								
							MAI JOS UNU DE SELECTARE
								- aici ai de unde le poti alege sa le editezi, ca pana acum, nimic special -->
						<?php } elseif($_GET['do']=="asociaza_meniu") { ?>
							<h2 class="titlu_companie"><?php echo $lang['SETARILE_MENIU'];?><b><?php echo $denumire; ?></b></h2>
							<form name="asociere_meniu" action="" method="post">								
								<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.$lang['MENIU_ASOCIERE'].'</span>'; ?>
								<div>
								<label><?php $lang['SELECT_MENU_COMPANIE'];?></label><br />
									<?php if(isset($err['id_meniu'])) echo '<span class="eroare">'.$err['id_meniu'].'</span>'; ?>
									<select name="id_meniu" id="id_meniu">                            
										<option value=""></option>		
										<?php 
											
										$s = mysql_query("SELECT * FROM `tipuri_meniu` ORDER BY `denumire` ASC");
											while($r = mysql_fetch_array($s)) { 
												if(mysql_num_rows(mysql_query("SELECT `id_meniu_companie` FROM `meniu_companie` WHERE `id_meniu`='".$r['id_meniu']."' AND `id_companie`='".cinp($id_companie)."' LIMIT 1"))==0) {
										?>
										<option value="<?php echo $r['id_meniu'];?>" <?php if(isset($id_meniu) and $id_meniu ==$r['id_meniu']) echo 'selected'; ?> ><?php echo $r['denumire'];?></option>		
										<?php 	} 
											} ?>
									</select><br/>
									<a href="companii.php?id_companie=<?php echo $id_companie;?>&amp;do=adauga_meniu"><?php echo $lang['ADAUGA_EDITEAZA_MENIU'];?></a>
								</div>
								<div>
									<input type="submit" name="asociaza_meniu" value="<?php echo $lang['ASOCIAZA_MENIU'];?>" />
								</div>
							</form><br /><br />
						
							<div class="rezultate_existente">
							<h3><?php echo $lang['MENIURI_ASOCIATE_COMPANIEI'];?> <?php echo $denumire; ?></h3>
							<table>
								<tr class="table_head"><td><?php echo $lang['MENIU'];?></td><td><?php echo $lang['STATUS'];?></td></td>
								<?php 
									$s_meniu = mysql_query("SELECT `tm`.`denumire`, `mc`.`id_meniu_companie`,`mc`.`status` FROM `meniu_companie` AS `mc` INNER JOIN `tipuri_meniu` AS `tm` ON `mc`.`id_meniu`=`tm`.`id_meniu` 
										WHERE `mc`.`id_companie`='".cinp($id_companie)."'");
									while($r_meniu = mysql_fetch_array($s_meniu)) {
										echo '<tr>';
											echo '<td>'.$r_meniu['denumire'].'</td>';
											echo '<td><a href="companii.php?id_companie='.$id_companie.'&amp;do=asociaza_meniu&amp;id_meniu_companie='.$r_meniu['id_meniu_companie'].'&amp;status='.(($r_meniu['status']==1) ? "0" : "1").'">'.(($r_meniu['status']==1) ? "".$lang['ACTIV']."" : "".$lang['INACTIV']."").'</a></td>';
										echo '</tr>';
									} 
								?>
							</table>
							</div>
						<?php } ?>
						<?php if($_GET['do']=="adauga_tip_bagaj") { ?>
							<h1><?php if(isset($id_tip_bagaj)) echo $lang['FORMULAR_BAGAJ_EDIT']; else echo $lang['FORMULAR_BAGAJ']; ?></h1>
							<form action="" method="post" name="meniu_form" id="creare_meniu" action="">
								
									<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.((isset($id_tip_bagaj)) ? $lang['BAGAJ_EDIT'] : $lang['BAGAJ_ADD']).'</span>'; ?>
									<div>
										<?php if(isset($err['tip_bagaj'])) echo '<span class="eroare">'.$err['tip_bagaj'].'</span>'; ?>
										<label><?php echo $lang['BAGAJ']; ?></label>
										<input type="text" id="meniu" value="<?php if(isset($tip_bagaj)) echo $tip_bagaj;?>"  name="tip_bagaj" placeholder="<?php echo $lang['BAGAJ']; ?>" autocomplete="off" required="required" />
									</div>
									
									<div>
										<input type="submit" id="x" name="<?php if(isset($id_tip_bagaj)) echo 'edit_tip_bagaj'; else echo 'add_tip_bagaj'; ?>" value="<?php if(isset($id_tip_bagaj)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" />
									</div>

								</table>
							</form>
							
							<form name="alegere_bagaj" action="" method="post">
								<div>
								<label><?php echo $lang['SELECT_BAGAJ_MODIFY'];?></label><br />
									<?php if(isset($err['id_tip_bagaj'])) echo '<span class="eroare">'.$err['id_tip_bagaj'].'</span>'; ?>
									<select name="id_tip_bagaj" id="id_tip_bagaj">                            
										<option value=""></option>		
										<?php $s = mysql_query("SELECT * FROM `tipuri_bagaj` ORDER BY `tip_bagaj` ASC");
											while($r = mysql_fetch_array($s)) { 
										?>
										<option value="<?php echo $r['id_tip_bagaj'];?>" <?php if(isset($id_tip_bagaj) and $id_tip_bagaj==$r['id_tip_bagaj']) echo 'selected'; ?> ><?php echo $r['tip_bagaj'];?></option>		
										<?php } ?>
									</select><br/>
								</div>
								<div>
									<input type="submit" name="alege_tip_bagaj" value="<?php echo $lang['ALEGE_TIP_BAGAJ'];?>" />
								</div>
							</form><br /><br />
							

						<?php } elseif($_GET['do']=="asociaza_tip_bagaj") { ?>
							<h2 class="titlu_companie"><?php echo $lang['SETTINGS'];?> <b><?php echo $denumire; ?></b></h2>
							<form name="asociere_tip_bagaj" action="" method="post">								
								<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.$lang['BAGAJ_ASOCIERE'].'</span>'; ?>
								<div>
								<label><?php echo $lang['SELECT_BAGAJ_ASOC_COMP'];?></label><br />
									<?php if(isset($err['id_tip_bagaj'])) echo '<span class="eroare">'.$err['id_tip_bagaj'].'</span>'; ?>
									<select name="id_tip_bagaj" id="id_tip_bagaj">                            
										<option value=""></option>		
										<?php 
											
										$s = mysql_query("SELECT * FROM `tipuri_bagaj` ORDER BY `tip_bagaj` ASC");
											while($r = mysql_fetch_array($s)) { 
												if(mysql_num_rows(mysql_query("SELECT `id_bagaje_companie` FROM `bagaje_companie` WHERE `id_tip_bagaj`='".$r['id_tip_bagaj']."' AND `id_companie`='".cinp($id_companie)."' LIMIT 1"))==0) {
										?>
										<option value="<?php echo $r['id_tip_bagaj'];?>" <?php if(isset($id_tip_bagaj) and $id_tip_bagaj ==$r['id_tip_bagaj']) echo 'selected'; ?> ><?php echo $r['tip_bagaj'];?></option>		
										<?php 	} 
											} ?>
									</select><br/>
									<a href="companii.php?id_companie=<?php echo $id_companie;?>&amp;do=adauga_tip_bagaj"><?php echo $lang['ADAUGA_EDITEAZA_BAGAJ'];?></a>
								</div>
								<div> 
									<input type="submit" name="asociaza_tip_bagaj" value="<?php echo $lang['ASOC_TIP_BAGAJ'];?>" />
								</div>
							</form><br /><br />
						
							<div class="rezultate_existente">
							<h3><?php echo $lang['TIPURI_BAGAJ_ASOC_COMP'];?><?php echo $denumire; ?></h3>
							<table>
								<tr class="table_head"><td><?php echo $lang['TIP_BAGAJ'];?></td><td><?php echo $lang['STATUS'];?></td></td>
								<?php 
									$s_meniu = mysql_query("SELECT `tb`.`tip_bagaj`, `bc`.`id_bagaje_companie`,`bc`.`status` FROM `bagaje_companie` AS `bc` INNER JOIN `tipuri_bagaj` AS `tb` ON `bc`.`id_tip_bagaj`=`tb`.`id_tip_bagaj` 
										WHERE `bc`.`id_companie`='".cinp($id_companie)."'");
									while($r_meniu = mysql_fetch_array($s_meniu)) {
										echo '<tr>';
											echo '<td>'.$r_meniu['tip_bagaj'].'</td>';
											echo '<td><a href="companii.php?id_companie='.$id_companie.'&amp;do=asociaza_tip_bagaj&amp;id_bagaje_companie='.$r_meniu['id_bagaje_companie'].'&amp;status='.(($r_meniu['status']==1) ? "0" : "1").'">'.(($r_meniu['status']==1) ? "".$lang['ACTIV']."" : "".$lang['INACTIV']."").'</a></td>';
										echo '</tr>';
									} 
								?>
							</table>
							</div>
							
						<?php } ?>
						
						<?php if($_GET['do']=="adauga_clasa") { ?>
							<h1><?php if(isset($id_clasa)) echo $lang['FORMULAR_CLASA_EDIT'];  else echo $lang['FORMULAR_CLASA']; ?></h1>
							<form action="" method="post" name="clasa_form" id="creare_meniu" action="">
								
									<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.((isset($id_clasa)) ? $lang['CLASA_EDIT'] : $lang['CLASA_ADD']).'</span>'; ?>
									<div>
										<?php if(isset($err['clasa'])) echo '<span class="eroare">'.$err['clasa'].'</span>'; ?>
										<label><?php echo $lang['CLASA']; ?></label>
										<input type="text" id="clasa" value="<?php if(isset($clasa)) echo $clasa;?>"  name="clasa" placeholder="<?php echo $lang['CLASA']; ?>" autocomplete="off" required="required" />
									</div>
									
									<div>
										<input type="submit" id="x" name="<?php if(isset($id_clasa)) echo 'edit_clasa'; else echo 'add_clasa'; ?>" value="<?php if(isset($id_clasa)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" />
									</div>

								</table>
							</form>
							
							<form name="alegere_bagaj" action="" method="post">
								<div>
								<label><?php echo $lang['SELECT_CLASA_CONFORT'];?></label><br />
									<?php if(isset($err['id_clasa'])) echo '<span class="eroare">'.$err['id_clasa'].'</span>'; ?>
									<select name="id_clasa" id="id_clasa">                            
										<option value=""></option>		
										<?php $s = mysql_query("SELECT * FROM `clase` ORDER BY `clasa` ASC");
											while($r = mysql_fetch_array($s)) { 
										?>
										<option value="<?php echo $r['id_clasa'];?>" <?php if(isset($id_clasa) and $id_clasa==$r['id_clasa']) echo 'selected'; ?> ><?php echo $r['clasa'];?></option>		
										<?php } ?>
									</select><br/>
								</div>
								<div>
									<input type="submit" name="alege_clasa" value="<?php echo $lang['ALEGE_CLASA_CONFORT'];?>" />
								</div>
							</form><br /><br />
							
						<?php } elseif($_GET['do']=="asociaza_clasa") { ?>
							<h2 class="titlu_companie"><?php echo $lang['SETTINGS'];?> <b><?php echo $denumire; ?></b></h2>
							<form name="asociere_clasa" action="" method="post">								
								<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.$lang['CLASA_ASOCIERE'].'</span>'; ?>
								<div>
								<label><?php echo $lang['SELECT_CLASA_CONFORT_ASOC_COMP'];?></label><br />
									<?php if(isset($err['id_clasa'])) echo '<span class="eroare">'.$err['id_clasa'].'</span>'; ?>
									<select name="id_clasa" id="id_clasa">                            
										<option value=""></option>		
										<?php 
											
										$s = mysql_query("SELECT * FROM `clase` ORDER BY `clasa` ASC");
											while($r = mysql_fetch_array($s)) { 
												if(mysql_num_rows(mysql_query("SELECT `id_companie_clasa` FROM `companie_clase` WHERE `id_clasa`='".$r['id_clasa']."' AND `id_companie`='".cinp($id_companie)."' LIMIT 1"))==0) {
										?>
										<option value="<?php echo $r['id_clasa'];?>" <?php if(isset($id_clasa) and $id_clasa ==$r['id_clasa']) echo 'selected'; ?> ><?php echo $r['clasa'];?></option>		
										<?php 	} 
											} ?>
									</select><br/>
									<a href="companii.php?id_companie=<?php echo $id_companie;?>&amp;do=adauga_clasa"><?php echo $lang['ADAUGA_EDIT_CLASA_CONFORT'];?></a>
								</div>
								<div>
									<input type="submit" name="asociaza_clasa" value="<?php echo $lang['ASOC_CL_CONFORT_'];?>" />
								</div>
							</form><br /><br />
						
							<div class="rezultate_existente">
							<h3><?php echo $lang['CLASE_CONFORT_ASOC_COMP'];?><?php echo $denumire; ?></h3>
							<table>
								<tr class="table_head"><td><?php echo $lang['CLASE_DE_CONFORT'];?></td><td><?php echo $lang['STATUS'];?></td></td>
								<?php 
									$s_meniu = mysql_query("SELECT `c`.`clasa`, `cc`.`id_companie_clasa`,`cc`.`status` FROM `companie_clase` AS `cc` INNER JOIN `clase` AS `c` ON `cc`.`id_clasa`=`c`.`id_clasa` 
										WHERE `cc`.`id_companie`='".cinp($id_companie)."'");
									while($r_meniu = mysql_fetch_array($s_meniu)) {
										echo '<tr>';
											echo '<td>'.$r_meniu['clasa'].'</td>';
											echo '<td><a href="companii.php?id_companie='.$id_companie.'&amp;do=asociaza_clasa&amp;id_companie_clasa='.$r_meniu['id_companie_clasa'].'&amp;status='.(($r_meniu['status']==1) ? "0" : "1").'">'.(($r_meniu['status']==1) ? "".$lang['ACTIV']."" : "".$lang['INACTIV']."").'</a></td>';
										echo '</tr>';
									} 
								?>
							</table>
							</div>
						<?php } ?>

						<?php if($_GET['do']=="adauga_categorie_varsta") { ?>

							<h1><?php if(isset($id_categorie_varsta)) echo $lang['FORMULAR_VARSTA_EDIT']; else echo $lang['FORMULAR_VARSTA']; ?></h1>
							<form action="" method="post" name="varsta_form" id="creare_varsta" action="">
								
									<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.((isset($id_categorie_varsta)) ? $lang['VARSTA_EDIT'] : $lang['VARSTA_ADD']).'</span>'; ?>
									<div>
										<?php if(isset($err['categorie'])) echo '<span class="eroare">'.$err['categorie'].'</span>'; ?>
										<label><?php echo $lang['VARSTA']; ?></label>
										<input type="text" id="categorie" value="<?php if(isset($categorie)) echo $categorie;?>"  name="categorie" placeholder="<?php echo $lang['VARSTA']; ?>" autocomplete="off" required="required" />
									</div>
									
									<div>
										<input type="submit" id="x" name="<?php if(isset($id_categorie_varsta)) echo 'edit_categorie_varsta'; else echo 'add_categorie_varsta'; ?>" value="<?php if(isset($id_categorie_varsta)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" />
									</div>

								</table>
							</form>
							
							<form name="alegere_categorie_varsta" action="" method="post">
								<div>
								<label><?php echo $lang['SELECT_CATEGORIE_VARSTA_MODIF'];?></label><br />
									<?php if(isset($err['id_categorie_varsta'])) echo '<span class="eroare">'.$err['id_categorie_varsta'].'</span>'; ?>
									<select name="id_categorie_varsta" id="id_categorie_varsta">                            
										<option value=""></option>		
										<?php $s = mysql_query("SELECT * FROM `categorii_varsta` ORDER BY `categorie` ASC");
											while($r = mysql_fetch_array($s)) { 
										?>
										<option value="<?php echo $r['id_categorie_varsta'];?>" <?php if(isset($id_categorie_varsta) and $id_categorie_varsta==$r['id_categorie_varsta']) echo 'selected'; ?> ><?php echo $r['categorie'];?></option>		
										<?php } ?>
									</select><br/>
								</div>
								<div>
									<input type="submit" name="alege_categorie_varsta" value="<?php echo $lang['ALEGE_CATEGORIA'];?>" />
								</div>
							</form><br /><br />
							
						<?php } elseif($_GET['do']=="asociaza_categorie_varsta") { ?>
							<h2 class="titlu_companie"><?php echo $lang['SETTINGS']; ?><b><?php echo $denumire; ?></b></h2>
							<form name="asociere_categorie_varsta" action="" method="post">								
								<?php if(isset($_GET['show']) and $_GET['show']=="succes") echo '<span class="succes">'.$lang['VARSTA_ASOCIERE'].'</span>'; ?>
								<div>
								<label><?php echo $lang['SELECT_AGE_CAT_ASOC_COMP'];?></label><br />
									<?php if(isset($err['id_categorie_varsta'])) echo '<span class="eroare">'.$err['id_categorie_varsta'].'</span>'; ?>
									<select name="id_categorie_varsta" id="id_categorie_varsta">                            
										<option value=""></option>		
										<?php 
											
										$s = mysql_query("SELECT * FROM `categorii_varsta` ORDER BY `categorie` ASC");
											while($r = mysql_fetch_array($s)) { 
												if(mysql_num_rows(mysql_query("SELECT `id_comp_red_cat` FROM `companie_reduceri_categorii` WHERE `id_categorie_varsta`='".$r['id_categorie_varsta']."' AND `id_companie`='".cinp($id_companie)."' LIMIT 1"))==0) {
										?>
										<option value="<?php echo $r['id_categorie_varsta'];?>" <?php if(isset($id_categorie_varsta) and $id_categorie_varsta ==$r['id_categorie_varsta']) echo 'selected'; ?> ><?php echo $r['categorie'];?></option>		
										<?php 	} 
											} ?>
									</select><br/>
									<a href="companii.php?id_companie=<?php echo $id_companie;?>&amp;do=adauga_categorie_varsta"><?php echo $lang['ADAUGA_EDITEAZA_CAT_VARSTA'];?></a>
								</div>
								<div>
									<input type="submit" name="asociaza_categorie_varsta" value="<?php echo $lang['ASOCIAZA_CATEGORIE'];?>" />
								</div>
							</form><br /><br />
						
							<div class="rezultate_existente">
							<h3><?php echo $lang['CAT_VARSTA_ASOC_COMP'];?><?php echo $denumire; ?></h3>
							<table>
								<tr class="table_head"><td><?php echo $lang['CATEGORIA_VARSTA'];?></td><td><?php echo $lang['STATUS'];?></td></td>
								<?php 
									$s_meniu = mysql_query("SELECT `cv`.`categorie`, `crc`.`id_comp_red_cat`,`crc`.`status` FROM `companie_reduceri_categorii` AS `crc` INNER JOIN `categorii_varsta` AS `cv` ON `crc`.`id_categorie_varsta`=`cv`.`id_categorie_varsta` 
										WHERE `crc`.`id_companie`='".cinp($id_companie)."'");
									while($r_meniu = mysql_fetch_array($s_meniu)) {
										echo '<tr>';
											echo '<td>'.$r_meniu['categorie'].'</td>';
											echo '<td><a href="companii.php?id_companie='.$id_companie.'&amp;do=asociaza_categorie_varsta&amp;id_comp_red_cat='.$r_meniu['id_comp_red_cat'].'&amp;status='.(($r_meniu['status']==1) ? "0" : "1").'">'.(($r_meniu['status']==1) ? "".$lang['ACTIV']."" : "".$lang['INACTIV']."").'</a></td>';
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
				<?php if(isset($id_companie)) { ?>
				<span class="clear"></span>
					<ul class="admin_submenu"> 
					<li><a href="companii.php?id_companie=<?php echo $id_companie;?>&amp;do=asociaza_meniu"><?php echo $lang['MENU_ASOC_MENU_COMP'];?></a></li>
					<li><a href="companii.php?id_companie=<?php echo $id_companie;?>&amp;do=asociaza_tip_bagaj"><?php echo $lang['MENU_ASOC_BAGAJ_COMP'];?></a></li>
					<li><a href="companii.php?id_companie=<?php echo $id_companie;?>&amp;do=asociaza_clasa"><?php echo $lang['MENU_ASOC_CONFORT_COMP'];?></a></li>
					<li><a href="companii.php?id_companie=<?php echo $id_companie;?>&amp;do=asociaza_categorie_varsta"><?php echo $lang['MENU_ASOC_VARSTA_CAT_COMP'];?></a></li>
					</ul>
				<span class="clear"></span>
				<?php } ?>
				<?php include('includes/links_admin.php');  ?>
			</aside>
		</div>
	</div>

<?php include('footer.php'); ?> 