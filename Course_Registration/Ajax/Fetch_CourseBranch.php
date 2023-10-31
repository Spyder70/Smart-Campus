<?php
require("../../DB/config.php");

if(isset($_POST['C_Branch']))
{
			$C_Date = $_POST['C_Branch'];
          $sql1 ="SELECT * FROM Course_Subjects where  Branch=:C_Branch order by Sem,Branch,Subject_Code asc";
    			$query1= $dbh -> prepare($sql1);
    			$query1-> bindParam(':C_Branch', $C_Branch);
    			$query1-> execute();
    			$results12=$query1->fetchAll(PDO::FETCH_OBJ);
    			foreach($results12 as $resultBranch)
    			{
    			echo "<tr>";

			?>

        <td><a href="Add_Course.php?GSub_ID=<?php echo $resultBranch->Sub_ID; ?>"><i class="nav-icon fas fa-edit"></i></a></td>
  			<td ><?php echo $resultBranch->Exam_Type  ; ?></td>
  			<td ><?php echo $resultBranch->Subject_Type  ; ?></td>
  			<td ><?php echo $resultBranch->Th_Pract  ; ?></td>
  			<td><?php echo  $resultBranch->Subject_Code  ; ?></td>
                       <td><?php echo $resultBranch->Subject_Name  ; ?></td>
                       <td><?php echo $resultBranch->Sem  ; ?></td>
                       <td><?php echo $resultBranch->Branch  ; ?></td>
                       <td><?php echo $resultBranch->Credit  ; ?></td>
                       <td><?php echo $resultBranch->Grade  ; ?></td>
                       <td><?php echo $resultBranch->Area  ; ?></td>
                       <td><?php echo $resultBranch->Scheme  ; ?></td>
                       <td><center><a onclick="Dlt('<?php echo $resultBranch->Sub_ID ; ?>');" href="#"><i class="nav-icon fas fa-trash" style='color:red'></i></a></td>
                      	<?php
                      	echo "</tr>";
    			}
}
//$query->close;
//$dbh=null;
?>
