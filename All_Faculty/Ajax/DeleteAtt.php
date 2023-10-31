<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../../DB/config.php");
require("../../Authenticate/Faculty.php");


//$Course_Registration_Head="menu-open";
//$Add_Subjects="active";

$PageName="Delete Students Attendance";
$Entry_Head="menu-open";
$DeleteAttendance="active";
$Faculty_ID=$_SESSION['F_ID'];


$C_msg="";



$C_Date=$_POST['C_Date'];
$FS_ID=$_POST['FS_ID'];
$Exam_Type=$_POST['Exam_Type'];
//$Range=$_POST['Range'];

$sqla ="SELECT * FROM Faculty_Subjects where FS_ID='$FS_ID' ";
$querya= $dbh -> prepare($sqla);
$querya-> execute();
$rowa = $querya->fetch();
$Sub_ID=$rowa['Sub_ID'];
$Section=$rowa['Section'];
$L_Batch=$rowa['LBatch'];
$Finalized=$rowa['Finalized'];

//check For Regular+Core+Lab or not
$sqlb ="SELECT * FROM Course_Subjects where Sub_ID='$Sub_ID' ";
$queryb= $dbh -> prepare($sqlb);
$queryb-> execute();
$rowb = $queryb->fetch();
$Sub_Type=$rowb['Subject_Type'];
$Th_Pract=$rowb['Th_Pract'];
$Sub_Name=$rowb['Subject_Name'];
$Sub_Code=$rowb['Subject_Code'];
$Sub_Branch=$rowb['Branch'];
$Sub_Sem=$rowb['Sem'];

$sql = "select Att_Date,Period,LBatch,Handle_ID from Subject_Handled where FS_ID='$FS_ID' order by Att_Date asc";
$FileName="AttendanceRegister_".$Sub_Code;
?>



 <div class="row">
  <?php if($Finalized==1)
	  {
	   echo "<h2 style='margin-left:40px;color:green'> Attendance Already Finalized..!</h2>";
	  }
	  else
	  {
	  ?>
          <div class="col-12">
            <div class="card card-primary" >
              <div class="card-header" style="background:orange">
              <span style="color:black;font-weight:bold;"><?php echo $Sub_Code." - ".$Sub_Name; ?></span>


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
                    <tr align="center">
                     <th style="width:5%;">Sl.No.</th>
                     <th style="width:10%;">Date (YYYY-MM-DD)</th>
                     <th style="width:12%;">Period</th>

                     <th>Delete</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php
                      		$slno=0;
                  	      	$Tot_class;
                  		$sel2 = $dbh->prepare($sql);
    				$sel2->execute();
    				$results=$sel2->fetchAll(PDO::FETCH_OBJ);
                  		foreach($results as $res)
				{
				$slno=$slno+1;
				//$Tot_class.$result->LBatch=$Tot_class.$result->LBatch+1;
			        ?>
                                <tr align="center">
                                <td><?php echo $slno; ?>
                                 <td><?php echo $res->Att_Date."</td><td>".$res->Period; ?></td>
                              
                                 <td><form <?php echo "name='myform' id='".$res->Handle_ID."'"; ?>
                                      method="post" onsubmit="FadeAll()" action="DeleteAttendance.php">
                                      <input type="hidden" name="delid" id="delid"
                                      <?php echo "value='".$res->Handle_ID."'"; ?> />
                                 <input type='Submit' value="DELETE" class="btn btn-block btn-success btn-sm" style="width:30%;font-weight:bold" >
                                     </form>
                                 </td>
                                 </tr>
                         <?php }?>






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

<?php } ?>
