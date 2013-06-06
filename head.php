 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script type="text/javascript" language="javascript">
	function validateEmail() {
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var email = $("#loginForm\\:emailInput").val();
                              
        if (email.length==0)
        {   $("#emailValidare").text("Va rugam sa completati adresa de mail!");
            $("#emailValidare").css("color","red");
            return false;
        }
        else
        if(emailReg.test(email)) 
        {
            $("#emailValidare").text("");
            $("#emailValidare").css("color","green");
            return true;
        }
        else
        {
            $("#emailValidare").text("Va rugam sa verificati adresa de mail introdusa!");
			$("#emailValidare").css("color","red");
            return false;
        }
    }
                          
    function validateNume(){
                              
        var nume = $("#loginForm\\:userName").val();
        var nume_length = nume.length;
        var letters = /^[A-Z a-z]+$/; 
        var numere = /^[0-9]+$/;
        if(nume_length == 0)
        {
            $("#numeValidare").text("Va rugam sa completati numele!");
            $("#numeValidare").css("color","red");
            return false;
        }
        else
        if(nume.match(letters))
        {
            $("#numeValidare").text("");
            $("#numeValidare").css("color","green");
            return true;
        }
        else
        {
            $("#numeValidare").text("Va rugam sa completati corect campul corespunzator numelui!");
            $("#numeValidare").css("color","red");
            return false;
        }
    }
	
  </script>
  <script>
  
  $( document ).ready(function() {
		$("#afiseaza_login").click(function() { 
		if($("#loginform").hasClass('arata')) $("#loginform").removeClass('arata');
		else $("#loginform").addClass('arata');
		return false;
	  });
	});
   
  
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