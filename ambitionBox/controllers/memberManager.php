<?php
	require_once("../models/member.php");
	require_once("./connectionManager.php");
	require_once("../configurations/salts.php");
	require_once("./inputCleaner.php");
	class MemberManager{
		private $error;
		private $cleaner;
		public function __construct(){
			$this->cleaner=new InputCleaner;
		}
		public function getError(){
			return $this->error;
		}
		
/* 
	function for adding a new member to table 
	argument1: single argument of type class member that holds details of a member
	Return type: int
	0: error
	1: user Id alloted
*/
		public function addMember($member){
			$manager=new ConnectionManager;
			$con=$manager->getConnection();
			if(!$con){
				$this->error=$manager->getError();
				return 0;
			}
			$name=$this->cleaner->cleanSqlInput($con, $member->getName());
			$pass=$this->cleaner->cleanSqlInput($con,$member->getPassword());
			$pass=md5(SALT_PREFIX.$pass.SALT_SUFFIX);
			$query="Insert into `Members` (`username`,`password`) values ('$name','$pass')";
			$result=mysqli_query($con,$query) ;
			if(!$result){
				$this->error=mysqli_error($con);
				return 0;
			}
			$id=mysqli_insert_id($con);
			$manager->close();			
			return $id;
		}
		public function getMemberByName($name){
			$manager=new ConnectionManager;
			$member=new Member;
			$con=$manager->getConnection();
			if(!$con){
				$this->error=$manager->getError();
				return 0;
			}
			$name=$this->cleaner->cleanSqlInput($con,$name);
			$query="Select id,username from `members` where username='$name' ";
			$result=mysqli_query($con,$query);
			if(!$result){
				$this->error=mysqli_error($con);
				return 0;
			}
			$count=mysqli_num_rows($result);
			if($count==0)
				return $member;
			$row=mysqli_fetch_row($result);
			$manager->close();
			$member->setName($row[1]);
			$member->setId($row[0]);
			return $member;
		}
/*
		function for validating a login scenario
		Return type: int
		0 : error
		-1: invalid username/passwords
		>0: user id of valid user
*/
		public function validateMember($nm,$pass){
/*
		get connection from connection manager
*/
			$manager=new ConnectionManager;
			$con=$manager->getConnection();
			if(!$con){
				$this->error=$manager->getError();
				return 0;
			}
//	convert normal password into the encrpted one stored in database 
			$nm=$this->cleaner->cleanSqlInput($con,$nm);
			$pass=md5(SALT_PREFIX.$pass.SALT_SUFFIX);
			$query="SELECT id from `members` where username='$nm' and password='$pass'";
			$result=mysqli_query($con,$query);
			if(!$result){
				$this->error=mysqli_error($con);
				return 0;
			}
// if no match is found than invalid login credentials
			$count=mysqli_num_rows($result);
			if($count==0)
				return -1;
// else return user Id of user
			$row=mysqli_fetch_row($result);
			return $row[0];
		}
		
		public function getAllUsers($offset,$length){
/*
		get connection from connection manager
*/
			$manager=new ConnectionManager;
			$con=$manager->getConnection();
			if(!$con){
				$this->error=$manager->getError();
				return 0;
			}
			$query="SELECT id, username from `members` LIMIT $offset, $length";
			$result=mysqli_query($con,$query);
			if(!$result){
				$this->error=mysqli_error($con);
				return 0;
			}
// if no match is found than invalid login credentials
			$count=mysqli_num_rows($result);
			$members=array();
			for($i=0;$i<$count;++$i){
				$row=mysqli_fetch_row($result);
				$member=new Member($row[1],"");
				$member->setId($row[0]);
				array_push($members,$member);
			}
			$manager->close();
			return $members;
		}
	}
?>