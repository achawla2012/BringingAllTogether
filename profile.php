<?php
include_once 'header.php';
if(!isset($_SESSION['user']))
	die("Please Login");
$user=$_SESSION['user'];
echo "<h3>Edit your profile </h3>";
if(isset($_POST['text']))
{
	$text=SanitizeString($_POST['text']);
	$text=preg_replace('/\s\s+/',' ', $text);
	$query="SELECT * FROM profiles WHERE user='$user'";
	if( mysql_num_row(QueryMySql($query)))
	{
		QueryMySql("UPDATE profiles SET text ='$text' WHERE user= '$user'");
	}
	else
	{
		$query="INSERT INTO profiles VALUES ('$user','$text')";
		QueryMySql($query);
	}
}
else
{
	$query="SELECT * FROM profiles WHERE user='$user'";
	$result=QueryMySql($query);
	if( mysql_num_rows($result))
	{
		$row= mysql_fetch_row($result);
		$text= stripslashes($row[1]);
	}
	else $text="";
}
$text= stripslashes(preg_replace('/\s\s+/',' ', $text));
if (isset($_FILES['image']['name']))
{
	$saveto = "$user.jpg";
	move_uploaded_file($_FILE['image']['tmp_name'],$saveto);
	$typeok= TRUE;
	switch($_FILE['image']['type'])
	{
		case 'image/gif':
				$src= imagecreatefromgif($saveto);
				break;
		case 'image/jpeg':
		case 'image/jpg':
				$src= imagecreatefromjpeg($saveto);
				break;
		case 'image/png':
				$src= imagecreatefrompng($saveto);
				break;
		default:
				$typeok= FALSE;
	}
	if($typeok)
	{
		list($w,$h) = getimagesize($saveto);
		$max = 200;
		$tw= $w;
		$th= $h;
		if($w>$h && $w>$max)
		{
			$th=$max/$w*$h;
			$tw=$max;
		}
		elseif($w<$h && $h>$max)
		{
			$tw=$max/$h*$w;
			$th=$max;
		}
		elseif($max < $w)
		{
			$tw=$th=$max;
		}
		$tmp= imagecreatetruecolor($tw, $th);
		imagecopysampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
		imageconvolution($tmp,array(array(-1,-1,-1),
				                    array(-1,16,-1),
                                    array(-1,-1,-1)), 8, 0);
		imagejpeg($tmp,$saveto);
		imagedestroy($tmp);
		imagedestroy($src);
	}
}
ShowProfile($user);
<form method='post' action='profile.php' enctype='multidata/form-data'>
Enter or edit your profile and/or upload an image <br/>
<textarea name='text' cols='40' rows='3'>$text</textarea> <br/>
<pre>
Image <input type='file' name='image' size='14' maxlength='32' />
<input type='submit' value='Save Profile' />
</pre>
</form>
?>






















