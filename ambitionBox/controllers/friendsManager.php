<?php
	require_once("./connectionManager.php");
	require_once("../models/member.php");
	require_once("./inputCleaner.php");
	
/*
	Responsibilities:
	1. Add a new friend : i.e. adding an entry into friends table
	2. get friends of a particular user
*/	
	class FriendsManager{
		private $error;
		private $cleaner;
		public function __construct(){
			$this->cleaner=new InputCleaner;
		}
		public function getError(){
			return $this->error;
		}
		public function addFriend($user1,$user2){
			$manager=new ConnectionManager;
			$con=$manager->getConnection();
			if(!$con){		
				$this->error=$manager->getError();
				return 0;
			}
/*
	minimum and max user id's are identified as
	there is a check in database that user1 < user2 
	so that only 1 entry is sufficient to represent their relationship
*/
			$min=($user1<$user2)?$user1:$user2;
			$max=($user1>$user2)?$user1:$user2;
			$query="Insert into `friends` values ('$min','$max')";
			$result=mysqli_query($con,$query);
			if(!$result){
				$this->error=mysqli_error($con);
				$manager->close();
				return 0;
			}
			$manager->close();
			return $result;
		}
/*
	function for retrieving friends of a particular user
	argument1: user id of the person 
	argument2: offset from where records have to be loaded
	argument3: number of records which have to be loaded
*/		
		public function getFriendsOfUser($user,$offset,$length){
/*
	Get connection from connection manager
*/
			$manager=new ConnectionManager;
			$con=$manager->getConnection();
			if(!$con){		
				$this->error=$manager->getError();
				return 0;
			}
			$user=$this->cleaner->cleanSqlInput($con,$user);
			$inquery="(Select user1 from `friends` where user2='$user' UNION Select user2 from `friends` where user1='$user')";
			$query="SELECT id,username from `members` where id in $inquery LIMIT $offset, $length";
			$result=mysqli_query($con,$query);
// error case			
			if(!$result){
				$this->error=mysqli_error($con);
				$manager->close();
				return $this->error;
			}
			$count=mysqli_num_rows($result);
/*
	retrieve members one ny one and add them to an array
*/
			$members=array();
			for($i=0;$i<$count;++$i){
				$row=mysqli_fetch_row($result);
				$member=new Member($row[1],"");
				$member->setId($row[0]);
				array_push($members,$member);
			}
// 	close connection			
			$manager->close();
			return $members;
			
		}
		public function checkFriendship($user1,$user2){
				$manager=new ConnectionManager;
				$con=$manager->getConnection();
				if(!$con){		
					$this->error=$manager->getError();
					return 0;
				}
	/*
		minimum and max user id's are identified as
		there is a check in database that user1 < user2 
		so that only 1 entry is sufficient to represent their relationship
	*/
				$min=($user1<$user2)?$user1:$user2;
				$max=($user1>$user2)?$user1:$user2;
				$query="Select * from `friends` where user1='$min' and user2='$max' LIMIT 0,30";
				$result=mysqli_query($con,$query);
				if(!$result){
					$this->error=mysqli_error($con);
					$manager->close();
					return -1;
				}
				$count=mysqli_num_rows($result);
				$manager->close();
				return $count;
		}

	}
?>