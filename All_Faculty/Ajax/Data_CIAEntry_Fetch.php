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
          	$sql ="SELECT Exam_Type FROM Course_Subjects where Course_Date='$C_Date' group by Exam_Type order by Exam_Type";
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
    	  $MaxMark=0;

    	  if($Th_Pract=='S')
				{
				 if($Occasion=='TASK_1' || $Occasion=='TASK_2' || $Occasion=='TASK_3'|| $Occasion=='TASK_4'|| $Occasion=='TASK_5'|| $Occasion=='TASK_6'|| $Occasion=='TASK_7'|| $Occasion=='TASK_8'|| $Occasion=='TASK_9'|| $Occasion=='TASK_10' )
				 {	$MaxMark=15;   }
				 else if($Occasion=='MSE_1' || $Occasion=='MSE_2'|| $Occasion=='MSE_3' )
				 {	$MaxMark=50;   }
			 }
    	  else if($Th_Pract=='T')
    	  {
    	  	if($Occasion=='TASK_1' || $Occasion=='TASK_2' || $Occasion=='TASK_3'|| $Occasion=='TASK_4'|| $Occasion=='TASK_5'|| $Occasion=='TASK_6'|| $Occasion=='TASK_7'|| $Occasion=='TASK_8'|| $Occasion=='TASK_9'|| $Occasion=='TASK_10' )
    	  	{	$MaxMark=10;   }
    	  	else if($Occasion=='MSE_1' || $Occasion=='MSE_2'|| $Occasion=='MSE_3' )
    	  	{	$MaxMark=20;   }
    	  }



	  if($Finalized==1)
	  {
	   echo "<h2 style='margin-left:40px;color:green'> CIA Entry Already Finalized..!</h2>";
	  }
	  else
	  {

	  $sqlch="select * from CIA_Entered where
	  Faculty_ID='$Faculty_ID' and Occasion='$Occasion' and FS_ID='$FS_ID' and LBatch='$L_Batch' ";
	  $querych= $dbh -> prepare($sqlch);
    	  $querych-> execute();
    	  $count = $querych->rowCount();

	  if($count!=0){
	  $rows=$querych->fetch();
	  $MaxMark=$rows['Max_Mark'];
	  }



	  ?>
<style>
.lets{

  width:80%;
}
</style>

	  <div class="col-12">

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><b>CIA Entry For <span id="Sh_Title"><?php echo "$Sub_Name - $Occasion ";?></span></b></h3>
                <span style="font-weight:bold;float:right;">

                <input  type="text"
    		id="CIA_Max" name="CIA_Max" required pattern="[0-9]{1,2}[.]{0,1}[0-9]{0,2}" maxlength='5' style="width:20%;float:right;"
    		value="<?php echo $MaxMark;  ?>"
    		 onchange="check_max()"/>
                <span style="float:right;">Max Mark : &nbsp;</span>


    		 </span>


              </div>
              <!-- /.card-header -->

             <style>
		 #testTable1 td,th{
		  border: 1px solid #ddd;
		 }
		 </style>

              <!--   Display  CompanyWise Registraion Count  -->

              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed table-hover text-nowrap" id="testTable1" >
                 <thead style="cursor: pointer;">
                    <tr >
                      <th style="padding: 5px;">Sl.No</th>
                      <th style="width:10%;padding: 5px;">Roll NO</th>
                      <th style="width:15%;padding: 5px;">USN</th>
                      <th style="width:30%;padding: 5px;">Name</th>
											<th style="width:10%;padding: 5px;">Weightage</th>
                      <th style="width:10%;padding: 5px;text-align:center;">Marks</th>
                      <th style="width:10%;padding: 5px;text-align:center;">Absent</th>
                    </tr>
                  </thead>
                  <tbody >


                  	<!--  Table from Ajax -->





	 <?php

	  $slno=1;
    	  if($count!=0)
    	  {
    	  	//$rows=$querych->fetch();


    	  	 //************   Update *****************//
    	  	 // fetch the attendance and show for edit  and update

    	  	$sql_mid1=""; $sql_mid2="";
    	  	$sql3="Select SI.Student_ID,SI.C_Roll_Number,SI.C_USN,SI.Student_Name from
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


    		foreach($rowsAll as $resIn)
    		{  ?>
    		<tr>
    		 <td style="width:5%;padding:4px;text-align:center;"><?php echo $slno;?></td>
    		 <td style="width:10%;padding:4px;"><?php echo $resIn->C_Roll_Number; ?></td>
    		 <td style="width:15%;padding:4px;"><?php echo $resIn->C_USN; ?></td>
    		 <td style="width:30%;padding:4px;"><?php echo $resIn->Student_Name; ?></td>



    		 <?php
    		 $slno=$slno+1;
    		 $S_Abs="";
    		 $Mark=0;
    		 $CStudent_ID=$resIn->Student_ID;
    		 $sqlST="select * from Student_CIA where
	  	 Student_ID='$CStudent_ID' and FS_ID='$FS_ID' and Occasion='$Occasion' ";
	         $queryST= $dbh -> prepare($sqlST);
    	         $queryST->execute();
    	         $rowc = $queryST->fetch();
    	  	 $Mark=$rowc['Mark'];
    	  	 $Att=$rowc['Attendance'];
    	         if($Att=='A'){ $S_Abs="checked";}
							 	//echo $CStudent_ID;


				 				if($Finalized==1 || $Finalized==0)
				 				{

				 				 $T1_M=0;  $T2_M=0;  $T3_M=0;$T4_M=0;  $T5_M=0;  $T6_M=0;$T7_M=0;  $T8_M=0;$T9_M=0;  $T10_M=0;$M1_M=0;  $M2_M=0; $M3_M=0;
				 				 $sql4c ="SELECT Occasion,Mark,Attendance from Student_CIA WHERE Sub_ID='$Sub_ID' and Student_ID='$CStudent_ID'";
				 				 $query4c= $dbh -> prepare($sql4c);
				 				 $query4c-> execute();
				 				 $rows4c=$query4c->fetchAll(PDO::FETCH_OBJ);
				 				 foreach($rows4c as $rw4c)
				 				 {
				 				 $exmt=$rw4c->Occasion;
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
				 				 }


				 				 // Calculate highest and second highest round marks
				 				 $highestround = max($M1_M, $M2_M, $M3_M);
				 				 $secondHighestround = max(min($M1_M, $M2_M,), min($M1_M,$M3_M), min($M2_M, $M3_M));

				 				 $Task_maxround="";
				 				 $Task_maxround=$T1_M+$T2_M+$T3_M+$T4_M+$T5_M+$T6_M+$T7_M+$T8_M+$T9_M+$T10_M;

				 				 $Final=  $Task_maxround/10;



				 				 $MSE_maxround=$highestround+$secondHighestround;

				 				 $AllMaxround=$Final+$MSE_maxround;

				 				 $Std_Mark=round($AllMaxround);


				 				 if($Std_Mark>=0)
				 				 {
				 				 $sql44c ="UPDATE Student_CIA SET Tot_Mark = '$Std_Mark' WHERE Sub_ID='$Sub_ID' and Student_ID='$CStudent_ID'";
				 				 $query44c= $dbh -> prepare($sql44c);
				 				 $query44c-> execute();
				 				 }







				 				  $T1_M=0;  $T2_M=0;  $T3_M=0;$T4_M=0;  $T5_M=0;  $T6_M=0;$T7_M=0;  $T8_M=0;$T9_M=0;  $T10_M=0;$M1_M=0;  $M2_M=0; $M3_M=0;
				 				  $sql4c ="SELECT Occasion,Mark,Attendance,Weightage from Student_CIA WHERE FS_ID='$FS_ID' and Occasion='$Occasion'";
				 				$query4c= $dbh -> prepare($sql4c);
				 				$query4c-> execute();
				 				  $rows4c=$query4c->fetchAll(PDO::FETCH_OBJ);
				 				  foreach($rows4c as $rw4c)
				 				  {
									$Weightage=$rw4c->Weightage;
				 				  $exmt=$rw4c->Occasion;
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
				 				  }


				 				  // Calculate highest and second highest round marks
				 				  $highestround = max($M1_M, $M2_M, $M3_M);
				 				  $secondHighestround = max(min($M1_M, $M2_M,), min($M1_M,$M3_M), min($M2_M, $M3_M));

				 				  $Task_maxround="";
				 				  $Task_maxround=$T1_M+$T2_M+$T3_M+$T4_M+$T5_M+$T6_M+$T7_M+$T8_M+$T9_M+$T10_M;
				 				  $Final=$Task_maxround/10;



				 				  $MSE_maxround=$highestround+$secondHighestround;

				 				  $AllMaxround=$Final+$MSE_maxround;

				 				  $Std_Mark=round($AllMaxround);


				 				  if($Std_Mark>=0)
				 				  {
				 				  $sql44c ="UPDATE Student_CIA SET Tot_Mark = '$Std_Mark' WHERE Sub_ID='$Sub_ID' and Student_ID='$CStudent_ID'";
				 				  $query44c= $dbh -> prepare($sql44c);
				 				  $query44c-> execute();
				 				  }
				 				}
									?>
				<td style="width:10%;padding:4px;"><?php echo $Weightage ?></td>
    		 <td style="width:10%;padding:4px;text-align:center;" >
    		 <input type="hidden" name="S_id[]" value="<?php echo $resIn->Student_ID; ?>" />

    		<input  type="text" class="lets"
    		id="<?php echo $resIn->Student_ID."M"; ?>" name="<?php echo $resIn->Student_ID."M"; ?>"
    		 required pattern="[0-9]{1,2}[.]{0,1}[0-9]{0,2}" maxlength='5' value="<?php echo $Mark; ?>"
    		 onchange="Check_mark(this.value,'<?php echo $MaxMark; ?>','<?php echo $resIn->Student_ID."M";?>')"
    		 <?php if($Att=='A') { echo "disabled"; } ?>/>
    		 </td>


    		 <td style="width:10%;padding: 4px;text-align:center;" >
    		 <div class="icheck-danger d-inline" >
    		 <input type="checkbox"  <?php  echo $S_Abs; ?>
    		 id="<?php echo $resIn->Student_ID."A"; ?>" name="<?php echo $resIn->Student_ID."A"; ?>"
    		 value="<?php echo $resIn->Student_ID; ?>"
    		 onclick="No_mark('<?php echo $resIn->Student_ID."M";?>','<?php echo $resIn->Student_ID."A";?>')"/>

    		 <label for="<?php echo $resIn->Student_ID."A"; ?>"></label></div>
    		 </td>


    		 </tr>



    		<?php
    		}

    	  }
    	  else
    	  {      //************   Insert *****************//
    	  	//show the usn's for entry and insert
    	  	$sql_mid1=""; $sql_mid2="";
    	  	$sql3="Select SI.Student_ID,SI.C_Roll_Number,SI.C_USN,SI.Student_Name from
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

    		foreach($rowsAll as $resIn)
    		{  ?>
    		<tr>
    		 <td style="width:5%;padding:4px;text-align:center;"> <?php echo $slno; ?></td>
    		 <td style="width:10%;padding:4px;"><?php echo $resIn->C_Roll_Number; ?></td>
    		 <td style="width:15%;padding:4px;"><?php echo $resIn->C_USN; ?></td>
    		 <td style="width:40%;padding:4px;"><?php echo $resIn->Student_Name; ?></td>

    		 <td style="width:10%;padding:4px;text-align:center;" >
    		 <input type="hidden" name="S_id[]" value="<?php echo $resIn->Student_ID; ?>" />

    		<input  type="text" class="lets" id="<?php echo $resIn->Student_ID."M"; ?>" name="<?php echo $resIn->Student_ID."M"; ?>"
    		 required pattern="[0-9]{1,2}[.]{0,1}[0-9]{0,2}"  maxlength='5'
    		 onchange="Check_mark(this.value,'<?php echo $MaxMark; ?>','<?php echo $resIn->Student_ID."M";?>')"/>


    		 </td>
    		 <td style="width:10%;padding:4px;text-align:center;" >
    		 <div class="icheck-danger d-inline" >
    		 <input type="checkbox"  id="<?php echo $resIn->Student_ID."A"; ?>" name="<?php echo $resIn->Student_ID."A"; ?>"
    		  value="<?php echo $resIn->Student_ID; ?>"
    		  onclick="No_mark('<?php echo $resIn->Student_ID."M";?>','<?php echo $resIn->Student_ID."A";?>')"/>
    		 <label for="<?php echo $resIn->Student_ID."A"; ?>"></label></div>
    		 </td>


    		 </tr>
    		<?php
    		$slno=$slno+1;
    		}
    		?>
    		<?php
    	  }




    	  ?>
    	  </tbody>
                </table>
                <hr>
                <center>
                <?php
                if($count==0) {
                if($slno!=1){?>
                <button type="submit" name="CIA_Submit" id="CIA_Submit"
    		class="btn btn-block btn-success btn-lg" style="Width:60%;">Submit the CIA Details</button>
    		<?php } } else { ?>
    		<button type="submit" name="CIA_Update" id="CIA_Update"
    		class="btn btn-block btn-success btn-lg" style="Width:60%;">Update the CIA Details</button>
    		<?php }  ?>
    		</center>
    		<br>
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


function No_mark(std,chk)
{
var checkBox = document.getElementById(chk);
if (checkBox.checked == true){
  $("#"+std).prop('disabled',true);
  $("#"+std).val("0");
}
else
{
 $("#"+std).prop('disabled',false);
 $("#"+std).val("");
}
}

function Check_mark(mark,maxm,mid)
{
var maxm = $("#CIA_Max").val();
if(maxm==0){maxm=0;}
var a=0; a=a+parseFloat(maxm);
var b=0; b=b+parseFloat(mark);
 if(b<0 || b > a)
 {
 	$("#"+mid).val("");
 	alert(" Mark Should Be Between 0 - "+maxm);
 }

}

function check_max()
{
  var maxm = $("#CIA_Max").val();
  var f=0;
  $('#myform input[type="text"]').each(function(){
  var a=0; a=a+parseFloat(maxm);
  var b=0; b=b+parseFloat(this.value);
    if(this.value>a){
        $("#CIA_Max").val("");
        f=1;
    }
  });
  if(f==1)
  {alert(" Some Mark are above Maximum mark");}
}
</script>

 <?php

	}
	}

}

?>
