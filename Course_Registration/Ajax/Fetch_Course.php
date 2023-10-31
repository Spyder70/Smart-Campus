<?php
require("../../DB/config.php");

if(isset($_POST['C_Date']))
{
			$C_Date = $_POST['C_Date'];
                      	$sql ="SELECT * FROM Course_Subjects where  Branch=:C_Date order by Sem,Branch,Subject_Code asc";
    			$query= $dbh -> prepare($sql);
    			$query-> bindParam(':C_Date', $C_Date);
    			$query-> execute();
    			$results2=$query->fetchAll(PDO::FETCH_OBJ);
    			foreach($results2 as $result)
    			{
    			echo "<tr>";

			?>

                      	<td><a href="Add_Course.php?GSub_ID=<?php echo $result->Sub_ID; ?>"><i class="nav-icon fas fa-edit"></i></a></td>
  			<td ><?php echo $result->Exam_Type  ; ?></td>
  			<td ><?php echo $result->Subject_Type  ; ?></td>
  			<td ><?php echo $result->Th_Pract  ; ?></td>
  			<td><?php echo $result->Subject_Code  ; ?></td>
                       <td><?php echo $result->Subject_Name  ; ?></td>
                       <td><?php echo $result->Sem  ; ?></td>
                       <td><?php echo $result->Branch  ; ?></td>
                       <td><?php echo $result->Credit  ; ?></td>
                       <td><?php echo $result->Hours  ; ?></td>
                    
                       <td><center><a onclick="Dlt('<?php echo $result->Sub_ID ; ?>');" href="#"><i class="nav-icon fas fa-trash" style='color:red'></i></a></td>
                      	<?php
                      	echo "</tr>";
    			}
}
//$query->close;
//$dbh=null;
?>
