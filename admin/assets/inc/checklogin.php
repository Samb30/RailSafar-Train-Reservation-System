<?php
function check_login()
{
if(strlen($_SESSION['adminId'])==0)
	{
		$host = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra="emp-login.php";
		$_SESSION["adminId"]="";
		header("Location: http://$host$uri/$extra");
	}
}
?>
