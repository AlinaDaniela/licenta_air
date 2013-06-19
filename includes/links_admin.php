<?php if($_SESSION['tip_user']=="admin") { ?>
<ul class="links_admin">
	<li><a href="companii.php"><?php echo $lang['MENIU_COMPANIE'] ?></a></li>
	<li><a href="zboruri.php"><?php echo $lang['MENIU_ZBORURI'] ?></a></li>
	<li><a href="fabricanti_avioane.php"><?php echo $lang['MENIU_FABRICANTI'] ?></a></li>
	<li><a href="aeroporturi.php"><?php echo $lang['MENIU_AEROPORTURI'] ?></a></li>
	<li><a href="rute.php"><?php echo $lang['MENIU_RUTE'] ?></a></li>
	<li><a href="tipuri_companii.php"><?php echo $lang['MENIU_TIPURI_COMPANII'] ?></a></li>
	<li><a href="rezervare_op.php">Rezervari</a></li>
	<li><a href="modificare_factura">Facturi</a></li>
</ul>
<?php } ?>