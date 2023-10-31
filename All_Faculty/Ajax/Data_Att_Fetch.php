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

	if($_POST['Fetch']=="ShowList")
	{
	  $C_Date = $_POST['C_Date'];
	  $Exam_Type = $_POST['Exam_Type'];
	  $FS_ID = $_POST['FS_ID'];
	  //$L_Batch = $_POST['L_Batch'];
	  $A_Date = $_POST['A_Date'];
	  $Period = $_POST['Period'];


	  $sqla ="SELECT * FROM Faculty_Subjects where FS_ID='$FS_ID' ";
    	  $querya= $dbh -> prepare($sqla);
    	  $querya-> execute();
    	  $rowa = $querya->fetch();
    	  $Sub_ID=$rowa['Sub_ID'];
    	  $Section=$rowa['Section'];
    	  $L_Batch=$rowa['LBatch'];  // Picked from table //
	  $Finalized=$rowa['Finalized'];

	  //check For Regular+Core+Lab or not
	  $sqlb ="SELECT * FROM Course_Subjects where Sub_ID='$Sub_ID' ";
    	  $queryb= $dbh -> prepare($sqlb);
    	  $queryb-> execute();
    	  $rowb = $queryb->fetch();
    	  $Sub_Type=$rowb['Subject_Type'];
    	  $Th_Pract=$rowb['Th_Pract'];
    	  $S_Branch=$rowb['Branch'];
    	  $Sub_Name=$rowb['Subject_Name'];
	  $S_Sem=$rowb['Sem'];

	  if($Finalized==1)
	  {
	   echo "<h2 style='margin-left:40px;color:green'> Attendance Already Finalized..!</h2>";
	  }
	  else
	  {


	  ?>

	   <div class="col-12">

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><b>Attendance For <span id="Sh_Title"><?php echo $Sub_Name;?></span> (Select The Absenties) </b></h3>


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
                    <tr style="text-align:center;">

                      <th style="width:9%;padding:4px;">Sl.No.</th>

                      <th style="width:13%;padding:4px;">USN</th>
                      <th style="width:60%;padding:4px;">Name</th>
                      <th style="width:8%;padding:4px;text-align:left;padding-left:15px;">Absent</th>


                    </tr>
                  </thead>
                  <tbody >


                  	<!--  Table from Ajax -->



	  <?php





	  $sqlch="select * from Subject_Handled where
	  Faculty_ID='$Faculty_ID' and Att_Date='$A_Date' and Period='$Period' and FS_ID='$FS_ID' ";
	  $querych= $dbh -> prepare($sqlch);
    	  $querych-> execute();
    	  $count = $querych->rowCount();
    	  if($count!=0)
    	  {

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
    	  	$sql_mid2="and SI.LBatch='$L_Batch' ";
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
    		?>
    		<tr style="text-align:center;">
    		 <td style="width:9%;padding:4px;"><?php echo $slno; ?> </td>

    		 <td style="width:13%;padding:4px;"><?php echo $resIn->C_USN; ?></td>
				  <td style="width:8%;padding:4px;"><?php echo $resIn->Student_Name; ?></td>
    		 <td style="width:8%;padding:4px;" >

    		 <?php
    		 $S_Found="";
    		 $CStudent_ID=$resIn->Student_ID;
    		 $sqlST="select * from Student_Attendance where
	  	 Student_ID='$CStudent_ID' and FS_ID='$FS_ID' and Att_Date='$A_Date' and Period='$Period' ";
	         $queryST= $dbh -> prepare($sqlST);
    	         $queryST-> execute();
    	         $CountST = $queryST->rowCount();
    	         if($CountST!=0){ $S_Found="checked";}
    		 ?>


    		 <div class="icheck-danger d-inline" >
    		 <input type="checkbox"  <?php  echo $S_Found; ?>
    		 id="<?php echo $resIn->Student_ID; ?>" name="Att[]"
    		 value="<?php echo $resIn->Student_ID; ?>" />

    		 <label for="<?php echo $resIn->Student_ID; ?>"></label></div>
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
    	  	$sql_mid2="and SI.LBatch='$L_Batch' ";
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
    		$slno=$slno+1;?>
    		<tr style="text-align:center;">
    		 <td style="width:9%;padding:4px;"><?php echo $slno; ?></td>

    		 <td style="width:13%;padding:4px;"><?php echo $resIn->C_USN; ?></td>
				 <td style="width:8%;padding:4px;"><?php echo $resIn->Student_Name; ?></td>
				 <td style="width:60%;padding:4px;text-align:left;padding-left:15px;" >

				 <div class="icheck-danger d-inline" >
				 <input type="checkbox"  id="<?php echo $resIn->Student_ID; ?>" name="Att[]"
					value="<?php echo $resIn->Student_ID; ?>" />
				 <label for="<?php echo $resIn->Student_ID; ?>"></label></div>
				 </td>





    		 </tr>
    		<?php
    		}


    	  }
    	  ?>

    	    </tbody>
          </table>
          <hr>
          <center>
          <?php
          if($count!=0){ ?>

    		<button type="submit" name="Att_Update" id="Att_Update"
    		class="btn btn-block btn-success btn-lg" style="Width:60%;">Update the Attendance</button>

   	<?php } else {
   		if($slno!=0){
   	?>
   		<button type="submit" name="Att_Submit" id="Att_Submit"
    		class="btn btn-block btn-success btn-lg" style="Width:60%;">Submit the Attendance</button>
 	<?php } } ?>
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


</script>

	<?php
	}
	}
}


?>
