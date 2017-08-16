<?php
	require_once("./connectionManager.php");
	require_once("./friendsManager.php");
	require_once("../models/member.php");
	
/*
	Responsibilities:
	1. add to new request to requests table 
	2. show requests received by a particular user
	3. Accept request: this include deleting entry from requests table and ading an entry in friends table
	4. Decline request: delete the entry from requests table 
*/
	class RequestManager{
/*
	for handling Errors
*/		
		private $error;
		public function getError(){
			return $this->error;
		}
/*
	function for accepting requests
	argument1: the userId of the person who sent the request
	argument2: userId of the person being requested
	Return value:int
	1 : success
	0: error 
*/
		public function addRequest($reuestedBy,$reuestedTo){
/*
	 first get the connection
*/
			$fmanager=new FriendsManager;
			$result=$fmanager->checkFriendship($reuestedBy,$reuestedTo);
			if($result){
				$this->error="Already friends";
				return 0;
			}
			$manager=new ConnectionManager;
			$con=$manager->getConnection();
			if(!$con){		
				$this->error=$manager->getError();
				return 0;
			}
/*
 	set status and request time
*/
			$status="pending";
			$dt=date("Y-m-d H:i:s",strtotime("+330 minutes"));
// 	query for insertion in table
			$query="INSERT into `requests` (`requestedBy`,`requestedTo`,`status`,`timeStamp`) values ('$reuestedBy','$reuestedTo' ,'$status','$dt')";
// query database
			$result=mysqli_query($con,$query);
			if(!$result){
// in case of error store it in error and return -1
				$this->error=mysqli_error($con);
				$manager->close();
				return 0;
			}
// 	close database connection
			$manager->close();
			return $result;
		}
		
/*
	function for getting requests for a particular user
	argument1: user Id od the user in concern
	argument2: offset from where requests are loaded
	argument2: no. of requests to be loaded at a time
	Return type:  members[] i.e. array of members 
*/		
		public function getRequestsForUser($user,$offset,$length){
			$manager=new ConnectionManager;
			$con=$manager->getConnection();
			$members=array();
			if(!$con){		
				$this->error=$manager->getError();
				return 0;
			}
/*
	first get the requests from the database 
*/			
			$query = "SELECT requestedBy,username FROM `requests` r, `members` m WHERE r.requestedBy = m.id AND requestedTo ='$user' LIMIT $offset , $length";
			$result=mysqli_query($con,$query);
			if(!$result){
				$this->error=mysqli_error($con);
				$manager->close();
				return 0;
			}
/*
	now add each request to an array
	to form an array of requests
*/			
			$count=mysqli_num_rows($result);
			for($i=0;$i<$count;++$i){
				$row=mysqli_fetch_row($result);
//		creating a member object to hold username and his Id
				$member=new Member($row[1],"");
				$member->setId($row[0]);
// 		store this member into an array
				array_push($members,$member);
			}
// close connection
			$manager->close();
// return all the members who requested 
			return $members;
		}
/*
	function for accepting q request
	This proceeds in 2 steps 
	i. first the request is deleted from requests table 
	ii. an entry is created into friends 
*/		
		public function acceptRequest($requestedBy,$requestedTo){
// 	get no. if rows affected ideally it should be 1			
			$count=$this->deleteRequest($requestedBy,$requestedTo);
// 	if there is a request found that is being deleted add coressponding  entry into friends table
			if($count>0){
				$friendManager=new FriendsManager;
				if(!$friendManager->addFriend($requestedBy,$requestedTo)){
					$this->error=$friendManager->getError();
// 	now undo operation has to be performed as it is deleted but not added so
					$this->addRequest($requestedBy,$requestedTo);
					return -1;
				}
			}
// 	close connection
			return 1;
		}
/*
	function for deleting a Request	
	argument1: user id of the person who requested
	argument2: user id of the person being requested
	Return type: int 
	1 : success
	-1: error
*/
		public function deleteRequest($requestedBy,$requestedTo){
			$manager=new ConnectionManager;
			$con=$manager->getConnection();
			$members=array();
			if(!$con){		
				$this->error=$manager->getError();
				return -1;
			}
//  	first perform the delete operation			
			$query="DELETE FROM `requests` WHERE requestedBy='$requestedBy' and requestedTo='$requestedTo'";
			$result=mysqli_query($con,$query);
			if(!$result){
				$this->error=mysqli_error($con);
				$manager->close();
				return -1;
			}
// 	get no. if rows affected ideally it should be 1			
			$count=mysqli_affected_rows($con);
				$manager->close();
			return $count;
		}
	}
?>