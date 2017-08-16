<?php
	require_once("../models/post.php");
	require_once("./connectionManager.php");
	require_once("./inputCleaner.php");

/*
	Responsibilities:
	1. add a new post : i.e.adding an entry in posts table
	2. get posts for a particular user
*/
	class PostManager{
		private $error;
		private $cleaner;
		public function __construct(){
			$this->cleaner=new InputCleaner;
		}
		public function getError(){
			return $this->error;
		}
/*
	function to perform simple insertion in database 
	argument1: is the only argument to function which is of type class Post
				representing a post
	Return Type: int
	1: success
	0: error
*/
		public function addPost($post){
		//	$post=new Post;
			$manager=new ConnectionManager;
			$con=$manager->getConnection();
			if(!$con){
				$this->error=$manager->getError();
				return 0;
			}
			$from=$post->getFrom();
			$desc=$this->cleaner->cleanSqlInput($con,$post->getDescription());
			$time=$post->getTimeStamp();
			$query="Insert into `posts` (`user`,`description`,`time`) values ('$from','$desc','$time')";
			$result=mysqli_query($con,$query);
			if(!$result){
				$this->error=mysqli_error($con);
				return 0;
			}
			$manager->close();
			return $result;
		}
/*
	function for getting post for a user
	argument1: user id 
	argument2: offset from where post have to loaded
	argument3: no. of posts to be loaded
*/
		public function getPostsForUser($user,$offset,$length){
			$posts=array();
			$manager=new ConnectionManager;
			$con=$manager->getConnection();
			if(!$con){
				$this->error=$manager->getError();
				return 0;
			}
			$inquery="(Select user1 from `friends` where user2='$user' UNION Select user2 from `friends` where user1='$user')";
			$sql = "SELECT username,description,time FROM `posts` p,`members` m WHERE p.user=m.id AND (user='$user' or user in $inquery )order by time desc LIMIT $offset, $length ";
			$result=mysqli_query($con,$sql) ;	
			if(!$result){
				$this->error= mysqli_error($con);
				return 0;
			}
			$count=mysqli_num_rows($result);
			for($i=0;$i<$count;++$i){
				$row=mysqli_fetch_row($result);
				$post=new Post($row[0],$row[1],$row[2]);
				array_push($posts,$post);
			}
			$manager->close();
			return $posts;
		}
	}
?>