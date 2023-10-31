<?php
require("../../../DB/config.php");


if(isset($_POST['C_Type']))
{
			
			//$Role = $_POST['Role'];
			//$Student_ID = $_POST['Student_ID'];
			$Batch = $_POST['Batch'];
			$C_Type = $_POST['C_Type'];
			$Sem = $_POST['Sem'];
			$Dept_Name = $_POST['Dept_Name'];
			$Program = $_POST['Program'];
			$Section = $_POST['Section'];
			$Pre_Roll = $_POST['Pre_Roll'];
			
			$Add_sql=" Select S1.Student_ID,
				   S1.Program,
			    	   S1.Student_Name,
				   S1.Admission_Quota,
				   S1.Father_Name,
				   S1.DOB
			          from Student_Info as S1 where S1.C_USN='' 
			          and S1.Batch='$Batch'  and S1.Sem='$Sem' 
			          and S1.Program In( Select D1.Short_Name from Department as D1
                                 where D1.Course_Type='$C_Type') ";
			
			
		
			if($Program!="")
			{
				$Add_sql=$Add_sql." and S1.Program='$Program' ";
			}
			if($Section!="")
			{
				$Add_sql=$Add_sql." and S1.Section='$Section' ";
			}
			
                       $Add_sql=$Add_sql." order by S1.Student_Name";
                       $Add_query= $dbh -> prepare($Add_sql);
			$Add_query-> execute();
    			$Fresult=$Add_query->fetchAll(PDO::FETCH_OBJ);
			
			         
			
    			
?>
<style>
.lets{
  padding: 8px 5px;
  font: bold 14px'lucida sans', 'trebuchet MS', 'Tahoma';
  border: 1px solid #a4c3ca;
  background: #f1f1f1;
  border-radius: 5px;
  margin-left:-10px;
  margin-top:-8px;
  margin-bottom:-8px;
  
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25) inset, 0 1px 0 rgba(255, 255, 255, 1);

}
</style>

 <div class="col-6">
  
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title"><b>Without USN <?php echo $Sem; ?> Sem 
                <?php if($Section!=""){ echo "Section:".$Section;}?>
                <input class="btn bg-gradient-danger" type="Button" value='Clear' onclick="Clear_T('mt1')">
                <!-- <input class="btn bg-gradient-warning" type="Reset">--> 
                &nbsp;&nbsp;
                <input class="btn bg-gradient-success" type="Button" onclick="Update_USN('Add')" value='Submit'></b></h3>
		
              </div>
              <!-- /.card-header -->
             
         
              <div class="card-body table-responsive p-0" style="height: 400px;font-size:12px;">
                <table class="table table-head-fixed table-hover text-nowrap" id="mt1" >
                  
                  <thead style="cursor: pointer;">
                    <tr>
                      	<th id="a1" onclick="sortTable('#a1')">USN</th>
                      	<th id="a2" onclick="sortTable('#a2')">Name</th>
  			<th id="a3" onclick="sortTable('#a3')">Branch</th>
  			<th id="a4" onclick="sortTable('#a4')">Quota</th>
                      	<th id="a5" onclick="sortTable('#a5')">DOB</th>
                    
                    </tr>
                  </thead>
                  <tbody id="TBODY">
                  
                  	<?php  
                  	if($Pre_Roll=="")
                  	{
                  	$Pre_Roll="4NM20BE";
                  	}
                  	$new_roll=1;
                  	
                  	 			
    			foreach($Fresult as $Fres)
			{
			
			echo "<tr>";
			
			   while(true)
			   {
			     	$Rnew_roll=sprintf("%03d",$new_roll);
			     	$RRR=$Pre_Roll.$Rnew_roll;
			     
			     	$Add_sql="Select C_USN from Student_Info where C_USN='$RRR'";
				$Add_query= $dbh -> prepare($Add_sql);
				$Add_query-> execute();
			
				$count = $Add_query->rowCount();
				if($count==0) // Show Sample Roll Which are not exist in table
				{

			?>
                    
                      		<td> 
                      		<input  type="text"   class="lets"
                      		name="<?php echo "NA".$Fres->Student_ID ?>" value="<?php echo $RRR; ?>" 
                      		id="<?php echo "NA".$Fres->Student_ID ?>" 
                      		onkeyup="this.value = this.value.toUpperCase();
                      		Check_USN('<?php echo "NA".$Fres->Student_ID;?>','mt1')"/>
                      		</td>
                      	
                     <?php     $new_roll=$new_roll+1;  // increment for Next Roll
                     		break; // out of while loop 
                     		}
                     		$new_roll=$new_roll+1;
                     
                     	    } ?>
                     
                     
                     
                     
                     
                     
  			<td><?php echo $Fres->Student_Name  ; ?></td>
  			<td><?php echo $Fres->Program  ; ?></td>
  			<td><?php echo $Fres->Admission_Quota  ; ?></td>
  			<td><?php echo $Fres->DOB  ; ?></td>
  			
  			
                      
                      	<?php
                      	echo "</tr>";
                      	}
                  	
			?>
                      
                    
                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              
            </div>
            <!-- /.card -->
           
          </div>
        
          
          
          
          
          
        <?php  
          
          
          
          $Add_sql=" Select S1.Student_ID,
          			   S1.C_USN,
			    	   S1.Student_Name,
				   S1.Admission_Quota,
				   S1.Program,
				   S1.DOB
			          from Student_Info as S1 where S1.C_USN!='' 
			          and S1.Batch='$Batch'  and S1.Sem='$Sem' 
			          and S1.Program In( Select D1.Short_Name from Department as D1
                                 where D1.Course_Type='$C_Type') ";
			
			
		
			if($Program!="")
			{
				$Add_sql=$Add_sql." and S1.Program='$Program' ";
			}
			if($Section!="")
			{
				$Add_sql=$Add_sql." and S1.Section='$Section' ";
			}
			
                       $Add_sql=$Add_sql." order by S1.C_USN";
                       $Add_query= $dbh -> prepare($Add_sql);
			$Add_query-> execute();
    			$Fresult=$Add_query->fetchAll(PDO::FETCH_OBJ);
			
			         
			
    			
