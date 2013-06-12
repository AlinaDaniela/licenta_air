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
	  $("<div><p>Sunteti sigur ca vreti sa stergeti intrarea?</p></div>").dialog({
		autoOpen: true,
		title: 'Stergeti?',
		modal:true,
		buttons:btns
	  });
	}
	$('.delete').click(function(){
		yesnodialog('Da', 'Nu', $(this));
		return false;
	}); 
	
	});
	

   da nu cred ca asta foloseste.
  
	  $(function() {
		$( "#tabs" ).tabs();
	  });
	  (function($) {

		$.organicTabs = function(el, options) {
		
			var base = this;
			base.$el = $(el);
			base.$nav = base.$el.find(".nav");
					
			base.init = function() {
			
				base.options = $.extend({},$.organicTabs.defaultOptions, options);
				
				// Accessible hiding fix
				$(".hide").css({
					"position": "relative",
					"top": 0,
					"left": 0,
					"display": "none"
				}); 
				
				base.$nav.delegate("li > a", "click", function() {
				
					// Figure out current list via CSS class
					var curList = base.$el.find("a.current").attr("href").substring(1),
					
					// List moving to
						$newList = $(this),
						
					// Figure out ID of new list
						listID = $newList.attr("href").substring(1),
					
					// Set outer wrapper height to (static) height of current inner list
						$allListWrap = base.$el.find(".list-wrap"),
						curListHeight = $allListWrap.height();
					$allListWrap.height(curListHeight);
											
					if ((listID != curList) && ( base.$el.find(":animated").length == 0)) {
												
						// Fade out current list
						base.$el.find("#"+curList).fadeOut(base.options.speed, function() {
							
							// Fade in new list on callback
							base.$el.find("#"+listID).fadeIn(base.options.speed);
							
							// Adjust outer wrapper to fit new list snuggly
							var newHeight = base.$el.find("#"+listID).height();
							$allListWrap.animate({
								height: newHeight
							});
							
							// Remove highlighting - Add to just-clicked tab
							base.$el.find(".nav li a").removeClass("current");
							$newList.addClass("current");
								
						});
						
					}   
					
					// Don't behave like a regular link
					// Stop propegation and bubbling
					return false;
				});
				
			};
			base.init();
		};
		
		$.organicTabs.defaultOptions = {
			"speed": 300
		};
		
		$.fn.organicTabs = function(options) {
			return this.each(function() {
				(new $.organicTabs(this, options));
			});
		};
		
		
})(jQuery);
</script>