<?php
include 'connect.php';
include 'header.php';
//check if the reply has been posted else post it
if($_SERVER['REQUEST_METHOD'] != 'POST'){
	echo 'This file cannot be called directly.';
} else {
	if(!$_SESSION['logged_in']){
		echo 'You must be logged in to post a reply.';
	} else {
		$sql = "INSERT INTO 
					posts(post_content,
						  post_date,
						  post_topic,
						  post_by) 
				VALUES ('" . $_POST['reply-content'] . "',
						NOW(),
						" . mysql_real_escape_string($_GET['id']) . ",
						" . $_SESSION['user_id'] . ")";
						
		$result = mysql_query($sql);
						
		if(!$result){
			echo 'There was an error posting the reply.';
		} else {
			$name = "SELECT topic_replies
						FROM topics";
			$res = mysql_query($name);
			echo 'Your reply was posted, go to <a href="topic.php?id=' . htmlentities($_GET['id']) . '">the topic</a>.';
		}
	}
}

include 'footer.php';
?>