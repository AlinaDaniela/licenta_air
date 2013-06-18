<?php require_once('config.php');?>
<?php
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user']) or ($_SESSION['tip_user']!="admin" and $_SESSION['tip_user']!="agent")) header("Location: cont.php");
?>
<?php
	if(isset($_GET['id_rezervare'])){
		$id_rezervare = $_GET['id_rezervare'];
		$s = mysql_query("SELECT * FROM `rezervari` WHERE `id_rezervare`='".cinp($id_rezervare)."' LIMIT 1");
		$r = mysql_fetch_assoc($s);
		$cod = $r['status'];
		$status = $r['status'];
		$status_anulat = $r['status_anulat'];
		
		if(isset($_GET['status'])) {
	
			if($_GET['status'] == 0) {
				//aici trebuie cu for, ceva? ca trebuie pt fiecare zbor, pt fiecare clasa...
				//pai, iei cu query, fiecare rezervare_persoana. . ai acolo si zbor si clasa deci, stai putin
				$s = mysql_query("SELECT `rpz`.`id_rezervare`, `rpz`.`id_meniu`,`rpz`.`id_persoana`, `zc`.`id_zbor_clasa`, `zc`.`nr_locuri`
								  FROM `rezervare_persoana_zbor` AS `rpz` INNER JOIN `rezervari` AS `rz` ON `rpz`.`id_rezervare` = `rz`.`id_rezervare`
								  INNER JOIN `zbor_meniu_clasa` AS `zmc` ON `zmc`.`id_zbor_meniu_clasa` = `rpz`.`id_meniu`
								  INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor_clasa` = `zmc`.`id_zbor_clasa`
								  INNER JOIN `zboruri` AS `zb` ON `zb`.`id_zbor` = `zc`.`id_zbor`
								  WHERE `rz`.`id_rezervare`='".cinp($_GET['id_rezervare'])."' AND `zb`.`data_plecare`>='".(time()+(2*24*60*60))."'");
				if(mysql_num_rows($s)!=0){	
					
					while( $r = mysqL_fetch_array($s)) {
						 $ins_update_zb = mysql_query("UPDATE `zbor_clasa` SET
														`nr_locuri` = `nr_locuri` + '1'
														WHERE `id_zbor_clasa` = '".$r['id_zbor_clasa']."' LIMIT 1");
					     
						//asta e ultima- updatezi rezervari doar daca e totul ok inainte.
						
					}
							mysql_query("UPDATE `rezervari` SET `status`='".cinp($_GET['status'])."' WHERE `id_rezervare`='".cinp($_GET['id_rezervare'])."' LIMIT 1");
							header("Location: rezervare_op.php?show=succes");
				}else {
					$err['rez_redo'] = 'Statusul rezervarii nu mai poate fi modificat!';
				}
			}
			elseif($_GET['status'] == 1){
				$s = mysql_query("SELECT `rpz`.`id_rezervare`, `rpz`.`id_meniu`,`rpz`.`id_persoana`, `zc`.`id_zbor_clasa`, `zc`.`nr_locuri`
								  FROM `rezervare_persoana_zbor` AS `rpz` INNER JOIN `rezervari` AS `rz` ON `rpz`.`id_rezervare` = `rz`.`id_rezervare`
								  INNER JOIN `zbor_meniu_clasa` AS `zmc` ON `zmc`.`id_zbor_meniu_clasa` = `rpz`.`id_meniu`
								  INNER JOIN `zbor_clasa` AS `zc` ON `zc`.`id_zbor_clasa` = `zmc`.`id_zbor_clasa`
								  INNER JOIN `zboruri` AS `zb` ON `zb`.`id_zbor` = `zc`.`id_zbor`
								  WHERE `rz`.`id_rezervare`='".cinp($_GET['id_rezervare'])."' AND `zb`.`data_plecare`>='".(time()+(2*24*60*60))."'");
				if(mysql_num_rows($s)!=0){						   
					$nr_R = mysql_num_rows($s);
					$i = 0;
					while( $r = mysqL_fetch_array($s)) {

						$sz = mysql_query("SELECT `zc`.`nr_locuri` FROM `zbor_clasa` AS `zc`
											WHERE `zc`.`id_zbor_clasa`='".$r['id_zbor_clasa']."'");
						$rz = mysql_fetch_assoc($sz);
						
						if($rz['nr_locuri']>=1){
							$i = $i + 1;
						}	
						
					}
				
					if($i != mysql_num_rows($s)) {
						$err['rez_redo'] = 'Ne pare rau, dar rezervarea nu mai poate fi reactivata, intrucat nu mai exista locuri suficiente!';
					} else {
						while( $r = mysqL_fetch_array($s)) {
							$ins_update_zb = mysql_query("UPDATE `zbor_clase` SET
															`nr_locuri` = `nr_locuri` - '1'
															WHERE `id_zbor_clasa` = '".$r['id_zbor_clasa']."' LIMIT 1");
											
							//asta e ultima- updatezi rezervari doar daca e totul ok inainte.
						}

								mysql_query("UPDATE `rezervari` SET `status`='".cinp($_GET['status'])."' WHERE `id_rezervare`='".cinp($_GET['id_rezervare'])."' LIMIT 1");
								header("Location: rezervare_op.php?show=succes");
						
					}
				}else{
					$err['rez_redo'] = 'Statusul rezervarii nu mai poate fi modificat!';
				}
			}
	}
		
	}
	
	if(isset($_POST['modificare_persoane_rezervare'])) {
		
		 $s = mysql_query("SELECT `tit`.`titulatura`,`pers`.`id_titulatura`,`pers`.`nume`,`pers`.`prenume`,`pers`.`id_persoana`
							FROM `rezervari` AS `rz` INNER JOIN `rezervare_persoana_zbor` AS `rpz` ON `rz`.`id_rezervare` = `rpz`.`id_rezervare`
							INNER JOIN `persoane` AS `pers` ON `pers`.`id_persoana`=`rpz`.`id_persoana`
							INNER JOIN `titulaturi` AS `tit` ON `tit`.`id_titulatura` = `pers`.`id_titulatura`
							WHERE `rz`.`id_rezervare` = '".$id_rezervare."'
							GROUP BY `rpz`.`id_persoana`
							ORDER BY `pers`.`id_persoana`");
			$i=0;
			while($r = mysql_fetch_array($s)) {
			$i = $i+1;
								
			if(empty($_POST['titulatura'][$i])) $err['titulatura'][$i] = $lang['EROARE_TITULATURA'];
 			else $titulatura= $_POST['titulatura'][$i];
 			
			
 			if(empty($_POST['name'][$i])) $err['name'][$i] = $lang['EROARE_NUME_EMPTY'];
 			else if(!empty($_POST['name'][$i]) && !preg_match("/^[a-z ]/i",$_POST['name'][$i])) $err['name'][$i] = $lang['EROARE_WRONG_NAME'];
 			else $name = $_POST['name'][$i];
 			echo $name;
 			if(empty($_POST['prenume'][$i])) $err['prenume'][$i] = $lang['EROARE_PRENUME_EMPTY'];
 			else if(!empty($_POST['prenume'][$i]) && !preg_match("/^[a-z ]/i",$_POST['prenume'][$i])) $err['prenume'][$i] = $lang['EROARE_WRONG_PRENUME'];
 			else $prenume = $_POST['prenume'][$i];

 			if(count($err)==0) { //daca nu apare nicio eroare, introducem in baza de date.

	 				$sql = "UPDATE `persoane` SET ";
	 				$sql .= "`id_titulatura` = '".cinp($titulatura)."',";
					$sql .= "`nume` = '".cinp($name)."',";
					$sql .= "`prenume` = '".cinp($prenume)."' ";
					$sql .= "WHERE `id_persoana` = '".cinp($r['id_persoana'])."'";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: rezervare_op.php?id_rezervare=".$id_rezervare."&show=succes");
						unset($titulatura,$nume,$prenume); 
					} 

 			}
		}
 	}

	
		
?>
<?php include('head.php'); ?>
<?php include('header.php'); ?> 
		
	
	<div class="main_content">
		<div class="wrap">
			<section>
			<?php if(!isset($_GET['id_rezervare']))  { ?>
			 <div class="rezultate_existente facturi">
			 <h3>Rezervari</h3>
					<?php if(isset($err['rez_redo'])) echo '<span class="eroare">'.$err['rez_redo'].'</span>'; ?>
					<table>
						<tr class="table_head"><td>Cod Rezervare</td><td>Nume</td><td>Prenume</td><td>Status</td><td>Actiuni</td></td>
						<?php 
							//paginare cate 2
							if(isset($_GET['page'])) $page = $_GET['page'];
							else $page = 1;
							$pas = 2;
							$s_total = mysql_num_rows(mysql_query("SELECT `rez`.`status`,`rez`.`cod`,`fct`.`nume`,`fct`.`prenume` ,`rez`.`id_rezervare`
											  FROM `rezervari` AS `rez` INNER JOIN `facturi` AS `fct` ON `rez`.`id_rezervare` = `fct`.`id_rezervare`
											  ORDER BY `rez`.`cod` "));
							echo $s_total;
							$s = mysql_query("SELECT `rez`.`status`,`rez`.`cod`,`fct`.`nume`,`fct`.`prenume` ,`rez`.`id_rezervare`
											  FROM `rezervari` AS `rez` INNER JOIN `facturi` AS `fct` ON `rez`.`id_rezervare` = `fct`.`id_rezervare`
											  ORDER BY `rez`.`cod` LIMIT ".(($page-1)*2).",".$pas." ");
									while($r_rezervare = mysql_fetch_array($s)) { 
										echo '<tr>';
											echo '<td>'.$r_rezervare['cod'].'</td>
												 <td>'.$r_rezervare['nume'].'</td>
												 <td>'.$r_rezervare['prenume'].'</td>
												<td><a href="rezervare_op.php?id_rezervare='.$r_rezervare['id_rezervare'].'&amp;status='.(($r_rezervare['status']==1) ? "0" : "1").'">'.(($r_rezervare['status']==1) ? $lang['ACTIV'] : $lang['INACTIV']).'</a></td>';

											echo '<td>
													<a href="rezervare_op.php?id_rezervare='.$r_rezervare['id_rezervare'].'">
														'.$lang['EDITEAZA'].'
													</a><br/>';
										echo '</tr>';
							} 
						?>
					</table>
					<?php for($i=1;$i<=$s_total/$pas;$i=$i+1) {
						echo '<a href="rezervare_op.php?page='.$i.'">'.$i.'</a>';
					}
					
					?>
			</div>
			<?php } ?>
			<?php if(isset($id_rezervare)) {?>
			<div>
				<h3>Editare Rezervare</h3>
				<form method="post" action="">
					<?php $s = mysql_query("SELECT `tit`.`titulatura`,`pers`.`id_titulatura`,`pers`.`nume`,`pers`.`prenume`,`pers`.`id_persoana`
											FROM `rezervari` AS `rz` INNER JOIN `rezervare_persoana_zbor` AS `rpz` ON `rz`.`id_rezervare` = `rpz`.`id_rezervare`
											INNER JOIN `persoane` AS `pers` ON `pers`.`id_persoana`=`rpz`.`id_persoana`
											INNER JOIN `titulaturi` AS `tit` ON `tit`.`id_titulatura` = `pers`.`id_titulatura`
											WHERE `rz`.`id_rezervare` = '".$id_rezervare."'
											GROUP BY `rpz`.`id_persoana`
											ORDER BY `pers`.`id_persoana`");
						$i=0;?>
					<?php while($r = mysql_fetch_array($s)) {
						$i = $i+1;
					?>
						
						<br/><br/><span> Datele persoanei  nr. <?php echo $i; ?></span> <br/><br/>
						<?php if(isset($err['titulatura'][$i])) echo '<span class="eroare">'.$err['titulatura'][$i].'</span>'; ?>
						<tr>
							<td class="form-input-name"><?php echo $lang['TITULATURA']; ?></td>
							<td class="input">
								<select name="titulatura[<?php echo $i;?>]" placeholder="<?php echo $lang['TITULATURA']; ?>"  autocomplete="off">
									<?php 
										$sql = mysql_query("SELECT * FROM `titulaturi`");
										while($rand = mysql_fetch_array($sql)) {
									?>
									<option value="<?php echo $rand['id_titulatura'];?>"<?php if(isset($r['id_titulatura']) and $r['id_titulatura']==$rand['id_titulatura']) echo 'selected'; ?>><?php echo $rand['titulatura'];?></option>
									<?php
									}
									?>	
								</select>						
								<br/>
							</td>
							<td class=""><span></span></td>
						</tr>
 						
						<?php if(isset($err['name'][$i])) echo '<span class="eroare">'.$err['name'][$i].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['NUME']; ?></td>
 							<td class="input"><input type="text"  name="name[<?php echo $i;?>]"  value="<?php if(isset($r['nume'])) echo $r['nume'];?>" autocomplete="off" required="required" /></td>
 							<td class=""><span></span></td>
 						</tr>
						
 						<?php if(isset($err['prenume'][$i])) echo '<span class="eroare">'.$err['prenume'][$i].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['PRENUME']; ?></td>
 							<td class="input"><input type="text" name="prenume[<?php echo $i;?>]"  value="<?php if(isset($r['prenume'])) echo $r['prenume'];?>"  autocomplete="off" required="required" /></td>
 							<td class=""><span></span></td>
 						</tr>

					<?php } ?>
					<div>
						<input type="submit" value="modifica" name="modificare_persoane_rezervare">
					</div>
					<div>
						<a href="rezervare_op.php" class="button_like_submit">Inapoi</a>
					</div>
				</form>
				
			</div>
			<?php } ?>
			</section>
			<aside>
			</aside>
		</div>
	</div>
<?php include('footer.php'); ?> 