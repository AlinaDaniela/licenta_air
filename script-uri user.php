<?php 


//am bagat in functions.php codul de generate password. (genereaza un string unic in tabelul din baza de  date, ca referinta - 25 de caractere - code)
$code = generate_password(25);
            while(mysql_num_rows(mysql_query("SELECT `idUser` FROM `users` WHERE `code`='".cinp($code)."' LIMIT 1"))!=0) $code = generate_password(25);
            
            $s = mysql_query("INSERT INTO `users` SET 
                                `status` = 'unconfirmed',
                                `code` = '".cinp($code)."',
                                `f_name`='".cinp($account['f_name'])."',   
                                `l_name`='".cinp($account['l_name'])."',   
                                `email`='".cinp($account['email'])."',       
                                `password`='".md5($account['password'])."',  
                                `gender`='".cinp($account['gender'])."', 
                                `date_of_birth`='".cinp($account['date_of_birth'])."', 
                                `city`='".cinp($account['city'])."', 
                                `country`='".cinp($account['country'])."',      
                                `zip`='".cinp($account['zip'])."', 
                                `major1`='".cinp($account['major1'])."',   
                                `exam_date`='".cinp($account['exam_date'])."', 
                                `gre_before`='".cinp($account['gre_before'])."', 
                                `obtained_verbal`='".cinp($scores['obtained_verbal'])."', 
                                `obtained_quantitative`='".cinp($scores['obtained_quantitative'])."', 
                                `obtained_issue`='".cinp($scores['obtained_issue'])."', 
                                `obtained_argument`='".cinp($scores['obtained_argument'])."',  
                                `needed_verbal`='".cinp($scores['needed_verbal'])."', 
                                `needed_quantitative`='".cinp($scores['needed_quantitative'])."', 
                                `needed_issue`='".cinp($scores['needed_issue'])."', 
                                `needed_argument`='".cinp($scores['needed_argument'])."',   
                                `verbal`='".cinp($scores['verbal'])."', 
                                `quantitative`='".cinp($scores['quantitative'])."', 
                                `issue`='".cinp($scores['issue'])."', 
                                `argument`='".cinp($scores['argument'])."',    
                                 `registration_date`='".time()."'
            ");

if($s) {
                include_once('phpmailer/class.phpmailer.php');
                $mail    = new PHPMailer();
                
                $body    = "
                Hello {$account['f_name']},<br />
                You have successfully registered to Nucleus!<br /><br />
                
                You can start using your account after confirming <a href='".site."confirm.php?code={$code}&amp;email={$account['email']}'>here</a>.<br /><br />    
                
                <strong>".site."confirm.php?code={$code}&amp;email={$account['email']}</strong><br /><br /><br />
                
                
                Thank you for choosing Nucleus!            
                ";              
                                
                if(is_smtp==1) {
                    $mail->isSMTP();
                    $mail->Host = "smtp.rdslink.ro";
                }
                
                $mail->From     = email_no_reply;
                $mail->FromName = "Nucleus";
                $mail->Subject = "Welcome to Nucleus!";
        
                $mail->MsgHTML($body); 
        
                $mail->AddAddress($account['email'],"{$account['f_name']} {$account['l_name']}");         
                if($mail->Send()) {
                    header("Location: congratulations.php");    
                }            
            }



//mai jos e codul de pe pagina de verificare a codului de confirmare:
            if(isset($_GET['code'])) {
    if(isset($_GET['email'])) {
        if(mysql_num_rows(mysql_query("SELECT `idUser` FROM `users` WHERE `code`='".cinp($_GET['code'])."' AND `email`='".cinp($_GET['email'])."' AND `status`='unconfirmed' LIMIT 1"))==0) $response = "This account doesn't exist, or is already confirmed.";
        else {
            mysql_query("UPDATE `users` SET `status`='active' WHERE `code`='".cinp($_GET['code'])."' AND `email`='".cinp($_GET['email'])."' LIMIT 1");
            $response = "Congratulations, you just took the first step towards mastering the GRE! Click <a href='login.php' style='text-decoration: underline; color: inherit;'>here</a> to log in.";
        }
    } else $response = "No e-mail submitted.";    
} else $response = "No code submitted.";



//mai jos e codul de pe pagina de unde cere resetare parola, iti trebuie un formular unde sa bage e-mail-ul - ti-ar mai trebui o pagina de genul asta, pt cerere retrimitere cod de confirmare
if(isset($_POST['submit'])) {
    if(empty($_POST['email'])) $err['email'] = "Please fill in your e-mail address.";
    if (!empty($_POST['email']) && !preg_match($regexp, $_POST['email'])) $err['email'] = "This e-mail address is incorrect.";
    elseif(mysql_num_rows(mysql_query("SELECT `idUser` FROM `users` WHERE `email`='".cinp($_POST['email'])."' LIMIT 1"))==0) $err['email'] = "This e-mail address is unregistered.";
    else { 
        $email = $_POST['email'];
    }

    if(count($err)==0) {
        $code = generate_password(25);
        while(mysql_num_rows(mysql_query("SELECT `idUser` FROM `users` WHERE `reset_code`='".cinp($code)."' LIMIT 1"))!=0) $code = generate_password(25);
        
        $s = mysql_query("UPDATE `users` SET 
                                `reset_code` = '".cinp($code)."'
                          WHERE `email`='".cinp($email)."' LIMIT 1");
            
            if($s) {
                include_once('phpmailer/class.phpmailer.php');
                $mail    = new PHPMailer();
                
                $body    = "
                In order to reset your password, we must verify that you asked for this. If you did, please go to the following URL: <a href='".site."reset_password.php?reset_code={$code}&amp;email={$email}'>".site."reset_password.php?reset_code={$code}&amp;email={$email}</a>.<br />
                Your reset code is: <strong>{$code}</strong><br />
                If the address above doesn't work, please go to: ".site."reset_password.php and input manually.<br />
                <br />   
                
                
                If you didn't ask for a password reset, please ignore this e-mail.          
                ";              
                
                if(is_smtp==1) {
                    $mail->isSMTP();
                    $mail->Host = "smtp.rdslink.ro";
                }
                
                $mail->From     = "no-reply@nucleus.com";
                $mail->FromName = "Nucleus";
                $mail->Subject = "Reset your password";
        
                $mail->MsgHTML($body);
        
                $mail->AddAddress($email,"");
                $mail->Send();            
                             
                header("Location: lost_password.php?show=code_sent");                
            }
    }
}





//mai jos e codul din pagina de un se reseteaza parola, cand vine din e-mail
if(isset($_GET['reset_code'])) {
    if(isset($_GET['email'])) {
        if(mysql_num_rows(mysql_query("SELECT `idUser` FROM `users` WHERE `reset_code`='".cinp($_GET['reset_code'])."' AND `email`='".cinp($_GET['email'])."'  LIMIT 1"))==0) $response = "The reset code is incorrect, or a password reset wasn't asked for this e-mail address.";
        else {
            $new_password = generate_password(10);
            $s = mysql_query("UPDATE `users` SET `reset_code`='',`password`='".md5($new_password)."' WHERE `reset_code`='".cinp($_GET['reset_code'])."' AND `email`='".cinp($_GET['email'])."' LIMIT 1");
            if($s) {
                include_once('phpmailer/class.phpmailer.php');
                $mail    = new PHPMailer();
                
                $body    = "
                Your new password is: <strong>{$new_password}</strong><br />
                You can login <a href='".site."login.php'>here</a>.<br /><br />                   
                
                Thank you for choosing Nucleus!
                ";              
                if(is_smtp==1) {
                    $mail->isSMTP();
                    $mail->Host = "smtp.rdslink.ro";
                }
                
                $mail->From     = "no-reply@nucleus.com";
                $mail->FromName = "Nucleus";
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
</form>
";





?>