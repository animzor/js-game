<?php

include 'connect.php';
include 'header.php';

	if($_SERVER['REQUEST_METHOD'] != 'POST'){

//all users are selected except for the one that is currently logged in	
$sql = "SELECT
			user_name,
			user_level,
			user_id
		FROM
			users
		WHERE
			user_id != " . $_SESSION['user_id'];
			
$result = mysql_query($sql);

if(!$result){
	echo 'There was an error retrieving the users.';
} else {
	//check if there are any other users
	if(mysql_num_rows($result) == 0){
		echo 'There are no other users';
	} else {
		//small table with user and user level selection
			echo '<table class="level" border="1">
					<tr>
						<th colspan="2">' . 'Users' . '</th>';
					
					echo '<tr class="level-row">
							<td class="level-left"> <form action="" method="post"> <select name="selected_user">';
							
							while($row = mysql_fetch_assoc($result)){
								echo '<option value="'.$row['user_id'].'">'.$row['user_name'].'</option>';
							}
								echo '</select>  <br/>' . '</td>';
							 echo '<td class="level-right">  <select name="newlevel">
									<option value="0">0</option>
									<option value="1">1</option>
								</select> <input type="submit" value="Update user level" /> </form> </td>';
				echo '</tr>';
			echo '</table>';
	}
}

	} else {
			//update the user level
			$update = "UPDATE
						users
					SET
						user_level =  " . $_POST['newlevel'] . "
					WHERE
						user_id = " . $_POST['selected_user'];
						
						if(mysql_query($update)){
				echo "User level updated";
			} else {
				echo mysql_error();
			}
			}
			
include 'footer.php';
?>