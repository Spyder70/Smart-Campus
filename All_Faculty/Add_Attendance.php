<?php
session_start();
//require("connect.php");
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Faculty.php");



$PageName="Student Attendance";
$Entry_Head="menu-open";
$Add_Attendance="active";
$Faculty_ID=$_SESSION['F_ID'];


$C_msg="";

///Session Creation
$Subject = $_POST['A_Date'];
$_SESSION['A_Date'] = $Subject;
$Exam_Type = $_POST['Exam_Type'];
$_SESSION['Exam_Type'] = $Exam_Type;
$C_Date = $_POST['C_Date'];
$_SESSION['C_Date'] = $C_Date;
$A_Date = $_POST['A_Date'];
$_SESSION['A_Date'] = $A_Date;
$Subject = $_POST['Subject'];
$_SESSION['Subject'] = $Subject;

///Retrive the Subject name
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
}
$Subject_Name = $flow;
$_SESSION['Subject_Name'] = $Subject_Name;



if($_POST)
{
  $C_Date = $_POST['C_Date'];
  $Exam_Type = $_POST['Exam_Type'];
  $FS_ID = $_POST['Subject'];
  //$L_Batch = $_POST['L_Batch'];
  $A_Date = $_POST['A_Date'];
  $Period = $_POST['Period'];
  $Att = $_POST['Att'];
  $Entry_Dt=date("Y-m-d");

  $sqla ="SELECT * FROM Faculty_Subjects where FS_ID='$FS_ID' ";
  $querya= $dbh -> prepare($sqla);
  $querya-> execute();
  $rowa = $querya->fetch();
  $Sub_ID=$rowa['Sub_ID'];
  $Section=$rowa['Section'];
  $L_Batch = $rowa['LBatch'];

  $Finalized=$rowa['Finalized'];

  if(isset($_POST['Att_Submit']))
  {
     $sqlr ="SELECT FS_ID FROM Subject_Handled where FS_ID='$FS_ID' and Att_Date='$A_Date' and Period='$Period' and LBatch='$L_Batch'";
     $queryr= $dbh -> prepare($sqlr);
     $queryr-> execute();
     if($queryr->rowCount() <= 0)
     {


        $sql3="insert into Subject_Handled(Course_Date,Faculty_ID,FS_ID,Sub_ID,Entry_On,Att_Date,Period,LBatch)
	values('$C_Date','$Faculty_ID','$FS_ID','$Sub_ID','$Entry_Dt','$A_Date','$Period','$L_Batch')";
	$query3 = $dbh->prepare($sql3);
	$query3->execute();
        //insert to Faculty_Handled

        $Tot_Absent=0;
     	if (isset($_POST['Att'])) {
	foreach($Att as $In_stud)
	{
		$In_stud;
		$sql2="insert into Student_Attendance(Course_Date,FS_ID,Faculty_ID,Student_ID,Sub_ID,Entry_On,Att_Date,Period,LBatch)
		values('$C_Date','$FS_ID','$Faculty_ID','$In_stud','$Sub_ID','$Entry_Dt','$A_Date','$Period','$L_Batch')";
		$query2 = $dbh->prepare($sql2);
		$query2->execute();
		$Tot_Absent= $Tot_Absent+1;

		//insert it to Attendance
	}
	}
	$C_msg="Total $Tot_Absent  Students Absent";

    }
  }
  if(isset($_POST['Att_Update']))
  {

  	// delete from Attendance
  	$sql1="delete from Student_Attendance where FS_ID='$FS_ID' and Att_Date='$A_Date' and Period='$Period' and LBatch='$L_Batch'";
  	$query1 = $dbh->prepare($sql1);
	$query1->execute();


  	 $Tot_Absent=0;
     	if (isset($_POST['Att'])) {
	foreach($Att as $In_stud)
	{
		$In_stud;
		$sql2="insert into Student_Attendance(Course_Date,FS_ID,Faculty_ID,Student_ID,Sub_ID,Entry_On,Att_Date,Period,LBatch)
		values('$C_Date','$FS_ID','$Faculty_ID','$In_stud','$Sub_ID','$Entry_Dt','$A_Date','$Period','$L_Batch')";
		$query2 = $dbh->prepare($sql2);
		$query2->execute();
		$Tot_Absent= $Tot_Absent+1;

		//insert it to Attendance
	}

	$sql3="Update Subject_Handled set Entry_On='$Entry_Dt' where FS_ID='$FS_ID' and Att_Date='$A_Date' and Period='$Period' and LBatch='$L_Batch'";
  	$query3 = $dbh->prepare($sql3);
	$query3->execute();

	}
	$C_msg="Total $Tot_Absent Students Absent";
  }
include("TotalAttendance.php");

}// POST End

?>



<?php require('../Head/Head.php'); ?>




<style>

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 40%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>









 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid" >
        <div class="row mb-2" >

          <div id="myModal" class="modal">
  		<!-- Modal content -->
  		<div class="modal-content">
    		<span class="close">&times;</span>
    		<p><?php echo $C_msg; ?></p>
  		</div>
	</div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


