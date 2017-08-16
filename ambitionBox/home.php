<?php
	session_start();
	if(!isset($_SESSION['username']))
		header("Location: login.php?message=login%20Required");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />
</head>

<body>
	<header>
        <div class="navbar navbar-default navbar-static-top" style="border-bottom:thin solid #D5D5D5">
            <div class="container">        
                <div class="navbar-header">
                  <a class="navbar-brand" href="#"><?php echo $_SESSION['username']?></a>
               
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
                        	<a href="friends.php" ><button type="button" class="btn btn-primary">Friends</button></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
	</header>
	<section >
    	<div class="row container">
        	<div class="col-lg-8">
            	
                <ul class="media-list" id="posts">
                </ul>
                <a><button type="button" class="btn btn-primary" id="post1" onclick="loadMorePosts()" style="margin-left:10%">Load More</button></a>
                <span id="loadMessage" ></span>
            </div>
            <div class="col-lg-4">
                <h4> Whats on your Mind ?</h4>
               	<textarea rows="4" id="description"  placeholder="Share Something" required="required" class="form-control" ></textarea>
                <br />
                <a><button type="button" class="btn btn-primary" id="post2" onclick="postUpdate()" >Post</button></a>
                <span id="message" ></span>
            </div>
        </div>
    </section>
</body>
<script type="text/javascript" src="js/home.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
</html>