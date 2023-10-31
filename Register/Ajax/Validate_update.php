<?php
require("../../DB/config.php");

if(isset($_POST['C_USN']))
{
			$C_USN = trim($_POST['C_USN']);
			$Old_USN = trim($_POST['Old_USN']);
			$Praaptha_No = trim($_POST['Praaptha_No']);
			$Batch = $_POST['Batch'];
			$Section = $_POST['Section'];
			$Sem = $_POST['Sem'];
			$C_Roll_Number = trim($_POST['C_Roll_Number']);
			$Aadhaar = trim($_POST['Aadhaar']);
			$G_Student_ID = $_POST['G_Student_ID'];
			
			$Msg="Success";
			//if($query->rowCount() > 0){}
			
			if($C_Roll_Number!="")
			{
    				$sql ="SELECT C_USN FROM Student_Info where C_Roll_Number=:C_Roll_Number1 and Student_ID!=:G_Student_ID1";
    				$query= $dbh -> prepare($sql);
    				$query-> bindParam(':C_Roll_Number1', $C_Roll_Number);
    				$query-> bindParam(':G_Student_ID1', $G_Student_ID);
    				$query-> execute();
    				if($query->rowCount() > 0)
    				{
    				$Msg="Roll Number Alredy Exist";
    				}
    			}
			
			
			if($C_USN!="")
			{
                      		$sql ="SELECT C_USN FROM Student_Info where C_USN=:C_USN1 and Student_ID!=:G_Student_ID1";
    				$query= $dbh -> prepare($sql);
    				$query-> bindParam(':C_USN1', $C_USN);
    				$query-> bindParam(':G_Student_ID1', $G_Student_ID);
    				$query-> execute();
    				if($query->rowCount() > 0)
    				{
    				$Msg="USN Alredy Exist";
    				}
    			}
    			
    			if($Praaptha_No!="")
    			{
    				$sql ="SELECT C_USN FROM Student_Info where Praaptha_No=:Praaptha_No1 and Student_ID!=:G_Student_ID1";
    				$query= $dbh -> prepare($sql);
    				$query-> bindParam(':Praaptha_No1', $Praaptha_No);
    				$query-> bindParam(':G_Student_ID1', $G_Student_ID);
    				$query-> execute();
    				if($query->rowCount() > 0)
    				{
    				$Msg="Praaptha_No Alredy Exist";
    				}
    			}
    			
    			if($Aadhaar!="")
    			{
    				$sql ="SELECT C_USN FROM Student_Info where Aadhaar=:Aadhaar1 and Student_ID!=:G_Student_ID1";
    				$query= $dbh -> prepare($sql);
    				$query-> bindParam(':Aadhaar1', $Aadhaar);
    				$query-> bindParam(':G_Student_ID1', $G_Student_ID);
    				$query-> execute();
    				if($query->rowCount() > 0)
    				{
    				$Msg="Aadhaar Number Alredy Exist";
    				}
    			}
    			
    			echo $Msg;
    			
    			
    			
    			
}    			

?>
