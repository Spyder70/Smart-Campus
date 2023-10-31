<?php
session_start();
require("../../DB/config.php");
$Faculty_ID=$_SESSION['F_ID'];
if(isset($_POST['Fetch']))
{
	$tak=$_POST['Fetch'];
	if($tak=="Finalize")
	{
	if($FID!=""){
	$FID=$_POST['FsId'];
	$sup="Update Faculty_Subjects Set Finalized='1' where FS_ID='$FID'";
	$qsup= $dbh -> prepare($sup);
	$qsup-> execute();}
	}
	else if($tak=="Editable")
	{
	$FID=$_POST['FsId'];
	if($FID!=""){
	$sup="Update Faculty_Subjects Set Finalized='0' where FS_ID='$FID'";
	$qsup= $dbh -> prepare($sup);
	$qsup-> execute();}
	}
	else if($tak=="Deallocate")
	{
	$FID=$_POST['FsId'];
	
	if($FID!=""){
	$sup="delete from Faculty_Subjects where FS_ID='$FID'";
	$qsup= $dbh -> prepare($sup);
	$qsup-> execute();
	
	$sup="delete from Subject_Handled where FS_ID='$FID'";
	$qsup= $dbh -> prepare($sup);
	$qsup-> execute(); 
	
	$sup="delete from Student_Attendance where FS_ID='$FID'";
	$qsup= $dbh -> prepare($sup);
	$qsup-> execute();
	
	$sup="delete from Total_Attendance where FS_ID='$FID'";
	$qsup= $dbh -> prepare($sup);
	$qsup-> execute();
	
	$sup="delete from CIA_Entered where FS_ID='$FID'";
	$qsup= $dbh -> prepare($sup);
	$qsup-> execute();
	
	$sup="delete from Student_CIA where FS_ID='$FID'";
	$qsup= $dbh -> prepare($sup);
	$qsup-> execute();}
	
	}




	if(isset($_POST['C_Date']))
	{
	$C_Date = $_POST['C_Date'];

	$FileName="Facultuy_Subjects-$C_Date";
		
	$sid_sql="Select Faculty_Subjects.FS_ID,Faculty_Subjects.Faculty_ID,Faculty_Subjects.Sub_ID,Faculty_Subjects.Section,
	Faculty_Subjects.LBatch,Faculty_Subjects.Finalized,Faculty.Name,Course_Subjects.Subject_Code,Course_Subjects.Subject_Name,
	Course_Subjects.Sem,Course_Subjects.Branch from Faculty_Subjects 
	Left JOIN Faculty ON Faculty_Subjects.Faculty_ID= Faculty.Faculty_ID 
	Left JOIN Course_Subjects ON Faculty_Subjects.Sub_ID= Course_Subjects.Sub_ID 
	where Faculty_Subjects.Course_Date='$C_Date' ORDER BY Course_Subjects.Branch,Course_Subjects.Sem,Faculty_Subjects.Section,Course_Subjects.Subject_Code   ASC";
	
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
                      <th id="a2" onclick="sortTable('#a2')">Emp_ID</th>
                      <th id="a3" onclick="sortTable('#a3')">Name</th>
                      <th id="a4" onclick="sortTable('#a4')">Subject</th>
                      <th id="a5" onclick="sortTable('#a5')">Branch</th>
                      <th id="a6" onclick="sortTable('#a6')">Sem</th>
                      <th id="a7" onclick="sortTable('#a7')">Section</th>
                      <th id="a8" onclick="sortTable('#a8')">Batch</th>
                      <th id="a9" onclick="sortTable('#a9')">Cls</th>
                      <th id="a12" onclick="sortTable('#a12')">Entered</th>
                      <th id="a10" onclick="sortTable('#a10')">Status</th>
                      <th colspan="2" id="a11" onclick="sortTable('#a11')"><center>Action</th>
                      
                    </tr>
                  </thead>
                  
                  
                  <tbody id="TBODY">
                  
                  	<?php 
                  	$i=1;  
                  
				
    			foreach($Fresult as $Fres)
			{
			 $Fac_sub=$Fres->FS_ID;
			 $TotCls=0;
			 $sql3="select Handle_ID from Subject_Handled where FS_ID='$Fac_sub'";
			 $queryIn= $dbh -> prepare($sql3);
    	  		 $queryIn-> execute();
    	  		 $TotCls = $queryIn->rowCount();
			
			 $sql8="SELECT Occasion from CIA_Entered where FS_ID='$Fac_sub' ";
			 $exqry= $dbh -> prepare($sql8);
    	  		 $exqry-> execute();
    			 $Exres=$exqry->fetchAll(PDO::FETCH_OBJ);
    			 $TMEntry="";
    			 foreach($Exres as $Ers)
			 { 
			 $focsb=$Ers->Occasion;
			 $TMEntry=$TMEntry.$focsb." , ";
			 }
			 $TMEntry = rtrim($TMEntry," , ");
			?>
			<tr>
			<td><?php echo $i; $i=$i+1; ?></td>
                      	<td><?php echo $Fres->Faculty_ID  ; ?></td>
  			<td><?php echo $Fres->Name  ; ?></td>
  			<td><?php echo $Fres->Subject_Code."-".$Fres->Subject_Name  ; ?></td>
  			<td><?php echo $Fres->Branch  ; ?></td>
  			<td><?php echo $Fres->Sem  ; ?></td>
  			<td><?php echo $Fres->Section  ; ?></td>
  			<td><?php if($Fres->LBatch>=1){ echo $Fres->Section.$Fres->LBatch; } ?></td>
  			<td><?php echo $TotCls ; ?></td>
  			<td><?php echo $TMEntry; ?></td>
  			<td><?php if($Fres->Finalized==1){
  			          echo "<span style='color:green;font-weight:bold;'>Finalized</span>"; }
  			          else { echo "Nil"; }	
  			?></td>
  			<td><?php  if($Fres->Finalized==0)
  				   { 
  				   ?>
  	<button type="button" class="btn btn-block btn-outline-danger" 
  	id="<?php echo $Fres->FS_ID;?>"  onclick="MakeFz('<?php echo $Fres->FS_ID;?>')"> Force Finalize</button>
  				   <?php
  				   }
  				   else
  				   {   
  				   ?>
  	 <button type="button" class="btn btn-block btn-outline-info"  
  	 id="<?php echo $Fres->FS_ID;?>" onclick="MakeEd('<?php echo $Fres->FS_ID;?>')">Enable to Edit</button>
  	  			   <?php
  				   }
  			?></td>
  			
  			<td> 
  	 <button type="button" class="btn btn-block btn-outline-dark"  
  	 id="<?php echo $Fres->FS_ID."D";?>" onclick="Deallocate('<?php echo $Fres->FS_ID;?>')">Deallocate</button>
  	  	       </td>
  			
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
