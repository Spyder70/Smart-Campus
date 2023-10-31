<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Faculty.php");

$PageName="CIA Entry";
$Entry_Head="menu-open";
$CIA_Entry="active";
$Faculty_ID=$_SESSION['F_ID'];


$C_msg="";
$T_Name="";


if($_POST)
{
  $C_Date = $_POST['C_Date'];
  $Exam_Type = $_POST['Exam_Type'];
  $FS_ID = $_POST['Subject'];
  $Occasion = $_POST['Occasion'];
  $Weightage = $_POST['Weightage'];
  $T_Name = $_POST['T_Name'];
  $CIA_Max=$_POST['CIA_Max'];

  $S_id = $_POST['S_id'];


  $sqla ="SELECT * FROM Faculty_Subjects where FS_ID='$FS_ID' ";
  $querya= $dbh -> prepare($sqla);
  $querya-> execute();
  $rowa = $querya->fetch();
  $Sub_ID=$rowa['Sub_ID'];
  $Section=$rowa['Section'];
  $L_Batch=$rowa['LBatch'];
  $flag_abv=0;
  $Entry_Dt=date("Y-m-d");
  if(isset($_POST['CIA_Submit']))
  {

     $sqlr ="SELECT FS_ID FROM CIA_Entered where
		 FS_ID='$FS_ID' and Occasion='$Occasion' and LBatch='$L_Batch'";
     $queryr= $dbh -> prepare($sqlr);
     $queryr-> execute();
     if($queryr->rowCount() <= 0)
     {

	$sql3="insert into CIA_Entered(Course_Date,Faculty_ID,FS_ID,Sub_ID,Occasion,T_Name,Max_Mark,LBatch,Entry_On,Weightage)
	values('$C_Date','$Faculty_ID','$FS_ID','$Sub_ID','$Occasion','$T_Name','$CIA_Max','$L_Batch','$Entry_Dt','$Weightage')";
	$query3 = $dbh->prepare($sql3);
	$query3->execute();
        //insert to Faculty_Handled

        $Tot_Absent=0;
     	if (isset($_POST['S_id'])) {
	foreach($S_id as $In_stud)
	{
		$attendence="P";
		$marks=0;
		$In_stud;
		if (isset($_POST[$In_stud.'A'])) { $attendence="A"; $Tot_Absent= $Tot_Absent+1;}
		if (isset($_POST[$In_stud.'M'])) { $marks=floatval($_POST[$In_stud.'M']); if($marks<0) {$marks=0;}
		                                   if($marks>$CIA_Max){$flag_abv=1;}
		                                 }

		$sql2="insert into Student_CIA(Course_Date,FS_ID,Faculty_ID,Student_ID,Sub_ID,Occasion,T_Name,Mark,Max_Mark,Attendance,LBatch,Weightage)
		values('$C_Date','$FS_ID','$Faculty_ID','$In_stud','$Sub_ID','$Occasion','$T_Name','$marks','$CIA_Max','$attendence','$L_Batch','$Weightage')";
		$query2 = $dbh->prepare($sql2);
		$query2->execute();






		//insert it to Attendance
	}
	}
	$C_msg="Total $Tot_Absent  Students Absent";

     }
  }
  if(isset($_POST['CIA_Update']))
  {
        $sql3="delete from Student_CIA where FS_ID='$FS_ID' and Occasion='$Occasion' and LBatch='$L_Batch' ";
	$query3 = $dbh->prepare($sql3);
	$query3->execute();

  	$Tot_Absent=0;
     	if (isset($_POST['S_id'])) {
	foreach($S_id as $In_stud)
	{
		$attendence="P";
		$marks=0;
		$In_stud;
		if (isset($_POST[$In_stud.'A'])) { $attendence="A"; $Tot_Absent= $Tot_Absent+1;}
		if (isset($_POST[$In_stud.'M'])) { $marks=floatval($_POST[$In_stud.'M']); if($marks<0) {$marks=0;}
		                                   if($marks>$CIA_Max){$flag_abv=1;}
		                                 }

		$sql2="insert into Student_CIA(Course_Date,FS_ID,Faculty_ID,Student_ID,Sub_ID,Occasion,T_Name,Mark,Max_Mark,Attendance,LBatch,Weightage)
		values('$C_Date','$FS_ID','$Faculty_ID','$In_stud','$Sub_ID','$Occasion','$T_Name','$marks','$CIA_Max','$attendence','$L_Batch','$Weightage')";
		$query2 = $dbh->prepare($sql2);
		$query2->execute();
    //echo $In_stud;
    $sql21="Update Student_CIA set Status=0,Weightage='$Weightage' where FS_ID='$FS_ID' and Student_ID='$In_stud'  ";
    $query21 = $dbh->prepare($sql21);
    $query21->execute();


	}
	}
	$C_msg="Total $Tot_Absent  Students Absent";

	$sql3="Update CIA_Entered set Max_Mark='$CIA_Max',Entry_On='$Entry_Dt',Weightage='$Weightage',T_Name='$T_Name' where FS_ID='$FS_ID' and Occasion='$Occasion' and LBatch='$L_Batch'  ";
		$query3 = $dbh->prepare($sql3);
		$query3->execute();
  }

  if($flag_abv==1){$C_msg=$C_msg."<br><br><span style='color:red'></b> Few Marks are Above Maximum Marks Please Do Change the marks at the Earliest..!</b></span>";}

  $sqld ="SELECT SUM(Max_Mark) as Tot_CIA FROM CIA_Entered where FS_ID='$FS_ID' and LBatch='$L_Batch'";
  $queryd= $dbh -> prepare($sqld);
  $queryd-> execute();
  $rowd = $queryd->fetch();
  $Tot_CIA=$rowd['Tot_CIA'];

  if($Tot_CIA>160)
  {
  $C_msg=$C_msg."<br><br><span style='color:green'><b> Total CIA Marks Exceeds  to $Tot_CIA <br>Please Do make the Correction </b></span>";
  }

//Fetching Assignment Data





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


<form id="myform" method="post" action="CIA_Entry.php">

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

                    <option selected="selected"></option>
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

                    <option value="" selected="selected"></option>


                  </select>
                  </div>
                <!-- /.form-group -->
		</div>


		<div class="col-md-7">
		  <div class="form-group">
                   <label>Choose Subject</label>

                   <select class="form-control select2"  id="Subject" name="Subject"  required>
                    <option selected="selected"></option>

                  </select>
                  </div>
                <!-- /.form-group -->
		</div>

    <div class="col-md-3">
      <div class="form-group">
                   <label>Weightage</label>
                   <select class="form-control select2" name="Weightage" id="Weightage" required>
                     <option value="" selected="selected"></option>
                      <option value="Default">Default</option>
                      <option value="50-50">50-50</option>
                   </select>
      </div>
                <!-- /.form-group -->
    </div>
		<div class="col-md-3">
		  <div class="form-group">
                   <label>Occasion</label>
                   <select class="form-control select2"  id="Occasion" name="Occasion" required>
                    <option value="" selected="selected"></option>
                  </select>
      </div>
		</div>
    <div class="col-md-4">
     <div class="form-group">
                  <label>Assignment Name</label>

                   <input  type="text" class="form-control input" style="width:100%;"
                    <?php if(isset($Course_GType)){ echo " readonly "; }?>
                   name="T_Name" id="T_Name" required />
                 </div>
                 <!-- /.form-group -->
    </div>

    <div id="display_info" >
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
        <div class="row" id="TBY">


        </div>
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
    $.ajax({
	type: 'POST',
	url: 'Ajax/Data_CIAEntry_Fetch.php',
	data: {C_Date:val,Fetch:val2},
	success:function(data)
		{
		$("#Exam_Type").html(data);
		$("#Occasion").val("").change();
		}
	    });
     }
     else
     {
      $("#Exam_Type").html("");
      $("#Subject").html("");
      $("#Occasion").val("").change();
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
	url: 'Ajax/Data_CIAEntry_Fetch.php',
	data: {C_Date:val,Exam_Type:Exam_Type,Fetch:val2},
	success:function(data)
		{
		$("#Subject").html(data);
		$("#Occasion").val("").change();
		}
	    });
     }
     else
     {
      $("#Subject").html("");
      $("#Occasion").val("").change();
     }
});




