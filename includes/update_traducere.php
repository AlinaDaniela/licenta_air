<?php require_once('../config.php');


if(isset($_POST['tabela_referinta']) and isset($_POST['camp_referinta']) and isset($_POST['id_referinta']) and isset($_POST['id_limba']) and isset($_POST['traducere'])) {
	$sql_traducere = mysql_query("SELECT `t`.`id_traducere` FROM `traduceri` AS `t`
                                WHERE `t`.`tabela_referinta`='".cinp($_POST['tabela_referinta'])."' AND 
                                `t`.`camp_referinta`='".cinp($_POST['camp_referinta'])."' AND 
                                `t`.`id_referinta`='".cinp($_POST['id_referinta'])."' AND 
                                `t`.`id_limba`='".cinp($_POST['id_limba'])."' LIMIT 1");
    if(mysql_num_rows($sql_traducere)==0) mysql_query("INSERT INTO `traduceri` SET `tabela_referinta`='".cinp($_POST['tabela_referinta'])."', `camp_referinta`='".cinp($_POST['camp_referinta'])."', `id_referinta`='".cinp($_POST['id_referinta'])."', `id_limba`='".cinp($_POST['id_limba'])."', `traducere` = '".cinp($_POST['traducere'])."' ");
    else {
      mysql_query("UPDATE `traduceri` SET `traducere` = '".cinp($_POST['traducere'])."' WHERE `tabela_referinta`='".cinp($_POST['tabela_referinta'])."' AND `camp_referinta`='".cinp($_POST['camp_referinta'])."' AND `id_referinta`='".cinp($_POST['id_referinta'])."' AND `id_limba`='".cinp($_POST['id_limba'])."' LIMIT 1  ");
    }
    echo $lang['TRADUCERE_ACT'];
}



?>