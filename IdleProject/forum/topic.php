<?php

include 'connect.php';
include 'header.php';

$sql = "SELECT
			topic_id,
			topic_name
		FROM
			topics
		WHERE
			topics.topic_id = " . mysql_real_escape_string($_GET['id']);
			
$result = mysql_query($sql);

if(!$result){
	echo 'The topic could not be displayed, please try again later.';
} else {
	if(mysql_num_rows($result) == 0){
		echo 'This topic doesn&prime;t exist.';
	} else {
		while($row = mysql_fetch_assoc($result)){
			//topics are displayed using a table
			echo '<table class="topic" border="1">
					<tr>
						<th colspan="2">' . $row['topic_name'] . '</th>
					</tr>';
					


			$posts_sql = "SELECT
						posts.post_topic,
						posts.post_content,
						posts.post_date,
						posts.post_by,
						users.user_id,
						users.user_name
					FROM
						posts
					LEFT JOIN
						users
					ON
					posts.post_by = users.user_id
					WHERE
						posts.post_topic = " . mysql_real_escape_string($_GET['id']);
						
			$posts_result = mysql_query($posts_sql);
			
			if(!$posts_result){
				echo '<tr><td>There was an error displaying the posts.</tr></td></table>';
			} else {
					//the table content is displayed here
					while($posts_row = mysql_fetch_assoc($posts_result)){
					echo '<tr class="topic-post">
							<td class="user-post">' . "user: " . $posts_row['user_name'] . '<br/>' . date('d-m-Y H:i', strtotime($posts_row['post_date'])) . '</td>
							<td class="post-content">' . htmlentities(stripslashes($posts_row['post_content'])) . '</td>
						  </tr>';
				}
			}
			if(!$_SESSION['logged_in']){
				echo '<tr><td colspan=2>You must be <a href="login.php">logged in</a> to reply. You can also <a href="create_acc.php">sign up</a> for an account.';
			} else {
				echo '<tr><td colspan="2"><h2>Reply:</h2><br />
					<form method="post" action="reply.php?id=' . $row['topic_id'] . '">
					
						<textarea name="reply-content"></textarea><br /><br />
						<input type="submit" value="Submit reply" />
					</form></td></tr>';
			}
			
			echo '</table>';
		}
	}
}

include 'footer.php';
?>