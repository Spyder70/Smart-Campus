<?php
session_start();
require("../../DB/config.php");

if(isset($_POST['C_Date']))
{
	$Faculty_ID=$_SESSION['F_ID'];
	$C_Date = $_POST['C_Date'];

    	$sql4 =" Select CS.Sub_ID,CS.Exam_Type,CS.Subject_Type,CS.Subject_Name,CS.Subject_Code,CS.Sem,CS.Branch,FS.Section,FS.LBatch
    		from Course_Subjects as CS ,Faculty_Subjects  as FS where
    		FS.Faculty_ID='$Faculty_ID' and FS.Course_Date='$C_Date'
    		and CS.Sub_ID=FS.Sub_ID and CS.Course_Date=FS.Course_Date order by CS.Subject_Code";
    	$query4= $dbh -> prepare($sql4);
    	$query4-> execute();
    	$results4=$query4->fetchAll(PDO::FETCH_OBJ);
    	foreach($results4 as $res4)
    	{

    		echo "<tr>";
		?>

         	<td ><?php echo $res4->Exam_Type  ; ?></td>
  		<td ><?php echo $res4->Subject_Type  ; ?></td>
  		<td><?php echo $res4->Subject_Code  ; ?></td>
            	<td><?php echo $res4->Subject_Name  ; ?></td>
     		<td><?php echo $res4->Sem  ; ?></td>
 		<td><?php echo $res4->Branch  ; ?></td>
 		<td><?php echo 'A' ?></td>


		<?php
		echo "</tr>";
	}


}
//$query->close;
//$dbh=null;
?>
