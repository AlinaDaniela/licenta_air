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


?>