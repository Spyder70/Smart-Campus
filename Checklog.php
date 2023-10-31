<?php
//session_start();
//require("connect.php");
//require("config.php");

//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
$CL=$_SESSION['SMC_Login']; 

    	if($CL==="yes")
    	{
	}
	else
	{
		header("location:../Logout.php");
		exit;
	}


?>
