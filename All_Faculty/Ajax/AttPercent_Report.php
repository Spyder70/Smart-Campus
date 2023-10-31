<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../../DB/config.php");
require("../../Authenticate/Faculty.php");


//$Course_Registration_Head="menu-open";
//$Add_Subjects="active";

$PageName="Students Attendance Register ";
$Report_Head="menu-open";
$Attendance_Register="active";
$Faculty_ID=$_SESSION['F_ID'];


$C_msg="";



$C_Date=$_POST['C_Date'];
$FS_ID=$_POST['FS_ID'];
$Exam_Type=$_POST['Exam_Type'];
$Range=$_POST['Range'];

$sqla ="SELECT * FROM Faculty_Subjects where FS_ID='$FS_ID' ";
$querya= $dbh -> prepare($sqla);
$querya-> execute();
$rowa = $querya->fetch();
$Sub_ID=$rowa['Sub_ID'];
$Section=$rowa['Section'];
$L_Batch=$rowa['LBatch'];
$Finalized=$rowa['Finalized'];

//include("../TotalAttendance.php");

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

$sql = "select Att_Date,Period,LBatch from Subject_Handled where FS_ID='$FS_ID'";
$FileName="AttendancePercentage_".$Sub_Code;
$MinRange=0;
$MaxRange=100;
if($Range==85)
{$MinRange=85;$MaxRange=100;}
if($Range==84.99)
{$MinRange=0;$MaxRange=84.99;}

?>



 <div class="row">
          <div class="col-12">
            <div class="card card-primary" >
              <div class="card-header" style="background:orange">
              <span style="color:black;font-weight:bold;"><?php echo $Sub_Code." - ".$Sub_Name; ?></span>


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
                <caption style="caption-side:top;margin-left:10px"><center>
                  <b>Cycle/Branch:</b> <?php echo $Sub_Branch; ?>	&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>Sem:</b> <?php echo $Sub_Sem; ?>		&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>Section:</b> <?php echo $Section; ?>		&nbsp;&nbsp;&nbsp;&nbsp;<br>
                  <b>Faculty:</b> <?php echo $_SESSION['F_Name']; ?>	&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>Course :</b> <?php echo $Sub_Code."- (".$Sub_Name.")"; ?> &nbsp;&nbsp;&nbsp;&nbsp;
                  <b>Range:</b> <?php echo $MinRange."% - ".$MaxRange."%"; ?>
                  </center>
                  </caption>
                  <thead>
                    <tr align="center">
                     <th style="width:5%;">Sl.<br>No.</th>
                     <?php if($Sub_Branch=="PHY" or $Sub_Branch=="CHE" or $Sub_Sem<=3){ ?>
                     <th style="width:10%;">Roll<br>Number</th>
                     <?php } ?>
                     <th style="width:12%;">USN</th>
                     <th>Name</th>
                     <?php if($Th_Pract=="P"){ ?>
                     <th style="width:6%;">Lab<br>Batch</th>
                     <?php } ?>
                     <th style="width:10%;">No of Classes<br>Conducted</th>
                     <th style="width:10%;">No of Classes<br>Attended</th>
                     <th style="width:10%;">% of<br>Attendance</th>

                    </tr>
                  </thead>
                  <tbody>
               <?php
      		$sql_mid1=""; $sql_mid2="";
    	  	$sql3="Select SI.Student_ID,SI.C_Roll_Number,SI.C_USN,SI.Student_Name,SI.LBatch from
    	  	Course_Registration as CR ,Student_Info as SI ";

    	  	if($Exam_Type=="Regular" and $Sub_Type=="Core"){
    	  	$sql_mid1="and SI.Section='$Section' ";
    	  	}

    	  	if($L_Batch>=1){
    	  	$sql3=$sql3." ";
    	  	$sql_mid2=" and SI.LBatch='$L_Batch' ";
    	  	}
    	  	$sql3=$sql3." where CR.Sub_ID='$Sub_ID' ";


    	  	$sql_end="and CR.Student_ID=SI.Student_ID  order by SI.C_USN,SI.C_Roll_Number ";

    	  	$sql3= $sql3.$sql_mid1.$sql_mid2.$sql_end;


		$queryIn= $dbh -> prepare($sql3);
    	  	$queryIn-> execute();
    	  	$countIn = $queryIn->rowCount();
    	  	$rowsAll=$queryIn->fetchAll(PDO::FETCH_OBJ);

    	  	$slno=0;
    		foreach($rowsAll as $resIn)
    		{



    			$Std_id=$resIn->Student_ID;
    			$Std_USN=$resIn->C_USN;
    			$Std_Roll=$resIn->C_Roll_Number;
    			$Std_Name=$resIn->Student_Name;
    			$Std_LB=$resIn->LBatch;

                        //Delete  section move previous attendance
    			/*
                        $sqldel ="delete from Student_Attendance where FS_ID!='$FS_ID' and Sub_ID='$Sub_ID' and Student_ID='$Std_id' ";
			$querydel= $dbh -> prepare($sqldel);
			$querydel-> execute();

                        $sqldel ="delete from Total_Attendance where FS_ID!='$FS_ID' and Sub_ID='$Sub_ID' and Student_ID='$Std_id' ";
			$querydel= $dbh -> prepare($sqldel);
			$querydel-> execute();

			$sqldel ="delete from Student_CIA where FS_ID!='$FS_ID' and Sub_ID='$Sub_ID' and Student_ID='$Std_id' ";
			$querydel= $dbh -> prepare($sqldel);
			$querydel-> execute();
                        */


    			$sql4= "select Total_Class,Total_Present from Total_Attendance where FS_ID='$FS_ID' and Student_ID='$Std_id'";
			$queryb= $dbh -> prepare($sql4);
			$queryb-> execute();
			$rowb = $queryb->fetch();
			$Tot_Class=$rowb['Total_Class'];
			$Tot_Present=$rowb['Total_Present'];
			$Tot_Absent=$Tot_Class-$Tot_Present;
			$Tot_per=0;
			if($Tot_Present>0){$Tot_per= ($Tot_Present * 100)/$Tot_Class;}
    		        $Tot_per=round($Tot_per,2);

    		   if($Tot_per>=$MinRange and $Tot_per<=$MaxRange)
		   {
		   $slno=$slno+1;
    		   echo "<tr align='center'>";
    		   echo "<td style='padding:4px;'>". $slno ."</td>";
    		   if($Sub_Branch=="PHY" or $Sub_Branch=="CHE" or $Sub_Sem<=3){
    		   echo "<td style='padding:4px;'>". $Std_Roll ."</td>";
    		   }
    		   echo "<td style='padding:4px;'>". $Std_USN ."</td>
    		         <td style='padding:4px;'>". $Std_Name ."</td>";
    		   if($Th_Pract=="P"){
    		   echo "<td style='padding:4px;'>". $Section.$Std_LB ."</td>";
    		   }
    		   echo "<td style='padding:4px;'>". $Tot_Class."</td>
    		         <td style='padding:4px;'>". $Tot_Present."</td>
    		         <td style='padding:4px;'>". $Tot_per."</td>";
    		   }


    		  echo "</tr>";
    		  }
    		  //include("../TotalAttendance.php");
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
