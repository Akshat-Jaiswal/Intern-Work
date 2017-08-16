<?php
	session_start();
	require_once("../models/post.php");
	require_once("requestManager.php");
	require_once("postManager.php");
if(isset($_POST['userId'])&&isset($_POST['type'])){
		$user=$_SESSION['id'];
		$name=$_POST['name'];
		$type=$_POST['type'];
		$requestedBy=$_POST['userId'];
		if($user==$requestedBy){
			$response=array('code' => '5','data' => "You Cannot Send requests To YourSelf");
			exit(json_encode($response));

		}
		$dt=date("Y-m-d H:i:s",strtotime("+330 minutes"));
		$manager=new RequestManager;
		if($type=="accept"){
			$result=$manager->acceptRequest($requestedBy,$user);
			$data="Request accepted";
			if($result){
				$desc=$_SESSION['username']." is now friends with ". $name;
				$post=new Post($user,$desc,$dt);
				$manager=new PostManager;
				$manager->addPost($post);
			}
		}
		else if($type=="decline"){
			$result=$manager->deleteRequest($requestedBy,$user);
			$data="Request Declined";
		}
		else if($type=="send"){
			$result=$manager->addRequest($user,$requestedBy);
			$data="Request Send";
		}
		if(!$result){
			$data=$manager->getError();
			$response=array('code' => '1','data' => $data);
		}
		$response=array('code' => '6','data' => $data);
		exit(json_encode($response));

}
else{
$response=array('code' => '0', 'data' => 'Not Enough Parameters in Call to scripts');
exit(json_encode($response));
}
?>
