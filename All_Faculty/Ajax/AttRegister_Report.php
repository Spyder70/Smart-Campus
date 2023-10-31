<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../../DB/config.php");
require("../../Authenticate/Faculty.php");


$_POST['Range']="";
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

$sql = "select Att_Date,Period,LBatch from Subject_Handled where FS_ID='$FS_ID'  order by Att_Date,Period";
$FileName="AttendanceRegister_".$Sub_Code;
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
                  <b>Cycle/Branch:</b> <?php echo $Sub_Branch; ?>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>Sem:</b> <?php echo $Sub_Sem; ?>		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>Section:</b> <?php echo $Section; ?>		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                  <b>Faculty:</b> <?php echo $_SESSION['F_Name']; ?>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>Course :</b> <?php echo $Sub_Code." - (".$Sub_Name.")"; ?>
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
                     <th>Lab<br>Batch</th>
                     <?php } ?>

                      <?php
                  	      	$Tot_class;
                  		$sel2 = $dbh->prepare($sql);
    				$sel2->execute();
    				$results=$sel2->fetchAll(PDO::FETCH_OBJ);
                                $DtCt=0;
                  		foreach($results as $res)
				{
                                 $DtCt=$DtCt+1;
				//$Tot_class.$result->LBatch=$Tot_class.$result->LBatch+1;
			        ?>
                                 <th><?php echo $res->Att_Date."<br>Period:".$res->Period;
                                 ?><span style="color:blue"> [<?php echo $DtCt; ?>]</span></th>
                         <?php }?>

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
    		$slno=$slno+1;

    			echo "<tr align='center'>";

    			$Std_id=$resIn->Student_ID;
    			$Std_USN=$resIn->C_USN;
    			$Std_Roll=$resIn->C_Roll_Number;
    			$Std_Name=$resIn->Student_Name;
    			$Std_LB=$resIn->LBatch;


    			echo "<td style='padding:4px;'>". $slno ."</td>";
    			if($Sub_Branch=="PHY" or $Sub_Branch=="CHE" or $Sub_Sem<=3){
    			echo "<td style='padding:4px;'>". $Std_Roll ."</td>";
    			}
    			echo "<td style='padding:4px;'>". $Std_USN ."</td>
    			      <td style='padding:4px;'>". $Std_Name ."</td>";
    			if($Th_Pract=="P"){
    			echo "<td style='padding:4px;'>". $Section.$Std_LB ."</td>";
    			}





    			$sql4= "select Att_Date,Period,LBatch from Subject_Handled where FS_ID='$FS_ID' order by Att_Date,Period";
			$query4= $dbh -> prepare($sql4);
    	  		$query4-> execute();
    	  		$count4 = $query4->rowCount();
    	  		$rows4=$query4->fetchAll(PDO::FETCH_OBJ);
    	  		foreach($rows4 as $rw4)
    			{
    			   $C_AD=$rw4->Att_Date;
    			   $C_PD=$rw4->Period;
    			   $C_LB=$rw4->LBatch;
    			   if($C_LB=="")    //if its not Lab Batch
    			   {
    			      	$sql5= "select SAtt_ID from Student_Attendance where
    			      	        Att_Date='$C_AD' and Period='$C_PD' and  Student_ID='$Std_id' and FS_ID='$FS_ID'";
				$query5= $dbh -> prepare($sql5);
    	  			$query5-> execute();
    	  			$count5 = $query5->rowCount();
    	  			if($count5>0)
    	  			echo "<td style='color:red;padding:4px;'> A </td>";
    	  			else
    	  			echo "<td style='color:green;padding:4px;'> P </td>";

    			   }
    			   else
    			   {
    			      if($Std_LB==$C_LB)
    			      {
    			  	$sql5= "select SAtt_ID from Student_Attendance where
    			      	        Att_Date='$C_AD' and Period='$C_PD' and  Student_ID='$Std_id' and FS_ID='$FS_ID'";
				$query5= $dbh -> prepare($sql5);
    	  			$query5-> execute();
    	  			$count5 = $query5->rowCount();
    	  			if($count5>0)
    	  			echo "<td style='color:red;padding:4px;'> A </td>";
    	  			else
    	  			echo "<td style='color:green;padding:4px;'> P </td>";
    			      }
    			      else
    			      {
    			      echo "<td style='padding:4px;'> -- </td>";
    			      }

    			   }
    		       }
    		  echo "</tr>";
    		  }

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
