<?php require_once('config.php');?>
<?php if(isset($_SESSION['logat'])) header("Location: cont.php"); ?>
<?php if(isset($_GET['reset_code'])) {
    if(isset($_GET['email'])) {
        if(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `cod_confirmare`='".cinp($_GET['reset_code'])."' AND `email`='".cinp($_GET['email'])."'  LIMIT 1"))==0) $response = $lang['EROARE_CR_1'];
        else {
            $new_password = generate_password(10);
            $s = mysql_query("UPDATE `utilizatori` SET `cod_confirmare`='',`parola`='".sha1($salt.$new_password)."' WHERE `cod_confirmare`='".cinp($_GET['reset_code'])."' AND `email`='".cinp($_GET['email'])."' LIMIT 1");
            if($s) {
                include_once('phpmailer/class.phpmailer.php');
                $mail    = new PHPMailer();
                
                $body    = $lang['CR_MSG1']. "<strong>{$new_password}</strong><br />" . $lang['CR_MSG2'] . 
                " <a href='".site."login.php'>" .$lang['CR_MSG3']. "</a>.<br /><br /> " . $lang['CR_MSG4'];                              
                if(is_smtp==1) {
                     $mail->IsSMTP(); 
						$mail->SMTPDebug = 0; 
						$mail->SMTPAuth = true;  
						$mail->SMTPSecure = 'ssl'; 
						$mail->Host = 'smtp.gmail.com';
						$mail->Port = 465; 
						$mail->Username = "AirADG.Reservation@gmail.com";  
						$mail->Password = "airadg1234";           
                }
                
                $mail->SetFrom("AirADG.Reservation@gmail.com", "ADG Air");
                $mail->Subject = $lang['CR_MSG5'];
        
                $mail->MsgHTML($body);
        
                $mail->AddAddress($_GET['email'],"");
                if(!$mail->Send()){
					$err['eroare'] = 'Mesajul nu a putut fi trimis';
				} else echo 'Succes!';
            }
            $response = $lang['CR_MSG6'] ." <a href='login.php' style='text-decoration: underline; color: inherit;'>" .$lang['CR_MSG7']. "</a>.";
        }
    } else $response = $lang['CR_MSG8'] ."<br /><br />


<form name='reset_form' class='login_f2' method='get' action=''>
<div>
<label>" . $lang['CR_MSG9'] ."</label><input type='text' name='reset_code' value='' />
</div>
<div>
<label>E-mail:</label><input type='text' name='email' value='' />
</div>
<div><label></label><input type='submit' name='reset' value='Submit' class='button yellow rounded' /></div>
</form>";    
} else $response = $lang['CR_MSG10']."<br /><br />
<form name='reset_form' class='login_f2' method='get' action=''>
<div>
<label>" .$lang['CR_MSG11']. "</label><input type='text' name='reset_code' value='' />
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