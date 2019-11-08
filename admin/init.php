<?php
//development
error_reporting (E_ALL ^ E_DEPRECATED);

//deploy
//error_reporting (0);

if(!isset($_SESSION['admindata']))
{
	if($directory =='ajax')
	{

	}
	else if($directory =='')
	{
		//header('location:../index.php');
		header('location:index.php');
	}
}
else
{
	//echo isset($_SESSION['admindata']);
}

//ini_set('post_max_size', '64M');
//ini_set('upload_max_filesize', '64M');

?>