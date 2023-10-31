<?php
session_start();
require("../../DB/config.php");
$Faculty_ID=$_SESSION['F_ID'];
if(isset($_POST['Fetch']))
{

	if($_POST['Fetch']=="Exam_Type")
	{
		$C_Date = $_POST['C_Date'];
          	$sql ="SELECT Exam_Type FROM Course_Subjects where Course_Date='$C_Date' group by Exam_Type order by Exam_Type asc";
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
          	$sql ="SELECT Sem FROM Course_Subjects where Course_Date='$C_Date' and Exam_Type='$Exam_Type' group by Sem order by Sem asc";
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
          	Course_Date='$C_Date' and Sem='$Sem' and Exam_Type='$Exam_Type' group by Branch order by Branch asc";
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
	if($_POST['Fetch']=="SubjectType")
	{
		$C_Date = $_POST['C_Date'];
		$Sem = $_POST['Sem'];
		$Branch = $_POST['Branch'];
		$Exam_Type = $_POST['Exam_Type'];
		$sql ="SELECT Subject_Type FROM Course_Subjects where 
          	Course_Date='$C_Date' and Sem='$Sem' and Exam_Type='$Exam_Type' group by Subject_Type order by Subject_Type asc";
    		$query= $dbh -> prepare($sql);
    		$query-> execute();
    		$results2=$query->fetchAll(PDO::FETCH_OBJ);
    		?>
    		<option selected="selected"></option>
    		<?php
    		foreach($results2 as $result2)
    		{  ?>
    		<option value="<?php echo $result2->Subject_Type;?>"> <?php echo $result2->Subject_Type;?> </option>
    		<?php 
    		} 
		
	}
	if($_POST['Fetch']=="Subject")
	{
		$C_Date = $_POST['C_Date'];
		$Sem = $_POST['Sem'];
		$Branch = $_POST['Branch'];
		$Exam_Type = $_POST['Exam_Type'];
		$Subject_Type = $_POST['Sub_type'];
		if($Subject_Type=="Global Elective")
		{
		$sql ="SELECT Sub_ID,Subject_Code,Subject_Name FROM Course_Subjects where 
          	Course_Date='$C_Date' and Sem='$Sem' and Exam_Type='$Exam_Type' and Subject_Type='$Subject_Type' order by Subject_Code";
		}else{
          	$sql ="SELECT Sub_ID,Subject_Code,Subject_Name FROM Course_Subjects where 
          	Course_Date='$C_Date' and Sem='$Sem' and Branch='$Branch' and Exam_Type='$Exam_Type' and Subject_Type='$Subject_Type' order by Subject_Code";
          	}
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
	
}
//$query->close;
//$dbh=null;
?>
