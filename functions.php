<?php
$db_username='amar';
$db_servername='localhost';
$db_password='amar';
$db_name='publications';
$appname="Amar";
mysql_connect($db_servername, $db_username, $db_password ) or die (mysql.error());
mysql_select_db($db_name) or die (mysql.error());
function CreateTable($name,$query)
{
	if(TableExists($name))
	    {
	    	echo "Table $name already exists"."<br/>";     
    	}
  	else
    	{
       		$result= QueryMySql("CREATE TABLE $name($query)");
			echo "$result";
       		echo "Table $name created"."<br/>";        
    	}
}
function TableExists($name)
{
	$query=QueryMySql("SHOW TABLES like '$name'");
	return mysql_num_rows($query);     
}
function QueryMySql($query)
{
	$result= mysql_query($query);
	return $result;
}
function SanitizeString($str)
{
    $string=stripslashes($str);
	$string=strip_tags($str);
	$string=htmlentities($str);
	return mysql_real_escape_string($str);
}
function DestroySession()
{
	$_SESSION=array();
	if (session_id() != '' || isset($_COOKIE[session_name()]))
        	setCookie(session_name(),'',time()-20000,'/');
	session_destroy();
}
function ShowProfile($user)
{
	if(file_exists("khada.jpg"))
     		echo "<img src='khanda.jpg' border ='1' align='left'/>";
  	$result=QueryMySql("SELECT * FROM profiles where USER='$user'");
  	if(mysql_num_rows($result))
    	{
     		$row=mysql_fetch_row($result);
     		echo stripslashes($row[1]);
    	} 
}
?>