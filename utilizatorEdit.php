<?php require_once("config.php");?>
 <?php 
if(!isset($_SESSION['id_utilizator'])) header("Location: login.php"); 
if(!isset($_SESSION['tip_user']) or $_SESSION['tip_user']!="admin") header("Location: cont.php");
?>
<?php 
	if(isset($_POST['alege_user'])) {
    if(empty($_POST['id_utilizator'])) $err['id_utilizator'] = "Va rugam alegeti utilizator.";
    else {
        header("Location: utilizatorEdit.php?id_utilizator=".$_POST['id_utilizator']);
		}
	}
	if(isset($_GET['id_utilizator'])) {
    $s = mysql_query("SELECT * FROM `utilizatori` WHERE `id_utilizator`='".mysql_real_escape_string($_GET['id_utilizator'])."' LIMIT 1");
    $r = mysql_fetch_assoc($s);
    $id_utilizator = $_GET['id_utilizator'];
    $nume = $r['nume'];
    $grup = $r['id_grup'];
    $prenume = $r['prenume'];
    $adresa = $r['adresa'];
    $telefon = $r['telefon'];
    $email = $r['email'];
	$oras = $r['oras'];
    $status = $r['status'];
	}

    if(isset($_POST['editeaza_user'])) {
        if(empty($_POST['grup']) or !is_numeric($_POST['grup'])) $err['grup'] = "Alegeti un grup de utilizatori";
    	else $grup = $_POST['grup'];
    	
    	if(empty($_POST['nume'])) $err['nume'] = "Introduceti numele";
    	else $nume = $_POST['nume'];
    	
		if(empty($_POST['prenume'])) $err['prenume'] = "Introduceti prenumele";
    	else $prenume = $_POST['prenume'];
    	
    	if(empty($_POST['adresa'])) $err['adresa'] = "Introduceti adresa";
    	else $adresa = $_POST['adresa'];
        
        if(empty($_POST['email'])) $err['email'] = "Introduceti adresa de e-mail";
        elseif (!empty($_POST['email']) && !preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $_POST['email'])) $err['email'] = "Aceasta adresa de e-mail este incorecta.";
        elseif(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `email`='".mysql_real_escape_string($_POST['email'])."' AND `id_utilizator`<>'".mysql_real_escape_string($id_utilizator)."' LIMIT 1"))!=0) $err['email'] = "Aceasta adresa de e-mail exista deja in baza noastra de date.";
    	else $email = $_POST['email'];        
        
        if(empty($_POST['telefon'])) $err['telefon'] = "Introduceti telefon";
        elseif(strlen($_POST['telefon'])!=10 or !is_numeric($_POST['telefon'])) $err['telefon'] = "Telefonul trebuie sa fiu un numar format din 10 cifre.";
    	else $telefon = $_POST['telefon'];
        
        if(isset($_POST['status'])) $status = 1;
        else $status = 0;
                
        if(count($err)==0) {        
            $sql = "UPDATE `utilizatori` SET ";
            $sql .= "`nume`='".mysql_real_escape_string($nume)."',";
            $sql .= "`id_grup`='".mysql_real_escape_string($grup)."',";
            $sql .= "`prenume`='".mysql_real_escape_string($prenume)."',";
            $sql .= "`adresa`='".mysql_real_escape_string($adresa)."',";
            $sql .= "`email`='".mysql_real_escape_string($email)."',";
            $sql .= "`telefon`='".mysql_real_escape_string($telefon)."',";
            $sql .= "`status`='".mysql_real_escape_string($status)."'";  
            $sql .= " WHERE `id_utilizator`='".mysql_real_escape_string($id_utilizator)."' LIMIT 1";
            
            
            $query = mysql_query($sql);
            
            if($query) {
                $succes = "Utilizatorul a fost editat. "; 
            }
        }        
    }

?>
<?php include('head.php'); ?>
<?php include('header.php'); ?> 
	
	<div class="main_content">
		<div class="wrap">
		<section>
				<h4>Modificare Utilizator</h4>
                    <form name="alegere_utilizator" action="" method="post">
    				<label>Selectati utilizatorul pe care doriti sa il modificati:</label><br />
                        <?php if(isset($err['id_utilizator'])) echo '<span class="eroare">'.$err['id_utilizator'].'</span>'; ?>
    					<select name="id_utilizator" id="id_utilizator">                            
    						<option value=""></option>		
                            <?php $s = mysql_query("SELECT * FROM `utilizatori` ORDER BY `nume` ASC, `prenume` ASC");
                                while($r = mysql_fetch_array($s)) { 
                            ?>
                            <option value="<?php echo $r['id_utilizator'];?>" <?php if(isset($id_utilizator) and $id_utilizator==$r['id_utilizator']) echo 'selected'; ?> ><?php echo $r['nume'].' '.$r['prenume'].' ('.$r['nume_utilizator'].')';?></option>		
                            <?php } ?>
    					</select><br/>
                        <input type="submit" name="alege_user" value="Alege Utilizator" />
                    </form><br /><br />
                        
                    <?php if(isset($id_utilizator)) { ?>
    				<form method="post" name="modificare_utilizator" id="modificare_utilizator" action="" > 
                        <?php if(isset($succes)) echo '<span class="succes">'.$succes.'</span>'; ?>
    					<?php if(isset($err['grup'])) echo '<span class="eroare">'.$err['grup'].'</span>'; ?>
    					<label>Grup:</label>
    					<select name="grup" id="grup" >
    						<?php 
    							$sql = mysql_query("SELECT * FROM `grupuri_utilizatori`");
    							while($rand = mysql_fetch_array($sql)) {
    						?>
    						<option value="<?php echo $rand['id_grup_utilizatori'];?>"<?php if(isset($grup) and $grup==$rand['id_grup_utilizatori']) echo 'selected';?>><?php echo $rand['denumire_grup'];?></option>
    						<?php
    						}
    						?>						
    					</select><br/>
    					
    										
    					<?php if(isset($err['nume'])) echo '<span class="eroare">'.$err['nume'].'</span>'; ?>
    					<label>Nume:</label><input type="text" name="nume" class="camp" value="<?php if(isset($nume)) echo $nume;?>"/><br/>
   
   						<?php if(isset($err['prenume'])) echo '<span class="eroare">'.$err['prenume'].'</span>'; ?>
   						<label>Prenume:</label><input type="text" name="prenume" class="camp" value="<?php if(isset($prenume)) echo $prenume;?>"/><br/>
							
						<?php if(isset($err['adresa'])) echo '<span class="eroare">'.$err['adresa'].'</span>'; ?>
    					<label>Adresa:</label><input type="text" name="adresa" class="camp" value="<?php if(isset($adresa)) echo $adresa; ?>"/><br/>
						
    					<?php if(isset($err['email'])) echo '<span class="eroare">'.$err['email'].'</span>'; ?>
    					<label>Email:</label><input type="text" name="email" class="camp" value="<?php if(isset($email)) echo $email; ?>"/><br/>
    					
    					<?php if(isset($err['telefon'])) echo '<span class="eroare">'.$err['telefon'].'</span>'; ?>
    					<label>Telefon:</label><input type="text" name="telefon" class="camp" value="<?php if(isset($telefon)) echo $telefon; ?>"/><br/>
    					
                        <label>Status</label><input type="checkbox" name="status" class="camp" value="1" <?php if(isset($status) and $status==1) echo "checked"; ?>/><br/>
                        
    					<input type="submit" class="butonactiune" name="editeaza_user" value="Editeaza User" />
    				</form>
                    
                    <?php } ?>
			</section>
		</div>
	</div>
<?php include('footer.php'); ?> 