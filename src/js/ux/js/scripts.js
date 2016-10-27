var xmlHttp=null;
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)
		{
			 alert ("Browser does not support HTTP Request")
		}
function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	{
		 // Firefox, Opera 8.0+, Safari
		 xmlHttp=new XMLHttpRequest();
	}
	
	catch(e)
	{
		  // Internet Explorer
		  try
		  {
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		  catch(e)
		  {
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
return xmlHttp;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function send_msg(){
		document.getElementById("status").innerHTML="";
		var name=document.ansq.name.value;
		var email=document.ansq.email.value;
		var phone=document.ansq.phone.value;
		var details=document.ansq.details.value;
		if(details!="" && email!="" && name!="" && phone!="" ){
		url="http://localhost/ccnmoduleslive/ux//system_functions/system_mail/examples/send_mail.php";
		url=url+"?name="+name+"&email="+email+"&phone="+phone+"&details="+details;
		//xmlHttp.onreadystatechange=stateChanged
		xmlHttp.open("GET",url,false);
		xmlHttp.send(null);
		if(xmlHttp.responseText=="ok"){
			document.getElementById("status").innerHTML="<font style='color:#FF0000;'>Message sent successfully. Thanks, we'll be sure to get back to you very soon!</font>";
		}
		document.ansq.name.value="";
		document.ansq.email.value="";
		document.ansq.phone.value="";
		document.ansq.details.value="";
		}
		else{
		var err="<font color='red'>Message failed to send, Please fill in all required fields.</font>";
		document.getElementById("status").innerHTML=err;
		}
}


function pass(){
		var user_email=document.getElementById("i_email").value;
		if(user_email!=""){
			//url="www.porterlogics.com"
			url="http://localhost/ccnmoduleslive/ux//modules/pw_reset.php"
			url=url+"?user_email="+user_email
			xmlHttp.open("GET",url,false)
			xmlHttp.send(null)
			var respx=xmlHttp.responseText;
			if(respx=="f"){ document.getElementById("loginstatus").innerHTML="<font color='red'>Failed, no such Email Address was found in the system.</font><br><br>"; }
			if(respx=="ie"){
			document.getElementById("loginstatus").innerHTML="<font color='red'>Failed, please provide a valid email address.<br>(Example: myusername@domain.com)</font><br><br>"; }
			if(respx!="f" && respx!="ie"){
				//var xmkh="http://porterlogics.com";
				//xmlHttp.open("GET",xmkh,false)
				//xmlHttp.send(null)
				//document.getElementById("loginstatus").innerHTML=xmlHttp.responseText;
				//document.getElementById("loginstatus").innerHTML="Please check your inbox for instructions to reset your password!";
				//document.getElementById("loginstatus").innerHTML=xmlHttp.responseText;
				document.getElementById("errframe").src = respx;
				document.getElementById("loginstatus").innerHTML=$("#errframe").contents().find("body").html();
			}
			//document.getElementById("loginstatus").innerHTML=xmlHttp.responseText;
		}else{
			document.getElementById("loginstatus").innerHTML="Please enter your email address above and click the link below again.";
		}
}


function passreset(){
		var xl=document.getElementById("xl").value;
		var xvo=document.getElementById("xvo").value;
		var new_password=document.getElementById("np").value;
		var confirm_password=document.getElementById("cp").value;
		url="http://localhost/ccnmoduleslive/ux//system_functions/system_mail/examples/pw_change_mail.php";
		url=url+"?xl="+xl+"&xvo="+xvo+"&new_password="+new_password+"&confirm_password="+confirm_password;
		xmlHttp.open("GET",url,false);
		xmlHttp.send(null);
        var resp=xmlHttp.responseText;
		document.getElementById("loginstatus").innerHTML=resp;
        /*
        document.getElementById("errframe").src = url;
         */
}
function dflt_d(sd,ed){
    if(document.getElementById("at").checked){ document.criteria_form.start_date.value= "01/01/1970"; document.criteria_form.end_date.value= "01/01/2099"; }
    else{ document.criteria_form.start_date.value= sd; document.criteria_form.end_date.value= ed; }
}
