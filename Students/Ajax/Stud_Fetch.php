<?php
require("../../DB/config.php");
$sql="";

if(isset($_POST['Dept_Name']))
{
			$Dept_Name = $_POST['Dept_Name'];
			$Program = $_POST['Program'];
			$Batch = $_POST['Batch'];
			$Sem = $_POST['Sem'];
			
			$jk=0;
			$Add_Str="";
			if($Dept_Name!="ALL")
			{ $jk=$jk+1;
			$Add_Str=$Add_Str." Dept_Name='$Dept_Name' "; }
			
			if($Program!="ALL")
			{ 
			if($jk!=0){ $Add_Str=$Add_Str." and "; } $jk=$jk+1;
			$Add_Str=$Add_Str." Program='$Program' "; 
			}
			
			if($Batch!="ALL")
			{ 
			if($jk!=0){ $Add_Str=$Add_Str." and "; } $jk=$jk+1;
			$Add_Str=$Add_Str." Batch='$Batch' "; 
			}
			
			if($Sem!="ALL")
			{ 
			if($jk!=0){ $Add_Str=$Add_Str." and "; } $jk=$jk+1;
			$Add_Str=$Add_Str." Sem='$Sem' "; 
			}
			
			if($jk!=0){$Add_Str=" where ".$Add_Str;}
			
			
$sql ="SELECT Student_ID,C_USN,C_Roll_Number,Gender,Student_Name,Program,Sem,Section,DOB,DOJ,Admission_Quota,Student_Mob,PCM_Percent FROM Student_Info ".$Add_Str." order by Program,Sem,Section,C_USN ";
    			
    			//$query-> bindParam(':Dept_Name1', $Dept_Name);
    			
}
else if(isset($_POST['Search_Text']))
{
			$Search_By = $_POST['Search_By'];
			$Search_Text = $_POST['Search_Text'];
			//echo $Search_By."=".$Search_Text ;
			
			$sql ="SELECT Student_ID,C_USN,C_Roll_Number,Gender,Student_Name,Program,Sem,Section,DOB,DOJ,Admission_Quota,Student_Mob,PCM_Percent FROM Student_Info where $Search_By='$Search_Text' ";
    			
}

			$query= $dbh -> prepare($sql);
			$query-> execute();
    			$Fresult=$query->fetchAll(PDO::FETCH_OBJ);
    			
    			foreach($Fresult as $Fres)
			{
			echo "<tr>";
			
			?>
                    
                      	<td style="padding:4px;text-align:center;"><a href="../Register/Admission.php?S_ID=<?php echo $Fres->Student_ID  ; ?>" target='_new'><i class="nav-icon fas fa-edit"></i> Edit </a></td>
                      	
                      	<td style="padding:4px;"><?php echo $Fres->C_USN  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->C_Roll_Number  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->Student_Name  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->Gender  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->Program  ; ?></td>
                       <td style="padding:4px;"><?php echo $Fres->Sem  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->Section  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->DOB  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->DOJ  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->Admission_Quota  ; ?></td>
                        <td style="padding:4px;"><?php echo $Fres->Student_Mob  ; ?></td>
                        <td style="padding:4px;"><?php echo $Fres->PCM_Percent  ; ?></td>

                      
                      	<?php
                      	echo "</tr>";
                      	}

?>
