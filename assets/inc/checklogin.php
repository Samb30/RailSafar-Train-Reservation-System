<?php
function check_login()
{
if(strlen($_SESSION['userId'])==0)
	{
		$host = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra="pass-login.php";
		$_SESSION["userId"]="";
		header("Location: http://$host$uri/$extra");
	}
}
?>
