<?php
	require_once("../models/member.php");
	require("inputCleaner.php");
	require("memberManager.php");
		if(isset($_POST['username'])&& isset($_POST['password'])){
		// Connect to Database
			$cleaner=new InputCleaner;
			$username=$cleaner->getCleanInput('username');
			$password=$cleaner->getCleanInput('password');
			$type=$_POST['type'];
			$manager=new MemberManager;
			if($type=="validate")
			$result=$manager->validateMember($username,$password); 
			else{
				$member=new Member($username,$password);
				$result=$manager->addMember($member);	
			}
			
			if(!$result){
				$response=array('code' => '5', 'data' => '$manager->getError()');
				exit(json_encode($response));
			}
			if($result<0){
				$response=array('code' => '1', 'data' => 'invalid username/password ');
				exit(json_encode($response));
			}
			else{
				session_start();
					$_SESSION['username']=$username;
					$_SESSION['id']=$result;
				$response=array('code' => '6', 'data' => 'Login Successful ');
				exit(json_encode($response));
			}
		}
	else{
	$response=array('code' => '0', 'data' => 'Not Enough Parameters in Call to scripts');
	exit(json_encode($response));
	}
	
	?>
?>