?>

 <div class="col-6">
 	
             <div class="card card-outline card-success">
              <div class="card-header">
                <h3 class="card-title"><b>With USN Number 	<?php echo $Sem; ?> Sem  &nbsp;&nbsp;
                 <input class="btn bg-gradient-danger" type="Button" value='Clear' onclick="Clear_T('mt2')">&nbsp;&nbsp;
                <!--<input class="btn bg-gradient-warning" type="Reset"> -->
                &nbsp;&nbsp;<input class="btn bg-gradient-info" type="Button" onclick="Update_USN('Update')" value='Update'> </b></h3>
		
              </div>
              <!-- /.card-header -->
              
         	
              <div class="card-body table-responsive p-0" style="height: 400px;font-size:12px;">
                <table class="table table-head-fixed table-hover text-nowrap"  id="mt2">
                  
                      
                 <thead style="cursor: pointer;">
                    <tr>
                    
                       <th id="b1" onclick="sortTable('#b1')">USN</th>
                      	<th id="b2" onclick="sortTable('#b2')">Name</th>
  			<th id="b3" onclick="sortTable('#b3')">Branch</th>
  			<th id="b4" onclick="sortTable('#b4')">Quota</th>
                      	<th id="b5" onclick="sortTable('#b5')">DOB</th>
                    </tr>
                  </thead>
                  
                  
                  
                  <tbody id="TBODY">
                  
                  	<?php   			
    			foreach($Fresult as $Fres)
			{
			echo "<tr>";
			
			?>
                    
                      	<td> 
                      	<input  type="text" class="lets"
                      	name="<?php echo "A".$Fres->Student_ID ?>"  value="<?php echo $Fres->C_USN ?>"
                      	id="<?php echo "A".$Fres->Student_ID ?>" 
                      	onkeyup="this.value = this.value.toUpperCase();
                      		Check_USN('<?php echo "A".$Fres->Student_ID;?>','mt2')"/>
                      	</td>
                      	
                   
  			<td ><?php echo $Fres->Student_Name  ; ?></td>
  			<td ><?php echo $Fres->Program  ; ?></td>
  			<td><?php echo $Fres->Admission_Quota  ; ?></td>
  			<td><?php echo $Fres->DOB  ; ?></td>
  			
  			
                      
                      	<?php
                      	echo "</tr>";
                      	}
                  	
			?>
                      
                    
                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
             
            </div>
            <!-- /.card -->
            
          </div>
          
         
    
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
       
	
<?php   
  			
 
 }

?>
                      

