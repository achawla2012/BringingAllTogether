<?php
include_once 'header.php';
if (!isset($_SESSION['user']))
     die("<br /><br /> Login in ");
$user= $_SESSION['user'];
if (isset($_GET['view'])) 
	{
		$view= SanitizeString($_GET['view']);
	}
else 
	{
		$view= $user;
	}
if($view == $user)
{
	$name ="Your";
	$name1="Your";
	$name2="You are";
}
else
{
	$name1="<a href='members.php?view=$view'>$view</a>'s";
	$name2="$view's";
	$name3="$view is";
}
echo "<h3>$name Friends </h3>";
ShowProfile($view);
$followers = array();
$following = array();
$query = "SELECT * FROM friends WHERE user='$view'";
$result =QueryMySql($query);
$num = mysql_num_rows($result);
for($j=0; $j<$num; ++$j)
{
	$row=$mysql_fetch_row($result);
	$follower[$j] = $row[1];
}
$query = "SELECT * FROM friends WHERE friend ='$view'";
$result =QueryMySql($query);
$num = mysql_num_rows($result);
for($j=0; $j<$num; ++$j)
{
	$row=$mysql_fetch_row($result);
	$following[$j] = $row[1];
}
$mutual = array_intersect($followers, $following);
$followers= array_diff($followers, $mutual);
$following= array_diff($following, $mutual);
$friends= FALSE;
if(sizeof($mutual))
{
	echo "<b>$name2 mutual friends</b><ul>";
	foreach($mutual as $friend)
		echo "<li><a href='members.php?view=$friend'>$friend</a>";
	echo "</ul>";
	$friends =TRUE;
}
if(sizeof($followers))
{
	echo "<b>$name2 followers</b><ul>";
	foreach($followers as $friend)
		echo "<li><a href='members.php?view=$friend'>$friend</a>";
	echo "</ul>";
	$friends =TRUE;
}
if(sizeof($following))
{
	echo "<b>$name3 following</b><ul>";
	foreach($following as $friend)
		echo "<li><a href='members.php?view=$friend'>$friend</a>";
	echo "</ul>";
	$friends =TRUE;
}
if(!$friends)
{
	echo "<ul><li>No one in your circle !!!"; 
}
echo "</ul><a href='rnmembers.php?view=$view'>View $name2 messages</a>";
?>