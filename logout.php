<?php
require_once 'functions.php';
session_start();
echo "<h3>Log Out</h3>";
if (isset($_SESSION['user']))
{
	DestroySession();
	echo "You have been logged out. Please <a href='Index.php'> Click here</a> to refresh screen.";
}
else
{
	echo "You are already logged out";
}
   
?>