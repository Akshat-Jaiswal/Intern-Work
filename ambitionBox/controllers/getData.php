<?php
	session_start();
	require_once("memberManager.php");
	require_once("friendsManager.php");
	require_once("requestManager.php");
	require_once("postManager.php");
	require_once("inputCleaner.php");
if(isset($_POST['offset'])&& isset($_POST['length'])){
		$cleaner=new InputCleaner;
		$offset=$cleaner->getCleanInput('offset');
		$noOfPosts=$cleaner->getCleanInput('length');
		// for selecting a particular table
		$table=$_POST['about'];
		$result="";
		$user=$_SESSION['id'];
		$data="";
		if($table=="posts"){
			$manager=new PostManager;
			$result=$manager->getPostsForUser($user,$offset,$noOfPosts);
		}
		else if($table=="requests"){
			$manager=new RequestManager;
			$result=$manager->getRequestsForUser($user,$offset,$noOfPosts);
		}
		else if($table=="friends"){
			$manager=new FriendsManager;
			$result=$manager->getFriendsOfUser($user,$offset,$noOfPosts);
		}
		else if($table=="users"){
			$manager=new MemberManager;
			$result=$manager->getAllUsers($offset,$noOfPosts);
		}
		if(!$result){
			$data=$manager->getError();
			$response=array('code' => '1','data' => $data);
			exit(json_encode($response));

		}// connect to database
		// fetch each row and convert to an array
		$data=array();
		$count=count($result);
		for($i=0;$i<$count;++$i){
			$row=$result[$i];
			array_push($data,convertToArray($row));
		}
		// create a new response
		$response=array('code' => '6','data' => $data);
		exit(json_encode($response));

}
else{
$response=array('code' => '0', 'data' => 'Not Enough Parameters in Call to scripts');
exit(json_encode($response));
}
// function for converting row into a json object
function convertToArray($r){
	$table=$_POST['about'];
	// change array according to the table
	// for projects
	if($table=='posts'){
		$tm=strtotime($r->getTimeStamp());
		$dt=date("F d,Y",$tm);
		$value=array('from' => $r->getFrom(),'time' => $dt,'description' => $r->getDescription());
	}
	if($table=='users'||$table=='friends' ||$table=='requests'){
		$value=array('name' => $r->getName(),'id' => $r->getId());		
	}
	return $value;
}
?>