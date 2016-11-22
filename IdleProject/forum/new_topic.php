<?php
include 'connect.php';
include 'header.php';

echo '<h2>Create a topic</h2>';
if($_SESSION['logged_in'] == false){
	echo 'Sorry, you have to be <a href="/9/login.php">logged in</a> to create a topic.';
} else {
	if($_SERVER['REQUEST_METHOD'] != 'POST'){	
		$sql = "SELECT
					category_id,
					category_name,
					category_description
				FROM
					categories";
		
		$result = mysql_query($sql);
		
		if(!$result){
			echo 'There was an error when selecting from the database.';
		} else {
			if(mysql_num_rows($result) == 0){
				if($_SESSION['user_level'] == 1){
					echo 'You have not created categories yet.';
				} else {
					echo 'An administrator must create a category before topics can be posted.';
				}
			} else {
		
				echo '<form method="post" action="">
					Subject: <input type="text" name="topic_name" /><br />
					Category:'; 
				
				echo '<select name="topic_category">';
					while($row = mysql_fetch_assoc($result)){
						echo '<option value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
					}
				echo '</select><br />';	
					
				echo 'Message: <br /><textarea name="post_content" /></textarea><br /><br />
					<input type="submit" value="Create topic" />
				 </form>';
			}
		}
	} else {
		//start transaction
		$query  = "BEGIN WORK;";
		$result = mysql_query($query);
		
		if(!$result){
			echo 'An error occured while creating your topic. Please try again later.';
		} else {
			$sql = "INSERT INTO 
						topics(topic_name,
							   topic_date,
							   topic_category,
							   topic_by)
				   VALUES('" . mysql_real_escape_string($_POST['topic_name']) . "',
							   NOW(),
							   " . mysql_real_escape_string($_POST['topic_category']) . ",
							   " . $_SESSION['user_id'] . "
							   )";
					 
			$result = mysql_query($sql);
			if(!$result){
				echo 'An error occured while inserting your data. Please try again later.<br /><br />' . mysql_error();
				$sql = "ROLLBACK;";
				$result = mysql_query($sql);
			} else {
				$topicid = mysql_insert_id();
				
				$sql = "INSERT INTO
							posts(post_content,
								  post_date,
								  post_topic,
								  post_by)
						VALUES
							('" . mysql_real_escape_string($_POST['post_content']) . "',
								  NOW(),
								  " . $topicid . ",
								  " . $_SESSION['user_id'] . "
							)";
				$result = mysql_query($sql);
				
			if(!$result){
				echo 'An error occured while inserting your post. Please try again later.<br /><br />' . mysql_error();
				//cancel the transaction
				$sql = "ROLLBACK;";
				$result = mysql_query($sql);
			} else {
				$sql = "COMMIT;";
				$result = mysql_query($sql);
				echo 'You have succesfully created <a href="topic.php?id='. $topicid . '">your new topic</a>.';
				}
			}
		}
	}
}

include 'footer.php';
?>
