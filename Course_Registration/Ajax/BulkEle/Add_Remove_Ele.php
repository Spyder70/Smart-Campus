<?php
require("../../../DB/config.php");
$sql="";
if(isset($_POST['Sub_code']))
{
	$C_Date = $_POST['C_Date'];
	$Exam_Type = $_POST['Exam_Type'];
	$Branch = $_POST['Branch'];
	$Sem = $_POST['Sem'];
	$Sub_type = $_POST['Sub_type'];
	
	
	$_SESSION['C_Date']= $C_Date ;
	$_SESSION['Exam_Type']= $Exam_Type ;
	$_SESSION['Branch']= $Branch ;
	$_SESSION['Sem']= $Sem;
	$_SESSION['Sub_type']= $Sub_type;
}		
/*if($Role=="Add")
{
			// check whether row exist with that sem
			$Add_sql="Update Student_Info set Section='$Section' where Student_ID='$Student_ID'";
			$Add_query= $dbh -> prepare($Add_sql);
			$Add_query-> execute();					
}
*/
	$C_Date =$_SESSION['C_Date'];
	$Exam_Type =$_SESSION['Exam_Type'];
	$Branch =$_SESSION['Branch'];
	$Sem =$_SESSION['Sem'];
	$Sub_type =$_SESSION['Sub_type'];
	
	$Sub_ID=$_POST['Sub_code'];
	
		
	if( ($Branch=='PHY' or $Branch=='CHE') and ($Sem<=2))
	{
	$str_lst=" and S1.Cycle='$Branch' ";
	}
	else
	{
	$str_lst=" and S1.Program='$Branch' ";
	}
	 
	 
	$sql ="Select S1.Student_ID,S1.C_USN,S1.C_Roll_Number,S1.Student_Name
		from Student_Info as S1 Where S1.Sem='$Sem' ";
                       
        $sql= $sql.$str_lst;
     
     	$query= $dbh -> prepare($sql);
	$query-> execute();
    	$Fresult=$query->fetchAll(PDO::FETCH_OBJ);
	
	
	
	
	$TopCh=0;
	if($_POST['Fetch']=="ApplyAll")
	{
	 $TopCh=10;
	 
	 foreach($Fresult as $Fres)
	 {
	  $STD_ID=$Fres->Student_ID;
	
	   $sqlE="Select Student_ID from Course_Registration where Course_Date='$C_Date' and Sub_ID='$Sub_ID' and Student_ID='$STD_ID'";
	   $queryE = $dbh->prepare($sqlE);	
	   $queryE->execute();
	   $ENO = $queryE->rowCount();
	   if($ENO==0)
	   {
	   $sqlA ="insert into Course_Registration (Course_Date,Sub_ID,Student_ID) values('$C_Date','$Sub_ID','$STD_ID')";
	   $queryA= $dbh -> prepare($sqlA);
	   $queryA-> execute();
	   }
	  }
	}
	else if($_POST['Fetch']=="RemoveAll")
	{
	 $TopCh=-10;
	 
	 foreach($Fresult as $Fres)
	 {
	  $STD_ID=$Fres->Student_ID;
	   
	   $sqlA ="delete from Course_Registration where  Student_ID='$STD_ID' and Course_Date='$C_Date' and Sub_ID='$Sub_ID'";
	   $queryA= $dbh -> prepare($sqlA);
	   $queryA-> execute();
	 }
	}
	
	
	
	if($_POST['Fetch']=="Add_Ele")
	{
	$TopCh=1;
	$stdid=$_POST['stdid'];
	
	$sqlE="Select Student_ID from Course_Registration where Course_Date='$C_Date' and Sub_ID='$Sub_ID' and Student_ID='$stdid'";
	$queryE = $dbh->prepare($sqlE);	
	$queryE->execute();
	$ENO = $queryE->rowCount();
	if($ENO==0)
	{
	   $sqlA ="insert into Course_Registration (Course_Date,Sub_ID,Student_ID) values('$C_Date','$Sub_ID','$stdid')";
	   $queryA= $dbh -> prepare($sqlA);
	   $queryA-> execute();
	}
	exit;
	}
	if($_POST['Fetch']=="Remove_Ele")
	{
	$TopCh=-1;
	$stdid=$_POST['stdid'];
	$sqlA ="delete from Course_Registration where  Student_ID='$stdid' and Sub_ID='$Sub_ID' and Course_Date='$C_Date'";
	$queryA= $dbh -> prepare($sqlA);
	$queryA-> execute();
	 
	exit;
	}
	//echo "<center><h1> Top= $TopCh;</h1></center>";
	
	
	
	
	
	
	
	
	
	
		
	
	
    	
   					
?>


 <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><b>Students List To Above Elective Subject </b></h3>
		
              </div>
              <!-- /.card-header -->
              
         
              <div class="card-body table-responsive p-0" style="height: 400px;font-size:12px;">
                <table class="table table-head-fixed table-hover text-nowrap" id="mt1">
                 
                 
                 <thead style="cursor: pointer;">
                    <tr>
                      <th id="a1" onclick="sortTable('#a1')" valign="left">
                      <input type="checkbox"  name="CheckAll" id="CheckAll"  onclick="ApplyAllEle()"  
                      <?php if($TopCh==10){echo "checked";} ?>/> All</th>
                      <th id="a2" onclick="sortTable('#a2')">USN No</th>
                      <th id="a3" onclick="sortTable('#a3')">Roll No</th>
                      <th id="a4" onclick="sortTable('#a4')">Name</th>
                    </tr>
                  </thead>
                  
                  
                  <tbody id="TBODY">
                  
                  	<?php   			
    			foreach($Fresult as $Fres)
			{
			echo "<tr>";
			
			$STD_ID=$Fres->Student_ID;
	 		$sid_sql="Select count(*) as STot from Course_Registration where 
	 		Course_Date='$C_Date' and Student_ID='$STD_ID' and Sub_ID ='$Sub_ID'";
	 		$sid_query= $dbh -> prepare($sid_sql);
	 		$sid_query-> execute();
	 		$ct = $sid_query->fetch();
	 		$Found=$ct['STot'];
	 		
	 		if($Found == 1){
			?>
                       <td><input type="checkbox" id="<?php echo $STD_ID;?>" value="<?php echo $STD_ID;?>" onclick="AdRm_Ele('<?php echo $STD_ID;?>')" checked /> </td>
                       <?php } else { ?>
                       <td><input type="checkbox" id="<?php echo $STD_ID;?>" value="<?php echo $STD_ID;?>"  onclick="AdRm_Ele('<?php echo $STD_ID;?>')"  /></td>
                        <?php } ?>
                     
                      	
                      	<td><?php echo $Fres->C_USN  ; ?></td>
  			<td><?php echo $Fres->C_Roll_Number  ; ?></td>
  			<td><?php echo $Fres->Student_Name  ; ?></td>
  			
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
 

?>  

