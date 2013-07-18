<?php

include($_SERVER['DOCUMENT_ROOT'] . "views/includes/comments.php");

if($_SESSION["user"]) { // Logged in?
	$targetId = $_POST['target'];
	$type = $_POST['type'];
	$comment = $_POST['commentText'];
	
	$user = unserialize($_SESSION["user"]);
	$userName = $user->__get("name");
	$userId = $user->__get("id");
	
	$ip = $_SERVER["REMOTE_ADDR"];
	
	$commentsAccess = new CommentsAccess();
	//$ok = $commentsAccess->addComment($type, $targetId, $userName, $userId, $comment, $ip);
	
	if(!$ok && false) { // If db connection failed
		echo("connectionFailed");
		exit;
	}
	
	$time = date("Y-m-d H:i:s");
	$writerIsBoard = $user->__get("isBoard");
	
	printComment(0, $time, $comment, $userId, $userName, $writerIsBoard);
}
else {
	echo("notLoggedIn");
}
?>