<?php
require("../../../DB/config.php");

if(isset($_POST['C_Roll']))
{
			$C_Roll = $_POST['C_Roll'];
			$stid = $_POST['stid'];
			$mts = $_POST['mts'];
			$sql="";
			if($mts=="mt1")
		        {
                      		$sql ="SELECT C_Roll_Number FROM Student_Info where C_Roll_Number='$C_Roll'";
                      	}
                      	if($mts=="mt2")
                      	{
                      		$stid= ltrim($stid,'A'); 
                      		$sql ="SELECT C_Roll_Number FROM Student_Info where C_Roll_Number='$C_Roll' and Student_ID!='$stid' ";
                      	}
    			$query= $dbh -> prepare($sql);
    			$query-> execute();
    			$count = $query->rowCount();
			if($count!=0) // Show Sample Roll Which are not exist in table
			{
    			 echo "Found";
    			} 
}
//$query->close;
//$dbh=null;
?>