<form id="myform" method="post" action="Add_Attendance.php">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">



         <!-- SELECT2 EXAMPLE -->
        <div class="card card-default" style="margin-top:-30px;">

          <!-- /.card-header -->



          <div class="card-body" style="margin-bottom:-30px;margin-top:-5px;">
            <div class="row">


		<div class="col-md-2">
		 <div class="form-group">
                  <label>Course Date</label>

                   <select class="form-control select2"  id="C_Date" name="C_Date"  required>

                    <option value="<?php echo $_SESSION['C_Date'];?>" selected="selected"><?php echo $_SESSION['C_Date'];?></option>
                   <?php

                    	$sql ="SELECT Course_Date FROM Faculty_Subjects where
                    	Faculty_ID='$Faculty_ID' Group By Course_Date order by Course_Date desc  ";
    			$query= $dbh -> prepare($sql);
    			$query-> execute();
    			$results2=$query->fetchAll(PDO::FETCH_OBJ);
    			foreach($results2 as $result2)
    			{  ?>
    			<option value="<?php echo $result2->Course_Date;?>"> <?php echo $result2->Course_Date;?> </option>
    			<?php
    			}  ?>
                  </select>
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-2">
		  <div class="form-group">
                   <label>Exam Type</label>
                   <select class="form-control select2"  id="Exam_Type" name="Exam_Type"  required>

                    <option value="<?php echo $_SESSION['Exam_Type'];?>" selected="selected"><?php echo $_SESSION['Exam_Type'];?></option>


                  </select>
                  </div>
                <!-- /.form-group -->
		</div>


		<div class="col-md-7">
		  <div class="form-group">
                   <label>Choose Subject</label>

                   <select class="form-control select2"  id="Subject" name="Subject"  required>
                    <option value="<?php echo $_SESSION['Subject'];?>" selected="selected"><?php echo $_SESSION['Subject_Name'];?></option>

                  </select>
                  </div>
                <!-- /.form-group -->
		</div>


		<div class="col-md-3">
		  <div class="form-group">
                   <label>Attendace Date</label>
                   <input value="<?php echo $_SESSION['A_Date'];?>" type="Date" max="<?php $today=Date('Y-m-d');
                                                 $dplus="2023-12-30";
                                                 echo $dplus; ?>" min="2021-08-16" class="form-control input"  id="A_Date" name="A_Date"  required>



                  </select>
                  </div>
                <!-- /.form-group -->
		</div>

		<div class="col-md-1">
		  <div class="form-group">
                   <label>Period</label>
                   <select class="form-control select2"  id="Period" name="Period"  required>

                    <option value="" selected="selected"></option>
                    <option value="1">1</option>	<option value="2">2</option>	<option value="3">3</option>
                    <option value="4">4</option>	<option value="5">5</option>	<option value="6">6</option>
                    <option value="7">7</option>	<option value="8">8</option>	<option value="9">9</option>

                  </select>
                  </div>
                <!-- /.form-group -->
		</div>


              <!-- /.col -->
            </div>
            <!-- /.row -->

          </div>
          <!-- /.card-body -->
         </div>



      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->










<section class="content">
      <div class="container-fluid" >
        <div class="row"  id="TBY">


        </div>
        <!-- /.row -->

         <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
     </form>
 </div>
  <!-- /.content-wrapper -->















<script>
// Get the modal
var modal = document.getElementById("myModal");
// Get the button that opens the modal
//var btn = document.getElementById("myBtn");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks the button, open the modal
<?php
	if($C_msg!="")
	{
		echo "modal.style.display = 'block';";
	}
	else
	{
		echo "modal.style.display = 'none';";
	}
?>
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>




<?php require('../Head/Foot.php');   ?>

<script>

$( "#myform" ).submit(function() {
 $(".se-pre-con").fadeIn();;
});






$("#C_Date").change(function()
{

    var val = $("#C_Date").val();
    var val2="Exam_Type";
    if(val!="")
    {
    $("#A_Date").attr("min",val);
    $.ajax({
	type: 'POST',
	url: 'Ajax/Data_Att_Fetch.php',
	data: {C_Date:val,Fetch:val2},
	success:function(data)
		{
		$("#Exam_Type").html(data);
		}
	    });
     }
     else
     {
      $("#A_Date").val("").change();
      $("#A_Date").attr("min",val);
      $("#Exam_Type").html("");
      $("#Subject").html("");
      $("#Period").val("").change();
     }

});



$("#Exam_Type").change(function()
{

    var val = $("#C_Date").val();
    var Exam_Type = $("#Exam_Type").val();
    var val2="Subjects";
    if(Exam_Type!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Data_Att_Fetch.php',
	data: {C_Date:val,Exam_Type:Exam_Type,Fetch:val2},
	success:function(data)
		{
		$("#Subject").html(data);
		}
	    });
     }
     else
     {
      $("#Subject").html("");

      $("#Period").val("").change();
     }
});





$("#Subject").change(function()
{
    $("#Period").val("").change();
    $("#TBY").html("");
});



$("#A_Date").change(function()
{
    $("#Period").val("").change();

});





$("#Period").change(function()
{
    var val = $("#C_Date").val();
    var FS_ID = $("#Subject").val();
    var Exam_Type = $("#Exam_Type").val();
    var L_Batch = $("#L_Batch").val();
    var A_Date = $("#A_Date").val();
    var Period = $("#Period").val();
    var val2="ShowList";
    if(Period!="" && FS_ID!="" && Exam_Type!=""  && A_Date!="" && val!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Data_Att_Fetch.php',
	data: {C_Date:val,FS_ID:FS_ID,Exam_Type:Exam_Type,L_Batch:L_Batch,A_Date:A_Date,Period:Period,Fetch:val2},
	success:function(data)
		{
		 var t2=data;
		 var t1=t2.substring(0, 8);
		 if (t1=="<!-- -->")
		 {
		 alert("You Have Alrteady Took This Slot..!");
		 }
		 else
		 {
		 $("#TBY").html(data);
		 }
		 }
	    });
     }
     else
     {
      //
       $("#TBY").html("")
     }
});

</script>
