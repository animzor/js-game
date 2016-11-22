<?php
include 'connect.php';
include 'header.php';

$sql = "SELECT
			categories.category_id,
			categories.category_name,
			categories.category_description,
			COUNT(topics.topic_id) AS topics
		FROM
			categories
		LEFT JOIN
			topics
		ON
			topics.topic_id = categories.category_id
		GROUP BY
			categories.category_name, categories.category_description, categories.category_id";

$result = mysql_query($sql);

if(!$result){
	echo 'There was an error displaying the categories.';
} else {
	if(mysql_num_rows($result) == 0){
		echo 'There are no categories.';
	} else {
		echo '<table border="1">
			  <tr>
				<th>Category</th>
				<th>Topics</th>
				<th>Last topic</th>
			  </tr>';	
			  
			
		while($row = mysql_fetch_assoc($result)){				
			echo '<tr>';
				echo '<td class="categories">';
					echo '<h3><a href="category.php?id=' . $row['category_id'] . '" class="nounderline">' . $row['category_name'] . '</a></h3>' . $row['category_description'];
				echo '</td>';
				
				//the number of posts per topic are counted
					$count_result = mysql_query("SELECT 
								COUNT(*) 
								AS total
								FROM topics
								WHERE topic_category = " . $row['category_id']);
					$count = mysql_fetch_assoc($count_result);
				//the total count is displayed here
				echo '<td class="topics">';       
							echo '<h3> '. $count['total'] .' <h3>';
						echo '</td>';
				
				echo '<td class="most-recent">';
					$topicsql = "SELECT
									topic_id,
									topic_name,
									topic_date,
									topic_category
								FROM
									topics
								WHERE
									topic_category = " . $row['category_id'] . "
								ORDER BY
									topic_date
								DESC
								LIMIT
									1";
								
					$topicsresult = mysql_query($topicsql);
				
					if(!$topicsresult){
						echo 'Last topic could not be displayed.';
					} else {
						if(mysql_num_rows($topicsresult) == 0){
							echo 'no topics';
						} else {
							while($topicrow = mysql_fetch_assoc($topicsresult))
							echo '<a href="topic.php?id=' . $topicrow['topic_id'] . '">' . $topicrow['topic_name'] . '</a> at ' . date('d-m-Y', strtotime($topicrow['topic_date']));
						}
					}
				echo '</td>';
			echo '</tr>';
		}
	}
}


?>