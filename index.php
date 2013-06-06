<?php
include_once 'common.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>AirReservation</title>
<link type="text/css" href="css/normalize.min.css" rel="stylesheet" media="screen" />
<link type="text/css" href="css/style.css" rel="stylesheet" media="screen" />
<?php include_once 'head.php'; ?>
</style>

<script type="text/javascript">
function isAlphapet()
{
  var alphaExp = /^[a-zA-Z]+$/;
  var namee=document.field.name.value;
  var nalt=document.getElementById('name1');
  if(namee!="")
   {
      if(!namee.match(alphaExp))
      {
       nalt.innerHTML="<font color='red'> Invalid Characters </font>";
       document.field.name.focus();
        document.field.name.value="";
         return false; 	
       }else{
  		  nalt.innerHTML="";
		    return true; 
        }
   }
  else  if(namee.length==0) {
   nalt.innerHTML="<font color='red'> Invalid Name</font>";
    document.getElementById('name').focus();
   return false;
    }
  
}
function isAlphaNumeric()
{
  var alphaExp = /^[0-9 a-zA-Z]+$/;
  var usernam=document.field.user.value;
  var ualt=document.getElementById('user1');
  if(!usernam.match(alphaExp) && (usernam!=""))
  {
    document.field.user.focus();
    ualt.innerHTML="<font color='red'> Invalid Username </font>";
    return false;
  }else{
		ualt.innerHTML="";
    return true;
  } 
}
function emailvalid()
{
  var emal=document.field.email.value;
  var ealt=document.getElementById('email1');
  if(emal!="")
  {
    var emailExp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([com\co\.\in])+$/;
    if(!emal.match(emailExp))
    {
	   document.field.email.focus();
    
    ealt.innerHTML="<font color='red'> Invalid Email id </font>";
		 return false; 	
	  }else{
		 ealt.innerHTML="";
     document.getElementById('email').focus();
     return true;
    }
  }    
 else if(emal.length==0)
 {
  ealt.innerHTML="<font color='red'> Invalid Email id</font>";
 return false; 
 }
}
 
function isNumeric()
{
  var elem=document.field.ph_no.value;
  var nalt=document.getElementById('phno1');
 if(elem!="")
 {
    var numericExpression = /^[0-9]+$/;
	  if(elem.match(numericExpression))
    {
         nalt.innerHTML="";
         return true;
       }
    
    else{
		
    nalt.innerHTML="<font color='red'> Numeric Values Only</font>";
		  document.field.ph_no.focus();
	 	  document.field.ph_no.value="";
       return false;
	  }
  }
  else if(elem.length==0)  {
    nalt.innerHTML="<font color='red'> Numeric Values Only</font>";
     document.field.ph_no.focus();;
   return false;
    }


}
  

function chkform()
{
  var nam=document.getElementById('name');
  var selct=document.getElementById('gender');
  var userlen=document.getElementById('user');
  var phno=document.getElementById('ph_no');
  var pawd=document.getElementById('pwd');  
  var pawdcon=document.getElementById('pwd_con');      

  if(isAlphapet())   
  {   
    if(madeselection())
    {
      if(emailvalid())
      {                 
        if(isAlphaNumeric())
        { 
          if(charlen())
          {
           if(password)
            { 
             if(pass())
             {
              if(isNumeric())
              {                    
                                 
                if((userlen.value.length!=0) && (phno.value.length!=0)&& (pawd.value.length!=0) && (pawdcon.value.length!=0) && (nam.value.length!=0))
                {
                 var id=document.getElementById('fld');
                 id.innerHTML="<center><h1><font color=green>Welcome to HScripts.com</h1><br><h4><font color=red>Submission Successful!</font></h4></center>";
                }
                               
               }
              }
            }
          }
        }
      } 
     }
  }
   else{
     
      return false;
      
   }
}    

function madeselection()
{
 var selct=document.getElementById('gender');
  var salt=document.getElementById('opt1'); 
 
  if(selct.value=="Please Choose")//|| (userlen.value.length==0) || (phno.value.length==0)|| (pawd.value.length==0) || (pawdcon.value.length==0) || (nam.value.length==0))
  {
    salt.innerHTML="<font color='red'> Choose Gender</font>";
    selct.focus();
   return false;
  }
  else{ 
     return true;
  }
}
 
