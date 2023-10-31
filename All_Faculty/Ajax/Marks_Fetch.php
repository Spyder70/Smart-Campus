<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../../DB/config.php");
$Faculty_ID=$_SESSION['F_ID'];
if(isset($_POST['Fetch']))
{


$Weightage="";
	$Sub_Name="";
	if($_POST['Fetch']=="Exam_Type")
	{
		$C_Date = $_POST['C_Date'];
          	$sql ="SELECT Exam_Type FROM Course_Subjects where Course_Date='$C_Date' group by Exam_Type";
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

	if($_POST['Fetch']=="Subjects")
	{
		$C_Date = $_POST['C_Date'];
		$Exam_Type = $_POST['Exam_Type'];

		$sql =" Select CS.Sub_ID,CS.Subject_Name,CS.Subject_Code,FS.Section,FS.LBatch,FS.FS_ID
    		from Course_Subjects as CS ,Faculty_Subjects  as FS where
    		FS.Faculty_ID='$Faculty_ID' and FS.Course_Date='$C_Date' and CS.Exam_Type='$Exam_Type'
    		and CS.Sub_ID=FS.Sub_ID and CS.Course_Date=FS.Course_Date order by CS.Subject_Code";

    		$query= $dbh -> prepare($sql);

    		$query-> execute();
    		$results2=$query->fetchAll(PDO::FETCH_OBJ);
    		?>
    		<option selected="selected"></option>
    		<?php
    		foreach($results2 as $result2)
    		{
    		       $flow="";$f1="";
    			if (strlen($result2->Subject_Name)>35){
    			    $f1=substr($result2->Subject_Name,0,32);
    			    $f1=$f1."...";}
    			else{
    			    $f1=$f1.$result2->Subject_Name;}

    			$flow=$result2->Subject_Code."-".$f1;

    			if($result2->Section!=""){
    			$flow=$flow."- (Section-".$result2->Section."";}

    			if($result2->LBatch>=1){
    			$flow=$flow.$result2->LBatch;}

    			$flow=$flow.")";

    		?>
    		<option value="<?php echo $result2->FS_ID;?>"> <?php echo $flow;?> </option>
    		<?php
    		}

	}
	if($_POST['Fetch']=="ShowSub")
	{
		$C_Date = $_POST['C_Date'];
		$Exam_Type = $_POST['Exam_Type'];
		$FS_ID = $_POST['FS_ID'];


		$sqla ="SELECT * FROM Faculty_Subjects where FS_ID='$FS_ID' ";
    		$querya= $dbh -> prepare($sqla);
    		$querya-> execute();
    		$rowa = $querya->fetch();
    		$Sub_ID=$rowa['Sub_ID'];
    		$Section=$rowa['Section'];


		//check For Regular+Core+Lab or not
		$sql ="SELECT * FROM Course_Subjects where Sub_ID='$Sub_ID' ";
    		$query= $dbh -> prepare($sql);
    		$query-> execute();
    		$row = $query->fetch();
    		$Sub_Type=$row['Subject_Type'];
    		$Th_Pract=$row['Th_Pract'];
    		$Sub_Name=$row['Subject_Name'];

    		echo $Th_Pract;
    		 //show USN,Name,Attenedance filling


	}
	if($_POST['Fetch']=="ShowList")
	{
	  $C_Date = $_POST['C_Date'];
	  $Exam_Type = $_POST['Exam_Type'];
	  $FS_ID = $_POST['FS_ID'];
	  //$L_Batch = $_POST['L_Batch'];
	  $Occasion = $_POST['Occasion'];



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




	  $maxm=0;
	  if($Occasion=='All'){ $maxm=50;}
	  else{   $sqlz ="SELECT Max_Mark from CIA_Entered WHERE FS_ID='$FS_ID' and Occasion='$Occasion'";
		  $queryz= $dbh -> prepare($sqlz);
		  $queryz-> execute();
		  $rowz= $queryz->fetch();
		  $maxm=$rowz['Max_Mark'];}



$FileName="MarksReport".$Sub_Code;

?>



  <div class="row">
          <div class="col-12">
            <div class="card card-primary" >
              <div class="card-header" style="background:orange">
              <span style="color:black;font-weight:bold;"><?php echo $Sub_Code." - ".$Sub_Name." Out of $maxm"; ?></span>

               <?php // if($Finalized==1) { ?>
               <button type="button" id="dwn" class="btn btn-primary float-right" style="margin-right: 5px;"
               onClick="tableToExcel('testTable1','Student' ,'<?php echo $FileName.".xls"; ?>')">
                    <i class="fas fa-download"></i> Download As Excel
                  </button>
               <?php // } ?>


              </div>
              <!-- /.card-header -->

               <style>
		 #testTable1 td,th{
		  border: 1px solid #ddd;
		 }
		 </style>



              <!--   Display  CompanyWise Registraion Count  -->



              <div class="card-body table-responsive p-0"  >

		 <!-- 4 -->

                <table class="table table-head-fixed table-hover text-nowrap" id="testTable1">
                <caption style="caption-side:top;margin-left:10px">
                 <center>
                  <b>Cycle/Branch:</b> <?php echo $Sub_Branch."\r\n"; ?>	&nbsp;&nbsp;&nbsp;
                  <b>Sem:</b> <?php echo $Sub_Sem; ?>		&nbsp;&nbsp;&nbsp;
                  <b>Section:</b> <?php echo $Section; ?>		&nbsp;&nbsp;&nbsp;
                  <b>Faculty:</b> <?php echo $_SESSION['F_Name']; ?>	&nbsp;&nbsp;&nbsp;<br>
                  <b>Course :</b> <?php echo $Sub_Code." - (".$Sub_Name.")"; ?>  &nbsp;&nbsp;&nbsp;
                  
                  </center>
                  </caption>
                  <thead>
                    <tr style="cursor:pointer;text-align:center;">
                     <th width='4px'>Sl.<br>No.</th>
                     <?php if($Sub_Branch=="PHY" or $Sub_Branch=="CHE" or $Sub_Sem<=3){ ?>
                     <th width='5px'>Roll<br>Number</th>
                     <?php } ?>
                     <th width='10px'>USN</th>
                     <th>Name</th>
                     <?php if($Th_Pract=="P"){ ?>
                     <th width='5px'>Lab<br>Batch</th>
                     <?php } ?>
                     <th width='5px'>Marks<br>Obtained</th>

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
    	  	$sql_mid2="and SI.LBatch='$L_Batch'  ";
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

    			$Std_id=$resIn->Student_ID;
    			$Std_USN=$resIn->C_USN;
    			$Std_Roll=$resIn->C_Roll_Number;
    			$Std_Name=$resIn->Student_Name;
    			$Std_LB=$resIn->LBatch;




    		  if($Occasion=="All")
    		  {
    		  $sql4c ="SELECT Sum(Mark) as Marks from Student_CIA WHERE Student_ID='$Std_id' and FS_ID='$FS_ID'";
					//TOTAL MARK START HERE
					$T1_M=0;  $T2_M=0;  $T3_M=0;$T4_M=0;  $T5_M=0;  $T6_M=0;$T7_M=0;  $T8_M=0;$T9_M=0;  $T10_M=0;$M1_M=0;  $M2_M=0; $M3_M=0;$Status=0;
					$sql4c ="SELECT Occasion,Status,Mark,Attendance,Weightage from Student_CIA WHERE Sub_ID='$Sub_ID' and Student_ID='$Std_id'";
					$query4c= $dbh -> prepare($sql4c);
					$query4c-> execute();
					$rows4c=$query4c->fetchAll(PDO::FETCH_OBJ);
					foreach($rows4c as $rw4c)
					{
					$exmt=$rw4c->Occasion;
					$Weightage=$rw4c->Weightage;
					$St=$rw4c->Status;
					$pr_at=$rw4c->Attendance;
					   if($exmt=='TASK_1'){$T1_M=$rw4c->Mark;if($pr_at=='A'){$T1_M='0';}}
					   if($exmt=='TASK_2'){$T2_M=$rw4c->Mark;if($pr_at=='A'){$T2_M='0';}}
					   if($exmt=='TASK_3'){$T3_M=$rw4c->Mark;if($pr_at=='A'){$T3_M='0';}}
					   if($exmt=='TASK_4'){$T4_M=$rw4c->Mark;if($pr_at=='A'){$T4_M='0';}}
					   if($exmt=='TASK_5'){$T5_M=$rw4c->Mark;if($pr_at=='A'){$T5_M='0';}}
					   if($exmt=='TASK_6'){$T6_M=$rw4c->Mark;if($pr_at=='A'){$T6_M='0';}}
					   if($exmt=='TASK_7'){$T7_M=$rw4c->Mark;if($pr_at=='A'){$T7_M='0';}}
					   if($exmt=='TASK_8'){$T8_M=$rw4c->Mark;if($pr_at=='A'){$T8_M='0';}}
					   if($exmt=='TASK_9'){$T9_M=$rw4c->Mark;if($pr_at=='A'){$T9_M='0';}}
					   if($exmt=='TASK_10'){$T10_M=$rw4c->Mark;if($pr_at=='A'){$T10_M='0';}}
					   if($exmt=='MSE_1'){$M1_M=$rw4c->Mark;if($pr_at=='A'){$M1_M='0';}}
					   if($exmt=='MSE_2'){$M2_M=$rw4c->Mark;if($pr_at=='A'){$M2_M='0';}}
					   if($exmt=='MSE_3'){$M3_M=$rw4c->Mark;if($pr_at=='A'){$M3_M='0';}}
					   if($St=='1'){$Status=$rw4c->Status;}
					}


					// Calculate highest and second highest round marks
					$highestround = max($M1_M, $M2_M, $M3_M);
					$secondHighestround = max(min($M1_M, $M2_M,), min($M1_M,$M3_M), min($M2_M, $M3_M));

					$Task_maxround="";
					$Task_maxround=$T1_M+$T2_M+$T3_M+$T4_M+$T5_M+$T6_M+$T7_M+$T8_M+$T9_M+$T10_M;

					//For Default Option
					$Final=  $Task_maxround/10;
					$MSE_maxround=$highestround+$secondHighestround;
					$AllMaxround=$Final+$MSE_maxround;
					$Std_Mark1=round($AllMaxround);

					//For 50-50 Option
					$FinalTask5050=  ($Task_maxround*25)/100;
					$MSE_5050=$highestround+$secondHighestround;
					$MSE=($MSE_5050*100)/40;
					$MSE100=($MSE*0.25);
					$Round5050=$FinalTask5050+$MSE100;
					$Std_Mark5050=round($Round5050);

    		  }
    		  else
    		  {
    		   $sql4c ="SELECT Mark as Marks,Attendance from Student_CIA WHERE Student_ID='$Std_id' and FS_ID='$FS_ID' and Occasion='$Occasion'";
    		  }
		  $query4c= $dbh -> prepare($sql4c);
		  $query4c-> execute();
		  $row4c = $query4c->fetch();
			$Std_Mark="";

		  $Std_Mark=$row4c['Marks'];

		  if($Occasion!="All"){
		  $Std_att=$row4c['Attendance']; if($Std_att=='A'){$Std_Mark="AB";}
		  }
                  else
									{ $Std_Mark = $Std_Mark ?? 0; // Provide a default value if $Std_Mark is null
    										$Std_Mark = round($Std_Mark);
										  }




    		  	echo "<tr style='text-align:center;'>";
    		   	echo "<td style='padding:4px;'>". $slno ."</td>";
    		   	if($Sub_Branch=="PHY" or $Sub_Branch=="CHE" or $Sub_Sem<=3){
    		   	echo "<td style='padding:4px;'>". $Std_Roll ."</td>";
    		   	}
    		   	echo "<td style='padding:4px;'>". $Std_USN ."</td>
    		   	      <td style='padding:4px;text-align:left;'>". $Std_Name ."</td>";
    		   	if($Th_Pract=="P"){
    		   	echo "<td style='padding:4px;'>". $Section.$Std_LB ."</td>";
    		   	}
						if($Weightage == "Default")
						{
							echo "<td style='padding:4px;'>". $Std_Mark1 ."</td>";
						}
						elseif ($Weightage == "50-50") {
							echo "<td style='padding:4px;'>". $Std_Mark5050 ."</td>";
						}
						else {
							echo "<td style='padding:4px;'>". $Std_Mark ."</td>";
					 }
    		  	//echo "<td>".$Lab_tot."</td><td>".$Lab_totA."</td>";



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

<?php } } ?>
