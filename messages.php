<?php
include_once 'header.php';
if (!isset($_SESSION['user']))
     die("<br /><br /> Login in ");
$user= $_SESSION['user'];
if (isset($_POST['view'])) 
	{
		$view= SanitizeString($_POST['view']);
	}
else 
	{
		$view = $user;
	}
if (isset($_POST['text']))
{
	$text= SanitizeString($_POST['view']);
	
	if ($text!="")
	{
		$pm =substr(SanitizeString($_POST['pm']),0,1);
		$time=time();
		QueryMySql("INSERT INTO messages VALUES(NULL, '$user', '$view', '$pm', '$time', '$text')");
	}  
}
if($view != "")
{
	if($view == $user)
	{
		$name1="Your";
		$name2="Your";
	}
	else
	{
		$name1="<a href='members.php?view=$view'>$view</a>'s";
		$name2="$view's";
	}
	echo "<h3>$name1 Messages</h3>";
	ShowProfile($view);
<form method='post' action='messages.php?view=$view'>
Type Message: 
<br/>
<textarea name='text' cols='40' rows='4'></textarea>
<br/>
Public <input type ='radio' name ='pm' value='0' checked='checked'/>
Private <input type ='radio' name ='pm' value='1' />
<input type='submit' value= 'Post message' />
</form>
	if(isset($_POST['erase']))
	{
		$erase=SanitizeString($_POST['erase']);
        QueryMySql("DELETE FROM messages WHERE id=$erase AND recip='$user'");
	}
	$query= "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
	$result= QueryMySql($query);
	$num=mysql_num_rows($result);
	for ($j=0;$j<$num;$j++)
	{
		$num=mysql_fetch_row($result);
		if($row[3]==0 || $row[1]==$user || $row[2]==$user)
		{
			echo date('M jS \'y g:sa', $row[4]);
			echo "<a href='messages.php?view=$row[1]'> $row[1]</a>";
		
			if($row[3] == 0)
			{
				echo "wrote: &quot;$row[5]&quot; ";
			}
			else
			{
				echo "whispered: <i><font color='#006600'>&quot;$row[5]&quot;</font></i> ";
			}

			if($row[2] == $user)
			{
				echo "[<a href='messages.php?view=$view";
				echo "&erase=$row[0]'>erase</a>]";
			}
			echo "<br/>";
		}
	}
}		
if(!$num) 
	{
		echo "<li> No messages yet </li> <br/>";
	}
echo "<br><a href = 'messages.php?view=$view'> Refresh messages </a> | ";
echo "<a href = 'friends.php?view=$view'> View your friends </a></br>";

?>