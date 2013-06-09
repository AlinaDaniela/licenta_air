<?php require_once("config.php");?>
 <?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user']) or $_SESSION['tip_user']!="admin") header("Location: cont.php");
?>


<?php 
if(isset($_GET['id_companie'])) {
	$id_companie = $_GET['id_companie'];
	$s = mysql_query("SELECT * FROM `companii` WHERE `id_tip_companie`='".cinp($id_companie)."' LIMIT 1");
    $r = mysql_fetch_assoc($s);
	$compaanie = $r['denumire'];
	$descriere = $r['descriere'];
	$tara = $r['tara'];
	$tip_companie = $r['id_tip_companie'];
	$status = $r['status'];
} 
?>

 <?php  

 		if(isset($_POST['add_companie']) or isset($_POST['edit_companie'])){

 			
			if(empty($_POST['companie'])) $err['companie'] = $lang['EROARE_COMPANIE_EMPTY']; 
 			else if(!empty($_POST['companie']) && !preg_match("/^[a-z 0-9.]/i",$_POST['companie'])) $err['companie'] = $lang['EROARE_WORNG_COMPANIE'];
 			else $companie = $_POST['companie'];
			
			if(empty($_POST['descriere'])) $err['descriere'] = $lang['EROARE_DESCRIERE_EMPTY']; 
 			else $descriere = $_POST['descriere'];
			
			if(empty($_POST['tara'])) $err['tara'] = $lang['EROARE_TARA_EMPTY'];
 			else $tara= $_POST['tara'];

			if(empty($_POST['tip_companie'])) $err['tip_companie'] = $lang['EROARE_TIP_COMPANIE_EMPTY'];
 			else $tip_companie= $_POST['companie'];
			
 			if(isset($_POST['status'])) $status = 1;
 			else $status = 0;
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_tip'])) { 
				
	 				$sql = "INSERT INTO `companii_aeriene` SET ";
	 				$sql .= "`denumire` = '".cinp($denumire)."',";
					$sql .= "`descriere` = '".cinp($descriere)."',";
					$sql .= "`id_tara` = '".cinp($tara)."',";
					$sql .= "`id_tip_companie` = '".cinp($tip_companie)."',";
					$sql .= "`status` = '".cinp($status)."'";

	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?show=succes");
						unset($denumire,$descriere,$tara,$tip_companie,$status); 
					} 
				}

				if(isset($_POST['edit_companie'])) { 
				
	 				$sql = "UPDATE `companii_aeriene` SET ";
	 				$sql .= "`denumire` = '".cinp($denumire)."',";
					$sql .= "`descriere` = '".cinp($descriere)."',";
					$sql .= "`id_tara` = '".cinp($tara)."',";
					$sql .= "`id_tip_companie` = '".cinp($tip_companie)."',";
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
		

	if(isset($_POST['alege_companie'])) {
    if(empty($_POST['id_companie'])) $err['id_companie'] = "Va rugam alegeti compania aeriana pe care doriti sa o modificati.";
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
 			else if(!empty($_POST['meniu']) && !preg_match("/^[a-z 0-9.]/i",$_POST['meniu'])) $err['meniu'] = $lang['EROARE_WORNG_MENIU'];
 			else $meniu = $_POST['meniu'];
			
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_meniu'])) { 
				
	 				$sql = "INSERT INTO `tipuri_meniu` SET ";
	 				$sql .= "`denumire` = '".cinp($meniu)."'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?id_companie=".$id_companie."&amp;do=adauga_meniu?show=succes");
						unset($meniu); 
					} 
				}

				if(isset($_POST['edit_meniu'])) { 
				
	 				$sql = "UPDATE `tipuri_meniu` SET ";
	 				$sql .= "`denumire` = '".cinp($meniu)."'";
	 				$sql .= " WHERE `id_meniu` = '".cinp($id_meniu)."' LIMIT 1";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?id_companie=".$id_companie."&amp;do=adauga_meniu?show=succes");
						unset($meniu); 
					} 
				}					

 			}        
 		}    
		
		     
	//Formular de selectare a meniului de modificat
	if(isset($_POST['alege_meniu'])) {
    if(empty($_POST['id_meniu'])) $err['id_meniu'] = "Va rugam alegeti tipul de meniu.";
    else {
        header("Location: companii.php?id_meniu=".$_POST['id_meniu']);
    }
}

		//VALIDAREA FORMULARULUI DE ASOCIERE MENIU
		
		
	//Validare formular de adaugare/editare tip bagaj	
	if(isset($_GET['id_bagaj'])) {
			$id_bagaj = $_GET['id_tip_bagaj'];
			$s = mysql_query("SELECT * FROM `tipuri_bagaj` WHERE `id_tip_bagaj`='".cinp($id_bagaj)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$bagaj = $r['tip_bagaj'];
		} 

 		if(isset($_POST['add_tip_bagaj']) or isset($_POST['edit_tip_bagaj'])){

 			
			if(empty($_POST['bagaj'])) $err['bagaj'] = $lang['EROARE_BAGAJ_EMPTY']; 
 			else $bagaj = $_POST['bagaj'];
			
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_bagaj'])) { 
				
	 				$sql = "INSERT INTO `tipuri_bagaj` SET ";
	 				$sql .= "`tip_bagaj` = '".cinp($bagaj)."'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?id_companie=".$id_companie."&amp;do=adauga_tip_bagaj?show=succes");
						unset($bagaj); 
					} 
				}

				if(isset($_POST['edit_bagaj'])) { 
				
	 				$sql = "UPDATE `tipuri_bagaj` SET ";
	 				$sql .= "`tip_bagaj` = '".cinp($bagaj)."'";
	 				$sql .= " WHERE `id_tip_bagaj` = '".cinp($id_bagaj)."' LIMIT 1";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?id_companie=".$id_companie."&amp;do=adauga_tip_bagaj?show=succes");
						unset($bagaj); 
					} 
				}					

 			}        
 		}    
		
		     
	//Formular de selectare a bagajului de modificat
	if(isset($_POST['alege_bagaj'])) {
    if(empty($_POST['id_bagaj'])) $err['id_bagaj'] = "Va rugam alegeti tipul de bagaj.";
    else {
        header("Location: companii.php?id_bagaj=".$_POST['id_bagaj']);
    }


		if(isset($_GET['id_clasa'])) {
			$id_clasa = $_GET['id_clasa'];
			$s = mysql_query("SELECT * FROM `clase` WHERE `id_clasa`='".cinp($id_clasa)."' LIMIT 1");
			$r = mysql_fetch_assoc($s);
			$clasa = $r['clasa'];
		} 



 		if(isset($_POST['add_clasa']) or isset($_POST['edit_clasa'])){

 			
			if(empty($_POST['clasa'])) $err['clasa'] = $lang['EROARE_CLASA_EMPTY']; 
 			else $clasa = $_POST['clasa'];
			
			
 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.
 				if(isset($_POST['add_clasa'])) { 
				
	 				$sql = "INSERT INTO `clase` SET ";
	 				$sql .= "`clasa` = '".cinp($clasa)."'";
	 				
					$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?id_companie=".$id_companie."&amp;do=adauga_clasa?show=succes");
						unset($clasa); 
					} 
				}

				if(isset($_POST['edit_clasa'])) { 
				
	 				$sql = "UPDATE `clase` SET ";
	 				$sql .= "`clasa` = '".cinp($clasa)."'";
	 				$sql .= " WHERE `id_clasa` = '".cinp($id_clasa)."' LIMIT 1";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: companii.php?id_companie=".$id_companie."&amp;do=adauga_clasa?show=succes");
						unset($meniu); 
					} 
				}					

 			}        
 		}    
		
		     
	//Formular de selectare a meniului de modificat
	if(isset($_POST['alege_clasa'])) {
    if(empty($_POST['id_clasa'])) $err['id_clasa'] = "Va rugam alegeti clasa.";
    else {
        header("Location: companii.php?id_clasa=".$_POST['id_clasa']);
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
				<h1><?php echo $lang['FORMULAR_COMPANIE']; ?></h1>
				
				<form action="" method="post" name="companie_form" id="creare_companie" action="">
 					
 						<?php if(isset($succes)) echo '<span class="succes">'.$succes.'</span>'; ?>
 						<?php if(isset($err['companie'])) echo '<span class="eroare">'.$err['companie'].'</span>'; ?>
 						<div>
 							<?php if(isset($err['companie'])) echo '<span class="eroare">'.$err['companie'].'</span>'; ?>
 							<label><?php echo $lang['COMPANIE']; ?></label>
 							<input type="text" id="tip" value="<?php if(isset($companie)) echo $companie;?>"  name="companie" placeholder="<?php echo $lang['COMPANIE']; ?>" autocomplete="off" required="required" />
 						</div>
						<?php if(isset($err['descriere'])) echo '<span class="eroare">'.$err['descriere'].'</span>'; ?>
 						<div>
 							<?php if(isset($err['descriere'])) echo '<span class="eroare">'.$err['descriere'].'</span>'; ?>
 							<label><?php echo $lang['DESCRIERE_COMP']; ?></label>
 							<input type="textarea" id="tip" value="<?php if(isset($descriere)) echo $descriere;?>"  name="descriere" placeholder="<?php echo $lang['DESCRIERE_COMP']; ?>" autocomplete="off" required="required" />
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
							<?php if(isset($err['tip_companie'])) echo '<span class="eroare">'.$err['tip_companie'].'</span>'; ?>
							<label><?php echo $lang['TIP']; ?></label>
							<select id="tara" name="tara" placeholder="<?php echo $lang['TIP']; ?>"  autocomplete="off">
								<option></option>
								<?php 
 								$sql = mysql_query("SELECT * FROM `tipuri_companii`");
									while($rand = mysql_fetch_array($sql)) {
								?>
								<option value="<?php echo $rand['id_tip_companie'];?>" <?php if(isset($tip_companie) and $tip_companie==$rand['id_tip_companie']) echo 'selected'; ?>><?php echo $rand['tip'];?></option>
								<?php
								}
								?>	
							</select>
 						</div>
						<div>
 							<label>Activ</label>
 							<input type="checkbox" name="status" value="1" <?php if(isset($status) and $status==0) echo ''; else echo 'checked'; ?> /></td>
 						</div>
 						<div>
 							<input type="submit" id="x" name="<?php if(isset($id_companie)) echo 'edit_companie'; else echo 'add_companie'; ?>" value="<?php if(isset($id_companie)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" />
 						</div>

 					</table>
				</form>
				
				<?php if(isset($id_companie)) { ?>
					<a href="companii.php?id_companie=<?php echo $id_companie;?>&amp;do=adauga_meniu">Adauga meniu nou</a>
					<a href="companii.php?id_companie=<?php echo $id_companie;?>&amp;do=asociaza_meniu">Asociaza meniu companiei</a>
					<a href="companii.php?id_companie=<?php echo $id_companie;?>&amp;do=adauga_tip_bagaj">Adauga un nou tip de bagaj</a>
					<a href="companii.php?id_companie=<?php echo $id_companie;?>&amp;do=asociaza_tip_bagaj">Asociaza tipurile de bagaj companiei</a>
					<a href="companii.php?id_companie=<?php echo $id_companie;?>&amp;do=adauga_clasa">Adauga o noua clasa de comfort disponibila</a>
					<a href="companii.php?id_companie=<?php echo $id_companie;?>&amp;do=asociaza_clasa">Asociaza clase de comfort companiei companiei</a>
				<?php } ?>
				
				<form name="alegere_companie" action="" method="post">
    				<label>Selectati compania pe care doriti sa o modificati:</label><br />
                        <?php if(isset($err['id_companie'])) echo '<span class="eroare">'.$err['id_companie'].'</span>'; ?>
    					<select name="id_companie" id="id_companie">                            
    						<option value=""></option>		
                            <?php $s = mysql_query("SELECT * FROM `companii_aeriene` ORDER BY `denumire` ASC");
                                while($r = mysql_fetch_array($s)) { 
                            ?>
                            <option value="<?php echo $r['id_companie'];?>" <?php if(isset($id_companie) and $id_companie =$r['id_comapnie']) echo 'selected'; ?> ><?php echo $r['denumire'];?></option>		
                            <?php } ?>
    					</select><br/>
                        <input type="submit" name="alege_companie" value="Alege companie" />
                </form><br /><br />
				<?php } else { ?>
					<?php if(isset($id_companie)) { ?>
						<?php if($_GET['do']=="adauga_meniu")) { ?>
							<h1><?php echo $lang['FORMULAR_MENIU']; ?></h1>
							<form action="" method="post" name="meniu_form" id="creare_meniu" action="">
								
									<?php if(isset($succes)) echo '<span class="succes">'.$succes.'</span>'; ?>
									<?php if(isset($err['meniu'])) echo '<span class="eroare">'.$err['meniu'].'</span>'; ?>
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
								<label>Selectati meniul pe care doriti sa il modificati:</label><br />
									<?php if(isset($err['id_meniu'])) echo '<span class="eroare">'.$err['id_meniu'].'</span>'; ?>
									<select name="id_meniu" id="id_meniu">                            
										<option value=""></option>		
										<?php $s = mysql_query("SELECT * FROM `tipuri_meniu` ORDER BY `denumire` ASC");
											while($r = mysql_fetch_array($s)) { 
										?>
										<option value="<?php echo $r['id_meniu'];?>" <?php if(isset($id_meniu) and $id_meniu =$r['id_meniu']) echo 'selected'; ?> ><?php echo $r['denumire'];?></option>		
										<?php } ?>
									</select><br/>
									<input type="submit" name="alege_meniu" value="Alege meniu" />
							</form><br /><br />
							<!--AICI AI UN FORMULAR DE INTRODUCERE SI DE EDITARE
								- aici se introduc chestii noi in tip_meniu, independent de compania asta in care esti acum, e ca si cum ai avea un fisier meniuri.php
								
							MAI JOS UNU DE SELECTARE
								- aici ai de unde le poti alege sa le editezi, ca pana acum, nimic special -->
						<?php } elseif($_GET['do']=="asociaza_meniu") { ?>
							<form name="asociere_meniu" action="" method="post">
								<label>Selectati meniul pe care doriti sa il asociati companiei:</label><br />
									<?php if(isset($err['id_meniu'])) echo '<span class="eroare">'.$err['id_meniu'].'</span>'; ?>
									<select name="id_meniu" id="id_meniu">                            
										<option value=""></option>		
										<?php $s = mysql_query("SELECT * FROM `tipuri_meniu` ORDER BY `denumire` ASC");
											while($r = mysql_fetch_array($s)) { 
										?>
										<option value="<?php echo $r['id_meniu'];?>" <?php if(isset($id_meniu) and $id_meniu =$r['id_meniu']) echo 'selected'; ?> ><?php echo $r['denumire'];?></option>		
										<?php } ?>
									</select><br/>
									<input type="submit" name="asociaza_meniu" value="Asociaza meniu" />
							</form><br /><br />
						<!--
							AICI AI UN FORMULAR DE ASOCIERE - APAR AICI IN SELECTUL DE MENIU 
								- Aici initial ai un select in care iti apar toate toate toate meniurile din tip_meniu
								- Selectezi unu si ii este asociat acestei companii in care lucrezi
								- urmatoarea data, avand un inner join cu tabela companii_meniu WHERE tm.id_meniu!=cm.id_meniu nu o sa-ti mai apara alea pe care le-ai ales deja 
							MAI JOS AI UN SELECT CARE AFISEAZA TOATE SELECTIILE DEJA FACUTE PENTRU ACEASTA COMPANIE
								- Aici ai o lista (tabel) cu toate pe care le-ai ales deja pt compania asta (AICI VEZI CE AI DISPONIBIL PT COMPANIE). e un select pe companii_meniuri.
								
								AI INTELES? SPER  CA DA
								 SI O SA TREBUIASCA SA AM DUPA SI DE EDIT PT COMPANII_MENIRURI?
								 IN tabelul ala punem un buton care sa activeze/dezactiveze o asociere. de stergere nu punem 
								 ok.
								 acum primul lucru, fa sa mearga asta de companii, sa adaugi companii. fa abstractie de tot ce am scris si fa sa mearga companiile
								 doar cu select de meniu sau cu add?
								 mai, tu cum populezi tabela companii.php
								 ?
								 
								 
								 !!!!!pai introduc denumirea, o descriere, aleg tara, aleg un tip_companie, sau daca nu gasesc tipul de companie dorit, adaug un altul!!!! 
								 asta trebuie sa faci in fisierul asta mai sus
								 STOP!
								 mai jos nu citesti
								 dupa care vad ce meniuri, clase, tipuri de bagaje, eventual reduceri ii asociez
								 da cu reduceri era modificare
								 -->
						<?php } ?>
						<?php if($_GET['do']=="adauga_tip_bagaj")) { ?>
						<!--AICI AI UN FORMULAR DE INTRODUCERE SI DE EDITARE
								
							MAI JOS UNU DE SELECTARE
							-->
							<h1><?php echo $lang['FORMULAR_BAGAJ']; ?></h1>
							<form action="" method="post" name="bagaj_form" id="creare_bagaj" action="">
								
									<?php if(isset($succes)) echo '<span class="succes">'.$succes.'</span>'; ?>
									<?php if(isset($err['bagaj'])) echo '<span class="eroare">'.$err['bagaj'].'</span>'; ?>
									<div>
										<?php if(isset($err['bagaj'])) echo '<span class="eroare">'.$err['bagaj'].'</span>'; ?>
										<label><?php echo $lang['BAGAJ']; ?></label>
										<input type="text" id="bagaj" value="<?php if(isset($bagaj)) echo $bagaj;?>"  name="bagaj" placeholder="<?php echo $lang['BAGAJ']; ?>" autocomplete="off" required="required" />
									</div>
									
									<div>
										<input type="submit" id="x" name="<?php if(isset($id_bagaj)) echo 'edit_bagaj'; else echo 'add_bagaj'; ?>" value="<?php if(isset($id_bagaj)) echo $lang['EDITEAZA']; else echo $lang['ADAUGA']; ?>" />
									</div>

								</table>
							</form>
							
							<form name="alegere_bagaj" action="" method="post">
								<label>Selectati tipul de bagaj pe care doriti sa il modificati:</label><br />
									<?php if(isset($err['id_bagaj'])) echo '<span class="eroare">'.$err['id_bagaj'].'</span>'; ?>
									<select name="id_bagaj" id="id_bagaj">                            
										<option value=""></option>		
										<?php $s = mysql_query("SELECT * FROM `tipuri_bagaj` ORDER BY `tip_bagaj` ASC");
											while($r = mysql_fetch_array($s)) { 
										?>
										<option value="<?php echo $r['id_tip_bagaj'];?>" <?php if(isset($id_bagaj) and $id_bagaj =$r['id_tip_bagaj']) echo 'selected'; ?> ><?php echo $r['tip_bagaj'];?></option>		
										<?php } ?>
									</select><br/>
									<input type="submit" name="alege_bagaj" value="Alege bagaj" />
							</form><br /><br />
							

						<?php } elseif($_GET['do']=="asociaza_tip_bagaj") { ?>
							<form name="asociere_meniu" action="" method="post">
								<label>Selectati tipul de bagaj pe care doriti sa il asociati companiei:</label><br />
									<?php if(isset($err['id_bagaj'])) echo '<span class="eroare">'.$err['id_bagaj'].'</span>'; ?>
									<select name="id_bagaj" id="id_bagaj">                            
										<option value=""></option>		
										<?php $s = mysql_query("SELECT * FROM `tipuri_bagaj` ORDER BY `tip_bagaj` ASC");
											while($r = mysql_fetch_array($s)) { 
										?>
										<option value="<?php echo $r['id_tip_bagaj'];?>" <?php if(isset($id_bagaj) and $id_bagaj =$r['id_tip_bagaj']) echo 'selected'; ?> ><?php echo $r['tip_bagaj'];?></option>		
										<?php } ?>
									</select><br/>
									<input type="submit" name="asociaza_tip_bagaj" value="Asociaza tip bagaj" />
							</form><br /><br />
							
						<?php } ?>
						
						<?php if($_GET['do']=="adauga_clasa")) { ?>
							<!--AICI AI UN FORMULAR DE INTRODUCERE SI DE EDITARE								
							MAI JOS UNU DE SELECTARE -->
							<h1><?php echo $lang['FORMULAR_CLASA']; ?></h1>
							<form action="" method="post" name="clasa_form" id="creare_clasa" action="">
								
									<?php if(isset($succes)) echo '<span class="succes">'.$succes.'</span>'; ?>
									<?php if(isset($err['clasa'])) echo '<span class="eroare">'.$err['clasa'].'</span>'; ?>
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
							
							<form name="alegere_clasa" action="" method="post">
								<label>Selectati clasa de comfort pe care doriti sa o modificati:</label><br />
									<?php if(isset($err['id_clasa'])) echo '<span class="eroare">'.$err['id_clasa'].'</span>'; ?>
									<select name="id_clasa" id="id_clasa">                            
										<option value=""></option>		
										<?php $s = mysql_query("SELECT * FROM `clase` ORDER BY `clasa` ASC");
											while($r = mysql_fetch_array($s)) { 
										?>
										<option value="<?php echo $r['id_clasa'];?>" <?php if(isset($id_clasa) and $id_meniu =$r['id_clasa']) echo 'selected'; ?> ><?php echo $r['clasa'];?></option>		
										<?php } ?>
									</select><br/>
									<input type="submit" name="alege_clasa" value="Alege clasa" />
							</form><br /><br />
							
						<?php } elseif($_GET['do']=="asociaza_clasa") { ?>
							<form name="asociere_clasa" action="" method="post">
								<label>Selectati clasa pe care doriti sa o asociati companiei:</label><br />
									<?php if(isset($err['id_clasa'])) echo '<span class="eroare">'.$err['id_clasa'].'</span>'; ?>
									<select name="id_clasa" id="id_clasa">                            
										<option value=""></option>		
										<?php $s = mysql_query("SELECT * FROM `clase` ORDER BY `clasa` ASC");
											while($r = mysql_fetch_array($s)) { 
										?>
										<option value="<?php echo $r['id_clasa'];?>" <?php if(isset($id_clasa) and $id_clasa =$r['id_clasa']) echo 'selected'; ?> ><?php echo $r['clasa'];?></option>		
										<?php } ?>
									</select><br/>
									<input type="submit" name="asociaza_clasa" value="Asociaza clasa" />
							</form><br /><br />
						<!--
							AICI AI UN FORMULAR DE ASOCIERE - APAR AICI IN SELECTUL DE MENIU 
						
							MAI JOS AI UN SELECT CARE AFISEAZA TOATE SELECTIILE DEJA FACUTE PENTRU ACEASTA COMPANIE  -->
						<?php } ?>
					<?php } ?>
				<?php } ?>
				
			</section>
			<aside>
			</aside>
		</div>
	</div>

<?php include('footer.php'); ?> 