$("#Subject").change(function()
{
    var val = $("#C_Date").val();
    var FS_ID = $("#Subject").val();
    var Exam_Type = $("#Exam_Type").val();
    var val2="ShowSub";
    var lab_oc="<option value='' selected></option><option value='TASK_1'>CIA1_TASK_1</option><option value='MSE_1'>CIA1_MSE_1</option>";
    var th_oc="<option value='' selected></option><option value='TASK_1'>CIA1_ASSIGNMENT_1</option> <option value='TASK_2'>CIA1_ASSIGNMENT_2</option><option value='TASK_3'>CIA1_ASSIGNMENT_3</option><option value='TASK_4'>CIA1_ASSIGNMENT_4</option><option value='TASK_5'>CIA1_ASSIGNMENT_5</option><option value='TASK_6'>CIA1_ASSIGNMENT_6</option><option value='TASK_7'>CIA1_ASSIGNMENT_7</option><option value='TASK_8'>CIA1_ASSIGNMENT_8</option><option value='TASK_9'>CIA1_ASSIGNMENT_9</option><option value='TASK_10'>CIA1_ASSIGNMENT_10</option><option value='MSE_1'>CIA1_MSE_1</option>   <option value='MSE_2'>CIA1_MSE_2</option><option value='MSE_3'>CIA1_MSE_3</option>";
    if(FS_ID!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Data_CIAEntry_Fetch.php',
	data: {C_Date:val,FS_ID:FS_ID,Exam_Type:Exam_Type,Fetch:val2},
	success:function(data)
		{
		 if (data=="P")
		 {
		  $("#Occasion").html(lab_oc);
		 }
		 else
		 {
		 $("#Occasion").html(th_oc);
		 }
		}
	    });
     }
     else
     {
      $("#Occasion").val("").change();
     }
     $("#TBY").html("")
});




$("#Occasion").change(function()
{
    var val = $("#C_Date").val();
    var FS_ID = $("#Subject").val();
    var Exam_Type = $("#Exam_Type").val();
    var L_Batch = $("#L_Batch").val();
    var Occasion = $("#Occasion").val();
    var val2="ShowList";
    if(Occasion!="" && FS_ID!="" && Exam_Type!=""  && val!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Data_CIAEntry_Fetch.php',
	data: {C_Date:val,FS_ID:FS_ID,Exam_Type:Exam_Type,L_Batch:L_Batch,Occasion:Occasion,Fetch:val2},
	success:function(data)
		{

		 $("#TBY").html(data);

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
