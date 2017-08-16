<?php
	session_start();
	if(!isset($_SESSION['username']))
		header("Location: login.php?message=login%20Required");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Friends</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />
</head>

<body>
	<header>
        <div class="navbar navbar-default navbar-static-top" style="border-bottom:thin solid #D5D5D5">
            <div class="container">        
                <div class="navbar-header">
                  <a class="navbar-brand" href="home.php"><?php echo $_SESSION['username']?></a>
               
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="navbar-collapse collapse ">
                    <ul class="nav">
                    
                        <li class="pull-right">
                        	<a href="signout.php" ><button type="button" class="btn btn-success">Logout</button></a>
                        </li>
                    	<li class="pull-right">
                        	<a href="#" ><button type="button" class="btn btn-primary">Friends</button></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
	</header>
	<section >
    	<div class="row container">
        	<div class="col-lg-4">
            	<h4> Friend Requests</h4>
                <ul class="media-list" id="requests">
                 </ul>
                <a><button type="button" class="btn btn-primary" id="post1" onclick="loadMorePosts('requests')" style="margin-left:10%">Load 					More</button></a>
                <span class="loadMessage" ></span>
            </div>
            <div class="col-lg-4">
                <h4> Friends </h4>
                <ul class="media-list" id="friends">
                </ul>
                <a><button type="button" class="btn btn-primary" id="post2" onclick="loadMorePosts('friends')" style="margin-left:10%">Load 					More</button></a>
             <span class="loadMessage" ></span>
   
            </div>
            <div class="col-lg-4">
                <h4>All users </h4>
                <ul class="media-list" id="users">

                </ul>
                <a><button type="button" class="btn btn-primary" id="post3" onclick="loadMorePosts('users')" style="margin-left:10%">Load 					More</button></a>
             <span class="loadMessage" ></span>
            </div>
            
        </div>
    </section>
</body>
<script type="text/javascript" src="js/friends.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
</html>