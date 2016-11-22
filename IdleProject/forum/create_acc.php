<?php
include 'connect.php';
include 'header.php';
 
echo '<h3>Create account</h3>';

if($_SERVER['REQUEST_METHOD'] != 'POST'){

echo '<form method="post" action="">
        Username: <input type="text" name="user_name" />
        Password: <input type="password" name="user_password">
        E-mail: <input type="email" name="user_email">
        <input type="submit" value="Create account" />
     </form>';
} else {
	 $errors = array();
	 
	 //make sure the username contains no special characters
	 if(isset($_POST['user_name'])){
		 if(!ctype_alnum($_POST['user_name'])){
			 $errors[] = 'A username may only contain letters and numbers';
		 }
		 if(strlen($_POST['user_name']) > 30){
			 $errors[] = 'A username may not be longer than 30 characters';
		 }
	 } else {
		 $errors[] = 'You did not enter a username';
	 }
	 
	 //make sure the password isn't too short
	 if(isset($_POST['user_password'])){
        if(strlen($_POST['user_password']) < 4){
			 $errors[] = 'A password may not be shorter than 4 characters';
		 }
    } else {
        $errors[] = 'You did not enter a password';
    }
	
	if(!empty($errors)) 
    {
        echo '<ul>';
        foreach($errors as $key => $value)
        {
            echo '<li>' . $value . '</li>';
        }
        echo '</ul>';
    } else {
		//password is md5 encrypted
        $sql = "INSERT INTO
                    users(user_name, user_password, user_email ,user_date, user_level)
                VALUES('" . mysql_real_escape_string($_POST['user_name']) . "',
                       '" . md5($_POST['user_password']) . "', 
                       '" . mysql_real_escape_string($_POST['user_email']) . "',
                        NOW(),
                        0)";
                         
        $result = mysql_query($sql);
        if(!$result)
        {
            echo 'The account could not be created.';
        } else {
            echo 'Your account was created.  <a href="login.php">log in</a> to start posting.';
        }
    }
}

include 'footer.php';

?>