<?php
include_once 'functions.php';
if( isset($_POST['user'] )
{
	$user=SantizeString($_POST['$user']);
	$query= "SELECT * FROM rnmembers WHERE user ='$user'";
	if(mysql_num_rows(QueryMySql($query)))
             echo "<font color= 'red'> &nbsp;&larr; Already Exists </font>";
	else echo "<font color= 'green'> &nbsp;&larr; Username available </font>"; 
}
?>