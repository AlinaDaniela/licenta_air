<?php require_once('config.php');?>
<?php if(!isset($_SESSION['logat'])) header("Location: login.php"); ?>
<?php include('head.php'); ?>
<?php include('header.php'); ?> 
		
	
	<div class="main_content">
		<div class="wrap">
			<?php if($_SESSION['tip_user']=="admin") { ?>
			<aside class="admin_menu">
			<ul>
				<li><a href="tipuri_companii.php">Tipuri companii aeriene</a></li>
				<li><a href="companii.php">Companii</a></li>
				<li><a href="fabricanti_avioane.php">Fabricanti de avioane</a></li>
				<li><a href="avioane.php">Avioane</a></li>
				<li><a href="rute.php">Rute</a></li>
				<li><a href="zboruri.php">Zboruri</a></li>
				<li><a href="utilizatorEdit.php">Utilizatori</a></li>
			</ul>
			</aside>
			<?php } ?>
		</div>
	</div>
<?php include('footer.php'); ?> 