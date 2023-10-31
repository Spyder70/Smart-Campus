<?php
require("../../../DB/config.php");
$sql="";

if(isset($_POST['LBatch']))
{
			
			$Role = $_POST['Role'];
			$Student_ID = $_POST['Student_ID'];
			$Batch = $_POST['Batch'];
			$C_Type = $_POST['C_Type'];
			$Sem = $_POST['Sem'];
			$Dept_Name = $_POST['Dept_Name'];
			$Program = $_POST['Program'];
			$Section = $_POST['Section'];
			$LBatch = $_POST['LBatch'];
			
			
		if($Role=="Add")
		{
			// check whether row exist with that sem
			
			$Add_sql="Update Student_Info set LBatch='$LBatch' where Student_ID='$Student_ID'";
			$Add_query= $dbh -> prepare($Add_sql);
			$Add_query-> execute();
		}
			
		if($Role=="Remove")
		{
			$Add_sql="Update Student_Info set LBatch='' where Student_ID='$Student_ID'";
			$Add_query= $dbh -> prepare($Add_sql);
			$Add_query-> execute();	
		}
			
			
			$sql ="Select S1.Student_ID,
			S1.C_USN, 
			S1.C_Roll_Number,
			S1.Student_Name,
			S1.Admission_Quota,
			S1.DOB
			from Student_Info as S1
			Where S1.LBatch='' and  S1.Sem='$Sem' and S1.Section='$Section' and S1.Batch='$Batch' "; 
                 
                       if($C_Type=="UG" and $Sem<=2)
                       { 
                           	$sql=$sql." AND S1.Program In( Select D1.Short_Name from Department as D1
                                 where D1.Course_Type='UG' )";
                                 
                       }
                       
                       if($C_Type=="PG" or ($C_Type=="UG" and $Sem>2))
                       { 
                       	$sql =$sql." and S1.Program='$Program'"; 
                       }
                       
                       $sql =$sql." order by S1.C_USN,S1.C_Roll_Number";
                       $query= $dbh -> prepare($sql);
			$query-> execute();
    			$Fresult=$query->fetchAll(PDO::FETCH_OBJ);
			
			
			
			
			
                      
			
    			
?>

 <div class="col-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><b>Students Not in <?php echo $Sem; ?> Sem Lab Batches  </b></h3>
		
              </div>
              <!-- /.card-header -->
              
         
              <div class="card-body table-responsive p-0" style="height: 400px;font-size:12px;">
                <table class="table table-head-fixed table-hover text-nowrap" id="mt1">
                 
                 
                 <thead style="cursor: pointer;">
                    <tr>
                      <th id="a1" onclick="sortTable('#a1')">Add</th>
                      <th id="a2" onclick="sortTable('#a2')">USN No</th>
                      <th id="a3" onclick="sortTable('#a3')">Roll No</th>
                      <th id="a4" onclick="sortTable('#a4')">Name</th>
                      <th id="a5" onclick="sortTable('#a5')">Quota</th>
                      <th id="a6" onclick="sortTable('#a6')">DOB</th>
                      
                      
                    </tr>
                  </thead>
                  
                  
                  <tbody id="TBODY">
                  
                  	<?php   			
    			foreach($Fresult as $Fres)
			{
			echo "<tr>";
			
			?>
                    
                      	<td><a href="#" onclick="Add_LAB('<?php echo $Fres->Student_ID;?>')"><i class="nav-icon fas fa-plus"></i></a></td>
                      	
                      	<td><?php echo $Fres->C_USN  ; ?></td>
  			<td ><?php echo $Fres->C_Roll_Number  ; ?></td>
  			<td ><?php echo $Fres->Student_Name  ; ?></td>
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
          
          $sql ="Select S1.Student_ID,
			S1.C_USN, 
			S1.C_Roll_Number,
			S1.Student_Name,
			S1.Admission_Quota,
			S1.DOB
			from Student_Info as S1
			Where S1.LBatch='$LBatch' and  S1.Sem='$Sem' and S1.Section='$Section' and S1.Batch='$Batch' "; 
                 
                       if($C_Type=="UG" and $Sem<=2)
                       { 
                           	$sql=$sql." AND S1.Program In( Select D1.Short_Name from Department as D1
                                 where D1.Course_Type='UG' )";
                                 
                       }
                       
                       if($C_Type=="PG" or ($C_Type=="UG" and $Sem>2))
                       { 
                       	$sql =$sql." and S1.Program='$Program'"; 
                       }
                       
                       $query= $dbh -> prepare($sql);
			$query-> execute();
    			$Fresult=$query->fetchAll(PDO::FETCH_OBJ);
    			
    			$count = $query->rowCount();
			
    			
          
          
          
          ?>
          
          
          
          
          <div class="col-6">
            <div class="card card-lime">
              <div class="card-header">
                <h3 class="card-title"><b>Students Added To Batch : <?php echo $Section.$LBatch; ?></b></h3>
                <span style="float:right;margin-bottom:-2px"><?php echo "Total: ".$count;?></span>
		
              </div>
              <!-- /.card-header -->
              
              
              <div class="card-body table-responsive p-0" style="height: 400px;font-size:12px;">
                <table class="table table-head-fixed table-hover text-nowrap" id="mt2">
                  
                  
                  <thead style="cursor: pointer;">
                    <tr>
                      	<th id="b1" onclick="sortTable('#b1')">Remove</th>
                      	<th id="b2" onclick="sortTable('#b2')">USN No</th>
                       <th id="b3" onclick="sortTable('#b3')">Roll No</th>
                       <th id="b4" onclick="sortTable('#b4')">Name</th>
                      	<th id="b4" onclick="sortTable('#b5')">Quota</th>
                       <th id="b6" onclick="sortTable('#b6')">DOB</th>
                    </tr>
                  </thead>
                  
                  
                  <tbody id="TBODY">
                  	
                  	
                  <?php   			
    			foreach($Fresult as $Fres)
			{
			echo "<tr>";
			
			?>
                    
                      	<td><a href="#" onclick="Remove_LAB('<?php echo $Fres->Student_ID;?>')"><i class="nav-icon fas fa-minus"></i></a></td>
                      	
                      	<td><?php echo $Fres->C_USN  ; ?></td>
  			<td ><?php echo $Fres->C_Roll_Number  ; ?></td>
  			<td ><?php echo $Fres->Student_Name  ; ?></td>
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
                      

