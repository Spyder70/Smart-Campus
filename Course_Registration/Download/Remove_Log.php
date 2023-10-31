<?php
   session_start();
   header("Content-type: text/plain");
   header("Content-Disposition: attachment; filename=Remove_Log.txt");

   if($_SESSION["NT_Exist_USN"]!="")
   {
   	echo "************************ NOT Registered  USN ************************\n\n"; 
   	echo $_SESSION["NT_Exist_USN"];
   }
   
   if($_SESSION["Err_USN"]!="")
   {
   	echo "\n\n**************************Unable To Un-Register***************************\n\n";
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

