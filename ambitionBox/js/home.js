// JavaScript Document
var plen=10;
var poff=0;
	window.onload=function(){
		getData(plen,poff);
	}
	function getData(length,offset){
		var ajax=new XMLHttpRequest();
		ajax.addEventListener("load",addPosts,false);
		ajax.addEventListener("error",function(event){
				alert(event.target.responseText);
		},false);
		var str="length="+length+"&offset="+offset+"&about=posts";
		ajax.open("POST","controllers/getData.php",true);
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send(str);
	}		
	function loadMorePosts(){
		elem=document.getElementById("loadMessage");
		elem.innerHTML="Loading Please Wait..";
		getData("posts",plen,poff+plen,"addPosts");
	}
	function addPosts(event){
		info=JSON.parse(event.target.responseText);
		if(info.code==6){
			elem=document.getElementById("posts");
			data=info.data;
			for(i=0;i<data.length;++i){
				post=formPosts(data[i]);
				elem.innerHTML+=post;
			}		
		poff=poff+plen;
		}
		elem=document.getElementById("loadMessage");
		elem.innerHTML="";

	}
	function formPosts(post){
		var str="<li class='row' style='margin-left:5%; margin-right:5%'>";
            str+=  " <label>"+post.from+"</label>";
            str+= "  <span class='pull-right'>" +post.time+"</span>";
            str+= "  <blockquote>"+post.description+"</blockquote> </li>";
		return str;
	}
	function postUpdate(){
		var desc=document.getElementById("description").value;
		
		if(desc.length==0){
			alert("Message Required");
			return;
		}
		if(desc.length>250){
			alert("Message length Cannot Exceed 250 characters");
		}
			var ajax=new XMLHttpRequest();
		ajax.addEventListener("load",postComplete,false);
		ajax.addEventListener("error",function(event){
				alert(event.target.responseText);
		},false);
		var str="description="+desc;
		ajax.open("POST","controllers/postUpdate.php",true);
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send(str);
	}
	function postComplete(event){
		var info=JSON.parse(event.target.responseText);
		if(info.code==6){
			alert(info.data);
			window.location="home.php";
		}
		else 
			alert(info.data);
	}