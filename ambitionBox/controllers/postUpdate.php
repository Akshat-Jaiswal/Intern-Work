<?php
	session_start();
	include_once('../models/post.php');
	include_once('postManager.php');
	include_once('inputCleaner.php');
if(isset($_POST['description'])){
		$cleaner=new InputCleaner;
		// create a new response
		$desc=$cleaner->getCleanInput('description');
		$user=$_SESSION['id'];
		$dt=date("Y-m-d H:i:s",strtotime("+330 minutes"));
		$post=new Post($user,$desc,$dt);
		$manager=new PostManager;
		$result=$manager->addPost($post);
		if(!$result){
			$data=$manager->getError();
			$response=array('code' => '1','data' => $data);
		}
		$data="Post Successful";
		$response=array('code' => '6','data' => $data);
		exit(json_encode($response));

}
else{
$response=array('code' => '0', 'data' => 'Not Enough Parameters in Call to scripts');
exit(json_encode($response));
}
?>