<?php
	session_start();
	if(isset($_SESSION['username']))
		header("Location : home.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ambition Login</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body style="background-image:url(images/Tulips.jpg); background-size:cover">
    <div class="container center-block" style="opacity:.7">
    	<div class="row" style="margin-top:10%">
        	<div class="col-lg-4">
            </div>
            <div class="form-group col-lg-4 center-block" style="background-color:#F8F8F8">
            	<h1> Login Panel </h1>
                <form class="validateForm">
                    <div id="message">
                    	<?php
							if(isset($_GET['message']))
								echo $_GET['message'];
						?>
                    </div>
                    <label> Username</label>
                    <input required type="text" class="form-control" placeholder="min. 6 characters required" id="username" />
                    <div class="validation">
                    </div>
                    <label> Password </label>
                    <input type="password" class="form-control" placeholder="min. 4 characters required" id="password"/>
                    <div class="validation">
                    </div>
                    <br />
                    <button type="button" class="btn btn-primary btn-lg" onclick="ajax(1)" >Sign in</button>
                    <button type="button" class="btn btn-success pull-right btn-lg" onclick="ajax(2)" >Register </button>
                </form>
            </div>
            <div class="col-lg-4">
            </div>
        </div>
    </div>

</body>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/login.js"></script>

</html>