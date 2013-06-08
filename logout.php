<?php require_once('config.php');?>
<?php if(isset($_SESSION['logat'])) {
	unset($_SESSION['logat']);
	unset($_SESSION['tip_user']);
	unset($_SESSION['id_utilizator']);
} ?>
<?php include('head.php'); ?>
<?php include('header.php'); ?> 
		
	
	<div class="main_content">
		<div class="wrap">
			<section>
				<p>Ati fost delogat. Va puteti reloga <a href="login.php">aici</a>.</p>
			</section>
		</div>
	</div>
<?php include('footer.php'); ?> 