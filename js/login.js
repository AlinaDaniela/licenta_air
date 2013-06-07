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