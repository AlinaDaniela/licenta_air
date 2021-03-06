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
  <?php include("js/common.php"); ?>
  <link type="text/css" href="js/jquery.datepick.css" rel="stylesheet">
  <script type="text/javascript" src="js/jquery.datepick.js"></script>
  <script type="text/javascript" src="js/tab.js"></script>
  <script type="text/javascript">
	$(function() {
		$('.date-pick').datepick({
			dateFormat: 'dd/mm/yyyy'
		});
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
          options += '<option value=""><?php echo $lang['ALEGE_TIP_AVION_JS'];?>';
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
  
  
  <script type="text/javascript" charset="utf-8">
  $(function(){
    $("select#aeroport_plecare").change(function(){
      $.getJSON("includes/selectAeroportPlecare.php",{id_aeroport_plecare: $(this).val(), ajax: 'true'}, function(j){
        var options = '';
          options += '<option value=""><?php echo $lang['ALEGE_AEROPORT_PLECARE_JS'];?></option>';
        for (var i = 0; i < j.length; i++) {
          options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
        }
        $("select#aeroport_sosire").html(options);
      })
    })
  });
  
  $(function(){
	  $("select.select_zbor_clasa").change(function() {
			element = $(this);
			$.ajax({
			  url: "includes/rezervare1.php?id_zbor_clasa="+$(this).val()+"&nr="+$(this).attr('rel'),
			  cache: false
			}).done(function( html ) {
			  element.parent().next('.informatii_zbor_clasa').empty();
			  element.parent().next('.informatii_zbor_clasa').html(html);
			});
	  });
  });

  $(function(){
    $(".open_traducere").click(function() {
      var open_element = $(this);
      open_element.next('.traducere_table').addClass("show");
      return false;
    });

    $(".update_limba").click(function() {
      var update_limba = $(this);
      var sub_open_element = update_limba.parent().parent().prev('.open_traducere').attr('rel').split(' ');
      var tabela_referinta = sub_open_element[0];
      var camp_referinta = sub_open_element[1];
      var id_referinta = sub_open_element[2];
      var id_limba = update_limba.attr('rel');
      var traducere = update_limba.prev('input').val();

      $.ajax({
        url: "includes/update_traducere.php",
        type: 'POST',
        data: { tabela_referinta: tabela_referinta, camp_referinta: camp_referinta, id_referinta: id_referinta, id_limba: id_limba, traducere: traducere },
        cache: false
      }).done(function( html ) {
        alert(html);
      });
      return false;
    });

    $(".close_traducere").click(function() {
      $(this).parent().removeClass("show");
      return false;
    });
  });
  
  </script>
  
</head>

<body>