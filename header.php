<?php
require_once 'functions.php';
session_start();
if (isset($_SESSION['user']))
{
  $user= $_SESSION['user'];
  $loggedin= TRUE;
}
else 
{
	$loggedin=FALSE;
}
echo "<html><head><title>$appname";
if($loggedin) 
	echo "($user)";
echo "</title></head><body><font face='verdana' size='2'>";
echo"<h2>$appname</h2>";
if($loggedin)
{
        echo "<b>$user</b>:
	<a href='members.php?view=$user'>Home</a> |
	<a href='members.php'>Members</a> |
	<a href='friends.php'>Friends</a> |
	<a href='messages.php'>Messages</a> |
	<a href='profile.php'>Profile</a> |
	<a href='logout.php'>Log out</a>";
}
else
{
	echo "<a href='index.php'>Home</a> | <a href='signup.php'>Sign Up</a> | <a href='login.php'>Login</a>" ;
}
?>