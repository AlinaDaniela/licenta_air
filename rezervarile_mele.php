<?php require_once('config.php');?>
 <?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user'])) header("Location: cont.php");
?>
<?php include('head.php'); ?>
<?php include('header.php'); ?> 
		
	
	<div class="main_content">
		<div class="wrap">
			<section>
				<h3> Rezervarile dumneavoastra </h3>
				<form name="alegere_optiune_rezervare" action="" method="post">
    				<label>Alegeti ce rezervari doriti sa vizualizati</label><br />
                        <?php if(isset($err['optiune_rezervare'])) echo '<span class="eroare">'.$err['optiune_rezervare'].'</span>'; ?>
    					<select name="">                            
    						<option value=""></option>		
                            <option value="1">Toate rezervarile</option>
							<option value="2">Rezervarile active</option>
							<option value="3">Rezervarile anulate</option>
							<option value="4">Rezervarile finalizate </option>		
    					</select><br/>
                    <input type="submit" name="alege_optiune_rezervare" value="Afiseaza" />
                </form>
			<div> <!-- Pt prima optiune-->
			<h3> Rezervarile dumneavoastra </h3>
				<?php $s = mysql_query("SELECT * FROM `rezervari` AS `rz` INNER JOIN `rezervare_persoana_zbor` AS `rpz` ON `rz`.`id_rezervare`=`rpz`.`id_rezervare`
										INNER JOIN `persoane` AS `pers` ON `pers`.`id_persoana` = `rpz`.`id_persoana`
										INNER JOIN `zboruri` AS `zb` ON `zb`.`id_zbor` = `rpz`.`id_zbor`
										INNER JOIN `rute` AS `rt` ON `rt`.`id_ruta` = `zb`.`id_ruta`
										INNER JOIN `aeroporturi` AS `aeroS` ON `aeroS`.`id_aeroport`=`rt`.`id_aeroport_sosire`
										INNER JOIN `aeroporturi` AS `aeroP` ON `aeroP`.`id_aeroport` = `rt`.`id_aeroport_sosire`
										INNER JOIN `tari` AS `trS` ON `aeroS`.`id_tara` = `trS`.`id_tara`
										INNER JOIN `tari` AS `trP` ON `aeroP`.`id_tara` = `trP`.`id_tara`
										WHERE `rz`.`id_utilizator`='".$id_utilizator."'");
										
				 while($s = mysql_fetch_array($s)) { ?>
				 
				 <?php } ?>
				
			</div>
			<div> <!-- Pt a 2-a optiune-->

				<?php $s = mysql_query("SELECT * FROM `rezervari` AS `rz` INNER JOIN `rezervare_persoana_zbor` AS `rpz` ON `rz`.`id_rezervare`=`rpz`.`id_rezervare`
										INNER JOIN `persoane` AS `pers` ON `pers`.`id_persoana` = `rpz`.`id_persoana`
										INNER JOIN `zboruri` AS `zb` ON `zb`.`id_zbor` = `rpz`.`id_zbor`
										INNER JOIN `rute` AS `rt` ON `rt`.`id_ruta` = `zb`.`id_ruta`
										INNER JOIN `aeroporturi` AS `aeroS` ON `aeroS`.`id_aeroport`=`rt`.`id_aeroport_sosire`
										INNER JOIN `aeroporturi` AS `aeroP` ON `aeroP`.`id_aeroport` = `rt`.`id_aeroport_sosire`
										INNER JOIN `tari` AS `trS` ON `aeroS`.`id_tara` = `trS`.`id_tara`
										INNER JOIN `tari` AS `trP` ON `aeroP`.`id_tara` = `trP`.`id_tara`
										WHERE `rz`.`id_utilizator`='".$id_utilizator."'");
										
				 while($s = mysql_fetch_array($s)) { ?>
				 
				 <?php } ?>
				
			</div>
			<div> <!-- Pt a 3-a optiune-->
			<h3> Rezervarile dumneavoastra </h3>
				<?php $s = mysql_query("SELECT * FROM `rezervari` AS `rz` INNER JOIN `rezervare_persoana_zbor` AS `rpz` ON `rz`.`id_rezervare`=`rpz`.`id_rezervare`
										INNER JOIN `persoane` AS `pers` ON `pers`.`id_persoana` = `rpz`.`id_persoana`
										INNER JOIN `zboruri` AS `zb` ON `zb`.`id_zbor` = `rpz`.`id_zbor`
										INNER JOIN `rute` AS `rt` ON `rt`.`id_ruta` = `zb`.`id_ruta`
										INNER JOIN `aeroporturi` AS `aeroS` ON `aeroS`.`id_aeroport`=`rt`.`id_aeroport_sosire`
										INNER JOIN `aeroporturi` AS `aeroP` ON `aeroP`.`id_aeroport` = `rt`.`id_aeroport_sosire`
										INNER JOIN `tari` AS `trS` ON `aeroS`.`id_tara` = `trS`.`id_tara`
										INNER JOIN `tari` AS `trP` ON `aeroP`.`id_tara` = `trP`.`id_tara`
										WHERE `rz`.`id_utilizator`='".$id_utilizator."'");
										
				 while($s = mysql_fetch_array($s)) { ?>
				 
				 <?php } ?>
				
			</div>
			<div> <!-- Pt a 4-a optiune-->
			<h3> Rezervarile dumneavoastra </h3>
				<?php $s = mysql_query("SELECT * FROM `rezervari` AS `rz` INNER JOIN `rezervare_persoana_zbor` AS `rpz` ON `rz`.`id_rezervare`=`rpz`.`id_rezervare`
										INNER JOIN `persoane` AS `pers` ON `pers`.`id_persoana` = `rpz`.`id_persoana`
										INNER JOIN `zboruri` AS `zb` ON `zb`.`id_zbor` = `rpz`.`id_zbor`
										INNER JOIN `rute` AS `rt` ON `rt`.`id_ruta` = `zb`.`id_ruta`
										INNER JOIN `aeroporturi` AS `aeroS` ON `aeroS`.`id_aeroport`=`rt`.`id_aeroport_sosire`
										INNER JOIN `aeroporturi` AS `aeroP` ON `aeroP`.`id_aeroport` = `rt`.`id_aeroport_sosire`
										INNER JOIN `tari` AS `trS` ON `aeroS`.`id_tara` = `trS`.`id_tara`
										INNER JOIN `tari` AS `trP` ON `aeroP`.`id_tara` = `trP`.`id_tara`
										WHERE `rz`.`id_utilizator`='".$id_utilizator."'");
										
				 while($s = mysql_fetch_array($s)) { ?>
				 
				 <?php } ?>
				
			</div>
			</section>
			<aside>
			</aside>
		</div>
	</div>
<?php include('footer.php'); ?> 