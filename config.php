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
define("is_smtp","1");
define("site","http://localhost/licenta_air/");
define("email_contact","alinadanielagheorghe@gmail.com");
define("email_no_reply","alinadanielagheorghe@gmail.com");

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

$regexp="/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";

include('languages/'.$lang_file);
include('functions.php');
//Am pus aici astea pt formularul de logare. E ok? da Acum, la partea a 2-a.. cu recuperare, etc.. :| Nu stiu ce fac pe acolo.. am facut niste fisiere.. da e dezordine si in ce am facut, si in capul meu
// watch me :) ok :D
	if(isset($_POST['loginForm'])) {	
		if($_POST['userName']=="") $err['userName'] = "Introduceti utilizatorul.";
		elseif(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `nume_utilizator`='".cinp($_POST['userName'])."' LIMIT 1"))==0) $err['userName'] = "Acest utilizator nu exista."; 
			elseif(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `nume_utilizator`='".cinp($_POST['userName'])."' AND `parola`='".sha1($salt . $_POST['passwordLogin'])."' LIMIT 1"))==0) $err['userName'] = "Combinatia user/parola nu este corecta";            
				elseif(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `nume_utilizator`='".cinp($_POST['userName'])."' AND `parola`='".sha1($salt . $_POST['passwordLogin'])."' AND `status`='0' LIMIT 1"))==1) $err['userName'] = "Contul este suspendat"; 
				elseif(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `nume_utilizator`='".cinp($_POST['userName'])."' AND `parola`='".sha1($salt . $_POST['passwordLogin'])."' AND `status`='1' AND `id_grup`='1' LIMIT 1"))==1){
					$_SESSION['logat'] = 1;
					$_SESSION['tip_user'] = 'admin';
					$_SESSION['id_utilizator'] = mysql_result(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `nume_utilizator`='".cinp($_POST['userName'])."' AND `parola`='".sha1($salt . $_POST['passwordLogin'])."' AND `status`='1' AND `id_grup`='1' LIMIT 1"),0);
					header("Location: cont.php");
				}            
				elseif(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `nume_utilizator`='".cinp($_POST['userName'])."' AND `parola`='".sha1($salt . $_POST['passwordLogin'])."' AND `status`='1' AND `id_grup`='2' LIMIT 1"))==1){
					$_SESSION['logat'] = 1;
					$_SESSION['tip_user'] = 'agent';
					$_SESSION['id_utilizator'] = mysql_result(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `nume_utilizator`='".cinp($_POST['userName'])."' AND `parola`='".sha1($salt . $_POST['passwordLogin'])."' AND `status`='1' AND `id_grup`='2' LIMIT 1"),0);
					header("Location: cont.php");
				}  
				elseif(mysql_num_rows(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `nume_utilizator`='".cinp($_POST['userName'])."' AND `parola`='".sha1($salt . $_POST['passwordLogin'])."' AND `status`='1' AND `id_grup`='3' LIMIT 1"))==1){
					$_SESSION['logat'] = 1;
					$_SESSION['tip_user'] = 'normal';
					$_SESSION['id_utilizator'] = mysql_result(mysql_query("SELECT `id_utilizator` FROM `utilizatori` WHERE `nume_utilizator`='".cinp($_POST['userName'])."' AND `parola`='".sha1($salt . $_POST['passwordLogin'])."' AND `status`='1' AND `id_grup`='3' LIMIT 1"),0);
					header("Location: cont.php");
				}  
				else $err['userName'] = 'eroare';
	}
?>