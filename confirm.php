<?php require_once("config.php");?>
<?php if(isset($_SESSION['logat'])) header("Location: cont.php"); ?>
<?php 

if(isset($_GET['code'])) {
    if(isset($_GET['email'])) {
        if(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `cod_confirmare`='".cinp($_GET['code'])."' AND `email`='".cinp($_GET['email'])."' AND `status`='0' LIMIT 1"))==0) $response = $lang['CONFIRM_ER1'];
        else {
            mysql_query("UPDATE `utilizatori` SET `status`='1' WHERE `cod_confirmare`='".cinp($_GET['code'])."' AND `email`='".cinp($_GET['email'])."' LIMIT 1");
            $response =  $lang['CONFIRM_GOOD'] ."<a href='login.php' style='text-decoration: underline; color: inherit;'>" .$lang['HERE']. "</a>".$lang['CONFIRM_GOOD_1'];
        }
    } else $response = $lang['CONFIRM_ER2'];    
} else $response = $lang['CONFIRM_ER3'];

?>
<?php include_once 'head.php'; ?>
<?php include('header.php'); ?> 
<div class="main_content">
		<div class="wrap">
			<section>
<?php echo $response; ?>
			</section>
		</div>
</div>

<?php include('footer.php'); ?>
