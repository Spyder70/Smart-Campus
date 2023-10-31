<?php
require("../../DB/config.php");

if(isset($_POST['Short_Name']))
{
			$Short_Name = trim($_POST['Short_Name']);
			$EShort_Name = trim($_POST['EShort_Name']);
			
			
			$Msg="Success";
			//if($query->rowCount() > 0){}
			
			if($EShort_Name=="")
			{
    				$sql ="SELECT Short_Name FROM Department where Short_Name=:Short_Name ";
    				$query= $dbh -> prepare($sql);
    				$query-> bindParam(':Short_Name', $Short_Name);
    				$query-> execute();
    				if($query->rowCount() > 0)
    				{
    				$Msg="Program Alredy Exist";
    				}
    			}
			
			
			if($EShort_Name!="")
			{
                      		$sql ="SELECT Short_Name FROM Department where Short_Name!=:EShort_Name and Short_Name=:Short_Name";
    				$query= $dbh -> prepare($sql);
    				$query-> bindParam(':Short_Name', $Short_Name);
    				$query-> bindParam(':EShort_Name', $EShort_Name);
    				$query-> execute();
    				if($query->rowCount() > 0)
    				{
    				$Msg="Program Alredy Exist";
    				}
    			}
    			
    			echo $Msg;
    				
    			
}    			

?>
