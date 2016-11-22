<?php
include 'connect.php';
include 'header.php';

echo '<h2>Create a category</h2>';
//check if user is an administrator
if($_SESSION['logged_in'] == false | $_SESSION['user_level'] != 1 ){
	echo 'Sorry, this page is only available to administrators.';
} else {
	if($_SERVER['REQUEST_METHOD'] != 'POST'){
		echo '<form method="post" action="">
			Category name: <input type="text" name="category_name" /><br />
			Category description:<br /> <textarea name="category_description" /></textarea><br /><br />
			<input type="submit" value="Create category" />
		 </form>';
	} else {
		$sql = "INSERT INTO categories(category_name, category_description)
		   VALUES('" . mysql_real_escape_string($_POST['category_name']) . "',
				 '" . mysql_real_escape_string($_POST['category_description']) . "')";
		$result = mysql_query($sql);
		if(!$result){
			echo 'Error' . mysql_error();
		} else {
			echo 'The category was successfully created.';
		}
	}
}

include 'footer.php';
?>
