<?php
require("../../../DB/config.php");
$sql="";

if(isset($_POST['Role']))
{
			
			$Role = $_POST['Role'];
			
			$C_Date = $_POST['C_Date'];
			$Exam_Type = $_POST['Exam_Type'];
			$Subject_Type = $_POST['Subject_Type'];
		
		
			
		if($Role=="Fetch_Exam")
		{
			// check whether row exist with that sem
			
			$Add_sql="select Exam_Type from Course_Subjects where 
			Course_Date='$C_Date'  group by Exam_Type order by Exam_Type asc";
			$query= $dbh -> prepare($Add_sql);
    			$query-> execute();
    			$results2=$query->fetchAll(PDO::FETCH_OBJ);
    			?>
    			<option value=""></option>
    			<?php
    			
    			foreach($results2 as $result2)
    			{  ?>
    			<option value="<?php echo $result2->Exam_Type;?>"> <?php echo $result2->Exam_Type;?> </option>
    			<?php 
    			} 
		}
			
		if($Role=="Fetch_SType")
		{
			$Add_sql="select Subject_Type from Course_Subjects where 
			Course_Date='$C_Date' and Exam_Type='$Exam_Type' group by Subject_Type order by Subject_Type asc";
			$query= $dbh -> prepare($Add_sql);
    			$query-> execute();
    			$results2=$query->fetchAll(PDO::FETCH_OBJ);
    			?>
    			<option value=""></option>
    			<?php
    			
    			foreach($results2 as $result2)
    			{  ?>
    			<option value="<?php echo $result2->Subject_Type;?>"> <?php echo $result2->Subject_Type;?> </option>
    			<?php 
    			} 	
		}
		
		if($Role=="Fetch_Subject")
		{
			$Add_sql="select Sub_ID,Subject_Code,Subject_Name from Course_Subjects where 
			Course_Date='$C_Date' and Sem='$Sem' and Branch='$Branch' and Exam_Type='$Exam_Type' 
			and Subject_Type='$Subject_Type'  order by Subject_Code asc";
			$query= $dbh -> prepare($Add_sql);
    			$query-> execute();
    			$results2=$query->fetchAll(PDO::FETCH_OBJ);
    			?>
    			<option value=""></option>
    			<?php
    			
    			foreach($results2 as $result2)
    			{  ?>
    			<option value="<?php echo $result2->Sub_ID;?>"> <?php echo $result2->Subject_Code."-".$result2->Subject_Name;?> </option>
    			<?php 
    			} 	
		}
			
			
}		
?>
                      

