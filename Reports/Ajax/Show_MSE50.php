<?php
session_start();
require("../../DB/config.php");
$Faculty_ID=$_SESSION['F_ID'];
if(isset($_POST['Fetch']))
{
	
	if($_POST['Fetch']=="DispAll")
	{
	$C_Date = $_POST['C_Date'];
	$Sem = $_POST['Sem'];
	$Branch = $_POST['Branch'];
	$MSE = $_POST['MSE'];

	
	$FileName="MSE$MSE Below 50 -$Branch -$Sem";	
	/*
	SELECT * FROM `Student_CIA` WHERE ((Mark*100)/`Max_Mark`)<50 and Occasion='TASK_2'
	
	
	SELECT Student_Info.Student_ID,Student_Info.Student_Name,
Student_Info.C_Roll_Number,
Student_Info.C_USN,Student_Info.Sem, 
Course_Subjects.Sub_ID, 
Course_Subjects.Subject_Code,
Course_Subjects.Subject_Name, 
Student_CIA.Mark,
Student_CIA.Attendance   FROM Student_CIA 
Left JOIN Student_Info ON Student_CIA.Student_ID= Student_Info.Student_ID 
Left JOIN Course_Subjects ON Student_CIA.Sub_ID =Course_Subjects.Sub_ID 
WHERE ((Student_CIA.Mark*100)/Student_CIA.Max_Mark)<50 and Student_CIA.Occasion='MSE1'
	
	
	
	*/
		
	$sid_sql="SELECT Student_Info.Student_ID,Student_Info.Student_Name, Student_Info.C_Roll_Number,
	 Student_Info.C_USN,Student_Info.Sem, Course_Subjects.Sub_ID, Course_Subjects.Subject_Code,
	 Course_Subjects.Subject_Name, Student_CIA.Mark, Student_CIA.Attendance
	 FROM Student_CIA 
	 Left JOIN Student_Info ON Student_CIA.Student_ID= Student_Info.Student_ID 
	 Left JOIN Course_Subjects ON Student_CIA.Sub_ID =Course_Subjects.Sub_ID 
	 WHERE ((Student_CIA.Mark*100)/Student_CIA.Max_Mark)<50 and
	 Student_CIA.Occasion='$MSE' and Student_Info.Sem='$Sem' and Student_CIA.Course_Date='$C_Date'  ";
	

	if( ($Branch=='PHY' or $Branch=='CHE') and ($Sem<=2))
	{
	$sid_sql=$sid_sql." and Student_Info.Cycle='$Branch' ";
	}
	else
	{
	$sid_sql=$sid_sql." and Student_Info.Program='$Branch' ";
	}
	 
	 
	$sid_sql=$sid_sql."  order by Course_Subjects.Subject_Code,Student_Info.C_USN,Student_Info.C_Roll_Number ";
        
     	$query= $dbh -> prepare($sid_sql);
	$query-> execute();
    	$Fresult=$query->fetchAll(PDO::FETCH_OBJ);
    	
    	?>
    	
    	
    	  <div class="col-12">
            <div class="card card-primary" >
              <div class="card-header" style="background:orange">
              <span style="color:black;font-weight:bold;">Students List of Below 50%</span>
              
              
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
              
             
              
              <!--   Display  CompanyWise Registraion Count  -->
            
              
              
              <div class="card-body table-responsive p-0" style="height: 400px;" >
		
		 <!-- 4 -->
            
                <table class="table table-head-fixed table-hover text-nowrap" id="testTable1">
                
                  <thead>
                      <tr>
                      <th id="a1" onclick="sortTable('#a1')">Sl.No</th>
                      <th id="a2" onclick="sortTable('#a2')">USN/Roll No</th>
                      <th id="a3" onclick="sortTable('#a3')">Name</th>
                      <th id="a4" onclick="sortTable('#a4')">Course Code</th>
                      <th id="a5" onclick="sortTable('#a5')">Course Name</th>
                      <th id="a6" onclick="sortTable('#a6')">Marks Obtained</th>
                    </tr>
                  </thead>
                  
                  
                  <tbody id="TBODY">
                  
                  	<?php 
                  	$i=1;  			
    			foreach($Fresult as $Fres)
			{
			$STD_ID=$Fres->Student_ID;
			$STD_Roll=$Fres->C_Roll_Number;
			$STD_USN=$Fres->C_USN;
			$STD_Name=$Fres->Student_Name;
			$STD_SubCode=$Fres->Subject_Code;
			$STD_SubName=$Fres->Subject_Name;
			$STD_Att=trim($Fres->Attendance);
			$STD_Mark=$Fres->Mark;
	 		?>
	 		
			<tr>
			<td><?php echo $i; $i=$i+1; ?></td>
                      	<td><?php if($STD_USN!=""){echo $STD_USN; } else { echo $STD_Roll;} ?></td>
  			<td><?php echo $STD_Name;  ?></td>
  			<td><?php echo $STD_SubCode;  ?></td>
  			<td><?php echo $STD_SubName;  ?></td>
  		<?php	if($STD_Att=='A')  { ?>
  			<td><span style='color:red'>ABSENT</span></td>
  		<?php   } else { ?>
  			<td><?php echo $STD_Mark;  ?></td>
  			<?php }  ?>
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
		
	<?php
	}
	
	
}
//$query->close;
//$dbh=null;
?>

