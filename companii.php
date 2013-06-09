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
	 				$sql .= " WHERE `id_tip_companie` = '".cinp($id_companie)."' LIMIT 1";
	 				
	 				$query = mysql_query($sql);
	 				
	 				if($query) { 
						header("Location: tipuri_companii.php?id_tip=".$id_companie."&show=succes");
						unset($fabricant); 
					} 
				}

 			}        
 		}    
		
		//AICI AI VALIDAREA FORMULARULUI DE INTRODUCERE MENIU NOU/ sau de editare, ca mai sus
		
		
		//AICI AI VALIDAREA FORMULARULUI DE ASOCIERE MENIU
		
		     
		
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
				<?php 
				//DACA SE INTRODUCE COMPANIE
				if(!isset($_GET['do'])){ 
				?>
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
				
				<?php if(isset($id_companie)) { ?>
					<a href="companii.php?id_companie=<?php echo $id_companie;?>&amp;do=adauga_meniu">Adauga meniu nou</a>
					<a href="companii.php?id_companie=<?php echo $id_companie;?>&amp;do=asociaza_meniu">Asociaza meniu companiei</a>
				<?php } ?>
				
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
				<?php } else { ?>
					<?php if(isset($id_companie)) { ?>
						<?php if($_GET['do']=="adauga_meniu")) { ?>
							AICI AI UN FORMULAR DE INTRODUCERE SI DE EDITARE
								- aici se introduc chestii noi in tip_meniu, independent de compania asta in care esti acum, e ca si cum ai avea un fisier meniuri.php
								
							MAI JOS UNU DE SELECTARE
								- aici ai de unde le poti alege sa le editezi, ca pana acum, nimic special
						<?php } elseif($_GET['do']=="asociaza_meniu") { ?>
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
						<?php } ?>
					
					<?php } ?>
				<?php } ?>
				
			</section>
			<aside>
			</aside>
		</div>
	</div>

<?php include('footer.php'); ?> 