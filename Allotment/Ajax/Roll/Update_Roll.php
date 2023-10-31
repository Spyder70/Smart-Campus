<?php
require("../../../DB/config.php");

/*
if(isset($_POST['Stat']))
{*/
			
		//$Role = $_POST['Role'];
		//$Student_ID = $_POST['Student_ID'];
		$Batch = $_POST['Batch'];
		$C_Type = $_POST['C_Type'];
		$Sem = $_POST['Sem'];
		$Dept_Name = $_POST['Dept_Name'];
		$Program = $_POST['Program'];
		$Section = $_POST['Section'];
		$Pre_Roll = $_POST['Pre_Roll'];
		/*$Stat = $_POST['Stat'];
			
		if($Stat=="Addf")
		{*/	
			$Add_sql="Select S1.Student_ID
			          from Student_Info as S1 where S1.C_Roll_Number!='' 
			          and S1.Batch='$Batch'  and S1.Sem='$Sem' 
			          and S1.Program In( Select D1.Short_Name from Department as D1
                                 where D1.Course_Type='$C_Type') ";
                                 
			if($Program!="")
			{
				$Add_sql=$Add_sql." and S1.Program='$Program' ";
			}
			if($Section!="")
			{
				$Add_sql=$Add_sql." and S1.Section='$Section' ";
			}
			
                    
                       $Add_query= $dbh -> prepare($Add_sql);
			$Add_query-> execute();
    			$Fresult=$Add_query->fetchAll(PDO::FETCH_OBJ);
			
			$i=0;     
                  	 			
    			foreach($Fresult as $Fres)
			{
				$SS_id=$Fres->Student_ID;
				$Each_id="A".$SS_id;
				$New_Sid=trim($_POST[$Each_id]);
				
				$new_sql=" update Student_Info set C_Roll_Number='$New_Sid' where Student_ID='$SS_id'";
				$new_query= $dbh -> prepare($new_sql);
				$new_query-> execute();
				
				$i=$i+1;
                       }
                      
                       if($i!=0)
                       echo "OK";
                       else
                       echo "No Update";
                     
			
?>
                      

