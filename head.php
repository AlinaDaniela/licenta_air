<!DOCTYPE html>
<html>
<head>
<title>AirReservation</title>
<link type="text/css" href="css/normalize.min.css" rel="stylesheet" media="screen" />
<link type="text/css" href="css/style.css" rel="stylesheet" media="screen" />
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <?php if(this_page()=="register.php") { ?><script type="text/javascript"  src="js/register.js" ></script><?php } ?>
  <script type="text/javascript"  src="js/common.php" ></script>
  <link type="text/css" href="js/jquery.datepick.css" rel="stylesheet">
  <script type="text/javascript" src="js/jquery.datepick.js"></script>
  <script type="text/javascript" src="js/tab.js"></script>
  <script type="text/javascript">
	$(function() {
		$('#data_plecare').datepick();
		$('#data_sosire').datepick();
	});

	function showDate(date) {
		alert('<?php echo $lang['DATA_ALEASA'];?>' + date);
	}
  </script>

  <?php 
    if(this_page()=="zboruri.php") { 
  ?>
  <script type="text/javascript" charset="utf-8">
  $(function(){
    $("select#companie").change(function(){
      $.getJSON("includes/selectAvioane.php",{id_companie: $(this).val(), ajax: 'true'}, function(j){
        var options = '';
          options += '<option value=""><?php echo $lang['ALEGE_AVION_JS'];?></option>';
        for (var i = 0; i < j.length; i++) {
          options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
        }
        $("select#avion").html(options);
      })
    })
  })
  </script>
  <?php 
    }
  ?>
  
  <?php 
   if(this_page()=="avioane.php") { 
  ?>
  <script type="text/javascript" charset="utf-8">
  $(function(){
    $("select#fabricant").change(function(){
      $.getJSON("includes/selectTipAvioane.php",{id_fabricant: $(this).val(), ajax: 'true'}, function(j){
        var options = '';
          options += '<option value=""><?php echo $lang['ALEGE_TIP_AVION_JS'];?>Alege tipul de avion</option>';
        for (var i = 0; i < j.length; i++) {
          options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
        }
        $("select#tip").html(options);
      })
    })
  })
  </script>
  <?php 
    }
  ?>
</head>

<body>