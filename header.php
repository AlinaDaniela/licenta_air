<?php  ?>
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
<div id="top"> 
	<div id="logo">
		<a href="#"><img src="images/littleplane.png" border="0" class="logoimage" /></a>
		<div id="languages">
			<a href="index.php?lang=en"><img src="images/en.png" /></a>
			<a href="index.php?lang=ro"><img src="images/ro.png" /></a>
		</div>
	</div>
	
</div>
<div id="menucont"> 
	<div id="tabs">
	  <ul>
		<li><a href="#tabs-1">Nunc tincidunt</a></li>
		<li><a href="#tabs-2">Proin dolor</a></li>
		<li><a href="#tabs-3">Aenean lacinia</a></li>
	  </ul>
	  <div id="tabs-1">
		<p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
	  </div>
	  <div id="tabs-2">
		<p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
	  </div>
	  <div id="tabs-3">
		<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
		<p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
	  </div>
	</div>
</div>
	<div id="right_tab">
			<label><?php echo $lang['LOGIN_TITLE'] ?>
			<a href="#" id="afiseaza_login"><?php echo $lang['LOGARE']; ?></a>
			<div id="loginform">  
				<form name="login" action="login.php" method="post" accept-charset="utf-8" class="loginForm">  
					<ul>  
						<li><label for="userName"><?php echo $lang['USERNAME']; ?></label>  
						<input id="userName" type="userName" name="userName" onblur="validateNume();" placeholder="yourname@email.com" required><span id="numeValidare"></span></li>  
						<li><label for="password"><?php echo $lang['PAROLA']; ?></label>  
						<input type="password" name="password" placeholder="password" required></li>  
						<li>  
							<input type="submit" value="<?php echo $lang['LOGARE']; ?>"> 
							<input type="submit" value="<?php echo $lang['INREGISTRARE']; ?>">
						</li>
						<a href="#"><?php echo $lang['RECUPERARE_PAROLA']; ?></a>
					</ul>  
				</form>  
			</div> 
	</div>
