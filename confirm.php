<?php require_once("config.php");?>
<?php 

if(isset($_GET['code'])) {
    if(isset($_GET['email'])) {
        if(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `cod_confirmare`='".cinp($_GET['code'])."' AND `email`='".cinp($_GET['email'])."' AND `status`='0' LIMIT 1"))==0) $response = "This account doesn't exist, or is already confirmed.";
        else {
            mysql_query("UPDATE `utilizatori` SET `status`='1' WHERE `cod_confirmare`='".cinp($_GET['code'])."' AND `email`='".cinp($_GET['email'])."' LIMIT 1");
            $response = "Congratulations, you just took the first step towards mastering the GRE! Click <a href='login.php' style='text-decoration: underline; color: inherit;'>here</a> to log in.";
        }
    } else $response = "No e-mail submitted.";    
} else $response = "No code submitted.";

echo $response;
?>
<?php include_once 'head.php'; ?>
<?php include('header.php'); ?> 
