<?php
include 'connect.php';
include 'header.php';

echo '<h2>Log out</h2>';

//check if logged in before logging out then nullify session variables
if($_SESSION['logged_in'] == true){
	$_SESSION['logged_in'] = NULL;
	$_SESSION['user_name'] = NULL;
	$_SESSION['user_id']   = NULL;

	echo 'Succesfully logged out, thank you for visiting.';
} else {
	echo 'You are not logged in. Would you <a href="login.php">like to</a>?';
}

include 'footer.php';
?>