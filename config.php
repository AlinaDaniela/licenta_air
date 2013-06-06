<?php 
	session_start(); 
	set_time_limit(0); 
	error_reporting(E_ALL); 
	$err = array(); //initializez vectorul err pe care o sa-l utilizez la fiecare formular. Daca e gol, se poate merge mai departe :)


		 $AdresaBazaDate = "localhost"; 
		 $UtilizatorBazaDate = "root"; 
		 $ParolaBazaDate = ""; 
		 $NumeBazaDate = "airreservation"; 

	$conexiune = mysql_connect($AdresaBazaDate,$UtilizatorBazaDate,$ParolaBazaDate) 
	or die("Nu ma pot conecta la MySQL!"); 
	mysql_select_db($NumeBazaDate,$conexiune) or die("Nu gasesc baza de date!"); 
?>