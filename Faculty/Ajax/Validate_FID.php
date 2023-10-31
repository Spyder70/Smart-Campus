<?php
require("../../DB/config.php");

if(isset($_POST['F_ID']))
{
			$F_ID = trim($_POST['F_ID']);
			$EF_ID = trim($_POST['EF_ID']);
			
			
			$Msg="Success";
			//if($query->rowCount() > 0){}
			
			if($EF_ID=="")
			{
    				$sql ="SELECT Faculty_ID FROM Faculty where Faculty_ID=:F_ID ";
    				$query= $dbh -> prepare($sql);
    				$query-> bindParam(':F_ID', $F_ID);
    				$query-> execute();
    				if($query->rowCount() > 0)
    				{
    				$Msg="Emloyee ID Alredy Exist";
    				}
    			}
			
			
			if($EF_ID!="")
			{
                      		$sql ="SELECT Faculty_ID FROM Faculty where Faculty_ID!=:EF_ID and Faculty_ID=:F_ID";
    				$query= $dbh -> prepare($sql);
    				$query-> bindParam(':F_ID', $F_ID);
    				$query-> bindParam(':EF_ID', $EF_ID);
    				$query-> execute();
    				if($query->rowCount() > 0)
    				{
    				$Msg="Emloyee ID Alredy Exist";
    				}
    			}
    			
    			echo $Msg;
    				
    			
}    			

?>
