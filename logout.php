<?php require_once('config.php');?>
<?php if(isset($_SESSION['logat']) and !isset($_POST['loginForm'])) {
	unset($_SESSION['logat']);
	unset($_SESSION['tip_user']);
	unset($_SESSION['id_utilizator']);
} ?>
<?php include('head.php'); ?>
<?php include('header.php'); ?> 
		
	
	<div class="main_content">
		<div class="wrap">
			<section>
				<p><?php echo $lang['DELOGAT'];?><a href="login.php"><?php echo $lang['HERE'];?></a>.</p>
			</section>
		</div>
	</div>
<?php include('footer.php'); ?> 