function  charlen()
{
  var userid=document.getElementById('user');
  var uu=userid.value;
  var chrlen=uu.length;
 var ualt=document.getElementById('user1');
  if(uu!="")
  {
    if(chrlen<5)
    {
      document.field.user.focus();
      
    ualt.innerHTML="<font color='red'> Username Too Short</font>";
       return false;
    }else {
      ualt.innerHTML="";
      return true;
    }
   }
   else if(chrlen==0)  {
     ualt.innerHTML="<font color='red'> Invalid  Username</font>";
    userid.focus();
   return false;
    }

}
function password()
{
   var pawd1=document.getElementById('pwd');
   var palt=document.getElementById('pwd1');
 if(pawd1.value.length==0)
  {
    palt.innerHTML="<font color='red'> Invalid PassWord</font>";
    document.getElementById('pwd').focus();
   return false;
  }
 else
  {
    palt.innerHTML="";
    return true;
  }

}
function pass()
{
  var pawd1=document.getElementById('pwd');
  var pawdcon2=document.getElementById('pwd_con');
  var palt=document.getElementById('pwd1');
  var pcalt=document.getElementById('pwdcon1');
  
 if(pawdcon2.value.length==0)  {
    pcalt.innerHTML="<font color='red'> Invalid Password Cofirm </font>";
    pawdcon.focus();
   return false;
    }
   
 else if(pawd1.value!=pawdcon2.value)
  {
    pcalt.innerHTML="";
    palt.innerHTML="<font color='red'> Password Mismatch</font>";
    return false;
  }else{
    palt.innerHTML="";
    pcalt.innerHTML="";
    return true;
  }
}
function slctemp()
{
var saalt=document.getElementById('opt1'); 
saalt.innerHTML="";
 }
</script>
</head>
<body>
	<header class="clear">
		<div class="wrap">
			<?php include('header.php'); ?> 
		</div>
	</header>
	
	<div class="main_content">
		<div class="wrap">
			<section>
				<table  align=center cellspacing=0 cellpadding=0 style="font-family: Monaco, Verdana, Sans-serif; font-size: 12px;background-color: #f9f9f9;border: 1px solid #D0D0D0;color: #002166;width:45%;" >
<tr><td><div id="header"><div align=center style='padding-top:15px;font-size:15px;color:orange;font-weight:bold;'>Field Validation Form</div></div></td></tr><tr><td>
<form name="field">
<div id='fld'>
<table   cellspacing=2 cellpadding=2 style="font-family: Monaco, Verdana, Sans-serif; font-size: 12px;background-color: #f9f9f9;border: 0px solid #D0D0D0;color: #002166;padding-left:10px;width:100%;" >
<tr><td width='31%'>Name</td><td><input type="text" name="name" id="name"  onBlur="isAlphapet()"><span id=name1></span></td></tr>
<tr><td>Gender</td><td><select id="gender" onChange="slctemp()" onBlur="madeselection()" style='width:135px;' ><option>Please Choose</option><option>Male</option><option>Female</option></select><span id=opt1></span></td></tr>
<tr><td>Email</td><td><input type="text" name="email" id="email" onBlur="emailvalid()" ><span id=email1></span></td></tr>
<tr><td>Username</td><td><input type="text" name="user" id="user"  onBlur="charlen(this.id)" maxlength=10 onKeyup="isAlphaNumeric()" ><span id=user1></span></td></tr>
<tr><td>Password</td><td><input type="password" name="pwd" id="pwd" onBlur='password()' ><span id=pwd1></span></td></tr>
<tr><td>Confirm password</i>  </td><td><input type="password" name="pwd_con" id="pwd_con" onBlur='pass()'><span id=pwdcon1></span></td></tr>
<tr><td>Ph_no</td><td><input type="text" name="ph_no" id="ph_no" onKeyup="isNumeric()"  maxlength=10 ><span id=phno1></span></td></tr>
<tr><td colspan=2 align=center> <input id="x" type="button" value="Validate Form"  onClick="chkform()" ></tr></td>
</table></div></form></td></tr></table>
	<div style="font-size: 10px;color: #dadada;" id="dumdiv" align=center>
<a href="http://www.hscripts.com" id="dum" style="text-decoration:none;color: #dadada;">Â©h</a></div>
			</section>
			<aside>
			</aside>
		</div>
	</div>

	<footer>
		<div class="wrap">
		
		</div>
	</footer>
	
</body>

</html>