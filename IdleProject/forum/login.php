<?php
include 'connect.php';
include 'header.php';

echo '<h3>Log in</h3>';

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
	echo 'You are already logged in, do you want to <a href="logout.php">log out</a>?';
} else {
	 if($_SERVER['REQUEST_METHOD'] != 'POST'){
        echo '<form method="post" action="">
            Username: <input type="text" name="user_name"/>
            Password: <input type="password" name="user_password">
            <input type="submit" value="Log in" />
         </form>';
    } else { 
	  $errors = array(); 
        if(!isset($_POST['user_name'])){
            $errors[] = 'You did not enter a username.';
        }
         
        if(!isset($_POST['user_password'])){
            $errors[] = 'You did not enter a password.';
        }
         
        if(!empty($errors)){
            echo '<ul>';
            foreach($errors as $key => $value) {
                echo '<li>' . $value . '</li>'; 
            }
            echo '</ul>';
        } else {
			$sql = "SELECT
                        user_id,
                        user_name,
                        user_level
                    FROM
                        users
                    WHERE
                        user_name = '" . mysql_real_escape_string($_POST['user_name']) . "'
                    AND
                        user_password = '" . md5($_POST['user_password']) . "'";
                         
            $result = mysql_query($sql);
            if(!$result){
                echo 'Unable to log in.';
            } else {
                if(mysql_num_rows($result) == 0){
                    echo 'The username or password was incorrect.';
                } else {
                    $_SESSION['logged_in'] = true;
                     
                    while($row = mysql_fetch_assoc($result)){
						
                        $_SESSION['user_id']    = $row['user_id'];
                        $_SESSION['user_name']  = $row['user_name'];
                        $_SESSION['user_level'] = $row['user_level'];
                    }
                     
                    echo 'Welcome, ' . $_SESSION['user_name'] . '. <a href="index.php">go to index</a>.';
                }
            }
        }
    }
}

include 'footer.php';
?>