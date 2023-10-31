<?php
session_start();
require("../../DB/config.php");
$Faculty_ID=$_SESSION['F_ID'];
if(isset($_POST['Fetch']))
{
	$tak=$_POST['Fetch'];
	$F_Dept=$_SESSION['F_Dept'];

	if(isset($_POST['C_Date']))
	{
	$C_Date = $_POST['C_Date'];

	$FileName="Facultuy_Subjects-$C_Date";
	
        if((strpos($_SESSION['F_Desig'], "COORDINATOR") == true))
  	{
    	$sid_sql="Select Faculty_Subjects.FS_ID,Faculty_Subjects.Faculty_ID,Faculty_Subjects.Sub_ID,Faculty_Subjects.Section,
    	Faculty_Subjects.LBatch,Faculty_Subjects.Finalized,Faculty.Name,Course_Subjects.Subject_Code,Course_Subjects.Subject_Name,
    	Course_Subjects.Sem,Course_Subjects.Branch from Faculty_Subjects 
    	Left JOIN Faculty ON Faculty_Subjects.Faculty_ID= Faculty.Faculty_ID 
    	Left JOIN Course_Subjects ON Faculty_Subjects.Sub_ID= Course_Subjects.Sub_ID 
    	where Faculty_Subjects.Course_Date='$C_Date' and ( Course_Subjects.Branch='PHY' or Course_Subjects.Branch='CHE')
    	ORDER BY Faculty.Name,Course_Subjects.Subject_Code ASC";
  	}
	else
  	{
	$sid_sql="Select Faculty_Subjects.FS_ID,Faculty_Subjects.Faculty_ID,Faculty_Subjects.Sub_ID,Faculty_Subjects.Section,
	Faculty_Subjects.LBatch,Faculty_Subjects.Finalized,Faculty.Name,Course_Subjects.Subject_Code,Course_Subjects.Subject_Name,
	Course_Subjects.Sem,Course_Subjects.Branch from Faculty_Subjects 
	Left JOIN Faculty ON Faculty_Subjects.Faculty_ID= Faculty.Faculty_ID 
	Left JOIN Course_Subjects ON Faculty_Subjects.Sub_ID= Course_Subjects.Sub_ID 
	where Faculty_Subjects.Course_Date='$C_Date' and Faculty.Department='$F_Dept'
	ORDER BY Faculty.Name,Course_Subjects.Subject_Code ASC";
	}

     	$query= $dbh -> prepare($sid_sql);
	$query-> execute();
    	$Fresult=$query->fetchAll(PDO::FETCH_OBJ);
   	?>

    	  <div class="col-12">
            <div class="card card-primary" >
              <div class="card-header" style="background:orange">
              <span style="color:black;font-weight:bold;">Subjects Handled By Faculties : <?php echo $C_Date; ?></span>
              
              
               <button type="button" id="dwn" class="btn btn-primary float-right" style="margin-right: 5px;" 
               onClick="tableToExcel('testTable1','Student' ,'<?php echo $FileName.".xls"; ?>')">
                    <i class="fas fa-download"></i> Download As Excel
                  </button>
              </div>
              <!-- /.card-header -->
              
               <style>
		 #testTable1 td,th{
		  border: 1px solid #ddd;
		 }
		 </style>
              
             
              
              <!--   Fetch and display  -->
            
              
              
              <div class="card-body table-responsive p-0" style="height: 400px;" >
		
		 <!-- 4 -->
            
                <table class="table table-head-fixed table-hover text-nowrap" id="testTable1">
                
                  <thead>
                      <tr>
                      <th id="a1" onclick="sortTable('#a1')">Sl.No</th>
                      <th id="a2" onclick="sortTable('#a2')">Name</th>
                      <th id="a3" onclick="sortTable('#a3')">Dept</th>
                      <th id="a4" onclick="sortTable('#a4')">Sem</th>
                      <th id="a5" onclick="sortTable('#a5')">Section</th>
                      <th id="a6" onclick="sortTable('#a6')">L_Batch</th>
                      <th id="a7" onclick="sortTable('#a7')">Sub_Code</th>
                      <th id="a8" onclick="sortTable('#a8')">Sub_Name</th>
                      <th id="a9" onclick="sortTable('#a9')">Class_Held</th>
                      <th id="a10" onclick="sortTable('#a10')">Last_Entry</th>
                      <th id="a11" onclick="sortTable('#a11')">Task-1</th>
                      <th id="a12" onclick="sortTable('#a12')">Tast-2</th>
                      <th id="a13" onclick="sortTable('#a13')">MSE-1</th>
                      <th id="a14" onclick="sortTable('#a14')">MSE-2</th>
                      
                    </tr>
                  </thead>
                  
                  
                  <tbody id="TBODY">
                  
                  	<?php 
                  	$i=1;  
                  
				
    			foreach($Fresult as $Fres)
			{
			 $Fac_sub=$Fres->FS_ID;
			 $TotCls=0;
			 $sql3="select count(*) as Totc, Max(Entry_On) as LSTE from Subject_Handled where FS_ID='$Fac_sub'";
			 $queryIn= $dbh -> prepare($sql3);
    	  		 $queryIn-> execute();
    	  		 $ct = $queryIn->fetch();
	 		 $TotCls=$ct['Totc'];   	$LastEntry=$ct['LSTE'];  
    	  		
    	  		 
    	  		  
    	  		
  $sqlf="SELECT Occasion,Entry_On from CIA_Entered where FS_ID='$Fac_sub' " ;     
  $queryf= $dbh -> prepare($sqlf);
  $queryf-> execute();
  $resultsf=$queryf->fetchAll(PDO::FETCH_OBJ);
  $tk_1=$tk_2=$ms_1=$ms_2="<span style='color:red'>No</span>";
  foreach($resultsf as $rowd)
  {     
   $exmt=$rowd->Occasion;
   $N_LNT=$rowd->Entry_On;
   if($N_LNT>$LastEntry){ $LastEntry=$N_LNT; }
   
   if($exmt=='TASK_1'){$tk_1="Yes";}	if($exmt=='TASK_2'){$tk_2="Yes";}
   if($exmt=='MSE_1'){$ms_1="Yes";}	if($exmt=='MSE_2'){$ms_2="Yes";}
   }
	 		
	 		
			
			
			?>
			<tr>
			<td><?php echo $i; $i=$i+1; ?></td>
  			<td><?php echo $Fres->Name  ; ?></td>
  			<td><?php echo $Fres->Branch  ; ?></td>
  			<td><?php echo $Fres->Sem  ; ?></td>
  			<td><?php echo $Fres->Section  ; ?></td>
  			<td><?php if($Fres->LBatch>=1){ echo $Fres->Section.$Fres->LBatch; } ?></td>
  			<td><?php echo $Fres->Subject_Code; ?></td> 
  			<td><?php echo $Fres->Subject_Name; ?></td>
  			
  			
  			<td><?php echo $TotCls ; ?></td>
  			<td><?php echo $LastEntry ; ?></td>
  			<td><?php echo $tk_1 ; ?></td>
  			<td><?php echo $tk_2 ; ?></td>
  			<td><?php echo $ms_1 ; ?></td>
  			<td><?php echo $ms_2 ; ?></td>
  			
  			</tr>
                      	<?php
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
}
//$query->close;
//$dbh=null;
?>
<script>

 $('th').click(function(){
    var table = $(this).parents('table').eq(0)
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
    this.asc = !this.asc
    if (!this.asc){rows = rows.reverse()}
    for (var i = 0; i < rows.length; i++){table.append(rows[i])}
})
function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index), valB = getCellValue(b, index)
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
    }
}
function getCellValue(row, index){ return $(row).children('td').eq(index).text() }

</script>
