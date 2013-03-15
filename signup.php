<?php
include_once 'header.php';
<script>
document.write("hello");
function CheckUser(user)
{
document.write("HELLO");
if(user.value == '')
   {
     document.getElementById('info').innerHTML =''
	 return
   }
document.write("hello");
params="user:"+user.value
request= new ajaxRequest()
request.open("POST", "checkuser.php", true)
request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
request.setRequestHeader("Content-length", params.length)
request.setRequestHeader("Connection","close")
request.onreadystatechange = function()
{
  if(this.readystate == 4)
   {
     if(this.status == 200)
       {
         if(this.responseText!=null)
          {
		    document.getElementById('info').innerHTML = this.reponseText
     		return
          }
         else alert("Ajax eror:" + this.statusText)
       } 
   } 
  request.send(params) 
}
function ajaxRequest()
{
  try
  {
     var request= new XMLHttpRequest()
  }
  catch(e1)
  {
     try
     {
       request = new ActiveXObject("Msxml2.XMLHTTP")
     }
     catch(e2)
     {
       try
       {  
          request = new ActiveXObject("Microsoft.XMLHTTP")
       }
       catch(e3)
       {
          request = false
       } 
     }
  }
  return request
}
</script>
$error=$user=$pass="";
if(isset($_SESSION['user'])) 
{ 
	echo "Hello";
	DestroySession();
}
if(isset($_POST['user']))
{
    $user= SanitizeString($_POST['user']);
	$pass= SanitizeString($_POST['pass']);
	if($user == "" || $pass == "")
	{
		$error = "Enter all fields"."<br/>";
	}
	else
	{
		$query= "SELECT user, pass FROM members WHERE user='$user' AND pass='$pass'";
		
		if (mysql_num_rows(QueryMySql($query)) != 0)
        {
		    echo "<br/>";
			die ("User name already exists");
        } 
		else
        {
			$query= "INSERT INTO members VALUES('$user','$pass')";
			QueryMySql($query);
        }
		die ("<h4> Account created</h4> Log in");
	}	
}	
<form method='post' action='signup.php'> <b>$error</b>
Username <input type='text' maxlength='16' name= 'user' value='$user' onBlur='CheckUser(this)'/> 
         <span id='info'> Text </span>
<br/>
Password <input type='password' maxlength='16' name= 'pass' value='$pass'/>
<br/>
<input type='submit' value='Signup' />
</form>
?>



