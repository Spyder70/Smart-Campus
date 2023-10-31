<?php
require("../../DB/config.php");
$sql="";

if(isset($_POST['Program']))
{
	$Program = $_POST['Program'];
	$Batch = $_POST['Batch'];
	$Sem = $_POST['Sem'];

	$jk=0;
	$Add_Str="";

	if($Program!="ALL")
	{
		if($jk!=0){ $Add_Str=$Add_Str." and "; } $jk=$jk+1;
		$Add_Str=$Add_Str." Department.Course_Type='$Program' ";
	}

	if($Batch!="ALL")
	{
		if($jk!=0){ $Add_Str=$Add_Str." and "; } $jk=$jk+1;
		$Add_Str=$Add_Str." Student_Info.Batch='$Batch' ";
	}

	if($Sem!="ALL")
	{
		if($jk!=0){ $Add_Str=$Add_Str." and "; } $jk=$jk+1;
		$Add_Str=$Add_Str." Student_Info.Sem='$Sem' ";
	}

	if($jk!=0){$Add_Str=" where ".$Add_Str;}


$sql ="SELECT Student_Info.* FROM Department JOIN Student_Info ON Department.Short_Name = Student_Info.Program  ".$Add_Str."
       order by Student_Info.Program,Student_Info.Sem,Student_Info.C_USN ";

    			//$query-> bindParam(':Dept_Name1', $Dept_Name);

}


$query= $dbh -> prepare($sql);
$query-> execute();
$Fresult=$query->fetchAll(PDO::FETCH_OBJ);
?>



<div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><b>Students List </b></h3>



		<button type="button" id="dwn" class="btn btn-primary float-right" style="margin-right: 5px;"
               onClick="tableToExcel('testTable1','Student' ,'StudentsList.xls')">
                    <i class="fas fa-download"></i> Download As Excel
                  </button>


              </div>
              <!-- /.card-header -->



              <?php


              ?>

              <!--   Display  CompanyWise Registraion Count  -->
            <style>
		 #testTable1 td,th{
		  border: 1px solid #ddd;
		 }
		 </style>


              <div class="card-body table-responsive p-0" style="height: 400px;font-size:14px;">
                <table class="table table-head-fixed table-hover text-nowrap" id='testTable1'>
                  <thead style="cursor: pointer;">
                    <tr>
                      <th style="width:5%">Edit</th>
                      <th style="width:5%">USN No</th>
                      <th style="width:5%">Roll No</th>
                      <th style="width:20%">Name</th>
                      <th style="width:5%">Gender</th>
					  <th style="width:5%">DOB</th>
                      <th style="width:5%">Branch</th>
                      <th style="width:3%">Sem</th>
                      <th style="width:5%">Section</th>
                      <th style="width:5%">LBatch</th>

                      <th>Blood</th>
                      <th>Student_Mob</th>
					  <th>Student_Email</th>
					  <th>Aadhaar</th>
					  <th>Religion</th>
					  <th>Caste</th>
					  <th>Category</th>
					  <th>Mother_Tongue</th>
					  <th>State_Domicile</th>

					  <th>C_Address</th>
					  <th>C_Post</th>
					  <th>C_Taluk</th>
					  <th>C_District</th>
					  <th>C_State</th>
					  <th>C_Pin</th>
					  <th>P_Address</th>
					  <th>P_Post</th>
					  <th>P_Taluk</th>
					  <th>P_District</th>
					  <th>P_State</th>
					  <th>P_Pin</th>

					  <th>Father_Name</th>
					  <th>Father_Designation</th>
					  <th>Father_Income</th>
					  <th>Mother_Name</th>
					  <th>Mother_Designation</th>
					  <th>Mother_Income</th>
					  <th>Father_Mob</th>
					  <th>Father_Email</th>
					  <th>Mother_Mob</th>
					  <th>Mother_Email</th>
					  <th>Guardian_Mob</th>
					  <th>Guardian_Email</th>

					  <th>Admission_Type</th>
					  <th>Admission_Quota</th>
					  <th>Allotted_Category</th>
					  <th>NATA_Roll_No</th>

					  <th>NATA_Mark</th>

					  <th>NATA_Fee</th>
					  <th>College_Fee</th>
					  <th>Praaptha_No</th>
					  <th>Batch</th>

					  <th>Q_Course</th>
					  <th>Q_Reg_No</th>
					  <th>College_Name</th>
					  <th>Pass_Year</th>
					  <th>Area_type</th>
					  <th>Board_Name</th>
					  <th>Board_State</th>
					  <th>Leaving_Date</th>
					  <th>Total_Max</th>
					  <th>Total_Obtain</th>
					  <th>Total_Percent</th>
					  <th>P_Max</th>
					  <th>P_Obtain</th>
					  <th>C_Max</th>
					  <th>C_Obtain</th>
					  <th>M_Max</th>
					  <th>M_Obtain</th>
					  <th>E_Max</th>
					  <th>E_Obtain</th>
					  <th>Tot_PCM_Obtain</th>
		 			  <th>PCM_Percent</th>


                    </tr>
                  </thead>
                  <tbody>
