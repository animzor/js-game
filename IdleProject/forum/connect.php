<?php 
session_start();

if(!mysql_connect('localhost', 'root', 'secret')){
 	exit('Error: could not establish database connection');
}
if(!mysql_select_db('forumdb')){
 	exit('Error: could not select the database');
}
?>
