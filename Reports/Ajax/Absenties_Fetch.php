<?php
session_start();
require("../../DB/config.php");
$Faculty_ID=$_SESSION['F_ID'];
if(isset($_POST['Fetch']))
{
	
	$Sub_Name="";	
	if($_POST['Fetch']=="Exam_Type")
	{
		$C_Date = $_POST['C_Date'];
          	$sql ="SELECT Exam_Type FROM Course_Subjects where Course_Date='$C_Date' group by Exam_Type order by Exam_Type asc";
    		$query= $dbh -> prepare($sql);
    		
    		$query-> execute();
    		$results2=$query->fetchAll(PDO::FETCH_OBJ);
    		?>
    		<option value="" selected="selected"></option>
    		<?php
    		foreach($results2 as $result2)
    		{  ?>
    		<option value="<?php echo $result2->Exam_Type;?>"> <?php echo $result2->Exam_Type;?> </option>
    		<?php 
    		} 
    		
    	}
	
	
	
	if($_POST['Fetch']=="ShowList")
	{
	
	  $C_Date = $_POST['C_Date'];
	  $Exam_Type = $_POST['Exam_Type'];
	  $B_Type = $_POST['B_Type'];
	  $Program = $_POST['Program'];
	  $Cycle = $_POST['Cycle'];
	  $Semester = $_POST['Semester'];
	  $Section = $_POST['Section'];
	  $Start_Date = $_POST['Fr_Date'];
	  $End_Date = $_POST['To_Date'];
	  
$FileName="Absenties_".$Start_Date."_".$End_Date;

$mid_q="";

if($B_Type=="Cycle")
{
	if($Cycle!="All")
	{
	$mid_q=$mid_q." and  SI.Cycle='$Cycle' ";
	}
	else
	{
	$mid_q=$mid_q." and  (SI.Cycle='PHY' or SI.Cycle='CHE') ";
	}
}
else if($B_Type=="Program")
{
	if($Program!="All")
	{
	$mid_q=$mid_q." and  SI.Program='$Program' ";
	}
}
if($Semester!="All")
{
	$mid_q=$mid_q." and  SI.Sem='$Semester' ";
}

if($Section!="All")
{
	$mid_q=$mid_q." and  SI.Section='$Section' ";
}



$Ab_q="Select SI.Student_ID,SI.C_USN,SI.C_Roll_Number,SI.Student_Name,
       SI.Father_Mob,SI.Father_Email,SI.Mother_Mob,SI.Mother_Email,
       SI.Guardian_Mob,SI.Guardian_Email,CS.Subject_Code,SA.Att_Date from 
       Student_Info as SI,Course_Subjects as CS,Student_Attendance as SA
       where SA.Student_ID=SI.Student_ID and SA.Sub_ID=CS.Sub_ID 
       and (SA.Att_Date  Between '$Start_Date' and '$End_Date') and SA.Course_Date='$C_Date'";
       
$Ab_q=$Ab_q.$mid_q;
       
       
$Ab_q=$Ab_q." order by  SA.Att_Date,SI.C_USN,SI.C_Roll_Number,CS.Sub_ID  ";
//echo $Ab_q;
?>



  <div class="row">
          <div class="col-12">
            <div class="card card-primary" >
              <div class="card-header" style="background:orange">
              <span style="color:black;font-weight:bold;">Absenties List From <?php echo $Start_Date." To ".$End_Date; ?></span>
              
              
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
                    <tr style="cursor:pointer;text-align:center;">
                    
                     <th>USN/Roll No</th>
                     <th>Name</th>
                     <th>Parent Phone</th>
                     <th>Parent Email</th>
                     <th>SubjectCode</th>
                     <th>Absent On</th>
                    </tr>
                  </thead>
                  <tbody>
               <?php
      		
    	  	
    	  	
		$queryIn= $dbh -> prepare($Ab_q);
    	  	$queryIn-> execute();
    	  	$countIn = $queryIn->rowCount();
    	  	$rowsAll=$queryIn->fetchAll(PDO::FETCH_OBJ);
    	  	
    	  	$j=$i=0;
    	  	$Allsub="";$Sub_code="";$Std_id="";$Std_USN="";$Std_Name="";$P_M="";$P_E="";$Att_D="";
    		foreach($rowsAll as $resIn)
    		{
    		     
    		    if($j==0)
    		    {
    			
    		    }
    		    else
    		    {
    		       if($resIn->Student_ID==$Std_id and $resIn->Att_Date==$Att_D and  $resIn->Subject_Code!=$Sub_code)
    		       {
		       $Allsub=$Allsub." ".$resIn->Subject_Code;
    		       }
    		       else if($resIn->Student_ID!=$Std_id or $resIn->Att_Date!=$Att_D)
    		       {
    		       echo "<tr style='text-align:center;'>"; 
    		       echo "<td style='padding:4px;'>". $Std_USN ."</td>
    		             <td style='padding:4px;text-align:left;'>". $Std_Name ."</td>
    		             <td style='padding:4px;'>". $P_M ."</td>
    		             <td style='padding:4px;'>". $P_E ."</td>
    		             <td style='padding:4px;text-align:left;'>". $Allsub ."</td>
    		             <td style='padding:4px;'>". $Att_D ."</td>";
    		       echo "</tr>";  
    		             $j=0;
    		       }
    		    }
    		    if($j==0)
    		    {
    			$Std_id=$resIn->Student_ID;
    			$Std_USN=$resIn->C_USN;
    			if($Std_USN=="")
    			{
    			$Std_USN=$resIn->C_Roll_Number;
    			}
    			$Std_Name=$resIn->Student_Name;
    			$P_M=$resIn->Father_Mob;
    			$P_E=$resIn->Father_Email;
    			if($P_M==""){$P_M=$resIn->Mother_Mob;if($P_M==""){$P_M=$resIn->Guardian_Mob;}}
    			if($P_E==""){$P_E=$resIn->Mother_Email;if($P_E==""){$P_E=$resIn->Guardian_Email;}}
    			$Att_D=$resIn->Att_Date;
    			$Sub_code=$resIn->Subject_Code;
    			$Allsub=$Sub_code;
    			$j=$j+1;
    		    }
    			
			
    		  }//FOR ENDS 
    		  //if it completes the rows and no rows to check comes out and print the last one
    		  echo "<tr style='text-align:center;'>"; 
    		  echo "<td style='padding:4px;'>". $Std_USN ."</td>
    		             <td style='padding:4px;text-align:left;'>". $Std_Name ."</td>
    		             <td style='padding:4px;'>". $P_M ."</td>
    		             <td style='padding:4px;'>". $P_E ."</td>
    		             <td style='padding:4px;text-align:left;'>". $Allsub ."</td>
    		             <td style='padding:4px;'>". $Att_D ."</td>";
    		  echo "</tr>";  
    		 
    		
    		?>
    		
  			
                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              
                </div>
              
              
              
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
       
        <!-- /.row -->
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

<?php } } ?>
