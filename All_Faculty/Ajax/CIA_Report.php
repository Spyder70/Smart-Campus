<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../../DB/config.php");
require("../../Authenticate/Faculty.php");


//$Course_Registration_Head="menu-open";
//$Add_Subjects="active";

/*$PageName="Students Attendance Register ";
$Report_Head="menu-open";
$Attendance_Register="active";*/
$Faculty_ID=$_SESSION['F_ID'];


$C_msg="";



$C_Date=$_POST['C_Date'];
$FS_ID=$_POST['FS_ID'];
$Exam_Type=$_POST['Exam_Type'];

$sqla ="SELECT * FROM Faculty_Subjects where FS_ID='$FS_ID' ";
$querya= $dbh -> prepare($sqla);
$querya-> execute();
$rowa = $querya->fetch();
$Sub_ID=trim($rowa['Sub_ID']);
$Section=$rowa['Section'];
$L_Batch=$rowa['LBatch'];
$Finalized=$rowa['Finalized'];

if($L_Batch==1)
{
$sqlB="SELECT Subject_Handled.FS_ID,Subject_Handled.LBatch, count(Subject_Handled.FS_ID) as TotHand from Subject_Handled LEFT JOIN Faculty_Subjects ON Subject_Handled.FS_ID=Faculty_Subjects.FS_ID where Subject_Handled.Sub_ID='$Sub_ID' and Faculty_Subjects.Section='$Section' and Subject_Handled.Course_Date='$C_Date' group By Subject_Handled.FS_ID,Subject_Handled.LBatch";
$queryB= $dbh -> prepare($sqlB);
$queryB-> execute();
$rowsB=$queryB->fetchAll(PDO::FETCH_OBJ);
}
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


/*Fetching Data For Weightage
$sqlb ="SELECT * FROM Student_CIA where Sub_ID='$Sub_ID' and FS_ID='$FS_ID'";
$queryb= $dbh -> prepare($sqlb);
$queryb-> execute();
$rowb = $queryb->fetch();
$Sub_Type=$rowb['Subject_Type'];
$Th_Pract=$rowb['Th_Pract'];
$Sub_Name=$rowb['Subject_Name'];
$Sub_Code=$rowb['Subject_Code'];
$Sub_Branch=$rowb['Branch'];
$Sub_Sem=$rowb['Sem'];*/


$sql = "select Att_Date,Period,LBatch from Subject_Handled where FS_ID='$FS_ID'";
$FileName="StudentsEligibility_".$Sub_Code;
$queryT= $dbh -> prepare($sql);
$queryT-> execute();



$countT = $queryT->rowCount();

$t1=$t2=$t3=$t4=$t5=$t6=$t7=$t8=$t9=$t10=$m1=$m2=$m3=0;
$T1_Mx=0;  $T2_Mx=0; $T3_Mx=0;$T4_Mx=0;  $T5_Mx=0; $T6_Mx=0;$T7_Mx=0;  $T8_Mx=0; $T9_Mx=0;$T10_Mx=0;  $M1_Mx=0;  $M2_Mx=0;$M3_Mx=0;  $AllMax=0;
$sql4c ="SELECT Occasion,Max_Mark from CIA_Entered WHERE FS_ID='$FS_ID'";
$query4c= $dbh -> prepare($sql4c);
$query4c-> execute();
$rows4c=$query4c->fetchAll(PDO::FETCH_OBJ);
foreach($rows4c as $rw4c)
{
    $exmt=$rw4c->Occasion;
    if($exmt=='TASK_1' and $t1==0)
    { $T1_Mx=$rw4c->Max_Mark;if($T1_Mx!=0){ $t1=$t1+1;}}
    if($exmt=='TASK_2' and $t2==0)
    { $T2_Mx=$rw4c->Max_Mark;if($T2_Mx!=0){ $t2=$t2+1;}}
    if($exmt=='TASK_3' and $t3==0)
    { $T3_Mx=$rw4c->Max_Mark;if($T3_Mx!=0){ $t3=$t3+1;}}
    if($exmt=='TASK_4' and $t4==0)
    { $T4_Mx=$rw4c->Max_Mark;if($T4_Mx!=0){ $t4=$t4+1;}}
    if($exmt=='TASK_5' and $t5==0)
    { $T5_Mx=$rw4c->Max_Mark;if($T5_Mx!=0){ $t5=$t5+1;}}
    if($exmt=='TASK_6' and $t6==0)
    { $T6_Mx=$rw4c->Max_Mark;if($T6_Mx!=0){ $t6=$t6+1;}}
    if($exmt=='TASK_7' and $t7==0)
    { $T7_Mx=$rw4c->Max_Mark;if($T7_Mx!=0){ $t7=$t7+1;}}
    if($exmt=='TASK_8' and $t8==0)
    { $T8_Mx=$rw4c->Max_Mark;if($T8_Mx!=0){ $t8=$t8+1;}}
    if($exmt=='TASK_9' and $t9==0)
    { $T9_Mx=$rw4c->Max_Mark;if($T9_Mx!=0){ $t9=$t9+1;}}
    if($exmt=='TASK_10' and $t10==0)
    { $T10_Mx=$rw4c->Max_Mark;if($T10_Mx!=0){ $t10=$t10+1;}}
    if($exmt=='MSE_1' and $m1==0)
    { $M1_Mx=$rw4c->Max_Mark;if($M1_Mx!=0){ $m1=$m1+1;}}
    if($exmt=='MSE_2' and $m2==0)
    { $M2_Mx=$rw4c->Max_Mark;if($M2_Mx!=0){ $m2=$m2+1;}}
    if($exmt=='MSE_3' and $m3==0)
    { $M3_Mx=$rw4c->Max_Mark;if($M3_Mx!=0){ $m3=$m3+1;}}
}

