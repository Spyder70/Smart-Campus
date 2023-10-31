<?php
   session_start();
   header("Content-type: text/plain");
   header("Content-Disposition: attachment; filename=Upload_Log.txt");

   if($_SESSION["Exist_USN"]!="")
   {
   	echo "************************ Already Registered  USN ************************\n\n"; 
   	echo $_SESSION["Exist_USN"];
   }
   
   if($_SESSION["Err_USN"]!="")
   {
   	echo "\n\n**************************Unable To Register***************************\n\n";
   	echo $_SESSION["Err_USN"];
   }
   
   if($_SESSION["SbCode_NF"]!="")
   {
   	echo "\n\n***********************Subject Code Not Found************************\n\n";
   	echo $_SESSION["SbCode_NF"];
   }
   
   if($_SESSION["USN_NF"]!="")
   {
   	echo "\n\n**************************USN  Not Found***************************\n\n";
   	echo $_SESSION["USN_NF"];
   }
   
 ?>

