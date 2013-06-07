<?php 
session_start(); 
set_time_limit(0); 
error_reporting(E_ALL); 
header('Cache-control: private'); // IE 6 FIX

$err = array(); //initializez vectorul err pe care o sa-l utilizez la fiecare formular. Daca e gol, se poate merge mai departe :)


		 $AdresaBazaDate = "localhost"; 
		 $UtilizatorBazaDate = "root"; 
		 $ParolaBazaDate = ""; 
		 $NumeBazaDate = "airreservation"; 

	$conexiune = mysql_connect($AdresaBazaDate,$UtilizatorBazaDate,$ParolaBazaDate) 
	or die("Nu ma pot conecta la MySQL!"); 
	mysql_select_db($NumeBazaDate,$conexiune) or die("Nu gasesc baza de date!"); 

	
$salt = "f#@V)Hu^%Hgfds";


// Pt mail
define("is_smtp","0");

if(isSet($_GET['lang']))
{
$lang = $_GET['lang'];

// register the session and set the cookie
$_SESSION['lang'] = $lang;

setcookie("lang", $lang, time() + (3600 * 24 * 30));
}
else if(isSet($_SESSION['lang']))
{
	$lang = $_SESSION['lang'];
}
else if(isSet($_COOKIE['lang']))
{
	$lang = $_COOKIE['lang'];
}
else
{
	$lang = 'ro';
}

switch ($lang) {
  case 'en':
  $lang_file = 'lang.en.php';
  break;

  case 'ro':
  $lang_file = 'lang.ro.php';
  break;

  default:
  $lang_file = 'lang.ro.php';

}

include('languages/'.$lang_file);
include('functions.php');
?>