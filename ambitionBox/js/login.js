// JavaScript Document
function ajax(object){
		var name=document.getElementById("username").value;
		var passwd=document.getElementById("password").value;
		var error=document.getElementsByClassName("validation");
		var type;
		if(object==2)
			type="register";
		else
			type="validate";
		var allow=true;
		if(name.length<6){
			error.item(0).innerHTML="Minimum 6 characters Required";
			allow=false;
		}
		if(name.length<6){
			error.item(1).innnerHTML="Minimum 6 characters Required";
			allow=false;
		}
		if(!allow)
			return;
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.addEventListener("error",errorHandler,false);
		xmlhttp.addEventListener("load",completeHandler,false);
		xmlhttp.addEventListener("abort",abortHandler,false);
		document.getElementById("message").innerHTML="Checking Please Wait";
		xmlhttp.open("POST","controllers/validate.php",true);
		xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		var str="username="+name+"&password="+passwd+"&type="+type;
		xmlhttp.send(str);
}
function completeHandler(event){
	var data=JSON.parse(event.target.responseText);
	if(data.code==6){
		document.getElementById("message").innerHTML="Login Successful";
		window.location.href="./home.php";
	}
	else
	document.getElementById("message").innerHTML="Invalid Credentials";
}
function abortHandler(event){
		document.getElementById("message").innerHTML="Aborted By user";
}
function errorHandler(event){
		document.getElementById("message").innerHTML="Unable to Connect Check Network Settings...";
}
