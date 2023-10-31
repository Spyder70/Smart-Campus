<?php
require("../../DB/config.php");

if(isset($_POST['s_by']))
{
			$Search_By = $_POST['s_by'];
                      	$sql ="SELECT $Search_By FROM Student_Info group by $Search_By";
    			$query= $dbh -> prepare($sql);
    			//$query-> bindParam(':Dept_Name1', $Dept_Name);
    			$query-> execute();
    			$Tresults=$query->fetchAll(PDO::FETCH_OBJ);
    			?>
    			<option value=''></option>
    			<?php
    			
    			foreach($Tresults as $result2)
    			{  ?>
    			<option value="<?php echo $result2->$Search_By;?>"> <?php echo $result2->$Search_By;?> </option>
    			<?php 
    			} 
}
//$query->close;
//$dbh=null;
?>
