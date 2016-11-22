<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" /> 
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
	<h1>Forum</h1>
	
	<div id="container">
	<div id="menu">
		<a class="item" href="index.php">Index</a> 
		<a class="item" href="new_topic.php">Post topic</a> 
		<a class="item" href="new_category.php">Create category</a>

		<div id="tools">
		<?php
		if($_SESSION['logged_in']){
			echo '<font color="white"> <a class="item" href="logout.php">Log out</a> : <b>' . htmlentities($_SESSION['user_name']) . '</b> </font>';
			if($_SESSION['user_level'] == 1){
				echo '<a class="item" href="user_level.php">User levels</a>';
			}
		} else {
			echo '<a class="item" href="login.php">Log in</a>  <a class="item" href="create_acc.php">Create an account</a>';
		}
		?>
		</div>
		
	</div>
		<div id="content">
		<!--html and body tags are closed in the footer that is added to each file -->