<?php
session_start();
require("../../DB/config.php");
$Faculty_ID=$_SESSION['F_ID'];
if(isset($_POST['Fetch']))
{

	if($_POST['Fetch']=="FindFacs")
	{
		$C_Date = $_POST['C_Date'];
          	$sql ="Select Faculty_Subjects.Faculty_ID,Faculty.Name from Faculty_Subjects 
		Left JOIN Faculty ON Faculty_Subjects.Faculty_ID= Faculty.Faculty_ID 
		where Faculty_Subjects.Course_Date='$C_Date' GROUP BY Faculty_Subjects.Faculty_ID 
		ORDER BY Faculty_Subjects.Faculty_ID ASC";
    		$query= $dbh -> prepare($sql);
    		
    		$query-> execute();
    		$results2=$query->fetchAll(PDO::FETCH_OBJ);
    		?>
    		<option value="" selected="selected"></option>
    		<?php
    		foreach($results2 as $result2)
    		{  ?>
    		<option value="<?php echo $result2->Faculty_ID;?>"> <?php 
    		echo $result2->Faculty_ID." - ".$result2->Name ;
    		?></option>
    		<?php 
    		} 
    		
    	}
    	if($_POST['Fetch']=="FindSubs")
	{
		$C_Date = $_POST['C_Date'];
		$Fac_ID = $_POST['Fac_ID'];
		
          	$sql ="Select Faculty_Subjects.FS_ID,Faculty_Subjects.Section,Faculty_Subjects.LBatch,
          	Course_Subjects.Subject_Code,Course_Subjects.Subject_Name,
		Course_Subjects.Sem,Course_Subjects.Branch from Faculty_Subjects 
		Left JOIN Course_Subjects ON Faculty_Subjects.Sub_ID= Course_Subjects.Sub_ID 
		where Faculty_Subjects.Course_Date='$C_Date' and  Faculty_Subjects.Faculty_ID='$Fac_ID' 
		ORDER BY Course_Subjects.Subject_Code ASC";
    		$query= $dbh -> prepare($sql);
    		
    		$query-> execute();
    		$results2=$query->fetchAll(PDO::FETCH_OBJ);
    		?>
    		<option value="" selected="selected"></option>
    		<?php
    		foreach($results2 as $result2)
    		{  ?>
    		<option value="<?php echo $result2->FS_ID;?>"> <?php 
    		echo $result2->Subject_Code." - ".$result2->Subject_Name." : Sem-".$result2->Sem." : ".$result2->Branch;
    		
    		$stLin=""; 
    		
    		if($result2->Section!="")
    		{ $stLin="Sec-".$result2->Section; }
    		if($result2->LBatch>=1)
    		{ $stLin=$stLin." ".$result2->Section.$result2->LBatch; }
    		
    		if($result2->Section!="" or $result2->LBatch>=1)
    		{
    		  $stLin=" ( ".$stLin." ) ";
    		}
    		echo $stLin;
    		?></option>
    		<?php 
    		} 
    		
    	}
    	if($_POST['Fetch']=="FindAlt")
	{
		$C_Date = $_POST['C_Date'];
		$Fac_ID = $_POST['Fac_ID'];
		
          	/*$sql ="Select Faculty_Subjects.Faculty_ID,Faculty.Name from Faculty_Subjects 
		Left JOIN Faculty ON Faculty_Subjects.Faculty_ID= Faculty.Faculty_ID 
		where Faculty_Subjects.Course_Date='$C_Date' and Faculty_Subjects.Faculty_ID!='$Fac_ID'  
		GROUP BY Faculty_Subjects.Faculty_ID 
		ORDER BY Faculty_Subjects.Faculty_ID ASC";*/

                $sql ="Select Faculty.Faculty_ID,Faculty.Name from Faculty 
		where Faculty.Faculty_ID!='$Fac_ID' and  Faculty.Faculty_ID!='admin'
		ORDER BY Faculty.Name ASC";

    		$query= $dbh -> prepare($sql);
    		
    		$query-> execute();
    		$results2=$query->fetchAll(PDO::FETCH_OBJ);
    		?>
    		<option value="" selected="selected"></option>
    		<?php
    		foreach($results2 as $result2)
    		{  ?>
    		<option value="<?php echo $result2->Faculty_ID;?>"> <?php 
    		echo $result2->Faculty_ID." - ".$result2->Name ;
    		?></option>
    		<?php 
    		} 
    		
    	}
 }
	
?>
