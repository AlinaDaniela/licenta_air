<?php

function this_page() {
	$this_page = explode("/",$_SERVER['PHP_SELF']);
	return $this_page[count($this_page)-1];
}

function cinp($value)
{
if (get_magic_quotes_gpc())
  {
  $value = stripslashes($value);
  }
if (!is_numeric($value))
  {
  $value = mysql_real_escape_string($value);
  }
return $value;
}

function generate_password ($length = 10)
{
  $password = "";
  $possible = "0123456789abcdfghjkmnpqrstvwxyz";
  $i = 0;
  while ($i < $length) {
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
    if (!strstr($password, $char)) {
      $password .= $char;
      $i++;
    }
  }
  return $password;
}

function get_traducere($tabela_referinta, $camp_referinta, $id_referinta, $valoare_initiala) {
  $sql_traducere = mysql_query("SELECT `t`.`traducere` FROM `traduceri` as `t` INNER JOIN `limbi` AS `l` on `t`.`id_limba`=`l`.`id_limba` 
                                WHERE `t`.`tabela_referinta`='".cinp($tabela_referinta)."' AND 
                                `t`.`camp_referinta`='".cinp($camp_referinta)."' AND 
                                `t`.`id_referinta`='".$id_referinta."'  AND
                                `l`.`cod_limba`='".$_SESSION['lang']."' LIMIT 1");
  if(mysql_num_rows($sql_traducere)==0) return  $valoare_initiala; 
  else {
    return mysql_result($sql_traducere,0);
  }
}

function open_traducere($tabela_referinta, $camp_referinta, $id_referinta) {
  $return =  '<div class="traducere_box"><a href="#" class="open_traducere" rel="'.$tabela_referinta.' '.$camp_referinta.' '.$id_referinta.'">T</a>';
  $return .= '<ul class="traducere_table">';
  $return .= '<a href="#" class="close_traducere">x</a>';
  $s = mysql_query("SELECT * FROM `limbi` ORDER BY `id_limba`");
  while($r = mysql_fetch_array($s)) {
    $sql_traducere = mysql_query("SELECT `t`.`traducere` FROM `traduceri` as `t` INNER JOIN `limbi` AS `l` on `t`.`id_limba`=`l`.`id_limba` 
                                WHERE `t`.`tabela_referinta`='".cinp($tabela_referinta)."' AND 
                                `t`.`camp_referinta`='".cinp($camp_referinta)."' AND 
                                `t`.`id_referinta`='".$id_referinta."' LIMIT 1");
    if(mysql_num_rows($sql_traducere)==0) $valoare_actuala = ''; 
    else {
      $valoare_actuala = mysql_result($sql_traducere,0);
    }
    $return .= "<li><span>".ucfirst($r['limba'])."</span><input type='text' name='update_limba".$id_referinta."' value='".$valoare_actuala."'  /><a href='#' class='update_limba' rel=".$r['id_limba']." >UPDATE</a></li>";

  }
  $return .= '</ul></div>';
  return $return;
}

?>