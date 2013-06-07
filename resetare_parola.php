<?php require_once('config.php');?>
<?php 

if(isset($_POST['reset'])) {
    if(empty($_POST['email'])) $err['email'] = "Please fill in your e-mail address.";
    if (!empty($_POST['email']) && !preg_match($regexp, $_POST['email'])) $err['email'] = "This e-mail address is incorrect.";
    elseif(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `email`='".cinp($_POST['email'])."' LIMIT 1"))==0) $err['email'] = "This e-mail address is unregistered.";
	elseif(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `email`='".cinp($_POST['email'])."' AND `status`='1' LIMIT 1"))==0) $err['email'] = "This e-mail address is unconfirmed.";
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
                
                $body    = "
                In order to reset your password, we must verify that you asked for this. If you did, please go to the following URL: <a href='".site."confirmReset.php?reset_code={$code}&amp;email={$email}'>".site."confirmReset.php?reset_code={$code}&amp;email={$email}</a>.<br />
                Your reset code is: <strong>{$code}</strong><br />
                If the address above doesn't work, please go to: ".site."confirmReset.php and input manually.<br />
                <br />   
                
                
                If you didn't ask for a password reset, please ignore this e-mail.          
                ";   

				
                
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
                $mail->Subject = "Reset your password";
        
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