// Calculate highest and second highest marks
$highest = max($M1_Mx, $M2_Mx, $M3_Mx);
$secondHighest = max(min($M1_Mx, $M2_Mx,), min($M1_Mx,$M3_Mx), min($M2_Mx, $M3_Mx));


$Task_max=$T1_Mx+$T2_Mx+$T3_Mx+$T4_Mx+$T5_Mx+$T6_Mx+$T7_Mx+$T8_Mx+$T9_Mx+$T10_Mx/10;
$MSE_max=$highest+$secondHighest;
$AllMax=$Task_max+$MSE_max;

?>
<style>
#status {
  margin-bottom: 1em;
}
.status {
  background: #fff;
  margin-bottom: .25em;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
.status {
  position: relative;
  height: 1em;
  line-height: 1em;
  padding: .5em;
  padding-left: 2em;
  transition: color 500ms;
}
.status:before, .status:after {
  content: '';
  display: inline-block;
  position: absolute;
  transition: all 500ms;
}
.status.-pending {
  color: #666;
}
.status.-pending:before, .status.-pending:after {
  background: #888;
  animation-name: spin;
  animation-duration: 1000ms;
  animation-iteration-count: infinite;
  animation-timing-function: linear;
}
.status.-pending:before {
  width: .25em;
  height: .25em;
  top: .5em;
  left: .875em;
  border-radius: .125em;
  transform-origin: 50% .5em;
}
.status.-pending:after {
  width: .25em;
  height: .25em;
  top: 1.25em;
  left: .875em;
  border-radius: .125em;
  transform-origin: 50% -.25em;
}
.status.-success {
  color: #368;
}
.status.-success:before, .status.-success:after {
  background: #6cf;
  border-radius: .125em;
}
.status.-success:before {
  width: .25em;
  height: 1em;
  top: .5em;
  left: .875em;
  transform-origin: 50% .875em;
  transform: translate(-.177em, -.11em) rotate(.125turn);
}
.status.-success:after {
  width: .25em;
  height: .5em;
  top: 1em;
  left: .875em;
  transform-origin: 50% .375em;
  transform: translate(-.177em, -.11em) rotate(-.125turn);
}
.status.-failure {
  color: #802;
}
.status.-failure:before, .status.-failure:after {
  background: #f04;
  border-radius: .125em;
}
.status.-failure:before {
  width: .25em;
  height: 1em;
  top: .5em;
  left: .875em;
  transform: rotate(.125turn);
}
.status.-failure:after {
  width: .25em;
  height: 1em;
  top: .5em;
  left: .875em;
  transform: rotate(-.125turn);
}

</style>
<input type='hidden' name='C_DateP' id='C_DateP' value='<?php echo $C_Date; ?>'>
<input type='hidden' name='FS_IDP' id='FS_IDP' value='<?php echo $FS_ID; ?>'>
<input type='hidden' name='Exam_TypeP' id='Exam_TypeP' value='<?php echo $Exam_Type; ?>'>

 <div class="row">
          <div class="col-12">
            <div class="card card-primary" >
              <div class="card-header" style="background:orange">
              <span style="color:black;font-weight:bold;"><?php echo $Sub_Code." - ".$Sub_Name; ?></span>
              <span style="color:black;font-weight:bold;"><?php echo $Sub_Code." - ".$Sub_Name; ?></span>
              <?php if($Finalized==0 and ($L_Batch==1 or $L_Batch=="")) { ?>

              <button type="button" id="Finalize" class="btn btn-primary float-right" style="margin-right: 5px;"
              onClick="Finalizing()" >
                   <i class="fas fa-check "></i> Finalize
              </button>

              <?php }
                   else if($Finalized==1 and ($L_Batch==1 or $L_Batch=="")) {
              ?>
              <button type="submit" id="dwn" class="btn btn-primary float-right" style="margin-right: 5px;"
               >
                   <i class="fas fa-file-pdf"></i> Download As PDF
                  </button>
               <button type="button" id="dwn" class="btn btn-primary float-right" style="margin-right: 5px;"
               onClick="tableToExcel('testTable1','Student' ,'<?php echo $FileName.".xls"; ?>')">
                    <i class="fas fa-download"></i> Download As Excel
                  </button>

              <?php }
              ?>


              </div>
              <!-- /.card-header -->





              <!--   Display  CompanyWise Registraion Count  -->



              <div class="card-body table-responsive p-0" style="height: 400px;" >

		 <!-- 4 -->
		 <style>
		 #testTable1 td,th{
		  border: 1px solid #ddd;
		 }
		 </style>

                <table class="table table-head-fixed table-hover text-nowrap" id="testTable1">
                <caption style="caption-side:top;margin-left:10px;text-align:center;"><center>
                  <b>Cycle/Branch:</b> <?php echo $Sub_Branch."\r\n"; ?>	&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>Sem:</b> <?php echo $Sub_Sem; ?>		&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>Section:</b> <?php echo $Section; ?>		&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>Faculty:</b> <?php echo $_SESSION['F_Name']; ?>	&nbsp;&nbsp;&nbsp;&nbsp;<br>
                  <b>Course :</b> <?php echo $Sub_Code." - (".$Sub_Name.")"; ?>
                 </center>
                  </caption>
                  <thead>
                    <tr style="cursor:pointer;text-align:center;">
                     <th width='4px'>Sl.<br>No</th>
                     <?php if($Sub_Branch=="PHY" or $Sub_Branch=="CHE" or $Sub_Sem<=3){ ?>
                     <th width='5px'>Roll<br>Number</th>
                     <?php } ?>
                     <th width='10px'>USN</th>
                     <th >Name</th>
                     <?php if($Th_Pract=="P"){ ?>
                     <th width='5px'>Lab<br>Batch</th>
                     <?php } ?>
                     <?php if($Th_Pract=='T' ||$Th_Pract=='S'){ ?>
                     <th width='5px'>Attendance<br>out of <?php echo $countT; ?></th>
                     <?php if($t1>0){ ?>
                     <th width='5px'>Assignment_1<br>(Max:<?php echo $T1_Mx; ?>)</th>
                     <?php }if($t2>0){ ?>
                     <th width='5px'>Assignment_2<br>(Max:<?php echo $T2_Mx; ?>)</th>
                     <?php }if($t3>0){ ?>
                     <th width='5px'>Assignment_3<br>(Max:<?php echo $T3_Mx; ?>)</th>
                   <?php }if($t4>0){ ?>
                     <th width='5px'>Assignment_4<br>(Max:<?php echo $T4_Mx; ?>)</th>
                     <?php }if($t5>0){ ?>
                     <th width='5px'>Assignment_5<br>(Max:<?php echo $T5_Mx; ?>)</th>
                   <?php }if($t6>0){ ?>
                     <th width='5px'>Assignment_6<br>(Max:<?php echo $T6_Mx; ?>)</th>
                   <?php }if($t7>0){ ?>
                     <th width='5px'>Assignment_7<br>(Max:<?php echo $T7_Mx; ?>)</th>
                   <?php }if($t8>0){ ?>
                     <th width='5px'>Assignment_8<br>(Max:<?php echo $T8_Mx; ?>)</th>
                   <?php }if($t9>0){ ?>
                     <th width='5px'>Assignment_9<br>(Max:<?php echo $T9_Mx; ?>)</th>
                   <?php }if($t10>0){ ?>
                     <th width='5px'>Assignment_10<br>(Max:<?php echo $T10_Mx; ?>)</th>
                     <?php }if($m1>0){ ?>
                     <th width='5px'>MSE1<br>(Max:<?php echo $M1_Mx; ?>)</th>
                     <?php }if($m2>0){ ?>
                     <th width='5px'>MSE2<br>(Max:<?php echo $M2_Mx; ?>)</th>
                   <?php }if($m3>0){ ?>
                   <th width='5px'>MSE3<br>(Max:<?php echo $M3_Mx; ?>)</th>

                     <?php } }  if($Th_Pract=='P'){ ?>
                      <th width='5px'>Attendance<br>out of <?php echo $countT; ?></th>
                      <?php if($t1>0){ ?>
                     <th width='5px'>Task1<br>(Max:<?php echo $T1_Mx; ?>)</th>
                     <?php }if($m1>0){ ?>
                     <th width='5px'>MSE1<br>(Max:<?php echo $M1_Mx; ?>)</th>
                     <?php }} ?>


                     <th width='5px'>Total<br>(Max:<?php echo $AllMax; ?>)</th>
                     <th width='5px'>Remarks<br>(NE)</th>
                    <th width='5px'>Mark Verify <br>Status</th>

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

    	  	if($L_Batch>1){
    	  	$sql3=$sql3." ";
    	  	$sql_mid2="and SI.LBatch='$L_Batch' ";
    	  	}

    	  	if($L_Batch==1){
    	  	$sql_end="and CR.Student_ID=SI.Student_ID order by SI.LBatch,SI.C_USN,SI.C_Roll_Number";
    	  	}
    	  	else{
    	  	$sql_end="and CR.Student_ID=SI.Student_ID order by SI.C_USN,SI.C_Roll_Number";
    	  	}

    	  	$sql3=$sql3." where CR.Sub_ID='$Sub_ID' ";




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




    			$sql4= "select Total_Class,Total_Present from Total_Attendance where Sub_ID='$Sub_ID' and Student_ID='$Std_id'";
			$queryb= $dbh -> prepare($sql4);
			$queryb-> execute();
			$rowb = $queryb->fetch();
			$Tot_Class=$rowb['Total_Class'];
			$Tot_Present=$rowb['Total_Present'];
			$Tot_per=0;
			if($Tot_Present>0){$Tot_per= ($Tot_Present * 100)/$Tot_Class;}
    		        $Tot_per=round($Tot_per,2);


    		  $T1_M=0;  $T2_M=0;  $T3_M=0;$T4_M=0;  $T5_M=0;  $T6_M=0;$T7_M=0;  $T8_M=0;$T9_M=0;  $T10_M=0;$M1_M=0;  $M2_M=0; $M3_M=0;$Status=0;
    		  $sql4c ="SELECT Occasion,Status,Mark,Attendance,Weightage,Max_Mark from Student_CIA WHERE Sub_ID='$Sub_ID' and Student_ID='$Std_id'";
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
             if($exmt=='MSE_1'){$M1_M=$rw4c->Mark;$Max1=$rw4c->Max_Mark;if($pr_at=='A'){$M1_M='0';}}
             if($exmt=='MSE_2'){$M2_M=$rw4c->Mark;$Max2=$rw4c->Max_Mark;if($pr_at=='A'){$M2_M='0';}}
             if($exmt=='MSE_3'){$M3_M=$rw4c->Mark;$Max3=$rw4c->Max_Mark;if($pr_at=='A'){$M3_M='0';}}
             if($St=='1'){$Status=$rw4c->Status;}
    		  }


          $highestMax = max($Max1, $Max2, $Max3);
          $secondHighestMax = max(min($Max1, $Max2,), min($Max1,$Max3), min($Max2, $Max3));
          $MaxMarks=$highestMax+ $secondHighestMax;


          $highestround = max($M1_M, $M2_M, $M3_M);
          $secondHighestround = max(min($M1_M, $M2_M,), min($M1_M,$M3_M), min($M2_M, $M3_M));

          $Task_maxround="";
          $Task_maxround=$T1_M+$T2_M+$T3_M+$T4_M+$T5_M+$T6_M+$T7_M+$T8_M+$T9_M+$T10_M;

          //For Default Option
          $Final=  $Task_maxround/10;
          $MSE_maxround=$highestround+$secondHighestround;
          $AllMaxround=$Final+$MSE_maxround;
          $Std_Mark=round($AllMaxround);

          //For 50-50 Option
          $FinalTask5050=  ($Task_maxround*25)/100;
          $MSE_5050=$highestround+$secondHighestround;
          $MSE=($MSE_5050*100)/$MaxMarks;
          $MSE100=($MSE*0.25);
          $Round5050=$FinalTask5050+$MSE100;
          $Std_Mark5050=round($Round5050);


          if($Std_Mark>=0)
          {
          $sql44c ="UPDATE Student_CIA SET Tot_Mark = '$Std_Mark' WHERE Sub_ID='$Sub_ID' and Student_ID='$Std_id'";
          $query44c= $dbh -> prepare($sql44c);
          $query44c-> execute();
        }

    		  $Std_Status="";
    		  if(($Tot_per<85 or $Std_Mark<20) and $countT>0){ $Std_Status="<span style='color:red'>NE</span>"; }

    		  if($Th_Pract=="T" ||$Th_Pract=="S" )
    		  {

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
                    echo "<td style='padding:4px;'>".$Tot_per."</td>";
                         if($t1>0){
                         echo "<td style='padding:4px;'>".$T1_M."</td>";}
                         if($t2>0){
                         echo "<td style='padding:4px;'>".$T2_M."</td>";}
                         if($t3>0){
                         echo "<td style='padding:4px;'>".$T3_M."</td>";}
                         if($t4>0){
                         echo "<td style='padding:4px;'>".$T4_M."</td>";}
                         if($t5>0){
                         echo "<td style='padding:4px;'>".$T5_M."</td>";}
                         if($t6>0){
                         echo "<td style='padding:4px;'>".$T6_M."</td>";}
                         if($t7>0){
                         echo "<td style='padding:4px;'>".$T7_M."</td>";}
                         if($t8>0){
                         echo "<td style='padding:4px;'>".$T8_M."</td>";}
                         if($t9>0){
                         echo "<td style='padding:4px;'>".$T9_M."</td>";}
                         if($t10>0){
                         echo "<td style='padding:4px;'>".$T10_M."</td>";}
                         if($m1>0){
                         echo "<td style='padding:4px;'>".$M1_M."</td>";}
                         if($m2>0){
                         echo "<td style='padding:4px;'>".$M2_M."</td>";}
                         if($m3>0){
                         echo "<td style='padding:4px;'>".$M3_M."</td>";}
                         if ($Weightage == "Default")
                         {
                            echo "<td style='padding:4px;'>". $Std_Mark ."</td>
                            <td style='padding:4px;'>". $Std_Status ."</td>";
                          }
                          else
                          {
                             echo "<td style='padding:4px;'>". $Std_Mark5050 ."</td>
                             <td style='padding:4px;'>". $Std_Status ."</td>";
                           }
                         if($Status==1)
                         {
                         echo"<td style='padding:4px;'><div class='status -success'>Success</div></td>";
                          }
                        else {
                        echo"<td style='padding:4px;'><div class='status -pending'>Pending</div></td>";
                            }





    		  }
    		  else
    		  {

    		  	echo "<tr style='text-align:center;'>";
                    echo "<td style='padding:4px;'>". $slno ."</td>";
                    if($Sub_Branch=="PHY" or $Sub_Branch=="CHE" or $Sub_Sem<=3){
                    echo "<td style='padding:4px;'>". $Std_Roll ."</td>";
                    }
                    echo "<td style='padding:4px;'>". $Std_USN ."</td>

    		   	      <td style='padding:4px;text-align:left;'>". $Std_Name ."</td>
    		   	      <td style='padding:4px;'>". $Section.$Std_LB ."</td>
    		   	      <td style='padding:4px;'>".$Tot_per."</td>";
                             if($t1>0){
                             echo "<td style='padding:4px;'>".$T1_M."</td>";}
                             if($m1>0){
                             echo "<td style='padding:4px;'>".$M1_M."</td>";}
    		   	      echo "<td style='padding:4px;'>". $Std_Mark ."</td>
    		   	      <td style='padding:4px;'>". $Std_Status ."</td>";

    		  	//echo "<td>".$Lab_tot."</td><td>".$Lab_totA."</td>";


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

<?php
//LAB_Report:








?>


<script>
let cnt = 0;

setInterval(() => {
  cnt = (cnt + 1) & 3;

  if (cnt & 1) {
    if (cnt & 2) {
      $('#status')
        .text('Failure')
        .attr('class', 'status -failure');
    } else {
      $('#status')
        .text('Success')
        .attr('class', 'status -success');
    }
  } else {
    $('#status')
      .text('Pending')
      .attr('class', 'status -pending');
  }
}, 3000);

</script>






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
