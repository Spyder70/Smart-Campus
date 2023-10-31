<?php
session_start();
require("../../DB/config.php");
$Faculty_ID=$_SESSION['F_ID'];
if(isset($_POST['Fetch']))
{

	if($_POST['Fetch']=="Exam_Type")
	{
		$C_Date = $_POST['C_Date'];
          	$sql ="SELECT Exam_Type FROM Course_Subjects where Course_Date='$C_Date' group by Exam_Type order by Exam_Type";
    		$query= $dbh -> prepare($sql);
    		
    		$query-> execute();
    		$results2=$query->fetchAll(PDO::FETCH_OBJ);
    		?>
    		<option value="" selected="selected"></option>
    		<?php
    		foreach($results2 as $result2)
    		{  ?>
    		<option value="<?php echo $result2->Exam_Type;?>"> <?php echo $result2->Exam_Type;?> </option>
    		<?php 
    		} 
    		
    	}
	if($_POST['Fetch']=="Sem")
	{
		$C_Date = $_POST['C_Date'];
		$Exam_Type = $_POST['Exam_Type'];
          	$sql ="SELECT Sem FROM Course_Subjects where Course_Date='$C_Date' and Exam_Type='$Exam_Type' group by Sem order by Sem";
    		$query= $dbh -> prepare($sql);
    		
    		$query-> execute();
    		$results2=$query->fetchAll(PDO::FETCH_OBJ);
    		?>
    		<option selected="selected"></option>
    		<?php
    		foreach($results2 as $result2)
    		{  ?>
    		<option value="<?php echo $result2->Sem;?>"> <?php echo $result2->Sem;?> </option>
    		<?php 
    		} 
    	}
    	if($_POST['Fetch']=="Branch")
	{
		$C_Date = $_POST['C_Date'];
		$Sem = $_POST['Sem'];
		$Exam_Type = $_POST['Exam_Type'];
          	$sql ="SELECT Branch FROM Course_Subjects where 
          	Course_Date='$C_Date' and Sem='$Sem' and Exam_Type='$Exam_Type' group by Branch order by Branch";
    		$query= $dbh -> prepare($sql);
    		
    		$query-> execute();
    		$results2=$query->fetchAll(PDO::FETCH_OBJ);
    		?>
    		<option selected="selected"></option>
    		<?php
    		foreach($results2 as $result2)
    		{  ?>
    		<option value="<?php echo $result2->Branch;?>"> <?php echo $result2->Branch;?> </option>
    		<?php 
    		} 
	
	}
	if($_POST['Fetch']=="Subject")
	{
		$C_Date = $_POST['C_Date'];
		$Sem = $_POST['Sem'];
		$Branch = $_POST['Branch'];
		$Exam_Type = $_POST['Exam_Type'];
          	$sql ="SELECT Sub_ID,Subject_Code,Subject_Name FROM Course_Subjects where 
          	Course_Date='$C_Date' and Sem='$Sem' and Branch='$Branch' and Exam_Type='$Exam_Type' order by Subject_Code";
    		$query= $dbh -> prepare($sql);
    		
    		$query-> execute();
    		$results2=$query->fetchAll(PDO::FETCH_OBJ);
    		?>
    		<option selected="selected"></option>
    		<?php
    		foreach($results2 as $result2)
    		{  ?>
    		<option value="<?php echo $result2->Sub_ID;?>"> <?php echo $result2->Subject_Code." - ".$result2->Subject_Name;?> </option>
    		<?php 
    		} 
	
	}
	if($_POST['Fetch']=="Check_Section")
	{
		$Sub_ID = $_POST['Sub_ID'];
		$Exam_Type = $_POST['Exam_Type'];
		
          	$sql ="SELECT * FROM Course_Subjects where Sub_ID='$Sub_ID' ";
    		$query= $dbh -> prepare($sql);
    		$query-> execute();
    		$row = $query->fetch();
    		$Sub_Type=$row['Subject_Type'];
    		$Branch=$row['Branch'];
    		$Sem=$row['Sem'];
    		$Th_Lb=$row['Th_Pract'];
    		
    		if($Sub_Type=='Core' and $Exam_Type='Regular')
    		{
    			// first year
    			if($Branch=="CHE" or $Branch=="PHY")
    			{
    		  	$bt_str="  Cycle='$Branch'  and ";
    			}
    			else 
    			{
    		  	$bt_str="  Program='$Branch'  and ";
    			}
    			$sql2 ="SELECT Section FROM Student_Info where ";
    			$sql2 = $sql2.$bt_str;
    			$sql2=$sql2." Sem='$Sem' group by Section order by Section";
    			$query2= $dbh -> prepare($sql2);
    			$query2-> execute();
    			$results2=$query2->fetchAll(PDO::FETCH_OBJ);
    			?>
    			<option value="" selected="selected"></option>
    			<?php
    			foreach($results2 as $result2)
    			{  
    			  if($result2->Section!=""){
    			  ?>
    			  <option value="<?php echo $result2->Section;?>"> <?php 
    			  echo $result2->Section;?> </option>
    			  <?php 
    			  }
    			}
    			
    			if($Th_Lb=="P")
    			{
    			$sql2 ="SELECT LBatch FROM Student_Info where ";
    			$sql2 = $sql2.$bt_str;
    			$sql2=$sql2." Sem='$Sem' group by LBatch order by LBatch";
    			$query2= $dbh -> prepare($sql2);
    			$query2-> execute();
    			$results2=$query2->fetchAll(PDO::FETCH_OBJ);
    			echo "@";
    			?>
    			<option value="" selected="selected"></option>
    			<?php
    			foreach($results2 as $result2)
    			{  
    			  if($result2->LBatch>=1){
    			  ?>
    			  <option value="<?php echo $result2->LBatch;?>"> <?php 
    			  echo $result2->LBatch;?> </option>
    			  <?php 
    			  }
    			}
    			
    			}
    			 
    		
    		}
    		else
    		{
    		echo 0;
    		}
    		
	}
}
//$query->close;
//$dbh=null;
?>
