<?php
//session_start();
//require("connect.php");
//require("config.php");

//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
if( $_SESSION['F_Role']!='Admin' &&  $_SESSION['F_Role']!='Support')
{       
	echo "No Access..!";
	header("location:../DashBoard/index.php");			
	exit;
}


?>
