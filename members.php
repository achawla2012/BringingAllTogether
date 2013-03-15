<?php
include_once 'header.php';
if(!isset($_SESSION['user']))
	die("Please Login");
$user=$_SESSION['user'];
if(isset($_GET['view']))
{
	$view=SanitizeString($_GET['view']);
	if($view == $user) 
	{
		$name = "Your";
	}
	else 
	{
		$name = "$view's";
	}
	echo "<h3> $name Page </h3>";
	ShowProfile($view);
    echo "<a href = 'messages.php?view=$view'>$name Messages</a><br/>";
    die ("<a href = 'friends.php?view=$view'>$name Friends</a><br/>");
}
if(isset($_GET['add']))
{
	$add=SanitizeString($_GET['add']);
	$query="SELECT FROM  friends WHERE USER= '$add' AND friend='$user'";

	if(!mysql_num_rows(QueryMySql($query)))
	{
		$query="INSERT INTO friends VALUES('$add','$user')";
		QueryMySql($query);
	}
}
elseif(isset($_GET['remove']))
{
	$remove=SanitizeString($_GET['remove']);
	$query="DELETE FROM friends WHERE user= 'remove' AND friend='$user'";
	$query="INSERT INTO friends VALUES('$add','$user')";
	QueryMySql($query);
}
$result= QueryMySql("SELECT user FROM members ORDER BY user");
$num = mysql_num_rows($result);
echo "<h3> Other Members </h3> <ul>";
for($j=0;$j<$num;++$j)
{
	$row=mysql_fetch_row($result);
	if($row[0] == $user) continue;
	echo "<li><a href='members.php?view=$row[0]'>$row[0]</a>";
 	$query="SELECT FROM friends WHERE USER= '$row[0]' AND friend='$user'";
	$t1= mysql_num_rows(QueryMySql($query));
	$query="SELECT FROM friends WHERE USER= '$add' AND friend='$row[0]'";
	$t2= mysql_num_rows(QueryMySql($query));
	$follow="follow";
	if (($t1+$t2)>1)
	{
		echo " &harr; is a mutual friend";
	}
	elseif ($t1)
	{
		echo " &larr; you are following ";
	}
	elseif ($t2)
	{
		echo " &larr; is following you ";
	}
	if(!$t1)
	{
		echo "[<a href = 'messages.php?add=".$row[0]."'>$follow</a>]";
	}
	else
	{
		echo "[<a href = 'messages.php?remove=".$row[0]."'>drop</a>]";
	}
}
?>