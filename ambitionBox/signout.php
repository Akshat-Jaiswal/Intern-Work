
<?php 
// startting session to get session variable and also to destroy it
		session_start();
// code for destroying the session
		if (session_id() != "" || isset($_COOKIE[session_name()]))
// destroying the cookie
		setcookie(session_name(), '', time() - 2592000, '/');
//destroying the session
		session_destroy();
// return destroyed for indicating successful logout
		header("Location: login.php");

?>
<html>
<body>
	<br />
	if you are not automatically redirected <a href="login.php"> Click Here </a>
</body>
</html>