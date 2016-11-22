<?php
include 'connect.php';
include 'header.php';

$sql = "SELECT
			category_id,
			category_name,
			category_description
		FROM
			categories
		WHERE
			category_id = " . mysql_real_escape_string($_GET['id']);

$result = mysql_query($sql);

if(!$result){
	echo 'There was an error displaying the category.' . mysql_error();
} else {
	if(mysql_num_rows($result) == 0){
		echo 'This category does not exist.';
	} else {
		while($row = mysql_fetch_assoc($result)){
			echo '<h2>Topics in &Prime;' . $row['category_name'] . '&Prime; category</h2><br />';
		}
		$sql = "SELECT	
					topic_id,
					topic_name,
					topic_date,
					topic_category
					
				FROM
					topics
				WHERE
					topic_category = " . mysql_real_escape_string($_GET['id']);
		
		$result = mysql_query($sql);
		
		if(!$result){
			echo 'There was an error displaying the topics.';
		} else {
			if(mysql_num_rows($result) == 0){
				echo 'There are no topics in this category.';
			} else {
				echo '<table border="1">
					  <tr>
						<th>Topic</th>
						<th>Replies</th>
						<th>Created at</th>
					  </tr>';	
					
				while($row = mysql_fetch_assoc($result))
				{				
			
					//the number of posts per topic are counted
					$count_result = mysql_query("SELECT 
								COUNT(*) 
								AS total
								FROM posts
								WHERE post_topic = " . $row['topic_id']);
					$count = mysql_fetch_assoc($count_result);
					
					echo '<tr>';
						echo '<td class="topic">';
							echo '<h3><a href="topic.php?id=' . $row['topic_id'] . '"class="nounderline">' . $row['topic_name'] . '</a><br /><h3>';
						echo '</td>';
						//the post count is decremented and displayed
						echo '<td class="replies">';       
							echo '<h3> '. --$count['total'] .' <h3>';
						echo '</td>';
						
						echo '<td class="created-at">';
							echo date('d-m-Y', strtotime($row['topic_date']));
						echo '</td>';
					echo '</tr>';
				}
			}
		}
	}
}

include 'footer.php';
?>
