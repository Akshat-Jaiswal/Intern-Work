// JavaScript Document
// JavaScript Document
var flen=10;
var foff=0;
var rlen=10;
var roff=0;
var ulen=25;
var uoff=0;
	window.onload=function(){
		getData("friends",flen,foff);
		getData("requests",rlen,roff);
		getData("users",ulen,uoff);
	}
	function getData(about,length,offset){
		var ajax=new XMLHttpRequest();
		if(about=="friends")
		ajax.addEventListener("load",addFriends,false);
		if(about=="requests")
		ajax.addEventListener("load",addRequests,false);
		if(about=="users")
		ajax.addEventListener("load",addUsers,false);
		
		ajax.addEventListener("error",function(event){
				alert(event.target.responseText);
		},false);
		var str="length="+length+"&offset="+offset+"&about="+about;
		ajax.open("POST","controllers/getData.php",true);
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send(str);
	}		
	function loadMorePosts(about){
		elem=document.getElementsByClassName("loadMessage");
		if(about=="requests"){
			elem=elem.item(0);
			plen=rlen;
			poff=roff;
		}
		if(about=="friends"){
			elem=elem.item(1);
			plen=flen;
			poff=foff;
		}
		if(about=="users"){
			elem=elem.item(2);
			plen=ulen;
			poff=uoff;
		}
		elem.innerHTML="Loading Please Wait..";
		getData(about,plen,poff+plen);
	}
	function addFriends(event){
		info=JSON.parse(event.target.responseText);
		if(info.code==6){
			elem=document.getElementById("friends");
			data=info.data;
			for(i=0;i<data.length;++i){
				post=formPosts(data[i]);
				elem.innerHTML+=post;
			}		
		foff=foff+flen;
		}
		elem=document.getElementsByClassName("loadMessage").item(1);
		elem.innerHTML="";
	}
	function addRequests(event){
		info=JSON.parse(event.target.responseText);
		if(info.code==6){
			elem=document.getElementById("requests");
			data=info.data;
			for(i=0;i<data.length;++i){
				post=formRequests(data[i]);
				elem.innerHTML+=post;
			}		
		roff=roff+rlen;
		}
		elem=document.getElementsByClassName("loadMessage").item(0);
		elem.innerHTML="";
	}
	function addUsers(event){
		info=JSON.parse(event.target.responseText);
		if(info.code==6){
			elem=document.getElementById("users");
			data=info.data;
			for(i=0;i<data.length;++i){
				post=formUsers(data[i]);
				elem.innerHTML+=post;
			}		
		uoff=uoff+ulen;
		}
		elem=document.getElementsByClassName("loadMessage").item(2);
		elem.innerHTML="";
	}
	function formPosts(post){
		var str="<li class='row' style='margin-left:5%; margin-right:5%'>";
            str+=  " <blockquote>"+post.name+"</blockquote>";
            str+= "  <span style='visibility:hidden'>" +post.id+"</span>";
            str+= " </li>";
		return str;
	}
	function formRequests(post){
		var str="<li class='row' style='margin-left:5%; margin-right:5%'>";
            str+=  " <p>"+post.name+"</p>";
            str+= "  <span style='visibility:hidden'>" +post.id+"</span>";
			str+="<button class='btn btn-success' onclick='request(this,1)' >Accept</button>";
            str+=      " <button class='btn' onclick='request(this,2)'>Decline</button>";             
            str+= " </li><br />";
		return str;
	}
	function formUsers(post){
			var str="<li class='row' style='margin-left:5%; margin-right:5%'>";
            str+=  " <p class='col-lg-8'>"+post.name+"</p>";
            str+= "  <span style='visibility:hidden'>" +post.id+"</span>";
			str+="	<button class='btn btn-success col-lg-4' onclick='request(this,3)'>Send Request</button>";
            str+= " </li><br />";
		return str;
	
	}
	function request(object,option){
		var userId=object.parentNode.getElementsByTagName("span").item(0).innerHTML;
		var name=object.parentNode.getElementsByTagName("p").item(0).innerHTML;
		var type="accept";
		if(option==2)
			type="decline";
		else if(option==3)
			type="send";
		var ajax=new XMLHttpRequest();
		ajax.addEventListener("load",requestComplete,false);
		ajax.addEventListener("error",function(event){
				alert(event.target.responseText);
		},false);
		var str="userId="+userId+"&type="+type+"&name="+name;
		ajax.open("POST","controllers/request.php",true);
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send(str);

	}
	function requestComplete(event){

		var info=JSON.parse(event.target.responseText);
			alert(info.data);
	}