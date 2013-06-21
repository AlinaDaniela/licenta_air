<?php require_once('config.php');?>
<?php include('head.php'); ?>
<?php include('header.php'); ?>
<?php
       if(isset($_POST['submit'])) {
        if(empty($_POST['nume'])) $err['nume'] = "Va rugam completati numele.";
        else $nume = $_POST['nume'];
        
        if(empty($_POST['telefon'])) $err['telefon'] = "Va rugam completati telefonul.";
        elseif(strlen($_POST['telefon'])!=10 or !is_numeric($_POST['telefon'])) $err['telefon'] = "Numarul de telefon nu este corect. Trebuie sa contina 10 cifre.";
        else $telefon = $_POST['telefon'];
        
        if(empty($_POST['email'])) $err['email'] = "Va rugam completati adresa de e-mail.";
        elseif (!empty($_POST['email']) && !preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $_POST['email'])) $err['email'] = "Aceasta adresa de e-mail este incorecta.";
        else $email = $_POST['email'];
        
        if(empty($_POST['mesaj'])) $err['mesaj'] = "Va rugam completati mesajul.";
        else $mesaj = $_POST['mesaj'];
        
        if(count($err)==0) {
		
			include_once('phpmailer/class.phpmailer.php');
			$mail = new PHPMailer();	
			$body = "Mesaj primit de la ".$nume." ce are adresa de mail ".$email." si numarul de telefon ".$telefon.". "."Mesajul transmis este: ".$mesaj;     
				
			if(is_smtp==1) {
				$mail->IsSMTP(); // enable SMTP
				$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
				$mail->SMTPAuth = true;  // authentication enabled
				$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
				$mail->Host = 'smtp.gmail.com';
				$mail->Port = 465; 
				$mail->Username = "AirADG.Reservation@gmail.com";  
				$mail->Password = "airadg1234";  
			}
				
				$subject = 'Mesaj Nou de la '.$nume;
				$mail->SetFrom($email, "ADG Air");
				$mail->Subject = $subject;
				$mail->MsgHTML($body); 
			
				$mail->AddAddress("AirADG.Reservation@gmail.com",$lang['REG_MSG6']);         
				if($mail->Send()) {    
					echo 'sent';
				} 
				else echo 'eroare';
        }
        
    }
?>	
<div class="main_content">
	<div class="wrap">
		<section>
			<h3>Trimiteti-ne un mesaj</h3>
			<form action="" id="contactform" name="contact_form" method="post">
                    <?php if(isset($succes)) echo '<span class="succes">'.$succes.'</span>'; ?>
					<?php if(isset($err['nume'])) echo '<span class="eroare">'.$err['nume'].'</span>'; ?>
                	<p><label>Nume:</label><input type="text" name="nume" value="<?php if(isset($nume)) echo $nume;?>" class="inp" /></p>
                    <?php if(isset($err['email'])) echo '<span class="eroare">'.$err['email'].'</span>'; ?>
                    <p><label>Email:</label><input type="text" name="email" value="<?php if(isset($email)) echo $email;?>" class="inp" /></p>
                    <?php if(isset($err['telefon'])) echo '<span class="eroare">'.$err['telefon'].'</span>'; ?>
                    <p><label>Telefon:</label><input type="text" name="telefon" value="<?php if(isset($telefon)) echo $telefon;?>" class="inp" /></p>
                    <?php if(isset($err['mesaj'])) echo '<span class="eroare">'.$err['mesaj'].'</span>'; ?>
                    <p><label>Mesaj:</label><textarea name="mesaj" id="txtarea" rows="" cols=""><?php if(isset($mesaj)) echo $mesaj;?></textarea></p>
                    <p><input type="submit" name="submit" value="Trimite" id="submitbtn" /></p>
            </form>           
		</section>
	</div>
</div>
<?php include('footer.php'); ?> 