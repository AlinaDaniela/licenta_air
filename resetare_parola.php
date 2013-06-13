<?php require_once('config.php');?>
<?php if(isset($_SESSION['logat'])) header("Location: cont.php"); ?>
<?php 

if(isset($_POST['reset'])) {
    if(empty($_POST['email'])) $err['email'] = $lang['EROARE_NO_EMAIL'];
    if (!empty($_POST['email']) && !preg_match($regexp, $_POST['email'])) $err['email'] = $lang['EROARE_INCORRECT_EMAIL'];
    elseif(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `email`='".cinp($_POST['email'])."' LIMIT 1"))==0) $err['email'] = $lang['EROARE_NOT_R_EMAIL'];
	elseif(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `email`='".cinp($_POST['email'])."' AND `status`='1' LIMIT 1"))==0) $err['email'] = $lang['EORARE_CONFIRMARE'];
    else { 
        $email = $_POST['email'];
    }

    if(count($err)==0) {
        $code = generate_password(25);
		while(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `cod_confirmare`='".cinp($code)."' LIMIT 1"))!=0) $code = generate_password(25);
        
        $s = mysql_query("UPDATE `utilizatori` SET 
                                `cod_confirmare` = '".cinp($code)."'
                          WHERE `email`='".cinp($email)."' LIMIT 1");
            
            if($s) {
                include_once('phpmailer/class.phpmailer.php');
                $mail    = new PHPMailer();
                
                $body  = $lang['RESET_PASSWORD_M1']."<a href='".site."confirmReset.php?reset_code=".$code."&amp;email=".$email."'>".site."confirmReset.php?reset_code=".$code."&amp;email=".$email."</a>.<br /> ".$lang['RESET_PASSWORD_M2']
				." <strong>".$code."</strong><br /> ".$lang['RESET_PASSWORD_M3']." ".site."confirmReset.php".$lang['RESER_PASSWORD_M3']."<br />
				<br /> ".$lang['RESET_PASSWORD_M4'];   

				
                
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
				
				$mail->SetFrom("AirADG.Reservation@gmail.com", "ADG Air");
                $mail->Subject = $lang['EMAIL_RESET_P'];
        
                $mail->MsgHTML($body);
        
                $mail->AddAddress($email,"");
                $mail->Send();            
                             
                header("Location: resetare_parola.php?show=code_sent");                
            }
    }
}
?>
<?php include('head.php'); ?>
<?php include('header.php'); ?> 

<div class="main_content">
		<div class="wrap">
			<section>
			
				<?php if(isset($_GET['show']) and $_GET['show']=="code_sent") { ?>
				<p><?php echo $lang['COD_TRIMIS']; ?></p>
				<?php } else { ?>
				<form action="" method="post" name="register_form" action="">
					<table cellpadding="0" cellspacing="0" border="0" class="register_table">
					
						<?php if(isset($err['email'])) echo '<span class="eroare">'.$err['email'].'</span>'; ?>
 						<tr>
 							<td class="form-input-name"><?php echo $lang['EMAIL']; ?></td>
 							<td class="input"><input type="email" name="email" id="email" onBlur="validateEmail()" placeholder="<?php echo $lang['EMAIL_PLH']; ?>" value="<?php if(isset($email)) echo $email;?>" autocomplete="off" required="required" /></td>
 							<td class=""><span id="email1"></span></td>
 						</tr>
						<tr>
 							<td class="form-input-name"></td>
 							<td><input type="submit" id="x" name="reset" value="<?php echo $lang['RESETEAZA']; ?>" /></td>
 						</tr>
					
					</table>  
				</form>  
				<?php } ?>
			</section>
		</div>
</div>

<?php include('footer.php'); ?>