<?php
foreach($Fresult as $Fres)
{
	echo "<tr>";

			?>

            <td style="padding:4px;text-align:center;"><a href="../Register/Admission.php?S_ID=<?php echo $Fres->Student_ID  ; ?>" target='_new'><i class="nav-icon fas fa-edit"></i> Edit </a></td>

            <td style="padding:4px;"><?php echo $Fres->C_USN  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->C_Roll_Number  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->Student_Name  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->Gender  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->DOB  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->Program  ; ?></td>
            <td style="padding:3px;"><?php echo $Fres->Sem  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->Section  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->LBatch  ; ?></td>

			<td style="padding:4px;"><?php echo $Fres->Blood  ; ?></td>

			<td style="padding:3px;"><?php echo $Fres->Student_Mob  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->Student_Email  ; ?></td>

			<td style="padding:3px;"><?php echo $Fres->Aadhaar  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->Religion  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Caste  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Category  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Mother_Tongue  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->State_Domicile  ; ?></td>

			<td style="padding:4px;"><?php echo $Fres->C_Address  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->C_Post  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->C_Taluk  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->C_District  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->C_State  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->C_Pin  ; ?></td>

			<td style="padding:4px;"><?php echo $Fres->P_Address  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->P_Post  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->P_Taluk  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->P_District  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->P_State  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->P_Pin  ; ?></td>


			<td style="padding:3px;"><?php echo $Fres->Father_Name  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->Father_Designation  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Father_Income  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Mother_Name  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Mother_Designation  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Mother_Income  ; ?></td>

			<td style="padding:3px;"><?php echo $Fres->Father_Mob  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->Father_Email  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Mother_Mob  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Mother_Email  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Guardian_Mob  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Guardian_Email  ; ?></td>


			<td style="padding:4px;"><?php echo $Fres->Admission_Type  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Admission_Quota  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Allotted_Category  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->CET_COMEDK_Order  ; ?></td>

			<td style="padding:4px;"><?php echo $Fres->CET_COMEDK_Rank  ; ?></td>

			<td style="padding:4px;"><?php echo $Fres->CET_COMEDK_Fee  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->College_Fee  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Praaptha_No  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Batch  ; ?></td>




			<td style="padding:3px;"><?php echo $Fres->Q_Course  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->Q_Reg_No  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->College_Name  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Pass_Year  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Area_type  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Board_Name  ; ?></td>
			<td style="padding:3px;"><?php echo $Fres->Board_State  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->Leaving_Date  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Total_Max  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Total_Obtain  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->Total_Percent  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->P_Max  ; ?></td>
			<td style="padding:3px;"><?php echo $Fres->P_Obtain  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->C_Max  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->C_Obtain  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->M_Max  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->M_Obtain  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->E_Max  ; ?></td>
			<td style="padding:3px;"><?php echo $Fres->E_Obtain  ; ?></td>
  			<td style="padding:4px;"><?php echo $Fres->Tot_PCM_Obtain  ; ?></td>
			<td style="padding:4px;"><?php echo $Fres->PCM_Percent  ; ?></td>









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
        </div>
        <!-- /.row -->

         <!-- /.row -->
</div><!-- /.container-fluid -->

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
