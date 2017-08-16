<?php
	require_once("postManager.php");
	require_once("memberManager.php");
	require_once("friendsManager.php");
	require_once("requestManager.php");
	echo "<h1> POSTS </h1>";	
	$manager=new PostManager;
	$posts=$manager->getPostsForUser(1,0,5);
			
	for($i=0;$i<count($posts);++$i){
		$post=$posts[$i];
		echo $post->getFrom()."\t ".$post->getDescription()."<br />";
	}
	echo "<h1> Friends </h1>";
	$manager=new FriendsManager;
	echo $manager->checkFriendship(1,12);
	echo $manager->getError();
	$friends=$manager->getFriendsOfUser(1,0,5);
	for($i=0;$i<count($friends);++$i){
		$member=$friends[$i];
		echo $member->getName()."\t ".$member->getId()."<br />";
	}
	echo "<h1> All Users </h1>";
	$manager=new MemberManager;
	$friends=$manager->getAllUsers(0,5);
	for($i=0;$i<count($friends);++$i){
		$member=$friends[$i];
		echo $member->getName()."\t ".$member->getId()."<br />";
	}
	echo "<h1> Friend Requests </h1>";
		$manager=new RequestManager;
	$friends=$manager->getRequestsForUser(1,0,5);
	for($i=0;$i<count($friends);++$i){
		$member=$friends[$i];
		echo $member->getName()."\t ".$member->getId()."<br />";
	}
?>
<html>
<script>
	function add(object){
		parent=document.getElementById("li1").parentNode;
			alert(parent.getElementsByTagName("span").item(0).innerHTML);
	}
</script>
<body>
	<ul>
    	<li class="row">
        	<span id="li1"> Akshat</span> <a onClick="add(this)"> Add me</a>
        </li>
    </ul>
    
</body>
</html>