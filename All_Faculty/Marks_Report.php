<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Faculty.php");


//$Course_Registration_Head="menu-open";
//$Add_Subjects="active";

$PageName="Marks Report";
$Report_Head="menu-open";
$Marks_Report="active";
$Faculty_ID=$_SESSION['F_ID'];


$C_msg="";



?>



<?php require('../Head/Head.php'); ?>
<script src="../dist/js/tableToExcel.js"></script>



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


<form method="post" action="Marks_Report.php">

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
                   <label>Occasion</label>
                   <select class="form-control select2"  id="Occasion" name="Occasion"  required>

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
      <div class="container-fluid" id="TBY">






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
    var lab_oc="<option value='' selected></option><option value='All'>All Marks</option><option value='TASK_1'>CIA1_TASK_1</option><option value='MSE_1'>CIA1_MSE_1</option>";
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

    var Occasion = $("#Occasion").val();
    var val2="ShowList";
    if(Occasion!="" && FS_ID!="" && Exam_Type!=""  && val!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Marks_Fetch.php',
	data: {C_Date:val,FS_ID:FS_ID,Exam_Type:Exam_Type,Occasion:Occasion,Fetch:val2},
	success:function(data)
		{
		 $("#TBY").html(data);

		 }
	    });
     }
     else
     {
      //Clr_F();
       $("#TBY").html("")
     }
});

</script>
