<?php
require("../../DB/config.php");

if(isset($_POST['d_name']))
{
			$Dept_Name = $_POST['d_name'];
                      	$sql ="SELECT Short_Name FROM Department where Dept_Name=:Dept_Name1";
    			$query= $dbh -> prepare($sql);
    			$query-> bindParam(':Dept_Name1', $Dept_Name);
    			$query-> execute();
    			$results2=$query->fetchAll(PDO::FETCH_OBJ);
    			?>
    			<option value=""></option>
    			<?php
    			
    			foreach($results2 as $result2)
    			{  ?>
    			<option value="<?php echo $result2->Short_Name;?>"> <?php echo $result2->Short_Name;?> </option>
    			<?php 
    			} 
}
//$query->close;
//$dbh=null;
?>
