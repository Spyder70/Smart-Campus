<?php
require("../../DB/config.php");

if(isset($_POST['c_type']))
{
			$Ctype = $_POST['c_type'];
                      	$sql ="SELECT Dept_Name FROM Department where Course_Type='$Ctype' order by Dept_Name asc";
    			$query= $dbh -> prepare($sql);
    			//$query-> bindParam(':Dept_Name1', $Dept_Name);
    			$query-> execute();
    			$results2=$query->fetchAll(PDO::FETCH_OBJ);
    			?>
    			<option value="">-----Choose----</option>
    			<?php
    			
    			foreach($results2 as $result2)
    			{  ?>
    			<option value="<?php echo $result2->Dept_Name;?>"> <?php echo $result2->Dept_Name;?> </option>
    			<?php 
    			} 
}
//$query->close;
//$dbh=null;
?>
