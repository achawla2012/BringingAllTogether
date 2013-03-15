<?php
include_once 'header.php';
echo "<h3>Member Log in </h3>";
$error=$user=$pass="";
if(isset($_POST['user']))
{
	$user= SanitizeString($_POST['user']);
	$pass= SanitizeString($_POST['pass']);
	if($user == "" || $pass =="")
	{
		$error = " Enter all fields";
	}
	else
	{
		$query= "SELECT user, pass FROM rnmembers WHERE user='$user' AND pass='$pass'";
		if (mysql_num_rows(QueryMySql($query)) == 0)
        {
		  $error= "Invalid UserName/Password";
        } 
        else
        {
          $_SESSION['user'] = $user;
          $_SESSION['pass'] = $pass;
		  die ("You are logged in. Please <a href='rnmembers.php?view=$user'> click here </a>.");
		}
	}	
}	 
<form method='post' action='login.php'>$error
Username <input type='text' maxlength='16' name= 'user' value='$user'/><br/>
Password <input type='password' maxlength='16' name= 'pass' value='$pass'/><br/>
<input type='submit' value='login' />
</form>
?>