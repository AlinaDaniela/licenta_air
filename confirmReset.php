<?php require_once('config.php');?>

<?php if(isset($_GET['reset_code'])) {
    if(isset($_GET['email'])) {
        if(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `cod_confirmare`='".cinp($_GET['reset_code'])."' AND `email`='".cinp($_GET['email'])."'  LIMIT 1"))==0) $response = "The reset code is incorrect, or a password reset wasn't asked for this e-mail address.";
        else {
            $new_password = generate_password(10);
            $s = mysql_query("UPDATE `utilizatori` SET `cod_confirmare`='',`parola`='".sha1($salt.$new_password)."' WHERE `cod_confirmare`='".cinp($_GET['reset_code'])."' AND `email`='".cinp($_GET['email'])."' LIMIT 1");
            if($s) {
                include_once('phpmailer/class.phpmailer.php');
                $mail    = new PHPMailer();
                
                $body    = "
                Your new password is: <strong>{$new_password}</strong><br />
                You can login <a href='".site."login.php'>here</a>.<br /><br />                   
                
                Thank you for choosing Nucleus!
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
                $mail->Subject = "New Password";
        
                $mail->MsgHTML($body);
        
                $mail->AddAddress($_GET['email'],"");
                $mail->Send();      
            }
            $response = "Your new password has been e-mailed to you! You can log in <a href='login.php' style='text-decoration: underline; color: inherit;'>here</a>.";
        }
    } else $response = "No e-mail submitted.<br /><br />


<form name='reset_form' class='login_f2' method='get' action=''>
<div>
<label>Reset code:</label><input type='text' name='reset_code' value='' />
</div>
<div>
<label>E-mail:</label><input type='text' name='email' value='' />
</div>
<div><label></label><input type='submit' name='reset' value='Submit' class='button yellow rounded' /></div>
</form>";    
} else $response = "No reset code submitted.<br /><br />
<form name='reset_form' class='login_f2' method='get' action=''>
<div>
<label>Reset code:</label><input type='text' name='reset_code' value='' />
</div>
<div>
<label>E-mail:</label><input type='text' name='email' value='' />
</div>
<div><label></label><input type='submit' name='reset' value='Submit' class='button yellow rounded' /></div>
</form>";
?>
<?php include('head.php'); ?>
<?php include('header.php'); ?> 

<div class="main_content">
		<div class="wrap">
			<section>
			
				<?php echo $response; ?>
			</section>
		</div>
</div>

<?php include('footer.php'); ?>