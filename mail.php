<?php 
include_once('phpmailer/class.phpmailer.php');
					$mail = new PHPMailer();
					
					
					$body = "
					Hello,<br />
					V-ati inregistrat cu succes la GAD Air!<br /><br />
					";              

						$mail->IsSMTP(); // enable SMTP
						$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
						$mail->SMTPAuth = true;  // authentication enabled
						$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
						$mail->Host = 'smtp.gmail.com';
						$mail->Port = 465; 
						$mail->Username = "alinadanielagheorghe@gmail.com";  
						$mail->Password = "21boring1991";           
						$mail->SetFrom("alinadanielagheorghe@gmail.com", "Alina Alina");

					$mail->Subject = "Welcome!";
			
					$mail->MsgHTML($body); 
			
					$mail->AddAddress("bogdan.oasa@gmail.com","Test TestSender");         
					if($mail->Send()) {
						//header("Location: congratulations.php");    
						echo 'sent';
					} 
?>