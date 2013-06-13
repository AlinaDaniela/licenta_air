//JQuery tabs
$(document).ready(function(){
	$('#tabs div.tabContent').hide();
	$('#tabs div.tabContent:first').show();
	$('#tabs ul li:first').addClass('active');
	$('#tabs ul li a').click(function(){ 
		$('#tabs ul li').removeClass('active');
		$(this).parent().addClass('active'); 
		var currentTab = $(this).attr('href'); 
		$('#tabs div.tabContent').hide();
		$(currentTab).show();
		return false;
	});
});
