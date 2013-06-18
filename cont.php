<?php require_once('config.php');?>
<?php if(!isset($_SESSION['logat'])) header("Location: login.php"); ?>
<?php include('head.php'); ?>
<?php include('header.php'); ?> 
		
	
	<div class="main_content">
		<div class="wrap">
			<aside>
				<?php include("includes/links_admin.php"); ?>
			</aside>
		</div>
	</div>
<?php include('footer.php'); ?> 