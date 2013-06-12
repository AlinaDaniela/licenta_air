<script type="text/javascript">
$( document ).ready(function() {
		$("#afiseaza_login").click(function() { 
		if($("#loginform").hasClass('arata')) $("#loginform").removeClass('arata');
		else $("#loginform").addClass('arata');
		return false;
	  });
	  
	  function yesnodialog(button1, button2, element){
	  var btns = {};
	  btns[button1] = function(){ 
		   window.location.href = element.attr('href');
		  $(this).dialog("close");
	  };
	  btns[button2] = function(){ 
		  $(this).dialog("close");
	  };
	  $("<div><p><?php echo $lang['DIALOG_SIGUR'];?></p></div>").dialog({
		autoOpen: true,
		title: '<?php echo $lang['DELETE_'];?>',
		modal:true,
		buttons:btns
	  });
	}
	$('.delete').click(function(){
		yesnodialog('<?php echo $lang['DA'];?>', '<?php echo $lang['NU'];?>', $(this));
		return false;
	}); 
	
	});

</script>