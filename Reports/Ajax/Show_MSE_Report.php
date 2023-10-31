<?php
session_start();
require("../../DB/config.php");
$Faculty_ID=$_SESSION['F_ID'];
if(isset($_POST['Fetch']))
{

	if($_POST['Fetch']=="DispAll")
	{
	$C_Date = $_POST['C_Date'];
	$Sem = $_POST['Sem'];
	$Branch = $_POST['Branch'];


	$FileName="$C_Date MSE Report $Branch : $Sem-Sem";
	/*
	SELECT * FROM `Student_CIA` WHERE ((Mark*100)/`Max_Mark`)<50 and Occasion='TASK_2'
	SELECT Student_Info.Student_ID,Student_Info.Student_Name,
Student_Info.C_Roll_Number,
Student_Info.C_USN,Student_Info.Sem,
Course_Subjects.Sub_ID,
Course_Subjects.Subject_Code,
Course_Subjects.Subject_Name,
Student_CIA.Mark,
Student_CIA.Attendance   FROM Student_CIA
Left JOIN Student_Info ON Student_CIA.Student_ID= Student_Info.Student_ID
Left JOIN Course_Subjects ON Student_CIA.Sub_ID =Course_Subjects.Sub_ID
WHERE ((Student_CIA.Mark*100)/Student_CIA.Max_Mark)<50 and Student_CIA.Occasion='MSE1'



	SELECT Student_CIA.Student_ID,Student_CIA.Sub_ID, sum(Student_CIA.Mark), Student_Info.Student_Name, Student_Info.C_Roll_Number, Student_Info.C_USN,Student_Info.Sem, Course_Subjects.Subject_Code, Course_Subjects.Subject_Name FROM Student_CIA
Left JOIN Student_Info ON Student_CIA.Student_ID= Student_Info.Student_ID
Left JOIN Course_Subjects ON Student_CIA.Sub_ID =Course_Subjects.Sub_ID
WHERE Student_Info.Sem='3' and Student_CIA.Course_Date='2021-08-16' and Student_Info.Program='COM'
group by Student_CIA.Student_ID,Student_CIA.Sub_ID
ORDER BY `Student_Info`.`C_USN` ASC


	*/
	$T1_M=0;  $T2_M=0;  $T3_M=0;$T4_M=0;  $T5_M=0;  $T6_M=0;$T7_M=0;  $T8_M=0;$T9_M=0;  $T10_M=0;$M1_M=0;  $M2_M=0; $M3_M=0;
	$sql41c ="SELECT Student_CIA.Student_ID,Student_CIA.Occasion,Student_CIA.Sub_ID,Student_CIA.Attendance,Student_CIA.Mark,Student_Info.Student_Name, Student_Info.C_Roll_Number, Student_Info.C_USN,Student_Info.Sem, Course_Subjects.Subject_Code, Course_Subjects.Subject_Name,Course_Subjects.Hours FROM Student_CIA
	Left JOIN Student_Info ON Student_CIA.Student_ID= Student_Info.Student_ID
	Left JOIN Course_Subjects ON Student_CIA.Sub_ID =Course_Subjects.Sub_ID
	WHERE Student_Info.Sem='$Sem' and Student_CIA.Course_Date='$C_Date' ";


	$query41c= $dbh -> prepare($sql41c);
	$query41c-> execute();
	$rows41c=$query41c->fetchAll(PDO::FETCH_OBJ);
	foreach($rows41c as $rw4c)
	{
	$exmt=$rw4c->Occasion;
	$pr_at=$rw4c->Attendance;
		 if($exmt=='TASK_1'){$T1_M=$rw4c->Mark;if($pr_at=='A'){$T1_M='AB';}}
		 if($exmt=='TASK_2'){$T2_M=$rw4c->Mark;if($pr_at=='A'){$T2_M='AB';}}
		 if($exmt=='TASK_3'){$T3_M=$rw4c->Mark;if($pr_at=='A'){$T3_M='AB';}}
		 if($exmt=='TASK_4'){$T4_M=$rw4c->Mark;if($pr_at=='A'){$T4_M='AB';}}
		 if($exmt=='TASK_5'){$T5_M=$rw4c->Mark;if($pr_at=='A'){$T5_M='AB';}}
		 if($exmt=='TASK_6'){$T6_M=$rw4c->Mark;if($pr_at=='A'){$T6_M='AB';}}
		 if($exmt=='TASK_7'){$T7_M=$rw4c->Mark;if($pr_at=='A'){$T7_M='AB';}}
		 if($exmt=='TASK_8'){$T8_M=$rw4c->Mark;if($pr_at=='A'){$T8_M='AB';}}
		 if($exmt=='TASK_9'){$T9_M=$rw4c->Mark;if($pr_at=='A'){$T9_M='AB';}}
		 if($exmt=='TASK_10'){$T10_M=$rw4c->Mark;if($pr_at=='A'){$T10_M='AB';}}
		 if($exmt=='MSE_1'){$M1_M=$rw4c->Mark;if($pr_at=='A'){$M1_M='AB';}}
		 if($exmt=='MSE_2'){$M2_M=$rw4c->Mark;if($pr_at=='A'){$M2_M='AB';}}
		 if($exmt=='MSE_3'){$M3_M=$rw4c->Mark;if($pr_at=='A'){$M3_M='AB';}}
	}

	// Calculate highest and second highest round marks
	$highestround = max($M1_M, $M2_M, $M3_M);
	$secondHighestround = max(min($M1_M, $M2_M,), min($M1_M,$M3_M), min($M2_M, $M3_M));

	$Task_maxround="";
	$Task_maxround=$T1_M+$T2_M+$T3_M+$T4_M+$T5_M+$T6_M+$T7_M+$T8_M+$T9_M+$T10_M;
	$Final=  $Task_maxround/10;



	$MSE_maxround=$highestround+$secondHighestround;

	$AllMaxround=$Final+$MSE_maxround;

	$result=round($AllMaxround);





$sid_sql="SELECT Student_CIA.Student_ID,Student_CIA.Tot_Mark,Student_CIA.Sub_ID, sum(Student_CIA.Mark) as Total, Student_Info.Student_Name, Student_Info.C_Roll_Number, Student_Info.C_USN,Student_Info.Sem, Course_Subjects.Subject_Code, Course_Subjects.Subject_Name,Course_Subjects.Hours FROM Student_CIA
Left JOIN Student_Info ON Student_CIA.Student_ID= Student_Info.Student_ID
Left JOIN Course_Subjects ON Student_CIA.Sub_ID =Course_Subjects.Sub_ID
WHERE Student_Info.Sem='$Sem' and Student_CIA.Course_Date='$C_Date' ";



	if( ($Branch=='PHY' or $Branch=='CHE') and ($Sem<=2))
	{
	$sid_sql=$sid_sql." and Student_Info.Cycle='$Branch' ";
	}
	else
	{
	$sid_sql=$sid_sql." and Student_Info.Program='$Branch' ";
	}


	$sid_sql=$sid_sql." group by Student_CIA.Student_ID,Student_CIA.Sub_ID   order by Student_Info.C_USN,Student_Info.C_Roll_Number,Course_Subjects.Hours ";



     	$query= $dbh -> prepare($sid_sql);
	$query-> execute();
    	$Fresult=$query->fetchAll(PDO::FETCH_OBJ);

    	?>


    	  <div class="col-12">
            <div class="card card-primary" >
              <div class="card-header" style="background:orange">
              <span style="color:black;font-weight:bold;">MSE Details As Below</span>


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

                <?php

                $C_Date = $_POST['C_Date'];
          /*	$sql ="SELECT Distinct Subject_Code,Hours FROM Course_Subjects
          	       where Course_Date='$C_Date' and Branch='$Branch' and Sem='$Sem'
          	       order by Hours";  */

                $sql ="SELECT Distinct Subject_Code,Hours FROM Course_Subjects
          	       where (Course_Date='$C_Date' and Branch='$Branch' and Sem='$Sem') or
                      (Course_Date='$C_Date' and Sem='$Sem' and Subject_Type='Global Elective')
          	       order by Hours";

    		$query= $dbh -> prepare($sql);

    		$query-> execute();
    		$resultH=$query->fetchAll(PDO::FETCH_OBJ);


                 //mysqli_data_seek($resultH,0);

                ?>


                  <thead>
                      <tr>
                      <th id="a1" onclick="sortTable('#a1')">Sl.No</th>
                      <th id="a2" onclick="sortTable('#a2')">USN/Roll No</th>
                      <th id="a3" onclick="sortTable('#a3')">Name</th>
                 <?php
                     $rtct=4;
    		      foreach($resultH as $rest2)
    		      {
    		      echo "<th id='a$rtct' onclick='sortTable('#a$rtct')>".$rest2->Subject_Code."</th>";
    		      $rtct=$rtct+1;
    		      }
    		      $rtct=$rtct-4;
    		      ?>
                    </tr>
                  </thead>


                  <tbody id="TBODY">

                  	<?php
                  	$i=1;
                  	$Flag=0;
    			foreach($Fresult as $Fres)
			{
		StartA:
			if($Flag==0)
			{
			$Flag=1;
			$innJ=0;
			$STD_ID=$Fres->Student_ID;
			$STD_Roll=$Fres->C_Roll_Number;
			$STD_USN=$Fres->C_USN;
			$STD_Name=$Fres->Student_Name;
			?>
			<tr>
			<td><?php echo $i; $i=$i+1; ?></td>
                      	<td><?php if($STD_USN!=""){echo $STD_USN; } else { echo $STD_Roll;} ?></td>
  			<td><?php echo $STD_Name;  ?></td>
  			<?php
			}


			if( $STD_ID != $Fres->Student_ID )
			{
                      	$Flag=0;
                      	$rem_TD=$rtct-$innJ;
                      	if($rem_TD!=0)
                      	{
                      	 for(;$rem_TD>0;$rem_TD--)
                      	    echo "<td> </td>";
                      	}
                      	echo "</tr>";
                      	goto StartA;
                      	// close <tr> and before that fill remaining Td's
                      	}

			#$STD_Sub_ID=$Fres->Sub_ID;
			$STD_Sub_code=$Fres->Subject_Code;

			$STD_Mark=round($Fres->Total);
			$STD_MarkT=$Fres->Tot_Mark;

			$innK=0;
			foreach($resultH as $rest3)
    		        {
    		        $innK=$innK+1;
    		        if($innK>$innJ)
    		        {
    		          $innJ=$innK;
    		          if($rest3->Subject_Code == $STD_Sub_code)
    		          {
    		             echo "<td> $STD_MarkT</td>";//$STD_Mark
    		             break;
    		          }
    		          else
    		          {
    		           echo "<td> </td>";
    		          }
    		        }
    		        } //Subjects For Loop

                  	}

                        //Last Row
                  	$rem_TD=$rtct-$innJ;
                      	if($rem_TD!=0)
                      	{
                      	 for(;$rem_TD>0;$rem_TD--)
                      	    echo "<td> </td>";
                      	}
                      	echo "</tr>";
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
	}


}
//$query->close;
//$dbh=null;

?>
