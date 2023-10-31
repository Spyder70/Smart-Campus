<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../../DB/config.php");
require("../../Authenticate/Admin.php");

//$L_Department="active";
if(isset($_POST['D_id']))
{

// Update it 
// While Update   delete  Student alloted with this id    insert again with new Same id's with compatible sem branch

$Sub_ID=$_POST['D_id'];

$sql2="delete from Course_Subjects where  Sub_ID='$Sub_ID'";
$query2 = $dbh->prepare($sql2);	
$query2->execute();	

$sql2="delete from Course_Registration where  Sub_ID='$Sub_ID'";
$query2 = $dbh->prepare($sql2);	

if( $query2->execute() ) 
echo "Delete was Successfull";
else
echo "Error with Deletion";
}//Update End
?>
